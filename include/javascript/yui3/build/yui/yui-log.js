/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('yui-log',function(Y){var INSTANCE=Y,LOGEVENT='yui:log',UNDEFINED='undefined',LEVELS={debug:1,info:1,warn:1,error:1};INSTANCE.log=function(msg,cat,src,silent){var bail,excl,incl,m,f,Y=INSTANCE,c=Y.config,publisher=(Y.fire)?Y:YUI.Env.globalEvents;if(c.debug){if(src){excl=c.logExclude;incl=c.logInclude;if(incl&&!(src in incl)){bail=1;}else if(excl&&(src in excl)){bail=1;}}
if(!bail){if(c.useBrowserConsole){m=(src)?src+': '+msg:msg;if(Y.Lang.isFunction(c.logFn)){c.logFn.call(Y,msg,cat,src);}else if(typeof console!=UNDEFINED&&console.log){f=(cat&&console[cat]&&(cat in LEVELS))?cat:'log';console[f](m);}else if(typeof opera!=UNDEFINED){opera.postError(m);}}
if(publisher&&!silent){if(publisher==Y&&(!publisher.getEvent(LOGEVENT))){publisher.publish(LOGEVENT,{broadcast:2});}
publisher.fire(LOGEVENT,{msg:msg,cat:cat,src:src});}}}
return Y;};INSTANCE.message=function(){return INSTANCE.log.apply(INSTANCE,arguments);};},'3.3.0',{requires:['yui-base']});