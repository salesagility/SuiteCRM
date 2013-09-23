/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('recordset-sort',function(Y){var Compare=Y.ArraySort.compare,isValue=Y.Lang.isValue;function RecordsetSort(field,desc,sorter){RecordsetSort.superclass.constructor.apply(this,arguments);}
Y.mix(RecordsetSort,{NS:"sort",NAME:"recordsetSort",ATTRS:{lastSortProperties:{value:{field:undefined,desc:true,sorter:undefined},validator:function(v){return(isValue(v.field)&&isValue(v.desc)&&isValue(v.sorter));}},defaultSorter:{value:function(recA,recB,field,desc){var sorted=Compare(recA.getValue(field),recB.getValue(field),desc);if(sorted===0){return Compare(recA.get("id"),recB.get("id"),desc);}
else{return sorted;}}},isSorted:{value:false}}});Y.extend(RecordsetSort,Y.Plugin.Base,{initializer:function(config){var self=this,host=this.get('host');this.publish("sort",{defaultFn:Y.bind("_defSortFn",this)});this.on("sort",function(){self.set('isSorted',true);});this.onHostEvent('add',function(){self.set('isSorted',false);},host);this.onHostEvent('update',function(){self.set('isSorted',false);},host);},destructor:function(config){},_defSortFn:function(e){this.get("host")._items.sort(function(a,b){return(e.sorter)(a,b,e.field,e.desc);});this.set('lastSortProperties',e);},sort:function(field,desc,sorter){this.fire("sort",{field:field,desc:desc,sorter:sorter||this.get("defaultSorter")});},resort:function(){var p=this.get('lastSortProperties');this.fire("sort",{field:p.field,desc:p.desc,sorter:p.sorter||this.get("defaultSorter")});},reverse:function(){this.get('host')._items.reverse();},flip:function(){var p=this.get('lastSortProperties');if(isValue(p.field)){this.fire("sort",{field:p.field,desc:!p.desc,sorter:p.sorter||this.get("defaultSorter")});}
else{}}});Y.namespace("Plugin").RecordsetSort=RecordsetSort;},'3.3.0',{requires:['arraysort','recordset-base','plugin']});