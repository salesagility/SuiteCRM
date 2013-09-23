/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("event-hover",function(d){var c=d.Lang.isFunction,b=function(){},a={processArgs:function(e){var f=c(e[2])?2:3;return(c(e[f]))?e.splice(f,1)[0]:b;},on:function(h,f,g,e){f._detach=h[(e)?"delegate":"on"]({mouseenter:d.bind(g.fire,g),mouseleave:f._extra},e);},detach:function(g,e,f){e._detacher.detach();}};a.delegate=a.on;a.detachDelegate=a.detach;d.Event.define("hover",a);},"3.3.0",{requires:["event-mouseenter"]});