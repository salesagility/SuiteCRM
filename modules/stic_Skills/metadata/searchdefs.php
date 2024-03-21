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

$module_name = 'stic_Skills';
$searchdefs[$module_name] = array(
    'templateMeta' => array(
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => array('label' => '10', 'field' => '30'),
    ),
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'stic_skills_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_SKILLS_CONTACTS_FROM_CONTACTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_SKILLSS_CONTACTSCONTACTS_IDA',
                'name' => 'stic_skills_contacts_name',
            ),
            'skill' => array(
                'type' => 'varchar',
                'studio' => 'visible',
                'label' => 'LBL_SKILL',
                'width' => '10%',
                'default' => true,
                'name' => 'skill',
            ),             
            'type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'type',
            ),         
            'level' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_LEVEL',
                'width' => '10%',
                'default' => true,
                'name' => 'level',
            ),      
            'assigned_user_id' => array(
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
            ),
            'current_user_only' => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),

        ),
        'advanced_search' => array(
            'name',
            'stic_skills_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_SKILLS_CONTACTS_FROM_CONTACTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_SKILLSS_CONTACTSCONTACTS_IDA',
                'name' => 'stic_skills_contacts_name',
            ),
            'skill' => array(
                'type' => 'varchar',
                'studio' => 'visible',
                'label' => 'LBL_SKILL',
                'width' => '10%',
                'default' => true,
                'name' => 'skill',
            ),             
            'type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'type',
            ),         
            'level' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_LEVEL',
                'width' => '10%',
                'default' => true,
                'name' => 'level',
            ),      
            'language' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_LANGUAGE',
                'width' => '10%',
                'default' => true,
                'name' => 'language',
            ),             
            'other' => array(
                'type' => 'varchar',
                'studio' => 'visible',
                'label' => 'LBL_OTHER',
                'width' => '10%',
                'default' => true,
                'name' => 'other',
            ),         
            'written' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_WRITTEN',
                'width' => '10%',
                'default' => true,
                'name' => 'written',
            ),   
            'oral' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_ORAL',
                'width' => '10%',
                'default' => true,
                'name' => 'oral',
            ),    
            'certificate' => array(
                'type' => 'dynamicenum',
                'studio' => 'visible',
                'label' => 'LBL_CERTIFICATE',
                'width' => '10%',
                'default' => true,
                'name' => 'certificate',
            ),   
            'certificate_date' => array(
                'type' => 'date',
                'studio' => 'visible',
                'label' => 'LBL_CERTIFICATE_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'certificate_date',
            ),          
            'assigned_user_id' => array(
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
            ),
            'current_user_only' => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
    ),
);
