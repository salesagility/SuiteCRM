/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('autocomplete-plugin',function(Y){var Plugin=Y.Plugin;function ACListPlugin(config){config.inputNode=config.host;if(!config.render&&config.render!==false){config.render=true;}
ACListPlugin.superclass.constructor.apply(this,arguments);}
Y.extend(ACListPlugin,Y.AutoCompleteList,{},{NAME:'autocompleteListPlugin',NS:'ac',CSS_PREFIX:Y.ClassNameManager.getClassName('aclist')});Plugin.AutoComplete=ACListPlugin;Plugin.AutoCompleteList=ACListPlugin;},'3.3.0',{requires:['autocomplete-list','node-pluginhost']});