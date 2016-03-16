<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Created by Adam Jakab.
 * Date: 14/03/16
 * Time: 8.45
 */
class DevelRequestStats {
    /** @var int */
    protected $requestNumber;

    /** @var  \DateTime */
    protected $executionTime;

    /** @var  int */
    protected $executionLength = 0;

    /** @var  int */
    protected $memoryUsage = 0;

    /** @var  int */
    protected $memoryPeakUsage = 0;

    /** @var  array */
    protected $php_get;

    /** @var  array */
    protected $php_post;

    /** @var  array */
    protected $php_files;

    /** @var  array */
    protected $php_server;

    /** @var  array */
    protected $php_session;

    /** @var  array */
    protected $php_cookie;

    /** @var  array */
    protected $php_env;

    /** @var int */
    protected $totalQueryCount = 0;

    /** @var array */
    protected $executedQueries = [];

    /**
     * @param int $requestNumber
     */
    public function __construct($requestNumber) {
        $this->requestNumber = $requestNumber;
        $this->executionTime = new \DateTime();
    }

    public function registerExecutedQuery($sql) {
        if ($sql) {
            array_push($this->executedQueries, $sql);
            $this->totalQueryCount = count($this->executedQueries);
        }
    }

    public function registerShutdownValues() {
        $this->php_get = $_GET;
        $this->php_post = $_POST;
        $this->php_files = $_FILES;
        $this->php_server = $_SERVER;
        $this->php_session = $_SESSION;
        $this->php_cookie = $_COOKIE;
        $this->php_env = $_ENV;

        $this->executionLength = microtime(TRUE) - $GLOBALS['starttTime'];

        if (function_exists('memory_get_usage')) {
            $this->memoryUsage = memory_get_usage();
        }

        if (function_exists('memory_get_peak_usage')) {
            $this->memoryPeakUsage = memory_get_peak_usage();
        }

    }

    /**
     * @return int
     */
    public function getRequestNumber() {
        return $this->requestNumber;
    }

    /**
     * @return DateTime
     */
    public function getExecutionTime() {
        return $this->executionTime;
    }

    /**
     * @return DateTime
     */
    public function getFormattedExecutionTime() {
        return $this->executionTime->format('Y-m-d H:m:s');
    }

    /**
     * @return int
     */
    public function getExecutionLength() {
        return $this->executionLength;
    }

    /**
     * @return int
     */
    public function getMemoryUsage() {
        return $this->memoryUsage;
    }

    /**
     * @return string
     */
    public function getFormattedMemoryUsage() {
        return $this->formatBytes($this->memoryUsage);
    }

    /**
     * @return int
     */
    public function getMemoryPeakUsage() {
        return $this->memoryPeakUsage;
    }

    /**
     * @return string
     */
    public function getFormattedMemoryPeakUsage() {
        return $this->formatBytes($this->memoryPeakUsage);
    }

    /**
     * @return int
     */
    public function getTotalQueryCount() {
        return $this->totalQueryCount;
    }

    /**
     * @return array
     */
    public function getExecutedQueries() {
        return $this->executedQueries;
    }

    /**
     * @return array
     */
    public function getPhpServer() {
        return $this->php_server;
    }

    /**
     * @return array
     */
    public function getPhpSession() {
        return $this->php_session;
    }

    /**
     * @return array
     */
    public function getPhpEnv() {
        return $this->php_env;
    }

    /**
     * @return array
     */
    public function getPhpCookie() {
        return $this->php_cookie;
    }

    /**
     * @return array
     */
    public function getPhpFiles() {
        return $this->php_files;
    }

    /**
     * @return array
     */
    public function getPhpGet() {
        return $this->php_get;
    }

    /**
     * @return array
     */
    public function getPhpPost() {
        return $this->php_post;
    }

    /**
     * @return string
     */
    public function getModule() {
        $answer = '';
        if(isset($this->php_get['module']) && !empty($this->php_get['module'])) {
            $answer = $this->php_get['module'];
        } else if(isset($this->php_post['module']) && !empty($this->php_post['module'])) {
            $answer = $this->php_post['module'];
        }
        return $answer;
    }

    /**
     * @return string
     */
    public function getAction() {
        $answer = '';
        if(isset($this->php_get['action']) && !empty($this->php_get['action'])) {
            $answer = $this->php_get['action'];
        } else if(isset($this->php_post['action']) && !empty($this->php_post['action'])) {
            $answer = $this->php_post['action'];
        }
        return $answer;
    }

    /**
     * @return string
     */
    public function getRequestMethod() {
        $answer = '';
        if(isset($this->php_server['REQUEST_METHOD']) && !empty($this->php_server['REQUEST_METHOD'])) {
            $answer = $this->php_server['REQUEST_METHOD'];
        }
        return $answer;
    }

    protected function formatBytes($bytes, $precision = 2) {
        $units = array('bytes', 'Kb', 'Mb', 'Gb', 'Tb');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . '' . $units[$pow];
    }

    /*---------------------------------------*/
    public function get_summary_text() {
        return "Request: " . $this->requestNumber;
    }

    public function ACLAccess() {
        return TRUE;
    }
}