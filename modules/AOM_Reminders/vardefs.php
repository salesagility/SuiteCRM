<?php

$dictionary['AOM_Reminders']['table']= 'aom_reminders';
$dictionary['AOM_Reminders']['audited']= true;
$dictionary['AOM_Reminders']['fields']= array(
    'popup' => array(
        'name' => 'popup',
        'vname' => 'LBL_POPUP',
        'type' => 'bool',
        'required' => false,
        'massupdate' => false,
        'studio' => false,
    ),
    'popup_sent' => array(
        'name' => 'popup_sent',
        'vname' => 'LBL_POPUP_SENT',
        'type' => 'bool',
        'required' => false,
        'massupdate' => false,
        'studio' => false,
    ),
    'popup_read' => array(
        'name' => 'popup_read',
        'vname' => 'LBL_POPUP_READ',
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
    'email_read' => array(
        'name' => 'email_read',
        'vname' => 'LBL_EMAIL_READ',
        'type' => 'bool',
        'required' => false,
        'massupdate' => false,
        'studio' => false,
    ),
    'duration' => array(
        'name' => 'duration',
        'vname' => 'LBL_DURATION',
        'type' => 'varchar',
        'len' => 32,
        'required' => true,
        'massupdate' => false,
        'studio' => false,
    )
);


if (!class_exists('VardefManager')){
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('AOM_Reminders','Reminder', array('basic','assignable'));

?>