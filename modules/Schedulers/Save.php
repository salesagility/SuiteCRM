<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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

require_once('include/formbase.php');

$focus = new Scheduler();
$focus = populateFromPost('', $focus);

///////////////////////////////////////////////////////////////////////////////
////	USE_ADV override
if (!isset($_REQUEST['adv_interval']) || $_REQUEST['adv_interval'] == 'false' || $_REQUEST['adv_interval'] == '0') {
    // Fix for issue #1142 - basic Scheduler settings do not allow to specify  day_of_month or which month it should run on,
    // so both of these options should be set to '*'; . These is especially important in case user moves from advanced to basic settings.
    $_REQUEST['day_of_month'] = '*';
    $_REQUEST['months'] = '*';

    // days of week
    $xtDays = array(1 => 'mon',
                    2 => 'tue',
                    3 => 'wed',
                    4 => 'thu',
                    5 => 'fri',
                    6 => 'sat',
                    0 => 'sun');
                    
    if ((isset($_REQUEST['mon']) && $_REQUEST['mon'] == 'true') &&
        (isset($_REQUEST['tue']) && $_REQUEST['tue'] == 'true') &&
        (isset($_REQUEST['wed']) && $_REQUEST['wed'] == 'true') &&
        (isset($_REQUEST['thu']) && $_REQUEST['thu'] == 'true') &&
        (isset($_REQUEST['fri']) && $_REQUEST['fri'] == 'true') &&
        (isset($_REQUEST['sat']) && $_REQUEST['sat'] == 'true') &&
        (isset($_REQUEST['sun']) && $_REQUEST['sun'] == 'true')) {
        $_REQUEST['day_of_week'] = '*';
    } else {
        $day_string = '';
        foreach ($xtDays as $k => $day) {
            if (isset($_REQUEST[$day]) && $_REQUEST[$day] == 'true') {
                if ($day_string != '') {
                    $day_string .= ',';
                }
                $day_string .= $k;
            }
        }
        $_REQUEST['day_of_week'] = $day_string;
    }


    if ($_REQUEST['basic_period'] == 'min') {
        $_REQUEST['mins'] = '*/'.$_REQUEST['basic_interval'];
        $_REQUEST['hours'] = '*';
    } else {
        // Bug # 44933 - hours cannot be greater than 23
        if ($_REQUEST['basic_interval'] < 24) {
            $_REQUEST['hours'] = '*/'.$_REQUEST['basic_interval'];
        } else {
            $_REQUEST['hours'] = '0'; // setting it to run midnight every 24 hours
        }
        $_REQUEST['mins'] = '0';    // on top of the hours
    }
}

////	END USE_ADV override
///////////////////////////////////////////////////////////////////////////////
$focus->job_interval = $_REQUEST['mins']."::".$_REQUEST['hours']."::".$_REQUEST['day_of_month']."::".$_REQUEST['months']."::".$_REQUEST['day_of_week'];
// deal with job types
// neither
if (($_REQUEST['job_function'] == 'url::') && ($_REQUEST['job_url'] == '' || $_REQUEST['job_url'] == 'http://')) {
    $GLOBALS['log']->fatal('Scheduler save did not get a job_url or job_function');
} elseif (($_REQUEST['job_function'] != 'url::') && ($_REQUEST['job_url'] != '' && $_REQUEST['job_url'] != 'http://')) {
    $GLOBALS['log']->fatal('Scheduler got both a job_url and job_function');
}
//function
if (($_REQUEST['job_function'] != 'url::')) {
    $focus->job = $_REQUEST['job_function'];
} elseif ($_REQUEST['job_url'] != '' && $_REQUEST['job_url'] != 'http://') { // url
    $focus->job = 'url::'.$_REQUEST['job_url'];
} // url wins if both passed

// save should refresh ALL jobs
$focus->save();
$return_id = $focus->id;

$edit='';
if (isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") {
    $return_module = $_REQUEST['return_module'];
} else {
    $return_module = "Schedulers";
}
if (isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") {
    $return_action = $_REQUEST['return_action'];
} else {
    $return_action = "DetailView";
}
if (isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") {
    $return_id = $_REQUEST['return_id'];
}
if (!empty($_REQUEST['edit'])) {
    $return_id='';
    $edit='edit=true';
}

$GLOBALS['log']->debug("Saved record with id of ".$return_id);

header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&$edit");
