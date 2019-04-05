<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
require_once 'include/entryPoint.php';

$sugar_view=new SugarView();
$favicon = $sugar_view->getFavicon();
$shortname = $GLOBALS['system_config']->settings['system_name'];
$searchuri="{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}"
    . (in_array("{$_SERVER['REQUEST_SCHEME']}{$_SERVER['SERVER_PORT']}",["http80","https443"])?"":":{$_SERVER['SERVER_PORT']}")
    . dirname($_SERVER['REQUEST_URI']). "index.php?action=UnifiedSearch&amp;module=Home&amp;search_form=false&amp;advanced=false&amp;query_string={searchTerms}";

header("Content-type: text/xml");
print <<<EOF
<?xml version="1.0" encoding="UTF-8" ?> 
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/"> 
    <ShortName>{$shortname}</ShortName>  
    <Description>SuiteCRM Search Provider</Description> 
    <InputEncoding>UTF-8</InputEncoding> 
    <Image width="16" height="16" type="image/x-icon">{$favicon['url']}</Image> 
    <Url type="text/html" template="{$searchuri}"/>
</OpenSearchDescription>
EOF;
