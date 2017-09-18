<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


class MailMerge
{
	var $mm_data_dir;
	var $obj;
	var $datasource_file = 'ds.doc';
	var $header_file = 'header.doc';
	var $fieldcnt;
	var $rowcnt;
	var $template;
	var $visible = false;
	var $list;
	var $fieldList;

	function __construct($list = NULL, $fieldList = null, $data_dir = 'data') {
		// this is the path to your data dir.
		$this->mm_data_dir = $data_dir;
		$this->list = $list;
		$this->fieldList = $fieldList;
	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function MailMerge($list = NULL, $fieldList = null, $data_dir = 'data'){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct($list, $fieldList, $data_dir);
    }


	function Execute() {
		$this->Initialize();
		if( count( $this->list ) > 0 ) {
			if(isset($this->template)) {
				$this->CreateHeaderFile();
				$this->CreateDataSource();
				$file = $this->CreateDocument($this->template);
				return $file;
			}
		} else return '';
	}

	function Template($template = NULL) {
		if(is_array($template)) $this->template = $template;
	}

	function CleanUp() {
		//remove the temp files
		unlink($this->mm_data_dir.'/Temp/'.$this->datasource_file);
		unlink($this->mm_data_dir.'/Temp/'.$this->header_file);
		rmdir($this->mm_data_dir);
		rmdir($this->mm_data_dir.'/Temp/');
		$this->Quit();
	}

	function CreateHeaderFile() {
		$this->obj->Documents->Add();

		$this->obj->ActiveDocument->Tables->Add($this->obj->Selection->Range,1,$this->fieldcnt);
		foreach($this->fieldList as $key => $value) {
			$this->obj->Selection->TypeText($key);
			$this->obj->Selection->MoveRight();
		}

		$this->obj->ActiveDocument->SaveAs($this->mm_data_dir.'/Temp/'.$this->header_file);
		$this->obj->ActiveDocument->Close();
	}

	function CreateDataSource() {
		$this->obj->Documents->Add();
		$this->obj->ActiveDocument->Tables->Add($this->obj->Selection->Range,$this->rowcnt,$this->fieldcnt);

		for($i = 0; $i < $this->rowcnt; $i++) {
			foreach($this->fieldList as $field => $value)
         	{
				$this->obj->Selection->TypeText($this->list[$i]->$field);
				$this->obj->Selection->MoveRight();
			}
		}
		$this->obj->ActiveDocument->SaveAs($this->mm_data_dir.'/Temp/'.$this->datasource_file);
		$this->obj->ActiveDocument->Close();
	}

	function CreateDocument($template) {
		//$this->obj->Documents->Open($this->mm_data_dir.'/Templates/'.$template[0].'.dot');
		$this->obj->Documents->Open($template[0]);

		$this->obj->ActiveDocument->MailMerge->OpenHeaderSource($this->mm_data_dir.'/Temp/'.$this->header_file);

		$this->obj->ActiveDocument->MailMerge->OpenDataSource($this->mm_data_dir.'/Temp/'.$this->datasource_file);

		$this->obj->ActiveDocument->MailMerge->Execute();
		$this->obj->ActiveDocument->SaveAs($this->mm_data_dir.'/'.$template[1].'.doc');
		//$this->obj->Documents[$template[0]]->Close();
		//$this->obj->Documents[$template[1].'.doc']->Close();
		$this->obj->ActiveDocument->Close();
		return $template[1].'.doc';
	}

	function Initialize() {
		$this->rowcnt = count($this->list);
		$this->fieldcnt = count($this->fieldList);
		$this->obj = new COM("word.application") or die("Unable to instanciate Word");
		$this->obj->Visible = $this->visible;

		//try to make the temp dir
		sugar_mkdir($this->mm_data_dir);
		sugar_mkdir($this->mm_data_dir.'/Temp/');
	}

	function Quit() {
		$this->obj->Quit();
	}

	function SetDataList($list = NULL) {
		if(is_array($list)) $this->list = $list;
	}

	function SetFieldList($list = NULL) {
		if(is_array($list)) $this->fieldList = $list;
	}

}

?>
