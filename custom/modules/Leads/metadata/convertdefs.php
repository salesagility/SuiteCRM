<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

$viewdefs['Contacts']['ConvertLead'] = array(
    'copyData' => true,
    'required' => true,
    'select' => "report_to_name",
    'default_action' => 'create',
    'templateMeta' => array(
        'form' => array(
            'hidden' => array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
            ),
        ),
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' => array(
        'LNK_NEW_CONTACT' => array(
            array(
                'first_name',
                'last_name',
            ),
            array(
                'birthdate',
            ),
            array(

                'stic_identification_type_c',
                'stic_identification_number_c',
            ),
            array(
                'title',
                'department',
            ),
            array(
                'phone_home',
                'phone_mobile',
            ),
            array(
                'phone_work',
                'do_not_call',
            ),
            array(
                'stic_primary_address_type_c',
                'primary_address_street',
            ),
            array(
                'primary_address_postalcode',
                'primary_address_city',
            ),
            array(
                'stic_primary_address_county_c',
                'primary_address_state',
            ),
            array(
                'stic_primary_address_region_c',
                'primary_address_country',
            ),
            array(
                'stic_do_not_send_postal_mail_c',
                'lawful_basis',
            ),
            array(
                'lawful_basis_source',
                'date_reviewed',
            ),
            array(
                'stic_language_c',
                'stic_gender_c',
            ),
            array(
                'stic_professional_sector_c',
                'stic_professional_sector_other_c',
            ),
            array(
                'stic_employment_status_c',
                'stic_acquisition_channel_c',
            ),
            array(
                'stic_referral_agent_c',
                array(
                    'name' => 'description',
                    'displayParams' => array('rows' => 2, 'cols' => 400),
                    'customCode' => '
                        <textarea id="Contactsdescription" name="Contactsdescription" rows="2" cols="400" title="" tabindex="0"></textarea>
                    ',
                ),
            ),
        ),
    ),
);
$viewdefs['Accounts']['ConvertLead'] = array(
    'copyData' => true,
    'required' => false,
    'select' => "account_name",
    'default_action' => 'create',
    'relationship' => 'accounts_contacts',
    'templateMeta' => array(
        'form' => array(
            'hidden' => array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
            ),
        ),
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' => array(
        'LNK_NEW_ACCOUNT' => array(
            array(
                'name',
                'phone_office',
            ),
            array(
                'website',
            ),
            array(
                array('name' => 'description', 'displayParams' => array('rows' => 2, 'cols' => 400)),
            ),
        ),
    ),
);

$viewdefs['Notes']['ConvertLead'] = array(
    'copyData' => false,
    'required' => false,
    'templateMeta' => array(
        'form' => array(
            'hidden' => array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
            ),
        ),
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' => array(
        'LNK_NEW_NOTE' => array(
            array(
                array('name' => 'name', 'displayParams' => array('size' => 90)),
            ),
            array(
                array('name' => 'description', 'displayParams' => array('rows' => 2, 'cols' => 400)),
            ),
        ),
    ),
);

$viewdefs['Calls']['ConvertLead'] = array(
    'copyData' => false,
    'required' => false,
    'templateMeta' => array(
        'form' => array(
            'hidden' => array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
                '<input type="hidden" name="Callsstatus" value="{sugar_translate label=\'call_status_default\'}">',
            ),
        ),
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' => array(
        'LNK_NEW_CALL' => array(
            array(
                array(
                    'name' => 'name',
                    'displayParams' => array('size' => 90),
                ),
            ),
            array(
                'date_start',
                array(
                    'name' => 'duration_hours',
                    'label' => 'LBL_DURATION',
                    'customCode' => '
                        {literal}
                            <script type="text/javascript">
                                function isValidCallsDuration() {
                                    form = document.getElementById(\'ConvertLead\');
                                    if (form.duration_hours.value + form.duration_minutes.value <= 0) {
                                        alert(\'
                        {/literal}
                                                {sugar_translate label="NOTICE_DURATION_TIME" module="Calls"}
                        {literal}
                                        \');
                                        return false;
                                    }
                                    return true;
                                }
                            </script>
                        {/literal}
                        <input name="Callsduration_hours" tabindex="1" size="2" maxlength="2" type="text" value="{$fields.duration_hours.value}"/>
                        {php}
                            $this->_tpl_vars["minutes_values"] = $this->_tpl_vars["bean"]->minutes_values;
                        {/php}
                        {
                            html_options name="Callsduration_minutes" options=$minutes_values selected=$fields.duration_minutes.value
                        }
                        &nbsp;
                        <span class="dateFormat">
                            {sugar_translate label="LBL_HOURS_MINUTES" module="Calls"}
                        </span>
                    ',
                    'displayParams' => array('required' => true),
                ),
            ),
            array(
                array('name' => 'description', 'displayParams' => array('rows' => 2, 'cols' => 400)),
            ),
        ),
    ),
);

$viewdefs['Meetings']['ConvertLead'] = array(
    'copyData' => false,
    'required' => false,
    'relationship' => 'meetings_users',
    'templateMeta' => array(
        'form' => array(
            'hidden' => array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
                '<input type="hidden" name="Meetingsstatus" value="{sugar_translate label=\'meeting_status_default\'}">',
            ),
        ),
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' => array(
        'LNK_NEW_MEETING' => array(
            array(
                array('name' => 'name', 'displayParams' => array('size' => 90)),
            ),
            array(
                'date_start',
                array(
                    'name' => 'duration_hours',
                    'label' => 'LBL_DURATION',
                    'customCode' => '
                        {literal}
                            <script type="text/javascript">
                                function isValidMeetingsDuration() {
                                    form = document.getElementById(\'ConvertLead\');
                                    if (form.duration_hours.value + form.duration_minutes.value <= 0) {
                                        alert(\'
                        {/literal}
                                            {sugar_translate label="NOTICE_DURATION_TIME" module="Calls"}
                        {literal}
                                        \');
                                        return false;
                                    }
                                    return true;
                                }
                            </script>
                        {/literal}
                        <input name="Meetingsduration_hours" tabindex="1" size="2" maxlength="2" type="text" value="{$fields.duration_hours.value}" />
                        {php}
                            $this->_tpl_vars["minutes_values"] = $this->_tpl_vars["bean"]->minutes_values;
                        {/php}
                        {html_options name="Meetingsduration_minutes" options=$minutes_values selected=$fields.duration_minutes.value}
                        &nbsp;
                        <span class="dateFormat">
                            {sugar_translate label="LBL_HOURS_MINUTES" module="Calls"}
                        </span>',
                    'displayParams' => array('required' => true),
                ),
            ),
            array(
                array('name' => 'description', 'displayParams' => array('rows' => 2, 'cols' => 400)),
            ),
        ),
    ),
);

$viewdefs['Tasks']['ConvertLead'] = array(
    'copyData' => false,
    'required' => false,
    'templateMeta' => array(
        'form' => array(
            'hidden' => array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
            ),
        ),
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' => array(
        'LNK_NEW_TASK' => array(
            array(
                array('name' => 'name', 'displayParams' => array('size' => 90)),
            ),
            array(
                'status', 'priority',
            ),
            array(
                array('name' => 'description', 'displayParams' => array('rows' => 2, 'cols' => 400)),
            ),
        ),
    ),
);
