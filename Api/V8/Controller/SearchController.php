<?php
namespace SuiteCRM\Api\V8\Controller;

use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

use SuiteCRM\Api\Core\Api;
use SuiteCRM\Api\V8\Library\SearchLib;

class SearchController extends Api
{

    function getSearchResults(Request $req, Response $res, $args)
    {
        global $container;
        if(!isset($_REQUEST['query_string']))
            return $this->generateResponse($res, 400, 'Incorrect parameters', 'Failure');
        else
        {
            if ($container["jwt"] !== null && $container["jwt"]->userId !== null)
            {
                $lib = new SearchLib();
                $results = $lib->getSearchResults($container["jwt"]->userId);
                return $this->generateResponse($res, 200, $results, 'Success');
            }
            else
            {
                return $this->generateResponse($res, 401, 'No user id', 'Failure');
            }


        }
    }

}