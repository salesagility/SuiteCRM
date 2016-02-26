<?php
$module_name = 'OutboundEmailAccounts';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'mail_smtpuser' =>
      array (
        'type' => 'varchar',
        'label' => 'LBL_USERNAME',
        'width' => '10%',
        'default' => true,
        'name' => 'mail_smtpuser',
      ),
      'mail_smtpserver' =>
      array (
        'type' => 'varchar',
        'label' => 'LBL_SMTP_SERVERNAME',
        'width' => '10%',
        'default' => true,
        'name' => 'mail_smtpserver',
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'mail_smtpuser' =>
      array (
        'type' => 'varchar',
        'label' => 'LBL_USERNAME',
        'width' => '10%',
        'default' => true,
        'name' => 'mail_smtpuser',
      ),
      'mail_smtpserver' =>
      array (
        'type' => 'varchar',
        'label' => 'LBL_SMTP_SERVERNAME',
        'width' => '10%',
        'default' => true,
        'name' => 'mail_smtpserver',
      ),
//      'description' =>
//      array (
//        'type' => 'text',
//        'label' => 'LBL_DESCRIPTION',
//        'sortable' => false,
//        'width' => '10%',
//        'default' => true,
//        'name' => 'description',
//      ),
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'default' => true,
        'width' => '10%',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>
