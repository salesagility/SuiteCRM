<?php
// created: 2013-04-25 10:18:48
$dictionary["FP_events"]["fields"]["fp_event_locations_fp_events_1"] = array (
  'name' => 'fp_event_locations_fp_events_1',
  'type' => 'link',
  'relationship' => 'fp_event_locations_fp_events_1',
  'source' => 'non-db',
  'vname' => 'LBL_FP_EVENT_LOCATIONS_FP_EVENTS_1_FROM_FP_EVENT_LOCATIONS_TITLE',
  'id_name' => 'fp_event_locations_fp_events_1fp_event_locations_ida',
);
$dictionary["FP_events"]["fields"]["fp_event_locations_fp_events_1_name"] = array (
  'name' => 'fp_event_locations_fp_events_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_FP_EVENT_LOCATIONS_FP_EVENTS_1_FROM_FP_EVENT_LOCATIONS_TITLE',
  'save' => true,
  'id_name' => 'fp_event_locations_fp_events_1fp_event_locations_ida',
  'link' => 'fp_event_locations_fp_events_1',
  'table' => 'fp_event_locations',
  'module' => 'FP_Event_Locations',
  'rname' => 'name',
);
$dictionary["FP_events"]["fields"]["fp_event_locations_fp_events_1fp_event_locations_ida"] = array (
  'name' => 'fp_event_locations_fp_events_1fp_event_locations_ida',
  'type' => 'link',
  'relationship' => 'fp_event_locations_fp_events_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_FP_EVENT_LOCATIONS_FP_EVENTS_1_FROM_FP_EVENTS_TITLE',
);
