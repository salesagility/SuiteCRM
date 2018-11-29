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

class GoogleCalendarAuthHandler
{

    /**
     *
     * @var string
     */
    protected $tplPath = '';

    /**
     *
     * @var User
     */
    protected $currentUser = null;

    /**
     *
     * @var array
     */
    protected $request = null;

    /**
     *
     * @var array
     */
    protected $modStrings = null;

    /**
     *
     * @var Configurator
     */
    protected $configurator = null;

    /**
     *
     * @var Sugar_Smarty
     */
    protected $ss = null;

    /**
     *
     * @var javascript
     */
    protected $js = null;



    /**
     * Setup object
     *
     * @param  User         $current_user
     * @param               $request
     * @param               $mod_strings
     * @param  Configurator $config
     * @param  Sugar_Smarty $sugar_smarty
     * @param  javascript   $js
     * @return void
     */
    public function __construct(string $tpl_path, User $current_user, $request, $mod_strings, Configurator $config, Sugar_Smarty $sugar_smarty, javascript $js)
    {
        $this->currentUser  = $current_user;
        $this->request      = $request;
        $this->modStrings   = $mod_strings;
        $this->ss           = $sugar_smarty;
        $this->tplPath      = $tpl_path;
        $this->js           = $js;
        $this->configurator = $config;

        if (isset($this->request['do']) && $this->request['do'] == 'save') {
            $this->configurator->config['google_auth_json'] = !empty($this->request['google_auth_json']);
            $this->configurator->saveConfig();
            header('Location: index.php?module=Administration&action=index');
            exit();
        }

        $this->handleDisplay();
    }


    /**
     * This function handles displaying the template
     *
     * @return void
     */
    protected function handleDisplay()
    {
        $errors = array();

        // Check current user is admin
        if (!is_admin($this->currentUser)) {
            sugar_die("Unauthorized access to administration.");
        }

        $pageTitle = getClassicModuleTitle(
            "Administration",
            array(
                "<a href='index.php?module=Administration&action=index'>" . translate('LBL_MODULE_NAME', 'Administration') . "</a>",
                $this->modStrings['LBL_GOOGLE_AUTH_TITLE'],
            ),
            false
        );

        $this->ss->assign('PAGE_TITLE', $pageTitle);
        $this->ss->assign('LANGUAGES', get_languages());
        $this->ss->assign("JAVASCRIPT", get_set_focus_js());

        if (!array_key_exists('google_auth_json', $this->configurator->config)) {
            $this->configurator->config['google_auth_json'] = false;
        }

        $this->ss->assign('config', $this->configurator->config['google_auth_json']);

        // Check for Google Sync JSON
        $json = base64_decode($this->configurator->config['google_auth_json']);

        $gcConfig = json_decode($json, true);

        if ($gcConfig) {
            $this->ss->assign("GOOGLE_JSON_CONF", 'CONFIGURED');
            $this->ss->assign("GOOGLE_JSON_CONF_COLOR", 'green');
        } else {
            $this->ss->assign("GOOGLE_JSON_CONF", 'UNCONFIGURED');
            $this->ss->assign("GOOGLE_JSON_CONF_COLOR", 'black');
        }

        $this->js->setFormName('ConfigureSettings');
        $js = $this->js->getScript();

        $this->ss->assign('JAVASCRIPT', $js);

        $this->ss->assign('error', $errors);

        $this->ss->display($this->tplPath);
    }
}
