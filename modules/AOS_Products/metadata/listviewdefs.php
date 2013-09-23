<?php
$listViewDefs ['AOS_Products'] = 
array (
  'NAME' => 
  array (
    'width' => '25%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'PART_NUMBER' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PART_NUMBER',
    'default' => true,
  ),
  'COST' => 
  array (
    'width' => '10%',
    'label' => 'LBL_COST',
    'currency_format' => true,
    'default' => true,
  ),
  'PRICE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRICE',
    'currency_format' => true,
    'default' => true,
  ),
  'CREATED_BY_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_CREATED',
    'default' => true,
    'module' => 'Users',
    'link' => true,
    'id' => 'CREATED_BY',
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '5%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
  ),
);
?>
