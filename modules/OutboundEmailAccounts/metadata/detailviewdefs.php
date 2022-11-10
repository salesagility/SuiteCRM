<?php
$viewdefs ['OutboundEmailAccounts'] = [
    'DetailView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    'EDIT',
                    'DELETE',
                ],
            ],
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
                'LBL_EDITVIEW_PANEL1' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
            'preForm' => '
                <script type="text/javascript">
                    {suite_combinescripts
                        files="modules/OutboundEmailAccounts/js/fields.js,
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
                    '',
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
