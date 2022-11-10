<?php
$viewdefs ['OutboundEmailAccounts'] = [
    'EditView' => [
        'templateMeta' => [
            'maxColumns' => '2',
            'widths' => [
                [
                    'label' => '10',
                    'field' => '30',
                ],
                [
                    'label' => '10',
                    'field' => '30',
                ],
            ],
            'useTabs' => false,
            'tabDefs' => [
                'DEFAULT' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_CONNECTION_CONFIGURATION' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_OUTBOUND_CONFIGURATION' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
            'form' => [
                'hidden' => [
                ],
            ],
            'javascript' => '
                <script type="text/javascript">
                    {suite_combinescripts
                        files="modules/OutboundEmailAccounts/js/fields.js,
                               modules/OutboundEmailAccounts/js/ssl_port_set.js,
                               modules/OutboundEmailAccounts/js/smtp_auth_toggle.js"}
                </script>
            ',
        ],
        'panels' => [
            'default' => [
                [
                    'name',
                    ''
                ],
                [
                    'type',
                    ''
                ],
                [
                    'owner_name',
                ],
            ],
            'lbl_connection_configuration' => [
                [
                    'mail_smtpserver',
                    'mail_smtpauth_req',
                ],
                [
                    'mail_smtpssl',
                    'mail_smtpuser',
                ],
                [
                    'mail_smtpport',
                    'mail_smtppass',
                ],
                [
                    [
                        'name' => 'sent_test_email_btn',
                        'label' => 'LBL_SEND_TEST_EMAIL',
                    ],
                ],
            ],
            'lbl_outbound_configuration' => [
                [
                    'smtp_from_name',
                ],
                [
                    'smtp_from_addr',
                ],
            ],
        ],
    ],
];
