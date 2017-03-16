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

  $.fn.EmailsComposeView = function (options) {
    "use strict";
    var self = $(this);
    var opts = $.extend({}, $.fn.EmailsComposeView.defaults, options);

    /**
     * @return string UUID
     */
    self.generateID = function () {
      "use strict";
      var characters = ['a', 'b', 'c', 'd', 'e', 'f', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
      var format = '0000000-0000-0000-0000-00000000000';
      var z = Array.prototype.map.call(format, function ($obj) {
        var min = 0;
        var max = characters.length - 1;

        if ($obj == '0') {
          var index = Math.round(Math.random() * (max - min) + min);
          $obj = characters[index];
        }

        return $obj;
      }).toString().replace(/(,)/g, '');
      return z;
    };

    /**
     * form validation
     * @returns {boolean}
     */
    self.isValid = function () {
      "use strict";
      return self.isToValid() &&
        self.isCcValid() &&
        self.isBccValid() &&
        self.isSubjectValid() &&
        self.isBodyValid();
    };

    /**
     *
     * @returns {boolean}
     */
    self.isToValid = function () {
      "use strict";
      var emailAddresses = $(self).find(' [name=to_addrs_names]').val().split('/[,;]/');

      if (self.isValidEmailAddresses(emailAddresses)) {
        return true;
      }

      self.setValidationMessage('to_addrs_names', 'LBL_HAS_INVALID_EMAIL_TO');
      return false;
    };

    /**
     *
     * @returns {boolean}
     */
    self.isCcValid = function () {
      "use strict";

      var cc = $(self).find(' [name=cc_addrs_names]').val();
      var emailAddresses = cc.split('/[,;]/');

      if (self.isValidEmailAddresses(emailAddresses) || cc === '') {
        return true;
      }

      self.setValidationMessage('cc_addrs_names', 'LBL_HAS_INVALID_EMAIL_CC');
      return false;
    };

    /**
     *
     * @returns {boolean}
     */
    self.isBccValid = function () {
      "use strict";
      var bcc = $(self).find('[name=bcc_addrs_names]').val();
      var emailAddresses = bcc.split('/[,;]/');

      if (self.isValidEmailAddresses(emailAddresses) || bcc === '') {
        return true;
      }

      self.setValidationMessage('bcc_addrs_names', 'LBL_HAS_INVALID_EMAIL_BCC');
      return false;
    };

    /**
     *
     * @returns {boolean}
     */
    self.isSubjectValid = function () {
      "use strict";

      if ($(self).find('[name=name]').val() !== '') {
        return true;
      }

      self.setValidationMessage('name', 'LBL_HAS_EMPTY_EMAIL_SUBJECT');
      return false;
    };

    /**
     *
     * @returns {boolean}
     */
    self.isBodyValid = function () {
      "use strict";

      if ($(self).find('#description').val() !== '') {
        return true;
      }

      self.setValidationMessage('description_html', 'LBL_HAS_EMPTY_EMAIL_BODY');
      return false;
    };

    /**
     *
     * @param field string name
     * @param label string eg LBL_OK
     */
    self.setValidationMessage = function (field, label) {
      "use strict";
      var translated_message = SUGAR.language.translate('Emails', label);
      alert(translated_message);
    };

    /**
     *
     * @param emailAddresses array|object eg ['a@example.com', 'b@example.com']
     * @returns {boolean}
     */
    self.isValidEmailAddresses = function (emailAddresses) {
      "use strict";
      if (typeof emailAddresses === 'object' || typeof emailAddresses === 'array') {
        for (var i = 0; i < emailAddresses.length; i++) {
          emailAddresses[i] = (emailAddresses[i] !== '') && isValidEmail(emailAddresses[i]);
        }
        if (emailAddresses.indexOf(false) === -1) {
          return true;
        }
      }

      return false;
    };

    /**
     *
     * @param editor
     */
    self.tinyMceSetup = function (editor) {
      editor.on('change', function (e) {
        // copy html to plain
        $(self).find('.html_preview').html(editor.getContent());
        $(self).find('[name=description_html]').val(editor.getContent());
        $(self).find('[name=description]').val($(self).find('.html_preview').text());
      });
    };

    /**
     *
     * @returns {boolean}
     */
    self.onSendEmail = function () {
      $(document).trigger("SendEmail", [self]);

      $.ajax({
        type: "POST",
        data: $(this).serialize(),
        cache: false,
        url: $(this).attr('action')
      }).done(function (data) {
        "use strict";
        // If the user is view the form own its own
        if ($(self).find('input[type="hidden"][name="return_module"]').val() !== '') {
          var redirect_location = 'index.php?module=' + $('#' + self.attr('id') + ' input[type="hidden"][name="return_module"]').val() +
            '&action=' +
            $(self).find('input[type="hidden"][name="return_action"]').val();
          location.href = redirect_location;
        } else {
          $(document).trigger("SentEmail", [data, self]);
        }
      }).fail(function (data) {
        "use strict";
        alert(SUGAR.language.translate($(self).find('input[type="hidden"][name="module"]').val(), 'LBL_ERROR_SENDING_EMAIL'))
        $(document).trigger("SentEmailError", [data, self]);
      }).always(function (data) {
        $(document).trigger("SentEmailAlways", [data, self]);
      });

      return false;
    };

    self.sendEmail = function () {
      "use strict";
      if (self.isValid()) {
        $(self).submit();
      }
      return false;
    }

    self.attachFile = function () {
      "use strict";
      alerts('attachFile placeholder');
      return false;
    };

    self.attachNote = function () {
      "use strict";
      alerts('attachNoteplaceholder');
      return false;
    };

    self.attachDocument = function () {
      "use strict";
      alerts('attachDocument placeholder');
      return false;
    };

    self.saveDraft = function () {
      "use strict";
      alerts('saveDraft placeholder');
      return false;
    };

    self.disregardDraft = function () {
      "use strict";
      alerts('disgardDraft placeholder');
      return false;
    };


    /**
     * Constructor
     */
    self.construct = function () {
      "use strict";

      if (self.length === 0) {
        console.error('EmailsComposeView: Invalid Selector');
        return
      }

      if (self.attr('id').length === 0) {
        console.warn('EmailsComposeView: expects element to have an id. EmailsComposeView has generated one.');
        self.attr('id', self.generateID());
      }

      if (typeof opts.tinyMceOptions.setup === "undefined") {
        opts.tinyMceOptions.setup = self.tinyMceSetup;
      }

      if (typeof opts.tinyMceOptions.selector === "undefined") {
        opts.tinyMceOptions.selector = $(self).find('#description_html');
      }

      /**
       * Used to preview email. It also doubles as a means to get the plain text version
       * using $('#'+self.attr('id') + ' .html_preview').text();s
       */
      $('<div></div>').addClass('hidden').addClass('html_preview').appendTo("form#" + self.attr('id') + ".composer-view");

      $('<input>')
        .attr('name', 'description_html')
        .attr('type', 'hidden')
        .attr('id', 'description_html')
        .appendTo($('#' + self.attr('id')));

      if (typeof tinymce === "undefined") {
        console.error('Missing Dependency: Cannot find tinyMCE.');

        // copy plain to html
        $(self).find('#description_html').closest('.edit-view-row-item').addClass('hidden');
        $(self).find('textarea[name=description]').on("keyup", function (e) {
          $(self).find('[name=description_html]').val($(self).find('textarea[name=description]').val().replace('\n', '<br>'));
        });
      } else {
        $(self).find('[data-label="description_html"]').closest('.edit-view-row-item').addClass('hidden');
        tinymce.init(opts.tinyMceOptions);
      }

      // Handle sent email submission
      self.submit(self.onSendEmail);

      // Handle toolbar button events
      $(self).find('.btn-send-email').click(self.sendEmail);
      $(self).find('.btn-attach-file').click(self.attachFile);
      $(self).find('.btn-attach-notes').click(self.attachNote);
      $(self).find('.btn-attach-document').click(self.attachDocument);
      $(self).find('.btn-save-draft').click(self.saveDraft);
      $(self).find('.btn-disregard-draft').click(self.disregardDraft);


      $(document).trigger("ConstructEmailsComposeView", [self]);
    };

    self.construct();

    return self;
  };

  $.fn.EmailsComposeView.defaults = {
    "tinyMceOptions": {
      mode: "specific_textareas",
      plugins: "fullscreen",
      formats: {
        bold: {inline: 'b'},
        italic: {inline: 'i'},
        underline: {inline: 'u'}
      }
    }
  }

}(jQuery));
