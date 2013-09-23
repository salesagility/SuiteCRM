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
 * @author Salesagility Ltd <support@salesagility.com>
 */

$dictionary['AOS_PDF_Templates'] = array(
	'table'=>'aos_pdf_templates',
	'audited'=>true,
	'fields'=>array (
  'active' =>
  array (
    'name' => 'active',
    'vname' => 'LBL_ACTIVE',
    'type' => 'bool',
    'massupdate' => 0,
    'default' => true,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => 0,
    'studio' => 'visible',
  ),
  'type' =>
  array (
    'required' => '1',
    'name' => 'type',
    'vname' => 'LBL_TYPE',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => '',
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => 0,
    'len' => 100,
    'options' => 'pdf_template_type_dom',
    'studio' => 'visible',
  ),
  'sample' => 
  array (
    'required' => '0',
    'name' => 'sample',
    'vname' => 'LBL_SAMPLE',
    'source' => 'non-db',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => '',
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => 0,
    'len' => 100,
    'options' => 'pdf_template_sample_dom',
    'studio' => 'visible',
  ),
  'insert_fields' =>
  array(
      'required' => '0',
      'name' => 'insert_fields',
      'vname' => 'LBL_INSERT_FIELDS',
      'studio' => 'visible',
      'source' => 'non-db',
      'type' => 'enum',
      'massupdate' => 0,
      'default' => '',
      'comments' => '',
      'help' => '',
      'reportable' => 0,
  ),
  'pdfheader' => 
  array (
    'required' => false,
    'name' => 'pdfheader',
    'vname' => 'LBL_HEADER',
    'type' => 'text',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'size' => '20',
    'studio' => 'visible',
    'rows' => '4',
    'cols' => '20',
  ),
  'pdffooter' => 
  array (
    'required' => false,
    'name' => 'pdffooter',
    'vname' => 'LBL_FOOTER',
    'type' => 'text',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'size' => '20',
    'studio' => 'visible',
    'rows' => '4',
    'cols' => '20',
  ),
  'margin_left' =>
  array (
    'required' => false,
    'name' => 'margin_left',
    'vname' => 'LBL_MARGIN_LEFT',
    'type' => 'int',
    'massupdate' => 0,
    'default' => '15',
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '255',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
  ),
  'margin_right' =>
  array (
    'required' => false,
    'name' => 'margin_right',
    'vname' => 'LBL_MARGIN_RIGHT',
    'type' => 'int',
    'massupdate' => 0,
    'default' => '15',
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '255',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
  ),
  'margin_top' =>
  array (
    'required' => false,
    'name' => 'margin_top',
    'vname' => 'LBL_MARGIN_TOP',
    'type' => 'int',
    'massupdate' => 0,
    'default' => '16',
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '255',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
  ),
  'margin_bottom' =>
  array (
    'required' => false,
    'name' => 'margin_bottom',
    'vname' => 'LBL_MARGIN_BOTTOM',
    'type' => 'int',
    'massupdate' => 0,
    'default' => '16',
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '255',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
  ),
  'margin_header' =>
  array (
    'required' => false,
    'name' => 'margin_header',
    'vname' => 'LBL_MARGIN_HEADER',
    'type' => 'int',
    'massupdate' => 0,
    'default' => '9',
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '255',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
  ),
  'margin_footer' =>
  array (
    'required' => false,
    'name' => 'margin_footer',
    'vname' => 'LBL_MARGIN_FOOTER',
    'type' => 'int',
    'massupdate' => 0,
    'default' => '9',
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '255',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
  ),
),
	'relationships'=>array (
),
	'optimistic_lock'=>true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('AOS_PDF_Templates','AOS_PDF_Templates', array('basic','assignable'));
