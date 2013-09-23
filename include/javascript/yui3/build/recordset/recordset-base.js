/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('recordset-base',function(Y){var Record=Y.Base.create('record',Y.Base,[],{_setId:function(){return Y.guid();},initializer:function(){},destructor:function(){},getValue:function(field){if(field===undefined){return this.get("data");}
else{return this.get("data")[field];}
return null;}},{ATTRS:{id:{valueFn:"_setId"},data:{value:null}}});Y.Record=Record;var ArrayList=Y.ArrayList,Lang=Y.Lang,Recordset=Y.Base.create('recordset',Y.Base,[],{initializer:function(){if(!this._items){this._items=[];}
this.publish('add',{defaultFn:this._defAddFn});this.publish('remove',{defaultFn:this._defRemoveFn});this.publish('empty',{defaultFn:this._defEmptyFn});this.publish('update',{defaultFn:this._defUpdateFn});this._recordsetChanged();this._syncHashTable();},destructor:function(){},_defAddFn:function(e){var len=this._items.length,recs=e.added,index=e.index,i=0;for(;i<recs.length;i++){if(index===len){this._items.push(recs[i]);}
else{this._items.splice(index,0,recs[i]);index++;}}},_defRemoveFn:function(e){if(e.index===0){this._items.shift();}
else if(e.index===this._items.length-1){this._items.pop();}
else{this._items.splice(e.index,e.range);}},_defEmptyFn:function(e){this._items=[];},_defUpdateFn:function(e){for(var i=0;i<e.updated.length;i++){this._items[e.index+i]=this._changeToRecord(e.updated[i]);}},_defAddHash:function(e){var obj=this.get('table'),key=this.get('key'),i=0;for(;i<e.added.length;i++){obj[e.added[i].get(key)]=e.added[i];}
this.set('table',obj);},_defRemoveHash:function(e){var obj=this.get('table'),key=this.get('key'),i=0;for(;i<e.removed.length;i++){delete obj[e.removed[i].get(key)];}
this.set('table',obj);},_defUpdateHash:function(e){var obj=this.get('table'),key=this.get('key'),i=0;for(;i<e.updated.length;i++){if(e.overwritten[i]){delete obj[e.overwritten[i].get(key)];}
obj[e.updated[i].get(key)]=e.updated[i];}
this.set('table',obj);},_defEmptyHash:function(){this.set('table',{});},_setHashTable:function(){var obj={},key=this.get('key'),i=0;if(this._items&&this._items.length>0){var len=this._items.length;for(;i<len;i++){obj[this._items[i].get(key)]=this._items[i];}}
return obj;},_changeToRecord:function(obj){var oRec;if(obj instanceof Y.Record){oRec=obj;}
else{oRec=new Y.Record({data:obj});}
return oRec;},_recordsetChanged:function(){this.on(['update','add','remove','empty'],function(){this.fire('change',{});});},_syncHashTable:function(){this.after('add',function(e){this._defAddHash(e);});this.after('remove',function(e){this._defRemoveHash(e);});this.after('update',function(e){this._defUpdateHash(e);});this.after('update',function(e){this._defEmptyHash();});},getRecord:function(i){if(Lang.isString(i)){return this.get('table')[i];}
else if(Lang.isNumber(i)){return this._items[i];}
return null;},getRecordByIndex:function(i){return this._items[i];},getRecordsByIndex:function(index,range){var i=0,returnedRecords=[];range=(Lang.isNumber(range)&&(range>0))?range:1;for(;i<range;i++){returnedRecords.push(this._items[index+i]);}
return returnedRecords;},getLength:function(){return this.size();},getValuesByKey:function(key){var i=0,len=this._items.length,retVals=[];for(;i<len;i++){retVals.push(this._items[i].getValue(key));}
return retVals;},add:function(oData,index){var newRecords=[],idx,i=0;idx=(Lang.isNumber(index)&&(index>-1))?index:this._items.length;if(Lang.isArray(oData)){for(;i<oData.length;i++){newRecords[i]=this._changeToRecord(oData[i]);}}
else if(Lang.isObject(oData)){newRecords[0]=this._changeToRecord(oData);}
this.fire('add',{added:newRecords,index:idx});return this;},remove:function(index,range){var remRecords=[];index=(index>-1)?index:(this._items.length-1);range=(range>0)?range:1;remRecords=this._items.slice(index,(index+range));this.fire('remove',{removed:remRecords,range:range,index:index});return this;},empty:function(){this.fire('empty',{});return this;},update:function(data,index){var rec,arr,i=0;arr=(!(Lang.isArray(data)))?[data]:data;rec=this._items.slice(index,index+arr.length);for(;i<arr.length;i++){arr[i]=this._changeToRecord(arr[i]);}
this.fire('update',{updated:arr,overwritten:rec,index:index});return this;}},{ATTRS:{records:{validator:Lang.isArray,getter:function(){return new Y.Array(this._items);},setter:function(allData){var records=[];function initRecord(oneData){var o;if(oneData instanceof Y.Record){records.push(oneData);}
else{o=new Y.Record({data:oneData});records.push(o);}}
if(allData){Y.Array.each(allData,initRecord);this._items=Y.Array(records);}},lazyAdd:false},table:{valueFn:'_setHashTable'},key:{value:'id',readOnly:true}}});Y.augment(Recordset,ArrayList);Y.Recordset=Recordset;},'3.3.0',{requires:['base','arraylist']});