<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\Exception\ContainerException;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use SuiteCRM\API\JsonApi\v1\JsonApi;
use SuiteCRM\API\v8\Exception\ApiException;
use SuiteCRM\API\v8\Exception\InvalidJsonApiRequest;
use SuiteCRM\API\v8\Exception\InvalidJsonApiResponse;
use SuiteCRM\API\v8\Exception\NotAcceptable;
use SuiteCRM\API\v8\Exception\UnsupportedMediaType;
use SuiteCRM\Utility\Paths;
use SuiteCRM\Utility\SuiteLogger as Logger;

class ApiController implements LoggerAwareInterface
{
    const CONTENT_TYPE = 'application/vnd.api+json';
    const CONTENT_TYPE_JSON = 'application/vnd.api+json';
    const CONTENT_TYPE_HEADER = 'Content-Type';
    const LINKS = 'links';

    const VERSION_MAJOR = 8;
    const VERSION_MINOR = 0;
    const VERSION_PATCH = 0;
    const VERSION_STABILITY = 'ALPHA';

    /**
     * @var LoggerInterface $logger
     */
    protected $logger;

    /**
     * @var ContainerInterface $containers
     */
    protected $containers;


    /**
     * @var Paths $paths
     */
    protected $paths;

    /**
     * ApiController constructor.
     * @param ContainerInterface $containers
     * @throws ContainerException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function __construct(ContainerInterface $containers)
    {
        $this->containers = $containers;
        $this->paths = new Paths();
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
    protected function generateJsonApiResponse(Request $request, Response $response, $payload)
    {
        $negotiated = $this->negotiatedJsonApiContent($request, $response);
        if (in_array($negotiated->getStatusCode(), array(415, 406), true)) {
            // return error instead of response
            return $negotiated;
        }

        $payload['meta']['suiteapi'] = array(
          'major' => self::VERSION_MAJOR,
          'minor' => self::VERSION_MINOR,
          'patch' => self::VERSION_PATCH,
          'stability' => self::VERSION_STABILITY,
        );

        $jsonAPI = $this->containers->get('JsonApi');
        $payload['jsonapi'] = $jsonAPI->toJsonApiResponse();

        // Validate Response
        $data = json_decode(json_encode($payload));

        $validator = new \JsonSchema\Validator();
        $validator->validate($data, (object)['$ref' => 'file://' . realpath($jsonAPI->getSchemaPath())]);

        if (!$validator->isValid()) {
            $errors = $validator->getErrors();
            $this->logger->error( '[Invalid Payload Response]'. json_encode($payload));
            foreach ($errors as $error) {
                throw new InvalidJsonApiResponse($errors[0]['property']. ' ' .$errors[0]['message']);
            }
        }

        return $response
            ->withHeader(self::CONTENT_TYPE_HEADER, self::CONTENT_TYPE)
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

        $payload['meta']['suiteapi'] = array(
            'major' => self::VERSION_MAJOR,
            'minor' => self::VERSION_MINOR,
            'patch' => self::VERSION_PATCH,
            'stability' => self::VERSION_STABILITY,
        );

        /** @var JsonApi $jsonAPI */
        $jsonAPI = $this->containers->get('JsonApi');
        $payload['jsonapi'] = $jsonAPI->toJsonApiResponse();


        return $response
            ->withHeader(self::CONTENT_TYPE_HEADER, self::CONTENT_TYPE)
            ->write(json_encode($payload));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws NotAcceptable
     * @throws UnsupportedMediaType
     */
    protected function negotiatedJsonApiContent(Request $request, Response $response)
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
     * @param Request $request
     * @throws InvalidJsonApiRequest
     */
    protected function validateRequestWithJsonApiSchema(Request $request)
    {
        // Validate Response
        $jsonAPI = $this->containers->get('JsonApi');
        $data = json_decode($request->getBody());

        $validator = new \JsonSchema\Validator();
        $validator->validate($data, (object)['$ref' => 'file://' . realpath($jsonAPI->getSchemaPath())]);

        if (!$validator->isValid()) {
            $errors = $validator->getErrors();
            $this->logger->error( '[Invalid Payload Request]'. $request->getBody());
            throw new InvalidJsonApiRequest($errors[0]['property']. ' ' .$errors[0]['message']);
        }
    }

    /**
     * @return int
     */
    public function getVersionMajor()
    {
        return self::VERSION_MAJOR;
    }

    /**
     * @return int
     */
    public function getVersionMinor()
    {
        return self::VERSION_MINOR;
    }

    /**
     * @return int
     */
    public function getVersionPatch()
    {
        return self::VERSION_PATCH;
    }

    /**
     * @return string
     */
    public function getVersionStability()
    {
        return self::VERSION_STABILITY;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
