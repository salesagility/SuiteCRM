<?php
$module_name = 'jjwg_Markers';
$viewdefs [$module_name] =
array(
  'QuickCreate' =>
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
            'name' => 'jjwg_maps_lat',
            'label' => 'LBL_JJWG_MAPS_LAT',
          ),
          1 =>
          array(
            'name' => 'jjwg_maps_lng',
            'label' => 'LBL_JJWG_MAPS_LNG',
          ),
        ),
        2 =>
        array(
          0 => '',
          1 =>
          array(
            'name' => 'marker_image',
            'studio' => 'visible',
            'label' => 'LBL_MARKER_IMAGE',
          ),
        ),
      ),
    ),
  ),
);
