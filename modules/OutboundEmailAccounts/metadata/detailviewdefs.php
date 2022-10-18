<?php
$viewdefs ['OutboundEmailAccounts'] =
array(
  'DetailView' =>
  array(
    'templateMeta' =>
    array(
      'form' =>
      array(
        'buttons' =>
        array(
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
        ),
      ),
      'maxColumns' => '2',
      'widths' =>
      array(
        0 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
        1 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' =>
      array(
        'DEFAULT' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' =>
    array(
      'default' =>
      array(
        0 =>
        array(
          0 => 'name',
        ),
      ),
      'lbl_editview_panel1' =>
      array(
        0 =>
        array(
          0 =>
          array(
            'name' => 'mail_smtpuser',
            'label' => 'LBL_USERNAME',
          ),
        ),
        1 =>
        array(
          0 =>
          array(
            'name' => 'mail_smtpserver',
            'label' => 'LBL_SMTP_SERVERNAME',
          ),
          1 =>
          array(
            'name' => 'mail_smtpport',
            'label' => 'LBL_SMTP_PORT',
          ),
        ),
        2 =>
        array(
          0 =>
          array(
            'name' => 'mail_smtpauth_req',
            'label' => 'LBL_SMTP_AUTH',
          ),
          1 =>
          array(
            'name' => 'mail_smtpssl',
            'studio' => 'visible',
            'label' => 'LBL_SMTP_PROTOCOL',
          ),
        ),
      ),
    ),
  ),
);
