<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

	global $db;
	 
	$even_id = $_GET['event'];
	$delegate_id = $_GET['delegate'];
	$type = $_GET['type'];
	$response = $_GET['response'];	

	//get event
    $event = new FP_events();
    $event->retrieve($even_id);
    
    if($type == 'c'){
    	
    	$event->load_relationship('fp_events_contacts'); // get related contacts

    	if($response == 'accept'){

            //check to see if they have already responded to the email
            $check_q = 'SELECT email_responded FROM fp_events_contacts_c WHERE fp_events_contactsfp_events_ida="'.$event->id.'" AND fp_events_contactscontacts_idb="'.$delegate_id.'"';
             $check = $db->getOne($check_q);
    		//update contact to accepted
    		$query = 'UPDATE fp_events_contacts_c SET accept_status="Accepted", email_responded="1" WHERE fp_events_contactsfp_events_ida="'.$event->id.'" AND fp_events_contactscontacts_idb="'.$delegate_id.'" AND email_responded="0"';
    		if($db->query($query) && $check != '1'){
    			
                if(!IsNullOrEmptyString($event->accept_redirect)){
                    
                    $url = $event->accept_redirect;
                    header('Location: ' . $url);    
                } else{
                    echo 'Thank you for accepting';
                }   
    		} else {
    			echo 'You have already responded to the invitation or there was a problem with the link. Please contact the sender of the invite for help.';
    		}	
    	} else if($response == 'decline'){
    		//check to see if they have already responded to the email
            $check_q = 'SELECT email_responded FROM fp_events_contacts_c WHERE fp_events_contactsfp_events_ida="'.$event->id.'" AND fp_events_contactscontacts_idb="'.$delegate_id.'"';
             $check = $db->getOne($check_q);
            //update contact to accepted
    		$query = 'UPDATE fp_events_contacts_c SET accept_status="Declined", email_responded="1" WHERE fp_events_contactsfp_events_ida="'.$event->id.'" AND fp_events_contactscontacts_idb="'.$delegate_id.'" AND email_responded="0"';
    		
            if($db->query($query) && $check != '1'){
    			
                if(!IsNullOrEmptyString($event->decline_redirect)){

                    $url = $event->decline_redirect;
                    header('Location: ' . $url);    
                    
                } else{
                    echo 'Thank you for declining';
                }
    		} else {
    			echo 'You have already responded to the invitation or there was a problem with the link. Please contact the sender of the invite for help.';
    		}
    	}
    }
    if($type == 't'){
    	
    	$event->load_relationship('fp_events_prospects_1'); //get related targets

    	if($response == 'accept'){
            //check to see if they have already responded to the email
            $check_q = 'SELECT email_responded FROM fp_events_prospects_1_c WHERE fp_events_prospects_1fp_events_ida="'.$event->id.'" AND fp_events_prospects_1prospects_idb="'.$delegate_id.'"';
             $check = $db->getOne($check_q);

    		//update contact to accepted
    		$query = 'UPDATE fp_events_prospects_1_c SET accept_status="Accepted", email_responded="1" WHERE fp_events_prospects_1fp_events_ida="'.$event->id.'" AND fp_events_prospects_1prospects_idb="'.$delegate_id.'" AND email_responded="0"';
    		if($db->query($query) && $check != '1'){
                
                if(!IsNullOrEmptyString($event->accept_redirect)){
                    
                    $url = $event->accept_redirect;
                    header('Location: ' . $url);    
                } else{
                    echo 'Thank you for accepting';
                }   
            } else {
                echo 'You have already responded to the invitation or there was a problem with the link. Please contact the sender of the invite for help.';
            }   
    	} else if($response == 'decline'){
            //check to see if they have already responded to the email
            $check_q = 'SELECT email_responded FROM fp_events_prospects_1_c WHERE fp_events_prospects_1fp_events_ida="'.$event->id.'" AND fp_events_prospects_1prospects_idb="'.$delegate_id.'"';
             $check = $db->getOne($check_q);
    		//update contact to accepted
    		$query = 'UPDATE fp_events_prospects_1_c SET accept_status="Declined", email_responded="1" WHERE fp_events_prospects_1fp_events_ida="'.$event->id.'" AND fp_events_prospects_1prospects_idb="'.$delegate_id.'" AND email_responded="0"';
    		if($db->query($query) && $check != '1'){
                
                if(!IsNullOrEmptyString($event->decline_redirect)){

                    $url = $event->decline_redirect;
                    header('Location: ' . $url);    
                    
                } else{
                    echo 'Thank you for declining';
                }
            } else {
                echo 'You have already responded to the invitation or there was a problem with the link. Please contact the sender of the invite for help.';
            }
    	}
    }
    if($type == 'l'){
    	
    	$event->load_relationship('fp_events_leads_1'); //get related leads

    	if($response == 'accept'){
            //check to see if they have already responded to the email
            $check_q = 'SELECT email_responded FROM fp_events_leads_1_c WHERE ffp_events_leads_1fp_events_ida="'.$event->id.'" AND fp_events_leads_1leads_idb="'.$delegate_id.'"';
             $check = $db->getOne($check_q);
    		//update contact to accepted
    		$query = 'UPDATE fp_events_leads_1_c SET accept_status="Accepted", email_responded="1" WHERE fp_events_leads_1fp_events_ida="'.$event->id.'" AND fp_events_leads_1leads_idb="'.$delegate_id.'" AND email_responded="0"';
    		if($db->query($query) && $check != '1'){
                
                if(!IsNullOrEmptyString($event->accept_redirect)){
                    
                    $url = $event->accept_redirect;
                    header('Location: ' . $url);    
                } else{
                    echo 'Thank you for accepting';
                }   
            } else {
                echo 'There was a problem with the link please contact the sender of the invite';
            }   
    	} else if($response == 'decline'){
    		//check to see if they have already responded to the email
            $check_q = 'SELECT email_responded FROM fp_events_leads_1_c WHERE fp_events_leads_1fp_events_ida="'.$event->id.'" AND fp_events_leads_1leads_idb="'.$delegate_id.'"';
             $check = $db->getOne($check_q);
            //update contact to accepted
    		$query = 'UPDATE fp_events_leads_1_c SET accept_status="Declined", email_responded="1" WHERE fp_events_leads_1fp_events_ida="'.$event->id.'" AND fp_events_leads_1leads_idb="'.$delegate_id.'" AND email_responded="0"';

    		if($db->query($query) && $check != '1'){
                
                if(!IsNullOrEmptyString($event->decline_redirect)){

                    $url = $event->decline_redirect;
                    header('Location: ' . $url);    
                    
                } else{
                    echo 'Thank you for declining';
                }
            } else {
                echo 'There was a problem with the link please contact the sender of the invite';
            }
    	}
    }
    // Function for basic field validation (present and neither empty nor only white space nor just 'http://')
    function IsNullOrEmptyString($question){
        return (!isset($question) || trim($question)==='' || $question =='http://');
    }

?>
