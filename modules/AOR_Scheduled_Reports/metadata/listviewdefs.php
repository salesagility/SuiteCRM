<?php
$module_name = 'AOR_Scheduled_Reports';
$OBJECT_NAME = 'AOR_SCHEDULED_REPORTS';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '40%',
    'label' => 'LBL_NAME',
    'link' => true,
    'default' => true,
  ),
  'SCHEDULE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SCHEDULE',
    'width' => '10%',
    'default' => true,
  ),
  'AOR_SCHEDULED_REPORTS_AOR_REPORTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_AOR_SCHEDULED_REPORTS_AOR_REPORTS_FROM_AOR_REPORTS_TITLE',
    'id' => 'AOR_SCHEDULED_REPORTS_AOR_REPORTSAOR_REPORTS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'EMAIL1' => 
  array (
    'width' => '15%',
    'label' => 'LBL_EMAIL_ADDRESS',
    'sortable' => false,
    'link' => true,
    'customCode' => '{$EMAIL1_LINK}{$EMAIL1}</a>',
    'default' => true,
  ),
);
?>
