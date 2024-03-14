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
$module_name = 'AOS_Products_Quotes';
$viewdefs[$module_name] =
array(
    'QuickCreate' => array(
        'templateMeta' => array(
            'maxColumns' => '2',
            'widths' => array(
                0 => array(
                    'label' => '10',
                    'field' => '30',
                ),
                1 => array(
                    'label' => '10',
                    'field' => '30',
                ),
            ),
            'useTabs' => true,
            'tabDefs' => array(
                'DEFAULT' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
            ),
        ),
        'panels' => array(
            'default' => array(
                0 => array(
                    0 => array(
                        'name' => 'name',
                        'label' => 'LBL_NAME',
                    ),
                    1 => array(
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO_NAME',
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'group_name',
                        'label' => 'LBL_GROUP_NAME',
                    ),
                    1 => array(
                        'name' => 'parent_name',
                        'label' => 'LBL_FLEX_RELATE',
                    ),
                ),
                2 => array(
                    0 => array(
                        'name' => 'number',
                        'label' => 'LBL_LIST_NUM',
                    ),
                    1 => array(
                        'name' => 'product_qty',
                        'label' => 'LBL_PRODUCT_QTY',
                    ),
                ),
                3 => array(
                    0 => array(
                        'name' => 'product',
                        'label' => 'LBL_PRODUCT',
                    ),
                    1 => array(
                        'name' => 'part_number',
                        'label' => 'LBL_PART_NUMBER',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'product_list_price',
                        'label' => 'LBL_PRODUCT_LIST_PRICE',
                    ),
                    1 => array(
                        'name' => 'product_unit_price',
                        'label' => 'LBL_PRODUCT_UNIT_PRICE',
                    ),
                ),
                5 => array(
                    0 => array(
                        'name' => 'product_discount',
                        'label' => 'LBL_PRODUCT_DISCOUNT',
                    ),
                    1 => array(
                        'name' => 'discount',
                        'studio' => 'visible',
                        'label' => 'LBL_DISCOUNT',
                    ),
                ),
                6 => array(
                    0 => array(
                        'name' => 'vat_amt',
                        'label' => 'LBL_VAT_AMT',
                    ),
                    1 => array(
                        'name' => 'vat',
                        'label' => 'LBL_VAT',
                    ),
                ),
                7 => array(
                    0 => array(
                        'name' => 'product_total_price',
                        'label' => 'LBL_PRODUCT_TOTAL_PRICE',
                    ),
                    1 => '',
                ),
                8 => array(
                    0 => array(
                        'name' => 'item_description',
                        'comment' => '',
                        'label' => 'LBL_PRODUCT_DESCRIPTION',
                    ),
                    1 => array(
                        'name' => 'description',
                        'label' => 'LBL_DESCRIPTION',
                    ),
                ),
            ),
        ),
    ),
);
// END STIC-Custom