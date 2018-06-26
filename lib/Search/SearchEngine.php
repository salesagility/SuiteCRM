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
     * Performs a search using the given query and returns a view to be displayed.
     *
     * @param $query SearchQuery
     * @return \SugarView
     */
    public function searchAndView($query)
    {
        $this->validateQuery($query);

        $this->search($query);

        return $this->makeView($this->search($query));
    }

    /**
     * Makes a default result view given a set of results.
     *
     * @param $results array
     * @return \SugarView
     */
    public function makeView($results)
    {
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
     * @throws MasterSearchInvalidRequestException if the query is not valid
     */
    protected abstract function validateQuery(&$query);
}