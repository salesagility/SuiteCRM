/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("recordset-filter",function(D){var C=D.Array,B=D.Lang;function A(E){A.superclass.constructor.apply(this,arguments);}D.mix(A,{NS:"filter",NAME:"recordsetFilter",ATTRS:{}});D.extend(A,D.Plugin.Base,{initializer:function(E){},destructor:function(E){},filter:function(H,E){var G=this.get("host").get("records"),I=[],F=H;if(B.isString(H)&&B.isValue(E)){F=function(J){if(J.getValue(H)===E){return true;}else{return false;}};}I=C.filter(G,F);return new D.Recordset({records:I});},reject:function(E){return new D.Recordset({records:C.reject(this.get("host").get("records"),E)});},grep:function(E){return new D.Recordset({records:C.grep(this.get("host").get("records"),E)});}});D.namespace("Plugin").RecordsetFilter=A;},"3.3.0",{requires:["recordset-base","array-extras","plugin"]});