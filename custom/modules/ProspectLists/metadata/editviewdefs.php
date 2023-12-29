<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
// created: 2020-07-04 10:28:55
$viewdefs['ProspectLists']['EditView'] = array (
  'templateMeta' => 
  array (
    'form' => 
    array (
      'hidden' => 
      array (
        0 => '<input type="hidden" name="campaign_id" value="{$smarty.request.campaign_id}">',
      ),
    ),
    'maxColumns' => '2',
    'widths' => 
    array (
      0 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
      1 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
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
    'useTabs' => true,
    'tabDefs' => 
    array (
      'LBL_OVERVIEW_PANEL' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'lbl_overview_panel' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'name',
          'displayParams' => 
          array (
            'required' => true,
          ),
        ),
        1 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO_NAME',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'list_type',
          'displayParams' => 
          array (
            'required' => true,
            'javascript' => 'onchange="toggle_domain_name(this);"',
          ),
        ),
        1 => 
        array(
          'name' => 'domain_name',
          'customLabel' => '<div id="domain_label_div">{$MOD.LBL_DOMAIN}</div>',
          'customCode' =>  '<div id="domain_name_div"><input name="domain_name" id="domain_name" maxlength="255" type="text" value="{$fields.domain_name.value}"></div>',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'description',
        ),
      ),
    ),
  ),
);