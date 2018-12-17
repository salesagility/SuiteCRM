{*
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

/**

 */
*}

	<input type="hidden" id="existing_tracker_count" name="existing_tracker_count" value="{$TRACKER_COUNT}">
	<input type="hidden" id="added_tracker_count" name="added_tracker_count" value=''>
	<input type="hidden" id="wiz_list_of_existing_trackers" name="wiz_list_of_existing_trackers" value="">
	<input type="hidden" id="wiz_list_of_trackers" name="wiz_list_of_trackers" value="">
	<input type="hidden" id="wiz_remove_tracker_list" name="wiz_remove_tracker_list" value="">


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<th colspan="4" align="left" ><h4 class="header-4">{$MOD.LBL_WIZ_NEWSLETTER_TITLE_STEP3}</h4></th>
		</tr>
		<tr><td class="datalabel" colspan="3">{$MOD.LBL_WIZARD_TRACKER_MESSAGE}<br></td><td>&nbsp;</td></tr>
		<tr><td class="datalabel" colspan="4">&nbsp;</td></tr>

	</table>
	<div id='tracker_input_div'>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width="15%" scope="row"><span>{$MOD.LBL_EDIT_TRACKER_NAME}<span class="required">&nbsp;</span></span></td>
		<td width="25%" ><span><input id="tracker_name" type="text" size="30" name="tracker_name" title="{$MOD.LBL_EDIT_TRACKER_NAME}" value="{$TRACKER_NAME}"></span></td>
		<td width="25%" scope="row"><span><input onclick="toggle_tracker_url(this);" name="is_optout" title="{$MOD.LBL_EDIT_OPT_OUT}" id="is_optout"  class="checkbox" type="checkbox" />&nbsp;{$MOD.LBL_EDIT_OPT_OUT_}</span></td>
	    <td width="35%" ><span>&nbsp;</span></td>
		</tr>
		<tr>
		<td scope="row"><span>{$MOD.LBL_EDIT_TRACKER_URL}&nbsp;<span class="required"></span></span></td>
		<td  colspan=3><span><input type="text" size="80" maxlength='255' {$TRACKER_URL_DISABLED} name="tracker_url" title="{$MOD.LBL_EDIT_TRACKER_URL}" id="tracker_url" value="http://"></span> <input type='button' value ='{$MOD.LBL_ADD_TRACKER}' class= 'button' onclick='javascript:add_tracker();'></td>
		</tr>
		<tr><td colspan='4'>&nbsp;</td></tr>
		</table>
	</div>
	<table width='100%' border="0" cellspacing="0" cellpadding="0">
		<tr><td>{$MOD.LBL_TRACKERS_ADDED}</td></tr>
		<tr><td class='list view'>

			<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr >
			    <th width='15%' scope="col" nowrap>{$MOD.LBL_EDIT_OPT_OUT}</th>
				<th width='40%' scope="col">{$MOD.LBL_EDIT_TRACKER_NAME}</th>
			    <th width='45%' scope="col" colspan="2">{$MOD.LBL_EDIT_TRACKER_URL}</th>
		    </tr>
			</table>
			<div id='added_trackers'>
				{$EXISTING_TRACKERS}
			</div>


		</td></tr>
	</table>
	<p>
		<script>
		var image_path = '{$IMAGE_PATH}';
		{literal}
			//this function toggles the tracker values based on whether the opt out check box is selected
			function toggle_tracker_url(isoptout) {
				tracker_url = document.getElementById('tracker_url');
				if (isoptout.checked) {
					tracker_url.disabled=true;
					tracker_url.value="index.php?entryPoint=removeme";
				} else {
					tracker_url.disabled=false;
				}
			}

			//create variables that will be used to monitor the number of tracker url
			var trackers_added = 0;
			//variable that will be passed back to server to specify list of trackers
			var list_of_trackers_array = new Array();

			//this function adds selected tracker to list
			function add_tracker(){
				//perform validation
				if(validate_step3()){
				//increment tracker count value
					trackers_added++;
					document.getElementById('added_tracker_count').value = trackers_added ;
					//get the appropriate values from tracker form
					var trkr_name = document.getElementById('tracker_name');
					var trkr_url = document.getElementById('tracker_url');
					var trkr_opt = document.getElementById('is_optout');
					var trkr_opt_checked = '';
					if(trkr_opt.checked){trkr_opt_checked = 'checked';	}
			{/literal}
					//construct html to display chosen tracker
					var trkr_name_html = "<input id='tracker_name"+trackers_added +"' type='text' size='20' maxlength='255' name='wiz_step3_tracker_name"+trackers_added+"' title='{$MOD.LBL_EDIT_TRACKER_NAME}"+trackers_added+"' value='"+trkr_name.value+"' >";
					var trkr_url_html = "<input type='text' size='60' maxlength='255' name='wiz_step3_tracker_url"+trackers_added+"' title='{$MOD.LBL_EDIT_TRACKER_URL}"+trackers_added+"' id='tracker_url"+trackers_added+"' value='"+trkr_url.value+"' >";
					var trkr_opt_html = "<input name='wiz_step3_is_optout"+trackers_added+"' title='{$MOD.LBL_EDIT_OPT_OUT}"+trackers_added+"' id='is_optout"+trackers_added+"' class='checkbox' type='checkbox' "+trkr_opt_checked+" />";
					//display the html
                    {capture assign='alt_remove' }{sugar_translate label='LBL_DELETE' module='CAMPAIGNS'}{/capture}
					var trkr_html = "<div id='trkr_added_"+trackers_added+"'> <table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='evenListRowS1'><td width='15%'>"+trkr_opt_html+"</td><td width='40%'>"+trkr_name_html+"</td><td width='40%'>"+trkr_url_html+"</td><td><a href='#' onclick=\"javascript:remove_tracker('trkr_added_"+trackers_added+"','"+trackers_added+"'); \" >  "+'{sugar_getimage name="delete_inline" ext=".gif" width="12" height="12" alt=$alt_remove other_attributes='align="absmiddle" border="0" '}'+"{$MOD.LBL_REMOVE}</a></td></tr></table></div>";
					document.getElementById('added_trackers').innerHTML = document.getElementById('added_trackers').innerHTML + trkr_html;

					//add values to array in string, separated by "@@" characters
					list_of_trackers_array[trackers_added] = trkr_name.value+"@@"+trkr_opt.checked+"@@"+trkr_url.value;
					//assign array to hidden input, which will be used by server to process array of trackers
					document.getElementById('wiz_list_of_trackers').value = list_of_trackers_array.toString();

					//now lets clear the form to allow input of new tracker
					trkr_name.value = '';
					trkr_url.disabled = false;
					trkr_url.value = 'http://';
					trkr_opt.checked = false;
					{literal}
					if(trackers_added ==1){
						document.getElementById('no_trackers').style.display='none';
					}
				}
			}

			//this function will remove the selected tracker from the ui, and from the tracker array
			function remove_tracker(div,num){
					//clear UI
					var trkr_div = document.getElementById(div);
					trkr_div.style.display = 'none';
					trkr_div.parentNode.removeChild(trkr_div);
					//clear tracker array from this entry and assign to form input
					list_of_trackers_array[num] = '';
					document.getElementById('wiz_list_of_trackers').value = list_of_trackers_array.toString();
			}

			//this function will remove the existing tracker from the ui, and add it's value to an array for removal upon save
			function remove_existing_tracker(div,id){
					//clear UI
					var trkr_div = document.getElementById(div);
					trkr_div.style.display = 'none';
					trkr_div.parentNode.removeChild(trkr_div);
					//assign this id to form input for removal
					document.getElementById('wiz_remove_tracker_list').value += ','+id;
			}

			/**
			*This function will iterate through list of trackers and gather all the values.  It will
			*populate these values, separated by delimiters into hidden inputs for processing
			*/
			function gatherTrackers(){
				//start with the newly added trackers, get count of total added
				count = parseInt(trackers_added);
				final_list_of_trackers_array = new Array();
				//iterate through list of added trackers
				for(i=1;i<=count;i++){
					//make sure all values exist
					if( document.getElementById('tracker_name'+i)  &&  document.getElementById('is_optout'+i)  &&  document.getElementById('tracker_url'+i) ){
						//make sure the check box value is int (0/1)
						var opt_val = '0';
						if(document.getElementById('is_optout'+i).checked){opt_val =1;}
						//add values for this tracker entry into array of tracker entries
						final_list_of_trackers_array[i] = document.getElementById('tracker_name'+i).value+"@@"+opt_val+"@@"+document.getElementById('tracker_url'+i).value;
					}
				}
				//assign array of tracker entries to hidden input, which will be used by server to process array of trackers
				document.getElementById('wiz_list_of_trackers').value = final_list_of_trackers_array.toString();

				//Now lets process existing trackers, get count of existing trackers
				count = parseInt(document.getElementById('existing_tracker_count').value);
				final_list_of_existing_trackers_array = new Array();
				//iterate through list of existing trackers
				for(i=0;i<count;i++){
					//make sure all values exist
					if( document.getElementById('existing_tracker_name'+i)  &&  document.getElementById('existing_is_optout'+i)  &&  document.getElementById('existing_tracker_url'+i) ){
						//make sure the check box value is int (0/1)
						var opt_val = '0';
						if(document.getElementById('existing_is_optout'+i).checked){opt_val =1;}
						//add values for this tracker entry into array of tracker entries
						final_list_of_existing_trackers_array[i] = document.getElementById('existing_tracker_id'+i).value+"@@"+document.getElementById('existing_tracker_name'+i).value+"@@"+opt_val+"@@"+document.getElementById('existing_tracker_url'+i).value;
					}
				}
				//assign array of tracker entries to hidden input, which will be used by server to process array of trackers
				document.getElementById('wiz_list_of_existing_trackers').value = final_list_of_existing_trackers_array.toString();


			}


	   /*
	     * this is the custom validation script that will validate the fields on step3 of wizard
	     * this is called directly from the add tracker button
	     */

	    function validate_step3(){

	        requiredTxt = SUGAR.language.get('app_strings', 'ERR_MISSING_REQUIRED_FIELDS');
	        var stepname = 'wiz_step3_';
	        var has_error = 0;
	        var fields = new Array();
	        fields[0] = 'tracker_name';
	        fields[1] = 'tracker_url';
	        //loop through and check for empty strings ('  ')
	        var field_value = '';

	        if(
		        (trim(document.getElementById(fields[0]).value) !='')
		        ||  ((trim(document.getElementById(fields[1]).value) !='')
			        &&  (trim(document.getElementById(fields[1]).value) !='http://'))
	        ){
	            for (i=0; i < fields.length; i++){
	                field_value = trim(document.getElementById(fields[i]).value);
	                if(field_value.length<1 || field_value == 'http://'){
	                  add_error_style('wizform', fields[i], requiredTxt +' ' +document.getElementById(fields[i]).title );
	                  has_error = 1;
	                }
	            }
	        }else{
	            //no values have been entered, return false without error
	            return false;
	        }
	        //error has been thrown, return false
	        if(has_error == 1){
	            return false;
	        }

	        //add fields to validation and call generic validation script
	        if(validate['wizform']!='undefined'){delete validate['wizform']};
	        addToValidate('wizform', 'tracker_name', 'alphanumeric', false,  document.getElementById('tracker_name').title);
	        addToValidate('wizform', 'tracker_url', 'alphanumeric', false,  document.getElementById('tracker_url').title);
	        return check_form('wizform');

	    }
			</script>
			{/literal}
