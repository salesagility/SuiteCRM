/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('array-extras',function(Y){var L=Y.Lang,Native=Array.prototype,A=Y.Array;A.lastIndexOf=Native.lastIndexOf?function(a,val,fromIndex){return fromIndex||fromIndex===0?a.lastIndexOf(val,fromIndex):a.lastIndexOf(val);}:function(a,val,fromIndex){var len=a.length,i=len-1;if(fromIndex||fromIndex===0){i=Math.min(fromIndex<0?len+fromIndex:fromIndex,len);}
if(i>-1&&len>0){for(;i>-1;--i){if(a[i]===val){return i;}}}
return-1;};A.unique=function(a,sort){var i=0,len=a.length,results=[],item,j;for(;i<len;++i){item=a[i];for(j=results.length;j>-1;--j){if(item===results[j]){break;}}
if(j===-1){results.push(item);}}
if(sort){if(L.isNumber(results[0])){results.sort(A.numericSort);}else{results.sort();}}
return results;};A.filter=Native.filter?function(a,f,o){return a.filter(f,o);}:function(a,f,o){var i=0,len=a.length,results=[],item;for(;i<len;++i){item=a[i];if(f.call(o,item,i,a)){results.push(item);}}
return results;};A.reject=function(a,f,o){return A.filter(a,function(item,i,a){return!f.call(o,item,i,a);});};A.every=Native.every?function(a,f,o){return a.every(f,o);}:function(a,f,o){for(var i=0,l=a.length;i<l;++i){if(!f.call(o,a[i],i,a)){return false;}}
return true;};A.map=Native.map?function(a,f,o){return a.map(f,o);}:function(a,f,o){var i=0,len=a.length,results=a.concat();for(;i<len;++i){results[i]=f.call(o,a[i],i,a);}
return results;};A.reduce=Native.reduce?function(a,init,f,o){return a.reduce(function(init,item,i,a){return f.call(o,init,item,i,a);},init);}:function(a,init,f,o){var i=0,len=a.length,result=init;for(;i<len;++i){result=f.call(o,result,a[i],i,a);}
return result;};A.find=function(a,f,o){for(var i=0,l=a.length;i<l;i++){if(f.call(o,a[i],i,a)){return a[i];}}
return null;};A.grep=function(a,pattern){return A.filter(a,function(item,index){return pattern.test(item);});};A.partition=function(a,f,o){var results={matches:[],rejects:[]};A.each(a,function(item,index){var set=f.call(o,item,index,a)?results.matches:results.rejects;set.push(item);});return results;};A.zip=function(a,a2){var results=[];A.each(a,function(item,index){results.push([item,a2[index]]);});return results;};A.forEach=A.each;},'3.3.0');