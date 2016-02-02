<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$fields = array('id', 'name', 'body', 'body_html', 'subject');

$error = false;
$data = array();

$emailTemplateId = $_REQUEST['emailTemplateId'];

if(preg_match('/[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/', $emailTemplateId)) {

    $bean = BeanFactory::getBean('EmailTemplates', $emailTemplateId);

    foreach($bean as $key => $value) {
        if(in_array($key, $fields)) {
            $data[$key] = $bean->$key;
        }
    }

}
else {
    $error = 'Illegal GUID format.';
}

$results = array(
    'error' => $error,
    'data' => $data,
);

echo json_encode($results);
