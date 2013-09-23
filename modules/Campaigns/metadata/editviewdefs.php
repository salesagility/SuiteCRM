<?php
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

$viewdefs['Campaigns']['EditView'] = array(
    'templateMeta' => array('maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30')
                                            ),
 'javascript' => '<script type="text/javascript" src="' . getJSPath('include/javascript/popup_parent_helper.js') . '"></script>
<script type="text/javascript">
function type_change() {ldelim}
	type = document.getElementsByName(\'campaign_type\');
	if(type[0].value==\'NewsLetter\') {ldelim}
		document.getElementById(\'freq_label\').style.display = \'\';
		document.getElementById(\'freq_field\').style.display = \'\';
	 {rdelim} else {ldelim}
		document.getElementById(\'freq_label\').style.display = \'none\';
		document.getElementById(\'freq_field\').style.display = \'none\';
	 {rdelim}
 {rdelim}
type_change();

function ConvertItems(id)  {ldelim}
	var items = new Array();

	//get the items that are to be converted
	expected_revenue = document.getElementById(\'expected_revenue\');
	budget = document.getElementById(\'budget\');
	actual_cost = document.getElementById(\'actual_cost\');
	expected_cost = document.getElementById(\'expected_cost\');

	//unformat the values of the items to be converted
	expected_revenue.value = unformatNumber(expected_revenue.value, num_grp_sep, dec_sep);
	expected_cost.value = unformatNumber(expected_cost.value, num_grp_sep, dec_sep);
	budget.value = unformatNumber(budget.value, num_grp_sep, dec_sep);
	actual_cost.value = unformatNumber(actual_cost.value, num_grp_sep, dec_sep);

	//add the items to an array
	items[items.length] = expected_revenue;
	items[items.length] = budget;
	items[items.length] = expected_cost;
	items[items.length] = actual_cost;

	//call function that will convert currency
	ConvertRate(id, items);

	//Add formatting back to items
	expected_revenue.value = formatNumber(expected_revenue.value, num_grp_sep, dec_sep);
	expected_cost.value = formatNumber(expected_cost.value, num_grp_sep, dec_sep);
	budget.value = formatNumber(budget.value, num_grp_sep, dec_sep);
	actual_cost.value = formatNumber(actual_cost.value, num_grp_sep, dec_sep);
 {rdelim}
</script>',
),
 'panels' =>array (
  'lbl_campaign_information' =>
  array (

    array (
      array('name'=>'name'),
      array('name' => 'status'),
    ),

    array (
       array('name'=>'start_date', 'displayParams'=>array('required'=>false, 'showFormats'=>true)),
       array('name'=>'campaign_type',
            'displayParams'=>array('javascript'=>'onchange="type_change();"'),
       ),
    ),

    array (
      array('name'=>'end_date', 'displayParams'=>array('showFormats'=>true)),
      array (
 		  'name' => 'frequency',
	      'customCode' => '<div style=\'none\' id=\'freq_field\'>{html_options name="frequency" options=$fields.frequency.options selected=$fields.frequency.value}</div></TD>',
	      'customLabel' => '<div style=\'none\' id=\'freq_label\'>{$MOD.LBL_CAMPAIGN_FREQUENCY}</div>',
	  ),
    ),

   array (
      'currency_id',
      'impressions',
    ),

    array (
        'budget',
    	'expected_cost',
    ),

    array (
    	'actual_cost',
        'expected_revenue',
    ),

    array (
      array('name'=>'objective','displayParams'=>array('rows'=>8,'cols'=>80)),
    ),

    array (
      array('name'=>'content','displayParams'=>array('rows'=>8, 'cols'=>80)),
    ),

  ),
  'LBL_PANEL_ASSIGNMENT' => array(
        array (
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
        ),  
  ),
)


);
?>