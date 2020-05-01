<?php

$module_name = 'AOS_Contracts';
$viewdefs[$module_name] =
[
    'EditView' => [
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
            'tabDefs' => [
                'DEFAULT' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_LINE_ITEMS' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
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
                    0 => [
                        'name' => 'total_contract_value',
                        'label' => 'LBL_TOTAL_CONTRACT_VALUE',
                    ],
                    1 => [
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO_NAME',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'start_date',
                        'label' => 'LBL_START_DATE',
                    ],
                    1 => [
                        'name' => 'contract_account',
                        'label' => 'LBL_CONTRACT_ACCOUNT',
                    ],
                ],
                3 => [
                    0 => [
                        'name' => 'end_date',
                        'label' => 'LBL_END_DATE',
                    ],
                    1 => [
                        'name' => 'contact',
                        'studio' => 'visible',
                        'label' => 'LBL_CONTACT',
                        'displayParams' => [
                            'initial_filter' => '&account_name="+this.form.{$fields.contract_account.name}.value+"',
                        ],
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'renewal_reminder_date',
                        'label' => 'LBL_RENEWAL_REMINDER_DATE',
                        'type' => 'datetimecombo',
                    ],
                    1 => [
                        'name' => 'opportunity',
                        'label' => 'LBL_OPPORTUNITY',
                    ],
                ],
                5 => [
                    0 => [
                        'name' => 'customer_signed_date',
                        'label' => 'LBL_CUSTOMER_SIGNED_DATE',
                    ],
                    1 => [
                        'name' => 'contract_type',
                        'studio' => 'visible',
                        'label' => 'LBL_CONTRACT_TYPE',
                    ],
                ],
                6 => [
                    0 => [
                        'name' => 'company_signed_date',
                        'label' => 'LBL_COMPANY_SIGNED_DATE',
                    ],
                    1 => '',
                ],
                7 => [
                    0 => 'description',
                ],
            ],
            'lbl_line_items' => [
                0 => [
                    0 => [
                        'name' => 'currency_id',
                        'studio' => 'visible',
                        'label' => 'LBL_CURRENCY',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'line_items',
                        'label' => 'LBL_LINE_ITEMS',
                    ],
                ],
                2 => [
                    0 => '',
                ],
                3 => [
                    0 => [
                        'name' => 'total_amt',
                        'label' => 'LBL_TOTAL_AMT',
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'discount_amount',
                        'label' => 'LBL_DISCOUNT_AMOUNT',
                    ],
                ],
                5 => [
                    0 => [
                        'name' => 'subtotal_amount',
                        'label' => 'LBL_SUBTOTAL_AMOUNT',
                    ],
                ],
                6 => [
                    0 => [
                        'name' => 'shipping_amount',
                        'label' => 'LBL_SHIPPING_AMOUNT',
                        'displayParams' => [
                            'field' => [
                                'onblur' => 'calculateTotal(\'lineItems\');',
                            ],
                        ],
                    ],
                ],
                7 => [
                    0 => [
                        'name' => 'shipping_tax_amt',
                        'label' => 'LBL_SHIPPING_TAX_AMT',
                    ],
                ],
                8 => [
                    0 => [
                        'name' => 'tax_amount',
                        'label' => 'LBL_TAX_AMOUNT',
                    ],
                ],
                9 => [
                    0 => [
                        'name' => 'total_amount',
                        'label' => 'LBL_GRAND_TOTAL',
                    ],
                ],
            ],
        ],
    ],
];
