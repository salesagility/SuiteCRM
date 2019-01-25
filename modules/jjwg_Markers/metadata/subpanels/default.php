<?php
$module_name='jjwg_Markers';
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
      'popup_module' => 'jjwg_Markers',
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
    'city' =>
    array(
      'type' => 'varchar',
      'vname' => 'LBL_CITY',
      'width' => '10%',
      'default' => true,
    ),
    'state' =>
    array(
      'type' => 'varchar',
      'vname' => 'LBL_STATE',
      'width' => '10%',
      'default' => true,
    ),
    'country' =>
    array(
      'type' => 'varchar',
      'vname' => 'LBL_COUNTRY',
      'width' => '10%',
      'default' => true,
    ),
    'marker_image' =>
    array(
      'type' => 'enum',
      'default' => true,
      'studio' => 'visible',
      'vname' => 'LBL_MARKER_IMAGE',
      'sortable' => false,
      'width' => '10%',
    ),
    'date_modified' =>
    array(
      'vname' => 'LBL_DATE_MODIFIED',
      'width' => '45%',
      'default' => true,
    ),
    'assigned_user_name' =>
    array(
      'link' => 'assigned_user_link',
      'type' => 'relate',
      'vname' => 'LBL_ASSIGNED_TO_NAME',
      'width' => '10%',
      'default' => true,
    ),
    'edit_button' =>
    array(
      'widget_class' => 'SubPanelEditButton',
      'module' => 'jjwg_Markers',
      'width' => '4%',
      'default' => true,
    ),
    'remove_button' =>
    array(
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'jjwg_Markers',
      'width' => '5%',
      'default' => true,
    ),
  ),
);
