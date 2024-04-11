/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
/**
 * Overload the data validation function to include the validation of the payment methods fields
 * @returns {String}
 */
(function () {
  var tmpCheckFields = checkFields;
  checkFields = function () {
    if (tmpCheckFields) {
      return tmpCheckFields() && validateIBAN();
    }
    return validateIBAN();
  };
})();


// Set variables for manage recurring payment validations
var oP = document.getElementById('allow_paypal_recurring_payments');
var allowPaypalRecurringPayments = oP && oP.value == 1 ? 1 : 0;
var oC = document.getElementById('allow_card_recurring_payments');
var allowCardRecurringPayments = oC && oC.value == 1 ? 1 : 0;
var oS = document.getElementById('allow_stripe_recurring_payments');
var allowStripeRecurringPayments = oS && oS.value == 1 ? 1 : 0;

/**
 * Adapt the form based on the periodicity value
 */
function adaptPeriodicity() {
  var oPeriodicity = document.getElementById("stic_Payment_Commitments___periodicity"); // Retrieve the html element from periodicity
  var vPeriodicity = oPeriodicity.options[oPeriodicity.selectedIndex].value;
  var oPaymentMethod = document.getElementById("stic_Payment_Commitments___payment_method"); // Retrieve the html element of payment method
  var vPaymentMethod = oPaymentMethod.options[oPaymentMethod.selectedIndex].value;

  // If the periodicity has a value and is not punctual mark the means of payment as 'Direct debit'
  if (vPeriodicity && vPeriodicity != "punctual" && (
      (vPaymentMethod == "card" && allowCardRecurringPayments == 0) || 
      (vPaymentMethod == "ceca_card" && allowCardRecurringPayments == 0) || 
      (vPaymentMethod == "paypal" && allowPaypalRecurringPayments == 0) || 
      (vPaymentMethod == "stripe" && allowStripeRecurringPayments == 0) || 
       vPaymentMethod == "bizum")) {
    if (confirm(stic_Payment_Commitments_LBL_PAYMENT_TYPE_PUNCTUAL)) {
      setSelectValue(oPaymentMethod, "direct_debit");
      adaptPaymentMethod();
    } else {
      setSelectValue(oPeriodicity, oPeriodicity.prev_value);
      return false;
    }
  }
  oPeriodicity.prev_value = vPeriodicity;
}

/**
* Adapt the form based on the value of the payment method
*/

function adaptPaymentMethod() {

  var oPaymentMethod = document.getElementById("stic_Payment_Commitments___payment_method"); // Retrieve the html element of payment method
  var vPaymentMethod = oPaymentMethod.options[oPaymentMethod.selectedIndex].value;
  var oPeriodicity = document.getElementById("stic_Payment_Commitments___periodicity"); // Retrieve the html element of periodicity
  var vPeriodicity = oPeriodicity.options[oPeriodicity.selectedIndex].value;

  // If the payment method has changed to card or bizum, check the periodicity
  if (((vPaymentMethod == "card" && allowCardRecurringPayments == 0)
    || (vPaymentMethod == "ceca_card" && allowPaypalRecurringPayments == 0)
    || (vPaymentMethod == "paypal" && allowPaypalRecurringPayments == 0)
    || (vPaymentMethod == "stripe" && allowStripeRecurringPayments == 0)
    || vPaymentMethod == "bizum")
    && vPeriodicity && vPeriodicity != "punctual") {
    if (confirm(stic_Payment_Commitments_LBL_PERIODICITY_PUNCTUAL)) {
      // If you want to continue, punctual periodicity is indicated
      setSelectValue(oPeriodicity, "punctual");
    } else {
      setSelectValue(oPaymentMethod, oPaymentMethod.prev_value);
      return false;
    }
  }

  // If the payment method is a direct debit, it shows the account number field and marks it as required.
  if (vPaymentMethod == "direct_debit") {
    showField("stic_Payment_Commitments___bank_account");
    addRequired("stic_Payment_Commitments___bank_account");
  } else {
    hideField("stic_Payment_Commitments___bank_account");
    removeRequired("stic_Payment_Commitments___bank_account");
  }
  oPaymentMethod.prev_value = vPaymentMethod;
}
