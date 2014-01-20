<?php
// created: 2014-01-20 12:14:36
$connectors = array (
  'ext_rest_linkedin' => 
  array (
    'id' => 'ext_rest_linkedin',
    'name' => 'LinkedIn&#169;',
    'enabled' => true,
    'directory' => 'modules/Connectors/connectors/sources/ext/rest/linkedin',
    'eapm' => 
    array (
      'enabled' => true,
    ),
    'modules' => 
    array (
      0 => 'Accounts',
      1 => 'Contacts',
      2 => 'Leads',
      3 => 'Prospects',
    ),
  ),
  'ext_rest_insideview' => 
  array (
    'id' => 'ext_rest_insideview',
    'name' => 'InsideView&#169;',
    'enabled' => true,
    'directory' => 'modules/Connectors/connectors/sources/ext/rest/insideview',
    'eapm' => false,
    'modules' => 
    array (
      0 => 'Accounts',
      1 => 'Contacts',
      2 => 'Leads',
      3 => 'Opportunities',
    ),
  ),
);