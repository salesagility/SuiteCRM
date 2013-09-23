/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('oop',function(Y){var L=Y.Lang,A=Y.Array,OP=Object.prototype,CLONE_MARKER='_~yuim~_',EACH='each',SOME='some',dispatch=function(o,f,c,proto,action){if(o&&o[action]&&o!==Y){return o[action].call(o,f,c);}else{switch(A.test(o)){case 1:return A[action](o,f,c);case 2:return A[action](Y.Array(o,0,true),f,c);default:return Y.Object[action](o,f,c,proto);}}};Y.augment=function(r,s,ov,wl,args){var sProto=s.prototype,newProto=null,construct=s,a=(args)?Y.Array(args):[],rProto=r.prototype,target=rProto||r,applyConstructor=false,sequestered,replacements;if(rProto&&construct){sequestered={};replacements={};newProto={};Y.Object.each(sProto,function(v,k){replacements[k]=function(){for(var i in sequestered){if(sequestered.hasOwnProperty(i)&&(this[i]===replacements[i])){this[i]=sequestered[i];}}
construct.apply(this,a);return sequestered[k].apply(this,arguments);};if((!wl||(k in wl))&&(ov||!(k in this))){if(L.isFunction(v)){sequestered[k]=v;this[k]=replacements[k];}else{this[k]=v;}}},newProto,true);}else{applyConstructor=true;}
Y.mix(target,newProto||sProto,ov,wl);if(applyConstructor){s.apply(target,a);}
return r;};Y.aggregate=function(r,s,ov,wl){return Y.mix(r,s,ov,wl,0,true);};Y.extend=function(r,s,px,sx){if(!s||!r){Y.error('extend failed, verify dependencies');}
var sp=s.prototype,rp=Y.Object(sp);r.prototype=rp;rp.constructor=r;r.superclass=sp;if(s!=Object&&sp.constructor==OP.constructor){sp.constructor=s;}
if(px){Y.mix(rp,px,true);}
if(sx){Y.mix(r,sx,true);}
return r;};Y.each=function(o,f,c,proto){return dispatch(o,f,c,proto,EACH);};Y.some=function(o,f,c,proto){return dispatch(o,f,c,proto,SOME);};Y.clone=function(o,safe,f,c,owner,cloned){if(!L.isObject(o)){return o;}
if(Y.instanceOf(o,YUI)){return o;}
var o2,marked=cloned||{},stamp,yeach=Y.each;switch(L.type(o)){case'date':return new Date(o);case'regexp':return o;case'function':return o;case'array':o2=[];break;default:if(o[CLONE_MARKER]){return marked[o[CLONE_MARKER]];}
stamp=Y.guid();o2=(safe)?{}:Y.Object(o);o[CLONE_MARKER]=stamp;marked[stamp]=o;}
if(!o.addEventListener&&!o.attachEvent){yeach(o,function(v,k){if((k||k===0)&&(!f||(f.call(c||this,v,k,this,o)!==false))){if(k!==CLONE_MARKER){if(k=='prototype'){}else{this[k]=Y.clone(v,safe,f,c,owner||o,marked);}}}},o2);}
if(!cloned){Y.Object.each(marked,function(v,k){if(v[CLONE_MARKER]){try{delete v[CLONE_MARKER];}catch(e){v[CLONE_MARKER]=null;}}},this);marked=null;}
return o2;};Y.bind=function(f,c){var xargs=arguments.length>2?Y.Array(arguments,2,true):null;return function(){var fn=L.isString(f)?c[f]:f,args=(xargs)?xargs.concat(Y.Array(arguments,0,true)):arguments;return fn.apply(c||fn,args);};};Y.rbind=function(f,c){var xargs=arguments.length>2?Y.Array(arguments,2,true):null;return function(){var fn=L.isString(f)?c[f]:f,args=(xargs)?Y.Array(arguments,0,true).concat(xargs):arguments;return fn.apply(c||fn,args);};};},'3.3.0');