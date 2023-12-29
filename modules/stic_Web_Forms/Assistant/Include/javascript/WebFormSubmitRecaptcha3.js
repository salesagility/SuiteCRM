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
var formHasAlreadyBeenSent = false;
/**
 * Form submission function
 * @param form form to be sent
 */
function submitForm(form) {
  grecaptcha.execute('<SITE_KEY>', {}).then(function (token) {
    // Agregamos el token al campo del formulario
    const recaptchaInput = document.createElement("input");
    recaptchaInput.type = "hidden";
    recaptchaInput.name = "g-recaptcha-response";
    recaptchaInput.value = token;
    recaptchaForm = document.querySelector("#WebToLeadForm");
    recaptchaForm.appendChild(recaptchaInput);

    if (checkFields() && checkFormSize()) {
      if (typeof validateCaptchaAndSubmit != "undefined") {
        validateCaptchaAndSubmit();
      } else {
        if (formHasAlreadyBeenSent != true) {
          formHasAlreadyBeenSent = true;
          form.submit();
        } else {
          console.log("Form is locked because it has already been sent.");
        }
      }
    }
  });
  return false;
}