<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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



/**
 * SugarFieldAddress.php
 * SugarFieldAddress translates and displays fields from a vardef definition into different formats
 * for EditViews and DetailViews.  A sample invocation from a Meta-Data file is as follows:
 *
 *  array (
 * 	   'name' => 'primary_address_street',
 *	   'type' => 'address',
 *	   'displayParams'=>array('key'=>'primary'),
 *  ),
 *
 * Where name is set to the field for ACL verification, type is set to 'address'
 * to override the default field type and the displayParams array includes the key
 * for the address field.  Assumptions are made that the vardefs.php contains address
 * elements with the corresponding names. There is the optional displayParam index
 * 'copy' that accepts as value the key of the other address fields.  In our
 * example we may enable copying from the primary address fields with:
 *
 *  array (
 * 	   'name' => 'altaddress_street',
 *	   'type' => 'address',
 *	   'displayParams'=>array('key'=>'alt', 'copy'=>'primary'),
 *  ),
 *
 */
require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');
class SugarFieldAddress extends SugarFieldBase
{
    public function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        global $app_strings;
        if (!isset($displayParams['key'])) {
            $GLOBALS['log']->debug($app_strings['ERR_ADDRESS_KEY_NOT_SPECIFIED']);
            $this->ss->trigger_error($app_strings['ERR_ADDRESS_KEY_NOT_SPECIFIED']);
            return;
        }
        
        //Allow for overrides.  You can specify a Smarty template file location in the language file.
        if (isset($app_strings['SMARTY_ADDRESS_DETAILVIEW'])) {
            $tplCode = $app_strings['SMARTY_ADDRESS_DETAILVIEW'];
            return $this->fetch($tplCode);
        }
        
        return $this->fetch($this->findTemplate('DetailView'));
    }
    
    public function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        global $app_strings;
        if (!isset($displayParams['key'])) {
            $GLOBALS['log']->debug($app_strings['ERR_ADDRESS_KEY_NOT_SPECIFIED']);
            $this->ss->trigger_error($app_strings['ERR_ADDRESS_KEY_NOT_SPECIFIED']);
            return;
        }
        
        //Allow for overrides.  You can specify a Smarty template file location in the language file.
        if (isset($app_strings['SMARTY_ADDRESS_EDITVIEW'])) {
            $tplCode = $app_strings['SMARTY_ADDRESS_EDITVIEW'];
            return $this->fetch($tplCode);
        }

        return $this->fetch($this->findTemplate('EditView'));
    }
}
