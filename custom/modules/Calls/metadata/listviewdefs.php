<?php
// created: 2013-09-23 20:18:02
$listViewDefs = array (
  'Calls' => 
  array (
    'SET_COMPLETE' => 
    array (
      'width' => '1%',
      'label' => 'LBL_LIST_CLOSE',
      'link' => true,
      'sortable' => false,
      'default' => true,
      'related_fields' => 
      array (
        0 => 'status',
      ),
    ),
    'DIRECTION' => 
    array (
      'width' => '10%',
      'label' => 'LBL_LIST_DIRECTION',
      'link' => false,
      'default' => true,
    ),
    'NAME' => 
    array (
      'width' => '40%',
      'label' => 'LBL_LIST_SUBJECT',
      'link' => true,
      'default' => true,
    ),
    'CONTACT_NAME' => 
    array (
      'width' => '20%',
      'label' => 'LBL_LIST_CONTACT',
      'link' => true,
      'id' => 'CONTACT_ID',
      'module' => 'Contacts',
      'default' => true,
      'ACLTag' => 'CONTACT',
    ),
    'PARENT_NAME' => 
    array (
      'width' => '20%',
      'label' => 'LBL_LIST_RELATED_TO',
      'dynamic_module' => 'PARENT_TYPE',
      'id' => 'PARENT_ID',
      'link' => true,
      'default' => true,
      'sortable' => false,
      'ACLTag' => 'PARENT',
      'related_fields' => 
      array (
        0 => 'parent_id',
        1 => 'parent_type',
      ),
    ),
    'DATE_START' => 
    array (
      'width' => '15%',
      'label' => 'LBL_LIST_DATE',
      'link' => false,
      'default' => true,
      'related_fields' => 
      array (
        0 => 'time_start',
      ),
    ),
    'ASSIGNED_USER_NAME' => 
    array (
      'width' => '2%',
      'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
      'module' => 'Employees',
      'id' => 'ASSIGNED_USER_ID',
      'default' => true,
    ),
    'STATUS' => 
    array (
      'width' => '10%',
      'label' => 'LBL_STATUS',
      'link' => false,
      'default' => false,
    ),
    'DATE_ENTERED' => 
    array (
      'width' => '10%',
      'label' => 'LBL_DATE_ENTERED',
      'default' => true,
    ),
    'RESCHEDULE_COUNT' => 
    array (
      'type' => 'varchar',
      'studio' => 'visible',
      'label' => 'LBL_RESCHEDULE_COUNT',
      'width' => '10%',
      'default' => true,
      'sortable' => false,
    ),
  ),
);