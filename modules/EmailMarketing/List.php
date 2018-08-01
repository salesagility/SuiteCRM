<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

$db = DBManagerFactory::getInstance();

$results = array(
    'error' => false,
    'data' => array(),
);
$selectedId = null;
if (!isset($_REQUEST['campaign_id']) || !$_REQUEST['campaign_id']) {
    $results['error'] = 'campaign_id is not set';
    unset($_SESSION['campaignWizard'][$campaign_id]['defaultSelectedMarketingId']);
} else {
    $campaign_id = $db->quote($_REQUEST['campaign_id']);
    if ($list = BeanFactory::getBean('EmailMarketing')->get_full_list("", "campaign_id = '{$campaign_id}'")) {
        foreach ($list as $elem) {
            $results['data'][] = array(
                'id' => $elem->id,
                'name' => $elem->name,
            );
            if (isset($_SESSION['campaignWizard'][$campaign_id]['defaultSelectedMarketingId']) && $elem->id == $_SESSION['campaignWizard'][$campaign_id]['defaultSelectedMarketingId']) {
                $selectedId = $elem->id;
            }
        }
        if (!$selectedId && !empty($results['data'][0]['id'])) {
            $selectedId = $results['data'][0]['id'];
        }
    }
}

if ($selectedId) {
    $results['selectedId'] = $_SESSION['campaignWizard'][$campaign_id]['defaultSelectedMarketingId'] = $selectedId;
} else {
    unset($_SESSION['campaignWizard'][$campaign_id]['defaultSelectedMarketingId']);
}

if (isset($_REQUEST['func']) && $_REQUEST['func'] == 'createEmailMarketing') {
    unset($_SESSION['campaignWizard'][$campaign_id]['defaultSelectedMarketingId']);
    $results['selectedId'] = null;
}

echo json_encode($results);
