<?php

function getOptInConfirmationEmailTemplateSelect($sugarSmarty, $emailTemplateList = null, $configurator = null)
{
    if (null === $configurator) {
        $configurator = new Configurator();
    } else {
        $configurator = $configurator;
    }

    if (null == $emailTemplateList) {
        $emailTemplateList = get_bean_select_array(true, 'EmailTemplate', 'name', '', 'name');
    } else {
        $emailTemplateList = $emailTemplateList;
    }

    if (!array_key_exists('opt_in_confirmation_email_template_id', $configurator->config)) {
        $configurator->config['opt_in_confirmation_email_template_id'] = '';
    }

    $sugarSmarty->assign('opt_in_checkbox_on_person_form_enabled', $configurator->config['opt_in_checkbox_on_person_form_enabled']);
    $sugarSmarty->assign('opt_in_confirmation_email_enabled', $configurator->config['opt_in_confirmation_email_enabled']);
    $sugarSmarty->assign('OPT_IN_CONFIRMATION_EMAIL_TEMPLATES',
        get_select_options_with_id($emailTemplateList, $configurator->config['opt_in_confirmation_email_template_id']));

    return $sugarSmarty;
}