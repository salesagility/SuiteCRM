/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('datatype-number-parse',function(Y){var LANG=Y.Lang;Y.mix(Y.namespace("DataType.Number"),{parse:function(data){var number=(data===null)?data:+data;if(LANG.isNumber(number)){return number;}
else{return null;}}});Y.namespace("Parsers").number=Y.DataType.Number.parse;},'3.3.0',{requires:['yui-base']});