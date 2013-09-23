/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('dd-gestures',function(Y){Y.DD.Drag.START_EVENT='gesturemovestart';Y.DD.Drag.prototype._prep=function(){this._dragThreshMet=false;var node=this.get('node'),DDM=Y.DD.DDM;node.addClass(DDM.CSS_PREFIX+'-draggable');node.on(Y.DD.Drag.START_EVENT,Y.bind(this._handleMouseDownEvent,this),{minDistance:0,minTime:0});node.on('gesturemoveend',Y.bind(this._handleMouseUp,this),{standAlone:true});node.on('dragstart',Y.bind(this._fixDragStart,this));};Y.DD.DDM._setupListeners=function(){var DDM=Y.DD.DDM;this._createPG();this._active=true;Y.one(Y.config.doc).on('gesturemove',Y.throttle(Y.bind(DDM._move,DDM),DDM.get('throttleTime')),{standAlone:true});};},'3.3.0',{skinnable:false,requires:['dd-drag','event-synthetic','event-gestures']});