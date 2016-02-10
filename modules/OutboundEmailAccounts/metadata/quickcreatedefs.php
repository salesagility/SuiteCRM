<?php
$module_name = 'OutboundEmailAccounts';
$viewdefs [$module_name] = 
array (
  'QuickCreate' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'assigned_user_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'username',
            'label' => 'LBL_USERNAME',
          ),
          1 => 
          array (
            'name' => 'password',
            'label' => 'LBL_PASSWORD',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'smtp_servername',
            'label' => 'LBL_smtp_servername',
          ),
          1 => 
          array (
            'name' => 'smtp_port',
            'label' => 'LBL_SMTP_PORT',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'smtp_auth',
            'label' => 'LBL_SMTP_AUTH',
          ),
          1 => 
          array (
            'name' => 'smtp_protocol',
            'studio' => 'visible',
            'label' => 'LBL_SMTP_PROTOCOL',
          ),
        ),
      ),
    ),
  ),
);
?>
