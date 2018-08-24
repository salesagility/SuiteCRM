<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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

/**
 * Registry for all the current classes in the system
 */
class SugarThemeRegistry
{
    /**
     * Array of all themes and thier object
     *
     * @var array
     */
    private static $_themes = array();

    /**
     * Name of the current theme; corresponds to an index key in SugarThemeRegistry::$_themes
     *
     * @var string
     */
    private static $_currentTheme;

    /**
     * Disable the constructor since this will be a singleton
     */
    private function __construct()
    {
    }

    /**
     * Adds a new theme to the registry
     *
     * @param $themedef array
     */
    public static function add(
        array $themedef
        ) {
        // make sure the we know the sugar version
        global $suitecrm_version;
        if (empty($suitecrm_version)) {
            include('suitecrm_version.php');
        }

        if (!isset($themedef['version']['regex_matches'])) {
            $themedef['version']['regex_matches'] = array('^7\.[0-8][^\d]');
        }

        // Check to see if theme is valid for this version of Sugar; return false if not

        $versionOk = false;
        if (isset($themedef['version']['exact_matches'])) {
            $matches_empty = false;
            foreach ($themedef['version']['exact_matches'] as $match) {
                if ($match == $GLOBALS['suitecrm_version']) {
                    $versionOk = true;
                }
            }
        }
        if (!$versionOk && isset($themedef['version']['regex_matches'])) {
            $matches_empty = false;
            foreach ($themedef['version']['regex_matches'] as $match) {
                if (preg_match("/$match/", $GLOBALS['suitecrm_version'])) {
                    $versionOk = true;
                }
            }
        }
        if (!$versionOk) {
            return false;
        }

        $theme = new SugarTheme($themedef);
        self::$_themes[$theme->dirName] = $theme;
    }

    /**
     * Removes a new theme from the registry
     *
     * @param $themeName string
     */
    public static function remove(
        $themeName
        ) {
        if (self::exists($themeName)) {
            unset(self::$_themes[$themeName]);
        }
    }

    /**
     * Returns a theme object in the registry specified by the given $themeName
     *
     * @param $themeName string
     */
    public static function get(
        $themeName
        ) {
        if (isset(self::$_themes[$themeName])) {
            return self::$_themes[$themeName];
        }
    }

    /**
     * Returns the current theme object
     *
     * @return SugarTheme object
     */
    public static function current()
    {
        if (!isset(static::$_currentTheme)) {
            self::buildRegistry();
        }

        if (self::$_currentTheme === null && !empty(self::$_themes)) {
            $themes = array_keys(self::$_themes);
            self::$_currentTheme = $themes[0];
        }

        $current_theme = self::$_currentTheme;
        return self::$_themes[$current_theme];
    }

    /**
     * Returns the default theme object
     *
     * @return SugarTheme object
     */
    public static function getDefault()
    {
        if (!isset(self::$_currentTheme)) {
            self::buildRegistry();
        }

        if (isset($GLOBALS['sugar_config']['default_theme']) && self::exists($GLOBALS['sugar_config']['default_theme'])) {
            return self::get($GLOBALS['sugar_config']['default_theme']);
        }
        $array_keys = array_keys(self::availableThemes());
        return self::get(array_pop($array_keys));
    }

    /**
     * Returns true if a theme object specified by the given $themeName exists in the registry
     *
     * @param  $themeName string
     * @return bool
     */
    public static function exists(
        $themeName
        ) {
        return (self::get($themeName) !== null);
    }

    /**
     * Sets the given $themeName to be the current theme
     *
     * @param  $themeName string
     */
    public static function set(
        $themeName
        ) {
        if (!self::exists($themeName)) {
            return false;
        }

        self::$_currentTheme = $themeName;

        // set some of the expected globals
        $GLOBALS['barChartColors'] = self::current()->barChartColors;
        $GLOBALS['pieChartColors'] = self::current()->pieChartColors;
        return true;
    }

    /**
     * Builds the theme registry
     */
    public static function buildRegistry()
    {
        self::$_themes = array();
        $dirs = array("themes/","custom/themes/");

        // check for a default themedef file
        $themedefDefault = array();
        if (is_file("custom/themes/default/themedef.php")) {
            $themedef = array();
            require("custom/themes/default/themedef.php");
            $themedefDefault = $themedef;
        }

        foreach ($dirs as $dirPath) {
            if (is_dir('./'.$dirPath) && is_readable('./'.$dirPath) && $dir = opendir('./'.$dirPath)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file == ".."
                            || $file == "."
                            || $file == ".svn"
                            || $file == "CVS"
                            || $file == "Attic"
                            || $file == "default"
                            || !is_dir("./$dirPath".$file)
                            || !is_file("./{$dirPath}{$file}/themedef.php")
                            ) {
                        continue;
                    }
                    $themedef = array();
                    require("./{$dirPath}{$file}/themedef.php");
                    $themedef = array_merge($themedef, $themedefDefault);
                    $themedef['dirName'] = $file;
                    // check for theme already existing in the registry
                    // if so, then it will override the current one
                    if (self::exists($themedef['dirName'])) {
                        $existingTheme = self::get($themedef['dirName']);
                        foreach (SugarTheme::getThemeDefFields() as $field) {
                            if (!isset($themedef[$field])) {
                                $themedef[$field] = $existingTheme->$field;
                            }
                        }
                        self::remove($themedef['dirName']);
                    }
                    if (isset($themedef['name'])) {
                        self::add($themedef);
                    }
                }
                closedir($dir);
            }
        }
        // default to setting the default theme as the current theme
        if (!isset($GLOBALS['sugar_config']['default_theme']) || !self::set($GLOBALS['sugar_config']['default_theme'])) {
            if (count(self::availableThemes()) == 0) {
                sugar_die('No valid themes are found on this instance');
            } else {
                self::set(self::getDefaultThemeKey());
            }
        }
    }


    /**
     * getDefaultThemeKey
     *
     * This function returns the default theme key.  It takes into account string casing issues that may arise
     * from upgrades.  It attempts to look for the Sugar theme and if not found, defaults to return the name of the last theme
     * in the array of available themes loaded.
     *
     * @return $defaultThemeKey String value of the default theme key to use
     */
    private static function getDefaultThemeKey()
    {
        $availableThemes = self::availableThemes();
        foreach ($availableThemes as $key=>$theme) {
            if (strtolower($key) == 'sugar') {
                return $key;
            }
        }
        $array_keys = array_keys($availableThemes);
        return array_pop($array_keys);
    }


    /**
     * Returns an array of available themes. Designed to be absorbed into get_select_options_with_id()
     *
     * @return array
     */
    public static function availableThemes()
    {
        $themelist = array();
        $disabledThemes = array();
        if (isset($GLOBALS['sugar_config']['disabled_themes'])) {
            $disabledThemes = explode(',', $GLOBALS['sugar_config']['disabled_themes']);
        }

        foreach (self::$_themes as $themename => $themeobject) {
            if (in_array($themename, $disabledThemes)) {
                continue;
            }
            $themelist[$themeobject->dirName] = $themeobject->name;
        }
        asort($themelist, SORT_STRING);
        if (count($themelist)==0) {
            $GLOBALS['log']->fatal('availableThemes() is returning an empty array! Check disabled_themes in config.php and config_override.php');
        }
        return $themelist;
    }

    /**
     * Returns an array of un-available themes. Designed used with the theme selector in the admin panel
     *
     * @return array
     */
    public static function unAvailableThemes()
    {
        $themelist = array();
        $disabledThemes = array();
        if (isset($GLOBALS['sugar_config']['disabled_themes'])) {
            $disabledThemes = explode(',', $GLOBALS['sugar_config']['disabled_themes']);
        }

        foreach (self::$_themes as $themename => $themeobject) {
            if (in_array($themename, $disabledThemes)) {
                $themelist[$themeobject->dirName] = $themeobject->name;
            }
        }

        return $themelist;
    }

    /**
     * Returns an array of all themes found in the current installation
     *
     * @return array
     */
    public static function allThemes()
    {
        $themelist = array();

        foreach (self::$_themes as $themename => $themeobject) {
            $themelist[$themeobject->dirName] = $themeobject->name;
        }

        return $themelist;
    }

    /**
     * Returns an array of all themes def found in the current installation
     *
     * @return array
     */
    public static function allThemesDefs()
    {
        $themelist = array();
        $disabledThemes = array();
        if (isset($GLOBALS['sugar_config']['disabled_themes'])) {
            $disabledThemes = explode(',', $GLOBALS['sugar_config']['disabled_themes']);
        }

        foreach (self::$_themes as $themename => $themeobject) {
            $themearray['name'] = $themeobject->name;
            $themearray['configurable'] = $themeobject->configurable;
            $themearray['enabled'] = !in_array($themename, $disabledThemes);
            $themelist[$themeobject->dirName] = $themearray;
        }

        return $themelist;
    }

    /**
     * get the configurable options for $themeName
     *
     * @param  $themeName string
     */
    public static function getThemeConfig($themeName)
    {
        global $sugar_config;

        if (!self::exists($themeName)) {
            return false;
        }

        $config = array();

        foreach (self::$_themes[$themeName]->config_options as $name => $def) {
            $config[$name] = $def;

            $value = '';
            if (isset($sugar_config['theme_settings'][$themeName][$name])) {
                $value = $sugar_config['theme_settings'][$themeName][$name];
            } elseif (isset($def['default'])) {
                $value = $def['default'];
            }
            $config[$name]['value'] = $value;
        }

        return $config;
    }

    /**
     * Clears out the cached path locations for all themes
     */
    public static function clearAllCaches()
    {
        foreach (self::$_themes as $themeobject) {
            $themeobject->clearCache();
        }
    }

    public static function getSubThemes()
    {
        global $mod_strings;
        $current = self::current();
        $themeConfig = self::getThemeConfig($current->dirName);
        $subThemes = isset($themeConfig['sub_themes']['options'])
            ? reset($themeConfig['sub_themes']['options']) : [];
        foreach ($subThemes as $key => &$subTheme) {
            $subTheme = isset($mod_strings['LBL_SUBTHEME_OPTIONS_' . strtoupper($key)]) ?
                $mod_strings['LBL_SUBTHEME_OPTIONS_' . strtoupper($key)] : $subTheme;
        }
        return $subThemes;
    }

    public static function getSubThemeDefault()
    {
        $current = self::current();
        $themeConfig = self::getThemeConfig($current->dirName);
        $subThemes = isset($themeConfig['sub_themes']['value']) ? $themeConfig['sub_themes']['value'] : null;
        return $subThemes;
    }
}
