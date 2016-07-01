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


/**
 * AddressRule.php
 *
 * This is a utility base class to provide further refinement when converting
 * pre 5.x files to the new meta-data rules.  Address fields defined in the
 * address panel will be removed as the new metadata definition will be merged later.
 * If the address fields are outside the address panel, we will keep them as is, but
 * ensure that they are not defined as Arrays.
 * @author Collin Lee
 */

require_once('include/SugarFields/Parsers/Rules/BaseRule.php');

class AddressRule extends BaseRule {

function __construct() {

}

function parsePanels($panels, $view) {
   $searchedAddressPanel = array();

   foreach($panels as $name=>$panel) {

   	  $isAddressPanel = $name == 'lbl_address_information';

   	  foreach($panel as $rowCount=>$row) {
   	  	 foreach($row as $key=>$column) {

   	  	 	if($this->matches($column, '/_address_(city|state|country|postalcode)$/si')) {
   	  	 	   if($view == 'DetailView' && !is_array($column)) {
   	  	 	   	  $panels[$name][$rowCount][$key] = '';
   	  	 	   } else if($view == 'DetailView' && $this->matches($column, '/_address_country$/') && is_array($column)) {
   	  	 	      $match = $this->getMatch($column, '/(.*?)_address_country$/');
                  $panels[$name][$rowCount][$key]['name'] = $match[1] . '_address_street';
                  $panels[$name][$rowCount][$key]['label'] = 'LBL_' . strtoupper($match[1]) . '_ADDRESS';
   	  	 	   } else if($view == 'EditView' && $isAddressPanel) {

	              $field = is_array($column) ? $column['name'] : $column;
	              preg_match('/^(.*?)_address_/si', $field, $matches);

   	  	 	   	  if(empty($searchedAddressPanel[$matches[1]])) {
   	  	 	   	     $intact = $this->hasAddressFieldsIntact($panel, $matches[1]);

   	  	 	   	     //now we actually have to go back in and replace the street field
   	  	 	   	     if(!$intact) {
   	  	 	   	     	$panels = $this->removeStreetFieldOverride($panels, $matches[1]);
   	  	 	   	     }

   	  	 	   	     $addressFieldsIntact[$matches[1]] = $intact;
   	  	 	   	     $searchedAddressPanel[$matches[1]] = true;
   	  	 	   	  }

   	  	 	   	  //Only remove in address panel if the street field is in there by itself
   	  	 	   	  if($addressFieldsIntact[$matches[1]]) {
   	  	 	   	  	 $panels[$name][$rowCount][$key] = '';
   	  	 	   	  }
   	  	 	   }
   	  	 	} else if($this->matches($column, '/^push_.*?_(shipping|billing)$/si')) {
   	  	 	   $panels[$name][$rowCount][$key] = '';
   	  	 	}
   	  	 } //foreach
   	  } //foreach
   } //foreach
   return $panels;
}

/**
 * hasAddressFieldsIntact
 * This function checks to see if the address fields for the given street key is
 * intact.  This means that all five fields (street, city, state, country and postalcode)
 * have not been moved from the address panel
 *
 * @param $addressPanel Array of address panel contents
 * @param $suffix The address suffix (billing, shipping, primary, alternate) to check for
 * @return boolean
 */
function hasAddressFieldsIntact($addressPanel, $suffix) {
   $expression = '/^' . $suffix . '_address_(street|city|state|country|postalcode)$/si';
   $count = 0;
   foreach($addressPanel as $rowCount=>$row) {
   	  foreach($row as $key=>$column) {
   	     if($this->matches($column, $expression)) {
   	        $count++;
   	     }
   	  }
   }
   return $count == 5;
}


/**
 * removeStreetFieldOverride
 * This function scans the panels and locates the street address field for the given key
 * and replaces the Array definition (from the merging process) with a String value.
 * @param $panels Array of the view's panels
 * @param $street String key value of the street to search for
 * @returns $panels Array of view's panels with street value substituted
 */
function removeStreetFieldOverride($panels, $street) {
   $expression = '/^' . $street . '_address_street$/si';
   foreach($panels as $name=>$panel) {
   	foreach($panel as $rowCount=>$row) {
   	  foreach($row as $key=>$column) {
   	     if($this->matches($column, $expression)) {
   	     	 $panels[$name][$rowCount][$key] = $street . '_address_street';
   	     }
   	  }
   	}
   }
   return $panels;
}

}

?>
