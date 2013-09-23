<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

?>
<script>
	function addToDescription(form, name, value){
			form.description.value += '--' + name + "=" + value+ "--"
	}
</script>
<form name='leadcap' action='../index.php?entryPoint=leadCapture' method='post'>
	<input type='hidden' name='lead_source' value='Web Site'>
	<input type='hidden' name='user' value='cheeto'>
	<input type='hidden' name='description' value=''>
	<input type='hidden' name='redirect' value='http://localhost/sugarcrm/examples/FormValidationTest.php'>
	<div align='center'>
	Please fill out this form so we can better server your game playing and food eating needs. It will redirect you to the form validation test.
	<table border=1><tr><td><table>
	<tr><td>First Name:</td><td><input type='text' name='first_name'></td></tr>
	<tr><td>Last Name:</td><td><input type='text' name='last_name'></td></tr>
	<tr><td>Company Name:</td><td><input type='text' name='account_name'></td></tr>
	<tr><td>Title:</td><td><input type='text' name='title'></td></tr>
	<tr><td>Favorite Game:</td><td><select name='game'>
		<option value='monopoly'> Monopoly</option>
		<option value='uno'> UNO</option>
		<option value='sorry'> Sorry</option>
		<option value='Checkers'> Checkers</option>
	</select></td></tr>
	<tr><td>Favorite Food:</td><td><select name='food'>
		<option value='pizza'> Pizza</option>
		<option value='hamburger'> Hamburger</option>
		<option value='candy'> Candy </option>
		<option value='icecream'> Ice Cream</option>
	</select></td></tr>

	<tr><td></td><td><input type='Submit' name='submit' value='Submit' onclick='addToDescription(document.leadcap,"Favorite Food", document.leadcap.food.options[document.leadcap.food.selectedIndex].text);addToDescription(document.leadcap,"Favorite Game", document.leadcap.game.options[document.leadcap.game.selectedIndex].text);' ></td></tr></table></table>
</form>