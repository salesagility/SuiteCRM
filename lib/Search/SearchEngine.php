<?php
/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 21/06/18
 * Time: 16:07
 */

namespace SuiteCRM\Search;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * This abstract class offers the interface and utilities for other classes to be used as search engines.
 */
abstract class SearchEngine
{
    /**
     * Performs a search using the given query and returns a view to be displayed.
     *
     * @param $query SearchQuery
     * @return \SugarView
     */
    public function searchAndView($query)
    {
        $this->validateQuery($query);
        $results = $this->search($query);
        return $this->makeView($results);
    }

    /**
     * Makes a default result view given a set of results.
     *
     * @param $results array
     * @return \SugarView
     */
    public function makeView($results)
    {
        // TODO
        return new \SugarView();
    }

    /**
     * Performs a search using the search engine and returns a list of ids in the following format:
     *
     * <code>
     * [
     *  'module1' => ['id1', 'id2', 'id3'],
     *  'module2' => ['id4', 'id5', 'id5'],
     * ]
     * </code>
     *
     * @param SearchQuery
     * @return array[] ids
     */
    public abstract function search($query);

    /**
     * This method should be extend to sanitize and standardise the request to fill all the values as they are expected
     * to be by the `search()` method.
     *
     * If it is impossible to validate the query a `MasterSearchInvalidRequestException` should be thrown.
     *
     * @param $query SearchQuery the query to validate
     * @throws \SuiteCRM\Search\Exceptions\MasterSearchInvalidRequestException if the query is not valid
     */
    protected abstract function validateQuery(&$query);
}