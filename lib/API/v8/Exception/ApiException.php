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

namespace SuiteCRM\API\v8\Exception;


use SuiteCRM\API\v8\Controller\ApiController;
use SuiteCRM\Enumerator\ExceptionCode;
use SuiteCRM\Exception\Exception;

/**
 * Class ApiException
 * @package SuiteCRM\API\v8\Exception
 */
class ApiException extends Exception
{
    /**
     * @var array $source
     * @see https://tools.ietf.org/html/rfc6901
     */
    private $source = array('pointer' => '');

    /**
     * @var string $detail
     */
    private $detail = 'Api Version: 8';

    /**
     * ApiException constructor.
     * @param string $message API Exception "$message"
     * @param int $code
     * @param $previous
     */
    public function __construct($message = '', $code = ExceptionCode::API_EXCEPTION, $previous = null)
    {
        parent::__construct('[API] '.$message.'', $code, $previous);
    }

    /**
     * Gives addition details to what caused the exception
     * @see ApiController::generateJsonApiExceptionResponse()
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param string $detail
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }

    /**
     * @see ApiController::generateJsonApiExceptionResponse()
     * @see https://tools.ietf.org/html/rfc6901
     * @return array
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param $source
     * @see https://tools.ietf.org/html/rfc6901
     */
    public function setSource($source)
    {
        $this->source['pointer'] = $source;
    }

    /**
     * @return int http status code that should be returned back to the client
     * @see ApiController::generateJsonApiExceptionResponse()
     */
    public function getHttpStatus()
    {
        return 500;
    }
}