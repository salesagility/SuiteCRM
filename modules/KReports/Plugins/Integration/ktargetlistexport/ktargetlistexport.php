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

require_once('modules/KReports/Plugins/prototypes/kreportintegrationplugin.php');

class ktargetlistexport extends kreportintegrationplugin {

    public function __construct() {
        global $mod_strings;
        $this->pluginName = $mod_strings['LBL_EXPORT_TO_TARGETLIST_BUTTON_LABEL'];
    }

    public function checkAccess($thisReport){

        require_once('modules/ProspectLists/ProspectList.php');
        $newProspectList = new ProspectList();

        // fill with results:
        $newProspectList->load_relationships();

        $linkedFields = $newProspectList->get_linked_fields();

        $foundModule = false;

        foreach ($linkedFields as $linkedField => $linkedFieldData) {
            if ($newProspectList->$linkedField->_relationship->rhs_module == $thisReport->report_module) {
                $foundModule = true;
            }
        }

        return ($foundModule) ? true : false;
    }
    
    public function getMenuItem() {
        return array(
            'jsFile' => 'modules/KReports/Plugins/Integration/ktargetlistexport/ktargetlistexport.js',
            'menuItem' => array(
                'icon' => $this->wrapText('modules/KReports/images/targetlist.png'),
                'text' => $this->wrapText($this->pluginName),
                'handler' => $this->wrapFunction('ktargetlistexport')
                ));
    }

}

?>
