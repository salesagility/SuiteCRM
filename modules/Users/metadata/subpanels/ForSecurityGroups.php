<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$subpanel_layout = array(
    'top_buttons' => array(
        array('widget_class' => 'SubPanelTopCreateButton'),
    ),

    'where' => '',
        
    'list_fields'=> array(
        'first_name'=>array(
            'usage' => 'query_only',
        ),
        'last_name'=>array(
            'usage' => 'query_only',
        ),
        'name'=>array(
            'vname' => 'LBL_LIST_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'module' => 'Users',
            'width' => '20%',
        ),
        'user_name'=>array(
            'vname' => 'LBL_LIST_USER_NAME',
            'width' => '20%',
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
        'email1'=>array(
            'vname' => 'LBL_LIST_EMAIL',
            'width' => '20%',
        ),
        'phone_work'=>array(
            'name'=>'phone_work',
            'vname' => 'LBL_LIST_PHONE',
            'width' => '10%',
        ),
        'edit_button'=>array(
            'widget_class' => 'SubPanelEditSecurityGroupUserButton',
            'securitygroup_noninherit_id'=>'securitygroup_noninherit_id',
            'module' => 'SecurityGroups',
            'width' => '5%',
        ),
        'remove_button'=>array(
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'Users',
            'width' => '4%',
            'linked_field' => 'users',
        ),
    ),
);
