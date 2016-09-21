/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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

(function () {
  //Do not double define
  if (SUGAR.EmailAddressWidget) return;

  SUGAR.EmailAddressWidget = function (module) {
    if (!SUGAR.EmailAddressWidget.count[module]) SUGAR.EmailAddressWidget.count[module] = 0;
    this.count = SUGAR.EmailAddressWidget.count[module];
    SUGAR.EmailAddressWidget.count[module]++;
    this.module = module;
    this.id = this.module + this.count;
    if (document.getElementById(module + '_email_widget_id'))
      document.getElementById(module + '_email_widget_id').value = this.id;
    SUGAR.EmailAddressWidget.instances[this.id] = this;
  }

  SUGAR.EmailAddressWidget.instances = {};
  SUGAR.EmailAddressWidget.count = {};

  SUGAR.EmailAddressWidget.prototype = {
    emailTemplate: '<tr id="emailAddressRow">' +
    '<td nowrap="NOWRAP"><input type="text" title="email address 0" name="emailAddress{$index}" id="emailAddress0" size="30"/></td>' +
    '<td><span>&nbsp;</span><img id="removeButton0" name="0" src="index.php?entryPoint=getImage&amp;themeName=Sugar&amp;imageName=delete_inline.gif"/></td>' +
    '<td align="center"><input type="radio" name="emailAddressPrimaryFlag" id="emailAddressPrimaryFlag0" value="emailAddress0" enabled="true" checked="true"/></td>' +
    '<td align="center"><input type="checkbox" name="emailAddressOptOutFlag[]" id="emailAddressOptOutFlag0" value="emailAddress0" enabled="true"/></td>' +
    '<td align="center"><input type="checkbox" name="emailAddressInvalidFlag[]" id="emailAddressInvalidFlag0" value="emailAddress0" enabled="true"/></td>' +
    '<td><input type="hidden" name="emailAddressVerifiedFlag0" id="emailAddressVerifiedFlag0" value="true"/></td>' +
    '<td><input type="hidden" name="emailAddressVerifiedValue0" id="emailAddressVerifiedValue0" value=""/></td></tr>',
    totalEmailAddresses: 0,
    replyToFlagObject: new Object(),
    verifying: false,
    enterPressed: false,
    tabPressed: false,
    emailView: "",
    emailIsRequired: false,
    tabIndex: -1,

    isIE: function() {

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
    {
      return true;
    }

    return false;
  },
    prefillEmailAddresses: function (tableId, o) {
      for (i = 0; i < o.length; i++) {
        o[i].email_address = o[i].email_address.replace('&#039;', "'");
        this.addEmailAddress(tableId, o[i].email_address, o[i].primary_address, o[i].reply_to_address, o[i].opt_out, o[i].invalid_email, o[i].email_address_id);
      }
    },

    retrieveEmailAddress: function (event) {
      var callbackFunction = function success(data) {
        var vals = jQuery.parseJSON(data.responseText);
        var target = vals.target;
        event = this.getEvent(event);

        if (vals.email) {
          var email = vals.email;
          if (email != '' && /\d+$/.test(target)) {
            var matches = target.match(/\d+$/);
            var targetNumber = matches[0];
            var optOutEl = $('#' + this.id + 'emailAddressOptOutFlag' + targetNumber);
            if (optOutEl) {
              optOutEl.checked = email['opt_out'] == 1 ? true : false;
            }
            var invalidEl = $('#' + this.id + 'emailAddressInvalidFlag' + targetNumber);
            if (invalidEl) {
              invalidEl.checked = email['invalid_email'] == 1 ? true : false;
            }
          }
        }
        //Set the verified flag to true
        var index = /[a-z]*\d?emailAddress(\d+)/i.exec(target)[1];

        var verifyElementFlag = $('#' + this.id + 'emailAddressVerifiedFlag' + index);

        if (verifyElementFlag.parentNode.childNodes.length > 1) {
          verifyElementFlag.parentNode.removeChild(verifyElementFlag.parentNode.lastChild);
        }

        var verifiedTextNode = document.createElement('span');
        verifiedTextNode.innerHTML = '';
        verifyElementFlag.parentNode.appendChild(verifiedTextNode);
        verifyElementFlag.value = "true";
        this.verifyElementValue = $('#' +this.id + 'emailAddressVerifiedValue' + index);
        this.verifyElementValue.value = $('#' +this.id + 'emailAddress' + index).value;
        this.verifying = false;

        // If Enter key or Save button was pressed then we proceed to attempt a form submission
        var savePressed = false;
        if (event) {
          var elm = document.activeElement || event.explicitOriginalTarget;
          if (typeof elm.type != 'undefined' && /submit|button/.test(elm.type.toLowerCase())) {
            //if we are in here, then the element has been recognized as a button or submit type, so check the id
            //to make sure it is related to a submit button that should lead to a form submit

            //note that the document.activeElement and explicitOriginalTarget calls do not work consistantly across
            // all browsers, so we have to include this check after we are sure that the calls returned something as opposed to in the coindition above.
            // Also, since this function is called on blur of the email widget, we can't rely on a third object as a flag (a var or hidden form input)
            // since this function will fire off before the click event from a button is executed, which means the 3rd object will not get updated prior to this function running.
            if (/save|full|cancel|change/.test(elm.value.toLowerCase())) {
              //this is coming from either a save, full form, cancel, or view change log button, we should set savePressed = true;
              savePressed = true;
            }
          }
        }


        if (savePressed || this.enterPressed) {
          setTimeout("SUGAR.EmailAddressWidget.instances." + this.id + ".forceSubmit()", 2100);
        } else if (this.tabPressed) {
          $('#' +this.id + 'emailAddressPrimaryFlag' + index).focus();
        }
      }

      var event = this.getEvent(event);
      var targetEl = this.getEventElement(event);
      var index = /[a-z]*\d?emailAddress(\d+)/i.exec(targetEl.id)[1];
      var verifyElementFlag = $('#' +this.id + 'emailAddressVerifiedFlag' + index);

      if (this.verifyElementValue == null || typeof(this.verifyElementValue) == 'undefined') {
        //we can't do anything without this value, so just return
        return false;
      }

      this.verifyElementValue = $('#' +this.id + 'emailAddressVerifiedValue' + index);
      verifyElementFlag.value = (trim(targetEl.value) == '' || targetEl.value == this.verifyElementValue.value) ? "true" : "false"

      //Remove the span element if it is present
      if (verifyElementFlag.parentNode.childNodes.length > 1) {
        verifyElementFlag.parentNode.removeChild(verifyElementFlag.parentNode.lastChild);
      }

      if (/emailAddress\d+$/.test(targetEl.id) && isValidEmail(targetEl.value) && !this.verifying && verifyElementFlag.value == "false") {
        verifiedTextNode = document.createElement('span');
        verifyElementFlag.parentNode.appendChild(verifiedTextNode);
        verifiedTextNode.innerHTML = SUGAR.language.get('app_strings', 'LBL_VERIFY_EMAIL_ADDRESS');
        this.verifying = true;
        var cObj = jQuery.get('index.php?module=Contacts&action=RetrieveEmail&target=' + targetEl.id + '&email=' + targetEl.value)
          .done(callbackFunction)
          .fail(callbackFunction);
      }
    },

    handleKeyDown: function (event) {
      var e = this.getEvent(event);
      var eL = this.getEventElement(e);
      if ((kc = e["keyCode"])) {
        this.enterPressed = (kc == 13) ? true : false;
        this.tabPressed = (kc == 9) ? true : false;

        if (this.enterPressed || this.tabPressed) {
          this.retrieveEmailAddress(e);
          if (this.enterPressed)
            this.freezeEvent(e);
        }
      }
    }, //handleKeyDown()

    getEvent: function (event) {
      return (event ? event : window.event);
    },//getEvent

    getEventElement: function (e) {
      return (e.srcElement ? e.srcElement : (e.target ? e.target : e.currentTarget));
    },//getEventElement

    freezeEvent: function (e) {
      if (e.preventDefault) e.preventDefault();
      e.returnValue = false;
      e.cancelBubble = true;
      if (e.stopPropagation) e.stopPropagation();
      return false;
    },//freezeEvent

    addEmailAddress: function (tableId, address, primaryFlag, replyToFlag, optOutFlag, invalidFlag, emailId) {
      if (this.addInProgress) {
        return;
      }

      this.addInProgress = true;

      if (!address) {
        address = "";
      }


      // TODO Remove
      console.log(this);
      console.log(tableId, address, primaryFlag, replyToFlag, optOutFlag, invalidFlag, emailId);

      var lineContainer = $('.template.email-address-line-container').clone();
      lineContainer.removeClass('template');
      lineContainer.removeClass('hidden');

      lineContainer.find('email-address-remove-button').click(function() {
        SUGAR.EmailAddressWidget.removeEmailAddress(0);
      })


      $(lineContainer).appendTo('.email-address-lines-container');

      // Add validation to field
      this.EmailAddressValidation(this.emailView, this.id + 'emailAddress' + this.totalEmailAddresses, this.emailIsRequired, SUGAR.language.get('app_strings', 'LBL_EMAIL_ADDRESS_BOOK_EMAIL_ADDR'));
      this.totalEmailAddresses += 1;
      this.addInProgress = false;
    }, //addEmailAddress

    EmailAddressValidation: function (ev, fn, r, stR) {
      $(document).ready(function() {
        addToValidate(ev, fn, 'email', r, stR);
      });
    },

    removeEmailAddress: function (index) {
      removeFromValidate(this.emailView, this.id + 'emailAddress' + index);
      var oNodeToRemove = $('#' +this.id + 'emailAddressRow' + index);
      // var form = Dom.getAncestorByTagName(oNodeToRemove, "form");
      var form = $(this).closest("form");
      oNodeToRemove.parentNode.removeChild(oNodeToRemove);

      var removedIndex = parseInt(index);
      //If we are not deleting the last email address, we need to shift the numbering to fill the gap
      if (this.totalEmailAddresses != removedIndex) {
        for (var x = removedIndex + 1; x < this.totalEmailAddresses; x++) {
          $('#' +this.id + 'emailAddress' + x).setAttribute("name", this.id + "emailAddress" + (x - 1));
          $('#' +this.id + 'emailAddress' + x).setAttribute("id", this.id + "emailAddress" + (x - 1));

          if ($('#' +this.id + 'emailAddressInvalidFlag' + x)) {
            $('#' +this.id + 'emailAddressInvalidFlag' + x).setAttribute("value", this.id + "emailAddress" + (x - 1));
            $('#' +this.id + 'emailAddressInvalidFlag' + x).setAttribute("id", this.id + "emailAddressInvalidFlag" + (x - 1));
          }

          if ($('#' +this.id + 'emailAddressOptOutFlag' + x)) {
            $('#' +this.id + 'emailAddressOptOutFlag' + x).setAttribute("value", this.id + "emailAddress" + (x - 1));
            $('#' +this.id + 'emailAddressOptOutFlag' + x).setAttribute("id", this.id + "emailAddressOptOutFlag" + (x - 1));
          }

          if ($('#' +this.id + 'emailAddressPrimaryFlag' + x)) {
            $('#' +this.id + 'emailAddressPrimaryFlag' + x).setAttribute("id", this.id + "emailAddressPrimaryFlag" + (x - 1));
          }

          $('#' +this.id + 'emailAddressVerifiedValue' + x).setAttribute("id", this.id + "emailAddressVerifiedValue" + (x - 1));
          $('#' +this.id + 'emailAddressVerifiedFlag' + x).setAttribute("id", this.id + "emailAddressVerifiedFlag" + (x - 1));

          var rButton = $('#' +this.id + 'removeButton' + x);
          rButton.setAttribute("name", (x - 1));
          rButton.setAttribute("id", this.id + "removeButton" + (x - 1));
          $('#' +this.id + 'emailAddressRow' + x).setAttribute("id", this.id + 'emailAddressRow' + (x - 1));
        }
      }

      this.totalEmailAddresses--;


      // CL Fix for 17651
      if (this.totalEmailAddresses == 0) {
        return;
      }

      var primaryFound = false;
      for (x = 0; x < this.totalEmailAddresses; x++) {
        if ($('#' +this.id + 'emailAddressPrimaryFlag' + x).checked) {
          primaryFound = true;
        }
      }

      if (!primaryFound) {
        $('#' +this.id + 'emailAddressPrimaryFlag0').checked = true;
        $('#' +this.id + 'emailAddressPrimaryFlag0').value = this.id + 'emailAddress0';
      }

    },

    toggleCheckbox: function (el) {
      var form = document.forms[this.emailView];
      if (!form) {
        form = document.forms['editContactForm'];
      }

      if (this.isIE()) {
        for (var i = 0; i < form.elements.length; i++) {
          var id = new String(form.elements[i].id);
          if (id.match(/emailAddressInvalidFlag/gim) && form.elements[i].type == 'checkbox' && id != el.id) {
            form.elements[i].checked = false;
          }
        }

        el.checked = true;
      }
    },

    forceSubmit: function () {
      var theForm = $('#' +this.emailView);
      if (theForm) {
        theForm.action.value = 'Save';
        if (!check_form(this.emailView)) {
          return false;
        }
        if (this.emailView == 'EditView') {
          //this is coming from regular edit view form
          theForm.submit();
        } else if (this.emailView.indexOf('DCQuickCreate') > 0) {
          //this is coming from the DC Quick Create Tool Bar, so call save on form
          DCMenu.save(theForm.id);
        } else if (this.emailView.indexOf('QuickCreate') >= 0) {
          //this is a subpanel create or edit form
          SUGAR.subpanelUtils.inlineSave(theForm.id, theForm.module.value + '_subpanel_save_button');
        }
      }
    } //forceSubmit
  };
  emailAddressWidgetLoaded = true;
})();
