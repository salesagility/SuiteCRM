/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("autocomplete-plugin",function(b){var a=b.Plugin;function c(d){d.inputNode=d.host;if(!d.render&&d.render!==false){d.render=true;}c.superclass.constructor.apply(this,arguments);}b.extend(c,b.AutoCompleteList,{},{NAME:"autocompleteListPlugin",NS:"ac",CSS_PREFIX:b.ClassNameManager.getClassName("aclist")});a.AutoComplete=c;a.AutoCompleteList=c;},"3.3.0",{requires:["autocomplete-list","node-pluginhost"]});