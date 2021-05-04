<?php
$module_name = 'n2804_purchases';
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
          3 => 'FIND_DUPLICATES',
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
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'quantity',
            'label' => 'LBL_QUANTITY',
          ),
        ),
        1 => 
        array (
          0 => 'description',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'date_of_purchase',
            'label' => 'LBL_DATE_OF_PURCHASE',
          ),
          1 => 
          array (
            'name' => 'total_cost_gbp',
            'label' => 'LBL_TOTAL_COST_GBP',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'total_cost_eur',
            'label' => 'LBL_TOTAL_COST_EUR',
          ),
          1 => 
          array (
            'name' => 'total_cost_aud',
            'label' => 'LBL_TOTAL_COST_AUD',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'total_cost_nzd',
            'label' => 'LBL_TOTAL_COST_NZD',
          ),
          1 => 
          array (
            'name' => 'total_cost_usd',
            'label' => 'LBL_TOTAL_COST_USD',
          ),
        ),
      ),
    ),
  ),
);
;
?>
