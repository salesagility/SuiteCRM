<?php


if (!defined('sugarEntry') || !sugarEntry || !defined('SUGAR_ENTRY') || !SUGAR_ENTRY) {
    die('Not A Valid Entry Point');
}
if (defined('sugarEntry')) {
    $deprecatedMessage = 'sugarEntry is deprecated use SUGAR_ENTRY instead';
    if (isset($GLOBALS['log'])) {
        $GLOBALS['log']->deprecated($deprecatedMessage);
    } else {
        trigger_error($deprecatedMessage, E_USER_DEPRECATED);
    }
}


$dictionary['twitter_api'] = array(


);

?>