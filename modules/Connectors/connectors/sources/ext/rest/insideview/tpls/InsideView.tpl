{*
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

*}
<script type="text/javascript">
function allowInsideView() {ldelim}

document.getElementById('insideViewFrame').src = "{$AJAX_URL}";
document.getElementById('insideViewConfirm').style.display = 'none';
document.getElementById('insideViewFrame').style.display = 'block';
YAHOO.util.Connect.asyncRequest('GET', 'index.php?module=Connectors&action=CallConnectorFunc&source_id=ext_rest_insideview&source_func=allowInsideView', {ldelim}{rdelim}, null);
{rdelim}
SUGAR.util.doWhen("typeof(markSubPanelLoaded) != 'undefined' && document.getElementById('subpanel_insideview')", function() {ldelim}
	markSubPanelLoaded('insideview');
	var insideViewSubPanel = document.getElementById("subpanel_insideview" );
	insideViewSubPanel.cookie_name="insideview_v";
	if(div_cookies['insideview_v']){ldelim}
		if(div_cookies['insideview_v'] == 'none')
		{ldelim}
            hideInsideViewSubPanel();
		{rdelim}
	{rdelim}
    else
    {ldelim}
        if(typeof(DCMenu) == 'undefined')
            return;
        var cookieKey = DCMenu.module + '_divs';
        var tmpCookie = Get_Cookie(cookieKey);
        if(tmpCookie)
        {ldelim}
            var subCookies = tmpCookie.split('#');
            var foundInsideViewCookie = false;
            for(var x=0;x<subCookies.length;x++ )
            {ldelim}
                var subCookie = subCookies[x];
                var pars = subCookie.split('=');
                if(pars.length == 2)
                {ldelim}
                    if(pars[0] == 'insideview_v')
                        foundInsideViewCookie = true;
                {rdelim}
            {rdelim}
            if(!foundInsideViewCookie)
            {ldelim}
                hideInsideViewSubPanel()
            {rdelim}
        {rdelim}
        else
        {ldelim}
            hideInsideViewSubPanel();
        {rdelim}

    {rdelim}

	toggleGettingStartedButton();
{rdelim});

function hideInsideViewSubPanel(){ldelim}
    hideSubPanel('insideview');
    document.getElementById('hide_link_insideview').style.display='none';
    document.getElementById('show_link_insideview').style.display='';
{rdelim}

function toggleGettingStartedButton(){ldelim}
	var acceptBox  = document.getElementById( "insideview_accept_box" );
	var gettingStartedButton  = document.getElementById( "insideview_accept_button" );

	if( acceptBox.checked ){ldelim}
		gettingStartedButton.disabled = '';
		gettingStartedButton.focus();
	{rdelim}
	else {ldelim}
		gettingStartedButton.disabled = "disabled";
	{rdelim}
{rdelim}
</script>
<div id='insideViewDiv' style='width:100%' class="doNotPrint">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formHeader h3Row">
        <tbody>
            <tr>
                <td nowrap="">
                    <h3>
                        <a name="insideview"> </a>
                        <span id="show_link_insideview" style="display: none">
                            <a class="utilsLink" href="#" onclick="current_child_field = 'insideview';markSubPanelLoaded('insideview');showSubPanel('insideview',null,null,'insideview');document.getElementById('show_link_insideview').style.display='none';document.getElementById('hide_link_insideview').style.display='';return false;">{sugar_getimage name='advanced_search' attr='border="0" align="absmiddle"' ext='.gif' alt=$APP.LBL_SHOW }</a>
                        </span>
                        <span id="hide_link_insideview" style="display: ">
                            <a class="utilsLink" href="#" onclick="hideSubPanel('insideview');document.getElementById('hide_link_insideview').style.display='none';document.getElementById('show_link_insideview').style.display='';return false;">{sugar_getimage name='basic_search' attr='border="0" align="absmiddle"' ext='.gif' alt=$APP.LBL_HIDE }</a>
                        </span>

                        <span>InsideView</span>
                    </h3>
                </td>
                <td width="100%" valign="middle" nowrap="">
                </td>
            </tr>
        </tbody>
    </table>
  <div id='subpanel_insideview' style='width:100%' {if !$showInsideView}align="center"{/if}>
      <div id='insideViewConfirm' class="detail view" style="width: 100%; text-align: left; position: relative;{if $showInsideView}display:none;{/if}">
          <a href="#" onclick="hideSubPanel('insideview');document.getElementById('hide_link_insideview').style.display='none';document.getElementById('show_link_insideview').style.display='';return false;"></a>
          <div style="width: 100%; float: left; padding: 10px 0px 20px 0pt;">
            <a target="_blank"  href="http://community.insideview.com/t5/Getting-Started/Find-Opportunities-to-Reach-Out-to-Customers/ta-p/1133"  style="float: left; width: 230px;display:block;text-decoration:none;">
                <img title="{$connector_language.LBL_OPP}" src="https://my.insideview.com/iv/common/ruby/images/sugarembed-img1.png" style="float: left;border:0 solid;">
                <div  style="float: left; padding-top: 11px; width: 150px;">
                    <span style="color: #990000; float: left; font-family: arial; font-size: 14px; font-weight: bold;">{$connector_language.LBL_OPP}</span>
                    <span style="font-size: 10px; font-weight: bold; font-family: arial; color: #333333;float: left;">{$connector_language.LBL_OPP_SUB}</span>
                </div>
            </a>
            <a target="_blank"  href="http://community.insideview.com/t5/Getting-Started/Get-Referrals-to-Key-Decision-Makers/ta-p/1141"  style="float: left; width: 230px;display:block;text-decoration:none;">
                <img title="{$connector_language.LBL_REFERRAL}" src="https://my.insideview.com/iv/common/ruby/images/sugarembed-img2.png" style="float: left;border:0 solid;">
                <div style="float: left; padding-top: 11px; padding-left: 10px;width: 150px;">
                    <span style="color: #990000; float: left; font-family: arial; font-size: 14px; font-weight: bold;">{$connector_language.LBL_REFERRAL}</span>
                    <span style="font-size: 10px; font-weight: bold; font-family: arial; color: #333333;float: left;">{$connector_language.LBL_REFERRAL_SUB}</span>
                </div>
            </a>
            <a  target="_blank"  href="http://community.insideview.com/t5/Getting-Started/Engage-Prospects-and-Customers/ta-p/1127" style="float: left; width: 230px;display:block;text-decoration:none;">
                <img title="{$connector_language.LBL_ENGAGE}" src="https://my.insideview.com/iv/common/ruby/images/sugarembed-img3.png" style="float: left;border:0 solid;">
                <div style="float: left; padding-top: 11px; padding-left: 10px;width: 140px;">
                    <span style="color: #990000; float: left; font-family: arial; font-size: 14px; font-weight: bold;">{$connector_language.LBL_ENGAGE}</span>
                    <span style="font-size: 10px; font-weight: bold; font-family: arial; color: #333333;float: left;">{$connector_language.LBL_ENGAGE_SUB}</span>
                </div>
            </a>
          </div>
          <hr style="border-color: rgb(238, 238, 238); background-color: rgb(238, 238, 238); width: 100%;">
          <form>
              <input type="checkbox" class="checkbox" name="insideview_accept_box" id="insideview_accept_box" style="display: none;" onclick="toggleGettingStartedButton();">
              <div style="float:left;padding:0 0 10px 0">
                    <div style="font-size: 11px; float:left;margin: 5px 15px 0px 150px;">
                        {$connector_language.iv_description0}&nbsp;<a href="http://www.insideview.com/cat-terms-use.html" target="_blank" style="color:#0099CC;text-decoration: none; font-size: 11px;">{$connector_language.LBL_TOS1}</a>&nbsp;and&nbsp;<a style="color:#0099CC;text-decoration: none; font-size: 11px;" target="_blank" href="http://www.insideview.com/cat-privacy.html">{$connector_language.LBL_TOS3}</a>.
                    </div>
                    <div onclick="allowInsideView(); return false;" name="insideview_accept_button" id="insideview_accept_button" style="float:right;height: 30px; background-image: url('https://my.insideview.com/iv/common/ruby/images/sugarembed-button.png');font-weight: bold; width: 113px; font-size: 14px;cursor:pointer;">
                        <div style="float:left;margin:7px 0 0 18px;color:#ffffff;">{$connector_language.LBL_GET_STARTED}</div>
                    </div>
              </div>
          </form>
          <div class="clear"></div>
      </div>
      <iframe id='insideViewFrame' src='{$URL}' title='{$URL}' scrolling="no" style='border:0px; width:100%;height:400px;overflow:hidden;{if !$showInsideView}display:none;{else}display:block;{/if}'></iframe>
   </div>
</div>