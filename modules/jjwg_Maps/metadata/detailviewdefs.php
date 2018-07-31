<?php
$module_name = 'jjwg_Maps';

$viewdefs[$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
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
      'useTabs' => false,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'assigned_user_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'parent_name',
            'studio' => 'visible',
            'label' => 'LBL_FLEX_RELATE',
          ),
          1 => 
          array (
            'name' => 'unit_type',
            'studio' => 'visible',
            'label' => 'LBL_UNIT_TYPE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'module_type',
            'studio' => 'visible',
            'label' => 'LBL_MODULE_TYPE',
          ),
          1 => 
          array (
            'name' => 'distance',
            'label' => 'LBL_DISTANCE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
          1 => 
          array (
            'name' => 'date_modified',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
            'label' => 'LBL_DATE_MODIFIED',
          ),
        ),
        4 => 
        array (
          0 => 'description',
        ),
        5 => 
        array (
          0 => 
          array (
          'name' => 'custom_map_display',
          'type' => 'url',
          'label' => 'LBL_MAP_DISPLAY',
          'width' => '10%',
          'sortable' => false,
          'link' => true,
          'default' => true,
          'related_fields' => 
          array (
            0 => 'parent_type',
            1 => 'module_type',
            2 => 'id',
          ),
          'customCode' => '<a href="index.php?module='.$module_name.'&action=map_display'.
                  '&relate_module={$fields.parent_type.value}&display_module={$fields.module_type.value}'.
                  '&record={$fields.id.value}" >'.$GLOBALS['app_strings']['LBL_MAP'].'</a>',
        ),
      ),
        
      ),
    ),
  ),
);
