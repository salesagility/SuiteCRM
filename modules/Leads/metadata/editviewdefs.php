<?php

$viewdefs['Leads'] =
[
    'EditView' => [
        'templateMeta' => [
            'form' => [
                'hidden' => [
                    0 => '<input type="hidden" name="prospect_id" value="{if isset($smarty.request.prospect_id)}{$smarty.request.prospect_id}{else}{$bean->prospect_id}{/if}">',
                    1 => '<input type="hidden" name="account_id" value="{if isset($smarty.request.account_id)}{$smarty.request.account_id}{else}{$bean->account_id}{/if}">',
                    2 => '<input type="hidden" name="contact_id" value="{if isset($smarty.request.contact_id)}{$smarty.request.contact_id}{else}{$bean->contact_id}{/if}">',
                    3 => '<input type="hidden" name="opportunity_id" value="{if isset($smarty.request.opportunity_id)}{$smarty.request.opportunity_id}{else}{$bean->opportunity_id}{/if}">',
                ],
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
            'javascript' => '<script type="text/javascript" language="Javascript">function copyAddressRight(form)  {ldelim} form.alt_address_street.value = form.primary_address_street.value;form.alt_address_city.value = form.primary_address_city.value;form.alt_address_state.value = form.primary_address_state.value;form.alt_address_postalcode.value = form.primary_address_postalcode.value;form.alt_address_country.value = form.primary_address_country.value;return true; {rdelim} function copyAddressLeft(form)  {ldelim} form.primary_address_street.value =form.alt_address_street.value;form.primary_address_city.value = form.alt_address_city.value;form.primary_address_state.value = form.alt_address_state.value;form.primary_address_postalcode.value =form.alt_address_postalcode.value;form.primary_address_country.value = form.alt_address_country.value;return true; {rdelim} </script>',
            'useTabs' => false,
            'tabDefs' => [
                'LBL_CONTACT_INFORMATION' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_ADVANCED' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_ASSIGNMENT' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
        ],
        'panels' => [
            'LBL_CONTACT_INFORMATION' => [
                0 => [
                    0 => [
                        'name' => 'first_name',
                        'customCode' => '{html_options name="salutation" id="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name"  id="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
                    ],
                ],
                1 => [
                    0 => 'last_name',
                    1 => 'phone_work',
                ],
                2 => [
                    0 => 'title',
                    1 => 'phone_mobile',
                ],
                3 => [
                    0 => 'department',
                    1 => 'phone_fax',
                ],
                4 => [
                    0 => [
                        'name' => 'account_name',
                        'type' => 'varchar',
                        'validateDependency' => false,
                        'customCode' => '<input name="account_name" id="EditView_account_name" {if ($fields.converted.value == 1)}disabled="true"{/if} size="30" maxlength="255" type="text" value="{$fields.account_name.value}">',
                    ],
                    1 => 'website',
                ],
                5 => [
                    0 => [
                        'name' => 'primary_address_street',
                        'hideLabel' => true,
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'primary',
                            'rows' => 2,
                            'cols' => 30,
                            'maxlength' => 150,
                        ],
                    ],
                    1 => [
                        'name' => 'alt_address_street',
                        'hideLabel' => true,
                        'type' => 'address',
                        'displayParams' => [
                            'key' => 'alt',
                            'copy' => 'primary',
                            'rows' => 2,
                            'cols' => 30,
                            'maxlength' => 150,
                        ],
                    ],
                ],
                6 => [
                    0 => 'email1',
                ],
                7 => [
                    0 => 'description',
                ],
            ],
            'LBL_PANEL_ADVANCED' => [
                0 => [
                    0 => 'status',
                    1 => 'lead_source',
                ],
                1 => [
                    0 => [
                        'name' => 'status_description',
                    ],
                    1 => [
                        'name' => 'lead_source_description',
                    ],
                ],
                2 => [
                    0 => 'opportunity_amount',
                    1 => 'refered_by',
                ],
                3 => [
                    0 => 'campaign_name',
                ],
            ],
            'LBL_PANEL_ASSIGNMENT' => [
                0 => [
                    0 => [
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO',
                    ],
                ],
            ],
        ],
    ],
];
