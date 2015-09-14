<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


if( !isset( $install_script ) || !$install_script ){
    die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}

class NonDBLocalization extends Localization {

    public function __construct() {
        global $sugar_config;
        $this->localeNameFormatDefault = empty($sugar_config['locale_name_format_default']) ? 's f l' : $sugar_config['default_name_format'];
    }

    /**
     * Creates dropdown items that have localized example names while filtering out invalid formats
     *
     * @override
     * @param array un-prettied dropdown list
     * @return array array of dropdown options
     */
    public function getUsableLocaleNameOptions($options) {
        global $mod_strings;
        $examples = array('s' => $mod_strings['LBL_LOCALE_NAME_FIRST'],
            'f' => $mod_strings['LBL_LOCALE_NAME_LAST'],
            'l' => $mod_strings['LBL_LOCALE_NAME_SALUTATION']);
        $newOpts = array();
        foreach ($options as $key => $val) {
            if ($this->isAllowedNameFormat($key) && $this->isAllowedNameFormat($val)) {
                $newVal = '';
                $pieces = str_split($val);
                foreach ($pieces as $piece) {
                    if (isset($examples[$piece])) {
                        $newVal .= $examples[$piece];
                    } else {
                        $newVal .= $piece;
                    }
                }
                $newOpts[$key] = $newVal;
            }
        }
        return $newOpts;
    }

}

class InstallLayout
{

    private $data = array();

    public function __construct($data) {
        $this->data = $data;
    }

    public static function getSelect($name, $options, $default) {
        $out = "<select name=\"$name\">";
        foreach($options as $key => $value) {
            $selected = '';
            if($key==$default) $selected = ' selected="selected"';
            $out .= "<option label=\"$value\" value=\"$key\"$selected>$value</option>";
        }
        $out .= "</select>";
        return $out;
    }

    private function getHeaderStyles() {
        $out = <<<EOQ
       <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
       <link rel="stylesheet" href="install/install.css" type="text/css">
       <link rel="stylesheet" href="themes/Suite7/css/fontello.css">
       <link rel="stylesheet" href="themes/Suite7/css/animation.css"><!--[if IE 7]><link rel="stylesheet" href="css/fontello-ie7.css"><![endif]-->
       <link rel='stylesheet' type='text/css' href='include/javascript/yui/build/container/assets/container.css' />
EOQ;
        return $out;
    }

    private function getHeaderScripts($sugar_version, $js_custom_version) {
        $out = <<<EOQ
            <script src="include/javascript/jquery/jquery-min.js"></script>
            <script src="cache/include/javascript/sugar_grp1_yui.js?s={$sugar_version}&c={$js_custom_version}"></script>
EOQ;
        return $out;
    }

    /**
     * @param $title page title
     * @param $styles linked css files (string)
     * @param $scripts linked javascript files (string)
     * @return string Install page layout header
     */
    private function getHeader($mod_strings, $styles, $scripts)
    {
        $out = <<<EOQ
    <head>
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
       <meta http-equiv="Content-Style-Type" content="text/css">
       <title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_SYSOPTS_DB_TITLE']}</title>
       $styles
       $scripts
    </head>
EOQ;
        return $out;
    }


    /**
     * @param $name form tag name
     * @param $id form tag id
     * @param $errs form errors
     * @param $title form header line
     * @param $items form items (string)
     * @param $controlls form controll buttons (string)
     * @return string
     */
    private function getForm($name, $id, $errs, $items, $controlls, $scripts, $next_step)
    {
        $out = <<<EOQ
            <iframe id="upload_target" name="upload_target" src="install.php?sugar_body_only=1&uploadLogoFrame=1" style="width:0;height:0;border:0px solid #fff;"></iframe>
            <form action="install.php" method="post" name="$name" id="$id" enctype="multipart/form-data">
                <input type="hidden" name="current_step" value="{$next_step}">
                <div id="install_content">
                    <div id="installoptions">
                        {$errs}
                        $items
                    </div>
                </div>
                <hr>
                <div id="installcontrols">
                    $controlls
                </div>
                <script type="text/javascript">
                    $scripts;
                </script>
            </form>
EOQ;

        return $out;
    }


    /**
     * @param $header install page head
     * @param $form install page form step
     * @return string install page
     */
    private function getOutput($header, $form, $sugar_md, $mod_strings)
    {
        // TODO-g: modify step sections in headers
        $langHeader = get_language_header();
        $out = <<<EOQ
    <!DOCTYPE HTML>
    <html {$langHeader}>
    $header
    <body onload="document.getElementById('button_next2').focus();">
        <!--SuiteCRM installer-->
        <div id="install_container">
            <div id="install_box">
                <div id='licenseDiv'></div>
                <header id="install_header">
                    <div class="install_img">
                        <a href="https://suitecrm.com" target="_blank">
                            <img src="{$sugar_md}" alt="SuiteCRM">
                        </a>
                    </div>
                    <div id="steps">
                        <p>{$mod_strings['LBL_STEP4']}</p>
                        <i class="icon-progress-0" id="complete"></i>
                        <i class="icon-progress-1" id="complete"></i>
                        <i class="icon-progress-2" id="complete"></i>
                        <i class="icon-progress-3"></i>
                        <i class="icon-progress-4"></i>
                        <i class="icon-progress-5"></i>
                        <i class="icon-progress-6"></i>
                        <i class="icon-progress-7"></i>
                    </div>
                </header>
                $form
            </div>
        </div>
    </body>
    </html>
EOQ;
        return $out;
    }

    private function getFormItems($mod_strings, $app_list_strings, $sugarConfigDefaults, $drivers, $checked, $db, $errors) {

        //demo data select
        $demoDD = "<select name='demoData' id='demoData' class='select'><option value='no' >".$mod_strings['LBL_NO']."</option><option value='yes'>".$mod_strings['LBL_YES']."</option>";
        $demoDD .= "</select>";


        $out3 =<<<EOQ3
            <hr>
            <div class="install_block">
                <h2>{$mod_strings['LBL_DBCONF_DEMO_DATA_TITLE']}</h2>
                <label>{$mod_strings['LBL_DBCONF_DEMO_DATA']}</label>
                    {$demoDD}
            </div>
            <br>
            <br>
EOQ3;

        // database selection
        $out = $out3 . "<h2>{$mod_strings['LBL_SYSOPTS_DB']}</h2>";
        foreach($drivers as $type => $driver) {
            $oci = ($type == "oci8")?"":'none'; // hack for special oracle message
            $out.=<<<EOQ
                <input type="radio" class="checkbox" name="setup_db_type" id="setup_db_type" value="$type" {$checked[$type]} onclick="onDBTypeClick(this);//document.getElementById('ociMsg').style.display='$oci'"/>{$mod_strings[$driver->label]}
EOQ;
        }
        $out.=<<<EOQ
            <div name="ociMsg" id="ociMsg" style="display:none"></div>
EOQ;

        // TODO-g: smtp
        // TODO-g: use default values from the system defaults or use user settings previously
        // TODO-g: test it for all types
        $MAIL_SSL_OPTIONS_GMAIL = get_select_options_with_id($app_list_strings['email_settings_for_ssl'], '2');
        //$MAIL_SSL_OPTIONS_YAHOO = get_select_options_with_id($app_list_strings['email_settings_for_ssl'], '1');
        $MAIL_SSL_OPTIONS_EXCHG = get_select_options_with_id($app_list_strings['email_settings_for_ssl'], 'none');
        $MAIL_SSL_OPTIONS_OTHER = get_select_options_with_id($app_list_strings['email_settings_for_ssl'], 'none');
        $out .= <<<EOQ
            <!-- smtp settings -->
            <h2>{$mod_strings['LBL_MAIL_SMTP_SETTINGS']}</h2>

            <p>{$mod_strings['LBL_WIZARD_SMTP_DESC']}</p>

            <!-- smtp types toggler buttons -->

            <p>{$mod_strings['LBL_CHOOSE_EMAIL_PROVIDER']}</p>
            <div>
                <input type="button" class="smtp_tab_toggler" for="smtp_tab_gmail" value="{$mod_strings['LBL_SMTPTYPE_GMAIL']}" />
                <input type="button" class="smtp_tab_toggler" for="smtp_tab_yahoo" value="{$mod_strings['LBL_SMTPTYPE_YAHOO']}" />
                <input type="button" class="smtp_tab_toggler" for="smtp_tab_exchange" value="{$mod_strings['LBL_SMTPTYPE_EXCHANGE']}" />
                <input type="button" class="smtp_tab_toggler selected" for="smtp_tab_other" value="{$mod_strings['LBL_SMTPTYPE_OTHER']}" />
                <input type="hidden" name="smtp_tab_selected" value="smtp_tab_other">
                <!-- TODO-g: save last selected tab and set as default when form reload -->
            </div>

            <!-- smtp / gmail tab -->

            <div class="form_section smtp_tab" id="smtp_tab_gmail">

                <div class="formrow">
                    <label>{$mod_strings['LBL_MAIL_SMTPSERVER']}</label>
                    <input type="text" id="mail_smtpserver" name="mail_smtpserver" size="25" maxlength="64" value="smtp.gmail.com">
                </div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_MAIL_SMTPPORT']}</label>
                    <input type="text" id="mail_smtpport" name="mail_smtpport" size="5" maxlength="5" value="587">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_MAIL_SMTPAUTH_REQ']}</label>
                    <input type="hidden" name="mail_smtpauth_req" value="0">
                    <input type="checkbox" name="mail_smtpauth_req" value="1" checked="checked">
                </div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_EMAIL_SMTP_SSL_OR_TLS']}</label>
                    <select id="mail_smtpssl" name="mail_smtpssl">
                        {$MAIL_SSL_OPTIONS_GMAIL}
                    </select>
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_GMAIL_SMTPUSER']}</label>
                    <input type="text" name="mail_smtpuser" size="25" maxlength="64">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_GMAIL_SMTPPASS']}</label>
                    <input type="password" id="mail_smtppass" name="mail_smtppass" size="25" maxlength="64" value="mysmtppassword" tabindex="1">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_ALLOW_DEFAULT_SELECTION']} <i>i<div class="tooltip">{$mod_strings['LBL_ALLOW_DEFAULT_SELECTION_HELP']}</div></i></label>
                    <input type="hidden" name="mail_smtpauth_req" value="0">
                    <input id="notify_allow_default_outbound" name="notify_allow_default_outbound" value="2" tabindex="1" class="checkbox" type="checkbox">
                </div>

                <div class="clear"></div>
            </div>

            <!-- smtp / yahoo! mail tab -->

            <div class="form_section smtp_tab" id="smtp_tab_yahoo">

                <input type="hidden" id="mail_smtpserver" name="mail_smtpserver" size="25" maxlength="64" value="smtp.mail.yahoo.com">
                <input type="text" id="mail_smtpport" name="mail_smtpport" size="5" maxlength="5" value="465">
                <input type="hidden" name="mail_smtpauth_req" value="1">
                <input type="hidden" name="mail_smtpssl" value="1">

                <div class="formrow">
                    <label>{$mod_strings['LBL_YAHOOMAIL_SMTPUSER']}</label>
                    <input type="text" name="mail_smtpuser" size="25" maxlength="64">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_YAHOOMAIL_SMTPPASS']}</label>
                    <input type="password" id="mail_smtppass" name="mail_smtppass" size="25" maxlength="64" value="mysmtppassword" tabindex="1">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_ALLOW_DEFAULT_SELECTION']} <i>i<div class="tooltip">{$mod_strings['LBL_ALLOW_DEFAULT_SELECTION_HELP']}</div></i></label>
                    <input type="hidden" name="mail_smtpauth_req" value="0">
                    <input id="notify_allow_default_outbound" name="notify_allow_default_outbound" value="2" tabindex="1" class="checkbox" type="checkbox">
                </div>

                <div class="clear"></div>
            </div>

            <!-- smtp / ms-exchange tab -->

            <div class="form_section smtp_tab" id="smtp_tab_exchange">

                <div class="formrow">
                    <label>{$mod_strings['LBL_EXCHANGE_SMTPSERVER']}</label>
                    <input type="text" id="mail_smtpserver" name="mail_smtpserver" size="25" maxlength="64" value="">
                </div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_EXCHANGE_SMTPPORT']}</label>
                    <input type="text" id="mail_smtpport" name="mail_smtpport" size="5" maxlength="5" value="25">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_MAIL_SMTPAUTH_REQ']}</label>
                    <input type="hidden" name="mail_smtpauth_req" value="0">
                    <input type="checkbox" name="mail_smtpauth_req" value="1" checked="checked">
                </div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_EMAIL_SMTP_SSL_OR_TLS']}</label>
                    <select id="mail_smtpssl" name="mail_smtpssl" tabindex="501">
                        {$MAIL_SSL_OPTIONS_EXCHG}
                    </select>
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_EXCHANGE_SMTPUSER']}</label>
                    <input type="text" name="mail_smtpuser" size="25" maxlength="64">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_EXCHANGE_SMTPPASS']}</label>
                    <input type="password" id="mail_smtppass" name="mail_smtppass" size="25" maxlength="64" value="mysmtppassword" tabindex="1">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_ALLOW_DEFAULT_SELECTION']} <i>i<div class="tooltip">{$mod_strings['LBL_ALLOW_DEFAULT_SELECTION_HELP']}</div></i></label>
                    <input type="hidden" name="mail_smtpauth_req" value="0">
                    <input id="notify_allow_default_outbound" name="notify_allow_default_outbound" value="2" tabindex="1" class="checkbox" type="checkbox">
                </div>

                <div class="clear"></div>
            </div>

            <!-- smtp / other tab-->

            <div class="form_section smtp_tab" id="smtp_tab_other">

                <div class="formrow">
                    <label>{$mod_strings['LBL_MAIL_SMTPSERVER']}</label>
                    <input type="text" id="mail_smtpserver" name="mail_smtpserver" size="25" maxlength="64" value="">
                </div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_MAIL_SMTPPORT']}</label>
                    <input type="text" id="mail_smtpport" name="mail_smtpport" size="5" maxlength="5" value="25">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_MAIL_SMTPAUTH_REQ']}</label>
                    <input type="hidden" name="mail_smtpauth_req" value="0">
                    <input type="checkbox" name="mail_smtpauth_req" value="1" checked="checked">
                </div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_EMAIL_SMTP_SSL_OR_TLS']}</label>
                    <select id="mail_smtpssl" name="mail_smtpssl" tabindex="501">
                        {$MAIL_SSL_OPTIONS_OTHER}
                    </select>
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_MAIL_SMTPUSER']}</label>
                    <input type="text" name="mail_smtpuser" size="25" maxlength="64">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_MAIL_SMTPPASS']}</label>
                    <input type="password" id="mail_smtppass" name="mail_smtppass" size="25" maxlength="64" value="mysmtppassword" tabindex="1">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_ALLOW_DEFAULT_SELECTION']} <i>i<div class="tooltip">{$mod_strings['LBL_ALLOW_DEFAULT_SELECTION_HELP']}</div></i></label>
                    <input type="hidden" name="mail_smtpauth_req" value="0">
                    <input id="notify_allow_default_outbound" name="notify_allow_default_outbound" value="2" tabindex="1" class="checkbox" type="checkbox">
                </div>

                <div class="clear"></div>
            </div>

            <!-- smtp default values & tabs toggler js & tooltip help -->

            <script>
                $(function(){

                    $('.smtp_tab_toggler').click(function(){
                        $('.smtp_tab_toggler.selected').removeClass('selected');
                        $(this).addClass('selected');
                        $('.smtp_tab').hide();
                        $('#'+$(this).attr('for')).show();
                        $('input[name="smtp_tab_selected"]').val($(this).attr('for'));
                    });
                    $('.smtp_tab_toggler.selected').click();

                    $('select[name="mail_smtpssl"] option').each(function(){
                        if(!$(this).html()) {
                            $(this).html('-none-');
                        }
                    });

                });
            </script>
EOQ;


        // db setup (dbConfig_a.php)
        $out2 =<<<EOQ2
            <input type='hidden' name='setup_db_drop_tables' id='setup_db_drop_tables' value=''>
            <h2>{$mod_strings['LBL_DBCONF_TITLE']}</h2>
            <div class="required">{$mod_strings['LBL_REQUIRED']}</div>
            <hr>
            <h3>{$mod_strings['LBL_DBCONF_TITLE_NAME']}</h3>
EOQ2;

        $config_params = $db->installConfig();
        $form = '';
        foreach($config_params as $group => $gdata) {
            $form.= "<div class='install_block'>";
            $form .= "<label>{$mod_strings[$group]}</label><br>\n";
            foreach($gdata as $name => $value) {

                if(!empty($value)) {
                    if(!empty($value['required'])) {
                        $form .= "<span class=\"required\">*</span>";
                    }
                    else {
                    }
                    if(!empty($_SESSION[$name])) {
                        $sessval = $_SESSION[$name];
                    } else {
                        $sessval = '';
                    }
                    if(!empty($value["type"])) {
                        $type = $value["type"];
                    } else {
                        $type = '';
                    }

                    $form .= <<<FORM

FORM;
                    //if the type is password, set a hidden field to capture the value.  This is so that we can properly encode special characters, which is a limitation with password fields
                    if($type=='password'){
                        $form .= "<input type='$type' name='{$name}_entry' id='{$name}_entry' value='".urldecode($sessval)."'><input type='hidden' name='$name' id='$name' value='".urldecode($sessval)."'>";
                    }else{
                        $form .= "<input type='$type' name='$name' id='$name' value='$sessval'>";
                    }



                    $form .= <<<FORM
FORM;

                } else {
                    $form .= "<input name=\"$name\" id=\"$name\" value=\"\" type=\"hidden\">\n";
                }
            }
            $form .= "</div>";
        }

        $out2 .= $form;



        // ---------- user data set (dbConfig_a.php)


//if we are installing in custom mode, include the following html
        if($db->supports("create_user")) {
// create / set db user dropdown
            $auto_select = '';
            $provide_select = '';
            $create_select = '';
            $same_select = '';
            if (isset($_SESSION['dbUSRData'])) {
//    if($_SESSION['dbUSRData']=='auto')    {$auto_select ='selected';}
                if ($_SESSION['dbUSRData'] == 'provide') {
                    $provide_select = 'selected';
                }
                if (isset($_SESSION['install_type']) && !empty($_SESSION['install_type']) && strtolower($_SESSION['install_type']) == 'custom') {
                    if ($_SESSION['dbUSRData'] == 'create') {
                        $create_select = 'selected';
                    }
                }
                if ($_SESSION['dbUSRData'] == 'same') {
                    $same_select = 'selected';
                }
            } else {
                $same_select = 'selected';
            }
            $dbUSRDD = "<select name='dbUSRData' id='dbUSRData' onchange='toggleDBUser();'>";
            $dbUSRDD .= "<option value='provide' $provide_select>" . $mod_strings['LBL_DBCONFIG_PROVIDE_DD'] . "</option>";
            $dbUSRDD .= "<option value='create' $create_select>" . $mod_strings['LBL_DBCONFIG_CREATE_DD'] . "</option>";
            $dbUSRDD .= "<option value='same' $same_select>" . $mod_strings['LBL_DBCONFIG_SAME_DD'] . "</option>";
            $dbUSRDD .= "</select><br>&nbsp;";


            $setup_db_sugarsales_password = urldecode($_SESSION['setup_db_sugarsales_password']);
            $setup_db_sugarsales_user = urldecode($_SESSION['setup_db_sugarsales_user']);
            $setup_db_sugarsales_password_retype = urldecode($_SESSION['setup_db_sugarsales_password_retype']);


            $out2 .= <<<EOQ2
<br>
    <hr>
<br>
{$mod_strings['LBL_DBCONFIG_SECURITY']}
<div class='install_block'><label><b>{$mod_strings['LBL_DBCONF_SUGAR_DB_USER']}</b></label>$dbUSRDD
    <span id='connection_user_div' style="display:none">
        <span class="required">*</span>
            <label><b>{$mod_strings['LBL_DBCONF_SUGAR_DB_USER']}</b></label>
            <input type="text" name="setup_db_sugarsales_user" maxlength="16" value="{$_SESSION['setup_db_sugarsales_user']}" />
            <label><b>{$mod_strings['LBL_DBCONF_DB_PASSWORD']}</b></label>
            <input type="password" name="setup_db_sugarsales_password_entry" value="{$setup_db_sugarsales_password}" /><input type="hidden" name="setup_db_sugarsales_password" value="{$setup_db_sugarsales_password}" />
            <input type="hidden" name="setup_db_sugarsales_password" value="{$_SESSION['setup_db_sugarsales_password']}" />
            <label><b>{$mod_strings['LBL_DBCONF_DB_PASSWORD2']}</b></label>
            <input type="password" name="setup_db_sugarsales_password_retype_entry" value="{$setup_db_sugarsales_password_retype}"  /><input type="hidden" name="setup_db_sugarsales_password_retype" value="{$setup_db_sugarsales_password_retype}" />
    </span>
</div>

EOQ2;
        }
        $out.=$out2;



        // ------ siteConfig_a.php
        $out .=<<<EOQ
                    <h2>{$mod_strings['LBL_SITECFG_TITLE']}</h2>
                    <p>{$errors}</p>
                    <div class="required">{$mod_strings['LBL_REQUIRED']}</div>
                    <hr>
                    <h3>{$mod_strings['LBL_SITECFG_TITLE2']}</h3>
EOQ;
        //hide this in typical mode
        if(!empty($_SESSION['install_type']) && strtolower($_SESSION['install_type'])=='custom'){
            $out .=<<<EOQ
<div class='install_block'>
    {$mod_strings['LBL_SITECFG_URL_MSG']}
    <span class="required">*</span>
    <label><b>{$mod_strings['LBL_SITECFG_URL']}</b></label>
    <input type="text" name="setup_site_url" id="button_next2" value="{$_SESSION['setup_site_url']}" size="40" />
    <br>{$mod_strings['LBL_SITECFG_SYS_NAME_MSG']}
    <span class="required">*</span>
    <label><b>{$mod_strings['LBL_SYSTEM_NAME']}</b></label>
    <input type="text" name="setup_system_name" value="{$_SESSION['setup_system_name']}" size="40" /><br>
</div>
EOQ;
            $db = getDbConnection();
            if($db->supports("collation")) {
                $collationOptions = $db->getCollationList();
            }
            if(!empty($collationOptions)) {
                if(isset($_SESSION['setup_db_options']['collation'])) {
                    $default = $_SESSION['setup_db_options']['collation'];
                } else {
                    $default = $db->getDefaultCollation();
                }
                $options = get_select_options_with_id(array_combine($collationOptions, $collationOptions), $default);
                $out .=<<<EOQ
     <div class='install_block'>
        <br>{$mod_strings['LBL_SITECFG_COLLATION_MSG']}
        <span class="required">*</span>
        <label><b>{$mod_strings['LBL_COLLATION']}</b></label>
        <select name="setup_db_collation" id="setup_db_collation">$options</select><br>
     </div>
EOQ;
            }
        }

        $out .=<<<EOQ
<div class='install_block'>
    <p>{$mod_strings['LBL_SITECFG_PASSWORD_MSG']}</p>
    <label><b>{$mod_strings['LBL_SITECFG_ADMIN_Name']} <span class="required">*</span></b></label>
    <input type="text" name="setup_site_admin_user_name" value="{$_SESSION['setup_site_admin_user_name']}" size="20" maxlength="60" /><br>
    <label><b>{$mod_strings['LBL_SITECFG_ADMIN_PASS']} <span class="required">*</span></b></label>
    <input type="password" name="setup_site_admin_password" value="{$_SESSION['setup_site_admin_password']}" size="20" /><br>
    <label><b>{$mod_strings['LBL_SITECFG_ADMIN_PASS_2']} <span class="required">*</span></b></label>
    <input type="password" name="setup_site_admin_password_retype" value="{$_SESSION['setup_site_admin_password_retype']}" size="20" />
</div>
EOQ;

        $out .= <<<EOQ
<hr>
EOQ;

        // TODO-g: admin email add to installer!

        // ---------------- Branding

        // TODO-g: page refresh bug on file uploader! fix it!!
        // company logo
        $currentLogoLink = SugarThemeRegistry::current()->getImageURL('company_logo.png');
        // show logo if we have
        $hiddenLogo = '';
        if(!file_exists($currentLogoLink)) {
            $hiddenLogo = 'display:none;';
        }


        // TODO-g: check the tooltip text at the logo image!

        $out .= <<<EOQ

            <!-- Branding  -->

            <h2>{$mod_strings['LBL_WIZARD_SYSTEM_TITLE']}</h2>

            <p>{$mod_strings['LBL_WIZARD_SYSTEM_DESC']}</p>

            <div class="form_section">

                <div class="formrow">
                    <label>{$mod_strings['SYSTEM_NAME_WIZARD']} <i>i<div class="tooltip">{$mod_strings['SYSTEM_NAME_HELP']}</div></i></label>
                    <input type="text" name="setup_system_name" size="25" maxlength="64" value="{$_SESSION['setup_system_name']}">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <!-- file upload -->
                    <label>{$mod_strings['NEW_LOGO']} <i>i<div class="tooltip">{$mod_strings['NEW_LOGO_HELP']}</div></i></label>
                    <input type="file" name="company_logo" id="company_logo">
                </div>

                <div class="clear"></div>
<!--
                <div class="formrow">
                    <label>&nbsp;</label>
                    <input type="button" name="company_logo_upload_btn" value="{$mod_strings['COMPANY_LOGO_UPLOAD_BTN']}">
                </div>
-->

                <div class="clear"></div>

                <div class="formrow" id="current_logo_row">
                    <label>{$mod_strings['CURRENT_LOGO']} <i>i<div class="tooltip">{$mod_strings['CURRENT_LOGO_HELP']}</div></i></label>
                    <img height="17" src="$currentLogoLink" alt="Company Logo" style="max-height: 17px; max-width: 450px; $hiddenLogo" />
                </div>

                <div class="clear"></div>
            </div>

EOQ;


        // TODO-g: System location defaults

        // TODO-g: bugs: when Next button clicked, the page stuck in a circuit (at the checking DB - by install.log)
        // TODO-g: bugs: Date Format, Time Format, 1000s sep, Decimal Symb, Name Format ? , dont save!!! ; SMTP some field not save!



        $defaultDateFormatSelect = self::getSelect('default_date_format', $sugarConfigDefaults['date_formats'], $sugarConfigDefaults['datef']);
        $defaultTimeFormatSelect = self::getSelect('default_time_format', $sugarConfigDefaults['time_formats'], $sugarConfigDefaults['timef']);
        // TODO-g: bug: only one options ary in this select. fix it!
        $defaultLanguageSelect = self::getSelect('default_language', $sugarConfigDefaults['languages'], $sugarConfigDefaults['default_language']);

        // example name formats (its are in the original language file so may this functionality was there in the original sugarcrm installer also)
        $nonDBLocalization = new NonDBLocalization();
        $sugarConfigDefaults['name_formats'] = $nonDBLocalization->getUsableLocaleNameOptions($sugarConfigDefaults['name_formats']);
        $defaultLocalNameFormatSelect = self::getSelect('default_locale_name_format', $sugarConfigDefaults['name_formats'], $sugarConfigDefaults['default_locale_name_format']);

        $out .= <<<EOQ

            <!-- System Local Settings  -->

            <h2>{$mod_strings['LBL_LOCALE_TITLE']}</h2>

            <p>{$mod_strings['LBL_WIZARD_LOCALE_DESC']}</p>

            <div class="form_section">

                <div class="formrow">
                    <label>{$mod_strings['LBL_DATE_FORMAT']}</label>
                    $defaultDateFormatSelect
                </div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_TIME_FORMAT']}</label>
                    $defaultTimeFormatSelect
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_LANGUAGE']}</label>
                    $defaultLanguageSelect
                </div>

                <div class="clear"><hr></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_CURRENCY']}</label>
                    <input type="text" name="default_currency_name" value="{$sugarConfigDefaults['default_currency_name']}">
                </div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_CURRENCY_SYMBOL']}</label>
                    <input type="text" name="default_currency_symbol" size="4" value="{$sugarConfigDefaults['default_currency_symbol']}">
                </div>

                <div class="clear"></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_CURRENCY_ISO4217']}</label>
                    <input type="text" name="default_currency_iso4217" size="4" value="{$sugarConfigDefaults['default_currency_iso4217']}">
                </div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_NUMBER_GROUPING_SEP']}</label>
                    <input type="text" name="default_number_grouping_seperator" size="3" maxlength="1" value="{$sugarConfigDefaults['default_number_grouping_seperator']}">
                </div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_DECIMAL_SEP']}</label>
                    <input type="text" name="default_decimal_seperator" size="3" maxlength="1" value="{$sugarConfigDefaults['default_decimal_seperator']}">
                </div>

                <div class="clear"><hr></div>

                <div class="formrow">
                    <label>{$mod_strings['LBL_NAME_FORMAT']}</label>
                    $defaultLocalNameFormatSelect
                </div>

                <div class="clear"></div>
            </div>

EOQ;


        return $out;
    }

    private function getFormControlls($mod_strings, $formId) {
        $out =<<<EOQ
        <div id="checkingDiv" style="display:none">
                    <p><img alt="{$mod_strings['LBL_LICENSE_CHKDB_HEADER']}" src='install/processing.gif'> <br>{$mod_strings['LBL_LICENSE_CHKDB_HEADER']}</p>
           </div>
          <div id='sysCheckMsg' style="display:none">
                    <p>{$mod_strings['LBL_DROP_DB_CONFIRM']}</p>
                    <input id='accept_btn' type='button' class='button' onclick='confirm_drop_tables(true)' value="{$mod_strings['LBL_ACCEPT']}">
                    <input type='button' class='button' onclick='confirm_drop_tables(false)' id="button_cancel_dbConfig" value="{$mod_strings['LBL_CANCEL']}">
          </div>

            <div id="preloaderDiv" style="display:none">
                <p><img alt="Please wait.." src='install/processing.gif'> <br><span id="process_msg">Please wait..</span></p>
            </div>
            <div class="clear"></div>

            <div id="errorMsgs" style="display:none"></div>

            <div class="text-right">
                <input type='hidden' name='setup_db_drop_tables' id='setup_db_drop_tables' value=''>

                <input type="hidden" name="goto" id="goto">
                <input type="hidden" id="hidden_goto" name="goto" value="{$mod_strings['LBL_BACK']}" />

                <input class="button" type="button" value="{$mod_strings['LBL_BACK']}" id="button_back_settings" onclick="document.getElementById('goto').value='{$mod_strings['LBL_BACK']}';document.getElementById('$formId').submit();" />
                <!--
                <input class="button" type="button" value="{$mod_strings['LBL_LANG_BUTTON_COMMIT']}" onclick="document.getElementById('goto').value='{$mod_strings['LBL_NEXT']}';document.getElementById('$formId').submit();" id="button_next2"/>
                -->
                <input class="button" type="button" name="goto" id="button_next2" value="{$mod_strings['LBL_NEXT']}" onClick="onNextClick(this); //callDBCheck();"/>
                <script>

                    var preloaderOn = function(msg) {
                        $('#process_msg').html(msg);
                        $('#preloaderDiv').show();
                    };

                    var preloaderOff = function() {
                        $('#process_msg').html('');
                        $('#preloaderDiv').hide();
                    };

                    var uploadLogoCallback = function(status) {
                        // Upload finished, more details in status. (override this function)
                    };

                    var uploadLogo = function(e, cb) {
                        if(cb) {
                            uploadLogoCallback = cb;
                        }
                        $(e.form).attr('action', 'install.php?sugar_body_only=1&uploadLogo=1&callback=uploadLogoCallback')
                        $(e.form).attr('target', 'upload_target');
                        $(e.form).submit();
                    };

                    var storeConfig = function(e, cb) {
                        var _cb = false;
                        if(cb) {
                            _cb = cb;
                        }
                        $.post('install.php?sugar_body_only=1&storeConfig=1', $(e.form).serialize(), function(resp, err){
                            if(err!=='success') {
                                console.error(err);
                            }
                            else if(resp) {
                                //console.error('configuration store failed');

                                document.getElementById("errorMsgs").innerHTML = resp;
                                document.getElementById("errorMsgs").style.display = '';
                                return false;

                            }
                            else {
                                $('#errorMsgs').html('');
                                $('#errorMsgs').hide();
                                if(_cb) {
                                    _cb();
                                }
                            }
                        });
                    };

                    var removeSMTPSettings = function() {
                        // on form submit prevent remove the unnecessary tabs div with inputs and do not post that!
                        $('.smtp_tab').each(function(i,e){
                            if($(this).attr('id') != $('input[name="smtp_tab_selected"]').val()) {
                                $(this).remove();
                            }
                        });
                    };

                    var dbCheckPassed = function(url, next_step) {
                                document.installForm.goto.value="{$mod_strings['LBL_NEXT']}";
                                document.getElementById('hidden_goto').value="{$mod_strings['LBL_NEXT']}";
                                document.installForm.current_step.value=next_step;
                                removeSMTPSettings();
                                // TODO-g: add correct form validation for all fields (number is number, server name a valid server name etc)
                                document.installForm.submit();
                    };

                    var onNextClick = function(e) {
                        var _e = e;
                        if( document.getElementById("company_logo").files.length == 0 ){
                            storeConfig(_e, function(){
                                callDBCheck(function(url, next_step){
                                    dbCheckPassed(url, next_step);
                                });
                            });
                        }
                        else {
                            preloaderOn('{$mod_strings['UPLOAD_LOGO']}');
                            uploadLogo(e, function(status){
                                preloaderOff();
                                // upload finish
                                $('#errorMsgs').html('');
                                $('#errorMsgs').hide();
                                if(status.errors) {
                                    // show errors..
                                    var errList = '';
                                    $.each(status.errors, function(i,e){
                                        errList+= '<li class="error"><span class="error">' + e + '</span></li>';
                                    });
                                    $('#errorMsgs').html('<p><b>{$mod_strings['LBL_SYSOPTS_ERRS_TITLE']}</b></p><ul>' + errList + '</ul>');
                                    $('#errorMsgs').show();

                                    storeConfig(_e);
                                }
                                else {
                                    // show logo ..
                                    $('#current_logo_row img').attr('src', status.filepath + '?' + Math.random());
                                    var imghtml = $('<div>').append($('#current_logo_row img')).html();
                                    $('#current_logo_row img').remove();
                                    $('#current_logo_row').append(imghtml);
                                    $('#current_logo_row img').show();

                                    storeConfig(_e, function(){
                                        callDBCheck(function(url, next_step){
                                            dbCheckPassed(url, next_step);
                                        });
                                    });
                                }
                            });
                        }
                        return false;
                    };
                </script>
            </div>
EOQ;
        return $out;
    }

    private function getFormScripts($mod_strings, $next_step) {
        $out =<<<EOQ
            var formRefreshSubmit = function(e) {
                document.getElementById('goto').value='resend';
                e.form.submit();
            }

            $('#fts_type').change(function(){
                if($(this).val() == '')
                    hideFTSSettings();
                else
                    showFTSSettings();
            });

            function showFTSSettings()
            {
                $('#fts_port_row').show();
                $('#fts_host_row').show();
            }

            function hideFTSSettings()
            {
                $('#fts_port_row').hide();
                $('#fts_host_row').hide();
            }


            function toggleDBUser(){
                 if(typeof(document.getElementById('dbUSRData')) !='undefined'
                 && document.getElementById('dbUSRData') != null){

                    ouv = document.getElementById('dbUSRData').value;
                    if(ouv == 'provide' || ouv == 'create'){
                        document.getElementById('connection_user_div').style.display = '';
                        //document.getElementById('sugarDBUs<br>er').style.display = 'none';
                    }else{
                        document.getElementById('connection_user_div').style.display = 'none';
                        //document.getElementById('sugarDBUser').style.display = '';
                    }
                }
            }
            toggleDBUser();

            var msgPanel;
            // TODO-g: some how show a message for user when install started.. "Installation process, pease wait..."
            function callDBCheck(cb){
                var _cb = cb;
                        //begin main function that will be called
                        ajaxCall = function(msg_panel){
                            //create success function for callback

                            getPanel = function() {
                            var args = {    width:"300px",
                                            modal:true,
                                            fixedcenter: true,
                                            constraintoviewport: false,
                                            underlay:"shadow",
                                            close:false,
                                            draggable:true,

                                            effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:.5}
                                           } ;
                                    msg_panel = new YAHOO.widget.Panel('p_msg', args);

                                    msg_panel.setHeader("{$mod_strings['LBL_LICENSE_CHKDB_HEADER']}");
                                    msg_panel.setBody(document.getElementById("checkingDiv").innerHTML);
                                    msg_panel.render(document.body);
                                    msgPanel = msg_panel;
                            }


                            passed = function(url){
                                _cb(url, "{$next_step}");
                            }
                            success = function(o) {
                                //condition for just the preexisting database
                                if (o.responseText.indexOf('preexeest')>=0){

                                    //  throw confirmation message
                                    msg_panel.setBody(document.getElementById("sysCheckMsg").innerHTML);
                                    msg_panel.render(document.body);
                                    msgPanel = msg_panel;
                                    document.getElementById('accept_btn').focus();
                                //condition for no errors
                                }else if (o.responseText.indexOf('dbCheckPassed')>=0){
                                    //make navigation
                                    passed("install.php?goto={$mod_strings['LBL_NEXT']}");

                                //condition for other errors
                                }else{
                                    //turn off loading message
                                    msgPanel.hide();
                                    document.getElementById("errorMsgs").innerHTML = o.responseText;
                                    document.getElementById("errorMsgs").style.display = '';
                                    return false;
                                }


                            }//end success


                            //copy the db values over to the hidden field counterparts
                            document.installForm.setup_db_admin_password.value = document.installForm.setup_db_admin_password_entry.value;



                            //set loading message and create url
                            postData = "checkDBSettings=true&to_pdf=1&sugar_body_only=1";
                            postData += "&setup_db_database_name="+document.installForm.setup_db_database_name.value;
                            if(typeof(document.installForm.setup_db_host_instance) != 'undefined'){
                                postData += "&setup_db_host_instance="+document.installForm.setup_db_host_instance.value;
                            }
                            if(typeof(document.installForm.setup_db_port_num) != 'undefined'){
                                postData += "&setup_db_port_num="+document.installForm.setup_db_port_num.value;
                            }
                            postData += "&setup_db_host_name="+document.installForm.setup_db_host_name.value;
                            postData += "&setup_db_admin_user_name="+document.installForm.setup_db_admin_user_name.value;
                            postData += "&setup_db_admin_password="+encodeURIComponent(document.installForm.setup_db_admin_password.value);
                            if(typeof(document.installForm.setup_db_sugarsales_user) != 'undefined'){
                                postData += "&setup_db_sugarsales_user="+document.installForm.setup_db_sugarsales_user.value;
                            }
                            if(typeof(document.installForm.setup_db_sugarsales_password) != 'undefined'){
                            document.installForm.setup_db_sugarsales_password.value = document.installForm.setup_db_sugarsales_password_entry.value;
                                postData += "&setup_db_sugarsales_password="+encodeURIComponent(document.installForm.setup_db_sugarsales_password.value);
                            }
                            if(typeof(document.installForm.setup_db_sugarsales_password_retype) != 'undefined'){
                                document.installForm.setup_db_sugarsales_password_retype.value = document.installForm.setup_db_sugarsales_password_retype_entry.value;
                                postData += "&setup_db_sugarsales_password_retype="+encodeURIComponent(document.installForm.setup_db_sugarsales_password_retype.value);
                            }
                            if(typeof(document.installForm.dbUSRData) != 'undefined'){
                                postData += "&dbUSRData="+document.getElementById('dbUSRData').value;
                            }

                            postData += "&demoData="+document.installForm.demoData.value;

                            postData += "&to_pdf=1&sugar_body_only=1";

                            //if this is a call already in progress, then just return
                                if(typeof ajxProgress != 'undefined'){
                                    return;
                                }

                            getPanel();
                            msgPanel.show;
                            var ajxProgress = YAHOO.util.Connect.asyncRequest('POST','install.php', {success: success, failure: success}, postData);


                        };//end ajaxCall method
                          ajaxCall();
                        return;
            }

            function confirm_drop_tables(yes_no){

                    if(yes_no == true){
                        document.getElementById('setup_db_drop_tables').value = true;
                       //make navigation
                                document.installForm.goto.value="{$mod_strings['LBL_NEXT']}";
                                document.getElementById('hidden_goto').value="{$mod_strings['LBL_NEXT']}";
                                document.installForm.current_step.value="{$next_step}";
                                document.installForm.submit();
                    }else{
                        //set drop tables to false
                        document.getElementById('setup_db_drop_tables').value = false;
                        msgPanel.hide();
                    }
            }




                        var removeDBSetup = function() {
                            $('input').each(function(i,e){
                                // TODO-g fix it (see more in DBManagerFactory (at line 204) for more db types hack)
                                if($(this).attr('name') && $(this).attr('name').indexOf('setup_db')==0 && $(this).attr('name') != 'setup_db_type') {
                                    $(this).attr('name', '__not_used__' + $(this).attr('name'));
                                }
                            });
                        };

                        var onDBTypeClick = function(e) {
                            removeDBSetup();
                            formRefreshSubmit(e);
                        };
EOQ;
        return $out;
    }

    private function setData($data) {
        $this->data = $data;
    }

    /**
     * @param $__data form data
     * @return string output
     */
    private function show($data = null) {
        if($data) $this->setData($data);
        foreach($this->data as $__key => $__val) {
            $$__key = $__val;
        }
        $formId = 'installForm';
        $out = $this->getOutput(
            $this->getHeader(
                $mod_strings,
                $this->getHeaderStyles(),
                $this->getHeaderScripts($sugar_version, $js_custom_version)
            ),
            $this->getForm(
                $formId,
                $formId,
                $errs,
                $this->getFormItems($mod_strings, $app_list_strings, $sugarConfigDefaults, $drivers, $checked, $db, $errors),
                $this->getFormControlls($mod_strings, $formId),
                $this->getFormScripts($mod_strings, $next_step),
                $next_step
            ),
            $sugar_md,
            $mod_strings
        );
        return $out;
    }

    public function __toString() {
        return $this->show();
    }

}

class DisplayErrors {

    private static $settingsStack = array();

    public static function show() {
        array_push(self::$settingsStack, array(
            'level' => error_reporting(),
            'display_errors' => ini_get('display_errors'),
        ));

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    public static function restore() {
        $settings = array_pop(self::$settingsStack);
        error_reporting($settings['level']);
        ini_set('display_errors', $settings['display_errors']);
    }
}


//-------------------------------------- InstallLayout

global $sugar_version, $js_custom_version;



if( !isset( $install_script ) || !$install_script ){
    die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}



//---------------- systemOption: db driver select

if(!isset($_SESSION['setup_db_type']) || $_SESSION['setup_db_type'] ==''){
    $_SESSION['setup_db_type'] = 'mysql';
}
$setup_db_type = $_SESSION['setup_db_type'];

$errs = '';
if(isset($validation_errors)) {
    if(count($validation_errors) > 0) {
        $errs  = '<div id="errorMsgs">';
        $errs .= "<p>{$mod_strings['LBL_SYSOPTS_ERRS_TITLE']}</p>";
        $errs .= '<ul>';

        foreach($validation_errors as $error) {
            $errs .= '<li>' . $error . '</li>';
        }

        $errs .= '</ul>';
        $errs .= '</div>';
    }
}

$drivers = DBManagerFactory::getDbDrivers();
foreach(array_keys($drivers) as $dname) {
    $checked[$dname] = '';
}
$checked[$setup_db_type] = 'checked="checked"';



//----------------- dbConfig_a: db name user pass...

if(empty($_SESSION['setup_db_host_name'])){
    $_SESSION['setup_db_host_name'] = (isset($sugar_config['db_host_name']))  ? $sugar_config['db_host_name'] :  $_SERVER['SERVER_NAME'];
}


// DB split
$createDbCheckbox = '';
$createDb = (!empty($_SESSION['setup_db_create_database'])) ? 'checked="checked"' : '';
$dropCreate = (!empty($_SESSION['setup_db_drop_tables'])) ? 'checked="checked"' : '';
$instanceName = '';
if (isset($_SESSION['setup_db_host_instance']) && !empty($_SESSION['setup_db_host_instance'])){
    $instanceName = $_SESSION['setup_db_host_instance'];
}

$setupDbPortNum ='';
if (isset($_SESSION['setup_db_port_num']) && !empty($_SESSION['setup_db_port_num'])){
    $setupDbPortNum = $_SESSION['setup_db_port_num'];
}

$db = getInstallDbInstance();





//----------------- siteConfig_a.php Site Config & admin user


if( is_file("config.php") ){
    if(!empty($sugar_config['default_theme']))
        $_SESSION['site_default_theme'] = $sugar_config['default_theme'];

    if(!empty($sugar_config['disable_persistent_connections']))
        $_SESSION['disable_persistent_connections'] =
            $sugar_config['disable_persistent_connections'];
    if(!empty($sugar_config['default_language']))
        $_SESSION['default_language'] = $sugar_config['default_language'];
    if(!empty($sugar_config['translation_string_prefix']))
        $_SESSION['translation_string_prefix'] = $sugar_config['translation_string_prefix'];
    if(!empty($sugar_config['default_charset']))
        $_SESSION['default_charset'] = $sugar_config['default_charset'];

    if(!empty($sugar_config['default_currency_name']))
        $_SESSION['default_currency_name'] = $sugar_config['default_currency_name'];
    if(!empty($sugar_config['default_currency_symbol']))
        $_SESSION['default_currency_symbol'] = $sugar_config['default_currency_symbol'];
    if(!empty($sugar_config['default_currency_iso4217']))
        $_SESSION['default_currency_iso4217'] = $sugar_config['default_currency_iso4217'];

    if(!empty($sugar_config['rss_cache_time']))
        $_SESSION['rss_cache_time'] = $sugar_config['rss_cache_time'];
    if(!empty($sugar_config['languages']))
    {
        // We need to encode the languages in a way that can be retrieved later.
        $language_keys = Array();
        $language_values = Array();

        foreach($sugar_config['languages'] as $key=>$value)
        {
            $language_keys[] = $key;
            $language_values[] = $value;
        }

        $_SESSION['language_keys'] = urlencode(implode(",",$language_keys));
        $_SESSION['language_values'] = urlencode(implode(",",$language_values));
    }
}

////	errors
$errors = '';
if( isset($validation_errors) && is_array($validation_errors)){
    if( count($validation_errors) > 0 ){
        $errors  = '<div id="errorMsgs">';
        $errors .= '<p>'.$mod_strings['LBL_SITECFG_FIX_ERRORS'].'</p><ul>';
        foreach( $validation_errors as $error ){
            $errors .= '<li>' . $error . '</li>';
        }
        $errors .= '</ul></div>';
    }
}


////	ternaries
$sugarUpdates = (isset($_SESSION['setup_site_sugarbeet']) && !empty($_SESSION['setup_site_sugarbeet'])) ? 'checked="checked"' : '';
$siteSecurity = (isset($_SESSION['setup_site_defaults']) && !empty($_SESSION['setup_site_defaults'])) ? 'checked="checked"' : '';
$customSession = (isset($_SESSION['setup_site_custom_session_path']) && !empty($_SESSION['setup_site_custom_session_path'])) ? 'checked="checked"' : '';
$customLog = (isset($_SESSION['setup_site_custom_log_dir']) && !empty($_SESSION['setup_site_custom_log_dir'])) ? 'checked="checked"' : '';
$customId = (isset($_SESSION['setup_site_specify_guid']) && !empty($_SESSION['setup_site_specify_guid'])) ? 'checked="checked"' : '';


/// defaults or user sets
// TODO-g: may the system bring it up
// TODO-g: fix it!!
$_SESSION = array_merge($_SESSION, $_POST);
$sugarConfigDefaults = array_merge(get_sugar_config_defaults(), $_SESSION);

//----- show layout

// TODO-g: remove display errors
DisplayErrors::show();

echo new InstallLayout(get_defined_vars());

DisplayErrors::restore();

?>