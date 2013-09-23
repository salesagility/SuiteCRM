/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('node-event-delegate',function(Y){Y.Node.prototype.delegate=function(type){var args=Y.Array(arguments,0,true),index=(Y.Lang.isObject(type)&&!Y.Lang.isArray(type))?1:2;args.splice(index,0,this._node);return Y.delegate.apply(Y,args);};},'3.3.0',{requires:['node-base','event-delegate']});