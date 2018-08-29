<?php

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


require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldBool extends SugarFieldBase {
	/**
	 *
	 * @return The html for a drop down if the search field is not 'my_items_only' or a dropdown for all other fields.
	 *			This strange behavior arises from the special needs of PM. They want the my items to be checkboxes and all other boolean fields to be dropdowns.
	 * @author Navjeet Singh
	 * @param $parentFieldArray -
	 **/
	function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
		$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
		//If there was a type override to specifically render it as a boolean, show the EditView checkbox
		if( preg_match("/(favorites|current_user|open)_only.*/", $vardef['name']))
		{
			return $this->fetch($this->findTemplate('EditView'));
		} else {
			return $this->fetch($this->findTemplate('SearchView'));
		}
	}

    /**
     * @see SugarFieldBase::importSanitize()
     */
    public function importSanitize(
        $value,
        $vardef,
        $focus,
        ImportFieldSanitize $settings
        )
    {
        $bool_values = array(0=>'0',1=>'no',2=>'off',3=>'n',4=>'yes',5=>'y',6=>'on',7=>'1');
        $bool_search = array_search($value,$bool_values);
        if ( $bool_search === false ) {
            return false;
        }
        else {
            //Convert all the values to a real bool.
            $value = (int) ( $bool_search > 3 );
        }
        if ( isset($vardef['dbType']) && $vardef['dbType'] == 'varchar' )
            $value = ( $value ? 'on' : 'off' );

        return $value;
    }

    public function getEmailTemplateValue($inputField, $vardef, $context = null){
        global $app_list_strings;
        // This does not return a smarty section, instead it returns a direct value
        if ( $inputField == 'bool_true' || $inputField === true ) { // Note: true must be absolute true
            return $app_list_strings['checkbox_dom']['1'];
        } else if ( $inputField == 'bool_false' || $inputField === false){ // Note: false must be absolute false
            return $app_list_strings['checkbox_dom']['2'];
        } else { // otherwise we return blank display
            return '';
        }
    }

    public function unformatField($formattedField, $vardef){
        if ( empty($formattedField) ) {
            $unformattedField = false;
            return $unformattedField;
        }
        if ( $formattedField == '0' || $formattedField == 'off' || $formattedField == 'false' || $formattedField == 'no' ) {
            $unformattedField = false;
        } else {
            $unformattedField = true;
        }

        return $unformattedField;
    }

}
