<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


// In order to load custom data during a silent_install
// you should place in files named: custom/install/customDataMODULE_NAME.php
// an array like the following:
//
//
// $suitecrm_custom_data['MODULE_NAME'] = [
//     [
//         'field1' => 'value1',
//         'field2' => 'value2',
//         'field3' => 'value3',
//     ],
//     [
//         'field1' => 'value1',
//         'field2' => 'value2',
//         'field3' => 'value3',
//     ],
// ];

$suitecrm_custom_data = [];
