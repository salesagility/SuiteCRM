/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('event-mouseenter',function(Y){function notify(e,notifier){var current=e.currentTarget,related=e.relatedTarget;if(current!==related&&!current.contains(related)){notifier.fire(e);}}
var config={proxyType:"mouseover",on:function(node,sub,notifier){sub.onHandle=node.on(this.proxyType,notify,null,notifier);},detach:function(node,sub){sub.onHandle.detach();},delegate:function(node,sub,notifier,filter){sub.delegateHandle=Y.delegate(this.proxyType,notify,node,filter,null,notifier);},detachDelegate:function(node,sub){sub.delegateHandle.detach();}};Y.Event.define("mouseenter",config,true);Y.Event.define("mouseleave",Y.merge(config,{proxyType:"mouseout"}),true);},'3.3.0',{requires:['event-synthetic']});