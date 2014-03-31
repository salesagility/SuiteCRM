<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrew
 * Date: 01/03/13
 * Time: 15:13
 * To change this template use File | Settings | File Templates.
 */

$dictionary['Call']['fields']['reschedule_history'] = array(

    'required' => false,
    'name' => 'reschedule_history',
    'vname' => 'LBL_RESCHEDULE_HISTORY',
    'type' => 'varchar',
    'source' => 'non-db',
    'studio' => 'visible',
    'massupdate' => 0,
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => false,
    'function' =>
    array (
        'name' => 'reschedule_history',
        'returns' => 'html',
        'include' => 'custom/modules/Calls/reschedule_history.php'
    ),
);

$dictionary['Call']['fields']['reschedule_count'] = array(

    'required' => false,
    'name' => 'reschedule_count',
    'vname' => 'LBL_RESCHEDULE_COUNT',
    'type' => 'varchar',
    'source' => 'non-db',
    'studio' => 'visible',
    'massupdate' => 0,
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => false,
    'function' =>
    array (
        'name' => 'reschedule_count',
        'returns' => 'html',
        'include' => 'custom/modules/Calls/reschedule_history.php'
    ),
);

// created: 2010-12-20 02:55:45
$dictionary["Call"]["fields"]["calls_reschedule"] = array (
    'name' => 'calls_reschedule',
    'type' => 'link',
    'relationship' => 'calls_reschedule',
    'module'=>'Calls_Reschedule',
    'bean_name'=>'Calls_Reschedule',
    'source'=>'non-db',
);


// created: 2010-12-20 02:56:01
$dictionary["Call"]["relationships"]["calls_reschedule"] = array (
    'lhs_module'=> 'Calls',
    'lhs_table'=> 'calls',
    'lhs_key' => 'id',
    'rhs_module'=> 'Calls_Reschedule',
    'rhs_table'=> 'calls_reschedule',
    'rhs_key' => 'call_id',
    'relationship_type'=>'one-to-many',
);
?>
