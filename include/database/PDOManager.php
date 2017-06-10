<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SuiteCRM\Database;

require_once('include/resource/ResourceManager.php');
require_once('include/database/Utils.php');

/**
 * Description of PDOManager
 * @version 0.0.1
 * @author opravil
 */
abstract class PDOManager {
    //put your code here
    // System variables

    /**
     * Sugar config
     * @var array
     */
    protected $config;

    /**
     * Sugar log
     * @var type 
     */
    protected $log;

    /**
     *
     * @var type 
     */
    protected $currentUser;

    /**
     * Database
     * @var \PDO
     */
    protected static $database = null;

    /**
     * Database options
     * @var array
     */
    protected $options = array();

    /**
     * Current query count
     * @var int 
     */
    protected static $queryCount = 0;

    /**
     * Query threshold limit
     * @var int 
     */
    protected static $queryLimit = 0;

    /**
     * Last error message from the DB backend
     */
    protected $last_error = false;

    /**
     * Indicates whether we should html encode the results from a query by default
     * @var bool 
     */
    protected $encode = true;

    public function __construct() {
        global $sugar_config;
        global $log;
        global $current_user;

        $this->config = $sugar_config;
        $this->log = $log;
        $this->currentUser = $current_user;
    }

    public function __destruct() {
        $this->database = null;
    }

    function getOptions() {
        return $this->options;
    }

    function setOptions($options) {
        $this->options = $options;
    }

    static function getQueryLimit() {
        return self::$queryLimit;
    }

    /**
     * This function sets the query threshold limit
     *
     * @param int $queryLimit value of query threshold limit
     */
    static function setQueryLimit($queryLimit) {
        self::$queryCount = 0;
        self::$queryLimit = $queryLimit;
    }

    // *************************************************
    // Code bellow does not include setters and getters
    // *************************************************
    // Code below is copied from DBManager and is not changed
    /**
     * Get DB option by name
     * @param string $option Option name
     * @return mixed Option value or null if doesn't exist
     */
    public function getOption($option) {
        if (isset($this->options[$option])) {
            return $this->options[$option];
        }
        return null;
    }

    /**
     * Resets the queryCount value to 0
     *
     */
    public static function resetQueryCount() {
        self::$queryCount = 0;
    }

    /**
     * Returns the type of the variable in the field
     *
     * @param  array $fieldDef Vardef-format field def
     * @return string
     */
    public function getFieldType($fieldDef) {
        $this->dump($fieldDef);
        // get the type for db type. if that is not set,
        // get it from type. This is done so that
        // we do not have change a lot of existing code
        // and add dbtype where type is being used for some special
        // purposes like referring to foreign table etc.
        if (!empty($fieldDef['dbType']))
            return $fieldDef['dbType'];
        if (!empty($fieldDef['dbtype']))
            return $fieldDef['dbtype'];
        if (!empty($fieldDef['type']))
            return $fieldDef['type'];
        if (!empty($fieldDef['Type']))
            return $fieldDef['Type'];
        if (!empty($fieldDef['data_type']))
            return $fieldDef['data_type'];

        return null;
    }

    /**
     * This function increments the global $sql_queries variable
     * @changed
     */
    public function countQuery() {
        if (self::$queryLimit != 0 && ++self::$queryCount > self::$queryLimit && (empty($this->currentUser) || !is_admin($this->currentUser))) {
            $resourceManager = ResourceManager::getInstance();
            $resourceManager->notifyObservers('ERR_QUERY_LIMIT');
        }
    }

    // Changed code copied from DBManager

    /**
     * Returns the current database handle
     * @return \PDO
     */
    public function getDatabase() {
        $this->checkConnection();
        return $this->database;
    }

    /**
     * Checks the current connection; if it is not connected then reconnect
     */
    public function checkConnection() {
        $this->last_error = '';
        if (!isset($this->database))
            $this->connect();
    }

    /**
     * Fetches the next row in the query result into an associative array
     *
     * @param  resource $result
     * @param  bool $encode Need to HTML-encode the result?
     * @return array    returns false if there are no more rows available to fetch
     */
    public function fetchByAssoc(\PDOStatement $result, $encode = true) {
        if (!is_bool($encode)) {
            $this->log->deprecated("Using row number in fetchByAssoc is not portable and no longer supported. Please fix your code.");
            $this->dump("FIX - code");
        }
        $row = $result->fetch(\PDO::FETCH_ASSOC);
        if (!empty($row) && $encode && $this->encode) {
            return array_map('\SuiteCRM\Database\Utils::to_html', $row);
        }
        return $row;
    }

    /**
     * Connects to the database backend
     *
     * Takes in the database settings and opens a database connection based on those
     * will open either a persistent or non-persistent connection.
     * If a persistent connection is desired but not available it will default to non-persistent
     *
     * configOptions must include
     * db_host_name - server ip
     * db_user_name - database user name
     * db_password - database password
     * db_port - database port
     *
     * @param array   $configOptions
     * @param boolean $dieOnError
     */
    public function connect(array $configOptions = null, $dieOnError = false) {
        if (is_null($configOptions)) {
            $configOptions = $this->config['dbconfig'];
        }
        if (!isset($configOptions["db_host_name"])) {
            $this->log->fatal("Could not connect to server parameter db_host_name is not filled");
            sugar_die("Could not connect to the database. Please refer to suitecrm.log for details.");
            return false;
        }
        if (!isset($configOptions["db_port"])) {
            $this->log->fatal("Could not connect to server parameter db_port is not filled");
            sugar_die("Could not connect to the database. Please refer to suitecrm.log for details.");
            return false;
        }
        if (!isset($configOptions["db_user_name"])) {
            $this->log->fatal("Could not connect to server parameter db_user_name is not filled");
            sugar_die("Could not connect to the database. Please refer to suitecrm.log for details.");
            return false;
        }
        if (!isset($configOptions["db_password"])) {
            $this->log->fatal("Could not connect to server parameter db_password is not filled");
            sugar_die("Could not connect to the database. Please refer to suitecrm.log for details.");
            return false;
        }
        $dsn = $this->dbType . ":host=" . $configOptions['db_host_name'] . ";port=" . $configOptions['db_port'] . ";dbname=" . $configOptions['db_name'];
        $options = array();
        $options[\PDO::ATTR_PERSISTENT] = $this->getOption('persistent');
        if ($this->dbType === "mysql") {
            $dsn .= ";charset=utf8";
            $options[\PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";
        }
        try {
            $this->database = new \PDO($dsn, $configOptions['db_user_name'], $configOptions['db_password'], $options);
            $this->database->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $ex) {
            $this->dump($ex->getMessage());
            $this->dump($ex->getCode());
            $this->log->fatal("Could not connect to server " . $configOptions['db_host_name'] . " as " . $configOptions['db_user_name'] . ":" . $ex->getMessage());
            if ($dieOnError) {
                sugar_die("Could not connect to the database. Please refer to suitecrm.log for details.");
            }
        }
        $this->log->info("Connect: connected to " . $this->dbName);
        return true;
    }

    /**
     * Parses and runs queries
     *
     * @param  string   $sql        SQL Statement to execute
     * @param  bool     $dieOnError True if we want to call die if the query returns errors
     * @param  string   $msg        Message to log if error occurs
     * @param  bool     $suppress   Flag to suppress all error output unless in debug logging mode.
     * @param  bool     $keepResult Keep query result in the object?
     * @return resource|bool result set or success/failure bool
     */
    public function query($sql, array $params = array(), $dieOnError = false, $msg = '', $suppress = false, $keepResult = false) {
        $time = microtime(TRUE);
        static $types = ['boolean' => \PDO::PARAM_BOOL, 'integer' => \PDO::PARAM_INT, 'resource' => \PDO::PARAM_LOB, 'NULL' => \PDO::PARAM_NULL];
        $this->dump("---------------------- RAW ------------------------------");
        $this->dump($sql);
        $this->dump("---------------------------------------------------------");
        $this->countQuery();
        // TODO: convert sql and params to one string sql query
        $this->lastsql = $sql;
        try {
            $this->checkConnection();
            $statement = $this->database->prepare($sql);
            foreach ($params as $key => $value) {
                $type = gettype($value);
                $statement->bindValue($key, $value, isset($types[$type]) ? $types[$type] : \PDO::PARAM_STR);
            }
            if ($statement !== false) {
                $statement->setFetchMode(\PDO::FETCH_ASSOC);
                $result = $statement->execute();
            } else {
                $result = false;
            }
            // TODO: Decide what to do with commented part
            /**
             * 
             * Do not know for what this code is good for.

              static $queryMD5 = array();
              $md5 = md5($sql);
              $this->dump("Start");
              if (empty($queryMD5[$md5])) {
              $queryMD5[$md5] = true;
              }

             */
        } catch (\PDOException $ex) {
            $this->log->fatal("Query:" . $sql . "\n Params: [" . implode($params, ",") . "].");
            if ($dieOnError) {
                sugar_die("Could not make query to the database. Please refer to suitecrm.log for details.");
            }
        }
        $this->query_time = microtime(true) - $time;
        $this->log->info("Query:" . $sql . "\n Params: " . implode($params, ",") . ".");
        $this->log->info('Query Execution Time:' . $this->query_time);
        return $statement;
    }

    /**
     * Runs a limit query: one where we specify where to start getting records and how many to get
     *
     * @param  string   $sql     SELECT query
     * @param  array    $params  query parameters
     * @param  int      $start   Starting row
     * @param  int      $count   How many rows
     * @param  boolean  $dieOnError  True if we want to call die if the query returns errors
     * @param  string   $msg     Message to log if error occurs
     * @param  bool     $execute Execute or return SQL?
     * @return resource query result
     */
    public function limitQuery($sql, array $params = array(), $offset, $limit, $dieOnError = false, $msg = '', $execute = true) {
        $start = (int) $offset;
        $count = (int) $limit;
        if ($offset < 0)
            $offset = 0;
        $this->log->debug('Limit Query:' . $sql . ' Start: ' . $offset . ' count: ' . $limit);
        $sql = $sql . " LIMIT :limit OFFSET :offset";
        $params[":limit"] = $limit;
        $params[":offset"] = $offset;
        $this->lastsql = $sql;
        if ($execute === false) {
            return $sql;
        }
        return $this->query($sql, $params, $dieOnError, $msg);
    }

    protected function dump($value, $die = false) {
        echo("<br>");
        echo("\n");
        print_r($value);
        if ($die === true) {
            die();
        }
    }

    // Deprecated staff

    /**
     * Return string properly quoted with ''
     * @deprecated since version 0.0.1
     * @param mixed $string
     * @return mixed
     */
    public function quote($string) {
        return $string;
    }

    /**
     * @deprecated since version 0.0.1 
     * @param mixed $string
     * @return mixed
     */
    public function quoted($string) {
        return $this->quote($string);
    }

    /**
     * Disconnects from the database
     *
     * Also handles any cleanup needed
     * @deprecated since version 0.0.1
     */
    public function disconnect() {
        $this->log->debug('Calling deprecated disconnect()');
        $this->database = null;
    }

    /**
     * Converts from Database data to app data
     *
     * Supported types
     * - date
     * - time
     * - datetime
     * - datetimecombo
     * - timestamp
     * @deprecated since version 0.0.1
     * @param string $string database string to convert
     * @param string $type type of conversion to do
     * @return string
     */
    public function fromConvert($string, $type) {
        return $string;
    }

}
