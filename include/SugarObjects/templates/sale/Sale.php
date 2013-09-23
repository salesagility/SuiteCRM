<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
 require_once('include/SugarObjects/templates/basic/Basic.php');
 class Sale extends Basic{

 	function Sale(){
 		parent::Basic();

 	}
 	
 	function create_new_list_query($order_by, $where,$filter=array(),$params=array(), $show_deleted = 0,$join_type='', $return_array = false,$parentbean=null, $singleSelect = false)
 	{
 		//Ensure that amount is always on list view queries if amount_usdollar is as well.
 		if (!empty($filter) && isset($filter['amount_usdollar']) && !isset($filter['amount']))
 		{
 			$filter['amount'] = true;
 		}
 		return parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect);
 	}
 	
 	function fill_in_additional_list_fields()
	{
    	parent::fill_in_additional_list_fields();
    		
		//Ensure that the amount_usdollar field is not null.
		if (empty($this->amount_usdollar) && !empty($this->amount))
		{
			$this->amount_usdollar = $this->amount;
		}
	}
 	
 	function fill_in_additional_detail_fields()
	{		
		parent::fill_in_additional_detail_fields();
		//Ensure that the amount_usdollar field is not null.
		if (empty($this->amount_usdollar) && !empty($this->amount))
		{
			$this->amount_usdollar = $this->amount;
		}
	}

 	
 	function save($check_notify = FALSE) {
 		//"amount_usdollar" is really amount_basecurrency. We need to save a copy of the amount in the base currency.
		if(isset($this->amount) && !number_empty($this->amount)){
            if (!number_empty($this->currency_id))
			{
                $currency = new Currency();
                $currency->retrieve($this->currency_id);
                $this->amount_usdollar = $currency->convertToDollar($this->amount);
			}
			else 
			{
			$this->amount_usdollar = $this->amount;
			}
		}
		
		return parent::save($check_notify);
 	}
 }
?>
