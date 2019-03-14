<!--
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

/**
 * Header: /cvsroot/sugarcrm/sugarcrm/modules/Products/ListView.html,v 1.4 2004/07/02 07:02:27 sugarclint Exp {APP.LBL_LIST_CURRENCY_SYM}
 */
-->

<body style="margin: 0px;">
<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
global $theme;

insert_popup_header($theme);

$sugarteam = array( 'Julian Ostrow', 'Lam Huynh', 'Majed Itani', 'Joey Parsons', 'Ajay Gupta', 'Jason Nassi', 'Andy Dreisch', 'Roger Smith', 'Liliya Bederov', 'Sadek Baroudi', 'Franklin Liu', 'Jennifer Yim', 'Sujata Pamidi', 'Eddy Ramirez', 'Jenny Gonsalves', 'Collin Lee', 'David Wheeler', 'John Mertic', 'Ran Zhou', 'Shine Ye','Emily Gan','Randy Lee','Eric Yang','Oliver Yang','Andreas Sandberg');
switch ($_REQUEST['style']) {
    case 'rev':
            $sugarteam = array_map('strrev', $sugarteam);
            break;
    case 'rand':
            shuffle($sugarteam);
            break;
    case 'dec':
            $sugarteam = array_reverse($sugarteam);
            break;
    case 'sort':
             sort($sugarteam);
             break;
    case 'rsort':
             rsort($sugarteam);
             break;
             
}

$founders = array("<b>Founders:</b>", 'John Roberts', 'Clint Oram', 'Jacob Taylor');

$body =  implode('<br>', $founders) . "<br><br><b>Developers:</b><br>" . implode('<br>', $sugarteam);
?>
<script>
	var user_notices = new Array();
	var delay = 25000
	var index = 0;
	var lastIndex = 0;
	var scrollerHeight=200
	var bodyHeight = ''
	var scrollSpeed = 1;
	var curTeam = 'all';
	var scrolling = true;


	


	function stopNotice(){
			scrolling = false;
	}
	function startNotice(){
			scrolling = true;
	}
	function scrollNotice(){

		if(scrolling){
		
		var body = document.getElementById('NOTICEBODY')
		var daddy = document.getElementById('daddydiv')

		if(parseInt(body.style.top) > bodyHeight *-1 ){

			body.style.top = (parseInt(body.style.top) - scrollSpeed) + 'px';

		}else{
			
			body.style.top =scrollerHeight + "px"
		}
		}

		setTimeout("scrollNotice()", 50);

	}
	function nextNotice(){



		body = document.getElementById('NOTICEBODY');
		if(scrolling){
				body.style.top = scrollerHeight/2 +'px'
				bodyHeight= parseInt(body.offsetHeight);
		}
				

		}
	


</script>
<div style="width: 300px; height: 400px; text-align: center; border:0; padding: 5px;">
<div id='daddydiv' style="position:relative;width=100%;height:350px;overflow:hidden">
<div id='NOTICEBODY' style="position:absolute;left:0px;top:0px;width:100%;z-index: 1; text-align: left;">
<?php echo $body; ?>
</div>
</div>
<script>
if(window.addEventListener){
	window.addEventListener("load", nextNotice, false);
	window.addEventListener("load", scrollNotice, false);
}else{
	window.attachEvent("onload", nextNotice);
	window.attachEvent("onload", scrollNotice);
}
</script>


