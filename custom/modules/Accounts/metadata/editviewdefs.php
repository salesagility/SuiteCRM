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
$viewdefs ['Accounts'] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'SAVE',
          1 => 'CANCEL',
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'modules/Accounts/Account.js',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_ACCOUNT_INFORMATION' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_STIC_PANEL_ADDRESSES' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_STIC_PANEL_INCORPORA' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_STIC_PANEL_INCORPORA_AGREEMENTS' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_STIC_PANEL_INCORPORA_ADDRESS' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => false,
    ),
    'panels' => 
    array (
      'lbl_account_information' => 
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
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'stic_acronym_c',
            'label' => 'LBL_STIC_ACRONYM',
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'stic_category_c',
            'label' => 'LBL_STIC_CATEGORY',
          ),
          1 => 
          array (
            'name' => 'stic_subcategory_c',
            'label' => 'LBL_STIC_SUBCATEGORY',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'stic_identification_number_c',
            'label' => 'LBL_STIC_IDENTIFICATION_NUMBER',
          ),
          1 => 'parent_name',
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'stic_language_c',
            'label' => 'LBL_STIC_LANGUAGE',
          ),
          1 => 
          array (
            'name' => 'email1',
            'studio' => 'false',
            'label' => 'LBL_EMAIL',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'phone_office',
            'label' => 'LBL_PHONE_OFFICE',
          ),
          1 => 
          array (
            'name' => 'phone_alternate',
            'comment' => 'An alternate phone number',
            'label' => 'LBL_PHONE_ALT',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'phone_fax',
            'label' => 'LBL_FAX',
          ),
          1 => 
          array (
            'name' => 'website',
            'type' => 'link',
            'label' => 'LBL_WEBSITE',
          ),
        ),
        7 => 
        array (
          0 => 'campaign_name',
          1 => 
          array (
            'name' => 'stic_postal_mail_return_reason_c',
            'label' => 'LBL_STIC_POSTAL_MAIL_RETURN_REASON',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'stic_tax_name_c',
            'label' => 'LBL_STIC_TAX_NAME',
          ),
          1 => 
          array (
            'name' => 'stic_182_excluded_c',
            'label' => 'LBL_STIC_182_EXCLUDED',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
      ),
      'lbl_stic_panel_addresses' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'stic_billing_address_type_c',
            'label' => 'LBL_STIC_BILLING_ADDRESS_TYPE',
          ),
          1 => 
          array (
            'name' => 'stic_shipping_address_type_c',
            'label' => 'LBL_STIC_SHIPPING_ADDRESS_TYPE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_street',
            'label' => 'LBL_BILLING_ADDRESS_STREET',
          ),
          1 => 
          array (
            'name' => 'shipping_address_street',
            'label' => 'LBL_SHIPPING_ADDRESS_STREET',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_postalcode',
            'comment' => 'The postal code used for billing address',
            'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
          ),
          1 => 
          array (
            'name' => 'shipping_address_postalcode',
            'comment' => 'The postal code used for the shipping address',
            'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_city',
            'comment' => 'The city used for billing address',
            'label' => 'LBL_BILLING_ADDRESS_CITY',
          ),
          1 => 
          array (
            'name' => 'shipping_address_city',
            'comment' => 'The city used for the shipping address',
            'label' => 'LBL_SHIPPING_ADDRESS_CITY',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'stic_billing_address_county_c',
            'label' => 'LBL_STIC_BILLING_ADDRESS_COUNTY',
          ),
          1 => 
          array (
            'name' => 'stic_shipping_address_county_c',
            'label' => 'LBL_STIC_SHIPPING_ADDRESS_COUNTY',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_state',
            'comment' => 'The state used for billing address',
            'label' => 'LBL_BILLING_ADDRESS_STATE',
          ),
          1 => 
          array (
            'name' => 'shipping_address_state',
            'comment' => 'The state used for the shipping address',
            'label' => 'LBL_SHIPPING_ADDRESS_STATE',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'stic_billing_address_region_c',
            'label' => 'LBL_STIC_BILLING_ADDRESS_REGION',
          ),
          1 => 
          array (
            'name' => 'stic_shipping_address_region_c',
            'label' => 'LBL_STIC_SHIPPING_ADDRESS_REGION',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_country',
            'comment' => 'The country used for the billing address',
            'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
          ),
          1 => 
          array (
            'name' => 'shipping_address_country',
            'comment' => 'The country used for the shipping address',
            'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
          ),
        ),
      ),
      'LBL_STIC_PANEL_INCORPORA' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'inc_id_c',
            'label' => 'LBL_INC_ID',
          ),
          1 => 
          array (
            'name' => 'inc_incorpora_record_c',
            'label' => 'LBL_INC_INCORPORA_RECORD',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'inc_status_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_STATUS',
          ),
          1 => 
          array (
            'name' => 'inc_contact_date_c',
            'label' => 'LBL_INC_CONTACT_DATE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'inc_collection_origin_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_COLLECTION_ORIGIN',
          ),
          1 => 
          array (
            'name' => 'inc_company_territory_scop_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_COMPANY_TERRITORY_SCOP',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'inc_size_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_SIZE',
          ),
          1 => 
          array (
            'name' => 'inc_employees_c',
            'label' => 'LBL_INC_EMPLOYEES',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'inc_communications_language_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_COMMUNICATIONS_LANGUAGE',
          ),
          1 => 
          array (
            'name' => 'inc_type_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_TYPE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'inc_activity_sector_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_ACTIVITY_SECTOR',
          ),
          1 => '',
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'inc_occupations_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_OCCUPATIONS',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'inc_cnae_n1_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_CNAE_N1',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'inc_cnae_n2_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_CNAE_N2',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'inc_cnae_n3_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_CNAE_N3',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'inc_contact_name_c',
            'label' => 'LBL_INC_CONTACT_NAME',
          ),
          1 => 
          array (
            'name' => 'inc_contact_telephone_c',
            'label' => 'LBL_INC_CONTACT_TELEPHONE',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'inc_contact_position_c',
            'label' => 'LBL_INC_CONTACT_POSITION',
          ),
          1 => 
          array (
            'name' => 'inc_observations_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_OBSERVATIONS',
          ),
        ),
      ),
      'LBL_STIC_PANEL_INCORPORA_AGREEMENTS' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'inc_agreement_avail_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_AGREEMENT_AVAIL',
          ),
          1 => 
          array (
            'name' => 'inc_agreement_start_date_c',
            'label' => 'LBL_INC_AGREEMENT_START_DATE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'inc_agreement_signed_with_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_AGREEMENT_SIGNED_WITH',
          ),
          1 => 
          array (
            'name' => 'inc_agreement_territory_scop_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_AGREEMENT_TERRITORY_SCOPE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'inc_agreement_inc_person_c',
            'label' => 'LBL_INC_AGREEMENT_INC_PERSON',
          ),
          1 => 
          array (
            'name' => 'inc_agreement_inc_position_c',
            'label' => 'LBL_INC_AGREEMENT_INC_POSITION',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'inc_agreement_comp_person_c',
            'label' => 'LBL_INC_AGREEMENT_COMP_PERSON',
          ),
          1 => 
          array (
            'name' => 'inc_agreement_comp_position_c',
            'label' => 'LBL_INC_AGREEMENT_COMP_POSITION',
          ),
        ),
      ),
      'LBL_STIC_PANEL_INCORPORA_ADDRESS' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'inc_address_street_type_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_ADDRESS_STREET_TYPE',
          ),
          1 => 
          array (
            'name' => 'inc_address_street_c',
            'label' => 'LBL_INC_ADDRESS_STREET',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'inc_address_num_a_c',
            'label' => 'LBL_INC_ADDRESS_NUM_A',
          ),
          1 => 
          array (
            'name' => 'inc_address_num_b_c',
            'label' => 'LBL_INC_ADDRESS_NUM_B',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'inc_address_block_c',
            'label' => 'LBL_INC_ADDRESS_BLOCK',
          ),
          1 => 
          array (
            'name' => 'inc_address_floor_c',
            'label' => 'LBL_INC_ADDRESS_FLOOR',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'inc_address_door_c',
            'label' => 'LBL_INC_ADDRESS_DOOR',
          ),
          1 => 
          array (
            'name' => 'inc_address_postal_code_c',
            'label' => 'LBL_INC_ADDRESS_POSTAL_CODE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'inc_address_district_c',
            'label' => 'LBL_INC_ADDRESS_DISTRICT',
          ),
          1 => 
          array (
            'name' => 'inc_location_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_LOCATION',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'inc_country_c',
            'studio' => 'visible',
            'label' => 'LBL_INC_COUNTRY',
          ),
        ),
      ),
    ),
  ),
);
;
?>
