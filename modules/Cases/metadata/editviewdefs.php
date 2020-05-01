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
$viewdefs['Cases'] =
[
    'EditView' => [
        'templateMeta' => [
            'maxColumns' => '2',
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
            'includes' => [
                0 => [
                    'file' => 'include/javascript/bindWithDelay.js',
                ],
                1 => [
                    'file' => 'modules/AOK_KnowledgeBase/AOK_KnowledgeBase_SuggestionBox.js',
                ],
                2 => [
                    'file' => 'include/javascript/qtip/jquery.qtip.min.js',
                ],
            ],
            'useTabs' => false,
            'tabDefs' => [
                'LBL_CASE_INFORMATION' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
            'form' => [
                'enctype' => 'multipart/form-data',
            ],
        ],
        'panels' => [
            'lbl_case_information' => [
                0 => [
                    0 => [
                        'name' => 'case_number',
                        'type' => 'readonly',
                    ],
                    1 => 'priority',
                ],
                1 => [
                    0 => [
                        'name' => 'state',
                        'comment' => 'The state of the case (i.e. open/closed)',
                        'label' => 'LBL_STATE',
                    ],
                    1 => 'status',
                ],
                2 => [
                    0 => 'type',
                    1 => 'account_name',
                ],
                3 => [
                    0 => [
                        'name' => 'name',
                        'displayParams' => [
                            //'size' => 75,
                        ],
                    ],
                    1 => [
                        'name' => 'suggestion_box',
                        //'studio' => 'visible',
                        'label' => 'LBL_SUGGESTION_BOX'
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'description',
                    ],
                ],
                5 => [
                    0 => [
                        'name' => 'resolution',
                        'nl2br' => true,
                    ],
                ],
                6 => [
                    0 => [
                        'name' => 'update_text',
                        'studio' => 'visible',
                        'label' => 'LBL_UPDATE_TEXT',
                    ],
                ],
                7 => [
                    0 => [
                        'name' => 'internal',
                        'studio' => 'visible',
                        'label' => 'LBL_INTERNAL',
                    ],
                ],
                8 => [
                    0 => [
                        'name' => 'case_update_form',
                        'studio' => 'visible',
                    ],
                ],
                9 => [
                    0 => 'assigned_user_name',
                ],
            ],
        ],
    ],
];
