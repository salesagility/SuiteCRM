<?php

$dictionary['AOM_Reminder']['table']= 'aom_reminders';
$dictionary['AOM_Reminder']['audited']= true;
$dictionary['AOM_Reminder']['fields']= array(
    'popup' => array(
        'name' => 'popup',
        'vname' => 'LBL_POPUP',
        'type' => 'bool',
        'required' => false,
        'massupdate' => false,
        'studio' => false,
    ),
//    'popup_sent' => array(
//        'name' => 'popup_sent',
//        'vname' => 'LBL_POPUP_SENT',
//        'type' => 'bool',
//        'required' => false,
//        'massupdate' => false,
//        'studio' => false,
//    ),
//    'popup_read' => array(
//        'name' => 'popup_read',
//        'vname' => 'LBL_POPUP_READ',
//        'type' => 'bool',
//        'required' => false,
//        'massupdate' => false,
//        'studio' => false,
//    ),
    'email' => array(
        'name' => 'email',
        'vname' => 'LBL_EMAIL',
        'type' => 'bool',
        'required' => false,
        'massupdate' => false,
        'studio' => false,
    ),
    'email_sent' => array(
        'name' => 'email_sent',
        'vname' => 'LBL_EMAIL_SENT',
        'type' => 'bool',
        'required' => false,
        'massupdate' => false,
        'studio' => false,
    ),
//    'email_read' => array(
//        'name' => 'email_read',
//        'vname' => 'LBL_EMAIL_READ',
//        'type' => 'bool',
//        'required' => false,
//        'massupdate' => false,
//        'studio' => false,
//    ),
    'duration' => array(
        'name' => 'duration',
        'vname' => 'LBL_DURATION',
        'type' => 'varchar',
        'len' => 32,
        'required' => true,
        'massupdate' => false,
        'studio' => false,
    ),
    'related_event_module' => array(
        'name' => 'related_event_module',
        'vname' => 'LBL_RELATED_EVENT_MODULE',
        'type' => 'varchar',
        'len' => 32,
        'required' => true,
        'massupdate' => false,
        'studio' => false,
    ),
    'related_event_module_id' => array(
        'name' => 'related_event_module_id',
        'vname' => 'LBL_RELATED_EVENT_MODULE_ID',
        'type' => 'id',
        'required' => true,
        'massupdate' => false,
        'studio' => false,
    ),
);


if (!class_exists('VardefManager')){
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('AOM_Reminders','AOM_Reminder', array('basic','assignable'));

?>