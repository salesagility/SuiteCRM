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

require_once('modules/Calls_Reschedule/Calls_Reschedule.php');
require_once('modules/Calls/Call.php');

global $locale, $app_list_strings, $app_strings, $current_user;

$id = $_GET['call_id'];//get the call id

$call = new call();
//get the users name format settings
$firstname = $current_user->first_name;
$lastname = $current_user->last_name;

$full_name = $locale->getLocaleFormattedName($firstname, $lastname);

$user_real_names = $current_user->getPreference('use_real_names');

if($user_real_names == 'on'){
    $Name = $full_name;
} else{
    $Name = $current_user->user_name;
}

$time_format = $current_user->getPreference('timef'); //get the current users time format setting
$dateformat = $current_user->getPreference('datef');//get the current users date format
$call->retrieve($id); //get the call fields

$time_stamp = $call->date_start; //get the time stamp for the current call

//Set the date and time input fields on the pop-up based on the current users time format setting
switch($time_format)
{
    case 'H:i':
        $existing_date = explode(" ",$time_stamp);//splits the date from the time
        $time = $existing_date[1];//gets the time
        $date = $existing_date[0];//gets the date
        $time = explode(":",$time);//splits the time into hours and minutes
        $hour = $time[0];//gets the hour
        $min = $time[1];//gets the time
        $period = '';
        $format = '23:00';//set time format for the javascript live update of date/time
        break;
    case 'H.i':
        $existing_date = explode(" ",$time_stamp);
        $time = $existing_date[1];
        $date = $existing_date[0];
        $time = explode(".",$time);
        $hour = $time[0];
        $min = $time[1];
        $period = '';
        $format = '23.00';
        break;
    case 'h:ia':
        $existing_date = explode(" ",$time_stamp);//splits the date from the time
        $time = $existing_date[1];//gets the time
        $date = $existing_date[0];//gets the date
        $time = explode(":",$time);//splits the time into hours and minutes
        $hour = $time[0];//gets the hour
        $min = $time[1];//gets the time
        $period = substr($min, -2);//gets only the 'pm' from the time
        $min = substr($min, 0,2);//gets only the minutes from the time
        $format = '11:00pm';
        break;
    case 'h:i a':
        $existing_date = explode(" ",$time_stamp);//splits the date from the time and the period from time
        $time = $existing_date[1];//gets the time
        $date = $existing_date[0];//gets the date
        $period = $existing_date[2];//gets the period
        $time = explode(":",$time);
        $hour = $time[0];
        $min = $time[1];
        $format = '11:00 pm';
        break;
    case 'h:iA':
        $existing_date = explode(" ",$time_stamp);//splits the date from the time
        $time = $existing_date[1];//gets the time
        $date = $existing_date[0];//gets the date
        $time = explode(":",$time);//splits the time into hours and minutes
        $hour = $time[0];//gets the hour
        $min = $time[1];//gets the time
        $period = substr($min, -2);//gets only the 'pm' from the time
        $min = substr($min, 0,2);//gets only the minutes from the time
        $format = '11:00PM';
        break;
    case 'h:i A':
        $existing_date = explode(" ",$time_stamp);//splits the date from the time and the period from time
        $time = $existing_date[1];//gets the time
        $date = $existing_date[0];//gets the date
        $period = $existing_date[2];//gets the period
        $time = explode(":",$time);
        $hour = $time[0];
        $min = $time[1];
        $format = '11:00 PM';
        break;
    case 'h.ia':
        $existing_date = explode(" ",$time_stamp);//splits the date from the time
        $time = $existing_date[1];//gets the time
        $date = $existing_date[0];//gets the date
        $time = explode(".",$time);//splits the time into hours and minutes
        $hour = $time[0];//gets the hour
        $min = $time[1];//gets the time
        $period = substr($min, -2);//gets only the 'pm' from the time
        $min = substr($min, 0,2);//gets only the minutes from the time
        $format = '11.00pm';
        break;
    case 'h.i a':
        $existing_date = explode(" ",$time_stamp);//splits the date from the time and the period from time
        $time = $existing_date[1];//gets the time
        $date = $existing_date[0];//gets the date
        $period = $existing_date[2];//gets the period
        $time = explode(".",$time);
        $hour = $time[0];
        $min = $time[1];
        $format = '11.00 pm';
        break;
    case 'h.iA':
        $existing_date = explode(" ",$time_stamp);//splits the date from the time
        $time = $existing_date[1];//gets the time
        $date = $existing_date[0];//gets the date
        $time = explode(".",$time);//splits the time into hours and minutes
        $hour = $time[0];//gets the hour
        $min = $time[1];//gets the time
        $period = substr($min, -2);//gets only the 'pm' from the time
        $min = substr($min, 0,2);//gets only the minutes from the time
        $format = '11.00PM';
        break;
    case 'h.i A':
        $existing_date = explode(" ",$time_stamp);//splits the date from the time and the period from time
        $time = $existing_date[1];//gets the time
        $date = $existing_date[0];//gets the date
        $period = $existing_date[2];//gets the period
        $time = explode(".",$time);
        $hour = $time[0];
        $min = $time[1];
        $format = '11.00 PM';
        break;
}
?>
<div id="dialog1" class="yui-pe-content">
    <div id="date_start_time_section"> </div>
    <div class="hd"><?php echo $app_strings['LBL_RESCHEDULE_TITLE']; ?></div>
    <div class="bd">
        <form method="POST" action="index.php?module=Calls&action=Reschedule">
            <input id="use_real_names" type="hidden" name="use_real_names" value="<?php echo $user_real_names; ?>">
            <input id="format" type="hidden" name="format" value="<?php echo $format; ?>">
            <input id="dateformat" type="hidden" name="dateformat" value="<?php echo $dateformat; ?>">
            <input id="format" type="hidden" name="user" value="<?php echo $Name; ?>" >
            <input id="call_id" type="hidden" name="call_id" >
            <label for="date"><?php echo $app_strings['LBL_RESCHEDULE_DATE']; ?></label><br />
            <input id="date" type="textbox" name="date" value="<?php echo $date;?>" />
            <img id="date_start_trigger"  border="0" style="position:relative; top:2px" alt="Enter Date" src="themes/Suite7/images/jscalendar.gif"/>
<?php
//$mins is the minutes option
$mins = '<select id="date_start_minutes" name="date_start_minutes" class="datetimecombo_time" size="1">';
//$mins .= '<option></option>';
    if($min == '00'){$mins .= '<option selected="selected" value="00">00</option>';} else{$mins.= '<option value="00">00</option>';}
    if($min == '15'){$mins .= '<option selected="selected" value="15">15</option>';} else{$mins.= '<option value="15">15</option>';}
    if($min == '30'){$mins .= '<option selected="selected" value="30">30</option>';} else{$mins.= '<option value="30">30</option>';}
    if($min == '45'){$mins .= '<option selected="selected" value="45">45</option>';} else{$mins.= '<option value="45">45</option>';}
$mins .= '</select>';

//$merm1 is lower case am / pm
$merm1 =  '<select id="date_start_meridiem" name="date_start_meridiem" class="datetimecombo_time" size="1">';
//$merm1 .= '<option></option>';

if($period == 'am'){$merm1 .= '<option selected="selected" value="am">am</option>';} else{$merm1 .= '<option value="am">am</option>'; }
if($period == 'pm'){$merm1 .= '<option selected="selected" value="pm">pm</option>';} else{$merm1 .= '<option value="pm">pm</option>'; }
$merm1 .= '</select>';
//$merm2 is used for upper case: AM / PM
$merm2 =  '<select id="date_start_meridiem" name="date_start_meridiem" class="datetimecombo_time" size="1">';
    if($period == 'AM'){$merm2 .= '<option selected="selected" value="AM">AM</option>';} else{$merm2 .= '<option value="AM">AM</option>'; }
    if($period == 'PM'){$merm2 .= '<option selected="selected" value="PM">PM</option>';} else{$merm2 .= '<option value="PM">PM</option>'; }
$merm2 .= '</select>';

//$hours1 is used when sugar's time/date settings are set to 24 hours
$hours1 = '<select id="date_start_hours" name="date_start_hours" class="datetimecombo_time"  tabindex="0" size="1">';
//$hours1 .= '<option></option>';

//Generate the options for the hours select box when sugar's time/date settings are set to 24 hours
for($i=0;$i<=23; $i++)
    {
        if($i < 10 ){
            $val = '0'.$i;
        } else{
            $val = $i;
        }
        if($hour == $val){

            $hours1 .= '<option selected="selected" value="'.$val.'">'.$val.'</option>';
        } else{
            $hours1 .= '<option value="'.$val.'">'.$val.'</option>';
        }
    }
$hours1 .= '</select>';


//$hours2 is used when sugar's time/date settings are set to am/pm
$hours2 = '<select id="date_start_hours" name="date_start_hours" class="datetimecombo_time"  tabindex="0" size="1">';
//$hours2 .= '<option></option>';

//Generate the options for the hours select box when sugar's time/date settings are set to am/pm
for($i=1;$i<=12; $i++)
{
    if($i < 10 ){
        $val = '0'.$i;
    } else{
        $val = $i;
    }

    if($hour == $val){

        $hours2 .= '<option selected="selected" value="'.$val.'">'.$val.'</option>';
    } else{
        $hours2 .= '<option value="'.$val.'">'.$val.'</option>';
    }
}
$hours2 .= '</select>';

 //Generate date and time form inputs based on the time format settings in sugar
            switch($time_format)
            {
                case 'H:i':
                    echo $hours1.' : '.$mins;
                    break;
                case 'H.i':
                    echo $hours1.' . '.$mins;
                    break;
                case 'h:ia':
                case 'h:i a':
                    echo $hours2.' : '.$mins.' '.$merm1;
                    break;
                case 'h:iA':
                case 'h:i A':
                    echo $hours2.' : '.$mins.' '.$merm2;
                    break;
                case 'h.iA':
                case 'h.i A':
                    echo $hours2.' . '.$mins.' '.$merm2;
                    break;
                case 'h.ia':
                case 'h.i a':
                    echo $hours2.' . '.$mins.' '.$merm1;
                    break;
            }
   ?>

            <br/>
            <span id="error1" style="color: #ff0000;display: none;"><?php echo $app_strings['LBL_RESCHEDULE_ERROR1']; ?></span>
            <br/>
            <label for="reason"><?php echo $app_strings['LBL_RESCHEDULE_REASON']; ?></label><br />
            <select id='reason' name='reason'>
                <?php echo get_select_options_with_id($app_list_strings["call_reschedule_dom"],''); ?>
            </select>
            <br/>
            <span id="error2" style="color: #ff0000;display: none;"><?php echo $app_strings['LBL_RESCHEDULE_ERROR2']; ?></span>
        </form>
    </div>
</div>

<script id="script" type="text/javascript">

    YAHOO.util.Event.onDOMReady(function()
    {
        var now = new Date();
        Calendar.setup ({

            inputField : "date",
            ifFormat : cal_date_format,
            daFormat : "%m/%d/%Y %I:%M%P",
            button : "date_start_trigger",
            singleClick : true,
            step : 1,
            weekNumbers: false,
            startWeekday: 0


        });

    });


</script>

<script id="script2" type="text/javascript" src="jsscource/src_files/include/javascript/sugar_3.js " > </script>
