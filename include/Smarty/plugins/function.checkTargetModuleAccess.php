<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14/09/16
 * Time: 11:15
 */

function smarty_function_checkTargetModuleAccess ($params, &$smarty)
{
    if(ACLController::checkAccess($GLOBALS['FOCUS']->report_module, 'list', true))
    {$smarty->assign('access', 'true');}
    else
    {$smarty->assign('access', 'false');}
}