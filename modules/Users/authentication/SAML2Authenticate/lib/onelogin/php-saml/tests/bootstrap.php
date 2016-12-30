<?php

ob_start();

$basePath = dirname(dirname(__FILE__));

require_once $basePath . '/_toolkit_loader.php';

if (!defined('TEST_ROOT')) define('TEST_ROOT', dirname(__FILE__));

if (!defined('XMLSECLIBS_DIR')) define('XMLSECLIBS_DIR', $basePath.'/extlib/xmlseclibs/');
require_once XMLSECLIBS_DIR . 'xmlseclibs.php';

if (!defined('ONELOGIN_SAML_DIR')) define('ONELOGIN_SAML_DIR', $basePath.'/lib/Saml/');
require_once ONELOGIN_SAML_DIR . 'AuthRequest.php';
require_once ONELOGIN_SAML_DIR . 'Response.php';
require_once ONELOGIN_SAML_DIR . 'Settings.php';
require_once ONELOGIN_SAML_DIR . 'Metadata.php';
require_once ONELOGIN_SAML_DIR . 'XmlSec.php';

if (!defined('ONELOGIN_CUSTOMPATH')) {
    define('ONELOGIN_CUSTOMPATH', dirname(__FILE__).'/data/customPath/');
}

date_default_timezone_set('America/Los_Angeles');


if (!function_exists('getUrlFromRedirect')) {
    /**
    * In phpunit when a redirect is executed an Excepion raise,
    * this funcion Get the target URL of the redirection
    * 
    * @param array $trace Trace of the Stack when an Exception raised
    *
    * @return string $targeturl Target url of the redirection
    */
    function getUrlFromRedirect($trace) 
    {
        $param_args = $trace[0]['args'][4];
        $targeturl = $param_args['url'];
        return $targeturl;
    }
}

if (!function_exists('getParamsFromUrl')) {
    /**
    * Parsed the Query parameters of an URL.
    * 
    * @param string $url The URL
    *
    * @return array $parsedQuery Parsed query of the url
    */
    function getParamsFromUrl($url) 
    {
        $parsedUrl = parse_url($url);
        $query = $parsedUrl['query'];
        parse_str($query, $parsedQuery);
        return $parsedQuery;
    }
}
