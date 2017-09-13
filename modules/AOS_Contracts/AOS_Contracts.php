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

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/AOS_Contracts/AOS_Contracts_sugar.php');

class AOS_Contracts extends AOS_Contracts_sugar {

	function __construct(){

		parent::__construct();

        //Process the default reminder date setting
        if($this->id == null && $this->renewal_reminder_date == null){
            global $sugar_config, $timedate;

            $default_time = "12:00:00";

            $period = empty($sugar_config['aos'])?false:(int)$sugar_config['aos']['contracts']['renewalReminderPeriod'];

            //Calculate renewal date from end_date minus $period days and format this.
            if($period && !empty($this->end_date)){
                $renewal_date = $timedate->fromUserDate($this->end_date);

                $renewal_date->modify("-$period days");
                $time_value = $timedate->fromString($default_time);
                $renewal_date->setTime($time_value->hour,$time_value->min,$time_value->sec);

                $renewal_date = $renewal_date->format($timedate->get_date_time_format());
                $this->renewal_reminder_date = $renewal_date;

            }
        }
	}


    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function AOS_Contracts(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

	function save($check_notify = FALSE){
        if (empty($this->id)){
            unset($_POST['group_id']);
            unset($_POST['product_id']);
            unset($_POST['service_id']);
        }

		if(isset($_POST['renewal_reminder_date']) && !empty($_POST['renewal_reminder_date'])){
			$this->createReminder();
		}

        require_once('modules/AOS_Products_Quotes/AOS_Utils.php');

        perform_aos_save($this);

		parent::save($check_notify);

        require_once('modules/AOS_Line_Item_Groups/AOS_Line_Item_Groups.php');
        $productQuoteGroup = new AOS_Line_Item_Groups();
        $productQuoteGroup->save_groups($_POST, $this, 'group_');

		if(isset($_POST['renewal_reminder_date']) && !empty($_POST['renewal_reminder_date'])){
			$this->createLink();
		}

	}

	function mark_deleted($id)
	{
        $productQuote = new AOS_Products_Quotes();
        $productQuote->mark_lines_deleted($this);
        $this->deleteCall();
		parent::mark_deleted($id);

	}

	function createReminder(){
	    require_once('modules/Calls/Call.php');
	    $call = new call();

        if($this->renewal_reminder_date != 0){

            $call->id = $this->call_id;
            $call->parent_id = $this->id;
            $call->parent_type = 'AOS_Contracts';
            $call->date_start = $this->renewal_reminder_date;
            $call->name = $this->name . ' Contract Renewal Reminder';
            $call->assigned_user_id = $this->assigned_user_id;
            $call->status = 'Planned';
            $call->direction = 'Outbound';
            $call->reminder_time = 60;
            $call->duration_hours = 0;
            $call->duration_minutes = 30;
            $call->deleted = 0;
            $call->save();
            $this->call_id = $call->id;
        }
	}

	function createLink(){
	    require_once('modules/Calls/Call.php');
	    $call = new call();

		if($this->renewal_reminder_date != 0){
            $call->id = $this->call_id;
            $call->parent_id = $this->contract_account_id;
            $call->parent_type = 'Accounts';
            $call->reminder_time = 60;
            $call->save();
		}
	}

	function deleteCall(){
	    require_once('modules/Calls/Call.php');
	    $call = new call();

		if($this->call_id != null){
            $call->id = $this->call_id;
            $call->mark_deleted($call->id);
		}
	}

}
?>
