<?php
$module_name = 'AOS_Products_Quotes';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 => 
          array (
            'name' => 'product_qty',
            'label' => 'LBL_PRODUCT_QTY',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'product_cost_price',
            'label' => 'LBL_PRODUCT_COST_PRICE',
          ),
          1 => 
          array (
            'name' => 'product_list_price',
            'label' => 'LBL_PRODUCT_LIST_PRICE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'product_unit_price',
            'label' => 'LBL_PRODUCT_UNIT_PRICE',
          ),
          1 => 
          array (
            'name' => 'vat',
            'label' => 'LBL_VAT',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'vat_amt',
            'label' => 'LBL_VAT_AMT',
          ),
          1 => 
          array (
            'name' => 'product_total_price',
            'label' => 'LBL_PRODUCT_TOTAL_PRICE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'product',
            'label' => 'LBL_PRODUCT',
          ),
          1 => 
          array (
            'name' => 'parent_name',
            'label' => 'LBL_FLEX_RELATE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
      ),
    ),
  ),
);
