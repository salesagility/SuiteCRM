<?php

$dictionary['AOM_Reminder_Invitee']['table']= 'aom_reminders_invitees';
$dictionary['AOM_Reminder_Invitee']['audited']= true;
$dictionary['AOM_Reminder_Invitee']['fields']= array(
    'reminder_id' => array(
        'name' => 'reminder_id',
        'vname' => 'LBL_REMINDER_ID',
        'type' => 'id',
        'required' => true,
        'massupdate' => false,
        'studio' => false,
    ),
    'related_invitee_module' => array(
        'name' => 'related_invitee_module',
        'vname' => 'LBL_RELATED_INVITEE_MODULE',
        'type' => 'varchar',
        'len' => 32,
        'required' => true,
        'massupdate' => false,
        'studio' => false,
    ),
    'related_invitee_module_id' => array(
        'name' => 'related_invitee_module_id',
        'vname' => 'LBL_RELATED_INVITEE_MODULE_ID',
        'type' => 'id',
        'required' => true,
        'massupdate' => false,
        'studio' => false,
    ),
);

//$dictionary['AOM_Reminder_Invitee']['indices'] = array(
//    array('name' => 'reminder_invitee_uk', 'type' => 'unique', 'fields' => array('reminder_id', 'related_invitee_module', 'related_invitee_module_id')),
//);


if (!class_exists('VardefManager')){
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('AOM_Reminders_Invitees','AOM_Reminder_Invitee', array('basic','assignable'));

?>