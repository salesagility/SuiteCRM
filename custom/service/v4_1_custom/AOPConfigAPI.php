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
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once('service/v4_1/SugarWebServiceImplv4_1.php');
class AOPConfigAPI extends SugarWebServiceImplv4_1 {

    function get_aop_config($session) {
        global $sugar_config;
        $GLOBALS['log']->info('Begin: SugarWebServiceImplv4_1_custom->get_aop_config');
        $error = new SoapError();

        //authenticate
        if (!self::$helperObject->checkSessionAndModuleAccess($session, 'invalid_session', '', '', '',  $error))
        {
            $GLOBALS['log']->info('End: SugarWebServiceImplv4_1_custom->get_aop_config.');
            return false;
        }
        $whitelist = array('allow_portal_status_change');
        $ret = array();
        foreach($sugar_config['aop'] as $key => $value){
            if(in_array($key,$whitelist)){
                $ret[$key] = $value;
            }
        }
        return $ret;
    }
} 