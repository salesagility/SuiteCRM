/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('attribute-complex',function(Y){var O=Y.Object,DOT=".";Y.Attribute.Complex=function(){};Y.Attribute.Complex.prototype={_normAttrVals:function(valueHash){var vals={},subvals={},path,attr,v,k;if(valueHash){for(k in valueHash){if(valueHash.hasOwnProperty(k)){if(k.indexOf(DOT)!==-1){path=k.split(DOT);attr=path.shift();v=subvals[attr]=subvals[attr]||[];v[v.length]={path:path,value:valueHash[k]};}else{vals[k]=valueHash[k];}}}
return{simple:vals,complex:subvals};}else{return null;}},_getAttrInitVal:function(attr,cfg,initValues){var val=cfg.value,valFn=cfg.valueFn,simple,complex,i,l,path,subval,subvals;if(valFn){if(!valFn.call){valFn=this[valFn];}
if(valFn){val=valFn.call(this);}}
if(!cfg.readOnly&&initValues){simple=initValues.simple;if(simple&&simple.hasOwnProperty(attr)){val=simple[attr];}
complex=initValues.complex;if(complex&&complex.hasOwnProperty(attr)){subvals=complex[attr];for(i=0,l=subvals.length;i<l;++i){path=subvals[i].path;subval=subvals[i].value;O.setValue(val,path,subval);}}}
return val;}};Y.mix(Y.Attribute,Y.Attribute.Complex,true,null,1);},'3.3.0',{requires:['attribute-base']});