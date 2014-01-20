<?php

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    require_once('include/connectors/sources/ext/rest/rest.php');

    class ext_rest_facebookAPI extends ext_rest
    {
        public function __construct()
        {
            parent::__construct();

            //Used for testing
            $this->_has_testing_enabled = false;

            //Used to enable hover for the formatter
            $this->_enable_in_hover = true;
        }



        /**
         * getItem
         * Returns an array containing a key/value pair(s) of a source record
         *
         * @param Array $args Array of arguments to search/filter by
         * @param String $module String optional value of the module that the connector framework is attempting to map to
         * @return Array of key/value pair(s) of the source record; empty Array if no results are found
         */
        public function getItem($args=array(), $module=null)
        {

            return null;
        }

        /**
         * getList
         * Returns a nested array containing a key/value pair(s) of a source record
         *
         * @param Array $args Array of arguments to search/filter by
         * @param String $module String optional value of the module that the connector framework is attempting to map to
         * @return Array of key/value pair(s) of source record; empty Array if no results are found
         */
        public function getList($args=array(), $module=null)
        {

            return null;
        }
    }

?>