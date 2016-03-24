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



if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

function progress_bar_flush($flush=true )
{
    if($flush) {
        if(ob_get_level()) {
            @ob_flush();
        } else {
            @flush();
        }
    }
}

function display_flow_bar($name, $delay, $size=200, $flush=true)
{
	$chunk = $size/5;
	echo "<div id='{$name}_flow_bar'><table  class='list view' cellpading=0 cellspacing=0><tr><td id='{$name}_flow_bar0' width='{$chunk}px' bgcolor='#cccccc' align='center'>&nbsp;</td><td id='{$name}_flow_bar1' width='{$chunk}px' bgcolor='#ffffff' align='center'>&nbsp;</td><td id='{$name}_flow_bar2' width='{$chunk}px' bgcolor='#ffffff' align='center'>&nbsp;</td><td id='{$name}_flow_bar3' width='{$chunk}px' bgcolor='#ffffff' align='center'>&nbsp;</td><td id='{$name}_flow_bar4' width='{$chunk}px' bgcolor='#ffffff' align='center'>&nbsp;</td></tr></table></div><br>";

	echo str_repeat(' ',256);

    progress_bar_flush($flush);

	start_flow_bar($name, $delay, $flush);
}

function start_flow_bar($name, $delay, $flush=true)
{
	$delay *= 1000;
	$timer_id = $name . '_id';
	echo "<script>
		function update_flow_bar(name, count){
			var last = (count - 1) % 5;
			var cur = count % 5;
			var next = cur + 1;
			eval(\"document.getElementById('\" + name+\"_flow_bar\" + last+\"').style.backgroundColor='#ffffff';\");
			eval(\"document.getElementById('\" + name+\"_flow_bar\" + cur+\"').style.backgroundColor='#cccccc';\");
			$timer_id = setTimeout(\"update_flow_bar('$name', \" + next + \")\", $delay);
		}
		 var $timer_id = setTimeout(\"update_flow_bar('$name', 1)\", $delay);

	</script>
";
	echo str_repeat(' ',256);

    progress_bar_flush($flush);
}

function destroy_flow_bar($name, $flush=true)
{
	$timer_id = $name . '_id';
	echo "<script>clearTimeout($timer_id);document.getElementById('{$name}_flow_bar').innerHTML = '';</script>";
	echo str_repeat(' ',256);

	progress_bar_flush($flush);
}

function display_progress_bar($name,$current, $total, $flush=true)
{
	$percent = $current/$total * 100;
	$remain = 100 - $percent;
	$status = floor($percent);
	//scale to a larger size
	$percent *= 2;
	$remain *= 2;
	if($remain == 0){
		$remain = 1;
	}
	if($percent == 0){
		$percent = 1;
	}
	echo "<div id='{$name}_progress_bar' style='width: 50%;'><table class='list view' cellpading=0 cellspacing=0><tr><td id='{$name}_complete_bar' width='{$percent}px' bgcolor='#cccccc' align='center'>$status% </td><td id='{$name}_remain_bar' width={$remain}px' bgcolor='#ffffff'>&nbsp;</td></tr></table></div><br>";
	if($status == 0){
		echo "<script>document.getElementById('{$name}_complete_bar').style.backgroundColor='#ffffff';</script>";
	}
	echo str_repeat(' ',256);

	progress_bar_flush($flush);
}

function update_progress_bar($name,$current, $total, $flush=true)
{
	$percent = $current/$total * 100;
	$remain = 100 - $percent;
	$status = floor($percent);
	//scale to a larger size
	$percent *= 2;
	$remain *= 2;
	if($remain == 0){
		$remain = 1;
	}
	if($status == 100){
		echo "<script>document.getElementById('{$name}_remain_bar').style.backgroundColor='#cccccc';</script>";
	}
	if($status == 0){
		echo "<script>document.getElementById('{$name}_remain_bar').style.backgroundColor='#ffffff';</script>";
		echo "<script>document.getElementById('{$name}_complete_bar').style.backgroundColor='#ffffff';</script>";
	}
	if($status > 0){
		echo "<script>document.getElementById('{$name}_complete_bar').style.backgroundColor='#cccccc';</script>";
	}


	if($percent == 0){
		$percent = 1;
	}

	echo "<script>
		document.getElementById('{$name}_complete_bar').width='{$percent}px';
		document.getElementById('{$name}_complete_bar').innerHTML = '$status%';
		document.getElementById('{$name}_remain_bar').width='{$remain}px';
		</script>";
	progress_bar_flush($flush);
}
