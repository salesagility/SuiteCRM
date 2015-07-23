<?php
$module_name = 'AM_ProjectHolidays';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
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
        'includes' =>
            array (
                0 =>
                    array (
                        'file' => 'modules/AM_ProjectHolidays/showResources.js', //call for the js file
                    ),
            ),
        'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => '',
        ),
          1 =>
              array (
                  0 => 'holiday_start_date',
              ),
          2 =>
              array (
                  0 => 'holiday_end_date',
              ),
        3 =>
        array (
          0 => 'description',
        ),
        4 =>
        array (
          0 => 
          array (
            'name' => 'resourse_users',
            'studio' => 'visible',
            'label' => 'LBL_RESOURSE_USERS',
              'customCode' => '<select name="resourse_users" id="resourse_users" onChange="showResources(this)">' .
                  '<option>Select Resource Type</option>'.
                  '<option value="User">{$MOD.LBL_USER}</option>' .
                  '<option value="Contact">{$MOD.LBL_CONTACT}</option>' .
                  '</select>' .
                  '<span id="resource_selector">
                       <select style="visibility: hidden;" onChange="showResourcesName()" name="resourse_select" id="resourse_select"></select>
                  </span>',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
?>
