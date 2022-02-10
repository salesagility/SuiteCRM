<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

//$module_name='SecurityGroups';
$subpanel_layout = array(
    'top_buttons' => array(
            array('widget_class' => 'SubPanelTopSelectButton'),
    ),

    'where' => '',

    'list_fields' => array(
        'name'=>array(
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '9999%',
        ),
        'description'=>array(
            'vname' => 'LBL_DESCRIPTION',
            'width' => '9999%',
            'sortable'=>false,
        ),
        'remove_button'=>array(
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'SecurityGroups',
            'width' => '5%',
            //'refresh_page'=>true,
        ),
    ),
);
