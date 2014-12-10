<?php
$module_name = 'AOR_Scheduled_Reports';
$_module_name = 'aor_scheduled_reports';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'aor_scheduled_reports_aor_reports_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_AOR_SCHEDULED_REPORTS_AOR_REPORTS_FROM_AOR_REPORTS_TITLE',
        'id' => 'AOR_SCHEDULED_REPORTS_AOR_REPORTSAOR_REPORTS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'aor_scheduled_reports_aor_reports_name',
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'aor_scheduled_reports_aor_reports_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_AOR_SCHEDULED_REPORTS_AOR_REPORTS_FROM_AOR_REPORTS_TITLE',
        'width' => '10%',
        'default' => true,
        'id' => 'AOR_SCHEDULED_REPORTS_AOR_REPORTSAOR_REPORTS_IDA',
        'name' => 'aor_scheduled_reports_aor_reports_name',
      ),
      'current_user_only' => 
      array (
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
        'name' => 'current_user_only',
      ),
      'email' => 
      array (
        'name' => 'email',
        'label' => 'LBL_ANY_EMAIL',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>
