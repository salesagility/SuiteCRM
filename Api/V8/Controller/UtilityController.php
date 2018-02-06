<?php
namespace Api\V8\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class UtilityController extends AbstractApiController
{
    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function getVersion(Request $request, Response $response)
    {
        require_once SUGAR_PATH . '/suitecrm_version.php';

        return $this->generateResponse($response, 200, $GLOBALS['suitecrm_version'], 'Success');
    }
}
