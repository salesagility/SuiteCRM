<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');

class AOK_KnowledgeBaseViewEdit extends ViewEdit
{
    function AOK_KnowledgeBaseViewEdit()
    {
        parent::ViewEdit();
    }

    function display()
    {
        parent::display();
        $this->displayTMCE();
    }


    function displayTMCE(){
        require_once("include/SugarTinyMCE.php");
        global $locale;

        $tiny = new SugarTinyMCE();
        $tinyMCE = $tiny->getConfig();

        $js =<<<JS
		<script language="javascript" type="text/javascript">
		$tinyMCE
		var df = '{$locale->getPrecedentPreference('default_date_format')}';

 		tinyMCE.init({
    		theme : "advanced",
    		theme_advanced_toolbar_align : "left",
    		mode: "exact",
			elements : "description",
			theme_advanced_toolbar_location : "top",
			theme_advanced_buttons1: "code,help,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,forecolor,backcolor,separator,styleprops,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,selectall,separator,search,replace,separator,bullist,numlist,separator,outdent,indent,separator,ltr,rtl,separator,undo,redo,separator, link,unlink,anchor,separator,sub,sup,separator,charmap,visualaid",
			theme_advanced_buttons3: "tablecontrols,separator,advhr,hr,removeformat,separator,insertdate,pagebreak",
			theme_advanced_fonts:"Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Helvetica Neu=helveticaneue,sans-serif;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
			plugins : "advhr,insertdatetime,table,paste,searchreplace,directionality,style,pagebreak",
			height:"auto",
			width: "auto",
			inline_styles : true,
			directionality : "ltr",
			remove_redundant_brs : true,
			entity_encoding: 'raw',
			cleanup_on_startup : true,
			strict_loading_mode : true,
			convert_urls : false,
			plugin_insertdate_dateFormat : '{DATE '+df+'}',
			pagebreak_separator : "<pagebreak />",
			extended_valid_elements : "textblock",
			custom_elements: "textblock",
		});
		</script>

JS;
        echo $js;
    }


}