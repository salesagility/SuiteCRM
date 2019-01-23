<?php
// NOTE => Defining the field definition 
require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');
class SugarFieldWysiwyg extends SugarFieldBase {

  function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
      $vardef['inline_edit'] = false;
    return parent::getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
    }

  function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
      require_once('include/SugarTinyMCE.php');
      global $json;
    
    if(empty($json)) {
      $json = getJSONobj();
    }
    $form_name = '';
    if(!empty($this->ss->_tpl_vars['displayParams']['formName']))
        $form_name = $this->ss->_tpl_vars['displayParams']['formName'];
    $tiny = new SugarTinyMCE();
    $tiny->buttonConfigs['default']['buttonConfig2'] = "cut,copy,paste,pastetext,pasteword,selectall,separator,search,replace,separator,bullist,numlist,separator,outdent,indent,separator,ltr,rtl,separator,undo,redo,separator,link,unlink,anchor,separator,sub,sup,separator,charmap,visualaid";
    $tiny->buttonConfigs['default']['buttonConfig3'] = "tablecontrols,separator,hr,removeformat,separator,insertdate,inserttime,separator";
    $tiny->defaultConfig['apply_source_formatting']=false;
    $tiny->defaultConfig['cleanup_on_startup']=true;
    $tiny->defaultConfig['relative_urls']=false;
    $tiny->defaultConfig['convert_urls']=false;
    $tiny->defaultConfig['strict_loading_mode'] = true;
    $tiny->defaultConfig['width'] = '100%';
    $config = $tiny->defaultConfig;
    $config['plugins']  = 'print code preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists textcolor wordcount imagetools    contextmenu colorpicker textpattern ';
    //$config['plugins']  = 'insertdatetime,table,preview,paste,searchreplace,directionality,textcolor';
    $config['elements'] = "#{$form_name} "."#".$vardef['name'];
    $config['selector'] = "#{$form_name} "."#".$vardef['name'];
    
    $config['content_css'] = 'include/javascript/mozaik/vendor/tinymce/tinymce/skins/lightgray/content.min.css';
    $config['toolbar1']   = 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat';
    $config['theme'] = 'modern';
    
  //  $config['theme_advanced_buttons1'] = $tiny->buttonConfigs['default']['buttonConfig']; 
   // $config['theme_advanced_buttons2'] = $tiny->buttonConfigs['default']['buttonConfig2']; 
   // $config['theme_advanced_buttons3'] = $tiny->buttonConfigs['default']['buttonConfig3']; 
    //$config['oninit'] =myfunction;
    $jsConfig = $json->encode($config);
    //$initiate = '<script type="text/javascript" language="Javascript">if(typeof(tinyMCE) != "undefined")tinyMCE.remove(); tinyMCE.init('.$jsConfig.');</script>';
    $initiate = '<script type="text/javascript" language="Javascript"> tinyMCE.init('.$jsConfig.');</script>';
    $this->ss->assign("tiny", $initiate);
    return parent::getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
    }
}
?>