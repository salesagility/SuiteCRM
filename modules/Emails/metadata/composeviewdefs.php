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
$viewdefs['Emails']['ComposeView'] = [
    'templateMeta' => [
        'maxColumns' => '2',
        'widths' => [
            ['label' => '10', 'field' => '30'],
            ['label' => '10', 'field' => '30']
        ],
        'form' => [
            'headerTpl' => 'modules/Emails/include/ComposeView/ComposeViewBlank.tpl',
            'footerTpl' => 'modules/Emails/include/ComposeView/ComposeViewToolbar.tpl',
            'buttons' => [
                ['customCode' => '<button class="btn btn-send-email" title="{$MOD.LBL_SEND_BUTTON_TITLE}"><span class="glyphicon glyphicon-send"></span></button>'],
                ['customCode' => '<button class="vertical-separator"></button>'],
                ['customCode' => '<button class="btn btn-attach-file" title="{$MOD.LBL_ATTACH_FILES}"><span class="glyphicon glyphicon-paperclip"></span></button>'],
                ['customCode' => '<button class="btn btn-attach-document" title="{$MOD.LBL_ATTACH_DOCUMENTS}"><span class="glyphicon suitepicon suitepicon-module-documents"></span></button>'],
                ['customCode' => '<button class="vertical-separator"></button>'],
                ['customCode' => '<button class="btn btn-save-draft" title="{$MOD.LBL_SAVE_AS_DRAFT_BUTTON_TITLE}"><span class="glyphicon glyphicon-floppy-save"></span></button>'],
                ['customCode' => '<button class="btn btn-disregard-draft" title="{$MOD.LBL_DISREGARD_DRAFT_BUTTON_TITLE}"><span class="glyphicon glyphicon-trash"></span></button>'],
            ]
        ],
        'includes' => [
            [
                'file' => 'modules/Emails/include/ComposeView/EmailsComposeView.js',
            ],
            [
                'file' => 'vendor/tinymce/tinymce/tinymce.min.js'
            ],
            [
                'file' => 'include/javascript/qtip/jquery.qtip.min.js'
            ]
        ],
    ],
    'panels' => [
        'LBL_COMPOSE_MODULE_NAME' => [
            [
                [
                    'name' => 'emails_email_templates_name',
                    'label' => 'LBL_EMAIL_TEMPLATE',
                    'displayParams' => [
                        'call_back_function' => '$.fn.EmailsComposeView.onTemplateSelect',
                    ],
                ],
                [
                    'name' => 'parent_name',
                    'label' => 'LBL_EMAIL_RELATE',
                    'displayParams' => [
                        'call_back_function' => '$.fn.EmailsComposeView.onParentSelect',
                        'field_to_name_array' => [
                            'id' => 'parent_id',
                            'name' => 'parent_name',
                            'email1' => 'email1',
                        ]
                    ],
                ]
            ],
            [
                [
                    'name' => 'from_addr_name',
                    'label' => 'LBL_LIST_FROM_ADDR',
                ]
            ],
            [
                [
                    'name' => 'to_addrs_names',
                    'label' => 'LBL_TO',
                    'expanded' => 'true',
                ]
            ],
            [
                [
                    'name' => 'cc_addrs_names',
                    'label' => 'LBL_CC',
                    'expanded' => 'true'
                ]
            ],
            [
                [
                    'name' => 'bcc_addrs_names',
                    'label' => 'LBL_BCC',
                    'expanded' => 'true'
                ]
            ],
            [
                [
                    'name' => 'name',
                    'label' => 'LBL_SUBJECT',
                ],
            ],
            [
                [
                    'name' => 'description',
                    'label' => 'LBL_BODY',
                ]
            ],
            [
                [
                    'name' => 'description_html',
                    'label' => 'LBL_BODY',
                ]
            ],
            [
                [
                    'name' => 'is_only_plain_text',
                    'label' => 'LBL_SEND_IN_PLAIN_TEXT'
                ]
            ]
        ]
    ]
];
