<?php
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

include_once __DIR__ . '/../../../../../../modules/SharedSecurityRulesActions/actions/actionAccessLevel.php';

/**
 * ActionAccessLevelTest
 *
 * @author gyula
 */
class ActionAccessLevelTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract {
    
    public function testLoadJS() {
        $aal = new actionAccessLevel();
        $ret = $aal->loadJS();
        $this->assertEquals(['modules/SharedSecurityRulesActions/actions/actionAccessLevel.js'], $ret);
    }
    
    public function testEditDisplay() {
        $aal = new actionAccessLevel();
        $ret = $aal->edit_display('test_line');
        $this->assertContains('<input type="hidden" name="aow_email_type_list" id="aow_email_type_list" value="
<OPTION selected value=\'\'>--None--</OPTION>
<OPTION value=\'Specify User\'>User</OPTION>
<OPTION value=\'Users\'>Users</OPTION>">
				  <input type="hidden" name="aow_email_to_list" id="aow_email_to_list" value="
<OPTION value=\'to\'>To</OPTION>
<OPTION value=\'cc\'>Cc</OPTION>
<OPTION value=\'bcc\'>Bcc</OPTION>">
				  <input type="hidden" name="sharedGroupRule" id="sharedGroupRule" value="
<OPTION value=\'none\'>No Access</OPTION>
<OPTION value=\'view\'>View Only</OPTION>
<OPTION value=\'view_edit\'>View & Edit</OPTION>
<OPTION value=\'view_edit_delete\'>View, Edit & Delete</OPTION>"><table border=\'0\' cellpadding=\'0\' cellspacing=\'0\' width=\'100%\' data-workflow-action=\'setRule\'><tr><td id="name_label" scope="row" valign="top"><label>Options:<span class="required">*</span></label></td><td valign="top" scope="row"><button type="button" onclick="add_emailLine(test_line)"><img src="themes/SuiteP/images/id-ff-add.png?v=', $ret);
        $this->assertContains('"></button><table id="emailLinetest_line_table" width="100%" class="email-line"></table></td></tr></table><script id =\'aow_scripttest_line\'></script>', $ret);
    }
    
}
