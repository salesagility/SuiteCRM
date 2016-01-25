<?php
use SuiteCRM\helpers\api;

$app->get('/{module_name}', function($request, $response, $args){
    $helper = new api();
    $test = $helper->getModuleRecords($args['module_name']);

    $class = new stdClass();
    $class->lewis = 5;
    $class->var =5 ;



    $array = array(
        0 => $class
    );


    $test_json = json_encode($array);

    $error = json_last_error_msg();




});

