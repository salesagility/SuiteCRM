/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('datasource-xmlschema',function(Y){var DataSourceXMLSchema=function(){DataSourceXMLSchema.superclass.constructor.apply(this,arguments);};Y.mix(DataSourceXMLSchema,{NS:"schema",NAME:"dataSourceXMLSchema",ATTRS:{schema:{}}});Y.extend(DataSourceXMLSchema,Y.Plugin.Base,{initializer:function(config){this.doBefore("_defDataFn",this._beforeDefDataFn);},_beforeDefDataFn:function(e){var data=(Y.DataSource.IO&&(this.get("host")instanceof Y.DataSource.IO)&&e.data.responseXML&&(e.data.responseXML.nodeType===9))?e.data.responseXML:e.data,response=Y.DataSchema.XML.apply.call(this,this.get("schema"),data);if(!response){response={meta:{},results:data};}
this.get("host").fire("response",Y.mix({response:response},e));return new Y.Do.Halt("DataSourceXMLSchema plugin halted _defDataFn");}});Y.namespace('Plugin').DataSourceXMLSchema=DataSourceXMLSchema;},'3.3.0',{requires:['datasource-local','plugin','dataschema-xml']});