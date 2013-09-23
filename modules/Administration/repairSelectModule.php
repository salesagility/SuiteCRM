<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
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

		
		global $mod_strings;
		global $current_language;
		$smarty = new Sugar_Smarty();
			$temp_bean_list = $beanList;
			asort($temp_bean_list);
			$values= array_values($temp_bean_list);
			$output= array_keys($temp_bean_list);  
			$output_local = array();
			if($current_language != 'en_us') {
				foreach($output as $temp_out) {
					$output_local[] = translate($temp_out);
				}
			} else {
				$output_local = $output;
			}
			//sort($output);
			//sort($values);
			$values=array_merge(array($mod_strings['LBL_ALL_MODULES']), $values);
			$output= array_merge(array($mod_strings['LBL_ALL_MODULES']),$output_local);
			$checkbox_values=array(
									 'clearTpls',
									 'clearJsFiles',
									 'clearVardefs', 
									 'clearJsLangFiles',
									 'clearDashlets',
									 'clearSugarFeedCache',
									 'clearThemeCache',
									 'rebuildAuditTables',
									 'rebuildExtensions',
									 'clearLangFiles',
                                     'clearSearchCache',
			                         'clearPDFFontCache',
			                         //'repairDatabase'
									 );
			$checkbox_output = array(   $mod_strings['LBL_QR_CBOX_CLEARTPL'], 
                                        $mod_strings['LBL_QR_CBOX_CLEARJS'],
                                        $mod_strings['LBL_QR_CBOX_CLEARVARDEFS'],
                                        $mod_strings['LBL_QR_CBOX_CLEARJSLANG'],
                                        $mod_strings['LBL_QR_CBOX_CLEARDASHLET'],
                                        $mod_strings['LBL_QR_CBOX_CLEARSUGARFEEDCACHE'],
                                        $mod_strings['LBL_QR_CBOX_CLEARTHEMECACHE'],
                                        $mod_strings['LBL_QR_CBOX_REBUILDAUDIT'],
                                        $mod_strings['LBL_QR_CBOX_REBUILDEXT'],
                                        $mod_strings['LBL_QR_CBOX_CLEARLANG'],
                                        $mod_strings['LBL_QR_CBOX_CLEARSEARCH'],
                                        $mod_strings['LBL_QR_CBOX_CLEARPDFFONT'],
                                        //$mod_strings['LBL_QR_CBOX_DATAB'],
									 );
			$smarty->assign('checkbox_values', $checkbox_values);
			$smarty->assign('values', $values);
			$smarty->assign('output', $output);
			$smarty->assign('MOD', $mod_strings);
			$smarty->assign('checkbox_output', $checkbox_output);
			$smarty->assign('checkbox_values', $checkbox_values);
			$smarty->display("modules/Administration/templates/QuickRepairAndRebuild.tpl");			
			
			
?>
