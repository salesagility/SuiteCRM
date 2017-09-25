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

namespace SuiteCRM\API\v8\Controller;

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use SuiteCRM\Utility\SuiteLogger as Logger;

class ApiController
{
    /**
     * @param Response $responseObject
     * @param int      $status
     * @param mixed    $data
     * @param string   $message
     *
     * @return Response
     */
    public function generateJwtResponse(Response $responseObject, $status, $data, $message)
    {
        $response = array(
            'status' => $status,
            'data' => $data,
            'message' => $message,
        );

        return $responseObject
            ->withStatus($status)
            ->withHeader('Content-type', 'application/json')
            ->write(json_encode($response, JSON_PRETTY_PRINT));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $payload
     * @return Response
     */
    public function generateJsonApiResponse(Request $request, Response $response, $payload)
    {
        $negotiated = $this->negotiatedJsonApiContent($request, $response);
        if(in_array($negotiated->getStatusCode(), array(415, 406), true)) {
            // return error instead of response
            return $negotiated;
        }

        return $response
            ->withHeader('Content-type', 'application/vnd.api+json')
            ->write(json_encode($payload));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param \Exception $exception
     * @return Response
     */
    public function generateJsonApiExceptionResponse(Request $request, Response $response, \Exception $exception)
    {
        $log = new Logger();
        $log->error($exception->getCode().' '. $exception->getMessage());
        $payload = array(
            'errors' => array(
                array(
                    'status' => $response->getStatusCode(),
                    'code' => $exception->getCode(),
                    'title' => $exception->getMessage(),
                    'detail' => $exception->getTraceAsString()
                )
            )
        );
       return $this->generateJsonApiResponse($request, $response, $payload);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    private function negotiatedJsonApiContent(Request $request, Response $response)
    {
        $log = new Logger();
        if($request->getContentType() !== 'application/vnd.api+json') {
            $data = array(
                'errors' => array(
                    array(
                        'status' => 415,
                        'title' => 'Unsupported Media Type',
                        'detail' => 'Json API expects the content type to be application/vnd.API+json'
                    )
                )
            );

            $log->error('Json API expects the content type to be application/vnd.API+json');

            return $response
                ->withStatus(415)
                ->withHeader('Content-type', 'application/vnd.api+json')
                ->write(json_encode($data));
        }

        $header = $request->getHeader('Accept');
        if(count($header) === 1 && $header[0] !== 'application/vnd.api+json') {
            $data = array(
                'errors' => array(
                    array(
                        'status' => 406,
                        'title' => 'Not Acceptable',
                        'detail' => 'Json API expects the client to accept application/vnd.API+json'
                    )
                )
            );
            $log->error('Json API expects the client to accept application/vnd.API+json');
            return $response
                ->withStatus(406)
                ->withHeader('Content-type', 'application/vnd.api+json')
                ->write(json_encode($data));
        }

        $log->debug('Json ApiController negotiated content type Successfully');
        return $response;
    }
}
