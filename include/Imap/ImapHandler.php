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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


require_once __DIR__ . '/ImapHandlerInterface.php';

/**
 * ImapHandler
 *
 * @author gyula
 */
class ImapHandler implements ImapHandlerInterface
{
    
    /**
     *
     * @var LoggerManager
     */
    protected $logger;
    
    /**
     *
     * @var resource|boolean
     */
    protected $stream;
    
    /**
     *
     * @var bool
     */
    protected $logErrors;
    
    /**
     *
     * @var bool
     */
    protected $logCalls;
    
    /**
     *
     * @param bool $log
     */
    public function __construct($logErrors = true, $logCalls = true)
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $this->logErrors = $logErrors;
        $this->logCalls = $logCalls;
        $this->logger = LoggerManager::getLogger();
    }
    
    /**
     *
     * @param array $errors
     */
    protected function log($errors)
    {
        if ($errors && $this->logErrors) {
            foreach ($errors as $error) {
                if ($error) {
                    $this->logger->warn('An Imap error detected: ' . json_encode($error));
                }
            }
        }
    }
    
    /**
     *
     * @param string $func
     * @param array $args
     */
    protected function logCall($func, $args)
    {
        if ($this->logCalls) {
            $this->logger->debug('IMAP wrapper called: ' . __CLASS__ . "::$func(" . json_encode($args) . ')');
        }
    }
    
    /**
     *
     * @param string $func
     * @param mixed $ret
     */
    protected function logReturn($func, $ret)
    {
        if ($this->logCalls) {
            $this->logger->debug('IMAP wrapper return: ' . __CLASS__ . "::$func(...) => " . json_encode($ret));
        }
    }
    
    /**
     *
     * @return boolean
     */
    public function close()
    {
        $this->logCall(__FUNCTION__, func_get_args());
        if (!$ret = imap_close($this->stream)) {
            $this->log(['IMAP close error']);
        }
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    /**
     *
     * @return array
     */
    public function getAlerts()
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_alerts();
        $this->log($ret);
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    /**
     *
     * @return resource|boolean
     */
    public function getConnection()
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = $this->stream;
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    /**
     *
     * @return array
     */
    public function getErrors()
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_errors();
        $this->log($ret);
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    /**
     *
     * @return string|boolean
     */
    public function getLastError()
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_last_error();
        $this->log([$ret]);
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    /**
     *
     * @param string $ref
     * @param string $pattern
     * @return array
     */
    public function getMailboxes($ref, $pattern)
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_getmailboxes($this->stream, $ref, $pattern);
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    /**
     *
     * @return boolean
     */
    public function isAvailable()
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = function_exists("imap_open") && function_exists("imap_timeout");
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    /**
     *
     * @param string $mailbox
     * @param string $username
     * @param string $password
     * @param int $options
     * @param int $n_retries
     * @param array|null $params
     * @return resource|boolean
     */
    public function open($mailbox, $username, $password, $options = 0, $n_retries = 0, $params = null)
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $this->stream = @imap_open($mailbox, $username, $password, $options, $n_retries, $params);
        if (!$this->stream) {
            $this->log(['IMAP open error']);
        }
        $this->logReturn(__FUNCTION__, $this->stream);
        return $this->stream;
    }

    /**
     *
     * @return boolean
     */
    public function ping()
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_ping($this->stream);
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }
    
    /**
     *
     * @param string $mailbox
     * @param int $options
     * @param int $n_retries
     * @return boolean
     */
    public function reopen($mailbox, $options = 0, $n_retries = 0)
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_reopen($this->stream, $mailbox, $options, $n_retries);
        if (!$ret) {
            $this->log(['IMAP reopen error']);
        }
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    /**
     *
     * @param int $timeout_type
     * @param int $timeout
     * @return mixed
     */
    public function setTimeout($timeout_type, $timeout = -1)
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_timeout($timeout_type, $timeout);
        if (!$ret) {
            $this->log(['IMAP set timeout error']);
        }
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    
    /**
     *
     * @param int $criteria
     * @param int $reverse
     * @param int $options
     * @param string $search_criteria
     * @param string $charset
     * @return array
     */
    public function sort($criteria, $reverse, $options = 0, $search_criteria = null, $charset = null)
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_sort($this->stream, $criteria, $reverse, $options, $search_criteria, $charset);
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    /**
     *
     * @param int $uid
     * @return int
     */
    public function getMessageNo($uid)
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_msgno($this->stream, $uid);
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }
    
    /**
     *
     * @param int $msg_number
     * @param int $fromlength
     * @param int $subjectlength
     * @param string $defaulthost
     * @return bool|object Returns FALSE on error or, if successful, the information in an object
     */
    public function getHeaderInfo($msg_number, $fromlength = 0, $subjectlength = 0, $defaulthost = null)
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_headerinfo($this->stream, $msg_number, $fromlength, $subjectlength, $defaulthost);
        if (!$ret) {
            $this->log(['IMAP get header info error']);
        }
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }
    
    /**
     *
     * @param type $msg_number
     * @param type $options
     * @return string
     */
    public function fetchHeader($msg_number, $options = 0)
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_fetchheader($this->stream, $msg_number, $options);
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    /**
     *
     * @param string $mailbox
     * @param string $message
     * @param string $options
     * @param string $internal_date
     * @return bool
     */
    public function append($mailbox, $message, $options = null, $internal_date = null)
    {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_append($this->stream, $msg_number, $fromlength, $subjectlength, $defaulthost);
        if (!$ret) {
            $this->log(['IMAP append error']);
        }
        $this->logReturn(__FUNCTION__, $ret);
        return $ret;
    }

    /**
     *
     * @param int $msg_number
     * @return int
     */
    public function getUid($msg_number) {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_uid($this->stream, $msg_number);
        $this->logReturn(__FUNCTION__, $ret);
    }
    
    /**
     * @return bool
     */
    public function expunge() {
        $this->logCall(__FUNCTION__, func_get_args());
        $ret = imap_append($this->stream);
        if (!$ret) {
            $this->log(['IMAP expunge error']);
        }
        $this->logReturn(__FUNCTION__, $ret);
    }

}
