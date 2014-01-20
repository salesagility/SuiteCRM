<?php

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    $dictionary['ext_rest_example'] = array(
        'comment' => 'vardefs for example connector',
        'fields' => array (
            'id' => array (
                'name' => 'id',
                'vname' => 'LBL_ID',
                'type' => 'id',
                'comment' => 'Unique identifier',
                'hidden' => true,
            ),
            'fullname' => array (
                'name' => 'fullname',
                'vname' => 'LBL_FULL_NAME',
                'hover' => true,
            ),
            'firstname' => array (
                'name' => 'firstname',
                'vname' => 'LBL_FIRST_NAME',
            ),
            'lastname' => array (
                'name' => 'lastname',
                'vname' => 'LBL_LAST_NAME',
                'input' => 'lastname',
                'search' => true,
            ),
            'email' => array (
                'name' => 'email',
                'vname' => 'LBL_EMAIL',
            ),
            'state' => array (
                'name' => 'state',
                'vname' => 'LBL_STATE',
                'options' => 'states_dom',
            ),
        )
    );

?>