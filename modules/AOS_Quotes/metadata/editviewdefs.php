<?php

$module_name = 'AOS_Quotes';
$_object_name = 'aos_quotes';
$viewdefs[$module_name] =
[
    'EditView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    0 => 'SAVE',
                    1 => 'CANCEL',
                ],
            ],
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
            'tabDefs' => [
                'LBL_ACCOUNT_INFORMATION' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_ADDRESS_INFORMATION' => [
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
            'lbl_account_information' => [
                0 => [
                    0 => [
                        'name' => 'name',
                        'displayParams' => [
                            'required' => true,
                        ],
                        'label' => 'LBL_NAME',
                    ],
                    1 => [
                        'name' => 'opportunity',
                        'label' => 'LBL_OPPORTUNITY',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'number',
                        'label' => 'LBL_QUOTE_NUMBER',
                        'customCode' => '{$fields.number.value}',
                    ],
                    1 => [
                        'name' => 'stage',
                        'label' => 'LBL_STAGE',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'expiration',
                        'label' => 'LBL_EXPIRATION',
                    ],
                    1 => [
                        'name' => 'invoice_status',
                        'label' => 'LBL_INVOICE_STATUS',
                    ],
                ],
                3 => [
                    0 => [
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO_NAME',
                    ],
                    1 => [
                        'name' => 'term',
                        'label' => 'LBL_TERM',
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'approval_status',
                        'label' => 'LBL_APPROVAL_STATUS',
                    ],
                    1 => [
                        'name' => 'approval_issue',
                        'label' => 'LBL_APPROVAL_ISSUE',
                    ],
                ],
            ],
            'lbl_address_information' => [
                0 => [
                    0 => [
                        'name' => 'billing_account',
                        'label' => 'LBL_BILLING_ACCOUNT',
                        'displayParams' => [
                            'key' => [
                                0 => 'billing',
                                1 => 'shipping',
                            ],
                            'copy' => [
                                0 => 'billing',
                                1 => 'shipping',
                            ],
                            'billingKey' => 'billing',
                            'shippingKey' => 'shipping',
                        ],
                    ],
                    1 => '',
                ],
                1 => [
                    0 => [
                        'name' => 'billing_contact',
                        'label' => 'LBL_BILLING_CONTACT',
                        'displayParams' => [
                            'initial_filter' => '&account_name="+this.form.{$fields.billing_account.name}.value+"',
                        ],
                    ],
                    1 => '',
                ],
                2 => [
                    0 => [
                        'name' => 'billing_address_street',
                        'hideLabel' => true,
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'billing',
                            'rows' => 2,
                            'cols' => 30,
                            'maxlength' => 150,
                        ],
                        'label' => 'LBL_BILLING_ADDRESS_STREET',
                    ],
                    1 => [
                        'name' => 'shipping_address_street',
                        'hideLabel' => true,
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'shipping',
                            'copy' => 'billing',
                            'rows' => 2,
                            'cols' => 30,
                            'maxlength' => 150,
                        ],
                        'label' => 'LBL_SHIPPING_ADDRESS_STREET',
                    ],
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
