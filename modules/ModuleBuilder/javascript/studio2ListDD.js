/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/


max_default_columns = 6;

 Studio2.ListDD = function(el, sGroup, fromOnly) {
 	if (typeof el == 'number') {
 		el = el + "";
	}
 	if (typeof el == 'string')
 		el = document.getElementById(el);
	if (el != null) {
		var Dom = YAHOO.util.Dom;
		Studio2.ListDD.superclass.constructor.call(this, el, sGroup);
		this.addInvalidHandleType("input");
		this.addInvalidHandleType("a");
		var dEl = this.getDragEl()
		Dom.setStyle(dEl, "borderColor", "#FF0000");
		Dom.setStyle(dEl, "backgroundColor", "#e5e5e5");
		Dom.setStyle(dEl, "opacity", 0.76);
		Dom.setStyle(dEl, "filter", "alpha(opacity=76)");
		this.fromOnly = fromOnly;
	}
};

YAHOO.extend(Studio2.ListDD, YAHOO.util.DDProxy, {
	copyStyles : {'opacity':"", 'border':"", 'height':"", 'filter':"", 'zoom':""},
    startDrag: function(x, y){
		//We need to make sure no inline editors are in use, as drag.drop can break them
		if (typeof (SimpleList) != "undefined") {
			SimpleList.endCurrentDropDownEdit();
		}
		
		var Dom = YAHOO.util.Dom;
		var dragEl = this.getDragEl();
		var clickEl = this.getEl();
		
		this.parentID = clickEl.parentNode.id;
		this.clickContent = clickEl.innerHTML;
		dragEl.innerHTML = clickEl.innerHTML;
		
		Dom.addClass(dragEl, clickEl.className);
		Dom.setStyle(dragEl, "color", Dom.getStyle(clickEl, "color"));
		Dom.setStyle(dragEl, "height", Dom.getStyle(clickEl, "height"));
		Dom.setStyle(dragEl, "border", "1px solid #aaa");
		
		// save the style of the object 
		if (this.clickStyle == null) {
			this.clickStyle = {};
			for (var s in this.copyStyles) {
				this.clickStyle[s] = clickEl.style[s];
			}
			if (typeof(this.clickStyle['border']) == 'undefined' || this.clickStyle['border'] == "") 
				this.clickStyle['border'] = "1px solid";
		}
		
		Dom.setStyle(clickEl, "opacity", 0.5);
		Dom.setStyle(clickEl, "filter", "alpha(opacity=10)");
		Dom.setStyle(clickEl, "border", '2px dashed #cccccc');
        Studio2.setScrollObj(this);
	},
	
	updateTabs: function(){
		studiotabs.moduleTabs = [];
		for (j = 0; j < studiotabs.slotCount; j++) {
		
			var ul = document.getElementById('ul' + j);
			studiotabs.moduleTabs[j] = [];
			items = ul.getElementsByTagName("li");
			for (i = 0; i < items.length; i++) {
				if (items.length == 1) {
					items[i].innerHTML = SUGAR.language.get('ModuleBuilder', 'LBL_DROP_HERE');
				}
				else if (items[i].innerHTML == SUGAR.language.get('ModuleBuilder', 'LBL_DROP_HERE')) {
					items[i].innerHTML = '';
				}
				studiotabs.moduleTabs[ul.id.substr(2, ul.id.length)][studiotabs.subtabModules[items[i].id]] = true;
			}	
		}	
	},
	
	endDrag: function(e){
        Studio2.clearScrollObj();
		ModuleBuilder.state.isDirty=true;
		var clickEl = this.getEl();
		var clickExEl = new YAHOO.util.Element(clickEl);
		dragEl = this.getDragEl();
		dragEl.innerHTML = "";
		clickEl.innerHTML = this.clickContent;
		
		var p = clickEl.parentNode;
		if (p.id == 'trash') {
			p.removeChild(clickEl);
			this.lastNode = false;
			this.updateTabs();
			return;
		}
		
		for(var style in this.clickStyle) {
			if (typeof(this.clickStyle[style]) != 'undefined')
				clickExEl.setStyle(style, this.clickStyle[style]);
			else
				clickExEl.setStyle(style, '');
		}
		
		this.clickStyle = null;
		
		if (this.lastNode) {
			this.lastNode.id = 'addLS' + addListStudioCount;
			studiotabs.subtabModules[this.lastNode.id] = this.lastNode.module;
			yahooSlots[this.lastNode.id] = new Studio2.ListDD(this.lastNode.id, 'subTabs', false);
			addListStudioCount++;
			this.lastNode.style.opacity = 1;
			this.lastNode.style.filter = "alpha(opacity=100)";
		}
		this.lastNode = false;
		this.updateTabs();
		
		dragEl.innerHTML = "";
	},

    onDrag: Studio2.onDrag,
    
	onDragOver: function(e, id){
		var el = document.getElementById(id);
		/**
		 * Start:	Bug_#44445 
		 * Limit number of columns in dashlets on 6!
		 */
		var parent = el.parentNode.parentNode
		if(studiotabs.view == 'dashlet'){
			if(parent.id == 'Default'){
				var cols = el.parentNode.getElementsByTagName("li");
				if(cols.length > max_default_columns){
					/**
					 * Alert could be added but it will apear everytime when moving item over Defaults.
					 * Even when trying to change schedule of components inside of tab.
					 * alert('Maximum ' + max_default_columns + ' columns are allowed in Defaults tab!');
					 */
					return;
				}	
			}	
		}
		/**
		 * End:	Bug_#44445
		 */
		if (this.lastNode) {
			this.lastNode.parentNode.removeChild(this.lastNode);
			this.lastNode = false;
		}
		if (id.substr(0, 7) == 'modSlot') {
			return;
		}
		el = document.getElementById(id);
		dragEl = this.getDragEl();
		
		var mid = YAHOO.util.Dom.getY(el) + (el.clientHeight / 2);
		var el2 = this.getEl();
		var p = el.parentNode;
		if ((this.fromOnly || (el.id != 'trashcan' && el2.parentNode.id != p.id && el2.parentNode.id == this.parentID))) {
			if (typeof(studiotabs.moduleTabs[p.id.substr(2, p.id.length)][studiotabs.subtabModules[el2.id]]) != 'undefined') 
				return;
		}
		
		if (this.fromOnly && el.id != 'trashcan') {
			el2 = el2.cloneNode(true);
			el2.module = studiotabs.subtabModules[el2.id];
			el2.id = 'addListStudio' + addListStudioCount;
			this.lastNode = el2;
			this.lastNode.clickContent = el2.clickContent;
			this.lastNode.clickBorder = el2.clickBorder;
			this.lastNode.clickHeight = el2.clickHeight
		}
		
		if (YAHOO.util.Dom.getY(dragEl) < mid) { // insert on top triggering item
			p.insertBefore(el2, el);
		}
		else { // insert below triggered item
			p.insertBefore(el2, el.nextSibling);
		}
	}
});