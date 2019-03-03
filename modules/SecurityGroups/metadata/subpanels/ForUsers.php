<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$subpanel_layout = array(
    'top_buttons' => array(
            array('widget_class' => 'SubPanelTopCreateButton'),
            array('widget_class' => 'SubPanelTopSelectButton'),
    ),

    'where' => '',

    'list_fields' => array(
        'name'=>array(
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '25%',
        ),
        'securitygroup_noninher_fields'=>array(
            'usage' => 'query_only',
        ),
        'securitygroup_noninherit_id'=>array(
            'usage' => 'query_only',
        ),
        'securitygroup_noninheritable'=>array(
            'name'=>'securitygroup_noninheritable',
            'vname' => 'LBL_LIST_NONINHERITABLE',
            'width' => '10%',
            'sortable'=>false,
            'widget_type'=>'checkbox',
        ),
        'securitygroup_primary_group'=>array(
            'name'=>'securitygroup_primary_group',
            'vname' => 'LBL_PRIMARY_GROUP',
            'width' => '10%',
            'sortable'=>false,
            'widget_type'=>'checkbox',
        ),
        'description'=>array(
            'vname' => 'LBL_DESCRIPTION',
            'width' => '45%',
            'sortable'=>false,
        ),
        'edit_button'=>array(
            'widget_class' => 'SubPanelEditSecurityGroupUserButton',
            'securitygroup_noninherit_id'=>'securitygroup_noninherit_id',
            'module' => 'SecurityGroups',
            'width' => '5%',
        ),
        'remove_button'=>array(
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'SecurityGroups',
            'width' => '5%',
            'refresh_page'=>true,
        ),
    ),
);
