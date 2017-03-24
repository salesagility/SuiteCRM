<?php

if (!defined('sugarEntry') || !sugarEntry || !defined('SUGAR_ENTRY') || !SUGAR_ENTRY) {
    die('Not A Valid Entry Point');
}
if (defined('sugarEntry')) {
    $deprecatedMessage = 'sugarEntry is deprecated use SUGAR_ENTRY instead';
    if (isset($GLOBALS['log'])) {
        $GLOBALS['log']->deprecated($deprecatedMessage);
    } else {
        trigger_error($deprecatedMessage, E_USER_DEPRECATED);
    }
}


$dashletData['jjwg_Adress_CacheDashlet']['searchFields'] = array('date_entered' => array('default' => ''),
    'date_modified' => array('default' => ''),
    'assigned_user_id' => array('type' => 'assigned_user_name',
        'default' => $GLOBALS['current_user']->name));
$dashletData['jjwg_Adress_CacheDashlet']['columns'] = array('name' => array('width' => '40',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true),
    'date_entered' => array('width' => '15',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true),
    'date_modified' => array('width' => '15',
        'label' => 'LBL_DATE_MODIFIED'),
    'created_by' => array('width' => '8',
        'label' => 'LBL_CREATED'),
    'assigned_user_name' => array('width' => '8',
        'label' => 'LBL_LIST_ASSIGNED_USER'),
);
