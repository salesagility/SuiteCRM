{*

/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */



*}
<link rel="stylesheet" type="text/css" href="modules/ModuleBuilder/tpls/ListEditor.css" />
<table class="preview-content">
<td>

{counter start=0 name="groupCounter" print=false assign="groupCounter"}
{foreach from=$groups key='label' item='list'}
	{counter name="groupCounter"}
{/foreach}
{math assign="groupWidth" equation="100/$groupCounter-5"}

{counter start=0 name="slotCounter" print=false assign="slotCounter"}
{counter start=0 name="modCounter" print=false assign="modCounter"}

{foreach from=$groups key='label' item='list'}

<div style="float: left; border: 1px gray solid; padding:4px; margin-right:4px; margin-top: 8px; width:{$groupWidth}%;">
<h3 >{$label}</h3>
<ul>

{foreach from=$list key='key' item='value'}

<li name="width={$value.width}%" class='draggable' style='cursor:default;'>
    <table width='100%'>
    	<tr>
    		<td style="font-weight: bold;">{if !empty($value.label)}{sugar_translate label=$value.label module=$language}{else}{$key}{/if}</td>
    		<td>
                {* BEGIN SUGARCRM flav=pro ONLY *}
                {if isset($field_defs.$key.calculated) && $field_defs.$key.calculated}
                    {sugar_getimage name="SugarLogic/icon_calculated" alt=$mod_strings.LBL_CALCULATED ext=".png" other_attributes=''}
                {/if}
                {if isset($field_defs.$key.dependency) && $field_defs.$key.dependency}
                    {sugar_getimage name="SugarLogic/icon_dependent" alt=$mod_strings.LBL_DEPENDANT ext=".png" other_attributes=''}
                {/if}
                {* END SUGARCRM flav=pro ONLY *}
    		</td>
    	</tr>
    	<tr class='fieldValue' style='cursor:default;'>
    		{if empty($hideKeys)}<td>[{$key}]</td>{/if}
    		<td align="right" colspan="2"><span>{$value.width}</span><span>%</span></td>
    	</tr>
    </table>
</li>
{counter name="modCounter"}
{/foreach}

<li class='noBullet'>&nbsp;</li>

</ul>
</div>

{counter name="slotCounter"}
{/foreach}
</td>
</tr></table>


