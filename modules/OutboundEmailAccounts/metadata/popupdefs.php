<?php
$popupMeta = array(
    'moduleMain' => 'OutboundEmailAccount',
    'varName' => 'OutboundEmailAccount',
    'orderBy' => 'outboundemailaccount.name',
    'whereClauses' => array(
  'mail_smtpuser' => 'outbound_email.mail_smtpuser',
  'mail_smtpserver' => 'outbound_email.mail_smtpserver',
),
    'searchInputs' => array(
  4 => 'mail_smtpuser',
  5 => 'mail_smtpserver',
),
    'searchdefs' => array(
  'mail_smtpuser' =>
  array(
    'type' => 'varchar',
    'label' => 'LBL_USERNAME',
    'width' => '10%',
    'name' => 'mail_smtpuser',
  ),
  'mail_smtpserver' =>
  array(
    'type' => 'varchar',
    'label' => 'LBL_SMTP_SERVERNAME',
    'width' => '10%',
    'name' => 'mail_smtpserver',
  ),
),
    'listviewdefs' => array(
  'mail_smtpuser' =>
  array(
    'type' => 'varchar',
    'label' => 'LBL_USERNAME',
    'width' => '10%',
    'default' => true,
  ),
  'mail_smtpserver' =>
  array(
    'type' => 'varchar',
    'label' => 'LBL_SMTP_SERVERNAME',
    'width' => '10%',
    'default' => true,
  ),
),
);
