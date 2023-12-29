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
$module_name = 'DHA_PlantillasDocumentos';
$_object_name = 'dha_plantillasdocumentos';
$viewdefs[$module_name] =
array(
    'DetailView' => array(
        'templateMeta' => array(
            'maxColumns' => '2',
            'form' => array(
                'buttons' => array(
                    0 => 'EDIT',
                    1 => 'DELETE',
                ),
            ),
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
                'LBL_STIC_PANEL_RECORD_DETAILS' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
            ),
        ),
        'panels' => array(
            'default' => array(
                0 => array(
                    0 => array(
                        'name' => 'document_name',
                        'label' => 'LBL_DOC_NAME',
                    ),
                    1 => '',
                ),
                1 => array(
                    0 => array(
                        'name' => 'uploadfile',
                        'displayParams' => array(
                            'link' => 'uploadfile',
                            'id' => 'id',
                        ),
                    ),
                    1 => '',
                ),
                2 => array(
                    0 => array(
                        'name' => 'modulo',
                        'studio' => 'visible',
                        'label' => 'LBL_MODULO',
                    ),
                    1 => '',
                ),
                3 => array(
                    0 => array(
                        'name' => 'idioma',
                        'studio' => 'visible',
                        'label' => 'LBL_IDIOMA_PLANTILLA',
                    ),
                    1 => '',
                ),
                4 => array(
                    0 => 'status',
                    1 => '',
                ),
                5 => array(
                    0 => array(
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO',
                    ),
                    1 => '',
                ),
                6 => array(
                    0 => array(
                        'name' => 'description',
                        'label' => 'LBL_DOC_DESCRIPTION',
                    ),
                    1 => '',
                ),
                7 => array(
                    0 => array(
                        'name' => 'aclroles',
                    ),
                    1 => '',
                ),
            ),
            'lbl_stic_panel_record_details' => array(
                0 => array(
                    0 => array(
                        'name' => 'created_by_name',
                        'label' => 'LBL_CREATED',
                    ),
                    1 => array(
                        'name' => 'date_entered',
                        'label' => 'LBL_DATE_ENTERED',
                        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'modified_by_name',
                        'label' => 'LBL_MODIFIED_NAME',
                    ),
                    1 => array(
                        'name' => 'date_modified',
                        'label' => 'LBL_DATE_MODIFIED',
                        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                    ),
                ),
            ),
        ),
    ),
);
