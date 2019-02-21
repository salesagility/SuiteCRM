/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */




if(typeof('console') == 'undefined'){
console = {
	log: function(message) {
	
	}
}
}

StudioTabGroup = function(){
	this.fields = {};
	this.lastEditTabGroupLabel = -1;
	this.widths = new Object;
};


StudioTabGroup.prototype.editTabGroupLabel = function (id, done){
	if(!done){
		if(this.lastEditTabGroupLabel != -1)editTabGroupLabel(this.lastEditTabGroupLabel, true);
		document.getElementById('tabname_'+id).style.display = 'none';
		document.getElementById('tablabel_'+id).style.display = '';
		document.getElementById('tabother_'+id).style.display = 'none';
		document.getElementById('tablabel_'+id).focus();
		this.lastEditTabGroupLabel = id;
		//Ext.dd.DragDropMgr.lock();
	}else{
		this.lastEditTabGroupLabel = -1;
		document.getElementById('tabname_'+id).innerHTML = escape(document.getElementById('tablabel_'+id).value);
		document.getElementById('tabname_'+id).style.display = '';
		document.getElementById('tablabel_'+id).style.display = 'none';
		document.getElementById('tabother_'+id).style.display = '';
		//Ext.dd.DragDropMgr.unlock();
	}
}

 StudioTabGroup.prototype.generateForm = function(formname){
		  	var form = document.getElementById(formname);
		  	for(j = 0; j < studiotabs.slotCount; j++){
				var ul = document.getElementById('ul' + j);
				items = ul.getElementsByTagName('li');
				for(i = 0; i < items.length; i++) {
				
				if(typeof(studiotabs.subtabModules[items[i].id]) != 'undefined'){
				
					var input = document.createElement('input');
					input.type='hidden'
					input.name= j + '_'+ i;
					input.value = studiotabs.tabLabelToValue[studiotabs.subtabModules[items[i].id]];
					form.appendChild(input);
				}
				}
		  }
		  };

 StudioTabGroup.prototype.generateGroupForm = function(formname){
		  	this.clearGroupForm(formname);
		  	var form = document.getElementById(formname);
		  	for(j = 0; j < studiotabs.slotCount; j++){
				var ul = document.getElementById('ul' + j);
				items = ul.getElementsByTagName('li');
				for(i = 0; i < items.length; i++) {
				if(typeof(studiotabs.subtabModules[items[i].id]) != 'undefined'){
					var input = document.createElement('input');
					input.type='hidden';
					input.name= 'group_'+ j + '[]';
					input.value = studiotabs.tabLabelToValue[studiotabs.subtabModules[items[i].id]];
					form.appendChild(input);
//					if(this.widths[items[i].id] != null) {
					var winput = document.createElement('input');
					winput.type='hidden';
					winput.name= input.value + 'width';
					winput.value = "width=" + document.getElementById(items[i].id+'width').innerHTML;
					form.appendChild(winput);
//					}
				}
				}
		  	}
		  };
		  
StudioTabGroup.prototype.clearGroupForm = function(formname){
		var form = document.getElementById(formname);
		for(j = 0; j < form.elements.length; j++){
			if (typeof(form.elements[j].name) != 'undefined' && String(form.elements[j].name).indexOf("group") > -1) {
				form.removeChild(form.elements[j]);
				j--;
			}
		}
};

StudioTabGroup.prototype.deleteTabGroup = function(id){
		if(document.getElementById('delete_' + id).value == 0){
			document.getElementById('ul' + id).style.display = 'none';
			document.getElementById('tabname_'+id).style.textDecoration = 'line-through'
			document.getElementById('delete_' + id).value = 1;
		}else{
			document.getElementById('ul' + id).style.display = '';
			document.getElementById('tabname_'+id).style.textDecoration = 'none'
			document.getElementById('delete_' + id).value = 0;
		}
	}	

StudioTabGroup.prototype.editField = function(elem, link) {
	if (this.widths[elem.id] != null) {
		ModuleBuilder.getContent(link + '&width=' + this.widths[elem.id]);
	}else{
		ModuleBuilder.getContent(link);
	}
}

StudioTabGroup.prototype.saveField = function(elemID, formname) {
	var elem = document.getElementById(elemID);
	var form = document.getElementById(formname);
	var inputs = form.getElementsByTagName("input");
	for (i = 0; i < inputs.length; i++) {
		if (inputs[i].name == "width") {
			this.widths[elemID] = inputs[i].value;
			var dispWidth = elem.getElementsByTagName("td")[3];
			dispWidth.innerHTML = "width:" + inputs[i].value;
		}
		if (inputs[i].name == "label") {
			var title = elem.getElementsByTagName("span")[0];
			title.innerHTML = inputs[i].value;
		}
	}
	ModuleBuilder.submitForm(formname);
	ajaxStatus.flashStatus('Field Saved', 1000);
}

StudioTabGroup.prototype.reset = function() {
	this.subtabCount = {};
	this.subtabModules = {};
	this.tabLabelToValue = {};
	this.widths = new Object;
}

var lastField = '';
			var lastRowCount = -1;
			var undoDeleteDropDown = function(transaction){
			    deleteDropDownValue(transaction['row'], document.getElementById(transaction['id']), false);
			}
			jstransaction.register('deleteDropDown', undoDeleteDropDown, undoDeleteDropDown);
			function deleteDropDownValue(rowCount, field, record){
			    if(record){
			        jstransaction.record('deleteDropDown',{'row':rowCount, 'id': field.id });
			    }
			    //We are deleting if the value is 0
			    if(field.value == '0'){
			        field.value = '1';
			        document.getElementById('slot' + rowCount + '_value').style.textDecoration = 'line-through';
			    }else{
			        field.value = '0';
			        document.getElementById('slot' + rowCount + '_value').style.textDecoration = 'none';
			    }
			    
			   
			}
var studiotabs = new StudioTabGroup();
studiotabs.subtabCount = {};
studiotabs.subtabModules = {};
studiotabs.tabLabelToValue = {};