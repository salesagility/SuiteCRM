<?php
$module_name='OutboundEmailAccounts';
$subpanel_layout = array (
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'popup_module' => 'OutboundEmailAccount',
    ),
  ),
  'where' => '',
  'list_fields' => 
  array (
    'name' => 
    array (
      'vname' => 'LBL_NAME',
      'widget_class' => 'SubPanelDetailViewLink',
      'width' => '45%',
      'default' => true,
    ),
//    'description' =>
//    array (
//      'type' => 'text',
//      'vname' => 'LBL_DESCRIPTION',
//      'sortable' => false,
//      'width' => '10%',
//      'default' => true,
//    ),
    'date_modified' => 
    array (
      'vname' => 'LBL_DATE_MODIFIED',
      'width' => '45%',
      'default' => true,
    ),
    'edit_button' => 
    array (
      'vname' => 'LBL_EDIT_BUTTON',
      'widget_class' => 'SubPanelEditButton',
      'module' => 'OutboundEmailAccount',
      'width' => '4%',
      'default' => true,
    ),
    'remove_button' => 
    array (
      'vname' => 'LBL_REMOVE',
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'OutboundEmailAccount',
      'width' => '5%',
      'default' => true,
    ),
    'mail_smtpuser' =>
    array (
      'type' => 'varchar',
      'vname' => 'LBL_USERNAME',
      'width' => '10%',
      'default' => true,
    ),
    'mail_smtpserver' =>
    array (
      'type' => 'varchar',
      'vname' => 'LBL_SMTP_SERVERNAME',
      'width' => '10%',
      'default' => true,
    ),
  ),
);