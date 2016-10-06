<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 *********************************************************************************/


require_once("include/JSON.php");


class SugarEmailAddress extends SugarBean {
    var $table_name = 'email_addresses';
    var $module_name = "EmailAddresses";
    var $module_dir = 'EmailAddresses';
    var $object_name = 'EmailAddress';

    //bug 40068, According to rules in page 6 of http://www.apps.ietf.org/rfc/rfc3696.html#sec-3,
	//allowed special characters ! # $ % & ' * + - / = ?  ^ _ ` . { | } ~ in local part
    var $regex = "/^(?:['\.\-\+&#!\$\*=\?\^_`\{\}~\/\w]+)@(?:(?:\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})|\w+(?:[\.-]*\w+)*(?:\.[\w-]{2,})+)\$/";
    var $disable_custom_fields = true;
    var $db;
    var $smarty;
    var $addresses = array(); // array of emails
    var $view = '';
    private $stateBeforeWorkflow;

    public $email_address;

    static $count = 0;

    /**
     * Sole constructor
     */
    public function __construct() {
        parent::__construct();
        $this->index = self::$count;
        self::$count++;
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function SugarEmailAddress(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    /**
     * Legacy email address handling.  This is to allow support for SOAP or customizations
     * @param string $id
     * @param string $module
     */
    function handleLegacySave($bean, $prefix = "") {
        if(!isset($_REQUEST) || !isset($_REQUEST['useEmailWidget'])) {
            if (empty($this->addresses) || !isset($_REQUEST['massupdate'])) {
                $this->addresses = array();
                $optOut = (isset($bean->email_opt_out) && $bean->email_opt_out == "1") ? true : false;
                $invalid = (isset($bean->invalid_email) && $bean->invalid_email == "1") ? true : false;

                $isPrimary = true;
                for($i = 1; $i <= 10; $i++){
                    $email = 'email'.$i;
                    if(isset($bean->$email) && !empty($bean->$email)){
                        $opt_out_field = $email.'_opt_out';
                        $invalid_field = $email.'_invalid';
                        $field_optOut = (isset($bean->$opt_out_field)) ? $bean->$opt_out_field : $optOut;
                        $field_invalid = (isset($bean->$invalid_field)) ? $bean->$invalid_field : $invalid;
                        $this->addAddress($bean->$email, $isPrimary, false, $field_invalid, $field_optOut);
                        $isPrimary = false;
                    }
                }
            }
        }
        $this->populateAddresses($bean->id, $bean->module_dir, array(),'');
        if(isset($_REQUEST) && isset($_REQUEST['useEmailWidget'])) {
            $this->populateLegacyFields($bean);
        }
    }

    /**
     * Fills standard email1 legacy fields
     * @param string id
     * @param string module
     * @return object
     */
    function handleLegacyRetrieve(&$bean) {
        $module_dir = $this->getCorrectedModule($bean->module_dir);
        $this->addresses = $this->getAddressesByGUID($bean->id, $module_dir);
        $this->populateLegacyFields($bean);
        if (isset($bean->email1) && !isset($bean->fetched_row['email1'])) {
            $bean->fetched_row['email1'] = $bean->email1;
        }

        return;
    }

    function populateLegacyFields(&$bean){
        $primary_found = false;
        $alternate_found = false;
        $alternate2_found = false;
        foreach($this->addresses as $k=>$address) {
            if ($primary_found && $alternate_found)
                break;
            if ($address['primary_address'] == 1 && !$primary_found) {
                $primary_index = $k;
                $primary_found = true;
            } elseif (!$alternate_found) {
                $alternate_index = $k;
                $alternate_found = true;
            } elseif (!$alternate2_found){
                $alternate2_index = $k;
                $alternate2_found = true;
            }
        }

        if ($primary_found) {
            $bean->email1 = $this->addresses[$primary_index]['email_address'];
            $bean->email_opt_out = $this->addresses[$primary_index]['opt_out'];
            $bean->invalid_email = $this->addresses[$primary_index]['invalid_email'];
            if ($alternate_found) {
                $bean->email2 = $this->addresses[$alternate_index]['email_address'];
            }
        } elseif ($alternate_found) {
            // Use the first found alternate as email1.
            $bean->email1 = $this->addresses[$alternate_index]['email_address'];
            $bean->email_opt_out = $this->addresses[$alternate_index]['opt_out'];
            $bean->invalid_email = $this->addresses[$alternate_index]['invalid_email'];
            if ($alternate2_found) {
                $bean->email2 = $this->addresses[$alternate2_index]['email_address'];
            }
        }
    }

    /**
     * Saves email addresses for a parent bean.
     * The base class SugarBean::save($check_notify) method is never called from SugarEmailAddresses::save(...)
     * The method's signature has been changed to correctly represent the save method call for SugarEmailAddress.
     * @param string $id Parent bean ID
     * @param string $module Parent bean's module
     * @param array $new_addrs Override of $_REQUEST vars, used to handle non-standard bean saves
     * @param string $primary GUID of primary address
     * @param string $replyTo GUID of reply-to address
     * @param string $invalid GUID of invalid address
     * @param string $optOut
     * @param bool $in_workflow
     * @return null
     */
    public function save($id, $module, $new_addrs = array(), $primary='', $replyTo='', $invalid='', $optOut='', $in_workflow = false) {
        if(gettype($id) == "boolean") {
            $GLOBALS['log']->fatal('SugarEmailAddress::save() Invalid arguments - Parent method SugarBean::save($checknotify) is not implemented. Please pass the correct arguments into SugarEmailAddress::save()');
        }

        if(empty($this->addresses) || $in_workflow) {
            $this->populateAddresses($id, $module, $new_addrs, $primary);
        }

        // handle the Employee/User split
        $module = $this->getCorrectedModule($module);

        // find all email addresses
        $current_links = array();
        $q2="select *  from email_addr_bean_rel eabr WHERE eabr.bean_id = '".$this->db->quote($id)."' AND eabr.bean_module = '".$this->db->quote($module)."' and eabr.deleted=0";
        $r2 = $this->db->query($q2);
        while(($row2=$this->db->fetchByAssoc($r2)) != null ) {
            $current_links[$row2['email_address_id']]=$row2;
        }

        $isConversion = (isset($_REQUEST) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'ConvertLead') ? true : false;

        if (!empty($this->addresses)) {
            // insert new relationships and create email address record, if they don't exist
            foreach($this->addresses as $address) {
                if(!empty($address['email_address'])) {
                    $guid = create_guid();
                    $emailId = isset($address['email_address_id'])
                        && isset($current_links[$address['email_address_id']])
                        ? $address['email_address_id'] : null;
                    $emailId = $this->AddUpdateEmailAddress($address['email_address'],
                                                            $address['invalid_email'],
                                                            $address['opt_out'],
                                                            $emailId);// this will save the email address if not found

                    //verify linkage and flags.
                    $upd_eabr="";
                    if (isset($current_links[$emailId])) {
                        if (!$isConversion) { // do not update anything if this is for lead conversion
                        if ($address['primary_address'] != $current_links[$emailId]['primary_address'] or $address['reply_to_address'] != $current_links[$emailId]['reply_to_address'] ) {
                            $upd_eabr="UPDATE email_addr_bean_rel SET primary_address='".$this->db->quote($address['primary_address'])."', reply_to_address='".$this->db->quote($address['reply_to_address'])."' WHERE id='".$this->db->quote($current_links[$emailId]['id'])."'";
                        }

                        unset($current_links[$emailId]);
                        }
                    } else {
                        $primary = $address['primary_address'];
                        if (!empty($current_links) && $isConversion) {
                            foreach ($current_links as $eabr) {
                                if ($eabr['primary_address'] == 1) {
                                    // for lead conversion, if there is already a primary email, do not insert another primary email
                                    $primary = 0;
                                    break;
                                }
                            }
                        }
                        $now = $this->db->now();
                        $upd_eabr = "INSERT INTO email_addr_bean_rel (id, email_address_id,bean_id, bean_module,primary_address,reply_to_address,date_created,date_modified,deleted) VALUES('".$this->db->quote($guid)."', '".$this->db->quote($emailId)."', '".$this->db->quote($id)."', '".$this->db->quote($module)."', ".intval($primary).", ".intval($address['reply_to_address']).", $now, $now, 0)";
                    }

                    if (!empty($upd_eabr)) {
                        $r2 = $this->db->query($upd_eabr);
                    }
                }
            }
        }

        //delete link to dropped email address.
        // for lead conversion, do not delete email addresses
        if (!empty($current_links) && !$isConversion) {

            $delete="";
            foreach ($current_links as $eabr) {

                $delete.=empty($delete) ? "'".$this->db->quote($eabr['id']) . "' " : ",'" . $this->db->quote($eabr['id']) . "'";
            }

            $eabr_unlink="update email_addr_bean_rel set deleted=1 where id in ({$delete})";
            $this->db->query($eabr_unlink);
        }
        $this->stateBeforeWorkflow = null;
    }

    /**
     * Moved implementation _save to save.
     * For backward compatibility the _save method has been preserved as a facade to save. In case it's used by a child
     * class.
     * @param string $id Parent bean ID
     * @param string $module Parent bean's module
     * @param array $new_addrs Override of $_REQUEST vars, used to handle non-standard bean saves
     * @param string $primary GUID of primary address
     * @param string $replyTo GUID of reply-to address
     * @param string $invalid GUID of invalid address
     * @param string $optOut
     * @param bool $in_workflow
     * @return NULL
     */
    private function _save($id, $module, $new_addrs = array(), $primary='', $replyTo='', $invalid='', $optOut='', $in_workflow = false) {
        $this->save($id, $module, $new_addrs, $primary, $replyTo, $invalid, $optOut, $in_workflow);
    }

    /**
     * returns the number of email addresses found for a specifed bean
     *
     * @param  string $email       Address to match
     * @param  object $bean        Bean to query against
     * @param  string $addresstype Optional, pass a 1 to query against the primary address, 0 for the other addresses
     * @return int                 Count of records found
     */
    function getCountEmailAddressByBean(
        $email,
        $bean,
        $addresstype
        )
    {
        $emailCaps = strtoupper(trim($email));
        if(empty($emailCaps))
            return 0;

        $q = "SELECT *
                FROM email_addr_bean_rel eabl JOIN email_addresses ea
                        ON (ea.id = eabl.email_address_id)
                    JOIN {$bean->table_name} bean
                        ON (eabl.bean_id = bean.id)
                WHERE ea.email_address_caps = '".$this->db->quote($emailCaps)."'
                    and eabl.bean_module = '".$this->db->quote($bean->module_dir)."'
                    and eabl.primary_address = '".$this->db->quote($addresstype)."'
                    and eabl.deleted=0 ";

        $r = $this->db->query($q);

        // do it this way to make the count accurate in oracle
        $i = 0;
        while ($this->db->fetchByAssoc($r)) ++$i;

        return $i;
    }

    /**
     * This function returns a contact or user ID if a matching email is found
     * @param   $email      the email address to match
     * @param   $table      which table to query
     */
    function getRelatedId($email, $module) {
        $email = $this->db->quote(trim(strtoupper($email)));
        $module = $this->db->quote(ucfirst($module));

        $q = "SELECT bean_id FROM email_addr_bean_rel eabr
                JOIN email_addresses ea ON (eabr.email_address_id = ea.id)
                WHERE bean_module = '$module' AND ea.email_address_caps = '$email' AND eabr.deleted=0";

        $r = $this->db->query($q, true);

        $retArr = array();
        while($a = $this->db->fetchByAssoc($r)) {
            $retArr[] = $a['bean_id'];
        }
        if(count($retArr) > 0) {
            return $retArr;
        } else {
            return false;
        }
    }

    /**
     * returns a collection of beans matching the email address
     * @param string $email Address to match
     * @return array
     */
    function getBeansByEmailAddress($email) {
        global $beanList;
        global $beanFiles;

        $ret = array();

        $email = trim($email);

        if(empty($email)) {
            return array();
        }

        $emailCaps = "'".$this->db->quote(strtoupper($email))."'";
        $q = "SELECT * FROM email_addr_bean_rel eabl JOIN email_addresses ea ON (ea.id = eabl.email_address_id)
                WHERE ea.email_address_caps = $emailCaps and eabl.deleted=0 ";
        $r = $this->db->query($q);

        while($a = $this->db->fetchByAssoc($r)) {
            if(isset($beanList[$a['bean_module']]) && !empty($beanList[$a['bean_module']])) {
                $className = $beanList[$a['bean_module']];

                if(isset($beanFiles[$className]) && !empty($beanFiles[$className])) {
                    if(!class_exists($className)) {
                        require_once($beanFiles[$className]);
                    }

                    $bean = new $className();
                    $bean->retrieve($a['bean_id']);

                    $ret[] = $bean;
                } else {
                    $GLOBALS['log']->fatal("SUGAREMAILADDRESS: could not find valid class file for [ {$className} ]");
                }
            } else {
                $GLOBALS['log']->fatal("SUGAREMAILADDRESS: could not find valid class [ {$a['bean_module']} ]");
            }
        }

        return $ret;
    }

    /**
     * Saves email addresses for a parent bean
     * @param string $id Parent bean ID
     * @param string $module Parent bean's module
     * @param array $addresses Override of $_REQUEST vars, used to handle non-standard bean saves
     * @param string $primary GUID of primary address
     * @param string $replyTo GUID of reply-to address
     * @param string $invalid GUID of invalid address
     */
    function populateAddresses($id, $module, $new_addrs=array(), $primary='', $replyTo='', $invalid='', $optOut='') {
        $module = $this->getCorrectedModule($module);
        //One last check for the ConvertLead action in which case we need to change $module to 'Leads'
        $module = (isset($_REQUEST) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'ConvertLead') ? 'Leads' : $module;

        $post_from_email_address_widget = (isset($_REQUEST) && isset($_REQUEST['emailAddressWidget'])) ? true : false;
        $primaryValue = $primary;
        $widgetCount = 0;
        $hasEmailValue = false;
        $email_ids = array();

        if (isset($_REQUEST) && isset($_REQUEST[$module .'_email_widget_id'])) {

            $fromRequest = false;
            // determine which array to process
            foreach($_REQUEST as $k => $v) {
                if(strpos($k, 'emailAddress') !== false) {
                   $fromRequest = true;
                   break;
                }
                $widget_id = $_REQUEST[$module .'_email_widget_id'];
            }

            //Iterate over the widgets for this module, in case there are multiple email widgets for this module
            while(isset($_REQUEST[$module . $widget_id . "emailAddress" . $widgetCount]))
            {
                if (empty($_REQUEST[$module . $widget_id . "emailAddress" . $widgetCount])) {
                    $widgetCount++;
                    continue;
                }

                $hasEmailValue = true;

                $eId = $module . $widget_id;
                if(isset($_REQUEST[$eId . 'emailAddressPrimaryFlag'])) {
                   $primaryValue = $_REQUEST[$eId . 'emailAddressPrimaryFlag'];
                } else if(isset($_REQUEST[$module . 'emailAddressPrimaryFlag'])) {
                   $primaryValue = $_REQUEST[$module . 'emailAddressPrimaryFlag'];
                }

                $optOutValues = array();
                if(isset($_REQUEST[$eId .'emailAddressOptOutFlag'])) {
                   $optOutValues = $_REQUEST[$eId .'emailAddressOptOutFlag'];
                } else if(isset($_REQUEST[$module . 'emailAddressOptOutFlag'])) {
                   $optOutValues = $_REQUEST[$module . 'emailAddressOptOutFlag'];
                }

                $invalidValues = array();
                if(isset($_REQUEST[$eId .'emailAddressInvalidFlag'])) {
                   $invalidValues = $_REQUEST[$eId .'emailAddressInvalidFlag'];
                } else if(isset($_REQUEST[$module . 'emailAddressInvalidFlag'])) {
                   $invalidValues = $_REQUEST[$module . 'emailAddressInvalidFlag'];
                }

                $deleteValues = array();
                if(isset($_REQUEST[$eId .'emailAddressDeleteFlag'])) {
                   $deleteValues = $_REQUEST[$eId .'emailAddressDeleteFlag'];
                } else if(isset($_REQUEST[$module . 'emailAddressDeleteFlag'])) {
                   $deleteValues = $_REQUEST[$module . 'emailAddressDeleteFlag'];
                }

                // prep from form save
                $primaryField = $primary;
                $replyToField = '';
                $invalidField = '';
                $optOutField = '';
                if($fromRequest && empty($primary) && isset($primaryValue)) {
                    $primaryField = $primaryValue;
                }

                if($fromRequest && empty($replyTo)) {
                    if(isset($_REQUEST[$eId .'emailAddressReplyToFlag'])) {
                       $replyToField = $_REQUEST[$eId .'emailAddressReplyToFlag'];
                    } else if(isset($_REQUEST[$module . 'emailAddressReplyToFlag'])) {
                       $replyToField = $_REQUEST[$module . 'emailAddressReplyToFlag'];
                    }
                }
                if($fromRequest && empty($new_addrs)) {
                    foreach($_REQUEST as $k => $v) {
                        if(preg_match('/'.$eId.'emailAddress[0-9]+$/i', $k) && !empty($v)) {
                            $new_addrs[$k] = $v;
                        }
                    }
                }
                if($fromRequest && empty($email_ids)) {
                    foreach($_REQUEST as $k => $v) {
                        if(preg_match('/'.$eId.'emailAddressId[0-9]+$/i', $k) && !empty($v)) {
                            $key = str_replace('emailAddressId', 'emailAddress', $k);
                            $email_ids[$key] = $v;
                        }
                    }
                }

                if($fromRequest && empty($new_addrs)) {
                    foreach($_REQUEST as $k => $v) {
                        if(preg_match('/'.$eId.'emailAddressVerifiedValue[0-9]+$/i', $k) && !empty($v)) {
                            $validateFlag = str_replace("Value", "Flag", $k);
                            if (isset($_REQUEST[$validateFlag]) && $_REQUEST[$validateFlag] == "true")
                              $new_addrs[$k] = $v;
                        }
                    }
                }

                //empty the addresses array if the post happened from email address widget.
                if($post_from_email_address_widget) {
                    $this->addresses=array();  //this gets populated during retrieve of the contact bean.
                } else {
                    $optOutValues = array();
                    $invalidValues = array();
                    foreach($new_addrs as $k=>$email) {
                       preg_match('/emailAddress([0-9])+$/', $k, $matches);
                       $count = $matches[1];
                       $result = $this->db->query("SELECT opt_out, invalid_email from email_addresses where email_address_caps = '" . $this->db->quote(strtoupper($email)) . "'");
                       if(!empty($result)) {
                          $row=$this->db->fetchByAssoc($result);
                          if(!empty($row['opt_out'])) {
                             $optOutValues[$k] = "emailAddress$count";
                          }
                          if(!empty($row['invalid_email'])) {
                             $invalidValues[$k] = "emailAddress$count";
                          }
                       }
                    }
                }
                // Re-populate the addresses class variable if we have new address(es).
                if (!empty($new_addrs)) {
                    foreach($new_addrs as $k => $reqVar) {
                        //$key = preg_match("/^$eId/s", $k) ? substr($k, strlen($eId)) : $k;
                        $reqVar = trim($reqVar);
                        if(strpos($k, 'emailAddress') !== false) {
                            if(!empty($reqVar) && !in_array($k, $deleteValues)) {
                                $email_id   = (array_key_exists($k, $email_ids)) ? $email_ids[$k] : null;
                                $primary    = ($k == $primaryValue) ? true : false;
                                $replyTo    = ($k == $replyToField) ? true : false;
                                $invalid    = (in_array($k, $invalidValues)) ? true : false;
                                $optOut     = (in_array($k, $optOutValues)) ? true : false;
                                $this->addAddress(trim($new_addrs[$k]), $primary, $replyTo, $invalid, $optOut, $email_id);
                            }
                        }
                    } //foreach
                }

                $widgetCount++;
            }//End of Widget for loop
        }

        //If no widgets, set addresses array to empty
        if($post_from_email_address_widget && !$hasEmailValue) {
           $this->addresses = array();
        }
    }

    /**
     * Preps internal array structure for email addresses
     * @param string $addr Email address
     * @param bool $primary Default false
     * @param bool $replyTo Default false
     */
    function addAddress($addr, $primary=false, $replyTo=false, $invalid=false, $optOut=false, $email_id = null) {
        $addr = html_entity_decode($addr, ENT_QUOTES);
        if(preg_match($this->regex, $addr)) {
            $primaryFlag = ($primary) ? '1' : '0';
            $replyToFlag = ($replyTo) ? '1' : '0';
            $invalidFlag = ($invalid) ? '1' : '0';
            $optOutFlag = ($optOut) ? '1' : '0';

            $addr = trim($addr);

            // If we have such address already, remove it and add new one in.
            foreach ($this->addresses as $k=>$address) {
                if ($address['email_address'] == $addr) {
                    unset($this->addresses[$k]);
                } elseif ($primary && $address['primary_address'] == '1') {
                    // We should only have one primary. If we are adding a primary but
                    // we find an existing primary, reset this one's primary flag.
                    $address['primary_address'] = '0';
                }
            }

            $this->addresses[] = array(
                'email_address' => $addr,
                'primary_address' => $primaryFlag,
                'reply_to_address' => $replyToFlag,
                'invalid_email' => $invalidFlag,
                'opt_out' => $optOutFlag,
                'email_address_id' => $email_id,
            );
        } else {
            $GLOBALS['log']->fatal("SUGAREMAILADDRESS: address did not validate [ {$addr} ]");
        }
    }

    /**
     * Updates invalid_email and opt_out flags for each address
     */
    function updateFlags() {
        if(!empty($this->addresses)) {
            foreach($this->addresses as $addressMeta) {
                if(isset($addressMeta['email_address']) && !empty($addressMeta['email_address'])) {
                    $address = $this->db->quote($this->_cleanAddress($addressMeta['email_address']));

                    $q = "SELECT * FROM email_addresses WHERE email_address = '{$address}'";
                    $r = $this->db->query($q);
                    $a = $this->db->fetchByAssoc($r);

                    if(!empty($a)) {
                        if(isset($a['invalid_email']) && isset($addressMeta['invalid_email']) && isset($addressMeta['opt_out']) && $a['invalid_email'] != $addressMeta['invalid_email'] || $a['opt_out'] != $addressMeta['opt_out']) {
                            $qUpdate = "UPDATE email_addresses SET invalid_email = ".intval($addressMeta['invalid_email']).", opt_out = ".intval($addressMeta['opt_out']).", date_modified = '".TimeDate::getInstance()->nowDb()."' WHERE id = '".$this->db->quote($a['id'])."'";
                            $rUpdate = $this->db->query($qUpdate);
                        }
                    }
                }
            }
        }
    }

    public function splitEmailAddress($addr)
    {
        $email = $this->_cleanAddress($addr);
        if(!preg_match($this->regex, $email)) {
            $email = ''; // remove bad email addr
        }
        $name = trim(str_replace(array($email, '<', '>', '"', "'"), '', $addr));
        return array("name" => $name, "email" => strtolower($email));
    }

    /**
     * PRIVATE UTIL
     * Normalizes an RFC-clean email address, returns a string that is the email address only
     * @param string $addr Dirty email address
     * @return string clean email address
     */
    function _cleanAddress($addr) {
        $addr = trim(from_html($addr));

        if(strpos($addr, "<") !== false && strpos($addr, ">") !== false) {
            $address = trim(substr($addr, strrpos($addr, "<") +1, strrpos($addr, ">") - strrpos($addr, "<") -1));
        } else {
            $address = trim($addr);
        }

        return $address;
    }

    /**
     * preps a passed email address for email address storage
     * @param array $addr Address in focus, must be RFC compliant
     * @return string $id email_addresses ID
     */
    function getEmailGUID($addr) {
        $address = $this->db->quote($this->_cleanAddress($addr));
        $addressCaps = strtoupper($address);

        $q = "SELECT id FROM email_addresses WHERE email_address_caps = '{$addressCaps}'";
        $r = $this->db->query($q);
        $a = $this->db->fetchByAssoc($r);

        if(!empty($a) && !empty($a['id'])) {
            return $a['id'];
        } else {
            $guid = '';
            if(!empty($address)){
                $guid = create_guid();
                $now = TimeDate::getInstance()->nowDb();
                $qa = "INSERT INTO email_addresses (id, email_address, email_address_caps, date_created, date_modified, deleted)
                        VALUES('{$guid}', '{$address}', '{$addressCaps}', '$now', '$now', 0)";
                $ra = $this->db->query($qa);
            }
            return $guid;
        }
    }

    /**
     * Creates or Updates an entry in the email_addresses table, depending
     * on if the email address submitted matches a previous entry (case-insensitive)
     * @param String $addr - email address
     * @param int $invalid - is the email address marked as Invalid?
     * @param int $opt_out - is the email address marked as Opt-Out?
     * @param String $id - the GUID of the original SugarEmailAddress bean,
     *        in case a "email has changed" WorkFlow has triggered - hack to allow workflow-induced changes
     *        to propagate to the new SugarEmailAddress - see bug 39188
     * @return String GUID of Email Address or '' if cleaned address was empty.
     */
    public function AddUpdateEmailAddress($addr,$invalid=0,$opt_out=0,$id=null)
    {
        // sanity checks to avoid SQL injection.
        $invalid = intval($invalid);
        $opt_out = intval($opt_out);

        $address = $this->db->quote($this->_cleanAddress($addr));
        $addressCaps = strtoupper($address);

        // determine if we have a matching email address
        $q = "SELECT * FROM email_addresses WHERE email_address_caps = '{$addressCaps}' and deleted=0";
        $r = $this->db->query($q);
        $duplicate_email = $this->db->fetchByAssoc($r);

        // check if we are changing an email address, where workflow might be in play
        if ($id) {
            $r = $this->db->query("SELECT * FROM email_addresses WHERE id='".$this->db->quote($id)."'");
            $current_email = $this->db->fetchByAssoc($r);
        }
        else {
            $current_email = null;
        }

        // unless workflow made changes, assume parameters are what to use.
        $new_opt_out = $opt_out;
        $new_invalid = $invalid;
        if (!empty($current_email['id']) && isset($this->stateBeforeWorkflow[$current_email['id']])) {
            if ($current_email['invalid_email'] != $invalid ||
                $current_email['opt_out'] != $opt_out) {

                // workflow could be in play
                $before_email = $this->stateBeforeWorkflow[$current_email['id']];

                // our logic is as follows: choose from parameter, unless workflow made a change to the value, then choose final value
                if (intval($before_email['opt_out']) != intval($current_email['opt_out'])) {
                    $new_opt_out = intval($current_email['opt_out']);
                }
                if (intval($before_email['invalid_email']) != intval($current_email['invalid_email'])) {
                    $new_invalid = intval($current_email['invalid_email']);
                }
            }
        }

        // determine how we are going to put in this address - UPDATE or INSERT
        if (!empty($duplicate_email['id'])) {

            // address_caps matches - see if we're changing fields
            if ($duplicate_email['invalid_email'] != $new_invalid ||
                $duplicate_email['opt_out'] != $new_opt_out ||
                (trim($duplicate_email['email_address']) != $address)) {
                $upd_q = 'UPDATE ' . $this->table_name . ' ' .
                    'SET email_address=\'' . $address . '\', ' .
                    'invalid_email=' . $new_invalid . ', ' .
                    'opt_out=' . $new_opt_out . ', ' .
                    'date_modified=' . $this->db->now() . ' ' .
                    'WHERE id=\'' . $this->db->quote($duplicate_email['id']) . '\'';
                $upd_r = $this->db->query($upd_q);
            }
            return $duplicate_email['id'];
        }
        else {
            // no case-insensitive address match - it's new, or undeleted.
            $guid = '';
            if(!empty($address)){
                $guid = create_guid();
                $now = TimeDate::getInstance()->nowDb();
                $qa = "INSERT INTO email_addresses (id, email_address, email_address_caps, date_created, date_modified, deleted, invalid_email, opt_out)
                        VALUES('{$guid}', '{$address}', '{$addressCaps}', '$now', '$now', 0 , $new_invalid, $new_opt_out)";
                $this->db->query($qa);
            }
            return $guid;
        }
    }

    /**
     * Returns Primary or newest email address
     * @param object $focus Object in focus
     * @return string email
     */
    function getPrimaryAddress($focus,$parent_id=null,$parent_type=null) {

        $parent_type=empty($parent_type) ? $focus->module_dir : $parent_type;
        // Bug63174: Email address is not shown in the list view for employees
        $parent_type = $this->getCorrectedModule($parent_type);
        $parent_id=empty($parent_id) ? $focus->id : $parent_id;

        $q = "SELECT ea.email_address FROM email_addresses ea
                LEFT JOIN email_addr_bean_rel ear ON ea.id = ear.email_address_id
                WHERE ear.bean_module = '".$this->db->quote($parent_type)."'
                AND ear.bean_id = '".$this->db->quote($parent_id)."'
                AND ear.deleted = 0
                AND ea.invalid_email = 0
                ORDER BY ear.primary_address DESC";
        $r = $this->db->limitQuery($q, 0, 1);
        $a = $this->db->fetchByAssoc($r);

        if(isset($a['email_address'])) {
            return $a['email_address'];
        }
        return '';
    }

    /**
     * As long as this function is used not only to retrieve user's Reply-To
     * address, but also notification address and so on, there were added
     * $replyToOnly optional parameter used to retrieve only address marked as
     * Reply-To (bug #43643).
     *
     * @param SugarBean $focus
     * @param bool $replyToOnly
     * @return string
     */
    function getReplyToAddress($focus, $replyToOnly = false) {
        $q = "SELECT ea.email_address FROM email_addresses ea
                LEFT JOIN email_addr_bean_rel ear ON ea.id = ear.email_address_id
                WHERE ear.bean_module = '".$this->db->quote($focus->module_dir)."'
                AND ear.bean_id = '".$this->db->quote($focus->id)."'
                AND ear.deleted = 0
                AND ea.invalid_email = 0";

        if (!$replyToOnly)
        {
            // retrieve reply-to address if it exists or any other address
            // otherwise
            $q .= "
                ORDER BY ear.reply_to_address DESC";
        }
        else
        {
            // retrieve reply-to address only
            $q .= "
                AND ear.reply_to_address = 1";
        }

        $r = $this->db->query($q);
        $a = $this->db->fetchByAssoc($r);

        if(isset($a['email_address'])) {
            return $a['email_address'];
        }
        return '';
    }

    /**
     * Returns all email addresses by parent's GUID
     * @param string $id Parent's GUID
     * @param string $module Parent's module
     * @return array
     */
    function getAddressesByGUID($id, $module) {
        $return = array();
        $module = $this->getCorrectedModule($module);

        $q = "SELECT ea.email_address, ea.email_address_caps, ea.invalid_email, ea.opt_out, ea.date_created, ea.date_modified,
                ear.id, ear.email_address_id, ear.bean_id, ear.bean_module, ear.primary_address, ear.reply_to_address, ear.deleted
                FROM email_addresses ea LEFT JOIN email_addr_bean_rel ear ON ea.id = ear.email_address_id
                WHERE ear.bean_module = '".$this->db->quote($module)."'
                AND ear.bean_id = '".$this->db->quote($id)."'
                AND ear.deleted = 0
                ORDER BY ear.reply_to_address, ear.primary_address DESC";
        $r = $this->db->query($q);

        while($a = $this->db->fetchByAssoc($r, FALSE)) {
            $return[] = $a;
        }

        return $return;
    }

    /**
     * Returns the HTML/JS for the EmailAddress widget
     * @param string $parent_id ID of parent bean, generally $focus
     * @param string $module $focus' module
     * @param bool asMetadata Default false
     * @return string HTML/JS for widget
     */
    function getEmailAddressWidgetEditView($id, $module, $asMetadata=false, $tpl='',$tabindex='0')
    {
        if ( !($this->smarty instanceOf Sugar_Smarty ) )
            $this->smarty = new Sugar_Smarty();

        global $app_strings, $dictionary, $beanList;

        $prefill = 'false';

        $prefillData = 'new Object()';
        $passedModule = $module;
        $module = $this->getCorrectedModule($module);
        $saveModule = $module;
        if(isset($_POST['is_converted']) && $_POST['is_converted']==true){
            $id=$_POST['return_id'];
            $module=$_POST['return_module'];
        }
        $prefillDataArr = array();
        if(!empty($id)) {
            $prefillDataArr = $this->getAddressesByGUID($id, $module);
            //When coming from convert leads, sometimes module is Contacts while the id is for a lead.
            if (empty($prefillDataArr) && $module == "Contacts")
                $prefillDataArr = $this->getAddressesByGUID($id, "Leads");
        } else if(isset($_REQUEST['full_form']) && !empty($_REQUEST['emailAddressWidget'])){
            $widget_id = isset($_REQUEST[$module . '_email_widget_id']) ? $_REQUEST[$module . '_email_widget_id'] : '0';
            $count = 0;
            $key = $module . $widget_id . 'emailAddress'.$count;
            while(isset($_REQUEST[$key])) {
                   $email = $_REQUEST[$key];
                   $prefillDataArr[] =  array('email_address'=>$email,
                                             'primary_address'=>isset($_REQUEST['emailAddressPrimaryFlag']) && $_REQUEST['emailAddressPrimaryFlag'] == $key,
                                             'invalid_email'=>isset($_REQUEST['emailAddressInvalidFlag']) && in_array($key, $_REQUEST['emailAddressInvalidFlag']),
                                             'opt_out'=>isset($_REQUEST['emailAddressOptOutFlag']) && in_array($key, $_REQUEST['emailAddressOptOutFlag']),
                                             'reply_to_address'=>false
                                        );
                   $key = $module . $widget_id . 'emailAddress' . ++$count;
            } //while
        }

        if(!empty($prefillDataArr)) {
            $json = new JSON(JSON_LOOSE_TYPE);
            $prefillData = $json->encode($prefillDataArr);
            $prefill = !empty($prefillDataArr) ? 'true' : 'false';
        }

        $required = false;
        $vardefs = $dictionary[$beanList[$passedModule]]['fields'];
        if (!empty($vardefs['email1']) && isset($vardefs['email1']['required']) && $vardefs['email1']['required'])
            $required = true;
        $this->smarty->assign('required', $required);

        $this->smarty->assign('module', $saveModule);
        $this->smarty->assign('index', $this->index);
        $this->smarty->assign('app_strings', $app_strings);
        $this->smarty->assign('prefillEmailAddresses', $prefill);
        $this->smarty->assign('prefillData', $prefillData);
        $this->smarty->assign('tabindex', $tabindex);
        //Set addDefaultAddress flag (do not add if it's from the Email module)
        $this->smarty->assign('addDefaultAddress', (isset($_REQUEST['module']) && $_REQUEST['module'] == 'Emails') ? 'false' : 'true');
        $form = $this->view;

        //determine if this should be a quickcreate form, or a quick create form under subpanels
        if ($this->view == "QuickCreate"){
            // Fixed #1120 - fixed email validation for: Accounts -> Contacts subpanel -> Select -> Create Contact -> Save.
            // If email is required it should highlight this field and show an error message.
            // It didnt because the the form was named form_DCSubpanelQuickCreate_Contacts instead of expected form_SubpanelQuickCreate_Contacts
            if($this->object_name = 'EmailAddress' && $saveModule == 'Contacts') {
                $form = 'form_'.$this->view .'_'.$module;
            } else {
                $form = 'form_DC'.$this->view .'_'.$module;
            }
            if(isset($_REQUEST['action']) && $_REQUEST['action']=='SubpanelCreates' ||  $_REQUEST['action']=='SubpanelEdits'){
                $form = 'form_Subpanel'.$this->view .'_'.$module;
            }
        }

        $this->smarty->assign('emailView', $form);

        if($module == 'Users') {
            $this->smarty->assign('useReplyTo', true);
        } else {
            $this->smarty->assign('useOptOut', true);
            $this->smarty->assign('useInvalid', true);
        }

        $template = empty($tpl) ? "include/SugarEmailAddress/templates/forEditView.tpl" : $tpl;
        $newEmail = $this->smarty->fetch($template);


        if($asMetadata) {
            // used by Email 2.0
            $ret = array();
            $ret['prefillData'] = $prefillDataArr;
            $ret['html'] = $newEmail;

            return $ret;
        }

        return $newEmail;
    }


    /**
     * Returns the HTML/JS for the EmailAddress widget
     * @param object $focus Bean in focus
     * @return string HTML/JS for widget
     */
    function getEmailAddressWidgetDetailView($focus, $tpl='')
    {
        if ( !($this->smarty instanceOf Sugar_Smarty ) )
            $this->smarty = new Sugar_Smarty();

        global $app_strings;
        global $current_user;
        $assign = array();
        if(empty($focus->id))return '';
        $prefillData = $this->getAddressesByGUID($focus->id, $focus->module_dir);

        foreach($prefillData as $addressItem) {
            $key = ($addressItem['primary_address'] == 1) ? 'primary' : "";
            $key = ($addressItem['reply_to_address'] == 1) ? 'reply_to' : $key;
            $key = ($addressItem['opt_out'] == 1) ? 'opt_out' : $key;
            $key = ($addressItem['invalid_email'] == 1) ? 'invalid' : $key;
            $key = ($addressItem['opt_out'] == 1) && ($addressItem['invalid_email'] == 1) ? 'opt_out_invalid' : $key;

            $assign[] = array('key' => $key, 'address' => $current_user->getEmailLink2($addressItem['email_address'], $focus).$addressItem['email_address']."</a>");
        }


        $this->smarty->assign('app_strings', $app_strings);
        $this->smarty->assign('emailAddresses', $assign);
        $templateFile = empty($tpl) ? "include/SugarEmailAddress/templates/forDetailView.tpl" : $tpl;
        $return = $this->smarty->fetch($templateFile);
        return $return;
    }


    /**
     * getEmailAddressWidgetDuplicatesView($focus)
     * @param object $focus Bean in focus
     * @return string HTML that contains hidden input values based off of HTML request
     */
    function getEmailAddressWidgetDuplicatesView($focus)
    {
        if ( !($this->smarty instanceOf Sugar_Smarty ) )
            $this->smarty = new Sugar_Smarty();

        $count = 0;
        $emails = array();
        $primary = null;
        $optOut = array();
        $invalid = array();
        $mod = isset($focus) ? $focus->module_dir : "";

        $widget_id = $_POST[$mod .'_email_widget_id'];
        $this->smarty->assign('email_widget_id',$widget_id);
        $this->smarty->assign('emailAddressWidget',$_POST['emailAddressWidget']);

        if(isset($_POST[$mod . $widget_id . 'emailAddressPrimaryFlag'])) {
           $primary = $_POST[$mod . $widget_id . 'emailAddressPrimaryFlag'];
        }

        while(isset($_POST[$mod . $widget_id . "emailAddress" . $count])) {
            $emails[] = $_POST[$mod . $widget_id . 'emailAddress' . $count];
            $count++;
        }

        if($count == 0) {
           return "";
        }

        if(isset($_POST[$mod . $widget_id . 'emailAddressOptOutFlag'])) {
           foreach($_POST[$mod . $widget_id . 'emailAddressOptOutFlag'] as $v) {
              $optOut[] = $v;
           }
        }

        if(isset($_POST[$mod . $widget_id . 'emailAddressInvalidFlag'])) {
           foreach($_POST[$mod . $widget_id . 'emailAddressInvalidFlag'] as $v) {
              $invalid[] = $v;
           }
        }

        if(isset($_POST[$mod . $widget_id . 'emailAddressReplyToFlag'])) {
           foreach($_POST[$mod . $widget_id . 'emailAddressReplyToFlag'] as $v) {
              $replyTo[] = $v;
           }
        }

        if(isset($_POST[$mod . $widget_id . 'emailAddressDeleteFlag'])) {
           foreach($_POST[$mod . $widget_id . 'emailAddressDeleteFlag'] as $v) {
              $delete[] = $v;
           }
        }

        while(isset($_POST[$mod . $widget_id . "emailAddressVerifiedValue" . $count])) {
            $verified[] = $_POST[$mod . $widget_id . 'emailAddressVerifiedValue' . $count];
            $count++;
        }

        $this->smarty->assign('emails', $emails);
        $this->smarty->assign('primary', $primary);
        $this->smarty->assign('optOut', $optOut);
        $this->smarty->assign('invalid', $invalid);
        $this->smarty->assign('replyTo', $invalid);
        $this->smarty->assign('delete', $invalid);
        $this->smarty->assign('verified', $invalid);
        $this->smarty->assign('moduleDir', $mod);

        return $this->smarty->fetch("include/SugarEmailAddress/templates/forDuplicatesView.tpl");
    }

    /**
     * getFormBaseURL
     *
     */
    function getFormBaseURL($focus) {
        $get = "";
        $count = 0;
        $mod = isset($focus) ? $focus->module_dir : "";

        $widget_id = $_POST[$mod .'_email_widget_id'];
        $get .= '&' . $mod . '_email_widget_id='. $widget_id;
        $get .= '&emailAddressWidget='.$_POST['emailAddressWidget'];

        while(isset($_REQUEST[$mod . $widget_id . 'emailAddress' . $count])) {
              $get .= "&" . $mod . $widget_id . "emailAddress" . $count . "=" . urlencode($_REQUEST[$mod . $widget_id . 'emailAddress' . $count]);
              $count++;
        } //while

        while(isset($_REQUEST[$mod . $widget_id . 'emailAddressVerifiedValue' . $count])) {
              $get .= "&" . $mod . $widget_id . "emailAddressVerifiedValue" . $count . "=" . urlencode($_REQUEST[$mod . $widget_id . 'emailAddressVerifiedValue' . $count]);
              $count++;
        } //while

        $options = array('emailAddressPrimaryFlag', 'emailAddressOptOutFlag', 'emailAddressInvalidFlag', 'emailAddressDeleteFlag', 'emailAddressReplyToFlag');

        foreach($options as $option) {
            $count = 0;
            $optionIdentifier = $mod.$widget_id.$option;
            if(isset($_REQUEST[$optionIdentifier])) {
               if(is_array($_REQUEST[$optionIdentifier])) {
                   foreach($_REQUEST[$optionIdentifier] as $optOut) {
                      $get .= "&" . $optionIdentifier . "[" . $count . "]=" . $optOut;
                      $count++;
                   } //foreach
               } else {
                   $get .= "&" . $optionIdentifier . "=" . $_REQUEST[$optionIdentifier];
               }
            } //if
        } //foreach
        return $get;

    }

    function setView($view) {
       $this->view = $view;
    }

/**
 * This function is here so the Employees/Users division can be handled cleanly in one place
 * @param object $focus SugarBean
 * @return string The value for the bean_module column in the email_addr_bean_rel table
 */
    function getCorrectedModule(&$module) {
        return ($module == "Employees")? "Users" : $module;
    }

    public function stash($parentBeanId, $moduleName)
    {
        $result = $this->db->query("select email_address_id from email_addr_bean_rel eabr WHERE eabr.bean_id = '".$this->db->quote($parentBeanId)."' AND eabr.bean_module = '".$this->db->quote($moduleName)."' and eabr.deleted=0");
        $this->stateBeforeWorkflow = array();
        $ids = array();
        while ($row = $this->db->fetchByAssoc($result, false))
        {
            $ids[] =$this->db->quote($row['email_address_id']); // avoid 2nd order SQL Injection
        }
        if (!empty($ids))
        {
            $ids = implode("', '", $ids);
            $queryEmailData = "SELECT id, email_address, invalid_email, opt_out FROM {$this->table_name} WHERE id IN ('$ids') AND deleted=0";
            $result = $this->db->query($queryEmailData);
            while ($row = $this->db->fetchByAssoc($result, false))
            {
                $this->stateBeforeWorkflow[$row['id']] = array_diff_key($row, array('id' => null));
            }
        }
    }
} // end class def


/**
 * Convenience function for MVC (Mystique)
 * @param object $focus SugarBean
 * @param string $field unused
 * @param string $value unused
 * @param string $view DetailView or EditView
 * @return string
 */
function getEmailAddressWidget($focus, $field, $value, $view, $tabindex='0') {
    $sea = new SugarEmailAddress();
    $sea->setView($view);

        if($view == 'EditView' || $view == 'QuickCreate' || $view == 'ConvertLead') {
            $module = $focus->module_dir;
            if ($view == 'ConvertLead' && $module == "Contacts")  $module = "Leads";

            return $sea->getEmailAddressWidgetEditView($focus->id, $module, false,'',$tabindex);
        }

    return $sea->getEmailAddressWidgetDetailView($focus);
}
