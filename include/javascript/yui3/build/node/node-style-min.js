/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("node-style",function(a){(function(c){var b=["getStyle","getComputedStyle","setStyle","setStyles"];c.Node.importMethod(c.DOM,b);c.NodeList.importMethod(c.Node.prototype,b);})(a);},"3.3.0",{requires:["dom-style","node-base"]});