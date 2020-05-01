<?php

$viewdefs['Project'] =
[
    'DetailView' => [
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
                    'file' => 'modules/Project/Project.js',
                ],
                1 => [
                    'file' => 'modules/Project/js/custom_project.js',
                ],
            ],
            'form' => [
                'buttons' => [
                    0 => [
                        'customCode' => '<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button" type="submit" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}"onclick="{if $IS_TEMPLATE}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'ProjectTemplatesEditView\';{else}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'EditView\'; {/if}"/>',
                        'sugar_html' => [
                            'type' => 'submit',
                            'value' => ' {$APP.LBL_EDIT_BUTTON_LABEL} ',
                            'htmlOptions' => [
                                'id' => 'edit_button',
                                'class' => 'button',
                                'accessKey' => '{$APP.LBL_EDIT_BUTTON_KEY}',
                                'name' => 'Edit',
                                'onclick' => '{if $IS_TEMPLATE}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'ProjectTemplatesEditView\';{else}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'EditView\'; {/if}',
                            ],
                        ],
                    ],
                    1 => [
                        'customCode' => '<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" type="button" name="Delete" id="delete_button" value="{$APP.LBL_DELETE_BUTTON_LABEL}" onclick="project_delete(this);"/>',
                        'sugar_html' => [
                            'type' => 'button',
                            'id' => 'delete_button',
                            'value' => '{$APP.LBL_DELETE_BUTTON_LABEL}',
                            'htmlOptions' => [
                                'title' => '{$APP.LBL_DELETE_BUTTON_TITLE}',
                                'accessKey' => '{$APP.LBL_DELETE_BUTTON_KEY}',
                                'id' => 'delete_button',
                                'class' => 'button',
                                'onclick' => 'project_delete(this);',
                            ],
                        ],
                    ],
                    2 => [
                        'customCode' => '<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" type="submit" name="Duplicate" id="duplicate_button" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}"onclick="{if $IS_TEMPLATE}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'projecttemplateseditview\'; this.form.return_id.value=\'{$id}\';{else}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'EditView\'; this.form.return_id.value=\'{$id}\';{/if}""/>',
                        'sugar_html' => [
                            'type' => 'submit',
                            'value' => '{$APP.LBL_DUPLICATE_BUTTON_LABEL}',
                            'htmlOptions' => [
                                'title' => '{$APP.LBL_DUPLICATE_BUTTON_TITLE}',
                                'accessKey' => '{$APP.LBL_DUPLICATE_BUTTON_KEY}',
                                'class' => 'button',
                                'name' => 'Duplicate',
                                'id' => 'duplicate_button',
                                'onclick' => '{if $IS_TEMPLATE}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'ProjectTemplatesDetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'projecttemplateseditview\'; this.form.return_id.value=\'{$id}\';{else}this.form.return_module.value=\'Project\'; this.form.return_action.value=\'DetailView\'; this.form.isDuplicate.value=true; this.form.action.value=\'EditView\'; this.form.return_id.value=\'{$id}\';{/if}',
                            ],
                        ],
                    ],
                    3 => [
                        'customCode' => '<input title="{$APP.LBL_VIEW_GANTT_TITLE}" class="button" type="button" name="view_gantt" id="view_gantt" value="{$APP.LBL_GANTT_BUTTON_LABEL}" onclick="javascript:window.location.href=\'index.php?module=Project&action=view_GanttChart&record={$id}\'"/>',
                    ],
                    4 => [
                        'customCode' => '<input title="{$APP.LBL_VIEW_DETAIL}" class="button" type="button" name="view_detail" id="view_detail" value="{$APP.LBL_DETAIL_BUTTON_LABEL}" onclick="javascript:window.location.href=\'index.php?module=Project&action=DetailView&record={$id}\'"/>',
                    ],
                ],
            ],
            'useTabs' => false,
            'tabDefs' => [
                'LBL_PROJECT_INFORMATION' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
            'syncDetailEditViews' => true,
        ],
        'panels' => [
            'lbl_project_information' => [
                0 => [
                    0 => 'name',
                    1 => 'status',
                ],
                1 => [
                    0 => [
                        'name' => 'estimated_start_date',
                        'label' => 'LBL_DATE_START',
                    ],
                    1 => 'priority',
                ],
                2 => [
                    0 => [
                        'name' => 'estimated_end_date',
                        'label' => 'LBL_DATE_END',
                    ],
                    1 => 'override_business_hours',
                ],
                3 => [
                    0 => [
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO',
                    ],
                    1 => [
                        'name' => 'am_projecttemplates_project_1_name',
                    ],
                ],
            ],
        ],
    ],
];
