<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

namespace SuiteCRM\api\v8\controller;

use Slim\Http\Request;
use Slim\Http\Response;
use SuiteCRM\api\core\Api;
use SuiteCRM\api\v8\library\UtilityLib;

class UtilityController extends Api
{
    //default time in seconds that the token is valid for
    const JWT_EXP_TIME = 14400;

    /**
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     */
    public function getServerInfo(Request $req, Response $res, array $args)
    {
        $lib = new UtilityLib();
        $server_info = $lib->getServerInfo();

        return $this->generateJwtResponse($res, 200, $server_info, 'Success');
    }

    /**
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     */
    public function login(Request $req, Response $res, array $args)
    {
        global $sugar_config;

        $data = $req->getParsedBody();

        $lib = new UtilityLib();
        $login = $lib->login($data);

        $expTime = !empty($sugar_config['api']['timeout']) ? (int)$sugar_config['api']['timeout'] : self::JWT_EXP_TIME;

        if ($login['loginApproved']) {
            $token = [
                'userId' => $login['userId'],
                'exp' => time() + $expTime,
            ];

            //Create the token
            $jwt = \Firebase\JWT\JWT::encode($token, $sugar_config['unique_key']);
            setcookie('SUITECRM_REST_API_TOKEN', json_encode($jwt), null, null, null, isSSL(), true);

            $res = $res->withHeader('Cache-Control', 'no-cache')->withHeader('Pragma', 'no-cache');

            return $this->generateJwtResponse($res, 200, $jwt, 'Success');
        }

        return $this->generateJwtResponse($res, 401, null, 'Unauthorised');
    }

}
