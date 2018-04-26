/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
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

$(function() {
    username = $("#facebook_user_c").text();
    if(username.length > 0){
        $("#subpanel_title_activities").before('<table cellspacing="0" cellpadding="0" border="0" width="100%" class="formHeader h3Row"><tbody><tr><td style="width:100px;"><h3 style="width:100px;"><span><a name="facebookfeeds"></a><span style="display: none" id="show_facebookfeeds"><a id="show_facebookfeeds" class="utilsLink" href="#"><img border="0" align="absmiddle" alt="Show" src="themes/SuiteP/images/advanced_search.gif"></a></span><span style="display: inline" id="hide_facebookfeeds"><a  class="utilsLink" href="#" id="facebookfeeds_show"><img border="0" align="absmiddle" alt="Hide" src="themes/SuiteP/images/basic_search.gif"></a></span>&nbsp;Facebook</span></h3></td><td width="100%"><img width="1" height="1" alt="" src="themes/SuiteP/images/blank.gif"></td></tr></tbody></table><div id="FacebookDiv" class="doNotPrint" style="width:100%"><table class="list view"><tr></tr><td width="100%"><span id="facebook_feed"></span></td></td><tr></tr></table></div>');

            $("#show_facebookfeeds").click(function(  ) {
            $("#FacebookDiv").show();
            $("#show_facebookfeeds").hide();
            $("#facebookfeeds_show").show();
            $("#show").hide();

        return false;
        });
        $("#facebookfeeds_show").click(function() {

            $("#FacebookDiv").hide();
            $("#facebookfeeds_show").hide();
            $("#show_facebookfeeds").show();
            return false;
        });
    }
});