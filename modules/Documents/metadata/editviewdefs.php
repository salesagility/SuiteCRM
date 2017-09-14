<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$viewdefs ['Documents'] =
    array(
        'EditView' =>
            array(
                'templateMeta' =>
                    array(
                        'form' =>
                            array(
                                'enctype' => 'multipart/form-data',
                                'hidden' =>
                                    array(
                                        0 => '<input type="hidden" name="old_id" value="{$fields.document_revision_id.value}">',
                                        1 => '<input type="hidden" name="contract_id" value="{$smarty.request.contract_id}">',
                                    ),
                            ),
                        'maxColumns' => '2',
                        'widths' =>
                            array(
                                0 =>
                                    array(
                                        'label' => '10',
                                        'field' => '30',
                                    ),
                                1 =>
                                    array(
                                        'label' => '10',
                                        'field' => '30',
                                    ),
                            ),
                        'javascript' => '{sugar_getscript file="include/javascript/popup_parent_helper.js"}
{sugar_getscript file="cache/include/javascript/sugar_grp_jsolait.js"}
{sugar_getscript file="modules/Documents/documents.js"}',
                        'useTabs' => false,
                        'tabDefs' =>
                            array(
                                'LBL_DOCUMENT_INFORMATION' =>
                                    array(
                                        'newTab' => false,
                                        'panelDefault' => 'expanded',
                                    ),
                            ),
                    ),
                'panels' =>
                    array(
                        'lbl_document_information' =>
                            array(
                                0 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'filename',
                                                'displayParams' =>
                                                    array(
                                                        'onchangeSetFileNameTo' => 'document_name',
                                                    ),
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'status_id',
                                                'label' => 'LBL_DOC_STATUS',
                                            ),
                                    ),
                                1 =>
                                    array(
                                        0 => 'document_name',
                                        1 =>
                                            array(
                                                'name' => 'revision',
                                                'customCode' => '<input name="revision" type="text" value="{$fields.revision.value}" {$DISABLED}>',
                                            ),
                                    ),
                                2 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'template_type',
                                                'label' => 'LBL_DET_TEMPLATE_TYPE',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'is_template',
                                                'label' => 'LBL_DET_IS_TEMPLATE',
                                            ),
                                    ),
                                3 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'active_date',
                                            ),
                                        1 => 'exp_date',
                                    ),
                                4 =>
                                    array(
                                        0 => 'category_id',
                                        1 => 'subcategory_id',
                                    ),
                                5 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'description',
                                            ),
                                    ),
                                6 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'related_doc_name',
                                                'customCode' => '<input name="related_document_name" type="text" size="30" maxlength="255" value="{$RELATED_DOCUMENT_NAME}" readonly><input name="related_doc_id" type="hidden" value="{$fields.related_doc_id.value}"/>&nbsp;<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="{$RELATED_DOCUMENT_BUTTON_AVAILABILITY}" class="button" value="{$APP.LBL_SELECT_BUTTON_LABEL}" name="btn2" onclick=\'open_popup("Documents", 600, 400, "", true, false, {$encoded_document_popup_request_data}, "single", true);\'/>',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'related_doc_rev_number',
                                                'customCode' => '<select name="related_doc_rev_id" id="related_doc_rev_id" {$RELATED_DOCUMENT_REVISION_DISABLED}>{$RELATED_DOCUMENT_REVISION_OPTIONS}</select>',
                                            ),
                                    ),
                                7 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'assigned_user_name',
                                                'label' => 'LBL_ASSIGNED_TO_NAME',
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
