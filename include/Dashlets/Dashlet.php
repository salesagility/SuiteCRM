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

require_once('include/Sugar_Smarty.php');
require_once('include/utils/layout_utils.php');

/**
 * Basic Dashlet
 * @api
 */
class Dashlet
{
   /**
     * Id of the Dashlet
     * @var guid
     */
    var $id;
    /**
     * Title of the Dashlet
     * @var string
     */
    var $title = 'Generic Dashlet';
    /**
     * true if the Dashlet has configuration options.
     * @var bool
     */
    var $isConfigurable = false;
    /**
     * true if the Dashlet is refreshable (ie charts that provide their own refresh)
     * @var bool
     */
    var $isRefreshable = true;
    /**
     * true if the Dashlet configuration options panel has the clear button
     * @var bool
     */
    public $isConfigPanelClearShown = true;
    /**
     * true if the Dashlet contains javascript
     * @var bool
     */
    var $hasScript = false;
    /**
     * Language strings, must be loaded at the Dashlet level w/ loadLanguage
     * @var array
     */
    var $dashletStrings;
    /**
     * Time period in minutes to refresh the dashlet (0 for never)
     * Do not refresh if $isRefreshable is set to false
     *
     * To support auto refresh all refreshable dashlets that override process() must call processAutoRefresh()
     * @var int
     */
    var $autoRefresh = "0";

    /**
     * Constructor
     *
     * @param $id
     */
    public function Dashlet($id)
    {
        $this->id = $id;
    }

    /**
     * Returns the HTML for the configure icon
     *
     * @return string HTML
     */
    public function setConfigureIcon()
    {
        if($this->isConfigurable) {
            $additionalTitle = '<td nowrap width="1%" style="padding-right: 0px;"><div class="dashletToolSet"><a href="javascript:void(0)" onclick="SUGAR.mySugar.configureDashlet(\''
                               . $this->id . '\'); return false;">'
                               . SugarThemeRegistry::current()->getImage('dashlet-header-edit','title="' . translate('LBL_DASHLET_EDIT', 'Home') . '" border="0"  align="absmiddle"', null,null,'.gif',translate('LBL_DASHLET_EDIT', 'Home')).'</a>'
                               . '';
        }
        else {
            $additionalTitle = '<td nowrap width="1%" style="padding-right: 0px;"><div class="dashletToolSet">';
    	}

    	return $additionalTitle;
    }

    /**
     * Returns the HTML for the refresh icon
     *
     * @return string HTML
     */
    public function setRefreshIcon()
    {
    	$additionalTitle = '';
        if($this->isRefreshable) {
            $additionalTitle .= '<a href="javascript:void(0)" onclick="SUGAR.mySugar.retrieveDashlet(\''
                                . $this->id . '\'); return false;">'
                                . SugarThemeRegistry::current()->getImage('dashlet-header-refresh','border="0" align="absmiddle" title="' . translate('LBL_DASHLET_REFRESH', 'Home') . '"',null,null,'.gif',translate('LBL_DASHLET_REFRESH', 'Home'))
                                . '</a>';
        }

        return $additionalTitle;
    }

    /**
     * Returns the HTML for the delete icon
     *
     * @return string HTML
     */
    public function setDeleteIcon()
    {
    	global $sugar_config;

    	if (!empty($sugar_config['lock_homepage']) && $sugar_config['lock_homepage'] == true) {
			return '</div></td></tr></table>';
		}
    	$additionalTitle = '<a href="javascript:void(0)" onclick="SUGAR.mySugar.deleteDashlet(\''
                            . $this->id . '\'); return false;">'
                            . SugarThemeRegistry::current()->getImage('dashlet-header-close','border="0" align="absmiddle" title="' . translate('LBL_DASHLET_DELETE', 'Home') . '"',null,null,'.gif',translate('LBL_DASHLET_DELETE', 'Home'))
                            . '</a></div></td></tr></table>';
		return $additionalTitle;
    }

    /**
     * @deprecated No longer needed, replaced with Dashlet::getHeader() and Dashlet::getFooter()
     *
     * @param string $text
     * @return string HTML
     */
    public function getTitle($text = '')
    {
        return '';
    }

    /**
     * Called when Dashlet is displayed
     *
     * @param string $text text after the title
     * @return string Header html
     */
    public function getHeader($text = '')
    {
        global $sugar_config;

        $title = '<table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="99%">' . $text . '</td>';
        $title .= $this->setConfigureIcon();
        $title .= $this->setRefreshIcon();
        $title .= $this->setDeleteIcon();

        $str = '<div ';
        if(empty($sugar_config['lock_homepage']) || $sugar_config['lock_homepage'] == false) $str .= 'onmouseover="this.style.cursor = \'move\';" ';
        $str .= 'id="dashlet_header_' . $this->id . '" class="hd"><div class="tl"></div><div class="hd-center">' . get_form_header($this->title, $title, false) . '</div><div class="tr"></div></div><div class="bd"><div class="ml"></div><div class="bd-center">';

        return $str;
    }

    /**
     * Called when Dashlet is displayed
     *
     * @return string footer HTML
     */
    public function getFooter()
    {
        $footer = '</div><div class="mr"></div></div><div class="ft"><div class="bl"></div><div class="ft-center"></div><div class="br"></div></div>';

        return $footer;
    }

    /**
     * Called when Dashlet is displayed, override this
     *
     * @param string $text text after the title
     * @return string title HTML
     */
    public function display($text = '')
    {
        return '';
    }

    /**
     * Called when Dashlets configuration options are called
     */
    public function displayOptions()
    {
    }

    /**
     * Override if you need to do pre-processing before display is called
     */
    public function process()
    {
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
            if(isset($_REQUEST[$module.'2_'.strtoupper($this->seedBean->object_name).'_offset'])) {
            	$dashletOffset = $_REQUEST[$module.'2_'.strtoupper($this->seedBean->object_name).'_offset'];
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
        $tpl = 'include/Dashlets/DashletGenericAutoRefresh.tpl';
        if ( $_REQUEST['action'] == "DynamicAction" ) {
            $tpl = 'include/Dashlets/DashletGenericAutoRefreshDynamic.tpl';
        }

        return $autoRefreshSS->fetch($tpl);
    }

    protected function getAutoRefresh()
    {
        global $sugar_config;

        if (empty($this->autoRefresh) || $this->autoRefresh == -1)
        {
            $autoRefresh = 0;
        }
        elseif (!empty($sugar_config['dashlet_auto_refresh_min'])
                && $this->autoRefresh > 0
                && $sugar_config['dashlet_auto_refresh_min'] > $this->autoRefresh)
        {
            $autoRefresh = $sugar_config['dashlet_auto_refresh_min'];
        }
        else
        {
            $autoRefresh = $this->autoRefresh;
        }

        return $autoRefresh * 1000;
    }

    /**
     * Override this if your dashlet is configurable (this is called when the the configureDashlet form is shown)
     * Filters the array for only the parameters it needs to save
     *
     * @param array $req the array to pull options from
     * @return array options array
     */
    public function saveOptions($req)
    {
    }

    /**
     * Sets the language strings
     *
     * @param string $dashletClassname classname of the dashlet
     * @param string $dashletDirectory directory path of the dashlet
     */
    public function loadLanguage($dashletClassname, $dashletDirectory = 'modules/Home/Dashlets/')
    {
        global $current_language, $dashletStrings;

        if(!isset($dashletStrings[$dashletClassname])) {
            // load current language strings for current language, else default to english
            if(is_file($dashletDirectory . $dashletClassname . '/' . $dashletClassname . '.' . $current_language . '.lang.php')
                    || is_file('custom/' . $dashletDirectory . $dashletClassname . '/' . $dashletClassname . '.' . $current_language . '.lang.php') ) {
                if(is_file($dashletDirectory . $dashletClassname . '/' . $dashletClassname . '.' . $current_language . '.lang.php')) {
                    require($dashletDirectory . $dashletClassname . '/' . $dashletClassname . '.' . $current_language . '.lang.php');
                }
                if(is_file('custom/' . $dashletDirectory . $dashletClassname . '/' . $dashletClassname . '.' . $current_language . '.lang.php')) {
                    require('custom/' . $dashletDirectory . $dashletClassname . '/' . $dashletClassname . '.' . $current_language . '.lang.php');
                }
            }
            else {
                if(is_file($dashletDirectory . $dashletClassname . '/' . $dashletClassname . '.en_us.lang.php')) {
                    require($dashletDirectory . $dashletClassname . '/' . $dashletClassname . '.en_us.lang.php');
                }
                if(is_file('custom/' . $dashletDirectory . $dashletClassname . '/' . $dashletClassname . '.en_us.lang.php')) {
                    require('custom/' . $dashletDirectory . $dashletClassname . '/' . $dashletClassname . '.en_us.lang.php');
                }
            }
        }

        $this->dashletStrings = $dashletStrings[$dashletClassname];
    }

    /**
     * Generic way to store an options array into UserPreferences
     *
     * @param array $optionsArray the array to save
     */
    public function storeOptions($optionsArray)
    {
        global $current_user;

        $dashletDefs = $current_user->getPreference('dashlets', 'Home'); // load user's dashlets config
        $dashletDefs[$this->id]['options'] = $optionsArray;
        $current_user->setPreference('dashlets', $dashletDefs, 0, 'Home');
    }

    /**
     * Generic way to retrieve options array from UserPreferences
     *
     * @return array options array stored in UserPreferences
     */
    public function loadOptions()
    {
        global $current_user;

        $dashletDefs = $current_user->getPreference('dashlets', 'Home'); // load user's dashlets config
        if(isset($dashletDefs[$this->id]['options']))
            return $dashletDefs[$this->id]['options'];
        else
            return array();
    }

    /**
     * Override this in the subclass. It is used to determine whether the dashlet can be displayed.
     *
     * @return bool indicating whether or not the current user has access to display this Dashlet.
     */
    public function hasAccess()
    {
    	return true;
    }

    /**
     * Returns the available auto refresh settings you can set a dashlet to
     *
     * @return array options available
     */
    protected function getAutoRefreshOptions()
    {
        $options = $GLOBALS['app_list_strings']['dashlet_auto_refresh_options'];

        if ( isset($GLOBALS['sugar_config']['dashlet_auto_refresh_min']) ) {
            foreach ( $options as $time => $desc ) {
                if ( $time != -1 && $time < $GLOBALS['sugar_config']['dashlet_auto_refresh_min'] ) {
                    unset($options[$time]);
                }
            }
        }

        return $options;
    }

    /**
     * Returns true if the dashlet is auto refreshable
     *
     * @return bool
     */
    protected function isAutoRefreshable()
    {
        return $this->isRefreshable &&
            ( isset($GLOBALS['sugar_config']['dashlet_auto_refresh_min']) ?
                $GLOBALS['sugar_config']['dashlet_auto_refresh_min'] != -1 : true );
    }
}
