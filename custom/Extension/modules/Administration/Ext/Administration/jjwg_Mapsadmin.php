<?php

$admin_option_defs = array();

$admin_option_defs['jjwg_Maps']['config'] = array('Administration', 'LBL_JJWG_MAPS_ADMIN_CONFIG_TITLE', 'LBL_JJWG_MAPS_ADMIN_CONFIG_DESC', './index.php?module=jjwg_Maps&action=config');
$admin_option_defs['jjwg_Maps']['geocoded_counts'] = array('Contacts', 'LBL_JJWG_MAPS_ADMIN_GEOCODED_COUNTS_TITLE', 'LBL_JJWG_MAPS_ADMIN_GEOCODED_COUNTS_DESC', './index.php?module=jjwg_Maps&action=geocoded_counts');
$admin_option_defs['jjwg_Maps']['geocoding_test'] = array('CreateContacts', 'LBL_JJWG_MAPS_ADMIN_GEOCODING_TEST_TITLE', 'LBL_JJWG_MAPS_ADMIN_GEOCODING_TEST_DESC', './index.php?module=jjwg_Maps&action=geocoding_test');
$admin_option_defs['jjwg_Maps']['geocode_addresses'] = array('CreateContacts', 'LBL_JJWG_MAPS_ADMIN_GEOCODE_ADDRESSES_TITLE', 'LBL_JJWG_MAPS_ADMIN_GEOCODE_ADDRESSES_DESC', './index.php?module=jjwg_Maps&action=geocode_addresses');
$admin_option_defs['jjwg_Maps']['donate'] = array('Opportunities', 'LBL_JJWG_MAPS_ADMIN_DONATE_TITLE', 'LBL_JJWG_MAPS_ADMIN_DONATE_DESC', './index.php?module=jjwg_Maps&action=donate');
$admin_option_defs['jjwg_Maps']['address_cache'] = array('Contacts', 'LBL_JJWG_MAPS_ADMIN_ADDRESS_CACHE_TITLE', 'LBL_JJWG_MAPS_ADMIN_ADDRESS_CACHE_DESC', './index.php?module=jjwg_Address_Cache&action=index');

$admin_group_header[]= array('LBL_JJWG_MAPS_ADMIN_HEADER', '', false, $admin_option_defs, 'LBL_JJWG_MAPS_ADMIN_DESC');

?>
