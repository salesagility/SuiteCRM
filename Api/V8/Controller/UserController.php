<?php

namespace SuiteCRM\Api\V8\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use SuiteCRM\Api\Core\Api;
use SuiteCRM\Api\V8\Library\UserLib;

class UserController extends Api
{
    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function getUpcomingActivities(Request $req, Response $res, array $args)
    {
        global $container;
        $lib = new UserLib();

        if ($container['jwt'] !== null && $container['jwt']->userId !== null) {
            $user = \BeanFactory::getBean('Users', $container['jwt']->userId);
            if ($user === false) {
                return $this->generateResponse($res, 401, 'No user id', 'Failure');
            } else {
                return $this->generateResponse($res, 200, json_encode($lib->getUpcomingActivities($user)), 'Success');
            }
        } else {
            return $this->generateResponse($res, 401, 'No user id', 'Failure');
        }
    }
}
