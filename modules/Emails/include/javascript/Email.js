/**
 * Represents email data
 * @constructor
 */
var Email = function() {
  "use strict";
  var self = this;

  self.bcc = '';
  self.body = '';
  self.cc = '';
  self.from = '';
  self.subject = '';
  self.to = '';

  /**
   * Create Email from form using a css selector
   * @param selector string - eg .classname or #id
   */
  self.fromSelector = function (selector) {
    self.bcc  = $(selector + ' [name=bcc_addrs_names]').val();
    self.body = $(selector + ' [name=description]').val();
    self.cc   = $(selector + ' [name=cc_addrs_names]').val();
    self.from   = $(selector + ' [name=from_addrs_names]').val();
    self.subject   = $(selector + ' [name=name]').val();
    self.to   = $(selector + ' [name=to_addrs_names]').val();
  };

};

/**
 * Create Email from form using a css selector
 * @param selector string - eg .classname or #id
 */
Email.prototype.fromSelector = function(selector) {
  var email = new Email();
  email.fromSelector(selector);
  return email;
};