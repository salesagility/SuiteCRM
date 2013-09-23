/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('node-pluginhost',function(Y){Y.Node.plug=function(){var args=Y.Array(arguments);args.unshift(Y.Node);Y.Plugin.Host.plug.apply(Y.Base,args);return Y.Node;};Y.Node.unplug=function(){var args=Y.Array(arguments);args.unshift(Y.Node);Y.Plugin.Host.unplug.apply(Y.Base,args);return Y.Node;};Y.mix(Y.Node,Y.Plugin.Host,false,null,1);Y.NodeList.prototype.plug=function(){var args=arguments;Y.NodeList.each(this,function(node){Y.Node.prototype.plug.apply(Y.one(node),args);});};Y.NodeList.prototype.unplug=function(){var args=arguments;Y.NodeList.each(this,function(node){Y.Node.prototype.unplug.apply(Y.one(node),args);});};},'3.3.0',{requires:['node-base','pluginhost']});