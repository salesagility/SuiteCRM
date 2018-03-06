<?php
/**
 *
 * @package Advanced OpenPortal
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */
if(!defined('sugarEntry'))define('sugarEntry', true);

class JAccountMissingException extends Exception {}

try {
    require_once 'modules/AOP_Case_Updates/util.php';

    function url_exists($url)
    {
        if (!$fp = curl_init($url)) return false;

        return true;
    }

    if (!isAOPEnabled()) {
        return;
    }
    global $sugar_config, $mod_strings;

    require_once('modules/Contacts/Contact.php');

    $bean = new Contact();
    $bean->retrieve($_REQUEST['record']);

    if (array_key_exists("aop", $sugar_config) && array_key_exists("joomla_urls", $sugar_config['aop'])) {
        $portalURLs = array_unique($sugar_config['aop']['joomla_urls']);
        // disable only in the selected joomla portal...
        if (!isset($_REQUEST['selected_portal_url']) || !$_REQUEST['selected_portal_url']) {
            SugarApplication::appendErrorMessage($mod_strings['LBL_ERROR_NO_PORTAL_SELECTED']);
        } else {
            foreach ($portalURLs as $portalURL) {
                if ($portalURL) {
                    if ($_REQUEST['selected_portal_url'] == $portalURL) {

                        $jaList = BeanFactory::getBean('JAccount')->get_full_list('', "contact_id = '{$_REQUEST['record']}' AND portal_url = '$portalURL'");

                        if (count($jaList) > 1) {
                            SugarApplication::appendErrorMessage($mod_strings['LBL_DISABLE_PORTAL_USER_FAILED']);
                            SugarApplication::redirect("index.php?module=Contacts&action=DetailView&record=" . $_REQUEST['record']);

                            return;
                            //throw new Exception('ambiguous JAccount selected');
                        }
                        if (!$jaList[0]) {
                            SugarApplication::appendErrorMessage($mod_strings['LBL_DISABLE_PORTAL_USER_FAILED']);
                            SugarApplication::redirect("index.php?module=Contacts&action=DetailView&record=" . $_REQUEST['record']);

                            return;
                            //throw new Exception('Contact has no portal account to this url');
                        }

                        $multiplePortalSupportAvailable = false;
                        $aopXML = $portalURL . '/administrator/components/com_advancedopenportal/advancedopenportal.xml';
                        if (url_exists($aopXML)) {
                            $aopv = file_get_contents($aopXML);
                            if (preg_match('/\<version\>([^<]+)\<\/version\>/', $aopv, $matches)) {
                                if (version_compare($matches[1], '2.0.1', '>')) {
                                    $multiplePortalSupportAvailable = true;
                                }
                            }
                        }

                        if ($multiplePortalSupportAvailable) {
                            if (!$jaList[0]->joomla_account_id) {
                                throw new JAccountMissingException('Trying to disable a CRM User without related Joomla Portal Account (1)');
                            }
                            $url = $portalURL . '/index.php?m=JAccount&option=com_advancedopenportal&task=disable_user&sug=' . $jaList[0]->id . '::' . $_REQUEST['record'] . '&uid=' . $jaList[0]->joomla_account_id;
                        } else {
                            if (count($portalURLs) > 1) {
                                $msg = $mod_strings['LBL_PLEASE_UPDATE_DEPRECATED_PORTAL_ERROR'] . " ($portalURL)";
                                SugarApplication::appendErrorMessage($msg);
                                SugarApplication::redirect("index.php?module=Contacts&action=DetailView&record=" . $_REQUEST['record']);

                                return;
                            }
                            if (!$bean->joomla_account_id) {
                                throw new Exception('Trying to disable a CRM User without related Joomla Portal Account (2)');
                            }
                            $url = $portalURL . '/index.php?m=JAccount&option=com_advancedopenportal&task=disable_user&sug=' . $_REQUEST['record'] . '&uid=' . $bean->joomla_account_id;
                            $msg = $mod_strings['LBL_PLEASE_UPDATE_DEPRECATED_PORTAL_WARNING'] . " ($portalURL)";
                            SugarApplication::appendErrorMessage($msg);
                        }

                        $wbsv = file_get_contents($url);
                        $res = json_decode($wbsv);
                        if (json_last_error() != JSON_ERROR_NONE) {
                            $json_msg = json_last_error();
                            if ($json_msg) {
                                $json_msg = " (json parser error: $json_msg)";
                            }
                            throw new Exception("Incorrect response from Joomla Portal Component$json_msg: " . $wbsv);
                        }
                        // append portal to messages
                        if (!isset($res->success) || !$res->success) {
                            $msg = $res->error ? $res->error : $mod_strings['LBL_DISABLE_PORTAL_USER_FAILED'] . " ($portalURL)";
                            SugarApplication::appendErrorMessage($msg);
                        } else {
                            $jaList[0]->portal_account_disabled = 1;
                            $jaList[0]->save(false);
                            SugarApplication::appendErrorMessage($mod_strings['LBL_DISABLE_PORTAL_USER_SUCCESS'] . " ($portalURL)");
                        }
                    }
                }
            }
        }
    } else {
        SugarApplication::appendErrorMessage($mod_strings['LBL_NO_JOOMLA_URL']);
    }
} catch (JAccountMissingException $e) {
    SugarApplication::appendErrorMessage($mod_strings['LBL_NO_RELATED_JACCOUNT']);
}

SugarApplication::redirect("index.php?module=Contacts&action=DetailView&record=".$_REQUEST['record']);
