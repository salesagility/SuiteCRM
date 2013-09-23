/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('base-pluginhost',function(Y){var Base=Y.Base,PluginHost=Y.Plugin.Host;Y.mix(Base,PluginHost,false,null,1);Base.plug=PluginHost.plug;Base.unplug=PluginHost.unplug;},'3.3.0',{requires:['base-base','pluginhost']});