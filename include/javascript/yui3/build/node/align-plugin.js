/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('align-plugin',function(Y){var OFFSET_WIDTH='offsetWidth',OFFSET_HEIGHT='offsetHeight',undefined=undefined;function Align(config){if(config.host){this._host=config.host;}}
Align.prototype={to:function(region,regionPoint,point,syncOnResize){this._syncArgs=Y.Array(arguments);if(region.top===undefined){region=Y.one(region).get('region');}
if(region){var xy=[region.left,region.top],offxy=[region.width,region.height],points=Align.points,node=this._host,NULL=null,size=node.getAttrs([OFFSET_HEIGHT,OFFSET_WIDTH]),nodeoff=[0-size[OFFSET_WIDTH],0-size[OFFSET_HEIGHT]],regionFn0=regionPoint?points[regionPoint.charAt(0)]:NULL,regionFn1=(regionPoint&&regionPoint!=='cc')?points[regionPoint.charAt(1)]:NULL,nodeFn0=point?points[point.charAt(0)]:NULL,nodeFn1=(point&&point!=='cc')?points[point.charAt(1)]:NULL;if(regionFn0){xy=regionFn0(xy,offxy,regionPoint);}
if(regionFn1){xy=regionFn1(xy,offxy,regionPoint);}
if(nodeFn0){xy=nodeFn0(xy,nodeoff,point);}
if(nodeFn1){xy=nodeFn1(xy,nodeoff,point);}
if(xy&&node){node.setXY(xy);}
this._resize(syncOnResize);}
return this;},sync:function(){this.to.apply(this,this._syncArgs);return this;},_resize:function(add){var handle=this._handle;if(add&&!handle){this._handle=Y.on('resize',this._onresize,window,this);}else if(!add&&handle){handle.detach();}},_onresize:function(){var self=this;setTimeout(function(){self.sync();});},center:function(region,resize){this.to(region,'cc','cc',resize);return this;},destroy:function(){var handle=this._handle;if(handle){handle.detach();}}};Align.points={'t':function(xy,off){return xy;},'r':function(xy,off){return[xy[0]+off[0],xy[1]];},'b':function(xy,off){return[xy[0],xy[1]+off[1]];},'l':function(xy,off){return xy;},'c':function(xy,off,point){var axis=(point[0]==='t'||point[0]==='b')?0:1,ret,val;if(point==='cc'){ret=[xy[0]+off[0]/ 2,xy[1]+off[1]/ 2];}else{val=xy[axis]+off[axis]/ 2;ret=(axis)?[xy[0],val]:[val,xy[1]];}
return ret;}};Align.NAME='Align';Align.NS='align';Align.prototype.constructor=Align;Y.namespace('Plugin');Y.Plugin.Align=Align;},'3.3.0',{requires:['node-screen']});