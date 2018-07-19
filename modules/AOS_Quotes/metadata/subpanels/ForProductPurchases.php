<?php
$module_name='AOS_Quotes';
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
      'popup_module' => 'AOS_Quotes',
    ),
  ),
  'where' => '',
  'list_fields' =>
  array(
    'number' =>
    array(
      'width' => '5%',
      'vname' => 'LBL_LIST_NUM',
      'default' => true,
    ),
    'name' =>
    array(
      'vname' => 'LBL_NAME',
      'widget_class' => 'SubPanelDetailViewLink',
      'width' => '25%',
      'default' => true,
    ),
    'billing_account' =>
    array(
      'width' => '20%',
      'vname' => 'LBL_BILLING_ACCOUNT',
      'default' => true,
    ),
    'total_amount' =>
    array(
      'type' => 'currency',
      'width' => '15%',
      'currency_format' => true,
      'vname' => 'LBL_GRAND_TOTAL',
      'default' => true,
    ),
    'expiration' =>
    array(
      'width' => '15%',
      'vname' => 'LBL_EXPIRATION',
      'default' => true,
    ),
    'assigned_user_name' =>
    array(
      'link' => 'assigned_user_link',
      'type' => 'relate',
      'vname' => 'LBL_ASSIGNED_USER',
      'width' => '15%',
      'default' => true,
    ),
    'currency_id'=>array(
      'usage'=>'query_only',
    ),
    'edit_button' =>
    array(
      'widget_class' => 'SubPanelEditButton',
      'module' => 'AOS_Quotes',
      'width' => '4%',
      'default' => true,
    ),
  ),
);
