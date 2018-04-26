/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("node-deprecated",function(b){var a=b.Node;a.ATTRS.data={getter:function(){return this._dataVal;},setter:function(c){this._dataVal=c;return c;},value:null};b.get=a.get=function(){return a.one.apply(a,arguments);};b.mix(a.prototype,{query:function(c){return this.one(c);},queryAll:function(c){return this.all(c);},each:function(d,c){c=c||this;return d.call(c,this);},item:function(c){return this;},size:function(){return this._node?1:0;}});},"3.3.0",{requires:["node-base"]});