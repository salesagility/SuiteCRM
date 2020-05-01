<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
$viewdefs['Contacts']['ConvertLead'] = [
    'copyData' => true,
    'required' => true,
    'select' => 'report_to_name',
    'default_action' => 'create',
    'templateMeta' => [
        'form' => [
            'hidden' => [
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">'
            ]
        ],
        'maxColumns' => '2',
        'widths' => [
            ['label' => '10', 'field' => '30'],
            ['label' => '10', 'field' => '30'],
        ],
    ],
    'panels' => [
        'LNK_NEW_CONTACT' => [
            [
                [
                    'name' => 'first_name',
                    'customCode' => '{html_options name="Contactssalutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="Contactsfirst_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
                ],
                'title',
            ],
            [
                'last_name',
                'department',
            ],
            [
                ['name' => 'primary_address_street', 'label' => 'LBL_PRIMARY_ADDRESS'],
                'phone_work',
            ],
            [
                ['name' => 'primary_address_city', 'label' => 'LBL_CITY'],
                'phone_mobile',
            ],
            [
                ['name' => 'primary_address_state', 'label' => 'LBL_STATE'],
                'phone_other',
            ],
            [
                ['name' => 'primary_address_postalcode', 'label' => 'LBL_POSTAL_CODE'],
                'phone_fax',
            ],
            [
                ['name' => 'primary_address_country', 'label' => 'LBL_COUNTRY'],
                'lead_source',
            ],
            [
                'email1',
            ],
            [
                'description'
            ],
        ]
    ],
];
$viewdefs['Accounts']['ConvertLead'] = [
    'copyData' => true,
    'required' => true,
    'select' => 'account_name',
    'default_action' => 'create',
    'relationship' => 'accounts_contacts',
    'templateMeta' => [
        'form' => [
            'hidden' => [
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">'
            ]
        ],
        'maxColumns' => '2',
        'widths' => [
            ['label' => '10', 'field' => '30'],
            ['label' => '10', 'field' => '30'],
        ],
    ],
    'panels' => [
        'LNK_NEW_ACCOUNT' => [
            [
                'name',
                'phone_office',
            ],
            [
                'website',
            ],
            [
                'description'
            ],
        ]
    ],
];
$viewdefs['Opportunities']['ConvertLead'] = [
    'copyData' => true,
    'required' => false,
    'templateMeta' => [
        'form' => [
            'hidden' => [
            ]
        ],
        'maxColumns' => '2',
        'widths' => [
            ['label' => '10', 'field' => '30'],
            ['label' => '10', 'field' => '30'],
        ],
    ],
    'panels' => [
        'LNK_NEW_OPPORTUNITY' => [
            [
                'name',
                'currency_id'
            ],
            [
                'sales_stage',
                'amount'
            ],
            [
                'date_closed',
                ''
            ],
            [
                'description'
            ],
        ]
    ],
];
$viewdefs['Notes']['ConvertLead'] = [
    'copyData' => false,
    'required' => false,
    'templateMeta' => [
        'form' => [
            'hidden' => [
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">'
            ]
        ],
        'maxColumns' => '2',
        'widths' => [
            ['label' => '10', 'field' => '30'],
            ['label' => '10', 'field' => '30'],
        ],
    ],
    'panels' => [
        'LNK_NEW_NOTE' => [
            [
                ['name' => 'name', 'displayParams' => ['size' => 90]],
            ],
            [
                ['name' => 'description', 'displayParams' => ['rows' => 10, 'cols' => 90]],
            ],
        ]
    ],
];

$viewdefs['Calls']['ConvertLead'] = [
    'copyData' => false,
    'required' => false,
    'templateMeta' => [
        'form' => [
            'hidden' => [
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
                '<input type="hidden" name="Callsstatus" value="{sugar_translate label=\'call_status_default\'}">',
            ]
        ],
        'maxColumns' => '2',
        'widths' => [
            ['label' => '10', 'field' => '30'],
            ['label' => '10', 'field' => '30'],
        ],
    ],
    'panels' => [
        'LNK_NEW_CALL' => [
            [
                ['name' => 'name', 'displayParams' => ['size' => 90]],
            ],
            [
                'date_start',
                [
                    'name' => 'duration_hours',
                    'label' => 'LBL_DURATION',
                    'customCode' => '{literal}
<script type="text/javascript">
    function isValidCallsDuration() { 
        form = document.getElementById(\'ConvertLead\');
        if ( form.duration_hours.value + form.duration_minutes.value <= 0 ) {
            alert(\'{/literal}{sugar_translate label="NOTICE_DURATION_TIME" module="Calls"}{literal}\'); 
            return false;
        }
        return true; 
    }
</script>{/literal}
<input name="Callsduration_hours" tabindex="1" size="2" maxlength="2" type="text" value="{$fields.duration_hours.value}"/>
{php}$this->_tpl_vars["minutes_values"] = $this->_tpl_vars["bean"]->minutes_values;{/php}
{html_options name="Callsduration_minutes" options=$minutes_values selected=$fields.duration_minutes.value} &nbsp;
<span class="dateFormat">{sugar_translate label="LBL_HOURS_MINUTES" module="Calls"}',
                    'displayParams' => [
                        'required' => true,
                    ],
                ],
            ],
            [
                ['name' => 'description', 'displayParams' => ['rows' => 10, 'cols' => 90]],
            ],
        ]
    ],
];

$viewdefs['Meetings']['ConvertLead'] = [
    'copyData' => false,
    'required' => false,
    'relationship' => 'meetings_users',
    'templateMeta' => [
        'form' => [
            'hidden' => [
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
                '<input type="hidden" name="Meetingsstatus" value="{sugar_translate label=\'meeting_status_default\'}">',
            ]
        ],
        'maxColumns' => '2',
        'widths' => [
            ['label' => '10', 'field' => '30'],
            ['label' => '10', 'field' => '30'],
        ],
    ],
    'panels' => [
        'LNK_NEW_MEETING' => [
            [
                ['name' => 'name', 'displayParams' => ['size' => 90]],
            ],
            [
                'date_start',
                [
                    'name' => 'duration_hours',
                    'label' => 'LBL_DURATION',
                    'customCode' => '{literal}
<script type="text/javascript">
    function isValidMeetingsDuration() { 
        form = document.getElementById(\'ConvertLead\');
        if ( form.duration_hours.value + form.duration_minutes.value <= 0 ) {
            alert(\'{/literal}{sugar_translate label="NOTICE_DURATION_TIME" module="Calls"}{literal}\'); 
            return false;
        }
        return true; 
    }
</script>{/literal}
<input name="Meetingsduration_hours" tabindex="1" size="2" maxlength="2" type="text" value="{$fields.duration_hours.value}" />
{php}$this->_tpl_vars["minutes_values"] = $this->_tpl_vars["bean"]->minutes_values;{/php}
{html_options name="Meetingsduration_minutes" options=$minutes_values selected=$fields.duration_minutes.value} &nbsp;
<span class="dateFormat">{sugar_translate label="LBL_HOURS_MINUTES" module="Calls"}',
                    'displayParams' => [
                        'required' => true,
                    ],
                ],
            ],
            [
                ['name' => 'description', 'displayParams' => ['rows' => 10, 'cols' => 90]],
            ],
        ]
    ],
];

$viewdefs['Tasks']['ConvertLead'] = [
    'copyData' => false,
    'required' => false,
    'templateMeta' => [
        'form' => [
            'hidden' => [
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">'
            ]
        ],
        'maxColumns' => '2',
        'widths' => [
            ['label' => '10', 'field' => '30'],
            ['label' => '10', 'field' => '30'],
        ],
    ],
    'panels' => [
        'LNK_NEW_TASK' => [
            [
                ['name' => 'name', 'displayParams' => ['size' => 90]],
            ],
            [
                'status', 'priority'
            ],

            [
                ['name' => 'description', 'displayParams' => ['rows' => 10, 'cols' => 90]],
            ],
        ]
    ],
];
