{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
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
 */
*}

<div id="{{$module}}_detailview_tabs"
        {{if $useTabs}}
     class="yui-navset detailview_tabs"
        {{/if}}
>
    {{if $useTabs}}
    {* Generate the Tab headers *}
    {{counter name="tabCount" start=-1 print=false assign="tabCount"}}
    <ul class="nav nav-tabs">
        {{foreach name=section from=$sectionPanels key=label item=panel}}
        {{capture name=label_upper assign=label_upper}}{{$label|upper}}{{/capture}}
        {* override from tab definitions *}
        {{if (isset($tabDefs[$label_upper].newTab) && $tabDefs[$label_upper].newTab == true)}}
        {{counter name="tabCount" print=false}}
        <li role="presentation"><a id="tab{{$tabCount}}"
                                   href="javascript:void(0)"><em>{sugar_translate label='{{$label}}' module='{{$module}}'}</em></a>
        </li>
        {{/if}}
        {{/foreach}}
    </ul>
    {{/if}}
    <div {{if $useTabs}}class="tab-content"{{/if}}>
        {{* Loop through all top level panels first *}}
        {{counter name="panelCount" print=false start=0 assign="panelCount"}}
        {{counter name="tabCount" start=-1 print=false assign="tabCount"}}
        {{foreach name=section from=$sectionPanels key=label item=panel}}
        {{assign var='panel_id' value=$panelCount}}
        {{capture name=label_upper assign=label_upper}}{{$label|upper}}{{/capture}}
        {{if (isset($tabDefs[$label_upper].newTab) && $tabDefs[$label_upper].newTab == true)}}
        {{counter name="tabCount" print=false}}
        {{if $tabCount != 0}}</div>{{/if}}
    <div role="tabpanel" class="tab-pane" id='tabcontent{{$tabCount}}'>
        {{/if}}

        {{if ( isset($tabDefs[$label_upper].panelDefault) && $tabDefs[$label_upper].panelDefault == "collapsed" && isset($tabDefs[$label_upper].newTab) && $tabDefs[$label_upper].newTab == false) }}
        {{assign var='panelState' value=$tabDefs[$label_upper].panelDefault}}
        {{else}}
        {{assign var='panelState' value="expanded"}}
        {{/if}}
        <div id='detailpanel_{{$smarty.foreach.section.iteration}}' class='detail view  detail508 {{$panelState}}'>
            {counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
            {{* Print out the panel title if one exists*}}

{{* Check to see if the panel variable is an array, if not, we'll attempt an include with type param php *}}
{{* See function.sugar_include.php *}}
{{if !is_array($panel)}}
    {sugar_include type='php' file='{{$panel}}'}
{{else}}

    {{if !empty($label) && !is_int($label) && $label != 'DEFAULT' && (!isset($tabDefs[$label_upper].newTab) || (isset($tabDefs[$label_upper].newTab) && $tabDefs[$label_upper].newTab == false))}}
    <h4>
      <a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel({{$smarty.foreach.section.iteration}});">
      <img border="0" id="detailpanel_{{$smarty.foreach.section.iteration}}_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
      <a href="javascript:void(0)" class="expandLink" onclick="expandPanel({{$smarty.foreach.section.iteration}});">
      <img border="0" id="detailpanel_{{$smarty.foreach.section.iteration}}_img_show" src="{sugar_getimagepath file="advanced_search.gif"}"></a>
      {sugar_translate label='{{$label}}' module='{{$module}}'}
    {{if isset($panelState) && $panelState == 'collapsed'}}
    <script>
      document.getElementById('detailpanel_{{$smarty.foreach.section.iteration}}').className += ' collapsed';
    </script>
    {{else}}
    <script>
      document.getElementById('detailpanel_{{$smarty.foreach.section.iteration}}').className += ' expanded';
    </script>
    {{/if}}
    </h4>

    {{/if}}
	{{* Print out the table data *}}
  <table id='{{$label}}' class="panelContainer" cellspacing='{$gridline}'>



	{{foreach name=rowIteration from=$panel key=row item=rowData}}
	{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
	{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
	{capture name="tr" assign="tableRow"}
	<tr>
		{{assign var='columnsInRow' value=$rowData|@count}}
		{{assign var='columnsUsed' value=0}}
		{{foreach name=colIteration from=$rowData key=col item=colData}}
	    {{if !empty($colData.field.hideIf)}}
	    	{if !({{$colData.field.hideIf}}) }
	    {{/if}}
			{counter name="fieldsUsed"}
			{{if empty($colData.field.hideLabel)}}
			<td width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].label}}%' scope="col">
				{{if !empty($colData.field.name)}}
				    {if !$fields.{{$colData.field.name}}.hidden}
                {{/if}}
				{{if isset($colData.field.customLabel)}}
			       {{$colData.field.customLabel}}
				{{elseif isset($colData.field.label) && strpos($colData.field.label, '$')}}
				   {capture name="label" assign="label"}{{$colData.field.label}}{/capture}
			       {$label|strip_semicolon}:
				{{elseif isset($colData.field.label)}}
				   {capture name="label" assign="label"}{sugar_translate label='{{$colData.field.label}}' module='{{$module}}'}{/capture}
			       {$label|strip_semicolon}:
				{{elseif isset($fields[$colData.field.name])}}
				   {capture name="label" assign="label"}{sugar_translate label='{{$fields[$colData.field.name].vname}}' module='{{$module}}'}{/capture}
			       {$label|strip_semicolon}:
				{{else}}
				   &nbsp;
				{{/if}}
                {{if isset($colData.field.popupHelp) || isset($fields[$colData.field.name]) && isset($fields[$colData.field.name].popupHelp) }}
                   {{if isset($colData.field.popupHelp) }}
                     {capture name="popupText" assign="popupText"}{sugar_translate label="{{$colData.field.popupHelp}}" module='{{$module}}'}{/capture}
                   {{elseif isset($fields[$colData.field.name].popupHelp)}}
                     {capture name="popupText" assign="popupText"}{sugar_translate label="{{$fields[$colData.field.name].popupHelp}}" module='{{$module}}'}{/capture}
                   {{/if}}
                   {sugar_help text=$popupText WIDTH=400}
                {{/if}}
                {{if !empty($colData.field.name)}}
                {/if}
                {{/if}}
                {{/if}}
			</td>
			<td class="{{if $inline_edit && !empty($colData.field.name) && ($fields[$colData.field.name].inline_edit == 1 || !isset($fields[$colData.field.name].inline_edit))}}inlineEdit{{/if}}" type="{{$fields[$colData.field.name].type}}" field="{{$fields[$colData.field.name].name}}" width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].field}}%' {{if $colData.colspan}}colspan='{{$colData.colspan}}'{{/if}} {{if isset($fields[$colData.field.name].type) && $fields[$colData.field.name].type == 'phone'}}class="phone"{{/if}}>
			    {{if !empty($colData.field.name)}}
			    {if !$fields.{{$colData.field.name}}.hidden}
			    {{/if}}
				{{$colData.field.prefix}}
				{{if ($colData.field.customCode && !$colData.field.customCodeRenderField) || $colData.field.assign}}
					{counter name="panelFieldCount"}
					<span id="{{$colData.field.name}}" class="sugar_field">{{sugar_evalcolumn var=$colData.field colData=$colData}}</span>
				{{elseif $fields[$colData.field.name] && !empty($colData.field.fields) }}
				    {{foreach from=$colData.field.fields item=subField}}
				        {{if $fields[$subField]}}
				        	{counter name="panelFieldCount"}
				            {{sugar_field parentFieldArray='fields' tabindex=$tabIndex vardef=$fields[$subField] displayType='DetailView'}}&nbsp;

				        {{else}}
				        	{counter name="panelFieldCount"}
				            {{$subField}}
				        {{/if}}
				    {{/foreach}}
				{{elseif $fields[$colData.field.name]}}
					{counter name="panelFieldCount"}
					{{sugar_field parentFieldArray='fields' vardef=$fields[$colData.field.name] displayType='DetailView' displayParams=$colData.field.displayParams typeOverride=$colData.field.type}}

				{{/if}}
				{{if !empty($colData.field.customCode) && $colData.field.customCodeRenderField}}
				    {counter name="panelFieldCount"}
				    <span id="{{$colData.field.name}}" class="sugar_field">{{sugar_evalcolumn var=$colData.field colData=$colData}}</span>
                {{/if}}
				{{$colData.field.suffix}}
				{{if !empty($colData.field.name)}}
				{/if}
				{{/if}}

				{{if $inline_edit && !empty($colData.field.name) && ($fields[$colData.field.name].inline_edit == 1 || !isset($fields[$colData.field.name].inline_edit))}}<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>{{/if}}
			</td>
	    {{if !empty($colData.field.hideIf)}}
			{else}

			<td>&nbsp;</td><td>&nbsp;</td>
			{/if}
	    {{/if}}

		{{/foreach}}
	</tr>
	{/capture}
	{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
	{$tableRow}
	{/if}
	{{/foreach}}
	</table>
    {{if !empty($label) && !is_int($label) && $label != 'DEFAULT' && (!isset($tabDefs[$label_upper].newTab) || (isset($tabDefs[$label_upper].newTab) && $tabDefs[$label_upper].newTab == false))}}
    <script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() {ldelim} initPanel({{$smarty.foreach.section.iteration}}, '{{$panelState}}'); {rdelim}); </script>
    {{/if}}
{{/if}}
</div>
{if $panelFieldCount == 0}

<script>document.getElementById("{{$label}}").style.display='none';</script>
{/if}
{{/foreach}}
{{if $useTabs}}
  </div>
{{/if}}

</div>
</div>

