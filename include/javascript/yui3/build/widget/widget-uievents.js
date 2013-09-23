/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('widget-uievents',function(Y){var BOUNDING_BOX="boundingBox",Widget=Y.Widget,RENDER="render",L=Y.Lang,EVENT_PREFIX_DELIMITER=":",_uievts=Y.Widget._uievts=Y.Widget._uievts||{};Y.mix(Widget.prototype,{_destroyUIEvents:function(){var widgetGuid=Y.stamp(this,true);Y.each(_uievts,function(info,key){if(info.instances[widgetGuid]){delete info.instances[widgetGuid];if(Y.Object.isEmpty(info.instances)){info.handle.detach();if(_uievts[key]){delete _uievts[key];}}}});},UI_EVENTS:Y.Node.DOM_EVENTS,_getUIEventNode:function(){return this.get(BOUNDING_BOX);},_createUIEvent:function(type){var uiEvtNode=this._getUIEventNode(),key=(Y.stamp(uiEvtNode)+type),info=_uievts[key],handle;if(!info){handle=uiEvtNode.delegate(type,function(evt){var widget=Widget.getByNode(this);widget.fire(evt.type,{domEvent:evt});},"."+Y.Widget.getClassName());_uievts[key]=info={instances:{},handle:handle};}
info.instances[Y.stamp(this)]=1;},_getUIEvent:function(type){if(L.isString(type)){var sType=this.parseType(type)[1],iDelim,returnVal;if(sType){iDelim=sType.indexOf(EVENT_PREFIX_DELIMITER);if(iDelim>-1){sType=sType.substring(iDelim+EVENT_PREFIX_DELIMITER.length);}
if(this.UI_EVENTS[sType]){returnVal=sType;}}
return returnVal;}},_initUIEvent:function(type){var sType=this._getUIEvent(type),queue=this._uiEvtsInitQueue||{};if(sType&&!queue[sType]){this._uiEvtsInitQueue=queue[sType]=1;this.after(RENDER,function(){this._createUIEvent(sType);delete this._uiEvtsInitQueue[sType];});}},on:function(type){this._initUIEvent(type);return Widget.superclass.on.apply(this,arguments);},publish:function(type,config){var sType=this._getUIEvent(type);if(sType&&config&&config.defaultFn){this._initUIEvent(sType);}
return Widget.superclass.publish.apply(this,arguments);}},true);},'3.3.0',{requires:['widget-base','node-event-delegate']});