<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


global $current_user, $sugar_config;
global $mod_strings;
global $app_list_strings;
global $app_strings;
global $theme;

if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

require_once('modules/Configurator/Configurator.php');


echo getClassicModuleTitle(
    "Administration",
    array(
        "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
        $mod_strings['LBL_COLOUR_SETTINGS'],
    ),
    false
);

$cfg			= new Configurator();
$sugar_smarty	= new Sugar_Smarty();
$errors			= array();

if(isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {

    foreach ($_POST as $key => $value) {
        if (strcmp("$value", 'true') == 0) {
            $value = true;
        }
        if (strcmp("$value", 'false') == 0) {
            $value = false;
        }
        $_POST[$key] = $value;
    }

    $cfg->saveConfig();

    SugarApplication::redirect('index.php?module=Administration');
    exit();
}

if(!isset($sugar_config['colourselector']['menu'])) $sugar_config['colourselector']['menu'] = '#121212';
if(!isset($sugar_config['colourselector']['menufrom'])) $sugar_config['colourselector']['menufrom'] = '#121212';
if(!isset($sugar_config['colourselector']['menuto'])) $sugar_config['colourselector']['menuto'] = '#333333';
if(!isset($sugar_config['colourselector']['menufont'])) $sugar_config['colourselector']['menufont'] = '#cccccc';
if(!isset($sugar_config['colourselector']['menubrd'])) $sugar_config['colourselector']['menubrd'] = '#f10202';
if(!isset($sugar_config['colourselector']['pageheader'])) $sugar_config['colourselector']['pageheader'] = '#f10202';
if(!isset($sugar_config['colourselector']['pagelink'])) $sugar_config['colourselector']['pagelink'] = '#f10202';
if(!isset($sugar_config['colourselector']['dashlet'])) $sugar_config['colourselector']['dashlet'] = '#777777';
if(!isset($sugar_config['colourselector']['button1'])) $sugar_config['colourselector']['button1'] = '#ffffff';
if(!isset($sugar_config['colourselector']['button2'])) $sugar_config['colourselector']['button2'] = '#f3f3f3';
if(!isset($sugar_config['colourselector']['button3'])) $sugar_config['colourselector']['button3'] = '#ededed';
if(!isset($sugar_config['colourselector']['button4'])) $sugar_config['colourselector']['button4'] = '#ffffff';
if(!isset($sugar_config['colourselector']['buttonhover'])) $sugar_config['colourselector']['buttonhover'] = '#f10202';
if(!isset($sugar_config['colourselector']['modlinkvisited'])) $sugar_config['colourselector']['modlinkvisited'] = '#cccccc';
if(!isset($sugar_config['colourselector']['modlisthover'])) $sugar_config['colourselector']['modlisthover'] = '#565656';
if(!isset($sugar_config['colourselector']['modlinkhover'])) $sugar_config['colourselector']['modlinkhover'] = '#ffffff';
if(!isset($sugar_config['colourselector']['cssmenu'])) $sugar_config['colourselector']['cssmenu'] = '#333333';
if(!isset($sugar_config['colourselector']['cssmenulink'])) $sugar_config['colourselector']['cssmenulink'] = '#cccccc';

$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('APP_LIST', $app_list_strings);
$sugar_smarty->assign('LANGUAGES', get_languages());
$sugar_smarty->assign("JAVASCRIPT",get_set_focus_js());
$sugar_smarty->assign('config', $sugar_config);
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

$sugar_smarty->display('custom/modules/Administration/colourAdmin.tpl');

$javascript = new javascript();
$javascript->setFormName('ConfigureSettings');
echo $javascript->getScript();
?>
<!--<script language="Javascript" type="text/javascript">
    addToValidate('ConfigureSettings','renewal_reminder_period','int',false,"Days must be a number");
    addToValidate('ConfigureSettings','initial_invoice_number','int',false,"Initial invoice number must be a number");
</script>-->

