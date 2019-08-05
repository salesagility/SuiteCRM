<?php
$module_name = 'TemplateSectionLine';
$viewdefs [$module_name] =
array(
  'EditView' =>
  array(
    'templateMeta' =>
    array(
      'maxColumns' => '1',
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
      'tabDefs' =>
      array(
        'DEFAULT' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' =>
    array(
      'default' =>
      array(
        0 =>
        array(
          0 => 'name',
        ),
        1 =>
          array(
            'name' => 'grp',
            'label' => 'LBL_GRP',
          ),
          2 => array(
              'name' => 'ord',
              'label' => 'LBL_ORD',
          ),
          3 =>
              array(
                  0 => 'description',
              ),
          4 =>
              array(
                  'name' => 'thumbnail',
                  'label' => 'LBL_THUMBNAIL',
              ),
      ),
    ),
  ),
);
