<?php
/**
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
$viewdefs['Documents'] =
[
    'DetailView' => [
        'templateMeta' => [
            'maxColumns' => '2',
            'form' => [
                'buttons' => [
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                ],
                'headerTpl' => 'modules/Documents/tpls/detailHeader.tpl',
            ],
            [
                'hidden' => [
                    0 => '<input type="hidden" name="old_id" value="{$fields.document_revision_id.value}">',
                ],
            ],
            'widths' => [
                0 => [
                    'label' => '10',
                    'field' => '30',
                ],
                1 => [
                    'label' => '10',
                    'field' => '30',
                ],
            ],
            'useTabs' => true,
            'tabDefs' => [
                'LBL_DOCUMENT_INFORMATION' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_ASSIGNMENT' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
            ],
        ],
        'panels' => [
            'lbl_document_information' => [
                0 => [
                    0 => [
                        'name' => 'filename',
                        'displayParams' => [
                            'link' => 'filename',
                            'id' => 'document_revision_id',
                        ],
                    ],
                    1 => [
                        'name' => 'status_id',
                        'label' => 'LBL_DOC_STATUS',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'document_name',
                        'label' => 'LBL_DOC_NAME',
                    ],
                    1 => [
                        'name' => 'revision',
                        'label' => 'LBL_DOC_VERSION',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'template_type',
                        'label' => 'LBL_DET_TEMPLATE_TYPE',
                    ],
                    1 => [
                        'name' => 'is_template',
                        'label' => 'LBL_DET_IS_TEMPLATE',
                    ],
                ],
                3 => [
                    0 => 'active_date',
                    1 => 'exp_date',
                ],
                4 => [
                    0 => 'category_id',
                    1 => 'subcategory_id',
                ],
                5 => [
                    0 => '',
                    1 => '',
                ],
                6 => [
                    0 => 'related_doc_name',
                    1 => 'related_doc_rev_number',
                ],
                7 => [
                    0 => [
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO_NAME',
                    ],
                ],
            ],
            'LBL_PANEL_ASSIGNMENT' => [
                0 => [
                    0 => [
                        'name' => 'date_entered',
                        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                    ],
                    1 => [
                        'name' => 'date_modified',
                        'label' => 'LBL_DATE_MODIFIED',
                        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                    ],
                ],
            ],
        ],
    ],
];
