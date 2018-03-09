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

{if !isset($config.enable_autocomplete) || $config.enable_autocomplete==false}

	<input type="hidden" id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}_multiselect"
	name="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}_multiselect" value="true">
	{multienum_to_array string={{sugarvar key='value' string=true}} default={{sugarvar key='default' string=true}} assign="values"}
	<select id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}"
	name="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}[]"
	multiple="true" size='{{$displayParams.size|default:6}}' style="width:150" title='{{$vardef.help}}' tabindex="{{$tabindex}}" {{$displayParams.field}} 
    {{if !empty($displayParams.accesskey)}} accesskey='{{$displayParams.accesskey}}' {{/if}}
 	{{if isset($displayParams.javascript)}}{{$displayParams.javascript}}{{/if}}>
	{html_options options={{sugarvar key='options' string=true}} selected=$values}
	</select>

{else}

	{assign var="field_options" value={{sugarvar key='options' string="true"}} }
	{capture name="field_val"}{{sugarvar key='value'}}{/capture}
	{assign var="field_val" value=$smarty.capture.field_val}
	{capture name="ac_key"}{{sugarvar key='name'}}{/capture}
	{assign var="ac_key" value=$smarty.capture.ac_key}

	{{if empty($vardef.autocomplete_ajax)}}
		<input type="hidden" id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}_multiselect"
		name="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}_multiselect" value="true">
		{multienum_to_array string={{sugarvar key='value' string=true}} default={{sugarvar key='default' string=true}} assign="values"}
		<select style='display:none' id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}"
		name="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}[]"
		multiple="true" size='{{$displayParams.size|default:6}}' style="width:150" title='{{$vardef.help}}' tabindex="{{$tabindex}}" {{$displayParams.field}} 
		{{if !empty($displayParams.accesskey)}} accesskey='{{$displayParams.accesskey}}' {{/if}}
        {{if isset($displayParams.javascript)}}{{$displayParams.javascript}}{{/if}}>
		{html_options options={{sugarvar key='options' string=true}} selected=$values}
		</select>

		<input
	    id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}-input"
	    name="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}-input"
	    size="60"
	    type="text" style="vertical-align: top;">
	{{else}}
		<input type="hidden"
		    id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}"
		    name="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}"
		    value="{{sugarvar key='value'}}">

		<input
		    id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}-input"
		    name="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}-input"
		    size="60"
		    type="text" style="vertical-align: top;">
	{{/if}}

	<span class="id-ff multiple">
	    <button type="button">
	    	<img src="{sugar_getimagepath file="id-ff-down.png"}" id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}-image">
	    	</button>
	    	<button type="button"
	        id="btn-clear-{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}-input"
	        title="Clear"
	        onclick="SUGAR.clearRelateField(this.form, '{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}-input', '{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}};');SUGAR.AutoComplete.{$ac_key}.inputNode.updateHidden()"><span class="suitepicon suitepicon-action-clear"></span></button>
	</span>

	{literal}
	<script>
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal} = [];
	{/literal}

	{{if empty($vardef.autocomplete_ajax)}}
		{literal}
		YUI().use('datasource', 'datasource-jsonschema', function (Y) {
					SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds = new Y.DataSource.Function({
					    source: function (request) {
					    	var selectElem = document.getElementById("{/literal}{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}{literal}");
					    	var ret = [];
					    	for (i=0;i<selectElem.options.length;i++)
					    		if (!(selectElem.options[i].value=='' && selectElem.options[i].innerHTML==''))
					    			ret.push({'key':selectElem.options[i].value,'text':selectElem.options[i].innerHTML});
					    	return ret;
					    }
					});
				});
		{/literal}
	{{else}}
		{literal}
		// Create a new YUI instance and populate it with the required modules.
		YUI().use('datasource', 'datasource-jsonschema', function (Y) {
			// DataSource is available and ready for use.
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds = new Y.DataSource.Get({
				source: 'index.php?module=Accounts&action=ajaxautocomplete&to_pdf=1'
			});
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds.plug(Y.Plugin.DataSourceJSONSchema, {
				schema: {
					resultListLocator: "option_items",
					resultFields: ["text", "key"],
					matchKey: "text",
				}
			});
		});
		{/literal}
	{{/if}}

	{literal}
	YUI().use("autocomplete", "autocomplete-filters", "autocomplete-highlighters","node-event-simulate", function (Y) {
		{/literal}
		
	    SUGAR.AutoComplete.{$ac_key}.inputNode = Y.one('#{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}-input');
	    SUGAR.AutoComplete.{$ac_key}.inputImage = Y.one('#{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}-image');
	    SUGAR.AutoComplete.{$ac_key}.inputHidden = Y.one('#{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}');

		{{if empty($vardef.autocomplete_ajax)}}
			SUGAR.AutoComplete.{$ac_key}.minQLen = 0;
			SUGAR.AutoComplete.{$ac_key}.queryDelay = 0;
			SUGAR.AutoComplete.{$ac_key}.numOptions = {$field_options|@count};
			if(SUGAR.AutoComplete.{$ac_key}.numOptions >= 300) {literal}{
				{/literal}
				SUGAR.AutoComplete.{$ac_key}.minQLen = 1;
				SUGAR.AutoComplete.{$ac_key}.queryDelay = 200;
				{literal}
			}
			{/literal}
			if(SUGAR.AutoComplete.{$ac_key}.numOptions >= 3000) {literal}{
				{/literal}
				SUGAR.AutoComplete.{$ac_key}.minQLen = 1;
				SUGAR.AutoComplete.{$ac_key}.queryDelay = 500;
				{literal}
			}
			{/literal}
		{{else}}
			SUGAR.AutoComplete.{$ac_key}.minQLen = 1;
			SUGAR.AutoComplete.{$ac_key}.queryDelay = 500;
		{{/if}}
		
		{{if empty($vardef.autocomplete_ajax)}}
		{literal}
	    SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.plug(Y.Plugin.AutoComplete, {
	        activateFirstItem: true,
	        allowTrailingDelimiter: true,
			{/literal}
	        minQueryLength: SUGAR.AutoComplete.{$ac_key}.minQLen,
	        queryDelay: SUGAR.AutoComplete.{$ac_key}.queryDelay,
	        queryDelimiter: ',',
	        zIndex: 99999,

			{{if !empty($vardef.autocomplete_ajax)}}
				requestTemplate: '&options={{$vardef.autocomplete_options}}&q={literal}{query}{/literal}',
			{{/if}}
			{literal}
			source: SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds,
			
	        resultTextLocator: 'text',
	        resultHighlighter: 'phraseMatch',
	        resultFilters: 'phraseMatch',
	        // Chain together a startsWith filter followed by a custom result filter
	        // that only displays tags that haven't already been selected.
	        resultFilters: ['phraseMatch', function (query, results) {
		        // Split the current input value into an array based on comma delimiters.
	        	var selected = SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value').split(/\s*,\s*/);
	        
	            // Convert the array into a hash for faster lookups.
	            selected = Y.Array.hash(selected);

	            // Filter out any results that are already selected, then return the
	            // array of filtered results.
	            return Y.Array.filter(results, function (result) {
	               return !selected.hasOwnProperty(result.text);
	            });
	        }]
	    });
		{/literal}{{else}}{literal}
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.plug(Y.Plugin.AutoComplete, {
	        activateFirstItem: true,
	        allowTrailingDelimiter: true,
			{/literal}
	        minQueryLength: SUGAR.AutoComplete.{$ac_key}.minQLen,
	        queryDelay: SUGAR.AutoComplete.{$ac_key}.queryDelay,
	        queryDelimiter: ',',
	        zIndex: 99999,
				requestTemplate: '&options={{$vardef.autocomplete_options}}&q={literal}{query}{/literal}',
			{literal}
			source: SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds,
			
	        resultTextLocator: 'text',
	        resultHighlighter: 'phraseMatch',
	        resultFilters: 'phraseMatch',
	        // Chain together a startsWith filter followed by a custom result filter
	        // that only displays tags that haven't already been selected.
	        resultFilters: ['phraseMatch', function (query, results) {
	            // Split the current input value into an array based on comma delimiters.
	            var selected = SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.get('value').split(/\s*,\s*/);

	            // Pop the last item off the array, since it represents the current query
	            // and we don't want to filter it out.
	            //selected.pop();

	            // Convert the array into a hash for faster lookups.
	            selected = Y.Array.hash(selected);

	            // Filter out any results that are already selected, then return the
	            // array of filtered results.
	            return Y.Array.filter(results, function (result) {
	               return !selected.hasOwnProperty(result.text);
	            });
	        }]
	    });
		{/literal}{{/if}}{literal}
		if({/literal}SUGAR.AutoComplete.{$ac_key}.minQLen{literal} == 0){
		    // expand the dropdown options upon focus
		    SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('focus', function () {
		        SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.sendRequest('');
		    });
		}

		{{if empty($vardef.autocomplete_ajax)}}
		    SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateHidden = function() {
				var index_array = SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value').split(/\s*,\s*/);

				var selectElem = document.getElementById("{/literal}{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}{literal}");

				var oTable = {};
		    	for (i=0;i<selectElem.options.length;i++){
		    		if (selectElem.options[i].selected)
		    			oTable[selectElem.options[i].value] = true;
		    	}

				for (i=0;i<selectElem.options.length;i++){
					selectElem.options[i].selected=false;
				}

				var nTable = {};

				for (i=0;i<index_array.length;i++){
					var key = index_array[i];
					for (c=0;c<selectElem.options.length;c++)
						if (selectElem.options[c].innerHTML == key){
							selectElem.options[c].selected=true;
							nTable[selectElem.options[c].value]=1;
						}
				}

				//the following two loops check to see if the selected options are different from before.
				//oTable holds the original select. nTable holds the new one
				var fireEvent=false;
				for (n in nTable){
					if (n=='')
						continue;
		    		if (!oTable.hasOwnProperty(n))
		    			fireEvent = true; //the options are different, fire the event
		    	}
		    	
		    	for (o in oTable){
		    		if (o=='')
		    			continue;
		    		if (!nTable.hasOwnProperty(o))
		    			fireEvent=true; //the options are different, fire the event
		    	}

		    	//if the selected options are different from before, fire the 'change' event
		    	if (fireEvent){
		    		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('change');
		    	}
		    };

		    SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateText = function() {
		    	//get last option typed into the input widget
		    	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.set(SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value'));
				var index_array = SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value').split(/\s*,\s*/);
				//create a string ret_string as a comma-delimited list of text from selectElem options.
				var selectElem = document.getElementById("{/literal}{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}{literal}");
				var ret_array = [];

                if (selectElem==null || selectElem.options == null)
					return;

				for (i=0;i<selectElem.options.length;i++){
					if (selectElem.options[i].selected && selectElem.options[i].innerHTML!=''){
						ret_array.push(selectElem.options[i].innerHTML);
					}
				}

				//index array - array from input
				//ret array - array from select

				var sorted_array = [];
				var notsorted_array = [];
				for (i=0;i<index_array.length;i++){
					for (c=0;c<ret_array.length;c++){
						if (ret_array[c]==index_array[i]){
							sorted_array.push(ret_array[c]);
							ret_array.splice(c,1);
						}
					}
				}
				ret_string = ret_array.concat(sorted_array).join(', ');
				if (ret_string.match(/^\s*$/))
					ret_string='';
				else
					ret_string+=', ';
				
				//update the input widget
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.set('value', ret_string);
		    };

		    function updateTextOnInterval(){
		    	if (document.activeElement != document.getElementById("{/literal}{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}-input{literal}"))
		    		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateText();
		    	setTimeout(updateTextOnInterval,100);
		    }

		    updateTextOnInterval();
		{{else}}
		    SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateHidden = function() {
				var index_array = SUGAR.MultiEnumAutoComplete.getMultiSelectKeysFromValues("{/literal}{{$vardef.autocomplete_options}}{literal}", SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value'));
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.set('value', index_array.join("^,^"));
		    };

		    SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateText = function() {
				var index_array = SUGAR.MultiEnumAutoComplete.getMultiSelectValuesFromKeys("{/literal}{{$vardef.autocomplete_options}}{literal}", SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.get('value'));
				if(index_array.length < 1){
					SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value', '');
				}
				else{
					SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value', index_array.join(", ") + ", ");
				}
		    };	
		    SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateText();
		{{/if}}

		{{if empty($vardef.autocomplete_ajax)}}
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('click', function(e) {
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('click');
			});
			
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('dblclick', function(e) {
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('dblclick');
			});

			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('focus', function(e) {
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('focus');
			});

			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('mouseup', function(e) {
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('mouseup');
			});

			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('mousedown', function(e) {
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('mousedown');
			});

			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('blur', function(e) {
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('blur');
			});
		{{/if}}

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('blur', function () {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateHidden();
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateText();
		});
	
	    // when they click on the arrow image, toggle the visibility of the options
	    SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputImage.on('click', function () {
			if({/literal}SUGAR.AutoComplete.{$ac_key}.minQLen{literal} == 0){
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.sendRequest('');
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.show();
			}
			else{
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.focus();
			}
	    });
	
		if({/literal}SUGAR.AutoComplete.{$ac_key}.minQLen{literal} == 0){
		    // After a tag is selected, send an empty query to update the list of tags.
		    SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.after('select', function () {
		      SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.sendRequest('');
		      SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.show();
			  SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateHidden();
			  SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateText();
		    });
		} else {
		    // After a tag is selected, send an empty query to update the list of tags.
		    SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.after('select', function () {
			  SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateHidden();
			  SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.updateText();
		    });
		}
	});
	</script>
	{/literal}
{/if}