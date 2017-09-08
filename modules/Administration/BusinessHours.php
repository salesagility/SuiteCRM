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

global $current_user, $sugar_config;
global $mod_strings;
global $app_list_strings;
global $app_strings;
global $theme;

if (!is_admin($current_user)) {
    sugar_die("Unauthorized access to administration.");
}

require_once('modules/Configurator/Configurator.php');

echo getClassicModuleTitle(
    "Administration",
    array(
        "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
        $mod_strings['LBL_BUSINESS_HOURS_DESC'],
    ),
    false
);

$sugar_smarty	= new Sugar_Smarty();
$errors			= array();
$days = array($mod_strings['LBL_MONDAY'],$mod_strings['LBL_TUESDAY'],$mod_strings['LBL_WEDNESDAY'],$mod_strings['LBL_THURSDAY'],$mod_strings['LBL_FRIDAY'],$mod_strings['LBL_SATURDAY'],$mod_strings['LBL_SUNDAY']);
$businessHours = BeanFactory::getBean("AOBH_BusinessHours");

if(isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
    foreach($days as $day){
        $bh = $businessHours->getOrCreate($day);
        $bh->day = $day;
        $bh->open = array_key_exists("open_".$day,$_REQUEST) ? $_REQUEST["open_".$day] : false;
        $bh->opening_hours = $_REQUEST["opening_time_".$day];
        $bh->closing_hours = $_REQUEST["closing_time_".$day];
        $bh->save();
    }
    SugarApplication::redirect('index.php?module=Administration&action=index');
}

$dayDropdowns = array();
foreach($days as $day){
    $drops = array();
    $bh = $businessHours->getBusinessHoursForDay($day);
    if($bh){
        $bh = $bh[0];
        $drops['open'] = $bh->open;
    } else{
        $drops['open'] = $day != $mod_strings['LBL_SATURDAY'] && $day != $mod_strings['LBL_SUNDAY'];
    }
    $hours = get_select_options_with_id($app_list_strings['business_hours_list'], ($bh ? $bh->opening_hours : 9));
    $drops['opening'] = $hours;
    $hours = get_select_options_with_id($app_list_strings['business_hours_list'], ($bh ? $bh->closing_hours : 17));
    $drops['closing'] = $hours;

    $dayDropdowns[$day] = $drops;
}
$sugar_smarty->assign('DAY_DROPDOWNS', $dayDropdowns);


$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('APP_LIST', $app_list_strings);
$sugar_smarty->assign('LANGUAGES', get_languages());
$sugar_smarty->assign("JAVASCRIPT",get_set_focus_js());
$sugar_smarty->assign('error', $errors);

$buttons =  <<<EOQ
    <input title="{$app_strings['LBL_SAVE_BUTTON_TITLE']}"
                       accessKey="{$app_strings['LBL_SAVE_BUTTON_KEY']}"
                       class="button primary"
                       type="submit"
                       name="save"
                       onclick="return check_form('ConfigureSettings');"
                       value="  {$app_strings['LBL_SAVE_BUTTON_LABEL']}  " >
                &nbsp;<input title="{$mod_strings['LBL_CANCEL_BUTTON_TITLE']}"  onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="  {$app_strings['LBL_CANCEL_BUTTON_LABEL']}  " >
EOQ;

$sugar_smarty->assign("BUTTONS",$buttons);

$sugar_smarty->display('modules/Administration/BusinessHours.tpl');

$javascript = new javascript();
$javascript->setFormName('ConfigureSettings');
echo $javascript->getScript();

echo <<<EOF
<script type="text/javascript">
$(document).ready(function(){
    $(".open_check").change(function(){
        var thisElem = $(this);

        var day = thisElem.data("day");
        if(thisElem.attr("checked")){
            $("#"+day+"_times").show();
        }else{
            $("#"+day+"_times").hide();
        }
    });
    $(".open_check").change();
});
</script>
EOF;


?>

