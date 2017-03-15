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

var ComposeView = function (options) {
  "use strict";
  var self = this;
  options = $.extend({"id": ''}, options);
  options = $.extend({"email": Email.prototype.fromSelector(options.id+'.compose-view')}, options);

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
    var emailAddresses = $('#' + options.id + ' [name=to_addrs_names]').val().split('/[,;]/');

    if(self.isValidEmailAddresses(emailAddresses)) {
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

    var cc =$('#' + options.id + ' [name=cc_addrs_names]').val();
    var emailAddresses = cc.split('/[,;]/');

    if(self.isValidEmailAddresses(emailAddresses) || cc === '') {
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
    var bcc =$('#' + options.id + ' [name=bcc_addrs_names]').val();
    var emailAddresses = bcc.split('/[,;]/');

    if(self.isValidEmailAddresses(emailAddresses) || bcc === '') {
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

    if($('#'  + options.id + ' [name=name]').val() !== '') {
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

    if($('#' + options.id + ' [name=description_html]').val() !== '') {
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
  self.setValidationMessage = function(field, label) {
    "use strict";
    var translated_message = SUGAR.language.translate('Emails', label);
    alert(translated_message);
  };

  /**
   *
   * @param emailAddresses array|object eg ['a@example.com', 'b@example.com']
   * @returns {boolean}
   */
  self.isValidEmailAddresses = function(emailAddresses) {
    "use strict";
    if(typeof emailAddresses === 'object' || typeof emailAddresses === 'array') {
      for(var i = 0; i < emailAddresses.length; i++) {
        emailAddresses[i] = (emailAddresses[i] !== '') && isValidEmail(emailAddresses[i]);
      }
      if(emailAddresses.indexOf(false) === -1) {
        return true;
      }
    }

    return false;
  };

  // Construct view
  $(document).ready(function() {
    "use strict";
    /**
     * Used to preview email. It also doubles as a means to get the plain text version
     * using $('#'+options.id + ' .html_preview').text();s
     */
    $('<div></div>').addClass('hidden').addClass('html_preview').appendTo("form#" + options.id + ".composer-view");


    if (typeof tinymce === "undefined") {
      console.error('Cannot find tiny mce. Please include it in modules/Emails/metadata/composeviewdefs.php.');
      $('<input>')
        .attr('name', 'description_html')
        .attr('type', 'hidden')
        .attr('id', 'description_html')
        .appendTo($('#' + options.id));

      // copy plain to html
      $('#' + options.id + ' #description_html').closest('.edit-view-row-item').addClass('hidden');
      $('#' + options.id + ' textarea[name=description]').on("keyup", function (e) {
        $('#' + options.id + ' [name=description_html]').val($('#' + options.id + ' textarea[name=description]').val());
      });
    } else {
      $('#' + options.id + ' [name=description]').closest('.edit-view-row-item').addClass('hidden');
      tinymce.init({
        selector: '#' + options.id + ' #description_html',
        mode: "specific_textareas",
        plugins: "fullscreen",
        formats: {
          bold: {inline: 'b'},
          italic: {inline: 'i'},
          underline: {inline: 'u'}
        },
        setup: function (editor) {
          editor.on('change', function (e) {
            // copy html to plain
            $('#' + options.id + ' .html_preview').html(editor.getContent());
            $('#' + options.id + ' [name=description_html]').val(editor.getContent());
            $('#' + options.id + ' [name=description]').val($('#' + options.id + ' .html_preview').text());
          });
        }
      });
    }

    // Handle sent email submission
    $("form#" + options.id + ".composer-view").submit(function () {
      $.ajax({
        type: "POST",
        data: $(this).serialize(),
        cache: false,
        url: $(this).attr('action')
      }).done(function (data) {
        "use strict";
        // If the user is view the form own its own
        if ($('#' + options.id + ' input[type="hidden"][name="return_module"]').val() !== '') {
          var redirect_location = 'index.php?module=' + $('#' + options.id + ' input[type="hidden"][name="return_module"]').val() +
            '&action=' +
            $('#' + options.id + ' input[type="hidden"][name="return_action"]').val();
          location.href = redirect_location;
        } else {
          // TODO: Create custom event for success
        }
      }).error(function (data) {
        "use strict";
        alert(SUGAR.language.translate($('#' + options.id + ' input[type="hidden"][name="module"]').val(), 'LBL_ERROR_SENDING_EMAIL'))
        // TODO: Create custom event for error
      });
      return false;
    });

    // Handle toolbar button events
    $('#' + options.id + ' .btn-send-email').click(function () {
      "use strict";
      self.email = Email.prototype.fromSelector(options.id + '.compose-view');
      if (self.isValid()) {
        $('#' + options.id).submit();
      }
      return false;
    });
    // TODO: Create custom event for on load
  });
};
