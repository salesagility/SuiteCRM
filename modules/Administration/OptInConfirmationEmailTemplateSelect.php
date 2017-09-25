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

    if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
        $configurator->config['opt_in_confirmation_email_template_id'] = $_REQUEST['opt_in_confirmation_email_template_id'];
    }

    $sugarSmarty->assign('OPT_IN_CONFIRMATION_EMAIL_TEMPLATES',
        get_select_options_with_id($emailTemplateList, $configurator->config['opt_in_confirmation_email_template_id']));

    return $sugarSmarty;
}