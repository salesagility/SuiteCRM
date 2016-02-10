<?php
$popupMeta = array (
    'moduleMain' => 'OutboundEmailAccount',
    'varName' => 'OutboundEmailAccount',
    'orderBy' => 'outboundemailaccount.name',
    'whereClauses' => array (
  'username' => 'outboundemailaccount.username',
  'smtp_servername' => 'outboundemailaccount.smtp_servername',
),
    'searchInputs' => array (
  4 => 'username',
  5 => 'smtp_servername',
),
    'searchdefs' => array (
  'username' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_USERNAME',
    'width' => '10%',
    'name' => 'username',
  ),
  'smtp_servername' =>
  array (
    'type' => 'varchar',
    'label' => 'LBL_smtp_servername',
    'width' => '10%',
    'name' => 'smtp_servername',
  ),
),
    'listviewdefs' => array (
  'USERNAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_USERNAME',
    'width' => '10%',
    'default' => true,
  ),
  'smtp_servername' =>
  array (
    'type' => 'varchar',
    'label' => 'LBL_smtp_servername',
    'width' => '10%',
    'default' => true,
  ),
),
);
