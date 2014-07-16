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


<div style='width:100%'>
<form name='configure_{$id}' action="index.php" method="post">
<input type='hidden' name='id' value='{$id}'>
<input type='hidden' name='module' value='Home'>
<input type='hidden' name='action' value='ConfigureDashlet'>
<input type='hidden' name='to_pdf' value='true'>
<input type='hidden' name='configure' value='true'>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="edit view" align="center">
<tr>
    <td scope='row'>{$titleLBL}</td>
    <td>
    	<input class="text" name="title" size='20' maxlength='80' value='{$title}'>
    </td>
</tr>
{if $isRefreshable}
<tr>
    <td scope='row'>
        {$autoRefresh}
    </td>
    <td>
        <select name='autoRefresh'>
            {html_options options=$autoRefreshOptions selected=$autoRefreshSelect}
        </select>
    </td>
</tr>
{/if}
<tr>
    <td scope='row'>{$rowsLBL}</td>
    <td>
    	<input class="text" name="rows" size='3' value='{$rows}'>
    </td>
</tr>
<tr>
    <td scope='row'>{$categoriesLBL}</td>
    <td>
        <select name='categories[]' multiple=true size=6 onchange='getMultiple(this);' id='categories_{$id}'>
    	{html_options options=$categories selected=$selectedCategories}
    	</select>
    </td>
</tr>
<tr>
  <td align="right" colspan="2">
    <div id='externalApiDiv'>
    </div>
  </td>
</tr>
<tr>
    <td align="right" colspan="2">
        <input type='button' class='button' value='{$saveLBL}' id='save_{$id}' onclick='promptAuthentication(); if(SUGAR.dashlets.postForm("configure_{$id}", SUGAR.mySugar.uncoverPage)) this.form.submit();'>
        <input type='submit' class='button' value='{$clearLBL}' onclick='SUGAR.searchForm.clear_form(this.form,["title","autoRefresh","rows"]);return false;'>
   	</td>
</tr>
</table>
<script language='javascript'>
var externalApiList = {$externalApiList};
var authenticatedExternalApiList = new Array();
{literal}


function getMultiple(ob){
    var showAll = false;
    var selected = new Array();
    for (var i = 0; i < ob.options.length; i++){
        if (ob.options[ i ].selected){
            selected.push(ob.options[ i ].value);
            if(ob.options[ i ].value == 'ALL'){
                showAll = true;
            }
        }
    }
    var buttonHtml = '';
    if(showAll){
        for (var j = 0; j < externalApiList.length; j++) 
        {
            if(!authenticatedExternalApiList[externalApiList[j]])
            {
	            buttonHtml += '<div id="' + externalApiList[j] + '_div" style="visibility:;"><a href="#" onclick="window.open(\'index.php?module=EAPM&callbackFunction=hideExternalDiv&closeWhenDone=1&action=QuickSave&application='+externalApiList[j]+'\',\'EAPM\');">{/literal}{$authenticateLBL}{literal} '+externalApiList[j]+'</a></div>';
            }
        }
    }else{
        for (var i = 0; i < selected.length; i++){
            for (var j = 0; j < externalApiList.length; j++)
            {
                if(selected[i] == externalApiList[j] && !authenticatedExternalApiList[externalApiList[j]]) 
                {
                    buttonHtml += '<div id="' + externalApiList[j] + '_div" style="visibility:";><a href="#" onclick="window.open(\'index.php?module=EAPM&callbackFunction=hideExternalDiv&closeWhenDone=1&action=QuickSave&application='+externalApiList[j]+'\',\'EAPM\');">{/literal}{$authenticateLBL}{literal} '+externalApiList[j]+'</a></div>';
                }
            }
        }
    }
    document.getElementById('externalApiDiv').innerHTML = buttonHtml;
}

function initExternalOptions(){
    var ob = document.getElementById('{/literal}categories_{$id}{literal}');
    getMultiple(ob);
}

function hideExternalDiv(id)
{
    //Hide the div for the external API link, set the authenticated Array list to true
    if(YAHOO.util.Dom.get(id + '_div'))
    {
		YAHOO.util.Dom.get(id + '_div').style.visibility = 'hidden';
		authenticatedExternalApiList[id] = true;
	}
}

function promptAuthentication()
{
    //This is how we know that not all external API links were authenticated
{/literal}
     categoryElement = YAHOO.util.Dom.get('categories_{$id}');  
{literal} 
    //Only check for prompt warning if the 'ALL' option was selected
    if(categoryElement.selectedIndex != -1 && categoryElement.options[categoryElement.selectedIndex].value != 'ALL')
    {
       return;
    }
    
	if(authenticatedExternalApiList.length < externalApiList.length)
	{
{/literal}
		if(!confirm("{$autenticationPendingLBL}")) 
{literal}		
		{
		    //Cancel form submission here
		    e = event ? event : window.event;
		    if (e.preventDefault) e.preventDefault();
		    e.returnValue = false;
		    e.cancelBubble = true;
		    if (e.stopPropagation) e.stopPropagation();
		}
	}
}

YAHOO.util.Event.onDOMReady(initExternalOptions);
</script>
{/literal}
</form>
</div>