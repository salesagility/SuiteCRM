<?php
$module_name='AOS_Invoices';
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
      'popup_module' => 'AOS_Invoices',
    ),
  ),
  'where' => '',
  'list_fields' => 
  array (
    'number' => 
    array (
      'width' => '5%',
      'vname' => 'LBL_LIST_NUM',
      'default' => true,
    ),
    'name' => 
    array (
      'vname' => 'LBL_NAME',
      'widget_class' => 'SubPanelDetailViewLink',
      'width' => '25%',
      'default' => true,
    ),
    'billing_account' => 
    array (
      'width' => '20%',
      'vname' => 'LBL_BILLING_ACCOUNT',
      'default' => true,
    ),
    'total_amount' =>
    array (
      'type' => 'currency',
      'vname' => 'LBL_GRAND_TOTAL',
      'currency_format' => true,
      'width' => '15%',
      'default' => true,
    ),
    'status' => 
    array (
      'width' => '15%',
      'vname' => 'LBL_STATUS',
      'default' => true,
    ),
    'assigned_user_name' => 
    array (
      'name' => 'assigned_user_name',
      'vname' => 'LBL_ASSIGNED_USER',
      'width' => '15%',
      'default' => true,
    ),
    'currency_id'=>array(
      'usage'=>'query_only',
    ),
    'edit_button' => 
    array (
      'widget_class' => 'SubPanelEditButton',
      'module' => 'AOS_Invoices',
      'width' => '4%',
      'default' => true,
    ),
    'remove_button' => 
    array (
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'AOS_Invoices',
      'width' => '5%',
      'default' => true,
    ),
  ),
);
