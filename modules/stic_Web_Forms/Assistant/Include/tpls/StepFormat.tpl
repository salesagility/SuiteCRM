{*
********************************************************************************
 Show the generated form for editing your format 
********************************************************************************
*}

{literal}
	<style>
		.edit {background-color: transparent !important;  margin-top:30px !important;}
	</style>
{/literal}

{$MAP.JAVASCRIPT}

<script type="text/javascript">
	{$MAP.FIELD_DEFS_JS}
</script>

<table width="100%">
    <tr>
        <td><h2>{$MOD.LBL_WEBFORMS_FORMAT}</h2></td>
        <td align="right" nowrap><span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span> {$APP.NTC_REQUIRED}</td>
    </tr>
</table>

<table width="100%" class="edit view">
	<tr>
		<td>
			<table width="100%">
				<tr>
					<td>
						<textarea id="bodyHTML" name="bodyHTML" cols="100" rows="40">{include file="$INCLUDE_TEMPLATE_DIR/FormToFormat.tpl"}</textarea>
	                </td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table width="100%">
    <tr>
		<td nowrap><span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span> {$APP.NTC_REQUIRED}</td>
	</tr>
	<tr>
		<td  style="padding: 40px 0px;">
			<input title="{$APP.LBL_BACK}" accessKey="{$APP.LBL_BACK}" class="button" onclick="return back('webforms');" type="submit" name="button" value="{$APP.LBL_BACK}"> 
   			<input title="{$APP.LBL_GENERATE_WEB_TO_LEAD_FORM}" class="button" type="submit" name="button" value="{$APP.LBL_GENERATE_WEB_TO_LEAD_FORM}"		
		</td>
	</tr>
</table>

{$MAP.TINY}
