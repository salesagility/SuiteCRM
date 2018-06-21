<?php
/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 21/06/18
 * Time: 16:09
 */

namespace SuiteCRM\Search;


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


}