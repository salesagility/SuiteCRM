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
 * @author SalesAgility Ltd <support@salesagility.com>
 */
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
require_once 'modules/AOP_Case_Updates/util.php';
if (!isAOPEnabled()) {
    return;
}
global $sugar_config, $mod_strings;

require_once('modules/Contacts/Contact.php');

$bean = new Contact();
$bean->retrieve($_REQUEST['record']);

if (array_key_exists("aop", $sugar_config) && array_key_exists("joomla_url", $sugar_config['aop'])) {
    $portalURL = $sugar_config['aop']['joomla_url'];
    $wbsv = file_get_contents($portalURL.'/index.php?option=com_advancedopenportal&task=disable_user&sug='.$_REQUEST['record'].'&uid='.$bean->joomla_account_id);
    $res = json_decode($wbsv);
    if (!$res->success) {
        $msg = $res->error ? $res->error : $mod_strings['LBL_DISABLE_PORTAL_USER_FAILED'];
        SugarApplication::appendErrorMessage($msg);
    } else {
        $bean->portal_account_disabled = 1;
        $bean->save(false);
        SugarApplication::appendErrorMessage($mod_strings['LBL_DISABLE_PORTAL_USER_SUCCESS']);
    }
} else {
    SugarApplication::appendErrorMessage($mod_strings['LBL_NO_JOOMLA_URL']);
}

SugarApplication::redirect("index.php?module=Contacts&action=DetailView&record=".$_REQUEST['record']);
