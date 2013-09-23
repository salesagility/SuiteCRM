{*

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


*}
<style>
div.playArea {ldelim}
    text-align:left; 
    overflow: hidden; 
    background-color: black; 
    background-image: url('modules/Home/Dashlets/InvadersDashlet/sprites/bg.png'); 
    width: 400px; 
    height:300px;
    position: relative;
    overflow: hidden;
{rdelim}
</style>
<div align="center">
<div class="playArea">
    <img id="player" style="position: absolute; top:270px; left:134px"
        src="modules/Home/Dashlets/InvadersDashlet/sprites/player.png" width="32px" height="32px"/>
    <img id="shot"   style="position: absolute; top:245px; display: none"
        src="modules/Home/Dashlets/InvadersDashlet/sprites/cube.png" width="16px" height="16px"/>
    
    <div id="aliens" style="position: absolute; left:0px; width:172px;">
		<table cellpadding="0" cellspacing="2"><tbody>
		<tr>
			<td id="a00" width="32" height="14">&nbsp;</td>
			<td id="a10" width="32" height="14">&nbsp;</td>
			<td id="a20" width="32" height="14">&nbsp;</td>
			<td id="a30" width="32" height="14">&nbsp;</td>
			<td id="a40" width="32" height="14">&nbsp;</td>
		</tr>
		<tr>
			<td id="a01" width="32" height="14">&nbsp;</td>
			<td id="a11" width="32" height="14">&nbsp;</td>
			<td id="a21" width="32" height="14">&nbsp;</td>
			<td id="a31" width="32" height="14">&nbsp;</td>
			<td id="a41" width="32" height="14">&nbsp;</td>
		</tr>
		<tr>
			<td id="a02" width="32" height="14">&nbsp;</td>
			<td id="a12" width="32" height="14">&nbsp;</td>
			<td id="a22" width="32" height="14">&nbsp;</td>
			<td id="a32" width="32" height="14">&nbsp;</td>
			<td id="a42" width="32" height="14">&nbsp;</td>
		</tr>
		<tr>
			<td id="a03" width="32" height="14">&nbsp;</td>
			<td id="a13" width="32" height="14">&nbsp;</td>
			<td id="a23" width="32" height="14">&nbsp;</td>
			<td id="a33" width="32" height="14">&nbsp;</td>
			<td id="a43" width="32" height="14">&nbsp;</td>
		</tr>
		</tbody></table>
	</div>
	<div align="center" id="startScreen" style="position: relative; top: 150px;" onclick="InvadersGame.reset()">
		<a href="javascript:void(0);" class="otherTabLink" style="text-decoration:none;">
		    <h1 style="color: #FFF;" id="messageText">{$dashletStrings.LBL_START}</h1>
		</a>
	</div>
</div>
</div>
