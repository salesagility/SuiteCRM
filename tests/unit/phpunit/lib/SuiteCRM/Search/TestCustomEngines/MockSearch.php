<?php

use SuiteCRM\Search\SearchEngine;
use SuiteCRM\Search\SearchQuery;

class MockSearch extends SearchEngine
{
    public function search(SearchQuery $query)
    {
        return ['foo'];
    }

    public function searchAndDisplay(SearchQuery $query)
    {
        echo $query->getSearchString();
    }
}
