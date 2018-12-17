<?php

/**
 *
 * Smarty {sugar_varname key='value'} function plugin
 *
 * example
 * {sugar_literal key='value'}
 *
 *
 * @param array $params
 * @param Smarty $smarty
 * @return string smarty varname
 */
function smarty_function_sugar_varname($params, &$smarty)
{
    if (empty($params['key'])) {
        $smarty->trigger_error("sugarvar: missing 'key' parameter");
        return;
    }

    $object = (empty($params['objectName']))?$smarty->get_template_vars('parentFieldArray'): $params['objectName'];

    $vardefs = $smarty->get_template_vars('vardef');
    $member = $vardefs['name'];

    $_contents =  '$'. $object . '.' . $member . '.' . $params['key'];
    return $_contents;
}
