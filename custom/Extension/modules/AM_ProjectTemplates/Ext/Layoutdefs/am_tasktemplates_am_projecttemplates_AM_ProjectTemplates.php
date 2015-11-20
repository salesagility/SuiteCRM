<?php
 // created: 2014-05-30 00:06:35
$layout_defs["AM_ProjectTemplates"]["subpanel_setup"]['am_tasktemplates_am_projecttemplates'] = array (
  'order' => 100,
  'module' => 'AM_TaskTemplates',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_TASKTEMPLATES_TITLE',
  'get_subpanel_data' => 'am_tasktemplates_am_projecttemplates',
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
