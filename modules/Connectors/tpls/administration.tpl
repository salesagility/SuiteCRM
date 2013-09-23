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
<table class='edit view small' width="100%" border="0" cellspacing="1" cellpadding="0" >		
	<tr valign="top">
		<td width="35%">
			<table  border="0" cellspacing="2" cellpadding="0" >	
				<tr valign='top'>
					<td><img src="{$IMG}icon_ConnectorConfig.gif" name="connectorConfig" onclick="document.location.href='index.php?module=Connectors&action=ModifyProperties';"
						onMouseOver="document.connectorConfig.src='{$IMG}icon_ConnectorConfigOver.gif'"
						onMouseOut="document.connectorConfig.src='{$IMG}icon_ConnectorConfig.gif'"></td>
					<td>&nbsp;&nbsp;</td>
					<td><b>{$mod.LBL_MODIFY_PROPERTIES_TITLE}</b><br/>
						{$mod.LBL_MODIFY_PROPERTIES_DESC}
					</td>
				</tr>
				<tr>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr valign='top'>
					<td><img src="{$IMG}icon_ConnectorEnable.gif" name="enableImage" onclick="document.location.href='index.php?module=Connectors&action=ModifyDisplay';"
						onMouseOver="document.enableImage.src='{$IMG}icon_ConnectorEnableOver.gif'"
						onMouseOut="document.enableImage.src='{$IMG}icon_ConnectorEnable.gif'"></td>
					<td>&nbsp;&nbsp;</td>
					<td><b>{$mod.LBL_MODIFY_DISPLAY_TITLE}</b><br/>
						{$mod.LBL_MODIFY_DISPLAY_DESC}
					</td>
				</tr>			
			</table>
		</td>
		<td width="10%">&nbsp;</td>
		<td width="35%">
			<table  border="0" cellspacing="2" cellpadding="0">	   
				<tr valign='top'>
					<td><img src="{$IMG}icon_ConnectorMap.gif" name="connectorMapImg" onclick="document.location.href='index.php?module=Connectors&action=ModifyMapping';"
						onMouseOver="document.connectorMapImg.src='{$IMG}icon_ConnectorMapOver.gif'"
						onMouseOut="document.connectorMapImg.src='{$IMG}icon_ConnectorMap.gif'"></td>
					<td>&nbsp;&nbsp;</td>
					<td><b>{$mod.LBL_MODIFY_MAPPING_TITLE}</b><br/>
						{$mod.LBL_MODIFY_MAPPING_DESC}
					</td>
				</tr>

				<tr>
					<td colspan=2>&nbsp;</td>
				</tr>


				<tr valign='top'>
					<td>
					    <img src="{$IMG}icon_ConnectorSearchFields.gif" name="connectorSearchImg" onclick="document.location.href='index.php?module=Connectors&action=ModifySearch';"
						onMouseOver="document.connectorSearchImg.src='{$IMG}icon_ConnectorSearchFieldsOver.gif'"
						onMouseOut="document.connectorSearchImg.src='{$IMG}icon_ConnectorSearchFields.gif'">
				    </td>
					<td>&nbsp;&nbsp;</td>
					<td>
					    {* BEGIN SUGARCRM flav=pro || flav=sales ONLY *}
					    <b>{$mod.LBL_MODIFY_SEARCH_TITLE}</b><br/>
						{$mod.LBL_MODIFY_SEARCH_DESC}
						{* END SUGARCRM flav=pro || flav=sales ONLY *}
					</td>	
				</tr>

			</table>
		</td>				
		<td width="20%">&nbsp;</td>
	</tr>
</table>