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
    username = $("#twitter_user_c").text();
    if(username.length > 0){
        $("#subpanel_title_activities").before('<table cellspacing="0" cellpadding="0" border="0" width="100%" class="formHeader h3Row"><tbody><tr><td style="width:100px;"><h3 style="width:100px;"><span><a name="socialfeeds"></a><span style="display: none" id="show_socialfeeds"><a id="show_socialfeeds" class="utilsLink" href="#"><img border="0" align="absmiddle" alt="Show" src="themes/Suite7/images/advanced_search.gif?v=2KCfmg8Syk4QkxQ5cge6iw"></a></span><span style="display: inline" id="hide_socialfeeds"><a  class="utilsLink" href="#" id="socialfeeds_show"><img border="0" align="absmiddle" alt="Hide" src="themes/Suite7/images/basic_search.gif?v=2KCfmg8Syk4QkxQ5cge6iw"></a></span>&nbsp;Twitter</span></h3></td><td width="100%"><img width="1" height="1" alt="" src="themes/Suite7/images/blank.gif?v=2KCfmg8Syk4QkxQ5cge6iw"></td></tr></tbody></table><div id="SocialDiv" class="doNotPrint" style="width:100%"><table class="list view"><tr></tr><td width="100%"><span id="facebook_feed"></span><span id="feed"></span></td></td><tr></tr></table></div>');

            $("#show_socialfeeds").click(function(  ) {
            $("#SocialDiv").show();
            $("#show_socialfeeds").hide();
            $("#socialfeeds_show").show();
            $("#show").hide();

        return false;
        });
        $("#socialfeeds_show").click(function() {

            $("#SocialDiv").hide();
            $("#socialfeeds_show").hide();
            $("#show_socialfeeds").show();
            return false;
        });
    }
});