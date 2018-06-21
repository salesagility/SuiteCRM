<?php
/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 21/06/18
 * Time: 16:07
 */

namespace SuiteCRM\Search;


abstract class SearchEngine
{
    /**
     * @param $query SearchQuery
     * @return \SugarView
     */
    public abstract function searchAndView($query);
}