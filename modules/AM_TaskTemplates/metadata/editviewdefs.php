<?php
$module_name = 'AM_TaskTemplates';
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
            'name' => 'duration',
            'label' => 'LBL_DURATION',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'priority',
            'studio' => 'visible',
            'label' => 'LBL_PRIORITY',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'percent_complete',
            'label' => 'LBL_PERCENT_COMPLETE',
          ),
          1 => 
          array (
            'name' => 'predecessors',
            'label' => 'LBL_PREDECESSORS',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'milestone_flag',
            'label' => 'LBL_MILESTONE_FLAG',
          ),
          1 => 
          array (
            'name' => 'relationship_type',
            'studio' => 'visible',
            'label' => 'LBL_RELATIONSHIP_TYPE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'task_number',
            'label' => 'LBL_TASK_NUMBER',
          ),
          1 => 
          array (
            'name' => 'order_number',
            'label' => 'LBL_ORDER_NUMBER',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'estimated_effort',
            'label' => 'LBL_ESTIMATED_EFFORT',
          ),
          1 => 
          array (
            'name' => 'utilization',
            'studio' => 'visible',
            'label' => 'LBL_UTILIZATION',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'am_tasktemplates_am_projecttemplates_name',
          ),
          1 => 'assigned_user_name',
        ),
        7 => 
        array (
          0 => 'description',
        ),
      ),
    ),
  ),
);
?>
