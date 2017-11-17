/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("node-pluginhost",function(a){a.Node.plug=function(){var b=a.Array(arguments);b.unshift(a.Node);a.Plugin.Host.plug.apply(a.Base,b);return a.Node;};a.Node.unplug=function(){var b=a.Array(arguments);b.unshift(a.Node);a.Plugin.Host.unplug.apply(a.Base,b);return a.Node;};a.mix(a.Node,a.Plugin.Host,false,null,1);a.NodeList.prototype.plug=function(){var b=arguments;a.NodeList.each(this,function(c){a.Node.prototype.plug.apply(a.one(c),b);});};a.NodeList.prototype.unplug=function(){var b=arguments;a.NodeList.each(this,function(c){a.Node.prototype.unplug.apply(a.one(c),b);});};},"3.3.0",{requires:["node-base","pluginhost"]});