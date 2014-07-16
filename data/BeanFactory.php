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


require_once('data/SugarBean.php');

/**
 * Factory to create SugarBeans
 * @api
 */
class BeanFactory {
    protected static $loadedBeans = array();
    protected static $maxLoaded = 10;
    protected static $total = 0;
    protected static $loadOrder = array();
    protected static $touched = array();
    public static $hits = 0;

    /**
     * Returns a SugarBean object by id. The Last 10 loaded beans are cached in memory to prevent multiple retrieves per request.
     * If no id is passed, a new bean is created.
     * @static
     * @param String $module
     * @param String $id
     * @param Array $params A name/value array of parameters. Names: encode, deleted, 
     *        If $params is boolean we revert to the old arguments (encode, deleted), and use $params as $encode.
     *        This will be changed to using only $params in later versions.
     * @param Bool $deleted @see SugarBean::retrieve
     * @return SugarBean
     */
    public static function getBean($module, $id = null, $params = array(), $deleted = true)
    {
    	
    	// Check if params is an array, if not use old arguments
    	if (isset($params) && !is_array($params)) {
    		$params = array('encode' => $params);
    	}
    	
    	// Pull values from $params array
    	$encode = isset($params['encode']) ? $params['encode'] : true;
    	$deleted = isset($params['deleted']) ? $params['deleted'] : $deleted;
    	
        if (!isset(self::$loadedBeans[$module])) {
            self::$loadedBeans[$module] = array();
            self::$touched[$module] = array();
        }

        $beanClass = self::getBeanName($module);

        if (empty($beanClass) || !class_exists($beanClass)) return false;

        if (!empty($id))
        {
            if (empty(self::$loadedBeans[$module][$id]))
            {
                $bean = new $beanClass();
                $result = $bean->retrieve($id, $encode, $deleted);
                if($result == null)
                    return FALSE;
                else
                    self::registerBean($module, $bean, $id);
            } else
            {
                self::$hits++;
                self::$touched[$module][$id]++;
                $bean = self::$loadedBeans[$module][$id];
            }
        } else {
            $bean = new $beanClass();
        }

        return $bean;
    }

    public static function newBean($module)
    {
        return self::getBean($module);
    }

    public static function getBeanName($module)
    {
        global $beanList;
        if (empty($beanList[$module]))  return false;

        return $beanList[$module];
    }

    /**
     * Returns the object name / dictionary key for a given module. This should normally
     * be the same as the bean name, but may not for special case modules (ex. Case vs aCase)
     * @static
     * @param String $module
     * @return bool
     */
    public static function getObjectName($module)
    {
        global $objectList;
        if (empty($objectList[$module]))
            return self::getBeanName($module);

        return $objectList[$module];
    }


    /**
     * @static
     * This function registers a bean with the bean factory so that it can be access from accross the code without doing
     * multiple retrieves. Beans should be registered as soon as they have an id.
     * @param String $module
     * @param SugarBean $bean
     * @param bool|String $id
     * @return bool true if the bean registered successfully.
     */
    public static function registerBean($module, $bean, $id=false)
    {
        global $beanList;
        if (empty($beanList[$module]))  return false;

        if (!isset(self::$loadedBeans[$module]))
            self::$loadedBeans[$module] = array();

        //Do not double register a bean
        if (!empty($id) && isset(self::$loadedBeans[$module][$id]))
            return true;

        $index = "i" . (self::$total % self::$maxLoaded);
        //We should only hold a limited number of beans in memory at a time.
        //Once we have the max, unload the oldest bean.
        if (count(self::$loadOrder) >= self::$maxLoaded - 1)
        {
            for($i = 0; $i < self::$maxLoaded; $i++)
            {
                if (isset(self::$loadOrder[$index]))
                {
                    $info = self::$loadOrder[$index];
                    //If a bean isn't in the database yet, we need to hold onto it.
                    if (!empty(self::$loadedBeans[$info['module']][$info['id']]->in_save))
                    {
                        self::$total++;
                    }
                    //Beans that have been used recently should be held in memory if possible
                    else if (!empty(self::$touched[$info['module']][$info['id']]) && self::$touched[$info['module']][$info['id']] > 0)
                    {
                        self::$touched[$info['module']][$info['id']]--;
                        self::$total++;
                    }
                    else
                        break;
                } else {
                    break;
                }
                $index = "i" . (self::$total % self::$maxLoaded);
            }
            if (isset(self::$loadOrder[$index]))
            {
                unset(self::$loadedBeans[$info['module']][$info['id']]);
                unset(self::$touched[$info['module']][$info['id']]);
                unset(self::$loadOrder[$index]);
            }
        }

        if(!empty($bean->id))
           $id = $bean->id;

        if ($id)
        {
            self::$loadedBeans[$module][$id] = $bean;
            self::$total++;
            self::$loadOrder[$index] = array("module" => $module, "id" => $id);
            self::$touched[$module][$id] = 0;
        } else{
            return false;
        }
        return true;
    }
}

