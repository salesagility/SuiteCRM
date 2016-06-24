<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

global $db;

/**
 * validate email template's html body for relative image links
 * @param EmailTemplate $emailTemplate
 * @return array|bool relative links or false
 */
function validateEmailTemplateForRelativeImageSrc(EmailTemplate $emailTemplate) {

    $html = $emailTemplate->body_html;

    $relatives = array();
    if(preg_match_all('/&lt;img\b((?!src).)*\bsrc\s*=\s*&quot;(((?!&quot;).)*)&quot;/i', $html, $matches)) {
        foreach($matches[2] as $key => $link) {
            if(!preg_match('/^http[s]{0,1}:\/\//i', $link)) {
                $relatives[$link] = $matches[0][$key];
            }
        }
    }

    // $relatives contains the all found relative link in the template
    if($relatives) {
        return $relatives;
    }

    return false;
}

function getTemplateValidationMessages($templateId) {
    $msgs = array();
    $rels = array();
    if(!$templateId) {
        $msgs[] = 'LBL_NO_SELECTED_TEMPLATE';
    }
    else {
        $template = new EmailTemplate();
        $template->retrieve($templateId);
        if (!$template->subject) {
            $msgs[] = 'LBL_NO_SUBJECT';
        }
        if (!$template->body_html) {
            $msgs[] = 'LBL_NO_HTML_BODY_CONTENTS';
        } else {
            if ($rels = validateEmailTemplateForRelativeImageSrc($template)) {
                $msgs[] = 'LBL_RELATIVE_IMG_SRC_IN_TPL';
            }
        }
        if (!$template->body) {
            $msgs[] = 'LBL_NO_BODY_CONTENTS';
        }

    }
    return array(
        'messages' => $msgs,
        'relativeImages' => $rels,
    );
}

$campaignId = $db->quote($_POST['campaignId']);
$marketingId = $db->quote($_POST['marketingId']);
$func = isset($_REQUEST['func']) ? $_REQUEST['func'] : null;
if($func == 'getTemplateValidation') {
    if (!empty($_POST['templateId'])) {
        $templateId = $db->quote($_POST['templateId']);
    }
    else {
        if (!$marketingId) {
            if (!empty($_SESSION['campaignWizard'][$campaignId]['defaultSelectedMarketingId']) && $func != 'createEmailMarketing') {
                $marketingId = $_SESSION['campaignWizard'][$campaignId]['defaultSelectedMarketingId'];
            }
        }
        $marketing = new EmailMarketing();
        $marketing->retrieve($marketingId);
        $templateId = $marketing->template_id;
    }
    $return = $_POST;
    $templateValidationMessages = getTemplateValidationMessages($templateId);
    $return['templateValidationMessages'] = $templateValidationMessages['messages'];
    $return['templateValidationMessages_relativeImages'] = array_keys($templateValidationMessages['relativeImages']);
    $return['marketingValidationMessages'] = $marketing->validate();

    echo json_encode($return);
}
else {
    if (!$marketingId) {
        if (!empty($_SESSION['campaignWizard'][$campaignId]['defaultSelectedMarketingId']) && $func != 'createEmailMarketing') {
            $marketingId = $_SESSION['campaignWizard'][$campaignId]['defaultSelectedMarketingId'];
        } else if($func != 'createEmailMarketing') {
            $marketing = new EmailMarketing();
            $marketing->save();
            $marketingId = $marketing->id;
        }
    }
    if (!empty($_POST['templateId'])) {
        $templateId = $db->quote($_POST['templateId']);
    }

//$campaign = new Campaign();
//$campaign->retrieve($campaignId);

    $marketing = new EmailMarketing();
    $marketing->retrieve($marketingId);
    $marketing->campaign_id = $campaignId;
    if (!empty($_POST['templateId'])) {
        $marketing->template_id = $templateId;
    }
    if($func != 'createEmailMarketing') {
        $marketing->save();
    }

    $_SESSION['campaignWizard'][$campaignId]['defaultSelectedMarketingId'] = $marketing->id;

    $return = $_POST;
    $templateValidationMessages = getTemplateValidationMessages($marketing->template_id);
    $return['templateValidationMessages'] = $templateValidationMessages['messages'];
    $return['templateValidationMessages_relativeImages'] = array_keys($templateValidationMessages['relativeImages']);
    $return['marketingValidationMessages'] = $marketing->validate();

    echo json_encode($return);
}