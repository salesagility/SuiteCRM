{*

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


*}
<script type="text/javascript">
{literal}
function submitListViewDCMenu(submitElem) {
var callback = {
success: function(o) {

var contentElem = document.getElementById('dcSearch');
while ( typeof(contentElem) != 'undefined' && contentElem.className != 'dccontent' ) {
contentElem = contentElem.parentNode;
}
contentElem.innerHTML = o.responseText;
},
failure: function(o) {
// AJAX failed, we have probably timed out of our session, force a reload
window.history.go(0);
}
};
{/literal}
YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback, "module=Documents&action=extdoc&isPopup={$isPopup}&elemBaseName={$elemBaseName}&apiName={$apiName}&button=Search&name_basic="+document.getElementById('dcSearch').value);
{literal}
}
{/literal}
</script>
<div id="dcSearchFormDiv" style="left:20px;">
<form id="dcSearchForm">
<table class='dcSearch' border='0' cellpadding='2' cellspacing='2'>
<tr>
<td>
<b>{$searchFieldLabel}:&nbsp;&nbsp;</b>
</td>
<td>
<input type='text' id='dcSearch' name='dcSearch' value="{$DCSEARCH}">
</td>
<td>
<input type='submit' name='submit' class='dcSubmit' value='{$APP.LBL_SEARCH}' onclick="submitListViewDCMenu(this); return false;">
</td>
</tr>
</table>
</form>	
</div>
<div style="padding-left: 3em; padding-right: 3em; padding-bottom: 5px;">{$displayedNote}</div>
<table width='100%' class='dcListView' cellpadding='0' cellspacing='0'>
  <tr height='20'>
    {counter start=0 name="colCounter" print=false assign="colCounter"}
    {foreach from=$displayColumns key=colHeader item=params}
      <th scope='col' width='{$params.width}%'>
        <div style='white-space: normal;'width='100%' align='{$params.align|default:'left'}'>
          {sugar_translate label=$params.label module='Documents'}
        </div>
      </th>
      {counter name="colCounter"}
    {/foreach}
    <th scope='col' nowrap="nowrap" width='1%'>&nbsp;</th>
  </tr>

  {foreach name=rowIteration from=$data key=id item=rowData}
	{counter name="offset" print=false}

	{if $smarty.foreach.rowIteration.iteration is odd}
	  {assign var='_rowColor' value=$rowColor[0]}
	{else}
	  {assign var='_rowColor' value=$rowColor[1]}
	{/if}
    <tr height='20' class='{$_rowColor}S1'>
      {counter start=0 name="colCounter" print=false assign="colCounter"}
      {foreach from=$displayColumns key=col item=params}
        {strip}
          <td scope='row' align='{$params.align|default:'left'}' valign="top" {if ($params.type == 'teamset')}class="nowrap"{/if}>
            {if $col == 'NAME' || $params.bold}<b>{/if}
            {if $params.link && !empty($rowData.DOC_URL) }
              <a href="{$rowData.DOC_URL}" target="{$linkTarget}">
            {/if}
            {sugar_field parentFieldArray=$rowData vardef=$params displayType=ListView field=$col}
            {if empty($rowData.$col)}&nbsp;{/if}
            {if $params.link && !empty($rowData.DOC_URL) }
              </a>
            {/if}
            {if $params.link && !empty($rowData.URL) }
              <a href="{$rowData.URL}" class="tabDetailViewDFLink" target="_blank"><img src="{$imgPath}" border="0"></a>
            {/if}
            {if $col == 'NAME' || $params.bold}</b>{/if}
          </td>
        {/strip}
      {counter name="colCounter"}
      {/foreach}
    </tr>
  {foreachelse}
	<tr height='20' class='{$rowColor[0]}S1'>
	    <td colspan="{$colCount}">
	        <em>{$APP.LBL_NO_DATA}</em>
	    </td>
	</tr>
  {/foreach}
</table>
