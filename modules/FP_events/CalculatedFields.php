<?php

function nb_where($focus, $where) { 
	global $db;
	$total = 0;
	$query = "SELECT count( * ) AS nb FROM fp_events_contacts_c WHERE  $where AND deleted =0 AND fp_events_contactsfp_events_ida LIKE '{$focus->id}'";
	$result = $db->query($query);	
	$row = $db->fetchByAssoc($result);
	if ($row) {
		$total += $row['nb'];
	}
	$query = "SELECT count( * ) AS nb FROM fp_events_leads_1_c WHERE  $where AND deleted =0 AND fp_events_leads_1fp_events_ida LIKE '{$focus->id}'";
	$result = $db->query($query);	
	$row = $db->fetchByAssoc($result);
	if ($row) {
		$total += $row['nb'];
	}
	$query = "SELECT count( * ) AS nb FROM fp_events_prospects_1_c WHERE  $where AND deleted =0 AND fp_events_prospects_1fp_events_ida LIKE '{$focus->id}'";
	$result = $db->query($query);	
	$row = $db->fetchByAssoc($result);
	if ($row) {
		$total += $row['nb'];
	}
	return $total;
}

function nb_invites($focus, $field, $value, $view) { //This is the function that the field will run when it is displayed
	global $db;
	return nb_where($focus,  "invite_status != 'Not Invited'");
}

function nb_accept($focus, $field, $value, $view) { //This is the function that the field will run when it is displayed
	global $db;
	return nb_where($focus,  "accept_status = 'Accepted'");
}

function nb_declined($focus, $field, $value, $view) { //This is the function that the field will run when it is displayed
	global $db;
	return nb_where($focus,  "accept_status = 'Declined'");
}

function nb_attended($focus, $field, $value, $view) { //This is the function that the field will run when it is displayed
	global $db;
	return nb_where($focus,  "invite_status = 'Attended'");
}
