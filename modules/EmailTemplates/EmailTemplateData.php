<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');



$error = false;
$data = array();

$emailTemplateId = isset($_REQUEST['emailTemplateId']) && $_REQUEST['emailTemplateId'] ? $_REQUEST['emailTemplateId'] : null;

if(preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/', $emailTemplateId) || !$emailTemplateId) {

    $func = isset($_REQUEST['func']) ? $_REQUEST['func'] : null;

    $fields = array('body_html', 'subject', 'name');

    switch($func) {

        case 'update':
            $bean = BeanFactory::getBean('EmailTemplates', $emailTemplateId);
            foreach($bean as $key => $value) {
                if(in_array($key, $fields)) {
                    $bean->$key = $_POST[$key];
                }
            }
            $bean->save();
            $data['id'] = $bean->id;
            $data['name'] = $bean->name;
            break;

        case 'createCopy':
            $bean = BeanFactory::getBean('EmailTemplates', $emailTemplateId);
            $newBean = new EmailTemplate();
            $fieldsForCopy = array('type', 'description');
            foreach($bean as $key => $value) {
                if(in_array($key, $fields)) {
                    $newBean->$key = $_POST[$key];
                }
                else if(in_array($key, $fieldsForCopy)) {
                    $newBean->$key = $bean->$key;
                }
            }
            $newBean->save();
            $data['id'] = $newBean->id;
            $data['name'] = $newBean->name;
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
