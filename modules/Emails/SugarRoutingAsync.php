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

/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 *********************************************************************************/
require_once("include/SugarRouting/SugarRouting.php");

$ie = new InboundEmail();
$json = getJSONobj();
$rules = new SugarRouting($ie, $current_user);

switch ($_REQUEST['routingAction']) {
    case "setRuleStatus":
        $rules->setRuleStatus($_REQUEST['rule_id'], $_REQUEST['status']);
    break;
    
    case "saveRule":
        $rules->save($_REQUEST);
    break;
    
    case "deleteRule":
        $rules->deleteRule($_REQUEST['rule_id']);
    break;
    
    /* returns metadata to construct actions */
    case "getActions":
        require_once("include/SugarDependentDropdown/SugarDependentDropdown.php");
        
        $sdd = new SugarDependentDropdown();
        $sdd->init("include/SugarDependentDropdown/metadata/dependentDropdown.php");
        $out = $json->encode($sdd->metadata, true);
        echo $out;
    break;
    
    /* returns metadata to construct a rule */
    case "getRule":
        $ret = '';
        if (isset($_REQUEST['rule_id']) && !empty($_REQUEST['rule_id']) && isset($_REQUEST['bean']) && !empty($_REQUEST['bean'])) {
            if (!isset($beanList)) {
                include("include/modules.php");
            }
            
            $class = $beanList[$_REQUEST['bean']];
            //$beanList['Groups'] = 'Group';
            if (isset($beanList[$_REQUEST['bean']])) {
                require_once("modules/{$_REQUEST['bean']}/{$class}.php");
                $bean = new $class();
                
                $rule = $rules->getRule($_REQUEST['rule_id'], $bean);
                
                $ret = array(
                    'bean' => $_REQUEST['bean'],
                    'rule' => $rule
                );
            }
        } else {
            $bean = new SugarBean();
            $rule = $rules->getRule('', $bean);
            
            $ret = array(
                'bean' => $_REQUEST['bean'],
                'rule' => $rule
            );
        }
        
        //_ppd($ret);
        
        $out = $json->encode($ret, true);
        echo $out;
    break;
    
    case "getStrings":
        $ret = $rules->getStrings();
        $out = $json->encode($ret, true);
        echo $out;
    break;

    
    default:
        echo "NOOP";
}
