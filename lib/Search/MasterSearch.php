<?php
/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 21/06/18
 * Time: 16:13
 */

namespace SuiteCRM\Search;

class MasterSearch
{
    private static $engines = [
        'ElasticSearchEngine' => 'modules/ElasticSearch/ElasticSearchEngine.php',
    ];

    public static function searchAndView($engine, $query)
    {
        $engine = self::fetchEngine($engine);

        return $engine->searchAndView($query);
    }

    /**
     * Performs various validation and retrieves an instance of a given search engine.
     *
     * @param $engineName
     * @return SearchEngine
     */
    private static function fetchEngine($engineName)
    {
        if (!isset(self::$engines[$engineName])) {
            throw new \RuntimeException("Unable to find search engine $engineName.");
        }

        $filename = self::$engines[$engineName];

        if (!file_exists($filename)) {
            throw new \RuntimeException("Unable to find search file '$filename'' for engine '$engineName''.");
        }

        /** @noinspection PhpIncludeInspection */
        require_once self::$engines[$engineName];

        /** @var SearchEngine $engineName */
        $engineName = new $engineName();
        return $engineName;
    }

    /**
     * Binds a class name / engine name to a file.
     * @param $className
     * @param $file
     */
    public static function addEngine($className, $file)
    {
        self::$engines[$className] = $file;
    }
}