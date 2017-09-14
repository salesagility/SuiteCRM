<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$viewdefs ['Leads'] =
    array(
        'EditView' =>
            array(
                'templateMeta' =>
                    array(
                        'form' =>
                            array(
                                'hidden' =>
                                    array(
                                        0 => '<input type="hidden" name="prospect_id" value="{if isset($smarty.request.prospect_id)}{$smarty.request.prospect_id}{else}{$bean->prospect_id}{/if}">',
                                        1 => '<input type="hidden" name="account_id" value="{if isset($smarty.request.account_id)}{$smarty.request.account_id}{else}{$bean->account_id}{/if}">',
                                        2 => '<input type="hidden" name="contact_id" value="{if isset($smarty.request.contact_id)}{$smarty.request.contact_id}{else}{$bean->contact_id}{/if}">',
                                        3 => '<input type="hidden" name="opportunity_id" value="{if isset($smarty.request.opportunity_id)}{$smarty.request.opportunity_id}{else}{$bean->opportunity_id}{/if}">',
                                    ),
                                'buttons' =>
                                    array(
                                        0 => 'SAVE',
                                        1 => 'CANCEL',
                                    ),
                            ),
                        'maxColumns' => '2',
                        'widths' =>
                            array(
                                0 =>
                                    array(
                                        'label' => '10',
                                        'field' => '30',
                                    ),
                                1 =>
                                    array(
                                        'label' => '10',
                                        'field' => '30',
                                    ),
                            ),
                        'javascript' => '<script type="text/javascript" language="Javascript">function copyAddressRight(form)  {ldelim} form.alt_address_street.value = form.primary_address_street.value;form.alt_address_city.value = form.primary_address_city.value;form.alt_address_state.value = form.primary_address_state.value;form.alt_address_postalcode.value = form.primary_address_postalcode.value;form.alt_address_country.value = form.primary_address_country.value;return true; {rdelim} function copyAddressLeft(form)  {ldelim} form.primary_address_street.value =form.alt_address_street.value;form.primary_address_city.value = form.alt_address_city.value;form.primary_address_state.value = form.alt_address_state.value;form.primary_address_postalcode.value =form.alt_address_postalcode.value;form.primary_address_country.value = form.alt_address_country.value;return true; {rdelim} </script>',
                        'useTabs' => false,
                        'tabDefs' =>
                            array(
                                'LBL_CONTACT_INFORMATION' =>
                                    array(
                                        'newTab' => false,
                                        'panelDefault' => 'expanded',
                                    ),
                                'LBL_PANEL_ADVANCED' =>
                                    array(
                                        'newTab' => false,
                                        'panelDefault' => 'expanded',
                                    ),
                                'LBL_PANEL_ASSIGNMENT' =>
                                    array(
                                        'newTab' => false,
                                        'panelDefault' => 'expanded',
                                    ),
                            ),
                    ),
                'panels' =>
                    array(
                        'LBL_CONTACT_INFORMATION' =>
                            array(
                                0 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'first_name',
                                                'customCode' => '{html_options name="salutation" id="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name"  id="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
                                            ),
                                    ),
                                1 =>
                                    array(
                                        0 => 'last_name',
                                        1 => 'phone_work',
                                    ),
                                2 =>
                                    array(
                                        0 => 'title',
                                        1 => 'phone_mobile',
                                    ),
                                3 =>
                                    array(
                                        0 => 'department',
                                        1 => 'phone_fax',
                                    ),
                                4 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'account_name',
                                                'type' => 'varchar',
                                                'validateDependency' => false,
                                                'customCode' => '<input name="account_name" id="EditView_account_name" {if ($fields.converted.value == 1)}disabled="true"{/if} size="30" maxlength="255" type="text" value="{$fields.account_name.value}">',
                                            ),
                                        1 => 'website',
                                    ),
                                5 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'primary_address_street',
                                                'hideLabel' => true,
                                                'type' => 'address',
                                                'displayParams' =>
                                                    array(
                                                        'key' => 'primary',
                                                        'rows' => 2,
                                                        'cols' => 30,
                                                        'maxlength' => 150,
                                                    ),
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'alt_address_street',
                                                'hideLabel' => true,
                                                'type' => 'address',
                                                'displayParams' =>
                                                    array(
                                                        'key' => 'alt',
                                                        'copy' => 'primary',
                                                        'rows' => 2,
                                                        'cols' => 30,
                                                        'maxlength' => 150,
                                                    ),
                                            ),
                                    ),
                                6 =>
                                    array(
                                        0 => 'email1',
                                    ),
                                7 =>
                                    array(
                                        0 => 'description',
                                    ),
                            ),
                        'LBL_PANEL_ADVANCED' =>
                            array(
                                0 =>
                                    array(
                                        0 => 'status',
                                        1 => 'lead_source',
                                    ),
                                1 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'status_description',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'lead_source_description',
                                            ),
                                    ),
                                2 =>
                                    array(
                                        0 => 'opportunity_amount',
                                        1 => 'refered_by',
                                    ),
                                3 =>
                                    array(
                                        0 => 'campaign_name',
                                    ),
                            ),
                        'LBL_PANEL_ASSIGNMENT' =>
                            array(
                                0 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'assigned_user_name',
                                                'label' => 'LBL_ASSIGNED_TO',
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
?>
