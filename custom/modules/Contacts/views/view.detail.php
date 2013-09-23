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
require_once('modules/Contacts/views/view.detail.php');

class CustomContactsViewDetail extends ContactsViewDetail{
    public function display(){
        global $sugar_config;

        $aop_portal_enabled = false;
        if(array_key_exists('aop',$sugar_config) && array_key_exists('joomla_url',$sugar_config['aop'])){
            $aop_portal_enabled = !empty($sugar_config['aop']['joomla_url']);
        }
        $this->ss->assign("AOP_PORTAL_ENABLED", $aop_portal_enabled);
        parent::display();
    }
}