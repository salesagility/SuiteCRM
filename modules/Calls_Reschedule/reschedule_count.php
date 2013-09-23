<?php

class reschedule_count {

    //Counts the number of call attempts made, for displaying in calls list view
    function count($focus, $event, $args){

        //$query = 'SELECT COUNT(*) FROM calls_reschedule WHERE call_id="'.$focus->id.'"';
        //$result = $focus->db->getOne($query);

        //$focus->reschedule_count = $result;

	require_once('custom/modules/Calls/reschedule_history.php');

	reschedule_count($focus, '', '', 'ListView');


    } 

	


}
