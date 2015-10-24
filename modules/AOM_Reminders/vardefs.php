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
    'timer' => array(
        'name' => 'timer',
        'vname' => 'LBL_TIMER',
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