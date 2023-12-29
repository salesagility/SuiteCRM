<?php
/**
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
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
 * You can contact Christian Knoll at info@kreporter.org
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

function additionalDetailsKReport($fields) {
    static $mod_strings;
    global $app_list_strings;
    if (empty($mod_strings)) {
        global $current_language;
        $mod_strings = return_module_language($current_language, 'KReports');
    }

    $overlib_string = '';

    if (!empty($fields['DESCRIPTION'])) {
        $overlib_string .= html_entity_decode($fields['DESCRIPTION']);
        if (strlen($fields['DESCRIPTION']) > 300)
            $overlib_string .= '...';
    }
    else
        $overlib_string .= 'no Description maintained';

    $editLink = "index.php?action=EditView&module=KReports&record={$fields['ID']}";
    $viewLink = "index.php?action=DetailView&module=Reports&record={$fields['ID']}";

    $return_module = empty($_REQUEST['module']) ? 'KReports' : $_REQUEST['module'];
    $return_action = empty($_REQUEST['action']) ? 'ListView' : $_REQUEST['action'];

    $editLink .= "&return_module=$return_module&return_action=$return_action";
    $viewLink .= "&return_module=$return_module&return_action=$return_action";

    return array('fieldToAddTo' => 'NAME',
        'string' => $overlib_string,
        'editLink' => $editLink,
        'viewLink' => $viewLink);
}

?>
