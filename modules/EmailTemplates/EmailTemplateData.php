<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');



$error = false;
$data = array();

$emailTemplateId = isset($_REQUEST['emailTemplateId']) && $_REQUEST['emailTemplateId'] ? $_REQUEST['emailTemplateId'] : null;

if(preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/', $emailTemplateId) || !$emailTemplateId) {

    $func = isset($_REQUEST['func']) ? $_REQUEST['func'] : null;

    $fields = array('body_html', 'subject', 'name');

    // TODO: validate for email template before save it!

    include_once 'modules/EmailTemplates/EmailTemplateFormBase.php';

    switch($func) {

        case 'update':
            $bean = BeanFactory::getBean('EmailTemplates', $emailTemplateId);
            foreach($bean as $key => $value) {
                if(in_array($key, $fields)) {
                    $bean->$key = $_POST[$key];
                }
            }
            $formBase = new EmailTemplateFormBase();
            $bean = $formBase->handleAttachmentsProcessImages($bean, false, true, 'download', true);
            $bean->save();
            //$formBase = new EmailTemplateFormBase();
            //$bean = $formBase->handleAttachmentsProcessImages($bean, false, true);
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
            //$formBase = new EmailTemplateFormBase();
            //$newBean = $formBase->handleAttachmentsProcessImages($newBean, false, true);
            $data['id'] = $newBean->id;
            $data['name'] = $newBean->name;
            break;

        case 'uploadAttachments':
            $formBase = new EmailTemplateFormBase();
            $focus = BeanFactory::getBean('EmailTemplates', $_REQUEST['attach_to_template_id']);
            //$data = $formBase->handleAttachments($focus, false, null);
            $data = $formBase->handleAttachmentsProcessImages($focus, false, true, 'download', true);
            $redirectUrl = 'index.php?module=Campaigns&action=WizardMarketing&campaign_id=' . $_REQUEST['campaign_id'] . "&jump=2&template_id=" . $_REQUEST['attach_to_template_id']; // . '&marketing_id=' . $_REQUEST['attach_to_marketing_id'] . '&record=' . $_REQUEST['attach_to_marketing_id'];
            header('Location: ' . $redirectUrl);
            die();
            break;

        default: case 'get':
            if($bean = BeanFactory::getBean('EmailTemplates', $emailTemplateId)) {
                $fields = array('id', 'name', 'body', 'body_html', 'subject');
                foreach ($bean as $key => $value) {
                    if (in_array($key, $fields)) {
                        $data[$key] = $bean->$key;
                    }
                }

                $data['body_from_html'] = from_html($bean->body_html);
                $attachmentBeans = $bean->getAttachments();
                if($attachmentBeans) {
                    $attachments = array();
                    foreach($attachmentBeans as $attachmentBean) {
                        $attachments[] = array(
                            'id' => $attachmentBean->id,
                            'name' => $attachmentBean->name,
                            'file_mime_type' => $attachmentBean->file_mime_type,
                            'filename' => $attachmentBean->filename,
                            'parent_type' => $attachmentBean->parent_type,
                            'parent_id' => $attachmentBean->parent_id,
                            'description' => $attachmentBean->description,
                        );
                    }
                    $data['attachments'] = $attachments;
                }
            }
            else {
                $error = 'Email Template not found.';
            }
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

$results = json_encode($results);
if(!$results) {
    if(json_last_error()) {
        $results = array(
            'error' => 'json_encode error: '.json_last_error_msg()
        );
        $results = json_encode($results);
    }
}
echo $results;
