/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('history-html5',function(Y){var HistoryBase=Y.HistoryBase,doc=Y.config.doc,win=Y.config.win,sessionStorage,useHistoryHTML5=Y.config.useHistoryHTML5,JSON=Y.JSON||win.JSON,ENABLE_FALLBACK='enableSessionFallback',SESSION_KEY='YUI_HistoryHTML5_state',SRC_POPSTATE='popstate',SRC_REPLACE=HistoryBase.SRC_REPLACE;function HistoryHTML5(){HistoryHTML5.superclass.constructor.apply(this,arguments);}
Y.extend(HistoryHTML5,HistoryBase,{_init:function(config){Y.on('popstate',this._onPopState,win,this);HistoryHTML5.superclass._init.apply(this,arguments);if(config&&config[ENABLE_FALLBACK]&&YUI.Env.windowLoaded){try{sessionStorage=win.sessionStorage;}catch(ex){}
this._loadSessionState();}},_getSessionKey:function(){return SESSION_KEY+'_'+win.location.pathname;},_loadSessionState:function(){var lastState=JSON&&sessionStorage&&sessionStorage[this._getSessionKey()];if(lastState){try{this._resolveChanges(SRC_POPSTATE,JSON.parse(lastState)||null);}catch(ex){}}},_storeSessionState:function(state){if(this._config[ENABLE_FALLBACK]&&JSON&&sessionStorage){sessionStorage[this._getSessionKey()]=JSON.stringify(state||null);}},_storeState:function(src,newState,options){if(src!==SRC_POPSTATE){win.history[src===SRC_REPLACE?'replaceState':'pushState'](newState,options.title||doc.title||'',options.url||null);}
this._storeSessionState(newState);HistoryHTML5.superclass._storeState.apply(this,arguments);},_onPopState:function(e){var state=e._event.state;this._storeSessionState(state);this._resolveChanges(SRC_POPSTATE,state||null);}},{NAME:'historyhtml5',SRC_POPSTATE:SRC_POPSTATE});if(!Y.Node.DOM_EVENTS.popstate){Y.Node.DOM_EVENTS.popstate=1;}
Y.HistoryHTML5=HistoryHTML5;if(useHistoryHTML5===true||(useHistoryHTML5!==false&&HistoryBase.html5)){Y.History=HistoryHTML5;}},'3.3.0',{optional:['json'],requires:['event-base','history-base','node-base']});