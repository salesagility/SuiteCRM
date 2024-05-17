<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
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
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

$viewdefs['Opportunities']['EditView'] = array(
    'templateMeta' => array('maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30')
                                            ),
    'javascript' => '{$PROBABILITY_SCRIPT}',
),
 'panels' =>array(
  'default' =>
  array(

    array(
      array('name'=>'name'),
      'account_name',
    ),
    array(
        array('name'=>'currency_id','label'=>'LBL_CURRENCY'),
        array('name'=>'date_closed'),
    ),
    array(
      array( 'name'=>'amount'),
      'opportunity_type',
    ),
    array(
      'sales_stage',
      'lead_source',
    ),
    array(
        'probability',
          'campaign_name',
    ),
    array(
          'next_step',
    ),
    array(
      'description',
    ),
  ),
  'lbl_line_items' =>
  array(
    0 =>
    array(
      0 =>
      array(
        'name' => 'currency_id',
        'studio' => 'visible',
        'label' => 'LBL_CURRENCY',
      ),
    ),
    1 =>
    array(
      0 =>
      array(
        'name' => 'line_items',
        'label' => 'LBL_LINE_ITEMS',
      ),
    ),
    2 =>
    array(
      0 => '',
    ),
    3 =>
    array(
      0 =>
      array(
        'name' => 'total_amt',
        'label' => 'LBL_TOTAL_AMT',
      ),
    ),
    4 =>
    array(
      0 =>
      array(
        'name' => 'discount_amount',
        'label' => 'LBL_DISCOUNT_AMOUNT',
      ),
    ),
    5 =>
    array(
      0 =>
      array(
        'name' => 'subtotal_amount',
        'label' => 'LBL_SUBTOTAL_AMOUNT',
      ),
    ),
    6 =>
    array(
      0 =>
      array(
        'name' => 'shipping_amount',
        'label' => 'LBL_SHIPPING_AMOUNT',
        'displayParams' =>
        array(
          'field' =>
          array(
            'onblur' => 'calculateTotal(\'lineItems\');',
          ),
        ),
      ),
    ),
    7 =>
    array(
      0 =>
      array(
        'name' => 'shipping_tax_amt',
        'label' => 'LBL_SHIPPING_TAX_AMT',
      ),
    ),
    8 =>
    array(
      0 =>
      array(
        'name' => 'tax_amount',
        'label' => 'LBL_TAX_AMOUNT',
      ),
    ),
    9 =>
    array(
      0 =>
      array(
        'name' => 'total_amount',
        'label' => 'LBL_GRAND_TOTAL',
      ),
    ),
  ),
),

  'LBL_PANEL_ASSIGNMENT' => array(
    array(
        'assigned_user_name',
    ),
  ),


);
