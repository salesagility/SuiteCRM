/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('datasource-io',function(Y){var DSIO=function(){DSIO.superclass.constructor.apply(this,arguments);};Y.mix(DSIO,{NAME:"dataSourceIO",ATTRS:{io:{value:Y.io,cloneDefaultValue:false},ioConfig:{value:null}}});Y.extend(DSIO,Y.DataSource.Local,{initializer:function(config){this._queue={interval:null,conn:null,requests:[]};},successHandler:function(id,response,e){var defIOConfig=this.get("ioConfig");delete Y.DataSource.Local.transactions[e.tId];this.fire("data",Y.mix({data:response},e));if(defIOConfig&&defIOConfig.on&&defIOConfig.on.success){defIOConfig.on.success.apply(defIOConfig.context||Y,arguments);}},failureHandler:function(id,response,e){var defIOConfig=this.get("ioConfig");delete Y.DataSource.Local.transactions[e.tId];e.error=new Error("IO data failure");this.fire("data",Y.mix({data:response},e));if(defIOConfig&&defIOConfig.on&&defIOConfig.on.failure){defIOConfig.on.failure.apply(defIOConfig.context||Y,arguments);}},_queue:null,_defRequestFn:function(e){var uri=this.get("source"),io=this.get("io"),defIOConfig=this.get("ioConfig"),request=e.request,cfg=Y.merge(defIOConfig,e.cfg,{on:Y.merge(defIOConfig,{success:this.successHandler,failure:this.failureHandler}),context:this,"arguments":e});if(Y.Lang.isString(request)){if(cfg.method&&(cfg.method.toUpperCase()==="POST")){cfg.data=cfg.data?cfg.data+request:request;}
else{uri+=request;}}
Y.DataSource.Local.transactions[e.tId]=io(uri,cfg);return e.tId;}});Y.DataSource.IO=DSIO;},'3.3.0',{requires:['datasource-local','io-base']});