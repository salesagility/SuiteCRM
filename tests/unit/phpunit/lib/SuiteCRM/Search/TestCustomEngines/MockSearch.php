<?php

use SuiteCRM\Search\SearchEngine;
use SuiteCRM\Search\SearchQuery;

class MockSearch extends SearchEngine
{
    /**
     * @param SearchQuery $query
     * @return string[]
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function search(SearchQuery $query)
    {
        return ['foo'];
    }

    /**
     * @param SearchQuery $query
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function searchAndDisplay(SearchQuery $query)
    {
        echo $query->getSearchString();
    }
}
