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
 */

(function ($) {
  "use strict";

  /**
   *
   * @param options
   * @returns {jQuery|HTMLElement}
   * @constructor
   */
  $.fn.ImportView = function (options) {
    var self = $(this);
    var opts = $.extend({}, $.fn.ImportView.defaults, options);

    /**
     *
     * @type {jQuery|HTMLElement}
     */
    self.messageBox = undefined;

    /**
     *
     * @type {{}}
     */
    self.email = {};
    /**
     * @type {undefined|String}
     */
    self.email.inboundEmailRecord = undefined;
    /**
     * @type {undefined|String}
     */
    self.email.uid = undefined;
    /**
     * @type {undefined|String}
     */
    self.email.msgno = undefined;

    /**
     * Where selects ok in messageBox
     * @param {MouseEvent} e
     */
    self.messageBoxOkHandler = function(e, caller) {
      self.messageBox.hideFooter();
      self.messageBox.setTitle(SUGAR.language.translate('', 'LBL_EMAIL_IMPORTING_EMAIL'));

      var view = self.messageBox.controls.modal.content.find('[name="EditView"]');
      var action = 'index.php?module=Emails&action=ImportAndShowDetailView&folder=INBOXTestInbox&folder=inbound'+
        '&inbound_email_record='+self.email.inboundEmailRecord +
        '&uid='+ self.email.uid +
        '&msgno=' + self.email.msgno;

      $('<div class="in-progress"><img src="themes/'+SUGAR.themes.theme_name+'/images/loading.gif"></div>')
        .prependTo(view.parent());

      view.hide();

      view.attr('action', action);

      $.each(view.find('input[name]'), function (i, v) {
        var name = 'SET_AFTER_IMPORT_'+$(v).attr('name');
        $(v).attr('name', name);
      });

      $.each(view.find('select[name]'), function (i, v) {
        var name = 'SET_AFTER_IMPORT_'+$(v).attr('name');
        $(v).attr('name', name);
      });

      $.each(view.find('textarea[name]'), function (i, v) {
        var name = 'SET_AFTER_IMPORT_'+$(v).attr('name');
        $(v).attr('name', name);
      });
      view.submit();
    };

    /**
     * Where selects ok in messageBox
     * @param {MouseEvent} e
     */
    self.messageBoxCancelHandler = function(e, caller) {
      self.messageBox.remove();
    };


    self.showMessageBox = function(mouseEvent) {

      var caller = $(mouseEvent.target);
      self.email.inboundEmailRecord = caller.attr('data-inbound-email-record');
      self.email.uid = caller.attr('data-email-uid');
      self.email.msgno = caller.attr('data-email-msgno');

      self.messageBox = messageBox({'size': 'lg'});

      if (typeof opts.messageBoxOkHandler !== "undefined") {
        self.messageBox.on('ok', function(e) {
          opts.messageBoxOkHandler(e, [self]);
        });
      } else {
        self.messageBox.on('ok', self.messageBoxOkHandler);
      }

      if (typeof opts.messageBoxCancelHandler !== "undefined") {
        self.messageBox.on('cancel', function(e) {
          opts.messageBoxCancelHandler(e, [self]);
        });
      } else {
        self.messageBox.on('cancel', self.messageBoxCancelHandler);
      }

      self.messageBox.setTitle(SUGAR.language.translate('', 'LBL_EMAIL_IMPORT_EMAIL'));
      self.messageBox.hideHeader();
      self.messageBox.hideFooter();
      self.messageBox.setBody('<div class="email-in-progress"><img src="themes/' + SUGAR.themes.theme_name + '/images/loading.gif"></div>');
      self.messageBox.show();
      // Get view
      $.ajax({type: "GET", cache: false, url: 'index.php?module=Emails&action=ImportView'}).done(function (data) {
        self.messageBox.showHeader();
        self.messageBox.showFooter();

        if (data.length === 0) {
          console.error("Unable to display ImportView");
          self.messageBox.setBody(SUGAR.language.translate('', 'ERR_AJAX_LOAD'));
          return;
        }
        // Display view
        self.messageBox.setBody(data);
      }).fail(function (data) {
        self.messageBox.showHeader();
        self.messageBox.showFooter();
        self.messageBox.controls.modal.content.html(SUGAR.language.translate('', 'LBL_EMAIL_ERROR_GENERAL_TITLE'));
      });
    };

    /**
     * Constructor
     */
    self.construct = function () {

      if(opts.callerSelector) {
        $(opts.callerSelector).on('click', self.showMessageBox);
      }

      $(self).trigger("constructImportView", [self]);
    };

    /**
     * @destructor
     */
    self.destruct = function () {
      $(self).trigger("deconstructImportView", [self]);
      return true;
    };

    self.construct();

    return $(self);
  };

  $.fn.ImportView.defaults = {
    'callerSelector': '[data-action="emails-import-single"]',
    'parentContainer': '#content',
    'mode': 'single'
  };
}(jQuery));