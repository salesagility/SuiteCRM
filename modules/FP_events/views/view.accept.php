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

function sort_delegates($a,$b){
		if ($a['name'] == $b['name']) {
			return 0;
		}
		return ($a['name'] < $b['name']) ? -1 : 1;
}


class Viewaccept extends SugarView
{

 	function display(){
				
		if(empty($this->bean->id)){
			global $app_strings;
			sugar_die($app_strings['ERROR_NO_RECORD']);
		}	

		global $mod_strings;
		
 		$event_id=$this->bean->id;
		$event_date = substr ( $this->bean->date_start , 0 , 10 );
		
		$logo_img = 'themes/default/images/company_logo.png';
		if (file_exists ( 'custom/themes/default/images/company_logo.png')) 
			$logo_img = 'custom/themes/default/images/company_logo.png';

		echo <<< EOQ
<div>
<table width='100%'  style='font-size: 15px;'>
 <thead>
  <tr style='page-break-inside:avoid' border='0' cellspacing='0' cellpadding='0' style='border-collapse:collapse;border:none'>
   <td style='width:30%'>
   <img src='$logo_img'/><br>
   </td>
   <td style='width:30%'>
   <p style='font-size: 25px;'>{$this->bean->name}</p>
   <p style='font-size: 18px;'>{$event_date}</p><p>&nbsp;</p>
   </td>
   <td style='width:10%'>
   </td>
   <td style='width:30%'>
   </td>
  </tr>
  <tr style='page-break-inside:avoid' border='0' cellspacing='0' cellpadding='0' style='border-collapse:collapse;border:none'>
   <td style='width:30%'>
   {$mod_strings['LBL_CONTACT_NAME']}
   </td>
   <td style='width:30%'>
   {$mod_strings['LBL_ACCOUNT_NAME']}
   </td>
   <td style='width:30%'>
   <p style='font-size: 15px;'>{$mod_strings['LBL_SIGNATURE']}</p>
   </td>
  </tr>
 </thead>
 <tbody>
EOQ;
		global $db;
		$accepted = array();
        $query = 'select fp_events_contacts_c.fp_events_contactscontacts_idb as id FROM fp_events_contacts_c JOIN contacts on contacts.id=fp_events_contacts_c.fp_events_contactscontacts_idb WHERE fp_events_contacts_c.deleted=0 AND contacts.deleted = 0 AND accept_status="Accepted" AND fp_events_contactsfp_events_ida="'.$event_id.'" ORDER BY contacts.last_name';

        $res = $db->query($query);
        while($row = $db->fetchByAssoc($res))
            {
				$contact=BeanFactory::getBean('Contacts', $row['id']);
				if ($contact->account_id !=''){
					$account=BeanFactory::getBean('Accounts', $contact->account_id);
					$account_name = $account->name;
				}
				else  {
					$account_name = '';
				}
				$name=strtoupper($contact->last_name).'&nbsp;'.$contact->first_name;
				$accepted[]= array('name' => $name,'account_name' => $account_name);
            }

        $query = 'select fp_events_leads_1_c.fp_events_leads_1leads_idb as id FROM fp_events_leads_1_c JOIN leads on leads.id=fp_events_leads_1_c.fp_events_leads_1leads_idb WHERE fp_events_leads_1_c.deleted=0 AND leads.deleted = 0 AND accept_status="Accepted" AND fp_events_leads_1fp_events_ida="'.$event_id.'" ORDER BY leads.last_name';

        $res = $db->query($query);
        while($row = $db->fetchByAssoc($res))
            {
				$contact=BeanFactory::getBean('Leads', $row['id']);
				$account_name = $contact->account_name;
				$name=strtoupper($contact->last_name).'&nbsp;'.$contact->first_name;
				$accepted[]= array('name' => $name,'account_name' => $account_name);
            }
			
        $query = 'select fp_events_prospects_1_c.fp_events_prospects_1prospects_idb as id FROM fp_events_prospects_1_c JOIN prospects on prospects.id=fp_events_prospects_1_c.fp_events_prospects_1prospects_idb WHERE fp_events_prospects_1_c.deleted=0 AND prospects.deleted = 0 AND accept_status="Accepted" AND fp_events_prospects_1fp_events_ida="'.$event_id.'" ORDER BY prospects.last_name';

        $res = $db->query($query);
        while($row = $db->fetchByAssoc($res))
            {
				$contact=BeanFactory::getBean('Leads', $row['id']);
				$account_name = $contact->account_name;
				$name=strtoupper($contact->last_name).'&nbsp;'.$contact->first_name;
				$accepted[]= array('name' => $name,'account_name' => $account_name);
            }
		
		usort($accepted, "sort_delegates");
		
		foreach ($accepted as $delegate){
				echo "<tr style='border-top:1px solid;border-bottom:1px solid;margin:0px;' >" . 
					"<td style='width:30%;border-top:1px solid;border-bottom:1px solid;font-size:12px;padding:8px;' >{$delegate['name']}</td>" .
					"<td style='width:30%;border-top:1px solid;border-bottom:1px solid;font-size:12px;padding:8px;' >{$delegate['account_name']}</td>" .
					"<td style='width:30%;border-top:1px solid;border-bottom:1px solid;'  >&nbsp;</td>" .
					"</tr>";
		}
		echo <<< EOQ
 </tbody>
 </table>
 </div>
EOQ;

 	} 	
}

?>