<?php
$module_name = 'AOS_Invoices';
$_object_name = 'aos_invoices';
$viewdefs [$module_name] =
    array (
        'DetailView' =>
        array (
            'templateMeta' =>
            array (
                'form' =>
                array (
                    'buttons' =>
                    array (
                        0 => 'EDIT',
                        1 => 'DUPLICATE',
                        2 => 'DELETE',
                        3 => 'FIND_DUPLICATES',
                        4 =>
                        array (
                            'customCode' => '<input type="button" class="button" onClick="showPopup(\'pdf\');" value="{$MOD.LBL_PRINT_AS_PDF}">',
                        ),
                        5 =>
                        array (
                            'customCode' => '<input type="button" class="button" onClick="showPopup(\'emailpdf\');" value="{$MOD.LBL_EMAIL_PDF}">',
                        ),
                        6 =>
                        array (
                            'customCode' => '<input type="button" class="button" onClick="showPopup(\'email\');" value="{$MOD.LBL_EMAIL_INVOICE}">',
                        ),
                    ),
                ),
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
                    'LBL_LINE_ITEMS' =>
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
                        0 =>
                        array (
                            'name' => 'name',
                            'label' => 'LBL_NAME',
                        ),
                        1 =>
                        array (
                            'name' => 'number',
                            'label' => 'LBL_INVOICE_NUMBER',
                        ),
                    ),
                    1 =>
                    array (
                        0 =>
                        array (
                            'name' => 'quote_number',
                            'label' => 'LBL_QUOTE_NUMBER',
                        ),
                        1 =>
                        array (
                            'name' => 'due_date',
                            'label' => 'LBL_DUE_DATE',
                        ),
                    ),
                    2 =>
                    array (
                        0 =>
                        array (
                            'name' => 'quote_date',
                            'label' => 'LBL_QUOTE_DATE',
                        ),
                        1 =>
                        array (
                            'name' => 'invoice_date',
                            'label' => 'LBL_INVOICE_DATE',
                        ),
                    ),
                    3 =>
                    array (
                        0 =>
                        array (
                            'name' => 'assigned_user_name',
                            'label' => 'LBL_ASSIGNED_TO_NAME',
                        ),
                        1 =>
                        array (
                            'name' => 'status',
                            'label' => 'LBL_STATUS',
                        ),
                    ),
                    4 =>
                    array (
                        0 => '',
                        1 => '',
                    ),
                    5 =>
                    array (
                        0 =>
                        array (
                            'name' => 'billing_account',
                            'label' => 'LBL_BILLING_ACCOUNT',
                        ),
                        1 =>
                        array (
                            'name' => 'billing_contact',
                            'label' => 'LBL_BILLING_CONTACT',
                        ),
                    ),
                    6 =>
                    array (
                        0 =>
                        array (
                            'name' => 'billing_address_street',
                            'label' => 'LBL_BILLING_ADDRESS',
                            'type' => 'address',
                            'displayParams' =>
                            array (
                                'key' => 'billing',
                            ),
                        ),
                        1 =>
                        array (
                            'name' => 'shipping_address_street',
                            'label' => 'LBL_SHIPPING_ADDRESS',
                            'type' => 'address',
                            'displayParams' =>
                            array (
                                'key' => 'shipping',
                            ),
                        ),
                    ),
                    7 =>
                    array (
                        0 => '',
                        1 => '',
                    ),
                    8 =>
                    array (
                        0 =>
                        array (
                            'name' => 'description',
                            'label' => 'LBL_DESCRIPTION',
                        ),
                    ),
                ),
                'lbl_line_items' =>
                array (
                    0 =>
                    array (
                        0 =>
                        array (
                            'name' => 'line_items',
                            'label' => 'LBL_LINE_ITEMS',
                        ),
                    ),
                    1 =>
                    array (
                        0 =>
                        array (
                            'name' => 'total_amt',
                            'label' => 'LBL_TOTAL_AMT',
                        ),
                        1 => '',
                    ),
                    2 =>
                    array (
                        0 =>
                        array (
                            'name' => 'discount_amount',
                            'label' => 'LBL_DISCOUNT_AMOUNT',
                        ),
                    ),
                    3 =>
                    array (
                        0 =>
                        array (
                            'name' => 'subtotal_amount',
                            'label' => 'LBL_SUBTOTAL_AMOUNT',
                        ),
                    ),
                    4 =>
                    array (
                        0 =>
                        array (
                            'name' => 'shipping_amount',
                            'label' => 'LBL_SHIPPING_AMOUNT',
                        ),
                    ),
                    5 =>
                    array (
                        0 =>
                        array (
                            'name' => 'shipping_tax_amt',
                            'label' => 'LBL_SHIPPING_TAX_AMT',
                        ),
                    ),
                    6 =>
                    array (
                        0 =>
                        array (
                            'name' => 'tax_amount',
                            'label' => 'LBL_TAX_AMOUNT',
                        ),
                    ),
                    7 =>
                    array (
                        0 =>
                        array (
                            'name' => 'total_amount',
                            'label' => 'LBL_GRAND_TOTAL',
                        ),
                    ),
                ),
            ),
        ),
    );
?>