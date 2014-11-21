<?php
 /**
 * 
 * 
 * @package 
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

require_once('include/MVC/View/views/view.edit.php');
class AOR_ReportsViewEdit extends ViewEdit {

    public function __construct() {
        parent::ViewEdit();
    }

    public function preDisplay() {
        global $app_list_strings;
        echo "<style type='text/css'>";
        readfile('modules/AOR_Reports/css/edit.css');
        readfile('modules/AOR_Reports/js/jqtree/jqtree.css');
        echo "</style>";
        if (!is_file('cache/jsLanguage/AOR_Fields/' . $GLOBALS['current_language'] . '.js')) {
            require_once ('include/language/jsLanguage.php');
            jsLanguage::createModuleStringsCache('AOR_Fields', $GLOBALS['current_language']);
        }

        echo '<script src="include/javascript/yui3/build/yui/yui-min.js"></script>';
        echo '<script src="cache/jsLanguage/AOR_Fields/'. $GLOBALS['current_language'] . '.js"></script>';
        echo "<script>";
        echo "sort_by_values = \"".trim(preg_replace('/\s+/', ' ', get_select_options_with_id($app_list_strings['aor_sort_operator'], '')))."\";";
        echo "</script>";
        parent::preDisplay();
    }


}
