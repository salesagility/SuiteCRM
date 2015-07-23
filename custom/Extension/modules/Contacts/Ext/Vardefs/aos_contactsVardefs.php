<?php
$dictionary["Contact"]["fields"]["aos_quotes"] = array (
  'name' => 'aos_quotes',
    'type' => 'link',
    'relationship' => 'contact_aos_quotes',
    'module'=>'AOS_Quotes',
    'bean_name'=>'AOS_Quotes',
    'source'=>'non-db',
);
$dictionary["Contact"]["relationships"]["contact_aos_quotes"] = array (
	'lhs_module'=> 'Contacts', 
	'lhs_table'=> 'contacts', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Quotes', 
	'rhs_table'=> 'aos_quotes', 
	'rhs_key' => 'billing_contact_id',
	'relationship_type'=>'one-to-many',
);

$dictionary["Contact"]["fields"]["aos_invoices"] = array (
  'name' => 'aos_invoices',
    'type' => 'link',
    'relationship' => 'contact_aos_invoices',
    'module'=>'AOS_Invoices',
    'bean_name'=>'AOS_Invoices',
    'source'=>'non-db',
);
$dictionary["Contact"]["relationships"]["contact_aos_invoices"] = array (
	'lhs_module'=> 'Contacts', 
	'lhs_table'=> 'contacts', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Invoices', 
	'rhs_table'=> 'aos_invoices', 
	'rhs_key' => 'billing_contact_id',
	'relationship_type'=>'one-to-many',
);

$dictionary["Contact"]["fields"]["aos_contracts"] = array (
  'name' => 'aos_contracts',
    'type' => 'link',
    'relationship' => 'contact_aos_contracts',
    'module'=>'AOS_Contracts',
    'bean_name'=>'AOS_Contracts',
    'source'=>'non-db',
);
$dictionary["Contact"]["relationships"]["contact_aos_contracts"] = array (
	'lhs_module'=> 'Contacts', 
	'lhs_table'=> 'contacts', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Contracts', 
	'rhs_table'=> 'aos_contracts', 
	'rhs_key' => 'contact_id',
	'relationship_type'=>'one-to-many',
);
?>
