<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');



$error = false;
$data = array();

$emailTemplateId = $_REQUEST['emailTemplateId'];

if(preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/', $emailTemplateId)) {

    $func = isset($_REQUEST['func']) ? $_REQUEST['func'] : null;
    switch($func) {

        case 'update':
            $bean = BeanFactory::getBean('EmailTemplates', $emailTemplateId);
            $fields = array('body_html');
            foreach($bean as $key => $value) {
                if(in_array($key, $fields)) {
                    $bean->$key = $_POST[$key];
                }
            }
            $bean->save();
            break;

        default: case 'get':
            $bean = BeanFactory::getBean('EmailTemplates', $emailTemplateId);
            $fields = array('id', 'name', 'body', 'body_html', 'subject');
            foreach($bean as $key => $value) {
                if(in_array($key, $fields)) {
                    $data[$key] = $bean->$key;
                }
            }

            $data['body_from_html'] = from_html($bean->body_html);
            break;
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
