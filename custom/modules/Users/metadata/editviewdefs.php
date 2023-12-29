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
$viewdefs['Users'] =
array(
    'EditView' => array(
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
            'form' => array(
                'headerTpl' => 'modules/Users/tpls/EditViewHeader.tpl',
                'footerTpl' => 'modules/Users/tpls/EditViewFooter.tpl',
            ),
            'useTabs' => false,
            'tabDefs' => array(
                'LBL_USER_INFORMATION' => array(
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ),
                'LBL_EMPLOYEE_INFORMATION' => array(
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ),
                'LBL_INCORPORA_CONNECTION_PARAMS' => array(
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ),
            ),
        ),
        'panels' => array(
            'LBL_USER_INFORMATION' => array(
                0 => array(
                    0 => array(
                        'name' => 'user_name',
                        'displayParams' => array(
                            'required' => true,
                        ),
                    ),
                    1 => 'first_name',
                ),
                1 => array(
                    0 => array(
                        'name' => 'status',
                        'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$STATUS_READONLY}{/if}',
                        'displayParams' => array(
                            'required' => true,
                        ),
                    ),
                    1 => 'last_name',
                ),
                2 => array(
                    0 => array(
                        'name' => 'UserType',
                        'customCode' => '{if $IS_ADMIN}{$USER_TYPE_DROPDOWN}{else}{$USER_TYPE_READONLY}{/if}',
                    ),
                    1 => 'sda_allowed_c',
                ),
                3 => array(
                    0 => 'photo',
                ),
                4 => array(
                    0 => array(
                        'name' => 'factor_auth',
                        'label' => 'LBL_FACTOR_AUTH',
                    ),
                ),
            ),
            'LBL_EMPLOYEE_INFORMATION' => array(
                0 => array(
                    0 => array(
                        'name' => 'employee_status',
                        'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$EMPLOYEE_STATUS_READONLY}{/if}',
                    ),
                    1 => 'show_on_employees',
                ),
                1 => array(
                    0 => array(
                        'name' => 'title',
                        'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$TITLE_READONLY}{/if}',
                    ),
                    1 => 'phone_work',
                ),
                2 => array(
                    0 => array(
                        'name' => 'department',
                        'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$DEPT_READONLY}{/if}',
                    ),
                    1 => 'phone_mobile',
                ),
                3 => array(
                    0 => array(
                        'name' => 'reports_to_name',
                        'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$REPORTS_TO_READONLY}{/if}',
                    ),
                    1 => 'phone_other',
                ),
                4 => array(
                    0 => '',
                    1 => 'phone_fax',
                ),
                5 => array(
                    0 => '',
                    1 => 'phone_home',
                ),
                6 => array(
                    0 => 'messenger_type',
                    1 => 'messenger_id',
                ),
                7 => array(
                    0 => 'address_street',
                    1 => 'address_city',
                ),
                8 => array(
                    0 => 'address_state',
                    1 => 'address_postalcode',
                ),
                9 => array(
                    0 => 'address_country',
                ),
                10 => array(
                    0 => 'description',
                ),
            ),
            'LBL_INCORPORA_CONNECTION_PARAMS' => array(
                0 => array(
                    0 => array(
                        'name' => 'inc_reference_group_c',
                        'studio' => 'visible',
                        'label' => 'LBL_INC_REFERENCE_GROUP',
                    ),
                    1 => array(
                        'name' => 'inc_reference_entity_c',
                        'studio' => 'visible',
                        'label' => 'LBL_INC_REFERENCE_ENTITY',
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'inc_reference_officer_c',
                        'label' => 'LBL_INC_REFERENCE_OFFICER',
                    ),
                    1 => array(
                        'name' => 'inc_incorpora_user_c',
                        'studio' => 'visible',
                        'label' => 'LBL_INC_INCORPORA_USER',
                    ),
                ),
            ),
        ),
    ),
);
