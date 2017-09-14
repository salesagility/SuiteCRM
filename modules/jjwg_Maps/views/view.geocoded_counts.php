<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class Jjwg_MapsViewGeocoded_Counts extends SugarView
{

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function Jjwg_MapsViewGeocoded_Counts()
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    function __construct()
    {
        parent::__construct();
    }

    function display()
    {

        echo '<div class="moduleTitle"><h2>' . $GLOBALS['mod_strings']['LBL_GEOCODED_COUNTS'] . '</h2><div class="clear"></div></div>';
        echo '<div class="clear"></div>';
        echo $GLOBALS['mod_strings']['LBL_GEOCODED_COUNTS_DESCRIPTION'];
        echo '<br /><br />';

        // Display last status code, if set.
        if (!empty($_REQUEST['last_status']) && preg_match('/[A-Z\_]/', $_REQUEST['last_status'])) {
            echo '<div><b>' . $GLOBALS['mod_strings']['LBL_MAP_LAST_STATUS'] . ': ' . $_REQUEST['last_status'] . '</b></div>';
            echo '<br /><br />';
        }

        echo '<table cellspacing="0" cellpadding="0" border="0" class="list view" style="width: 50% !important;"><tbody>';
        echo '<tr><th>' . $GLOBALS['mod_strings']['LBL_MODULE_HEADING'] . '</th>';
        foreach ($this->bean->geocoded_headings as $heading) {
            echo '<th>' . $heading . '</th>';
        }
        echo '<th>' . $GLOBALS['mod_strings']['LBL_MODULE_TOTAL_HEADING'] . '</th>';
        echo '<th>' . $GLOBALS['mod_strings']['LBL_MODULE_RESET_HEADING'] . '</th>';
        echo '</tr>' . "\n";

        foreach ($GLOBALS['jjwg_config']['valid_geocode_modules'] as $module) {

            $geocode_url = './index.php?module=jjwg_Maps&action=geocode_addresses&display_module=' . $module;
            $reset_url = './index.php?module=jjwg_Maps&action=reset_geocoding&display_module=' . $module;

            echo '<tr>';
            echo '<td><strong><a href="' . htmlspecialchars($geocode_url) . '">' . $GLOBALS['app_list_strings']['moduleList'][$module] . '</a></strong></td>';
            foreach ($this->bean->geocoded_headings as $heading) {
                echo '<td>' . $this->bean->geocoded_counts[$module][$heading] . '</td>';
            }
            echo '<td><strong>' . $this->bean->geocoded_module_totals[$module] . '</strong></td>';
            echo '<td><strong><a href="' . htmlspecialchars($reset_url) . '">' . $GLOBALS['mod_strings']['LBL_MODULE_RESET_HEADING'] . '</a.</strong></td>';
            echo '</tr>' . "\n";
        }

        echo '</tbody></table>';
        echo '<br /><br />';

        // Custom Entry Point Registry:
        // $entry_point_registry['jjwg_Maps'] = array('file' => 'modules/jjwg_Maps/jjwg_Maps_Router.php', 'auth' => false);
        // Usage / Cron URL: index.php?module=jjwg_Maps&entryPoint=jjwg_Maps&cron=1

        echo '<strong>' . $GLOBALS['mod_strings']['LBL_CRON_URL'] . '</strong>';
        echo '<br /><br />';
        echo $GLOBALS['mod_strings']['LBL_CRON_INSTRUCTIONS'];
        echo '<br /><br />';

        $cron_url = './index.php?module=jjwg_Maps&entryPoint=jjwg_Maps&cron=1';

        echo '<a href="' . $cron_url . '">' . $cron_url . '</a>';
        echo '<br /><br />';
        echo '<br /><br />';

        echo '<strong>' . $GLOBALS['mod_strings']['LBL_EXPORT_ADDRESS_URL'] . '</strong>';
        echo '<br /><br />';

        echo $GLOBALS['mod_strings']['LBL_EXPORT_INSTRUCTIONS'];
        echo '<br /><br />';

        $export_url = './index.php?module=jjwg_Maps&action=export_geocoding_addresses&display_module=';

        echo '<a target="_blank" href="' . htmlspecialchars($export_url) . $GLOBALS['app_strings']['LBL_ACCOUNTS'] . '">' . $GLOBALS['app_strings']['LBL_EXPORT'] . ' ' . $GLOBALS['app_strings']['LBL_ACCOUNTS'] . '</a>';
        echo '<br /><br />';
        echo '<a target="_blank" href="' . htmlspecialchars($export_url) . $GLOBALS['app_strings']['LBL_CONTACTS'] . '">' . $GLOBALS['app_strings']['LBL_EXPORT'] . ' ' . $GLOBALS['app_strings']['LBL_CONTACTS'] . '</a>';
        echo '<br /><br />';
        echo '<a target="_blank" href="' . htmlspecialchars($export_url) . $GLOBALS['app_strings']['LBL_LEADS'] . '">' . $GLOBALS['app_strings']['LBL_EXPORT'] . ' ' . $GLOBALS['app_strings']['LBL_LEADS'] . '</a>';
        echo '<br /><br />';
        echo '<a target="_blank" href="' . htmlspecialchars($export_url) . $GLOBALS['app_strings']['LBL_PROSPECTS'] . '">' . $GLOBALS['app_strings']['LBL_EXPORT'] . ' ' . $GLOBALS['app_strings']['LBL_PROSPECTS'] . '</a>';
        echo '<br /><br />';

        echo '<br /><br />';
        echo '<br /><br />';
        echo '<br /><br />';

        $delete_url = './index.php?module=jjwg_Maps&action=delete_all_address_cache';
        echo '<a href="' . htmlspecialchars($delete_url) . '">' . $GLOBALS['app_strings']['LBL_DELETE'] . ' - ' . $GLOBALS['mod_strings']['LBL_ADDRESS_CACHE'] . '</a>';

    }
}

