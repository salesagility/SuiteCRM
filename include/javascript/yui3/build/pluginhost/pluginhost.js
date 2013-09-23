/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('pluginhost-base',function(Y){var L=Y.Lang;function PluginHost(){this._plugins={};}
PluginHost.prototype={plug:function(Plugin,config){var i,ln,ns;if(L.isArray(Plugin)){for(i=0,ln=Plugin.length;i<ln;i++){this.plug(Plugin[i]);}}else{if(Plugin&&!L.isFunction(Plugin)){config=Plugin.cfg;Plugin=Plugin.fn;}
if(Plugin&&Plugin.NS){ns=Plugin.NS;config=config||{};config.host=this;if(this.hasPlugin(ns)){this[ns].setAttrs(config);}else{this[ns]=new Plugin(config);this._plugins[ns]=Plugin;}}}
return this;},unplug:function(plugin){var ns=plugin,plugins=this._plugins;if(plugin){if(L.isFunction(plugin)){ns=plugin.NS;if(ns&&(!plugins[ns]||plugins[ns]!==plugin)){ns=null;}}
if(ns){if(this[ns]){this[ns].destroy();delete this[ns];}
if(plugins[ns]){delete plugins[ns];}}}else{for(ns in this._plugins){if(this._plugins.hasOwnProperty(ns)){this.unplug(ns);}}}
return this;},hasPlugin:function(ns){return(this._plugins[ns]&&this[ns]);},_initPlugins:function(config){this._plugins=this._plugins||{};if(this._initConfigPlugins){this._initConfigPlugins(config);}},_destroyPlugins:function(){this.unplug();}};Y.namespace("Plugin").Host=PluginHost;},'3.3.0',{requires:['yui-base']});YUI.add('pluginhost-config',function(Y){var PluginHost=Y.Plugin.Host,L=Y.Lang;PluginHost.prototype._initConfigPlugins=function(config){var classes=(this._getClasses)?this._getClasses():[this.constructor],plug=[],unplug={},constructor,i,classPlug,classUnplug,pluginClassName;for(i=classes.length-1;i>=0;i--){constructor=classes[i];classUnplug=constructor._UNPLUG;if(classUnplug){Y.mix(unplug,classUnplug,true);}
classPlug=constructor._PLUG;if(classPlug){Y.mix(plug,classPlug,true);}}
for(pluginClassName in plug){if(plug.hasOwnProperty(pluginClassName)){if(!unplug[pluginClassName]){this.plug(plug[pluginClassName]);}}}
if(config&&config.plugins){this.plug(config.plugins);}};PluginHost.plug=function(hostClass,plugin,config){var p,i,l,name;if(hostClass!==Y.Base){hostClass._PLUG=hostClass._PLUG||{};if(!L.isArray(plugin)){if(config){plugin={fn:plugin,cfg:config};}
plugin=[plugin];}
for(i=0,l=plugin.length;i<l;i++){p=plugin[i];name=p.NAME||p.fn.NAME;hostClass._PLUG[name]=p;}}};PluginHost.unplug=function(hostClass,plugin){var p,i,l,name;if(hostClass!==Y.Base){hostClass._UNPLUG=hostClass._UNPLUG||{};if(!L.isArray(plugin)){plugin=[plugin];}
for(i=0,l=plugin.length;i<l;i++){p=plugin[i];name=p.NAME;if(!hostClass._PLUG[name]){hostClass._UNPLUG[name]=p;}else{delete hostClass._PLUG[name];}}}};},'3.3.0',{requires:['pluginhost-base']});YUI.add('pluginhost',function(Y){},'3.3.0',{use:['pluginhost-base','pluginhost-config']});