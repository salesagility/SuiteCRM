<?php

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
 * @see    fromString()
 * @see    fromArray()
 * @author Vittorio Iocolano
 */
class SearchQuery implements \JsonSerializable
{
    const DEFAULT_SEARCH_SIZE = 10;

    /** @var string Search query string */
    private $query;
    /** @var int The number of results per page */
    private $size;
    /** @var int The where to start */
    private $from;
    /** @var null|string Optional parameter to specify the SearchEngine (unqualified class name) to use. */
    private $engine;
    /** @var array Structure containing additional search parameters */
    private $options = [];

    /**
     * SearchQuery constructor.
     *
     * @param string      $searchString Search query
     * @param string|null $engine       Name of the search engine to use. `null` will use the default as specified by
     *                                  the config
     * @param int         $size         Number of results
     * @param int         $from         Offset of the search. Used for pagination
     * @param array       $options      [optional] used for additional options by SearchEngines.
     */
    private function __construct($searchString, $engine = null, $size = null, $from = 0, array $options = [])
    {
        $this->query = strval($searchString);
        $this->size = $size ? intval($size) : $this->getDefaultSearchSize();
        $this->from = intval($from);
        $this->options = $options;
        $this->engine = $engine !== null ? strval($engine) : null;
    }

    /**
     * Creates a query object from a query string, i.e. from a search from.
     *
     * `$size` and `$from` are for pagination.
     *
     * @param string      $searchString A string containing the search query.
     * @param int         $size         The number of results
     * @param int         $from         The results offset (for pagination)
     * @param string|null $engine       Name of the search engine to use. Use default if `null`
     * @param array|null  $options      Array with options (optional)
     *
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
     *
     * @return SearchQuery
     */
    public static function fromRequestArray(array $request)
    {
        $searchQuery = self::filterArray($request, 'search-query-string', '', FILTER_SANITIZE_STRING);
        $searchQueryAlt = self::filterArray($request, 'query_string', '', FILTER_SANITIZE_STRING);
        $searchSize = self::filterArray($request, 'search-query-size', null, FILTER_SANITIZE_NUMBER_INT);
        $searchFrom = self::filterArray($request, 'search-query-from', 0, FILTER_SANITIZE_NUMBER_INT);
        $searchEngine = self::filterArray($request, 'search-engine', null, FILTER_SANITIZE_STRING);

        if (!empty($searchQueryAlt) && empty($searchQuery)) {
            $searchQuery = $searchQueryAlt;
        }

        unset(
            $request['search-query-string'],
            $request['query_string'],
            $request['search-query-size'],
            $request['search-query-from'],
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

    /**
     * Validates and filters values from an array.
     *
     * @param array       $array   The array to filter
     * @param string      $key     The key of the array to load
     * @param mixed       $default The default value in case the array value is empty
     * @param null|string $filter  Optional filter to be used. e.g. FILTER_SANITIZE_STRING
     *
     * @return mixed
     */
    private static function filterArray(array $array, $key, $default, $filter = null)
    {
        if (!isset($array[$key])) {
            return $default;
        }

        $value = filter_var($array[$key], $filter);

        if ($value === false) {
            return $default;
        }

        return $value;
    }

    /**
     * The offset of the search results.
     *
     * @return int
     */
    public function getFrom()
    {
        return (int)$this->from;
    }

    /**
     * The size of the search results.
     *
     * @return int
     */
    public function getSize()
    {
        if ((int)$this->size < 0) {
            $this->size = 1;
        }
        return (int)$this->size;
    }

    /**
     * Get the default Search size by checking the config or falling back to Constant value
     *
     * @return int
     */
    public function getDefaultSearchSize()
    {
        global $sugar_config;

        if(isset($sugar_config['search']['query_size'])){
            return (int) $sugar_config['search']['query_size'];
        }

        if(isset($sugar_config['search']['pagination']['min'])){
            return (int) $sugar_config['search']['pagination']['min'];
        }

        return static::DEFAULT_SEARCH_SIZE;
    }

    /**
     * @return null|string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param $key
     *
     * @return mixed value
     */
    public function getOption($key)
    {
        return $this->options[$key];
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Checks if the query string is empty.
     *
     * @return bool
     */
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

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'query' => $this->query,
            'size' => $this->size,
            'from' => $this->from,
            'engine' => $this->engine,
            'options' => $this->options,
        ];
    }
}
