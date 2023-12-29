<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/MassUpdate.php';
require_once 'include/utils.php';

class CustomMassUpdate extends MassUpdate
{

    /**
     * Method override to allow MassUpdate for ColorPicker type fields
     * STIC#4
     * STIC#336
     * 
     * @param string $displayname field label
     * @param string $field field name
     * @param bool $even even or odd
     * @return string html field data
     */
    protected function addDefault($displayname, $field, &$even)
    {
        $even = !$even;
        $varname = $field["name"];
        $displayname = addslashes($displayname);

        if(in_array($field["type"], array('ColorPicker'))) {
            $scriptColorPicker = getVersionedScript("SticInclude/vendor/jqColorPicker/jqColorPicker.min.js");
            $html = <<<EOQ
                <td scope="row" width="20%">$displayname</td>
                <td class="dataField" width="30%"><input autocomplete="off" type="text" name="$varname" style="width: auto; " id="mass_{$varname}" value=""></td>
                $scriptColorPicker
                <script type="text/javascript">
                    $("#mass_$varname").colorPicker({
                        renderCallback: function(elm, toggled) { if (elm.val()) { var colors = this.color.colors; elm.val('#' + colors.HEX); } },
                        opacity: false});
                </script>
            EOQ;
            return $html;
        } else {
            return '';
        }
    }

}
