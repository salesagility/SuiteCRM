<?php
$popupMeta = array(
    'moduleMain' => 'AOR_Scheduled_Reports',
    'varName' => 'AOR_Scheduled_Reports',
    'orderBy' => 'aor_scheduled_reports.name',
    'whereClauses' => array(
  'name' => 'aor_scheduled_reports.name',
  'email' => 'aor_scheduled_reports.email',
  'aor_reports_name' => 'aor_scheduled_reports.aor_reports_name',
),
    'searchInputs' => array(
  0 => 'name',
  4 => 'email',
  5 => 'aor_reports_name',
),
    'searchdefs' => array(
  'name' =>
  array(
    'name' => 'name',
    'width' => '10%',
  ),
  'email' =>
  array(
    'name' => 'email',
    'label' => 'LBL_ANY_EMAIL',
    'type' => 'name',
    'width' => '10%',
  ),
  'aor_reports_name' =>
  array(
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_AOR_REPORTS_FROM_AOR_REPORTS_TITLE',
    'id' => 'AOR_REPORTSAOR_REPORTS_IDA',
    'width' => '10%',
    'name' => 'aor_reports_name',
  ),
),
);
