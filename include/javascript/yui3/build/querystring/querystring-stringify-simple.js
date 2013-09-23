/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('querystring-stringify-simple',function(Y){var QueryString=Y.namespace("QueryString"),EUC=encodeURIComponent;QueryString.stringify=function(obj,c){var qs=[],s=c&&c.arrayKey?true:false,key,i,l;for(key in obj){if(obj.hasOwnProperty(key)){if(Y.Lang.isArray(obj[key])){for(i=0,l=obj[key].length;i<l;i++){qs.push(EUC(s?key+'[]':key)+'='+EUC(obj[key][i]));}}
else{qs.push(EUC(key)+'='+EUC(obj[key]));}}}
return qs.join('&');};},'3.3.0');