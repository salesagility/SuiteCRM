<?php

$module_name = 'AOS_Invoices';
$_object_name = 'aos_invoices';
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
                'LBL_PANEL_OVERVIEW' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_INVOICE_TO' => [
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
            'LBL_PANEL_OVERVIEW' => [
                0 => [
                    0 => [
                        'name' => 'name',
                        'displayParams' => [
                            'required' => true,
                        ],
                        'label' => 'LBL_NAME',
                    ],
                    1 => [
                        'name' => 'number',
                        'label' => 'LBL_INVOICE_NUMBER',
                        'customCode' => '{$fields.number.value}',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'quote_number',
                        'label' => 'LBL_QUOTE_NUMBER',
                    ],
                    1 => [
                        'name' => 'quote_date',
                        'label' => 'LBL_QUOTE_DATE',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'due_date',
                        'label' => 'LBL_DUE_DATE',
                    ],
                    1 => [
                        'name' => 'invoice_date',
                        'label' => 'LBL_INVOICE_DATE',
                    ],
                ],
                3 => [
                    0 => [
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO_NAME',
                    ],
                    1 => [
                        'name' => 'status',
                        'label' => 'LBL_STATUS',
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'description',
                        'label' => 'LBL_DESCRIPTION',
                    ],
                ],
            ],
            'LBL_INVOICE_TO' => [
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
