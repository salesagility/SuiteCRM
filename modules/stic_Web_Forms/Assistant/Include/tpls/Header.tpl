{*
***************************************************
 Common header for all steps of the wizard
***************************************************
*}

<link rel="stylesheet" type="text/css" href="include/javascript/yui/build/datatable/assets/skins/sam/datatable.css?v={$VERSION_MARK}">
<script type="text/javascript" src="modules/stic_Web_Forms/Assistant/Include/javascript/WebFormGrid.js?v={$VERSION_MARK}"></script>

<form id="webforms" name="webforms" method="{$MAP.METHOD|default:"POST"}" action="{$MAP.URL}" enctype="{$MAP.ENCTYPE|default:"application/x-www-form-urlencoded"}">
	<input type="hidden" name="webFormClass" id="webFormClass" value="{$MAP.WEBFORMCLASS}">
    <input type="hidden" name="module" id="module" value="{$MAP.MODULE}">
	<input type="hidden" name="action" id="action" value="{$MAP.ACTION}">    
	<input type="hidden" name="return_module" id="return_module" value="{$MAP.RETURN_MODULE}">
	<input type="hidden" name="return_id" id="return_id" value="{$MAP.RETURN_ID}">
	<input type="hidden" name="return_action" id="return_action" value="{$MAP.RETURN_ACTION}">
	<input type="hidden" name="selection_module_name" id="selection_module_name" value="{$MAP.SELECTION_MODULE_NAME}">
	<textarea style="display:none" name="persistentData" id="persistentData">{$MAP.JSON_PERSISTENT_DATA}</textarea>
	<input type="hidden" name="prev_step" id="prev_step" value="{$MAP.PREV_STEP}">
	<input type="hidden" name="back_step" id="back_step" value="{$MAP.BACK_STEP}">
	<input type="hidden" name="step" id="step" value="{$MAP.STEP}">	
	