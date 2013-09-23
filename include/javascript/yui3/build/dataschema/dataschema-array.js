/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('dataschema-array',function(Y){var LANG=Y.Lang,SchemaArray={apply:function(schema,data){var data_in=data,data_out={results:[],meta:{}};if(LANG.isArray(data_in)){if(LANG.isArray(schema.resultFields)){data_out=SchemaArray._parseResults.call(this,schema.resultFields,data_in,data_out);}
else{data_out.results=data_in;}}
else{data_out.error=new Error("Array schema parse failure");}
return data_out;},_parseResults:function(fields,array_in,data_out){var results=[],result,item,type,field,key,value,i,j;for(i=array_in.length-1;i>-1;i--){result={};item=array_in[i];type=(LANG.isObject(item)&&!LANG.isFunction(item))?2:(LANG.isArray(item))?1:(LANG.isString(item))?0:-1;if(type>0){for(j=fields.length-1;j>-1;j--){field=fields[j];key=(!LANG.isUndefined(field.key))?field.key:field;value=(!LANG.isUndefined(item[key]))?item[key]:item[j];result[key]=Y.DataSchema.Base.parse.call(this,value,field);}}
else if(type===0){result=item;}
else{result=null;}
results[i]=result;}
data_out.results=results;return data_out;}};Y.DataSchema.Array=Y.mix(SchemaArray,Y.DataSchema.Base);},'3.3.0',{requires:['dataschema-base']});