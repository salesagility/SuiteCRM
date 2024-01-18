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

$module_name = 'stic_Security_Groups_Rules';
$viewdefs[$module_name] =
array(
    'EditView' => array(
        'templateMeta' => array(
            'maxColumns' => '2',
            'maxColumnsBasic' => '2',
            'widths' => array(
                0 => array(
                    'label' => '25',
                    'field' => '25',
                ),
                1 => array(
                    'label' => '25',
                    'field' => '25',
                ),
            ),
            'useTabs' => true,
            'tabDefs' => array(
                'DEFAULT' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
            ),
            'syncDetailEditViews' => true,
        ),
        'panels' => array(
            'DEFAULT' => array(
                0 => array(
                    0 => array('name' => 'name_label',
                        'type' => 'readonly',
                        'customCode' => '<strong>{$fields.name_label.value}</strong>',

                    ),
                    1 => array('name' => 'active',
                        'label' => 'LBL_ACTIVE',

                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'inherit_assigned',
                        'label' => 'LBL_INHERIT_ASSIGNED',
                    ),
                    1 => array(
                        'name' => 'inherit_creator',
                        'label' => 'LBL_INHERIT_CREATOR',
                    )),
                2 => array(
                    1 => array('name' => 'inherit_parent',
                        'label' => 'LBL_INHERIT_PARENT',
                    ),
                ),

                4 => array(
                    0 => array(
                        'name' => 'inherit_from_modules',
                        'studio' => 'visible',
                        'label' => 'LBL_INHERIT_FROM_MODULES',
                    ),
                    1 => array(
                        'name' => 'non_inherit_from_security_groups',
                        'studio' => 'visible',
                        'label' => 'LBL_NON_INHERIT_FROM_SECURITY_GROUPS',
                    ),

                ),

            ),

        ),
    ),
);
