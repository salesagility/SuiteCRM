<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/EmailTemplates/EmailTemplate.php");
require_once("modules/Contacts/Contact.php");
require_once("modules/Accounts/Account.php");
require_once("modules/Leads/Lead.php");
require_once("modules/Prospects/Prospect.php");
require_once("modules/FP_events/FP_events.php");



function generateFieldDefsJS2() {
		global $current_user;

		
		 $badFields = array(
		'account_description',
		'contact_id',
		'lead_id',
		'opportunity_amount',
		'opportunity_id',
		'opportunity_name',
		'opportunity_role_id',
		'opportunity_role_fields',
		'opportunity_role',
		'campaign_id',
		// User objects
		'id',
		'date_entered',
		'date_modified',
		'user_preferences',
		'accept_status',
		'user_hash',
		'authenticate_id',
		'sugar_login',
		'reports_to_id',
		'reports_to_name',
		'is_admin',
		'receive_notifications',
		'modified_user_id',
		'modified_by_name',
		'created_by',
		'created_by_name',
		'accept_status_id',
		'accept_status_name',
	);


		$contact = new Contact();
		$account = new Account();
		$lead = new Lead();
		$prospect = new Prospect();
		$event = new FP_events();


		$loopControl = array(
			'Contacts' => array(
			    'Contacts' => $contact,
			    'Leads' => $lead,
				'Prospects' => $prospect,
			),
			'Accounts' => array(
				'Accounts' => $account,
			),
			'Users' => array(
				'Users' => $current_user,
			),
			'FP_events' => array(
				'FP_events' => $event,
			),
		);

		$prefixes = array(
			'Contacts' => 'contact_',
			'Accounts' => 'account_',
			'Users'	=> 'contact_user_',
			'FP_events' => 'fp_events_',
		);

		$collection = array();
		foreach($loopControl as $collectionKey => $beans) {
			$collection[$collectionKey] = array();
			foreach($beans as $beankey => $bean) {

				foreach($bean->field_defs as $key => $field_def) {
				    if(	($field_def['type'] == 'relate' && empty($field_def['custom_type'])) ||
						($field_def['type'] == 'assigned_user_name' || $field_def['type'] =='link') ||
						($field_def['type'] == 'bool') ||
						(in_array($field_def['name'], $badFields)) ) {
				        continue;
				    }
				    if(!isset($field_def['vname'])) {
				    	//echo $key;
				    }
				    // valid def found, process
				    $optionKey = strtolower("{$prefixes[$collectionKey]}{$key}");
				    $optionLabel = preg_replace('/:$/', "", translate($field_def['vname'], $beankey));
				    $dup=1;
				    foreach ($collection[$collectionKey] as $value){
				    	if($value['name']==$optionKey){
				    		$dup=0;
				    		break;
				    	}
				    }
				    if($dup)
				        $collection[$collectionKey][] = array("name" => $optionKey, "value" => $optionLabel);
				}
			}
		}

		$json = getJSONobj();
		$ret = "var field_defs = ";
		$ret .= $json->encode($collection, false);
		$ret .= ";";
		return $ret;
	}
