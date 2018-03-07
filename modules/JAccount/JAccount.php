<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


include_once __DIR__ . '/JAccountException.php';
include_once __DIR__ . '/JAccountInvalidUserDataException.php';


/**
 * class JAccount
 */
class JAccount extends Basic
{
    /**
     *
     * @var bool 
     */
    public $new_schema = true;
    
    /**
     *
     * @var string 
     */
    public $module_dir = 'JAccount';
    
    /**
     *
     * @var string 
     */
    public $object_name = 'JAccount';
    
    /**
     *
     * @var string 
     */
    public $table_name = 'jaccount';
    
    /**
     *
     * @var bool 
     */
    public $importable = false;

    /**
     *
     * @var string 
     */
    public $id;
    
    /**
     *
     * @var string 
     */
    public $name;
    
    /**
     *
     * @var string 
     */
    public $date_entered;
    
    /**
     *
     * @var string 
     */
    public $date_modified;
    
    /**
     *
     * @var string 
     */
    public $modified_user_id;
    
    /**
     *
     * @var string 
     */
    public $modified_by_name;
    
    /**
     *
     * @var string 
     */
    public $created_by;
    
    /**
     *
     * @var string 
     */
    public $created_by_name;
    
    /**
     *
     * @var string 
     */
    public $description;
    
    /**
     *
     * @var int 
     */
    public $deleted;
    
    /**
     *
     * @var string 
     */
    public $created_by_link;
    
    /**
     *
     * @var string 
     */
    public $modified_user_link;
    
    /**
     *
     * @var string 
     */
    public $assigned_user_id;
    
    /**
     *
     * @var string 
     */
    public $assigned_user_name;
    
    /**
     *
     * @var string 
     */
    public $assigned_user_link;
    
    /**
     *
     * @var SecurityGroups
     */
    public $SecurityGroups;
    
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
    }
	
    /**
     * 
     * @param string $interface
     * @return boolean
     */
    public function bean_implements($interface)
    {
        switch($interface)
        {
            case 'ACL':
                return true;
        }

        return false;
    }

    /**
     * 
     * @param int|string|null $id
     * @param bool|null $encode
     * @param bool|null $deleted
     * @return SugarBean|null
     */
    public function retrieve($id = -1, $encode = true, $deleted = true) {
        $ret = parent::retrieve($id, $encode, $deleted);
        if($ret) {
            if($contact = BeanFactory::getBean('Contacts', $this->contact_id)) {
                $this->name = $contact->name;
                $this->email1 = $contact->email1;
                $this->save();
            }
        }
        return $ret;
    }

    /**
     * 
     * @param bool $check_notify
     * @return string ID
     * @throws JAccountInvalidUserDataException
     * @throws JAccountException
     */
    public function save($check_notify = false) {
        if(!isset($this->name) || !$this->name || !isset($this->email1) || !$this->email1) {
            throw new JAccountInvalidUserDataException("Trying to save a JAccount without name and/or any email address: (name: {$this->name}, email1: {$this->email1})");
        }
        if($contact = BeanFactory::getBean('Contacts', $this->contact_id)) {

            // update contact info if JAccount updated
            if($contact->name != $this->name || $contact->email1 != $this->email1) {
                $contact->name = $this->name;
                $contact->email1 = $this->email1;

                if(!$contact->save()) {
                    throw new JAccountException("Trying to save a Contact for this JAccount but something happened in SugarBean");
                }
            }

        }
        try {
            $ret = parent::save();
        } catch (Exception $e) {

            // todo: (scrm-436) but now, the Exception without type could be everything..

            // DBManager drop an exception when duplicate index error on insert so a bean already there, retrieve it..

            $ret = $this->retrieve_by_string_fields(array(
                'contact_id' => $contact->id,
                'portal_url' => $this->portal_url,
                'deleted' => '0',
            ));
        }

        if (!$ret) {
            throw new JAccountException("Trying to save/retrieve a JAccount but something went wrong in SugarBean");
        }

        return $ret;
    }

    /**
     * Return the rest requested JAccount bean
     * to get the joomla account access (password)
     * and handle the errors correctly
     * (return false on error)
     *
     * @param array $request $_REQUEST
     * @return bool|JAccount
     * @throws JAccountException
     */
    public static function getRequestedJAccount($request)
    {
        // is valid request?
        if (!isset($request['rest_data']) || !$request['rest_data']) {
            throw new JAccountException("Request doesn't contains any rest_data json argument");
        }

        // decode request

        $restDataJSON = html_entity_decode($request['rest_data']);
        $restData = json_decode($restDataJSON);

        // is valid request?
        if ($err = json_last_error()) {
            throw new JAccountException("Invalid JSON rest data, json error was: " . json_last_error_msg() . ", code: $err");
        }
        if (!is_object($restData) && !is_array($restData)) {
            throw new JAccountException("Invalid REST Data: " . $restData);
        }
        if (!isset($restData->module_name)) {
            throw new JAccountException("No requested module name");
        }
        if ($restData->module_name !== 'JAccount') {
            throw new JAccountException("The requested module is not JAccount, requested module name was: {$restData->module_name}");
        }


        // create an object by request

        $restObj = new stdClass();


        // is valid request?
        if (!isset($restData->name_value_list) || !$restData->name_value_list) {
            $GLOBALS['log']->fatal("Invalid REST data");
            $GLOBALS['log']->debug("Invalid REST data was: " . print_r($restData, true));

            return false;

        } else {

            foreach ($restData->name_value_list as $field) {
                $name = $field->name;
                $value = $field->value;
                $restObj->$name = $value;
            }

            // retrieve the requested JAccount

            $jAccount = BeanFactory::getBean('JAccount', $restObj->id);

            // any unhandled error in BeanFactory?
            if (!$jAccount) {
                throw new JAccountException("Something went wrong when trying to load a JAccount bean");
            }

            // is valid request?
            if (!isset($restObj->joomla_account_id) || !$restObj->joomla_account_id) {
                throw new JAccountException("Request Data doesn't contains any joomla_account_id");
            }

            // update the JAccount if request contains a joomla account id..

            if ($jAccount->joomla_account_id !== $restObj->joomla_account_id) {

                $jAccount->joomla_account_id = $restObj->joomla_account_id;

                // update success or are there any unhandled error?
                if (!$jAccount->save()) {
                    throw new JAccountException("Something went wrong when trying to update the joomla_account_id in JAccount bean");
                }
            }

            // whole function called because we want to know the password for joomla page.
            // but the request contains it?
            if (!isset($restObj->joomla_account_id) || !$restObj->joomla_account_id) {
                throw new JAccountException("Request Data doesn't contains any joomla_account_access, so retrieve a password is impossible");
            }

            // add the password to JAccount

            $jAccount->joomla_account_access = $restObj->joomla_account_access;

            return $jAccount;
        }
    }
	
}
