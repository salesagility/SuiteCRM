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
  /**
   *
   * @param options
   * @return {*|HTMLElement}
   */
  $.fn.ImportEmailAction =  function(options) {
    "use strict";
    var self = this;
    var opts = $.extend({}, $.fn.ImportEmailAction.defaults, options);

    if(typeof messageBox === "undefined") {
      console.error('ImportEmailAction - Missing Dependency: Cannot find messageBox.');
      return $(self);
    }

    self.handleClick = function (e) {

      var mb = messageBox({backdrop: false});
      mb.setTitle(SUGAR.language.translate('Emails', 'LBL_IMPORTING'));
      mb.setBody('<div class="in-progress"><img src="themes/'+SUGAR.themes.theme_name+'/images/loading.gif"></div>');
      mb.hideFooter();
      mb.show();
      mb.on('cancel', function() {
        "use strict";
        mb.remove();
      });


      var query = JSON.parse($('[name=current_query_by_page]').val());
      var url = 'index.php?module=Emails&action=ImportFromListView';

     var postOpts = {
        "inbound_email_record": query.inbound_email_record,
        "folders_id": query.folders_id,
        "folder": query.folder,
        "uid[]": []
      };

      if(document.MassUpdate.select_entire_list &&
        document.MassUpdate.select_entire_list.value == 1) {
        // Import all emails from mail box
        postOpts.all = true;
      } else {
        postOpts.all = false;
        // import only selected emails from inbox
        $('.listview-checkbox').each(function(i,v) {
          if($(v).is(':checked')) {
            postOpts['uid[]'].push(query.email_uids[i])
          };
        });
      }

      $.post( url, postOpts).done(function (data) {
        var jsonData = JSON.parse(data);
        mb.hide();
        if(jsonData.response === true) {
          window.location.reload();
        } else {
          console.error('Error importing emails. Please check the logs for details.')
        }
      }).error(function (data) {
        mb.hide();
        alert(data);
      });
    };

    self.construct = function() {
      $(opts.buttonSelector).click(self.handleClick);
    };

    self.construct();
    return $(self);
  };

  $.fn.ImportEmailAction.defaults = {
    'buttonSelector': '[data-action=emails-import-multiple]',
    'contentSelector': '#content',
    'defaultFolder': 'INBOX'
  }
}(jQuery));

$(document).ready(function() {
  $(document).ImportEmailAction();
});