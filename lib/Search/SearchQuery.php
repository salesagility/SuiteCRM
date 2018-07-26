<?php
/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 21/06/18
 * Time: 16:09
 */

namespace SuiteCRM\Search;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Class SearchQuery
 *
 * The current format is the following:
 *
 * ```php
 * [
 *  'query' => 'search this',
 *  'from' => 0,
 *  'size' => 100,
 *  'options' => [...]
 * ]
 * ```
 *
 * Use one of the static `from*()` methods to initialize.
 *
 * @see fromString()
 * @see fromArray()
 */
class SearchQuery
{
    private $query;
    private $size;
    private $from;
    private $engine;
    /** @var array Structure containing additional search parameters */
    private $options = [];

    /**
     * SearchQuery constructor.
     *
     * @param string $searchString Search query
     * @param string|null $engine Name of the search engine to use. `null` will use the default as specified by the config
     * @param int $size Number of results
     * @param int $from Offset of the search. Used for pagination
     * @param array $options [optional] used for additional options by SearchEngines.
     */
    private function __construct($searchString, $engine = null, $size = 10, $from = 0, array $options = [])
    {
        $this->query = strval($searchString);
        $this->size = intval($size);
        $this->from = intval($from);
        $this->engine = strval($engine);
        $this->options = $options;
    }

    /**
     * The offset of the search results.
     *
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * The size of the search results.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return null|string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function isEmpty()
    {
        return empty($this->query);
    }

    /**
     * The query string if available.
     *
     * If a query object is present `null` is returned.
     *
     * @return string
     */
    public function getSearchString()
    {
        return $this->query;
    }

    /**
     * Makes the search string lowercase.
     */
    public function toLowerCase()
    {
        $this->query = strtolower($this->query);
    }

    /**
     * Trims the search string.
     */
    public function trim()
    {
        $this->query = trim($this->query);
    }

    /**
     * Replaces $what with $with in the search query string.
     *
     * @param $what
     * @param $with
     */
    public function replace($what, $with)
    {
        $this->query = str_replace($what, $with, $this->query);
    }

    /**
     * Removes forward facing slashes used for escaping in the query string.
     */
    public function stripSlashes()
    {
        $this->query = stripslashes($this->query);
    }

    /**
     * Escapes regular expressions so that they are not recognised as such in the query string.
     */
    public function escapeRegex()
    {
        $this->query = preg_quote($this->query, '/');
    }

    /**
     * Removes HTML entities and converts them in UTF-8 characters.
     */
    public function convertEncoding()
    {
        $this->query = mb_convert_encoding($this->query, 'UTF-8', 'HTML-ENTITIES');
    }

    /**
     * Creates a query object from a query string, i.e. from a search from.
     *
     * `$size` and `$from` are for pagination.
     *
     * @param $searchString string a search string, as it would appear on a search bar
     * @param int $size the number of results
     * @param int $from
     * @param string|null $engine Name of the search engine to use. Use default if `null`
     * @param array|null $options
     * @return SearchQuery a fully built query
     */
    public static function fromString($searchString, $size = 50, $from = 0, $engine = null, array $options = [])
    {
        return new self($searchString, $engine, $size, $from, $options);
    }

    /**
     * Makes a query from an array containing data.
     * Fields are:
     * - search-query-string
     * - search-engine
     * - search-query-size
     * - search-query-from
     *
     * @param array $request
     * @return SearchQuery
     */
    public static function fromRequestArray(array $request)
    {
        $searchQuery = filter_var($request['search-query-string'], FILTER_SANITIZE_STRING);
        $searchSize = filter_var($request['search-query-size'], FILTER_SANITIZE_NUMBER_INT);
        $searchFrom = filter_var($request['search-query-from'], FILTER_SANITIZE_NUMBER_INT);
        $searchEngine = filter_var($request['search-engine'], FILTER_SANITIZE_STRING);

        if (empty($searchQuery)) {
            $searchQuery = filter_var($request['query_string'], FILTER_SANITIZE_STRING);
        }

        if (empty($searchSize)) {
            $searchSize = 10;
        }

        unset(
            $request['search-query-string'],
            $request['query_string'],
            $request['search-query-size'],
            $request['search-engine']
        );

        return new self($searchQuery, $searchEngine, $searchSize, $searchFrom, $request);
    }

    /**
     * Makes a Query from a GET request.
     *
     * @see fromRequestArray
     * @return SearchQuery
     */
    public static function fromGetRequest()
    {
        return self::fromRequestArray($_GET);
    }
}