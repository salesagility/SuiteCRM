<?php
 // created: 2013-04-25 10:18:48
$layout_defs["FP_Event_Locations"]["subpanel_setup"]['fp_event_locations_fp_events_1'] = array (
  'order' => 100,
  'module' => 'FP_events',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_FP_EVENT_LOCATIONS_FP_EVENTS_1_FROM_FP_EVENTS_TITLE',
  'get_subpanel_data' => 'fp_event_locations_fp_events_1',
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
