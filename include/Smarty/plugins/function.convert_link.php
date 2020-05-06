<?php

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {convert_link} function plugin
 *
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.convert_link.php
 * Type:     function<br>
 * Name:     convert_link<br>
 * Purpose:  convert link to new UI link introduced in 8.0
 * -------------------------------------------------------------
 * @param $params array - its structure is
 *     'link' => link to convert
 * @param $smarty
 * @param Smarty
 * @return string
 */
function smarty_function_convert_link($params, &$smarty)
{
    if (empty($params['link'])) {
        return '';
    }

    require_once 'include/portability/RouteConverter.php';
    $routeConverter = new RouteConverter();

    return $routeConverter->generateUiLink($params['link']);
}
?>
