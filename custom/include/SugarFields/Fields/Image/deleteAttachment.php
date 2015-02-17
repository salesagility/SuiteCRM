<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 17/02/15
 * Time: 11:59
 */

    $field = $_REQUEST['field'];
    $removeFile = "upload://{$_REQUEST['image_c_record_id']}_" . $field;
    $bean = BeanFactory::getBean($_REQUEST['module'], $_REQUEST[$field . "_record_id"]);


if(file_exists($removeFile)) {
    if(!unlink($removeFile)) {
        $GLOBALS['log']->error("*** Could not unlink() file: [ {$removeFile} ]");
    }else{
        $bean->$field = '';
        $bean->save();
        echo "true";
    }
} else {
    $bean->$field = '';
    $bean->save();
    echo 'true';
}