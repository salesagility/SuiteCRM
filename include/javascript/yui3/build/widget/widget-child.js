/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('widget-child',function(Y){var Lang=Y.Lang;function Child(){Y.after(this._syncUIChild,this,"syncUI");Y.after(this._bindUIChild,this,"bindUI");}
Child.ATTRS={selected:{value:0,validator:Lang.isNumber},index:{readOnly:true,getter:function(){var parent=this.get("parent"),index=-1;if(parent){index=parent.indexOf(this);}
return index;}},parent:{readOnly:true},depth:{readOnly:true,getter:function(){var parent=this.get("parent"),root=this.get("root"),depth=-1;while(parent){depth=(depth+1);if(parent==root){break;}
parent=parent.get("parent");}
return depth;}},root:{readOnly:true,getter:function(){var getParent=function(child){var parent=child.get("parent"),FnRootType=child.ROOT_TYPE,criteria=parent;if(FnRootType){criteria=(parent&&Y.instanceOf(parent,FnRootType));}
return(criteria?getParent(parent):child);};return getParent(this);}}};Child.prototype={ROOT_TYPE:null,_getUIEventNode:function(){var root=this.get("root"),returnVal;if(root){returnVal=root.get("boundingBox");}
return returnVal;},next:function(circular){var parent=this.get("parent"),sibling;if(parent){sibling=parent.item((this.get("index")+1));}
if(!sibling&&circular){sibling=parent.item(0);}
return sibling;},previous:function(circular){var parent=this.get("parent"),index=this.get("index"),sibling;if(parent&&index>0){sibling=parent.item([(index-1)]);}
if(!sibling&&circular){sibling=parent.item((parent.size()-1));}
return sibling;},remove:function(index){var parent,removed;if(Lang.isNumber(index)){removed=Y.WidgetParent.prototype.remove.apply(this,arguments);}
else{parent=this.get("parent");if(parent){removed=parent.remove(this.get("index"));}}
return removed;},isRoot:function(){return(this==this.get("root"));},ancestor:function(depth){var root=this.get("root"),parent;if(this.get("depth")>depth){parent=this.get("parent");while(parent!=root&&parent.get("depth")>depth){parent=parent.get("parent");}}
return parent;},_uiSetChildSelected:function(selected){var box=this.get("boundingBox"),sClassName=this.getClassName("selected");if(selected===0){box.removeClass(sClassName);}
else{box.addClass(sClassName);}},_afterChildSelectedChange:function(event){this._uiSetChildSelected(event.newVal);},_syncUIChild:function(){this._uiSetChildSelected(this.get("selected"));},_bindUIChild:function(){this.after("selectedChange",this._afterChildSelectedChange);}};Y.WidgetChild=Child;},'3.3.0',{requires:['base-build','widget']});