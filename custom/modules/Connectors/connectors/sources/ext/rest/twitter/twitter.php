<?php

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    require_once('include/connectors/sources/ext/rest/rest.php');

    class ext_rest_twitter extends ext_rest
    {
        public function __construct()
        {
            parent::__construct();
            global $app_list_strings;
            //Used for testing
            $this->_has_testing_enabled = false;
            $this->_enable_in_admin_search = false;
            $this->_enable_in_admin_mapping = false;
            //Used to enable hover for the formatter
            $this->_enable_in_hover = false;

            $this->allowedModuleList = array('Accounts' => $app_list_strings['moduleList']['Accounts'],
                'Contacts' => $app_list_strings['moduleList']['Contacts'],
                'Leads' => $app_list_strings['moduleList']['Leads']);


        }

        /**
         * function to force only to let the modules in the allowed list to appear in the enable connectors,
         *
         * @param array $moduleList
         * @return array
         */
        public function filterAllowedModules( $moduleList ) {
            // InsideView currently has no ability to talk to modules other than these four
            $outModuleList = array();
            foreach ( $moduleList as $module ) {
                if ( !in_array($module,$this->allowedModuleList) ) {
                    continue;
                } else {
                    $outModuleList[$module] = $module;
                }
            }
            return $outModuleList;
        }

        public function getItem($args=array(), $module=null)
        {  return null; }

        public function getList($args=array(), $module=null)
        {  return null;  }
    }

?>