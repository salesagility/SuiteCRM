<?php

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {suite_check_access} function plugin
 *
 * Type:     function<br>
 * Name:     suite_check_access<br>
 * Purpose:  Check if the current user has access to a record
 *
 * @author Jose C. Massón <jose AT gcoop DOT coop>
 * @param array
 * @param Smarty
 */
function smarty_function_suite_check_access($params, &$smarty)
{
    if (empty($params['module'])) {
        $smarty->trigger_error("sugar_check_access: missing 'module' parameter");
        return;
    }
    if (empty($params['record'])) {
        $smarty->trigger_error("sugar_check_access: missing 'record' parameter");
        return;
    }
    if (empty($params['action'])) {
        $smarty->trigger_error("sugar_check_access: missing 'module' parameter");
        return;
    }
    $ret = false;
    $bean = BeanFactory::getBean($params['module'], $params['record']);

    if (is_subclass_of($bean, 'SugarBean')) {
        $ret = (bool) $bean->ACLAccess($params['action']);
    }

    return $ret;
}
