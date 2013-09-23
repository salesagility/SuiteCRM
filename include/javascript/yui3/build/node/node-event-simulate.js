/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('node-event-simulate',function(Y){Y.Node.prototype.simulate=function(type,options){Y.Event.simulate(Y.Node.getDOMNode(this),type,options);};},'3.3.0',{requires:['node-base','event-simulate']});