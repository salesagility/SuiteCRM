<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('XTemplate/xtpl.php');
require_once('modules/SecurityGroups/SecurityGroupUserRelationship.php');
require_once('modules/SecurityGroups/Forms.php');
require_once('include/utils.php');

global $app_strings;
global $app_list_strings;
global $mod_strings;
global $sugar_version, $sugar_config;

$focus = new SecurityGroupUserRelationship();

if (isset($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);
}

if (isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
    $focus->id = "";
}

// Prepopulate either side of the relationship if passed in.
safe_map('user_name', $focus);
safe_map('user_id', $focus);
safe_map('securitygroup_name', $focus);
safe_map('securitygroup_id', $focus);
safe_map('noninheritable', $focus);
safe_map('primary_group', $focus);


$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$GLOBALS['log']->info("SecurityGroup User relationship");

$json = getJSONobj();
require_once('include/QuickSearchDefaults.php');
$qsd = new QuickSearchDefaults();
$sqs_objects = array('user_name' => $qsd->getQSParent());
$sqs_objects['user_name']['populate_list'] = array('user_name', 'user_id');
$quicksearch_js = $qsd->getQSScripts();
$quicksearch_js .= '<script type="text/javascript" language="javascript">sqs_objects = ' . $json->encode($sqs_objects) . '</script>';
echo $quicksearch_js;

$xtpl=new XTemplate('modules/SecurityGroups/SecurityGroupUserRelationshipEdit.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

$xtpl->assign("RETURN_URL", "&return_module=$currentModule&return_action=DetailView&return_id=$focus->id");
$xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
$xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
$xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
$xtpl->assign("THEME", $theme);
$xtpl->assign("IMAGE_PATH", $image_path);$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
$xtpl->assign("SECURITYGROUP", $securityGroup = array("NAME" => $focus->securitygroup_name, "ID" => $focus->securitygroup_id));
$xtpl->assign("USER", $user = array("NAME" => $focus->user_name, "ID" => $focus->user_id));

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_SECURITYGROUP_USER_FORM_TITLE'].": ".$securityGroup['NAME'] . " - ". $user['NAME'], true);
echo "\n</p>\n";

// noninheritable
$noninheritable = '';
if (isset($focus->noninheritable) && $focus->noninheritable == true) {
    $noninheritable = 'CHECKED';
}
$xtpl->assign('noninheritable', $noninheritable);

// primary_group
$primary_group = '';
if (isset($focus->primary_group) && $focus->primary_group == true) {
    $primary_group = 'CHECKED';
}
$xtpl->assign('primary_group', $primary_group);

$xtpl->parse("main");

$xtpl->out("main");

require_once('include/javascript/javascript.php');
$javascript = new javascript();
$javascript->setFormName('EditView');
$javascript->setSugarBean($focus);
$javascript->addToValidateBinaryDependency('user_name', 'alpha', $app_strings['ERR_SQS_NO_MATCH_FIELD'] . $mod_strings['LBL_USER_NAME'], 'false', '', 'user_id');
echo $javascript->getScript();
