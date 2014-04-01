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
$dictionary["Case"]["fields"]['update_text'] =
    array (
        'required' => false,
        'name' => 'update_text',
        'vname' => 'LBL_UPDATE_TEXT',
        'source' => 'non-db',
        'type' => 'text',
        'massupdate' => '0',
        'default' => '',
        'no_default' => false,
        'comments' => '',
        'help' => '',
        'importable' => 'true',
        'duplicate_merge' => 'disabled',
        'duplicate_merge_dom_value' => '0',
        'audited' => false,
        'reportable' => true,
        'unified_search' => false,
        'merge_filter' => 'disabled',
        'size' => '20',
        'studio' => 'visible',
        'rows' => 6,
        'cols' => 80,
        'id' => 'Casesupdate_text',
    );

$dictionary['Case']['fields']['resolution']['rows'] = 6;
$dictionary['Case']['fields']['resolution']['cols'] = 80;
$dictionary["Case"]["fields"]['internal'] =
            array(
                'name' => 'internal',
                'source' => 'non-db',
                'vname' => 'LBL_INTERNAL',
                'type' => 'bool',
                'studio' => 'visible',
            );
$dictionary["Case"]["fields"]['status']['type'] = 'dynamicenum';
$dictionary["Case"]["fields"]['status']['dbtype'] = 'enum';
$dictionary["Case"]["fields"]['status']['parentenum'] = 'state';



$dictionary["Case"]["fields"]['state'] =
    array (
        'name' => 'state',
        'vname' => 'LBL_STATE',
        'type' => 'enum',
        'options' => 'case_state_dom',
        'len' => 100,
        'audited' => true,
        'comment' => 'The state of the case (i.e. open/closed)',
        'default' => 'Open',
        'parentenum' => 'status',
        'merge_filter' => 'disabled',
    );

$dictionary["Case"]["fields"]['aop_case_updates_threaded'] =
    array (
        'required' => false,
        'name' => 'aop_case_updates_threaded',
        'vname' => 'LBL_AOP_CASE_UPDATES_THREADED',
        'type' => 'function',
        'source' => 'non-db',
        'massupdate' => 0,
        'studio' => 'visible',
        'importable' => 'false',
        'duplicate_merge' => 'disabled',
        'duplicate_merge_dom_value' => 0,
        'audited' => false,
        'reportable' => false,
        'function' =>
        array (
            'name' => 'display_updates',
            'returns' => 'html',
            'include' => 'modules/AOP_Case_Updates/Case_Updates.php'
        ),
    );
$dictionary["Case"]["fields"]["aop_case_updates"] = array (
    'name' => 'aop_case_updates',
    'type' => 'link',
    'relationship' => 'cases_aop_case_updates',
    'source' => 'non-db',
    'id_name' => 'case_id',
    'vname' => 'LBL_AOP_CASE_UPDATES',
);
 ?>