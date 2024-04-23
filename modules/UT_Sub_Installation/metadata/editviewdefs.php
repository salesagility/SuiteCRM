<?php
$module_name = 'UT_Sub_Installation';
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
          1 => 
          array (
            'name' => 'serial_number',
            'label' => 'LBL_SERIAL_NUMBER',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'product',
            'studio' => 'visible',
            'label' => 'LBL_PRODUCT',
          ),
          1 => 
          array (
            'name' => 'product_type',
            'studio' => 'visible',
            'label' => 'LBL_PRODUCT_TYPE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'supplier',
            'studio' => 'visible',
            'label' => 'LBL_SUPPLIER',
          ),
          1 => '',
        ),
        3 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'ut_sub_installation_ut_installation_name',
          ),
        ),
      ),
    ),
  ),
);
;
?>
