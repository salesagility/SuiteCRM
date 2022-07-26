<?php
/**
 * Products, Quotations & Invoices modules.
 * Extensions to SugarCRM
 * @package Advanced OpenSales for SugarCRM
 * @subpackage Products
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

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/AOS_PDF_Templates/AOS_PDF_Templates_sugar.php');
class AOS_PDF_Templates extends AOS_PDF_Templates_sugar
{
    public static $excludedModulesForCreateTemplates = ['Home', 'Calendar'];
    public static $excludedModulesToAddButtons = [
        'Home', 
        'Calendar', 
        'Users', 
        'SecurityGroups',
        'OAuth2Clients', 
        'OAuthKeys',  
        'Schedulers',  
        'AOS_Contracts',  //  The Contracts, Quotes and Invoices modules
        'AOS_Quotes',     //  add their own custom buttons 
        'AOS_Invoices'    //  and therefore they are excluded.
    ];

    public function __construct()
    {
        parent::__construct();
        global $app_list_strings;
        $app_list_strings['pdf_template_type_dom'] = $this->loadTabModules();        
    }

    public static function loadTabModules()
    {
        global $app_list_strings;
        include_once 'modules/MySettings/TabController.php';
        $controller = new TabController();
        $currentTabs = $controller->get_system_tabs();

        $modules = array();
        foreach($currentTabs as $key => $mod){
            if (!in_array($mod, self::$excludedModulesForCreateTemplates)) {
                $modules[$key] = (isset($app_list_strings['moduleList'][$key])) ? $app_list_strings['moduleList'][$key] : $key;
            }
        }

        asort($modules);
        return $modules;
    }
}
