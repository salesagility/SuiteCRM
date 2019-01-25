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

/**
 * ResourceManager.php
 * This class is responsible for resource management of SQL queries, file usage, etc.
 */
class ResourceManager
{

    /**
     * @var ResourceManager $instance
     */
    private static $instance;

    /**
     * @var array $_observers
     */
    private $_observers = array();

    /**
     * The constructor; declared as private
     */
    private function __construct()
    {
    }

    /**
     * getInstance
     * Singleton method to return static instance of ResourceManager
     * @return ResourceManager The static singleton
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ResourceManager();
        } // if

        return self::$instance;
    }

    /**
     * setup
     * Handles determining the appropriate setup based on client type.
     * It will create a SoapResourceObserver instance if the $module parameter is set to
     * 'Soap'; otherwise, it will try to create a WebResourceObserver instance.
     * @param string $module The module value used to create the corresponding observer
     * @return boolean value indicating whether or not an observer was successfully setup
     */
    public function setup($module)
    {
        //Check if config.php exists
        if (!file_exists('config.php') || empty($module)) {
            return false;
        }

        if ($module == 'Soap') {
            require_once('include/resource/Observers/SoapResourceObserver.php');
            $observer = new SoapResourceObserver('Soap');
        } elseif (defined('SUITE_PHPUNIT_RUNNER')) {
            return;
        } else {
            require_once('include/resource/Observers/WebResourceObserver.php');
            $observer = new WebResourceObserver($module);
        }

        //Load config
        if (!empty($observer->module)) {
            $limit = 0;

            if (isset($GLOBALS['sugar_config']['resource_management'])) {
                $res = $GLOBALS['sugar_config']['resource_management'];
                if (!empty($res['special_query_modules']) &&
                    in_array($observer->module, $res['special_query_modules']) &&
                    !empty($res['special_query_limit']) &&
                    is_int($res['special_query_limit']) &&
                    $res['special_query_limit'] > 0
                ) {
                    $limit = $res['special_query_limit'];
                } else {
                    if (!empty($res['default_limit']) && is_int($res['default_limit']) && $res['default_limit'] > 0) {
                        $limit = $res['default_limit'];
                    }
                }
            } //if

            if ($limit) {
                $db = DBManagerFactory::getInstance();
                $db->setQueryLimit($limit);
                $observer->setLimit($limit);
                $this->_observers[] = $observer;
            }

            return true;
        }

        return false;
    }

    /**
     * notifyObservers
     * This method notifies the registered observers with the provided message.
     * @param string $msg Message from language file to notify observers with
     */
    public function notifyObservers($msg)
    {
        if (empty($this->_observers)) {
            return;
        }

        //Notify observers limit has been reached
        if (empty($GLOBALS['app_strings'])) {
            $GLOBALS['app_strings'] = return_application_language($GLOBALS['current_language']);
        }
        $limitMsg = $GLOBALS['app_strings'][$msg];
        foreach ($this->_observers as $observer) {
            $limit = $observer->limit;
            $module = $observer->module;
            $limitMsg = str_replace('$limit', $limit, $limitMsg);
            $limitMsg = str_replace('$module', $module, $limitMsg);
            $GLOBALS['log']->fatal($limitMsg);
            $observer->notify($limitMsg);
        }
    }


    /**
     * getObservers
     * Returns the observer instances that have been setup for the ResourceManager instance
     * @return array ResourceObserver(s)
     */
    public function getObservers()
    {
        return $this->_observers;
    }
}
