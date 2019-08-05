/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("querystring-stringify-simple",function(c){var b=c.namespace("QueryString"),a=encodeURIComponent;b.stringify=function(j,k){var d=[],h=k&&k.arrayKey?true:false,g,f,e;for(g in j){if(j.hasOwnProperty(g)){if(c.Lang.isArray(j[g])){for(f=0,e=j[g].length;f<e;f++){d.push(a(h?g+"[]":g)+"="+a(j[g][f]));}}else{d.push(a(g)+"="+a(j[g]));}}}return d.join("&");};},"3.3.0");