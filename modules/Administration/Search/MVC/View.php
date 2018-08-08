<?php
/**
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

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 01/08/18
 * Time: 15:45
 */

namespace SuiteCRM\Modules\Administration\Search\MVC;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

use Sugar_Smarty;
use SuiteCRM\Search\SearchWrapper;

require_once __DIR__ . '/../../../Home/UnifiedSearchAdvanced.php';

abstract class View
{
    protected $smarty;
    protected $file;

    /**
     * View constructor.
     * @param $file
     */
    public function __construct($file)
    {
        $this->smarty = new Sugar_Smarty();
        $this->file = $file;
    }

    public function preDisplay()
    {
        global $mod_strings;
        global $app_list_strings;
        global $app_strings;
        global $sugar_config;

        $errors = array();
        $this->smarty->assign('MOD', $mod_strings);
        $this->smarty->assign('APP', $app_strings);
        $this->smarty->assign('APP_LIST', $app_list_strings);
        $this->smarty->assign('LANGUAGES', get_languages());
        $this->smarty->assign('JAVASCRIPT', get_set_focus_js());
        $this->smarty->assign('error', $errors);
        $this->smarty->assign('BUTTONS', $this->getButtons());

        $this->smarty->assign('config', $sugar_config['search']);
    }

    /**
     * @return string
     */
    private function getButtons()
    {
        global $mod_strings;
        global $app_strings;

        return <<<EOQ
    <input title="{$app_strings['LBL_SAVE_BUTTON_TITLE']}"
        accessKey="{$app_strings['LBL_SAVE_BUTTON_KEY']}"
        class="button primary"
        type="submit"
        name="save"
        onclick="return check_form('ConfigureSettings');"
        value="{$app_strings['LBL_SAVE_BUTTON_LABEL']}" >&nbsp;
    <input title="{$mod_strings['LBL_CANCEL_BUTTON_TITLE']}" 
        onclick="document.location.href='index.php?module=Administration&action=index'"
        class="button"
        type="button"
        name="cancel"
        value="{$app_strings['LBL_CANCEL_BUTTON_LABEL']}" >
EOQ;
    }

    public function display()
    {
        $this->smarty->display($this->file);
    }

    /**
     * @return Sugar_Smarty
     */
    public function getSmarty()
    {
        return $this->smarty;
    }

    protected function getEngines()
    {
        $engines = [];

        foreach (SearchWrapper::getEngines() as $engine) {
            $engines[$engine] = translate('LBL_' . $this->from_camel_case($engine));
        }

        return $engines;
    }

    protected function from_camel_case($input, $uppercase = true)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        $return = implode('_', $ret);

        if ($uppercase) {
            $return = strtoupper($return);
        }

        return $return;
    }

    protected function getModules()
    {
        $s = new \UnifiedSearchAdvanced();
        $r = $s->retrieveEnabledAndDisabledModules();
        $r = array_merge($r['enabled'], $r['disabled']);

        $modules = [];

        foreach ($r as $module) {
            $modules[$module['module']] = $module['label'];
        }

        return $modules;
    }

    /**
     * Returns the configured search controller from the sugar config.
     *
     * If the value is, for some reason, not set, `null` is returned.
     *
     * @return string|null
     */
    protected function getSelectedController()
    {
        global $sugar_config;

        if (!isset($sugar_config['search']['controller'])) {
            return null;
        }

        return $sugar_config['search']['controller'];
    }
}