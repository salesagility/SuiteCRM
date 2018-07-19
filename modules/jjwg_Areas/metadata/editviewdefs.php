<?php
$module_name = 'jjwg_Areas';
$viewdefs [$module_name] =
array(
  'EditView' =>
  array(
    'templateMeta' =>
    array(
      'maxColumns' => '2',
      'widths' =>
      array(
        0 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
        1 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      // Csutom
      'form' => array('footerTpl'=>'modules/jjwg_Areas/tpls/EditViewFooter.tpl'),
    ),
    'panels' =>
    array(
      'default' =>
      array(
        0 =>
        array(
          0 =>
          array(
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 =>
          array(
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
        ),
        1 =>
        array(
          0 =>
          array(
            'name' => 'city',
            'label' => 'LBL_CITY',
          ),
          1 =>
          array(
            'name' => 'state',
            'label' => 'LBL_STATE',
          ),
        ),
        2 =>
        array(
          0 =>
          array(
            'name' => 'country',
            'label' => 'LBL_COUNTRY',
          ),
          1 => '',
        ),
        3 =>
        array(
          0 =>
          array(
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
        4 =>
        array(
          0 =>
          array(
            'name' => 'coordinates',
            'studio' => 'visible',
            'label' => 'LBL_COORDINATES',
          ),
        ),
      ),
    ),
  ),
);
