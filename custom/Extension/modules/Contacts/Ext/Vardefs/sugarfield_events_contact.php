<?php

$dictionary['Contact']['fields']['e_invite_status_fields'] =
		array (
			'name' => 'e_invite_status_fields',
			'rname' => 'id',
			'relationship_fields'=>array('id' => 'event_invite_id', 'invite_status' => 'event_status_name'),
			'vname' => 'LBL_CONT_INVITE_STATUS',
			'type' => 'relate',
			'link' => 'fp_events_contacts',
			'link_type' => 'relationship_info',
            'join_link_name' => 'fp_events_contacts',
			'source' => 'non-db',
			'importable' => 'false',
            'duplicate_merge'=> 'disabled',
			'studio' => false,
		);

$dictionary['Contact']['fields']['event_status_name'] =
		array(
            'massupdate' => false,
            'name' => 'event_status_name',
            'type' => 'enum',
            'studio' => 'false',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_INVITE_STATUS_EVENT',
            'options' => 'fp_event_invite_status_dom',
            'importable' => 'false',
        );
$dictionary['Contact']['fields']['event_invite_id'] =
    array(
        'name' => 'event_invite_id',
        'type' => 'varchar',
        'source' => 'non-db',
        'vname' => 'LBL_LIST_INVITE_STATUS',
        'studio' => array('listview' => false),
    );


$dictionary['Contact']['fields']['e_accept_status_fields'] =
        array (
            'name' => 'e_accept_status_fields',
            'rname' => 'id',
            'relationship_fields'=>array('id' => 'event_status_id', 'accept_status' => 'event_accept_status'),
            'vname' => 'LBL_CONT_ACCEPT_STATUS',
            'type' => 'relate',
            'link' => 'fp_events_contacts',
            'link_type' => 'relationship_info',
            'join_link_name' => 'fp_events_contacts',
            'source' => 'non-db',
            'importable' => 'false',
            'duplicate_merge'=> 'disabled',
            'studio' => false,
        );


$dictionary['Contact']['fields']['event_accept_status'] =
        array(
            'massupdate' => false,
            'name' => 'event_accept_status',
            'type' => 'enum',
            'studio' => 'false',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_ACCEPT_STATUS_EVENT',
            'options' => 'fp_event_status_dom',
            'importable' => 'false',
        );
$dictionary['Contact']['fields']['event_status_id'] =
    array(
        'name' => 'event_status_id',
        'type' => 'varchar',
        'source' => 'non-db',
        'vname' => 'LBL_LIST_ACCEPT_STATUS',
        'studio' => array('listview' => false),
    );
