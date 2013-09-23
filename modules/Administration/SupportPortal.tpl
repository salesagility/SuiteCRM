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


{if $helpFileExists}
<html {$langHeader}>
<head>
<title>{$title}</title>
{$styleSheet}
<meta http-equiv="Content-Type" content="text/html; charset={$charset}">
</head>
<body onLoad='window.focus();'>
<table width='100%'>
<tr>
    <td align='right'>
        <a href='javascript:window.print()'>{$MOD.LBL_HELP_PRINT}</a> - 
        <a href='mailto:?subject="{$MOD.LBL_SUGARCRM_HELP}&body={$currentURL}'>{$MOD.LBL_HELP_EMAIL}</a> - 
        <a href='#' onmousedown="createBookmarkLink('{$MOD.LBL_SUGARCRM_HELP} - {$moduleName}', '{$currentURL|escape:url}')">{$MOD.LBL_HELP_BOOKMARK}</a>
    </td>
</tr>
</table>
<table class='edit view'>
<tr>
    <td>{include file="$helpPath"}</td>
</tr>
</table>
{literal}
<script type="text/javascript" language="JavaScript">
<!--
function createBookmarkLink(title, url){
    if (document.all)
        window.external.AddFavorite(url, title);
    else if (window.sidebar)
        window.sidebar.addPanel(title, url, "")
}
-->
</script>
{/literal}
</body>
</html>	
{else}
<IFRAME frameborder="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF" SRC="{$iframeURL}" TITLE="{$iframeURL}" NAME="SUGARIFRAME" ID="SUGARIFRAME" WIDTH="100%" height="1000"></IFRAME>
{/if}