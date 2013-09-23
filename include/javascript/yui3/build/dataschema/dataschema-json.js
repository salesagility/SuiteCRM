/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('dataschema-json',function(Y){var LANG=Y.Lang,SchemaJSON={getPath:function(locator){var path=null,keys=[],i=0;if(locator){locator=locator.replace(/\[(['"])(.*?)\1\]/g,function(x,$1,$2){keys[i]=$2;return'.@'+(i++);}).replace(/\[(\d+)\]/g,function(x,$1){keys[i]=parseInt($1,10)|0;return'.@'+(i++);}).replace(/^\./,'');if(!/[^\w\.\$@]/.test(locator)){path=locator.split('.');for(i=path.length-1;i>=0;--i){if(path[i].charAt(0)==='@'){path[i]=keys[parseInt(path[i].substr(1),10)];}}}
else{}}
return path;},getLocationValue:function(path,data){var i=0,len=path.length;for(;i<len;i++){if(LANG.isObject(data)&&(path[i]in data)){data=data[path[i]];}
else{data=undefined;break;}}
return data;},apply:function(schema,data){var data_in=data,data_out={results:[],meta:{}};if(!LANG.isObject(data)){try{data_in=Y.JSON.parse(data);}
catch(e){data_out.error=e;return data_out;}}
if(LANG.isObject(data_in)&&schema){if(!LANG.isUndefined(schema.resultListLocator)){data_out=SchemaJSON._parseResults.call(this,schema,data_in,data_out);}
if(!LANG.isUndefined(schema.metaFields)){data_out=SchemaJSON._parseMeta(schema.metaFields,data_in,data_out);}}
else{data_out.error=new Error("JSON schema parse failure");}
return data_out;},_parseResults:function(schema,json_in,data_out){var results=[],path,error;if(schema.resultListLocator){path=SchemaJSON.getPath(schema.resultListLocator);if(path){results=SchemaJSON.getLocationValue(path,json_in);if(results===undefined){data_out.results=[];error=new Error("JSON results retrieval failure");}
else{if(LANG.isArray(results)){if(LANG.isArray(schema.resultFields)){data_out=SchemaJSON._getFieldValues.call(this,schema.resultFields,results,data_out);}
else{data_out.results=results;}}
else{data_out.results=[];error=new Error("JSON Schema fields retrieval failure");}}}
else{error=new Error("JSON Schema results locator failure");}
if(error){data_out.error=error;}}
return data_out;},_getFieldValues:function(fields,array_in,data_out){var results=[],len=fields.length,i,j,field,key,locator,path,parser,simplePaths=[],complexPaths=[],fieldParsers=[],result,record;for(i=0;i<len;i++){field=fields[i];key=field.key||field;locator=field.locator||key;path=SchemaJSON.getPath(locator);if(path){if(path.length===1){simplePaths[simplePaths.length]={key:key,path:path[0]};}else{complexPaths[complexPaths.length]={key:key,path:path};}}else{}
parser=(LANG.isFunction(field.parser))?field.parser:Y.Parsers[field.parser+''];if(parser){fieldParsers[fieldParsers.length]={key:key,parser:parser};}}
for(i=array_in.length-1;i>=0;--i){record={};result=array_in[i];if(result){for(j=simplePaths.length-1;j>=0;--j){record[simplePaths[j].key]=Y.DataSchema.Base.parse.call(this,(LANG.isUndefined(result[simplePaths[j].path])?result[j]:result[simplePaths[j].path]),simplePaths[j]);}
for(j=complexPaths.length-1;j>=0;--j){record[complexPaths[j].key]=Y.DataSchema.Base.parse.call(this,(SchemaJSON.getLocationValue(complexPaths[j].path,result)),complexPaths[j]);}
for(j=fieldParsers.length-1;j>=0;--j){key=fieldParsers[j].key;record[key]=fieldParsers[j].parser.call(this,record[key]);if(LANG.isUndefined(record[key])){record[key]=null;}}
results[i]=record;}}
data_out.results=results;return data_out;},_parseMeta:function(metaFields,json_in,data_out){if(LANG.isObject(metaFields)){var key,path;for(key in metaFields){if(metaFields.hasOwnProperty(key)){path=SchemaJSON.getPath(metaFields[key]);if(path&&json_in){data_out.meta[key]=SchemaJSON.getLocationValue(path,json_in);}}}}
else{data_out.error=new Error("JSON meta data retrieval failure");}
return data_out;}};Y.DataSchema.JSON=Y.mix(SchemaJSON,Y.DataSchema.Base);},'3.3.0',{requires:['dataschema-base','json']});