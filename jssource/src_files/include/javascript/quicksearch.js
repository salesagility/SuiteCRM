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




/**
 * browse document for quickSearch fields
 * Compatible ExtJS 1.1.1 and ExtJS 2.0
 * parameter : noReload - if set to true, enableQS will enable only
 *             the new sqsEnabled field on the page. If set to false
 *             it will reload all the sqsEnabled fields.
 */
function enableQS(noReload){
	YAHOO.util.Event.onDOMReady(function(){
    	//Safety check.  If sqs_objects variable is null, we really can't do anything useful
    	if(typeof sqs_objects == 'undefined') {
    	   return;
    	}
        
    	var Dom = YAHOO.util.Dom;
    	
    	//Get all the fields where sqsEnabled is an attribue, these should be the input text fields for quicksearch
        var qsFields = Dom.getElementsByClassName('sqsEnabled');
        
        //Now loop through all these fields and process them
        for(var qsField in qsFields){
        	
        	//Safety checks to skip processing of invalid entries
        	if(typeof qsFields[qsField] == 'function' || typeof qsFields[qsField].id == 'undefined') {
        	   continue;
        	}
        	
        	//Create the index we are using to search for the sqs_objects Array
        	var form_id = qsFields[qsField].form.getAttribute('id');
        	
        	//This is a special case where there is an element with id attribute value of "id"
        	//In this case, we get the real_id attribute (occurs in modules/Import/tpls/step3.tpl only).
        	if(typeof form_id == 'object' && qsFields[qsField].form.getAttribute('real_id')) {
        		form_id = qsFields[qsField].form.getAttribute('real_id');
        	}
        	var qs_index_id = form_id + '_' + qsFields[qsField].name;

        	//Another safety check, if the sqs_objects entry is not defined, we can't do anything useful
        	if(typeof sqs_objects[qs_index_id] == 'undefined') {
        		qs_index_id = qsFields[qsField].name;
        		if(typeof sqs_objects[qs_index_id] == 'undefined') {
        	   		continue;
        	   	}
        	}
        	//Track if this field has already been processed.  The way the enableQS function is called
        	//is a bit problematic in that it lends itself to a lot of duplicate processing
        	if(QSProcessedFieldsArray[qs_index_id]) {
                skipSTR = 'collection_0';
                //the 'collection_0' id is not loaded dynamically, so the first item in the collection will not have an incremental value added to the base id
                //only skip the additional fields so that cases where a form is closed and reopened without refreshing the screen will still work
                if (qs_index_id.lastIndexOf(skipSTR) != (qs_index_id.length - skipSTR.length)){
        	        continue;
                }
        	}      	        	
        	
        	//Store sqs_objects entry as a reference for convenience
        	var qs_obj = sqs_objects[qs_index_id];
        	//The loaded variable will be used to check whether or not the quick search field should be created
            var loaded = false;   

            if (!document.forms[qs_obj.form]) {
        		continue;
        	}
            //Skip quicksearch fields that are readOnly or that are disabled since you can't search on them anyway
            if (!document.forms[qs_obj.form].elements[qsFields[qsField].id].readOnly && qs_obj['disable'] != true) {
            	var combo_id = qs_obj.form + '_' + qsFields[qsField].id;
            	if (Dom.get(combo_id + "_results")) {
            		loaded = true
            	}
                
                // if loaded == false, then we do the heavy lifting to re-create the quicksearch field
                if (!loaded) {
                	QSProcessedFieldsArray[qs_index_id] = true;
                	
                	qsFields[qsField].form_id = form_id;
                    
                    var sqs = sqs_objects[qs_index_id];    
                    
                    //Initialize the result div
                    var resultDiv = document.createElement('div');
                    resultDiv.id = combo_id + "_results";
                    Dom.insertAfter(resultDiv, qsFields[qsField]);
                    
                    //Add the module to the fields so we can read it from the response
                    var fields = qs_obj.field_list.slice();
                    fields[fields.length] = "module";
                    
                    //Create the DataSource for this QS
                    var ds = new YAHOO.util.DataSource("index.php?", {
        				responseType: YAHOO.util.XHRDataSource.TYPE_JSON,
                        responseSchema: {
                    		resultsList: 'fields',
        		            total: 'totalCount', 
        		            fields: fields,
        		            metaNode: "fields",
        		            metaFields: {total: 'totalCount', fields:"fields"}
        				},
        				connMethodPost: true
        		    });
                    
                    // Don't force selection for search fields
                    var forceSelect = !((qsFields[qsField].form && typeof(qsFields[qsField].form) == 'object' && qsFields[qsField].form.name == 'search_form')
							|| qsFields[qsField].className.match('sqsNoAutofill') !=  null);
                    
                    //Finally Declare the Autocomplete
                    var search = new YAHOO.widget.AutoComplete(qsFields[qsField], resultDiv, ds, {
                    	typeAhead: forceSelect,
                		forceSelection : forceSelect,
                    	fields: fields,
                    	sqs : sqs,
						animSpeed : 0.25,
                    	qs_obj: qs_obj,
                    	inputElement: qsFields[qsField],
                    	//YUI requires the data, even POST, to be URL encoded
                    	generateRequest : function(sQuery) {
                            //preprocess values
                            var item_id = this.inputElement.form_id + '_' + this.inputElement.name;
                            this.sqs = updateSqsFromQSFieldsArray(item_id, this.sqs);
                            if (QSCallbacksArray[item_id]) {
                                QSCallbacksArray[item_id](this.sqs);
                            }
	                    	var out = SUGAR.util.paramsToUrl({
	                    		to_pdf: 'true',
	                            module: 'Home',
	                            action: 'quicksearchQuery',
	                            data: YAHOO.lang.JSON.stringify(this.sqs),
	                            query: decodeURIComponent(sQuery)
	                    	});
	                    	return out;
	                    },
	                    //Method to fill in form fields with the returned results. 
	                    //Should be called on select, and must be called from the AC instance scope.
	                    setFields : function (data, filter) {
	                    	this.updateFields(data, filter);	
	                    },
	                    
	                    updateFields: function(data, filter) {
	                    	for(var i in this.fields) {		
	                    		for (var key in this.qs_obj.field_list) {
	                    		   //Check that the field exists and matches the filter
	                	           if (this.fields[i] == this.qs_obj.field_list[key] && 
	                	        	   document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]] &&
	                	        	   this.qs_obj.populate_list[key].match(filter)) {
	                	        	   //bug: 30823 - remove the apostrophe
	                	        	   var displayValue = data[i].replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"');
	                	        	   document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]].value = displayValue;
                                       SUGAR.util.callOnChangeListers(document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]]);
	                	           }
	                	       }
	                    	}
                            SUGAR.util.callOnChangeListers(this._elTextbox);
	                    },
	                    clearFields : function() {
	                    	for (var key in this.qs_obj.field_list) {
	                    	    if (document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]]){
                	        	    document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]].value = "";
                                    SUGAR.util.callOnChangeListers(document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]]);
                	            }
	                    	}
							this.oldValue = "";
	                    }
                    });

                    //C.L. Bug 36575: In event of account_name quicksearch, check to see if we need to warn user
                    //that address fields may change.  This code has similarities to code block in set_return method
                    //of sugar_3.js when building the alert message contents.
                    if(/^(billing_|shipping_)?account_name$/.exec(qsFields[qsField].name))
                    {
                      
                       //C.L. Bug 36106 only clear the name and id fields
                       search.clearFields = function() {
                           for(var i in {name:0, id:1}) {
	                    		for (var key in this.qs_obj.field_list) {
                                    //Check that the field exists
	                	           if (i == this.qs_obj.field_list[key] &&
	                	        	   document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]])
                                   {
                                       document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]].value = "";
                                   }
                                }
                           }
                       };
                    	
                       search.setFields = function(data, filter) 
                       {
                    	    var label_str = '';
	                		var label_data_str = '';
	                		var current_label_data_str = '';        		
	                		var label_data_hash = new Array();
	                    	
	                    	for(var i in this.fields) {
	                    		for (var key in this.qs_obj.field_list) {
	                    		   //Check that the field exists and matches the filter
	                	           if (this.fields[i] == this.qs_obj.field_list[key] && 
	                	        	   document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]] &&
	                	        	   document.getElementById(this.qs_obj.populate_list[key]+'_label') &&
	                	        	   this.qs_obj.populate_list[key].match(filter)) {
	                	        	   
	                	        	    var displayValue = data[i].replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"');
                                        var data_label =  document.getElementById(this.qs_obj.populate_list[key]+'_label').innerHTML.replace(/\n/gi,'').replace(/<\/?[^>]+(>|$)/g, "");
			        					
			        					label_and_data = data_label  + ' ' + displayValue;
			        					
			        					//Append to current_label_data_str only if the label and data are unique
			        					if(document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]] && !label_data_hash[data_label])
			        					{
			        						label_str += data_label + ' \n';
			        						label_data_str += label_and_data + '\n';
			        						label_data_hash[data_label] = true;
				        					current_label_data_str += data_label + ' ' + document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]].value + '\n';
			        					}			        					
	                	           }
	                	       }
	                    	}
	                    	
	        			    if(label_str != current_label_data_str && current_label_data_str != label_data_str) {    	
	        			    	
	        			    	module_key = (typeof document.forms[form_id].elements['module'] != 'undefined') ? document.forms[form_id].elements['module'].value : 'app_strings';
	        			    	warning_label = SUGAR.language.translate(module_key, 'NTC_OVERWRITE_ADDRESS_PHONE_CONFIRM') + '\n\n' + label_data_str;       			    	
	        			    		        			    	
	       			        	if(!confirm(warning_label))
	       						{
	       			        		this.updateFields(data,/account_id/); 
	       						} else {
	       							
	       							if(Dom.get('shipping_checkbox')) 
	       							{
	       							  if(this.inputElement.id == 'shipping_account_name')
	       							  {
	       								  //If the copy address checkbox is checked, update account and office_phone
	       							      filter = Dom.get('shipping_checkbox').checked ? /(account_id|office_phone)/ : filter;
	       							  } else if(this.inputElement.id == 'billing_account_name') {
	       								  //If the copy address is checked, update account, office phone and billing addresses
	       								  filter = Dom.get('shipping_checkbox').checked ? filter : /(account_id|office_phone|billing)/;
	       							  }
	       							} else if(Dom.get('alt_checkbox')) {
	       							  filter = Dom.get('alt_checkbox').checked ? filter : /^(?!alt)/;
	       							}
	       						
	       							this.updateFields(data,filter);
	       						}
	        			    } else {
		                        this.updateFields(data,filter); 	        			    	
	        			    }
                       };
                    }
                    
                    
                    if ( typeof(SUGAR.config.quicksearch_querydelay) != 'undefined' ) {
                        search.queryDelay = Number(SUGAR.config.quicksearch_querydelay);
                    }
                    
                    //fill in the data fields on selection
                    search.itemSelectEvent.subscribe(function(e, args){
                    	var data = args[2];
                    	var fields = this.fields;
                    	this.setFields(data, /\S/);
                        
                        //Handle special case where post_onblur_function is set    
                        if (typeof(this.qs_obj['post_onblur_function']) != 'undefined') {
                            collection_extended = new Array();
                            for (var i in fields) {
                                for (var key in this.qs_obj.field_list) {
                                    if (fields[i] == this.qs_obj.field_list[key]) {
                                        collection_extended[this.qs_obj.field_list[key]] = data[i];
                                    }
                                }
                            }
                            eval(this.qs_obj['post_onblur_function'] + '(collection_extended, this.qs_obj.id)');
                        }
                    });
                                        
					// We will get the old value firstly when the field lose focus.
                    search.textboxFocusEvent.subscribe(function(){
                    	this.oldValue = this.getInputEl().value;
                    });
                    
                    //If there is no change for this qucik search field , the value of it will not be cleared.
                    search.selectionEnforceEvent.subscribe(function(e, args){
	                    if (this.oldValue != args[1]) {
	                   		this.clearFields();
	                    } else {
	                    	this.getInputEl().value = this.oldValue;
	                    }
                    });
					
					search.dataReturnEvent.subscribe(function(e, args){
                        //Selected the first returned value if a tab was done before results were returned
						if (this.getInputEl().value.length == 0 && args[2].length > 0) {
							var data = [];
							for(var key in this.qs_obj.field_list) {
								data[data.length] = args[2][0][this.qs_obj.field_list[key]];
							}
							this.getInputEl().value = data[this.key];
							this.itemSelectEvent.fire(this, "", data);
						}
                    });

					search.typeAheadEvent.subscribe(function (e, args) {
						this.getInputEl().value = this.getInputEl().value.replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"');			
					});					
					
                    
                    if (typeof QSFieldsArray[combo_id] == 'undefined' && qsFields[qsField].id) {
                        QSFieldsArray[combo_id] = search;
                    }
                }
            }
        }
	});        
}

function registerSingleSmartInputListener(input) {
    if ((c = input.className) && (c.indexOf("sqsEnabled") != -1)) {
        enableQS(true);
    }
}

if(typeof QSFieldsArray == 'undefined') {
   QSFieldsArray = new Array();
   QSProcessedFieldsArray = new Array();
   QSCallbacksArray = new Array();
}
// Updates this.sqs of the Autocomplete instance with actual value from QSFieldsArray
function updateSqsFromQSFieldsArray(sqsId, sqsToUpdate)
{
    if (typeof(QSFieldsArray[sqsId]) != 'undefined' && sqsToUpdate != QSFieldsArray[sqsId].sqs)
    {
        return QSFieldsArray[sqsId].sqs;
    }
    else
    {
        return sqsToUpdate;
    }
}
