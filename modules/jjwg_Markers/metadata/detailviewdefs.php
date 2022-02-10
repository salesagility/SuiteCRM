<?php
$module_name = 'jjwg_Markers';
$viewdefs [$module_name] =
array(
  'DetailView' =>
  array(
    'templateMeta' =>
    array(
      'form' =>
      array(
        'buttons' =>
        array(
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
        ),
        // Csutom
        'footerTpl' => 'modules/jjwg_Markers/tpls/DetailViewFooter.tpl',
      ),
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
          0 => 'name',
          1 => 'assigned_user_name',
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
          1 =>
          array(
            'name' => 'marker_image',
            'studio' => 'visible',
            'label' => 'LBL_MARKER_IMAGE',
          ),
        ),
        3 =>
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
        4 =>
        array(
          0 =>
          array(
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
          1 =>
          array(
            'name' => 'date_modified',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
            'label' => 'LBL_DATE_MODIFIED',
          ),
        ),
        5 =>
        array(
          0 => 'description',
        ),
      ),
    ),
  ),
);
