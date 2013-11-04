<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/





require_once('include/upload_file.php');

// Note is used to store customer information.
class Note extends SugarBean {
	var $field_name_map;
	// Stored fields
	var $id;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $assigned_user_id;
	var $created_by;
	var $created_by_name;
	var $modified_by_name;
	var $description;
	var $name;
	var $filename;
	// handle to an upload_file object
	// used in emails
	var $file;
	var $embed_flag; // inline image flag
	var $parent_type;
	var $parent_id;
	var $contact_id;
	var $portal_flag;

	var $parent_name;
	var $contact_name;
	var $contact_phone;
	var $contact_email;
	var $file_mime_type;
	var $module_dir = "Notes";
	var $default_note_name_dom = array('Meeting notes', 'Reminder');
	var $table_name = "notes";
	var $new_schema = true;
	var $object_name = "Note";
	var $importable = true;

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array('contact_name', 'contact_phone', 'contact_email', 'parent_name','first_name','last_name');



	function Note() {
		parent::SugarBean();
	}

	function safeAttachmentName() {
		global $sugar_config;

		//get position of last "." in file name
		$file_ext_beg = strrpos($this->filename, ".");
		$file_ext = "";

		//get file extension
		if($file_ext_beg !== false) {
			$file_ext = substr($this->filename, $file_ext_beg + 1);
		}

		//check to see if this is a file with extension located in "badext"
		foreach($sugar_config['upload_badext'] as $badExt) {
			if(strtolower($file_ext) == strtolower($badExt)) {
				//if found, then append with .txt and break out of lookup
				$this->name = $this->name . ".txt";
				$this->file_mime_type = 'text/';
				$this->filename = $this->filename . ".txt";
				break; // no need to look for more
			}
		}

	}

	/**
	 * overrides SugarBean's method.
	 * If a system setting is set, it will mark all related notes as deleted, and attempt to delete files that are
	 * related to those notes
	 * @param string id ID
	 */
	function mark_deleted($id) {
		global $sugar_config;

		if($this->parent_type == 'Emails') {
			if(isset($sugar_config['email_default_delete_attachments']) && $sugar_config['email_default_delete_attachments'] == true) {
				$removeFile = "upload://$id";
				if(file_exists($removeFile)) {
					if(!unlink($removeFile)) {
						$GLOBALS['log']->error("*** Could not unlink() file: [ {$removeFile} ]");
					}
				}
			}
		}

		// delete note
		parent::mark_deleted($id);
	}

	function deleteAttachment($isduplicate="false"){
		if($this->ACLAccess('edit')){
			if($isduplicate=="true"){
				return true;
			}
			$removeFile = "upload://{$this->id}";
		}

		if(file_exists($removeFile)) {
			if(!unlink($removeFile)) {
				$GLOBALS['log']->error("*** Could not unlink() file: [ {$removeFile} ]");
			}else{
				$this->filename = '';
				$this->file_mime_type = '';
				$this->file = '';
				$this->save();
				return true;
			}
		} else {
			$this->filename = '';
			$this->file_mime_type = '';
			$this->file = '';
			$this->save();
			return true;
		}
		return false;
	}


	function get_summary_text() {
		return "$this->name";
	}

    function create_export_query(&$order_by, &$where, $relate_link_join='')
    {
        $custom_join = $this->getCustomJoin(true, true, $where);
        $custom_join['join'] .= $relate_link_join;
		$query = "SELECT notes.*, contacts.first_name, contacts.last_name, users.user_name as assigned_user_name ";

        $query .= $custom_join['select'];

    	$query .= " FROM notes ";

		$query .= "	LEFT JOIN contacts ON notes.contact_id=contacts.id ";
        	$query .= "  LEFT JOIN users ON notes.assigned_user_id=users.id ";
	
        $query .= $custom_join['join'];

		$where_auto = " notes.deleted=0 AND (contacts.deleted IS NULL OR contacts.deleted=0)";

        if($where != "")
			$query .= "where $where AND ".$where_auto;
        else
			$query .= "where ".$where_auto;

        $order_by = $this->process_order_by($order_by);
        if (empty($order_by)) {
            $order_by = 'notes.name';
        }
        $query .= ' ORDER BY ' . $order_by;

		return $query;
	}

	function fill_in_additional_list_fields() {
		$this->fill_in_additional_detail_fields();
	}

	function fill_in_additional_detail_fields() {
		parent::fill_in_additional_detail_fields();
		//TODO:  Seems odd we need to clear out these values so that list views don't show the previous rows value if current value is blank
		$this->getRelatedFields('Contacts', $this->contact_id, array('name'=>'contact_name', 'phone_work'=>'contact_phone') );
		if(!empty($this->contact_name)){

			$emailAddress = new SugarEmailAddress();
			$this->contact_email = $emailAddress->getPrimaryAddress(false, $this->contact_id, 'Contacts');
		}

		if(isset($this->contact_id) && $this->contact_id != '') {
		    $contact = new Contact();
		    $contact->retrieve($this->contact_id);
		    if(isset($contact->id)) {
		        $this->contact_name = $contact->full_name;
		    }
		}
	}


	function get_list_view_data()
	{
		$note_fields = $this->get_list_view_array();
		global $app_list_strings, $focus, $action, $currentModule,$mod_strings, $sugar_config;

		if(isset($this->parent_type)) {
			$note_fields['PARENT_MODULE'] = $this->parent_type;
		}

		if(!empty($this->filename)) {
            if(file_exists("upload://{$this->id}")){
                $note_fields['FILENAME'] = $this->filename;
                $note_fields['FILE_URL'] = UploadFile::get_upload_url($this);
            }
        }
        if(isset($this->contact_id) && $this->contact_id != '') {
			$contact = new Contact();
			$contact->retrieve($this->contact_id);
			if(isset($contact->id)) {
			    $this->contact_name = $contact->full_name;
			}
		}
        if(isset($this->contact_name)){
        	$note_fields['CONTACT_NAME'] = $this->contact_name;
        }

		global $current_language;
		$mod_strings = return_module_language($current_language, 'Notes');
		$note_fields['STATUS']=$mod_strings['LBL_NOTE_STATUS'];


		return $note_fields;
	}

	function listviewACLHelper() {
		$array_assign = parent::listviewACLHelper();
		$is_owner = false;
		if(!empty($this->parent_name)) {
			if(!empty($this->parent_name_owner)) {
				global $current_user;
				$is_owner = $current_user->id == $this->parent_name_owner;
			}
		}

		if(!ACLController::moduleSupportsACL($this->parent_type) || ACLController::checkAccess($this->parent_type, 'view', $is_owner)) {
			$array_assign['PARENT'] = 'a';
		} else {
			$array_assign['PARENT'] = 'span';
		}

		$is_owner = false;
		if(!empty($this->contact_name)) {
			if(!empty($this->contact_name_owner)) {
				global $current_user;
				$is_owner = $current_user->id == $this->contact_name_owner;
			}
		}

		if( ACLController::checkAccess('Contacts', 'view', $is_owner)) {
			$array_assign['CONTACT'] = 'a';
		} else {
			$array_assign['CONTACT'] = 'span';
		}

		return $array_assign;
	}

	function bean_implements($interface) {
		switch($interface) {
			case 'ACL':return true;
            case 'FILE' : return true;
		}
		return false;
	}
}

?>
