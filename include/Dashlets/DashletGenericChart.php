<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

require_once('include/Dashlets/Dashlet.php');
require_once('include/generic/LayoutManager.php');

abstract class DashletGenericChart extends Dashlet
{
    /**
     * The title of the dashlet
     * @var string
     */
    public $title;

    /**
     * @see Dashlet::$isConfigurable
     */
    public $isConfigurable = true;

    /**
     * @see Dashlet::$isRefreshable
     */
    public $isRefreshable  = true;

    /**
     * location of smarty template file for configuring
     * @var string
     */
    protected $_configureTpl = 'include/Dashlets/DashletGenericChartConfigure.tpl';

    /**
     * Bean file used in this Dashlet
     * @var object
     */
    private $_seedBean;

    /**
     * Module used in this Dashlet
     * @var string
     */
    protected $_seedName;

    /**
     * Array of fields and thier defintions that we are searching on
     * @var array
     */
    protected $_searchFields;

    /**
     * smarty object for the generic configuration template
     * @var object
     */
    private $_configureSS;


    /**
     * Constructor
     *
     * @param int   $id
     * @param array $options
     */
    public function __construct(
        $id,
        array $options = null
        )
    {
        parent::Dashlet($id);

        if ( isset($options) ) {
            foreach ( $options as $key => $value ) {
                $this->$key = $value;
            }
        }

        // load searchfields
        $classname = get_class($this);
        if ( is_file("modules/Charts/Dashlets/$classname/$classname.data.php") ) {
            require("modules/Charts/Dashlets/$classname/$classname.data.php");
            $this->_searchFields = $dashletData[$classname]['searchFields'];
        }

        // load language files
        $this->loadLanguage($classname, 'modules/Charts/Dashlets/');

        if ( empty($options['title']) )
            $this->title = $this->dashletStrings['LBL_TITLE'];
        if ( isset($options['autoRefresh']) )
            $this->autoRefresh = $options['autoRefresh'];

        $this->layoutManager = new LayoutManager();
        $this->layoutManager->setAttribute('context', 'Report');
        // fake a reporter object here just to pass along the db type used in many widgets.
        // this should be taken out when sugarwidgets change
        $temp = (object) array('db' => &$GLOBALS['db'], 'report_def_str' => '');
        $this->layoutManager->setAttributePtr('reporter', $temp);
    }

    /**
     * @see Dashlet::setRefreshIcon()
     */
    public function setRefreshIcon()
    {
    	$additionalTitle = '';
        if($this->isRefreshable)

            $additionalTitle .= '<a href="#" onclick="SUGAR.mySugar.retrieveDashlet(\''
                . $this->id
                . '\',\'predefined_chart\'); return false;"><!--not_in_theme!-->'
                . SugarThemeRegistry::current()->getImage(
                    'dashlet-header-refresh',
                    'border="0" align="absmiddle" title="'. translate('LBL_DASHLET_REFRESH', 'Home') . '"',
                    null,
                    null,
                    '.gif',
                    translate('LBL_DASHLET_REFRESH', 'Home')
                )
                . '</a>';
        return $additionalTitle;
    }

    /**
     * Displays the javascript for the dashlet
     *
     * @return string javascript to use with this dashlet
     */
    public function displayScript()
    {

		require_once('include/SugarCharts/SugarChartFactory.php');
		$sugarChart = SugarChartFactory::getInstance();
		return $sugarChart->getDashletScript($this->id);

    }

    /**
     * Gets the smarty object for the config window. Designed to allow lazy loading the object
     * when it's needed.
     */
    protected function getConfigureSmartyInstance()
    {
        if ( !($this->_configureSS instanceof Sugar_Smarty) ) {

            $this->_configureSS = new Sugar_Smarty();
        }

        return $this->_configureSS;
    }

    /**
     * Saves the chart config options
     * Filter the $_REQUEST and only save only the needed options
     *
     * @param  array $req
     * @return array
     */
    public function saveOptions(
        $req
        )
    {
        global $timedate;

        $options = array();

        foreach($req as $name => $value)
            if(!is_array($value)) $req[$name] = trim($value);

        foreach($this->_searchFields as $name => $params) {
            $widgetDef = $params;
            if ( isset($this->getSeedBean()->field_defs[$name]) )
                $widgetDef = $this->getSeedBean()->field_defs[$name];
            if ( $widgetDef['type'] == 'date')           // special case date types
                $options[$widgetDef['name']] = $timedate->swap_formats($req['type_'.$widgetDef['name']], $timedate->get_date_format(), $timedate->dbDayFormat);
            elseif ( $widgetDef['type'] == 'time')       // special case time types
                $options[$widgetDef['name']] = $timedate->swap_formats($req['type_'.$widgetDef['name']], $timedate->get_time_format(), $timedate->dbTimeFormat);
            elseif ( $widgetDef['type'] == 'datepicker') // special case datepicker types
                $options[$widgetDef['name']] = $timedate->swap_formats($req[$widgetDef['name']], $timedate->get_date_format(), $timedate->dbDayFormat);
            elseif (!empty($req[$widgetDef['name']]))
                $options[$widgetDef['name']] = $req[$widgetDef['name']];
        }

        if (!empty($req['dashletTitle']))
            $options['title'] = $req['dashletTitle'];

        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];

        return $options;
    }

    /**
     * Handles displaying the chart dashlet configuration popup window
     *
     * @return string HTML to return to the browser
     */
    public function displayOptions()
    {
        $currentSearchFields = array();

        if ( is_array($this->_searchFields) ) {
            foreach($this->_searchFields as $name=>$params) {
                if(!empty($name)) {
                    $name = strtolower($name);
                    $currentSearchFields[$name] = array();

                    $widgetDef = $params;
                    if ( isset($this->getSeedBean()->field_defs[$name]) )
                        $widgetDef = $this->getSeedBean()->field_defs[$name];

                    if($widgetDef['type'] == 'enum' || $widgetDef['type'] == 'singleenum') $widgetDef['remove_blank'] = true; // remove the blank option for the dropdown

                    if ( empty($widgetDef['input_name0']) )
                        $widgetDef['input_name0'] = empty($this->$name) ? '' : $this->$name;
                    $currentSearchFields[$name]['label'] = translate($widgetDef['vname'], $this->getSeedBean()->module_dir);
                    if ( $currentSearchFields[$name]['label'] == $widgetDef['vname'] )
                        $currentSearchFields[$name]['label'] = translate($widgetDef['vname'], 'Charts');
                    $currentSearchFields[$name]['input'] = $this->layoutManager->widgetDisplayInput($widgetDef, true, (empty($this->$name) ? '' : $this->$name));
                }
                else { // ability to create spacers in input fields
                    $currentSearchFields['blank' + $count]['label'] = '';
                    $currentSearchFields['blank' + $count]['input'] = '';
                    $count++;
                }
            }
        }
        $this->currentSearchFields = $currentSearchFields;
        $this->getConfigureSmartyInstance()->assign('title',translate('LBL_TITLE','Charts'));
        $this->getConfigureSmartyInstance()->assign('save',$GLOBALS['app_strings']['LBL_SAVE_BUTTON_LABEL']);
        $this->getConfigureSmartyInstance()->assign('clear',$GLOBALS['app_strings']['LBL_CLEAR_BUTTON_LABEL']);
        $this->getConfigureSmartyInstance()->assign('id', $this->id);
        $this->getConfigureSmartyInstance()->assign('searchFields', $this->currentSearchFields);
        $this->getConfigureSmartyInstance()->assign('dashletTitle', $this->title);
        $this->getConfigureSmartyInstance()->assign('dashletType', 'predefined_chart');
        $this->getConfigureSmartyInstance()->assign('module', $_REQUEST['module']);
        $this->getConfigureSmartyInstance()->assign('showClearButton', $this->isConfigPanelClearShown);
        
        if($this->isAutoRefreshable()) {
       		$this->getConfigureSmartyInstance()->assign('isRefreshable', true);
			$this->getConfigureSmartyInstance()->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$this->getConfigureSmartyInstance()->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$this->getConfigureSmartyInstance()->assign('autoRefreshSelect', $this->autoRefresh);
		}

        return parent::displayOptions() . $this->getConfigureSmartyInstance()->fetch($this->_configureTpl);
    }

    /**
     * Returns the DashletGenericChart::_seedBean object. Designed to allow lazy loading the object
     * when it's needed.
     *
     * @return object
     */
    protected function getSeedBean()
    {
        if ( !($this->_seedBean instanceof SugarBean) )
            $this->_seedBean = SugarModule::get($this->_seedName)->loadBean();

        return $this->_seedBean;
    }

    /**
     * Returns the built query read to feed into SugarChart::getData()
     *
     * @return string SQL query
     */
    protected function constructQuery()
    {
        return '';
    }

    /**
     * Returns the array of group by parameters for SugarChart::$group_by
     *
     * @return string SQL query
     */
    protected function constructGroupBy()
    {
        return array();
    }

    /**
     * Displays the Dashlet, must call process() prior to calling this
     *
     * @return string HTML that displays Dashlet
     */
    public function display()
    {
        return parent::display() . $this->processAutoRefresh();
    }

    /**
     * Processes and displays the auto refresh code for the dashlet
     *
     * @param int $dashletOffset
     * @return string HTML code
     */
    protected function processAutoRefresh($dashletOffset = 0)
    {
        global $sugar_config;

        if ( empty($dashletOffset) ) {
            $dashletOffset = 0;
            $module = $_REQUEST['module'];
            if(isset($_REQUEST[$module.'2_'.strtoupper($this->getSeedBean()->object_name).'_offset'])) {
            	$dashletOffset = $_REQUEST[$module.'2_'.strtoupper($this->getSeedBean()->object_name).'_offset'];
            }
        }

        if ( !$this->isRefreshable ) {
            return '';
        }
        if ( !empty($sugar_config['dashlet_auto_refresh_min']) && $sugar_config['dashlet_auto_refresh_min'] == -1 ) {
            return '';
        }
        $autoRefreshSS = new Sugar_Smarty();
        $autoRefreshSS->assign('dashletOffset', $dashletOffset);
        $autoRefreshSS->assign('dashletId', $this->id);
        $autoRefreshSS->assign('strippedDashletId', str_replace("-","",$this->id)); //javascript doesn't like "-" in function names
        $autoRefreshSS->assign('dashletRefreshInterval', $this->getAutoRefresh());
        $autoRefreshSS->assign('url', "predefined_chart");
        $tpl = 'include/Dashlets/DashletGenericAutoRefresh.tpl';
        if ( $_REQUEST['action'] == "DynamicAction" ) {
            $tpl = 'include/Dashlets/DashletGenericAutoRefreshDynamic.tpl';
        }

        return $autoRefreshSS->fetch($tpl);
    }
}
