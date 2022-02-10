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

/*********************************************************************************

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
$viewdefs = array(
  'Contacts' =>
  array(
    'QuickCreate' =>
    array(
      'templateMeta' =>
      array(
        'form' =>
        array(
          'hidden' =>
          array(
            '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
            '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
            '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
            '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
            '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
            '{if !empty($smarty.request.contact_id)}<input type="hidden" name="reports_to_id" value="{$smarty.request.contact_id}">{/if}',
            '{if !empty($smarty.request.contact_name)}<input type="hidden" name="report_to_name" value="{$smarty.request.contact_name}">{/if}',
          ),
        ),
        'maxColumns' => '2',
        'widths' =>
        array(
          array(
            'label' => '10',
            'field' => '30',
          ),
          array(
            'label' => '10',
            'field' => '30',
          ),
        ),
      ),
      'panels' =>
      array(
        'default' =>
        array(

          array(

            array(
              'name' => 'first_name',
                'customCode' => '{html_options name="salutation" id="salutation" options=$fields.salutation.options selected=$fields.salutation.value}'
                . '&nbsp;<input name="first_name" id="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
            ),

            array(
              'name' => 'account_name',
            ),
          ),

          array(

            array(
              'name' => 'last_name',
              'displayParams'=>array('required'=>true),
            ),

            array(
              'name' => 'phone_work',
            ),
          ),

          array(

            array(
              'name' => 'title',
            ),

            array(
              'name' => 'phone_mobile',
            ),
          ),

          array(

            array(
              'name' => 'phone_fax',
            ),

            array(
              'name' => 'do_not_call',
            ),
          ),

          array(
            array(
              'name' => 'email1',
            ),
            array(
              'name' => 'lead_source',
            ),
          ),

          array(

            array(
              'name' => 'assigned_user_name',
            ),
          ),
        ),
      ),
    ),
  ),
);
