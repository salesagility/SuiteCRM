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

class AlertsController extends SugarController
{
    public function action_get()
    {
        die();
    }

    /**
     * Use by Alerts.js to get the current alerts
     */
    public function action_getCurrentAlerts() {
        global $current_user, $db, $tiemdate;
        $NOW = new DateTime();
        $MOMENT = new DateTime();
        $MOMENT = $MOMENT->sub(new DateInterval('PT10S'));
        $query = "SELECT id FROM alerts WHERE deleted = 0 AND
                  delivery_datetime >= '$MOMENT' AND delivery_datetime <= '$NOW'
                  AND subscribers LIKE '%\"is_read\":false%' AND subscribers LIKE '%$current_user->id%'";
        $alerts = array();
        $result = $db->query($query);
        while ($row = $db->fetchByAssoc($result)) {
            $alert = new Alert();
            $alert->retrieve($row['id']);
            if (array_key_exists($current_user->id, $alert->subscribers)) {
                $alerts[] = array(
                    "id" => $alert->id,
                    "name" => $alert->name,
                    "description" => $alert->description,
                    "target_module" => $alert->target_module,
                    "target_module_id" => $alert->target_module_id,
                    "url_redirect" => $alert->url_redirect,
                    "send_email" => $alert->send_email,
                    "send_sms" => $alert->send_sms,
                    "send_popup" => $alert->send_popup,
                    "send_to_manager" => $alert->send_to_manager,
                    "content_type" => $alert->content_type,
                    "delivery_datetime" => $alert->delivery_datetime,
                    "type" => $alert->type,
                    "was_sent" => $alert->was_sent
                );
                // Since this is technically sending a popup.
                $alert->was_sent = true;
                $alert->save();
            }
        }
        header('Content-Type: application/json');
        $return_value = json_encode($alerts);
        echo $return_value;
        die();
    }

    public function action_getUnread() {
        global  $current_user, $db;
        $query = 'SELECT id FROM alerts WHERE deleted = 0 AND
                  delivery_datetime >= NOW() - INTERVAL 1 DAY AND delivery_datetime <= NOW()
                  AND subscribers LIKE \'%"is_read":false%\' AND subscribers LIKE \'%'.$current_user->id.'%\'';
        $alerts = array();
        $result = $db->query($query);
        while($row = $db->fetchByAssoc($result)) {
            $alert = new Alert();
            $alert->retrieve($row['id']);
            if(array_key_exists($current_user->id, $alert->subscribers)) {
                $alerts[] = array(
                    "id" => $alert->id,
                    "name" => $alert->name,
                    "description" => $alert->description,
                    "target_module" => $alert->target_module,
                    "target_module_id" => $alert->target_module_id,
                    "url_redirect" => $alert->url_redirect,
                    "send_email" => $alert->send_email,
                    "send_sms" => $alert->send_sms,
                    "send_popup" => $alert->send_popup,
                    "send_to_manager" => $alert->send_to_manager,
                    "content_type" => $alert->content_type,
                    "delivery_datetime" => $alert->delivery_datetime,
                    "type" => $alert->type,
                    "was_sent" => $alert->was_sent
                );
            }
        }

        header('Content-Type: application/json');
        $return_value = json_encode($alerts);
        echo $return_value;
        die();
    }

    public function action_countUnread() {
        global  $current_user, $db;
        $query = 'SELECT id FROM alerts WHERE deleted = 0 AND
                  delivery_datetime >= NOW() - INTERVAL 1 DAY AND delivery_datetime <= NOW()
                  AND subscribers LIKE \'%"is_read":false%\' AND subscribers LIKE \'%'.$current_user->id.'%\'';
        $count = 0;
        $result = $db->query($query);
        while($row = $db->fetchByAssoc($result)) {
            $alert = new Alert();
            $alert->retrieve($row['id']);
            if(array_key_exists($current_user->id, $alert->subscribers)) {
                $count++;
            }
        }

        header('Content-Type: application/json');
        echo "{count:".$count."}";
        die();
    }

    public function action_countMissed() {}

    public function action_add()
    {
        global $current_user;
        $name = null;
        $description = null;

        $assigned_user_id = $current_user->id;
        $is_read = 0;
        $url_redirect = null;
        $target_module = null;
        $type = 'info';


        if(isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if(isset($_POST['description'])) {
            $description = $_POST['description'];
        }
        if(isset($_POST['is_read'])) {
            $is_read = $_POST['is_read'];
        }
        if(isset($_POST['url_redirect'])) {
            $url_redirect = $_POST['url_redirect'];
        } else {
            $url_redirect == null;
        }

        if(isset($_POST['target_module'])) {
            $target_module = $_POST['target_module'];
        }
        if(isset($_POST['type'])) {
            $type = $_POST['type'];
        }

        if(isset($_POST)) {
            $bean = BeanFactory::getBean('Alerts');
            $result = $bean->get_full_list("","alerts.assigned_user_id = '".$current_user->id."' AND url_redirect = '".$_POST['url_redirect']."' AND is_read != 1");
            if(empty($result)) {
                $bean = BeanFactory::newBean('Alerts');
                $bean->name = $name;
                $bean->description = $description;
                $bean->url_redirect = $url_redirect;
                $bean->target_module = $target_module;
                $bean->is_read = $is_read;
                $bean->assigned_user_id = $assigned_user_id;
                $bean->type = $type;
                $bean->save();
            }
        }

        $this->view_object_map['Flash'] = '';
        $this->view_object_map['Result'] = '';
        $this->view = 'json';
    }

    public function action_markAsRead()
    {
        $bean = BeanFactory::getBean('Alerts', $_GET['record']);
        $bean->is_read = 1;
        $bean->save();
        die();
        $this->view = 'json';
    }

    public function action_redirect()
    {
        $bean = BeanFactory::getBean('Alerts', $_GET['record']);
        $bean->is_read = 1;
        $bean->save();

        if(empty($bean->url_redirect)) {
            if (!empty($_SERVER['HTTP_REFERER'])){
                SugarApplication::redirect($_SERVER['HTTP_REFERER']);
            }
            SugarApplication::redirect('index.php');
        }


        SugarApplication::redirect($bean->url_redirect);

    }
}