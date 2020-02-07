<?php

$dictionary['jjwg_Address_Cache'] = array(
    'table'=>'jjwg_address_cache',
    'audited'=>true,
    'fields'=>array(
  'lat' =>
  array(
    'required' => true,
    'name' => 'lat',
    'vname' => 'LBL_LAT',
    'type' => 'float',
    'massupdate' => 0,
    'comments' => '',
    'help' => 'Latitude',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '10',
    'size' => '20',
    'precision' => '8',
  ),
  'lng' =>
  array(
    'required' => true,
    'name' => 'lng',
    'vname' => 'LBL_LNG',
    'type' => 'float',
    'massupdate' => 0,
    'comments' => '',
    'help' => 'Longitude',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '11',
    'size' => '20',
    'precision' => '8',
  ),
  'name' =>
  array(
    'name' => 'name',
    'vname' => 'LBL_NAME',
    'type' => 'name',
    'dbType' => 'varchar',
    'len' => '255',
    'unified_search' => true,
    'required' => true,
    'importable' => 'required',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'size' => '20',
  ),
),
    'relationships'=>array(
),
    'optimistic_locking'=>true,
);
if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('jjwg_Address_Cache', 'jjwg_Address_Cache', array('basic','assignable'));
