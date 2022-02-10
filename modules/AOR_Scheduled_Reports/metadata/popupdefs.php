<?php
$popupMeta = array(
    'moduleMain' => 'AOR_Scheduled_Reports',
    'varName' => 'AOR_Scheduled_Reports',
    'orderBy' => 'aor_scheduled_reports.name',
    'whereClauses' => array(
  'name' => 'aor_scheduled_reports.name',
  'aor_report_name' => 'aor_scheduled_reports.aor_report_name',
),
    'searchInputs' => array(
  0 => 'name',
  5 => 'aor_report_name',
),
    'searchdefs' => array(
  'name' =>
  array(
    'name' => 'name',
    'width' => '10%',
  ),
  'aor_report_name' =>
  array(
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_AOR_REPORT_NAME',
    'id' => 'AOR_REPORTSAOR_REPORTS_IDA',
    'width' => '10%',
    'name' => 'aor_report_name',
  ),
),
);
