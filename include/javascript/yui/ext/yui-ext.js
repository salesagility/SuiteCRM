/*
 * yui-ext 0.33
 * Copyright(c) 2006, Jack Slocum.
 *
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 *     * Redistributions of source code must retain the above copyright notice, 
 *       this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright notice, 
 *       this list of conditions and the following disclaimer in the documentation 
 *       and/or other materials provided with the distribution.
 *     * Neither the name yui-ext nor the names of its contributors 
 *       may be used to endorse or promote products derived from this software 
 *       without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND 
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, 
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, 
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, 
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY 
 * OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING 
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, 
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

YAHOO.namespace('ext', 'ext.util', 'ext.grid');
YAHOO.ext.Strict = (document.compatMode == 'CSS1Compat');
YAHOO.ext.SSL_SECURE_URL = 'javascript:false';

window.undefined = undefined;

 
 
Function.prototype.createCallback = function(){
    
    var args = arguments;
    var method = this;
    return function() {
        return method.apply(window, args);
    };
};


Function.prototype.createDelegate = function(obj, args, appendArgs){
    var method = this;
    return function() {
        var callArgs = args || arguments;
        if(appendArgs === true){
            callArgs = Array.prototype.slice.call(arguments, 0);
            callArgs = callArgs.concat(args);
        }else if(typeof appendArgs == 'number'){
            callArgs = Array.prototype.slice.call(arguments, 0); 
            var applyArgs = [appendArgs, 0].concat(args); 
            Array.prototype.splice.apply(callArgs, applyArgs); 
        }
        return method.apply(obj || window, callArgs);
    };
};


Function.prototype.defer = function(millis, obj, args, appendArgs){
    return setTimeout(this.createDelegate(obj, args, appendArgs), millis);
};

Function.prototype.createSequence = function(fcn, scope){
    if(typeof fcn != 'function'){
        return this;
    }
    var method = this;
    return function() {
        var retval = method.apply(this || window, arguments);
        fcn.apply(scope || this || window, arguments);
        return retval;
    };
};


YAHOO.util.Event.on(window, 'unload', function(){
    delete Function.prototype.createSequence;
    delete Function.prototype.defer;
    delete Function.prototype.createDelegate;
    delete Function.prototype.createCallback;
    delete Function.prototype.createInterceptor;
});


Function.prototype.createInterceptor = function(fcn, scope){
    if(typeof fcn != 'function'){
        return this;
    }
    var method = this;
    return function() {
        fcn.target = this;
        fcn.method = method;
        if(fcn.apply(scope || this || window, arguments) === false){
            return;
        }
        return method.apply(this || window, arguments);;
    };
};


YAHOO.ext.util.Browser = new function(){
	var ua = navigator.userAgent.toLowerCase();
	
	this.isOpera = (ua.indexOf('opera') > -1);
   	
	this.isSafari = (ua.indexOf('webkit') > -1);
   	
	this.isIE = (window.ActiveXObject);
   	
	this.isIE7 = (ua.indexOf('msie 7') > -1);
   	
	this.isGecko = !this.isSafari && (ua.indexOf('gecko') > -1);
	
	if(ua.indexOf("windows") != -1 || ua.indexOf("win32") != -1){
	    
	    this.isWindows = true;
	}else if(ua.indexOf("macintosh") != -1){
		
	    this.isMac = true;
	}
	if(this.isIE && !this.isIE7){
        try{
            document.execCommand("BackgroundImageCache", false, true);
        }catch(e){}
    }
}();

YAHOO.print = function(arg1, arg2, etc){
    if(!YAHOO.ext._console){
        var cs = YAHOO.ext.DomHelper.insertBefore(document.body.firstChild,
        {tag: 'div',style:'width:250px;height:350px;overflow:auto;border:3px solid #c3daf9;' +
                'background:white;position:absolute;right:5px;top:5px;' +
                'font:normal 8pt arial,verdana,helvetica;z-index:50000;padding:5px;'}, true);
        new YAHOO.ext.Resizable(cs, {
            transparent:true,
            handles: 'all',
            pinned:true, 
            adjustments: [0,0], 
            wrap:true, 
            draggable:(YAHOO.util.DD ? true : false)
        });
        cs.on('dblclick', cs.hide);
        YAHOO.ext._console = cs;
    }
    var msg = '';
    for(var i = 0, len = arguments.length; i < len; i++) {
    	msg += arguments[i] + '<hr noshade style="color:#eeeeee;" size="1">';
    }
    YAHOO.ext._console.dom.innerHTML = msg + YAHOO.ext._console.dom.innerHTML;
    YAHOO.ext._console.dom.scrollTop = 0;
    YAHOO.ext._console.show();
};

YAHOO.printf = function(format, arg1, arg2, etc){
    var args = Array.prototype.slice.call(arguments, 1);
    YAHOO.print(format.replace(
      /\{\{[^{}]*\}\}|\{(\d+)(,\s*([\w.]+))?\}/g,
      function(m, a1, a2, a3) {
        if (m.chatAt == '{') {
          return m.slice(1, -1);
        }
        var rpl = args[a1];
        if (a3) {
          var f = eval(a3);
          rpl = f(rpl);
        }
        return rpl ? rpl : '';
      }));
}

 
YAHOO.util.CustomEvent.prototype.fireDirect = function(){
    var len=this.subscribers.length;
    for (var i=0; i<len; ++i) {
        var s = this.subscribers[i];
        if(s){
            var scope = (s.override) ? s.obj : this.scope;
            if(s.fn.apply(scope, arguments) === false){
                return false;
            }
        }
    }
    return true;
};

YAHOO.extendX = function(subclass, superclass, overrides){
    YAHOO.extend(subclass, superclass);
    subclass.override = function(o){
        YAHOO.override(subclass, o);
    };
    if(!subclass.prototype.override){
        subclass.prototype.override = function(o){
            for(var method in o){
                this[method] = o[method];
            }  
        };
    }
    if(overrides){
        subclass.override(overrides);
    }
};

YAHOO.override = function(origclass, overrides){
    if(overrides){
        var p = origclass.prototype;
        for(var method in overrides){
            p[method] = overrides[method];
        }
    }
};


YAHOO.ext.util.DelayedTask = function(fn, scope, args){
    var timeoutId = null;
    
    
    this.delay = function(delay, newFn, newScope, newArgs){
        if(timeoutId){
            clearTimeout(timeoutId);
        }
        fn = newFn || fn;
        scope = newScope || scope;
        args = newArgs || args;
        timeoutId = setTimeout(fn.createDelegate(scope, args), delay);
    };
    
    
    this.cancel = function(){
        if(timeoutId){
            clearTimeout(timeoutId);
            timeoutId = null;
        }
    };
};


YAHOO.ext.KeyMap = function(el, config, eventName){
    this.el  = getEl(el);
    this.eventName = eventName || 'keydown';
    this.bindings = [];
    if(config instanceof Array){
	    for(var i = 0, len = config.length; i < len; i++){
	        this.addBinding(config[i]);
	    }
    }else{
        this.addBinding(config);
    }
    this.keyDownDelegate = YAHOO.ext.EventManager.wrap(this.handleKeyDown, this, true);
    this.enable();
}

YAHOO.ext.KeyMap.prototype = {
    
	addBinding : function(config){
        var keyCode = config.key, 
            shift = config.shift, 
            ctrl = config.ctrl, 
            alt = config.alt,
            fn = config.fn,
            scope = config.scope;
        if(typeof keyCode == 'string'){
            var ks = [];
            var keyString = keyCode.toUpperCase();
            for(var j = 0, len = keyString.length; j < len; j++){
                ks.push(keyString.charCodeAt(j));
            }
            keyCode = ks;
        }        
        var keyArray = keyCode instanceof Array;
        var handler = function(e){
            if((!shift || e.shiftKey) && (!ctrl || e.ctrlKey) &&  (!alt || e.altKey)){
                var k = e.getKey();
                if(keyArray){
                    for(var i = 0, len = keyCode.length; i < len; i++){
                        if(keyCode[i] == k){
                          fn.call(scope || window, k, e);
                          return;
                        }
                    }
                }else{
                    if(k == keyCode){
                        fn.call(scope || window, k, e);
                    }
                }
            }
        };
        this.bindings.push(handler);  
	},
	
	handleKeyDown : function(e){
	    if(this.enabled){ 
    	    var b = this.bindings;
    	    for(var i = 0, len = b.length; i < len; i++){
    	        b[i](e);
    	    }
	    }
	},
	
	
	isEnabled : function(){
	    return this.enabled;  
	},
	
	
	enable: function(){
		if (!this.enabled){
	        this.el.on(this.eventName, this.keyDownDelegate);
		    this.enabled = true;
		}
	},

	
	disable: function(){
		if (this.enabled){
			this.el.removeListener(this.eventName, this.keyDownDelegate);
		    this.enabled = false;
		}
	}
};


YAHOO.ext.util.Observable = function(){};
YAHOO.ext.util.Observable.prototype = {
    
    fireEvent : function(){
        var ce = this.events[arguments[0].toLowerCase()];
        if(typeof ce == 'object'){
            return ce.fireDirect.apply(ce, Array.prototype.slice.call(arguments, 1));
        }else{
            return true;
        }
    },
    
    addListener : function(eventName, fn, scope, override){
        eventName = eventName.toLowerCase();
        var ce = this.events[eventName];
        if(!ce){
            
            throw 'You are trying to listen for an event that does not exist: "' + eventName + '".';
        }
        if(typeof ce == 'boolean'){
            ce = new YAHOO.util.CustomEvent(eventName);
            this.events[eventName] = ce;
        }
        ce.subscribe(fn, scope, override);
    },
    
    
    delayedListener : function(eventName, fn, scope, delay){
        var newFn = function(){
            setTimeout(fn.createDelegate(scope, arguments), delay || 1);
        }
        this.addListener(eventName, newFn);
        return newFn;
    },
    
    
    bufferedListener : function(eventName, fn, scope, millis){
        var task = new YAHOO.ext.util.DelayedTask();
        var newFn = function(){
            task.delay(millis || 250, fn, scope, Array.prototype.slice.call(arguments, 0));
        }
        this.addListener(eventName, newFn);
        return newFn;
    },
    
    
    removeListener : function(eventName, fn, scope){
        var ce = this.events[eventName.toLowerCase()];
        if(typeof ce == 'object'){
            ce.unsubscribe(fn, scope);
        }
    },
    
    
    purgeListeners : function(){
        for(var evt in this.events){
            if(typeof this.events[evt] == 'object'){
                 this.events[evt].unsubscribeAll();
            }
        }
    }
};

YAHOO.ext.util.Observable.prototype.on = YAHOO.ext.util.Observable.prototype.addListener;


YAHOO.ext.util.Config = {
    
    apply : function(obj, config, defaults){
        if(defaults){
            this.apply(obj, defaults);
        }
        if(config){
            for(var prop in config){
                obj[prop] = config[prop];
            }
        }
        return obj;
    }
};

if(!String.escape){
    String.escape = function(string) {
        return string.replace(/('|\\)/g, "\\$1");
    };
};

String.leftPad = function (val, size, ch) {
    var result = new String(val);
    if (ch == null) {
        ch = " ";
    }
    while (result.length < size) {
        result = ch + result;
    }
    return result;
};

/*
if(YAHOO.util.Connect){
    YAHOO.util.Connect.setHeader = function(o){
		for(var prop in this._http_header){
		    
			if(typeof this._http_header[prop] != 'function'){
				o.conn.setRequestHeader(prop, this._http_header[prop]);
			}
		}
		delete this._http_header;
		this._http_header = {};
		this._has_http_headers = false;
	};   
}
*/
if(YAHOO.util.DragDrop){
    
    YAHOO.util.DragDrop.prototype.defaultPadding = {left:0, right:0, top:0, bottom:0};
    
    
    YAHOO.util.DragDrop.prototype.constrainTo = function(constrainTo, pad, inContent){
        if(typeof pad == 'number'){
            pad = {left: pad, right:pad, top:pad, bottom:pad};
        }
        pad = pad || this.defaultPadding;
        var b = getEl(this.getEl()).getBox();
        var ce = getEl(constrainTo);
        var c = ce.dom == document.body ? { x: 0, y: 0,
                width: YAHOO.util.Dom.getViewportWidth(),
                height: YAHOO.util.Dom.getViewportHeight()} : ce.getBox(inContent || false);
        var topSpace = b.y - c.y;
        var leftSpace = b.x - c.x;

        this.resetConstraints();
        this.setXConstraint(leftSpace - (pad.left||0), 
                c.width - leftSpace - b.width - (pad.right||0) 
        );
        this.setYConstraint(topSpace - (pad.top||0), 
                c.height - topSpace - b.height - (pad.bottom||0) 
        );
    } 
}

YAHOO.ext.util.MixedCollection = function(allowFunctions){
    this.items = [];
    this.keys = [];
    this.events = {
        
        'clear' : new YAHOO.util.CustomEvent('clear'),
        
        'add' : new YAHOO.util.CustomEvent('add'),
        
        'replace' : new YAHOO.util.CustomEvent('replace'),
        
        'remove' : new YAHOO.util.CustomEvent('remove')
    }
    this.allowFunctions = allowFunctions === true;
};

YAHOO.extendX(YAHOO.ext.util.MixedCollection, YAHOO.ext.util.Observable, {
    allowFunctions : false,
   

    add : function(key, o){
        if(arguments.length == 1){
            o = arguments[0];
            key = this.getKey(o);
        }
        this.items.push(o);
        if(typeof key != 'undefined' && key != null){
            this.items[key] = o;
            this.keys.push(key);
        }
        this.fireEvent('add', this.items.length-1, o, key);
        return o;
    },
   

    getKey : function(o){
         return null; 
    },
   

    replace : function(key, o){
        if(arguments.length == 1){
            o = arguments[0];
            key = this.getKey(o);
        }
        if(typeof this.items[key] == 'undefined'){
            return this.add(key, o);
        }
        var old = this.items[key];
        if(typeof key == 'number'){ 
            this.items[key] = o;
        }else{
            var index = this.indexOfKey(key);
            this.items[index] = o;
            this.items[key] = o;
        }
        this.fireEvent('replace', key, old, o);
        return o;
    },
   

    addAll : function(objs){
        if(arguments.length > 1 || objs instanceof Array){
            var args = arguments.length > 1 ? arguments : objs;
            for(var i = 0, len = args.length; i < len; i++){
                this.add(args[i]);
            }
        }else{
            for(var key in objs){
                if(this.allowFunctions || typeof objs[key] != 'function'){
                    this.add(objs[key], key);
                }
            }
        }
    },
   

    each : function(fn, scope){
        for(var i = 0, len = this.items.length; i < len; i++){
            fn.call(scope || window, this.items[i]);
        }
    },
   

    eachKey : function(fn, scope){
        for(var i = 0, len = this.keys.length; i < len; i++){
            fn.call(scope || window, this.keys[i], this.items[i]);
        }
    },
   

    find : function(fn, scope){
        for(var i = 0, len = this.items.length; i < len; i++){
            if(fn.call(scope || window, this.items[i])){
                return this.items[i];
            }
        }
        return null;
    },
   

    insert : function(index, key, o){
        if(arguments.length == 2){
            o = arguments[1];
            key = this.getKey(o);
        }
        if(index >= this.items.length){
            return this.add(o, key);
        }
        this.items.splice(index, 0, o);
        if(typeof key != 'undefined' && key != null){
            this.items[key] = o;
            this.keys.splice(index, 0, key);
        }
        this.fireEvent('add', index, o, key);
        return o;
    },
   

    remove : function(o){
        var index = this.indexOf(o);
        this.items.splice(index, 1);
        if(typeof this.keys[index] != 'undefined'){
            var key = this.keys[index];
            this.keys.splice(index, 1);
            delete this.items[key];
        }
        this.fireEvent('remove', o);
        return o;
    },
   

    removeAt : function(index){
        this.items.splice(index, 1);
        var key = this.keys[index];
        if(typeof key != 'undefined'){
             this.keys.splice(index, 1);
             delete this.items[key];
        }
        this.fireEvent('remove', o, key);
    },
   

    removeKey : function(key){
        var o = this.items[key];
        var index = this.indexOf(o);
        this.items.splice(index, 1);
        this.keys.splice(index, 1);
        delete this.items[key];
        this.fireEvent('remove', o, key);
    },
   

    getCount : function(){
        return this.items.length; 
    },
   

    indexOf : function(o){
        if(!this.items.indexOf){
            for(var i = 0, len = this.items.length; i < len; i++){
                if(this.items[i] == o) return i;
            }
            return -1;
        }else{
            return this.items.indexOf(o);
        }
    },
   

    indexOfKey : function(key){
        if(!this.keys.indexOf){
            for(var i = 0, len = this.keys.length; i < len; i++){
                if(this.keys[i] == key) return i;
            }
            return -1;
        }else{
            return this.keys.indexOf(key);
        }
    },
   

    item : function(key){
        return this.items[key];
    },
   

    contains : function(o){
        return this.indexOf(o) != -1;
    },
   

    containsKey : function(key){
        return typeof this.items[key] != 'undefined';
    },
   

    clear : function(o){
        this.items = [];
        this.keys = [];
        this.fireEvent('clear');
    },
   

    first : function(){
        return this.items[0]; 
    },
   

    last : function(){
        return this.items[this.items.length];   
    }
});

YAHOO.ext.util.MixedCollection.prototype.get = YAHOO.ext.util.MixedCollection.prototype.item;

YAHOO.ext.util.JSON = new function(){
    var useHasOwn = {}.hasOwnProperty ? true : false;
    
    
    
    
    var pad = function(n) {
        return n < 10 ? '0' + n : n;
    };
    
    var m = {
        '\b': '\\b',
        '\t': '\\t',
        '\n': '\\n',
        '\f': '\\f',
        '\r': '\\r',
        '"' : '\\"',
        '\\': '\\\\'
    };

    var encodeString = function(s){
        if (/["\\\x00-\x1f]/.test(s)) {
            return '"' + s.replace(/([\x00-\x1f\\"])/g, function(a, b) {
                var c = m[b];
                if(c){
                    return c;
                }
                c = b.charCodeAt();
                return '\\u00' +
                    Math.floor(c / 16).toString(16) +
                    (c % 16).toString(16);
            }) + '"';
        }
        return '"' + s + '"';
    };
    
    var encodeArray = function(o){
        var a = ['['], b, i, l = o.length, v;
            for (i = 0; i < l; i += 1) {
                v = o[i];
                switch (typeof v) {
                    case 'undefined':
                    case 'function':
                    case 'unknown':
                        break;
                    default:
                        if (b) {
                            a.push(',');
                        }
                        a.push(v === null ? "null" : YAHOO.ext.util.JSON.encode(v));
                        b = true;
                }
            }
            a.push(']');
            return a.join('');
    };
    
    var encodeDate = function(o){
        return '"' + o.getFullYear() + '-' +
                pad(o.getMonth() + 1) + '-' +
                pad(o.getDate()) + 'T' +
                pad(o.getHours()) + ':' +
                pad(o.getMinutes()) + ':' +
                pad(o.getSeconds()) + '"';
    };
    
    
    this.encode = function(o){
        if(typeof o == 'undefined' || o === null){
            return 'null';
        }else if(o instanceof Array){
            return encodeArray(o);
        }else if(o instanceof Date){
            return encodeDate(o);
        }else if(typeof o == 'string'){
            return encodeString(o);
        }else if(typeof o == 'number'){
            return isFinite(o) ? String(o) : "null";
        }else if(typeof o == 'boolean'){
            return String(o);
        }else {
            var a = ['{'], b, i, v;
            for (var i in o) {
                if(!useHasOwn || o.hasOwnProperty(i)) {
                    v = o[i];
                    switch (typeof v) {
                    case 'undefined':
                    case 'function':
                    case 'unknown':
                        break;
                    default:
                        if(b){
                            a.push(',');
                        }
                        a.push(this.encode(i), ':',
                                v === null ? "null" : this.encode(v));
                        b = true;
                    }
                }
            }
            a.push('}');
            return a.join('');
        }
    };
    
    
    this.decode = function(json){
        
        
            
                return eval('(' + json + ')');
           
       
       
       
    };
}();

YAHOO.ext.util.CSS = new function(){
	var rules = null;
   	
   	var toCamel = function(property) {
      var convert = function(prop) {
         var test = /(-[a-z])/i.exec(prop);
         return prop.replace(RegExp.$1, RegExp.$1.substr(1).toUpperCase());
      };
      while(property.indexOf('-') > -1) {
         property = convert(property);
      }
      return property;
   };
   
   
   this.getRules = function(refreshCache){
   		if(rules == null || refreshCache){
   			rules = {};
   			var ds = document.styleSheets;
   			for(var i =0, len = ds.length; i < len; i++){
   			    try{
    		        var ss = ds[i];
    		        var ssRules = ss.cssRules || ss.rules;
    		        for(var j = ssRules.length-1; j >= 0; --j){
    		        	rules[ssRules[j].selectorText] = ssRules[j];
    		        }
   			    }catch(e){} 
	        }
   		}
   		return rules;
   	};
   	
   	
   this.getRule = function(selector, refreshCache){
   		var rs = this.getRules(refreshCache);
   		if(!(selector instanceof Array)){
   		    return rs[selector];
   		}
   		for(var i = 0; i < selector.length; i++){
			if(rs[selector[i]]){
				return rs[selector[i]];
			}
		}
		return null;
   	};
   	
   	
   	
   this.updateRule = function(selector, property, value){
   		if(!(selector instanceof Array)){
   			var rule = this.getRule(selector);
   			if(rule){
   				rule.style[toCamel(property)] = value;
   				return true;
   			}
   		}else{
   			for(var i = 0; i < selector.length; i++){
   				if(this.updateRule(selector[i], property, value)){
   					return true;
   				}
   			}
   		}
   		return false;
   	};
   	
   	
   this.apply = function(el, selector){
   		if(!(selector instanceof Array)){
   			var rule = this.getRule(selector);
   			if(rule){
   			    var s = rule.style;
   				for(var key in s){
   				    if(typeof s[key] != 'function'){
       					if(s[key] && String(s[key]).indexOf(':') < 0 && s[key] != 'false'){
       						try{el.style[key] = s[key];}catch(e){}
       					}
   				    }
   				}
   				return true;
   			}
   		}else{
   			for(var i = 0; i < selector.length; i++){
   				if(this.apply(el, selector[i])){
   					return true;
   				}
   			}
   		}
   		return false;
   	};
   	
   	this.applyFirst = function(el, id, selector){
   		var selectors = [
   			'#' + id + ' ' + selector,
   			selector
   		];
   		return this.apply(el, selectors);
   	};
   	
   	this.revert = function(el, selector){
   		if(!(selector instanceof Array)){
   			var rule = this.getRule(selector);
   			if(rule){
   				for(key in rule.style){
   					if(rule.style[key] && String(rule.style[key]).indexOf(':') < 0 && rule.style[key] != 'false'){
   						try{el.style[key] = '';}catch(e){}
   					}
   				}
   				return true;
   			}
   		}else{
   			for(var i = 0; i < selector.length; i++){
   				if(this.revert(el, selector[i])){
   					return true;
   				}
   			}
   		}
   		return false;
   	};
   	
   	this.revertFirst = function(el, id, selector){
   		var selectors = [
   			'#' + id + ' ' + selector,
   			selector
   		];
   		return this.revert(el, selectors);
   	};
}();
YAHOO.ext.util.Bench = function(){
   this.timers = {};
   this.lastKey = null;
};
YAHOO.ext.util.Bench.prototype = {
   start : function(key){
       this.lastKey = key;
       this.timers[key] = {};
       this.timers[key].startTime = new Date().getTime(); 
   },
   
   stop : function(key){
       key = key || this.lastKey;
       this.timers[key].endTime = new Date().getTime(); 
   },
   
   getElapsed : function(key){
       key = key || this.lastKey;
       return this.timers[key].endTime - this.timers[key].startTime;
   },
   
   toString : function(html){
       var results = "";
       for(var key in this.timers){
           if(typeof this.timers[key] != 'function'){
               results += key + ":\t" + (this.getElapsed(key) / 1000) + " seconds\n";
           }
       }
       if(html){
           results = results.replace("\n", '<br>');
       }
       return results;
   },
   
   show : function(){
       alert(this.toString());
   }
};

YAHOO.ext.DomHelper = new function(){
    
    var d = document;
    var tempTableEl = null;
    
    this.useDom = false;
    var emptyTags = /^(?:base|basefont|br|frame|hr|img|input|isindex|link|meta|nextid|range|spacer|wbr|audioscope|area|param|keygen|col|limittext|spot|tab|over|right|left|choose|atop|of)$/i;
    
    this.applyStyles = function(el, styles){
        if(styles){
           var D = YAHOO.util.Dom;
           if (typeof styles == "string"){
               var re = /\s?([a-z\-]*)\:([^;]*);?/gi;
               var matches;
               while ((matches = re.exec(styles)) != null){
                   D.setStyle(el, matches[1], matches[2]);
               }
           }else if (typeof styles == "object"){
               for (var style in styles){
                  D.setStyle(el, style, styles[style]);
               }
           }else if (typeof styles == "function"){
                YAHOO.ext.DomHelper.applyStyles(el, styles.call());
           }
        }
    }; 
    
    
    
    var createHtml = function(o){
        var b = '';
        b += '<' + o.tag;
        for(var attr in o){
            if(attr == 'tag' || attr == 'children' || attr == 'html' || typeof o[attr] == 'function') continue;
            if(attr == 'style'){
                var s = o['style'];
                if(typeof s == 'function'){
                    s = s.call();
                }
                if(typeof s == 'string'){
                    b += ' style="' + s + '"';
                }else if(typeof s == 'object'){
                    b += ' style="';
                    for(var key in s){
                        if(typeof s[key] != 'function'){
                            b += key + ':' + s[key] + ';';
                        }
                    }
                    b += '"';
                }
            }else{
                if(attr == 'cls'){
                    b += ' class="' + o['cls'] + '"';
                }else if(attr == 'htmlFor'){
                    b += ' for="' + o['htmlFor'] + '"';
                }else{
                    b += ' ' + attr + '="' + o[attr] + '"';
                }
            }
        }
        if(emptyTags.test(o.tag)){
            b += ' />';
        }else{
            b += '>';
            if(o.children){
                for(var i = 0, len = o.children.length; i < len; i++) {
                    b += createHtml(o.children[i], b);
                }
            }
            if(o.html){
                b += o.html;
            }
            b += '</' + o.tag + '>';
        }
        return b;
    }
    
    
    
    var createDom = function(o, parentNode){
        var el = d.createElement(o.tag);
        var useSet = el.setAttribute ? true : false; 
        for(var attr in o){
            if(attr == 'tag' || attr == 'children' || attr == 'html' || attr == 'style' || typeof o[attr] == 'function') continue;
            if(attr=='cls'){
                el.className = o['cls'];
            }else{
                if(useSet) el.setAttribute(attr, o[attr]);
                else el[attr] = o[attr];
            }
        }
        YAHOO.ext.DomHelper.applyStyles(el, o.style);
        if(o.children){
            for(var i = 0, len = o.children.length; i < len; i++) {
             	createDom(o.children[i], el);
            }
        }
        if(o.html){
            el.innerHTML = o.html;
        }
        if(parentNode){
           parentNode.appendChild(el);
        }
        return el;
    };
    
    
    var insertIntoTable = function(tag, where, el, html){
        if(!tempTableEl){
            tempTableEl = document.createElement('div');
        }
        var node;
        if(tag == 'table' || tag == 'tbody'){
           tempTableEl.innerHTML = '<table><tbody>'+html+'</tbody></table>';
           node = tempTableEl.firstChild.firstChild.firstChild;
        }else{
           tempTableEl.innerHTML = '<table><tbody><tr>'+html+'</tr></tbody></table>';
           node = tempTableEl.firstChild.firstChild.firstChild.firstChild;
        }
        if(where == 'beforebegin'){
            el.parentNode.insertBefore(node, el);
            return node;
        }else if(where == 'afterbegin'){
            el.insertBefore(node, el.firstChild);
            return node;
        }else if(where == 'beforeend'){
            el.appendChild(node);
            return node;
        }else if(where == 'afterend'){
            el.parentNode.insertBefore(node, el.nextSibling);
            return node;
        }
    } 
    
    
    this.insertHtml = function(where, el, html){
        where = where.toLowerCase();
        if(el.insertAdjacentHTML){
            var tag = el.tagName.toLowerCase();
            if(tag == 'table' || tag == 'tbody' || tag == 'tr'){
               return insertIntoTable(tag, where, el, html);
            }
            switch(where){
                case 'beforebegin':
                    el.insertAdjacentHTML(where, html);
                    return el.previousSibling;
                case 'afterbegin':
                    el.insertAdjacentHTML(where, html);
                    return el.firstChild;
                case 'beforeend':
                    el.insertAdjacentHTML(where, html);
                    return el.lastChild;
                case 'afterend':
                    el.insertAdjacentHTML(where, html);
                    return el.nextSibling;
            }
            throw 'Illegal insertion point -> "' + where + '"';
        }
        var range = el.ownerDocument.createRange();
        var frag;
        switch(where){
             case 'beforebegin':
                range.setStartBefore(el);
                frag = range.createContextualFragment(html);
                el.parentNode.insertBefore(frag, el);
                return el.previousSibling;
             case 'afterbegin':
                if(el.firstChild){ 
                    range.setStartBefore(el.firstChild);
                }else{
                    range.selectNodeContents(el);
                    range.collapse(true);
                }
                frag = range.createContextualFragment(html);
                el.insertBefore(frag, el.firstChild);
                return el.firstChild;
            case 'beforeend':
                if(el.lastChild){
                    range.setStartAfter(el.lastChild); 
                }else{
                    range.selectNodeContents(el);
                    range.collapse(false);
                }
                frag = range.createContextualFragment(html);
                el.appendChild(frag);
                return el.lastChild;
            case 'afterend':
                range.setStartAfter(el);
                frag = range.createContextualFragment(html);
                el.parentNode.insertBefore(frag, el.nextSibling);
                return el.nextSibling;
            }
            throw 'Illegal insertion point -> "' + where + '"';
    };
    
    
    this.insertBefore = function(el, o, returnElement){
        el = YAHOO.util.Dom.get(el);
        var newNode;
        if(this.useDom){
            newNode = createDom(o, null);
            el.parentNode.insertBefore(newNode, el);
        }else{
            var html = createHtml(o);
            newNode = this.insertHtml('beforeBegin', el, html);
        }
        return returnElement ? YAHOO.ext.Element.get(newNode, true) : newNode;
    };
    
    
    this.insertAfter = function(el, o, returnElement){
        el = YAHOO.util.Dom.get(el);
        var newNode;
        if(this.useDom){
            newNode = createDom(o, null);
            el.parentNode.insertBefore(newNode, el.nextSibling);
        }else{
            var html = createHtml(o);
            newNode = this.insertHtml('afterEnd', el, html);
        }
        return returnElement ? YAHOO.ext.Element.get(newNode, true) : newNode;
    };
    
    
    this.append = function(el, o, returnElement){
        el = YAHOO.util.Dom.get(el);
        var newNode;
        if(this.useDom){
            newNode = createDom(o, null);
            el.appendChild(newNode);
        }else{
            var html = createHtml(o);
            newNode = this.insertHtml('beforeEnd', el, html);
        }
        return returnElement ? YAHOO.ext.Element.get(newNode, true) : newNode;
    };
    
    
    this.overwrite = function(el, o, returnElement){
        el = YAHOO.util.Dom.get(el);
        el.innerHTML = createHtml(o);
        return returnElement ? YAHOO.ext.Element.get(el.firstChild, true) : el.firstChild;
    };
    
    
    this.createTemplate = function(o){
        var html = createHtml(o);
        return new YAHOO.ext.DomHelper.Template(html);
    };
}();


YAHOO.ext.DomHelper.Template = function(html){
    
    this.html = html;
};
YAHOO.ext.DomHelper.Template.prototype = {
    
    applyTemplate : function(values){
        if(this.compiled){
            return this.compiled(values);
        }
        var empty = '';
        var fn = function(match, index){
            if(typeof values[index] != 'undefined'){
                return values[index];
            }else{
                return empty;
            }
        }
        return this.html.replace(this.re, fn);
    },
    
    
    re : /\{(\w+)\}/g,
    
    
    compile : function(){
        var html = this.html;
        var re = this.re;
        var body = [];
        body.push("this.compiled = function(values){ return [");
        var result;
        var lastMatchEnd = 0;
        while ((result = re.exec(html)) != null){
            body.push("'", html.substring(lastMatchEnd, result.index), "', ");
            body.push("values['", html.substring(result.index+1,re.lastIndex-1), "'], ");
            lastMatchEnd = re.lastIndex;
        }
        body.push("'", html.substr(lastMatchEnd), "'].join('');};");
        eval(body.join(''));
    },
   
    
    insertBefore: function(el, values, returnElement){
        el = YAHOO.util.Dom.get(el);
        var newNode = YAHOO.ext.DomHelper.insertHtml('beforeBegin', el, this.applyTemplate(values));
        return returnElement ? YAHOO.ext.Element.get(newNode, true) : newNode;
    },
    
    
    insertAfter : function(el, values, returnElement){
        el = YAHOO.util.Dom.get(el);
        var newNode = YAHOO.ext.DomHelper.insertHtml('afterEnd', el, this.applyTemplate(values));
        return returnElement ? YAHOO.ext.Element.get(newNode, true) : newNode;
    },
    
    
    append : function(el, values, returnElement){
        el = YAHOO.util.Dom.get(el);
        var newNode = YAHOO.ext.DomHelper.insertHtml('beforeEnd', el, this.applyTemplate(values));
        return returnElement ? YAHOO.ext.Element.get(newNode, true) : newNode;
    },
    
    
    overwrite : function(el, values, returnElement){
        el = YAHOO.util.Dom.get(el);
        el.innerHTML = '';
        var newNode = YAHOO.ext.DomHelper.insertHtml('beforeEnd', el, this.applyTemplate(values));
        return returnElement ? YAHOO.ext.Element.get(newNode, true) : newNode;
    }
};

YAHOO.ext.Template = YAHOO.ext.DomHelper.Template;

YAHOO.ext.Element = function(element, forceNew){
    var dom = YAHOO.util.Dom.get(element);
    if(!dom){ 
        return null;
    }
    if(!forceNew && YAHOO.ext.Element.cache[dom.id]){ 
        return YAHOO.ext.Element.cache[dom.id];
    }
    
    this.dom = dom;
    
    
    this.id = this.dom.id;
    
    this.visibilityMode = YAHOO.ext.Element.VISIBILITY;
    
    
    
    this.originalDisplay = YAHOO.util.Dom.getStyle(this.dom, 'display') || '';
    if(this.autoDisplayMode){
        if(this.originalDisplay == 'none'){
            this.setVisibilityMode(YAHOO.ext.Element.DISPLAY);
        }
    }
    if(this.originalDisplay == 'none'){
        this.originalDisplay = '';
    }
    
    
    this.defaultUnit = 'px';
}

YAHOO.ext.Element.prototype = {    
    
    setVisibilityMode : function(visMode){
        this.visibilityMode = visMode;
        return this;
    },
    
    
    enableDisplayMode : function(display){
        this.setVisibilityMode(YAHOO.ext.Element.DISPLAY);
        if(typeof display != 'undefined') this.originalDisplay = display;
        return this;
    },
    
    
    animate : function(args, duration, onComplete, easing, animType){
        this.anim(args, duration, onComplete, easing, animType);
        return this;
    },
    
    
    anim : function(args, duration, onComplete, easing, animType){
        animType = animType || YAHOO.util.Anim;
        var anim = new animType(this.dom, args, duration || .35, 
                easing || YAHOO.util.Easing.easeBoth);
        if(onComplete){
            if(!(onComplete instanceof Array)){
                anim.onComplete.subscribe(onComplete, this, true);
            }else{
                for(var i = 0; i < onComplete.length; i++){
                    var fn = onComplete[i];
                    if(fn) anim.onComplete.subscribe(fn, this, true);
                }
            }
        }
        anim.animate();
    },
    
    
    scrollIntoView : function(container){
        var c = getEl(container || document.body, true);
        var cp = c.getStyle('position');
        var restorePos = false;
        if(cp != 'relative' && cp != 'absolute'){
            c.setStyle('position', 'relative');
            restorePos = true;
        }
        var el = this.dom;
        var childTop = parseInt(el.offsetTop, 10);
        var childBottom = childTop + el.offsetHeight;
        var containerTop = parseInt(c.scrollTop, 10); 
        var containerBottom = containerTop + c.clientHeight;
        if(childTop < containerTop){
        	c.scrollTop = childTop;
        }else if(childBottom > containerBottom){
            c.scrollTop = childBottom-c.clientHeight;
        }
        if(restorePos){
            c.setStyle('position', cp);
        }
        return this;
    },
        
    
    autoHeight : function(animate, duration, onComplete, easing){
        var oldHeight = this.getHeight();
        this.clip();
        this.setHeight(1); 
        setTimeout(function(){
            var height = parseInt(this.dom.scrollHeight, 10); 
            if(!animate){
                this.setHeight(height);
                this.unclip();
                if(typeof onComplete == 'function'){
                    onComplete();
                }
            }else{
                this.setHeight(oldHeight); 
                this.setHeight(height, animate, duration, function(){
                    this.unclip();
                    if(typeof onComplete == 'function') onComplete();
                }.createDelegate(this), easing);
            }
        }.createDelegate(this), 0);
        return this;
    },
    
    
    isVisible : function(deep) {
        var vis = YAHOO.util.Dom.getStyle(this.dom, 'visibility') != 'hidden' 
               && YAHOO.util.Dom.getStyle(this.dom, 'display') != 'none';
        if(!deep || !vis){
            return vis;
        }
        var p = this.dom.parentNode;
        while(p && p.tagName.toLowerCase() != 'body'){
            if(YAHOO.util.Dom.getStyle(p, 'visibility') == 'hidden' || YAHOO.util.Dom.getStyle(p, 'display') == 'none'){
                return false;
            }
            p = p.parentNode;
        }
        return true;
    },
    
    
    select : function(selector, unique){
        return YAHOO.ext.Element.select('#' + this.dom.id + ' ' + selector, unique);  
    },
    
    
    initDD : function(group, config, overrides){
        var dd = new YAHOO.util.DD(YAHOO.util.Dom.generateId(this.dom), group, config);
        return YAHOO.ext.util.Config.apply(dd, overrides);
    },
   
    
    initDDProxy : function(group, config, overrides){
        var dd = new YAHOO.util.DDProxy(YAHOO.util.Dom.generateId(this.dom), group, config);
        return YAHOO.ext.util.Config.apply(dd, overrides);
    },
   
    
    initDDTarget : function(group, config, overrides){
        var dd = new YAHOO.util.DDTarget(YAHOO.util.Dom.generateId(this.dom), group, config);
        return YAHOO.ext.util.Config.apply(dd, overrides);
    },
   
    
     setVisible : function(visible, animate, duration, onComplete, easing){
        
        if(!animate || !YAHOO.util.Anim){
            if(this.visibilityMode == YAHOO.ext.Element.DISPLAY){
                this.setDisplayed(visible);
            }else{
                YAHOO.util.Dom.setStyle(this.dom, 'visibility', visible ? 'visible' : 'hidden');
            }
        }else{
            
            this.setOpacity(visible?0:1);
            YAHOO.util.Dom.setStyle(this.dom, 'visibility', 'visible');
            if(this.visibilityMode == YAHOO.ext.Element.DISPLAY){
                this.setDisplayed(true);
            }
            var args = {opacity: { from: (visible?0:1), to: (visible?1:0) }};
            var anim = new YAHOO.util.Anim(this.dom, args, duration || .35, 
                easing || (visible ? YAHOO.util.Easing.easeIn : YAHOO.util.Easing.easeOut));
            anim.onComplete.subscribe((function(){
                if(this.visibilityMode == YAHOO.ext.Element.DISPLAY){
                    this.setDisplayed(visible);
                }else{
                    YAHOO.util.Dom.setStyle(this.dom, 'visibility', visible ? 'visible' : 'hidden');
                }
            }).createDelegate(this));
            if(onComplete){
                anim.onComplete.subscribe(onComplete);
            }
            anim.animate();
        }
        return this;
    },
    
    
    isDisplayed : function() {
        return YAHOO.util.Dom.getStyle(this.dom, 'display') != 'none';
    },
    
    
    toggle : function(animate, duration, onComplete, easing){
        this.setVisible(!this.isVisible(), animate, duration, onComplete, easing);
        return this;
    },
    
    
    setDisplayed : function(value) {
        if(typeof value == 'boolean'){
           value = value ? this.originalDisplay : 'none';
        }
        YAHOO.util.Dom.setStyle(this.dom, 'display', value);
        return this;
    },
    
    
    focus : function() {
        try{
            this.dom.focus();
        }catch(e){}
        return this;
    },
    
    
    blur : function() {
        try{
            this.dom.blur();
        }catch(e){}
        return this;
    },
    
    
    addClass : function(className){
        if(className instanceof Array){
            for(var i = 0, len = className.length; i < len; i++) {
            	this.addClass(className[i]);
            }
        }else{
            if(!this.hasClass(className)){
                this.dom.className = this.dom.className + ' ' + className;
            }
        }
        return this;
    },
    
    
    radioClass : function(className){
        var siblings = this.dom.parentNode.childNodes;
        for(var i = 0; i < siblings.length; i++) {
        	var s = siblings[i];
        	if(s.nodeType == 1){
        	    YAHOO.util.Dom.removeClass(s, className);
        	}
        }
        this.addClass(className);
        return this;
    },
    
    removeClass : function(className){
        if(className instanceof Array){
            for(var i = 0, len = className.length; i < len; i++) {
            	this.removeClass(className[i]);
            }
        }else{
            var re = new RegExp('(?:^|\\s+)' + className + '(?:\\s+|$)', 'g');
            var c = this.dom.className;
            if(re.test(c)){
                this.dom.className = c.replace(re, ' ');
            }
        }
        return this;
    },
    
    
    toggleClass : function(className){
        if(this.hasClass(className)){
            this.removeClass(className);
        }else{
            this.addClass(className);
        }
        return this;
    },
    
    
    hasClass : function(className){
        var re = new RegExp('(?:^|\\s+)' + className + '(?:\\s+|$)');
        return re.test(this.dom.className);
    },
    
    
    replaceClass : function(oldClassName, newClassName){
        this.removeClass(oldClassName);
        this.addClass(newClassName);
        return this;
    },
    
    
    getStyle : function(name){
        return YAHOO.util.Dom.getStyle(this.dom, name);
    },
    
    
    setStyle : function(name, value){
        if(typeof name == 'string'){
            YAHOO.util.Dom.setStyle(this.dom, name, value);
        }else{
            var D = YAHOO.util.Dom;
            for(var style in name){
                if(typeof name[style] != 'function'){
                   D.setStyle(this.dom, style, name[style]);
                }
            }
        }
        return this;
    },
    
    
    applyStyles : function(style){
       YAHOO.ext.DomHelper.applyStyles(this.dom, style);
    },
    
    
    getX : function(){
        return YAHOO.util.Dom.getX(this.dom);
    },
    
    
    getY : function(){
        return YAHOO.util.Dom.getY(this.dom);
    },
    
    
    getXY : function(){
        return YAHOO.util.Dom.getXY(this.dom);
    },
    
    
    setX : function(x, animate, duration, onComplete, easing){
        if(!animate || !YAHOO.util.Anim){
            YAHOO.util.Dom.setX(this.dom, x);
        }else{
            this.setXY([x, this.getY()], animate, duration, onComplete, easing);
        }
        return this;
    },
    
    
    setY : function(y, animate, duration, onComplete, easing){
        if(!animate || !YAHOO.util.Anim){
            YAHOO.util.Dom.setY(this.dom, y);
        }else{
            this.setXY([this.getX(), y], animate, duration, onComplete, easing);
        }
        return this;
    },
    
    
    setLeft : function(left){
        YAHOO.util.Dom.setStyle(this.dom, 'left', this.addUnits(left));
        return this;
    },
    
    
    setTop : function(top){
        YAHOO.util.Dom.setStyle(this.dom, 'top', this.addUnits(top));
        return this;
    },
    
    
    setRight : function(right){
        YAHOO.util.Dom.setStyle(this.dom, 'right', this.addUnits(right));
        return this;
    },
    
    
    setBottom : function(bottom){
        YAHOO.util.Dom.setStyle(this.dom, 'bottom', this.addUnits(bottom));
        return this;
    },
    
    
    setXY : function(pos, animate, duration, onComplete, easing){
        if(!animate || !YAHOO.util.Anim){
            YAHOO.util.Dom.setXY(this.dom, pos);
        }else{
            this.anim({points: {to: pos}}, duration, onComplete, easing, YAHOO.util.Motion);
        }
        return this;
    },
    
    
    setLocation : function(x, y, animate, duration, onComplete, easing){
        this.setXY([x, y], animate, duration, onComplete, easing);
        return this;
    },
    
    
    moveTo : function(x, y, animate, duration, onComplete, easing){
        
        
        this.setXY([x, y], animate, duration, onComplete, easing);
        return this;
    },
    
    
    getRegion : function(){
        return YAHOO.util.Dom.getRegion(this.dom);
    },
    
    
    getHeight : function(contentHeight){
        var h = this.dom.offsetHeight;
        return contentHeight !== true ? h : h-this.getBorderWidth('tb')-this.getPadding('tb');
    },
    
    
    getWidth : function(contentWidth){
        var w = this.dom.offsetWidth;
        return contentWidth !== true ? w : w-this.getBorderWidth('lr')-this.getPadding('lr');
    },
    
    
    getSize : function(contentSize){
        return {width: this.getWidth(contentSize), height: this.getHeight(contentSize)};
    },
    
    
    adjustWidth : function(width){
        if(typeof width == 'number'){
            if(this.autoBoxAdjust && !this.isBorderBox()){
               width -= (this.getBorderWidth('lr') + this.getPadding('lr'));
            }
            if(width < 0){
                width = 0;
            }
        }
        return width;
    },
    
    
    adjustHeight : function(height){
        if(typeof height == 'number'){
           if(this.autoBoxAdjust && !this.isBorderBox()){
               height -= (this.getBorderWidth('tb') + this.getPadding('tb'));
           }
           if(height < 0){
               height = 0;
           }
        }
        return height;
    },
    
    
    setWidth : function(width, animate, duration, onComplete, easing){
        width = this.adjustWidth(width);
        if(!animate || !YAHOO.util.Anim){
            YAHOO.util.Dom.setStyle(this.dom, 'width', this.addUnits(width));
        }else{
            this.anim({width: {to: width}}, duration, onComplete, 
                easing || (width > this.getWidth() ? YAHOO.util.Easing.easeOut : YAHOO.util.Easing.easeIn));
        }
        return this;
    },
    
    
     setHeight : function(height, animate, duration, onComplete, easing){
        height = this.adjustHeight(height);
        if(!animate || !YAHOO.util.Anim){
            YAHOO.util.Dom.setStyle(this.dom, 'height', this.addUnits(height));
        }else{
            this.anim({height: {to: height}}, duration, onComplete,  
                   easing || (height > this.getHeight() ? YAHOO.util.Easing.easeOut : YAHOO.util.Easing.easeIn));
        }
        return this;
    },
    
    
     setSize : function(width, height, animate, duration, onComplete, easing){
        if(!animate || !YAHOO.util.Anim){
            this.setWidth(width);
            this.setHeight(height);
        }else{
            width = this.adjustWidth(width); height = this.adjustHeight(height);
            this.anim({width: {to: width}, height: {to: height}}, duration, onComplete, easing);
        }
        return this;
    },
    
    
    setBounds : function(x, y, width, height, animate, duration, onComplete, easing){
        if(!animate || !YAHOO.util.Anim){
            this.setWidth(width);
            this.setHeight(height);
            this.setLocation(x, y);
        }else{
            width = this.adjustWidth(width); height = this.adjustHeight(height);
            this.anim({points: {to: [x, y]}, width: {to: width}, height: {to: height}}, duration, onComplete, easing, YAHOO.util.Motion);
        }
        return this;
    },
    
    
    setRegion : function(region, animate, duration, onComplete, easing){
        this.setBounds(region.left, region.top, region.right-region.left, region.bottom-region.top, animate, duration, onComplete, easing);
        return this;
    },
    
    
    addListener : function(eventName, handler, scope, override){
        YAHOO.util.Event.addListener(this.dom, eventName, handler, scope || this, true);
        return this;
    },
    
    bufferedListener : function(eventName, fn, scope, millis){
        var task = new YAHOO.ext.util.DelayedTask();
        scope = scope || this;
        var newFn = function(){
            task.delay(millis || 250, fn, scope, Array.prototype.slice.call(arguments, 0));
        }
        this.addListener(eventName, newFn);
        return newFn;
    },
    
    
    
    addHandler : function(eventName, stopPropagation, handler, scope, override){
        var fn = YAHOO.ext.Element.createStopHandler(stopPropagation, handler, scope || this, true);
        YAHOO.util.Event.addListener(this.dom, eventName, fn);
        return this;
    },
    
    
    on : function(eventName, handler, scope, override){
        YAHOO.util.Event.addListener(this.dom, eventName, handler, scope || this, true);
        return this;
    },
    
    
    addManagedListener : function(eventName, fn, scope, override){
        return YAHOO.ext.EventManager.on(this.dom, eventName, fn, scope || this, true);
    },
    
    
    mon : function(eventName, fn, scope, override){
        return YAHOO.ext.EventManager.on(this.dom, eventName, fn, scope || this, true);
    },
    
    removeListener : function(eventName, handler, scope){
        YAHOO.util.Event.removeListener(this.dom, eventName, handler);
        return this;
    },
    
    
    removeAllListeners : function(){
        YAHOO.util.Event.purgeElement(this.dom);
        return this;
    },
    
    
    
     setOpacity : function(opacity, animate, duration, onComplete, easing){
        if(!animate || !YAHOO.util.Anim){
            YAHOO.util.Dom.setStyle(this.dom, 'opacity', opacity);
        }else{
            this.anim({opacity: {to: opacity}}, duration, onComplete, easing);
        }
        return this;
    },
    
    
    getLeft : function(local){
        if(!local){
            return this.getX();
        }else{
            return parseInt(this.getStyle('left'), 10) || 0;
        }
    },
    
    
    getRight : function(local){
        if(!local){
            return this.getX() + this.getWidth();
        }else{
            return (this.getLeft(true) + this.getWidth()) || 0;
        }
    },
    
    
    getTop : function(local) {
        if(!local){
            return this.getY();
        }else{
            return parseInt(this.getStyle('top'), 10) || 0;
        }
    },
    
    
    getBottom : function(local){
        if(!local){
            return this.getY() + this.getHeight();
        }else{
            return (this.getTop(true) + this.getHeight()) || 0;
        }
    },
    
    
    setAbsolutePositioned : function(zIndex){
        this.setStyle('position', 'absolute');
        if(zIndex){
            this.setStyle('z-index', zIndex);
        }
        return this;
    },
    
    
    setRelativePositioned : function(zIndex){
        this.setStyle('position', 'relative');
        if(zIndex){
            this.setStyle('z-index', zIndex);
        }
        return this;
    },
    
    
    clearPositioning : function(){
        this.setStyle('position', '');
        this.setStyle('left', '');
        this.setStyle('right', '');
        this.setStyle('top', '');
        this.setStyle('bottom', '');
        return this;
    },
    
    
    getPositioning : function(){
        return {
            'position' : this.getStyle('position'),
            'left' : this.getStyle('left'),
            'right' : this.getStyle('right'),
            'top' : this.getStyle('top'),
            'bottom' : this.getStyle('bottom')
        };
    },
    
    
    getBorderWidth : function(side){
        return this.addStyles(side, YAHOO.ext.Element.borders);
    },
    
    
    getPadding : function(side){
        return this.addStyles(side, YAHOO.ext.Element.paddings);
    },
    
    
    setPositioning : function(positionCfg){
        if(positionCfg.position)this.setStyle('position', positionCfg.position);
        if(positionCfg.left)this.setLeft(positionCfg.left);
        if(positionCfg.right)this.setRight(positionCfg.right);
        if(positionCfg.top)this.setTop(positionCfg.top);
        if(positionCfg.bottom)this.setBottom(positionCfg.bottom);
        return this;
    },
    
    
    
     setLeftTop : function(left, top){
        this.dom.style.left = this.addUnits(left);
        this.dom.style.top = this.addUnits(top);
        return this;
    },
    
    
     move : function(direction, distance, animate, duration, onComplete, easing){
        var xy = this.getXY();
        direction = direction.toLowerCase();
        switch(direction){
            case 'l':
            case 'left':
                this.moveTo(xy[0]-distance, xy[1], animate, duration, onComplete, easing);
                break;
           case 'r':
           case 'right':
                this.moveTo(xy[0]+distance, xy[1], animate, duration, onComplete, easing);
                break;
           case 't':
           case 'top':
           case 'up':
                this.moveTo(xy[0], xy[1]-distance, animate, duration, onComplete, easing);
                break;
           case 'b':
           case 'bottom':
           case 'down':
                this.moveTo(xy[0], xy[1]+distance, animate, duration, onComplete, easing);
                break;
        }
        return this;
    },
    
    
    clip : function(){
        if(!this.isClipped){
           this.isClipped = true;
           this.originalClip = {
               'o': this.getStyle('overflow'), 
               'x': this.getStyle('overflow-x'),
               'y': this.getStyle('overflow-y')
           };
           this.setStyle('overflow', 'hidden');
           this.setStyle('overflow-x', 'hidden');
           this.setStyle('overflow-y', 'hidden');
        }
        return this;
    },
    
    
    unclip : function(){
        if(this.isClipped){
            this.isClipped = false;
            var o = this.originalClip;
            if(o.o){this.setStyle('overflow', o.o);}
            if(o.x){this.setStyle('overflow-x', o.x);}
            if(o.y){this.setStyle('overflow-y', o.y);}
        }
        return this;
    },
    
    
     alignTo : function(element, position, offsets, animate, duration, onComplete, easing){
        var otherEl = getEl(element);
        if(!otherEl){
            return this; 
        }
        offsets = offsets || [0, 0];
        var r = otherEl.getRegion();
        position = position.toLowerCase();
        switch(position){
           case 'bl':
                this.moveTo(r.left + offsets[0], r.bottom + offsets[1], 
                            animate, duration, onComplete, easing);
                break;
           case 'br':
                this.moveTo(r.right + offsets[0], r.bottom + offsets[1], 
                            animate, duration, onComplete, easing);
                break;
           case 'tl':
                this.moveTo(r.left + offsets[0], r.top + offsets[1], 
                            animate, duration, onComplete, easing);
                break;
           case 'tr':
                this.moveTo(r.right + offsets[0], r.top + offsets[1], 
                            animate, duration, onComplete, easing);
                break;
        }
        return this;
    },
    
    
    clearOpacity : function(){
        if (window.ActiveXObject) {
            this.dom.style.filter = '';
        } else {
            this.dom.style.opacity = '';
            this.dom.style['-moz-opacity'] = '';
            this.dom.style['-khtml-opacity'] = '';
        }
        return this;
    },
    
    
    hide : function(animate, duration, onComplete, easing){
        this.setVisible(false, animate, duration, onComplete, easing);
        return this;
    },
    
    
    show : function(animate, duration, onComplete, easing){
        this.setVisible(true, animate, duration, onComplete, easing);
        return this;
    },
    
    
    addUnits : function(size){
        if(size === '' || size == 'auto' || typeof size == 'undefined'){
            return size;
        }
        if(typeof size == 'number' || !YAHOO.ext.Element.unitPattern.test(size)){
            return size + this.defaultUnit;
        }
        return size;
    },
    
    
    beginMeasure : function(){
        var el = this.dom;
        if(el.offsetWidth || el.offsetHeight){
            return this; 
        }
        var changed = [];
        var p = this.dom; 
        while((!el.offsetWidth && !el.offsetHeight) && p && p.tagName && p.tagName.toLowerCase() != 'body'){
            if(YAHOO.util.Dom.getStyle(p, 'display') == 'none'){
                changed.push({el: p, visibility: YAHOO.util.Dom.getStyle(p, 'visibility')});
                p.style.visibility = 'hidden';
                p.style.display = 'block';
            }
            p = p.parentNode;
        }
        this._measureChanged = changed;
        return this;
               
    },
    
    
    endMeasure : function(){
        var changed = this._measureChanged;
        if(changed){
            for(var i = 0, len = changed.length; i < len; i++) {
            	var r = changed[i];
            	r.el.style.visibility = r.visibility;
                r.el.style.display = 'none';
            }
            this._measureChanged = null;
        }
        return this;
    },
    
    
    update : function(html, loadScripts, callback){
        if(typeof html == 'undefined'){
            html = '';
        }
        if(loadScripts !== true){
            this.dom.innerHTML = html;
            if(typeof callback == 'function'){
                callback();
            }
            return this;
        }
        var id = YAHOO.util.Dom.generateId();
        var dom = this.dom;
        
        html += '<span id="' + id + '"></span>';
        
        YAHOO.util.Event.onAvailable(id, function(){
            var hd = document.getElementsByTagName("head")[0];
            var re = /(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)/img; 
            var srcRe = /\ssrc=([\'\"])(.*?)\1/i;
            var match;
            while(match = re.exec(html)){
                var srcMatch = match[0].match(srcRe);
                if(srcMatch && srcMatch[2]){
                   var s = document.createElement("script");
                   s.src = srcMatch[2];
                   hd.appendChild(s);
                }else if(match[1] && match[1].length > 0){
                   eval(match[1]);
                }                     
            }
            var el = document.getElementById(id);
            if(el){el.parentNode.removeChild(el);}
            if(typeof callback == 'function'){
                callback();
            }
        });
        dom.innerHTML = html.replace(/(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)/img, '');
        return this;
    },
    
    
    load : function(){
        var um = this.getUpdateManager();
        um.update.apply(um, arguments);
        return this;
    },
    
    
    getUpdateManager : function(){
        if(!this.updateManager){
            this.updateManager = new YAHOO.ext.UpdateManager(this);
        }
        return this.updateManager;
    },
    
    
    unselectable : function(){
        this.dom.unselectable = 'on';
        this.swallowEvent('selectstart', true);
        this.applyStyles('-moz-user-select:none;-khtml-user-select:none;');
        return this;
    },
    
    
    getCenterXY : function(offsetScroll){
        var centerX = Math.round((YAHOO.util.Dom.getViewportWidth()-this.getWidth())/2);
        var centerY = Math.round((YAHOO.util.Dom.getViewportHeight()-this.getHeight())/2);
        if(!offsetScroll){
            return [centerX, centerY];
        }else{
            var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft || 0;
            var scrollY = document.documentElement.scrollTop || document.body.scrollTop || 0;
            return[centerX + scrollX, centerY + scrollY];
        }
    },
    
    
    center : function(centerIn) {
        if(!centerIn){
            this.setXY(this.getCenterXY(true));
        }else{
            var box = YAHOO.ext.Element.get(centerIn).getBox();
            this.setXY([box.x + (box.width / 2) - (this.getWidth() / 2),
                   box.y + (box.height / 2) - (this.getHeight() / 2)]);
        }
        return this;
    },

    
    getChildrenByTagName : function(tagName){
        var children = this.dom.getElementsByTagName(tagName);
        var len = children.length;
        var ce = new Array(len);
        for(var i = 0; i < len; ++i){
            ce[i] = YAHOO.ext.Element.get(children[i], true);
        }
        return ce;
    },
    
    
    getChildrenByClassName : function(className, tagName){
        var children = YAHOO.util.Dom.getElementsByClassName(className, tagName, this.dom);
        var len = children.length;
        var ce = new Array(len);
        for(var i = 0; i < len; ++i){
            ce[i] = YAHOO.ext.Element.get(children[i], true);
        }
        return ce;
    },
    
    
    isBorderBox : function(){
        if(typeof this.bbox == 'undefined'){
            var el = this.dom;
            var b = YAHOO.ext.util.Browser;
            var strict = YAHOO.ext.Strict;
            this.bbox = ((b.isIE && !strict && el.style.boxSizing != 'content-box') || 
               (b.isGecko && YAHOO.util.Dom.getStyle(el, "-moz-box-sizing") == 'border-box') || 
               (!b.isSafari && YAHOO.util.Dom.getStyle(el, "box-sizing") == 'border-box'));
        }
        return this.bbox; 
    },
    
    
    getBox : function(contentBox, local){
        var xy;
        if(!local){
            xy = this.getXY();
        }else{
            var left = parseInt(YAHOO.util.Dom.getStyle('left'), 10) || 0;
            var top = parseInt(YAHOO.util.Dom.getStyle('top'), 10) || 0;
            xy = [left, top];
        }
        var el = this.dom;
        var w = el.offsetWidth;
        var h = el.offsetHeight;
        if(!contentBox){
            return {x: xy[0], y: xy[1], width: w, height: h};
        }else{
            var l = this.getBorderWidth('l')+this.getPadding('l');
            var r = this.getBorderWidth('r')+this.getPadding('r');
            var t = this.getBorderWidth('t')+this.getPadding('t');
            var b = this.getBorderWidth('b')+this.getPadding('b');
            return {x: xy[0]+l, y: xy[1]+t, width: w-(l+r), height: h-(t+b)};
        }
    },
    
    
    setBox : function(box, adjust, animate, duration, onComplete, easing){
        var w = box.width, h = box.height;
        if((adjust && !this.autoBoxAdjust) && !this.isBorderBox()){
           w -= (this.getBorderWidth('lr') + this.getPadding('lr'));
           h -= (this.getBorderWidth('tb') + this.getPadding('tb'));
        }
        this.setBounds(box.x, box.y, w, h, animate, duration, onComplete, easing);
        return this;
    },
    
    
     repaint : function(){
        var dom = this.dom;
        YAHOO.util.Dom.addClass(dom, 'yui-ext-repaint');
        setTimeout(function(){
            YAHOO.util.Dom.removeClass(dom, 'yui-ext-repaint');
        }, 1);
        return this;
    },
    
    
    getMargins : function(side){
        if(!side){
            return {
                top: parseInt(this.getStyle('margin-top'), 10) || 0,
                left: parseInt(this.getStyle('margin-left'), 10) || 0,
                bottom: parseInt(this.getStyle('margin-bottom'), 10) || 0,
                right: parseInt(this.getStyle('margin-right'), 10) || 0
            };
        }else{
            return this.addStyles(side, YAHOO.ext.Element.margins);
         }
    },
    
    addStyles : function(sides, styles){
        var val = 0;
        for(var i = 0, len = sides.length; i < len; i++){
             var w = parseInt(this.getStyle(styles[sides.charAt(i)]), 10);
             if(!isNaN(w)) val += w;
        }
        return val;
    },
    
    
    createProxy : function(config, renderTo, matchBox){
        if(renderTo){
            renderTo = YAHOO.util.Dom.get(renderTo);
        }else{
            renderTo = document.body;
        }
        config = typeof config == 'object' ? 
            config : {tag : 'div', cls: config};
        var proxy = YAHOO.ext.DomHelper.append(renderTo, config, true);
        if(matchBox){
           proxy.setBox(this.getBox());
        }
        return proxy;
    },
    
    
    createShim : function(){
        var config = {
            tag : 'iframe', 
            frameBorder:'no', 
            cls: 'yiframe-shim', 
            style: 'position:absolute;visibility:hidden;left:0;top:0;overflow:hidden;', 
            src: YAHOO.ext.SSL_SECURE_URL
        };
        var shim = YAHOO.ext.DomHelper.append(this.dom.parentNode, config, true);
        shim.setBox(this.getBox());
        return shim;
    },
    
    
    remove : function(){
	        this.dom.parentNode.removeChild(this.dom);
	        delete YAHOO.ext.Element.cache[this.dom.id];
    },
    
    
    addClassOnOver : function(className){
        this.on('mouseover', function(){
            this.addClass(className);
        }, this, true);
        this.on('mouseout', function(){
            this.removeClass(className);
        }, this, true);
        return this;
    },
    
    
    swallowEvent : function(eventName, preventDefault){
        var fn = function(e){
            e.stopPropagation();
            if(preventDefault){
                e.preventDefault();
            }
        };
        this.mon(eventName, fn);
        return this;
    },
    
    
    fitToParent : function(monitorResize){
        var p = getEl(this.dom.parentNode, true);
        p.beginMeasure(); 
        var box = p.getBox(true, true);
        p.endMeasure();
        this.setSize(box.width, box.height);
        if(monitorResize === true){
            YAHOO.ext.EventManager.onWindowResize(this.fitToParent, this, true);
        }
        return this;
    },
    
    
    getNextSibling : function(){
        var n = this.dom.nextSibling;
        while(n && n.nodeType != 1){
            n = n.nextSibling;
        }
        return n;
    },
    
    
    getPrevSibling : function(){
        var n = this.dom.previousSibling;
        while(n && n.nodeType != 1){
            n = n.previousSibling;
        }
        return n;
    },
    
    
    
    appendChild: function(el){
        el = getEl(el);
        el.appendTo(this);
        return this;
    },
    
    
    createChild: function(config, insertBefore){
        var c;
        if(insertBefore){
            c = YAHOO.ext.DomHelper.insertBefore(insertBefore, config, true);
        }else{
            c = YAHOO.ext.DomHelper.append(this.dom, config, true);
        }
        return c;
    },
    
    
    appendTo: function(el){
        var node = getEl(el).dom;
        node.appendChild(this.dom);
        return this;
    },
    
    
    insertBefore: function(el){
        var node = getEl(el).dom;
        node.parentNode.insertBefore(this.dom, node);
        return this;
    },
    
    
    insertAfter: function(el){
        var node = getEl(el).dom;
        node.parentNode.insertBefore(this.dom, node.nextSibling);
        return this;
    },
    
    
    wrap: function(config){
        if(!config){
            config = {tag: 'div'};
        }
        var newEl = YAHOO.ext.DomHelper.insertBefore(this.dom, config, true);
        newEl.dom.appendChild(this.dom);
        return newEl;
    },
    
    
    replace: function(el){
        el = getEl(el);
        this.insertBefore(el);
        el.remove();
        return this;
    },
    
    
    insertHtml : function(where, html){
        YAHOO.ext.DomHelper.insertHtml(where, this.dom, html);
        return this;
    },
    
    
    set : function(o){
        var el = this.dom;
        var useSet = el.setAttribute ? true : false;
        for(var attr in o){
            if(attr == 'style' || typeof o[attr] == 'function') continue;
            if(attr=='cls'){
                el.className = o['cls'];
            }else{
                if(useSet) el.setAttribute(attr, o[attr]);
                else el[attr] = o[attr];
            }
        }
        YAHOO.ext.DomHelper.applyStyles(el, o.style);
        return this;
    },
    
    
    addKeyListener : function(key, fn, scope){
        var config;
        if(typeof key != 'object' || key instanceof Array){
            config = {
                key: key,
                fn: fn,
                scope: scope 
            };
        }else{
            config = {
                key : key.key,
                shift : key.shift,
                ctrl : key.ctrl,
                alt : key.alt,
                fn: fn,
                scope: scope
            };
        }
        var map = new YAHOO.ext.KeyMap(this, config);
        return map; 
    },
    
    
    addKeyMap : function(config){
        return new YAHOO.ext.KeyMap(this, config);
    }
};


YAHOO.ext.Element.prototype.autoBoxAdjust = true;

YAHOO.ext.Element.prototype.autoDisplayMode = true;

YAHOO.ext.Element.unitPattern = /\d+(px|em|%|en|ex|pt|in|cm|mm|pc)$/i;

YAHOO.ext.Element.VISIBILITY = 1;

YAHOO.ext.Element.DISPLAY = 2;

YAHOO.ext.Element.blockElements = /^(?:address|blockquote|center|dir|div|dl|fieldset|form|h\d|hr|isindex|menu|ol|ul|p|pre|table|dd|dt|li|tbody|tr|td|thead|tfoot|iframe)$/i;
YAHOO.ext.Element.borders = {l: 'border-left-width', r: 'border-right-width', t: 'border-top-width', b: 'border-bottom-width'};
YAHOO.ext.Element.paddings = {l: 'padding-left', r: 'padding-right', t: 'padding-top', b: 'padding-bottom'};
YAHOO.ext.Element.margins = {l: 'margin-left', r: 'margin-right', t: 'margin-top', b: 'margin-bottom'};
        

YAHOO.ext.Element.createStopHandler = function(stopPropagation, handler, scope, override){
    return function(e){
        if(e){
            if(stopPropagation){
                YAHOO.util.Event.stopEvent(e);
            }else {
                YAHOO.util.Event.preventDefault(e);
            }
        }
        handler.call(override && scope ? scope : window, e, scope);
    };
};


YAHOO.ext.Element.cache = {};


YAHOO.ext.Element.get = function(el, autoGenerateId){
    if(!el){ return null; }
    autoGenerateId = true; 
    if(el instanceof YAHOO.ext.Element){
        el.dom = YAHOO.util.Dom.get(el.id); 
        YAHOO.ext.Element.cache[el.id] = el; 
        return el;
    }else if(el.isComposite){
        return el;
    }else if(el instanceof Array){
        return YAHOO.ext.Element.select(el);
    }else if(el === document){
        
        if(!YAHOO.ext.Element.cache['__ydocument']){
            var docEl = function(){};
            docEl.prototype = YAHOO.ext.Element.prototype;
            var o = new docEl();
            o.dom = document;
            YAHOO.ext.Element.cache['__ydocument'] = o;
        }
        return YAHOO.ext.Element.cache['__ydocument'];
    }
    var key = el;
    if(typeof el != 'string'){ 
        if(!el.id && !autoGenerateId){ return null; }
        YAHOO.util.Dom.generateId(el, 'elgen-');
        key = el.id;
    }
    var element = YAHOO.ext.Element.cache[key];
    if(!element){
        element = new YAHOO.ext.Element(key);
        if(!element.dom) return null;
        YAHOO.ext.Element.cache[key] = element;
    }else{
        element.dom = YAHOO.util.Dom.get(key);
    }
    return element;
};


var getEl = YAHOO.ext.Element.get;


YAHOO.util.Event.addListener(window, 'unload', function(){ 
    YAHOO.ext.Element.cache = null;
});



YAHOO.ext.CompositeElement = function(els){
    this.elements = [];
    this.addElements(els);
};
YAHOO.ext.CompositeElement.prototype = {
    isComposite: true,
    addElements : function(els){
        if(!els) return this;
        var yels = this.elements;
        var index = yels.length-1;
        for(var i = 0, len = els.length; i < len; i++) {
        	yels[++index] = getEl(els[i], true);
        }
        return this;
    },
    invoke : function(fn, args){
        var els = this.elements;
        for(var i = 0, len = els.length; i < len; i++) {
        	YAHOO.ext.Element.prototype[fn].apply(els[i], args);
        }
        return this;
    },
    
    add : function(els){
        if(typeof els == 'string'){
            this.addElements(YAHOO.ext.Element.selectorFunction(string));
        }else if(els instanceof Array){
            this.addElements(els);
        }else{
            this.addElements([els]);
        }
        return this;
    },
    
    each : function(fn, scope){
        var els = this.elements;
        for(var i = 0, len = els.length; i < len; i++){
            fn.call(scope || els[i], els[i], this, i);
        }
        return this;
    }
};

YAHOO.ext.CompositeElementLite = function(els){
    YAHOO.ext.CompositeElementLite.superclass.constructor.call(this, els);
    this.el = YAHOO.ext.Element.get(this.elements[0], true);
};
YAHOO.extendX(YAHOO.ext.CompositeElementLite, YAHOO.ext.CompositeElement, {
    addElements : function(els){
        if(els){
            this.elements = this.elements.concat(els);
        }
        return this;
    },
    invoke : function(fn, args){
        var els = this.elements;
        var el = this.el;
        for(var i = 0, len = els.length; i < len; i++) {
            el.dom = els[i];
        	YAHOO.ext.Element.prototype[fn].apply(el, args);
        }
        return this;
    }
});
YAHOO.ext.CompositeElement.createCall = function(proto, fnName){
    if(!proto[fnName]){
        proto[fnName] = function(){
            return this.invoke(fnName, arguments);  
        };
    }
};
for(var fnName in YAHOO.ext.Element.prototype){
    if(typeof YAHOO.ext.Element.prototype[fnName] == 'function'){
        YAHOO.ext.CompositeElement.createCall(YAHOO.ext.CompositeElement.prototype, fnName);
    }
}
if(typeof cssQuery == 'function'){
    YAHOO.ext.Element.selectorFunction = cssQuery;
}else if(typeof document.getElementsBySelector == 'function'){ 
    YAHOO.ext.Element.selectorFunction = document.getElementsBySelector.createDelegate(document);
}

YAHOO.ext.Element.select = function(selector, unique){
    var els;
    if(typeof selector == 'string'){
        els = YAHOO.ext.Element.selectorFunction(selector);
    }else if(selector instanceof Array){
        els = selector;
    }else{
        throw 'Invalid selector';
    }
    if(unique === true){
        return new YAHOO.ext.CompositeElement(els);
    }else{
        return new YAHOO.ext.CompositeElementLite(els);
    }
};

var getEls = YAHOO.ext.Element.select;
YAHOO.namespace('ext.state');

YAHOO.ext.state.Provider = function(){
    YAHOO.ext.state.Provider.superclass.constructor.call(this);
    
    this.events = {
        'statechange': new YAHOO.util.CustomEvent('statechange')  
    };
    this.state = {};
};
YAHOO.extendX(YAHOO.ext.state.Provider, YAHOO.ext.util.Observable, {
    
    get : function(name, defaultValue){
        return typeof this.state[name] == 'undefined' ?
            defaultValue : this.state[name];
    },
    
    
    clear : function(name){
        delete this.state[name];
        this.fireEvent('statechange', this, name, null);
    },
    
    
    set : function(name, value){
        this.state[name] = value;
        this.fireEvent('statechange', this, name, value);
    },
    
    
    decodeValue : function(cookie){
        var re = /^(a|n|d|b|s|o)\:(.*)$/;
        var matches = re.exec(unescape(cookie));
        if(!matches || !matches[1]) return; 
        var type = matches[1];
        var v = matches[2];
        switch(type){
            case 'n':
                return parseFloat(v);
            case 'd':
                return new Date(Date.parse(v));
            case 'b':
                return (v == '1');
            case 'a':
                var all = [];
                var values = v.split('^');
                for(var i = 0, len = values.length; i < len; i++){
                    all.push(this.decodeValue(values[i]))
                }
                return all;
           case 'o':
                var all = {};
                var values = v.split('^');
                for(var i = 0, len = values.length; i < len; i++){
                    var kv = values[i].split('=');
                    all[kv[0]] = this.decodeValue(kv[1]);
                }
                return all;
           default:
                return v;
        }
    },
    
    
    encodeValue : function(v){
        var enc;
        if(typeof v == 'number'){
            enc = 'n:' + v;
        }else if(typeof v == 'boolean'){
            enc = 'b:' + (v ? '1' : '0');
        }else if(v instanceof Date){
            enc = 'd:' + v.toGMTString();
        }else if(v instanceof Array){
            var flat = '';
            for(var i = 0, len = v.length; i < len; i++){
                flat += this.encodeValue(v[i]);
                if(i != len-1) flat += '^';
            }
            enc = 'a:' + flat;
        }else if(typeof v == 'object'){
            var flat = '';
            for(var key in v){
                if(typeof v[key] != 'function'){
                    flat += key + '=' + this.encodeValue(v[key]) + '^';
                }
            }
            enc = 'o:' + flat.substring(0, flat.length-1);
        }else{
            enc = 's:' + v;
        }
        return escape(enc);        
    }
});


YAHOO.ext.state.Manager = new function(){
    var provider = new YAHOO.ext.state.Provider();
    
    return {
        
        setProvider : function(stateProvider){
            provider = stateProvider;
        },
        
        
        get : function(key, defaultValue){
            return provider.get(key, defaultValue);
        },
        
        
         set : function(key, value){
            provider.set(key, value);
        },
        
        
        clear : function(key){
            provider.clear(key);
        },
        
        
        getProvider : function(){
            return provider;
        }
    };
}();


YAHOO.ext.state.CookieProvider = function(config){
    YAHOO.ext.state.CookieProvider.superclass.constructor.call(this);
    this.path = '/';
    this.expires = new Date(new Date().getTime()+(1000*60*60*24*7)); 
    this.domain = null;
    this.secure = false;
    YAHOO.ext.util.Config.apply(this, config);
    this.state = this.readCookies();
};

YAHOO.extendX(YAHOO.ext.state.CookieProvider, YAHOO.ext.state.Provider, {
    set : function(name, value){
        if(typeof value == 'undefined' || value === null){
            this.clear(name);
            return;
        }
        this.setCookie(name, value);
        YAHOO.ext.state.CookieProvider.superclass.set.call(this, name, value);
    },
        
    clear : function(name){
        this.clearCookie(name);
        YAHOO.ext.state.CookieProvider.superclass.clear.call(this, name);
    },
        
    readCookies : function(){
        var cookies = {};
        var c = document.cookie + ';';
        var re = /\s?(.*?)=(.*?);/g;
    	var matches;
    	while((matches = re.exec(c)) != null){
            var name = matches[1];
            var value = matches[2];
            if(name && name.substring(0,3) == 'ys-'){
                cookies[name.substr(3)] = this.decodeValue(value);
            }
        }
        return cookies;
    },
    
    setCookie : function(name, value){
        document.cookie = "ys-"+ name + "=" + this.encodeValue(value) +
           ((this.expires == null) ? "" : ("; expires=" + this.expires.toGMTString())) +
           ((this.path == null) ? "" : ("; path=" + this.path)) +
           ((this.domain == null) ? "" : ("; domain=" + this.domain)) +
           ((this.secure == true) ? "; secure" : "");
    },
    
    clearCookie : function(name){
        document.cookie = "ys-" + name + "=null; expires=Thu, 01-Jan-70 00:00:01 GMT" +
           ((this.path == null) ? "" : ("; path=" + this.path)) +
           ((this.domain == null) ? "" : ("; domain=" + this.domain)) +
           ((this.secure == true) ? "; secure" : "");
    }
});



YAHOO.ext.EventManager = new function(){
    var docReadyEvent;
    var docReadyProcId;
    var docReadyState = false;
    this.ieDeferSrc = false;
    var resizeEvent;
    var resizeTask;
    
    var fireDocReady = function(){
        if(!docReadyState){
            docReadyState = true;
            if(docReadyProcId){
                clearInterval(docReadyProcId);
            }
            if(docReadyEvent){
                docReadyEvent.fire();
            }
        }
    };
    
    var initDocReady = function(){
        docReadyEvent = new YAHOO.util.CustomEvent('documentready');
        if(document.addEventListener) {
            YAHOO.util.Event.on(document, "DOMContentLoaded", fireDocReady);
        }else if(YAHOO.ext.util.Browser.isIE){
            
            document.write('<s'+'cript id="ie-deferred-loader" defer="defer" src="' +
                        (YAHOO.ext.EventManager.ieDeferSrc || YAHOO.ext.SSL_SECURE_URL) + '"></s'+'cript>');
            YAHOO.util.Event.on('ie-deferred-loader', 'readystatechange', function(){
                if(this.readyState == 'complete'){
                    fireDocReady();
                }
            });
        }else if(YAHOO.ext.util.Browser.isSafari){ 
            docReadyProcId = setInterval(function(){
                var rs = document.readyState;
                if(rs == 'loaded' || rs == 'complete') {
                    fireDocReady();     
                 }
            }, 10);
        }
        
        YAHOO.util.Event.on(window, 'load', fireDocReady);
    };
    
    this.wrap = function(fn, scope, override){
        var wrappedFn = function(e){
            YAHOO.ext.EventObject.setEvent(e);
            fn.call(override ? scope || window : window, YAHOO.ext.EventObject, scope);
        };
        return wrappedFn;
    };
    
    
    this.addListener = function(element, eventName, fn, scope, override){
        var wrappedFn = this.wrap(fn, scope, override);
        YAHOO.util.Event.addListener(element, eventName, wrappedFn);
        return wrappedFn;
    };
    
    
    this.removeListener = function(element, eventName, wrappedFn){
        return YAHOO.util.Event.removeListener(element, eventName, wrappedFn);
    };
    
    
    this.on = this.addListener;
    
    
    this.onDocumentReady = function(fn, scope, override){
        if(docReadyState){ 
            fn.call(override? scope || window : window, scope);
            return;
        }
        if(!docReadyEvent){
            initDocReady();
        }
        docReadyEvent.subscribe(fn, scope, override);
    }
    
    
    this.onWindowResize = function(fn, scope, override){
        if(!resizeEvent){
            resizeEvent = new YAHOO.util.CustomEvent('windowresize');
            resizeTask = new YAHOO.ext.util.DelayedTask(function(){
                resizeEvent.fireDirect(YAHOO.util.Dom.getViewportWidth(), YAHOO.util.Dom.getViewportHeight());
            });
            YAHOO.util.Event.on(window, 'resize', function(){
                resizeTask.delay(50);
            });
        }
        resizeEvent.subscribe(fn, scope, override);
    },
    
    
    this.removeResizeListener = function(fn, scope){
        if(resizeEvent){
            resizeEvent.unsubscribe(fn, scope);
        }
    }
};


YAHOO.ext.EventObject = new function(){
     
    this.browserEvent = null;
     
    this.button = -1;
     
    this.shiftKey = false;
     
    this.ctrlKey = false;
     
    this.altKey = false;
    
    
    this.BACKSPACE = 8;
    
    this.TAB = 9;
    
    this.RETURN = 13;
    
    this.ESC = 27;
    
    this.SPACE = 32;
    
    this.PAGEUP = 33;
    
    this.PAGEDOWN = 34;
    
    this.END = 35;
    
    this.HOME = 36;
    
    this.LEFT = 37;
    
    this.UP = 38;
    
    this.RIGHT = 39;
    
    this.DOWN = 40;
    
    this.DELETE = 46;
    
    this.F5 = 116;

        
    this.setEvent = function(e){
        if(e == this){ 
            return this;
        }
        this.browserEvent = e;
        if(e){
            this.button = e.button;
            this.shiftKey = e.shiftKey;
            this.ctrlKey = e.ctrlKey;
            this.altKey = e.altKey;
        }else{
            this.button = -1;
            this.shiftKey = false;
            this.ctrlKey = false;
            this.altKey = false;
        }
        return this;
    };
    
     
    this.stopEvent = function(){
        if(this.browserEvent){
            YAHOO.util.Event.stopEvent(this.browserEvent);
        }
    };
    
     
    this.preventDefault = function(){
        if(this.browserEvent){
            YAHOO.util.Event.preventDefault(this.browserEvent);
        }
    };
    
    
    this.isNavKeyPress = function(){
        return (this.browserEvent.keyCode && this.browserEvent.keyCode >= 33 && this.browserEvent.keyCode <= 40);
    };
    
     
    this.stopPropagation = function(){
        if(this.browserEvent){
            YAHOO.util.Event.stopPropagation(this.browserEvent);
        }
    };
    
     
    this.getCharCode = function(){
        if(this.browserEvent){
            return YAHOO.util.Event.getCharCode(this.browserEvent);
        }
        return null;
    };
    
    
    this.getKey = function(){
        if(this.browserEvent){
            return this.browserEvent.keyCode || this.browserEvent.charCode;
        }
        return null;
    };
    
     
    this.getPageX = function(){
        if(this.browserEvent){
            return YAHOO.util.Event.getPageX(this.browserEvent);
        }
        return null;
    };
    
     
    this.getPageY = function(){
        if(this.browserEvent){
            return YAHOO.util.Event.getPageY(this.browserEvent);
        }
        return null;
    };
    
     
    this.getTime = function(){
        if(this.browserEvent){
            return YAHOO.util.Event.getTime(this.browserEvent);
        }
        return null;
    };
    
     
    this.getXY = function(){
        if(this.browserEvent){
            return YAHOO.util.Event.getXY(this.browserEvent);
        }
        return [];
    };
    
     
    this.getTarget = function(){
        if(this.browserEvent){
            return YAHOO.util.Event.getTarget(this.browserEvent);
        }
        return null;
    };
    
     
    this.findTarget = function(className, tagName){
        if(tagName) tagName = tagName.toLowerCase();
        if(this.browserEvent){
            function isMatch(el){
               if(!el){
                   return false;
               }
               if(className && !YAHOO.util.Dom.hasClass(el, className)){
                   return false;
               }
               if(tagName && el.tagName.toLowerCase() != tagName){
                   return false;
               }
               return true;
            };
            
            var t = this.getTarget();
            if(!t || isMatch(t)){
    		    return t;
    	    }
    	    var p = t.parentNode;
    	    var b = document.body;
    	    while(p && p != b){
                if(isMatch(p)){
                	return p;
                }
                p = p.parentNode;
            }
    	}
        return null;
    };
     
    this.getRelatedTarget = function(){
        if(this.browserEvent){
            return YAHOO.util.Event.getRelatedTarget(this.browserEvent);
        }
        return null;
    };
    
    
    this.getWheelDelta = function(){
        var e = this.browserEvent;
        var delta = 0;
        if(e.wheelDelta){ 
            delta = e.wheelDelta/120;
            
            if(window.opera) delta = -delta;
        }else if(e.detail){ 
            delta = -e.detail/3;
        }
        return delta;
    };
    
     
    this.hasModifier = function(){
        return this.ctrlKey || this.altKey || this.shiftKey;
    };
}();
            
    

YAHOO.ext.UpdateManager = function(el, forceNew){
    el = YAHOO.ext.Element.get(el);
    if(!forceNew && el.updateManager){
        return el.updateManager;
    }
    
    this.el = el;
    
    this.defaultUrl = null;
    this.beforeUpdate = new YAHOO.util.CustomEvent('UpdateManager.beforeUpdate');
    this.onUpdate = new YAHOO.util.CustomEvent('UpdateManager.onUpdate');
    this.onFailure = new YAHOO.util.CustomEvent('UpdateManager.onFailure');
    
    this.events = {
        
        'beforeupdate': this.beforeUpdate,
        
        'update': this.onUpdate,
        
        'failure': this.onFailure 
    };
    
    
    this.sslBlankUrl = YAHOO.ext.UpdateManager.defaults.sslBlankUrl;
    
    this.disableCaching = YAHOO.ext.UpdateManager.defaults.disableCaching;
    
    this.indicatorText = YAHOO.ext.UpdateManager.defaults.indicatorText;
    
    this.showLoadIndicator = YAHOO.ext.UpdateManager.defaults.showLoadIndicator;
    
    this.timeout = YAHOO.ext.UpdateManager.defaults.timeout;
    
    
    this.loadScripts = YAHOO.ext.UpdateManager.defaults.loadScripts;
    
    
    this.transaction = null;
    
    
    this.autoRefreshProcId = null;
    
    this.refreshDelegate = this.refresh.createDelegate(this);
    
    this.updateDelegate = this.update.createDelegate(this);
    
    this.formUpdateDelegate = this.formUpdate.createDelegate(this);
    
    this.successDelegate = this.processSuccess.createDelegate(this);
    
     this.failureDelegate = this.processFailure.createDelegate(this);
     
     
      this.renderer = new YAHOO.ext.UpdateManager.BasicRenderer();
};

YAHOO.ext.UpdateManager.prototype = {
    fireEvent : YAHOO.ext.util.Observable.prototype.fireEvent,
    on : YAHOO.ext.util.Observable.prototype.on,
    addListener : YAHOO.ext.util.Observable.prototype.addListener,
    delayedListener : YAHOO.ext.util.Observable.prototype.delayedListener,
    removeListener : YAHOO.ext.util.Observable.prototype.removeListener,
    purgeListeners : YAHOO.ext.util.Observable.prototype.purgeListeners,
    bufferedListener : YAHOO.ext.util.Observable.prototype.bufferedListener,
    
    getEl : function(){
        return this.el;
    },
    
    
    update : function(url, params, callback, discardUrl){
        if(this.beforeUpdate.fireDirect(this.el, url, params) !== false){
            if(typeof url == 'object'){ 
                var cfg = url;
                url = cfg.url;
                params = params || cfg.params;
                callback = callback || cfg.callback;
                discardUrl = discardUrl || cfg.discardUrl;
                if(callback && cfg.scope){
                    callback = callback.createDelegate(cfg.scope);
                }
                if(typeof cfg.nocache != 'undefined'){this.disableCaching = cfg.nocache};
                if(typeof cfg.text != 'undefined'){this.indicatorText = '<div class="loading-indicator">'+cfg.text+'</div>'};
                if(typeof cfg.scripts != 'undefined'){this.loadScripts = cfg.scripts};
                if(typeof cfg.timeout != 'undefined'){this.timeout = cfg.timeout};
            }
            this.showLoading();
            if(!discardUrl){
                this.defaultUrl = url;
            }
            if(typeof url == 'function'){
                url = url();
            }
            if(typeof params == 'function'){
                params = params();
            }
            if(params && typeof params != 'string'){ 
                var buf = [];
                for(var key in params){
                    if(typeof params[key] != 'function'){
                        buf.push(encodeURIComponent(key), '=', encodeURIComponent(params[key]), '&');
                    }
                }
                delete buf[buf.length-1];
                params = buf.join('');
            }
            var callback = {
                success: this.successDelegate,
                failure: this.failureDelegate,
                timeout: (this.timeout*1000),
                argument: {'url': url, 'form': null, 'callback': callback, 'params': params}
            };
            var method = params ? 'POST' : 'GET';
            if(method == 'GET'){
                url = this.prepareUrl(url);
            }
            this.transaction = YAHOO.util.Connect.asyncRequest(method, url, callback, params);
        }
    },
    
    
    formUpdate : function(form, url, reset, callback){
        if(this.beforeUpdate.fireDirect(this.el, form, url) !== false){
            this.showLoading();
            formEl = YAHOO.util.Dom.get(form);
            if(typeof url == 'function'){
                url = url();
            }
            if(typeof params == 'function'){
                params = params();
            }
            url = url || formEl.action;
            var callback = {
                success: this.successDelegate,
                failure: this.failureDelegate,
                timeout: (this.timeout*1000),
                argument: {'url': url, 'form': form, 'callback': callback, 'reset': reset}
            };
            var isUpload = false;
            var enctype = formEl.getAttribute('enctype');
            if(enctype && enctype.toLowerCase() == 'multipart/form-data'){
                isUpload = true;
            }
            YAHOO.util.Connect.setForm(form, isUpload, this.sslBlankUrl);
            this.transaction = YAHOO.util.Connect.asyncRequest('POST', url, callback);
        }
    },
    
    
    refresh : function(callback){
        if(this.defaultUrl == null){
            return;
        }
        this.update(this.defaultUrl, null, callback, true);
    },
    
    
    startAutoRefresh : function(interval, url, params, callback, refreshNow){
        if(refreshNow){
            this.update(url || this.defaultUrl, params, callback, true);
        }
        if(this.autoRefreshProcId){
            clearInterval(this.autoRefreshProcId);
        }
        this.autoRefreshProcId = setInterval(this.update.createDelegate(this, [url || this.defaultUrl, params, callback, true]), interval*1000);
    },
    
    
     stopAutoRefresh : function(){
        if(this.autoRefreshProcId){
            clearInterval(this.autoRefreshProcId);
        }
    },
    
    
    showLoading : function(){
        if(this.showLoadIndicator){
            this.el.update(this.indicatorText);
        }
    },
    
    
    prepareUrl : function(url){
        if(this.disableCaching){
            var append = '_dc=' + (new Date().getTime());
            if(url.indexOf('?') !== -1){
                url += '&' + append;
            }else{
                url += '?' + append;
            }
        }
        return url;
    },
    
    
    processSuccess : function(response){
        this.transaction = null;
        if(response.argument.form && response.argument.reset){
            try{ 
                response.argument.form.reset();
            }catch(e){}
        }
        if(this.loadScripts){
            this.renderer.render(this.el, response, this, 
                this.updateComplete.createDelegate(this, [response]));
        }else{
            this.renderer.render(this.el, response, this);
            this.updateComplete(response);
        }
    },
    
    updateComplete : function(response){
        this.fireEvent('update', this.el, response);
        if(typeof response.argument.callback == 'function'){
            response.argument.callback(this.el, true);
        }
    },
    
    
    processFailure : function(response){
        this.transaction = null;
        this.onFailure.fireDirect(this.el, response);
        if(typeof response.argument.callback == 'function'){
            response.argument.callback(this.el, false);
        }
    },
    
    
    setRenderer : function(renderer){
        this.renderer = renderer;
    },
    
    getRenderer : function(){
       return this.renderer;  
    },
    
    
    setDefaultUrl : function(defaultUrl){
        this.defaultUrl = defaultUrl;
    },
    
    
    abort : function(){
        if(this.transaction){
            YAHOO.util.Connect.abort(this.transaction);
        }
    },
    
    
    isUpdating : function(){
        if(this.transaction){
            return YAHOO.util.Connect.isCallInProgress(this.transaction);
        }
        return false;
    }
};


   YAHOO.ext.UpdateManager.defaults = {
       
         timeout : 30,
         
         
        loadScripts : false,
         
        
        sslBlankUrl : (YAHOO.ext.SSL_SECURE_URL || 'javascript:false'),
        
        disableCaching : false,
        
        showLoadIndicator : true,
        
        indicatorText : '<div class="loading-indicator">Loading...</div>'
   };


YAHOO.ext.UpdateManager.updateElement = function(el, url, params, options){
    var um = getEl(el, true).getUpdateManager();
    YAHOO.ext.util.Config.apply(um, options);
    um.update(url, params, options.callback);
}

YAHOO.ext.UpdateManager.update = YAHOO.ext.UpdateManager.updateElement;
 
YAHOO.ext.UpdateManager.BasicRenderer = function(){};

YAHOO.ext.UpdateManager.BasicRenderer.prototype = {
    
     render : function(el, response, updateManager, callback){
        el.update(response.responseText, updateManager.loadScripts, callback);
    }
};



Date.parseFunctions = {count:0};

Date.parseRegexes = [];

Date.formatFunctions = {count:0};


Date.prototype.dateFormat = function(format) {
    if (Date.formatFunctions[format] == null) {
        Date.createNewFormat(format);
    }
    var func = Date.formatFunctions[format];
    return this[func]();
};


Date.prototype.format = Date.prototype.dateFormat;


Date.createNewFormat = function(format) {
    var funcName = "format" + Date.formatFunctions.count++;
    Date.formatFunctions[format] = funcName;
    var code = "Date.prototype." + funcName + " = function(){return ";
    var special = false;
    var ch = '';
    for (var i = 0; i < format.length; ++i) {
        ch = format.charAt(i);
        if (!special && ch == "\\") {
            special = true;
        }
        else if (special) {
            special = false;
            code += "'" + String.escape(ch) + "' + ";
        }
        else {
            code += Date.getFormatCode(ch);
        }
    }
    eval(code.substring(0, code.length - 3) + ";}");
};


Date.getFormatCode = function(character) {
    switch (character) {
    case "d":
        return "String.leftPad(this.getDate(), 2, '0') + ";
    case "D":
        return "Date.dayNames[this.getDay()].substring(0, 3) + ";
    case "j":
        return "this.getDate() + ";
    case "l":
        return "Date.dayNames[this.getDay()] + ";
    case "S":
        return "this.getSuffix() + ";
    case "w":
        return "this.getDay() + ";
    case "z":
        return "this.getDayOfYear() + ";
    case "W":
        return "this.getWeekOfYear() + ";
    case "F":
        return "Date.monthNames[this.getMonth()] + ";
    case "m":
        return "String.leftPad(this.getMonth() + 1, 2, '0') + ";
    case "M":
        return "Date.monthNames[this.getMonth()].substring(0, 3) + ";
    case "n":
        return "(this.getMonth() + 1) + ";
    case "t":
        return "this.getDaysInMonth() + ";
    case "L":
        return "(this.isLeapYear() ? 1 : 0) + ";
    case "Y":
        return "this.getFullYear() + ";
    case "y":
        return "('' + this.getFullYear()).substring(2, 4) + ";
    case "a":
        return "(this.getHours() < 12 ? 'am' : 'pm') + ";
    case "A":
        return "(this.getHours() < 12 ? 'AM' : 'PM') + ";
    case "g":
        return "((this.getHours() %12) ? this.getHours() % 12 : 12) + ";
    case "G":
        return "this.getHours() + ";
    case "h":
        return "String.leftPad((this.getHours() %12) ? this.getHours() % 12 : 12, 2, '0') + ";
    case "H":
        return "String.leftPad(this.getHours(), 2, '0') + ";
    case "i":
        return "String.leftPad(this.getMinutes(), 2, '0') + ";
    case "s":
        return "String.leftPad(this.getSeconds(), 2, '0') + ";
    case "O":
        return "this.getGMTOffset() + ";
    case "T":
        return "this.getTimezone() + ";
    case "Z":
        return "(this.getTimezoneOffset() * -60) + ";
    default:
        return "'" + String.escape(character) + "' + ";
    };
};


Date.parseDate = function(input, format) {
    if (Date.parseFunctions[format] == null) {
        Date.createParser(format);
    }
    var func = Date.parseFunctions[format];
    return Date[func](input);
};


Date.createParser = function(format) {
    var funcName = "parse" + Date.parseFunctions.count++;
    var regexNum = Date.parseRegexes.length;
    var currentGroup = 1;
    Date.parseFunctions[format] = funcName;

    var code = "Date." + funcName + " = function(input){\n"
        + "var y = -1, m = -1, d = -1, h = -1, i = -1, s = -1;\n"
        + "var d = new Date();\n"
        + "y = d.getFullYear();\n"
        + "m = d.getMonth();\n"
        + "d = d.getDate();\n"
        + "var results = input.match(Date.parseRegexes[" + regexNum + "]);\n"
        + "if (results && results.length > 0) {"
    var regex = "";

    var special = false;
    var ch = '';
    for (var i = 0; i < format.length; ++i) {
        ch = format.charAt(i);
        if (!special && ch == "\\") {
            special = true;
        }
        else if (special) {
            special = false;
            regex += String.escape(ch);
        }
        else {
            obj = Date.formatCodeToRegex(ch, currentGroup);
            currentGroup += obj.g;
            regex += obj.s;
            if (obj.g && obj.c) {
                code += obj.c;
            }
        }
    }

    code += "if (y > 0 && m >= 0 && d > 0 && h >= 0 && i >= 0 && s >= 0)\n"
        + "{return new Date(y, m, d, h, i, s);}\n"
        + "else if (y > 0 && m >= 0 && d > 0 && h >= 0 && i >= 0)\n"
        + "{return new Date(y, m, d, h, i);}\n"
        + "else if (y > 0 && m >= 0 && d > 0 && h >= 0)\n"
        + "{return new Date(y, m, d, h);}\n"
        + "else if (y > 0 && m >= 0 && d > 0)\n"
        + "{return new Date(y, m, d);}\n"
        + "else if (y > 0 && m >= 0)\n"
        + "{return new Date(y, m);}\n"
        + "else if (y > 0)\n"
        + "{return new Date(y);}\n"
        + "}return null;}";

    Date.parseRegexes[regexNum] = new RegExp("^" + regex + "$");
    eval(code);
};


Date.formatCodeToRegex = function(character, currentGroup) {
    switch (character) {
    case "D":
        return {g:0,
        c:null,
        s:"(?:Sun|Mon|Tue|Wed|Thu|Fri|Sat)"};
    case "j":
    case "d":
        return {g:1,
            c:"d = parseInt(results[" + currentGroup + "], 10);\n",
            s:"(\\d{1,2})"};
    case "l":
        return {g:0,
            c:null,
            s:"(?:" + Date.dayNames.join("|") + ")"};
    case "S":
        return {g:0,
            c:null,
            s:"(?:st|nd|rd|th)"};
    case "w":
        return {g:0,
            c:null,
            s:"\\d"};
    case "z":
        return {g:0,
            c:null,
            s:"(?:\\d{1,3})"};
    case "W":
        return {g:0,
            c:null,
            s:"(?:\\d{2})"};
    case "F":
        return {g:1,
            c:"m = parseInt(Date.monthNumbers[results[" + currentGroup + "].substring(0, 3)], 10);\n",
            s:"(" + Date.monthNames.join("|") + ")"};
    case "M":
        return {g:1,
            c:"m = parseInt(Date.monthNumbers[results[" + currentGroup + "]], 10);\n",
            s:"(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)"};
    case "n":
    case "m":
        return {g:1,
            c:"m = parseInt(results[" + currentGroup + "], 10) - 1;\n",
            s:"(\\d{1,2})"};
    case "t":
        return {g:0,
            c:null,
            s:"\\d{1,2}"};
    case "L":
        return {g:0,
            c:null,
            s:"(?:1|0)"};
    case "Y":
        return {g:1,
            c:"y = parseInt(results[" + currentGroup + "], 10);\n",
            s:"(\\d{4})"};
    case "y":
        return {g:1,
            c:"var ty = parseInt(results[" + currentGroup + "], 10);\n"
                + "y = ty > Date.y2kYear ? 1900 + ty : 2000 + ty;\n",
            s:"(\\d{1,2})"};
    case "a":
        return {g:1,
            c:"if (results[" + currentGroup + "] == 'am') {\n"
                + "if (h == 12) { h = 0; }\n"
                + "} else { if (h < 12) { h += 12; }}",
            s:"(am|pm)"};
    case "A":
        return {g:1,
            c:"if (results[" + currentGroup + "] == 'AM') {\n"
                + "if (h == 12) { h = 0; }\n"
                + "} else { if (h < 12) { h += 12; }}",
            s:"(AM|PM)"};
    case "g":
    case "G":
    case "h":
    case "H":
        return {g:1,
            c:"h = parseInt(results[" + currentGroup + "], 10);\n",
            s:"(\\d{1,2})"};
    case "i":
        return {g:1,
            c:"i = parseInt(results[" + currentGroup + "], 10);\n",
            s:"(\\d{2})"};
    case "s":
        return {g:1,
            c:"s = parseInt(results[" + currentGroup + "], 10);\n",
            s:"(\\d{2})"};
    case "O":
        return {g:0,
            c:null,
            s:"[+-]\\d{4}"};
    case "T":
        return {g:0,
            c:null,
            s:"[A-Z]{3}"};
    case "Z":
        return {g:0,
            c:null,
            s:"[+-]\\d{1,5}"};
    default:
        return {g:0,
            c:null,
            s:String.escape(character)};
    }
};

Date.prototype.getTimezone = function() {
    return this.toString().replace(
        /^.*? ([A-Z]{3}) [0-9]{4}.*$/, "$1").replace(
        /^.*?\(([A-Z])[a-z]+ ([A-Z])[a-z]+ ([A-Z])[a-z]+\)$/, "$1$2$3");
};

Date.prototype.getGMTOffset = function() {
    return (this.getTimezoneOffset() > 0 ? "-" : "+")
        + String.leftPad(Math.floor(this.getTimezoneOffset() / 60), 2, "0")
        + String.leftPad(this.getTimezoneOffset() % 60, 2, "0");
};

Date.prototype.getDayOfYear = function() {
    var num = 0;
    Date.daysInMonth[1] = this.isLeapYear() ? 29 : 28;
    for (var i = 0; i < this.getMonth(); ++i) {
        num += Date.daysInMonth[i];
    }
    return num + this.getDate() - 1;
};

Date.prototype.getWeekOfYear = function() {
    
    var now = this.getDayOfYear() + (4 - this.getDay());
    
    var jan1 = new Date(this.getFullYear(), 0, 1);
    var then = (7 - jan1.getDay() + 4);
    return String.leftPad(((now - then) / 7) + 1, 2, "0");
};

Date.prototype.isLeapYear = function() {
    var year = this.getFullYear();
    return ((year & 3) == 0 && (year % 100 || (year % 400 == 0 && year)));
};

Date.prototype.getFirstDayOfMonth = function() {
    var day = (this.getDay() - (this.getDate() - 1)) % 7;
    return (day < 0) ? (day + 7) : day;
};

Date.prototype.getLastDayOfMonth = function() {
    var day = (this.getDay() + (Date.daysInMonth[this.getMonth()] - this.getDate())) % 7;
    return (day < 0) ? (day + 7) : day;
};

Date.prototype.getDaysInMonth = function() {
    Date.daysInMonth[1] = this.isLeapYear() ? 29 : 28;
    return Date.daysInMonth[this.getMonth()];
};


Date.prototype.getSuffix = function() {
    switch (this.getDate()) {
        case 1:
        case 21:
        case 31:
            return "st";
        case 2:
        case 22:
            return "nd";
        case 3:
        case 23:
            return "rd";
        default:
            return "th";
    }
};


Date.daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];


Date.monthNames =
   ["January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"];
    

Date.dayNames =
   ["Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday"];


Date.y2kYear = 50;


Date.monthNumbers = {
    Jan:0,
    Feb:1,
    Mar:2,
    Apr:3,
    May:4,
    Jun:5,
    Jul:6,
    Aug:7,
    Sep:8,
    Oct:9,
    Nov:10,
    Dec:11};

YAHOO.ext.TabPanel = function(container, config){
    
    this.el = getEl(container, true);
    
    this.tabPosition = 'top';
    this.currentTabWidth = 0;
    
    this.minTabWidth = 40;
    
    this.maxTabWidth = 250;
    
    this.preferredTabWidth = 175;
    
    this.resizeTabs = false;
    
    this.monitorResize = true;
    
    if(config){
        if(typeof config == 'boolean'){
            this.tabPosition = config ? 'bottom' : 'top';
        }else{
            YAHOO.ext.util.Config.apply(this, config);
        }
    }
    if(this.tabPosition == 'bottom'){
        this.bodyEl = getEl(this.createBody(this.el.dom));
        this.el.addClass('ytabs-bottom');
    }
    this.stripWrap = getEl(this.createStrip(this.el.dom), true);
    this.stripEl = getEl(this.createStripList(this.stripWrap.dom), true);
    this.stripBody = getEl(this.stripWrap.dom.firstChild.firstChild, true);
    if(YAHOO.ext.util.Browser.isIE){
        YAHOO.util.Dom.setStyle(this.stripWrap.dom.firstChild, 'overflow-x', 'hidden');
    }
    if(this.tabPosition != 'bottom'){
    
      this.bodyEl = getEl(this.createBody(this.el.dom));
      this.el.addClass('ytabs-top');
    }
    this.items = [];
    
    this.bodyEl.setStyle('position', 'relative');
    
    
    if(!this.items.indexOf){
        this.items.indexOf = function(o){
            for(var i = 0, len = this.length; i < len; i++){
                if(this[i] == o) return i;
            }
            return -1;
        }
    }
    this.active = null;
    this.onTabChange = new YAHOO.util.CustomEvent('TabItem.onTabChange');
    this.activateDelegate = this.activate.createDelegate(this);
    
    this.events = {
        
        'tabchange': this.onTabChange,
        
        'beforetabchange' : new YAHOO.util.CustomEvent('beforechange')
    };
    
    YAHOO.ext.EventManager.onWindowResize(this.onResize, this, true);
    this.cpad = this.el.getPadding('lr');
    this.hiddenCount = 0;
}

YAHOO.ext.TabPanel.prototype = {
    fireEvent : YAHOO.ext.util.Observable.prototype.fireEvent,
    on : YAHOO.ext.util.Observable.prototype.on,
    addListener : YAHOO.ext.util.Observable.prototype.addListener,
    delayedListener : YAHOO.ext.util.Observable.prototype.delayedListener,
    removeListener : YAHOO.ext.util.Observable.prototype.removeListener,
    purgeListeners : YAHOO.ext.util.Observable.prototype.purgeListeners,
    
    addTab : function(id, text, content, closable){
        var item = new YAHOO.ext.TabPanelItem(this, id, text, closable);
        this.addTabItem(item);
        if(content){
            item.setContent(content);
        }
        return item;
    },
    
    
    getTab : function(id){
        return this.items[id];
    },
    
    
    hideTab : function(id){
        var t = this.items[id];
        if(!t.isHidden()){
           t.setHidden(true);
           this.hiddenCount++;
           this.autoSizeTabs();
        }
    },
    
    
    unhideTab : function(id){
        var t = this.items[id];
        if(t.isHidden()){
           t.setHidden(false);
           this.hiddenCount--;
           this.autoSizeTabs();
        }
    },
    
    
    addTabItem : function(item){
        this.items[item.id] = item;
        this.items.push(item);
        if(this.resizeTabs){
           item.setWidth(this.currentTabWidth || this.preferredTabWidth)
           this.autoSizeTabs();
        }else{
            item.autoSize();
        }
    },
        
    
    removeTab : function(id){
        var items = this.items;
        var tab = items[id];
        if(!tab) return;
        var index = items.indexOf(tab);
        if(this.active == tab && items.length > 1){
            var newTab = this.getNextAvailable(index);
            if(newTab)newTab.activate();
        }
        this.stripEl.dom.removeChild(tab.pnode.dom);
        if(tab.bodyEl.dom.parentNode == this.bodyEl.dom){ 
            this.bodyEl.dom.removeChild(tab.bodyEl.dom);
        }
        items.splice(index, 1);
        delete this.items[tab.id];
        tab.fireEvent('close', tab);
        tab.purgeListeners();
        this.autoSizeTabs();
    },
    
    getNextAvailable : function(start){
        var items = this.items;
        var index = start;
        
        
        while(index < items.length){
            var item = items[++index];
            if(item && !item.isHidden()){
                return item;
            }
        }
        
        var index = start;
        while(index >= 0){
            var item = items[--index];
            if(item && !item.isHidden()){
                return item;
            }
        }
        return null;
    },
    
    
    disableTab : function(id){
        var tab = this.items[id];
        if(tab && this.active != tab){
            tab.disable();
        }
    },
    
    
    enableTab : function(id){
        var tab = this.items[id];
        tab.enable();
    },
    
    
    activate : function(id){
        var tab = this.items[id];
        if(tab == this.active){
            return tab;
        } 
        var e = {};
        this.fireEvent('beforetabchange', this, e, tab);
        if(e.cancel !== true && !tab.disabled){
            if(this.active){
                this.active.hide();
            }
            this.active = this.items[id];
            this.active.show();
            this.onTabChange.fireDirect(this, this.active);
        }
        return tab;
    },
    
    
    getActiveTab : function(){
        return this.active;
    },
    
    
    syncHeight : function(targetHeight){
        var height = (targetHeight || this.el.getHeight())-this.el.getBorderWidth('tb')-this.el.getPadding('tb');
        var bm = this.bodyEl.getMargins();
        var newHeight = height-(this.stripWrap.getHeight()||0)-(bm.top+bm.bottom);
        this.bodyEl.setHeight(newHeight);
        return newHeight; 
    },
    
    onResize : function(){
        if(this.monitorResize){
            this.autoSizeTabs();
        }
    },

    
    beginUpdate : function(){
        this.updating = true;    
    },
    
    
    endUpdate : function(){
        this.updating = false;
        this.autoSizeTabs();  
    },
    
    
    autoSizeTabs : function(){
        var count = this.items.length;
        var vcount = count - this.hiddenCount;
        if(!this.resizeTabs || count < 1 || vcount < 1 || this.updating) return;
        var w = Math.max(this.el.getWidth() - this.cpad, 10);
        var availWidth = Math.floor(w / vcount);
        var b = this.stripBody;
        if(b.getWidth() > w){
            var tabs = this.items;
            this.setTabWidth(Math.max(availWidth, this.minTabWidth));
            if(availWidth < this.minTabWidth){
                
            }
        }else{
            if(this.currentTabWidth < this.preferredTabWidth){
                this.setTabWidth(Math.min(availWidth, this.preferredTabWidth));
            }
        }
    },
    
    
     getCount : function(){
         return this.items.length;  
     },
    
    
    setTabWidth : function(width){
        this.currentTabWidth = width;
        for(var i = 0, len = this.items.length; i < len; i++) {
        	if(!this.items[i].isHidden())this.items[i].setWidth(width);
        }
    },
    
    
    destroy : function(removeEl){
        YAHOO.ext.EventManager.removeResizeListener(this.onResize, this);
        for(var i = 0, len = this.items.length; i < len; i++){
            this.items[i].purgeListeners();
        }
        if(removeEl === true){
            this.el.update('');
            this.el.remove();
        }
    }
};

 
YAHOO.ext.TabPanelItem = function(tabPanel, id, text, closable){
    
    this.tabPanel = tabPanel;
    
    this.id = id;
    
    this.disabled = false;
    
    this.text = text;
    
    this.loaded = false;
    this.closable = closable;
    
    
    this.bodyEl = getEl(tabPanel.createItemBody(tabPanel.bodyEl.dom, id));
    this.bodyEl.setVisibilityMode(YAHOO.ext.Element.VISIBILITY);
    this.bodyEl.setStyle('display', 'block');
    this.bodyEl.setStyle('zoom', '1');
    this.hideAction();
    
    var els = tabPanel.createStripElements(tabPanel.stripEl.dom, text, closable);
    
    this.el = getEl(els.el, true);
    this.inner = getEl(els.inner, true);
    this.textEl = getEl(this.el.dom.firstChild.firstChild.firstChild, true);
    this.pnode = getEl(els.el.parentNode, true);
    this.el.mon('click', this.onTabClick, this, true);
    
    if(closable){
        var c = getEl(els.close, true);
        c.dom.title = this.closeText;
        c.addClassOnOver('close-over');
        c.mon('click', this.closeClick, this, true);
     }
    
    
    this.onActivate = new YAHOO.util.CustomEvent('TabItem.onActivate');
    this.onDeactivate = new YAHOO.util.CustomEvent('TabItem.onDeactivate');
    
    this.events = {
         
        'activate': this.onActivate,
        
        'beforeclose': new YAHOO.util.CustomEvent('beforeclose'),
        
         'close': new YAHOO.util.CustomEvent('close'),
        
         'deactivate' : this.onDeactivate  
    };
    this.hidden = false;
};

YAHOO.ext.TabPanelItem.prototype = {
    fireEvent : YAHOO.ext.util.Observable.prototype.fireEvent,
    on : YAHOO.ext.util.Observable.prototype.on,
    addListener : YAHOO.ext.util.Observable.prototype.addListener,
    delayedListener : YAHOO.ext.util.Observable.prototype.delayedListener,
    removeListener : YAHOO.ext.util.Observable.prototype.removeListener,
    purgeListeners : function(){
       YAHOO.ext.util.Observable.prototype.purgeListeners.call(this);
       this.el.removeAllListeners(); 
    },
    
    show : function(){
        this.pnode.addClass('on');
        this.showAction();
        if(YAHOO.ext.util.Browser.isOpera){
            this.tabPanel.stripWrap.repaint();
        }
        this.onActivate.fireDirect(this.tabPanel, this); 
    },
    
    
    isActive : function(){
        return this.tabPanel.getActiveTab() == this;  
    },
    
    
    hide : function(){
        this.pnode.removeClass('on');
        this.hideAction();
        this.onDeactivate.fireDirect(this.tabPanel, this); 
    },
    
    hideAction : function(){
        this.bodyEl.setStyle('position', 'absolute');
        this.bodyEl.setLeft('-20000px');
        this.bodyEl.setTop('-20000px');
        this.bodyEl.hide();
    },
    
    showAction : function(){
        this.bodyEl.setStyle('position', 'relative');
        this.bodyEl.setTop('');
        this.bodyEl.setLeft('');
        this.bodyEl.show();
        this.tabPanel.el.repaint.defer(1);
    },
    
    
    setTooltip : function(text){
        this.textEl.dom.title = text;
    },
    
    onTabClick : function(e){
        e.preventDefault();
        this.tabPanel.activate(this.id);
    },
    
    getWidth : function(){
        return this.inner.getWidth();  
    },
    
    setWidth : function(width){
        var iwidth = width - this.pnode.getPadding("lr");
        this.inner.setWidth(iwidth);
        this.textEl.setWidth(iwidth-this.inner.getPadding('lr'));
        this.pnode.setWidth(width);
    },
    
    setHidden : function(hidden){
        this.hidden = hidden;
        this.pnode.setStyle('display', hidden ? 'none' : '');  
    },
    
    
    isHidden : function(){
        return this.hidden;  
    },
    
    
    getText : function(){
        return this.text;
    },
    
    autoSize : function(){
        this.el.beginMeasure();
        this.textEl.setWidth(1);
        this.setWidth(this.textEl.dom.scrollWidth+this.pnode.getPadding("lr")+this.inner.getPadding('lr'));
        this.el.endMeasure();
    },
    
    
    setText : function(text){
        this.text = text;
        this.textEl.update(text);
        this.textEl.dom.title = text;
        if(!this.tabPanel.resizeTabs){
            this.autoSize();
        }
    },
    
    activate : function(){
        this.tabPanel.activate(this.id);
    },
    
    
    disable : function(){
        if(this.tabPanel.active != this){
            this.disabled = true;
            this.pnode.addClass('disabled');
        }
    },
    
    
    enable : function(){
        this.disabled = false;
        this.pnode.removeClass('disabled');
    },
    
    
    setContent : function(content, loadScripts){
        this.bodyEl.update(content, loadScripts);
    },
    
    
    getUpdateManager : function(){
        return this.bodyEl.getUpdateManager();
    },
    
    
    setUrl : function(url, params, loadOnce){
        if(this.refreshDelegate){
            this.onActivate.unsubscribe(this.refreshDelegate);
        }
        this.refreshDelegate = this._handleRefresh.createDelegate(this, [url, params, loadOnce]);
        this.onActivate.subscribe(this.refreshDelegate);
        return this.bodyEl.getUpdateManager();
    },
    
    
    _handleRefresh : function(url, params, loadOnce){
        if(!loadOnce || !this.loaded){
            var updater = this.bodyEl.getUpdateManager();
            updater.update(url, params, this._setLoaded.createDelegate(this));
        }
    },
    
    
    refresh : function(){
        if(this.refreshDelegate){
           this.loaded = false;
           this.refreshDelegate();
        }
    }, 
    
    
    _setLoaded : function(){
        this.loaded = true;
    },
    
    
    closeClick : function(e){
        var e = {};
        this.fireEvent('beforeclose', this, e);
        if(e.cancel !== true){
            this.tabPanel.removeTab(this.id);
        }
    },
    
    closeText : 'Close this tab'
};


YAHOO.ext.TabPanel.prototype.createStrip = function(container){
    var strip = document.createElement('div');
    strip.className = 'ytab-wrap';
    container.appendChild(strip);
    return strip;
};

YAHOO.ext.TabPanel.prototype.createStripList = function(strip){
    
    strip.innerHTML = '<div class="ytab-strip-wrap"><table class="ytab-strip" cellspacing="0" cellpadding="0" border="0"><tbody><tr></tr></tbody></table></div>';
    return strip.firstChild.firstChild.firstChild.firstChild;
};

YAHOO.ext.TabPanel.prototype.createBody = function(container){
    var body = document.createElement('div');
    YAHOO.util.Dom.generateId(body, 'tab-body');
    YAHOO.util.Dom.addClass(body, 'yui-ext-tabbody');
    container.appendChild(body);
    return body;
};

YAHOO.ext.TabPanel.prototype.createItemBody = function(bodyEl, id){
    var body = YAHOO.util.Dom.get(id);
    if(!body){
        body = document.createElement('div');
        body.id = id;
    }
    YAHOO.util.Dom.addClass(body, 'yui-ext-tabitembody');
    bodyEl.insertBefore(body, bodyEl.firstChild);
    return body;
};

YAHOO.ext.TabPanel.prototype.createStripElements = function(stripEl, text, closable){
    var td = document.createElement('td');
    stripEl.appendChild(td);
    if(closable){
        td.className = "ytab-closable";
        if(!this.closeTpl){
            this.closeTpl = new YAHOO.ext.Template(
               '<a href="#" class="ytab-right"><span class="ytab-left"><em class="ytab-inner">' +
               '<span unselectable="on" title="{text}" class="ytab-text">{text}</span>' +
               '<div unselectable="on" class="close-icon">&#160;</div></em></span></a>'
            );
        }
        var el = this.closeTpl.overwrite(td, {'text': text});
        var close = el.getElementsByTagName('div')[0];
        var inner = el.getElementsByTagName('em')[0];
        return {'el': el, 'close': close, 'inner': inner};
    } else {
        if(!this.tabTpl){
            this.tabTpl = new YAHOO.ext.Template(
               '<a href="#" class="ytab-right"><span class="ytab-left"><em class="ytab-inner">' +
               '<span unselectable="on" title="{text}" class="ytab-text">{text}</span></em></span></a>'
            );
        }
        var el = this.tabTpl.overwrite(td, {'text': text});
        var inner = el.getElementsByTagName('em')[0];
        return {'el': el, 'inner': inner};
    }
};


YAHOO.ext.Actor = function(element, animator, selfCapture){
    this.el = YAHOO.ext.Element.get(element, true); 
    YAHOO.ext.Actor.superclass.constructor.call(this, element, true);
    this.onCapture = new YAHOO.util.CustomEvent('Actor.onCapture');
    if(animator){
        
        animator.addActor(this);
    }
    
    this.capturing = selfCapture;
    this.playlist = selfCapture ? new YAHOO.ext.Animator.AnimSequence() : null;
};

YAHOO.extendX(YAHOO.ext.Actor, YAHOO.ext.Element);


YAHOO.ext.Actor.prototype.capture = function(action){
    if(this.playlist != null){
        this.playlist.add(action);
    }
    this.onCapture.fireDirect(this, action);
    return action;
};


YAHOO.ext.Actor.overrideAnimation = function(method, animParam, onParam){
    return function(){
        if(!this.capturing){
            return method.apply(this, arguments);
        }
        var args = Array.prototype.slice.call(arguments, 0);
        if(args[animParam] === true){
            return this.capture(new YAHOO.ext.Actor.AsyncAction(this, method, args, onParam));
        }else{
            return this.capture(new YAHOO.ext.Actor.Action(this, method, args));
        }
    };
}


YAHOO.ext.Actor.overrideBasic = function(method){
    return function(){
        if(!this.capturing){
            return method.apply(this, arguments);
        }
        var args = Array.prototype.slice.call(arguments, 0);
        return this.capture(new YAHOO.ext.Actor.Action(this, method, args));
    };
}



YAHOO.ext.Actor.prototype.setVisibilityMode = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.setVisibilityMode);

YAHOO.ext.Actor.prototype.enableDisplayMode = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.enableDisplayMode);

YAHOO.ext.Actor.prototype.focus = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.focus);

YAHOO.ext.Actor.prototype.addClass = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.addClass);

YAHOO.ext.Actor.prototype.removeClass = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.removeClass);

YAHOO.ext.Actor.prototype.replaceClass = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.replaceClass);

YAHOO.ext.Actor.prototype.setStyle = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.setStyle);

YAHOO.ext.Actor.prototype.setLeft = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.setLeft);

YAHOO.ext.Actor.prototype.setTop = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.setTop);

YAHOO.ext.Actor.prototype.setAbsolutePositioned = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.setAbsolutePositioned);

YAHOO.ext.Actor.prototype.setRelativePositioned = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.setRelativePositioned);

YAHOO.ext.Actor.prototype.clearPositioning = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.clearPositioning);

YAHOO.ext.Actor.prototype.setPositioning = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.setPositioning);

YAHOO.ext.Actor.prototype.clip = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.clip);

YAHOO.ext.Actor.prototype.unclip = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.unclip);

YAHOO.ext.Actor.prototype.clearOpacity = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.clearOpacity);

YAHOO.ext.Actor.prototype.update = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.update);

YAHOO.ext.Actor.prototype.remove = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.remove);
YAHOO.ext.Actor.prototype.fitToParent = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.fitToParent);
YAHOO.ext.Actor.prototype.appendChild = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.appendChild);
YAHOO.ext.Actor.prototype.createChild = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.createChild);
YAHOO.ext.Actor.prototype.appendTo = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.appendTo);
YAHOO.ext.Actor.prototype.insertBefore = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.insertBefore);
YAHOO.ext.Actor.prototype.insertAfter = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.insertAfter);
YAHOO.ext.Actor.prototype.wrap = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.wrap);
YAHOO.ext.Actor.prototype.replace = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.replace);
YAHOO.ext.Actor.prototype.insertHtml = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.insertHtml);
YAHOO.ext.Actor.prototype.set = YAHOO.ext.Actor.overrideBasic(YAHOO.ext.Actor.superclass.set);


YAHOO.ext.Actor.prototype.load = function(){
   if(!this.capturing){
        return YAHOO.ext.Actor.superclass.load.apply(this, arguments);
   }
   var args = Array.prototype.slice.call(arguments, 0);
   return this.capture(new YAHOO.ext.Actor.AsyncAction(this, YAHOO.ext.Actor.superclass.load, 
        args, 2));
};


YAHOO.ext.Actor.prototype.animate = function(args, duration, onComplete, easing, animType){
    if(!this.capturing){
        return YAHOO.ext.Actor.superclass.animate.apply(this, arguments);
    }
    return this.capture(new YAHOO.ext.Actor.AsyncAction(this, YAHOO.ext.Actor.superclass.animate, 
        [args, duration, onComplete, easing, animType], 2));
};


YAHOO.ext.Actor.prototype.setVisible = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.setVisible, 1, 3);

YAHOO.ext.Actor.prototype.toggle = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.toggle, 0, 2);

YAHOO.ext.Actor.prototype.setXY = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.setXY, 1, 3);

YAHOO.ext.Actor.prototype.setLocation = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.setLocation, 2, 4);

YAHOO.ext.Actor.prototype.setWidth = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.setWidth, 1, 3);

YAHOO.ext.Actor.prototype.setHeight = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.setHeight, 1, 3);

YAHOO.ext.Actor.prototype.setSize = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.setSize, 2, 4);

YAHOO.ext.Actor.prototype.setBounds = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.setBounds, 4, 6);

YAHOO.ext.Actor.prototype.setOpacity = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.setOpacity, 1, 3);

YAHOO.ext.Actor.prototype.moveTo = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.moveTo, 2, 4);

YAHOO.ext.Actor.prototype.move = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.move, 2, 4);

YAHOO.ext.Actor.prototype.alignTo = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.alignTo, 3, 5);

YAHOO.ext.Actor.prototype.hide = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.hide, 0, 2);

YAHOO.ext.Actor.prototype.show = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.show, 0, 2);


YAHOO.ext.Actor.prototype.setBox = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.setBox, 2, 4);


YAHOO.ext.Actor.prototype.autoHeight = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.autoHeight, 0, 2);

YAHOO.ext.Actor.prototype.setX = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.setX, 1, 3);

YAHOO.ext.Actor.prototype.setY = YAHOO.ext.Actor.overrideAnimation(YAHOO.ext.Actor.superclass.setY, 1, 3);


YAHOO.ext.Actor.prototype.startCapture = function(){
    this.capturing = true;
    this.playlist = new YAHOO.ext.Animator.AnimSequence();
 };
 
 
 YAHOO.ext.Actor.prototype.stopCapture = function(){
     this.capturing = false;
 };


YAHOO.ext.Actor.prototype.clear = function(){
    this.playlist = new YAHOO.ext.Animator.AnimSequence();
};


YAHOO.ext.Actor.prototype.play = function(oncomplete){
    this.capturing = false;
    if(this.playlist){
        this.playlist.play(oncomplete);
    }
 };


YAHOO.ext.Actor.prototype.addCall = function(fcn, args, scope){
    if(!this.capturing){
        fcn.apply(scope || this, args || []);
    }else{
        this.capture(new YAHOO.ext.Actor.Action(scope, fcn, args || []));
    }
};


YAHOO.ext.Actor.prototype.addAsyncCall = function(fcn, callbackIndex, args, scope){
    if(!this.capturing){
        fcn.apply(scope || this, args || []);
    }else{
       this.capture(new YAHOO.ext.Actor.AsyncAction(scope, fcn, args || [], callbackIndex));
    }
 },
 

YAHOO.ext.Actor.prototype.pause = function(seconds){
    this.capture(new YAHOO.ext.Actor.PauseAction(seconds));
 };
 

YAHOO.ext.Actor.prototype.shake = function(){
    this.move('left', 20, true, .05);
    this.move('right', 40, true, .05);
    this.move('left', 40, true, .05);
    this.move('right', 20, true, .05);
};


YAHOO.ext.Actor.prototype.bounce = function(){
    this.move('up', 20, true, .05);
    this.move('down', 40, true, .05);
    this.move('up', 40, true, .05);
    this.move('down', 20, true, .05);
};


YAHOO.ext.Actor.prototype.blindShow = function(anchor, newSize, duration, easing){
    var size = newSize || this.getSize();
    this.clip();
    this.setVisible(true);
    anchor = anchor.toLowerCase();
    switch(anchor){
        case 't':
        case 'top':
            this.setHeight(1);
            this.setHeight(newSize, true, duration || .5, null, easing || YAHOO.util.Easing.easeOut);
        break;
        case 'l':
        case 'left':
            this.setWidth(1);
            this.setWidth(newSize, true, duration || .5, null, easing || YAHOO.util.Easing.easeOut);
        break;
    }
    this.unclip();
    return size;
};


YAHOO.ext.Actor.prototype.blindHide = function(anchor, duration, easing){
    var size = this.getSize();
    this.clip();
    anchor = anchor.toLowerCase();
    switch(anchor){
        case 't':
        case 'top':
            this.setSize(size.width, 1, true, duration || .5, null, easing || YAHOO.util.Easing.easeIn);
            this.setVisible(false);
        break;
        case 'l':
        case 'left':
            this.setSize(1, size.height, true, duration || .5, null, easing || YAHOO.util.Easing.easeIn);
            this.setVisible(false);
        break;
        case 'r':
        case 'right':
            this.animate({width: {to: 1}, points: {by: [this.getWidth(), 0]}}, 
            duration || .5, null, YAHOO.util.Easing.easeIn, YAHOO.util.Motion);
            this.setVisible(false);
        break;
        case 'b':
        case 'bottom':
            this.animate({height: {to: 1}, points: {by: [0, this.getHeight()]}}, 
            duration || .5, null, YAHOO.util.Easing.easeIn, YAHOO.util.Motion);
            this.setVisible(false);
        break;
    }
    return size;
};


YAHOO.ext.Actor.prototype.slideShow = function(anchor, newSize, duration, easing, clearPositioning){
    var size = newSize || this.getSize();
    this.clip();
    var firstChild = this.dom.firstChild;
    if(!firstChild || (firstChild.nodeName && "#TEXT" == firstChild.nodeName.toUpperCase())) { 
        this.blindShow(anchor, newSize, duration, easing);
        return;
    }
    var child = YAHOO.ext.Element.get(firstChild, true);
    var pos = child.getPositioning();
    this.addCall(child.setAbsolutePositioned, null, child);
    this.setVisible(true);
    anchor = anchor.toLowerCase();
    switch(anchor){
        case 't':
        case 'top':
            this.addCall(child.setStyle, ['right', ''], child);
            this.addCall(child.setStyle, ['top', ''], child);
            this.addCall(child.setStyle, ['left', '0px'], child);
            this.addCall(child.setStyle, ['bottom', '0px'], child);
            this.setHeight(1);
            this.setHeight(newSize, true, duration || .5, null, easing || YAHOO.util.Easing.easeOut);
        break;
        case 'l':
        case 'left':
            this.addCall(child.setStyle, ['left', ''], child);
            this.addCall(child.setStyle, ['bottom', ''], child);
            this.addCall(child.setStyle, ['right', '0px'], child);
            this.addCall(child.setStyle, ['top', '0px'], child);
            this.setWidth(1);
            this.setWidth(newSize, true, duration || .5, null, easing || YAHOO.util.Easing.easeOut);
        break;
        case 'r':
        case 'right':
            this.addCall(child.setStyle, ['left', '0px'], child);
            this.addCall(child.setStyle, ['top', '0px'], child);
            this.addCall(child.setStyle, ['right', ''], child);
            this.addCall(child.setStyle, ['bottom', ''], child);
            this.setWidth(1);
            this.setWidth(newSize, true, duration || .5, null, easing || YAHOO.util.Easing.easeOut);
        break;
        case 'b':
        case 'bottom':
            this.addCall(child.setStyle, ['right', ''], child);
            this.addCall(child.setStyle, ['top', '0px'], child);
            this.addCall(child.setStyle, ['left', '0px'], child);
            this.addCall(child.setStyle, ['bottom', ''], child);
            this.setHeight(1);
            this.setHeight(newSize, true, duration || .5, null, easing || YAHOO.util.Easing.easeOut);
        break;
    }
    if(clearPositioning !== false){
      this.addCall(child.setPositioning, [pos], child);
    }
    this.unclip();
    return size;
};


YAHOO.ext.Actor.prototype.slideHide = function(anchor, duration, easing){
    var size = this.getSize();
    this.clip();
    var firstChild = this.dom.firstChild;
    if(!firstChild || (firstChild.nodeName && "#TEXT" == firstChild.nodeName.toUpperCase())) { 
        this.blindHide(anchor, duration, easing);
        return;
    }
    var child = YAHOO.ext.Element.get(firstChild, true);
    var pos = child.getPositioning();
    this.addCall(child.setAbsolutePositioned, null, child);
    anchor = anchor.toLowerCase();
    switch(anchor){
        case 't':
        case 'top':
            this.addCall(child.setStyle, ['right', ''], child);
            this.addCall(child.setStyle, ['top', ''], child);
            this.addCall(child.setStyle, ['left', '0px'], child);
            this.addCall(child.setStyle, ['bottom', '0px'], child);
            this.setSize(size.width, 1, true, duration || .5, null, easing || YAHOO.util.Easing.easeIn);
            this.setVisible(false);
        break;
        case 'l':
        case 'left':
            this.addCall(child.setStyle, ['left', ''], child);
            this.addCall(child.setStyle, ['bottom', ''], child);
            this.addCall(child.setStyle, ['right', '0px'], child);
            this.addCall(child.setStyle, ['top', '0px'], child);
            this.setSize(1, size.height, true, duration || .5, null, easing || YAHOO.util.Easing.easeIn);
            this.setVisible(false);
        break;
        case 'r':
        case 'right':
            this.addCall(child.setStyle, ['right', ''], child);
            this.addCall(child.setStyle, ['bottom', ''], child);
            this.addCall(child.setStyle, ['left', '0px'], child);
            this.addCall(child.setStyle, ['top', '0px'], child);
            this.setSize(1, size.height, true, duration || .5, null, easing || YAHOO.util.Easing.easeIn);
            this.setVisible(false);
        break;
        case 'b':
        case 'bottom':
            this.addCall(child.setStyle, ['right', ''], child);
            this.addCall(child.setStyle, ['top', '0px'], child);
            this.addCall(child.setStyle, ['left', '0px'], child);
            this.addCall(child.setStyle, ['bottom', ''], child);
            this.setSize(size.width, 1, true, duration || .5, null, easing || YAHOO.util.Easing.easeIn);
            this.setVisible(false);
        break;
    }
    this.addCall(child.setPositioning, [pos], child);
    return size;
};


YAHOO.ext.Actor.prototype.squish = function(duration){
    var size = this.getSize();
    this.clip();
    this.setSize(1, 1, true, duration || .5);
    this.setVisible(false);
    return size;
};


YAHOO.ext.Actor.prototype.appear = function(duration){
    this.setVisible(true, true, duration);
};


YAHOO.ext.Actor.prototype.fade = function(duration){
    this.setVisible(false, true, duration);
};


YAHOO.ext.Actor.prototype.switchOff = function(duration){
    this.clip();
    this.setVisible(false, true, .1);
    this.clearOpacity();
    this.setVisible(true);
    this.animate({height: {to: 1}, points: {by: [0, this.getHeight()/2]}}, 
            duration || .5, null, YAHOO.util.Easing.easeOut, YAHOO.util.Motion);
    this.setVisible(false);
};


YAHOO.ext.Actor.prototype.highlight = function(color, fromColor, duration, attribute){
    attribute = attribute || 'background-color';
    var original = this.getStyle(attribute);
    fromColor = fromColor || ((original && original != '' && original != 'transparent') ? original : '#FFFFFF');
    var cfg = {};
    cfg[attribute] = {to: color, from: fromColor};
    this.setVisible(true);
    this.animate(cfg, duration || .5, null, YAHOO.util.Easing.bounceOut, YAHOO.util.ColorAnim);
    this.setStyle(attribute, original);
};


YAHOO.ext.Actor.prototype.pulsate = function(count, duration){
    count = count || 3;
    for(var i = 0; i < count; i++){
        this.toggle(true, duration || .25);
        this.toggle(true, duration || .25);
    }
};


YAHOO.ext.Actor.prototype.dropOut = function(duration){
    this.animate({opacity: {to: 0}, points: {by: [0, this.getHeight()]}}, 
            duration || .5, null, YAHOO.util.Easing.easeIn, YAHOO.util.Motion);
    this.setVisible(false);
};


YAHOO.ext.Actor.prototype.moveOut = function(anchor, duration, easing){
    var Y = YAHOO.util;
    var vw = Y.Dom.getViewportWidth();
    var vh = Y.Dom.getViewportHeight();
    var cpoints = this.getCenterXY()
    var centerX = cpoints[0];
    var centerY = cpoints[1];
    var anchor = anchor.toLowerCase();
    var p;
    switch(anchor){
        case 't':
        case 'top':
            p = [centerX, -this.getHeight()];
        break;
        case 'l':
        case 'left':
            p = [-this.getWidth(), centerY];
        break;
        case 'r':
        case 'right':
            p = [vw+this.getWidth(), centerY];
        break;
        case 'b':
        case 'bottom':
            p = [centerX, vh+this.getHeight()];
        break;
        case 'tl':
        case 'top-left':
            p = [-this.getWidth(), -this.getHeight()];
        break;
        case 'bl':
        case 'bottom':
            p = [-this.getWidth(), vh+this.getHeight()];
        break;
        case 'br':
        case 'bottom-right':
            p = [vw+this.getWidth(), vh+this.getHeight()];
        break;
        case 'tr':
        case 'top-right':
            p = [vw+this.getWidth(), -this.getHeight()];
        break;
    }
    this.moveTo(p[0], p[1], true, duration || .35, null, easing || Y.Easing.easeIn);
    this.setVisible(false);
};


YAHOO.ext.Actor.prototype.moveIn = function(anchor, to, duration, easing){
    to = to || this.getCenterXY();
    this.moveOut(anchor, .01);
    this.setVisible(true);
    this.setXY(to, true, duration || .35, null, easing || YAHOO.util.Easing.easeOut);
};

YAHOO.ext.Actor.prototype.frame = function(color, count, duration){
    color = color || "red";
    count = count || 3;
    duration = duration || .5;
    var frameFn = function(callback){
        var box = this.getBox();
        var animFn = function(){ 
            var proxy = this.createProxy({
                 tag:"div",
                 style:{
                    visbility:"hidden",
                    position:"absolute",
                    zIndex:this.getStyle("zIndex"),
                    border:"0px solid " + color
                 }
              });
            var scale = proxy.isBorderBox() ? 2 : 1;
            proxy.animate({
                top:{from:box.y, to:box.y - 20},
                left:{from:box.x, to:box.x - 20},
                borderWidth:{from:0, to:10},
                opacity:{from:1, to:0},
                height:{from:box.height, to:(box.height + (20*scale))},
                width:{from:box.width, to:(box.width + (20*scale))}
            }, duration, function(){
                proxy.remove();
            });
            if(--count > 0){
                 animFn.defer((duration/2)*1000, this);
            }else{
                if(typeof callback == 'function'){
                    callback();
                }
            }
       }
       animFn.call(this);
   }
   this.addAsyncCall(frameFn, 0, null, this);
};

YAHOO.ext.Actor.Action = function(actor, method, args){
      this.actor = actor;
      this.method = method;
      this.args = args;
  }
  
YAHOO.ext.Actor.Action.prototype = {
    play : function(onComplete){
        this.method.apply(this.actor || window, this.args);
        onComplete();
    }  
};


YAHOO.ext.Actor.AsyncAction = function(actor, method, args, onIndex){
    YAHOO.ext.Actor.AsyncAction.superclass.constructor.call(this, actor, method, args);
    this.onIndex = onIndex;
    this.originalCallback = this.args[onIndex];
}
YAHOO.extendX(YAHOO.ext.Actor.AsyncAction, YAHOO.ext.Actor.Action);

YAHOO.ext.Actor.AsyncAction.prototype.play = function(onComplete){
    var callbackArg = this.originalCallback ? 
                        this.originalCallback.createSequence(onComplete) : onComplete;
    this.args[this.onIndex] = callbackArg;
    this.method.apply(this.actor, this.args);
};


YAHOO.ext.Actor.PauseAction = function(seconds){
    this.seconds = seconds;
};
YAHOO.ext.Actor.PauseAction.prototype = {
    play : function(onComplete){
        setTimeout(onComplete, this.seconds * 1000);
    }
};
 
 YAHOO.ext.Animator = function(){
    this.actors = [];
    this.playlist = new YAHOO.ext.Animator.AnimSequence();
    this.captureDelegate = this.capture.createDelegate(this);
    this.playDelegate = this.play.createDelegate(this);
    this.syncing = false;
    this.stopping = false;
    this.playing = false;
    for(var i = 0; i < arguments.length; i++){
        this.addActor(arguments[i]);
    }
 };
 
 YAHOO.ext.Animator.prototype = {
 
     capture : function(actor, action){
        if(this.syncing){
            if(!this.syncMap[actor.id]){
                this.syncMap[actor.id] = new YAHOO.ext.Animator.AnimSequence();
            }
            this.syncMap[actor.id].add(action);
        }else{
            this.playlist.add(action);
        }
    },
    
    
     addActor : function(actor){
        actor.onCapture.subscribe(this.captureDelegate);
        this.actors.push(actor);
    },
    
    
    
     startCapture : function(clearPlaylist){
        for(var i = 0; i < this.actors.length; i++){
            var a = this.actors[i];
            if(!this.isCapturing(a)){
                a.onCapture.subscribe(this.captureDelegate);
            }
            a.capturing = true;
        }
        if(clearPlaylist){
            this.playlist = new YAHOO.ext.Animator.AnimSequence();
        }
     },
     
     
     isCapturing : function(actor){
        var subscribers = actor.onCapture.subscribers;
        if(subscribers){
            for(var i = 0; i < subscribers.length; i++){
                if(subscribers[i] && subscribers[i].contains(this.captureDelegate)){
                    return true;
                }
            }
        }
        return false;
     },
     
     
     stopCapture : function(){
         for(var i = 0; i < this.actors.length; i++){
            var a = this.actors[i];
            a.onCapture.unsubscribe(this.captureDelegate);
            a.capturing = false;
         }
     },
     
     
    beginSync : function(){
        this.syncing = true;
        this.syncMap = {};
     },
     
     
    endSync : function(){
         this.syncing = false;
         var composite = new YAHOO.ext.Animator.CompositeSequence();
         for(key in this.syncMap){
             if(typeof this.syncMap[key] != 'function'){
                composite.add(this.syncMap[key]);
             }
         }
         this.playlist.add(composite);
         this.syncMap = null;
     },
     
    
    play : function(oncomplete){
        if(this.playing) return; 
        this.stopCapture();
        this.playlist.play(oncomplete);
    },
    
    
    stop : function(){
        this.playlist.stop();
    },
    
    
    isPlaying : function(){
        return this.playlist.isPlaying();
    },
    
    clear : function(){
        this.playlist = new YAHOO.ext.Animator.AnimSequence();
     },
     
    
     addCall : function(fcn, args, scope){
        this.playlist.add(new YAHOO.ext.Actor.Action(scope, fcn, args || []));
     },
     
     
    addAsyncCall : function(fcn, callbackIndex, args, scope){
        this.playlist.add(new YAHOO.ext.Actor.AsyncAction(scope, fcn, args || [], callbackIndex));
     },
     
     
    pause : function(seconds){
        this.playlist.add(new YAHOO.ext.Actor.PauseAction(seconds));
     }
     
  };

YAHOO.ext.Animator.select = function(selector){
    var els;
    if(typeof selector == 'string'){
        els = YAHOO.ext.Element.selectorFunction(selector);
    }else if(selector instanceof Array){
        els = selector;
    }else{
        throw 'Invalid selector';
    }
    return new YAHOO.ext.AnimatorComposite(els);
};
var getActors = YAHOO.ext.Animator.select;


YAHOO.ext.AnimatorComposite = function(els){
    this.animator = new YAHOO.ext.Animator();
    this.addElements(els);
    this.syncAnims = true;
};
YAHOO.ext.AnimatorComposite.prototype = {
    isComposite: true,
    
    addElements : function(els){
        if(!els) return this;
        var anim = this.animator;
        for(var i = 0, len = els.length; i < len; i++) {
        	anim.addActor(new YAHOO.ext.Actor(els[i]));
        }
        anim.startCapture();
        return this;
    },
    
    sequence : function(){
        this.syncAnims = false;
        return this;
    },
    
    sync : function(){
        this.syncAnims = true;
        return this;
    },
    invoke : function(fn, args){
        var els = this.animator.actors;
        if(this.syncAnims) this.animator.beginSync();
        for(var i = 0, len = els.length; i < len; i++) {
            YAHOO.ext.Actor.prototype[fn].apply(els[i], args);
        }
        if(this.syncAnims) this.animator.endSync();
        return this;
    },
    
    play : function(callback){
        this.animator.play(callback);
        return this;
    },
    
    reset : function(callback){
        this.animator.startCapture(true);
        return this;
    },
    
    pause : function(seconds){
        this.animator.pause(seconds);
        return this;
    },
    
    getAnimator : function(){
        return this.animator;
    },
    
    each : function(fn, scope){
        var els = this.animator.actors;
        if(this.syncAnims) this.animator.beginSync();
        for(var i = 0, len = els.length; i < len; i++){
            fn.call(scope || els[i], els[i], this, i);
        }
        if(this.syncAnims) this.animator.endSync();
        return this;
    },
    
     addCall : function(fcn, args, scope){
        this.animator.addCall(fcn, args, scope);
        return this;
    },
    
    addAsyncCall : function(fcn, callbackIndex, args, scope){
        this.animator.addAsyncCall(fcn, callbackIndex, args, scope);
        return this;
    }
};
for(var fnName in YAHOO.ext.Actor.prototype){
    if(typeof YAHOO.ext.Actor.prototype[fnName] == 'function'){
        YAHOO.ext.CompositeElement.createCall(YAHOO.ext.AnimatorComposite.prototype, fnName);
    }
}


YAHOO.ext.Animator.AnimSequence = function(){
    this.actions = [];
    this.nextDelegate = this.next.createDelegate(this);
    this.playDelegate = this.play.createDelegate(this);
    this.oncomplete = null;
    this.playing = false;
    this.stopping = false;
    this.actionIndex = -1;
 };
 
 YAHOO.ext.Animator.AnimSequence.prototype = {
 
    add : function(action){
        this.actions.push(action);
    },
    
    next : function(){
        if(this.stopping){
            this.playing = false;
            if(this.oncomplete){
                this.oncomplete(this, false);
            }
            return;
        }
        var nextAction = this.actions[++this.actionIndex];
        if(nextAction){
            nextAction.play(this.nextDelegate);
        }else{
            this.playing = false;
            if(this.oncomplete){
                this.oncomplete(this, true);
            }
        }
    },
    
    play : function(oncomplete){
        if(this.playing) return; 
        this.oncomplete = oncomplete;
        this.stopping = false;
        this.playing = true;
        this.actionIndex = -1;
        this.next();
    },
    
    stop : function(){
        this.stopping = true;
    },
    
    isPlaying : function(){
        return this.playing;
    },
    
    clear : function(){
        this.actions = [];
    },
     
    addCall : function(fcn, args, scope){
        this.actions.push(new YAHOO.ext.Actor.Action(scope, fcn, args || []));
     },
     
     addAsyncCall : function(fcn, callbackIndex, args, scope){
        this.actions.push(new YAHOO.ext.Actor.AsyncAction(scope, fcn, args || [], callbackIndex));
     },
     
     pause : function(seconds){
        this.actions.push(new YAHOO.ext.Actor.PauseAction(seconds));
     }
     
  };

YAHOO.ext.Animator.CompositeSequence = function(){
    this.sequences = [];
    this.completed = 0;
    this.trackDelegate = this.trackCompletion.createDelegate(this);
}

YAHOO.ext.Animator.CompositeSequence.prototype = {
    add : function(sequence){
        this.sequences.push(sequence);
    },
    
    play : function(onComplete){
        this.completed = 0;
        if(this.sequences.length < 1){
            if(onComplete)onComplete();
            return;
        }
        this.onComplete = onComplete;
        for(var i = 0; i < this.sequences.length; i++){
            this.sequences[i].play(this.trackDelegate);
        }
    },
    
    trackCompletion : function(){
        ++this.completed;
        if(this.completed >= this.sequences.length && this.onComplete){
            this.onComplete();
        }
    },
    
    stop : function(){
        for(var i = 0; i < this.sequences.length; i++){
            this.sequences[i].stop();
        }
    },
    
    isPlaying : function(){
        for(var i = 0; i < this.sequences.length; i++){
            if(this.sequences[i].isPlaying()){
                return true;
            }
        }
        return false;
    }
};



 
 YAHOO.ext.Toolbar = function(container, buttons){
    this.el = getEl(container, true);
    var div = document.createElement('div');
    div.className = 'ytoolbar';
    var tb = document.createElement('table');
    tb.border = 0;
    tb.cellPadding = 0; 
    tb.cellSpacing = 0;
    div.appendChild(tb);
    var tbody = document.createElement('tbody');
    tb.appendChild(tbody);
    var tr = document.createElement('tr');
    tbody.appendChild(tr);
    this.el.dom.appendChild(div);
    this.tr = tr;
    if(buttons){
        this.add.apply(this, buttons);
    }
};

YAHOO.ext.Toolbar.prototype = {
    
    add : function(){
        for(var i = 0; i < arguments.length; i++){
            var el = arguments[i];
            var td = document.createElement('td');
            this.tr.appendChild(td);
            if(el instanceof YAHOO.ext.ToolbarButton){
                el.init(td);
            }else if(el instanceof Array){
                this.addButton(el);
            }else if(typeof el == 'string'){
                var span = document.createElement('span');
                if(el == 'separator'){
                    span.className = 'ytb-sep';
                }else{
                    span.innerHTML = el;
                    span.className = 'ytb-text';
                }
                td.appendChild(span);
            }else if(typeof el == 'object' && el.nodeType){ 
                td.appendChild(el);
            }else if(typeof el == 'object'){ 
                this.addButton(el);
            }
        }
    },
    
    
    getEl : function(){
        return this.el;  
    },
    
    
    addSeparator : function(){
        var td = document.createElement('td');
        this.tr.appendChild(td);
        var span = document.createElement('span');
        span.className = 'ytb-sep';
        td.appendChild(span);
    },
    
    
    addButton : function(config){
        if(config instanceof Array){
            var buttons = [];
            for(var i = 0, len = config.length; i < len; i++) {
            	buttons.push(this.addButton(config[i]));
            }
            return buttons;
        }
        var b = config;
        if(!(config instanceof YAHOO.ext.ToolbarButton)){
             b = new YAHOO.ext.ToolbarButton(config);
        }
        this.add(b);
        return b;
    },
    
    
    addText : function(text){
        var td = document.createElement('td');
        this.tr.appendChild(td);
        var span = document.createElement('span');
        span.className = 'ytb-text';
        span.innerHTML = text;
        td.appendChild(span);
        return span;
    },
    
    
    insertButton : function(index, config){
        if(config instanceof Array){
            var buttons = [];
            for(var i = 0, len = config.length; i < len; i++) {
               buttons.push(this.insertButton(index + i, config[i]));
            }
            return buttons;
        }
        var b = new YAHOO.ext.ToolbarButton(config);
        var td = document.createElement('td');
        var nextSibling = this.tr.childNodes[index];
        if (nextSibling)
           this.tr.insertBefore(td, nextSibling);
       else
           this.tr.appendChild(td);
        b.init(td);
        return b;
    }
};


YAHOO.ext.ToolbarButton = function(config){
    YAHOO.ext.util.Config.apply(this, config);
};

YAHOO.ext.ToolbarButton.prototype = {
    
    init : function(appendTo){
        var element = document.createElement('span');
        element.className = 'ytb-button';
        if(this.id){
            element.id = this.id;
        }
        this.setDisabled(this.disabled === true);
        var inner = document.createElement('span');
        inner.className = 'ytb-button-inner ' + this.className;
        inner.unselectable = 'on';
        if(this.tooltip){
            element.setAttribute('title', this.tooltip);
        }
        if(this.style){
           YAHOO.ext.DomHelper.applyStyles(inner, this.style);
        } 
        element.appendChild(inner);
        appendTo.appendChild(element);
        this.el = getEl(element, true);
        this.el.unselectable();
        inner.innerHTML = (this.text ? this.text : '&#160;');
        this.inner = inner;
        this.el.mon('click', this.onClick, this, true);    
        this.el.mon('mouseover', this.onMouseOver, this, true);    
        this.el.mon('mouseout', this.onMouseOut, this, true);
    },
    
    
    setHandler : function(click, scope){
        this.click = click;
        this.scope = scope;  
    },
    
    
    setText : function(text){
        this.inner.innerHTML = text;    
    },
    
    
    setTooltip : function(text){
        this.el.dom.title = text;    
    },
    
    
    show: function(){
        this.el.dom.parentNode.style.display = '';
    },
    
    
    hide: function(){
        this.el.dom.parentNode.style.display = 'none';  
    },
    
    
    disable : function(){
        this.disabled = true;
        if(this.el){
            this.el.addClass('ytb-button-disabled');
        }
    },
    
    
    enable : function(){
        this.disabled = false;
        if(this.el){
            this.el.removeClass('ytb-button-disabled');
        }
    },
    
    
    isDisabled : function(){
        return this.disabled === true;
    },
    
    setDisabled : function(disabled){
        if(disabled){
            this.disable();
        }else{
            this.enable();
        }
    },
    
    
    onClick : function(){
        if(!this.disabled && this.click){
            this.click.call(this.scope || window, this);
        }
    },
    
    
    onMouseOver : function(){
        if(!this.disabled){
            this.el.addClass('ytb-button-over');
            if(this.mouseover){
                this.mouseover.call(this.scope || window, this);
            }
        }
    },
    
    
    onMouseOut : function(){
        this.el.removeClass('ytb-button-over');
        if(!this.disabled){
            if(this.mouseout){
                this.mouseout.call(this.scope || window, this);
            }
        }
    }
};

YAHOO.ext.Resizable = function(el, config){
    this.el = getEl(el);
    
    if(config && config.wrap){
        config.resizeChild = this.el;
        this.el = this.el.wrap(typeof config.wrap == 'object' ? config.wrap : null);
        this.el.id = this.el.dom.id = config.resizeChild.id + '-rzwrap';
        this.el.setStyle('overflow', 'hidden');
        this.el.setPositioning(config.resizeChild.getPositioning());
        config.resizeChild.clearPositioning();
        if(!config.width || !config.height){
            var csize = config.resizeChild.getSize();
            
            
            this.el.setSize(csize.width, csize.height);
        }
        if(config.pinned && !config.adjustments){
            config.adjustments = 'auto';
        }
    }
    
    this.proxy = this.el.createProxy({tag: 'div', cls: 'yresizable-proxy', id: this.el.id + '-rzproxy'})
    this.proxy.unselectable();
    
    
    this.overlay = this.el.createProxy({tag: 'div', cls: 'yresizable-overlay', html: '&#160;'});
    this.overlay.unselectable();
    this.overlay.enableDisplayMode('block');
    this.overlay.mon('mousemove', this.onMouseMove, this, true);
    this.overlay.mon('mouseup', this.onMouseUp, this, true);
    
    YAHOO.ext.util.Config.apply(this, config, {
        
        resizeChild : false,
        
        adjustments : [0, 0],
        
        minWidth : 5,
        
        minHeight : 5,
        
        maxWidth : 10000,
        
        maxHeight : 10000,
        
        enabled : true,
        
        animate : false,
        
        duration : .35,
        
        dynamic : false,
        
        
        handles : false,
        multiDirectional : false,
        
        disableTrackOver : false,
        
        easing : YAHOO.util.Easing ? YAHOO.util.Easing.easeOutStrong : null,
        
        widthIncrement : 0,
        
        heightIncrement : 0,
        
        pinned : false,
        
        width : null,
        
        height : null,
        
        preserveRatio : false,
        
        transparent: false,
        
        minX: 0,
        
        minY: 0,
        
        draggable: false
    });
    
    if(this.pinned){
        this.disableTrackOver = true;
        this.el.addClass('yresizable-pinned');    
    }
    
    var position = this.el.getStyle('position');
    if(position != 'absolute' && position != 'fixed'){
        this.el.setStyle('position', 'relative');
    }
    if(!this.handles){ 
        this.handles = 's,e,se';
        if(this.multiDirectional){
            this.handles += ',n,w';
        }
    }
    if(this.handles == 'all'){
        this.handles = 'n s e w ne nw se sw';
    }
    var hs = this.handles.split(/\s*?[,;]\s*?| /);
    var ps = YAHOO.ext.Resizable.positions;
    for(var i = 0, len = hs.length; i < len; i++){
        if(hs[i] && ps[hs[i]]){
            var pos = ps[hs[i]];
            this[pos] = new YAHOO.ext.Resizable.Handle(this, pos, this.disableTrackOver, this.transparent);
        }
    }
    
    this.corner = this.southeast;
    
    this.activeHandle = null;
    
    if(this.resizeChild){
        if(typeof this.resizeChild == 'boolean'){
            this.resizeChild = YAHOO.ext.Element.get(this.el.dom.firstChild, true);
        }else{
            this.resizeChild = YAHOO.ext.Element.get(this.resizeChild, true);
        }
    }
    
    if(this.adjustments == 'auto'){
        var rc = this.resizeChild;
        var hw = this.west, he = this.east, hn = this.north, hs = this.south;
        if(rc && (hw || hn)){
            rc.setRelativePositioned();
            rc.setLeft(hw ? hw.el.getWidth() : 0);
            rc.setTop(hn ? hn.el.getHeight() : 0);
        }
        this.adjustments = [
            (he ? -he.el.getWidth() : 0) + (hw ? -hw.el.getWidth() : 0),
            (hn ? -hn.el.getHeight() : 0) + (hs ? -hs.el.getHeight() : 0) -1 
        ];
    }
    
    if(this.draggable){
        this.dd = this.dynamic ? 
            this.el.initDD(null) : this.el.initDDProxy(null, {dragElId: this.proxy.id});
        this.dd.setHandleElId(this.resizeChild ? this.resizeChild.id : this.el.id);
    }
    
    
    this.events = {
        
        'beforeresize' : new YAHOO.util.CustomEvent(),
        
        'resize' : new YAHOO.util.CustomEvent()
    };
    
    if(this.width !== null && this.height !== null){
        this.resizeTo(this.width, this.height);
    }else{
        this.updateChildSize();
    }
};

YAHOO.extendX(YAHOO.ext.Resizable, YAHOO.ext.util.Observable, {
    
    resizeTo : function(width, height){
        this.el.setSize(width, height);
        this.updateChildSize();
        this.fireEvent('resize', this, width, height, null);
    },
    
    startSizing : function(e){
        this.fireEvent('beforeresize', this, e);
        if(this.enabled){ 
            this.resizing = true;
            this.startBox = this.el.getBox();
            this.startPoint = e.getXY();
            this.offsets = [(this.startBox.x + this.startBox.width) - this.startPoint[0],
                            (this.startBox.y + this.startBox.height) - this.startPoint[1]];
            this.proxy.setBox(this.startBox);
            
            this.overlay.setSize(YAHOO.util.Dom.getDocumentWidth(), YAHOO.util.Dom.getDocumentHeight());
            this.overlay.show();
            
            if(!this.dynamic){
                this.proxy.show();
            }
        }
    },
    
    onMouseDown : function(handle, e){
        if(this.enabled){
            e.stopEvent();
            this.activeHandle = handle;
            this.overlay.setStyle('cursor', handle.el.getStyle('cursor'));
            this.startSizing(e);
        }          
    },
    
    onMouseUp : function(e){
        var size = this.resizeElement();
        this.resizing = false;
        this.handleOut();
        this.overlay.hide();
        this.fireEvent('resize', this, size.width, size.height, e);
    },
    
    updateChildSize : function(){
        if(this.resizeChild){
            var el = this.el;
            var child = this.resizeChild;
            var adj = this.adjustments;
            if(el.dom.offsetWidth){
                var b = el.getSize(true);
                child.setSize(b.width+adj[0], b.height+adj[1]);
            }
            
            
            
            
            if(YAHOO.ext.util.Browser.isIE){
                setTimeout(function(){
                    if(el.dom.offsetWidth){
                        var b = el.getSize(true);
                        child.setSize(b.width+adj[0], b.height+adj[1]);
                    }
                }, 10);
            }
        }
    },
    
    snap : function(value, inc, min){
        if(!inc || !value) return value;
        var newValue = value;
        var m = value % inc;
        if(m > 0){
            if(m > (inc/2)){
                newValue = value + (inc-m);
            }else{
                newValue = value - m;
            }
        }
        return Math.max(min, newValue);
    },
    
    resizeElement : function(){
        var box = this.proxy.getBox();
        
        
        
            this.el.setBox(box, false, this.animate, this.duration, null, this.easing);
        
        
        
        this.updateChildSize();
        this.proxy.hide();
        return box;
    },
    
    constrain : function(v, diff, m, mx){
        if(v - diff < m){
            diff = v - m;    
        }else if(v - diff > mx){
            diff = mx - v; 
        }
        return diff;                
    },
    
    onMouseMove : function(e){
        if(this.enabled){
            try{
            
            
            var curSize = this.curSize || this.startBox;
            var x = this.startBox.x, y = this.startBox.y;
            var ox = x, oy = y;
            var w = curSize.width, h = curSize.height;
            var ow = w, oh = h;
            var mw = this.minWidth, mh = this.minHeight;
            var mxw = this.maxWidth, mxh = this.maxHeight;
            var wi = this.widthIncrement;
            var hi = this.heightIncrement;
            
            var eventXY = e.getXY();
            var diffX = -(this.startPoint[0] - Math.max(this.minX, eventXY[0]));
            var diffY = -(this.startPoint[1] - Math.max(this.minY, eventXY[1]));
            
            var pos = this.activeHandle.position;
            
            switch(pos){
                case 'east':
                    w += diffX; 
                    w = Math.min(Math.max(mw, w), mxw);
                    break;
                case 'south':
                    h += diffY;
                    h = Math.min(Math.max(mh, h), mxh);
                    break;
                case 'southeast':
                    w += diffX; 
                    h += diffY;
                    w = Math.min(Math.max(mw, w), mxw);
                    h = Math.min(Math.max(mh, h), mxh);
                    break;
                case 'north':
                    diffY = this.constrain(h, diffY, mh, mxh);
                    y += diffY;
                    h -= diffY;
                    break;
                case 'west':
                    diffX = this.constrain(w, diffX, mw, mxw);
                    x += diffX;
                    w -= diffX;
                    break;
                case 'northeast':
                    w += diffX; 
                    w = Math.min(Math.max(mw, w), mxw);
                    diffY = this.constrain(h, diffY, mh, mxh);
                    y += diffY;
                    h -= diffY;
                    break;
                case 'northwest':
                    diffX = this.constrain(w, diffX, mw, mxw);
                    diffY = this.constrain(h, diffY, mh, mxh);
                    y += diffY;
                    h -= diffY;
                    x += diffX;
                    w -= diffX;
                    break;
               case 'southwest':
                    diffX = this.constrain(w, diffX, mw, mxw);
                    h += diffY;
                    h = Math.min(Math.max(mh, h), mxh);
                    x += diffX;
                    w -= diffX;
                    break;
            }
            
            var sw = this.snap(w, wi, mw);
            var sh = this.snap(h, hi, mh);
            if(sw != w || sh != h){
                switch(pos){
                    case 'northeast':
                        y -= sh - h;
                    break;
                    case 'north':
                        y -= sh - h;
                        break;
                    case 'southwest':
                        x -= sw - w;
                    break;
                    case 'west':
                        x -= sw - w;
                        break;
                    case 'northwest':
                        x -= sw - w;
                        y -= sh - h;
                    break;
                }
                w = sw;
                h = sh;
            }
            
            if(this.preserveRatio){
                switch(pos){
                    case 'southeast':
                    case 'east':
                        h = oh * (w/ow);
                        h = Math.min(Math.max(mh, h), mxh);
                        w = ow * (h/oh);
                       break;
                    case 'south':
                        w = ow * (h/oh);
                        w = Math.min(Math.max(mw, w), mxw);
                        h = oh * (w/ow);
                        break;
                    case 'northeast':
                        w = ow * (h/oh);
                        w = Math.min(Math.max(mw, w), mxw);
                        h = oh * (w/ow);
                    break;
                    case 'north':
                        var tw = w;
                        w = ow * (h/oh);
                        w = Math.min(Math.max(mw, w), mxw);
                        h = oh * (w/ow);
                        x += (tw - w) / 2;
                        break;
                    case 'southwest':
                        h = oh * (w/ow);
                        h = Math.min(Math.max(mh, h), mxh);
                        var tw = w;
                        w = ow * (h/oh);
                        x += tw - w;
                        break;
                    case 'west':
                        var th = h;
                        h = oh * (w/ow);
                        h = Math.min(Math.max(mh, h), mxh);
                        y += (th - h) / 2;
                        var tw = w;
                        w = ow * (h/oh);
                        x += tw - w;
                       break;
                    case 'northwest':
                        var tw = w;
                        var th = h;
                        h = oh * (w/ow);
                        h = Math.min(Math.max(mh, h), mxh);
                        w = ow * (h/oh);
                        y += th - h;
                         x += tw - w;
                       break;
                        
                }
            }
            this.proxy.setBounds(x, y, w, h);
            if(this.dynamic){
                this.resizeElement();
            }
            }catch(e){}
        }
    },
    
    handleOver : function(){
        if(this.enabled){
            this.el.addClass('yresizable-over');
        }
    },
    
    handleOut : function(){
        if(!this.resizing){
            this.el.removeClass('yresizable-over');
        }
    },
    
    
    getEl : function(){
        return this.el;
    },
    
    
    getResizeChild : function(){
        return this.resizeChild;
    }
});


YAHOO.ext.Resizable.positions = {
    n: 'north', s: 'south', e: 'east', w: 'west', se: 'southeast', sw: 'southwest', nw: 'northwest', ne: 'northeast' 
};


YAHOO.ext.Resizable.Handle = function(rz, pos, disableTrackOver, transparent){
    if(!this.tpl){
        
        var tpl = YAHOO.ext.DomHelper.createTemplate(
            {tag: 'div', cls: 'yresizable-handle yresizable-handle-{0}', html: '&#160;'}
        );
        tpl.compile();
        YAHOO.ext.Resizable.Handle.prototype.tpl = tpl;
    }
    this.position = pos;
    this.rz = rz;
    this.el = this.tpl.append(rz.el.dom, [this.position], true);
    this.el.unselectable();
    if(transparent){
        this.el.setOpacity(0);
    }
    this.el.mon('mousedown', this.onMouseDown, this, true);
    if(!disableTrackOver){
        this.el.mon('mouseover', this.onMouseOver, this, true);
        this.el.mon('mouseout', this.onMouseOut, this, true);
    }
};

YAHOO.ext.Resizable.Handle.prototype = {
    afterResize : function(rz){
        
    },
    
    onMouseDown : function(e){
        this.rz.onMouseDown(this, e);
    },
    
    onMouseOver : function(e){
        this.rz.handleOver(this, e);
    },
    
    onMouseOut : function(e){
        this.rz.handleOut(this, e);
    }  
};




if(YAHOO.util.DragDropMgr){
  YAHOO.util.DragDropMgr.clickTimeThresh = 350;
}

YAHOO.ext.SplitBar = function(dragElement, resizingElement, orientation, placement){
    
    
    this.el = YAHOO.ext.Element.get(dragElement, true);
    this.el.dom.unselectable = 'on';
    
    this.resizingEl = YAHOO.ext.Element.get(resizingElement, true);
    
    
    this.orientation = orientation || YAHOO.ext.SplitBar.HORIZONTAL;
    
    
    this.minSize = 0;
    
    
    this.maxSize = 2000;
    
    this.onMoved = new YAHOO.util.CustomEvent("SplitBarMoved", this);
    
    
    this.animate = false;
    
    
    this.useShim = false;
    
    
    this.shim = null;
    
    
    this.proxy = YAHOO.ext.SplitBar.createProxy(this.orientation);
    
    
    this.dd = new YAHOO.util.DDProxy(this.el.dom.id, "SplitBars", {dragElId : this.proxy.id});
    
    
    this.dd.b4StartDrag = this.onStartProxyDrag.createDelegate(this);
    
    
    this.dd.endDrag = this.onEndProxyDrag.createDelegate(this);
    
    
    this.dragSpecs = {};
    
    
    this.adapter = new YAHOO.ext.SplitBar.BasicLayoutAdapter();
    this.adapter.init(this);
    
    if(this.orientation == YAHOO.ext.SplitBar.HORIZONTAL){
        
        this.placement = placement || (this.el.getX() > this.resizingEl.getX() ? YAHOO.ext.SplitBar.LEFT : YAHOO.ext.SplitBar.RIGHT);
        this.el.setStyle('cursor', 'e-resize');
    }else{
        
        this.placement = placement || (this.el.getY() > this.resizingEl.getY() ? YAHOO.ext.SplitBar.TOP : YAHOO.ext.SplitBar.BOTTOM);
        this.el.setStyle('cursor', 'n-resize');
    }
    
    this.events = {
        
        'resize' : this.onMoved,
        
        'moved' : this.onMoved,
        
        'beforeresize' : new YAHOO.util.CustomEvent('beforeresize')
    }
}

YAHOO.extendX(YAHOO.ext.SplitBar, YAHOO.ext.util.Observable, {
    onStartProxyDrag : function(x, y){
        this.fireEvent('beforeresize', this);
        if(this.useShim){
            if(!this.shim){
                this.shim = YAHOO.ext.SplitBar.createShim();
            }
            this.shim.setVisible(true);
        }
        YAHOO.util.Dom.setStyle(this.proxy, 'display', 'block');
        var size = this.adapter.getElementSize(this);
        this.activeMinSize = this.getMinimumSize();;
        this.activeMaxSize = this.getMaximumSize();;
        var c1 = size - this.activeMinSize;
        var c2 = Math.max(this.activeMaxSize - size, 0);
        if(this.orientation == YAHOO.ext.SplitBar.HORIZONTAL){
            this.dd.resetConstraints();
            this.dd.setXConstraint(
                this.placement == YAHOO.ext.SplitBar.LEFT ? c1 : c2, 
                this.placement == YAHOO.ext.SplitBar.LEFT ? c2 : c1
            );
            this.dd.setYConstraint(0, 0);
        }else{
            this.dd.resetConstraints();
            this.dd.setXConstraint(0, 0);
            this.dd.setYConstraint(
                this.placement == YAHOO.ext.SplitBar.TOP ? c1 : c2, 
                this.placement == YAHOO.ext.SplitBar.TOP ? c2 : c1
            );
         }
        this.dragSpecs.startSize = size;
        this.dragSpecs.startPoint = [x, y];
        
        YAHOO.util.DDProxy.prototype.b4StartDrag.call(this.dd, x, y);
    },
    
    
    onEndProxyDrag : function(e){
        YAHOO.util.Dom.setStyle(this.proxy, 'display', 'none');
        var endPoint = YAHOO.util.Event.getXY(e);
        if(this.useShim){
            this.shim.setVisible(false);
        }
        var newSize;
        if(this.orientation == YAHOO.ext.SplitBar.HORIZONTAL){
            newSize = this.dragSpecs.startSize + 
                (this.placement == YAHOO.ext.SplitBar.LEFT ?
                    endPoint[0] - this.dragSpecs.startPoint[0] :
                    this.dragSpecs.startPoint[0] - endPoint[0]
                );
        }else{
            newSize = this.dragSpecs.startSize + 
                (this.placement == YAHOO.ext.SplitBar.TOP ?
                    endPoint[1] - this.dragSpecs.startPoint[1] :
                    this.dragSpecs.startPoint[1] - endPoint[1]
                );
        }
        newSize = Math.min(Math.max(newSize, this.activeMinSize), this.activeMaxSize);
        if(newSize != this.dragSpecs.startSize){
            this.adapter.setElementSize(this, newSize);
            this.onMoved.fireDirect(this, newSize);
        }
    },
    
    
    getAdapter : function(){
        return this.adapter;
    },
    
    
    setAdapter : function(adapter){
        this.adapter = adapter;
        this.adapter.init(this);
    },
    
    
    getMinimumSize : function(){
        return this.minSize;
    },
    
    
    setMinimumSize : function(minSize){
        this.minSize = minSize;
    },
    
    
    getMaximumSize : function(){
        return this.maxSize;
    },
    
    
    setMaximumSize : function(maxSize){
        this.maxSize = maxSize;
    },
    
    
    setCurrentSize : function(size){
        var oldAnimate = this.animate;
        this.animate = false;
        this.adapter.setElementSize(this, size);
        this.animate = oldAnimate;
    },
    
    
    destroy : function(removeEl){
        if(this.shim){
            this.shim.remove();
        }
        this.dd.unreg();
        this.proxy.parentNode.removeChild(this.proxy);
        if(removeEl){
            this.el.remove();
        }
    }
});


YAHOO.ext.SplitBar.createShim = function(){
    var shim = document.createElement('div');
    shim.unselectable = 'on';
    YAHOO.util.Dom.generateId(shim, 'split-shim');
    YAHOO.util.Dom.setStyle(shim, 'width', '100%');
    YAHOO.util.Dom.setStyle(shim, 'height', '100%');
    YAHOO.util.Dom.setStyle(shim, 'position', 'absolute');
    YAHOO.util.Dom.setStyle(shim, 'background', 'white');
    YAHOO.util.Dom.setStyle(shim, 'z-index', 11000);
    window.document.body.appendChild(shim);
    var shimEl = YAHOO.ext.Element.get(shim);
    shimEl.setOpacity(.01);
    shimEl.setXY([0, 0]);
    return shimEl;
};


YAHOO.ext.SplitBar.createProxy = function(orientation){
    var proxy = document.createElement('div');
    proxy.unselectable = 'on';
    YAHOO.util.Dom.generateId(proxy, 'split-proxy');
    YAHOO.util.Dom.setStyle(proxy, 'position', 'absolute');
    YAHOO.util.Dom.setStyle(proxy, 'visibility', 'hidden');
    YAHOO.util.Dom.setStyle(proxy, 'z-index', 11001);
    YAHOO.util.Dom.setStyle(proxy, 'background-color', "#aaa");
    if(orientation == YAHOO.ext.SplitBar.HORIZONTAL){
        YAHOO.util.Dom.setStyle(proxy, 'cursor', 'e-resize');
    }else{
        YAHOO.util.Dom.setStyle(proxy, 'cursor', 'n-resize');
    }
    
    YAHOO.util.Dom.setStyle(proxy, 'line-height', '0px');
    YAHOO.util.Dom.setStyle(proxy, 'font-size', '0px');
    window.document.body.appendChild(proxy);
    return proxy;
};


YAHOO.ext.SplitBar.BasicLayoutAdapter = function(){
};

YAHOO.ext.SplitBar.BasicLayoutAdapter.prototype = {
    
    init : function(s){
    
    },
    
     getElementSize : function(s){
        if(s.orientation == YAHOO.ext.SplitBar.HORIZONTAL){
            return s.resizingEl.getWidth();
        }else{
            return s.resizingEl.getHeight();
        }
    },
    
    
    setElementSize : function(s, newSize, onComplete){
        if(s.orientation == YAHOO.ext.SplitBar.HORIZONTAL){
            if(!YAHOO.util.Anim || !s.animate){
                s.resizingEl.setWidth(newSize);
                if(onComplete){
                    onComplete(s, newSize);
                }
            }else{
                s.resizingEl.setWidth(newSize, true, .1, onComplete, YAHOO.util.Easing.easeOut);
            }
        }else{
            
            if(!YAHOO.util.Anim || !s.animate){
                s.resizingEl.setHeight(newSize);
                if(onComplete){
                    onComplete(s, newSize);
                }
            }else{
                s.resizingEl.setHeight(newSize, true, .1, onComplete, YAHOO.util.Easing.easeOut);
            }
        }
    }
};


YAHOO.ext.SplitBar.AbsoluteLayoutAdapter = function(container){
    this.basic = new YAHOO.ext.SplitBar.BasicLayoutAdapter();
    this.container = getEl(container);
}

YAHOO.ext.SplitBar.AbsoluteLayoutAdapter.prototype = {
    init : function(s){
        this.basic.init(s);
        
    },
    
    getElementSize : function(s){
        return this.basic.getElementSize(s);
    },
    
    setElementSize : function(s, newSize, onComplete){
        this.basic.setElementSize(s, newSize, this.moveSplitter.createDelegate(this, [s]));
    },
    
    moveSplitter : function(s){
        var yes = YAHOO.ext.SplitBar;
        switch(s.placement){
            case yes.LEFT:
                s.el.setX(s.resizingEl.getRight());
                break;
            case yes.RIGHT:
                s.el.setStyle('right', (this.container.getWidth() - s.resizingEl.getLeft()) + 'px');
                break;
            case yes.TOP:
                s.el.setY(s.resizingEl.getBottom());
                break;
            case yes.BOTTOM:
                s.el.setY(s.resizingEl.getTop() - s.el.getHeight());
                break;
        }
    }
};


YAHOO.ext.SplitBar.VERTICAL = 1;


YAHOO.ext.SplitBar.HORIZONTAL = 2;


YAHOO.ext.SplitBar.LEFT = 1;


YAHOO.ext.SplitBar.RIGHT = 2;


YAHOO.ext.SplitBar.TOP = 3;


YAHOO.ext.SplitBar.BOTTOM = 4;


YAHOO.ext.grid.Grid = function(container, config, colModel, selectionModel){
	
	this.container = YAHOO.ext.Element.get(container);
	this.container.update('');
	this.container.setStyle('overflow', 'hidden');
	this.id = this.container.id;
	this.rows = [];
    this.rowCount = 0;
    this.fieldId = null;
    var dataModel = config; 
    this.dataModel = dataModel;
    this.colModel = colModel;
    this.selModel = selectionModel;
	this.activeEditor = null;
	this.editingCell = null;
	
	
	this.minColumnWidth = 25;
	
	
	this.autoSizeColumns = false;
	
	
	this.autoSizeHeaders = false;
	
	
	this.monitorWindowResize = true;
	
	
	this.maxRowsToMeasure = 0;
	
	
	this.trackMouseOver = false;
	
	
	this.enableDragDrop = false;
	
	
	this.stripeRows = true;
	
	this.autoHeight = false;
	
	
	this.autoWidth = false;
	
	
	this.view = null;
	
	
    this.allowTextSelectionPattern = /INPUT|TEXTAREA|SELECT/i;
	
	if(typeof config == 'object' && !config.getRowCount){
	    YAHOO.ext.util.Config.apply(this, config);
	}
	
	
	this.setValueDelegate = this.setCellValue.createDelegate(this);
	
	
	this.events = {
	    
	    
	    'click' : true,
	    
	    'dblclick' : true,
	    
	    'mousedown' : true,
	    
	    'mouseup' : true,
	    
	    'mouseover' : true,
	    
	    'mouseout' : true,
	    
	    'keypress' : true,
	    
	    'keydown' : true,
	    
	    
	    
	    
	    'cellclick' : true,
	    
	    'celldblclick' : true,
	    
	    'rowclick' : true,
	    
	    'rowdblclick' : true,
	    
	    'headerclick' : true,
	    
	    'rowcontextmenu' : true,
	    
	    'headercontextmenu' : true,
	    
	    'beforeedit' : true,
	    
	    'afteredit' : true,
	    
	    'bodyscroll' : true,
	    
	    'columnresize' : true,
	    
	    'startdrag' : true,
	    
	    'enddrag' : true,
	    
	    'dragdrop' : true,
	    
	    'dragover' : true,
	    
	    'dragenter' : true,
	    
	    'dragout' : true
	};
};

YAHOO.ext.grid.Grid.prototype = { 
    
    render : function(){
        if((!this.container.dom.offsetHeight || this.container.dom.offsetHeight < 20) 
                || this.container.getStyle('height') == 'auto'){
    	    this.autoHeight = true;   
    	}	       
    	if((!this.container.dom.offsetWidth || this.container.dom.offsetWidth < 20)){
    	    this.autoWidth = true;   
    	}	       
    	if(!this.view){
    	    if(this.dataModel.isPaged()){
    		    this.view = new YAHOO.ext.grid.PagedGridView();
    	    }else{
    	        this.view = new YAHOO.ext.grid.GridView();
    	    }
    	}
    	this.view.init(this);
        this.el = getEl(this.view.render(), true);
        var c = this.container;
        c.mon("click", this.onClick, this, true);
        c.mon("dblclick", this.onDblClick, this, true);
        c.mon("contextmenu", this.onContextMenu, this, true);
        c.mon("selectstart", this.cancelTextSelection, this, true);
        c.mon("mousedown", this.cancelTextSelection, this, true);
        c.mon("mousedown", this.onMouseDown, this, true);
        c.mon("mouseup", this.onMouseUp, this, true);
        if(this.trackMouseOver){
            this.el.mon("mouseover", this.onMouseOver, this, true);
            this.el.mon("mouseout", this.onMouseOut, this, true);
        }
        c.mon("keypress", this.onKeyPress, this, true);
        c.mon("keydown", this.onKeyDown, this, true);
        this.init();
        return this;
    },
    
    init : function(){
        this.rows = this.el.dom.rows;
        if(!this.disableSelection){
	        if(!this.selModel){
	            this.selModel = new YAHOO.ext.grid.DefaultSelectionModel(this);
	        }
	        this.selModel.init(this);
	        this.selModel.onSelectionChange.subscribe(this.updateField, this, true);
        }else{
            this.selModel = new YAHOO.ext.grid.DisableSelectionModel(this);
            this.selModel.init(this);
        }
        
        if(this.enableDragDrop){
            this.dd = new YAHOO.ext.grid.GridDD(this, this.container.dom);
        }
     },   

    
    reset : function(config){
        this.destroy(false, true);
        YAHOO.ext.util.Config.apply(this, config);
        return this;
    },
    
    
    destroy : function(removeEl, keepListeners){
        var c = this.container;
        c.removeAllListeners();
        this.view.destroy();
        YAHOO.ext.EventManager.removeResizeListener(this.view.onWindowResize, this.view);
        this.view = null;
        this.colModel.purgeListeners();
        if(!keepListeners){
            this.purgeListeners();
        }
        c.update('');
        if(removeEl === true){
            c.remove();
        }
    },
    
    
    setDataModel : function(dm, rerender){
        this.view.unplugDataModel(this.dataModel);
        this.dataModel = dm;
        this.view.plugDataModel(dm);
        if(rerender){
            dm.fireEvent('datachanged');
        }
    },
    
    onMouseDown : function(e){
        this.fireEvent('mousedown', e);
    },
    
    onMouseUp : function(e){
        this.fireEvent('mouseup', e);
    },
    
    onMouseOver : function(e){
        this.fireEvent('mouseover', e);
    },
    
    onMouseOut : function(e){
        this.fireEvent('mouseout', e);
    },
    
    onKeyPress : function(e){
        this.fireEvent('keypress', e);
    },
    
    onKeyDown : function(e){
        this.fireEvent('keydown', e);
    },
    
    fireEvent : YAHOO.ext.util.Observable.prototype.fireEvent,
    on : YAHOO.ext.util.Observable.prototype.on,
    addListener : YAHOO.ext.util.Observable.prototype.addListener,
    delayedListener : YAHOO.ext.util.Observable.prototype.delayedListener,
    removeListener : YAHOO.ext.util.Observable.prototype.removeListener,
    purgeListeners : YAHOO.ext.util.Observable.prototype.purgeListeners,
    bufferedListener : YAHOO.ext.util.Observable.prototype.bufferedListener,
    
    onClick : function(e){
        this.fireEvent('click', e);
        var target = e.getTarget();
        var row = this.getRowFromChild(target);
        var cell = this.getCellFromChild(target);
        var header = this.getHeaderFromChild(target);
        if(row){
            this.fireEvent('rowclick', this, row.rowIndex, e);
        }
        if(cell){
            this.fireEvent('cellclick', this, row.rowIndex, cell.columnIndex, e);
        }
        if(header){
            this.fireEvent('headerclick', this, header.columnIndex, e);
        }
    },

    onContextMenu : function(e){
        var target = e.getTarget();
        var row = this.getRowFromChild(target);
        var header = this.getHeaderFromChild(target);
        if(row){
            this.fireEvent('rowcontextmenu', this, row.rowIndex, e);
        }
        if(header){
            this.fireEvent('headercontextmenu', this, header.columnIndex, e);
        }
        e.preventDefault();
    },

    onDblClick : function(e){
        this.fireEvent('dblclick', e);
        var target = e.getTarget();
        var row = this.getRowFromChild(target);
        var cell = this.getCellFromChild(target);
        if(row){
            this.fireEvent('rowdblclick', this, row.rowIndex, e);
        }
        if(cell){
            this.fireEvent('celldblclick', this, row.rowIndex, cell.columnIndex, e);
        }
    },
    
    
    startEditing : function(rowIndex, colIndex){
        var row = this.rows[rowIndex];
        var cell = row.childNodes[colIndex];
        this.stopEditing();
        setTimeout(this.doEdit.createDelegate(this, [row, cell]), 10);
    },
        
    
    stopEditing : function(){
        if(this.activeEditor){
            this.activeEditor.stopEditing();
        }
    },
        
    
    doEdit : function(row, cell){
        if(!row || !cell) return;
        var cm = this.colModel;
        var dm = this.dataModel;
        var colIndex = cell.columnIndex;
        var rowIndex = row.rowIndex;
        if(cm.isCellEditable(colIndex, rowIndex)){
           var ed = cm.getCellEditor(colIndex, rowIndex);
           if(ed){
               if(this.activeEditor){
                   this.activeEditor.stopEditing();
               }
               this.fireEvent('beforeedit', this, rowIndex, colIndex);
               this.activeEditor = ed;
               this.editingCell = cell;
               this.view.ensureVisible(row, true);
               try{
                   cell.focus();
               }catch(e){}
               ed.init(this, this.el.dom.parentNode, this.setValueDelegate);
               var value = dm.getValueAt(rowIndex, cm.getDataIndex(colIndex));
               
               setTimeout(ed.startEditing.createDelegate(ed, [value, row, cell]), 1);
           }   
        }  
    },
    
    setCellValue : function(value, rowIndex, colIndex){
         this.dataModel.setValueAt(value, rowIndex, this.colModel.getDataIndex(colIndex));
         this.fireEvent('afteredit', this, rowIndex, colIndex);
    },
    
    
    cancelTextSelection : function(e){
        var target = e.getTarget();
        if(target && target != this.el.dom.parentNode && !this.allowTextSelectionPattern.test(target.tagName)){
            e.preventDefault();
        }
    },
    
    
    autoSize : function(){
        this.view.updateWrapHeight();
        this.view.adjustForScroll();
    },
    
    
    scrollTo : function(row){
        if(typeof row == 'number'){
            row = this.rows[row];
        }
        this.view.ensureVisible(row, true);
    },
    
    
    getEditingCell : function(){
        return this.editingCell;    
    },
    
    
    bindToField : function(fieldId){
        this.fieldId = fieldId;
        this.readField();
    },
    
    
    updateField : function(){
        if(this.fieldId){
            var field = YAHOO.util.Dom.get(this.fieldId);
            field.value = this.getSelectedRowIds().join(',');
        }
    },
    
    
    readField : function(){
        if(this.fieldId){
            var field = YAHOO.util.Dom.get(this.fieldId);
            var values = field.value.split(',');
            var rows = this.getRowsById(values);
            this.selModel.selectRows(rows, false);
        }
    },
	
	
    getRow : function(index){
        return this.rows[index];
    },
	
	
    getRowsById : function(id){
        var dm = this.dataModel;
        if(!(id instanceof Array)){
            for(var i = 0; i < this.rows.length; i++){
                if(dm.getRowId(i) == id){
                    return this.rows[i];
                }
            }
            return null;
        }
        var found = [];
        var re = "^(?:";
        for(var i = 0; i < id.length; i++){
            re += id[i];
            if(i != id.length-1) re += "|";
        }
        var regex = new RegExp(re + ")$");
        for(var i = 0; i < this.rows.length; i++){
            if(regex.test(dm.getRowId(i))){
                found.push(this.rows[i]);
            }
        }
        return found;
    },
    
    
    getRowAfter : function(row){
        return this.getSibling('next', row);
    },
    
    
    getRowBefore : function(row){
        return this.getSibling('previous', row);
    },
    
    
    getCellAfter : function(cell, includeHidden){
        var next = this.getSibling('next', cell);
        if(next && !includeHidden && this.colModel.isHidden(next.columnIndex)){
            return this.getCellAfter(next);
        }
        return next;
    },
    
    
    getCellBefore : function(cell, includeHidden){
        var prev = this.getSibling('previous', cell);
        if(prev && !includeHidden && this.colModel.isHidden(prev.columnIndex)){
            return this.getCellBefore(prev);
        }
        return prev;
    },
    
    
    getLastCell : function(row, includeHidden){
        var cell = this.getElement('previous', row.lastChild);
        if(cell && !includeHidden && this.colModel.isHidden(cell.columnIndex)){
            return this.getCellBefore(cell);
        }
        return cell;
    },
    
    
    getFirstCell : function(row, includeHidden){
        var cell = this.getElement('next', row.firstChild);
        if(cell && !includeHidden && this.colModel.isHidden(cell.columnIndex)){
            return this.getCellAfter(cell);
        }
        return cell;
    },
    
    
    getSibling : function(type, node){
        if(!node) return null;
        type += 'Sibling';
        var n = node[type];
        while(n && n.nodeType != 1){
            n = n[type];
        }
        return n;
    },
    
    
    getElement : function(direction, node){
        if(!node || node.nodeType == 1) return node;
        else return this.getSibling(direction, node);
    },
    
    
    getElementFromChild : function(childEl, parentClass){
        if(!childEl || (YAHOO.util.Dom.hasClass(childEl, parentClass))){
		    return childEl;
	    }
	    var p = childEl.parentNode;
	    var b = document.body;
	    while(p && p != b){
            if(YAHOO.util.Dom.hasClass(p, parentClass)){
            	return p;
            }
            p = p.parentNode;
        }
	    return null;
    },
    
    
    getRowFromChild : function(childEl){
        return this.getElementFromChild(childEl, 'ygrid-row');
    },
    
    
    getCellFromChild : function(childEl){
        return this.getElementFromChild(childEl, 'ygrid-col');
    },
    
    
    
     getHeaderFromChild : function(childEl){
        return this.getElementFromChild(childEl, 'ygrid-hd');
    },
    
    
    getSelectedRows : function(){
        return this.selModel.getSelectedRows();
    },
    
    
    getSelectedRow : function(){
        if(this.selModel.hasSelection()){
            return this.selModel.getSelectedRows()[0];
        }
        return null;
    },
    
    
    getSelectedRowIndexes : function(){
        var a = [];
        var rows = this.selModel.getSelectedRows();
        for(var i = 0; i < rows.length; i++) {
        	a[i] = rows[i].rowIndex;
        }
        return a;
    },
    
    
    getSelectedRowIndex : function(){
        if(this.selModel.hasSelection()){
           return this.selModel.getSelectedRows()[0].rowIndex;
        }
        return -1;
    },
    
    
    getSelectedRowId : function(){
        if(this.selModel.hasSelection()){
           return this.selModel.getSelectedRowIds()[0];
        }
        return null;
    },
    
    
    getSelectedRowIds : function(){
        return this.selModel.getSelectedRowIds();
    },
    
    
    clearSelections : function(){
        this.selModel.clearSelections();
    },
    
        
    
    selectAll : function(){
        this.selModel.selectAll();
    },
    
        
    
    getSelectionCount : function(){
        return this.selModel.getCount();
    },
    
    
    hasSelection : function(){
        return this.selModel.hasSelection();
    },
    
    
    getSelectionModel : function(){
        if(!this.selModel){
            this.selModel = new DefaultSelectionModel();
        }
        return this.selModel;
    },
    
    
    getDataModel : function(){
        return this.dataModel;
    },
    
    
    getColumnModel : function(){
        return this.colModel;
    },
    
    
    getView : function(){
        return this.view;
    },
    
    getDragDropText : function(){
        return this.ddText.replace('%0', this.selModel.getCount());
    }
};

YAHOO.ext.grid.Grid.prototype.ddText = "%0 selected row(s)";


if(YAHOO.util.DDProxy){

YAHOO.ext.grid.GridDD = function(grid, bwrap){
    this.grid = grid;
    var ddproxy = document.createElement('div');
    ddproxy.id = grid.container.id + '-ddproxy';
    ddproxy.className = 'ygrid-drag-proxy';
    document.body.insertBefore(ddproxy, document.body.firstChild);
    YAHOO.util.Dom.setStyle(ddproxy, 'opacity', .80);
    var ddicon = document.createElement('span');
    ddicon.className = 'ygrid-drop-icon ygrid-drop-nodrop';
    ddproxy.appendChild(ddicon);
    var ddtext = document.createElement('span');
    ddtext.className = 'ygrid-drag-text';
    ddtext.innerHTML = "&#160;";
    ddproxy.appendChild(ddtext);
    
    this.ddproxy = ddproxy;
    this.ddtext = ddtext;
    this.ddicon = ddicon;
    YAHOO.util.Event.on(bwrap, 'click', this.handleClick, this, true);
    YAHOO.ext.grid.GridDD.superclass.constructor.call(this, bwrap.id, 'GridDD', 
          {dragElId : ddproxy.id, resizeFrame: false});
          
    this.unlockDelegate = grid.selModel.unlock.createDelegate(grid.selModel);
};
YAHOO.extendX(YAHOO.ext.grid.GridDD, YAHOO.util.DDProxy);

YAHOO.ext.grid.GridDD.prototype.handleMouseDown = function(e){
    var row = this.grid.getRowFromChild(YAHOO.util.Event.getTarget(e));
    if(!row) return;
    if(this.grid.selModel.isSelected(row)){
        YAHOO.ext.grid.GridDD.superclass.handleMouseDown.call(this, e);
    }else {
        this.grid.selModel.unlock();
        YAHOO.ext.EventObject.setEvent(e);
        this.grid.selModel.rowClick(this.grid, row.rowIndex, YAHOO.ext.EventObject);
        YAHOO.ext.grid.GridDD.superclass.handleMouseDown.call(this, e);
        this.grid.selModel.lock();
    }
};

YAHOO.ext.grid.GridDD.prototype.handleClick = function(e){
    if(this.grid.selModel.isLocked()){
         setTimeout(this.unlockDelegate, 1);
         YAHOO.util.Event.stopEvent(e);
    }
};


YAHOO.ext.grid.GridDD.prototype.setDropStatus = function(dropStatus){
    if(dropStatus === true){
        YAHOO.util.Dom.replaceClass(this.ddicon, 'ygrid-drop-nodrop', 'ygrid-drop-ok');
    }else{
        YAHOO.util.Dom.replaceClass(this.ddicon, 'ygrid-drop-ok', 'ygrid-drop-nodrop');
    }
};

YAHOO.ext.grid.GridDD.prototype.startDrag = function(e){
    this.ddtext.innerHTML = this.grid.getDragDropText();
    this.setDropStatus(false);
    this.grid.selModel.lock();
    this.grid.fireEvent('startdrag', this.grid, this, e);
};
       
YAHOO.ext.grid.GridDD.prototype.endDrag = function(e){
    YAHOO.util.Dom.setStyle(this.ddproxy, 'visibility', 'hidden');
    this.grid.fireEvent('enddrag', this.grid, this, e);
};

YAHOO.ext.grid.GridDD.prototype.autoOffset = function(iPageX, iPageY) {
    this.setDelta(-12, -20);
};

YAHOO.ext.grid.GridDD.prototype.onDragEnter = function(e, id) {
    this.setDropStatus(true);
    this.grid.fireEvent('dragenter', this.grid, this, id, e);
};

YAHOO.ext.grid.GridDD.prototype.onDragDrop = function(e, id) {
    this.grid.fireEvent('dragdrop', this.grid, this, id, e);
};

YAHOO.ext.grid.GridDD.prototype.onDragOver = function(e, id) {
    this.grid.fireEvent('dragover', this.grid, this, id, e);
};

YAHOO.ext.grid.GridDD.prototype.onDragOut = function(e, id) {
    this.setDropStatus(false);
    this.grid.fireEvent('dragout', this.grid, this, id, e);
};
};

YAHOO.ext.grid.GridView = function(){
	this.grid = null;
	this.lastFocusedRow = null;
	this.onScroll = new YAHOO.util.CustomEvent('onscroll');
	this.adjustScrollTask = new YAHOO.ext.util.DelayedTask(this._adjustForScroll, this);
	this.ensureVisibleTask = new YAHOO.ext.util.DelayedTask();
};

YAHOO.ext.grid.GridView.prototype = {
	init: function(grid){
		this.grid = grid;
	},
	
	fireScroll: function(scrollLeft, scrollTop){
		this.onScroll.fireDirect(this.grid, scrollLeft, scrollTop);
	},
	
	
	getColumnRenderers : function(){
    	var renderers = [];
    	var cm = this.grid.colModel;
        var colCount = cm.getColumnCount();
        for(var i = 0; i < colCount; i++){
            renderers.push(cm.getRenderer(i));
        }
        return renderers;
    },
    
    buildIndexMap : function(){
        var colToData = {};
        var dataToCol = {};
        var cm = this.grid.colModel;
        for(var i = 0, len = cm.getColumnCount(); i < len; i++){
            var di = cm.getDataIndex(i);
            colToData[i] = di;
            dataToCol[di] = i;
        }
        return {'colToData': colToData, 'dataToCol': dataToCol};
    },
    
    getDataIndexes : function(){
    	if(!this.indexMap){
            this.indexMap = this.buildIndexMap();
        }
        return this.indexMap.colToData;
    },
    
    getColumnIndexByDataIndex : function(dataIndex){
        if(!this.indexMap){
            this.indexMap = this.buildIndexMap();
        }
    	return this.indexMap.dataToCol[dataIndex];
    },
    
    updateHeaders : function(){
        var colModel = this.grid.colModel;
        var hcells = this.headers;
        var colCount = colModel.getColumnCount();
        for(var i = 0; i < colCount; i++){
            hcells[i].textNode.innerHTML = colModel.getColumnHeader(i);
        }
    },
    
    adjustForScroll : function(disableDelay){
        if(!disableDelay){
            this.adjustScrollTask.delay(50);
        }else{
            this._adjustForScroll();
        }
    },
    
    
     getCellAtPoint : function(x, y){
        var colIndex = null;        
        var rowIndex = null;
        
        
        var xy = YAHOO.util.Dom.getXY(this.wrap);
        x = (x - xy[0]) + this.wrap.scrollLeft;
        y = (y - xy[1]) + this.wrap.scrollTop;
        
        var colModel = this.grid.colModel;
        var pos = 0;
        var colCount = colModel.getColumnCount();
        for(var i = 0; i < colCount; i++){
            if(colModel.isHidden(i)) continue;
            var width = colModel.getColumnWidth(i);
            if(x >= pos && x < pos+width){
                colIndex = i;
                break;
            }
            pos += width;
        }
        if(colIndex != null){
            rowIndex = (y == 0 ? 0 : Math.floor(y / this.getRowHeight()));
            if(rowIndex >= this.grid.dataModel.getRowCount()){
                return null;
            }
            return [colIndex, rowIndex];
        }
        return null;
    },
    
    
    _adjustForScroll : function(){
        this.forceScrollUpdate();
        if(this.scrollbarMode == YAHOO.ext.grid.GridView.SCROLLBARS_OVERLAP){
            var adjustment = 0;
            if(this.wrap.clientWidth && this.wrap.clientWidth !== 0){
                adjustment = this.wrap.offsetWidth - this.wrap.clientWidth;
            }
            this.hwrap.setWidth(this.wrap.offsetWidth-adjustment);
        }else{
            this.hwrap.setWidth(this.wrap.offsetWidth);
        }
        this.bwrap.setWidth(Math.max(this.grid.colModel.getTotalWidth(), this.wrap.clientWidth));
    },

    
     focusRow : function(row){
        if(typeof row == 'number'){
            row = this.getBodyTable().childNodes[row];
        }
        if(!row) return;
    	var left = this.wrap.scrollLeft;
    	try{ 
    	    row.childNodes.item(0).hideFocus = true;
        	row.childNodes.item(0).focus();
        }catch(e){}
        this.ensureVisible(row);
        this.wrap.scrollLeft = left;
        this.handleScroll();
        this.lastFocusedRow = row;
    },

    
     ensureVisible : function(row, disableDelay){
        if(!disableDelay){
            this.ensureVisibleTask.delay(50, this._ensureVisible, this, [row]);
        }else{
            this._ensureVisible(row);
        }
    },

    
    _ensureVisible : function(row){
        if(typeof row == 'number'){
            row = this.getBodyTable().childNodes[row];
        }
        if(!row) return;
    	var left = this.wrap.scrollLeft;
    	var rowTop = parseInt(row.offsetTop, 10); 
        var rowBottom = rowTop + row.offsetHeight;
        var clientTop = parseInt(this.wrap.scrollTop, 10); 
        var clientBottom = clientTop + this.wrap.clientHeight;
        if(rowTop < clientTop){
        	this.wrap.scrollTop = rowTop;
        }else if(rowBottom > clientBottom){
            this.wrap.scrollTop = rowBottom-this.wrap.clientHeight;
        }
        this.wrap.scrollLeft = left;
        this.handleScroll();
    },
    
    updateColumns : function(){
        this.grid.stopEditing();
        var colModel = this.grid.colModel;
        var hcols = this.headers;
        var colCount = colModel.getColumnCount();
        var pos = 0;
        var totalWidth = colModel.getTotalWidth();
        for(var i = 0; i < colCount; i++){
            if(colModel.isHidden(i)) continue;
            var width = colModel.getColumnWidth(i);
            hcols[i].style.width = width + 'px';
            hcols[i].style.left = pos + 'px';
            hcols[i].split.style.left = (pos+width-3) + 'px';
            this.setCSSWidth(i, width, pos);
            pos += width;
        }
        this.lastWidth = totalWidth;
        if(this.grid.autoWidth){
            this.grid.container.setWidth(totalWidth+this.grid.container.getBorderWidth('lr'));
            this.grid.autoSize();
        }
        this.bwrap.setWidth(Math.max(totalWidth, this.wrap.clientWidth));
        if(!YAHOO.ext.util.Browser.isIE){ 
        	this.wrap.scrollLeft = this.hwrap.dom.scrollLeft;
        }
        this.syncScroll();
        this.forceScrollUpdate();
        if(this.grid.autoHeight){
            this.autoHeight();
            this.updateWrapHeight();
        }
    },
    
    setCSSWidth : function(colIndex, width, pos){
        var selector = ["#" + this.grid.id + " .ygrid-col-" + colIndex, ".ygrid-col-" + colIndex];
        YAHOO.ext.util.CSS.updateRule(selector, 'width', width + 'px');
        if(typeof pos == 'number'){
            YAHOO.ext.util.CSS.updateRule(selector, 'left', pos + 'px');
        }
    },
    
    
     setCSSStyle : function(colIndex, name, value){
        var selector = ["#" + this.grid.id + " .ygrid-col-" + colIndex, ".ygrid-col-" + colIndex];
        YAHOO.ext.util.CSS.updateRule(selector, name, value);
    },
    
    handleHiddenChange : function(colModel, colIndex, hidden){
        if(hidden){
            this.hideColumn(colIndex);
        }else{
            this.unhideColumn(colIndex);
        }
        this.updateColumns();
    },
    
    hideColumn : function(colIndex){
        var selector = ["#" + this.grid.id + " .ygrid-col-" + colIndex, ".ygrid-col-" + colIndex];
        YAHOO.ext.util.CSS.updateRule(selector, 'position', 'absolute');
        YAHOO.ext.util.CSS.updateRule(selector, 'visibility', 'hidden');
        
        this.headers[colIndex].style.display = 'none';
        this.headers[colIndex].split.style.display = 'none';
    },
    
    unhideColumn : function(colIndex){
        var selector = ["#" + this.grid.id + " .ygrid-col-" + colIndex, ".ygrid-col-" + colIndex];
        YAHOO.ext.util.CSS.updateRule(selector, 'position', '');
        YAHOO.ext.util.CSS.updateRule(selector, 'visibility', 'visible');
        
        this.headers[colIndex].style.display = '';
        this.headers[colIndex].split.style.display = '';
    },
    
    getBodyTable : function(){
    	return this.bwrap.dom;
    },
    
    updateRowIndexes : function(firstRow, lastRow){
        var stripeRows = this.grid.stripeRows;
        var bt = this.getBodyTable();
        var nodes = bt.childNodes;
        firstRow = firstRow || 0;
        lastRow = lastRow || nodes.length-1;
        var re = /^(?:ygrid-row ygrid-row-alt|ygrid-row)/;
        for(var rowIndex = firstRow; rowIndex <= lastRow; rowIndex++){
            var node = nodes[rowIndex];
            if(stripeRows && (rowIndex+1) % 2 == 0){
        		node.className = node.className.replace(re, 'ygrid-row ygrid-row-alt');
        	}else{
        		node.className = node.className.replace(re, 'ygrid-row');
        	}
            node.rowIndex = rowIndex;
            nodes[rowIndex].style.top = (rowIndex * this.rowHeight) + 'px';
        }
    },

    insertRows : function(dataModel, firstRow, lastRow){
        this.updateBodyHeight();
        this.adjustForScroll(true);
        var renderers = this.getColumnRenderers();
        var dindexes = this.getDataIndexes();
        var colCount = this.grid.colModel.getColumnCount();
        var beforeRow = null;
        var bt = this.getBodyTable();
        if(firstRow < bt.childNodes.length){
            beforeRow = bt.childNodes[firstRow];
        }
        for(var rowIndex = firstRow; rowIndex <= lastRow; rowIndex++){
            var row = document.createElement('span');
            row.className = 'ygrid-row';
            row.style.top = (rowIndex * this.rowHeight) + 'px';
            this.renderRow(dataModel, row, rowIndex, colCount, renderers, dindexes);
            if(beforeRow){
            	bt.insertBefore(row, beforeRow);
            }else{
                bt.appendChild(row);
            }
        }
        this.updateRowIndexes(firstRow);
        this.adjustForScroll(true);
    },
    
    renderRow : function(dataModel, row, rowIndex, colCount, renderers, dindexes){
        for(var colIndex = 0; colIndex < colCount; colIndex++){
            var td = document.createElement('span');
            td.className = 'ygrid-col ygrid-col-' + colIndex + (colIndex == colCount-1 ? ' ygrid-col-last' : '');
            td.columnIndex = colIndex;
            td.tabIndex = 0;
            var span = document.createElement('span');
            span.className = 'ygrid-cell-text';
            td.appendChild(span);
            var val = renderers[colIndex](dataModel.getValueAt(rowIndex, dindexes[colIndex]), rowIndex, colIndex, td);
            if(typeof val == 'undefined' || val === '') val = '&#160;';
            span.innerHTML = val;
            row.appendChild(td);
        }
    },
    
    deleteRows : function(dataModel, firstRow, lastRow){
        this.updateBodyHeight();
        
        this.grid.selModel.deselectRange(firstRow, lastRow);
        var bt = this.getBodyTable();
        var rows = []; 
        for(var rowIndex = firstRow; rowIndex <= lastRow; rowIndex++){
            rows.push(bt.childNodes[rowIndex]);
        }
        for(var i = 0; i < rows.length; i++){
            bt.removeChild(rows[i]);
            rows[i] = null;
        }
        rows = null;
        this.updateRowIndexes(firstRow);
        this.adjustForScroll();
    },
    
    updateRows : function(dataModel, firstRow, lastRow){
        var bt = this.getBodyTable();
        var dindexes = this.getDataIndexes();
        var renderers = this.getColumnRenderers();
        var colCount = this.grid.colModel.getColumnCount();
        for(var rowIndex = firstRow; rowIndex <= lastRow; rowIndex++){
            var row = bt.rows[rowIndex];
            var cells = row.childNodes;
            for(var colIndex = 0; colIndex < colCount; colIndex++){
                var td = cells[colIndex];
                var val = renderers[colIndex](dataModel.getValueAt(rowIndex, dindexes[colIndex]), rowIndex, colIndex, td);
                if(typeof val == 'undefined' || val === '') val = '&#160;';
                td.firstChild.innerHTML = val;
            }
        }
    },
    
    handleSort : function(dataModel, sortColumnIndex, sortDir, noRefresh){
        this.grid.selModel.syncSelectionsToIds();
        if(!noRefresh){
           this.updateRows(dataModel, 0, dataModel.getRowCount()-1);
        }
        this.updateHeaderSortState();
        if(this.lastFocusedRow){
            this.focusRow(this.lastFocusedRow);
        }
    },
    
    syncScroll : function(){
        this.hwrap.dom.scrollLeft = this.wrap.scrollLeft;
    },
    
    handleScroll : function(){
        this.syncScroll();
        this.fireScroll(this.wrap.scrollLeft, this.wrap.scrollTop);
        this.grid.fireEvent('bodyscroll', this.wrap.scrollLeft, this.wrap.scrollTop);
    },
    
    getRowHeight : function(){
        if(!this.rowHeight){
            var rule = YAHOO.ext.util.CSS.getRule(["#" + this.grid.id + " .ygrid-row", ".ygrid-row"]);
        	if(rule && rule.style.height){
        	    this.rowHeight = parseInt(rule.style.height, 10);
        	}else{
        	    this.rowHeight = 21;
        	}
        }
        return this.rowHeight;
    },
    
    renderRows : function(dataModel){
        this.grid.stopEditing();
        if(this.grid.selModel){
            this.grid.selModel.clearSelections();
        }
    	var bt = this.getBodyTable();
    	bt.innerHTML = '';
    	this.rowHeight = this.getRowHeight();
    	this.insertRows(dataModel, 0, dataModel.getRowCount()-1);
    },
    
    updateCell : function(dataModel, rowIndex, dataIndex){
        var colIndex = this.getColumnIndexByDataIndex(dataIndex);
        if(typeof colIndex == 'undefined'){ 
            return;
        }
        var bt = this.getBodyTable();
        var row = bt.childNodes[rowIndex];
        var cell = row.childNodes[colIndex];
        var renderer = this.grid.colModel.getRenderer(colIndex);
        var val = renderer(dataModel.getValueAt(rowIndex, dataIndex), rowIndex, colIndex, cell);
        if(typeof val == 'undefined' || val === '') val = '&#160;';
        cell.firstChild.innerHTML = val;
    },
    
    calcColumnWidth : function(colIndex, maxRowsToMeasure){
        var maxWidth = 0;
        var bt = this.getBodyTable();
        var rows = bt.childNodes;
        var stopIndex = Math.min(maxRowsToMeasure || rows.length, rows.length);
        if(this.grid.autoSizeHeaders){
            var h = this.headers[colIndex];
            var curWidth = h.style.width;
            h.style.width = this.grid.minColumnWidth+'px';
            maxWidth = Math.max(maxWidth, h.scrollWidth);
            h.style.width = curWidth;
        }
        for(var i = 0; i < stopIndex; i++){
            var cell = rows[i].childNodes[colIndex].firstChild;
            maxWidth = Math.max(maxWidth, cell.scrollWidth);
        }
        return maxWidth +  5;
    },
    
    
     autoSizeColumn : function(colIndex, forceMinSize){
        if(forceMinSize){
           this.setCSSWidth(colIndex, this.grid.minColumnWidth);
        }
        var newWidth = this.calcColumnWidth(colIndex);
        this.grid.colModel.setColumnWidth(colIndex,
            Math.max(this.grid.minColumnWidth, newWidth));
        this.grid.fireEvent('columnresize', colIndex, newWidth);
    },
    
    
     autoSizeColumns : function(){
        var colModel = this.grid.colModel;
        var colCount = colModel.getColumnCount();
        var wrap = this.wrap;
        for(var i = 0; i < colCount; i++){
            this.setCSSWidth(i, this.grid.minColumnWidth);
            colModel.setColumnWidth(i, this.calcColumnWidth(i, this.grid.maxRowsToMeasure), true);
        }
        if(colModel.getTotalWidth() < wrap.clientWidth){
            var diff = Math.floor((wrap.clientWidth - colModel.getTotalWidth()) / colCount);
            for(var i = 0; i < colCount; i++){
                colModel.setColumnWidth(i, colModel.getColumnWidth(i) + diff, true);
            }
        }
        this.updateColumns();  
    },
    
    
    fitColumns : function(){
        var cm = this.grid.colModel;
        var colCount = cm.getColumnCount();
        var cols = [];
        var width = 0;
        var i, w;
        for (i = 0; i < colCount; i++){
            if(!cm.isHidden(i) && !cm.isFixed(i)){
                w = cm.getColumnWidth(i);
                cols.push(i);
                cols.push(w);
                width += w;
            }
        }
        var frac = (this.wrap.clientWidth - cm.getTotalWidth())/width;
        while (cols.length){
            w = cols.pop();
            i = cols.pop();
            cm.setColumnWidth(i, Math.floor(w + w*frac), true);
        }
        this.updateColumns();
    }, 
    
    onWindowResize : function(){
        if(this.grid.monitorWindowResize){
            this.adjustForScroll();
            this.updateWrapHeight();
            this.adjustForScroll();
        }  
    },
    
    updateWrapHeight : function(){
        this.grid.container.beginMeasure();
        this.autoHeight();
        var box = this.grid.container.getSize(true);
        this.wrapEl.setHeight(box.height-this.footerHeight-parseInt(this.wrap.offsetTop, 10));
        this.pwrap.setSize(box.width, box.height);
        this.grid.container.endMeasure();
    },
    
    forceScrollUpdate : function(){
        var wrap = this.wrapEl;
        wrap.setWidth(wrap.getWidth(true));
        setTimeout(function(){ 
            wrap.setWidth('');
        }, 1);
    },
    
    updateHeaderSortState : function(){
        var state = this.grid.dataModel.getSortState();
        if(!state || typeof state.column == 'undefined') return;
        var sortColumn = this.getColumnIndexByDataIndex(state.column);
        var sortDir = state.direction;
        for(var i = 0, len = this.headers.length; i < len; i++){
            var h = this.headers[i];
            if(i != sortColumn){
                h.sortDesc.style.display = 'none';
                h.sortAsc.style.display = 'none';
            }else{
                h.sortDesc.style.display = sortDir == 'DESC' ? 'block' : 'none';
                h.sortAsc.style.display = sortDir == 'ASC' ? 'block' : 'none';
            }
        }
    },

    unplugDataModel : function(dm){
        dm.removeListener('cellupdated', this.updateCell, this);
        dm.removeListener('datachanged', this.renderRows, this);
        dm.removeListener('rowsdeleted', this.deleteRows, this);
        dm.removeListener('rowsinserted', this.insertRows, this);
        dm.removeListener('rowsupdated', this.updateRows, this);
        dm.removeListener('rowssorted', this.handleSort, this);
    },
    
    plugDataModel : function(dm){
        dm.on('cellupdated', this.updateCell, this, true);
        dm.on('datachanged', this.renderRows, this, true);
        dm.on('rowsdeleted', this.deleteRows, this, true);
        dm.on('rowsinserted', this.insertRows, this, true);
        dm.on('rowsupdated', this.updateRows, this, true);
        dm.on('rowssorted', this.handleSort, this, true);
    },
    
    destroy : function(){
        this.unplugDataModel(this.grid.dataModel);
        var sp = this.splitters;
        if(sp){
            for(var i in sp){
                if(sp[i] && typeof sp[i] != 'function'){
                    sp[i].destroy(true);
                }
            }
        }
    },
    
    render : function(){
        var grid = this.grid;
        var container = grid.container.dom;
        var dataModel = grid.dataModel;
        this.plugDataModel(dataModel);
    
        var colModel = grid.colModel;
        colModel.onWidthChange.subscribe(this.updateColumns, this, true);
        colModel.onHeaderChange.subscribe(this.updateHeaders, this, true);
        colModel.onHiddenChange.subscribe(this.handleHiddenChange, this, true);
        
        if(grid.monitorWindowResize === true){
            YAHOO.ext.EventManager.onWindowResize(this.onWindowResize, this, true);
        }
        var autoSizeDelegate = this.autoSizeColumn.createDelegate(this);
        
        var colCount = colModel.getColumnCount();
        
        var dh = YAHOO.ext.DomHelper;
        this.pwrap = dh.append(container, 
            {tag: 'div', cls: 'ygrid-positioner', 
            style: 'position:relative;width:100%;height:100%;left:0;top:0;overflow:hidden;'}, true);
        var pos = this.pwrap.dom;
        
        
        var wrap = dh.append(pos, {tag: 'div', cls: 'ygrid-wrap'});
        this.wrap = wrap;
        this.wrapEl = getEl(wrap, true);
        YAHOO.ext.EventManager.on(wrap, 'scroll', this.handleScroll, this, true);
        
        var hwrap = dh.append(pos, {tag: 'div', cls: 'ygrid-wrap-headers'});
        this.hwrap = getEl(hwrap, true);
        
        var bwrap = dh.append(wrap, {tag: 'div', cls: 'ygrid-wrap-body', id: container.id + '-body'});
        this.bwrap = getEl(bwrap, true);
        this.bwrap.setWidth(colModel.getTotalWidth());
        bwrap.rows = bwrap.childNodes;
        
        this.footerHeight = 0;
        var foot = this.appendFooter(this.pwrap.dom);
        if(foot){
            this.footer = getEl(foot, true);
            this.footerHeight = this.footer.getHeight();
        }
        this.updateWrapHeight();
        
        var hrow = dh.append(hwrap, {tag: 'span', cls: 'ygrid-hrow'});
        this.hrow = hrow;
        
        if(!YAHOO.ext.util.Browser.isGecko){
            
            var iframe = document.createElement('iframe');
            iframe.className = 'ygrid-hrow-frame';
            iframe.frameBorder = 0;
            iframe.src = YAHOO.ext.SSL_SECURE_URL;
            hwrap.appendChild(iframe);
        }
        this.headerCtrl = new YAHOO.ext.grid.HeaderController(this.grid);
        this.headers = [];
        this.cols = [];
        this.splitters = [];
        
        var htemplate = dh.createTemplate({
           tag: 'span', cls: 'ygrid-hd ygrid-header-{0}', children: [{
                tag: 'span',
                cls: 'ygrid-hd-body',
                html: '<table border="0" cellpadding="0" cellspacing="0" title="{2}">' +
                      '<tbody><tr><td><span>{1}</span></td>' +
                      '<td><span class="sort-desc"></span><span class="sort-asc"></span></td>' +
                      '</tr></tbody></table>'
           }]
        });
        htemplate.compile();
        for(var i = 0; i < colCount; i++){
            var hd = htemplate.append(hrow, [i, colModel.getColumnHeader(i), colModel.getColumnTooltip(i) || '']);
            var spans = hd.getElementsByTagName('span');
            hd.textNode = spans[1];
            hd.sortDesc = spans[2];
            hd.sortAsc = spans[3];
    	    hd.columnIndex = i;
            this.headers.push(hd);
            if(colModel.isSortable(i)){
                this.headerCtrl.register(hd);
            }
            var split = dh.append(hrow, {tag: 'span', cls: 'ygrid-hd-split'});
            hd.split = split;
        	
        	if(colModel.isResizable(i) && !colModel.isFixed(i)){
            	YAHOO.util.Event.on(split, 'dblclick', autoSizeDelegate.createCallback(i+0, true));
            	var sb = new YAHOO.ext.SplitBar(split, hd, null, YAHOO.ext.SplitBar.LEFT);
            	sb.columnIndex = i;
            	sb.minSize = grid.minColumnWidth;
            	sb.onMoved.subscribe(this.onColumnSplitterMoved, this, true);
            	YAHOO.util.Dom.addClass(sb.proxy, 'ygrid-column-sizer');
            	YAHOO.util.Dom.setStyle(sb.proxy, 'background-color', '');
            	sb.dd._resizeProxy = function(){
            	    var el = this.getDragEl();
            	    YAHOO.util.Dom.setStyle(el, 'height', (hwrap.clientHeight+wrap.clientHeight-2) +'px');
            	};
            	this.splitters[i] = sb;
        	}else{
        	    split.style.cursor = 'default';
        	}
        }
       if(grid.autoSizeColumns){
            this.renderRows(dataModel);
            this.autoSizeColumns();
        }else{
            this.updateColumns();
            this.renderRows(dataModel);
        }
        
        for(var i = 0; i < colCount; i++){
            if(colModel.isHidden(i)){
                this.hideColumn(i);
            }
        }
        this.updateHeaderSortState();
        return this.bwrap;
    },
    
    onColumnSplitterMoved : function(splitter, newSize){
        this.grid.colModel.setColumnWidth(splitter.columnIndex, newSize);
        this.grid.fireEvent('columnresize', splitter.columnIndex, newSize);
    },
    
    appendFooter : function(parentEl){
        return null;  
    },
    
    autoHeight : function(){
        if(this.grid.autoHeight){
            var h = this.getBodyHeight();
            var c = this.grid.container;
            var total = h + (parseInt(this.wrap.offsetTop, 10)||0) + 
                    this.footerHeight + c.getBorderWidth('tb') + c.getPadding('tb')
                    + (this.wrap.offsetHeight - this.wrap.clientHeight);
            c.setHeight(total);
            
        }
    },
    
    getBodyHeight : function(){
        return this.grid.dataModel.getRowCount() * this.getRowHeight();;
    },
    
    updateBodyHeight : function(){
        this.getBodyTable().style.height = this.getBodyHeight() + 'px';
        if(this.grid.autoHeight){
            this.autoHeight();
            this.updateWrapHeight();
        }
    }
};
YAHOO.ext.grid.GridView.SCROLLBARS_UNDER = 0;
YAHOO.ext.grid.GridView.SCROLLBARS_OVERLAP = 1;
YAHOO.ext.grid.GridView.prototype.scrollbarMode = YAHOO.ext.grid.GridView.SCROLLBARS_UNDER;

YAHOO.ext.grid.GridView.prototype.fitColumnsToContainer = YAHOO.ext.grid.GridView.prototype.fitColumns;

YAHOO.ext.grid.HeaderController = function(grid){
	this.grid = grid;
	this.headers = [];
};

YAHOO.ext.grid.HeaderController.prototype = {
	register : function(header){
		this.headers.push(header);
		YAHOO.ext.EventManager.on(header, 'selectstart', this.cancelTextSelection, this, true);
        YAHOO.ext.EventManager.on(header, 'mousedown', this.cancelTextSelection, this, true);
        YAHOO.ext.EventManager.on(header, 'mouseover', this.headerOver, this, true);
        YAHOO.ext.EventManager.on(header, 'mouseout', this.headerOut, this, true);
        YAHOO.ext.EventManager.on(header, 'click', this.headerClick, this, true);
	},
	
	headerClick : function(e){
	    var grid = this.grid, cm = grid.colModel, dm = grid.dataModel;
	    grid.stopEditing();
        var header = grid.getHeaderFromChild(e.getTarget());
        var state = dm.getSortState();
        var direction = header.sortDir || 'ASC';
        if(typeof state.column != 'undefined' && 
                 grid.getView().getColumnIndexByDataIndex(state.column) == header.columnIndex){
            direction = (state.direction == 'ASC' ? 'DESC' : 'ASC');
        }
        header.sortDir = direction;
        dm.sort(cm, cm.getDataIndex(header.columnIndex), direction);
    },
    
    headerOver : function(e){
        var header = this.grid.getHeaderFromChild(e.getTarget());
        YAHOO.util.Dom.addClass(header, 'ygrid-hd-over');
        
    },
    
    headerOut : function(e){
        var header = this.grid.getHeaderFromChild(e.getTarget());
        YAHOO.util.Dom.removeClass(header, 'ygrid-hd-over');
        
    },
    
    cancelTextSelection : function(e){
    	e.preventDefault();
    }
};

YAHOO.ext.grid.PagedGridView = function(){
    YAHOO.ext.grid.PagedGridView.superclass.constructor.call(this);
    this.cursor = 1;
};

YAHOO.extendX(YAHOO.ext.grid.PagedGridView, YAHOO.ext.grid.GridView, {
    appendFooter : function(parentEl){
        var fwrap = document.createElement('div');
        fwrap.className = 'ygrid-wrap-footer';
        var fbody = document.createElement('span');
        fbody.className = 'ygrid-footer';
        fwrap.appendChild(fbody);
        parentEl.appendChild(fwrap);
        this.createPagingToolbar(fbody);
        return fwrap;
    },

    createPagingToolbar : function(container){
        var tb = new YAHOO.ext.Toolbar(container);
        this.pageToolbar = tb;
        this.first = tb.addButton({
            tooltip: this.firstText, 
            className: 'ygrid-page-first',
            disabled: true,
            click: this.onClick.createDelegate(this, ['first'])
        });
        this.prev = tb.addButton({
            tooltip: this.prevText, 
            className: 'ygrid-page-prev', 
            disabled: true,
            click: this.onClick.createDelegate(this, ['prev'])
        });
        tb.addSeparator();
        tb.add(this.beforePageText);
        var pageBox = document.createElement('input');
        pageBox.type = 'text';
        pageBox.size = 3;
        pageBox.value = '1';
        pageBox.className = 'ygrid-page-number';
        tb.add(pageBox);
        this.field = getEl(pageBox, true);
        this.field.mon('keydown', this.onEnter, this, true);
        this.field.on('focus', function(){pageBox.select();});
        this.afterTextEl = tb.addText(this.afterPageText.replace('%0', '1'));
        this.field.setHeight(18);
        tb.addSeparator();
        this.next = tb.addButton({
            tooltip: this.nextText, 
            className: 'ygrid-page-next', 
            disabled: true,
            click: this.onClick.createDelegate(this, ['next'])
        });
        this.last = tb.addButton({
            tooltip: this.lastText, 
            className: 'ygrid-page-last', 
            disabled: true,
            click: this.onClick.createDelegate(this, ['last'])
        });
        tb.addSeparator();
        this.loading = tb.addButton({
            tooltip: this.refreshText, 
            className: 'ygrid-loading',
            disabled: true,
            click: this.onClick.createDelegate(this, ['refresh'])
        });
        this.onPageLoaded(1, this.grid.dataModel.getTotalPages());
    },
    
    
    getPageToolbar : function(){
        return this.pageToolbar;  
    },
    
    onPageLoaded : function(pageNum, totalPages){
        this.cursor = pageNum;
        this.lastPage = totalPages;
        this.afterTextEl.innerHTML = this.afterPageText.replace('%0', totalPages);
        this.field.dom.value = pageNum;
        this.first.setDisabled(pageNum == 1);
        this.prev.setDisabled(pageNum == 1);
        this.next.setDisabled(pageNum == totalPages);
        this.last.setDisabled(pageNum == totalPages);
        this.loading.enable();
    },
    
    onLoadError : function(){
        this.loading.enable();
    },
    
    onEnter : function(e){
        if(e.browserEvent.keyCode == e.RETURN){
            var v = this.field.dom.value;
            if(!v){
                this.field.dom.value = this.cursor;
                return;
            }
            var pageNum = parseInt(v, 10);
            if(isNaN(pageNum)){
                this.field.dom.value = this.cursor;
                return;
            }
            pageNum = Math.min(Math.max(1, pageNum), this.lastPage);
            this.grid.dataModel.loadPage(pageNum);
            e.stopEvent();
        }
    },
    
    beforeLoad : function(){
        this.grid.stopEditing();
        if(this.loading){
            this.loading.disable();
        }  
    },
    
    onClick : function(which){
        switch(which){
            case 'first':
                this.grid.dataModel.loadPage(1);
            break;
            case 'prev':
                this.grid.dataModel.loadPage(this.cursor -1);
            break;
            case 'next':
                this.grid.dataModel.loadPage(this.cursor + 1);
            break;
            case 'last':
                this.grid.dataModel.loadPage(this.lastPage);
            break;
            case 'refresh':
                this.grid.dataModel.loadPage(this.cursor);
            break;
        }
    },
    
    unplugDataModel : function(dm){
        dm.removeListener('beforeload', this.beforeLoad, this);
        dm.removeListener('load', this.onPageLoaded, this);
        dm.removeListener('loadexception', this.onLoadError, this);
        YAHOO.ext.grid.PagedGridView.superclass.unplugDataModel.call(this, dm);
    },
    
    plugDataModel : function(dm){
        dm.on('beforeload', this.beforeLoad, this, true);
        dm.on('load', this.onPageLoaded, this, true);
        dm.on('loadexception', this.onLoadError, this);
        YAHOO.ext.grid.PagedGridView.superclass.plugDataModel.call(this, dm);
    },
    
    
    beforePageText : "Page",
    
    afterPageText : "of %0",
    
    firstText : "First Page",
    
    prevText : "Previous Page",
    
    nextText : "Next Page",
    
    lastText : "Last Page",
    
    refreshText : "Refresh"
});


YAHOO.ext.grid.EditorGrid = function(container, dataModel, colModel){
    YAHOO.ext.grid.EditorGrid.superclass.constructor.call(this, container, dataModel, 
                      colModel, new YAHOO.ext.grid.EditorSelectionModel());
    this.container.addClass('yeditgrid');
};
YAHOO.extendX(YAHOO.ext.grid.EditorGrid, YAHOO.ext.grid.Grid);

YAHOO.ext.grid.AbstractColumnModel = function(){
	
	this.onWidthChange = new YAHOO.util.CustomEvent('widthChanged');
    this.onHeaderChange = new YAHOO.util.CustomEvent('headerChanged');
	this.onHiddenChange = new YAHOO.util.CustomEvent('hiddenChanged');
    
    this.events = {
        
	    'widthchange': this.onWidthChange,
        
	    'headerchange': this.onHeaderChange,
        
	    'hiddenchange': this.onHiddenChange
    };
};

YAHOO.ext.grid.AbstractColumnModel.prototype = {
	fireEvent : YAHOO.ext.util.Observable.prototype.fireEvent,
    on : YAHOO.ext.util.Observable.prototype.on,
    addListener : YAHOO.ext.util.Observable.prototype.addListener,
    delayedListener : YAHOO.ext.util.Observable.prototype.delayedListener,
    removeListener : YAHOO.ext.util.Observable.prototype.removeListener,
    purgeListeners : YAHOO.ext.util.Observable.prototype.purgeListeners,
    bufferedListener : YAHOO.ext.util.Observable.prototype.bufferedListener,
    
    fireWidthChange : function(colIndex, newWidth){
		this.onWidthChange.fireDirect(this, colIndex, newWidth);
	},
	
	fireHeaderChange : function(colIndex, newHeader){
		this.onHeaderChange.fireDirect(this, colIndex, newHeader);
	},
	
	fireHiddenChange : function(colIndex, hidden){
		this.onHiddenChange.fireDirect(this, colIndex, hidden);
	},
	
	
    getColumnCount : function(){
        return 0;
    },
    
    
    isSortable : function(col){
        return false;
    },
    
    
    isHidden : function(col){
        return false;
    },
    
    
    getSortType : function(col){
        return YAHOO.ext.grid.DefaultColumnModel.sortTypes.none;
    },
    
    
    getRenderer : function(col){
        return YAHOO.ext.grid.DefaultColumnModel.defaultRenderer;
    },
    
    
    getColumnWidth : function(col){
        return 0;
    },
    
    
    getTotalWidth : function(){
        return 0;
    },
    
    
    getColumnHeader : function(col){
        return '';
    }
};


YAHOO.ext.grid.DefaultColumnModel = function(config){
	YAHOO.ext.grid.DefaultColumnModel.superclass.constructor.call(this);
    
    this.config = config;
    
    
    this.defaultWidth = 100;
    
    this.defaultSortable = false;
};
YAHOO.extendX(YAHOO.ext.grid.DefaultColumnModel, YAHOO.ext.grid.AbstractColumnModel, {
    
    
    getColumnCount : function(){
        return this.config.length;
    },
        
    
    isSortable : function(col){
        if(typeof this.config[col].sortable == 'undefined'){
            return this.defaultSortable;
        }
        return this.config[col].sortable;
    },
        
    
    getSortType : function(col){
        if(!this.dataMap){
            
            var map = [];
            for(var i = 0, len = this.config.length; i < len; i++){
                map[this.getDataIndex(i)] = i;
            }
            this.dataMap = map;
        }
        col = this.dataMap[col];
        if(!this.config[col].sortType){
            return YAHOO.ext.grid.DefaultColumnModel.sortTypes.none;
        }
        return this.config[col].sortType;
    },
        
    
    setSortType : function(col, fn){
        this.config[col].sortType = fn;
    },
        
    
    
    getRenderer : function(col){
        if(!this.config[col].renderer){
            return YAHOO.ext.grid.DefaultColumnModel.defaultRenderer;
        }
        return this.config[col].renderer;
    },
        
    
    setRenderer : function(col, fn){
        this.config[col].renderer = fn;
    },
        
    
    getColumnWidth : function(col){
        return this.config[col].width || this.defaultWidth;
    },
        
    
    setColumnWidth : function(col, width, suppressEvent){
        this.config[col].width = width;
        this.totalWidth = null;
        if(!suppressEvent){
             this.onWidthChange.fireDirect(this, col, width);
        }
    },
        
    
    getTotalWidth : function(includeHidden){
        if(!this.totalWidth){
            this.totalWidth = 0;
            for(var i = 0; i < this.config.length; i++){
                if(includeHidden || !this.isHidden(i)){
                    this.totalWidth += this.getColumnWidth(i);
                }
            }
        }
        return this.totalWidth;
    },
        
    
    getColumnHeader : function(col){
        return this.config[col].header;
    },
         
    
    setColumnHeader : function(col, header){
        this.config[col].header = header;
        this.onHeaderChange.fireDirect(this, col, header);
    },
    
    
    getColumnTooltip : function(col){
            return this.config[col].tooltip;
    },
    
    setColumnTooltip : function(col, header){
            this.config[col].tooltip = tooltip;
    },
        
    
    getDataIndex : function(col){
        if(typeof this.config[col].dataIndex != 'number'){
            return col;
        }
        return this.config[col].dataIndex;
    },
         
    
    setDataIndex : function(col, dataIndex){
        this.config[col].dataIndex = dataIndex;
    },
    
    isCellEditable : function(colIndex, rowIndex){
        return this.config[colIndex].editable || (typeof this.config[colIndex].editable == 'undefined' && this.config[colIndex].editor);
    },
    
    
    getCellEditor : function(colIndex, rowIndex){
        return this.config[colIndex].editor;
    },
       
    
    setEditable : function(col, editable){
        this.config[col].editable = editable;
    },
    
    
    
    isHidden : function(colIndex){
        return this.config[colIndex].hidden;
    },
    
    
    
    isFixed : function(colIndex){
        return this.config[colIndex].fixed;
    },
    
    
    isResizable : function(colIndex){
        return this.config[colIndex].resizable !== false;
    },
    
    setHidden : function(colIndex, hidden){
        this.config[colIndex].hidden = hidden;
        this.totalWidth = null;
        this.fireHiddenChange(colIndex, hidden);
    },
    
    
    setEditor : function(col, editor){
        this.config[col].editor = editor;
    }
});


YAHOO.ext.grid.DefaultColumnModel.sortTypes = {
    none : function(s) {
    	return s;
    },

    asUCString : function(s) {
    	return String(s).toUpperCase();
    },
    
    asDate : function(s) {
        if(s instanceof Date){
            return s.getTime();
        }
    	return Date.parse(String(s));
    },
    
    asFloat : function(s) {
    	var val = parseFloat(String(s).replace(/,/g, ''));
        if(isNaN(val)) val = 0;
    	return val;
    },
    
    asInt : function(s) {
        var val = parseInt(String(s).replace(/,/g, ''));
        if(isNaN(val)) val = 0;
    	return val;
    }
};

YAHOO.ext.grid.DefaultColumnModel.defaultRenderer = function(value){
	if(typeof value == 'string' && value.length < 1){
	    return '&#160;';
	}
	return value;
}

YAHOO.ext.grid.AbstractDataModel = function(){
    
    this.onCellUpdated = new YAHOO.util.CustomEvent('onCellUpdated');
    
    this.onTableDataChanged = new YAHOO.util.CustomEvent('onTableDataChanged');
    
    this.onRowsDeleted = new YAHOO.util.CustomEvent('onRowsDeleted');
    
    this.onRowsInserted = new YAHOO.util.CustomEvent('onRowsInserted');
    
    this.onRowsUpdated = new YAHOO.util.CustomEvent('onRowsUpdated');
    
    this.onRowsSorted = new YAHOO.util.CustomEvent('onRowsSorted');
    
    this.events = {
      
      'cellupdated' : this.onCellUpdated,
      
      'datachanged' : this.onTableDataChanged,
      
      'rowsdeleted' : this.onRowsDeleted,
      
      'rowsinserted' : this.onRowsInserted,
      
      'rowsupdated' : this.onRowsUpdated,
      
      'rowssorted' : this.onRowsSorted
    };
};

YAHOO.ext.grid.AbstractDataModel.prototype = {
    
    fireEvent : YAHOO.ext.util.Observable.prototype.fireEvent,
    on : YAHOO.ext.util.Observable.prototype.on,
    addListener : YAHOO.ext.util.Observable.prototype.addListener,
    delayedListener : YAHOO.ext.util.Observable.prototype.delayedListener,
    removeListener : YAHOO.ext.util.Observable.prototype.removeListener,
    purgeListeners : YAHOO.ext.util.Observable.prototype.purgeListeners,
    bufferedListener : YAHOO.ext.util.Observable.prototype.bufferedListener,
    
    
    fireCellUpdated : function(row, col){
        this.onCellUpdated.fireDirect(this, row, col);
    },
    
    
    fireTableDataChanged : function(){
        this.onTableDataChanged.fireDirect(this);
    },
    
    
    fireRowsDeleted : function(firstRow, lastRow){
        this.onRowsDeleted.fireDirect(this, firstRow, lastRow);
    },
    
    
    fireRowsInserted : function(firstRow, lastRow){
        this.onRowsInserted.fireDirect(this, firstRow, lastRow);
    },
    
    
    fireRowsUpdated : function(firstRow, lastRow){
        this.onRowsUpdated.fireDirect(this, firstRow, lastRow);
    },
    
    
    fireRowsSorted : function(sortColumnIndex, sortDir, noRefresh){
        this.onRowsSorted.fireDirect(this, sortColumnIndex, sortDir, noRefresh);
    },
    
    
    sort : function(sortInfo, columnIndex, direction, suppressEvent){
    	
    },
    
    
    getSortState : function(){
    	return {column: this.sortColumn, direction: this.sortDir};
    },
    
    
    getRowCount : function(){
    	
    },
    
    
    getTotalRowCount : function(){
    	return this.getRowCount();
    },
    
    
    
    getRowId : function(rowIndex){
    	
    },
    
    
    getValueAt : function(rowIndex, colIndex){
    	
    },
    
    
    setValueAt : function(value, rowIndex, colIndex){
    	
    },
    
    isPaged : function(){
        return false;
    }
};


YAHOO.ext.grid.DefaultDataModel = function(data){
    YAHOO.ext.grid.DefaultDataModel.superclass.constructor.call(this);
    
    this.data = data;
};
YAHOO.extendX(YAHOO.ext.grid.DefaultDataModel, YAHOO.ext.grid.AbstractDataModel, {
    
    getRowCount : function(){
        return this.data.length;
    },
        
    
    getRowId : function(rowIndex){
        return this.data[rowIndex][0];
    },
    
    
    getRow : function(rowIndex){
        return this.data[rowIndex];
    },
    
    
    getRows : function(indexes){
        var data = this.data;
        var r = [];
        for(var i = 0; i < indexes.length; i++){
           r.push(data[indexes[i]]);
        }
        return r;
    },
    
    
    getValueAt : function(rowIndex, colIndex){
    	return this.data[rowIndex][colIndex];
    },
    
    
    setValueAt: function(value, rowIndex, colIndex){
        this.data[rowIndex][colIndex] = value;
        this.fireCellUpdated(rowIndex, colIndex);
    },
    
    
    removeRows: function(startIndex, endIndex){
        endIndex = endIndex || startIndex;
        this.data.splice(startIndex, endIndex-startIndex+1);
        this.fireRowsDeleted(startIndex, endIndex);
    },
    
    
    removeRow: function(index){
        this.data.splice(index, 1);
        this.fireRowsDeleted(index, index);
    },
    
    
    removeAll: function(){
    	var count = this.getRowCount();
    	if(count > 0){
        	this.removeRows(0, count-1);
    	}
    },
    
    
    query: function(spec, returnUnmatched){
        var d = this.data;
        var r = [];
        for(var i = 0; i < d.length; i++){
            var row = d[i];
            var isMatch = true;
            for(var col in spec){
                
                    if(!isMatch) continue;
                    var filter = spec[col];
                    switch(typeof filter){
                        case 'string':
                        case 'number':
                        case 'boolean':
                          if(row[col] != filter){
                              isMatch = false;
                          }
                        break;
                        case 'function':
                          if(!filter(row[col], row)){
                              isMatch = false;
                          }
                        break;
                        case 'object':
                           if(filter instanceof RegExp){
                               if(String(row[col]).search(filter) === -1){
                                   isMatch = false;
                               }
                           }
                        break;
                    }
                
            }
            if(isMatch && !returnUnmatched){
                r.push(i);
            }else if(!isMatch && returnUnmatched){
                r.push(i);
            }
        }
        return r;
    },
    
    
    filter: function(query){
        var matches = this.query(query, true);
        var data = this.data;
        
        
        for(var i = 0; i < matches.length; i++){ 
            data[matches[i]]._deleted = true;
        }
        for(var i = 0; i < data.length; i++){
            while(data[i] && data[i]._deleted === true){
                this.removeRow(i);
            }
        }
        return matches.length;
    },
    
    
    addRow: function(cellValues){
        this.data.push(cellValues);
        var newIndex = this.data.length-1;
        this.fireRowsInserted(newIndex, newIndex);
        this.applySort();
        return newIndex;
    },
    
    
    addRows: function(rowData){
        this.data = this.data.concat(rowData);
        var firstIndex = this.data.length-rowData.length;
        this.fireRowsInserted(firstIndex, firstIndex+rowData.length-1);
        this.applySort();
    },
    
    
    insertRow: function(index, cellValues){
        this.data.splice(index, 0, cellValues);
        this.fireRowsInserted(index, index);
        this.applySort();
        return index;
    },
    
    
    insertRows: function(index, rowData){
        
        var args = rowData.concat();
        args.splice(0, 0, index, 0);
        this.data.splice.apply(this.data, args);
        this.fireRowsInserted(index, index+rowData.length-1);
        this.applySort();
    },
    
    
    applySort: function(suppressEvent){
    	if(typeof this.sortColumn != 'undefined'){
    		this.sort(this.sortInfo, this.sortColumn, this.sortDir, suppressEvent);
    	}
    },
    
    
    setDefaultSort: function(sortInfo, columnIndex, direction){
        this.sortInfo = sortInfo;
        this.sortColumn = columnIndex;
        this.sortDir = direction;
    },
    
    sort: function(sortInfo, columnIndex, direction, suppressEvent){
        
        this.sortInfo = sortInfo;
        this.sortColumn = columnIndex;
        this.sortDir = direction;
        
        var dsc = (direction && direction.toUpperCase() == 'DESC');
        var sortType = null;
        if(sortInfo != null){
            if(typeof sortInfo == 'function'){
                sortType = sortInfo;
            }else if(typeof sortInfo == 'object'){
                sortType = sortInfo.getSortType(columnIndex);;
            }
        }
        var fn = function(cells, cells2){
            var v1 = sortType ? sortType(cells[columnIndex], cells) : cells[columnIndex];
            var v2 = sortType ? sortType(cells2[columnIndex], cells2) : cells2[columnIndex];
            if(v1 < v2)
    			return dsc ? +1 : -1;
    		if(v1 > v2)
    			return dsc ? -1 : +1;
    	    return 0;
        };
        this.data.sort(fn);
        if(!suppressEvent){
           this.fireRowsSorted(columnIndex, direction);
        }
    },
    
     
    each: function(fn, scope){
        var d = this.data;
        for(var i = 0, len = d.length; i < len; i++){
            if(fn.call(scope || window, d[i], i) === false) break;
        }
    }
});


if(YAHOO.ext.grid.DefaultColumnModel){
    YAHOO.ext.grid.DefaultDataModel.sortTypes = YAHOO.ext.grid.DefaultColumnModel.sortTypes;
}

YAHOO.ext.grid.LoadableDataModel = function(dataType){
    YAHOO.ext.grid.LoadableDataModel.superclass.constructor.call(this, []);
    
    
    this.onLoad = new YAHOO.util.CustomEvent('load');
    
    this.onLoadException = new YAHOO.util.CustomEvent('loadException');
    
    this.events['load'] = this.onLoad;
    
    this.events['beforeload'] = new YAHOO.util.CustomEvent('beforeload');
    
    this.events['loadexception'] = this.onLoadException;
    
    
    this.dataType = dataType;
    
    this.preprocessors = [];
    
    this.postprocessors = [];
    
    
    
    this.loadedPage = 1;
    
    this.remoteSort = false;
    
    this.pageSize = 0;
    
    this.pageUrl = null;
    
    this.baseParams = {};
    
    this.paramMap = {'page':'page', 'pageSize':'pageSize', 'sortColumn':'sortColumn', 'sortDir':'sortDir'};
    
};
YAHOO.extendX(YAHOO.ext.grid.LoadableDataModel, YAHOO.ext.grid.DefaultDataModel, {
    
    
    setLoadedPage: function(pageNum, userCallback){
        this.loadedPage = pageNum;
        if(typeof userCallback == 'function'){
            userCallback();
        }
    },
    
    
    isPaged: function(){
        return this.pageSize > 0;
    },
    
    
    getTotalRowCount: function(){
        return this.totalCount || this.getRowCount();
    },
    
    
    getPageSize: function(){
        return this.pageSize;
    },
    
    
    getTotalPages: function(){
        if(this.getPageSize() == 0 || this.getTotalRowCount() == 0){
            return 1;
        }
        return Math.ceil(this.getTotalRowCount()/this.getPageSize());
    },
    
    
    initPaging: function(url, pageSize, baseParams){
        this.pageUrl = url;
        this.pageSize = pageSize;
        this.remoteSort = true;
        if(baseParams) this.baseParams = baseParams;
    },
    
    
    createParams: function(pageNum, sortColumn, sortDir){
        var params = {}, map = this.paramMap;
        for(var key in this.baseParams){
            if(typeof this.baseParams[key] != 'function'){
                params[key] = this.baseParams[key];
            }
        }
        params[map['page']] = pageNum;
        params[map['pageSize']] = this.getPageSize();
        params[map['sortColumn']] = (typeof sortColumn == 'undefined' ? '' : sortColumn);
        params[map['sortDir']] = sortDir || '';
        return params;
    },
    
    
    loadPage: function(pageNum, callback, keepExisting){
        var sort = this.getSortState();
        var params = this.createParams(pageNum, sort.column, sort.direction);
        this.load(this.pageUrl, params, this.setLoadedPage.createDelegate(this, [pageNum, callback]), 
                   keepExisting ? (pageNum-1) * this.pageSize : null);
    },
    
    
    applySort: function(suppressEvent){
    	if(!this.remoteSort){
            YAHOO.ext.grid.LoadableDataModel.superclass.applySort.apply(this, arguments);
        }else if(!suppressEvent){
            var sort = this.getSortState();
            if(sort.column){
               this.fireRowsSorted(sort.column, sort.direction, true);
            }
        }
    },
    
    
    resetPaging: function(){
    	this.loadedPage = 1;
    },
    
    
    sort: function(sortInfo, columnIndex, direction, suppressEvent){
        if(!this.remoteSort){
            YAHOO.ext.grid.LoadableDataModel.superclass.sort.apply(this, arguments);
        }else{
            this.sortInfo = sortInfo;
            this.sortColumn = columnIndex;
            this.sortDir = direction;
            var params = this.createParams(this.loadedPage, columnIndex, direction);
            this.load(this.pageUrl, params, this.fireRowsSorted.createDelegate(this, [columnIndex, direction, true]));
        }
    },
    
    
    load: function(url, params, callback, insertIndex){
    	this.fireEvent('beforeload', this);
    	if(params && typeof params != 'string'){ 
            var buf = [];
            for(var key in params){
                if(typeof params[key] != 'function'){
                    buf.push(encodeURIComponent(key), '=', encodeURIComponent(params[key]), '&');
                }
            }
            delete buf[buf.length-1];
            params = buf.join('');
        }
        var cb = {
            success: this.processResponse,
            failure: this.processException,
            scope: this,
    		argument: {callback: callback, insertIndex: insertIndex}
        };
        var method = params ? 'POST' : 'GET';
        this.transId = YAHOO.util.Connect.asyncRequest(method, url, cb, params);
    },
    
    
    processResponse: function(response){
        var cb = response.argument.callback;
        var keepExisting = (typeof response.argument.insertIndex == 'number');
        var insertIndex = response.argument.insertIndex;
        switch(this.dataType){
        	case YAHOO.ext.grid.LoadableDataModel.XML:
        		this.loadData(response.responseXML, cb, keepExisting, insertIndex);
        	break;
        	case YAHOO.ext.grid.LoadableDataModel.JSON:
        		var rtext = response.responseText;
        		try { 
    		        
    		        while(rtext.substring(0,1) == " ") {
    		            rtext = rtext.substring(1, rtext.length);
    		        }
    		        
    		        if(rtext.indexOf("{") < 0) {
    		            throw "Invalid JSON response";
    		        }
    		
    		        
    		        if(rtext.indexOf("{}") === 0) {
    		            this.loadData({}, response.argument.callback);
    		            return;
    		        }
    		
    		        
    		        
    		        var jsonObjRaw = eval("(" + rtext + ")");
    		        if(!jsonObjRaw) {
    		            throw "Error evaling JSON response";
    		        }
    				this.loadData(jsonObjRaw, cb, keepExisting, insertIndex);
    		    } catch(e) {
    		        this.fireLoadException(e, response);
    				if(typeof cb == 'function'){
    			    	cb(this, false);
    			    }
    		   	}
        	break;
        	case YAHOO.ext.grid.LoadableDataModel.TEXT:
        		this.loadData(response.responseText, cb, keepExisting, insertIndex);
        	break;
        };
    },
    
    
    processException: function(response){
        this.fireLoadException(null, response);
        if(typeof response.argument.callback == 'function'){
            response.argument.callback(this, false);
        }
    },
    
    fireLoadException: function(e, responseObj){
        this.onLoadException.fireDirect(this, e, responseObj);
    },
    
    fireLoadEvent: function(){
        this.fireEvent('load', this.loadedPage, this.getTotalPages());
    },
    
    
    addPreprocessor: function(columnIndex, fn){
        this.preprocessors[columnIndex] = fn;
    },
    
    
    getPreprocessor: function(columnIndex){
        return this.preprocessors[columnIndex];
    },
    
    
    removePreprocessor: function(columnIndex){
        this.preprocessors[columnIndex] = null;
    },
    
    
    addPostprocessor: function(columnIndex, fn){
        this.postprocessors[columnIndex] = fn;
    },
    
    
    getPostprocessor: function(columnIndex){
        return this.postprocessors[columnIndex];
    },
    
    
    removePostprocessor: function(columnIndex){
        this.postprocessors[columnIndex] = null;
    },
    
    loadData: function(data, callback, keepExisting, insertIndex){
    	
    }
});

YAHOO.ext.grid.LoadableDataModel.XML = 'xml';
YAHOO.ext.grid.LoadableDataModel.JSON = 'json';
YAHOO.ext.grid.LoadableDataModel.TEXT = 'text';







YAHOO.ext.grid.XMLDataModel = function(schema, xml){
    YAHOO.ext.grid.XMLDataModel.superclass.constructor.call(this, YAHOO.ext.grid.LoadableDataModel.XML);
    
    this.schema = schema;
    this.xml = xml;
    if(xml){
        this.loadData(xml);
    }
    this.idSeed = 0;
};
YAHOO.extendX(YAHOO.ext.grid.XMLDataModel, YAHOO.ext.grid.LoadableDataModel, {
    
    getDocument: function(){
       return this.xml;    
    },
    
    
    loadData: function(doc, callback, keepExisting, insertIndex){
    	//debugger;
    	this.xml = doc;
    	var idField = this.schema.id;
    	var fields = this.schema.fields;
    	if(this.schema.totalTag){
    	    this.totalCount = null;
    	    var totalNode = doc.getElementsByTagName(this.schema.totalTag);
    	    if(totalNode && totalNode.item(0) && totalNode.item(0).firstChild) {
                var v = parseInt(totalNode.item(0).firstChild.nodeValue, 10);
                if(!isNaN(v)){
                    this.totalCount = v;
                }
        	}
    	}
    	var rowData = [];
    	var nodes = doc.getElementsByTagName(this.schema.tagName);
        if(nodes && nodes.length > 0) {
    	    for(var i = 0; i < nodes.length; i++) {
    	        var node = nodes.item(i);
    	        var colData = [];
    	        colData.node = node;
    	        colData.id = this.getNamedValue(node, idField, String(++this.idSeed));
    	        for(var j = 0; j < fields.length; j++) {
    	            var val = this.getNamedValue(node, fields[j], "");
    	            if(this.preprocessors[j]){
    	                val = this.preprocessors[j](val);
    	            }
    	            colData.push(val);
    	        }
    	        rowData.push(colData);
    	    }
        }
        if(keepExisting !== true){
           YAHOO.ext.grid.XMLDataModel.superclass.removeAll.call(this);
    	}
    	if(typeof insertIndex != 'number'){
    	    insertIndex = this.getRowCount();
    	}
        YAHOO.ext.grid.XMLDataModel.superclass.insertRows.call(this, insertIndex, rowData);
        if(typeof callback == 'function'){
        	callback(this, true);
        }
        this.fireLoadEvent();
    },
    
    
    addRow: function(id, cellValues){
        var node = this.createNode(this.xml, id, cellValues);
        cellValues.id = id || ++this.idSeed;
        cellValues.node = node;
        return YAHOO.ext.grid.XMLDataModel.superclass.addRow.call(this, cellValues);
    },
    
    
    insertRow: function(index, id, cellValues){
        var node = this.createNode(this.xml, id, cellValues);
        cellValues.id = id || ++this.idSeed;
        cellValues.node = node;
        return YAHOO.ext.grid.XMLDataModel.superclass.insertRow.call(this, index, cellValues);
    },
    
    
    removeRow: function(index){
        var node = this.data[index].node;
        node.parentNode.removeChild(node);
        YAHOO.ext.grid.XMLDataModel.superclass.removeRow.call(this, index, index);
    },
    
    getNode: function(rowIndex){
        return this.data[rowIndex].node;
    },
    
    
    createNode: function(xmlDoc, id, colData){
        var template = this.data[0].node;
        var newNode = template.cloneNode(true);
        var fields = this.schema.fields;
        for(var i = 0, len = fields.length; i < len; i++){
            var nodeValue = colData[i];
            if(this.postprocessors[i]){
                nodeValue = this.postprocessors[i](nodeValue);
            }
            this.setNamedValue(newNode, fields[i], nodeValue);
        }
        if(id){
            this.setNamedValue(newNode, this.schema.idField, id);
        }
        template.parentNode.appendChild(newNode);
        return newNode;
    },
    
    
    getNamedValue: function(node, name, defaultValue){
    	if(!node || !name){
    		return defaultValue;
    	}
    	var nodeValue = defaultValue;
        var attrNode = node.attributes.getNamedItem(name);
        if(attrNode) {
        	nodeValue = attrNode.value;
        } else {
            var childNode = node.getElementsByTagName(name);
            if(childNode && childNode.item(0) && childNode.item(0).firstChild) {
                nodeValue = childNode.item(0).firstChild.nodeValue;
        	}else{
        	    
        	    var index = name.indexOf(':');
        	    if(index > 0){
        	        return this.getNamedValue(node, name.substr(index+1), defaultValue);
        	    }
        	}
        }
        return nodeValue;
    },
    
    
    setNamedValue: function(node, name, value){
    	if(!node || !name){
    		return;
    	}
    	var attrNode = node.attributes.getNamedItem(name);
        if(attrNode) {
        	attrNode.value = value;
        	return;
        }
        var childNode = node.getElementsByTagName(name);
        if(childNode && childNode.item(0) && childNode.item(0).firstChild) {
            childNode.item(0).firstChild.nodeValue = value;
        }else{
    	    
    	    var index = name.indexOf(':');
    	    if(index > 0){
    	        this.setNamedValue(node, name.substr(index+1), value);
    	    }
    	}
    },
    
    
    setValueAt: function(value, rowIndex, colIndex){
        var node = this.data[rowIndex].node;
        if(node){
            var nodeValue = value;
            if(this.postprocessors[colIndex]){
                nodeValue = this.postprocessors[colIndex](value);
            }
            this.setNamedValue(node, this.schema.fields[colIndex], nodeValue);
        }
        YAHOO.ext.grid.XMLDataModel.superclass.setValueAt.call(this, value, rowIndex, colIndex);
    },
    
    
    getRowId: function(rowIndex){
        return this.data[rowIndex].id;
    },
    
    addRows : function(rowData){   
        for(var j = 0, len = rowData.length; j < len; j++){
           var cellValues = rowData[j];
           var id = ++this.idSeed; 
           var node = this.createNode(this.xml, id, cellValues);       
           cellValues.node=node;
           cellValues.id = cellValues.id || id;
           YAHOO.ext.grid.XMLDataModel.superclass.addRow.call(this,cellValues);
        }
    },   

   insertRows : function(index, rowData){
       
       rowData = rowData.slice(0).reverse();
       for(var j = 0, len = rowData.length; j < len; j++){
          var cellValues = rowData[j];
          var id = ++this.idSeed; 
          var node = this.createNode(this.xml, id, cellValues);
          cellValues.id = cellValues.id || id;
          cellValues.node = node;
          YAHOO.ext.grid.XMLDataModel.superclass.insertRow.call(this, index, cellValues);
       }
   }
});

YAHOO.ext.grid.XMLQueryDataModel = function(){
   YAHOO.ext.grid.XMLQueryDataModel.superclass.constructor.apply(this, arguments);
};
YAHOO.extendX(YAHOO.ext.grid.XMLQueryDataModel, YAHOO.ext.grid.XMLDataModel, {
    getNamedValue: function(node, name, defaultValue){
    	if(!node || !name){
    		return defaultValue;
    	}
    	var nodeValue = defaultValue;
    	var childNode = cssQuery(name, node);
    	if(childNode && childNode[0]) {
            nodeValue = childNode[0].firstChild.nodeValue;
    	}
        return nodeValue;
    }
});


YAHOO.ext.grid.JSONDataModel = function(schema){
    YAHOO.ext.grid.JSONDataModel.superclass.constructor.call(this, YAHOO.ext.grid.LoadableDataModel.JSON);
    
    this.schema = schema;
};
YAHOO.extendX(YAHOO.ext.grid.JSONDataModel, YAHOO.ext.grid.LoadableDataModel, {
    
    loadData : function(data, callback, keepExisting){
    	var idField = this.schema.id;
    	var fields = this.schema.fields;
    	try{
        	if(this.schema.totalProperty){
                var v = parseInt(eval('data.' + this.schema.totalProperty), 10);
                if(!isNaN(v)){
                    this.totalCount = v;
                }
            }
        	var rowData = [];
    	    var root = eval('data.' + this.schema.root);
    	    for(var i = 0; i < root.length; i++){
    			var node = root[i];
    			var colData = [];
    			colData.node = node;
    			colData.id = (typeof node[idField] != 'undefined' && node[idField] !== '' ? node[idField] : String(i));
    			for(var j = 0; j < fields.length; j++) {
    			    var val = node[fields[j]];
    			    if(typeof val == 'undefined'){
    			        val = '';
    			    }
    	            if(this.preprocessors[j]){
    	                val = this.preprocessors[j](val);
    	            }
    	            colData.push(val);
    	        }
    	        rowData.push(colData);
    		}
    		if(keepExisting !== true){
    		  this.removeAll();
    		}
            this.addRows(rowData);
        	if(typeof callback == 'function'){
    	    	callback(this, true);
    	    }
          	this.fireLoadEvent();
    	}catch(e){
    		this.fireLoadException(e, null);
    		if(typeof callback == 'function'){
    	    	callback(this, false);
    	    }
    	}
    },
    
    
    getRowId : function(rowIndex){
        return this.data[rowIndex].id;
    }
});

YAHOO.ext.grid.DefaultSelectionModel = function(){
    this.selectedRows = [];
    this.selectedRowIds = [];
    this.lastSelectedRow = null;
    
    this.onRowSelect = new YAHOO.util.CustomEvent('SelectionTable.rowSelected');
    this.onSelectionChange = new YAHOO.util.CustomEvent('SelectionTable.selectionChanged');
    
    this.events = {
        
	    'selectionchange' : this.onSelectionChange,
        
	    'rowselect' : this.onRowSelect
    };
    
    this.locked = false;
};

YAHOO.ext.grid.DefaultSelectionModel.prototype = {
    
    init : function(grid){
        this.grid = grid;
        this.initEvents();
    },
    
    
    lock : function(){
        this.locked = true;
    },
    
    
    unlock : function(){
        this.locked = false;  
    },
    
    
    isLocked : function(){
        return this.locked;    
    },
    
    
    initEvents : function(){
        if(this.grid.trackMouseOver){
        	this.grid.addListener("mouseover", this.handleOver, this, true);
        	this.grid.addListener("mouseout", this.handleOut, this, true);
        }
        this.grid.addListener("rowclick", this.rowClick, this, true);
        this.grid.addListener("keydown", this.keyDown, this, true);
    },
    
    fireEvent : YAHOO.ext.util.Observable.prototype.fireEvent,
    on : YAHOO.ext.util.Observable.prototype.on,
    addListener : YAHOO.ext.util.Observable.prototype.addListener,
    delayedListener : YAHOO.ext.util.Observable.prototype.delayedListener,
    removeListener : YAHOO.ext.util.Observable.prototype.removeListener,
    purgeListeners : YAHOO.ext.util.Observable.prototype.purgeListeners,
    bufferedListener : YAHOO.ext.util.Observable.prototype.bufferedListener,
    
    
    syncSelectionsToIds : function(){
        if(this.getCount() > 0){
            var ids = this.selectedRowIds.concat();
            this.clearSelections();
            this.selectRowsById(ids, true);
        }
    },
    
    
    selectRowsById : function(id, keepExisting){
        var rows = this.grid.getRowsById(id);
        if (!(rows instanceof Array)){
            this.selectRow(rows, keepExisting);
            return;
        }
        this.selectRows(rows, keepExisting);
    },
    
    
    getCount : function(){
        return this.selectedRows.length;
    },
    
    
    selectFirstRow : function(){
        for(var j = 0; j < this.grid.rows.length; j++){
            if(this.isSelectable(this.grid.rows[j])){
            	this.focusRow(this.grid.rows[j]);
                this.setRowState(this.grid.rows[j], true);
                return;
            }
        }
    },
    
    
    selectNext : function(keepExisting){
        if(this.lastSelectedRow){
            for(var j = (this.lastSelectedRow.rowIndex+1); j < this.grid.rows.length; j++){
                var row = this.grid.rows[j];
                if(this.isSelectable(row)){
                    this.focusRow(row);
                    this.setRowState(row, true, keepExisting);
                    return;
                }
            }
        }
    },
    
    
    selectPrevious : function(keepExisting){
        if(this.lastSelectedRow){
            for(var j = (this.lastSelectedRow.rowIndex-1); j >= 0; j--){
                var row = this.grid.rows[j];
                if(this.isSelectable(row)){
                    this.focusRow(row);
                    this.setRowState(row, true, keepExisting);
                    return;
                }
            }
        }
    },
    
    
    getSelectedRows : function(){
        return this.selectedRows;
    },
    
    
    getSelectedRowIds : function(){
        return this.selectedRowIds;
    },
    
    
    clearSelections : function(){
        if(this.isLocked()) return;
        var oldSelections = this.selectedRows.concat();
        for(var j = 0; j < oldSelections.length; j++){
            this.setRowState(oldSelections[j], false);
        }
        this.selectedRows = [];
        this.selectedRowIds = [];
    },
    
        
    
    selectAll : function(){
        if(this.isLocked()) return;
        this.selectedRows = [];
        this.selectedRowIds = [];
        for(var j = 0, len = this.grid.rows.length; j < len; j++){
            this.setRowState(this.grid.rows[j], true, true);
        }
    },
    
    
    hasSelection : function(){
        return this.selectedRows.length > 0;
    },
    
    
    isSelected : function(row){
        return row && (row.selected === true || row.getAttribute('selected') == 'true');
    },
    
    
    isSelectable : function(row){
        return row && row.getAttribute('selectable') != 'false';
    },
    
    
    rowClick : function(grid, rowIndex, e){
        if(this.isLocked()) return;
        var row = grid.getRow(rowIndex);
        if(this.isSelectable(row)){
            if(e.shiftKey && this.lastSelectedRow){
                var lastIndex = this.lastSelectedRow.rowIndex;
                this.selectRange(this.lastSelectedRow, row, e.ctrlKey);
                this.lastSelectedRow = this.grid.el.dom.rows[lastIndex];
            }else{
                this.focusRow(row);
                var rowState = e.ctrlKey ? !this.isSelected(row) : true;
                this.setRowState(row, rowState, e.hasModifier());
            }
        }
    },
    
    
    focusRow : function(row){
    	this.grid.view.focusRow(row);
    },

    
    selectRow : function(row, keepExisting){
        this.setRowState(this.getRow(row), true, keepExisting);
    },
    
    
    selectRows : function(rows, keepExisting){
        if(!keepExisting){
            this.clearSelections();
        }
        for(var i = 0; i < rows.length; i++){
            this.selectRow(rows[i], true);
        }
    },
    
    
    deselectRow : function(row){
        this.setRowState(this.getRow(row), false);
    },
    
    
    getRow : function(row){
        if(typeof row == 'number'){
            row = this.grid.rows[row];
        }
        return row;
    },
    
    
    selectRange : function(startRow, endRow, keepExisting){
        startRow = this.getRow(startRow);
        endRow = this.getRow(endRow);
        this.setRangeState(startRow, endRow, true, keepExisting);
    },
    
    
    deselectRange : function(startRow, endRow){
        startRow = this.getRow(startRow);
        endRow = this.getRow(endRow);
        this.setRangeState(startRow, endRow, false, true);
    },
    
    
    setRowStateFromChild : function(childEl, selected, keepExisting){
        var row = this.grid.getRowFromChild(childEl);
        this.setRowState(row, selected, keepExisting);
    },
    
    
    setRangeState : function(startRow, endRow, selected, keepExisting){
        if(this.isLocked()) return;
        if(!keepExisting){
            this.clearSelections();
        }
        var curRow = startRow;
        while(curRow.rowIndex != endRow.rowIndex){
            this.setRowState(curRow, selected, true);
            curRow = (startRow.rowIndex < endRow.rowIndex ? 
                        this.grid.getRowAfter(curRow) : this.grid.getRowBefore(curRow))
        }
        this.setRowState(endRow, selected, true);
    },
    
    
    setRowState : function(row, selected, keepExisting){
        if(this.isLocked()) return;
        if(this.isSelectable(row)){
            if(selected){
                if(!keepExisting){
                    this.clearSelections();
                }
                this.setRowClass(row, 'selected');
                row.selected = true;
                this.selectedRows.push(row);
                this.selectedRowIds.push(this.grid.dataModel.getRowId(row.rowIndex));
                this.lastSelectedRow = row;
            }else{
                this.setRowClass(row, '');
                row.selected = false;
                this._removeSelected(row);
            }
            this.fireEvent('rowselect', this, row, selected);
            this.fireEvent('selectionchange', this, this.selectedRows, this.selectedRowIds);
        }
    },

    
    handleOver : function(e){
        var row = this.grid.getRowFromChild(e.getTarget());
        if(this.isSelectable(row) && !this.isSelected(row)){
            this.setRowClass(row, 'over');
        }
    },
    
    
    handleOut : function(e){
        var row = this.grid.getRowFromChild(e.getTarget());
        if(this.isSelectable(row) && !this.isSelected(row)){
            this.setRowClass(row, '');
        }
    },
    
    
    keyDown : function(e){
        if(e.browserEvent.keyCode == e.DOWN){
            this.selectNext(e.shiftKey);
            e.preventDefault();
        }else if(e.browserEvent.keyCode == e.UP){
            this.selectPrevious(e.shiftKey);
            e.preventDefault();
        }
    },

    
    setRowClass : function(row, cssClass){
        if(this.isSelectable(row)){
            if(cssClass == 'selected'){
                YAHOO.util.Dom.removeClass(row, 'ygrid-row-over');
                YAHOO.util.Dom.addClass(row, 'ygrid-row-selected');
            }else if(cssClass == 'over'){
                YAHOO.util.Dom.removeClass(row, 'ygrid-row-selected');
                YAHOO.util.Dom.addClass(row, 'ygrid-row-over');
            }else if(cssClass == ''){
                YAHOO.util.Dom.removeClass(row, 'ygrid-row-selected');
                YAHOO.util.Dom.removeClass(row, 'ygrid-row-over');
            }
        }
    },
    
    
    _removeSelected : function(row){
        var sr = this.selectedRows;
        for (var i = 0; i < sr.length; i++) {
          if (sr[i] === row){
              this.selectedRows.splice(i, 1);
              this.selectedRowIds.splice(i, 1);
              return;
          }
        }
    }
};


YAHOO.ext.grid.SingleSelectionModel = function(){
    YAHOO.ext.grid.SingleSelectionModel.superclass.constructor.call(this);
};

YAHOO.extendX(YAHOO.ext.grid.SingleSelectionModel, YAHOO.ext.grid.DefaultSelectionModel);


YAHOO.ext.grid.SingleSelectionModel.prototype.setRowState = function(row, selected){
    YAHOO.ext.grid.SingleSelectionModel.superclass.setRowState.call(this, row, selected, false);
};

YAHOO.ext.grid.DisableSelectionModel = function(){
    YAHOO.ext.grid.DisableSelectionModel.superclass.constructor.call(this);
};

YAHOO.extendX(YAHOO.ext.grid.DisableSelectionModel, YAHOO.ext.grid.DefaultSelectionModel);

YAHOO.ext.grid.DisableSelectionModel.prototype.initEvents = function(){
};


YAHOO.ext.grid.EditorSelectionModel = function(){
    YAHOO.ext.grid.EditorSelectionModel.superclass.constructor.call(this);
    
    this.clicksToActivateCell = 1;
    this.events['cellactivate'] = new YAHOO.util.CustomEvent('cellactivate');
};

YAHOO.extendX(YAHOO.ext.grid.EditorSelectionModel, YAHOO.ext.grid.DefaultSelectionModel);

YAHOO.ext.grid.EditorSelectionModel.prototype.disableArrowNavigation = false;
YAHOO.ext.grid.EditorSelectionModel.prototype.controlForArrowNavigation = false;


YAHOO.ext.grid.EditorSelectionModel.prototype.initEvents = function(){
    this.grid.addListener("cellclick", this.onCellClick, this, true);
    this.grid.addListener("celldblclick", this.onCellDblClick, this, true);
    this.grid.addListener("keydown", this.keyDown, this, true);
};

YAHOO.ext.grid.EditorSelectionModel.prototype.onCellClick = function(grid, rowIndex, colIndex){
    if(this.clicksToActivateCell == 1){
        var row = this.grid.getRow(rowIndex);
        var cell = row.childNodes[colIndex];
        if(cell){
            this.activate(row, cell);
        }
    }
};

YAHOO.ext.grid.EditorSelectionModel.prototype.activate = function(row, cell){
    this.fireEvent('cellactivate', this, row, cell);
    this.grid.doEdit(row, cell);
};

YAHOO.ext.grid.EditorSelectionModel.prototype.onCellDblClick = function(grid, rowIndex, colIndex){
    if(this.clicksToActivateCell == 2){
        var row = this.grid.getRow(rowIndex);
        var cell = row.childNodes[colIndex];
        if(cell){
            this.activate(row, cell);
        }
    }
};


YAHOO.ext.grid.EditorSelectionModel.prototype.setRowState = function(row, selected){
    YAHOO.ext.grid.EditorSelectionModel.superclass.setRowState.call(this, row, false, false);
};

YAHOO.ext.grid.EditorSelectionModel.prototype.focusRow = function(row, selected){
};

YAHOO.ext.grid.EditorSelectionModel.prototype.getEditorCellAfter = function(cell, spanRows){
    var g = this.grid;
    var next = g.getCellAfter(cell);
    while(next && !g.colModel.isCellEditable(next.columnIndex)){
        next = g.getCellAfter(next);
    }
    if(!next && spanRows){
        var row = g.getRowAfter(g.getRowFromChild(cell));
        if(row){
            next = g.getFirstCell(row);
            if(!g.colModel.isCellEditable(next.columnIndex)){
                next = this.getEditorCellAfter(next);
            }
        }
    }
    return next;
};

YAHOO.ext.grid.EditorSelectionModel.prototype.getEditorCellBefore = function(cell, spanRows){
    var g = this.grid;
    var prev = g.getCellBefore(cell);
    while(prev && !g.colModel.isCellEditable(prev.columnIndex)){
        prev = g.getCellBefore(prev);
    }
    if(!prev && spanRows){
        var row = g.getRowBefore(g.getRowFromChild(cell));
        if(row){
            prev = g.getLastCell(row);
            if(!g.colModel.isCellEditable(prev.columnIndex)){
               prev = this.getEditorCellBefore(prev);
            }
        }
    }
    return prev;
};

YAHOO.ext.grid.EditorSelectionModel.prototype.allowArrowNav = function(e){
    return (!this.disableArrowNavigation && (!this.controlForArrowNavigation || e.ctrlKey));
}

YAHOO.ext.grid.EditorSelectionModel.prototype.keyDown = function(e){
    var g = this.grid, cm = g.colModel, cell = g.getEditingCell();
    if(!cell) return;
    var newCell;
    switch(e.browserEvent.keyCode){
         case e.TAB:
             if(e.shiftKey){
                 newCell = this.getEditorCellBefore(cell, true);
             }else{
                 newCell = this.getEditorCellAfter(cell, true);
             }
             e.preventDefault();
         break;
         case e.DOWN:
             if(this.allowArrowNav(e)){
                 var next = g.getRowAfter(g.getRowFromChild(cell));
                 if(next){
                     newCell = next.childNodes[cell.columnIndex];
                 }
             }
         break;
         case e.UP:
             if(this.allowArrowNav(e)){
                 var prev = g.getRowBefore(g.getRowFromChild(cell));
                 if(prev){
                     newCell = prev.childNodes[cell.columnIndex];
                 }
             }
         break;
         case e.RETURN:
             if(e.shiftKey){
                 var prev = g.getRowBefore(g.getRowFromChild(cell));
                 if(prev){
                     newCell = prev.childNodes[cell.columnIndex];
                 }
             }else{
                 var next = g.getRowAfter(g.getRowFromChild(cell));
                 if(next){
                     newCell = next.childNodes[cell.columnIndex];
                 }
             }
         break;
         case e.RIGHT:
             if(this.allowArrowNav(e)){
                 newCell = this.getEditorCellAfter(cell);
             }
         break;
         case e.LEFT:
             if(this.allowArrowNav(e)){
                 newCell = this.getEditorCellBefore(cell);
             }
         break;
    };
    if(newCell){
        this.activate(g.getRowFromChild(newCell), newCell);
        e.stopEvent();
    }
};


YAHOO.ext.grid.EditorAndSelectionModel = function(){
    YAHOO.ext.grid.EditorAndSelectionModel.superclass.constructor.call(this);
    this.events['cellactivate'] = new YAHOO.util.CustomEvent('cellactivate');
};

YAHOO.extendX(YAHOO.ext.grid.EditorAndSelectionModel, YAHOO.ext.grid.DefaultSelectionModel);

YAHOO.ext.grid.EditorAndSelectionModel.prototype.initEvents = function(){
    YAHOO.ext.grid.EditorAndSelectionModel.superclass.initEvents.call(this);
    this.grid.addListener("celldblclick", this.onCellDblClick, this, true);
};

YAHOO.ext.grid.EditorAndSelectionModel.prototype.onCellDblClick = function(grid, rowIndex, colIndex){
    var row = this.grid.getRow(rowIndex);
    var cell = row.childNodes[colIndex];
    if(cell){
        this.fireEvent('cellactivate', this, row, cell);
        this.grid.doEdit(row, cell);
    }
}; 

YAHOO.ext.grid.CellEditor = function(element){
    this.colIndex = null;
    this.rowIndex = null;
    this.grid = null;
    this.editing = false;
    this.originalValue = null;
    this.element = getEl(element, true);
    this.element.addClass('ygrid-editor');
    this.element.dom.tabIndex = 1;
    this.initialized = false;
    this.callback = null;
};

YAHOO.ext.grid.CellEditor.prototype = {
    init : function(grid, bodyElement, callback){
        
        
        
        if(this.initialized) return;
        this.initialized = true;
        this.callback = callback;
        this.grid = grid;
        bodyElement.appendChild(this.element.dom);
        this.initEvents();
    },
    
    initEvents : function(){
        var stopOnEnter = function(e){
            if(e.browserEvent.keyCode == e.RETURN){
                this.stopEditing(true);
            }else if(e.browserEvent.keyCode == e.ESC){
                this.setValue(this.originalValue);
                this.stopEditing(true);
            }
        }
        this.element.mon('keydown', stopOnEnter, this, true);
        this.element.on('blur', this.stopEditing, this, true);
    },

    startEditing : function(value, row, cell){
        this.originalValue = value;
        this.rowIndex = row.rowIndex;
        this.colIndex = cell.columnIndex;
        this.cell = cell;
        this.setValue(value);
        var cellbox = getEl(cell, true).getBox();
        this.fitToCell(cellbox);
        this.editing = true;
        this.show();
    },
     
    stopEditing : function(focusCell){
         if(this.editing){
             this.editing = false;
             var newValue = this.getValue();
             this.hide();
             
             if(this.originalValue != newValue){
                this.callback(newValue, this.rowIndex, this.colIndex);
             }
         }
     },
     
    setValue : function(value){
        this.element.dom.value = value;
    },
    
    getValue : function(){
        return this.element.dom.value;
    },
    
    fitToCell : function(box){
        this.element.setBox(box, true);
    },
    
    show : function(){
        this.element.show();
        this.element.focus();
    },
    
    hide : function(){
        try{
            this.element.dom.blur();
        }catch(e){}
        this.element.hide();
    }
};

YAHOO.ext.grid.CheckboxEditor = function(){
    var div = document.createElement('span');
    div.className = 'ygrid-editor ygrid-checkbox-editor';
    var cb = document.createElement('input');
    cb.type = 'checkbox';
    cb.setAttribute('autocomplete', 'off');
    div.appendChild(cb);
    document.body.appendChild(div);
    YAHOO.ext.grid.CheckboxEditor.superclass.constructor.call(this, div);
    div.tabIndex = '';
    cb.tabIndex = 1;
    this.cb = getEl(cb, true);
};

YAHOO.extendX(YAHOO.ext.grid.CheckboxEditor, YAHOO.ext.grid.CellEditor);

YAHOO.ext.grid.CheckboxEditor.prototype.fitToCell = function(box){
    this.element.setBox(box, true);
};

YAHOO.ext.grid.CheckboxEditor.prototype.setValue = function(value){
     this.cb.dom.checked = (value === true || value === 'true' || value === 1 || value === '1');
};

YAHOO.ext.grid.CheckboxEditor.prototype.getValue = function(){
     return this.cb.dom.checked;
};

YAHOO.ext.grid.CheckboxEditor.prototype.show = function(){
    this.element.show();
    this.cb.focus();
};

YAHOO.ext.grid.CheckboxEditor.prototype.initEvents = function(){
    var stopOnEnter = function(e){
        if(e.browserEvent.keyCode == e.RETURN){
            this.stopEditing(true);
        }else if(e.browserEvent.keyCode == e.ESC){
            this.setValue(this.originalValue);
            this.stopEditing(true);
        }
    }
    this.cb.mon('keydown', stopOnEnter, this, true);
    this.cb.on('blur', this.stopEditing, this, true);
};

YAHOO.ext.grid.CheckboxEditor.prototype.hide = function(){
    try{
        this.cb.dom.blur();
    }catch(e){}
    this.element.hide();
};

YAHOO.ext.grid.DateEditor = function(config){
    var div = document.createElement('span');
    div.className = 'ygrid-editor ygrid-editor-container';
    
    var element = document.createElement('input');
    element.type = 'text';
    element.tabIndex = 1;
    element.setAttribute('autocomplete', 'off');
    div.appendChild(element);
    
    var pick = document.createElement('span');
    pick.className = 'pick-button';
    div.appendChild(pick);
    
    document.body.appendChild(div);
    
    this.div = getEl(div, true);
    this.element = getEl(element, true);
    this.pick = getEl(pick, true);
    
    this.colIndex = null;
    this.rowIndex = null;
    this.grid = null;
    this.editing = false;
    this.originalValue = null;
    this.initialized = false;
    this.callback = null;
    
    this.cal = null;
    this.mouseDownHandler = YAHOO.ext.EventManager.wrap(this.handleMouseDown, this, true);
    
    YAHOO.ext.util.Config.apply(this, config);
    if(typeof this.minValue == 'string') this.minValue = this.parseDate(this.minValue);
    if(typeof this.maxValue == 'string') this.maxValue = this.parseDate(this.maxValue);
    this.ddMatch = /ddnone/;
    if(this.disabledDates){
        var dd = this.disabledDates;
        var re = "(?:";
        for(var i = 0; i < dd.length; i++){
            re += dd[i];
            if(i != dd.length-1) re += "|";
        }
        this.ddMatch = new RegExp(re + ")");
    }
};

YAHOO.ext.grid.DateEditor.prototype = {
    init : function(grid, bodyElement, callback){
        if(this.initialized) return;
        
        this.initialized = true;
        this.callback = callback;
        this.grid = grid;
        bodyElement.appendChild(this.div.dom);
        this.initEvents();
    },
    
    initEvents : function(){
         var stopOnEnter = function(e){
            if(e.browserEvent.keyCode == e.RETURN){
                this.stopEditing(true);
            }else if(e.browserEvent.keyCode == e.ESC){
                this.setValue(this.originalValue);
                this.stopEditing(true);
            }
        }
        this.element.mon('keydown', stopOnEnter, this, true);
        var vtask = new YAHOO.ext.util.DelayedTask(this.validate, this);
        this.element.mon('keyup', vtask.delay.createDelegate(vtask, [this.validationDelay]));
        this.pick.on('click', this.showCalendar, this, true);
    },
    
    startEditing : function(value, row, cell){
        this.originalValue = value;
        this.rowIndex = row.rowIndex;
        this.colIndex = cell.columnIndex;
        this.cell = cell;
        this.setValue(value);
        this.validate();
        var cellbox = getEl(cell, true).getBox();
        this.div.setBox(cellbox, true);
        this.element.setWidth(cellbox.width-this.pick.getWidth());
        this.editing = true;
        YAHOO.util.Event.on(document, "mousedown", this.mouseDownHandler);
        this.show();
    },
     
     stopEditing : function(focusCell){
         if(this.editing){
             YAHOO.util.Event.removeListener(document, "mousedown", this.mouseDownHandler);
             this.editing = false;
             var newValue = this.getValue();
             this.hide();
             
             if(this.originalValue != newValue){
                this.callback(newValue, this.rowIndex, this.colIndex);
             }
         }
     },
    
    setValue : function(value){
        this.element.dom.value = this.formatDate(value);
        this.validate();
    },
    
    getValue : function(){
        if(!this.validate()){
           return this.originalValue;
       }else{
           var value = this.element.dom.value;
           if(value.length < 1){
               return value;
           } else{
               return this.parseDate(value);
           }
       }   
    },
    
    show : function() {
        this.div.show();
        this.element.focus();
        this.validate();
    },
    
    hide : function(){
        try{
            this.element.dom.blur();
        }catch(e){}
        this.div.hide();
    },
    
    validate : function(){
        var dom = this.element.dom;
        var value = dom.value;
        if(value.length < 1){ 
             if(this.allowBlank){
                 dom.title = '';
                 this.element.removeClass('ygrid-editor-invalid');
                 return true;
             }else{
                 dom.title = this.blankText;
                 this.element.addClass('ygrid-editor-invalid');
                 return false;
             }
        }
        value = this.parseDate(value);
        if(!value){
            dom.title = this.invalidText.replace('%0', dom.value).replace('%1', this.format);
            this.element.addClass('ygrid-editor-invalid');
            return false;
        }
        var time = value.getTime();
        if(this.minValue && time < this.minValue.getTime()){
            dom.title = this.minText.replace('%0', this.formatDate(this.minValue));
            this.element.addClass('ygrid-editor-invalid');
            return false;
        }
        if(this.maxValue && time > this.maxValue.getTime()){
            dom.title = this.maxText.replace('%0', this.formatDate(this.maxValue));
            this.element.addClass('ygrid-editor-invalid');
            return false;
        }
        if(this.disabledDays){
            var day = value.getDay();
            for(var i = 0; i < this.disabledDays.length; i++) {
            	if(day === this.disabledDays[i]){
            	    dom.title = this.disabledDaysText;
                    this.element.addClass('ygrid-editor-invalid');
                    return false;
            	}
            }
        }
        var fvalue = this.formatDate(value);
        if(this.ddMatch.test(fvalue)){
            dom.title = this.disabledDatesText.replace('%0', fvalue);
            this.element.addClass('ygrid-editor-invalid');
            return false;
        }
        var msg = this.validator(value);
        if(msg !== true){
            dom.title = msg;
            this.element.addClass('ygrid-editor-invalid');
            return false;
        }
        dom.title = '';
        this.element.removeClass('ygrid-editor-invalid');
        return true;
    },
    
    handleMouseDown : function(e){
        var t = e.getTarget();
        var dom = this.div.dom;
        if(t != dom && !YAHOO.util.Dom.isAncestor(dom, t)){
            this.stopEditing();
        }
    },
    
    showCalendar : function(value){
        if(this.cal == null){
            this.cal = new YAHOO.ext.DatePicker(this.div.dom.parentNode.parentNode);
        }
        this.cal.minDate = this.minValue;
        this.cal.maxDate = this.maxValue;
        this.cal.disabledDatesRE = this.ddMatch;
        this.cal.disabledDatesText = this.disabledDatesText;
        this.cal.disabledDays = this.disabledDays;
        this.cal.disabledDaysText = this.disabledDaysText;
        this.cal.format = this.format;
        if(this.minValue){
            this.cal.minText = this.minText.replace('%0', this.formatDate(this.minValue));
        }
        if(this.maxValue){
            this.cal.maxText = this.maxText.replace('%0', this.formatDate(this.maxValue));
        }
        var r = this.div.getRegion();
        this.cal.show(r.left, r.bottom, this.getValue(), this.setValue.createDelegate(this));
    },
    
    parseDate : function(value){
        if(!value || value instanceof Date) return value;
        return Date.parseDate(value, this.format);
    },
    
    formatDate : function(date){
        if(!date || !(date instanceof Date)) return date;
        return date.format(this.format);
    }
};

YAHOO.ext.grid.DateEditor.prototype.format = 'm/d/y';
YAHOO.ext.grid.DateEditor.prototype.disabledDays = null;
YAHOO.ext.grid.DateEditor.prototype.disabledDaysText = '';
YAHOO.ext.grid.DateEditor.prototype.disabledDates = null;
YAHOO.ext.grid.DateEditor.prototype.disabledDatesText = '';
YAHOO.ext.grid.DateEditor.prototype.allowBlank = true;
YAHOO.ext.grid.DateEditor.prototype.minValue = null;
YAHOO.ext.grid.DateEditor.prototype.maxValue = null;
YAHOO.ext.grid.DateEditor.prototype.minText = 'The date in this field must be after %0';
YAHOO.ext.grid.DateEditor.prototype.maxText = 'The date in this field must be before %0';
YAHOO.ext.grid.DateEditor.prototype.blankText = 'This field cannot be blank';
YAHOO.ext.grid.DateEditor.prototype.invalidText = '%0 is not a valid date - it must be in the format %1';
YAHOO.ext.grid.DateEditor.prototype.validationDelay = 200;
YAHOO.ext.grid.DateEditor.prototype.validator = function(){return true;};

YAHOO.ext.grid.NumberEditor = function(config){
    var element = document.createElement('input');
    element.type = 'text';
    element.className = 'ygrid-editor ygrid-num-editor';
    element.setAttribute('autocomplete', 'off');
    document.body.appendChild(element);
    YAHOO.ext.grid.NumberEditor.superclass.constructor.call(this, element);
    YAHOO.ext.util.Config.apply(this, config);
};
YAHOO.extendX(YAHOO.ext.grid.NumberEditor, YAHOO.ext.grid.CellEditor);

YAHOO.ext.grid.NumberEditor.prototype.initEvents = function(){
    var stopOnEnter = function(e){
        if(e.browserEvent.keyCode == e.RETURN){
            this.stopEditing(true);
        }else if(e.browserEvent.keyCode == e.ESC){
            this.setValue(this.originalValue);
            this.stopEditing(true);
        }
    };
    
    var allowed = "0123456789";
    if(this.allowDecimals){
        allowed += this.decimalSeparator;
    }
    if(this.allowNegative){
        allowed += '-';
    }
    var keyPress = function(e){
        var c = e.getCharCode();
        if(c != e.BACKSPACE && allowed.indexOf(String.fromCharCode(c)) === -1){
            e.stopEvent();
        }
    };
    this.element.mon('keydown', stopOnEnter, this, true);
    var vtask = new YAHOO.ext.util.DelayedTask(this.validate, this);
    this.element.mon('keyup', vtask.delay.createDelegate(vtask, [this.validationDelay]));
    this.element.mon('keypress', keyPress, this, true);
    this.element.on('blur', this.stopEditing, this, true);
};

YAHOO.ext.grid.NumberEditor.prototype.validate = function(){
    var dom = this.element.dom;
    var value = dom.value;
    if(value.length < 1){ 
         if(this.allowBlank){
             dom.title = '';
             this.element.removeClass('ygrid-editor-invalid');
             return true;
         }else{
             dom.title = this.blankText;
             this.element.addClass('ygrid-editor-invalid');
             return false;
         }
    }
    if(value.search(/\d+/) === -1){
        dom.title = this.nanText.replace('%0', value);
        this.element.addClass('ygrid-editor-invalid');
        return false;
    }
    var num = this.parseValue(value);
    if(num < this.minValue){
        dom.title = this.minText.replace('%0', this.minValue);
        this.element.addClass('ygrid-editor-invalid');
        return false;
    }
    if(num > this.maxValue){
        dom.title = this.maxText.replace('%0', this.maxValue);
        this.element.addClass('ygrid-editor-invalid');
        return false;
    }
    var msg = this.validator(value);
    if(msg !== true){
        dom.title = msg;
        this.element.addClass('ygrid-editor-invalid');
        return false;
    }
    dom.title = '';
    this.element.removeClass('ygrid-editor-invalid');
    return true;
};

YAHOO.ext.grid.NumberEditor.prototype.show = function(){
    this.element.dom.title = '';
    YAHOO.ext.grid.NumberEditor.superclass.show.call(this);
    if(this.selectOnFocus){
        try{
            this.element.dom.select();
        }catch(e){}
    }
    this.validate(this.element.dom.value);
};

YAHOO.ext.grid.NumberEditor.prototype.getValue = function(){
   if(!this.validate()){
       return this.originalValue;
   }else{
       var value = this.element.dom.value;
       if(value.length < 1){
           return value;
       } else{
           return this.fixPrecision(this.parseValue(value));
       }
   }   
};
YAHOO.ext.grid.NumberEditor.prototype.parseValue = function(value){
    return parseFloat(new String(value).replace(this.decimalSeparator, '.'));
};

YAHOO.ext.grid.NumberEditor.prototype.fixPrecision = function(value){
   if(!this.allowDecimals || this.decimalPrecision == -1 || isNaN(value) || value == 0 || !value){
       return value;
   }
   
   
   
   
   
   
   var scale = Math.pow(10, this.decimalPrecision+1);
   var fixed = this.decimalPrecisionFcn(value * scale);
   fixed = this.decimalPrecisionFcn(fixed/10);
   return fixed / (scale/10);
};

YAHOO.ext.grid.NumberEditor.prototype.allowBlank = true;
YAHOO.ext.grid.NumberEditor.prototype.allowDecimals = true;
YAHOO.ext.grid.NumberEditor.prototype.decimalSeparator = '.';
YAHOO.ext.grid.NumberEditor.prototype.decimalPrecision = 2;
YAHOO.ext.grid.NumberEditor.prototype.decimalPrecisionFcn = Math.floor;
YAHOO.ext.grid.NumberEditor.prototype.allowNegative = true;
YAHOO.ext.grid.NumberEditor.prototype.selectOnFocus = true;
YAHOO.ext.grid.NumberEditor.prototype.minValue = Number.NEGATIVE_INFINITY;
YAHOO.ext.grid.NumberEditor.prototype.maxValue = Number.MAX_VALUE;
YAHOO.ext.grid.NumberEditor.prototype.minText = 'The minimum value for this field is %0';
YAHOO.ext.grid.NumberEditor.prototype.maxText = 'The maximum value for this field is %0';
YAHOO.ext.grid.NumberEditor.prototype.blankText = 'This field cannot be blank';
YAHOO.ext.grid.NumberEditor.prototype.nanText = '%0 is not a valid number';
YAHOO.ext.grid.NumberEditor.prototype.validationDelay = 100;
YAHOO.ext.grid.NumberEditor.prototype.validator = function(){return true;};
YAHOO.ext.DatePicker = function(id, parentElement){
    this.id = id;
    this.selectedDate = new Date();
    this.visibleDate = new Date();
    this.element = null;
    this.shadow = null;
    this.callback = null;
    this.buildControl(parentElement || document.body);
    this.mouseDownHandler = YAHOO.ext.EventManager.wrap(this.handleMouseDown, this, true);
    this.keyDownHandler = YAHOO.ext.EventManager.wrap(this.handleKeyDown, this, true);
    this.wheelHandler = YAHOO.ext.EventManager.wrap(this.handleMouseWheel, this, true);
};

YAHOO.ext.DatePicker.prototype = {
    show : function(x, y, value, callback){
        this.hide();
        this.selectedDate = value;
        this.visibleDate = value;
        this.callback = callback;
        this.refresh();
        this.element.show();
        this.element.setXY(this.constrainToViewport ? this.constrainXY(x, y) : [x, y]);
        this.shadow.show();
        this.shadow.setRegion(this.element.getRegion());
        this.element.dom.tabIndex = 1;
        this.element.focus();
        YAHOO.util.Event.on(document, "mousedown", this.mouseDownHandler);
        YAHOO.util.Event.on(document, "keydown", this.keyDownHandler);
        YAHOO.util.Event.on(document, "mousewheel", this.wheelHandler);
        YAHOO.util.Event.on(document, "DOMMouseScroll", this.wheelHandler);
    },
    
    constrainXY : function(x, y){
        var w = YAHOO.util.Dom.getViewportWidth();
        var h = YAHOO.util.Dom.getViewportHeight();
        var size = this.element.getSize();
        return [
            Math.min(w-size.width, x),
            Math.min(h-size.height, y)
        ];
    },
    
    hide : function(){
        this.shadow.hide();
        this.element.hide();
        YAHOO.util.Event.removeListener(document, "mousedown", this.mouseDownHandler);
        YAHOO.util.Event.removeListener(document, "keydown", this.keyDownHandler);
        YAHOO.util.Event.removeListener(document, "mousewheel", this.wheelHandler);
        YAHOO.util.Event.removeListener(document, "DOMMouseScroll", this.wheelHandler);
    },
    
    setSelectedDate : function(date){
        this.selectedDate = date;
    },
    
    getSelectedDate : function(){
        return this.selectedDate;
    },
    
    showPrevMonth : function(){
        this.visibleDate = this.getPrevMonth(this.visibleDate);
        this.refresh();
    },
    
    showNextMonth : function(){
        this.visibleDate = this.getNextMonth(this.visibleDate);
        this.refresh();
    },
    
    showPrevYear : function(){
        var d = this.visibleDate;
        this.visibleDate = new Date(d.getFullYear()-1, d.getMonth(), d.getDate());
        this.refresh();
    },
    
    showNextYear : function(){
        var d = this.visibleDate;
        this.visibleDate = new Date(d.getFullYear()+1, d.getMonth(), d.getDate());
        this.refresh();
    },
    
    handleMouseDown : function(e){
        var target = e.getTarget();
        if(target != this.element.dom && !YAHOO.util.Dom.isAncestor(this.element.dom, target)){
            this.hide();
        }
    },
    
    handleKeyDown : function(e){
        switch(e.browserEvent.keyCode){
            case e.LEFT:
                this.showPrevMonth();
                e.stopEvent();
            break;
            case e.RIGHT:
                this.showNextMonth();
                e.stopEvent();
            break;
            case e.DOWN:
                this.showPrevYear();
                e.stopEvent();
            break;
            case e.UP:
                this.showNextYear();
                e.stopEvent();
            break;
        }
    },
    
    handleMouseWheel : function(e){
        var delta = e.getWheelDelta();
        if(delta > 0){
            this.showPrevMonth();
            e.stopEvent();
        } else if(delta < 0){
            this.showNextMonth();
            e.stopEvent();
        }
    },
    
    handleClick : function(e){
        var d = this.visibleDate;
        var t = e.getTarget();
        if(t && t.className){
            switch(t.className){
                case 'active':
                    this.handleSelection(new Date(d.getFullYear(), d.getMonth(), parseInt(t.innerHTML)));
                break;
                case 'prevday':
                    var p = this.getPrevMonth(d);
                    this.handleSelection(new Date(p.getFullYear(), p.getMonth(), parseInt(t.innerHTML)));
                break;
                case 'nextday':
                    var n = this.getNextMonth(d);
                    this.handleSelection(new Date(n.getFullYear(), n.getMonth(), parseInt(t.innerHTML)));
                break;
                case 'ypopcal-today':
                    this.handleSelection(new Date());
                break;
                case 'next-month':
                    this.showNextMonth();
                break;
                case 'prev-month':
                    this.showPrevMonth();
                break;
            }   
        }
        e.stopEvent();
    },
    
    selectToday : function(){
        this.handleSelection(new Date());
    },
    
    handleSelection: function(date){
        this.selectedDate = date;
        this.callback(date);
        this.hide();    
    },
    
    getPrevMonth : function(d){
        var m = d.getMonth();var y = d.getFullYear();
        return (m == 0 ? new Date(--y, 11, 1) : new Date(y, --m, 1));
    },
    
    getNextMonth : function(d){
        var m = d.getMonth();var y = d.getFullYear();
        return (m == 11 ? new Date(++y, 0, 1) : new Date(y, ++m, 1));
    },
    
    getDaysInMonth : function(m, y){
        return (m == 1 || m == 3 || m == 5 || m == 7 || m == 8 || m == 10 || m == 12) ? 31 : (m == 4 || m == 6 || m == 9 || m == 11) ? 30 : this.isLeapYear(y) ? 29 : 28;
    },
    
    isLeapYear : function(y){
        return (((y % 4) == 0) && ((y % 100) != 0) || ((y % 400) == 0));
    },
    
    clearTime : function(date){
        if(date){
            date.setHours(0);
            date.setMinutes(0);
            date.setSeconds(0);
            date.setMilliseconds(0);
        }
        return date;
    },
    
    refresh : function(){
        var d = this.visibleDate;
        this.buildInnerCal(d);
        this.calHead.update(this.monthNames[d.getMonth()] + ' ' + d.getFullYear());
        if(this.element.isVisible()){
            this.shadow.setRegion(this.element.getRegion());
        }
    }
};

 
YAHOO.ext.DatePicker.prototype.buildControl = function(parentElement){
    var c = document.createElement('div');
    c.style.position = 'absolute';
    c.style.visibility = 'hidden';
    document.body.appendChild(c);
    var html = '<iframe id="'+this.id+'_shdw" frameborder="0" style="position:absolute; z-index:2000; display:none; top:0px; left:0px;" class="ypopcal-shadow"></iframe>' +
    '<div hidefocus="true" class="ypopcal" id="'+this.id+'" style="-moz-outline:none; position:absolute; z-index:2001; display:none; top:0px; left:0px;">' +
    '<table class="ypopcal-head" border=0 cellpadding=0 cellspacing=0><tbody><tr><td class="ypopcal-arrow"><div class="prev-month">&#160;</div></td><td class="ypopcal-month">&#160;</td><td class="ypopcal-arrow"><div class="next-month">&#160;</div></td></tr></tbody></table>' +
    '<center><div class="ypopcal-inner">';
    html += "<table border=0 cellpadding=2 cellspacing=0 class=\"ypopcal-table\"><thead><tr class=\"ypopcal-daynames\">";
    var names = this.dayNames;
    for(var i = 0; i < names.length; i++){
        html += '<td>' + names[i].substr(0, 1) + '</td>';
    }
    html+= "</tr></thead><tbody><tr>";
    for(var i = 0; i < 42; i++) {
        if(i % 7 == 0 && i != 0){
            html += '</tr><tr>';
        }
        html += "<td>&nbsp;</td>";
    }
    html += "</tr></tbody></table>";
    html += '</div><button class="ypopcal-today" style="margin-top:2px;">'+this.todayText+'</button></center></div>';
    c.innerHTML = html;
    this.shadow = getEl(c.childNodes[0], true);
    this.shadow.enableDisplayMode();
    this.element = getEl(c.childNodes[1], true);
    this.element.enableDisplayMode();
    document.body.appendChild(this.shadow.dom);
    document.body.appendChild(this.element.dom);
    document.body.removeChild(c);
    this.element.on("selectstart", function(){return false;});
    var tbody = this.element.dom.getElementsByTagName('tbody')[1];
    this.cells = tbody.getElementsByTagName('td');
    this.calHead = this.element.getChildrenByClassName('ypopcal-month', 'td')[0];
    this.element.mon('mousedown', this.handleClick, this, true);
};

YAHOO.ext.DatePicker.prototype.buildInnerCal = function(dateVal){
    var days = this.getDaysInMonth(dateVal.getMonth() + 1, dateVal.getFullYear());
    var firstOfMonth = new Date(dateVal.getFullYear(), dateVal.getMonth(), 1);
    var startingPos = firstOfMonth.getDay();
    if(startingPos == 0) startingPos = 7;
    var pm = this.getPrevMonth(dateVal);
    var prevStart = this.getDaysInMonth(pm.getMonth()+1, pm.getFullYear())-startingPos;
    var cells = this.cells;
    days += startingPos;
    
    
    var day = 86400000;
    var date = this.clearTime(new Date(pm.getFullYear(), pm.getMonth(), prevStart));
    var today = this.clearTime(new Date()).getTime();
    var sel = this.selectedDate ? this.clearTime(this.selectedDate).getTime() : today + 1; 
    var min = this.minDate ? this.clearTime(this.minDate).getTime() : Number.NEGATIVE_INFINITY;
    var max = this.maxDate ? this.clearTime(this.maxDate).getTime() : Number.POSITIVE_INFINITY;
    var ddMatch = this.disabledDatesRE;
    var ddText = this.disabledDatesText;
    var ddays = this.disabledDays;
    var ddaysText = this.disabledDaysText;
    var format = this.format;
    
    var setCellClass = function(cal, cell, d){
        cell.title = '';
        var t = d.getTime();
        if(t == today){
            cell.className += ' today';
            cell.title = cal.todayText;
        }
        if(t == sel){
            cell.className += ' selected';
        }
        
        if(t < min) {
            cell.className = ' ypopcal-disabled';
            cell.title = cal.minText;
            return;
        }
        if(t > max) {
            cell.className = ' ypopcal-disabled';
            cell.title = cal.maxText;
            return;
        }
        if(ddays){
            var day = d.getDay();
            for(var i = 0; i < ddays.length; i++) {
            	if(day === ddays[i]){
            	    cell.title = ddaysText;
                    cell.className = ' ypopcal-disabled';
                    return;
                }
            }
        }
        if(ddMatch && format){
            var fvalue = d.format(format);
            if(ddMatch.test(fvalue)){
                cell.title = ddText.replace('%0', fvalue);
                cell.className = ' ypopcal-disabled';
                return;
            }
        }
    };
    
    var i = 0;
    for(; i < startingPos; i++) {
        cells[i].innerHTML = (++prevStart);
        date.setDate(date.getDate()+1);
        cells[i].className = 'prevday';
        setCellClass(this, cells[i], date);
    }
    for(; i < days; i++){
        intDay = i - startingPos + 1;
        cells[i].innerHTML = (intDay);
        date.setDate(date.getDate()+1);
        cells[i].className = 'active';
        setCellClass(this, cells[i], date);
    }
    var extraDays = 0;
    for(; i < 42; i++) {
         cells[i].innerHTML = (++extraDays);
         date.setDate(date.getDate()+1);
         cells[i].className = 'nextday';
         setCellClass(this, cells[i], date);
    }
};

YAHOO.ext.DatePicker.prototype.todayText = "Today";
YAHOO.ext.DatePicker.prototype.minDate = null;
YAHOO.ext.DatePicker.prototype.maxDate = null;
YAHOO.ext.DatePicker.prototype.minText = "This date is before the minimum date";
YAHOO.ext.DatePicker.prototype.maxText = "This date is after the maximum date";
YAHOO.ext.DatePicker.prototype.format = 'm/d/y';
YAHOO.ext.DatePicker.prototype.disabledDays = null;
YAHOO.ext.DatePicker.prototype.disabledDaysText = '';
YAHOO.ext.DatePicker.prototype.disabledDatesRE = null;
YAHOO.ext.DatePicker.prototype.disabledDatesText = '';
YAHOO.ext.DatePicker.prototype.constrainToViewport = true;


YAHOO.ext.DatePicker.prototype.monthNames = Date.monthNames;

YAHOO.ext.DatePicker.prototype.dayNames = Date.dayNames;

YAHOO.ext.grid.SelectEditor = function(element){
    element.hideFocus = true;
    YAHOO.ext.grid.SelectEditor.superclass.constructor.call(this, element);
    this.element.swallowEvent('click');
};
YAHOO.extendX(YAHOO.ext.grid.SelectEditor, YAHOO.ext.grid.CellEditor);

YAHOO.ext.grid.SelectEditor.prototype.fitToCell = function(box){
    if(YAHOO.ext.util.Browser.isGecko){
        box.height -= 3;
    }
    this.element.setBox(box, true);
};

YAHOO.ext.grid.TextEditor = function(config){
    var element = document.createElement('input');
    element.type = 'text';
    element.className = 'ygrid-editor ygrid-text-editor';
    element.setAttribute('autocomplete', 'off');
    document.body.appendChild(element);
    YAHOO.ext.grid.TextEditor.superclass.constructor.call(this, element);
    YAHOO.ext.util.Config.apply(this, config);
};
YAHOO.extendX(YAHOO.ext.grid.TextEditor, YAHOO.ext.grid.CellEditor);

YAHOO.ext.grid.TextEditor.prototype.validate = function(){
    var dom = this.element.dom;
    var value = dom.value;
    if(value.length < 1){ 
         if(this.allowBlank){
             dom.title = '';
             this.element.removeClass('ygrid-editor-invalid');
             return true;
         }else{
             dom.title = this.blankText;
             this.element.addClass('ygrid-editor-invalid');
             return false;
         }
    }
    if(value.length < this.minLength){
        dom.title = this.minText.replace('%0', this.minLength);
        this.element.addClass('ygrid-editor-invalid');
        return false;
    }
    if(value.length > this.maxLength){
        dom.title = this.maxText.replace('%0', this.maxLength);
        this.element.addClass('ygrid-editor-invalid');
        return false;
    }
    var msg = this.validator(value);
    if(msg !== true){
        dom.title = msg;
        this.element.addClass('ygrid-editor-invalid');
        return false;
    }
    if(this.regex && !this.regex.test(value)){
        dom.title = this.regexText;
        this.element.addClass('ygrid-editor-invalid');
        return false;
    }
    dom.title = '';
    this.element.removeClass('ygrid-editor-invalid');
    return true;
};

YAHOO.ext.grid.TextEditor.prototype.initEvents = function(){
    YAHOO.ext.grid.TextEditor.superclass.initEvents.call(this);
    var vtask = new YAHOO.ext.util.DelayedTask(this.validate, this);
    this.element.mon('keyup', vtask.delay.createDelegate(vtask, [this.validationDelay]));
};

YAHOO.ext.grid.TextEditor.prototype.show = function(){
    this.element.dom.title = '';
    YAHOO.ext.grid.TextEditor.superclass.show.call(this);
    this.element.focus();
    if(this.selectOnFocus){
        try{
            this.element.dom.select();
        }catch(e){}
    }
    this.validate(this.element.dom.value);
};

YAHOO.ext.grid.TextEditor.prototype.getValue = function(){
   if(!this.validate()){
       return this.originalValue;
   }else{
       return this.element.dom.value;
   }   
};

YAHOO.ext.grid.TextEditor.prototype.allowBlank = true;
YAHOO.ext.grid.TextEditor.prototype.minLength = 0;
YAHOO.ext.grid.TextEditor.prototype.maxLength = Number.MAX_VALUE;
YAHOO.ext.grid.TextEditor.prototype.minText = 'The minimum length for this field is %0';
YAHOO.ext.grid.TextEditor.prototype.maxText = 'The maximum length for this field is %0';
YAHOO.ext.grid.TextEditor.prototype.selectOnFocus = true;
YAHOO.ext.grid.TextEditor.prototype.blankText = 'This field cannot be blank';
YAHOO.ext.grid.TextEditor.prototype.validator = function(){return true;};
YAHOO.ext.grid.TextEditor.prototype.validationDelay = 200;
YAHOO.ext.grid.TextEditor.prototype.regex = null;
YAHOO.ext.grid.TextEditor.prototype.regexText = '';

YAHOO.ext.LayoutManager = function(container){
    YAHOO.ext.LayoutManager.superclass.constructor.call(this);
    this.el = getEl(container, true);
    this.id = this.el.id;
    this.el.addClass('ylayout-container');
    
    this.monitorWindowResize = true;
    this.regions = {};
    this.events = {
        
        'layout' : new YAHOO.util.CustomEvent(),
        
        'regionresized' : new YAHOO.util.CustomEvent(),
        
        'regioncollapsed' : new YAHOO.util.CustomEvent(),
        
        'regionexpanded' : new YAHOO.util.CustomEvent()
    };
    this.updating = false;
    YAHOO.ext.EventManager.onWindowResize(this.onWindowResize, this, true);
};

YAHOO.extendX(YAHOO.ext.LayoutManager, YAHOO.ext.util.Observable, {
    
    isUpdating : function(){
        return this.updating; 
    },
    
    
    beginUpdate : function(){
        this.updating = true;    
    },
    
    
    endUpdate : function(noLayout){
        this.updating = false;
        if(!noLayout){
            this.layout();
        }    
    },
    
    layout: function(){
        
    },
    
    onRegionResized : function(region, newSize){
        this.fireEvent('regionresized', region, newSize);
        this.layout();
    },
    
    onRegionCollapsed : function(region){
        this.fireEvent('regioncollapsed', region);
    },
    
    onRegionExpanded : function(region){
        this.fireEvent('regionexpanded', region);
    },
        
    
    getViewSize : function(){
        var size;
        if(this.el.dom != document.body){
            this.el.beginMeasure();
            size = this.el.getSize();
            this.el.endMeasure();
        }else{
            size = {width: YAHOO.util.Dom.getViewportWidth(), height: YAHOO.util.Dom.getViewportHeight()};
        }
        size.width -= this.el.getBorderWidth('lr')-this.el.getPadding('lr');
        size.height -= this.el.getBorderWidth('tb')-this.el.getPadding('tb');
        return size;
    },
    
    
    getEl : function(){
        return this.el;
    },
    
    
    getRegion : function(target){
        return this.regions[target.toLowerCase()];
    },
    
    onWindowResize : function(){
        if(this.monitorWindowResize){
            this.layout();
        }
    }
});

YAHOO.ext.LayoutRegion = function(mgr, config, pos){
    this.mgr = mgr;
    this.position  = pos;
    var dh = YAHOO.ext.DomHelper;
    
    this.el = dh.append(mgr.el.dom, {tag: 'div', cls: 'ylayout-panel ylayout-panel-' + this.position}, true);
    
    this.titleEl = dh.append(this.el.dom, {tag: 'div', unselectable: 'on', cls: 'yunselectable ylayout-panel-hd ylayout-title-'+this.position, children:[
        {tag: 'span', cls: 'yunselectable ylayout-panel-hd-text', unselectable: 'on', html: '&#160;'},
        {tag: 'div', cls: 'yunselectable ylayout-panel-hd-tools', unselectable: 'on'}
    ]}, true);
    this.titleEl.enableDisplayMode();
    
    this.titleTextEl = this.titleEl.dom.firstChild;
    this.tools = getEl(this.titleEl.dom.childNodes[1], true);
    this.closeBtn = this.createTool(this.tools.dom, 'ylayout-close');
    this.closeBtn.enableDisplayMode();
    this.closeBtn.on('click', this.closeClicked, this, true);
    this.closeBtn.hide();
    
    this.bodyEl = dh.append(this.el.dom, {tag: 'div', cls: 'ylayout-panel-body'}, true);
    this.events = {
        
        'beforeremove' : new YAHOO.util.CustomEvent('beforeremove'),
        
        'invalidated' : new YAHOO.util.CustomEvent('invalidated'),
        
        'visibilitychange' : new YAHOO.util.CustomEvent('visibilitychange'),
        
        'paneladded' : new YAHOO.util.CustomEvent('paneladded'),
        
        'panelremoved' : new YAHOO.util.CustomEvent('panelremoved'),
        
        'collapsed' : new YAHOO.util.CustomEvent('collapsed'),
        
        'expanded' : new YAHOO.util.CustomEvent('expanded'),
        
        'panelactivated' : new YAHOO.util.CustomEvent('panelactivated'),
        
        'resized' : new YAHOO.util.CustomEvent('resized')
    };
    
    this.panels = new YAHOO.ext.util.MixedCollection();
    this.panels.getKey = this.getPanelId.createDelegate(this);
    this.box = null;
    this.visible = false;
    this.collapsed = false;
    this.hide();
    this.on('paneladded', this.validateVisibility, this, true);
    this.on('panelremoved', this.validateVisibility, this, true);
    this.activePanel = null;
    
    this.applyConfig(config);
    
    
};

YAHOO.extendX(YAHOO.ext.LayoutRegion, YAHOO.ext.util.Observable, {
    getPanelId : function(p){
        return p.getId();
    },
    
    applyConfig : function(config){
        if(config.collapsible && this.position != 'center' && !this.collapsedEl){
            var dh = YAHOO.ext.DomHelper;
            this.collapseBtn = this.createTool(this.tools.dom, 'ylayout-collapse-'+this.position);
            this.collapseBtn.mon('click', this.collapse, this, true);
            
            this.collapsedEl = dh.append(this.mgr.el.dom, {tag: 'div', cls: 'ylayout-collapsed ylayout-collapsed-'+this.position, children:[
                {tag: 'div', cls: 'ylayout-collapsed-tools'}
            ]}, true);
            if(config.floatable !== false){
               this.collapsedEl.addClassOnOver('ylayout-collapsed-over');
               this.collapsedEl.mon('click', this.collapseClick, this, true);
            }
            this.expandBtn = this.createTool(this.collapsedEl.dom.firstChild, 'ylayout-expand-'+this.position);
            this.expandBtn.mon('click', this.expand, this, true);
        }
        if(this.collapseBtn){
            this.collapseBtn.setVisible(config.collapsible == true);
        }
        this.cmargins = config.cmargins || this.cmargins || 
                         (this.position == 'west' || this.position == 'east' ? 
                             {top: 0, left: 2, right:2, bottom: 0} : 
                             {top: 2, left: 0, right:0, bottom: 2});
        this.margins = config.margins || this.margins || {top: 0, left: 0, right:0, bottom: 0};
        this.bottomTabs = config.tabPosition != 'top';
        this.autoScroll = config.autoScroll || false;
        if(this.autoScroll){
            this.bodyEl.setStyle('overflow', 'auto');
        }else{
            this.bodyEl.setStyle('overflow', 'hidden');
        }
        if((!config.titlebar && !config.title) || config.titlebar === false){
            this.titleEl.hide();
        }else{
            this.titleEl.show();
            if(config.title){
                this.titleTextEl.innerHTML = config.title;
            }
        }
        this.duration = config.duration || .30;
        this.slideDuration = config.slideDuration || .45;
        this.config = config;
        if(config.collapsed){
            this.collapse(true);
        }
    },
    
    
    resizeTo : function(newSize){
        switch(this.position){
            case 'east':
            case 'west':
                this.el.setWidth(newSize);
                this.fireEvent('resized', this, newSize);
            break;
            case 'north':
            case 'south':
                this.el.setHeight(newSize);
                this.fireEvent('resized', this, newSize);
            break;                
        }
    },
    
    getBox : function(){
        var b;
        if(!this.collapsed){
            b = this.el.getBox(false, true);
        }else{
            b = this.collapsedEl.getBox(false, true);
        }
        return b;
    },
    
    getMargins : function(){
        return this.collapsed ? this.cmargins : this.margins;
    },
    
    highlight : function(){
        this.el.addClass('ylayout-panel-dragover'); 
    },
    
    unhighlight : function(){
        this.el.removeClass('ylayout-panel-dragover'); 
    },
    
    updateBox : function(box){
        this.box = box;
        if(!this.collapsed){
            this.el.dom.style.left = box.x + 'px';
            this.el.dom.style.top = box.y + 'px';
            this.el.setSize(box.width, box.height);
            var bodyHeight = this.titleEl.isVisible() ? box.height - (this.titleEl.getHeight()||0) : box.height;
            bodyHeight -= this.el.getBorderWidth('tb');
            bodyWidth = box.width - this.el.getBorderWidth('rl');
            this.bodyEl.setHeight(bodyHeight);
            this.bodyEl.setWidth(bodyWidth);
            var tabHeight = bodyHeight;
            if(this.tabs){
                tabHeight = this.tabs.syncHeight(bodyHeight);
                if(YAHOO.ext.util.Browser.isIE) this.tabs.el.repaint();
            }
            this.panelSize = {width: bodyWidth, height: tabHeight};
            if(this.activePanel){
                this.activePanel.setSize(bodyWidth, tabHeight);
            }
        }else{
            this.collapsedEl.dom.style.left = box.x + 'px';
            this.collapsedEl.dom.style.top = box.y + 'px';
            this.collapsedEl.setSize(box.width, box.height);
        }
        if(this.tabs){
            this.tabs.autoSizeTabs();
        }
    },
    
    
    getEl : function(){
        return this.el;
    },
    
    
    hide : function(){
        if(!this.collapsed){
            this.el.dom.style.left = '-2000px';
            this.el.hide();
        }else{
            this.collapsedEl.dom.style.left = '-2000px';
            this.collapsedEl.hide();
        }
        this.visible = false;
        this.fireEvent('visibilitychange', this, false);
    },
    
    
    show : function(){
        if(!this.collapsed){
            this.el.show();
        }else{
            this.collapsedEl.show();
        }
        this.visible = true;
        this.fireEvent('visibilitychange', this, true);
    },
    
    
    isVisible : function(){
        return this.visible;
    },
    
    closeClicked : function(){
        if(this.activePanel){
            this.remove(this.activePanel);
        }
    },
    
    collapseClick : function(e){
       if(this.isSlid){
           e.stopPropagation();
           this.slideIn();
       }else{
           e.stopPropagation();
           this.slideOut();
       }   
    },
    
    
    collapse : function(skipAnim){
        if(this.collapsed) return;
        this.collapsed = true;
        if(this.split){
            this.split.el.hide();
        }
        if(this.config.animate && skipAnim !== true){
            this.fireEvent('invalidated', this);    
            this.animateCollapse();
        }else{
            this.el.setLocation(-20000,-20000);
            this.el.hide();
            this.collapsedEl.show();
            this.fireEvent('collapsed', this);
            this.fireEvent('invalidated', this); 
        }
    },
    
    animateCollapse : function(){
        
    },
    
    
    expand : function(e, skipAnim){
        if(e) e.stopPropagation();
        if(!this.collapsed) return;
        if(this.isSlid){
            this.slideIn(this.expand.createDelegate(this));
            return;
        }
        this.collapsed = false;
        this.el.show();
        if(this.config.animate && skipAnim !== true){
            this.animateExpand();
        }else{
            if(this.split){
                this.split.el.show();
            }
            this.collapsedEl.setLocation(-2000,-2000);
            this.collapsedEl.hide();
            this.fireEvent('invalidated', this);
            this.fireEvent('expanded', this);
        }
    },
    
    animateExpand : function(){
        
    },
    
    initTabs : function(){
        this.bodyEl.setStyle('overflow', 'hidden');
        var ts = new YAHOO.ext.TabPanel(this.bodyEl.dom, this.bottomTabs);
        this.tabs = ts;
        ts.resizeTabs = this.config.resizeTabs === true;
        ts.minTabWidth = this.config.minTabWidth || 40;
        ts.maxTabWidth = this.config.maxTabWidth || 250;
        ts.preferredTabWidth = this.config.preferredTabWidth || 150;
        ts.monitorResize = false;
        ts.bodyEl.setStyle('overflow', this.config.autoScroll ? 'auto' : 'hidden');
        this.panels.each(this.initPanelAsTab, this);
    },
    
    initPanelAsTab : function(panel){
        var ti = this.tabs.addTab(panel.getEl().id, panel.getTitle(), null, 
                    this.config.closeOnTab && panel.isClosable());
        ti.on('activate', function(){ 
              this.setActivePanel(panel); 
        }, this, true);
        if(this.config.closeOnTab){
            ti.on('beforeclose', function(t, e){
                e.cancel = true;
                this.remove(panel);
            }, this, true);
        }
        return ti;
    },
    
    updatePanelTitle : function(panel, title){
        if(this.activePanel == panel){
            this.updateTitle(title);
        }
        if(this.tabs){
            this.tabs.getTab(panel.getEl().id).setText(title);
        }
    },
    
    updateTitle : function(title){
        if(this.titleTextEl && !this.config.title){
            this.titleTextEl.innerHTML = (typeof title != 'undefined' && title.length > 0 ? title : "&#160;");
        }
    },
    
    setActivePanel : function(panel){
        panel = this.getPanel(panel);
        if(this.activePanel && this.activePanel != panel){
            this.activePanel.setActiveState(false);
        }
        this.activePanel = panel;
        panel.setActiveState(true);
        if(this.panelSize){
            panel.setSize(this.panelSize.width, this.panelSize.height);
        }
        this.closeBtn.setVisible(!this.config.closeOnTab && !this.isSlid && panel.isClosable());
        this.updateTitle(panel.getTitle());
        this.fireEvent('panelactivated', this, panel);
        
    },
    
    
    showPanel : function(panel){
        if(panel = this.getPanel(panel)){
            if(this.tabs){
                this.tabs.activate(panel.getEl().id);
            }else{
                this.setActivePanel(panel);
            }
        }
        return panel;
    },
    
    
    getActivePanel : function(){
        return this.activePanel;
    },
    
    validateVisibility : function(){
        if(this.panels.getCount() < 1){
            this.updateTitle('&#160;');
            this.closeBtn.hide();
            this.hide();
        }else{
            if(!this.isVisible()){
                this.show();
            }
        }
    },
    
    
    add : function(panel){
        if(arguments.length > 1){
            for(var i = 0, len = arguments.length; i < len; i++) {
            	this.add(arguments[i]);
            }
            return null;
        }
        if(this.hasPanel(panel)){
            this.showPanel(panel);
            return panel;
        }
        panel.setRegion(this);
        this.panels.add(panel);
        if(this.panels.getCount() == 1 && !this.config.alwaysShowTabs){
            this.bodyEl.dom.appendChild(panel.getEl().dom);
            this.setActivePanel(panel);
            this.fireEvent('paneladded', this, panel);
            return panel;
        }
        if(!this.tabs){
            this.initTabs();
        }else{
            this.initPanelAsTab(panel);
        }
        this.tabs.activate(panel.getEl().id);
        this.fireEvent('paneladded', this, panel);
        return panel;
    },
    
    
    hasPanel : function(panel){
        if(typeof panel == 'object'){ 
            panel = panel.getId();
        }
        return this.getPanel(panel) ? true : false;
    },
    
    
    hidePanel : function(panel){
        if(this.tabs && (panel = this.getPanel(panel))){
            this.tabs.hideTab(panel.getEl().id);
        }
    },
    
    
    unhidePanel : function(panel){
        if(this.tabs && (panel = this.getPanel(panel))){
            this.tabs.unhideTab(panel.getEl().id);
        }
    },
    
    clearPanels : function(){
        while(this.panels.getCount() > 0){
             this.remove(this.panels.first());
        }
    },
    
    
    remove : function(panel, preservePanel){
        panel = this.getPanel(panel);
        if(!panel){
            return null;
        }
        var e = {};
        this.fireEvent('beforeremove', this, panel, e);
        if(e.cancel === true){
            return null;
        }
        preservePanel = (typeof preservePanel != 'undefined' ? preservePanel : (this.config.preservePanels === true || panel.preserve === true));
        var panelId = panel.getId();
        this.panels.removeKey(panelId);
        if(preservePanel){
            document.body.appendChild(panel.getEl().dom);
        }
        if(this.tabs){
            this.tabs.removeTab(panel.getEl().id);
        }else if (!preservePanel){
            this.bodyEl.dom.removeChild(panel.getEl().dom);
        }
        if(this.panels.getCount() == 1 && this.tabs && !this.config.alwaysShowTabs){
            var p = this.panels.first();
            var tempEl = document.createElement('span'); 
            tempEl.appendChild(p.getEl().dom);
            this.bodyEl.update('');
            this.bodyEl.dom.appendChild(p.getEl().dom);
            tempEl = null;
            this.updateTitle(p.getTitle());
            this.tabs = null;
            this.bodyEl.setStyle('overflow', this.config.autoScroll ? 'auto' : 'hidden');
            this.setActivePanel(p);
        }
        panel.setRegion(null);
        if(this.activePanel == panel){
            this.activePanel = null;
        }
        if(this.config.autoDestroy !== false && preservePanel !== true){
            try{panel.destroy();}catch(e){}
        }
        this.fireEvent('panelremoved', this, panel);
        return panel;
    },
    
    
    getTabs : function(){
        return this.tabs;    
    },
    
    
    getPanel : function(id){
        if(typeof id == 'object'){ 
            return id;
        }
        return this.panels.get(id);
    },
    
    
    getPosition: function(){
        return this.position;    
    },
    
    createTool : function(parentEl, className){
        var btn = YAHOO.ext.DomHelper.append(parentEl, {tag: 'div', cls: 'ylayout-tools-button', 
            children: [{tag: 'div', cls: 'ylayout-tools-button-inner ' + className, html: '&#160;'}]}, true);
        btn.addClassOnOver('ylayout-tools-button-over');
        return btn;
    }
});

YAHOO.ext.SplitLayoutRegion = function(mgr, config, pos, cursor){
    this.cursor = cursor;
    YAHOO.ext.SplitLayoutRegion.superclass.constructor.call(this, mgr, config, pos);
    if(config.split){
        this.hide();
    }
};

YAHOO.extendX(YAHOO.ext.SplitLayoutRegion, YAHOO.ext.LayoutRegion, {
    applyConfig : function(config){
        YAHOO.ext.SplitLayoutRegion.superclass.applyConfig.call(this, config);
        if(config.split){
            if(!this.split){
                var splitEl = YAHOO.ext.DomHelper.append(this.mgr.el.dom, 
                        {tag: 'div', id: this.el.id + '-split', cls: 'ylayout-split ylayout-split-'+this.position, html: '&#160;'});
                
                this.split = new YAHOO.ext.SplitBar(splitEl, this.el);
                this.split.onMoved.subscribe(this.onSplitMove, this, true);
                this.split.useShim = config.useShim === true;
                YAHOO.util.Dom.setStyle([this.split.el.dom, this.split.proxy], 'cursor', this.cursor);
                this.split.getMaximumSize = this.getMaxSize.createDelegate(this);
            }
            if(typeof config.minSize != 'undefined'){
                this.split.minSize = config.minSize;
            }
            if(typeof config.maxSize != 'undefined'){
                this.split.maxSize = config.maxSize;
            }
        }
    },
    
    getMaxSize : function(){
         var cmax = this.config.maxSize || 10000;
         var center = this.mgr.getRegion('center');
         return Math.min(cmax, (this.el.getWidth()+center.getEl().getWidth())-center.getMinWidth());
    },
    
    onSplitMove : function(split, newSize){
        this.fireEvent('resized', this, newSize);
    },
    
    
    getSplitBar : function(){
        return this.split;
    },
    
    hide : function(){
        if(this.split){
            this.split.el.setLocation(-2000,-2000);
            this.split.el.hide();
        }
        YAHOO.ext.SplitLayoutRegion.superclass.hide.call(this);
    },
    
    show : function(){
        if(this.split){
            this.split.el.show();
        }
        YAHOO.ext.SplitLayoutRegion.superclass.show.call(this);
    },
    
    beforeSlide: function(){
        if(YAHOO.ext.util.Browser.isGecko){
            this.bodyEl.clip();
            if(this.tabs) this.tabs.bodyEl.clip();
            if(this.activePanel){
                this.activePanel.getEl().clip();
                
                if(this.activePanel.beforeSlide){
                    this.activePanel.beforeSlide();
                }
            }
        }
    },
    
    afterSlide : function(){
        if(YAHOO.ext.util.Browser.isGecko){
            this.bodyEl.unclip();
            if(this.tabs) this.tabs.bodyEl.unclip();
            if(this.activePanel){
                this.activePanel.getEl().unclip();
                if(this.activePanel.afterSlide){
                    this.activePanel.afterSlide();
                }
            }
        }
    },
    
    slideOut : function(){
        if(!this.slideEl){
            this.slideEl = new YAHOO.ext.Actor(
                YAHOO.ext.DomHelper.append(this.mgr.el.dom, {tag: 'div', cls:'ylayout-slider'}));
            if(this.config.autoHide !== false){
                var slideInTask = new YAHOO.ext.util.DelayedTask(this.slideIn, this);
                this.slideEl.mon('mouseout', function(e){
                    var to = e.getRelatedTarget();
                    if(to && to != this.slideEl.dom && !YAHOO.util.Dom.isAncestor(this.slideEl.dom, to)){
                        slideInTask.delay(500);
                    }
                }, this, true);
                this.slideEl.mon('mouseover', function(e){
                    slideInTask.cancel();
                }, this, true);
            }
        }
        var sl = this.slideEl, c = this.collapsedEl, cm = this.cmargins;
        this.isSlid = true;
        this.snapshot = {
            'left': this.el.getLeft(true),
            'top': this.el.getTop(true),
            'colbtn': this.collapseBtn.isVisible(),
            'closebtn': this.closeBtn.isVisible()
        };
        this.collapseBtn.hide();
        this.closeBtn.hide();
        this.el.show();
        this.el.setLeftTop(0,0);
        sl.startCapture(true);
        var size;
        switch(this.position){
            case 'west':
                sl.setLeft(c.getRight(true));
                sl.setTop(c.getTop(true));
                size = this.el.getWidth();
            break;
            case 'east':
                sl.setRight(this.mgr.getViewSize().width-c.getLeft(true));
                sl.setTop(c.getTop(true));
                size = this.el.getWidth();
            break;
            case 'north':
                sl.setLeft(c.getLeft(true));
                sl.setTop(c.getBottom(true));
                size = this.el.getHeight();
            break;
            case 'south':
                sl.setLeft(c.getLeft(true));
                sl.setBottom(this.mgr.getViewSize().height-c.getTop(true));
                size = this.el.getHeight();
            break;
        }
        sl.dom.appendChild(this.el.dom);
        YAHOO.util.Event.on(document.body, 'click', this.slideInIf, this, true);
        sl.setSize(this.el.getWidth(), this.el.getHeight());
        this.beforeSlide();
        if(this.activePanel){
            this.activePanel.setSize(this.bodyEl.getWidth(), this.bodyEl.getHeight());
        }
        sl.slideShow(this.getAnchor(), size, this.slideDuration, null, false);
        sl.play(function(){
            this.afterSlide();
        }.createDelegate(this));
    },
    
    slideInIf : function(e){
        var t = YAHOO.util.Event.getTarget(e);
        if(!YAHOO.util.Dom.isAncestor(this.el.dom, t)){
            this.slideIn();
        }
    },
    
    slideIn : function(callback){
        if(this.isSlid && !this.slideEl.playlist.isPlaying()){
            YAHOO.util.Event.removeListener(document.body, 'click', this.slideInIf, this, true);
            this.slideEl.startCapture(true);
            this.slideEl.slideHide(this.getAnchor(), this.slideDuration, null);
            this.beforeSlide();
            this.slideEl.play(function(){
                this.isSlid = false;
                this.el.setPositioning(this.snapshot);
                this.collapseBtn.setVisible(this.snapshot.colbtn);
                this.closeBtn.setVisible(this.snapshot.closebtn);
                this.afterSlide();
                this.mgr.el.dom.appendChild(this.el.dom);
                if(typeof callback == 'function'){
                    callback();
                }
            }.createDelegate(this));
        }
    },
    
    animateExpand : function(){
        var em = this.margins, cm = this.cmargins;
        var c = this.collapsedEl, el = this.el;
        var direction, distance;
        switch(this.position){
            case 'west':
                direction = 'right';
                el.setLeft(-(el.getWidth() + (em.right+em.left)));
                el.setTop(c.getTop(true)-cm.top+em.top);
                distance = el.getWidth() + (em.right+em.left);
            break;
            case 'east':
                direction = 'left';
                el.setLeft(this.mgr.getViewSize().width + em.left);
                el.setTop(c.getTop(true)-cm.top+em.top);
                distance = el.getWidth() + (em.right+em.left);
            break;
            case 'north':
                direction = 'down';
                el.setLeft(em.left);
                el.setTop(-(el.getHeight() + (em.top+em.bottom)));
                distance = el.getHeight() + (em.top+em.bottom);
            break;
            case 'south':
                direction = 'up';
                el.setLeft(em.left);
                el.setTop(this.mgr.getViewSize().height + em.top);
                distance = el.getHeight() + (em.top+em.bottom);
            break;
        }
        this.beforeSlide();
        el.setStyle('z-index', '100');
        el.show();
        c.setLocation(-2000,-2000);
        c.hide();
        el.move(direction, distance, true, this.duration, function(){
            this.afterSlide();
            el.setStyle('z-index', '');
            if(this.split){
                this.split.el.show();
            }
            this.fireEvent('invalidated', this);
            this.fireEvent('expanded', this);
        }.createDelegate(this), this.config.easing || YAHOO.util.Easing.easeOut);
    },
    
    animateCollapse : function(){
        var em = this.margins, cm = this.cmargins;
        var c = this.collapsedEl, el = this.el;
        var direction, distance;
        switch(this.position){
            case 'west':
                direction = 'left';
                distance = el.getWidth() + (em.right+em.left);
            break;
            case 'east':
                direction = 'right';
                distance = el.getWidth() + (em.right+em.left);
            break;
            case 'north':
                direction = 'up';
                distance = el.getHeight() + (em.top+em.bottom);
            break;
            case 'south':
                direction = 'down';
                distance = el.getHeight() + (em.top+em.bottom);
            break;
        }
        this.el.setStyle('z-index', '100');
        this.beforeSlide();
        this.el.move(direction, distance, true, this.duration, function(){
            this.afterSlide();
            this.el.setStyle('z-index', '');
            this.el.setLocation(-20000,-20000);
            this.el.hide();
            this.collapsedEl.show();
            this.fireEvent('collapsed', this); 
        }.createDelegate(this), YAHOO.util.Easing.easeIn);
    },
    
    getAnchor : function(){
        switch(this.position){
            case 'west':
                return 'left';
            case 'east':
                return 'right';
            case 'north':
                return 'top';
            case 'south':
                return 'bottom';
        }
    }
});

YAHOO.ext.BorderLayout = function(container, config){
    YAHOO.ext.BorderLayout.superclass.constructor.call(this, container);
    this.factory = config.factory || YAHOO.ext.BorderLayout.RegionFactory;
    
    this.hideOnLayout = config.hideOnLayout || false;
    for(var i = 0, len = this.factory.validRegions.length; i < len; i++) {
    	var target = this.factory.validRegions[i];
    	if(config[target]){
    	    this.addRegion(target, config[target]);
    	}
    }
    
};

YAHOO.extendX(YAHOO.ext.BorderLayout, YAHOO.ext.LayoutManager, {
    
    addRegion : function(target, config){
        if(!this.regions[target]){
            var r = this.factory.create(target, this, config);
    	    this.regions[target] = r;
    	    r.on('visibilitychange', this.layout, this, true);
            r.on('paneladded', this.layout, this, true);
            r.on('panelremoved', this.layout, this, true);
            r.on('invalidated', this.layout, this, true);
            r.on('resized', this.onRegionResized, this, true);
            r.on('collapsed', this.onRegionCollapsed, this, true);
            r.on('expanded', this.onRegionExpanded, this, true);
        }
        return this.regions[target];
    },
    
    
    layout : function(){
        if(this.updating) return;
        
	    
        var size = this.getViewSize();
        var w = size.width, h = size.height;
        var centerW = w, centerH = h, centerY = 0, centerX = 0;
        var x = 0, y = 0;
        
        var rs = this.regions;
        var n = rs['north'], s = rs['south'], west = rs['west'], e = rs['east'], c = rs['center'];
        if(this.hideOnLayout){
            c.el.setStyle('display', 'none');
        }
        if(n && n.isVisible()){
            var b = n.getBox();
            var m = n.getMargins();
            b.width = w - (m.left+m.right);
            b.x = m.left;
            b.y = m.top;
            centerY = b.height + b.y + m.bottom;
            centerH -= centerY;
            n.updateBox(this.safeBox(b));
        }
        if(s && s.isVisible()){
            var b = s.getBox();
            var m = s.getMargins();
            b.width = w - (m.left+m.right);
            b.x = m.left;
            var totalHeight = (b.height + m.top + m.bottom);
            b.y = h - totalHeight + m.top;
            centerH -= totalHeight;
            s.updateBox(this.safeBox(b));
        }
        if(west && west.isVisible()){
            var b = west.getBox();
            var m = west.getMargins();
            b.height = centerH - (m.top+m.bottom);
            b.x = m.left;
            b.y = centerY + m.top;
            var totalWidth = (b.width + m.left + m.right);
            centerX += totalWidth;
            centerW -= totalWidth;
            west.updateBox(this.safeBox(b));
        }
        if(e && e.isVisible()){
            var b = e.getBox();
            var m = e.getMargins();
            b.height = centerH - (m.top+m.bottom);
            var totalWidth = (b.width + m.left + m.right);
            b.x = w - totalWidth + m.left;
            b.y = centerY + m.top;
            centerW -= totalWidth;
            e.updateBox(this.safeBox(b));
        }
        if(c){
            var m = c.getMargins();
            var centerBox = {
                x: centerX + m.left,
                y: centerY + m.top,
                width: centerW - (m.left+m.right),
                height: centerH - (m.top+m.bottom)
            };
            if(this.hideOnLayout){
                c.el.setStyle('display', 'block');
            }
            c.updateBox(this.safeBox(centerBox));
        }
        this.el.repaint();
        this.fireEvent('layout', this);
        
	    
    },
    
    safeBox : function(box){
        box.width = Math.max(0, box.width);
        box.height = Math.max(0, box.height);
        return box;
    },
    
    
    add : function(target, panel){
        target = target.toLowerCase();
        return this.regions[target].add(panel);
    },
    
    
    remove : function(target, panel){
        target = target.toLowerCase();
        return this.regions[target].remove(panel);
    },
    
    
    findPanel : function(panelId){
        var rs = this.regions;
        for(var target in rs){
            if(typeof rs[target] != 'function'){
                var p = rs[target].getPanel(panelId);
                if(p){
                    return p;
                }
            }
        }
        return null;
    },
    
    
    showPanel : function(panelId) {
      var rs = this.regions;
      for(var target in rs){
         var r = rs[target];
         if(typeof r != 'function'){
            if(r.hasPanel(panelId)){
               return r.showPanel(panelId);
            }
         }
      }
      return null;
   },
   
   
    restoreState : function(provider){
        if(!provider){
            provider = YAHOO.ext.state.Manager;
        }
        var sm = new YAHOO.ext.LayoutStateManager();
        sm.init(this, provider);
    }
});

YAHOO.ext.BorderLayout.RegionFactory = {};
YAHOO.ext.BorderLayout.RegionFactory.validRegions = ['north','south','east','west','center'];
YAHOO.ext.BorderLayout.RegionFactory.create = function(target, mgr, config){
    if(config.lightweight){
        return new YAHOO.ext.LayoutRegionLite(mgr, config);
    }
    target = target.toLowerCase();
    switch(target){
        case 'north':
            return new YAHOO.ext.NorthLayoutRegion(mgr, config);
        case 'south':
            return new YAHOO.ext.SouthLayoutRegion(mgr, config);
        case 'east':
            return new YAHOO.ext.EastLayoutRegion(mgr, config);
        case 'west':
            return new YAHOO.ext.WestLayoutRegion(mgr, config);
        case 'center':
            return new YAHOO.ext.CenterLayoutRegion(mgr, config);
    }
    throw 'Layout region "'+target+'" not supported.';
};

YAHOO.ext.CenterLayoutRegion = function(mgr, config){
    YAHOO.ext.CenterLayoutRegion.superclass.constructor.call(this, mgr, config, 'center');
    this.visible = true;
    this.minWidth = config.minWidth || 20;
    this.minHeight = config.minHeight || 20;
};

YAHOO.extendX(YAHOO.ext.CenterLayoutRegion, YAHOO.ext.LayoutRegion, {
    hide : function(){
        
    },
    
    show : function(){
        
    },
    
    getMinWidth: function(){
        return this.minWidth;
    },
    
    getMinHeight: function(){
        return this.minHeight;
    }
});


YAHOO.ext.NorthLayoutRegion = function(mgr, config){
    YAHOO.ext.NorthLayoutRegion.superclass.constructor.call(this, mgr, config, 'north', 'n-resize');
    if(this.split){
        this.split.placement = YAHOO.ext.SplitBar.TOP;
        this.split.orientation = YAHOO.ext.SplitBar.VERTICAL;
        this.split.el.addClass('ylayout-split-v');
    }
    if(typeof config.initialSize != 'undefined'){
        this.el.setHeight(config.initialSize);
    }
};
YAHOO.extendX(YAHOO.ext.NorthLayoutRegion, YAHOO.ext.SplitLayoutRegion, {
    getBox : function(){
        if(this.collapsed){
            return this.collapsedEl.getBox();
        }
        var box = this.el.getBox();
        if(this.split){
            box.height += this.split.el.getHeight();
        }
        return box;
    },
    
    updateBox : function(box){
        if(this.split && !this.collapsed){
            box.height -= this.split.el.getHeight();
            this.split.el.setLeft(box.x);
            this.split.el.setTop(box.y+box.height);
            this.split.el.setWidth(box.width);
        }
        if(this.collapsed){
            this.el.setWidth(box.width);
            var bodyWidth = box.width - this.el.getBorderWidth('rl');
            this.bodyEl.setWidth(bodyWidth);
            if(this.activePanel && this.panelSize){
                this.activePanel.setSize(bodyWidth, this.panelSize.height);
            }
        }
        YAHOO.ext.NorthLayoutRegion.superclass.updateBox.call(this, box);
    }
});

YAHOO.ext.SouthLayoutRegion = function(mgr, config){
    YAHOO.ext.SouthLayoutRegion.superclass.constructor.call(this, mgr, config, 'south', 's-resize');
    if(this.split){
        this.split.placement = YAHOO.ext.SplitBar.BOTTOM;
        this.split.orientation = YAHOO.ext.SplitBar.VERTICAL;
        this.split.el.addClass('ylayout-split-v');
    }
    if(typeof config.initialSize != 'undefined'){
        this.el.setHeight(config.initialSize);
    }
};
YAHOO.extendX(YAHOO.ext.SouthLayoutRegion, YAHOO.ext.SplitLayoutRegion, {
    getBox : function(){
        if(this.collapsed){
            return this.collapsedEl.getBox();
        }
        var box = this.el.getBox();
        if(this.split){
            var sh = this.split.el.getHeight();
            box.height += sh;
            box.y -= sh;
        }
        return box;
    },
    
    updateBox : function(box){
        if(this.split && !this.collapsed){
            var sh = this.split.el.getHeight();
            box.height -= sh;
            box.y += sh;
            this.split.el.setLeft(box.x);
            this.split.el.setTop(box.y-sh);
            this.split.el.setWidth(box.width);
        }
        if(this.collapsed){
            this.el.setWidth(box.width);
            var bodyWidth = box.width - this.el.getBorderWidth('rl');
            this.bodyEl.setWidth(bodyWidth);
            if(this.activePanel && this.panelSize){
                this.activePanel.setSize(bodyWidth, this.panelSize.height);
            }
        }
        YAHOO.ext.SouthLayoutRegion.superclass.updateBox.call(this, box);
    }
});

YAHOO.ext.EastLayoutRegion = function(mgr, config){
    YAHOO.ext.EastLayoutRegion.superclass.constructor.call(this, mgr, config, 'east', 'e-resize');
    if(this.split){
        this.split.placement = YAHOO.ext.SplitBar.RIGHT;
        this.split.orientation = YAHOO.ext.SplitBar.HORIZONTAL;
        this.split.el.addClass('ylayout-split-h');
    }
    if(typeof config.initialSize != 'undefined'){
        this.el.setWidth(config.initialSize);
    }
};
YAHOO.extendX(YAHOO.ext.EastLayoutRegion, YAHOO.ext.SplitLayoutRegion, {
    getBox : function(){
        if(this.collapsed){
            return this.collapsedEl.getBox();
        }
        var box = this.el.getBox();
        if(this.split){
            var sw = this.split.el.getWidth();
            box.width += sw;
            box.x -= sw;
        }
        return box;
    },
    
    updateBox : function(box){
        if(this.split && !this.collapsed){
            var sw = this.split.el.getWidth();
            box.width -= sw;
            this.split.el.setLeft(box.x);
            this.split.el.setTop(box.y);
            this.split.el.setHeight(box.height);
            box.x += sw;
        }
        if(this.collapsed){
            this.el.setHeight(box.height);
            var bodyHeight = this.config.titlebar ? box.height - (this.titleEl.getHeight()||0) : box.height;
            bodyHeight -= this.el.getBorderWidth('tb');
            this.bodyEl.setHeight(bodyHeight);
            if(this.activePanel && this.panelSize){
                this.activePanel.setSize(this.panelSize.width, bodyHeight);
            }
        }
        YAHOO.ext.EastLayoutRegion.superclass.updateBox.call(this, box);
    }
});

YAHOO.ext.WestLayoutRegion = function(mgr, config){
    YAHOO.ext.WestLayoutRegion.superclass.constructor.call(this, mgr, config, 'west', 'w-resize');
    if(this.split){
        this.split.placement = YAHOO.ext.SplitBar.LEFT;
        this.split.orientation = YAHOO.ext.SplitBar.HORIZONTAL;
        this.split.el.addClass('ylayout-split-h');
    }
    if(typeof config.initialSize != 'undefined'){
        this.el.setWidth(config.initialSize);
    }
};
YAHOO.extendX(YAHOO.ext.WestLayoutRegion, YAHOO.ext.SplitLayoutRegion, {
    getBox : function(){
        if(this.collapsed){
            return this.collapsedEl.getBox();
        }
        var box = this.el.getBox();
        if(this.split){
            box.width += this.split.el.getWidth();
        }
        return box;
    },
    
    updateBox : function(box){
        if(this.split && !this.collapsed){
            var sw = this.split.el.getWidth();
            box.width -= sw;
            this.split.el.setLeft(box.x+box.width);
            this.split.el.setTop(box.y);
            this.split.el.setHeight(box.height);
        }
        if(this.collapsed){
            this.el.setHeight(box.height);
            var bodyHeight = this.config.titlebar ? box.height - (this.titleEl.getHeight()||0) : box.height;
            bodyHeight -= this.el.getBorderWidth('tb');
            this.bodyEl.setHeight(bodyHeight);
            if(this.activePanel && this.panelSize){
                this.activePanel.setSize(this.panelSize.width, bodyHeight);
            }
        }
        YAHOO.ext.WestLayoutRegion.superclass.updateBox.call(this, box);
    }
});


YAHOO.ext.ContentPanel = function(el, config, content){
    YAHOO.ext.ContentPanel.superclass.constructor.call(this);
    this.el = getEl(el, true);
    if(!this.el && config && config.autoCreate){
        if(typeof config.autoCreate == 'object'){
            if(!config.autoCreate.id){
                config.autoCreate.id = el;
            }
            this.el = YAHOO.ext.DomHelper.append(document.body,
                        config.autoCreate, true);
        }else{
            this.el = YAHOO.ext.DomHelper.append(document.body,
                        {tag: 'div', cls: 'ylayout-inactive-content', id: el}, true);
        }
    }
    this.closable = false;
    this.loaded = false;
    this.active = false;
    if(typeof config == 'string'){
        this.title = config;
    }else{
        YAHOO.ext.util.Config.apply(this, config);
    }
    if(this.resizeEl){
        this.resizeEl = getEl(this.resizeEl, true);
    }else{
        this.resizeEl = this.el;
    }
    this.events = {
        
        'activate' : new YAHOO.util.CustomEvent('activate'),
        
        'deactivate' : new YAHOO.util.CustomEvent('deactivate') 
    };
    if(this.autoScroll){
        this.el.setStyle('overflow', 'auto');
    }
    if(content){
        this.setContent(content);
    }
};

YAHOO.extendX(YAHOO.ext.ContentPanel, YAHOO.ext.util.Observable, {
    setRegion : function(region){
        this.region = region;
        if(region){
           this.el.replaceClass('ylayout-inactive-content', 'ylayout-active-content'); 
        }else{
           this.el.replaceClass('ylayout-active-content', 'ylayout-inactive-content'); 
        } 
    },
    
    
    getToolbar : function(){
        return this.toolbar;
    },
    
    setActiveState : function(active){
        this.active = active;
        if(!active){
            this.fireEvent('deactivate', this);
        }else{
            this.fireEvent('activate', this);
        }
    },
    
    setContent : function(content, loadScripts){
        this.el.update(content, loadScripts);
    },
    
    
    getUpdateManager : function(){
        return this.el.getUpdateManager();
    },
    
    
    setUrl : function(url, params, loadOnce){
        if(this.refreshDelegate){
            this.removeListener('activate', this.refreshDelegate);
        }
        this.refreshDelegate = this._handleRefresh.createDelegate(this, [url, params, loadOnce]);
        this.on('activate', this._handleRefresh.createDelegate(this, [url, params, loadOnce]));
        return this.el.getUpdateManager();
    },
    
    _handleRefresh : function(url, params, loadOnce){
        if(!loadOnce || !this.loaded){
            var updater = this.el.getUpdateManager();
            updater.update(url, params, this._setLoaded.createDelegate(this));
        }
    },
    
    _setLoaded : function(){
        this.loaded = true;
    }, 
    
    
    getId : function(){
        return this.el.id;
    },
    
    
    getEl : function(){
        return this.el;
    },
    
    adjustForComponents : function(width, height){
        if(this.toolbar){
            var te = this.toolbar.getEl();
            height -= te.getHeight();
            te.setWidth(width);
        }
        if(this.adjustments){
            width += this.adjustments[0];
            height += this.adjustments[1];
        }
        return {'width': width, 'height': height};
    },
    
    setSize : function(width, height){
        if(this.fitToFrame){
            var size = this.adjustForComponents(width, height);
            this.resizeEl.setSize(this.autoWidth ? 'auto' : size.width, size.height);
        }
    },
    
    
    getTitle : function(){
        return this.title;
    },
    
    
    setTitle : function(title){
        this.title = title;
        if(this.region){
            this.region.updatePanelTitle(this, title);
        }
    },
    
    
    isClosable : function(){
        return this.closable;
    },
    
    beforeSlide : function(){
        this.el.clip();
        this.resizeEl.clip();
    },
    
    afterSlide : function(){
        this.el.unclip();
        this.resizeEl.unclip();
    },
    
    
    refresh : function(){
        if(this.refreshDelegate){
           this.loaded = false;
           this.refreshDelegate();
        }
    },
    
    
    destroy : function(){
        this.el.removeAllListeners();
        var tempEl = document.createElement('span');
        tempEl.appendChild(this.el.dom);
        tempEl.innerHTML = '';
        this.el = null;
    }
});


YAHOO.ext.GridPanel = function(grid, config){
    this.wrapper = YAHOO.ext.DomHelper.append(document.body, 
        {tag: 'div', cls: 'ylayout-grid-wrapper ylayout-inactive-content'}, true);
    this.wrapper.dom.appendChild(grid.container.dom);
    YAHOO.ext.GridPanel.superclass.constructor.call(this, this.wrapper, config);
    if(this.toolbar){
        this.toolbar.el.insertBefore(this.wrapper.dom.firstChild);
    }
    grid.monitorWindowResize = false; 
    grid.autoHeight = false;
    grid.autoWidth = false;
    this.grid = grid;
    this.grid.container.replaceClass('ylayout-inactive-content', 'ylayout-component-panel');
};

YAHOO.extendX(YAHOO.ext.GridPanel, YAHOO.ext.ContentPanel, {
    getId : function(){
        return this.grid.id;
    },
    
    
    getGrid : function(){
        return this.grid;    
    },
    
    setSize : function(width, height){
        var grid = this.grid;
        var size = this.adjustForComponents(width, height);
        grid.container.setSize(size.width, size.height);
        grid.autoSize();
    },
    
    beforeSlide : function(){
        this.grid.getView().wrapEl.clip();
    },
    
    afterSlide : function(){
        this.grid.getView().wrapEl.unclip();
    },
    
    destroy : function(){
        this.grid.getView().unplugDataModel(this.grid.getDataModel());
        this.grid.container.removeAllListeners();
        YAHOO.ext.GridPanel.superclass.destroy.call(this);
    }
});



YAHOO.ext.NestedLayoutPanel = function(layout, config){
    YAHOO.ext.NestedLayoutPanel.superclass.constructor.call(this, layout.getEl(), config);
    layout.monitorWindowResize = false; 
    this.layout = layout;
    this.layout.getEl().addClass('ylayout-nested-layout');
};

YAHOO.extendX(YAHOO.ext.NestedLayoutPanel, YAHOO.ext.ContentPanel, {
    setSize : function(width, height){
        var size = this.adjustForComponents(width, height);
        this.layout.getEl().setSize(size.width, size.height);
        this.layout.layout();
    },
    
    
    getLayout : function(){
        return this.layout;
    }
});

YAHOO.ext.LayoutStateManager = function(layout){
     
     this.state = {
        north: {},
        south: {},
        east: {},
        west: {}       
    };
};

YAHOO.ext.LayoutStateManager.prototype = {
    init : function(layout, provider){
        this.provider = provider;
        var state = provider.get(layout.id+'-layout-state');
        if(state){
            var wasUpdating = layout.isUpdating();
            if(!wasUpdating){
                layout.beginUpdate();
            }
            for(var key in state){
                if(typeof state[key] != 'function'){
                    var rstate = state[key];
                    var r = layout.getRegion(key);
                    if(r && rstate){
                        if(rstate.size){
                            r.resizeTo(rstate.size);
                        }
                        if(rstate.collapsed == true){
                            r.collapse(true);
                        }else{
                            r.expand(null, true);
                        }
                    }
                }
            }
            if(!wasUpdating){
                layout.endUpdate();
            }
            this.state = state; 
        }
        this.layout = layout;
        layout.on('regionresized', this.onRegionResized, this, true);
        layout.on('regioncollapsed', this.onRegionCollapsed, this, true);
        layout.on('regionexpanded', this.onRegionExpanded, this, true);
    },
    
    storeState : function(){
        this.provider.set(this.layout.id+'-layout-state', this.state);
    },
    
    onRegionResized : function(region, newSize){
        this.state[region.getPosition()].size = newSize;
        this.storeState();
    },
    
    onRegionCollapsed : function(region){
        this.state[region.getPosition()].collapsed = true;
        this.storeState();
    },
    
    onRegionExpanded : function(region){
        this.state[region.getPosition()].collapsed = false;
        this.storeState();
    }
};

YAHOO.ext.BasicDialog = function(el, config){
    this.el = getEl(el);
    var dh = YAHOO.ext.DomHelper;
    if(!this.el && config && config.autoCreate){
        if(typeof config.autoCreate == 'object'){
            if(!config.autoCreate.id){
                config.autoCreate.id = el;
            }
            this.el = dh.append(document.body,
                        config.autoCreate, true);
        }else{
            this.el = dh.append(document.body,
                        {tag: 'div', id: el}, true);
        }
    }
    el = this.el;
    el.setDisplayed(true);
    el.hide = this.hideAction;
    this.id = el.id;
    el.addClass('ydlg');
    this.shadowOffset = 3;
    this.minHeight = 80;
    this.minWidth = 200;
    this.minButtonWidth = 75;
    this.defaultButton = null;
    
    YAHOO.ext.util.Config.apply(this, config);
    
    this.proxy = el.createProxy('ydlg-proxy');
    this.proxy.hide = this.hideAction;
    this.proxy.setOpacity(.5);
    this.proxy.hide();
    
    if(config.width){
        el.setWidth(config.width);
    }
    if(config.height){
        el.setHeight(config.height);
    }
    this.size = el.getSize();
    if(typeof config.x != 'undefined' && typeof config.y != 'undefined'){
        this.xy = [config.x,config.y];
    }else{
        this.xy = el.getCenterXY(true);
    }
    
    var cn = el.dom.childNodes;
    for(var i = 0, len = cn.length; i < len; i++) {
    	var node = cn[i];
    	if(node && node.nodeType == 1){
    	    if(YAHOO.util.Dom.hasClass(node, 'ydlg-hd')){
    	        this.header = getEl(node, true);
    	    }else if(YAHOO.util.Dom.hasClass(node, 'ydlg-bd')){
    	        this.body = getEl(node, true);
    	    }else if(YAHOO.util.Dom.hasClass(node, 'ydlg-ft')){
    	        
                this.footer = getEl(node, true);
    	    }
    	}
    }
    
    if(!this.header){
        
        this.header = dh.append(el.dom, {tag: 'div', cls:'ydlg-hd'}, true);
    }
    if(this.title){
        this.header.update(this.title);
    }
    if(!this.body){
        
        this.body = dh.append(el.dom, {tag: 'div', cls:'ydlg-bd'}, true);
    }
    
    var hl = dh.insertBefore(this.header.dom, {tag: 'div', cls:'ydlg-hd-left'});
    var hr = dh.append(hl, {tag: 'div', cls:'ydlg-hd-right'});
    hr.appendChild(this.header.dom);
    
    
    this.bwrap = dh.insertBefore(this.body.dom, {tag: 'div', cls:'ydlg-dlg-body'}, true);
    this.bwrap.dom.appendChild(this.body.dom);
    if(this.footer) this.bwrap.dom.appendChild(this.footer.dom);
    
    if(this.autoScroll !== false && !this.autoTabs){
        this.body.setStyle('overflow', 'auto');
    }
    if(this.closable !== false){
        this.el.addClass('ydlg-closable');
        this.close = dh.append(el.dom, {tag: 'div', cls:'ydlg-close'}, true);
        this.close.mon('click', function(){
            this.hide();
        }, this, true);
    }
    if(this.resizable !== false){
        this.el.addClass('ydlg-resizable');
        this.resizer = new YAHOO.ext.Resizable(el, {
            minWidth: this.minWidth || 80, 
            minHeight:this.minHeight || 80, 
            handles: 'all',
            pinned: true
        });
        this.resizer.on('beforeresize', this.beforeResize, this, true);
        this.resizer.on('resize', this.onResize, this, true);
    }
    if(this.draggable !== false){
        el.addClass('ydlg-draggable');
        if (!this.proxyDrag) {
            var dd = new YAHOO.util.DD(el.dom.id, 'WindowDrag');
        }
        else {
            var dd = new YAHOO.util.DDProxy(el.dom.id, 'WindowDrag', {dragElId: this.proxy.id});
        }
        dd.setHandleElId(this.header.id);
        dd.endDrag = this.endMove.createDelegate(this);
        dd.startDrag = this.startMove.createDelegate(this);
        dd.onDrag = this.onDrag.createDelegate(this);
        this.dd = dd;
    }
    if(this.modal){
        this.mask = dh.append(document.body, {tag: 'div', cls:'ydlg-mask'}, true);
        this.mask.enableDisplayMode('block');
        this.mask.hide();
    }
    if(this.shadow){
        this.shadow = el.createProxy({tag: 'div', cls:'ydlg-shadow'});
        this.shadow.setOpacity(.3);
        this.shadow.setVisibilityMode(YAHOO.ext.Element.VISIBILITY);
        this.shadow.setDisplayed('block');
        this.shadow.hide = this.hideAction;
        this.shadow.hide();
    }else{
        this.shadowOffset = 0;
    }
    if(this.shim){
        this.shim = this.el.createShim();
        this.shim.hide = this.hideAction;
        this.shim.hide();
    }
    if(this.autoTabs){
        var tabEls = YAHOO.util.Dom.getElementsByClassName('ydlg-tab', this.tabTag || 'div', el.dom);
        if(tabEls.length > 0){
            this.body.addClass(this.tabPosition == 'bottom' ? 'ytabs-bottom' : 'ytabs-top');
            this.tabs = new YAHOO.ext.TabPanel(this.body.dom, this.tabPosition == 'bottom');
            for(var i = 0, len = tabEls.length; i < len; i++) {
            	var tabEl = tabEls[i];
            	this.tabs.addTab(YAHOO.util.Dom.generateId(tabEl), tabEl.title);
            	tabEl.title = '';
            }
            this.tabs.activate(tabEls[0].id);
        }
    }
    this.syncBodyHeight();
    this.events = {
        
        'keydown' : true,
        
        'move' : true,
        
        'resize' : true,
        
        'beforehide' : true,
        
        'hide' : true,
        
        'beforeshow' : true,
        
        'show' : true
    };
    el.mon('keydown', this.onKeyDown, this, true);
    el.mon("mousedown", this.toFront, this, true);

    YAHOO.ext.EventManager.onWindowResize(this.adjustViewport, this, true);
    this.el.hide();
    YAHOO.ext.DialogManager.register(this);
};

YAHOO.extendX(YAHOO.ext.BasicDialog, YAHOO.ext.util.Observable, {
    
    setTitle : function(text){
        this.header.update(text);
        return this; 
    },
    
    beforeResize : function(){
        this.resizer.minHeight = Math.max(this.minHeight, this.getHeaderFooterHeight(true)+40);
    },
    
    onResize : function(){
        this.refreshSize();
        this.syncBodyHeight();
        this.adjustAssets();
        this.fireEvent('resize', this, this.size.width, this.size.height);
    },
    
    onKeyDown : function(e){
        this.fireEvent('keydown', this, e);
    },
    
    
    resizeTo : function(width, height){
        this.el.setSize(width, height);
        this.size = {width: width, height: height};
        this.syncBodyHeight();
        if(this.fixedcenter){
            this.center();
        }
        if(this.isVisible()){
            this.constrainXY();
            this.adjustAssets();
        }
        this.fireEvent('resize', this, width, height);
        return this;
    },
    
    
    addKeyListener : function(key, fn, scope){
        var keyCode, shift, ctrl, alt;
        if(typeof key == 'object' && !(key instanceof Array)){
            keyCode = key['key'];
            shift = key['shift'];
            ctrl = key['ctrl'];
            alt = key['alt'];
        }else{
            keyCode = key;
        }
        var handler = function(dlg, e){
            if((!shift || e.shiftKey) && (!ctrl || e.ctrlKey) &&  (!alt || e.altKey)){
                var k = e.getKey();
                if(keyCode instanceof Array){
                    for(var i = 0, len = keyCode.length; i < len; i++){
                        if(keyCode[i] == k){
                          fn.call(scope || window, dlg, k, e);
                          return;
                        }
                    }
                }else{
                    if(k == keyCode){
                        fn.call(scope || window, dlg, k, e);
                    }
                }
            }
        };
        this.on('keydown', handler);
        return this; 
    },
    
    
    getTabs : function(){
        if(!this.tabs){
            this.body.addClass(this.tabPosition == 'bottom' ? 'ytabs-bottom' : 'ytabs-top');
            this.tabs = new YAHOO.ext.TabPanel(this.body.dom, this.tabPosition == 'bottom');
        }
        return this.tabs;    
    },
    
    
    addButton : function(config, handler, scope){
        var dh = YAHOO.ext.DomHelper;
        if(!this.footer){
            this.footer = dh.append(this.bwrap.dom, {tag: 'div', cls:'ydlg-ft'}, true);
        }
        var bconfig = {
            handler: handler,
            scope: scope,
            minWidth: this.minButtonWidth
        };
        if(typeof config == 'string'){
            bconfig.text = config;
        }else{
            bconfig.dhconfig = config;
        }
        var btn = new YAHOO.ext.Button(this.footer, bconfig);
        this.syncBodyHeight();
        if(!this.buttons){
            this.buttons = [];
        }
        this.buttons.push(btn);
        return btn;
    },
    
    
    setDefaultButton : function(btn){
        this.defaultButton = btn;  
        return this;
    },
    
    getHeaderFooterHeight : function(safe){
        var height = 0;
        if(this.header){
           height += this.header.getHeight();
        }
        if(this.footer){
            var fm = this.footer.getMargins();
            height += (this.footer.getHeight()+fm.top+fm.bottom);
        }
        height += this.bwrap.getPadding('tb')+this.bwrap.getBorderWidth('tb');
        return height;
    },
    
    syncBodyHeight : function(){
        var height = this.size.height - this.getHeaderFooterHeight(false);
        var bm = this.body.getMargins();
        this.body.setHeight(height-(bm.top+bm.bottom));
        if(this.tabs){
            this.tabs.syncHeight();
        }
        this.bwrap.setHeight(this.size.height-this.header.getHeight());
        
        this.body.setWidth(this.el.getWidth(true)-this.bwrap.getBorderWidth('lr')-this.bwrap.getPadding('lr'));
    },
    
    
    restoreState : function(){
        var box = YAHOO.ext.state.Manager.get(this.el.id + '-state');
        if(box && box.width){
            this.xy = [box.x, box.y];
            this.resizeTo(box.width, box.height);
        }
        return this; 
    },
    
    beforeShow : function(){
        if(this.fixedcenter) {
            this.xy = this.el.getCenterXY(true);
        }
        if(this.modal){
            YAHOO.util.Dom.addClass(document.body, 'masked');
            this.mask.setSize(YAHOO.util.Dom.getDocumentWidth(), YAHOO.util.Dom.getDocumentHeight());
            this.mask.show();
        }
        this.constrainXY();
    },
    
    animShow : function(){
        var b = getEl(this.animateTarget, true).getBox();
        this.proxy.setSize(b.width, b.height);
        this.proxy.setLocation(b.x, b.y);
        this.proxy.show();
        this.proxy.setBounds(this.xy[0], this.xy[1], this.size.width, this.size.height, 
                    true, .35, this.showEl.createDelegate(this));
    },
    
    
    show : function(animateTarget){
        if (this.fireEvent('beforeshow', this) === false){
            return;
        }
        if(this.syncHeightBeforeShow){
            this.syncBodyHeight();
        }
        this.animateTarget = animateTarget || this.animateTarget;
        if(!this.el.isVisible()){
            this.beforeShow();
            if(this.animateTarget){
                this.animShow();
            }else{
                this.showEl();
            }
        }
        return this; 
    },
    
    showEl : function(){
        this.proxy.hide();
        this.el.setXY(this.xy);
        this.el.show();
        this.adjustAssets(true);
        this.toFront();
        if(this.defaultButton){
            this.defaultButton.focus();
        }
        this.fireEvent('show', this);
    },
    
    constrainXY : function(){
        if(this.constraintoviewport !== false){
            if(!this.viewSize){
                this.viewSize = [YAHOO.util.Dom.getViewportWidth(), YAHOO.util.Dom.getViewportHeight()];
            }
            var x = this.xy[0], y = this.xy[1];
            var w = this.size.width, h = this.size.height;
            var vw = this.viewSize[0], vh = this.viewSize[1];
            
            var moved = false;
            
            if(x + w > vw){
                x = vw - w;
                moved = true;
            }
            if(y + h > vh){
                y = vh - h;
                moved = true;
            }
            
            if(x < 0){
                x = 0;
                moved = true;
            }
            if(y < 0){
                y = 0;
                moved = true;
            }
            if(moved){
                
                this.xy = [x, y];
                if(this.isVisible()){
                    this.el.setLocation(x, y);
                    this.adjustAssets();
                }
            }
        }
    },
    
    onDrag : function(){
        if(!this.proxyDrag){
            this.xy = this.el.getXY();
            this.adjustAssets();
        }   
    },
    
    adjustAssets : function(doShow){
        var x = this.xy[0], y = this.xy[1];
        var w = this.size.width, h = this.size.height;
        if(doShow === true){
            if(this.shadow){
                this.shadow.show();
            }
            if(this.shim){
                this.shim.show();
            }
        }
        if(this.shadow && this.shadow.isVisible()){
            this.shadow.setBounds(x + this.shadowOffset, y + this.shadowOffset, w, h);
        }
        if(this.shim && this.shim.isVisible()){
            this.shim.setBounds(x, y, w, h);
        }
    },
    
    
    adjustViewport : function(w, h){
        if(!w || !h){
            w = YAHOO.util.Dom.getViewportWidth();
            h = YAHOO.util.Dom.getViewportHeight();
        }
        
        this.viewSize = [w, h];
        if(this.modal && this.mask.isVisible()){
            this.mask.setSize(w, h); 
            this.mask.setSize(YAHOO.util.Dom.getDocumentWidth(), YAHOO.util.Dom.getDocumentHeight());
        }
        if(this.isVisible()){
            this.constrainXY();
        }
    },
    
    
    destroy : function(removeEl){
        YAHOO.ext.EventManager.removeResizeListener(this.adjustViewport, this);
        if(this.tabs){
            this.tabs.destroy(removeEl);
        }
        if(removeEl === true){
            this.el.update('');
            this.el.remove();
        }
        YAHOO.ext.DialogManager.unregister(this);
    },
    
    startMove : function(){
        if(this.proxyDrag){
            this.proxy.show();
        }
        if(this.constraintoviewport !== false){
            this.dd.constrainTo(document.body, {right: this.shadowOffset, bottom: this.shadowOffset});
        }
    },
    
    endMove : function(){
        if(!this.proxyDrag){
            YAHOO.util.DD.prototype.endDrag.apply(this.dd, arguments);
        }else{
            YAHOO.util.DDProxy.prototype.endDrag.apply(this.dd, arguments);
            this.proxy.hide();
        }
        this.refreshSize();
        this.adjustAssets();
        this.fireEvent('move', this, this.xy[0], this.xy[1])
    },
    
    
    toFront : function(){
        YAHOO.ext.DialogManager.bringToFront(this);  
        return this; 
    },
    
    
    toBack : function(){
        YAHOO.ext.DialogManager.sendToBack(this);  
        return this; 
    },
    
    
    center : function(){
        this.moveTo(this.el.getCenterXY(true));
        return this; 
    },
    
    
    moveTo : function(x, y){
        this.xy = [x,y];
        if(this.isVisible()){
            this.el.setXY(this.xy);
            this.adjustAssets();
        }
        return this; 
    },
    
    
    isVisible : function(){
        return this.el.isVisible();    
    },
    
    animHide : function(callback){
        var b = getEl(this.animateTarget, true).getBox();
        this.proxy.show();
        this.proxy.setBounds(this.xy[0], this.xy[1], this.size.width, this.size.height);
        this.el.hide();
        this.proxy.setBounds(b.x, b.y, b.width, b.height, true, .35, 
                    this.hideEl.createDelegate(this, [callback]));
    },
    
    
    hide : function(callback){
        if (this.fireEvent('beforehide', this) === false)
            return;
        
        if(this.shadow){
            this.shadow.hide();
        }
        if(this.shim) {
          this.shim.hide();
        }
        if(this.animateTarget){
           this.animHide(callback);
        }else{
            this.el.hide();
            this.hideEl(callback);
        }
        return this; 
    },
    
    hideEl : function(callback){
        this.proxy.hide();
        if(this.modal){
            this.mask.hide();
            YAHOO.util.Dom.removeClass(document.body, 'masked');
        }
        this.fireEvent('hide', this);
        if(typeof callback == 'function'){
            callback();
        }
    },
    
    hideAction : function(){
        this.setLeft('-10000px');  
        this.setTop('-10000px');
        this.setStyle('visibility', 'hidden'); 
    },
    
    refreshSize : function(){
        this.size = this.el.getSize();
        this.xy = this.el.getXY();
        YAHOO.ext.state.Manager.set(this.el.id + '-state', this.el.getBox());
    },
    
    setZIndex : function(index){
        if(this.modal){
            this.mask.setStyle('z-index', index);
        }
        if(this.shadow){
            this.shadow.setStyle('z-index', ++index);
        }
        if(this.shim){
            this.shim.setStyle('z-index', ++index);
        }
        this.el.setStyle('z-index', ++index);
        if(this.proxy){
            this.proxy.setStyle('z-index', ++index);
        }
        if(this.resizer){
            this.resizer.proxy.setStyle('z-index', ++index);
        }
        
        this.lastZIndex = index;
    },
    
    
    getEl : function(){
        return this.el;
    }
});


YAHOO.ext.DialogManager = function(){
    var list = {};
    var accessList = [];
    var front = null;
    
    var sortDialogs = function(d1, d2){
        return (!d1._lastAccess || d1._lastAccess < d2._lastAccess) ? -1 : 1;
    };
    
    var orderDialogs = function(){
        accessList.sort(sortDialogs);
        var seed = YAHOO.ext.DialogManager.zseed;
        for(var i = 0, len = accessList.length; i < len; i++){
            if(accessList[i]){
                accessList[i].setZIndex(seed + (i*10));
            }  
        }
    };
    
    return {
        
        zseed : 10000,
        
        
        register : function(dlg){
            list[dlg.id] = dlg;
            accessList.push(dlg);
        },
        
        unregister : function(dlg){
            delete list[dlg.id];
            if(!accessList.indexOf){
                for(var i = 0, len = accessList.length; i < len; i++){
                    accessList.splice(i, 1);
                    return;
                }
            }else{
                var i = accessList.indexOf(dlg);
                if(i != -1){
                    accessList.splice(i, 1);
                }
            }
        },
        
        
        get : function(id){
            return typeof id == 'object' ? id : list[id];
        },
        
        
        bringToFront : function(dlg){
            dlg = this.get(dlg);
            if(dlg != front){
                front = dlg;
                dlg._lastAccess = new Date().getTime();
                orderDialogs();
            }
            return dlg;
        },
        
        
        sendToBack : function(dlg){
            dlg = this.get(dlg);
            dlg._lastAccess = -(new Date().getTime());
            orderDialogs();
            return dlg;
        }
    };
}();


YAHOO.ext.LayoutDialog = function(el, config){
    config.autoTabs = false;
    YAHOO.ext.LayoutDialog.superclass.constructor.call(this, el, config);
    this.body.setStyle({overflow:'hidden', position:'relative'});
    this.layout = new YAHOO.ext.BorderLayout(this.body.dom, config);
    this.layout.monitorWindowResize = false;
    
    this.center = YAHOO.ext.BasicDialog.prototype.center;
    this.on('show', this.layout.layout, this.layout, true);
};
YAHOO.extendX(YAHOO.ext.LayoutDialog, YAHOO.ext.BasicDialog, {
    
    endUpdate : function(){
        this.layout.endUpdate();
    },
    
    beginUpdate : function(){
        this.layout.beginUpdate();
    },
    
    getLayout : function(){
        return this.layout;
    },
    syncBodyHeight : function(){
        YAHOO.ext.LayoutDialog.superclass.syncBodyHeight.call(this);
        if(this.layout)this.layout.layout();
    }
});

YAHOO.ext.Button = function(renderTo, config){
    YAHOO.ext.util.Config.apply(this, config);
    this.events = {
        
	    'click' : true  
    };
    if(renderTo){
        this.render(renderTo);
    }
};

YAHOO.extendX(YAHOO.ext.Button, YAHOO.ext.util.Observable, {
    render : function(renderTo){
        var btn;
        if(!this.dhconfig){
            if(!YAHOO.ext.Button.buttonTemplate){
                
                YAHOO.ext.Button.buttonTemplate = new YAHOO.ext.DomHelper.Template('<a href="#" class="ybtn-focus"><table border="0" cellpadding="0" cellspacing="0" class="ybtn-wrap"><tbody><tr><td class="ybtn-left">&#160;</td><td class="ybtn-center" unselectable="on">{0}</td><td class="ybtn-right">&#160;</td></tr></tbody></table></a>');
            }
            btn = YAHOO.ext.Button.buttonTemplate.append(
               getEl(renderTo).dom, [this.text], true);
            this.tbl = getEl(btn.dom.firstChild, true);
        }else{
            btn = YAHOO.ext.DomHelper.append(this.footer.dom, this.dhconfig, true);
        }
        this.el = btn;
        this.autoWidth();
        btn.addClass('ybtn');
        btn.mon('click', this.onClick, this, true);
        btn.on('mouseover', this.onMouseOver, this, true);
        btn.on('mouseout', this.onMouseOut, this, true);
        btn.on('mousedown', this.onMouseDown, this, true);
        btn.on('mouseup', this.onMouseUp, this, true);
    },
    
    getEl : function(){
        return this.el;  
    },
    
    autoWidth : function(){
        if(this.tbl){
            this.el.setWidth('auto');
            this.tbl.setWidth('auto');
            if(this.minWidth){
                 if(this.tbl.getWidth() < this.minWidth){
                     this.tbl.setWidth(this.minWidth);
                 }
            }
            this.el.setWidth(this.tbl.getWidth());
        } 
    },
    
    setHandler : function(handler, scope){
        this.handler = handler;
        this.scope = scope;  
    },
    
    
    setText : function(text){
        this.el.dom.firstChild.firstChild.firstChild.childNodes[1].innerHTML = text;
        this.autoWidth();
    },
    
    
    show: function(){
        this.el.setStyle('display', '');
    },
    
    
    hide: function(){
        this.el.setStyle('display', 'none'); 
    },
    
    
    setVisible: function(visible){
        if(visible) {
            this.show();
        }else{
            this.hide();
        }
    },
    
    
    focus : function(){
        this.el.focus();    
    },
    
    
    disable : function(){
        this.el.addClass('ybtn-disabled');
        this.disabled = true;
    },
    
    
    enable : function(){
        this.el.removeClass('ybtn-disabled');
        this.disabled = false;
    },
    
    onClick : function(e){
        e.preventDefault();
        if(!this.disabled){
            this.fireEvent('click', this, e);
            this.handler.call(this.scope || window, this, e);
        }
    },
    onMouseOver : function(e){
        if(!this.disabled){
            this.el.addClass('ybtn-over');
        }
    },
    onMouseOut : function(e){
        this.el.removeClass('ybtn-over');
    },
    onMouseDown : function(){
        if(!this.disabled){
            this.el.addClass('ybtn-click');
        }
    },
    onMouseUp : function(){
        this.el.removeClass('ybtn-click');
    }    
});

YAHOO.ext.View = function(container, tpl, dataModel, config){
    this.el = getEl(container, true);
    this.nodes = this.el.dom.childNodes;
    if(typeof tpl == 'string'){
        tpl = new YAHOO.ext.Template(tpl);
    }
    tpl.compile();
    
    this.tpl = tpl;
    this.setDataModel(dataModel);
    var CE = YAHOO.util.CustomEvent;
	
	this.events = {
	    
        'click' : true,
	    
        'dblclick' : true,
	    
        'contextmenu' : true,
	    
        'selectionchange' : true,
        
        
        'beforeselect' : true
	};
	this.el.mon("click", this.onClick, this, true);
    this.el.mon("dblclick", this.onDblClick, this, true);
    this.el.mon("contextmenu", this.onContextMenu, this, true);
    
    
    this.selectedClass = 'ydataview-selected';
    
    this.emptyText = '';
    
    this.selections = [];
    this.lastSelection = null;
    
    
    this.jsonRoot = null;
    YAHOO.ext.util.Config.apply(this, config);
    if(this.renderUpdates || this.jsonRoot){
        var um = this.el.getUpdateManager();
        um.setRenderer(this);
    }
};

YAHOO.extendX(YAHOO.ext.View, YAHOO.ext.util.Observable, {
    
    getEl : function(){
        return this.el;  
    },
    
    render : function(el, response){
        this.clearSelections();
        this.el.update('');
        var o;
        try{
            o = YAHOO.ext.util.JSON.decode(response.responseText);
            if(this.jsonRoot){
                o = eval('o.' + this.jsonRoot);
            }
        }catch(e){}
        
        this.jsonData = o;
        this.beforeRender();
        this.refresh();
    },
    
    beforeRender : function(){
        
    },
    
    
     refresh : function(){
        this.clearSelections();
        this.el.update('');
        this.html = [];
        if(this.renderUpdates || this.jsonRoot){
            var o = this.jsonData;
            if(o){
                for(var i = 0, len = o.length; i < len; i++) {
                	this.renderEach(o[i]);
                }
            }
        }else{
           this.dataModel.each(this.renderEach, this);
        }
        var strHtml;
        if(this.html.length > 0){
            strHtml = this.html.join('');
        }else{
            strHtml = this.emptyText;
        }
        this.el.update(strHtml);
        this.html = null;
        this.nodes = this.el.dom.childNodes;
        this.updateIndexes(0);
    },
    
    
    prepareData : function(data, index){
        return data;  
    },
    
    renderEach : function(data){
        this.html[this.html.length] = this.tpl.applyTemplate(this.prepareData(data));
    },
    
    
    refreshNode : function(index){
        this.refreshNodes(index, index);
    },
    
    refreshNodes : function(dm, startIndex, endIndex){
        this.clearSelections();
        var dm = this.dataModel;
        var ns = this.nodes;
        for(var i = startIndex; i <= endIndex; i++){
            var d = this.prepareData(dm.getRow(i), i);
            if(i < ns.length-1){
                var old = ns[i];
                this.tpl.insertBefore(old, d);
                this.el.dom.removeChild(old);
            }else{
                this.tpl.append(this.el.dom, d);
            }
        }
        this.updateIndexes(startIndex, endIndex);
    },
    
    deleteNodes : function(dm, startIndex, endIndex){
        this.clearSelections();
        if(startIndex == 0 && endIndex >= this.nodes.length-1){
            this.el.update('');
        }else{
            var el = this.el.dom;
            for(var i = startIndex; i <= endIndex; i++){
                el.removeChild(this.nodes[startIndex]);
            }
            this.updateIndexes(startIndex);
        }
    },
    
    insertNodes : function(dm, startIndex, endIndex){
        if(this.nodes.length == 0){
            this.refresh();
        }else{
            this.clearSelections();
            var t = this.tpl;
            var before = this.nodes[startIndex];
            var dm = this.dataModel;
            if(before){
                for(var i = startIndex; i <= endIndex; i++){
                    t.insertBefore(before, this.prepareData(dm.getRow(i), i));
                }
            }else{
                var el = this.el.dom;
                for(var i = startIndex; i <= endIndex; i++){
                    t.append(el, this.prepareData(dm.getRow(i), i));
                }
            }
            this.updateIndexes(startIndex);
        }
    },
    
    updateIndexes : function(dm, startIndex, endIndex){
        var ns = this.nodes;
        startIndex = startIndex || 0;
        endIndex = endIndex || ns.length-1;
        for(var i = startIndex; i <= endIndex; i++){
            ns[i].nodeIndex = i;
        }
    },
    
    
     setDataModel : function(dm){
        if(!dm) return;
        this.unplugDataModel(this.dataModel);
        this.dataModel = dm;
        dm.on('cellupdated', this.refreshNode, this, true);
        dm.on('datachanged', this.refresh, this, true);
        dm.on('rowsdeleted', this.deleteNodes, this, true);
        dm.on('rowsinserted', this.insertNodes, this, true);
        dm.on('rowsupdated', this.refreshNodes, this, true);
        dm.on('rowssorted', this.refresh, this, true);
        this.refresh();
    },
    
    
    unplugDataModel : function(dm){
        if(!dm) return;
        dm.removeListener('cellupdated', this.refreshNode, this);
        dm.removeListener('datachanged', this.refresh, this);
        dm.removeListener('rowsdeleted', this.deleteNodes, this);
        dm.removeListener('rowsinserted', this.insertNodes, this);
        dm.removeListener('rowsupdated', this.refreshNodes, this);
        dm.removeListener('rowssorted', this.refresh, this);
        this.dataModel = null;
    },
    
    
    findItemFromChild : function(node){
        var el = this.el.dom;
        if(!node || node.parentNode == el){
		    return node;
	    }
	    var p = node.parentNode;
	    while(p && p != el){
            if(p.parentNode == el){
            	return p;
            }
            p = p.parentNode;
        }
	    return null;
    },
    
    
    onClick : function(e){
        var item = this.findItemFromChild(e.getTarget());
        if(item){
            var index = this.indexOf(item);
            this.onItemClick(item, index, e);
            this.fireEvent('click', this, index, item, e);
        }else{
            this.clearSelections();
        }
    },

    
    onContextMenu : function(e){
        var item = this.findItemFromChild(e.getTarget());
        if(item){
            this.fireEvent('contextmenu', this, this.indexOf(item), item, e);
        }
    },

    
    onDblClick : function(e){
        var item = this.findItemFromChild(e.getTarget());
        if(item){
            this.fireEvent('dblclick', this, this.indexOf(item), item, e);
        }
    },
    
    onItemClick : function(item, index, e){
        if(this.multiSelect || this.singleSelect){
            if(this.multiSelect && e.shiftKey && this.lastSelection){
                this.select(this.getNodes(this.indexOf(this.lastSelection), index), false);
            }else{
                this.select(item, this.multiSelect && e.ctrlKey);
                this.lastSelection = item;
            }
        }
    },
    
    
     getSelectionCount : function(){
        return this.selections.length;
    },
    
    
    getSelectedNodes : function(){
        return this.selections;
    },
    
    
    getSelectedIndexes : function(){
        var indexes = [];
        for(var i = 0, len = this.selections.length; i < len; i++) {
        	indexes.push(this.selections[i].nodeIndex);
        }
        return indexes;
    },
    
    
    clearSelections : function(suppressEvent){
        if(this.multiSelect || this.singleSelect){
            YAHOO.util.Dom.removeClass(this.selections, this.selectedClass);
            this.selections = [];
            if(!suppressEvent){
                this.fireEvent('selectionchange', this, this.selections);
            }
        }
    },
    
    
    select : function(nodeInfo, keepExisting, suppressEvent){
        if(!keepExisting){
            this.clearSelections(true);
        }
        if(nodeInfo instanceof Array){
            for(var i = 0, len = nodeInfo.length; i < len; i++) {
            	this.select(nodeInfo[i], true, true);
            }
        }else{
            var node = this.getNode(nodeInfo);
            if(node){
                if(this.fireEvent('beforeselect', this, node, this.selections) !== false){
                    YAHOO.util.Dom.addClass(node, this.selectedClass);
                    this.selections.push(node);
                }
            }
        }
        if(!suppressEvent){
            this.fireEvent('selectionchange', this, this.selections);
        }
    },
    
    
     getNode : function(nodeInfo){
        if(typeof nodeInfo == 'object'){
            return nodeInfo;
        }else if(typeof nodeInfo == 'string'){
            return document.getElementById(nodeInfo);
        }else if(typeof nodeInfo == 'number'){
            return this.nodes[nodeInfo];
        }
        return null;
    },
    
    
    getNodes : function(start, end){
        var ns = this.nodes;
        startIndex = startIndex || 0;
        endIndex = typeof endIndex == 'undefined' ? ns.length-1 : endIndex;
        var nodes = [];
        for(var i = start; i <= end; i++) {
        	nodes.push(ns[i]);
        }
        return nodes;
    },
    
    
     indexOf : function(node){
        node = this.getNode(node);
        if(typeof node.nodeIndex == 'number'){
            return node.nodeIndex;
        }
        var ns = this.nodes;
        for(var i = 0, len = ns.length; i < len; i++) {
        	if(ns[i] == node){
        	    return i;
        	}
        }
        return -1;
    }
});

 
YAHOO.ext.JsonView = function(container, tpl, config){
    var cfg = config || {};
    cfg.renderUpdates = true;
    YAHOO.ext.JsonView.superclass.constructor.call(this, container, tpl, null, cfg);        
    
     this.events['beforerender'] = true;
     
     this.events['load'] = true;
     
     this.events['loadexception'] = true;
     this.el.getUpdateManager().on('update', this.onLoad, this, true);
     this.el.getUpdateManager().on('failure', this.onLoadException, this, true);
};
YAHOO.extendX(YAHOO.ext.JsonView, YAHOO.ext.View, {
    
    load : function(){
        var um = this.el.getUpdateManager();
        um.update.apply(um, arguments);
    },
    
    
    getCount : function(){
        return this.jsonData ? this.jsonData.length : 0;  
    },
    
    beforeRender : function(){
        this.snapshot = this.jsonData;    
        if(this.sortInfo){
            this.sort.apply(this, this.sortInfo);    
        }
        this.fireEvent('beforerender', this, this.jsonData);
    },
    
    onLoad : function(el, o){
       this.fireEvent('load', this, this.jsonData, o);
    },
    
    onLoadException : function(el, o){
       this.fireEvent('loadexception', this, o);
    },
    
    
    filter : function(property, value){
        if(this.jsonData){
            var data = [];
            var ss = this.snapshot;
            if(typeof value == 'string'){
                var vlen = value.length;
                if(vlen == 0){
                    this.clearFilter();
                    return;
                }
                for(var i = 0, len = ss.length; i < len; i++){
    				var o = ss[i];
    				if(o[property].substr(0, vlen) == value){
    					data.push(o);
    				}
    			}
            }else if(value.exec){ 
                for(var i = 0, len = ss.length; i < len; i++){
    				var o = ss[i];
    				if(value.test(o[property])){
    					data.push(o);
    				}
    			}
            }else{
                return;
            }
            this.jsonData = data;
    		this.refresh();
        }
	},
    
    
    filterBy : function(fn, scope){
        if(this.jsonData){
            var data = [];
            var ss = this.snapshot;
            for(var i = 0, len = ss.length; i < len; i++){
    			var o = ss[i];
    			if(fn.call(scope|| this, o)){
    				data.push(o);
    			}
    		}
    		this.jsonData = data;
    		this.refresh();
        }
    },
    
    
    clearFilter : function(){
        if(this.snapshot && this.jsonData != this.snapshot){
            this.jsonData = this.snapshot;
            this.refresh();
        }   
    },
    
    
    
    sort : function(property, dir, sortType){
        this.sortInfo = Array.prototype.slice.call(arguments, 0);
        if(this.jsonData){
            var p = property;
            var dsc = dir && dir.toLowerCase() == 'desc';
            var f = function(o1, o2){
            	var v1 = sortType ? sortType(o1[p]) : o1[p];
            	var v2 = sortType ? sortType(o2[p]) : o2[p];;
            	if(v1 < v2){
        			return dsc ? +1 : -1;
        		}else if(v1 > v2){
        			return dsc ? -1 : +1;
                }else{
        	    	return 0;
                }
            };
            this.jsonData.sort(f);
            this.refresh();
            if(this.jsonData != this.snapshot){
            	this.snapshot.sort(f);
            }
        }
    }
});
