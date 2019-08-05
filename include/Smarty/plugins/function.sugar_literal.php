<?php

/**
 * by passes the smarty parsing for the detail view.
 * Smarty {sugar_literal} function plugin
 *
 * example
 * {sugar_literal content=$vardef.value}
 *
 *
 * @param array $params
 * @return string with content wrapped around with literals
 */
function smarty_function_sugar_literal($params)
{
    $content = '';

    if (!isset($params['content'])) {
        return $content;
    }
    return $params['content'];
}
