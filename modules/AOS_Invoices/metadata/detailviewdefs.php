<?php

$module_name = 'AOS_Invoices';
$_object_name = 'aos_invoices';
$viewdefs[$module_name] =
[
    'DetailView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                    3 => 'FIND_DUPLICATES',
                    4 => [
                        'customCode' => '<input type="button" class="button" onClick="showPopup(\'pdf\');" value="{$MOD.LBL_PRINT_AS_PDF}">',
                    ],
                    5 => [
                        'customCode' => '<input type="button" class="button" onClick="showPopup(\'emailpdf\');" value="{$MOD.LBL_EMAIL_PDF}">',
                    ],
                    6 => [
                        'customCode' => '<input type="button" class="button" onClick="showPopup(\'email\');" value="{$MOD.LBL_EMAIL_INVOICE}">',
                    ],
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
            'useTabs' => true,
            'tabDefs' => [
                'LBL_PANEL_OVERVIEW' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
                'LBL_INVOICE_TO' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
                'LBL_LINE_ITEMS' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_ASSIGNMENT' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
            ],
        ],
        'panels' => [
            'LBL_PANEL_OVERVIEW' => [
                0 => [
                    0 => [
                        'name' => 'name',
                        'label' => 'LBL_NAME',
                    ],
                    1 => [
                        'name' => 'number',
                        'label' => 'LBL_INVOICE_NUMBER',
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
                    ],
                    1 => '',
                ],
                1 => [
                    0 => [
                        'name' => 'billing_contact',
                        'label' => 'LBL_BILLING_CONTACT',
                    ],
                    1 => '',
                ],
                2 => [
                    0 => [
                        'name' => 'billing_address_street',
                        'label' => 'LBL_BILLING_ADDRESS',
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'billing',
                        ],
                    ],
                    1 => [
                        'name' => 'shipping_address_street',
                        'label' => 'LBL_SHIPPING_ADDRESS',
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'shipping',
                        ],
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
                    1 => '',
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
            'LBL_PANEL_ASSIGNMENT' => [
                0 => [
                    0 => [
                        'name' => 'date_entered',
                        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                    ],
                    1 => [
                        'name' => 'date_modified',
                        'label' => 'LBL_DATE_MODIFIED',
                        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                    ],
                ],
            ],
        ],
    ],
];
