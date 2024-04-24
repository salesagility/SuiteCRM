<?php
$dictionary['Contact']['fields']['ut_ordersupplier'] =
array (
    'name' => 'ut_ordersupplier',
    'vname' => 'LBL_UT_ORDERSUPPLIER',
    'type' => 'link',
    'relationship' => 'contact_ut_ordersupplier',
    'module' => 'UT_OrderSupplier',
    'bean_name' => 'UT_OrderSupplier',
    'source' => 'non-db',
);
$dictionary['Contact']['relationships']['contact_ut_ordersupplier'] =
array (
    'lhs_module' => 'Contacts',
    'lhs_table' => 'contacts',
    'lhs_key' => 'id',
    'rhs_module' => 'UT_OrderSupplier',
    'rhs_table' => 'ut_ordersupplier',
    'rhs_key' => 'billing_contact_id',
    'relationship_type' => 'one-to-many',
);

