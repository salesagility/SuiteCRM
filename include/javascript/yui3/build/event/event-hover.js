/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('event-hover',function(Y){var isFunction=Y.Lang.isFunction,noop=function(){},conf={processArgs:function(args){var i=isFunction(args[2])?2:3;return(isFunction(args[i]))?args.splice(i,1)[0]:noop;},on:function(node,sub,notifier,filter){sub._detach=node[(filter)?"delegate":"on"]({mouseenter:Y.bind(notifier.fire,notifier),mouseleave:sub._extra},filter);},detach:function(node,sub,notifier){sub._detacher.detach();}};conf.delegate=conf.on;conf.detachDelegate=conf.detach;Y.Event.define("hover",conf);},'3.3.0',{requires:['event-mouseenter']});