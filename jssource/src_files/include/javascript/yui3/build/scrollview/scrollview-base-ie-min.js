/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("scrollview-base-ie",function(a){a.mix(a.ScrollView.prototype,{_fixIESelect:function(c,b){this._cbDoc=b.get("ownerDocument");this._nativeBody=a.Node.getDOMNode(a.one("body",this._cbDoc));b.on("mousedown",function(){this._selectstart=this._nativeBody.onselectstart;this._nativeBody.onselectstart=this._iePreventSelect;this._cbDoc.once("mouseup",this._ieRestoreSelect,this);},this);},_iePreventSelect:function(){return false;},_ieRestoreSelect:function(){this._nativeBody.onselectstart=this._selectstart;}},true);},"3.3.0",{requires:["scrollview-base"]});