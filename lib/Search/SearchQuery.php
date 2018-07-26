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
 * <code>
 * [
 *  'from' => 0,
 *  'size' => 100,
 *  'query' => 'search this'
 * ]
 * </code>
 */
class SearchQuery
{
    public $query = [];

    /**
     * SearchQuery constructor.
     * @param array $query
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * The offset of the search results.
     *
     * @return int
     */
    public function getFrom()
    {
        return $this->query['from'];
    }

    /**
     * The size of the search results.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->query['size'];
    }

    /**
     * The query string if available.
     *
     * If a query object is present `null` is returned.
     *
     * @return string|null
     */
    public function getSearchString()
    {
        if (is_string($this->query['query'])) {
            return $this->query['query'];
        } else {
            return null;
        }
    }

    /**
     * Makes the search string lowercase.
     */
    public function toLowerCase()
    {
        $this->query['query'] = strtolower($this->query['query']);
    }

    /**
     * Trims the search string.
     */
    public function trim()
    {
        $this->query['query'] = trim($this->query['query']);
    }

    /**
     * Replaces $what with $with in the search query string.
     *
     * @param $what
     * @param $with
     */
    public function replace($what, $with)
    {
        $this->query['query'] = str_replace($what, $with, $this->query['query']);
    }

    /**
     * Removes forward facing slashes used for escaping in the query string.
     */
    public function stripSlashes()
    {
        $this->query['query'] = stripslashes($this->query['query']);
    }

    /**
     * Escapes regular expressions so that they are not recognised as such in the query string.
     */
    public function escapeRegex()
    {
        $this->query['query'] = preg_quote($this->query['query'], '/');
    }

    /**
     * Removes HTML entities and converts them in UTF-8 characters.
     */
    public function convertEncoding()
    {
        $this->query['query'] = mb_convert_encoding($this->query['query'], 'UTF-8', 'HTML-ENTITIES');
    }

    /**
     * Creates a query object from a query string, i.e. from a search from.
     *
     * `$size` and `$from` are for pagination.
     *
     * @param $searchString string a search string, as it would appear on a search bar
     * @param int $size the number of results
     * @param int $from
     * @return SearchQuery a fully built query
     */
    public static function fromString($searchString, $size = 50, $from = 0)
    {
        $query = [
            'from' => $from,
            'size' => $size,
            'query' => $searchString
        ];

        return new self($query);
    }
}