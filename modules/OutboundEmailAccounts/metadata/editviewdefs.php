<?php
$module_name = 'OutboundEmailAccounts';
$viewdefs [$module_name] =
    array(
        'EditView' =>
            array(
                'templateMeta' =>
                    array(
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
                                        //1 => 'assigned_user_name',
                                    ),
//        1 =>
//        array (
//          0 => 'description',
//        ),
                            ),
                        'lbl_editview_panel1' =>
                            array(
                                
                                array(
                                        'name' => 'smtp_from_name',
                                        'label' => 'LBL_SMTP_FROM_NAME',
                                    ),
                                
                                array(
                                        'name' => 'smtp_from_addr',
                                        'label' => 'LBL_SMTP_FROM_ADDR',
                                    ),
                                
                                array(
                                    'name' => 'email_provider_chooser',
                                    'label' => 'LBL_CHOOSE_EMAIL_PROVIDER',
                                ),

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

                                array(
                                    array(
                                        'name' => 'mail_smtpuser',
                                        'label' => 'LBL_USERNAME',
                                    ),
                                ),
                                array(
                                    array(
                                        'name' => 'password_change',
                                        'label' => 'LBL_PASSWORD',
                                    ),
                                ),
                                array(
                                    array(
                                        'name' => 'sent_test_email_btn',
                                        'label' => 'LBL_SEND_TEST_EMAIL',
                                    ),
                                ),
                            ),
                    ),
            ),
    );
