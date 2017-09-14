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

class Jjwg_MapsViewQuick_Radius extends SugarView
{

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function Jjwg_MapsViewQuick_Radius()
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

        if (!isset($_REQUEST['quick_address'])) {
            $_REQUEST['quick_address'] = '';
        }
        ?>

        <div class="moduleTitle">
            <h2><?php echo $GLOBALS['mod_strings']['LBL_MAP_QUICK_RADIUS']; ?>
                <div class="clear"></div>
            </h2>
        </div>
        <div class="clear"></div>

        <form name="quickradius" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
            <input type="hidden" name="module" value="<?php echo $GLOBALS['currentModule']; ?>">
            <input type="hidden" name="action" value="quick_radius_display"/>

            <table border="0">
                <tr>
                    <td>
                        <strong><?php echo $GLOBALS['mod_strings']['LBL_MAP_ADDRESS'] . ': '; ?> </strong>
                    </td>
                    <td>
                        <input type="text" name="quick_address" id="quick_address"
                               value="<?php echo htmlspecialchars($_REQUEST['quick_address']); ?>" title=''
                               tabindex='101' size="40" maxlength="255">
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo $GLOBALS['mod_strings']['LBL_MODULE_TYPE'] . ' '; ?> </strong>
                    </td>
                    <td>
                        <select id="display_module" tabindex="111"
                                title="<?php echo $GLOBALS['mod_strings']['LBL_MODULE_TYPE']; ?>" name="display_module">
                            <?php foreach ($GLOBALS['jjwg_config']['valid_geocode_modules'] as $module) { ?>
                            <option value="<?php echo htmlspecialchars($module); ?>" <?php
                            if (!empty($_REQUEST['display_module']) && $module == $_REQUEST['display_module']) {
                                echo 'selected="selected"';
                            }
                            ?>><?php echo htmlspecialchars($GLOBALS['app_list_strings']['moduleList'][$module]); ?>
                                <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo $GLOBALS['mod_strings']['LBL_DISTANCE'] . ' '; ?> </strong>
                    </td>
                    <td>
                        <input type="text" name="distance" id="distance"
                               value="<?php echo htmlspecialchars($_REQUEST['distance']); ?>" title='' tabindex='121'
                               size="10" maxlength="10">
                        <select id="unit_type" tabindex="131"
                                title="<?php echo $GLOBALS['mod_strings']['LBL_DISTANCE']; ?>" name="unit_type">
                            <?php foreach ($GLOBALS['app_list_strings']['map_unit_type_list'] as $key => $value) { ?>
                            <option value="<?php echo htmlspecialchars($key); ?>" <?php
                            if ($key == $_REQUEST['unit_type']) {
                                echo 'selected="selected"';
                            }
                            ?>><?php echo htmlspecialchars($value); ?>
                                <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
            <br/>
            <input class="button" tabindex="211" type="submit" name="submit"
                   value="<?php echo $GLOBALS['mod_strings']['LBL_MAP_PROCESS']; ?>" align="bottom">
        </form>

        <?php
    }
}
