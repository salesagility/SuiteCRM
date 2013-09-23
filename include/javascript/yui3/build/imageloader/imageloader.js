/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('imageloader',function(Y){Y.ImgLoadGroup=function(){this._init();Y.ImgLoadGroup.superclass.constructor.apply(this,arguments);};Y.ImgLoadGroup.NAME='imgLoadGroup';Y.ImgLoadGroup.ATTRS={name:{value:''},timeLimit:{value:null},foldDistance:{validator:Y.Lang.isNumber,setter:function(val){this._setFoldTriggers();return val;},lazyAdd:false},className:{value:null,setter:function(name){this._className=name;return name;},lazyAdd:false}};var groupProto={_init:function(){this._triggers=[];this._imgObjs={};this._timeout=null;this._classImageEls=null;this._className=null;this._areFoldTriggersSet=false;this._maxKnownHLimit=0;Y.on('domready',this._onloadTasks,this);},addTrigger:function(obj,type){if(!obj||!type){return this;}
var wrappedFetch=function(){this.fetch();};this._triggers.push(Y.on(type,wrappedFetch,obj,this));return this;},addCustomTrigger:function(name,obj){if(!name){return this;}
var wrappedFetch=function(){this.fetch();};if(Y.Lang.isUndefined(obj)){this._triggers.push(Y.on(name,wrappedFetch,this));}
else{this._triggers.push(obj.on(name,wrappedFetch,this));}
return this;},_setFoldTriggers:function(){if(this._areFoldTriggersSet){return;}
var wrappedFoldCheck=function(){this._foldCheck();};this._triggers.push(Y.on('scroll',wrappedFoldCheck,window,this));this._triggers.push(Y.on('resize',wrappedFoldCheck,window,this));this._areFoldTriggersSet=true;},_onloadTasks:function(){var timeLim=this.get('timeLimit');if(timeLim&&timeLim>0){this._timeout=setTimeout(this._getFetchTimeout(),timeLim*1000);}
if(!Y.Lang.isUndefined(this.get('foldDistance'))){this._foldCheck();}},_getFetchTimeout:function(){var self=this;return function(){self.fetch();};},registerImage:function(){var domId=arguments[0].domId;if(!domId){return null;}
this._imgObjs[domId]=new Y.ImgLoadImgObj(arguments[0]);return this._imgObjs[domId];},fetch:function(){this._clearTriggers();this._fetchByClass();for(var id in this._imgObjs){if(this._imgObjs.hasOwnProperty(id)){this._imgObjs[id].fetch();}}},_clearTriggers:function(){clearTimeout(this._timeout);for(var i=0,len=this._triggers.length;i<len;i++){this._triggers[i].detach();}},_foldCheck:function(){var allFetched=true,viewReg=Y.DOM.viewportRegion(),hLimit=viewReg.bottom+this.get('foldDistance'),id,imgFetched,els,i,len;if(hLimit<=this._maxKnownHLimit){return;}
this._maxKnownHLimit=hLimit;for(id in this._imgObjs){if(this._imgObjs.hasOwnProperty(id)){imgFetched=this._imgObjs[id].fetch(hLimit);allFetched=allFetched&&imgFetched;}}
if(this._className){if(this._classImageEls===null){this._classImageEls=[];els=Y.all('.'+this._className);els.each(function(node){this._classImageEls.push({el:node,y:node.getY(),fetched:false});},this);}
els=this._classImageEls;for(i=0,len=els.length;i<len;i++){if(els[i].fetched){continue;}
if(els[i].y&&els[i].y<=hLimit){els[i].el.removeClass(this._className);els[i].fetched=true;}
else{allFetched=false;}}}
if(allFetched){this._clearTriggers();}},_fetchByClass:function(){if(!this._className){return;}
Y.all('.'+this._className).removeClass(this._className);}};Y.extend(Y.ImgLoadGroup,Y.Base,groupProto);Y.ImgLoadImgObj=function(){Y.ImgLoadImgObj.superclass.constructor.apply(this,arguments);this._init();};Y.ImgLoadImgObj.NAME='imgLoadImgObj';Y.ImgLoadImgObj.ATTRS={domId:{value:null,writeOnce:true},bgUrl:{value:null},srcUrl:{value:null},width:{value:null},height:{value:null},setVisible:{value:false},isPng:{value:false},sizingMethod:{value:'scale'},enabled:{value:'true'}};var imgProto={_init:function(){this._fetched=false;this._imgEl=null;this._yPos=null;},fetch:function(withinY){if(this._fetched){return true;}
var el=this._getImgEl(),yPos;if(!el){return false;}
if(withinY){yPos=this._getYPos();if(!yPos||yPos>withinY){return false;}}
if(this.get('bgUrl')!==null){if(this.get('isPng')&&Y.UA.ie&&Y.UA.ie<=6){el.setStyle('filter','progid:DXImageTransform.Microsoft.AlphaImageLoader(src="'+this.get('bgUrl')+'", sizingMethod="'+this.get('sizingMethod')+'", enabled="'+this.get('enabled')+'")');}
else{el.setStyle('backgroundImage',"url('"+this.get('bgUrl')+"')");}}
else if(this.get('srcUrl')!==null){el.setAttribute('src',this.get('srcUrl'));}
if(this.get('setVisible')){el.setStyle('visibility','visible');}
if(this.get('width')){el.setAttribute('width',this.get('width'));}
if(this.get('height')){el.setAttribute('height',this.get('height'));}
this._fetched=true;return true;},_getImgEl:function(){if(this._imgEl===null){this._imgEl=Y.one('#'+this.get('domId'));}
return this._imgEl;},_getYPos:function(){if(this._yPos===null){this._yPos=this._getImgEl().getY();}
return this._yPos;}};Y.extend(Y.ImgLoadImgObj,Y.Base,imgProto);},'3.3.0',{requires:['base-base','node-style','node-screen']});