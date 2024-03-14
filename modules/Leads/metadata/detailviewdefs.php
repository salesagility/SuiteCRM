<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105 
// $viewdefs ['Leads'] =
// array(
//   'DetailView' =>
//   array(
//     'templateMeta' =>
//     array(
//       'form' =>
//       array(
//         'buttons' =>
//         array(
//             'SEND_CONFIRM_OPT_IN_EMAIL' => EmailAddress::getSendConfirmOptInEmailActionLinkDefs('Leads'),
//           0 => 'EDIT',
//           1 => 'DUPLICATE',
//           2 => 'DELETE',
//           3 =>
//           array(
//             'customCode' => '{if $bean->aclAccess("edit") && !$DISABLE_CONVERT_ACTION}<input title="{$MOD.LBL_CONVERTLEAD_TITLE}" accessKey="{$MOD.LBL_CONVERTLEAD_BUTTON_KEY}" type="button" class="button" onClick="document.location=\'index.php?module=Leads&action=ConvertLead&record={$fields.id.value}\'" name="convert" value="{$MOD.LBL_CONVERTLEAD}">{/if}',
//             'sugar_html' =>
//             array(
//               'type' => 'button',
//               'value' => '{$MOD.LBL_CONVERTLEAD}',
//               'htmlOptions' =>
//               array(
//                 'title' => '{$MOD.LBL_CONVERTLEAD_TITLE}',
//                 'accessKey' => '{$MOD.LBL_CONVERTLEAD_BUTTON_KEY}',
//                 'class' => 'button',
//                 'onClick' => 'document.location=\'index.php?module=Leads&action=ConvertLead&record={$fields.id.value}\'',
//                 'name' => 'convert',
//                 'id' => 'convert_lead_button',
//               ),
//               'template' => '{if $bean->aclAccess("edit") && !$DISABLE_CONVERT_ACTION}[CONTENT]{/if}',
//             ),
//           ),
//           4 => 'FIND_DUPLICATES',
//           5 =>
//           array(
//             'customCode' => '<input title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" class="button" onclick="this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'DetailView\';this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Leads\';" type="submit" name="Manage Subscriptions" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}">',
//             'sugar_html' =>
//             array(
//               'type' => 'submit',
//               'value' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
//               'htmlOptions' =>
//               array(
//                 'title' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
//                 'class' => 'button',
//                 'id' => 'manage_subscriptions_button',
//                 'onclick' => 'this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'DetailView\';this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Leads\';',
//                 'name' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
//               ),
//             ),
//           ),
//           'AOS_GENLET' =>
//           array(
//             'customCode' => '<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_PRINT_AS_PDF}">',
//           ),
//         ),
//         'headerTpl' => 'modules/Leads/tpls/DetailViewHeader.tpl',
//       ),
//       'maxColumns' => '2',
//       'widths' =>
//       array(
//         0 =>
//         array(
//           'label' => '10',
//           'field' => '30',
//         ),
//         1 =>
//         array(
//           'label' => '10',
//           'field' => '30',
//         ),
//       ),
//       'includes' =>
//       array(
//         0 =>
//         array(
//           'file' => 'modules/Leads/Lead.js',
//         ),
//       ),
//       'useTabs' => true,
//       'tabDefs' =>
//       array(
//         'LBL_CONTACT_INFORMATION' =>
//         array(
//           'newTab' => true,
//           'panelDefault' => 'expanded',
//         ),
//         'LBL_PANEL_ADVANCED' =>
//         array(
//           'newTab' => true,
//           'panelDefault' => 'expanded',
//         ),
//         'LBL_PANEL_ASSIGNMENT' =>
//         array(
//           'newTab' => true,
//           'panelDefault' => 'expanded',
//         ),
//       ),
//     ),
//     'panels' =>
//     array(
//       'LBL_CONTACT_INFORMATION' =>
//       array(
//         0 =>
//         array(
//           0 =>
//           array(
//             'name' => 'full_name',
//             'label' => 'LBL_NAME',
//           ),
//           1 => 'phone_work',
//         ),
//         1 =>
//         array(
//           0 => 'title',
//           1 => 'phone_mobile',
//         ),
//         2 =>
//         array(
//           0 => 'department',
//           1 => 'phone_fax',
//         ),
//         3 =>
//         array(
//           0 =>
//           array(
//             'name' => 'account_name',
//           ),
//           1 => 'website',
//         ),
//         4 =>
//         array(
//           0 =>
//           array(
//             'name' => 'primary_address_street',
//             'label' => 'LBL_PRIMARY_ADDRESS',
//             'type' => 'address',
//             'displayParams' =>
//             array(
//               'key' => 'primary',
//             ),
//           ),
//           1 =>
//           array(
//             'name' => 'alt_address_street',
//             'label' => 'LBL_ALTERNATE_ADDRESS',
//             'type' => 'address',
//             'displayParams' =>
//             array(
//               'key' => 'alt',
//             ),
//           ),
//         ),
//         5 =>
//         array(
//           0 => 'email1',
//         ),
//         6 =>
//         array(
//           0 => 'description',
//         ),
//         7 =>
//         array(
//           0 =>
//           array(
//             'name' => 'assigned_user_name',
//             'label' => 'LBL_ASSIGNED_TO',
//           ),
//         ),
//       ),
//       'LBL_PANEL_ADVANCED' =>
//       array(
//         0 =>
//         array(
//           0 => 'status',
//           1 => 'lead_source',
//         ),
//         1 =>
//         array(
//           0 => 'status_description',
//           1 => 'lead_source_description',
//         ),
//         2 =>
//         array(
//           0 => 'opportunity_amount',
//           1 => 'refered_by',
//         ),
//         3 =>
//         array(
//           0 =>
//           array(
//             'name' => 'campaign_name',
//             'label' => 'LBL_CAMPAIGN',
//           ),
//         ),
//       ),
//       'LBL_PANEL_ASSIGNMENT' =>
//       array(
//         0 =>
//         array(
//           0 =>
//           array(
//             'name' => 'date_modified',
//             'label' => 'LBL_DATE_MODIFIED',
//             'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
//           ),
//           1 =>
//           array(
//             'name' => 'date_entered',
//             'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
//           ),
//         ),
//       ),
//     ),
//   ),
// );

$viewdefs['Leads']['DetailView'] = array (
  'templateMeta' => 
  array (
    'form' => 
    array (
      'buttons' => 
      array (
        'SEND_CONFIRM_OPT_IN_EMAIL' => 
        array (
          'customCode' => '<input type="submit" class="button hidden" disabled="disabled" title="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}" onclick="this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'Leads\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'sendConfirmOptInEmail\'; this.form.module.value=\'Leads\'; this.form.module_tab.value=\'Leads\';" name="send_confirm_opt_in_email" value="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}"/>',
          'sugar_html' => 
          array (
            'type' => 'submit',
            'value' => '{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}',
            'htmlOptions' => 
            array (
              'class' => 'button hidden',
              'id' => 'send_confirm_opt_in_email',
              'title' => '{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}',
              'onclick' => 'this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'sendConfirmOptInEmail\'; this.form.module.value=\'Leads\'; this.form.module_tab.value=\'Leads\';',
              'name' => 'send_confirm_opt_in_email',
              'disabled' => true,
            ),
          ),
        ),
        0 => 'EDIT',
        1 => 'DUPLICATE',
        2 => 'DELETE',
        3 => 
        array (
          'customCode' => '{if $bean->aclAccess("edit") && !$DISABLE_CONVERT_ACTION}<input title="{$MOD.LBL_CONVERTLEAD_TITLE}" accessKey="{$MOD.LBL_CONVERTLEAD_BUTTON_KEY}" type="button" class="button" onClick="document.location=\'index.php?module=Leads&action=ConvertLead&record={$fields.id.value}\'" name="convert" value="{$MOD.LBL_CONVERTLEAD}">{/if}',
          'sugar_html' => 
          array (
            'type' => 'button',
            'value' => '{$MOD.LBL_CONVERTLEAD}',
            'htmlOptions' => 
            array (
              'title' => '{$MOD.LBL_CONVERTLEAD_TITLE}',
              'accessKey' => '{$MOD.LBL_CONVERTLEAD_BUTTON_KEY}',
              'class' => 'button',
              'onClick' => 'document.location=\'index.php?module=Leads&action=ConvertLead&record={$fields.id.value}\'',
              'name' => 'convert',
              'id' => 'convert_lead_button',
            ),
            'template' => '{if $bean->aclAccess("edit") && !$DISABLE_CONVERT_ACTION}[CONTENT]{/if}',
          ),
		),
        'AOS_GENLET' => 
          array (
            'customCode' => '<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_PRINT_AS_PDF}">',
        ),
      ),
      'headerTpl' => 'modules/Leads/tpls/DetailViewHeader.tpl',
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
    'includes' => 
    array (
      0 => 
      array (
        'file' => 'modules/Leads/Lead.js',
      ),
    ),
    'useTabs' => true,
    'tabDefs' => 
    array (
      'LBL_CONTACT_INFORMATION' => 
	  array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_STIC_PANEL_ADDRESSES' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_PANEL_ADVANCED' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_STIC_PANEL_GDPR' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_STIC_PANEL_RECORD_DETAILS ' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
    ),
    'syncDetailEditViews' => true,
  ),
  'panels' => 
    array (
    'LBL_CONTACT_INFORMATION' => 
    array (
      0 => 
      array (
        0 => 'first_name',
        1 => 'last_name',
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO',
        ),
        1 => 'status',
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'stic_identification_type_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_IDENTIFICATION_TYPE',
        ),
        1 => 
        array (
          'name' => 'stic_identification_number_c',
          'label' => 'LBL_STIC_IDENTIFICATION_NUMBER',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'stic_gender_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_GENDER',
        ),
        1 => 
        array (
          'name' => 'birthdate',
          'comment' => 'The birthdate of the contact',
          'label' => 'LBL_BIRTHDATE',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'stic_language_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_LANGUAGE',
        ),
        1 => '',
      ),
      5 => 
      array (
        0 => 'email1',
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'phone_home',
          'comment' => 'Home phone number of the contact',
          'label' => 'LBL_HOME_PHONE',
        ),
        1 => 'phone_mobile',
      ),
      7 => 
      array (
        0 => 'phone_work',
        1 => 
        array (
          'name' => 'do_not_call',
          'comment' => 'An indicator of whether contact can be called',
          'label' => 'LBL_DO_NOT_CALL',
        ),
      ),
      8 => 
      array (
        0 => 'campaign_name',
        1 => 
        array (
          'name' => 'stic_acquisition_channel_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_ACQUISITION_CHANNEL',
        ),
      ),
      9 => 
      array (
        0 => 
        array (
          'name' => 'description',
          'comment' => 'Full text of the note',
          'label' => 'LBL_DESCRIPTION',
        ),
      ),
    ),
    'LBL_STIC_PANEL_ADDRESSES' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'stic_primary_address_type_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_PRIMARY_ADDRESS_TYPE',
        ),
        1 => 
        array (
          'name' => 'stic_alt_address_type_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_ALT_ADDRESS_TYPE',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'studio' => 'visible',
          'name' => 'primary_address_street',
          'label' => 'LBL_PRIMARY_ADDRESS_STREET',
        ),
        1 => 
        array (
          'studio' => 'visible',
          'name' => 'alt_address_street',
          'label' => 'LBL_ALT_ADDRESS_STREET',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'primary_address_postalcode',
          'comment' => 'Postal code for primary address',
          'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
        ),
        1 => 
        array (
          'name' => 'alt_address_postalcode',
          'comment' => 'Postal code for alternate address',
          'label' => 'LBL_ALT_ADDRESS_POSTALCODE',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'primary_address_city',
          'comment' => 'City for primary address',
          'label' => 'LBL_PRIMARY_ADDRESS_CITY',
        ),
        1 => 
        array (
          'name' => 'alt_address_city',
          'comment' => 'City for alternate address',
          'label' => 'LBL_ALT_ADDRESS_CITY',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'stic_primary_address_county_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_PRIMARY_ADDRESS_COUNTY',
        ),
        1 => 
        array (
          'name' => 'stic_alt_address_county_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_ALT_ADDRESS_COUNTY',
        ),
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'primary_address_state',
          'comment' => 'State for primary address',
          'label' => 'LBL_PRIMARY_ADDRESS_STATE',
        ),
        1 => 
        array (
          'name' => 'alt_address_state',
          'comment' => 'State for alternate address',
          'label' => 'LBL_ALT_ADDRESS_STATE',
        ),
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'stic_primary_address_region_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_PRIMARY_ADDRESS_REGION',
        ),
        1 => 
        array (
          'name' => 'stic_alt_address_region_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_ALT_ADDRESS_REGION',
        ),
      ),
      7 => 
      array (
        0 => 
        array (
          'name' => 'primary_address_country',
          'comment' => 'Country for primary address',
          'label' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
        ),
        1 => 
        array (
          'name' => 'alt_address_country',
          'comment' => 'Country for alternate address',
          'label' => 'LBL_ALT_ADDRESS_COUNTRY',
        ),
      ),
    ),
    'LBL_PANEL_ADVANCED' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'stic_professional_sector_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_PROFESSIONAL_SECTOR',
        ),
        1 => 
        array (
          'name' => 'stic_professional_sector_other_c',
          'label' => 'LBL_STIC_PROFESSIONAL_SECTOR_OTHER',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'stic_employment_status_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_EMPLOYMENT_STATUS',
        ),
        1 => 
        array (
          'name' => 'account_name',
        ),
      ),
      2 => 
      array (
        0 => 'title',
        1 => 'department',
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'stic_referral_agent_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_REFERRAL_AGENT',
        ),
        1 => '',
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'stic_do_not_send_postal_mail_c',
          'label' => 'LBL_STIC_DO_NOT_SEND_POSTAL_MAIL',
        ),
        1 => 
        array (
          'name' => 'stic_postal_mail_return_reason_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_POSTAL_MAIL_RETURN_REASON',
        ),
      ),
    ),
    'LBL_STIC_PANEL_GDPR' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'lawful_basis',
          'label' => 'LBL_LAWFUL_BASIS',
        ),
        1 => 
        array (
          'name' => 'lawful_basis_source',
          'label' => 'LBL_LAWFUL_BASIS_SOURCE',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'date_reviewed',
          'label' => 'LBL_DATE_REVIEWED',
        ),
        1 => '',
      ),
    ),
    'LBL_STIC_PANEL_RECORD_DETAILS ' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'created_by_name',
          'label' => 'LBL_CREATED',
        ),
        1 => 
        array (
          'name' => 'date_entered',
          'customCode' => '{$fields.date_entered.value}',
          'label' => 'LBL_DATE_ENTERED',
        ),
          ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'modified_by_name',
          'label' => 'LBL_MODIFIED_NAME',
        ),
        1 => 
        array (
          'name' => 'date_modified',
          'customCode' => '{$fields.date_modified.value}',
          'label' => 'LBL_DATE_MODIFIED',
        ),
      ),
    ),
  ),
);
// END STIC-Custom