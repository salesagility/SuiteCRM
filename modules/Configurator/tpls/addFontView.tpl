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

<p>
{$MODULE_TITLE}
</p>
<form name="addFontView" enctype='multipart/form-data' method="POST" action="index.php?action=addFont&module=Configurator" onSubmit="return (check_form('addFontView'));">
<span class='error'>{$error}</span>
<br>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td style="padding-bottom: 2px;">
            <input title="{$MOD.LBL_ADD_FONT_BUTTON}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button"  type="submit"  name="save" value="  {$MOD.LBL_ADD_FONT_BUTTON}  " >
            &nbsp;<input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"  onclick="document.location.href='index.php?module=Configurator&action=FontManager'" class="button"  type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " >
        </td>
    </tr>
</table>
<br>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
        <tr>
            <td  scope="row">{$MOD.LBL_PDF_METRIC_FILE}: <span class="required">*</span>{sugar_help text=$MOD.LBL_PDF_METRIC_FILE_INFO} </td>
            <td>
                <input type='file' size='30' name='pdf_metric_file' id='pdf_metric_file'>
            </td>
            <td  scope="row"></td>
            <td></td>
        </tr>
        <tr>
            <td  scope="row">{$MOD.LBL_PDF_FONT_FILE}: <span class="required">*</span>{sugar_help text=$MOD.LBL_PDF_FONT_FILE_INFO} </td>
            <td>
                <input type='file' size='30' name='pdf_font_file' id='pdf_font_file'>
            </td>
            <td  scope="row"></td>
            <td></td>
        </tr>
        <tr>
            <td  scope="row">{$MOD.LBL_FONT_LIST_EMBEDDED}: <span class="required">*</span>{sugar_help text=$MOD.LBL_FONT_LIST_EMBEDDED_INFO} </td>
            <td>
                <input type="hidden" name='pdf_embedded' value='false'>
                <input type='checkbox' name='pdf_embedded' value='true' id='pdf_embedded' onchange="showCidInfo()" CHECKED>
            </td>
            <td  scope="row"></td>
            <td></td>
        </tr>
        <tr id="cidInfo" style="display:none">
            <td  scope="row">{$MOD.LBL_FONT_LIST_CIDINFO}: <span class="required">*</span>{sugar_help text=$MOD.LBL_FONT_LIST_CIDINFO_INFO} </td>
            <td>
                <textarea name='pdf_cidinfo' rows="4" cols="80" id="pdf_cidinfo"></textarea>
            </td>
            <td  scope="row"></td>
            <td></td>
        </tr>
        <tr>
            <td  scope="row">{$MOD.LBL_PDF_ENCODING_TABLE}: <span class="required">*</span>{sugar_help text=$MOD.LBL_PDF_ENCODING_TABLE_INFO} </td>
            <td>
                {html_options name="pdf_encoding_table" options=$ENCODING_TABLE}
            </td>
            <td  scope="row"></td>
            <td></td>
        </tr>
        <tr>
            <td  scope="row">{$MOD.LBL_PDF_PATCH}:{sugar_help text=$MOD.LBL_PDF_PATCH_INFO} </td>
            <td>
                <textarea size='60' name='pdf_patch' id='pdf_patch' rows="4" cols="80"></textarea>
            </td>
            <td  scope="row"></td>
            <td></td>
        </tr>
        <tr>
            <td  scope="row">{$MOD.LBL_FONT_LIST_STYLE}: <span class="required">*</span>{sugar_help text=$MOD.LBL_FONT_LIST_STYLE_INFO} </td>
            <td>
                {html_options name="pdf_style_list" options=$STYLE_LIST}
            </td>
            <td  scope="row"></td>
            <td></td>
        </tr>
    </table>
<br>
<div style="padding-top: 2px;">
<input title="{$MOD.LBL_ADD_FONT_BUTTON}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button"  type="submit"  name="save" value="  {$MOD.LBL_ADD_FONT_BUTTON}  " >
&nbsp;<input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"  onclick="document.location.href='index.php?module=Configurator&action=FontManager'" class="button"  type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " />
</div>
</form>
{literal}
<script type='text/javascript'>
function checkFileExtension(metric){
    if(metric){
        var element = document.getElementById("pdf_metric_file");
    }else{
    	var element = document.getElementById("pdf_font_file");
    }
    if(element.value != ""){
        var error=true;
		var filename = element.value;
	    var dot = filename.lastIndexOf(".");
	    if( dot != -1 ){
    	    var extension = filename.substr(dot,filename.length);
            if(!metric){
        	    if(extension==".ttf" || extension==".otf" || extension==".pfb") error=false;
            }else{
                if(extension==".afm" || extension==".ufm") error=false;
            }
	    }
        if(error){
        	element.value="";
            {/literal}
            alert("{$MOD.JS_ALERT_PDF_WRONG_EXTENSION}");
            {literal}
        }
	}
}
function showCidInfo(){
    if(document.getElementById("pdf_embedded").checked == false){
        document.getElementById("cidInfo").style.display = "";
        addToValidate('addFontView', 'pdf_cidinfo', 'varchar', 1,'{/literal}{$MOD.LBL_FONT_LIST_CIDINFO}{literal}' );
    }else{
        document.getElementById("cidInfo").style.display = "none";
        removeFromValidate('addFontView', 'pdf_cidinfo');
    }
}
document.getElementById('pdf_metric_file').onchange=function(){checkFileExtension(true);};
document.getElementById('pdf_font_file').onchange=function(){checkFileExtension(false);};
{/literal}
addToValidate('addFontView', 'pdf_metric_file', 'varchar', 1,'{$MOD.LBL_PDF_METRIC_FILE}' );
addToValidate('addFontView', 'pdf_font_file', 'varchar', 1,'{$MOD.LBL_PDF_FONT_FILE}' );
showCidInfo();
</script>
