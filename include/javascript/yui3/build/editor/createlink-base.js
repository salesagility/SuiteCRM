/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("createlink-base",function(B){var A={};A.STRINGS={PROMPT:"Please enter the URL for the link to point to:",DEFAULT:"http://"};B.namespace("Plugin");B.Plugin.CreateLinkBase=A;B.mix(B.Plugin.ExecCommand.COMMANDS,{createlink:function(I){var H=this.get("host").getInstance(),E,C,G,F,D=prompt(A.STRINGS.PROMPT,A.STRINGS.DEFAULT);if(D){F=H.config.doc.createElement("div");D=H.config.doc.createTextNode(D);F.appendChild(D);D=F.innerHTML;this.get("host")._execCommand(I,D);G=new H.Selection();E=G.getSelected();if(!G.isCollapsed&&E.size()){C=E.item(0).one("a");if(C){E.item(0).replace(C);}if(B.UA.gecko){if(C.get("parentNode").test("span")){if(C.get("parentNode").one("br.yui-cursor")){C.get("parentNode").insert(C,"before");}}}}else{this.get("host").execCommand("inserthtml",'<a href="'+D+'">'+D+"</a>");}}return C;}});},"3.3.0",{requires:["editor-base"],skinnable:false});