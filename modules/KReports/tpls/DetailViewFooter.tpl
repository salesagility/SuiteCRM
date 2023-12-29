{*
/**
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * You can contact Christian Knoll at info@kreporter.org
 */
 *}

<input type="hidden" name="listfieldarray" id="listfieldarray" value="{$listfieldarray}">
<input type="hidden" name="listfields" id="listfields" value="{$fields.listfields.value}">
<input type="hidden" name="listtype" id="listtype" value="{$fields.listtype.value}">
<input type='hidden' name='listtypeproperties' id='listtypeproperties' value='{$fields.listtypeproperties.value}'>
<input type='hidden' name='reportoptions' id='reportoptions' value='{$reportoptions}'>
<input type='hidden' name='jsonlanguage' id='jsonlanguage' value='{$jsonlanguage}'>
<input type="hidden" name="recordid" id="recordid" value="{$fields.id.value}">

<link rel="stylesheet" type="text/css" href="custom/k/extjs4/resources/css/ext-all-gray.css" />
<link rel="stylesheet" type="text/css" href="custom/k/css/ext_override.css" />
<script type="text/javascript" src="custom/k/extjs4/ext-all{if $kreportDebug}-debug{/if}.js"></script>

{* any further variables we need *}
<script type='text/javascript'>{$jsVariables}</script>

<script type='text/javascript' src='modules/KReports/js/kreportsbase1{if $kreportDebug}_debug{/if}.js'></script>
<script type="text/javascript" src="modules/KReports/js/kreportsbase2{if $kreportDebug}_debug{/if}.js"></script>

{$integrationpluginjs}
{$visualizationpluginjs}
{$presentation}

{*$addViewJS*}
{*$viewJS*}

<script type="text/javascript" src="modules/KReports/js/kreportsbase4{if $kreportDebug}_debug{/if}.js"></script> 

<div id='reportMain' style="margin-left:0px; margin-right:10px">
<div id='toolbarArea'></div>
{if $dynamicoptions != ''}<div id='optionsArea' style='margin-top:5px;'></div>{/if}

{$visualization}

<div id='reportGrid' style='margin-top:5px;'>{$reportData}</div><br></div>
