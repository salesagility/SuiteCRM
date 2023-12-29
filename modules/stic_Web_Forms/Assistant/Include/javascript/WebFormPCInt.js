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
 * File for the unconditional validation of bank accounts, for use when the CRM Setting GENERAL_IBAN_VALIDATION is set to 0 at the time of generating the form.
 * @returns {Boolean}
 */
function validateIBAN() {
  // If the type of payment is not direct debit, the IBAN must not be validated
  if (document.getElementById("stic_Payment_Commitments___payment_method").value == "direct_debit") {
    var bankAccount = document.getElementById("stic_Payment_Commitments___bank_account");
    bankAccount.value = bankAccount.value.toUpperCase();
    if (bankAccount == null) {
      // If there is no account number it will give error
      return false;
    }
  }
  return true;
}
