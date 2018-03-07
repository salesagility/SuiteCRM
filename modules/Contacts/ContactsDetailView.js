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



var ContactsDetailView = new function() {
  this.onPortalUrlLinkClick = function(lnk, operation) {
    var selectedPortalUrl = $(lnk).attr('data-url');
    var _form = document.getElementById('formDetailView');
    var _onclick=(function() {
      _form.action.value = operation+'PortalUser';
      $(_form).append('<input type="hidden" name="selected_portal_url" value="'+selectedPortalUrl+'">');
    }());
    if(_onclick!==false) {
      _form.submit();
    }
  };

  // get aop config & urls
  var contact_id = $('form[name="DetailView"] input[type="hidden"][name="record"]').val();
  $.getJSON('index.php?module=Contacts&action=getAOPConfig&contact_id='+contact_id, function(aop) {
    console.log(aop);
    // if aop enabled build a submenu..
    if(aop && aop.config.enable_aop) {

      pUrls = [];
      pDisableds = {};
      for(var i in aop.JAccounts) {
        pUrls.push(aop.JAccounts[i].portal_url);
        pDisableds[aop.JAccounts[i].portal_url] = (parseInt(aop.JAccounts[i].portal_account_disabled) == 1);
      }

      /**
       * We also need the create button when we already having a portal user
       * because no garanti it's still there and not deleted by Joomla site Administrator (for e.g)
       *
       * @type {boolean}
       */
      var needCreateButton = true;
      var needDisableButton = false;
      var needEnableButton = false;
      var createPortalUserLinksHtml = '<ul class="sub-ddmenu joomlaPortalUrls">';
      var disablePortalUserLinksHtml = '<ul class="sub-ddmenu joomlaPortalUrls">';
      var enablePortalUserLinksHtml = '<ul class="sub-ddmenu joomlaPortalUrls">';
      for(var i in aop.config.joomla_urls) {

        // add only these urls where this contact having at least one portal user
        var created = "&nbsp;&nbsp;(created)";
        if(pUrls.indexOf(aop.config.joomla_urls[i]) == -1) {
          // already in the DB but may deleted in the Joomla site or an error happened when trying to create portal user
          created = "";
        }

        createPortalUserLinksHtml += '<li><a href="javascript:" onclick="ContactsDetailView.onPortalUrlLinkClick(this, \'create\');" data-url="' + aop.config.joomla_urls[i] + '">' + aop.config.joomla_urls[i] + created + '</a></li>';

        if(!pDisableds[aop.config.joomla_urls[i]]) {
          disablePortalUserLinksHtml += '<li><a href="javascript:" onclick="ContactsDetailView.onPortalUrlLinkClick(this, \'disable\');" data-url="' + aop.config.joomla_urls[i] + '">' + aop.config.joomla_urls[i] + '</a></li>';
          needDisableButton = true;
        } else {
          enablePortalUserLinksHtml += '<li><a href="javascript:" onclick="ContactsDetailView.onPortalUrlLinkClick(this, \'enable\');" data-url="' + aop.config.joomla_urls[i] + '">' + aop.config.joomla_urls[i] + '</a></li>';
          needEnableButton = true;
        }


      }
      createPortalUserLinksHtml += '</ul>';
      disablePortalUserLinksHtml += '</ul>';
      enablePortalUserLinksHtml += '</ul>';
      $('input[name="buttonCreatePortalUser"]').after(createPortalUserLinksHtml);
      $('input[name="buttonDisablePortalUser"]').after(disablePortalUserLinksHtml);
      $('input[name="buttonEnablePortalUser"]').after(enablePortalUserLinksHtml);

      if(!needCreateButton) {
        $('input[name="buttonCreatePortalUser"]').closest('li').remove();
      }
      if(!needDisableButton) {
        $('input[name="buttonDisablePortalUser"]').closest('li').remove();
      }
      if(!needEnableButton) {
        $('input[name="buttonEnablePortalUser"]').closest('li').remove();
      }

    }
  });

};
