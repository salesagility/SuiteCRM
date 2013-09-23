/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('plugin',function(Y){function Plugin(config){if(!(this.hasImpl&&this.hasImpl(Y.Plugin.Base))){Plugin.superclass.constructor.apply(this,arguments);}else{Plugin.prototype.initializer.apply(this,arguments);}}
Plugin.ATTRS={host:{writeOnce:true}};Plugin.NAME='plugin';Plugin.NS='plugin';Y.extend(Plugin,Y.Base,{_handles:null,initializer:function(config){this._handles=[];},destructor:function(){if(this._handles){for(var i=0,l=this._handles.length;i<l;i++){this._handles[i].detach();}}},doBefore:function(strMethod,fn,context){var host=this.get("host"),handle;if(strMethod in host){handle=this.beforeHostMethod(strMethod,fn,context);}else if(host.on){handle=this.onHostEvent(strMethod,fn,context);}
return handle;},doAfter:function(strMethod,fn,context){var host=this.get("host"),handle;if(strMethod in host){handle=this.afterHostMethod(strMethod,fn,context);}else if(host.after){handle=this.afterHostEvent(strMethod,fn,context);}
return handle;},onHostEvent:function(type,fn,context){var handle=this.get("host").on(type,fn,context||this);this._handles.push(handle);return handle;},afterHostEvent:function(type,fn,context){var handle=this.get("host").after(type,fn,context||this);this._handles.push(handle);return handle;},beforeHostMethod:function(strMethod,fn,context){var handle=Y.Do.before(fn,this.get("host"),strMethod,context||this);this._handles.push(handle);return handle;},afterHostMethod:function(strMethod,fn,context){var handle=Y.Do.after(fn,this.get("host"),strMethod,context||this);this._handles.push(handle);return handle;},toString:function(){return this.constructor.NAME+'['+this.constructor.NS+']';}});Y.namespace("Plugin").Base=Plugin;},'3.3.0',{requires:['base-base']});