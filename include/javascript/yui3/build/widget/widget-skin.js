/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("widget-skin",function(e){var d="boundingBox",b="contentBox",a="skin",c=e.ClassNameManager.getClassName;e.Widget.prototype.getSkinName=function(){var f=this.get(b)||this.get(d),h=new RegExp("\\b"+c(a)+"-(\\S+)"),g;if(f){f.ancestor(function(i){g=i.get("className").match(h);return g;});}return(g)?g[1]:null;};},"3.3.0",{requires:["widget-base"]});