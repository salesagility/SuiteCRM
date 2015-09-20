<?php
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
require_once('include/SugarObjects/templates/basic/Basic.php');
require_once('modules/Alerts/EAlertType.php');
require_once('modules/Alerts/EAlertContentType.php');
class Alert extends Basic {

    var $new_schema = true;
    var $module_dir = 'Alerts';
    var $object_name = 'Alert';
    var $table_name = 'alerts';
    var $importable = false;
    var $disable_row_level_security = true ; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO
    var $id;
    var $name = 'Alert';
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $modified_by_name;
    var $created_by;
    var $created_by_name;
    var $description = '-';
    var $deleted;
    var $created_by_link;
    var $modified_user_link;
    var $assigned_user_id;
    var $assigned_user_name;
    var $assigned_user_link;
    var $deilivery_datetime;
    var $content_type = EAlertContentType::text;
    var $was_sent = false;
    var $send_email = false;
    var $send_popup = false;
    var $send_sms = false;
    var $send_to_manager = false;
    var $type = EAlertType::info;
    var $target_module = 'Alerts';
    var $target_module_id = '';
    var $url_redirect = null;
    var $subscribers = array();

    /**
     * @param $id
     */
    function Alert() {
        parent::Basic();
    }

    /**
     * @param $interface
     * @return bool
     */
    function bean_implements($interface) {
        switch($interface) {
            case 'ACL': return true;
            case 'Alert': return true;
        }
        return false;
    }

    /**
     * @param bool|FALSE $check_notify
     */
    function save($check_notify = FALSE) {
        global $mod_strings;

        // Assign defaults if empty
        if($this->url_redirect === null) {
            $this->url_redirect = 'index.php?module='.$this->target_module.'&record='.$this->target_module_id;
        }
        // Create a copy of subscribers (in its php array form)
        $subscribers = $this->subscribers;

        // convert to a json string
        $this->subscribers = utf8_encode(json_encode($this->subscribers));

        // save bean
        parent::save($check_notify);

        // convert it back to a php array;
        $this->subscribers = $subscribers;
        $break = 1;
    }

    /**
     * Custom retrieve handling
     * @param int $id
     * @param bool|true $encode
     * @param bool|true $deleted
     * @return $this (Alert)
     */
    function retrieve($id = -1, $encode=true, $deleted=true) {
        // run normal retrieve
        $instance = parent::retrieve($id, $encode, $deleted);
        // custom handling for subscribers
        // (prevents undefined exception)
        $instance->subscribers = str_replace("&quot;",'"', $instance->subscribers);
        $instance->subscribers = json_decode(utf8_decode($instance->subscribers));

        // Convert from stdClass to Array
        $subscribers = array();
        foreach($instance->subscribers as $key => $value) {
            $subscribers[$key] = (array)$value;
        }
        $this->subscribers = $subscribers;

        return $instance;
    }

    /**
     * Add a subscriber to alert (This doesn't save the bean)
     * @param SugarBean $subscriber_bean
     */
    function subscribeBean(SugarBean $subscriber_bean) {
        $subscriber = array(
            'id' => $subscriber_bean->id,
            'module_name' => $subscriber_bean->module_name,
        );
        $this->subscribers[$subscriber_bean->id] = $subscriber;
    }

    /**
     * Add a subscriber to alert (This doesn't save the bean)
     * @param $subscriber_bean
     * @param $subscriber_id
     */
    function subscribe($subscriber_bean, $subscriber_id) {
        $subscriber = array(
            'id' => $subscriber_id,
            'module_name' => $subscriber_bean,
            'is_read' => false
        );
        $this->subscribers[$subscriber_id] = $subscriber;
    }

    /**
     * Removes a subscriber from alert (This doesn't save the bean)
     * @param SugarBean $subscriber_bean
     */
    function unsubscribe(SugarBean $subscriber_bean) {
        foreach($this->subscribers as $key => $subscriber) {
            if($subscriber_bean->id == $subscriber['id']) {
                unset($this->subscribers[$key]);
                break;
            }
        }
    }

    /**
     * Clears subscription
     */
    function unsubscribeAll() {
        foreach($this->subscribers as $key => $subscriber) {
            unset($this->subscribers[$key]);
        }
    }
    /**
     * @param SugarBean $bean
     * @return Alert - An Array of all the alerts in which $bean is subscribed to
     */
    function fetch_all_alerts_for_subscriber(SugarBean $bean) {
        $alertBean = new Alert();
        $alertBean->get_full_list("", "subscribers LIKE %".$bean->module_name."% AND subscribers LIKE %".$bean->id."%");
        return $alertBean;
    }
}
?>