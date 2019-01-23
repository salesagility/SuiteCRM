<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
// NOTE => field type
require_once('modules/DynamicFields/templates/Fields/TemplateField.php');
class TemplateWysiwyg extends TemplateField{
	var $type = 'wysiwyg';
	var $len = '';
    var $inline_edit = 0;

	function get_field_def(){

		$def = parent::get_field_def();
        
		//IF WE HAVE A DEFAULT VALUE SET IT
		$def['default'] = !empty( $this->default) ? $this->default : $this->default_value;
		//STILL HAVE THE DB THINK OF THE FIELD AS A text
		$def['dbType'] = 'text';
        $this->inline_edit =  0;
        $def['inline_edit'] = 0;
		return $def;
	}
}


?>