<?php
$dashletData['OutboundEmailAccountsDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'date_modified' => 
  array (
    'default' => '',
  ),
  'assigned_user_id' => 
  array (
    'default' => '',
  ),
  'mail_smtpuser' =>
  array (
    'default' => '',
  ),
  'mail_smtpserver' =>
  array (
    'default' => '',
  ),
);
$dashletData['OutboundEmailAccountsDashlet']['columns'] = array (
  'name' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
    'name' => 'date_entered',
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
//  'assigned_user_name' =>
//  array (
//    'width' => '8%',
//    'label' => 'LBL_LIST_ASSIGNED_USER',
//    'name' => 'assigned_user_name',
//    'default' => false,
//  ),
  'mail_smtpuser' =>
  array (
    'type' => 'varchar',
    'label' => 'LBL_USERNAME',
    'width' => '10%',
    'default' => false,
  ),
  'mail_smtpserver' =>
  array (
    'type' => 'varchar',
    'label' => 'LBL_SMTP_SERVERNAME',
    'width' => '10%',
    'default' => false,
  ),
);
