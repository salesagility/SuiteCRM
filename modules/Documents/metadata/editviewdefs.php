<?php

$viewdefs['Documents'] =
[
    'EditView' => [
        'templateMeta' => [
            'form' => [
                'enctype' => 'multipart/form-data',
                'hidden' => [
                    0 => '<input type="hidden" name="old_id" value="{$fields.document_revision_id.value}">',
                    1 => '<input type="hidden" name="contract_id" value="{$smarty.request.contract_id}">',
                ],
            ],
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
            'javascript' => '{sugar_getscript file="include/javascript/popup_parent_helper.js"}
{sugar_getscript file="cache/include/javascript/sugar_grp_jsolait.js"}
{sugar_getscript file="modules/Documents/documents.js"}',
            'useTabs' => false,
            'tabDefs' => [
                'LBL_DOCUMENT_INFORMATION' => [
                    'newTab' => false,
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
                            'onchangeSetFileNameTo' => 'document_name',
                        ],
                    ],
                    1 => [
                        'name' => 'status_id',
                        'label' => 'LBL_DOC_STATUS',
                    ],
                ],
                1 => [
                    0 => 'document_name',
                    1 => [
                        'name' => 'revision',
                        'customCode' => '<input name="revision" type="text" value="{$fields.revision.value}" {$DISABLED}>',
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
                    0 => [
                        'name' => 'active_date',
                    ],
                    1 => 'exp_date',
                ],
                4 => [
                    0 => 'category_id',
                    1 => 'subcategory_id',
                ],
                5 => [
                    0 => [
                        'name' => 'description',
                    ],
                ],
                6 => [
                    0 => [
                        'name' => 'related_doc_name',
                        'customCode' => '<input name="related_document_name" type="text" size="30" maxlength="255" value="{$RELATED_DOCUMENT_NAME}" readonly><input name="related_doc_id" type="hidden" value="{$fields.related_doc_id.value}"/>&nbsp;<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="{$RELATED_DOCUMENT_BUTTON_AVAILABILITY}" class="button" value="{$APP.LBL_SELECT_BUTTON_LABEL}" name="btn2" onclick=\'open_popup("Documents", 600, 400, "", true, false, {$encoded_document_popup_request_data}, "single", true);\'/>',
                    ],
                    1 => [
                        'name' => 'related_doc_rev_number',
                        'customCode' => '<select name="related_doc_rev_id" id="related_doc_rev_id" {$RELATED_DOCUMENT_REVISION_DISABLED}>{$RELATED_DOCUMENT_REVISION_OPTIONS}</select>',
                    ],
                ],
                7 => [
                    0 => [
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO_NAME',
                    ],
                ],
            ],
        ],
    ],
];
