<?php

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    require_once('include/connectors/sources/ext/rest/rest.php');

    class ext_rest_twitter extends ext_rest
    {
        public function __construct()
        {
            parent::__construct();

            //Used for testing
            $this->_has_testing_enabled = false;
            $this->_enable_in_admin_search = false;
            //Used to enable hover for the formatter
            $this->_enable_in_hover = false;
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
            $result = null;
            if ($args['id'] == 1)
            {
                $result = array();
                $result['id'] = '1'; //Unique record identifier
                $result['firstname'] = 'John';
                $result['lastname'] = 'Doe';
                $result['email'] = 'john.doe@sugar.crm';
                $result['state'] = 'CA';
            }
            else if ($args['id'] == 2)
            {
                $result = array();
                $result['id'] = '2'; //Unique record identifier
                $result['firstname'] = 'Jane';
                $result['lastname'] = 'Doe';
                $result['email'] = 'jane.doe@sugar.crm';
                $result['state'] = 'HI';
            }

            return $result;
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
            $results = array();
            if(!empty($args['name']['last']) && strtolower($args['name']['last']) == 'doe')
            {
                $results[1] = array('
                    id' => 1,
                    'firstname' => 'John',
                    'lastname' => 'Doe',
                    'email' => 'john.doe@sugar.crm',
                    'state' => 'CA'
                );

                $results[2] = array(
                    'id' => 2,
                    'firstname' => 'Jane',
                    'lastname' => 'Doe',
                    'email' => 'john.doe@sugar.crm',
                    'state' => 'HI'
                );
            }

            return $results;
        }
    }

?>