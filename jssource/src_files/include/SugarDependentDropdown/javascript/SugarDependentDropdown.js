/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

SUGAR.dependentDropdown = {
	/*
	 * Container for "action" metadata - allows DD to parse saved choices and apply them at display time
	 */
	currentAction : null,
	/*
	 * Flag to turn on debug mode.
	 * Current debug output:
	 * SUGAR.dependentDropdown._stack - simple list of this class' called methods
	 */
	debugMode : false
}

/**
 * Handle drop-down dependencies
 * @param object HTML form element object
 */
SUGAR.dependentDropdown.handleDependentDropdown = function(el) {
	/**
	 * 
	 * 
	 * PROTOTYPE THIS METHOD TO CUSTOMIZE RESPONSES FOR YOUR DEPENDENT DROPDOWNS
	 * 
	 * 
	 * 
	 */
	/**
	if(SUGAR.dependentDropdown.debugMode) SUGAR.dependentDropdown.utils.debugStack('handleDependentDropdown');
	
	/*
	 * el.id example:
	 * "criteriaGroup::0:::0:-:crit0id"
	 * [grouping from metadata]::[index]:::[elementIndex]:-:[assignedID from metadata]
	 * index is row-number
	 * elementIndex is the index of the current element in this row
	var index = el.id.slice(el.id.indexOf("::") + 2, el.id.indexOf(":::"));
	var elementRow = el.boxObject.parentBox;
	var elementIndex = el.id.slice(el.id.indexOf(":::") + 3, el.id.indexOf(":-:"));

	elementIndex++;
	var elementKey = "element" + elementIndex;
	var focusElement = SUGAR.dependentDropdown.dropdowns[focusDD].elements[elementKey];
	
	if(focusElement) {
		if(focusElement.handlers) {
			try {
				focusElement = focusElement.handlers[el.value];
			} catch(e) {
				if(SUGAR.dependentDropdown.dropdowns.debugMode) {
					debugger;
				}
			}
		}
		SUGAR.dependentDropdown.generateElement(focusElement, elementRow, index, elementIndex);
	} else {
	}
	*/
}






SUGAR.dependentDropdown.generateElement = function(focusElement, elementRow, index, elementIndex) {
	if(SUGAR.dependentDropdown.debugMode) SUGAR.dependentDropdown.utils.debugStack('generateElement');
	
	var tmp = null;
	
	if(focusElement) {
		/* get sandbox to play in */
		var sandbox = SUGAR.dependentDropdown.utils.generateElementContainer(focusElement, elementRow, index, elementIndex);
		
		/* handle labels that appear 'left' or 'top' */
		if(focusElement.label) {
			focusLabel = {
				tag : 'span',
				cls : 'routingLabel',
				html : "&nbsp;" + focusElement.label + "&nbsp;"
			}
			
			switch(focusElement.label_pos) {
				case "top":
					focusLabel.html = focusElement.label + "<br />";
				break;
				
				case "bottom": 
					focusLabel.html = "<br />" + focusElement.label;
				break;
			}
			
			if(focusElement.label_pos == 'left' || focusElement.label_pos == 'top') {
				YAHOO.ext.DomHelper.append(sandbox, focusLabel);
			}
		}

		/**********************************************************************
		 * FUN PART BELOW
		 */
		switch(focusElement.type) {
			case 'input':
				/*
				 * focusElement.values can be lazy-loaded via JS call
				 */
				if(typeof(focusElement.values) == 'string') {
					focusElement.values = eval(focusElement.values);
				}
				
				/* Define the key-value that is to be used to pre-select a value in the dropdown */	
				var preselect = SUGAR.dependentDropdown.utils.getPreselectKey(focusElement.name);

				if(preselect.match(/::/))
					preselect = '';

				tmp = YAHOO.ext.DomHelper.append(sandbox, {
					tag			: 'input',
					id			: focusElement.grouping + "::" + index + ":::" + elementIndex + ":-:" + focusElement.id,
					name		: focusElement.grouping + "::" + index + "::" + focusElement.name,
					cls			: 'input',
					onchange	: focusElement.onchange,
					value		: preselect
				}, true);
				var newElement = tmp.dom;
			break;


			case 'select':
				tmp = YAHOO.ext.DomHelper.append(sandbox, {
					tag			: 'select',
					id			: focusElement.grouping + "::" + index + ":::" + elementIndex + ":-:" + focusElement.id,
					name		: focusElement.grouping + "::" + index + "::" + focusElement.name,
					cls			: 'input',
					onchange	: focusElement.onchange
				}, true);
				var newElement = tmp.dom;
				
				/*
				 * focusElement.values can be lazy-loaded via JS call
				 */
				if(typeof(focusElement.values) == 'string') {
					focusElement.values = eval(focusElement.values);
				}
				
				/* Define the key-value that is to be used to pre-select a value in the dropdown */
				var preselect = SUGAR.dependentDropdown.utils.getPreselectKey(focusElement.name);
				
				// Loop through the values (passed or generated) and preselect as needed
				var i = 0;
				for(var key in focusElement.values) {
					var selected = (preselect == key) ? true : false;
					newElement.options[i] = new Option(focusElement.values[key], key, selected);

					// ie6/7 workaround
					if(selected) {
						newElement.options[i].selected = true;
					}
					i++;
				}
			break;
			
			case 'none':
			break;
			
			case 'checkbox':
				alert('implement checkbox pls');
			break;
			case 'multiple':
				alert('implement multiple pls');
			break;
			
			default:
				if(SUGAR.dependentDropdown.dropdowns.debugMode) {
					alert("Improper type defined: [ " + focusElement.type + "]");
				}
				return;
			break;
		}

		/* handle label placement *after* or *below* the drop-down */
		if(focusElement.label) {
			if(focusElement.label_pos == 'right' || focusElement.label_pos == 'bottom') {
				YAHOO.ext.DomHelper.append(sandbox, focusLabel);
			}
		}

		/* trigger dependent dropdown action to cascade dependencies */
		try {
			newElement.onchange();
			//eval(focusElement.onchange); "this" has no reference
		} catch(e) {
			if(SUGAR.dependentDropdown.dropdowns.debugMode) {
				debugger;
			}
		}

	} else {
	}
}



///////////////////////////////////////////////////////////////////////////////
////	UTILS
SUGAR.dependentDropdown.utils = {
	/**
	 * creates a DIV container for a given element
	 * @param object focusElement Element in focus' metadata
	 * @param object elementRow Parent DIV container's DOM object
	 * @param int index Index of current elementRow
	 * @param int elementIndex Index of the element in focus relative to others in the definition
	 * @return obj Reference DOM object generated
	 */
	generateElementContainer : function(focusElement, elementRow, index, elementIndex) {
		/* clear out existing element if exists */
		var oldElement = document.getElementById('elementContainer' + focusElement.grouping + "::" + index + ":::" + elementIndex);
	
		if(oldElement) {
			SUGAR.dependentDropdown.utils.removeChildren(oldElement);
		}
		
		/* create sandbox to ease removal */
		var tmp = YAHOO.ext.DomHelper.append(elementRow, {
			tag : 'span',
			id	: 'elementContainer' + focusElement.grouping + "::" + index + ":::" + elementIndex
		}, true);
		
		return tmp.dom;
	},
	/**
	 * Finds the preselect key from the User's saved (loaded into memory) metadata
	 * @param string elementName Name of form element - functions as key to user's saved value
	 */
	getPreselectKey : function(elementName) {
		try {
			if(SUGAR.dependentDropdown.currentAction.action[elementName]) {
				return SUGAR.dependentDropdown.currentAction.action[elementName];
			} else {
				return '';
			}
		} catch(e) {
			if(SUGAR.dependentDropdown.dropdowns.debugMode) {
				//debugger;
			}
			return '';
		}
	},
	
	/**
	 * provides a list of methods called in order when debugging
	 * @param object
	 */
	debugStack : function(func) {
		if(!SUGAR.dependentDropdown._stack) {
			SUGAR.dependentDropdown._stack = new Array();
		}
		
		SUGAR.dependentDropdown._stack.push(func);
	},
	
	/**
	 * Removes all child nodes from the passed DOM element
	 */
	removeChildren : function(el) {
		for(i=el.childNodes.length - 1; i >= 0; i--) {
			if(el.childNodes[i]) {
				el.removeChild(el.childNodes[i]);
			}
		}
	}
}
