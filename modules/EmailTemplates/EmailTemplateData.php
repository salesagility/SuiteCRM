<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');



$error = false;
$data = array();

$emailTemplateId = $_REQUEST['emailTemplateId'];

if(preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/', $emailTemplateId)) {

    $func = isset($_REQUEST['func']) ? $_REQUEST['func'] : null;
    switch($func) {

        // TODO: this function unnecessary
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

        case 'createCopy':
            $bean = BeanFactory::getBean('EmailTemplates', $emailTemplateId);
            $newBean = new EmailTemplate();

            $fields = array('body_html', 'subject', 'name');
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
