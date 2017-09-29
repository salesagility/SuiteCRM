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

use League\JsonGuard\Dereferencer;
use League\JsonGuard\RuleSets\DraftFour;
use League\JsonGuard\Validator;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use SuiteCRM\API\JsonApi\v1\JsonApi;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\InvalidJsonApiResponse;
use SuiteCRM\API\v8\Exception\NotAcceptable;
use SuiteCRM\API\v8\Exception\UnsupportedMediaType;
use SuiteCRM\Utility\SuiteLogger as Logger;

class ApiController implements LoggerAwareInterface
{
    const CONTENT_TYPE = 'application/vnd.api+json';
    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    public function construct()
    {
        $this->setLogger(new Logger());
    }

    /**
     * @param Response $responseObject
     * @param int $status
     * @param mixed $data
     * @param string $message
     * @return Response
     * @throws \InvalidArgumentException
     * @throws NotAcceptable
     * @throws UnsupportedMediaType
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
            ->withHeader('Content-type', self::CONTENT_TYPE)
            ->write(json_encode($response, JSON_PRETTY_PRINT));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $payload
     * @return Response
     * @throws InvalidJsonApiResponse
     * @throws \InvalidArgumentException
     * @throws NotAcceptable
     * @throws UnsupportedMediaType
     */
    public function generateJsonApiResponse(Request $request, Response $response, $payload)
    {
        $negotiated = $this->negotiatedJsonApiContent($request, $response);
        if (in_array($negotiated->getStatusCode(), array(415, 406), true)) {
            // return error instead of response
            return $negotiated;
        }

        // Validate Response
        $jsonApi = new JsonApi();
        $data = json_decode(json_encode($payload));

        $ruleSet =  new DraftFour();
        $dereferencer = new Dereferencer();
        $schema = $dereferencer->dereference('file://'.$jsonApi->getSchemaPath());

        $validator = new Validator($data, $schema, $ruleSet);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $errors[0];
            $exception = new InvalidJsonApiResponse($error->getMessage(). ' Keyword:'. $error->getKeyword());
            $exception->setSource($error->getPointer());
            throw $exception;
        }

        return $response
            ->withHeader('Content-Type', self::CONTENT_TYPE)
            ->write(json_encode($payload));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $payload
     * @return $this|Response
     * @throws ApiException
     * @throws \InvalidArgumentException
     * @throws NotAcceptable
     * @throws UnsupportedMediaType
     */
    public function generateJsonApiListResponse(Request $request, Response $response, $payload)
    {
        $negotiated = $this->negotiatedJsonApiContent($request, $response);
        if (in_array($negotiated->getStatusCode(), array(415, 406), true)) {
            // return error instead of response
            return $negotiated;
        }

        if (!isset($payload['data']) && !is_array($payload['data'])) {
            throw new ApiException('[generateJsonApiListResponse expects a list]');
        }


        return $response
            ->withHeader('Content-Type', self::CONTENT_TYPE)
            ->write(json_encode($payload));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param \Exception|ApiException $exception
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function generateJsonApiExceptionResponse(Request $request, Response $response, \Exception $exception)
    {
        $jsonError = array(
            'code' => $exception->getCode(),
            'title' => $exception->getMessage(),
        );

        if (null === $this->logger) {
            $this->setLogger(new Logger());
        }

        if (is_subclass_of($exception, ApiException::class)) {
            $jsonError['detail'] = $exception->getDetail();
            $jsonError['source'] = $exception->getSource();
            $response = $response->withStatus($exception->getHttpStatus());
            $logMessage =
                ' Code: [' . $exception->getCode() . ']' .
                ' Status: [' . $exception->getHttpStatus() . ']' .
                ' Message: ' . $exception->getMessage() .
                ' Detail: ' . $exception->getDetail() .
                ' Source: [' . $exception->getSource()['pointer'] . ']';
            $this->logger->log($exception->getLogLevel(), $logMessage);
        } else {
            $response = $response->withStatus(400);
            $logMessage = $exception->getMessage();
            $this->logger->error($logMessage);
        }



        $jsonError['status'] = $response->getStatusCode();

        $payload = array(
            'errors' => array(
                $jsonError
            )
        );

        return $response
            ->withHeader('Content-Type', self::CONTENT_TYPE)
            ->write(json_encode($payload));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws NotAcceptable
     * @throws UnsupportedMediaType
     */
    public function negotiatedJsonApiContent(Request $request, Response $response)
    {
        if ($request->getContentType() !== self::CONTENT_TYPE) {
            throw new UnsupportedMediaType();
        }

        $header = $request->getHeader('Accept');
        if (empty($header) || count($header) !== 1 || $header[0] !== self::CONTENT_TYPE) {
            throw new NotAcceptable();
        }

        if ($this->logger === null) {
            $this->setLogger(new Logger());
        }

        $this->logger->debug('Json ApiController negotiated content type Successfully');

        return $response;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
