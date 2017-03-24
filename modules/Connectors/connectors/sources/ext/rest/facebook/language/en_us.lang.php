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


    $connector_strings = array (
        //Vardef labels
        'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><th valign="top" width="35%" class="dataLabel">Facebook Application Information </th></tr>
                                    <tr><td width="35%" class="dataLabel">You will need to create a facebook application, Get one <a href=https://developers.facebook.com/?ref=pf">here</a>  </td></tr></table>',

        //Configuration labels
        'appid' => 'Facebook App ID ',
        'secret' => 'Facebook App Secret ',
    );

?>