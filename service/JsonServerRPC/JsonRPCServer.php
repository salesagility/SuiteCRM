<?php

require_once __DIR__ . '/../../soap/SoapHelperFunctions.php';
require_once __DIR__ . '/../../include/json_config.php';
require_once __DIR__ . '/JsonRPCServerUtils.php';
require_once __DIR__ . '/JsonRPCServerCalls.php';

class JsonRPCServer
{
    /**
     * @var JSON $jsonParser
     */
    private $jsonParser;

    /**
     * @var JsonRPCServerUtils $jsonServerUtils
     */
    private $jsonServerUtils;

    /**
     * @var JsonRPCServerCalls
     */
    private $jsonServerCalls;

    /**
     * JsonRPCServer constructor.
     */
    public function __construct() {
        $this->jsonParser = getJSONobj();
        $this->jsonServerUtils = new JsonRPCServerUtils();
        $this->jsonServerCalls = new JsonRPCServerCalls();
    }

    /**
     * Run the JSON RPC Server
     */
    public function run()
    {
        global $sugar_config;
        global $log;

        $response = array();
        $jsonParser = $this->jsonParser;

        $log->debug('JSON_SERVER:');

        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
        ob_start();
        insert_charset_header();

        if (!empty($sugar_config['session_dir'])) {
            session_save_path($sugar_config['session_dir']);
            $log->debug('JSON_SERVER:session_save_path:' . $sugar_config['session_dir']);
        }

        session_start();
        $log->debug('JSON_SERVER:session started');
        
        if (isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] !== '') {
            $current_language = $_SESSION['authenticated_user_language'];
        } else {
            $current_language = $sugar_config['default_language'];
        }
        
        $log->debug('JSON_SERVER: current_language:' . $current_language);

        if (strtolower($_SERVER['REQUEST_METHOD']) === 'get') {
            $response['error'] = array('error_msg' => 'DEPRECATED API');
            $log->deprecated('JsonServer: Get Request Method is deprecated');
        } else {
            $response = $this->processRequest();
        }

        print $jsonParser::encode($response, true);
        ob_end_flush();
        sugar_cleanup();
    }

    /**
     * @return array json response
     */
    private function processRequest()
    {
        $response['result'] = null;
        $response['id'] = '-1';
        $jsonParser = $this->jsonParser;
        $current_user = $this->jsonServerUtils->authenticate();

        if ($current_user === null) {
            $response['error'] = array('error_msg' => 'user not logged in');
            return $response;
        }

        // extract request
        if (isset($GLOBALS['HTTP_RAW_POST_DATA'])) {
            $request = $jsonParser::decode($GLOBALS['HTTP_RAW_POST_DATA'], true);
        } else {
            $request = $jsonParser::decode(file_get_contents('php://input'), true);
        }

        if (!is_array($request)) {
            $response['error'] = array('error_msg' => 'malformed request');
            return $response;
        }

        // make sure required RPC fields are set
        if (empty($request['method']) || empty($request['id'])) {
            $response['error'] = array('error_msg' => 'missing parameters');
            return $response;
        }

        $response['id'] = $request['id'];

        if (method_exists($this->jsonServerCalls, $request['method'])) {
            $response = call_user_func(array($this->jsonServerCalls, $request['method']), $request['id'], $request['params']);
            if(!empty($response)) {
                return $response;
            }
        }

        $response['error'] = array('error_msg' => 'method:' . $request['method'] . ' not supported');
        return $response;

    }
}