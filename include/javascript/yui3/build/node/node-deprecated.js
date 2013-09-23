/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('node-deprecated',function(Y){var Y_Node=Y.Node;Y_Node.ATTRS.data={getter:function(){return this._dataVal;},setter:function(val){this._dataVal=val;return val;},value:null};Y.get=Y_Node.get=function(){return Y_Node.one.apply(Y_Node,arguments);};Y.mix(Y_Node.prototype,{query:function(selector){return this.one(selector);},queryAll:function(selector){return this.all(selector);},each:function(fn,context){context=context||this;return fn.call(context,this);},item:function(index){return this;},size:function(){return this._node?1:0;}});},'3.3.0',{requires:['node-base']});