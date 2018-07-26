<?php
/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 21/06/18
 * Time: 16:07
 */

namespace SuiteCRM\Search;

use SuiteCRM\Search\UI\MasterSearchFormController;
use SuiteCRM\Search\UI\MasterSearchResultsController;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * This abstract class offers the interface and utilities for other classes to be used as search engines.
 */
abstract class SearchEngine
{
    /**
     * Performs a search using the given query and shows a search view.
     *
     * The search view contains both a search bar and search results (if any).
     *
     * @param $query SearchQuery
     */
    public function searchAndView(SearchQuery $query)
    {
        $this->validateQuery($query);
        $this->displayForm($query);

        if (!$query->isEmpty()) {
            $results = $this->search($query);
            $this->displayResults($query, $results);
        }
    }

    /**
     * Shows the default search form (search bar and options) for a given search query.
     *
     * @param $query SearchQuery
     */
    public function displayForm(SearchQuery $query)
    {
        $controller = new MasterSearchFormController($query);
        $controller->display();
    }

    /**
     * Shows the default search results for the given search query and results.
     *
     * @param SearchQuery $query
     * @param array $results
     */
    public function displayResults(SearchQuery $query, array $results)
    {
        $controller = new MasterSearchResultsController($query, $results);
        $controller->display();
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
     * @param SearchQuery $query
     * @return array[] ids
     */
    public abstract function search(SearchQuery $query);

    /**
     * This method should be extend to sanitize and standardise the request to fill all the values as they are expected
     * to be by the `search()` method.
     *
     * If it is impossible to validate the query a `MasterSearchInvalidRequestException` should be thrown.
     *
     * @param $query SearchQuery the query to validate
     * @throws \SuiteCRM\Search\Exceptions\MasterSearchInvalidRequestException if the query is not valid
     */
    protected abstract function validateQuery(SearchQuery &$query);
}