<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
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
 */

use AOW_Actions\FormulaCalculator\Exception\FormulaCalculatorException;

/**
 * A temporary autoloader for FormulaCalculator until the day we will be using composer's autoloader
 *
 * Class FormulaCalculatorPluginLoader
 */
class FormulaCalculatorPluginLoader
{
    /** @var string */
    protected static $projectRootPath;

    /** @var array */
    protected static $plugins = Array();

    /**
     *
     */
    public static function initialize()
    {
        self::$projectRootPath = dirname(dirname(dirname(__DIR__)));

        spl_autoload_register("FormulaCalculatorPluginLoader::load");
    }

    /**
     * @param string $function
     *
     * @throws FormulaCalculatorException
     *
     * @return \AOW_Actions\FormulaCalculator\Plugins\FormulaCalculatorPluginInterface
     */
    public static function getPluginInstanceForFunction($function)
    {
        if (!array_key_exists($function, self::$plugins)) {
            if (!$function) {
                throw new FormulaCalculatorException(__CLASS__ . ": No function name provided!");
            }

            $fqcn = null;
            $className = 'FormulaCalculator' . ucfirst($function) . 'Plugin';

            $fqcnTests = [];
            $fqcnTests["custom"] = '\Custom\AOW_Actions\FormulaCalculator\Plugins\\' . $className;
            $fqcnTests["core"] = '\AOW_Actions\FormulaCalculator\Plugins\\' . $className;

            foreach ($fqcnTests as $key => $class) {
                if (class_exists($class)) {
                    $fqcn = $class;
                }
            }

            if (!$fqcn) {
                throw new FormulaCalculatorException(__CLASS__ . ": Plugin class was not found for function("
                    . $function . ")! ");
            }

            $reflection = new ReflectionClass($fqcn);

            if (!$reflection->implementsInterface("\AOW_Actions\FormulaCalculator\Plugins\FormulaCalculatorPluginInterface")) {
                throw new FormulaCalculatorException(__CLASS__
                    . ": The loaded plugin does not implement the FormulaCalculatorPluginInterface interface!");
            }

            if (!$reflection->isSubclassOf("\AOW_Actions\FormulaCalculator\Plugins\FormulaCalculatorBasePlugin")) {
                throw new FormulaCalculatorException(__CLASS__
                    . ": The loaded plugin does not extend the FormulaCalculatorBasePlugin class!");
            }

            self::$plugins[$function] = $reflection->newInstanceWithoutConstructor();
        }

        return self::$plugins[$function];
    }

    /**
     * This method will only load classes with:
     *  - name: FormulaCalculator...Plugin
     *  - from namespaces:
     *          - \AOW_Actions\FormulaCalculator\Plugins
     *          - \Custom\AOW_Actions\FormulaCalculator\Plugins
     *
     * @param string $fqcn Fully Qualified Class Name
     */
    public static function load($fqcn)
    {
        $fqcnParts = explode("\\", $fqcn);
        if (!count($fqcnParts)) {
            return;
        }

        $className = array_pop($fqcnParts);
        if (!$className) {
            return;
        }

        if (!preg_match("#^FormulaCalculator.*Plugin$#", $className)) {
            return;
        }

        $classFullPath = self::getPathForFqcnParts($fqcnParts, $className);

        if (!file_exists($classFullPath)) {
            return;
        }

        require_once $classFullPath;
    }

    /**
     * @param array $fqcnParts
     * @param string $className
     *
     * @return string
     */
    protected static function getPathForFqcnParts($fqcnParts, $className)
    {
        $prefix = '/modules/';

        if ($fqcnParts[0] == "Custom") {
            array_shift($fqcnParts);
            $prefix = '/custom/modules/';
        }

        return self::$projectRootPath . $prefix . implode("/", $fqcnParts) . '/' . $className . '.php';
    }
}
