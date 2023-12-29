{*
********************************************************************************
 Display the screen with to download the form or with the form itself in text format 
********************************************************************************
*}

{literal}
	<style>
		#subjectfield { height: 1.6em; }
		.charset_notice  { color:red; }
		.charset_headtag { color:#880000; }
		.charset_metatag { color:blue; }
		.edit {background-color: transparent !important; margin-top:30px !important;}
	</style>
{/literal}

{$JAVASCRIPT}

<form name="webforms" id="webforms" method="POST" action="index.php" enctype="multipart/form-data">
	<input type="hidden" name="module" id="module" value="{$MAP.MODULE}">
	<input type="hidden" name="action" id="action" value="{$MAP.ACTION}">

	<table style="width: 100%;">
	    <tr>
	        <td><h2>{$MOD.LBL_WEBFORMS_GENERATED}</h2></td>
	    </tr>
	</table>

	<table style="width: 100%;" class="edit view">
		<tr>
			<td>
			<table style="width: 100%; border: 0;">
				<tr>
					<td colspan=4>&nbsp;</td>
				</tr>
				<tr>
					<b>{$MOD.LBL_WEBFORMS_LINK_DESC} <a href="{$MAP.LINK_TO_WEB_FORM}">{$MOD[$MAP.DOWNLOAD_LABEL]}</a></b>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td>
				<b>{$MOD.LBL_COPY_AND_PASTE_CODE}</b>
	            <p>
	                <b><span class='charset_notice'>{$MOD.LBL_CHARSET_NOTICE}</span></b><br/>
	                <span class='charset_headtag'>
	                    &lt;head&gt;<br />
	                    ...<br />
	                </span>
	                <span class='charset_metatag'>
	                    &lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=UTF-8&quot;&gt;<br />
	                </span>
	                <span class='charset_headtag'>
	                    ...<br />
	                    &lt;/head&gt;<br />
	                </span>
	                <br />
	            </p>
				<textarea class="no-autosize"rows="6" cols="80">{$MAP.RAW_SOURCE|escape:"htmlall"}</textarea>
			</td>
		</tr>
	</table>
</form>
