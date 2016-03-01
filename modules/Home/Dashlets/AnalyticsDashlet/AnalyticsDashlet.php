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


require_once('include/Dashlets/Dashlet.php');


class AnalyticsDashlet extends Dashlet {
    var $savedText; // users's saved text
    var $height = '200'; // height of the pad
    var $pivotId;
    var $showGui;

    /**
     * Constructor
     *
     * @global string current language
     * @param guid $id id for the current dashlet (assigned from Home module)
     * @param array $def options saved for this dashlet
     */
    function AnalyticsDashlet($id, $def) {
        $this->loadLanguage('AnalyticsDashlet'); // load the language strings here
/*
        if(!empty($def['savedText']))  // load default text is none is defined
            $this->savedText = $def['savedText'];
        else
            $this->savedText = $this->dashletStrings['LBL_DEFAULT_TEXT'];
*/
        if(!empty($def['height'])) // set a default height if none is set
            $this->height = $def['height'];

        if(!empty($def['pivotId']))
        {
            $this->pivotId = $def['pivotId'];
        }
        else
        {
            $this->pivotId = '';
        }

        if(!empty($def['showGui']) && $def['showGui']==='on')
        {
            $this->showGui = 1;
        }
        else
        {
            $this->showGui = 0;
        }


        parent::Dashlet($id); // call parent constructor

        $this->isConfigurable = true; // dashlet is configurable
        $this->hasScript = true;  // dashlet has javascript attached to it

        // if no custom title, use default
        if(empty($def['title'])) $this->title = $this->dashletStrings['LBL_TITLE'];
        else $this->title = $def['title'];
    }

    /**
     * Displays the dashlet
     *
     * @return string html to display dashlet
     */
    function display() {

        $ss = new Sugar_Smarty();
        //$ss->assign('savedText', SugarCleaner::cleanHtml($this->savedText));
        //$ss->assign('saving', $this->dashletStrings['LBL_SAVING']);
        //$ss->assign('saved', $this->dashletStrings['LBL_SAVED']);
        $ss->assign('id', $this->id);
        $ss->assign('showUI', $this->showGui);
        $ss->assign('pivotToLoad', $this->pivotId);
        //$ss->assign('height', $this->height);

        //$str = $ss->fetch('modules/Home/Dashlets/AnalyticsDashlet/AnalyticsDashlet.tpl');
        //return parent::display($this->dashletStrings['LBL_DBLCLICK_HELP']) . $str . '<br />'; // return parent::display for title and such

        //$_REQUEST['analysisDashletId']= $this->id;
        //$str = file_get_contents("modules/Home/Dashlets/AnalyticsDashlet/AnalyticsDashletSpecific.php");
        $str = $ss->fetch('modules/Home/Dashlets/AnalyticsDashlet/AnalyticsDashlet.tpl');
        return parent::display($this->dashletStrings['LBL_DBLCLICK_HELP']) . $str . '<br />'; // return parent::display for title and such

    }

    /**
     * Displays the javascript for the dashlet
     *
     * @return string javascript to use with this dashlet
     */
    function displayScript() {
        $ss = new Sugar_Smarty();
        $ss->assign('saving', $this->dashletStrings['LBL_SAVING']);
        $ss->assign('saved', $this->dashletStrings['LBL_SAVED']);
        $ss->assign('id', $this->id);

        $str = $ss->fetch('modules/Home/Dashlets/AnalyticsDashlet/AnalyticsDashletScript.tpl');
        return $str; // return parent::display for title and such
    }

    /**
     * Displays the configuration form for the dashlet
     *
     * @return string html to display form
     */
    function displayOptions() {
        global $app_strings;

        $ss = new Sugar_Smarty();
        $ss->assign('titleLbl', $this->dashletStrings['LBL_CONFIGURE_TITLE']);
        $ss->assign('heightLbl', $this->dashletStrings['LBL_CONFIGURE_HEIGHT']);
        $ss->assign('saveLbl', $app_strings['LBL_SAVE_BUTTON_LABEL']);
        $ss->assign('clearLbl', $app_strings['LBL_CLEAR_BUTTON_LABEL']);
        $ss->assign('title', $this->title);
        $ss->assign('height', $this->height);
        $ss->assign('id', $this->id);
        $ss->assign('showUI', $this->showGui);
        $ss->assign('pivotToLoad', $this->pivotId);

        //$pivots[] = ["id"=>123,"name"=>'test'];
        //$pivots[] = ["id"=>456,"name"=>'test2'];
        //$ss->assign('pivots',json_encode($pivots));
        $ss->assign('pivots',$this->getPivotList());

        return parent::displayOptions() . $ss->fetch('modules/Home/Dashlets/AnalyticsDashlet/AnalyticsDashletOptions.tpl');
    }

    public function getPivotList()
    {
        $pivotBean = BeanFactory::getBean('a007_Pivot');
        $beanList = $pivotBean->get_full_list('name');
        $returnArray = [];
        foreach ($beanList as $b) {
            $bean = new stdClass();
            $bean->type = $b->type;
            $bean->config = htmlspecialchars_decode($b->config);
            $bean->name = $b->name;
            $bean->id = $b->id;
            $returnArray[] = $bean;
        }
        return json_encode($returnArray);
    }

    /**
     * called to filter out $_REQUEST object when the user submits the configure dropdown
     *
     * @param array $req $_REQUEST
     * @return array filtered options to save
     */
    function saveOptions($req) {
        global $sugar_config, $timedate, $current_user, $theme;
        $options = array();
        $options['title'] = $_REQUEST['title'];

        $options['showGui']= $_REQUEST['showGui'];
        $options['pivotId']= $_REQUEST['pivots'];


        return $options;
    }


}

?>
