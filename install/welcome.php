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
// $mod_strings come from calling page.

$langDropDown = get_select_options_with_id($supportedLanguages, $current_language);




$_SESSION['setup_license_accept']   = get_boolean_from_request('setup_license_accept');
$_SESSION['license_submitted']      = true;

// setup session variables (and their defaults) if this page has not yet been submitted
if(!isset($_SESSION['license_submitted']) || !$_SESSION['license_submitted']){
    $_SESSION['setup_license_accept'] = false;
}

$checked = (isset($_SESSION['setup_license_accept']) && !empty($_SESSION['setup_license_accept'])) ? 'checked="on"' : '';

require_once("install/install_utils.php");
$license_file = getLicenseContents("LICENSE.txt");
$langHeader = get_language_header();


// load javascripts
include('jssource/JSGroupings.php');
$jsSrc = '';
foreach($sugar_grp1_yui as $jsFile => $grp) {
    $jsSrc .= "\t<script src=\"$jsFile\"></script>\n";
}

///////////////////////////////////////////////////////////////////////////////
////	START OUTPUT

$langHeader = get_language_header();
$out = <<<EOQ
<!DOCTYPE HTML>
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
   <title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_TITLE_WELCOME']} {$setup_sugar_version} {$mod_strings['LBL_WELCOME_SETUP_WIZARD']}, {$mod_strings['LBL_LICENSE_ACCEPTANCE']}</title>
   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
   <link rel="stylesheet" href="install/install2.css" type="text/css">
   <link rel="stylesheet" href="themes/Suite7/css/responsiveslides.css" type="text/css">
   <link rel="stylesheet" href="themes/Suite7/css/themes.css" type="text/css">
   <script src="include/javascript/jquery/jquery-min.js"></script>
   <script src="themes/Suite7/js/responsiveslides.min.js"></script>
    $jsSrc
   <script type="text/javascript">
    <!--
    if ( YAHOO.env.ua )
        UA = YAHOO.env.ua;
    -->
    </script>
    <link rel='stylesheet' type='text/css' href='include/javascript/yui/build/container/assets/container.css' />
    <script type="text/javascript" src="install/license.js"></script>
    <link rel="stylesheet" href="themes/Suite7/css/fontello.css">
    <link rel="stylesheet" href="themes/Suite7/css/animation.css"><!--[if IE 7]><link rel="stylesheet" href="css/fontello-ie7.css"><![endif]-->
    <style>
        /*
        #install_box {
            max-width: 1000px;
            margin: 20px auto;
        }
        */
    </style>
</head>
<body onload="javascript:toggleNextButton();document.getElementById('button_next2').focus();">
    <!--SuiteCRM installer-->
    <div id="install_container">
    <div id="install_box">
        <form action="install.php" method="post" name="setConfig" id="form">
            <header id="install_header">
                <h1 id="welcomelink">{$mod_strings['LBL_TITLE_WELCOME']} {$setup_sugar_version} {$mod_strings['LBL_WELCOME_SETUP_WIZARD']}</h1>
                <div class="install_img"><a href="https://suitecrm.com" target="_blank"><img src="{$sugar_md}" alt="SuiteCRM"></a></div>
            </header>
            <div id="wrapper" style="display:none;">
                <div class="rslides_container">
                    <ul class="rslides" id="slider2">
                        <li><img src="themes/Suite7/images/SuiteScreen1.png" alt="" class="sliderimg"></li>
                             <li><img src="themes/Suite7/images/SuiteScreen2.png" alt="" class="sliderimg"></li>
                            <li><img src="themes/Suite7/images/SuiteScreen3.png" alt="" class="sliderimg"></li>
                            <li><img src="themes/Suite7/images/SuiteScreen4.png" alt="" class="sliderimg"></li>
                    </ul>
                </div>
            </div>

            <!--
            <div id='licenseDivToggler' style="text-align: center;"><a href="javascript:void(0);" onclick="javascript:$('#licenseDiv').toggle();">Show Software License</a></div>
            -->
		<div id="content">
            <div id='licenseDiv' style="/* display: none; */">
                <textarea class="licensetext" cols="80" rows="20" readonly>{$license_file}</textarea>
            </div>
            <div id="licenseaccept">
                <input type="checkbox" class="checkbox" name="setup_license_accept" id="button_next2" onClick='toggleNextButton();' {$checked} />
                <a href='javascript:void(0)' onClick='toggleLicenseAccept();toggleNextButton();'>{$mod_strings['LBL_LICENSE_I_ACCEPT']}</a>
                <input type="button" class="button" name="print_license" id="button_print_license" value="{$mod_strings['LBL_LICENSE_PRINTABLE']}"
                onClick='window.open("install.php?page=licensePrint&language={$current_language}");' />
            </div>
		</div>
            <hr>
            <div id="installcontrols">

                <input type="hidden" name="current_step" value="{$next_step}">
                {$mod_strings['LBL_WELCOME_CHOOSE_LANGUAGE']}: <select name="language" onchange='onLangSelect(this);';>{$langDropDown}</select>
                <input class="acceptButton" type="button" name="goto" value="{$mod_strings['LBL_NEXT']}" id="button_next" disabled="disabled" title="{$mod_strings['LBL_LICENCE_TOOLTIP']}" onclick="callSysCheck();"/>
                <input type="hidden" name="goto" id='hidden_goto' value="{$mod_strings['LBL_BACK']}" />
            </div>



	    </form>
	    <div style="clear:both;"></div>
	    <div id='sysCheckMsg'></div>
	    <div style="clear:both;"></div>
	</div>
	<div id="checkingDiv" style="display:none">
	    <!-- <table cellspacing='0' cellpadding='0' border='0' align='center'><tr><td> -->
            <p><img src='install/processing.gif' alt="{$mod_strings['LBL_LICENSE_CHECKING']}"> <br>{$mod_strings['LBL_LICENSE_CHECKING']}</p>
        <!-- </td></tr></table> -->
    </div>
	<footer id="install_footer">
        <p id="footer_links"><a href="https://suitecrm.com" target="_blank">Visit suitecrm.com</a> | <a href="https://suitecrm.com/index.php?option=com_kunena&view=category&Itemid=1137&layout=list" target="_blank">Support Forums</a> | <a href="https://suitecrm.com/wiki/index.php/Installation" target="_blank">Installation Guide</a> | <a href="LICENSE.txt" target="_blank">License</a>
    </footer>
    </div>
<script>
    function showtime(div){

        if(document.getElementById(div).style.display == ''){
            document.getElementById(div).style.display = 'none';
            document.getElementById('adv_'+div).style.display = '';
            document.getElementById('basic_'+div).style.display = 'none';
            }
            else {
            document.getElementById(div).style.display = '';
            document.getElementById('adv_'+div).style.display = 'none';
            document.getElementById('basic_'+div).style.display = '';
            }

        }
</script>
<script>
    $(".rslides").responsiveSlides({
        auto: true,             // Boolean: Animate automatically, true or false
        speed: 800,            // Integer: Speed of the transition, in milliseconds
        timeout: 6000,          // Integer: Time between slide transitions, in milliseconds
        pager: false,           // Boolean: Show pager, true or false
        random: false,          // Boolean: Randomize the order of the slides, true or false
        pause: false,           // Boolean: Pause on hover, true or false
        pauseControls: true,    // Boolean: Pause when hovering controls, true or false
        prevText: "",   // String: Text for the "previous" button
        nextText: "",       // String: Text for the "next" button
        maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
        navContainer: "ul",       // Selector: Where controls should be appended to, default is after the 'ul'
        manualControls: "",     // Selector: Declare custom pager navigation
        namespace: "rslides",   // String: Change the default namespace used
        before: function(){},   // Function: Before callback
        after: function(){}     // Function: After callback
    });
    $("#slider2").responsiveSlides({
        nav: true,
        speed: 500,
        //maxwidth: 750,
        namespace: "centered-btns",
        speed: 800,            // Integer: Speed of the transition, in milliseconds
        timeout: 6000,          // Integer: Time between slide transitions, in milliseconds
    });
</script>

<script>
var msgPanel;
function callSysCheck(){

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

                                effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:.5},
                                zindex: 1000
                               } ;
                        msg_panel = new YAHOO.widget.Panel('p_msg', args);
                        //If we haven't built our panel using existing markup,
                        //we can set its content via script:
                        msg_panel.setHeader("{$mod_strings['LBL_LICENSE_CHKENV_HEADER']}");
                        msg_panel.setBody(document.getElementById("checkingDiv").innerHTML);
                        msg_panel.render(document.body);
                        msgPanel = msg_panel;
                }


                passed = function(url){
                    document.setConfig.goto.value="{$mod_strings['LBL_NEXT']}";
                    document.getElementById('hidden_goto').value="{$mod_strings['LBL_NEXT']}";
                    document.setConfig.current_step.value="{$next_step}";
                    document.setConfig.submit();
                    window.focus();
                }
                success = function(o) {
                    if (o.responseText.indexOf('passed')>=0){
                        if ( YAHOO.util.Selector.query('button', 'p_msg', true) != null )
                            YAHOO.util.Selector.query('button', 'p_msg', true).style.display = 'none';
                        //scsbody =  "<table cellspacing='0' cellpadding='0' border='0' align='center'><tr><td>";
						scsbody = '<h1>{$mod_strings['LBL_LICENSE_CHKENV_HEADER']}</h1>';
                        scsbody += "<p><img src='install/processing.gif' alt=\"{$mod_strings['LBL_CREATE_CACHE']}\"></p>";
                        scsbody += "<p>{$mod_strings['LBL_LICENSE_CHECK_PASSED']}<br>{$mod_strings['LBL_CREATE_CACHE']}</p>";
                        //scsbody += "<div id='cntDown'>{$mod_strings['LBL_THREE']}</div>";
                        //scsbody += "</td></tr></table>";
                        //scsbody += "<script>countdown(3);<\/script>";
                        //msgPanel.setBody(scsbody);
                        //msgPanel.render();
						$('#content').html(scsbody);
                        //countdown(3);
                        //window.setTimeout('passed("install.php?goto=next")', 2500);
                        passed("install.php?goto=next");

                    }else{
                        //turn off loading message
                        //msgPanel.hide();
                        $('#content p').remove();
                        document.getElementById('sysCheckMsg').style.display = '';
                        /* document.getElementById('licenseDiv').style.display = 'none'; */
                        document.getElementById('sysCheckMsg').innerHTML=o.responseText;
                    }


                }//end success

                //set loading message and create url
                postData = "checkInstallSystem=true&to_pdf=1&sugar_body_only=1";

                //if this is a call already in progress, then just return
                    if(typeof ajxProgress != 'undefined'){
                        return;
                    }

                //getPanel();
                //msgPanel.show;
				
				$('#content').addClass('preloading');
				$('#content').html('<h1>{$mod_strings['LBL_LICENSE_CHKENV_HEADER']}</h1>' + document.getElementById("checkingDiv").innerHTML);
						
                var ajxProgress = YAHOO.util.Connect.asyncRequest('POST','install.php', {success: success, failure: success}, postData);


            };//end ajaxCall method
              ajaxCall();
            return;
}

    function countdown(num){
        //scsbody =  "<table cellspacing='0' cellpadding='0' border='0' align='center'><tr><td>";
		scsbody = '<h1>{$mod_strings['LBL_LICENSE_CHKENV_HEADER']}</h1>';
        scsbody += "<p>{$mod_strings['LBL_LICENSE_CHECK_PASSED']}</p>";
        scsbody += "<div id='cntDown'>{$mod_strings['LBL_LICENSE_REDIRECT']}"+num+"</div>";
        //scsbody += "</td></tr></table>";
        //msgPanel.setBody(scsbody);
        //msgPanel.render();
		$('#content').html(scsbody);
        if(num >0){
             num = num-1;
             setTimeout("countdown("+num+")",1000);
        }
    }

</script>

<script>
function onLangSelect(e) {
    $("input[name=current_step]").attr('name', '_current_step');
    $("input[name=goto]").attr('name', '_goto');
    e.form.submit();
}
</script>

</body>
</html>
EOQ;
if (version_compare(phpversion(),'5.2.2') < 0) {
	if(empty($mod_strings['LBL_MINIMUM_PHP_VERSION'])){
		$mod_strings['LBL_MINIMUM_PHP_VERSION'] = 'The minimum PHP version required is 5.2.2.';
	}

$php_verison_warning =<<<eoq
	    <table width="100%" cellpadding="0" cellpadding="0" border="0" class="Welcome">
			<tr>
		      <td colspan="2"  align="center" id="ready_image"><IMG src="include/images/install_themes.jpg" width="698" height="190" alt="Sugar Themes" border="0"></td>
		    </tr>
			<th colspan="2" align="center">
				<h1><span class='error'><b>{$mod_strings['LBL_MINIMUM_PHP_VERSION']}</b></span></h1>
			</th>
			<tr>
		      <td colspan="2" align="center" id="ready_image"><IMG src="include/images/install_themes.jpg" width="698" height="190" alt="Sugar Themes" border="0"></td>
		    </tr>
	</table>
eoq;
	$out = $php_verison_warning;
}
echo $out;
?>
