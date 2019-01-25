<?php
$module_name='jjwg_Maps';
$subpanel_layout = array(
  'top_buttons' =>
  array(
    0 =>
    array(
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 =>
    array(
      'widget_class' => 'SubPanelTopSelectButton',
      'popup_module' => 'jjwg_Maps',
    ),
  ),
  'where' => '',
  'list_fields' =>
  array(
    'name' =>
    array(
      'vname' => 'LBL_NAME',
      'widget_class' => 'SubPanelDetailViewLink',
      'width' => '45%',
      'default' => true,
    ),
    'module_type' =>
    array(
      'type' => 'enum',
      'default' => true,
      'studio' => 'visible',
      'vname' => 'LBL_MODULE_TYPE',
      'sortable' => false,
      'width' => '10%',
    ),
    'date_modified' =>
    array(
      'vname' => 'LBL_DATE_MODIFIED',
      'width' => '45%',
      'default' => true,
    ),
    'edit_button' =>
    array(
      'widget_class' => 'SubPanelEditButton',
      'module' => 'jjwg_Maps',
      'width' => '4%',
      'default' => true,
    ),
    'remove_button' =>
    array(
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'jjwg_Maps',
      'width' => '5%',
      'default' => true,
    ),
  ),
);
