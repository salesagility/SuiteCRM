/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('dd-drop-plugin',function(Y){var Drop=function(config){config.node=config.host;Drop.superclass.constructor.apply(this,arguments);};Drop.NAME="dd-drop-plugin";Drop.NS="drop";Y.extend(Drop,Y.DD.Drop);Y.namespace('Plugin');Y.Plugin.Drop=Drop;},'3.3.0',{skinnable:false,requires:['dd-drop']});