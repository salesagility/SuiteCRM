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
{if $ERR_SUHOSIN == true}
{$APP_STRINGS.ERR_SUHOSIN}
{else}
{$scripts}
{$TREEHEADER}
{literal}

<style type="text/css">
#demo { width:100%; }
#demo .yui-content {
    padding:1em; /* pad content container */
}
.list {list-style:square;width:500px;padding-left:16px;}
.list li{padding:2px;font-size:8pt;}

/* hide the tab content while loading */
.tab-content{display:none;}

pre {
   font-size:11px;
}

#tabs1 {width:100%;}
#tabs1 .yui-ext-tabbody {border:1px solid #999;border-top:none;}
#tabs1 .yui-ext-tabitembody {display:none;padding:10px;}

/* default loading indicator for ajax calls */
.loading-indicator {
	font-size:8pt;
	background-image:url('../../resources/images/grid/loading.gif');
	background-repeat: no-repeat;
	background-position: left;
	padding-left:20px;
}
/* height of the rows in the grids */
.ygrid-row {
    height:27px;
}
.ygrid-col {
    height:27px !important;
}
</style>
{/literal}
{$INSTALLED_PACKAGES_HOLDER}
<br>

<form action='{$form_action}' method="post" name="installForm">
<input type=hidden name="release_id">
{$hidden_fields}
<div id='server_upload_div'>
{$FORM_2_PLACE_HOLDER}
{$MODULE_SELECTOR}
<div id='search_results_div'></div>
</div>
</form>
<div id='local_upload_div'>
{$FORM_1_PLACE_HOLDER}
</div>

{if $module_load == 'true'}
<div id='upload_table'>
<table width='100%'><tr><td><div id='patch_downloads' class='ygrid-mso' style='height:205px;'></div></td></tr></table>
</div>

{literal}<script>
//PackageManager.toggleView('browse');
</script>
{/literal}
{/if}
{/if}
