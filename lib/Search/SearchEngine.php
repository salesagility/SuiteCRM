<?php

namespace SuiteCRM\Search;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

use SuiteCRM\Search\Exceptions\SearchInvalidRequestException;
use SuiteCRM\Search\UI\SearchFormController;
use SuiteCRM\Search\UI\SearchResultsController;

/**
 * This abstract class offers the interface and utilities for other classes to be used as search engines.
 */
abstract class SearchEngine
{
    /**
     * Performs a search using the search engine and returns a list SearchResults instance.
     *
     * @param SearchQuery $query
     *
     * @return SearchResults
     */
    abstract public function search(SearchQuery $query);

    /**
     * Performs a search using the given query and shows a search view.
     *
     * The search view contains both a search bar and search results (if any).
     *
     * @param SearchQuery $query
     */
    public function searchAndDisplay(SearchQuery $query)
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
     * @param SearchQuery $query
     */
    public function displayForm(SearchQuery $query)
    {
        $controller = new SearchFormController($query);
        $controller->display();
    }

    /**
     * Shows the default search results for the given search query and results.
     *
     * @param SearchQuery   $query
     * @param SearchResults $results
     */
    public function displayResults(SearchQuery $query, SearchResults $results)
    {
        $controller = new SearchResultsController($query, $results);
        $controller->display();
    }

    /**
     * This method should be extended to sanitize and standardise the request to fill all the values as they are
     * expected to be by the `search()` method.
     *
     * By default the query gets white spaces trimmed.
     *
     * If it is impossible to validate or sanitize the query a `SearchInvalidRequestException` should be thrown.
     *
     * @param SearchQuery $query the query to validate
     *
     * @throws SearchInvalidRequestException if the query is not valid
     */
    protected function validateQuery(SearchQuery &$query)
    {
        $query->trim();
    }
}
