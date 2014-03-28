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
$dictionary["Contact"]["fields"]["aop_case_updates"] = array (
    'name' => 'aop_case_updates',
    'type' => 'link',
    'relationship' => 'contacts_aop_case_updates',
    'source' => 'non-db',
    'id_name' => 'contact_id',
    'vname' => 'LBL_AOP_CASE_UPDATES',
);

$dictionary["Contact"]["relationships"]["contacts_aop_case_updates"] = array (
    'lhs_module'=> 'Contacts',
    'lhs_table'=> 'contacts',
    'lhs_key' => 'id',
    'rhs_module'=> 'AOP_Case_Updates',
    'rhs_table'=> 'aop_case_updates',
    'rhs_key' => 'contact_id',
    'relationship_type'=>'one-to-many',
);

$dictionary["Contact"]["fields"]["joomla_account_id"] = array (
    'name' => 'joomla_account_id',
    'vname' => 'LBL_JOOMLA_ACCOUNT_ID',
    'type' => 'varchar',
    'len' => '255',
    'importable' => 'false',
    'studio' => 'true',
);
$dictionary["Contact"]["fields"]["portal_account_disabled"] = array (
    'name' => 'portal_account_disabled',
    'vname' => 'LBL_PORTAL_ACCOUNT_DISABLED',
    'type' => 'bool',
    'importable' => 'false',
    'studio' => 'false',
);
$dictionary["Contact"]["fields"]["joomla_account_access"] = array (
    'name' => 'joomla_account_access',
    'vname' => 'LBL_JOOMLA_ACCOUNT_ACCESS',
    'type' => 'varchar',
    'source' => 'non-db',
    'len' => '255',
    'importable' => 'false',
    'studio' => 'false',
);
$dictionary["Contact"]["fields"]["portal_user_type"] = array (
    'name' => 'portal_user_type',
    'vname' => 'LBL_PORTAL_USER_TYPE',
    'type' => 'enum',
    'options' => 'contact_portal_user_type_dom',
    'len' => '100',
    'default' => 'Single',
);
 ?>