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

///////////////////////////////////////////////////////////////////////////////
////	START OUTPUT

$langHeader = get_language_header();
$out = <<<EOQ
<!DOCTYPE HTML>
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_TITLE_WELCOME']} {$setup_sugar_version} {$mod_strings['LBL_WELCOME_SETUP_WIZARD']}</title>
   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
   <link rel="stylesheet" href="install/install.css" type="text/css">
   <link rel="stylesheet" href="themes/Suite7/css/responsiveslides.css" type="text/css">
   <link rel="stylesheet" href="themes/Suite7/css/themes.css" type="text/css">
   <script src="include/javascript/jquery/jquery-min.js"></script>
   <script src="themes/Suite7/js/responsiveslides.min.js"></script>
</head>
<body onload="javascript:document.getElementById('button_next2').focus();">
    <!--SuiteCRM installer-->
    <div id="install_container">
    <div id="install_box">
        <form action="install.php" method="post" name="form" id="form">
            <header id="install_header">
                <h1 id="welcomelink">{$mod_strings['LBL_TITLE_WELCOME']} {$setup_sugar_version} {$mod_strings['LBL_WELCOME_SETUP_WIZARD']}</h1>
                <div class="install_img"><a href="https://suitecrm.com" target="_blank"><img src="{$sugar_md}" alt="SuiteCRM"></a></div>
            </header>
            <div id="wrapper">
                <div class="rslides_container">
                    <ul class="rslides" id="slider2">
                        <li><img src="themes/Suite7/images/SuiteScreen1.png" alt="" class="sliderimg"></li>
                             <li><img src="themes/Suite7/images/SuiteScreen2.png" alt="" class="sliderimg"></li>
                            <li><img src="themes/Suite7/images/SuiteScreen3.png" alt="" class="sliderimg"></li>
                            <li><img src="themes/Suite7/images/SuiteScreen4.png" alt="" class="sliderimg"></li>
                    </ul>
                </div>
            </div>

            <div id="progress">
                {$mod_strings['LBL_WELCOME_CHOOSE_LANGUAGE']}: <select name="language" onchange='this.form.submit()';>{$langDropDown}</select>
	            <input type="hidden" name="current_step" value="{$next_step}">
                <input class="button" type="submit" name="goto" value="{$mod_strings['LBL_NEXT']}" id="button_next2" />
            </div>
	    </form>
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
        maxwidth: 750,
        namespace: "centered-btns",
        speed: 800,            // Integer: Speed of the transition, in milliseconds
        timeout: 6000,          // Integer: Time between slide transitions, in milliseconds
    });
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
