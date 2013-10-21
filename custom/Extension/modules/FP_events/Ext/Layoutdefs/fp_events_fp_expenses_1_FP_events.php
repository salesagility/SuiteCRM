<?php
 // created: 2013-03-25 09:19:52
$layout_defs["FP_events"]["subpanel_setup"]['fp_events_fp_expenses_1'] = array (
  'order' => 100,
  'module' => 'FP_expenses',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_FP_EVENTS_FP_EXPENSES_1_FROM_FP_EXPENSES_TITLE',
  'get_subpanel_data' => 'fp_events_fp_expenses_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
