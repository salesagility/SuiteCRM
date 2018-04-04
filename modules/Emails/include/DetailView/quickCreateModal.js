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

function openQuickCreateModal(module, paramStr, fromAddr) {
  "use strict";

  var quickCreateBox = $('<div></div>').appendTo('#content');
  quickCreateBox.messageBox({"showHeader": false, "showFooter": false, "size": 'lg'});
  quickCreateBox.setBody(
    '<div class="email-in-progress"><img src="themes/' + SUGAR.themes.theme_name + '/images/loading.gif"></div>'
  );
  quickCreateBox.show();

  $.ajax({
    type: "GET",
    cache: false,
    url: 'index.php?module=' +module + '&action=EditView&in_popup=1&sugar_body_only=1' + paramStr
  }).done(function (data) {
    if (data.length === 0) {
      console.error("Unable to display QuickCreateView");
      quickCreateBox.setBody(SUGAR.language.translate('', 'ERR_AJAX_LOAD'));
      return;
    }
    quickCreateBox.setBody(data);

    quickCreateBox.find('input').each(function () {
      if ($(this).attr('id') === 'CANCEL') {
        $(this).attr('onclick', "$('#" + quickCreateBox.attr('id') + "').remove(); return false;");
      }
      if ($(this).attr('id') === 'SAVE') {
        $(this).attr('onclick', "submitQuickCreateForm('" + quickCreateBox.attr('id') + "'); return false;");
      }
    }, quickCreateBox);

    quickCreateBox.find('input[type="email"]').val(fromAddr);

    $('<input>', {
      id: 'quickCreateModule',
      name: 'quickCreateModule',
      value: module,
      type: 'hidden'
    }).appendTo('#EditView');
    $('<input>', {
      id: 'parentEmailRecordId',
      name: 'parentEmailRecordId',
      value: $('#parentEmailId').val(),
      type: 'hidden'
    }).appendTo('#EditView');

  }).fail(function (data) {
    quickCreateBox.controls.modal.content.html(SUGAR.language.translate('', 'LBL_EMAIL_ERROR_GENERAL_TITLE'));
  });
}

function submitQuickCreateForm(parentId) {
  var _form = document.getElementById('EditView');
  _form.action.value = 'Save';
  if (check_form('EditView')) {
    _form.action.value = 'QuickCreate';
    _form.module.value = 'Emails';

    var sentDataBox = $('<div></div>').appendTo('#content');
    sentDataBox.messageBox({"showHeader": false, "showFooter": false, "size": 'lg'});
    sentDataBox.setBody(
      '<div class="email-in-progress"><img src="themes/' + SUGAR.themes.theme_name + '/images/loading.gif"></div>'
    );
    sentDataBox.show();

    $.ajax({
      type: "POST",
      cache: false,
      url: 'index.php',
      data: $(_form).serialize(),
      async:true
    })
      .done(function(jsonData) {
        var data = JSON.parse(jsonData);

        if (data.id) {
          sentDataBox.remove();
          var returnDataBox = $('<div></div>').appendTo('#content');
          returnDataBox.messageBox({"size": 'lg'});
          returnDataBox.setBody(
            SUGAR.language.translate('Emails', 'LBL_QUICK_CREATE_SUCCESS1')
            + '<br />'
            + SUGAR.language.translate('Emails', 'LBL_QUICK_CREATE_SUCCESS2')
            + '<br />'
            + SUGAR.language.translate('Emails', 'LBL_QUICK_CREATE_SUCCESS3')
          );
          returnDataBox.show();
          returnDataBox.on('ok', function () {
            window.location.href = 'index.php?module=' + data.module + '&action=DetailView&record=' + data.id;
          });
          returnDataBox.on('cancel', function () {
            returnDataBox.remove();
            $("#" + parentId).remove();
          });
        }
        else {
          showErrorMessage(SUGAR.language.translate('', 'LBL_EMAIL_ERROR_GENERAL_TITLE'));
        }
      })
      .fail(function() {
        showErrorMessage(SUGAR.language.translate('', 'ERR_AJAX_LOAD'));
      })
  }
}

function showErrorMessage(msg) {
  var errorBox = $('<div></div>').appendTo('#content');
  errorBox.messageBox({"size": 'lg'});
  errorBox.setBody(msg);
  errorBox.show();
  errorBox.on('ok', function () {
    errorBox.remove();
  });
  errorBox.on('cancel', function () {
    errorBox.remove();
  });
}