<?php

    $hook_array['before_save'][] = Array(
        //Processing index. For sorting the array.
        1,

        //Label. A string value to identify the hook.
        'Save in PRVCloud and bypass from DB',

        //The PHP file where your class is located.
        'custom/modules/Contacts/prv_cloud_class.php',

        //The class the method is in.
        'PrvCloud',

        //The method to call.
        'PrvSave'
    );

?>
