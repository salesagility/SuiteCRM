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
<script src="{if $smarty.server.HTTPS === 'on'}index.php?entryPoint=get_url&type=linkedin{else}{{$config.properties.company_url}}{/if}" type="text/javascript"></script>
<script type="text/javascript" src="{sugar_getjspath file='include/connectors/formatters/default/company_detail.js'}"></script>
{literal}
<style type="text/css">
.yui-panel .hd {
	background-color:#3D77CB;
	border-color:#FFFFFF #FFFFFF #000000;
	border-style:solid;
	border-width:1px;
	color:#000000;
	font-size:100%;
	font-weight:bold;
	line-height:100%;
	padding:4px;
	white-space:nowrap;
}
</style>
{/literal}
<script type="text/javascript">
function show_ext_rest_linkedin(event)
{literal} 
{

var xCoordinate = event.clientX;
var yCoordinate = event.clientY;
var isIE = document.all?true:false;
      
if(isIE) {
    xCoordinate = xCoordinate + document.body.scrollLeft;
    yCoordinate = yCoordinate + document.body.scrollTop;
}

{/literal}

cd = new CompanyDetailsDialog("linkedin_popup_div", '<div id="linkedin_div"></div>', xCoordinate, yCoordinate);
cd.setHeader("{$fields.{{$mapping_name}}.value}");
cd.display();
linked_in_popup = new LinkedIn.CompanyInsiderBox("linkedin_div", "{$fields.{{$mapping_name}}.value}");
{literal}
} 
{/literal}
</script>
