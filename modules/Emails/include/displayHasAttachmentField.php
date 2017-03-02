<?php
/**
 * @param $focus
 * @param $field
 * @param $value
 * @param $view
 * @return string
 */
function displayHasAttachmentField($focus, $field, $value, $view)
{
    global $app_strings, $app_list_strings, $mod_strings;
    $result = '';
    $bean = array();

    if(empty($view)) {
        return $result;
    }

    if(strtolower($field) !== 'has_attachment') {
        return $result;
    }

    if(is_object($focus)) {
        $focus = get_object_vars($focus);
    } else if(is_array($focus)) {
        $focus = array_change_key_case($focus, CASE_LOWER);
    }

    if(!empty($focus['id'])) {
        $bean = BeanFactory::getBean('Emails', $focus['id']);
        $bean->load_relationship('notes');
        $attachmentIds = $bean->notes->get();

        $bean->has_attachment = (count($attachmentIds) > 0);
        if (is_object($bean)) {
            $bean = get_object_vars($bean);
        }
    }

    $template = new Sugar_Smarty();
    $template->assign('APP', $app_strings);
    $template->assign('APP_LIST_STRINGS', $app_list_strings);
    $template->assign('MOD', $mod_strings);
    $template->assign('bean', $bean);

    $result = $template->fetch('modules/Emails/templates/displayHasAttachmentField.tpl');


    return $result;
}
