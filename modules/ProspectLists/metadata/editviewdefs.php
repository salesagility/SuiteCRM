<?php
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

$viewdefs['ProspectLists']['EditView'] = array(
    'templateMeta' => array('form'=>array('hidden'=>array('<input type="hidden" name="campaign_id" value="{$smarty.request.campaign_id}">')),
                            'maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30')
                                            ),
 'javascript' => '<script type="text/javascript">
function toggle_domain_name(list_type)  {ldelim} 
    domain_name = document.getElementById(\'domain_name_div\');
    domain_label = document.getElementById(\'domain_label_div\');
    if (list_type.value == \'exempt_domain\')  {ldelim} 
        domain_name.style.display=\'block\'; 
        domain_label.style.display=\'block\';
     {rdelim}  else  {ldelim} 
        domain_name.style.display=\'none\';
        domain_label.style.display=\'none\';
     {rdelim} 
 {rdelim} 
 
 SUGAR.util.doWhen(function(){ldelim}
     return  document.getElementById(\'list_type\').length > 0
 {rdelim}, function() {ldelim}
    var list_type_ele = document.getElementById(\'list_type\');
    toggle_domain_name(list_type_ele);
 {rdelim})
</script>',
),
 'panels' =>array(
  'default' =>
  array(
    
    array(
      array('name'=>'name', 'displayParams'=>array('required'=>true)),
      array('name'=>'list_type', 'displayParams'=>array('required'=>true, 'javascript'=>'onchange="toggle_domain_name(this);"')),
    ),
    array(
      array('name'=>'description'),
      array('name' => 'domain_name',
            'customLabel' => '<div id="domain_label_div">{$MOD.LBL_DOMAIN}</div>',
            'customCode' =>  '<div id="domain_name_div"><input name="domain_name" id="domain_name" maxlength="255" type="text" value="{$fields.domain_name.value}"></div>',),
    ),
    
  ),
  'LBL_PANEL_ASSIGNMENT' =>
      array(
        array(
          array(
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
        ),
      ),
)


);
