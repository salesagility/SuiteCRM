<?php
/**
 * sps_projectsLayoutdefs.php
 * @author SalesAgility <support@salesagility.com>
 * Date: 27/01/14
 */


$layout_defs["Project"]["subpanel_setup"]["history"]['searchdefs'] =
array (
    'collection' =>
        array (
            'name' => 'collection',
            'label' => 'LBL_COLLECTION_TYPE',
            'type' => 'enum',
            'options' => $GLOBALS['app_list_strings']['collection_temp_list'],
            'default' => true,
            'width' => '10%',
        ),
    'name' =>
        array (
            'name' => 'name',
            'default' => true,
            'width' => '10%',
        ),
    'current_user_only' =>
        array (
            'name' => 'current_user_only',
            'label' => 'LBL_CURRENT_USER_FILTER',
            'type' => 'bool',
            'default' => true,
            'width' => '10%',
        ),
    'date_modified' =>
        array (
            'name' => 'date_modified',
            'default' => true,
            'width' => '10%',
        ),
);

$layout_defs["Project"]["subpanel_setup"]["history"]['top_buttons'][] = array('widget_class' => 'SubPanelTopFilterButton');