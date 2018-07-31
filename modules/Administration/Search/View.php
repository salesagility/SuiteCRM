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
 * Date: 30/07/18
 * Time: 14:35
 */

namespace SuiteCRM\Modules\Administration\Search;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

use SuiteCRM\Search\SearchWrapper;

require_once __DIR__ . '/../../Home/UnifiedSearchAdvanced.php';

class View
{
    public $smarty;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->smarty = new \Sugar_Smarty();
    }

    public function display()
    {
        global $mod_strings;
        global $app_list_strings;
        global $app_strings;
        global $sugar_config;

        $errors = array();
        //$buttons = $this->getButtons($app_strings, $mod_strings);
        $this->smarty->assign('MOD', $mod_strings);
        $this->smarty->assign('APP', $app_strings);
        $this->smarty->assign('APP_LIST', $app_list_strings);
        $this->smarty->assign('LANGUAGES', get_languages());
        $this->smarty->assign('JAVASCRIPT', get_set_focus_js());
        $this->smarty->assign('error', $errors);

        $this->smarty->assign('config', $sugar_config['search']);
        $this->smarty->assign('controllers', $this->getSearchControllers());
        $this->smarty->assign('engines', $this->getEngines());
        $this->smarty->assign('modules', $this->getModules());

        //$this->smarty->assign("BUTTONS", $buttons);

        $this->smarty->display('modules/Administration/Search/view.tpl');
    }

    private function getSearchControllers()
    {
        return [
            'Search' => 'Search (new)',
            'UnifiedSearch' => 'Global Unified Search (legacy)'
        ];
    }

    private function getEngines()
    {
        $engines = [];

        foreach (SearchWrapper::getEngines() as $engine) {
            $engines[$engine] = translate('LBL_' . $this->from_camel_case($engine));
        }

        return $engines;
    }

    private function from_camel_case($input, $uppercase = true)
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

    private function getModules()
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
}