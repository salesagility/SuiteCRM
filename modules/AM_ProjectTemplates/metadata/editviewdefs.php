<?php

$module_name = 'AM_ProjectTemplates';
$viewdefs[$module_name] =
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

            'form' => [
                'headerTpl' => 'modules/AM_ProjectTemplates/tpls/header.tpl',
                'footerTpl' => 'modules/AM_ProjectTemplates/tpls/footer.tpl',
                'buttons' => [
                    0 => [
                        'customCode' => '<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" id ="SAVE_HEADER" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="SUGAR.project_template.fill_invitees();document.EditView.action.value=\'Save\'; document.EditView.return_action.value=\'view_GanttChart\'; {if isset($smarty.request.isDuplicate) && $smarty.request.isDuplicate eq "true"}document.EditView.return_id.value=\'\'; {/if} formSubmitCheck();"type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">',
                    ],
                    1 => 'CANCEL',
                ],
                'buttons_footer' => [
                    0 => [
                        'customCode' => '<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" id ="SAVE_HEADER" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="SUGAR.project_template.fill_invitees();document.EditView.action.value=\'Save\'; document.EditView.return_action.value=\'view_GanttChart\'; {if isset($smarty.request.isDuplicate) && $smarty.request.isDuplicate eq "true"}document.EditView.return_id.value=\'\'; {/if} formSubmitCheck();"type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">',
                    ],
                    1 => 'CANCEL',
                ],
            ],
            'javascript' => '<script type="text/javascript">{$JSON_CONFIG_JAVASCRIPT}</script>
		{sugar_getscript file="cache/include/javascript/sugar_grp_project_template.js"}
		<script>toggle_portal_flag();function toggle_portal_flag()  {ldelim} {$TOGGLE_JS} {rdelim} 
		function formSubmitCheck(){ldelim}if(check_form(\'EditView\')){ldelim}document.EditView.submit();{rdelim}{rdelim}</script>',

            'useTabs' => false,
            'tabDefs' => [
                'DEFAULT' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_ASSIGNMENT' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
            'syncDetailEditViews' => true,
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => 'name',
                    1 => [
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ],
                ],
                1 => [
                    0 => 'override_business_hours',
                    1 => [
                        'name' => 'priority',
                        'studio' => 'visible',
                        'label' => 'LBL_PRIORITY',
                    ],
                ],

                2 => [
                    0 => 'assigned_user_name',
                ],
            ],
        ],
    ],
];
