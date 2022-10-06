<?php
$module_name = 'OutboundEmailAccounts';
$listViewDefs [$module_name] =
array(
  'NAME' =>
  array(
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'MAIL_SMTPUSER' =>
  array(
    'type' => 'varchar',
    'label' => 'LBL_USERNAME',
    'width' => '10%',
    'default' => true,
  ),
  'MAIL_SMTPSERVER' =>
  array(
    'type' => 'varchar',
    'label' => 'LBL_SMTP_SERVERNAME',
    'width' => '10%',
    'default' => true,
  ),
);
