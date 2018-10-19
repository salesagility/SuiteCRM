<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
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


/**
 * VariableSubstitutionRule.php
 *
 * This is a utility base class to provide further refinement when converting
 * pre 5.x files to the new meta-data rules.  This rule substitutes the current
 * definitions will the standard meta-data ones.
 *
 * @author Collin Lee
 */

require_once('include/SugarFields/Parsers/Rules/BaseRule.php');

class VariableSubstitutionRule extends BaseRule
{
    public function __construct()
    {
    }

    public function parsePanels($panels, $view)
    {
        if ($view == 'DetailView') {
            foreach ($panels as $name=>$panel) {
                foreach ($panel as $rowCount=>$row) {
                    foreach ($row as $key=>$column) {
                        if ($this->matches($column, '/^date_entered$/') || $this->matches($column, '/^created_by$/')) {
                            $panels[$name][$rowCount][$key] = array(
                                                              'name' => 'date_entered',
                                                              'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                                                              'label' => 'LBL_DATE_ENTERED',
                                                            );
                        } elseif ($this->matches($column, '/^team.*?(_name)?$/s')) {
                            $panels[$name][$rowCount][$key] = 'team_name';
                        } elseif ($this->matches($column, '/^date_modified$/') || $this->matches($column, '/^modified_by$/')) {
                            $panels[$name][$rowCount][$key] = array(
                                                            'name' => 'date_modified',
                                                            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                                                            'label' => 'LBL_DATE_MODIFIED',
                                                            );
                        } elseif ($this->matches($column, '/^assigned.*?(_to|_name|_link)$/s')) {
                            //Remove "assigned_to" variable... this will be replaced with "assigned_to"
                            $panels[$name][$rowCount][$key] = 'assigned_user_name';
                        } elseif ($this->matches($column, '/^vcard_link$/')) {
                            $panels[$name][$rowCount][$key] = array(
                                                             'name' => 'full_name',
                                                             'customCode' => '{$fields.full_name.value}&nbsp;&nbsp;<input type="button" class="button" name="vCardButton" value="{$MOD.LBL_VCARD}" onClick="document.vcard.submit();">',
                                                             'label' => 'LBL_NAME',
                                                            );
                        } elseif ($this->matches($column, '/^parent_type$/si')) {
                            $panels[$name][$rowCount][$key] = 'parent_name';
                        } elseif ($this->matches($column, '/^account_id$/')) {
                            $panels[$name][$rowCount][$key] = 'account_name';
                        } elseif ($this->matches($column, '/^contact_id$/')) {
                            $panels[$name][$rowCount][$key] = 'contact_name';
                        } elseif ($this->matches($column, '/^reports_to_id$/')) {
                            $panels[$name][$rowCount][$key] = 'report_to_name';
                        } elseif ($this->matches($column, '/^reminder_time$/')) {
                            $panels[$name][$rowCount][$key] = array(
                                                           'name'=>'reminder_checked',
                                                           'fields'=>array('reminder_checked', 'reminder_time')
                                                           );
                        } elseif ($this->matches($column, '/^currency(_name)*$/')) {
                            $panels[$name][$rowCount][$key] = 'currency_id';
                        } elseif ($this->matches($column, '/^quote_id$/')) {
                            $panels[$name][$rowCount][$key] = 'quote_name';
                        }
                    } //foreach
                } //foreach
            } //foreach
        } elseif ($view == 'EditView') {
            foreach ($panels as $name=>$panel) {
                foreach ($panel as $rowCount=>$row) {
                    foreach ($row as $key=>$column) {
                        if ($this->matches($column, '/^salutation$/si') && is_array($column) && isset($column['fields']) && count($column['fields']) == 2) {
                            //Change salutation field to salutation + first_name'
                            $panels[$name][$rowCount][$key] = array(
                                                            'name' => 'first_name',
                                                            'customCode' => '{html_options name="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
                                                             );
                        } elseif ($this->matches($column, '/^parent_type$/si')) {
                            $panels[$name][$rowCount][$key] = 'parent_name';
                        } elseif ($this->matches($column, '/^currency(_name)$/')) {
                            $panels[$name][$rowCount][$key] = 'currency_id';
                        } elseif ($this->matches($column, '/^quote_id$/')) {
                            $panels[$name][$rowCount][$key] = 'quote_name';
                        } elseif ($this->matches($column, '/^account_id$/')) {
                            $panels[$name][$rowCount][$key] = 'account_name';
                        } elseif ($this->matches($column, '/^contact_id$/')) {
                            $panels[$name][$rowCount][$key] = 'contact_name';
                        }
                    } //foreach
                } //foreach
            } //foreach
        }

        return $panels;
    }
}
