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

require_once('include/MVC/Controller/SugarController.php');
/**
 * MVC Controller Factory
 * @api
 */
class ControllerFactory
{
    /**
     * Obtain an instance of the correct controller.
     *
     * @return an instance of SugarController
     */
    public static function getController($module)
    {
        $logger = LoggerManager::getLogger();

        $controller = null;
        // below are the allowed class names for controller classes
        $class = ucfirst($module).'Controller';
        $customClass = 'Custom' . $class;
        // try all known controller locations
        if (file_exists('custom/modules/'.$module.'/controller.php')) {
            require_once('custom/modules/'.$module.'/controller.php');
            if (class_exists($customClass)) {
                $controller = new $customClass();
            } elseif (class_exists($class)) {
                    $controller = new $class();
            } else {
                $logger->warn('A custom controller was loaded from custom/modules/'.$module.'/controller.php, but it neither contains the class '.$class.', nor the custom class'.$customClass.'. This is most likely a programming error.');
            }
        } elseif (file_exists('modules/'.$module.'/controller.php')) {
            require_once('modules/'.$module.'/controller.php');
            if (class_exists($customClass)) {
                $controller = new $customClass();
            } elseif (class_exists($class)) {
                $controller = new $class();
            } else {
                $logger->warn('A controller was loaded from modules/'.$module.'/controller.php, but it neither contains the class '.$class.', nor the custom class'.$customClass.'. This is most likely a programming error.');
            }

        } elseif (file_exists('custom/include/MVC/Controller/SugarController.php')) {
            require_once('custom/include/MVC/Controller/SugarController.php');
            if (class_exists('CustomSugarController')) {
                $controller = new CustomSugarController();
            } else {
                $logger->warn('A custom controller was loaded from custom/include/MVC/Controller/SugarController.php, but it contains no CustomSugarController class. This is most likely a programming error.');
            }
        }
        // if controller is still unset, no custom controller could be loaded
        if ($controller == null) {
            // default to default controller in ALL other cases
            $logger->debug('Defaulting to the default SugarController.');
            $controller = new SugarController();
        }

        $controller->setup($module);
        return $controller;
    }
}
