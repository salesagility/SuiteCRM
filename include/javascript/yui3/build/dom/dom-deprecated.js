/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("dom-deprecated",function(a){a.mix(a.DOM,{children:function(d,b){var c=[];if(d){b=b||"*";c=a.Selector.query("> "+b,d);}return c;},firstByTag:function(b,c){var d;c=c||a.config.doc;if(b&&c.getElementsByTagName){d=c.getElementsByTagName(b)[0];}return d||null;},previous:function(b,d,c){return a.DOM.elementByAxis(b,"previousSibling",d,c);},next:function(b,d,c){return a.DOM.elementByAxis(b,"nextSibling",d,c);}});},"3.3.0",{requires:["dom-base"]});