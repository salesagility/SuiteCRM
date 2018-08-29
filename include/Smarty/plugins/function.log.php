<?php

use SuiteCRM\ErrorMessage;

function smarty_function_log($params, &$smarty) {
    $from = $smarty->_plugins['function']['log'][1] . ':' . $smarty->_plugins['function']['log'][2];
    $message = "log call at: $from - " . $params['msg'];
    $level = isset($params['level']) ? $params['level'] : ErrorMessage::DEFAULT_LOG_LEVEL;
    ErrorMessage::log($message, $level);
}

