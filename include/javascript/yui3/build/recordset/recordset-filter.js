/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('recordset-filter',function(Y){var YArray=Y.Array,Lang=Y.Lang;function RecordsetFilter(config){RecordsetFilter.superclass.constructor.apply(this,arguments);}
Y.mix(RecordsetFilter,{NS:"filter",NAME:"recordsetFilter",ATTRS:{}});Y.extend(RecordsetFilter,Y.Plugin.Base,{initializer:function(config){},destructor:function(config){},filter:function(f,v){var recs=this.get('host').get('records'),oRecs=[],func=f;if(Lang.isString(f)&&Lang.isValue(v)){func=function(item){if(item.getValue(f)===v){return true;}
else{return false;}};}
oRecs=YArray.filter(recs,func);return new Y.Recordset({records:oRecs});},reject:function(f){return new Y.Recordset({records:YArray.reject(this.get('host').get('records'),f)});},grep:function(pattern){return new Y.Recordset({records:YArray.grep(this.get('host').get('records'),pattern)});}});Y.namespace("Plugin").RecordsetFilter=RecordsetFilter;},'3.3.0',{requires:['recordset-base','array-extras','plugin']});