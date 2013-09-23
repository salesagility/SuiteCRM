/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('scrollview-base',function(Y){var getClassName=Y.ClassNameManager.getClassName,SCROLLVIEW='scrollview',CLASS_NAMES={vertical:getClassName(SCROLLVIEW,'vert'),horizontal:getClassName(SCROLLVIEW,'horiz')},EV_SCROLL_END='scrollEnd',EV_SCROLL_FLICK='flick',FLICK=EV_SCROLL_FLICK,UI='ui',LEFT="left",TOP="top",PX="px",SCROLL_Y="scrollY",SCROLL_X="scrollX",BOUNCE="bounce",DIM_X="x",DIM_Y="y",BOUNDING_BOX="boundingBox",CONTENT_BOX="contentBox",EMPTY="",ZERO="0s",IE=Y.UA.ie,NATIVE_TRANSITIONS=Y.Transition.useNative,_constrain=function(val,min,max){return Math.min(Math.max(val,min),max);};Y.Node.DOM_EVENTS.DOMSubtreeModified=true;function ScrollView(){ScrollView.superclass.constructor.apply(this,arguments);}
Y.ScrollView=Y.extend(ScrollView,Y.Widget,{initializer:function(){var sv=this;sv._cb=sv.get(CONTENT_BOX);sv._bb=sv.get(BOUNDING_BOX);},_uiSizeCB:function(){},_onTransEnd:function(e){this.fire(EV_SCROLL_END);},bindUI:function(){var sv=this,cb=sv._cb,bb=sv._bb,scrollChangeHandler=sv._afterScrollChange,dimChangeHandler=sv._afterDimChange,flick=sv.get(FLICK);bb.on('gesturemovestart',Y.bind(sv._onGestureMoveStart,sv));if(IE){sv._fixIESelect(bb,cb);}
if(NATIVE_TRANSITIONS){cb.on('DOMSubtreeModified',Y.bind(sv._uiDimensionsChange,sv));}
if(flick){cb.on("flick",Y.bind(sv._flick,sv),flick);}
this.after({'scrollYChange':scrollChangeHandler,'scrollXChange':scrollChangeHandler,'heightChange':dimChangeHandler,'widthChange':dimChangeHandler});},syncUI:function(){this._uiDimensionsChange();this.scrollTo(this.get(SCROLL_X),this.get(SCROLL_Y));},scrollTo:function(x,y,duration,easing){var cb=this._cb,xSet=(x!==null),ySet=(y!==null),xMove=(xSet)?x*-1:0,yMove=(ySet)?y*-1:0,transition,TRANS=ScrollView._TRANSITION,callback=this._transEndCB;duration=duration||0;easing=easing||ScrollView.EASING;if(xSet){this.set(SCROLL_X,x,{src:UI});}
if(ySet){this.set(SCROLL_Y,y,{src:UI});}
if(NATIVE_TRANSITIONS){cb.setStyle(TRANS.DURATION,ZERO).setStyle(TRANS.PROPERTY,EMPTY);}
if(duration!==0){transition={easing:easing,duration:duration/1000};if(NATIVE_TRANSITIONS){transition.transform='translate3D('+xMove+'px,'+yMove+'px, 0px)';}else{if(xSet){transition.left=xMove+PX;}
if(ySet){transition.top=yMove+PX;}}
if(!callback){callback=this._transEndCB=Y.bind(this._onTransEnd,this);}
cb.transition(transition,callback);}else{if(NATIVE_TRANSITIONS){cb.setStyle('transform','translate3D('+xMove+'px,'+yMove+'px, 0px)');}else{if(xSet){cb.setStyle(LEFT,xMove+PX);}
if(ySet){cb.setStyle(TOP,yMove+PX);}}}},_prevent:{start:false,move:true,end:false},_onGestureMoveStart:function(e){var sv=this,bb=sv._bb;if(sv._prevent.start){e.preventDefault();}
sv._killTimer();sv._hm=bb.on('gesturemove',Y.bind(sv._onGestureMove,sv));sv._hme=bb.on('gesturemoveend',Y.bind(sv._onGestureMoveEnd,sv));sv._startY=e.clientY+sv.get(SCROLL_Y);sv._startX=e.clientX+sv.get(SCROLL_X);sv._startClientY=sv._endClientY=e.clientY;sv._startClientX=sv._endClientX=e.clientX;sv._isDragging=false;sv._flicking=false;sv._snapToEdge=false;},_onGestureMove:function(e){var sv=this;if(sv._prevent.move){e.preventDefault();}
sv._isDragging=true;sv._endClientY=e.clientY;sv._endClientX=e.clientX;if(sv._scrollsVertical){sv.set(SCROLL_Y,-(e.clientY-sv._startY));}
if(sv._scrollsHorizontal){sv.set(SCROLL_X,-(e.clientX-sv._startX));}},_onGestureMoveEnd:function(e){if(this._prevent.end){e.preventDefault();}
var sv=this,minY=sv._minScrollY,maxY=sv._maxScrollY,minX=sv._minScrollX,maxX=sv._maxScrollX,vert=sv._scrollsVertical,horiz=sv._scrollsHorizontal,startPoint=vert?sv._startClientY:sv._startClientX,endPoint=vert?sv._endClientY:sv._endClientX,distance=startPoint-endPoint,absDistance=Math.abs(distance),bb=sv._bb,x,y,xOrig,yOrig;sv._hm.detach();sv._hme.detach();sv._scrolledHalfway=sv._snapToEdge=sv._isDragging=false;sv.lastScrolledAmt=distance;if((horiz&&absDistance>bb.get('offsetWidth')/2)||(vert&&absDistance>bb.get('offsetHeight')/2)){sv._scrolledHalfway=true;sv._scrolledForward=distance>0;}
if(vert){yOrig=sv.get(SCROLL_Y);y=_constrain(yOrig,minY,maxY);}
if(horiz){xOrig=sv.get(SCROLL_X);x=_constrain(xOrig,minX,maxX);}
if(x!==xOrig||y!==yOrig){this._snapToEdge=true;if(vert){sv.set(SCROLL_Y,y);}
if(horiz){sv.set(SCROLL_X,x);}}
if(sv._snapToEdge){return;}
sv.fire(EV_SCROLL_END,{onGestureMoveEnd:true});return;},_afterScrollChange:function(e){var duration=e.duration,easing=e.easing,val=e.newVal;if(e.src!==UI){if(e.attrName==SCROLL_X){this._uiScrollTo(val,null,duration,easing);}else{this._uiScrollTo(null,val,duration,easing);}}},_uiScrollTo:function(x,y,duration,easing){duration=duration||this._snapToEdge?400:0;easing=easing||this._snapToEdge?ScrollView.SNAP_EASING:null;this.scrollTo(x,y,duration,easing);},_afterDimChange:function(){this._uiDimensionsChange();},_uiDimensionsChange:function(){var sv=this,bb=sv._bb,CLASS_NAMES=ScrollView.CLASS_NAMES,height=sv.get('height'),width=sv.get('width'),scrollHeight=bb.get('scrollHeight'),scrollWidth=bb.get('scrollWidth');if(height&&scrollHeight>height){sv._scrollsVertical=true;sv._maxScrollY=scrollHeight-height;sv._minScrollY=0;sv._scrollHeight=scrollHeight;bb.addClass(CLASS_NAMES.vertical);}
if(width&&scrollWidth>width){sv._scrollsHorizontal=true;sv._maxScrollX=scrollWidth-width;sv._minScrollX=0;sv._scrollWidth=scrollWidth;bb.addClass(CLASS_NAMES.horizontal);}},_flick:function(e){var flick=e.flick,sv=this;sv._currentVelocity=flick.velocity;sv._flicking=true;sv._cDecel=sv.get('deceleration');sv._cBounce=sv.get('bounce');sv._pastYEdge=false;sv._pastXEdge=false;sv._flickFrame();sv.fire(EV_SCROLL_FLICK);},_flickFrame:function(){var sv=this,newY,maxY,minY,newX,maxX,minX,scrollsVertical=sv._scrollsVertical,scrollsHorizontal=sv._scrollsHorizontal,deceleration=sv._cDecel,bounce=sv._cBounce,vel=sv._currentVelocity,step=ScrollView.FRAME_STEP;if(scrollsVertical){maxY=sv._maxScrollY;minY=sv._minScrollY;newY=sv.get(SCROLL_Y)-(vel*step);}
if(scrollsHorizontal){maxX=sv._maxScrollX;minX=sv._minScrollX;newX=sv.get(SCROLL_X)-(vel*step);}
vel=sv._currentVelocity=(vel*deceleration);if(Math.abs(vel).toFixed(4)<=0.015){sv._flicking=false;sv._killTimer(!(sv._pastYEdge||sv._pastXEdge));if(scrollsVertical){if(newY<minY){sv._snapToEdge=true;sv.set(SCROLL_Y,minY);}else if(newY>maxY){sv._snapToEdge=true;sv.set(SCROLL_Y,maxY);}}
if(scrollsHorizontal){if(newX<minX){sv._snapToEdge=true;sv.set(SCROLL_X,minX);}else if(newX>maxX){sv._snapToEdge=true;sv.set(SCROLL_X,maxX);}}
return;}
if(scrollsVertical){if(newY<minY||newY>maxY){sv._pastYEdge=true;sv._currentVelocity*=bounce;}
sv.set(SCROLL_Y,newY);}
if(scrollsHorizontal){if(newX<minX||newX>maxX){sv._pastXEdge=true;sv._currentVelocity*=bounce;}
sv.set(SCROLL_X,newX);}
if(!sv._flickTimer){sv._flickTimer=Y.later(step,sv,'_flickFrame',null,true);}},_killTimer:function(fireEvent){var sv=this;if(sv._flickTimer){sv._flickTimer.cancel();sv._flickTimer=null;}
if(fireEvent){sv.fire(EV_SCROLL_END);}},_setScroll:function(val,dim){var bouncing=this._cachedBounce||this.get(BOUNCE),range=ScrollView.BOUNCE_RANGE,maxScroll=(dim==DIM_X)?this._maxScrollX:this._maxScrollY,min=bouncing?-range:0,max=bouncing?maxScroll+range:maxScroll;if(!bouncing||!this._isDragging){if(val<min){val=min;}else if(val>max){val=max;}}
return val;},_setScrollX:function(val){return this._setScroll(val,DIM_X);},_setScrollY:function(val){return this._setScroll(val,DIM_Y);}},{NAME:'scrollview',ATTRS:{scrollY:{value:0,setter:'_setScrollY'},scrollX:{value:0,setter:'_setScrollX'},deceleration:{value:0.93},bounce:{value:0.1},flick:{value:{minDistance:10,minVelocity:0.3}}},CLASS_NAMES:CLASS_NAMES,UI_SRC:UI,BOUNCE_RANGE:150,FRAME_STEP:30,EASING:'cubic-bezier(0, 0.1, 0, 1.0)',SNAP_EASING:'ease-out',_TRANSITION:{DURATION:"WebkitTransitionDuration",PROPERTY:"WebkitTransitionProperty"}});},'3.3.0',{skinnable:true,requires:['widget','event-gestures','transition']});