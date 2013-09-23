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
{php}
global $emailInstances;
if (empty($emailInstances))
	$emailInstances = array();
if (!isset($emailInstances[$this->_tpl_vars['module']]))
	$emailInstances[$this->_tpl_vars['module']] = 0;
$this->_tpl_vars['index'] = $emailInstances[$this->_tpl_vars['module']];
$emailInstances['module']++;
{/php}
<script type="text/javascript" language="javascript">
var emailAddressWidgetLoaded = false;
</script>
<script type="text/javascript" src="include/SugarEmailAddress/SugarEmailAddress.js"></script>
<script type="text/javascript">
	var module = '{$module}';
</script>
<table style="border-spacing: 0pt;">
	<tr>
		<td  valign="top" NOWRAP>
			<table id="{$module}emailAddressesTable{$index}" class="emailaddresses">
				<tbody id="targetBody"></tbody>
				<tr>
					<td scope="row" NOWRAP>
					    <input type=hidden id="{$module}_email_widget_id" name="{$module}_email_widget_id" value="">
						<input type=hidden id='emailAddressWidget' name='emailAddressWidget' value='1'>
                        {capture assign="other_attributes"}id="{$module}{$index}_email_widget_add" onclick="javascript:SUGAR.EmailAddressWidget.instances.{$module}{$index}.addEmailAddress('{$module}emailAddressesTable{$index}','','');"{/capture}
                        <button type="button" {$other_attributes}>{sugar_getimage name="id-ff-add" alt="$app_strings.LBL_ID_FF_ADD" ext=".png"}</button>
					</td>
					<td scope="row" NOWRAP>
					    &nbsp;
					</td>
					<td scope="row" NOWRAP>
						{$app_strings.LBL_EMAIL_PRIMARY}
					</td>
					{if $useReplyTo == true}
					<td scope="row" NOWRAP>
						{$app_strings.LBL_EMAIL_REPLY_TO}
					</td>
					{/if}
					{if $useOptOut == true}
					<td scope="row" NOWRAP>
						{$app_strings.LBL_EMAIL_OPT_OUT}
					</td>
					{/if}
					{if $useInvalid == true}
					<td scope="row" NOWRAP>
						{$app_strings.LBL_EMAIL_INVALID}
					</td>
					{/if}
				</tr>
			</table>
		</td>
	</tr>
</table>
<input type="hidden" name="useEmailWidget" value="true">
<script type="text/javascript" language="javascript">
SUGAR_callsInProgress++;
function init{$module}Email{$index}(){ldelim}
	if(emailAddressWidgetLoaded || SUGAR.EmailAddressWidget){ldelim}
		var table = YAHOO.util.Dom.get("{$module}emailAddressesTable{$index}");
	    var eaw = SUGAR.EmailAddressWidget.instances.{$module}{$index} = new SUGAR.EmailAddressWidget("{$module}");
		eaw.emailView = '{$emailView}';
	    eaw.emailIsRequired = "{$required}";
	    eaw.tabIndex = '{$tabindex}';
	    var addDefaultAddress = '{$addDefaultAddress}';
	    var prefillEmailAddress = '{$prefillEmailAddresses}';
	    var prefillData = {$prefillData};
	    if(prefillEmailAddress == 'true') {ldelim}
	        eaw.prefillEmailAddresses('{$module}emailAddressesTable{$index}', prefillData);
		{rdelim} else if(addDefaultAddress == 'true') {ldelim}
	        eaw.addEmailAddress('{$module}emailAddressesTable{$index}');
		{rdelim}
		if('{$module}_email_widget_id') {ldelim}
		   document.getElementById('{$module}_email_widget_id').value = eaw.count;
		{rdelim}
		SUGAR_callsInProgress--;
	{rdelim}else{ldelim}
		setTimeout("init{$module}Email{$index}();", 500);
	{rdelim}
{rdelim}

YAHOO.util.Event.onDOMReady(init{$module}Email{$index});
</script>
