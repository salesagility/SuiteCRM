/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('datatype-date-parse',function(Y){var LANG=Y.Lang;Y.mix(Y.namespace("DataType.Date"),{parse:function(data){var date=null;if(!(LANG.isDate(data))){date=new Date(data);}
else{return date;}
if(LANG.isDate(date)&&(date!="Invalid Date")&&!isNaN(date)){return date;}
else{return null;}}});Y.namespace("Parsers").date=Y.DataType.Date.parse;},'3.3.0',{requires:['yui-base']});