<?php
$dictionary['Account']['fields']['ut_ordersupplier'] =
array (
    'name' => 'ut_ordersupplier',
    'vname' => 'LBL_UT_ORDERSUPPLIER',
    'type' => 'link',
    'relationship' => 'account_ut_ordersupplier',
    'module' => 'UT_OrderSupplier',
    'bean_name' => 'UT_OrderSupplier',
    'source' => 'non-db',
);
$dictionary['Account']['relationships']['account_ut_ordersupplier'] =
array (
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'UT_OrderSupplier',
    'rhs_table' => 'ut_ordersupplier',
    'rhs_key' => 'billing_account_id',
    'relationship_type' => 'one-to-many',
);

