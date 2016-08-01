<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/



class EmailMan extends SugarBean{
	var $id;
	var $deleted;
	var $date_created;
	var $date_modified;
	var $module;
	var $module_id;
	var $marketing_id;
	var $campaign_id;
	var $user_id;
	var $list_id;
	var $invalid_email;
	var $from_name;
	var $from_email;
	var $in_queue;
	var $in_queue_date;
	var $template_id;
	var $send_date_time;
	var $table_name = "emailman";
	var $object_name = "EmailMan";
	var $module_dir = "EmailMan";
	var $send_attempts;
	var $related_id;
	var $related_type;
	var $test=false;
	var $notes_array = array();
    var $verified_email_marketing_ids =  array();
	function toString(){
		return "EmailMan:\nid = $this->id ,user_id= $this->user_id module = $this->module , related_id = $this->related_id , related_type = $this->related_type ,list_id = $this->list_id, send_date_time= $this->send_date_time\n";
	}

    // This is used to retrieve related fields from form posts.
	var $additional_column_fields = array();

    public function __construct() {
		parent::__construct();

	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function EmailMan(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


	var $new_schema = true;

    function create_new_list_query($order_by, $where,$filter=array(),$params=array(), $show_deleted = 0,$join_type='', $return_array = false,$parentbean=null, $singleSelect = false, $ifListForExport = false) {
		$query = array('select' => '', 'from' => '', 'where' => '', 'order_by' => '');



		$query['select'] = "SELECT $this->table_name.* ,
					campaigns.name as campaign_name,
					email_marketing.name as message_name,
					(CASE related_type
						WHEN 'Contacts' THEN ".$this->db->concat('contacts', array('first_name', 'last_name'), '&nbsp;')."
						WHEN 'Leads' THEN ".$this->db->concat('leads', array('first_name', 'last_name'), '&nbsp;')."
						WHEN 'Accounts' THEN accounts.name
						WHEN 'Users' THEN ".$this->db->concat('users', array('first_name', 'last_name'), '&nbsp;')."
						WHEN 'Prospects' THEN ".$this->db->concat('prospects', array('first_name', 'last_name'), '&nbsp;')."
					END) recipient_name";
		$query['from'] = "	FROM $this->table_name
					LEFT JOIN users ON users.id = $this->table_name.related_id and $this->table_name.related_type ='Users'
					LEFT JOIN contacts ON contacts.id = $this->table_name.related_id and $this->table_name.related_type ='Contacts'
					LEFT JOIN leads ON leads.id = $this->table_name.related_id and $this->table_name.related_type ='Leads'
					LEFT JOIN accounts ON accounts.id = $this->table_name.related_id and $this->table_name.related_type ='Accounts'
					LEFT JOIN prospects ON prospects.id = $this->table_name.related_id and $this->table_name.related_type ='Prospects'
					LEFT JOIN prospect_lists ON prospect_lists.id = $this->table_name.list_id
                    LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = $this->table_name.related_id and $this->table_name.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0
					LEFT JOIN campaigns ON campaigns.id = $this->table_name.campaign_id
					LEFT JOIN email_marketing ON email_marketing.id = $this->table_name.marketing_id ";

                $where_auto = " $this->table_name.deleted=0";

        if($where != "")
			$query['where'] = "WHERE $where AND ".$where_auto;
		else
			$query['where'] = "WHERE ".$where_auto;

    	if(isset($params['group_by'])) {
            $query['group_by'] .= " GROUP BY {$params['group_by']}";
		}

        $order_by = $this->process_order_by($order_by);
        if (!empty($order_by)) {
            $query['order_by'] = ' ORDER BY ' . $order_by;
        }

		if ($return_array) {
			return $query;
		}

		return  $query['select'] . $query['from'] . $query['where']. $query['order_by'];

    } // if

    function create_queue_items_query($order_by, $where,$filter=array(),$params=array(), $show_deleted = 0,$join_type='', $return_array = false,$parentbean=null, $singleSelect = false) {

		if ($return_array) {
			return parent::create_new_list_query($order_by, $where,$filter,$params, $show_deleted,$join_type, $return_array,$parentbean, $singleSelect);
		}

		$query = "SELECT $this->table_name.* ,
					campaigns.name as campaign_name,
					email_marketing.name as message_name,
					(CASE related_type
						WHEN 'Contacts' THEN ".$this->db->concat('contacts', array('first_name', 'last_name'), '&nbsp;')."
						WHEN 'Leads' THEN ".$this->db->concat('leads', array('first_name', 'last_name'), '&nbsp;')."
						WHEN 'Accounts' THEN accounts.name
						WHEN 'Users' THEN ".$this->db->concat('users', array('first_name', 'last_name'), '&nbsp;')."
						WHEN 'Prospects' THEN ".$this->db->concat('prospects', array('first_name', 'last_name'), '&nbsp;')."
					END) recipient_name";

		 $query .= " FROM $this->table_name
		            LEFT JOIN users ON users.id = $this->table_name.related_id and $this->table_name.related_type ='Users'
					LEFT JOIN contacts ON contacts.id = $this->table_name.related_id and $this->table_name.related_type ='Contacts'
					LEFT JOIN leads ON leads.id = $this->table_name.related_id and $this->table_name.related_type ='Leads'
					LEFT JOIN accounts ON accounts.id = $this->table_name.related_id and $this->table_name.related_type ='Accounts'
					LEFT JOIN prospects ON prospects.id = $this->table_name.related_id and $this->table_name.related_type ='Prospects'
					LEFT JOIN prospect_lists ON prospect_lists.id = $this->table_name.list_id
                    LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = $this->table_name.related_id and $this->table_name.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0
					LEFT JOIN campaigns ON campaigns.id = $this->table_name.campaign_id
					LEFT JOIN email_marketing ON email_marketing.id = $this->table_name.marketing_id ";

		 //B.F. #37943
		if( isset($params['group_by']) )
		{
			$group_by = str_replace("emailman", "em", $params['group_by']);
		    $query .= "INNER JOIN (select min(id) as id from emailman  em GROUP BY $group_by  ) secondary
			           on {$this->table_name}.id = secondary.id	";
		}

                $where_auto = " $this->table_name.deleted=0";

        if($where != "")
			$query .= "WHERE $where AND ".$where_auto;
		else
			$query .= "WHERE ".$where_auto;

        $order_by = $this->process_order_by($order_by);
        if (!empty($order_by)) {
            $query .= ' ORDER BY ' . $order_by;
        }

		return $query;

    }

	function create_list_query($order_by, $where, $show_deleted = 0){

		$query = "SELECT $this->table_name.* ,
					campaigns.name as campaign_name,
					email_marketing.name as message_name,
					(CASE related_type
						WHEN 'Contacts' THEN ".$this->db->concat('contacts', array('first_name', 'last_name'), '&nbsp;')."
						WHEN 'Leads' THEN ".$this->db->concat('leads', array('first_name', 'last_name'), '&nbsp;')."
						WHEN 'Accounts' THEN accounts.name
						WHEN 'Users' THEN ".$this->db->concat('users', array('first_name', 'last_name'), '&nbsp;')."
						WHEN 'Prospects' THEN ".$this->db->concat('prospects', array('first_name', 'last_name'), '&nbsp;')."
					END) recipient_name";
		$query .= "	FROM $this->table_name
					LEFT JOIN users ON users.id = $this->table_name.related_id and $this->table_name.related_type ='Users'
					LEFT JOIN contacts ON contacts.id = $this->table_name.related_id and $this->table_name.related_type ='Contacts'
					LEFT JOIN leads ON leads.id = $this->table_name.related_id and $this->table_name.related_type ='Leads'
					LEFT JOIN accounts ON accounts.id = $this->table_name.related_id and $this->table_name.related_type ='Accounts'
					LEFT JOIN prospects ON prospects.id = $this->table_name.related_id and $this->table_name.related_type ='Prospects'
					LEFT JOIN prospect_lists ON prospect_lists.id = $this->table_name.list_id
                    LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = $this->table_name.related_id and $this->table_name.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0
					LEFT JOIN campaigns ON campaigns.id = $this->table_name.campaign_id
					LEFT JOIN email_marketing ON email_marketing.id = $this->table_name.marketing_id ";

                $where_auto = " $this->table_name.deleted=0";

        if($where != "")
			$query .= "where $where AND ".$where_auto;
		else
			$query .= "where ".$where_auto;

        $order_by = $this->process_order_by($order_by);
        if (!empty($order_by)) {
            $query .= ' ORDER BY ' . $order_by;
        }

		return $query;
	}

    function get_list_view_data()
    {
    	global $locale, $current_user;
        $temp_array = parent::get_list_view_array();

        $related_type = $temp_array['RELATED_TYPE'];
        $related_id = $temp_array['RELATED_ID'];
        $is_person = SugarModule::get($related_type)->moduleImplements('Person');

        if($is_person)
        {
            $query = "SELECT first_name, last_name FROM ". strtolower($related_type) ." WHERE id ='". $related_id ."'";
        } else {
            $query = "SELECT name FROM ". strtolower($related_type) ." WHERE id ='". $related_id ."'";
        }

        $result=$this->db->query($query);
        $row=$this->db->fetchByAssoc($result);

        if($row)
        {
        	$temp_array['RECIPIENT_NAME'] = $is_person ? $locale->getLocaleFormattedName($row['first_name'], $row['last_name'], '') : $row['name'];
        }

        //also store the recipient_email address
        $query = "SELECT addr.email_address FROM email_addresses addr,email_addr_bean_rel eb WHERE eb.deleted=0 AND addr.id=eb.email_address_id AND bean_id ='". $related_id ."' AND primary_address = '1'";

        $result=$this->db->query($query);
        $row=$this->db->fetchByAssoc($result);
        if ($row)
        {
            $temp_array['RECIPIENT_EMAIL']=$row['email_address'];
        }

        $this->email1 = $temp_array['RECIPIENT_EMAIL'];
		$temp_array['EMAIL1_LINK'] = $current_user->getEmailLink('email1', $this, '', '', 'ListView');

        return $temp_array;
    }


	function set_as_sent($email_address, $delete= true,$email_id=null, $email_type=null,$activity_type=null){

		global $timedate;

		$this->send_attempts++;
		$this->id = (int)$this->id;
		if($delete || $this->send_attempts > 5){

			//create new campaign log record.

			$campaign_log = new CampaignLog();
			$campaign_log->campaign_id=$this->campaign_id;
			$campaign_log->target_tracker_key=$this->target_tracker_key;
			$campaign_log->target_id= $this->related_id;
			$campaign_log->target_type=$this->related_type;
            $campaign_log->marketing_id=$this->marketing_id;
			//if test suppress duplicate email address checking.
			if (!$this->test) {
				$campaign_log->more_information=$email_address;
			}
			$campaign_log->activity_type=$activity_type;
			$campaign_log->activity_date=$timedate->now();
			$campaign_log->list_id=$this->list_id;
			$campaign_log->related_id= $email_id;
			$campaign_log->related_type=$email_type;
            $campaign_log->save();

			$query = "DELETE FROM emailman WHERE id = $this->id";
			$this->db->query($query);
		}else{
			//try to send the email again a day later.
			$query = 'UPDATE ' . $this->table_name . " SET in_queue='1', send_attempts='$this->send_attempts', in_queue_date=". $this->db->now() ." WHERE id = $this->id";
			$this->db->query($query);
		}
	}

    /**
     * Function finds the reference email for the campaign. Since a campaign can have multiple email templates
     * the reference email has same id as the marketing id.
     * this function will create an email if one does not exist. also the function will load these relationships leads, accounts, contacts
     * users and targets
     *
     * @param varchar marketing_id message id
     * @param string $subject email subject
     * @param string $body_text Email Body Text
     * @param string $body_html Email Body HTML
     * @param string $campaign_name Campaign Name
     * @param string from_address Email address of the sender, usually email address of the configured inbox.
     * @param string sender_id If of the user sending the campaign.
     * @param array  macro_nv array of name value pair, one row for each replacable macro in email template text.
     * @param string from_address_name The from address eg markeing <marketing@sugar.net>
     * @return
     */
    function create_ref_email($marketing_id,$subject,$body_text,$body_html,$campagin_name,$from_address,$sender_id,$notes,$macro_nv,$newmessage,$from_address_name) {

       global $mod_strings, $timedate;
       $upd_ref_email=false;
       if ($newmessage or empty($this->ref_email->id)) {
           $this->ref_email = new Email();
           $this->ref_email->retrieve($marketing_id, true, false);

           //the reference email should be updated when user swithces from test mode to regular mode,and, for every run in test mode, and is user
           //switches back to test mode.
           //this is to account for changes to email template.
           $upd_ref_email=(!empty($this->ref_email->id) and $this->ref_email->parent_type=='test' and $this->ref_email->parent_id=='test');
          //following condition is for switching back to test mode.
           if (!$upd_ref_email) $upd_ref_email=($this->test and !empty($this->ref_email->id) and empty($this->ref_email->parent_type) and empty($this->ref_email->parent_id));
           if (empty($this->ref_email->id) or $upd_ref_email) {
                //create email record.
                $this->ref_email->id=$marketing_id;
                $this->ref_email->date_sent = '';

                if ($upd_ref_email==false) {
                    $this->ref_email->new_with_id=true;
                }

                $this->ref_email->to_addrs= '';
                $this->ref_email->to_addrs_ids = '';
                $this->ref_email->to_addrs_names = '';
                $this->ref_email->to_addrs_emails ='';
                $this->ref_email->type= 'campaign';
                $this->ref_email->deleted = '0';
                $this->ref_email->name = $campagin_name.': '.$subject ;
                $this->ref_email->description_html = $body_html;
                $this->ref_email->description = $body_text;
                $this->ref_email->from_addr = $from_address;
                $this->ref_email->from_addr_name = $from_address_name;
                $this->ref_email->assigned_user_id = $sender_id;
                if ($this->test) {
                    $this->ref_email->parent_type = 'test';
                    $this->ref_email->parent_id =  'test';
                } else {
                    $this->ref_email->parent_type = '';
                    $this->ref_email->parent_id =  '';
                }
                $this->ref_email->date_start = $timedate->nowDate();
                $this->ref_email->time_start = $timedate->asUserTime($timedate->getNow(true));

                $this->ref_email->status='sent';
                $retId = $this->ref_email->save();

                foreach($notes as $note) {
                    if($note->object_name == 'Note') {
                        if (! empty($note->file->temp_file_location) && is_file($note->file->temp_file_location)) {
                            $file_location = $note->file->temp_file_location;
                            $filename = $note->file->original_file_name;
                            $mime_type = $note->file->mime_type;
                        } else {
                            $file_location = "upload://{$note->id}";
                            $filename = $note->id.$note->filename;
                            $mime_type = $note->file_mime_type;
                        }
                    } elseif($note->object_name == 'DocumentRevision') { // from Documents
                        $filename = $note->id.$note->filename;
                        $file_location = "upload://$filename";
                        $mime_type = $note->file_mime_type;
                    }

                    $noteAudit = new Note();
                    $noteAudit->parent_id = $retId;
                    $noteAudit->parent_type = $this->ref_email->module_dir;
                    $noteAudit->description = "[".$note->filename."] ".$mod_strings['LBL_ATTACHMENT_AUDIT'];
                    $noteAudit->filename=$filename;
                    $noteAudit->file_mime_type=$mime_type;
                    $noteAudit_id=$noteAudit->save();

                    UploadFile::duplicate_file($note->id, $noteAudit_id, $filename);
                }
            }

            //load relationships.
            $this->ref_email->load_relationship('users');
            $this->ref_email->load_relationship('prospects');
            $this->ref_email->load_relationship('contacts');
            $this->ref_email->load_relationship('leads');
            $this->ref_email->load_relationship('accounts');
       }

       if (!empty($this->related_id ) && !empty($this->related_type)) {

            //save relationships.
            switch ($this->related_type)  {
                case 'Users':
                    $rel_name="users";
                    break;

                case 'Prospects':
                    $rel_name="prospects";
                    break;

                case 'Contacts':
                    $rel_name="contacts";
                    break;

                case 'Leads':
                    $rel_name="leads";
                    break;

                case 'Accounts':
                    $rel_name="accounts";
                    break;
            }

            //serialize data to be passed into Link2->add() function
            $campaignData = serialize($macro_nv);

            //required for one email per campaign per marketing message.
            $this->ref_email->$rel_name->add($this->related_id,array('campaign_data'=>$this->db->quote($campaignData)));
       }
       return $this->ref_email->id;
    }

   /**
    * The function creates a copy of email send to each target.
    */
    function create_indiv_email($module,$mail) {

        global $locale, $timedate;
        $email = new Email();
        $email->to_addrs= $module->name . '&lt;'.$module->email1.'&gt;';
        $email->to_addrs_ids = $module->id .';';
        $email->to_addrs_names = $module->name . ';';
        $email->to_addrs_emails = $module->email1 . ';';
        $email->type= 'archived';
        $email->deleted = '0';
        $email->name = $this->current_campaign->name.': '.$mail->Subject ;
        if ($mail->ContentType == "text/plain") {
            $email->description = $mail->Body;
            $email->description_html =null;
        } else {
            $email->description_html = $mail->Body;
            $email->description = $mail->AltBody;
        }
        $email->from_addr = $mail->From;
        $email->assigned_user_id = $this->user_id;
        $email->parent_type = $this->related_type;
        $email->parent_id = $this->related_id ;

        $email->date_start = $timedate->nowDbDate();
        $email->time_start = $timedate->asDbTime($timedate->getNow());
        $email->status='sent';
        $retId = $email->save();

        foreach($this->notes_array as $note) {
            if(!class_exists('Note')) {

            }
            // create "audit" email without duping off the file to save on disk space
            $noteAudit = new Note();
            $noteAudit->parent_id = $retId;
            $noteAudit->parent_type = $email->module_dir;
            $noteAudit->description = "[".$note->filename."] ".$mod_strings['LBL_ATTACHMENT_AUDIT'];
            $noteAudit->save();
        }

        if (!empty($this->related_id ) && !empty($this->related_type)) {

                //save relationships.
                switch ($this->related_type)  {
                    case 'Users':
                        $rel_name="users";
                        break;

                    case 'Prospects':
                        $rel_name="prospects";
                        break;

                    case 'Contacts':
                        $rel_name="contacts";
                        break;

                    case 'Leads':
                        $rel_name="leads";
                        break;

                    case 'Accounts':
                        $rel_name="accounts";
                        break;
                }

                if (!empty($rel_name)) {
                    $email->load_relationship($rel_name);
                    $email->$rel_name->add($this->related_id);
                }
        }
        return $email->id;
    }
    /*
     * Call this function to verify the email_marketing message and email_template configured
     * for the campaign. If issues are found a fatal error will be logged but processing will not stop.
     * @return Boolean Returns true if all campaign parameters are set correctly
     */
    function verify_campaign($marketing_id) {

        if (!isset($this->verified_email_marketing_ids[$marketing_id])) {
            if (!class_exists('EmailMarketing')) {

            }
            $email_marketing = new EmailMarketing();
            $ret=$email_marketing->retrieve($marketing_id);
            if (empty($ret)) {
                $GLOBALS['log']->fatal('Error retrieving marketing message for the email campaign. marketing_id = ' .$marketing_id);
                return false;
            }

            //verify the email template.
            if (empty($email_marketing->template_id)) {
                $GLOBALS['log']->fatal('Error retrieving template for the email campaign. marketing_id = ' .$marketing_id);
                return false;
            }

            if (!class_exists('EmailTemplate')) {

            }
            $emailtemplate= new EmailTemplate();

            $ret=$emailtemplate->retrieve($email_marketing->template_id);
            if (empty($ret)) {
                $GLOBALS['log']->fatal('Error retrieving template for the email campaign. template_id = ' .$email_marketing->template_id);
                return false;
            }

            if (empty($emailtemplate->subject) and empty($emailtemplate->body) and empty($emailtemplate->body_html)) {
                $GLOBALS['log']->fatal('Email template is empty. email_template_id=' .$email_marketing->template_id);
				return false;
            }

        }
        $this->verified_email_marketing_ids[$marketing_id]=1;

        return true;
    }
	function sendEmail($mail,$save_emails=1,$testmode=false){
	    $this->test=$testmode;

		global $beanList, $beanFiles, $sugar_config;
		global $mod_strings;
        global $locale;
        $OBCharset = $locale->getPrecedentPreference('default_email_charset');
		$mod_strings = return_module_language( $sugar_config['default_language'], 'EmailMan');

		//get tracking entities locations.
		if (!isset($this->tracking_url)) {
			if (!class_exists('Administration')) {

			}
			$admin=new Administration();
			$admin->retrieveSettings('massemailer'); //retrieve all admin settings.
		    if (isset($admin->settings['massemailer_tracking_entities_location_type']) and $admin->settings['massemailer_tracking_entities_location_type']=='2'  and isset($admin->settings['massemailer_tracking_entities_location']) ) {
				$this->tracking_url=$admin->settings['massemailer_tracking_entities_location'];
		    } else {
				$this->tracking_url=$sugar_config['site_url'];
		    }
		}

        //make sure tracking url ends with '/' character
        $strLen = strlen($this->tracking_url);
        if($this->tracking_url{$strLen-1} !='/'){
            $this->tracking_url .='/';
        }

		if(!isset($beanList[$this->related_type])){
			return false;
		}
		$class = $beanList[$this->related_type];
		if (!class_exists($class)) {
			require_once($beanFiles[$class]);
		}

		if (!class_exists('Email')) {

		}

        //prepare variables for 'set_as_sent' function
        $this->target_tracker_key = create_guid();

        $module = new $class();
		$module->retrieve($this->related_id);
		$module->emailAddress->handleLegacyRetrieve($module);

        //check to see if bean has a primary email address
        if (!$this->is_primary_email_address($module)) {
            //no primary email address designated, do not send out email, create campaign log
            //of type send error to denote that this user was not emailed
            $this->set_as_sent($module->email1, true,null,null,'send error');
            //create fatal logging for easy review of cause.
            $GLOBALS['log']->fatal('Email Address provided is not Primary Address for email with id ' . $module->email1 . "' Emailman id=$this->id");
            return true;
        }

		if (!$this->valid_email_address($module->email1)) {
			$this->set_as_sent($module->email1, true,null,null,'invalid email');
			$GLOBALS['log']->fatal('Encountered invalid email address' . $module->email1 . " Emailman id=$this->id");
			return true;
		}

        if ((!isset($module->email_opt_out)
                    || ($module->email_opt_out !== 'on'
                        && $module->email_opt_out !== 1
                        && $module->email_opt_out !== '1'))
            && (!isset($module->invalid_email)
                    || ($module->invalid_email !== 'on'
                        && $module->invalid_email !== 1
                        && $module->invalid_email !== '1'))){
            $lower_email_address=strtolower($module->email1);
			//test against indivdual address.
			if (isset($this->restricted_addresses) and isset($this->restricted_addresses[$lower_email_address])) {
				$this->set_as_sent($lower_email_address, true,null,null,'blocked');
				return true;
			}
			//test against restricted domains
			$at_pos=strrpos($lower_email_address,'@');
			if ($at_pos !== false) {
				foreach ($this->restricted_domains as $domain=>$value) {
					$pos=strrpos($lower_email_address,$domain);
					if ($pos !== false && $pos > $at_pos) {
						//found
						$this->set_as_sent($lower_email_address, true,null,null,'blocked');
						return true;
					}
				}
			}

			//test for duplicate email address by marketing id.
            $dup_query="select id from campaign_log where more_information='".$this->db->quote($module->email1)."' and marketing_id='".$this->marketing_id."'";
			$dup=$this->db->query($dup_query);
			$dup_row=$this->db->fetchByAssoc($dup);
			if (!empty($dup_row)) {
				//we have seen this email address before
				$this->set_as_sent($module->email1,true,null,null,'blocked');
				return true;
			}


			//fetch email marketing.
			if (empty($this->current_emailmarketing) or !isset($this->current_emailmarketing)) {
				if (!class_exists('EmailMarketing')) {

				}

				$this->current_emailmarketing=new EmailMarketing();

			}
			if (empty($this->current_emailmarketing->id) or $this->current_emailmarketing->id !== $this->marketing_id) {
				$this->current_emailmarketing->retrieve($this->marketing_id);

                $this->newmessage = true;
			}
			//fetch email template associate with the marketing message.
			if (empty($this->current_emailtemplate) or $this->current_emailtemplate->id !== $this->current_emailmarketing->template_id) {
				if (!class_exists('EmailTemplate')) {

				}
				$this->current_emailtemplate= new EmailTemplate();

				$this->current_emailtemplate->retrieve($this->current_emailmarketing->template_id);

				//escape email template contents.
				$this->current_emailtemplate->subject=from_html($this->current_emailtemplate->subject);
				$this->current_emailtemplate->body_html=from_html($this->current_emailtemplate->body_html);
				$this->current_emailtemplate->body=from_html($this->current_emailtemplate->body);

				$q = "SELECT * FROM notes WHERE parent_id = '".$this->current_emailtemplate->id."' AND deleted = 0";
				$r = $this->db->query($q);

				// cn: bug 4684 - initialize the notes array, else old data is still around for the next round
				$this->notes_array = array();
                if (!class_exists('Note')){
                	require_once('modules/Notes/Note.php');
				}
				while($a = $this->db->fetchByAssoc($r)) {
					$noteTemplate = new Note();
					$noteTemplate->retrieve($a['id']);
					$this->notes_array[] = $noteTemplate;
				}
			}

			// fetch mailbox details..
			if(empty($this->current_mailbox)) {
				if (!class_exists('InboundEmail')) {

				}
				$this->current_mailbox= new InboundEmail();
			}
			if (empty($this->current_mailbox->id) or $this->current_mailbox->id !== $this->current_emailmarketing->inbound_email_id) {
				$this->current_mailbox->retrieve($this->current_emailmarketing->inbound_email_id);
				//extract the email address.
				$this->mailbox_from_addr=$this->current_mailbox->get_stored_options('from_addr','nobody@example.com',null);
			}

			// fetch campaign details..
			if (empty($this->current_campaign)) {
				if (!class_exists('Campaign')) {

				}
				$this->current_campaign= new Campaign();
			}
			if (empty($this->current_campaign->id) or $this->current_campaign->id !== $this->current_emailmarketing->campaign_id) {
				$this->current_campaign->retrieve($this->current_emailmarketing->campaign_id);

				//load defined tracked_urls
				$this->current_campaign->load_relationship('tracked_urls');
				$query_array=$this->current_campaign->tracked_urls->getQuery(true);
				$query_array['select']="SELECT tracker_name, tracker_key, id, is_optout ";
				$result=$this->current_campaign->db->query(implode(' ',$query_array));

				$this->has_optout_links=false;
				$this->tracker_urls=array();
				while (($row=$this->current_campaign->db->fetchByAssoc($result)) != null) {
					$this->tracker_urls['{'.$row['tracker_name'].'}']=$row;
					//has the user defined opt-out links for the campaign.
					if ($row['is_optout']==1) {
						$this->has_optout_links=true;
					}
				}
			}

			$mail->ClearAllRecipients();
			$mail->ClearReplyTos();
			$mail->Sender	= $this->mailbox_from_addr;
			$mail->From     = $this->mailbox_from_addr;
			$mail->FromName = $locale->translateCharsetMIME(trim($this->current_emailmarketing->from_name), 'UTF-8', $OBCharset);
			$mail->ClearCustomHeaders();
            $mail->AddCustomHeader('X-CampTrackID:'.$this->target_tracker_key);
            //CL - Bug 25256 Check if we have a reply_to_name/reply_to_addr value from the email marketing table.  If so use email marketing entry; otherwise current mailbox (inbound email) entry
			$replyToName = empty($this->current_emailmarketing->reply_to_name) ? $this->current_mailbox->get_stored_options('reply_to_name',$mail->FromName,null) : $this->current_emailmarketing->reply_to_name;
			$replyToAddr = empty($this->current_emailmarketing->reply_to_addr) ? $this->current_mailbox->get_stored_options('reply_to_addr',$mail->From,null) : $this->current_emailmarketing->reply_to_addr;

            if (!empty($replyToAddr)) {
                $mail->AddReplyTo($replyToAddr,$locale->translateCharsetMIME(trim($replyToName), 'UTF-8', $OBCharset));
            }

			//parse and replace bean variables.
            $macro_nv=array();
            $focus_name = 'Contacts';
            if($module->module_dir == 'Accounts')
            {
                $focus_name = 'Accounts';
            }


			$template_data=  $this->current_emailtemplate->parse_email_template(array('subject'=>$this->current_emailtemplate->subject,
																					  'body_html'=>$this->current_emailtemplate->body_html,
																					  'body'=>$this->current_emailtemplate->body,
																					  )
																					  ,$focus_name, $module
                                                                                      ,$macro_nv);

            //add email address to this list.
            $macro_nv['sugar_to_email_address']=$module->email1;
            $macro_nv['email_template_id']=$this->current_emailmarketing->template_id;

            //parse and replace urls.
			//this is new style of adding tracked urls to a campaign.
			$tracker_url_template= $this->tracking_url . 'index.php?entryPoint=campaign_trackerv2&track=%s'.'&identifier='.$this->target_tracker_key;
			$removeme_url_template=$this->tracking_url . 'index.php?entryPoint=removeme&identifier='.$this->target_tracker_key;
			$template_data=  $this->current_emailtemplate->parse_tracker_urls($template_data,$tracker_url_template,$this->tracker_urls,$removeme_url_template);
			$mail->AddAddress($module->email1,$locale->translateCharsetMIME(trim($module->name), 'UTF-8', $OBCharset) );

            //refetch strings in case they have been changed by creation of email templates or other beans.
            $mod_strings = return_module_language( $sugar_config['default_language'], 'EmailMan');

            if($this->test){
                $mail->Subject =  $mod_strings['LBL_PREPEND_TEST'] . $template_data['subject'];
            }else{
                $mail->Subject =  $template_data['subject'];
            }

            //check if this template is meant to be used as "text only"
            $text_only = false;
            if(isset($this->current_emailtemplate->text_only) && $this->current_emailtemplate->text_only){$text_only =true;}
            //if this template is textonly, then just send text body.  Do not add tracker, opt out,
            //or perform other processing as it will not show up in text only email
            if($text_only){
                $this->description_html = '';
                $mail->IsHTML(false);
                $mail->Body = $template_data['body'];

            }else{
                $mail->Body = wordwrap($template_data['body_html'], 900);
                //BEGIN:this code will trigger for only campaigns pending before upgrade to 4.2.0.
                //will be removed for the next release.
                if(!isset($btracker)) $btracker=false;
                if ($btracker) {
                    $mail->Body .= "<br /><br /><a href='". $tracker_url ."'>" . $tracker_text . "</a><br /><br />";
                } else {
                    if (!empty($tracker_url)) {
                        $mail->Body = str_replace('TRACKER_URL_START', "<a href='" . $tracker_url ."'>", $mail->Body);
                        $mail->Body = str_replace('TRACKER_URL_END', "</a>", $mail->Body);
                        $mail->AltBody = str_replace('TRACKER_URL_START', "<a href='" . $tracker_url ."'>", $mail->AltBody);
                        $mail->AltBody = str_replace('TRACKER_URL_END', "</a>", $mail->AltBody);
                    }
                }
                //END

                //do not add the default remove me link if the campaign has a trackerurl of the opotout link
                if ($this->has_optout_links==false) {
                    $mail->Body .= "<br /><span style='font-size:0.8em'>{$mod_strings['TXT_REMOVE_ME']} <a href='". $this->tracking_url . "index.php?entryPoint=removeme&identifier={$this->target_tracker_key}'>{$mod_strings['TXT_REMOVE_ME_CLICK']}</a></span>";
                }
                // cn: bug 11979 - adding single quote to comform with HTML email RFC
                $mail->Body .= "<br /><img alt='' height='1' width='1' src='{$this->tracking_url}index.php?entryPoint=image&identifier={$this->target_tracker_key}' />";

                $mail->AltBody = $template_data['body'];
                if ($btracker) {
                    $mail->AltBody .="\n". $tracker_url;
                }
                if ($this->has_optout_links==false) {
                    $mail->AltBody .="\n\n\n{$mod_strings['TXT_REMOVE_ME_ALT']} ". $this->tracking_url . "index.php?entryPoint=removeme&identifier=$this->target_tracker_key";
                }

            }

			// cn: bug 4684, handle attachments in email templates.
			$mail->handleAttachments($this->notes_array);
			$tmp_Subject = $mail->Subject;
			$mail->prepForOutbound();

	    	$success = $mail->Send();
	    	//Do not save the encoded subject.
            $mail->Subject = $tmp_Subject;
			if($success ){
                $email_id=null;
                if ($save_emails==1) {
                    $email_id=$this->create_indiv_email($module,$mail);
                } else {
                    //find/create reference email record. all campaign targets reveiving this message will be linked with this message.
                    $decodedFromName = mb_decode_mimeheader($this->current_emailmarketing->from_name);
                    $fromAddressName= "{$decodedFromName} <{$this->mailbox_from_addr}>";

                    $email_id=$this->create_ref_email($this->marketing_id,
                                            $this->current_emailtemplate->subject,
                                            $this->current_emailtemplate->body,
                                            $this->current_emailtemplate->body_html,
                                            $this->current_campaign->name,
                                            $this->mailbox_from_addr,
                                            $this->user_id,
                                            $this->notes_array,
                                            $macro_nv,
                                            $this->newmessage,
                                            $fromAddressName
                     );
                    $this->newmessage = false;
                }
            }

			if ($success) {
				$this->set_as_sent($module->email1, true, $email_id, 'Emails', 'targeted');
			} else {

				if(!empty($layout_def['parent_id'])) {
	                if (isset($layout_def['fields'][strtoupper($layout_def['parent_id'])])) {
	                    $parent.="&parent_id=".$layout_def['fields'][strtoupper($layout_def['parent_id'])];
	                }
	            }
	            if(!empty($layout_def['parent_module'])) {
	                if (isset($layout_def['fields'][strtoupper($layout_def['parent_module'])])) {
	                    $parent.="&parent_module=".$layout_def['fields'][strtoupper($layout_def['parent_module'])];
	                }
	            }
				//log send error. save for next attempt after 24hrs. no campaign log entry will be created.
				$this->set_as_sent($module->email1,false,null,null,'send error');
			}
		}else{
            $success = false;
            $this->target_tracker_key=create_guid();

			if (isset($module->email_opt_out) && ($module->email_opt_out === 'on' || $module->email_opt_out == '1' || $module->email_opt_out == 1)) {
				$this->set_as_sent($module->email1,true,null,null,'blocked');
			} else {
				if (isset($module->invalid_email) && ($module->invalid_email == 1 || $module->invalid_email == '1')) {
					$this->set_as_sent($module->email1,true,null,null,'invalid email');
				} else {
					$this->set_as_sent($module->email1,true, null,null,'send error');
				}
			}
		}

		return $success;
	}

	/*
	 * Validates the passed email address.
	 * Limitations of this algorithm: does not validate email addressess that end with .meuseum
	 *
	 */
	function valid_email_address($email_address) {

		$email_address=trim($email_address);
		if (empty($email_address)) {
			return false;
		}

		$pattern='/[A-Z0-9\._%-]+@[A-Z0-9\.-]+\.[A-Za-z]{2,}$/i';
		$ret=preg_match($pattern, $email_address);
		if ($ret===false or $ret==0) {
			return false;
		}
		return true;
	}

    /*
     * This function takes in the given bean and searches for a related email address
     * that has been designated as primary.  If one is found, true is returned
     * If no primary email address is found, then false is returned
     *
     */
    function is_primary_email_address($bean){
        $email_address=trim($bean->email1);

        if (empty($email_address)) {
            return false;
        }
        //query for this email address rel and see if this is primary address
        $primary_qry = "select email_address_id from email_addr_bean_rel where bean_id = '".$bean->id."' and email_addr_bean_rel.primary_address=1 and deleted=0";
        $res = $bean->db->query($primary_qry);
        $prim_row=$this->db->fetchByAssoc($res);
        //return true if this is primary
        if (!empty($prim_row)) {
            return true;
        }
        return false;

     }

    function create_export_query($order_by, $where)
    {
        $custom_join = $this->getCustomJoin(true, true, $where);
        $query = "SELECT emailman.*";
        $query .= $custom_join['select'];

        $query .= " FROM emailman ";

        $query .= $custom_join['join'];

        $where_auto = "( emailman.deleted IS NULL OR emailman.deleted=0 )";

        if($where != "")
            $query .= "where ($where) AND ".$where_auto;
        else
            $query .= "where ".$where_auto;

        $order_by = $this->process_order_by($order_by);
        if (!empty($order_by)) {
            $query .= ' ORDER BY ' . $order_by;
        }

        return $query;
    }

    /**
     * Actuall deletes the emailman record
     * @param int $id
     */
    public function mark_deleted($id)
	{
	    $this->db->query("DELETE FROM {$this->table_name} WHERE id=".intval($id));
	}
}
