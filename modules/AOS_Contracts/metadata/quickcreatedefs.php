<?php

$module_name = 'AOS_Contracts';
$viewdefs[$module_name] =
[
    'QuickCreate' => [
        'templateMeta' => [
            'maxColumns' => '2',
            'widths' => [
                0 => [
                    'label' => '10',
                    'field' => '30',
                ],
                1 => [
                    'label' => '10',
                    'field' => '30',
                ],
            ],
            'useTabs' => false,
            'syncDetailEditViews' => false,
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => 'name',
                    1 => [
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ],
                ],
                1 => [
                    0 => '',
                    1 => [
                        'name' => 'start_date',
                        'label' => 'LBL_START_DATE',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'reference_code',
                        'label' => 'LBL_REFERENCE_CODE ',
                    ],
                    1 => [
                        'name' => 'end_date',
                        'label' => 'LBL_END_DATE',
                    ],
                ],
                3 => [
                    0 => [
                        'name' => 'aos_contrac_accounts_name',
                        'label' => 'LBL_AOS_CONTRACTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                    ],
                    1 => [
                        'name' => 'renewal_reminder_date',
                        'label' => 'LBL_RENEWAL_REMINDER_DATE',
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'aos_contracrtunities_name',
                        'label' => 'LBL_AOS_CONTRACTS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
                    ],
                    1 => '',
                ],
                5 => [
                    0 => [
                        'name' => 'customer_signed_date',
                        'label' => 'LBL_CUSTOMER_SIGNED_DATE',
                    ],
                    1 => [
                        'name' => 'company_signed_date',
                        'label' => 'LBL_COMPANY_SIGNED_DATE',
                    ],
                ],
                6 => [
                    0 => [
                        'name' => 'contract_type',
                        'studio' => 'visible',
                        'label' => 'LBL_CONTRACT_TYPE',
                    ],
                    1 => [
                        'name' => 'rminder',
                        'label' => 'LBL_RMINDER',
                    ],
                ],
                7 => [
                    0 => [
                        'name' => 'description',
                        'comment' => 'Full text of the note',
                        'label' => 'LBL_DESCRIPTION',
                    ],
                ],
            ],
        ],
    ],
];
