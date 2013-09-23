/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('dd-constrain',function(Y){var DRAG_NODE='dragNode',OFFSET_HEIGHT='offsetHeight',OFFSET_WIDTH='offsetWidth',HOST='host',TICK_X_ARRAY='tickXArray',TICK_Y_ARRAY='tickYArray',DDM=Y.DD.DDM,TOP='top',RIGHT='right',BOTTOM='bottom',LEFT='left',VIEW='view',proto=null,EV_TICK_ALIGN_X='drag:tickAlignX',EV_TICK_ALIGN_Y='drag:tickAlignY',C=function(config){this._lazyAddAttrs=false;C.superclass.constructor.apply(this,arguments);};C.NAME='ddConstrained';C.NS='con';C.ATTRS={host:{},stickX:{value:false},stickY:{value:false},tickX:{value:false},tickY:{value:false},tickXArray:{value:false},tickYArray:{value:false},gutter:{value:'0',setter:function(gutter){return Y.DD.DDM.cssSizestoObject(gutter);}},constrain:{value:VIEW,setter:function(con){var node=Y.one(con);if(node){con=node;}
return con;}},constrain2region:{setter:function(r){return this.set('constrain',r);}},constrain2node:{setter:function(n){return this.set('constrain',Y.one(n));}},constrain2view:{setter:function(n){return this.set('constrain',VIEW);}},cacheRegion:{value:true}};proto={_lastTickXFired:null,_lastTickYFired:null,initializer:function(){this._createEvents();this.get(HOST).on('drag:end',Y.bind(this._handleEnd,this));this.get(HOST).on('drag:start',Y.bind(this._handleStart,this));this.get(HOST).after('drag:align',Y.bind(this.align,this));this.get(HOST).after('drag:drag',Y.bind(this.drag,this));},_createEvents:function(){var instance=this;var ev=[EV_TICK_ALIGN_X,EV_TICK_ALIGN_Y];Y.each(ev,function(v,k){this.publish(v,{type:v,emitFacade:true,bubbles:true,queuable:false,prefix:'drag'});},this);},_handleEnd:function(){this._lastTickYFired=null;this._lastTickXFired=null;},_handleStart:function(){this.resetCache();},_regionCache:null,_cacheRegion:function(){this._regionCache=this.get('constrain').get('region');},resetCache:function(){this._regionCache=null;},_getConstraint:function(){var con=this.get('constrain'),g=this.get('gutter'),region;if(con){if(con instanceof Y.Node){if(!this._regionCache){Y.on('resize',Y.bind(this._cacheRegion,this),Y.config.win);this._cacheRegion();}
region=Y.clone(this._regionCache);if(!this.get('cacheRegion')){this.resetCache();}}else if(Y.Lang.isObject(con)){region=Y.clone(con);}}
if(!con||!region){con=VIEW;}
if(con===VIEW){region=this.get(HOST).get(DRAG_NODE).get('viewportRegion');}
Y.each(g,function(i,n){if((n==RIGHT)||(n==BOTTOM)){region[n]-=i;}else{region[n]+=i;}});return region;},getRegion:function(inc){var r={},oh=null,ow=null,host=this.get(HOST);r=this._getConstraint();if(inc){oh=host.get(DRAG_NODE).get(OFFSET_HEIGHT);ow=host.get(DRAG_NODE).get(OFFSET_WIDTH);r[RIGHT]=r[RIGHT]-ow;r[BOTTOM]=r[BOTTOM]-oh;}
return r;},_checkRegion:function(_xy){var oxy=_xy,r=this.getRegion(),host=this.get(HOST),oh=host.get(DRAG_NODE).get(OFFSET_HEIGHT),ow=host.get(DRAG_NODE).get(OFFSET_WIDTH);if(oxy[1]>(r[BOTTOM]-oh)){_xy[1]=(r[BOTTOM]-oh);}
if(r[TOP]>oxy[1]){_xy[1]=r[TOP];}
if(oxy[0]>(r[RIGHT]-ow)){_xy[0]=(r[RIGHT]-ow);}
if(r[LEFT]>oxy[0]){_xy[0]=r[LEFT];}
return _xy;},inRegion:function(xy){xy=xy||this.get(HOST).get(DRAG_NODE).getXY();var _xy=this._checkRegion([xy[0],xy[1]]),inside=false;if((xy[0]===_xy[0])&&(xy[1]===_xy[1])){inside=true;}
return inside;},align:function(){var host=this.get(HOST),_xy=[host.actXY[0],host.actXY[1]],r=this.getRegion(true);if(this.get('stickX')){_xy[1]=(host.startXY[1]-host.deltaXY[1]);}
if(this.get('stickY')){_xy[0]=(host.startXY[0]-host.deltaXY[0]);}
if(r){_xy=this._checkRegion(_xy);}
_xy=this._checkTicks(_xy,r);host.actXY=_xy;},drag:function(event){var host=this.get(HOST),xt=this.get('tickX'),yt=this.get('tickY'),_xy=[host.actXY[0],host.actXY[1]];if((Y.Lang.isNumber(xt)||this.get(TICK_X_ARRAY))&&(this._lastTickXFired!==_xy[0])){this._tickAlignX();this._lastTickXFired=_xy[0];}
if((Y.Lang.isNumber(yt)||this.get(TICK_Y_ARRAY))&&(this._lastTickYFired!==_xy[1])){this._tickAlignY();this._lastTickYFired=_xy[1];}},_checkTicks:function(xy,r){var host=this.get(HOST),lx=(host.startXY[0]-host.deltaXY[0]),ly=(host.startXY[1]-host.deltaXY[1]),xt=this.get('tickX'),yt=this.get('tickY');if(xt&&!this.get(TICK_X_ARRAY)){xy[0]=DDM._calcTicks(xy[0],lx,xt,r[LEFT],r[RIGHT]);}
if(yt&&!this.get(TICK_Y_ARRAY)){xy[1]=DDM._calcTicks(xy[1],ly,yt,r[TOP],r[BOTTOM]);}
if(this.get(TICK_X_ARRAY)){xy[0]=DDM._calcTickArray(xy[0],this.get(TICK_X_ARRAY),r[LEFT],r[RIGHT]);}
if(this.get(TICK_Y_ARRAY)){xy[1]=DDM._calcTickArray(xy[1],this.get(TICK_Y_ARRAY),r[TOP],r[BOTTOM]);}
return xy;},_tickAlignX:function(){this.fire(EV_TICK_ALIGN_X);},_tickAlignY:function(){this.fire(EV_TICK_ALIGN_Y);}};Y.namespace('Plugin');Y.extend(C,Y.Base,proto);Y.Plugin.DDConstrained=C;Y.mix(DDM,{_calcTicks:function(pos,start,tick,off1,off2){var ix=((pos-start)/ tick),min=Math.floor(ix),max=Math.ceil(ix);if((min!==0)||(max!==0)){if((ix>=min)&&(ix<=max)){pos=(start+(tick*min));if(off1&&off2){if(pos<off1){pos=(start+(tick*(min+1)));}
if(pos>off2){pos=(start+(tick*(min-1)));}}}}
return pos;},_calcTickArray:function(pos,ticks,off1,off2){var i=0,len=ticks.length,next=0,diff1,diff2,ret;if(!ticks||(ticks.length===0)){return pos;}else if(ticks[0]>=pos){return ticks[0];}else{for(i=0;i<len;i++){next=(i+1);if(ticks[next]&&ticks[next]>=pos){diff1=pos-ticks[i];diff2=ticks[next]-pos;ret=(diff2>diff1)?ticks[i]:ticks[next];if(off1&&off2){if(ret>off2){if(ticks[i]){ret=ticks[i];}else{ret=ticks[len-1];}}}
return ret;}}
return ticks[ticks.length-1];}}});},'3.3.0',{requires:['dd-drag'],skinnable:false});