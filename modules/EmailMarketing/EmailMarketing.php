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


class EmailMarketing extends SugarBean
{
	var $field_name_map;

	var $id;
	var $deleted;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $created_by;
	var $name;
	var $from_addr;
	var $from_name;
	var $reply_to_name;
	var $reply_to_addr;
	var $date_start;
	var $time_start;
	var $template_id;
	var $campaign_id;
	var $all_prospect_lists;
	var $status;
	var $inbound_email_id;

	var $table_name = 'email_marketing';
	var $object_name = 'EmailMarketing';
	var $module_dir = 'EmailMarketing';

	var $new_schema = true;

	function EmailMarketing()
	{
		parent::SugarBean();



	}

	function retrieve($id, $encode=true, $deleted=true) {
	    parent::retrieve($id,$encode,$deleted);

        global $timedate;
        $date_start_array=explode(" ",trim($this->date_start));
        if (count($date_start_array)==2) {
			$this->time_start = $date_start_array[1];
        	$this->date_start = $date_start_array[0];
        }
        return $this;
	}

	function get_summary_text()
	{
		return $this->name;
	}

	function create_export_query($order_by, $where)
	{
		return $this->create_new_list_query($order_by, $where);
	}

	function get_list_view_data(){

		$temp_array = $this->get_list_view_array();

		$id = $temp_array['ID'];
		$template_id = $temp_array['TEMPLATE_ID'];

		//mode is set by schedule.php from campaigns module.
		if (!isset($this->mode) or empty($this->mode) or $this->mode!='test') {
			$this->mode='rest';
		}

		if ($temp_array['ALL_PROSPECT_LISTS']==1) {
			$query="SELECT name from prospect_lists ";
			$query.=" INNER JOIN prospect_list_campaigns plc ON plc.prospect_list_id = prospect_lists.id";
			$query.=" WHERE plc.campaign_id='{$temp_array['CAMPAIGN_ID']}'";
			$query.=" AND prospect_lists.deleted=0";
			$query.=" AND plc.deleted=0";
			if ($this->mode=='test') {
				$query.=" AND prospect_lists.list_type='test'";
			} else {
				$query.=" AND prospect_lists.list_type!='test'";
			}
		} else {
			$query="SELECT name from prospect_lists ";
			$query.=" INNER JOIN email_marketing_prospect_lists empl ON empl.prospect_list_id = prospect_lists.id";
			$query.=" WHERE empl.email_marketing_id='{$id}'";
			$query.=" AND prospect_lists.deleted=0";
			$query.=" AND empl.deleted=0";
			if ($this->mode=='test') {
				$query.=" AND prospect_lists.list_type='test'";
			} else {
				$query.=" AND prospect_lists.list_type!='test'";
			}
		}
		$res = $this->db->query($query);
		while (($row = $this->db->fetchByAssoc($res)) != null) {
			if (!empty($temp_array['PROSPECT_LIST_NAME'])) {
				$temp_array['PROSPECT_LIST_NAME'].="<BR>";
			}
			$temp_array['PROSPECT_LIST_NAME'].=$row['name'];
		}
		return $temp_array;
	}

	function bean_implements($interface){
		switch($interface){
			case 'ACL':return true;
		}
		return false;
	}

	function get_all_prospect_lists() {

		$query="select prospect_lists.* from prospect_lists ";
		$query.=" left join prospect_list_campaigns on prospect_list_campaigns.prospect_list_id=prospect_lists.id";
		$query.=" where prospect_list_campaigns.deleted=0";
		$query.=" and prospect_list_campaigns.campaign_id='$this->campaign_id'";
		$query.=" and prospect_lists.deleted=0";
		$query.=" and prospect_lists.list_type not like 'exempt%'";

		return $query;
	}
}
?>