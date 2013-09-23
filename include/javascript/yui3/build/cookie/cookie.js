/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('cookie',function(Y){var L=Y.Lang,O=Y.Object,NULL=null,isString=L.isString,isObject=L.isObject,isUndefined=L.isUndefined,isFunction=L.isFunction,encode=encodeURIComponent,decode=decodeURIComponent,doc=Y.config.doc;function error(message){throw new TypeError(message);}
function validateCookieName(name){if(!isString(name)||name===""){error("Cookie name must be a non-empty string.");}}
function validateSubcookieName(subName){if(!isString(subName)||subName===""){error("Subcookie name must be a non-empty string.");}}
Y.Cookie={_createCookieString:function(name,value,encodeValue,options){options=options||{};var text=encode(name)+"="+(encodeValue?encode(value):value),expires=options.expires,path=options.path,domain=options.domain;if(isObject(options)){if(expires instanceof Date){text+="; expires="+expires.toUTCString();}
if(isString(path)&&path!==""){text+="; path="+path;}
if(isString(domain)&&domain!==""){text+="; domain="+domain;}
if(options.secure===true){text+="; secure";}}
return text;},_createCookieHashString:function(hash){if(!isObject(hash)){error("Cookie._createCookieHashString(): Argument must be an object.");}
var text=[];O.each(hash,function(value,key){if(!isFunction(value)&&!isUndefined(value)){text.push(encode(key)+"="+encode(String(value)));}});return text.join("&");},_parseCookieHash:function(text){var hashParts=text.split("&"),hashPart=NULL,hash={};if(text.length){for(var i=0,len=hashParts.length;i<len;i++){hashPart=hashParts[i].split("=");hash[decode(hashPart[0])]=decode(hashPart[1]);}}
return hash;},_parseCookieString:function(text,shouldDecode){var cookies={};if(isString(text)&&text.length>0){var decodeValue=(shouldDecode===false?function(s){return s;}:decode),cookieParts=text.split(/;\s/g),cookieName=NULL,cookieValue=NULL,cookieNameValue=NULL;for(var i=0,len=cookieParts.length;i<len;i++){cookieNameValue=cookieParts[i].match(/([^=]+)=/i);if(cookieNameValue instanceof Array){try{cookieName=decode(cookieNameValue[1]);cookieValue=decodeValue(cookieParts[i].substring(cookieNameValue[1].length+1));}catch(ex){}}else{cookieName=decode(cookieParts[i]);cookieValue="";}
cookies[cookieName]=cookieValue;}}
return cookies;},_setDoc:function(newDoc){doc=newDoc;},exists:function(name){validateCookieName(name);var cookies=this._parseCookieString(doc.cookie,true);return cookies.hasOwnProperty(name);},get:function(name,options){validateCookieName(name);var cookies,cookie,converter;if(isFunction(options)){converter=options;options={};}else if(isObject(options)){converter=options.converter;}else{options={};}
cookies=this._parseCookieString(doc.cookie,!options.raw);cookie=cookies[name];if(isUndefined(cookie)){return NULL;}
if(!isFunction(converter)){return cookie;}else{return converter(cookie);}},getSub:function(name,subName,converter){var hash=this.getSubs(name);if(hash!==NULL){validateSubcookieName(subName);if(isUndefined(hash[subName])){return NULL;}
if(!isFunction(converter)){return hash[subName];}else{return converter(hash[subName]);}}else{return NULL;}},getSubs:function(name){validateCookieName(name);var cookies=this._parseCookieString(doc.cookie,false);if(isString(cookies[name])){return this._parseCookieHash(cookies[name]);}
return NULL;},remove:function(name,options){validateCookieName(name);options=Y.merge(options||{},{expires:new Date(0)});return this.set(name,"",options);},removeSub:function(name,subName,options){validateCookieName(name);validateSubcookieName(subName);options=options||{};var subs=this.getSubs(name);if(isObject(subs)&&subs.hasOwnProperty(subName)){delete subs[subName];if(!options.removeIfEmpty){return this.setSubs(name,subs,options);}else{for(var key in subs){if(subs.hasOwnProperty(key)&&!isFunction(subs[key])&&!isUndefined(subs[key])){return this.setSubs(name,subs,options);}}
return this.remove(name,options);}}else{return"";}},set:function(name,value,options){validateCookieName(name);if(isUndefined(value)){error("Cookie.set(): Value cannot be undefined.");}
options=options||{};var text=this._createCookieString(name,value,!options.raw,options);doc.cookie=text;return text;},setSub:function(name,subName,value,options){validateCookieName(name);validateSubcookieName(subName);if(isUndefined(value)){error("Cookie.setSub(): Subcookie value cannot be undefined.");}
var hash=this.getSubs(name);if(!isObject(hash)){hash={};}
hash[subName]=value;return this.setSubs(name,hash,options);},setSubs:function(name,value,options){validateCookieName(name);if(!isObject(value)){error("Cookie.setSubs(): Cookie value must be an object.");}
var text=this._createCookieString(name,this._createCookieHashString(value),false,options);doc.cookie=text;return text;}};},'3.3.0',{requires:['yui-base']});