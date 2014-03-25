<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * SubPanelSearchDisplay.php
 * @author SalesAgility <support@salesagility.com>
 * Date: 28/01/14
 */



global $beanList;
global $beanFiles;


if(empty($_REQUEST['module']))
{
	die("'module' was not defined");
}

if(empty($_REQUEST['record']))
{
	die("'record' was not defined");
}

if(!isset($beanList[$_REQUEST['module']]))
{
	die("'".$_REQUEST['module']."' is not defined in \$beanList");
}

if (!isset($_REQUEST['subpanel'])) {
    sugar_die('Subpanel was not defined');
}

$subpanel = $_REQUEST['subpanel'];
$record = $_REQUEST['record'];
$module = $_REQUEST['module'];

$search_query = '';
//$collection = array('Calls','Meetings');

//require_once('include/SubPanel/SubPanelDefinitions.php');
//require_once($beanFiles[$beanList[$_REQUEST['module']]]);
//$focus=new $beanList[$_REQUEST['module']];
//$focus->retrieve($record);

include('custom/include/SubPanel/SubPanel.php');
$layout_def_key = '';
if(!empty($_REQUEST['layout_def_key'])){
	$layout_def_key = $_REQUEST['layout_def_key'];
}

$subpanel_object = new CustomSubPanel($module, $record, $subpanel,null, $layout_def_key, $search_query, $collection);

echo $subpanel_object->getSearchForm();

