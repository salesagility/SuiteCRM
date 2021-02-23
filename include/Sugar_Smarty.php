<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

if (!defined('SUGAR_SMARTY_DIR')) {
    define('SUGAR_SMARTY_DIR', sugar_cached('smarty/'));
}

/**
 * Smarty wrapper for Sugar
 * @api
 */
class Sugar_Smarty extends Smarty
{
    /**
     * Sugar_Smarty constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (!file_exists(SUGAR_SMARTY_DIR)) {
            mkdir_recursive(SUGAR_SMARTY_DIR, true);
        }
        if (!file_exists(SUGAR_SMARTY_DIR . 'templates_c')) {
            mkdir_recursive(SUGAR_SMARTY_DIR . 'templates_c', true);
        }
        if (!file_exists(SUGAR_SMARTY_DIR . 'configs')) {
            mkdir_recursive(SUGAR_SMARTY_DIR . 'configs', true);
        }
        if (!file_exists(SUGAR_SMARTY_DIR . 'cache')) {
            mkdir_recursive(SUGAR_SMARTY_DIR . 'cache', true);
        }

        $this->template_dir = '.';
        $this->compile_dir = SUGAR_SMARTY_DIR . 'templates_c';
        $this->config_dir = SUGAR_SMARTY_DIR . 'configs';
        $this->cache_dir = SUGAR_SMARTY_DIR . 'cache';
        $this->request_use_auto_globals = true; // to disable Smarty from using long arrays

        if (file_exists('custom/include/Smarty/plugins')) {
            $plugins_dir[] = 'custom/include/Smarty/plugins';
        }
        $plugins_dir[] = 'include/Smarty/plugins';
        $this->plugins_dir = $plugins_dir;

        $this->assign("VERSION_MARK", getVersionedPath(''));
    }



    /**
     * Override default _unlink method call to fix Bug 53010
     *
     * @param string $resource
     * @param integer $exp_time
     * @return boolean
     */
    public function _unlink($resource, $exp_time = null)
    {
        if (file_exists($resource)) {
            return parent::_unlink($resource, $exp_time);
        }

        // file wasn't found, so it must be gone.
        return true;
    }

    /**
     * executes & returns or displays the template results
     *
     * @global array $app_list_strings
     * @global array $app_strings
     * @global array $mod_strings
     * @global array $sugar_config
     * @param string $resource_name
     * @param string|null $cache_id
     * @param string|null $compile_id
     * @param boolean $display
     * @return string
     */
    public function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        global $app_list_strings;
        global $app_strings;
        global $mod_strings;
        global $sugar_config;

        $themeResource =  $this->getThemeResource($resource_name);
        if (!empty($themeResource)){
            $resource_name = $themeResource;
        }


        $this->assign('APP_LIST_STRINGS', $app_list_strings);
        $this->assign('APP', $app_strings);
        $this->assign('MOD', $mod_strings);
        $this->assign('APP_CONFIG', $sugar_config);
        $errorLevelStored = 0;

        if (!empty($sugar_config['developerMode'])) {
            $level = isset($sugar_config['smarty_error_level']) ? $sugar_config['smarty_error_level'] : 0;
            $errorLevelStored = error_reporting();
            error_reporting($level);
        }
        $fetch = parent::fetch(get_custom_file_if_exists($resource_name), $cache_id, $compile_id, $display);

        if (!empty($sugar_config['developerMode'])) {
            error_reporting($errorLevelStored);
        }

        return $fetch;
    }

    /**
     * called for included templates
     * @param string $_smarty_include_tpl_file
     * @param string $_smarty_include_vars
     */
    function _smarty_include($params)
    {
        $params['smarty_include_tpl_file'] = get_custom_file_if_exists($params['smarty_include_tpl_file']);
        parent::_smarty_include($params);
    }

    /**
     * Log smarty error out to default log location
     * @param string $error_msg
     * @param integer $error_type
     */
    public function trigger_error($error_msg, $error_type = E_USER_WARNING)
    {
        $error_msg = htmlentities($error_msg);

        switch ($error_type) {
            case E_USER_ERROR:
                $GLOBALS['log']->error('Smarty: ' . $error_msg);
                break;
            case E_USER_WARNING:
                $GLOBALS['log']->warn('Smarty: ' . $error_msg);
                break;
            case E_USER_NOTICE:
                $GLOBALS['log']->error('Smarty: ' . $error_msg);
                break;
            case E_USER_DEPRECATED:
                $GLOBALS['log']->debug('Smarty: ' . $error_msg);
                break;
            default:
                $GLOBALS['log']->fatal('Smarty: ' . $error_type . ' ' . $error_msg);
                break;
        }
    }

    /**
     * Try and fetch the tpl from the theme folder
     * if the tpl exists in the theme folder then set the resource_name to the tpl in the theme folder.
     * otherwise fall back to the default tpl
     * @param $resource_name
     * @return string
     */
    public function getThemeResource($resource_name): string
    {
        $current_theme = SugarThemeRegistry::current();
        $theme_directory = (string)$current_theme;
        if (strpos ($resource_name, 'themes' . DIRECTORY_SEPARATOR . $theme_directory) === false) {
            $test_path = SUGAR_PATH . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $theme_directory . 
            DIRECTORY_SEPARATOR . $resource_name;
            if (file_exists($test_path)) {
                return 'themes' . DIRECTORY_SEPARATOR . $theme_directory . DIRECTORY_SEPARATOR . $resource_name;
            }
        }

        return '';
    }
}
