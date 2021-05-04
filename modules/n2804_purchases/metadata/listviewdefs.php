<?php
$module_name = 'n2804_purchases';
$listViewDefs [$module_name] = 
array (
  'QUANTITY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_QUANTITY',
    'width' => '10%',
    'default' => true,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
  ),
  'TOTAL_COST_GBP' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_TOTAL_COST_GBP',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'DATE_OF_PURCHASE' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_DATE_OF_PURCHASE',
    'width' => '10%',
    'default' => false,
  ),
  'TOTAL_COST_EUR' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_TOTAL_COST_EUR',
    'currency_format' => true,
    'width' => '10%',
    'default' => false,
  ),
  'TOTAL_COST_USD' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_TOTAL_COST_USD',
    'currency_format' => true,
    'width' => '10%',
    'default' => false,
  ),
  'TOTAL_COST_AUD' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_TOTAL_COST_AUD',
    'currency_format' => true,
    'width' => '10%',
    'default' => false,
  ),
  'TOTAL_COST_NZD' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_TOTAL_COST_NZD',
    'currency_format' => true,
    'width' => '10%',
    'default' => false,
  ),
);
;
?>
