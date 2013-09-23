/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('dump',function(Y){var L=Y.Lang,OBJ='{...}',FUN='f(){...}',COMMA=', ',ARROW=' => ',dump=function(o,d){var i,len,s=[],type=L.type(o);if(!L.isObject(o)){return o+'';}else if(type=='date'){return o;}else if(o.nodeType&&o.tagName){return o.tagName+'#'+o.id;}else if(o.document&&o.navigator){return'window';}else if(o.location&&o.body){return'document';}else if(type=='function'){return FUN;}
d=(L.isNumber(d))?d:3;if(type=='array'){s.push('[');for(i=0,len=o.length;i<len;i=i+1){if(L.isObject(o[i])){s.push((d>0)?L.dump(o[i],d-1):OBJ);}else{s.push(o[i]);}
s.push(COMMA);}
if(s.length>1){s.pop();}
s.push(']');}else if(type=='regexp'){s.push(o.toString());}else{s.push('{');for(i in o){if(o.hasOwnProperty(i)){try{s.push(i+ARROW);if(L.isObject(o[i])){s.push((d>0)?L.dump(o[i],d-1):OBJ);}else{s.push(o[i]);}
s.push(COMMA);}catch(e){s.push('Error: '+e.message);}}}
if(s.length>1){s.pop();}
s.push('}');}
return s.join('');};Y.dump=dump;L.dump=dump;},'3.3.0');