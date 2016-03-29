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


class PivotDashlet extends Dashlet {
    var $pivotId;
    var $showGui;

    /**
     * Constructor
     *
     * @global string current language
     * @param guid $id id for the current dashlet (assigned from Home module)
     * @param array $def options saved for this dashlet
     */
    function PivotDashlet($id, $def) {
        $this->loadLanguage('PivotDashlet','modules/Pivot/Dashlets/'); // load the language strings here

        $this->isRefreshable = false;

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

    function checkIfPivotHasBeenDeleted($pivotId)
    {
        $pivotBean = BeanFactory::getBean('Pivot',$pivotId);return $pivotBean === false;
    }

    /**
     * Displays the dashlet
     *
     * @return string html to display dashlet
     */
    function display() {

        //As the dashlet may point to a pivot that has been marked as deleted, check this here

        if(is_null($this->pivotId) || $this->pivotId === '')
        {
            return parent::display('') .'<span style="margin-left:10px;" class="dashletAnalyticMessage">'. $this->dashletStrings['LBL_NO_PIVOT_SELECTED'] . '</span><br />'; // return parent::display for title and such
        }
        else
        {
            if($this->checkIfPivotHasBeenDeleted($this->pivotId))
            {
                return parent::display('')  .'<span style="margin-left:10px;" class="dashletAnalyticMessage">'. $this->dashletStrings['LBL_PIVOT_POINTED_DELETED'] . '</span><br />'; // return parent::display for title and such
            }

            $ss = new Sugar_Smarty();
            $ss->assign('id', $this->id);
            $ss->assign('showUI', $this->showGui);
            $ss->assign('pivotToLoad', $this->pivotId);

            $ss->assign('lblSaved', $this->dashletStrings['LBL_SAVED']);
            $ss->assign('lblPivotToLoad', $this->dashletStrings['LBL_PIVOT_TO_LOAD']);
            $ss->assign('lblShowUI', $this->dashletStrings['LBL_SHOW_UI']);
            $ss->assign('lblPleaseSave', $this->dashletStrings['LBL_PLEASE_SAVE']);
            $ss->assign('lblPivotLoadError', $this->dashletStrings['LBL_PIVOT_LOAD_ERROR']);
            $ss->assign('lblBtnSave', $this->dashletStrings['LBL_BTN_SAVE']);
            $ss->assign('lblBtnLoad', $this->dashletStrings['LBL_BTN_LOAD']);
            $ss->assign('lblToggleUI', $this->dashletStrings['LBL_TOGGLE_UI']);
            $ss->assign('lblLoadPivot', $this->dashletStrings['LBL_LOAD_PIVOT']);
            $ss->assign('lblPivotSavedAs', $this->dashletStrings['LBL_PIVOT_SAVED_AS']);
            $ss->assign('lblLoadedSuccessfully', $this->dashletStrings['LBL_LOADED_SUCCESSFULLY']);
            $ss->assign('lblNoSavedPivots', $this->dashletStrings['LBL_NO_SAVED_PIVOTS']);
            $ss->assign('lblMinPivotName', $this->dashletStrings['LBL_MIN_PIVOT_NANE']);
            $ss->assign('lblCharacters', $this->dashletStrings['LBL_CHARACTERS']);
            $ss->assign('lblShowUi', $this->dashletStrings['LBL_SHOW_UI']);
            $ss->assign('lblName', $this->dashletStrings['LBL_NAME']);
            $ss->assign('lblBtnSavePivot', $this->dashletStrings['LBL_BTN_SAVE_PIVOT']);

            $str = $ss->fetch('modules/Pivot/Dashlets/PivotDashlet/PivotDashlet.tpl');
            return parent::display() . $str . '<br />'; // return parent::display for title and such
        }
    }

    /**
     * Displays the javascript for the dashlet
     *
     * @return string javascript to use with this dashlet
     */
    function displayScript() {}

    /**
     * Displays the configuration form for the dashlet
     *
     * @return string html to display form
     */
    function displayOptions() {
        global $app_strings;

        $ss = new Sugar_Smarty();
        $ss->assign('titleLbl', $this->dashletStrings['LBL_CONFIGURE_TITLE']);
        $ss->assign('saveLbl', $app_strings['LBL_SAVE_BUTTON_LABEL']);
        $ss->assign('pivotToLoadTitleLbl', $this->dashletStrings['LBL_PIVOT_TO_LOAD']);
        $ss->assign('showUILbl', $this->dashletStrings['LBL_SHOW_UI']);
        $ss->assign('title', $this->title);
        $ss->assign('id', $this->id);
        $ss->assign('showUI', $this->showGui);
        $ss->assign('pivotToLoad', $this->pivotId);


        $ss->assign('pivots',$this->getPivotList());

        return parent::displayOptions() . $ss->fetch('modules/Pivot/Dashlets/PivotDashlet/PivotDashletOptions.tpl');
    }

    public function getPivotList()
    {
        $pivotBean = BeanFactory::getBean('Pivot');
        $beanList = $pivotBean->get_full_list('name');
        $returnArray = [];
        if(!is_null($beanList))
        {
            foreach ($beanList as $b) {
                $bean = new stdClass();
                $bean->type = $b->type;
                $bean->config = htmlspecialchars_decode($b->config);
                $bean->name = $b->name;
                $bean->id = $b->id;
                $returnArray[] = $bean;
            }
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
        if(isset($_REQUEST['showGui']))
        {
            $options['showGui']= $_REQUEST['showGui'];
        }
        else
        {
            $options['showGui']= '';
        }
        if(isset($_REQUEST['pivots']))
        {
            $options['pivotId']= $_REQUEST['pivots'];
        }
        else
        {
            $options['pivotId']= '';
        }


        return $options;
    }


}

?>
