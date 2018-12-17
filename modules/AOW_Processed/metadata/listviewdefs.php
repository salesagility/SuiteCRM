<?php
$listViewDefs ['AOW_Processed'] = 
array (
  'AOW_WORKFLOW' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_AOW_WORKFLOW',
    'id' => 'AOW_WORKFLOW_ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'PARENT_TYPE' =>
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_MODULE',
    'width' => '10%',
  ),
  'PARENT_NAME' =>
  array (
    'width' => '10%',
    'label' => 'LBL_BEAN',
    'dynamic_module' => 'PARENT_TYPE',
    'id' => 'PARENT_ID',
    'link' => true,
    'default' => true,
    'sortable' => false,
    'ACLTag' => 'PARENT',
    'related_fields' =>
    array (
        0 => 'parent_id',
        1 => 'parent_module',
    ),
  ),
  'STATUS' =>
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => true,
  ),
);
