<?php
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



require_once('include/TemplateHandler/TemplateHandler.php');
require_once('include/EditView/SugarVCR.php');

/**
 * New EditView
 * @api
 */
class EditView
{
    public $th;
    public $tpl;
    public $notes;
    public $id;
    public $metadataFile;
    public $headerTpl;
    public $footerTpl;
    public $returnAction;
    public $returnModule;
    public $returnId;
    public $isDuplicate;
    public $focus;
    public $module;
    public $fieldDefs;
    public $sectionPanels;
    public $view = 'EditView';
    public $formatFields = true;
    public $showDetailData = true;
    public $showVCRControl = true;
    public $showSectionPanelsTitles = true;
    public $quickSearchCode;
    public $ss;
    public $offset = 0;
    public $populateBean = true;
    public $moduleTitleKey;
    public $viewObject = null;
    public $formName = '';

    /**
     * EditView constructor
     * This is the EditView constructor responsible for processing the new
     * Meta-Data framework
     *
     * @param $module String value of module this Edit view is for
     * @param $focus An empty sugarbean object of module
     * @param $id The record id to retrieve and populate data for
     * @param $metadataFile String value of file location to use in overriding default metadata file
     * @param tpl String value of file location to use in overriding default Smarty template
     * @param createFocus bool value to tell whether to create a new bean if we do not have one with an id, this is used from ConvertLead
     *
     */
    function setup($module, $focus = null, $metadataFile = null, $tpl = 'include/EditView/EditView.tpl', $createFocus = true)
    {
        $this->th = $this->getTemplateHandler();
        $this->th->ss =& $this->ss;
        $this->tpl = $tpl;
        $this->module = $module;
        $this->focus = $focus;

        //this logic checks if the focus has an id and if it does not then it will create a new instance of the focus bean
        //but in convert lead we do not want to create a new instance and do not want to populate id.
        if ($createFocus)
        {
            $this->createFocus();
        }

        if (empty($GLOBALS['sugar_config']['showDetailData']))
        {
            $this->showDetailData = false;
        }
        $this->metadataFile = $metadataFile;

        if (isset($GLOBALS['sugar_config']['disable_vcr']))
        {
           $this->showVCRControl = !$GLOBALS['sugar_config']['disable_vcr'];
        }

        if (!empty($this->metadataFile) && file_exists($this->metadataFile))
        {
            include($this->metadataFile);
        }
        else
        {
            //If file doesn't exist we create a best guess
            if (!file_exists("modules/$this->module/metadata/editviewdefs.php")
                && file_exists("modules/$this->module/EditView.html"))
            {
                require_once('include/SugarFields/Parsers/EditViewMetaParser.php');

                global $dictionary;

                $htmlFile = "modules/" . $this->module . "/EditView.html";
                $parser = new EditViewMetaParser();
                if (!file_exists('modules/'.$this->module.'/metadata'))
                {
                   sugar_mkdir('modules/'.$this->module.'/metadata');
                }

                $fp = sugar_fopen('modules/'.$this->module.'/metadata/editviewdefs.php', 'w');
                fwrite($fp, $parser->parse($htmlFile, $dictionary[$focus->object_name]['fields'], $this->module));
                fclose($fp);
            }

            //Flag an error... we couldn't create the best guess meta-data file
            if (!file_exists("modules/$this->module/metadata/editviewdefs.php"))
            {
                global $app_strings;

                $error = str_replace("[file]", "modules/$this->module/metadata/editviewdefs.php", $app_strings['ERR_CANNOT_CREATE_METADATA_FILE']);
                $GLOBALS['log']->fatal($error);
                echo $error;
                die();
            }

            require("modules/$this->module/metadata/editviewdefs.php");
        }

        $this->defs = $viewdefs[$this->module][$this->view];
        $this->isDuplicate = isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true' && $this->focus->aclAccess('edit');
    }

    function createFocus()
    {
        global $beanList, $beanFiles;

        if (empty($beanList[$this->module])) return;
        if(!$this->focus )
        {
           $bean = $beanList[$this->module];
           require_once($beanFiles[$bean]);
           $obj = new $bean();
           $this->focus = $obj;
        }

        //If there is no idea, assume we are creating a new instance
        //and call the fill_in_additional_detail_fields where initialization
        //code has been moved to
        if (empty($this->focus->id))
        {
            global $current_user;

            $this->focus->fill_in_additional_detail_fields();
            $this->focus->assigned_user_id = $current_user->id;
        }
    }

    function populateBean()
    {
        if (!empty($_REQUEST['record']) && $this->populateBean)
        {
           global $beanList;

           $bean = $beanList[$this->module];
           $obj = new $bean();
           $this->focus = $obj->retrieve($_REQUEST['record']);
        }
        else
        {
           $GLOBALS['log']->debug("Unable to populate bean, no record parameter found");
        }
    }

    /**
     * enableFormatting
     * This method is used to manually turn on/off the field formatting
     * @param $format boolean value to turn on/off field formatting
     */
    function enableFormatting($format = true)
    {
        $this->formatFields = $format;
    }

    /**
     * Enter description here ...
     */
    function requiredFirst()
    {
        $panels = array('required'=>array());
        $reqCol = -1;
        $reqRow = 0;
        foreach($this->defs['panels'] as $key=>$p)
        {
            foreach ($p as $row=>$rowDef)
            {
                foreach($rowDef as $col => $colDef)
                {
                    $field = (is_array($p[$row][$col])) ? $p[$row][$col]['name'] : $p[$row][$col];
                    if ((!empty($this->focus->field_defs[$field])
                        && !empty($this->focus->field_defs[$field]['required']))
                            || (!empty($p[$row][$col]['displayParams']['required'])))
                    {
                        $reqCol++;
                        if ($reqCol == $this->defs['templateMeta']['maxColumns'])
                        {
                            $reqCol = -1;
                            $reqRow++;
                        }

                        $panels['required'][$reqRow][$reqCol] = $p[$row][$col];
                    }
                    else
                    {
                        $panels[$key][$row][$col] = $p[$row][$col];
                    }
                }
            }
        }

        $this->defs['panels'] = $panels;
    }

    function render()
    {
        $totalWidth = 0;
        foreach ($this->defs['templateMeta']['widths'] as $col => $def) {
            foreach ($def as $k => $value) {
                $totalWidth += $value;
            }
        }

        // calculate widths
        foreach ($this->defs['templateMeta']['widths'] as $col => $def) {
            foreach ($def as $k => $value) {
                $this->defs['templateMeta']['widths'][$col][$k] = round($value / ($totalWidth / 100), 2);
            }
        }

        $this->sectionPanels = array();
        $this->sectionLabels = array();
        if (!empty($this->defs['panels']) && count($this->defs['panels']) > 0)
        {
           $keys = array_keys($this->defs['panels']);
           if (is_numeric($keys[0]))
           {
               $defaultPanel = $this->defs['panels'];
               unset($this->defs['panels']); //blow away current value
               $this->defs['panels'][''] = $defaultPanel;
           }
        }

        if ($this->view == 'EditView' && !empty($GLOBALS['sugar_config']['forms']['requireFirst'])){
            $this->requiredFirst();
        }

        $maxColumns = isset($this->defs['templateMeta']['maxColumns']) ? $this->defs['templateMeta']['maxColumns'] : 2;
        $panelCount = 0;
        static $itemCount = 100; //Start the generated tab indexes at 100 so they don't step on custom ones.

        /* loop all the panels */
        foreach ($this->defs['panels'] as $key=>$p)
        {
            $panel = array();

            if (!is_array($this->defs['panels'][$key])) {
               $this->sectionPanels[strtoupper($key)] = $p;
            }
            else
            {
                foreach ($p as $row=>$rowDef)
                {
                    $columnsInRows = count($rowDef);
                    $columnsUsed = 0;
                    foreach ($rowDef as $col => $colDef)
                    {
                        $panel[$row][$col] = is_array($p[$row][$col])
                            ? array('field' => $p[$row][$col])
                            : array('field' => array('name'=>$p[$row][$col]));

                        $panel[$row][$col]['field']['tabindex'] =
                            (isset($p[$row][$col]['tabindex']) && is_numeric($p[$row][$col]['tabindex']))
                                ? $p[$row][$col]['tabindex']
                                : '0';

                        if ($columnsInRows < $maxColumns)
                        {
                            if ($col == $columnsInRows - 1)
                            {
                                $panel[$row][$col]['colspan'] = 2 * $maxColumns - ($columnsUsed + 1);
                            }
                            else
                            {
                                $panel[$row][$col]['colspan'] = floor(($maxColumns * 2 - $columnsInRows) / $columnsInRows);
                                $columnsUsed = $panel[$row][$col]['colspan'];
                            }
                        }

                        //Set address types to have colspan value of 2 if colspan is not already defined
                        if (is_array($colDef) && !empty($colDef['hideLabel']) && !isset($panel[$row][$col]['colspan']))
                        {
                            $panel[$row][$col]['colspan'] = 2;
                        }

                        $itemCount++;

                    }
                }

			    	$panel = $this->getPanelWithFillers($panel);

			    	$this->sectionPanels[strtoupper($key)] = $panel;
		        }


		$panelCount++;
		} //foreach
    }

    /**
     * Adds fillers to each row if required
     *
     * Panel alignment will be off if the panel doesn't have a row with the max column
     * It will not be aligned to the other panels so we fill out the columns in the last row
     *
     * @param array $panel
     * @return array
     */
    protected function getPanelWithFillers($panel)
    {
        $addFiller = true;
        foreach($panel as $row)
        {
            if (count($row) == $this->defs['templateMeta']['maxColumns']
                || 1 == count($panel))
            {
                $addFiller = false;
                break;
            }
        }

        if ($addFiller)
        {
            $rowCount = count($panel);
            $filler   = count($panel[$rowCount-1]);
            while ($filler < $this->defs['templateMeta']['maxColumns'])
            {
                $panel[$rowCount - 1][$filler++] = array('field' => array('name' => ''));
            }
        }

        return $panel;
    }

    function process($checkFormName = false, $formName = '')
    {
        global $mod_strings, $sugar_config, $app_strings, $app_list_strings;

        //the retrieve already did this work;
        //$this->focus->fill_in_relationship_fields();
        //Bug#53261: If quickeditview is loaded after editview.tpl is created,
        //           the th->checkTemplate will return true. So, the following
        //           code prevent avoid rendering popup editview container.
        if(!empty($this->formName)) {
            $formName = $this->formName;
            $checkFormName = true;
        }

        if (!$this->th->checkTemplate($this->module, $this->view, $checkFormName, $formName))
        {
            $this->render();
        }

        if (isset($_REQUEST['offset']))
        {
            $this->offset = $_REQUEST['offset'] - 1;
        }

        if ($this->showVCRControl)
        {
            $this->th->ss->assign('PAGINATION', SugarVCR::menu($this->module, $this->offset, $this->focus->is_AuditEnabled(), ($this->view == 'EditView')));
        }

        if (isset($_REQUEST['return_module'])) $this->returnModule = $_REQUEST['return_module'];
        if (isset($_REQUEST['return_action'])) $this->returnAction = $_REQUEST['return_action'];
        if (isset($_REQUEST['return_id'])) $this->returnId = $_REQUEST['return_id'];
        if (isset($_REQUEST['return_relationship'])) $this->returnRelationship = $_REQUEST['return_relationship'];
        if (isset($_REQUEST['return_name'])) $this->returnName = $this->getValueFromRequest($_REQUEST, 'return_name' ) ;

        // handle Create $module then Cancel
        if (empty($this->returnId))
        {
            $this->returnAction = 'index';
        }

        $is_owner = $this->focus->isOwner($GLOBALS['current_user']->id);

        $this->fieldDefs = array();
        if ($this->focus)
        {
            global $current_user;

            if (!empty($this->focus->assigned_user_id))
            {
                $this->focus->assigned_user_name = get_assigned_user_name($this->focus->assigned_user_id);
            }

            if (!empty($this->focus->job) && $this->focus->job_function == '')
            {
                $this->focus->job_function = $this->focus->job;
            }

            foreach ($this->focus->toArray() as $name => $value)
            {
                $valueFormatted = false;
                //if ($this->focus->field_defs[$name]['type']=='link')continue;

                $this->fieldDefs[$name] = (!empty($this->fieldDefs[$name]) && !empty($this->fieldDefs[$name]['value']))
                    ? array_merge($this->focus->field_defs[$name], $this->fieldDefs[$name])
                    : $this->focus->field_defs[$name];

                foreach (array("formula", "default", "comments", "help") as $toEscape)
                {
                    if (!empty($this->fieldDefs[$name][$toEscape]))
                    {
                        $this->fieldDefs[$name][$toEscape] = htmlentities($this->fieldDefs[$name][$toEscape], ENT_QUOTES, 'UTF-8');
                    }
                }

                if (isset($this->fieldDefs[$name]['options']) && isset($app_list_strings[$this->fieldDefs[$name]['options']]))
                {
                    if(isset($GLOBALS['sugar_config']['enable_autocomplete']) && $GLOBALS['sugar_config']['enable_autocomplete'] == true)
                    {
						$this->fieldDefs[$name]['autocomplete'] = true;
	                	$this->fieldDefs[$name]['autocomplete_options'] = $this->fieldDefs[$name]['options']; // we need the name for autocomplete
					} else {
                        $this->fieldDefs[$name]['autocomplete'] = false;
                   	}
                   	// Bug 57472 - $this->fieldDefs[$name]['autocomplete_options' was set too late, it didn't retrieve the list's name, but the list itself (the developper comment show us that developper expected to retrieve list's name and not the options array)
                   	$this->fieldDefs[$name]['options'] = $app_list_strings[$this->fieldDefs[$name]['options']];
                }

                if(isset($this->fieldDefs[$name]['options']) && is_array($this->fieldDefs[$name]['options']) && isset($this->fieldDefs[$name]['default_empty']) && !isset($this->fieldDefs[$name]['options'][$this->fieldDefs[$name]['default_empty']])) {
                    $this->fieldDefs[$name]['options'] = array_merge(array($this->fieldDefs[$name]['default_empty']=>$this->fieldDefs[$name]['default_empty']), $this->fieldDefs[$name]['options']);
                }
                                
	       	 	if(isset($this->fieldDefs[$name]['function'])) {
	       	 		$function = $this->fieldDefs[$name]['function'];
	       			if(is_array($function) && isset($function['name'])){
	       				$function = $this->fieldDefs[$name]['function']['name'];
	       			}else{
	       				$function = $this->fieldDefs[$name]['function'];
	       			}

                    if(isset($this->fieldDefs[$name]['function']['include']) && file_exists($this->fieldDefs[$name]['function']['include']))
                    {
                  		require_once($this->fieldDefs[$name]['function']['include']);
                  	}

	       	 		if(!empty($this->fieldDefs[$name]['function']['returns']) && $this->fieldDefs[$name]['function']['returns'] == 'html'){
						if(!empty($this->fieldDefs[$name]['function']['include'])){
								require_once($this->fieldDefs[$name]['function']['include']);
						}
						$value = call_user_func($function, $this->focus, $name, $value, $this->view);
						$valueFormatted = true;
					}else{
						$this->fieldDefs[$name]['options'] = call_user_func($function, $this->focus, $name, $value, $this->view);
					}
	       	 	}

	       	 	if(isset($this->fieldDefs[$name]['type']) && $this->fieldDefs[$name]['type'] == 'function' && isset($this->fieldDefs[$name]['function_name'])){
	       	 		$value = $this->callFunction($this->fieldDefs[$name]);
	       	 		$valueFormatted = true;
	       	 	}

	       	 	if(!$valueFormatted) {
                    // $this->focus->format_field($this->focus->field_defs[$name]);
                   $value = isset($this->focus->$name) ? $this->focus->$name : '';
                }

                if (empty($this->fieldDefs[$name]['value']))
                {
                    $this->fieldDefs[$name]['value'] = $value;
                }


                //This code is used for QuickCreates that go to Full Form view.  We want to overwrite the values from the bean
                //with values from the request if they are set and either the bean is brand new (such as a create from a subpanels) or the 'full form' button has been clicked
                if ((($this->populateBean && empty($this->focus->id)) || (isset($_REQUEST['full_form'])))
                    && (!isset($this->fieldDefs[$name]['function']['returns']) || $this->fieldDefs[$name]['function']['returns'] != 'html')
                    && isset($_REQUEST[$name]))
                {
                    $this->fieldDefs[$name]['value'] = $this->getValueFromRequest($_REQUEST, $name);
                }

               /*
                * Populate any relate fields that are linked by a relationship to the calling module.
                * Clicking the create button on a subpanel for example will populate three values in the $_REQUEST:
                * 1. return_module => the name of the calling module
                * 2. return_id => the id of the record in the calling module that the user was viewing and that should be associated with this new record
                * 3. return_name => the display value of the return_id record - the value to show in any relate field in this EditView
                * Only do if this fieldDef does not already have a value; if it does it will have been explicitly set, and that should overrule this less specific mechanism
                */
                if (isset($this->returnModule) && isset($this->returnName)
                    && empty($this->focus->id) && empty($this->fieldDefs['name']['value']) )
                {
                   if (($this->focus->field_defs[$name]['type'] == 'relate')
                       && isset($this->focus->field_defs[$name][ 'module' ])
                       && $this->focus->field_defs[$name][ 'module' ] == $this->returnModule)
                   {
                       if (isset( $this->fieldDefs[$name]['id_name'])
                           && !empty($this->returnRelationship)
                           && isset($this->focus->field_defs[$this->fieldDefs[$name]['id_name']]['relationship'])
                           && ($this->returnRelationship == $this->focus->field_defs[$this->fieldDefs[$name]['id_name']]['relationship']))
                       {
                           $this->fieldDefs[$name]['value'] =  $this->returnName ;
                           // set the hidden id field for this relate field to the correct value i.e., return_id
                           $this->fieldDefs[$this->fieldDefs[$name]['id_name']]['value'] = $this->returnId ;
                       }
                   }
                }
            }
        }

        if (isset($this->focus->additional_meta_fields))
        {
            $this->fieldDefs = array_merge($this->fieldDefs, $this->focus->additional_meta_fields);
        }

        if ($this->isDuplicate)
        {
            foreach ($this->fieldDefs as $name=>$defs) {
                if (!empty($defs['auto_increment']))
                {
                    $this->fieldDefs[$name]['value'] = '';
                }
            }
        }
    }

    
    /**
     * display
     * This method makes the Smarty variable assignments and then displays the
     * generated view.
     * @param $showTitle boolean value indicating whether or not to show a title on the resulting page
     * @param $ajaxSave boolean value indicating whether or not the operation is an Ajax save request
     * @return HTML display for view as String
     */
    function display($showTitle = true, $ajaxSave = false)
    {
        global $mod_strings, $sugar_config, $app_strings, $app_list_strings, $theme, $current_user;

        if(isset($this->defs['templateMeta']['javascript']))
        {
            if(is_array($this->defs['templateMeta']['javascript']))
            {
                //$this->th->ss->assign('externalJSFile', 'modules/' . $this->module . '/metadata/editvewdefs.js');
                $this->th->ss->assign('externalJSFile', $this->defs['templateMeta']['javascript']);
            }
            else
            {
                $this->th->ss->assign('scriptBlocks', $this->defs['templateMeta']['javascript']);
            }
        }

        $this->th->ss->assign('id', $this->fieldDefs['id']['value']);
        $this->th->ss->assign('offset', $this->offset + 1);
        $this->th->ss->assign('APP', $app_strings);
        $this->th->ss->assign('MOD', $mod_strings);
        $this->th->ss->assign('fields', $this->fieldDefs);
        $this->th->ss->assign('sectionPanels', $this->sectionPanels);
        $this->th->ss->assign('config', $sugar_config);
        $this->th->ss->assign('returnModule', $this->returnModule);
        $this->th->ss->assign('returnAction', $this->returnAction);
        $this->th->ss->assign('returnId', $this->returnId);
        $this->th->ss->assign('isDuplicate', $this->isDuplicate);
        $this->th->ss->assign('def', $this->defs);
        $this->th->ss->assign('useTabs', isset($this->defs['templateMeta']['useTabs']) && isset($this->defs['templateMeta']['tabDefs']) ? $this->defs['templateMeta']['useTabs'] : false);
        $this->th->ss->assign('maxColumns', isset($this->defs['templateMeta']['maxColumns']) ? $this->defs['templateMeta']['maxColumns'] : 2);
        $this->th->ss->assign('module', $this->module);
        $this->th->ss->assign('headerTpl', isset($this->defs['templateMeta']['form']['headerTpl']) ? $this->defs['templateMeta']['form']['headerTpl'] : 'include/' . $this->view . '/header.tpl');
        $this->th->ss->assign('footerTpl', isset($this->defs['templateMeta']['form']['footerTpl']) ? $this->defs['templateMeta']['form']['footerTpl'] : 'include/' . $this->view . '/footer.tpl');
        $this->th->ss->assign('current_user', $current_user);
        $this->th->ss->assign('bean', $this->focus);
        $this->th->ss->assign('isAuditEnabled', $this->focus->is_AuditEnabled());
        $this->th->ss->assign('gridline',$current_user->getPreference('gridline') == 'on' ? '1' : '0');
        $this->th->ss->assign('tabDefs', isset($this->defs['templateMeta']['tabDefs']) ? $this->defs['templateMeta']['tabDefs'] : false);
        $this->th->ss->assign('VERSION_MARK', getVersionedPath(''));

        global $js_custom_version;
        global $sugar_version;

        $this->th->ss->assign('SUGAR_VERSION', $sugar_version);
        $this->th->ss->assign('JS_CUSTOM_VERSION', $js_custom_version);

        //this is used for multiple forms on one page
        if (!empty($this->formName)) {
            $form_id = $this->formName;
            $form_name = $this->formName;
        }
        else
        {
            $form_id = $this->view;
            $form_name = $this->view;
        }

        if ($ajaxSave && empty($this->formName))
        {
            $form_id = 'form_'.$this->view .'_'.$this->module;
            $form_name = $form_id;
            $this->view = $form_name;
            //$this->defs['templateMeta']['form']['buttons'] = array();
            //$this->defs['templateMeta']['form']['buttons']['ajax_save'] = array('id' => 'AjaxSave', 'customCode'=>'<input type="button" class="button" value="Save" onclick="this.form.action.value=\'AjaxFormSave\';return saveForm(\''.$form_name.'\', \'multiedit_form_{$module}\', \'Saving {$module}...\');"/>');
        }

        $form_name = $form_name == 'QuickCreate' ? "QuickCreate_{$this->module}" : $form_name;
        $form_id = $form_id == 'QuickCreate' ? "QuickCreate_{$this->module}" : $form_id;

        if (isset($this->defs['templateMeta']['preForm']))
        {
            $this->th->ss->assign('preForm', $this->defs['templateMeta']['preForm']);
        }

        if (isset($this->defs['templateMeta']['form']['closeFormBeforeCustomButtons']))
        {
            $this->th->ss->assign('closeFormBeforeCustomButtons', $this->defs['templateMeta']['form']['closeFormBeforeCustomButtons']);
        }

        if(isset($this->defs['templateMeta']['form']['enctype']))
        {
            $this->th->ss->assign('enctype', 'enctype="'.$this->defs['templateMeta']['form']['enctype'].'"');
        }

        //for SugarFieldImage, we must set form enctype to "multipart/form-data"
        foreach ($this->fieldDefs as $field)
        {
            if (isset($field['type']) && $field['type'] == 'image')
            {
                $this->th->ss->assign('enctype', 'enctype="multipart/form-data"');
                break;
            }
        }

        $this->th->ss->assign('showDetailData', $this->showDetailData);
        $this->th->ss->assign('showSectionPanelsTitles', $this->showSectionPanelsTitles);
        $this->th->ss->assign('form_id', $form_id);
        $this->th->ss->assign('form_name', $form_name);
        $this->th->ss->assign('set_focus_block', get_set_focus_js());

        $this->th->ss->assign('form', isset($this->defs['templateMeta']['form']) ? $this->defs['templateMeta']['form'] : null);
        $this->th->ss->assign('includes', isset($this->defs['templateMeta']['includes']) ? $this->defs['templateMeta']['includes'] : null);
        $this->th->ss->assign('view', $this->view);


        //Calculate time & date formatting (may need to calculate this depending on a setting)
        global $timedate;

        $this->th->ss->assign('CALENDAR_DATEFORMAT', $timedate->get_cal_date_format());
        $this->th->ss->assign('USER_DATEFORMAT', $timedate->get_user_date_format());
        $time_format = $timedate->get_user_time_format();
        $this->th->ss->assign('TIME_FORMAT', $time_format);

        $date_format = $timedate->get_cal_date_format();
        $time_separator = ':';
        if (preg_match('/\d+([^\d])\d+([^\d]*)/s', $time_format, $match))
        {
            $time_separator = $match[1];
        }

        // Create Smarty variables for the Calendar picker widget
        $t23 = strpos($time_format, '23') !== false ? '%H' : '%I';
        if (!isset($match[2]) || $match[2] == '')
        {
            $this->th->ss->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . '%M');
        }
        else
        {
            $pm = $match[2] == 'pm' ? '%P' : '%p';
            $this->th->ss->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . '%M' . $pm);
        }

        $this->th->ss->assign('CALENDAR_FDOW', $current_user->get_first_day_of_week());
        $this->th->ss->assign('TIME_SEPARATOR', $time_separator);

        $seps = get_number_seperators();
        $this->th->ss->assign('NUM_GRP_SEP', $seps[0]);
        $this->th->ss->assign('DEC_SEP', $seps[1]);

        if ($this->view == 'EditView')
        {
            $height = $current_user->getPreference('text_editor_height');
            $width  = $current_user->getPreference('text_editor_width');

            $height = isset($height) ? $height : '300px';
            $width  = isset($width) ? $width : '95%';

            $this->th->ss->assign('RICH_TEXT_EDITOR_HEIGHT', $height);
            $this->th->ss->assign('RICH_TEXT_EDITOR_WIDTH', $width);
        }
        else
        {
            $this->th->ss->assign('RICH_TEXT_EDITOR_HEIGHT', '100px');
            $this->th->ss->assign('RICH_TEXT_EDITOR_WIDTH', '95%');
        }

        $this->th->ss->assign('SHOW_VCR_CONTROL', $this->showVCRControl);

        $str = $this->showTitle($showTitle);

        //Use the output filter to trim the whitespace
        $this->th->ss->load_filter('output', 'trimwhitespace');
        $str .= $this->th->displayTemplate($this->module, $form_name, $this->tpl, $ajaxSave, $this->defs);

        return $str;
    }

    function insertJavascript($javascript)
    {
        $this->ss->assign('javascript', $javascript);
    }

    function callFunction($vardef)
    {
        $can_execute = true;
        $execute_function = array();
        $execute_params = array();
        if (!empty($vardef['function_class']))
        {
            $execute_function[] = $vardef['function_class'];
            $execute_function[] = $vardef['function_name'];
        }
        else
        {
            $execute_function = $vardef['function_name'];
        }

        foreach ($vardef['function_params'] as $param )
        {
            if (empty($vardef['function_params_source']) or $vardef['function_params_source']=='parent')
            {
                if (empty($this->focus->$param))
                {
                    $can_execute = false;
                }
                else
                {
                    $execute_params[] = $this->focus->$param;
                }
            }
            else if ($vardef['function_params_source']=='this')
            {
                if (empty($this->focus->$param))
                {
                    $can_execute = false;
                } else {
                    $execute_params[] = $this->focus->$param;
                }
            }
            else
            {
                $can_execute = false;
            }
        }

        $value = '';
        if ($can_execute)
        {
            if (!empty($vardef['function_require']))
            {
                require_once($vardef['function_require']);
            }

            $value = call_user_func_array($execute_function, $execute_params);
        }

        return $value;
    }

    /**
     * getValueFromRequest
     * This is a helper method to extract a value from the request
     * Array.  We do some special processing for fields that start
     * with 'date_' by checking to see if they also include time
     * and meridiem values
     *
     * @param request The request Array
     * @param name The field name to extract value for
     * @return String value for given name
     */
    function getValueFromRequest($request, $name)
    {
        //Special processing for date values (combine to one field)
        if (preg_match('/^date_(.*)$/s', $name, $matches))
        {
            $d = $request[$name];

            if (isset($request['time_' . $matches[1]]))
            {
                $d .= ' ' . $request['time_' . $matches[1]];
                if (isset($request[$matches[1] . '_meridiem']))
                {
                    $d .= $request[$matches[1] . '_meridiem'];
                }
            }
            else
            {
                if (isset($request['time_hour_' . $matches[1]])
                    && isset($request['time_minute_' . $matches[1]]))
                {
                    $d .= sprintf(' %s:%s', $request['time_hour_' . $matches[1]], $request['time_minute_' . $matches[1]]);
                }

                if (isset($request['meridiem']))
                {
                    $d .= $request['meridiem'];
                }
           }

           return $d;
        }

        if (empty($request[$name]) || !isset($this->fieldDefs[$name]))
        {
           return $request[$name];
        }

        //if it's a bean field - unformat it
        require_once('include/SugarFields/SugarFieldHandler.php');

        $sfh  = new SugarFieldHandler();
        $type = !empty($this->fieldDefs[$name]['custom_type'])
            ? $this->fieldDefs[$name]['custom_type']
            : $this->fieldDefs[$name]['type'];
        $sf   = $sfh->getSugarField($type);

        return $sf ? $sf->unformatField($request[$name], $this->fieldDefs[$name]) : $request[$name];
    }


	/**
	 * Allow Subviews to overwrite this method to show custom titles.
	 * Examples: Projects & Project Templates.
	 * params: $showTitle: boolean for backwards compatibility.
	 */
    public function showTitle($showTitle = false)
    {
        global $mod_strings, $app_strings;

        if (is_null($this->viewObject))
        {
            $this->viewObject = (!empty($GLOBALS['current_view']))
                ? $GLOBALS['current_view']
                : new SugarView();
        }

        if ($showTitle)
        {
            return $this->viewObject->getModuleTitle();
        }

        return '';
    }

    /**
     * Get template handler object
     * @return TemplateHandler
     */
    protected function getTemplateHandler()
    {
        return new TemplateHandler();
    }
}

