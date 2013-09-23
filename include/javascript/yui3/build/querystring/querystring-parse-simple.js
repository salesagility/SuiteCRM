/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('querystring-parse-simple',function(Y){var QueryString=Y.namespace("QueryString");QueryString.parse=function(qs,sep,eq){sep=sep||"&";eq=eq||"=";for(var obj={},i=0,pieces=qs.split(sep),l=pieces.length,tuple;i<l;i++){tuple=pieces[i].split(eq);if(tuple.length>0){obj[QueryString.unescape(tuple.shift())]=QueryString.unescape(tuple.join(eq));}}
return obj;};QueryString.unescape=function(s){return decodeURIComponent(s.replace(/\+/g,' '));};},'3.3.0');