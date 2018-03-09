/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("querystring-parse-simple",function(b){var a=b.namespace("QueryString");a.parse=function(e,g,d){g=g||"&";d=d||"=";for(var k={},h=0,j=e.split(g),f=j.length,c;h<f;h++){c=j[h].split(d);if(c.length>0){k[a.unescape(c.shift())]=a.unescape(c.join(d));}}return k;};a.unescape=function(c){return decodeURIComponent(c.replace(/\+/g," "));};},"3.3.0");