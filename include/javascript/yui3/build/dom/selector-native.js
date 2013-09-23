/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('selector-native',function(Y){(function(Y){Y.namespace('Selector');var COMPARE_DOCUMENT_POSITION='compareDocumentPosition',OWNER_DOCUMENT='ownerDocument';var Selector={_foundCache:[],useNative:true,_compare:('sourceIndex'in Y.config.doc.documentElement)?function(nodeA,nodeB){var a=nodeA.sourceIndex,b=nodeB.sourceIndex;if(a===b){return 0;}else if(a>b){return 1;}
return-1;}:(Y.config.doc.documentElement[COMPARE_DOCUMENT_POSITION]?function(nodeA,nodeB){if(nodeA[COMPARE_DOCUMENT_POSITION](nodeB)&4){return-1;}else{return 1;}}:function(nodeA,nodeB){var rangeA,rangeB,compare;if(nodeA&&nodeB){rangeA=nodeA[OWNER_DOCUMENT].createRange();rangeA.setStart(nodeA,0);rangeB=nodeB[OWNER_DOCUMENT].createRange();rangeB.setStart(nodeB,0);compare=rangeA.compareBoundaryPoints(1,rangeB);}
return compare;}),_sort:function(nodes){if(nodes){nodes=Y.Array(nodes,0,true);if(nodes.sort){nodes.sort(Selector._compare);}}
return nodes;},_deDupe:function(nodes){var ret=[],i,node;for(i=0;(node=nodes[i++]);){if(!node._found){ret[ret.length]=node;node._found=true;}}
for(i=0;(node=ret[i++]);){node._found=null;node.removeAttribute('_found');}
return ret;},query:function(selector,root,firstOnly,skipNative){root=root||Y.config.doc;var ret=[],useNative=(Y.Selector.useNative&&Y.config.doc.querySelector&&!skipNative),queries=[[selector,root]],query,result,i,fn=(useNative)?Y.Selector._nativeQuery:Y.Selector._bruteQuery;if(selector&&fn){if(!skipNative&&(!useNative||root.tagName)){queries=Selector._splitQueries(selector,root);}
for(i=0;(query=queries[i++]);){result=fn(query[0],query[1],firstOnly);if(!firstOnly){result=Y.Array(result,0,true);}
if(result){ret=ret.concat(result);}}
if(queries.length>1){ret=Selector._sort(Selector._deDupe(ret));}}
return(firstOnly)?(ret[0]||null):ret;},_splitQueries:function(selector,node){var groups=selector.split(','),queries=[],prefix='',i,len;if(node){if(node.tagName){node.id=node.id||Y.guid();prefix='[id="'+node.id+'"] ';}
for(i=0,len=groups.length;i<len;++i){selector=prefix+groups[i];queries.push([selector,node]);}}
return queries;},_nativeQuery:function(selector,root,one){if(Y.UA.webkit&&selector.indexOf(':checked')>-1&&(Y.Selector.pseudos&&Y.Selector.pseudos.checked)){return Y.Selector.query(selector,root,one,true);}
try{return root['querySelector'+(one?'':'All')](selector);}catch(e){return Y.Selector.query(selector,root,one,true);}},filter:function(nodes,selector){var ret=[],i,node;if(nodes&&selector){for(i=0;(node=nodes[i++]);){if(Y.Selector.test(node,selector)){ret[ret.length]=node;}}}else{}
return ret;},test:function(node,selector,root){var ret=false,groups=selector.split(','),useFrag=false,parent,item,items,frag,i,j,group;if(node&&node.tagName){if(!root&&!Y.DOM.inDoc(node)){parent=node.parentNode;if(parent){root=parent;}else{frag=node[OWNER_DOCUMENT].createDocumentFragment();frag.appendChild(node);root=frag;useFrag=true;}}
root=root||node[OWNER_DOCUMENT];if(!node.id){node.id=Y.guid();}
for(i=0;(group=groups[i++]);){group+='[id="'+node.id+'"]';items=Y.Selector.query(group,root);for(j=0;item=items[j++];){if(item===node){ret=true;break;}}
if(ret){break;}}
if(useFrag){frag.removeChild(node);}}
return ret;},ancestor:function(element,selector,testSelf){return Y.DOM.ancestor(element,function(n){return Y.Selector.test(n,selector);},testSelf);}};Y.mix(Y.Selector,Selector,true);})(Y);},'3.3.0',{requires:['dom-base']});