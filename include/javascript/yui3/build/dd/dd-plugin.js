/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('dd-plugin',function(Y){var Drag=function(config){config.node=((Y.Widget&&config.host instanceof Y.Widget)?config.host.get('boundingBox'):config.host);Drag.superclass.constructor.call(this,config);};Drag.NAME="dd-plugin";Drag.NS="dd";Y.extend(Drag,Y.DD.Drag);Y.namespace('Plugin');Y.Plugin.Drag=Drag;},'3.3.0',{requires:['dd-drag'],skinnable:false,optional:['dd-constrain','dd-proxy']});