/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('editor-tab',function(Y){var EditorTab=function(){EditorTab.superclass.constructor.apply(this,arguments);},HOST='host';Y.extend(EditorTab,Y.Base,{_onNodeChange:function(e){var action='indent';if(e.changedType==='tab'){if(!e.changedNode.test('li, li *')){e.changedEvent.halt();e.preventDefault();if(e.changedEvent.shiftKey){action='outdent';}
this.get(HOST).execCommand(action,'');}}},initializer:function(){this.get(HOST).on('nodeChange',Y.bind(this._onNodeChange,this));}},{NAME:'editorTab',NS:'tab',ATTRS:{host:{value:false}}});Y.namespace('Plugin');Y.Plugin.EditorTab=EditorTab;},'3.3.0',{requires:['editor-base'],skinnable:false});