<?php
// created: 2014-02-03 12:55:32
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
  'ext_rest_facebook' => 
  array (
    'id' => 'ext_rest_facebook',
    'name' => 'Facebook',
    'enabled' => true,
    'directory' => 'custom/modules/Connectors/connectors/sources/ext/rest/facebook',
    'eapm' => false,
    'modules' => 
    array (
      0 => 'Accounts',
      2 => 'Leads',
      3 => 'Contacts',
    ),
  ),
  'ext_rest_twitter' => 
  array (
    'id' => 'ext_rest_twitter',
    'name' => 'Twitter',
    'enabled' => true,
    'directory' => 'custom/modules/Connectors/connectors/sources/ext/rest/twitter',
    'eapm' => false,
    'modules' => 
    array (
      0 => 'Contacts',
    ),
  ),
);