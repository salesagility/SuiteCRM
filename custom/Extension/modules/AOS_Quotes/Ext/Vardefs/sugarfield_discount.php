<?php
$dictionary['AOS_Quotes']['fields']['overall_discount_amount'] = 
array(
    'required' => false,
    'name' => 'overall_discount_amount',
    'vname' => 'LBL_OVERALL_DISCOUNT_AMOUNT',
    'type' => 'currency',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => true,
    'len' => '26,6',
);
$dictionary['AOS_Quotes']['fields']['overall_discount_amount_usdollar'] = 
array(
    'name' => 'overall_discount_amount_usdollar',
    'vname' => 'LBL_OVERALL_DISCOUNT_AMOUNT_USDOLLAR',
    'type' => 'currency',
    'group' => 'discount_amount',
    'disable_num_format' => true,
    'duplicate_merge' => '0',
    'audited' => true,
    'comment' => '',
    'studio' => array(
        'editview' => false,
        'detailview' => false,
        'quickcreate' => false,
    ),
    'len' => '26,6',
);
$dictionary['AOS_Quotes']['fields']['other_charges_amount'] = 
array(
    'required' => false,
    'name' => 'other_charges_amount',
    'vname' => 'LBL_OTHER_CHARGES_AMOUNT',
    'type' => 'currency',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => true,
    'len' => '26,6',
);
$dictionary['AOS_Quotes']['fields']['other_charges_amount_usdollar'] = 
array(
    'name' => 'other_charges_amount_usdollar',
    'vname' => 'LBL_OTHER_CHARGES_AMOUNT_USDOLLAR',
    'type' => 'currency',
    'group' => 'discount_amount',
    'disable_num_format' => true,
    'duplicate_merge' => '0',
    'audited' => true,
    'comment' => '',
    'studio' => array(
        'editview' => false,
        'detailview' => false,
        'quickcreate' => false,
    ),
    'len' => '26,6',
);
$dictionary['AOS_Quotes']['fields']['line_items']['function'] = 
array(
    'name' => 'custom_display_lines',
    'returns' => 'html',
    'include' => 'custom/modules/AOS_Products_Quotes/Line_Items.php'
);
?>
