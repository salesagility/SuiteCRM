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

namespace SuiteCRM\Search;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Class MasterSearch performs a unified search using one of the available search engines.
 *
 * @author Vittorio Iocolano
 */
class MasterSearch
{
    /**
     * @var array stores an associative array matching the search engine class name with the file it is stored in.
     */
    private static $engines = [
        'ElasticSearchEngine' => 'lib/Search/ElasticSearch/ElasticSearchEngine.php',
    ];

    /** @var float|null the number of seconds it took to perform the previous search */
    private static $searchTime = null;

    /** @var string Path to the folder where to load custom engines from */
    const CUSTOM_ENGINES_PATH = __DIR__ . '/../../custom/Extension/SearchEngines/';

    /**
     * Perform a search with the given query and engine.
     *
     * @param $query SearchQuery
     */
    public static function searchAndView(SearchQuery $query)
    {
        if (empty($query->getEngine())) {
            // TODO use configurable default engine instead
            $engine = key(self::$engines);
        } else {
            $engine = $query->getEngine();
        }

        $engine = self::fetchEngine($engine);
        $engine->searchAndView($query);
    }

    /**
     * Performs various validation and retrieves an instance of a given search engine.
     *
     * It first searches in the default definitions array `self::$engines`,
     * then attempts to find a matching engine in the folder `self::CUSTOM_ENGINES_PATH`.
     *
     * @param $engineName string|SearchEngine
     * @return SearchEngine
     */
    private static function fetchEngine($engineName)
    {
        if (is_subclass_of($engineName, SearchEngine::class, false)) {
            return $engineName;
        } elseif (!is_string($engineName)) {
            throw new \InvalidArgumentException('$engineName should either be a string or a SearchEngine');
        }

        if (isset(self::$engines[$engineName])) {
            // Look in the $engines definitions first
            $filename = self::$engines[$engineName];
        } else {
            // Then look in the extension folder
            $filename = self::CUSTOM_ENGINES_PATH . $engineName . '.php';
        }

        if (!file_exists($filename)) {
            throw new \RuntimeException("Unable to find search file '$filename'' for engine '$engineName''.");
        }

        /** @noinspection PhpIncludeInspection */
        require_once $filename;

        if (!is_subclass_of($engineName, SearchEngine::class)) {
            throw new \RuntimeException("The provided class '$engineName' is not an instance of SearchEngine");
        }

        /** @var SearchEngine $engineName */
        $engineName = new $engineName();

        return $engineName;
    }

    /**
     * Perform a search with the given query and engine.
     *
     * Results are grouped by module.
     *
     * @param $engine string|SearchEngine
     * @param $query SearchQuery
     * @return array[] ids
     */
    public static function search($engine, SearchQuery $query)
    {
        $engine = self::fetchEngine($engine);

        $start = microtime(true);
        $results = $engine->search($query);
        $end = microtime(true);
        self::$searchTime = ($end - $start);

        return $results;
    }

    /**
     * Binds a class name / engine name to a file.
     *
     * @param $className string
     * @param $file string
     */
    public static function addEngine($className, $file)
    {
        self::$engines[$className] = $file;
    }

    /**
     * Retrieves the available search engines class names.
     *
     * @return string[]
     */
    public static function getEngines()
    {
        $default = array_keys(self::$engines);
        $custom = [];
        foreach (glob(self::CUSTOM_ENGINES_PATH . '*.php') as $file) {
            $file = pathinfo($file);
            $custom[] = $file['filename'];
        }
        return array_merge($default, $custom);
    }

    /*  @return float|null the number of seconds it took to perform the previous search */
    public static function getSearchTime()
    {
        return self::$searchTime;
    }

}