/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('node-load',function(Y){Y.Node.prototype._ioComplete=function(code,response,args){var selector=args[0],callback=args[1],tmp,content;if(response&&response.responseText){content=response.responseText;if(selector){tmp=Y.DOM.create(content);content=Y.Selector.query(selector,tmp);}
this.setContent(content);}
if(callback){callback.call(this,code,response);}};Y.Node.prototype.load=function(url,selector,callback){if(typeof selector=='function'){callback=selector;selector=null;}
var config={context:this,on:{complete:this._ioComplete},arguments:[selector,callback]};Y.io(url,config);return this;}},'3.3.0',{requires:['node-base','io-base']});