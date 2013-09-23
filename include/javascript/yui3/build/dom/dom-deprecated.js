/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('dom-deprecated',function(Y){Y.mix(Y.DOM,{children:function(node,tag){var ret=[];if(node){tag=tag||'*';ret=Y.Selector.query('> '+tag,node);}
return ret;},firstByTag:function(tag,root){var ret;root=root||Y.config.doc;if(tag&&root.getElementsByTagName){ret=root.getElementsByTagName(tag)[0];}
return ret||null;},previous:function(element,fn,all){return Y.DOM.elementByAxis(element,'previousSibling',fn,all);},next:function(element,fn,all){return Y.DOM.elementByAxis(element,'nextSibling',fn,all);}});},'3.3.0',{requires:['dom-base']});