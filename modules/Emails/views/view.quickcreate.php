<?php
//FILE SUGARCRM flav=pro || flav=sales
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

require_once('include/MVC/View/views/view.quickcreate.php');
require_once('modules/Emails/EmailUI.php');

class EmailsViewQuickcreate extends ViewQuickcreate 
{
    /**
     * @see ViewQuickcreate::display()
     */
    public function display()
    {
        $userPref = $GLOBALS['current_user']->getPreference('email_link_type');
		$defaultPref = $GLOBALS['sugar_config']['email_default_client'];
		if($userPref != '')
			$client = $userPref;
		else
			$client = $defaultPref;
		
        if ( $client == 'sugar' ) {
            $eUi = new EmailUI();
            if(!empty($this->bean->id) && !in_array($this->bean->object_name,array('EmailMan')) ) {
                $fullComposeUrl = "index.php?module=Emails&action=Compose&parent_id={$this->bean->id}&parent_type={$this->bean->module_dir}";
                $composeData = array('parent_id'=>$this->bean->id, 'parent_type' => $this->bean->module_dir);
            } else {
                $fullComposeUrl = "index.php?module=Emails&action=Compose";
                $composeData = array('parent_id'=>'', 'parent_type' => '');
            }
            
            $j_quickComposeOptions = $eUi->generateComposePackageForQuickCreate($composeData, $fullComposeUrl); 
            $json_obj = getJSONobj();
            $opts = $json_obj->decode($j_quickComposeOptions);
            $opts['menu_id'] = 'dccontent';
             
            $ss = new Sugar_Smarty();
            $ss->assign('json_output', $json_obj->encode($opts));
            $ss->display('modules/Emails/templates/dceMenuQuickCreate.tpl');
        }
        else {
            $emailAddress = '';
            if(!empty($this->bean->id) && !in_array($this->bean->object_name,array('EmailMan'))
                && !is_null($this->bean->emailAddress) ) {
                $emailAddress = $this->bean->emailAddress->getPrimaryAddress($this->bean);
            }
            echo "<script>document.location.href='mailto:$emailAddress';lastLoadedMenu=undefined;DCMenu.closeOverlay();</script>";
            die();
        }
    } 
}