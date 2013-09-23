/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('widget-skin',function(Y){var BOUNDING_BOX="boundingBox",CONTENT_BOX="contentBox",SKIN="skin",_getClassName=Y.ClassNameManager.getClassName;Y.Widget.prototype.getSkinName=function(){var root=this.get(CONTENT_BOX)||this.get(BOUNDING_BOX),search=new RegExp('\\b'+_getClassName(SKIN)+'-(\\S+)'),match;if(root){root.ancestor(function(node){match=node.get('className').match(search);return match;});}
return(match)?match[1]:null;};},'3.3.0',{requires:['widget-base']});