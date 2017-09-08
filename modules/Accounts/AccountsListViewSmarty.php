<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

require_once('include/ListView/ListViewSmarty.php');
require_once('modules/AOS_PDF_Templates/formLetter.php');


class AccountsListViewSmarty extends ListViewSmarty {

	function __construct(){

		parent::__construct();
		$this->targetList = true;

	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function AccountsListViewSmarty(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }



	protected function buildAddAccountContactsToTargetList()
	{
		global $app_strings;
		unset($_REQUEST[session_name()]);
		unset($_REQUEST['PHPSESSID']);
		$current_query_by_page = htmlentities(json_encode($_REQUEST));

		$js = <<<EOF
             if(sugarListView.get_checks_count() < 1) {
                 alert('{$app_strings['LBL_LISTVIEW_NO_SELECTED']}');
                 return false;
             }
 			if ( document.forms['targetlist_form'] ) {
 				var form = document.forms['targetlist_form'];
 				form.reset;
 			} else
 				var form = document.createElement ( 'form' ) ;
 			form.setAttribute ( 'name' , 'targetlist_form' );
 			form.setAttribute ( 'method' , 'post' ) ;
 			form.setAttribute ( 'action' , 'index.php' );
 			document.body.appendChild ( form ) ;
 			if ( !form.module ) {
 			    var input = document.createElement('input');
 			    input.setAttribute ( 'name' , 'module' );
 			    input.setAttribute ( 'value' , '{$this->seed->module_dir}' );
 			    input.setAttribute ( 'type' , 'hidden' );
 			    form.appendChild ( input ) ;
 			    var input = document.createElement('input');
 			    input.setAttribute ( 'name' , 'action' );
 			    input.setAttribute ( 'value' , 'TargetListUpdate' );
 			    input.setAttribute ( 'type' , 'hidden' );
 			    form.appendChild ( input ) ;
 			}
 			if ( !form.uids ) {
 			    var input = document.createElement('input');
 			    input.setAttribute ( 'name' , 'uids' );
 			    input.setAttribute ( 'type' , 'hidden' );
 			    form.appendChild ( input ) ;
 			}
 			if ( !form.prospect_list ) {
 			    var input = document.createElement('input');
 			    input.setAttribute ( 'name' , 'prospect_list' );
 			    input.setAttribute ( 'type' , 'hidden' );
 			    form.appendChild ( input ) ;
 			}
 			if ( !form.return_module ) {
 			    var input = document.createElement('input');
 			    input.setAttribute ( 'name' , 'return_module' );
 			    input.setAttribute ( 'type' , 'hidden' );
 			    form.appendChild ( input ) ;
 			}
 			if ( !form.return_action ) {
 			    var input = document.createElement('input');
 			    input.setAttribute ( 'name' , 'return_action' );
 			    input.setAttribute ( 'type' , 'hidden' );
 			    form.appendChild ( input ) ;
 			}
 			if ( !form.select_entire_list ) {
 			    var input = document.createElement('input');
 			    input.setAttribute ( 'name' , 'select_entire_list' );
 			    input.setAttribute ( 'value', document.MassUpdate.select_entire_list.value);
 			    input.setAttribute ( 'type' , 'hidden' );
 			    form.appendChild ( input ) ;
 			}
 			if ( !form.current_query_by_page ) {
 			    var input = document.createElement('input');
 			    input.setAttribute ( 'name' , 'current_query_by_page' );
 			    input.setAttribute ( 'value', '{$current_query_by_page}' );
 			    input.setAttribute ( 'type' , 'hidden' );
 			    form.appendChild ( input ) ;
 			}
 			open_popup('ProspectLists','600','400','',true,false,{ 'call_back_function':'set_return_and_save_targetlist', 'form_name':'targetlist_form','field_to_name_array':{'id':'prospect_list'}, 'passthru_data':{'do_contacts' : 1 }   } );
EOF;
		$js = str_replace(array("\r","\n"),'',$js);
		return "<a href='javascript:void(0)' class=\"parent-dropdown-action-handler\" id=\"targetlist_listview \" onclick=\"$js\">{$app_strings['LBL_ADD_TO_PROSPECT_LIST_BUTTON_LABEL_ACCOUNTS_CONTACTS']}</a>";
	}


	function process($file, $data, $htmlVar) {

		$this->actionsMenuExtraItems[] = $this->buildAddAccountContactsToTargetList();

		parent::process($file, $data, $htmlVar);

		if(!ACLController::checkAccess($this->seed->module_dir,'export',true) || !$this->export) {
			$this->ss->assign('exportLink', $this->buildExportLink());
		}
	}


	/**
	 * override
	 */
	protected function buildActionsLink($id = 'actions_link', $location = 'top') {
		$ret = parent::buildActionsLink($id, $location);

		$replaces = array(
			6 => 7,
		);

		foreach($replaces as $i => $j) {
			$tmp = $ret['buttons'][$j];
			$ret['buttons'][$j] = $ret['buttons'][$i];
			$ret['buttons'][$i] = $tmp;
		}

		return $ret;
	}
	
	function buildExportLink($id = 'export_link'){
		global $app_strings;
		global $sugar_config;

		$script = "";
		if(ACLController::checkAccess($this->seed->module_dir,'export',true)) {
			if($this->export) {
                		$script = parent::buildExportLink($id);
            		}
        	}

            $script .= "<a href='javascript:void(0)' id='map_listview_top' " .
                    " onclick=\"return sListView.send_form(true, 'jjwg_Maps', " .
                    "'index.php?entryPoint=jjwg_Maps&display_module={$_REQUEST['module']}', " .
                    "'{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_MAP']}</a>";

		return formLetter::LVSmarty().$script;
	}

}

?>
