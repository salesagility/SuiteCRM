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







$current_module_strings = return_module_language($current_language, "Opportunities");
$seedOpportunity = BeanFactory::newBean('Opportunities');
    
//build top 5 opportunity list
$where = "opportunities.sales_stage <> 'Closed Won' AND opportunities.sales_stage <> 'Closed Lost' AND opportunities.assigned_user_id='".$current_user->id."'";
$header_text = '';
if (is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])) {
    $header_text = "&nbsp;<a href='index.php?action=index&module=DynamicLayout&from_action=ListView&from_module=Opportunities'>".SugarThemeRegistry::current()->getImage("EditLayout", "border='0' align='bottom'", null, null, '.gif', $mod_strings['LBL_EDITLAYOUT'])."</a>";
}
$ListView = new ListView();
$ListView->initNewXTemplate('modules/Opportunities/ListViewTop.html', $current_module_strings);
$ListView->setHeaderTitle($current_module_strings['LBL_TOP_OPPORTUNITIES']. $header_text);
$ListView->setQuery($where, 5, "amount  DESC", "OPPORTUNITY", false);
$ListView->processListView($seedOpportunity, "main", "OPPORTUNITY");
