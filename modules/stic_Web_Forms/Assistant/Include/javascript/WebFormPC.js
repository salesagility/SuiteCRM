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
 * Library Code https://github.com/arhs/iban.js
 */
(function(root, factory) {
  if (typeof define === "function" && define.amd) {
    // AMD. Register as an anonymous module.
    define(["exports"], factory);
  } else if (typeof exports === "object" && typeof exports.nodeName !== "string") {
    // CommonJS
    factory(exports);
  } else {
    // Browser globals
    factory((root.IBAN = {}));
  }
})(this, function(exports) {
  // Array.prototype.map polyfill
  // Code from https://developer.mozilla.org/en-US/docs/JavaScript/Reference/Global_Objects/Array/map
  if (!Array.prototype.map) {
    Array.prototype.map = function(fun /*, thisArg */) {
      "use strict";
      if (this === void 0 || this === null) {
        throw new TypeError();
      }

      var t = Object(this);
      var len = t.length >>> 0;
      if (typeof fun !== "function") {
        throw new TypeError();
      }

      var res = new Array(len);
      var thisArg = arguments.length >= 2 ? arguments[1] : void 0;
      for (var i = 0; i < len; i++) {
        /* 
          STIC NOTE: Absolute correctness would demand Object.defineProperty be used.  But this method is fairly new, and failure is possible only 
          if Object.prototype or Array.prototype has a property |i| (very unlikely), so use a less-correct but more portable alternative.
        */
        if (i in t) {
          res[i] = fun.call(thisArg, t[i], i, t);
        }
      }
      return res;
    };
  }

  var A = "A".charCodeAt(0),
    Z = "Z".charCodeAt(0);

  /**
   * Prepare an IBAN for mod 97 computation by moving the first 4 chars to the end and transforming the letters to numbers (A = 10, B = 11,   .., Z = 35), as specified in ISO13616.
   *
   * @param {string} iban the IBAN
   * @returns {string} the prepared IBAN
   */
  function iso13616Prepare(iban) {
    iban = iban.toUpperCase();
    iban = iban.substr(4) + iban.substr(0, 4);
    return iban
      .split("")
      .map(function(n) {
        var code = n.charCodeAt(0);
        if (code >= A && code <= Z) {
          // A = 10, B = 11, ... Z = 35
          return code - A + 10;
        } else {
          return n;
        }
      })
      .join("");
  }

  /**
   * Calculates the MOD 97 10 of the passed IBAN as specified in ISO7064.
   *
   * @param iban
   * @returns {number}
   */
  function iso7064Mod97_10(iban) {
    var remainder = iban,
      block;

    while (remainder.length > 2) {
      block = remainder.slice(0, 9);
      remainder = (parseInt(block, 10) % 97) + remainder.slice(block.length);
    }

    return parseInt(remainder, 10) % 97;
  }

  /**
   * Parse the BBAN structure used to configure each IBAN Specification and returns a matching regular expression.
   * A structure is composed of blocks of 3 characters (one letter and 2 digits). Each block represents
   * a logical group in the typical representation of the BBAN. For each group, the letter indicates which characters
   * are allowed in this group and the following 2-digits number tells the length of the group.
   *
   * @param {string} structure the structure to parse
   * @returns {RegExp}
   */
  function parseStructure(structure) {
    // split in blocks of 3 chars
    var regex = structure.match(/(.{3})/g).map(function(block) {
      // parse each structure block (1-char + 2-digits)
      var format,
        pattern = block.slice(0, 1),
        repeats = parseInt(block.slice(1), 10);

      switch (pattern) {
        case "A":
          format = "0-9A-Za-z";
          break;
        case "B":
          format = "0-9A-Z";
          break;
        case "C":
          format = "A-Za-z";
          break;
        case "F":
          format = "0-9";
          break;
        case "L":
          format = "a-z";
          break;
        case "U":
          format = "A-Z";
          break;
        case "W":
          format = "0-9a-z";
          break;
      }
      return "([" + format + "]{" + repeats + "})";
    });
    return new RegExp("^" + regex.join("") + "$");
  }

  /**
   * @param iban
   * @returns {string}
   */
  function electronicFormat(iban) {
    return iban.replace(NON_ALPHANUM, "").toUpperCase();
  }

  /**
   * Create a new Specification for a valid IBAN number.
   *
   * @param countryCode the code of the country
   * @param length the length of the IBAN
   * @param structure the structure of the underlying BBAN (for validation and formatting)
   * @param example an example valid IBAN
   * @constructor
   */
  function Specification(countryCode, length, structure, example) {
    this.countryCode = countryCode;
    this.length = length;
    this.structure = structure;
    this.example = example;
  }

  /**
   * Lazy-loaded regex (parse the structure and construct the regular expression the first time we need it for validation)
   */
  Specification.prototype._regex = function() {
    return this._cachedRegex || (this._cachedRegex = parseStructure(this.structure));
  };

  /**
   * Check if the passed iban is valid according to this specification.
   *
   * @param {String} iban the iban to validate
   * @returns {boolean} true if valid, false otherwise
   */
  Specification.prototype.isValid = function(iban) {
    return this.length == iban.length && this.countryCode === iban.slice(0, 2) && this._regex().test(iban.slice(4)) && iso7064Mod97_10(iso13616Prepare(iban)) == 1;
  };

  /**
   * Convert the passed IBAN to a country-specific BBAN.
   *
   * @param iban the IBAN to convert
   * @param separator the separator to use between BBAN blocks
   * @returns {string} the BBAN
   */
  Specification.prototype.toBBAN = function(iban, separator) {
    return this._regex()
      .exec(iban.slice(4))
      .slice(1)
      .join(separator);
  };

  /**
   * Convert the passed BBAN to an IBAN for this country specification.
   * Please note that <i>"generation of the IBAN shall be the exclusive responsibility of the bank/branch servicing the account"</i>.
   * This method implements the preferred algorithm described in http://en.wikipedia.org/wiki/International_Bank_Account_Number#Generating_IBAN_check_digits
   *
   * @param bban the BBAN to convert to IBAN
   * @returns {string} the IBAN
   */
  Specification.prototype.fromBBAN = function(bban) {
    if (!this.isValidBBAN(bban)) {
      throw new Error("Invalid BBAN");
    }
    var remainder = iso7064Mod97_10(iso13616Prepare(this.countryCode + "00" + bban)),
      checkDigit = ("0" + (98 - remainder)).slice(-2);

    return this.countryCode + checkDigit + bban;
  };

  /**
   * Check of the passed BBAN is valid.
   * This function only checks the format of the BBAN (length and matching the letetr/number specs) but does not
   * verify the check digit.
   *
   * @param bban the BBAN to validate
   * @returns {boolean} true if the passed bban is a valid BBAN according to this specification, false otherwise
   */
  Specification.prototype.isValidBBAN = function(bban) {
    return this.length - 4 == bban.length && this._regex().test(bban);
  };

  var countries = {};
  function addSpecification(IBAN) {
    countries[IBAN.countryCode] = IBAN;
  }

  addSpecification(new Specification("AD", 24, "F04F04A12", "AD1200012030200359100100"));
  addSpecification(new Specification("AE", 23, "F03F16", "AE070331234567890123456"));
  addSpecification(new Specification("AL", 28, "F08A16", "AL47212110090000000235698741"));
  addSpecification(new Specification("AT", 20, "F05F11", "AT611904300234573201"));
  addSpecification(new Specification("AZ", 28, "U04A20", "AZ21NABZ00000000137010001944"));
  addSpecification(new Specification("BA", 20, "F03F03F08F02", "BA391290079401028494"));
  addSpecification(new Specification("BE", 16, "F03F07F02", "BE68539007547034"));
  addSpecification(new Specification("BG", 22, "U04F04F02A08", "BG80BNBG96611020345678"));
  addSpecification(new Specification("BH", 22, "U04A14", "BH67BMAG00001299123456"));
  addSpecification(new Specification("BR", 29, "F08F05F10U01A01", "BR9700360305000010009795493P1"));
  addSpecification(new Specification("BY", 28, "A04F04A16", "BY13NBRB3600900000002Z00AB00"));
  addSpecification(new Specification("CH", 21, "F05A12", "CH9300762011623852957"));
  addSpecification(new Specification("CR", 22, "F04F14", "CR72012300000171549015"));
  addSpecification(new Specification("CY", 28, "F03F05A16", "CY17002001280000001200527600"));
  addSpecification(new Specification("CZ", 24, "F04F06F10", "CZ6508000000192000145399"));
  addSpecification(new Specification("DE", 22, "F08F10", "DE89370400440532013000"));
  addSpecification(new Specification("DK", 18, "F04F09F01", "DK5000400440116243"));
  addSpecification(new Specification("DO", 28, "U04F20", "DO28BAGR00000001212453611324"));
  addSpecification(new Specification("EE", 20, "F02F02F11F01", "EE382200221020145685"));
  addSpecification(new Specification("ES", 24, "F04F04F01F01F10", "ES9121000418450200051332"));
  addSpecification(new Specification("FI", 18, "F06F07F01", "FI2112345600000785"));
  addSpecification(new Specification("FO", 18, "F04F09F01", "FO6264600001631634"));
  addSpecification(new Specification("FR", 27, "F05F05A11F02", "FR1420041010050500013M02606"));
  addSpecification(new Specification("GB", 22, "U04F06F08", "GB29NWBK60161331926819"));
  addSpecification(new Specification("GE", 22, "U02F16", "GE29NB0000000101904917"));
  addSpecification(new Specification("GI", 23, "U04A15", "GI75NWBK000000007099453"));
  addSpecification(new Specification("GL", 18, "F04F09F01", "GL8964710001000206"));
  addSpecification(new Specification("GR", 27, "F03F04A16", "GR1601101250000000012300695"));
  addSpecification(new Specification("GT", 28, "A04A20", "GT82TRAJ01020000001210029690"));
  addSpecification(new Specification("HR", 21, "F07F10", "HR1210010051863000160"));
  addSpecification(new Specification("HU", 28, "F03F04F01F15F01", "HU42117730161111101800000000"));
  addSpecification(new Specification("IE", 22, "U04F06F08", "IE29AIBK93115212345678"));
  addSpecification(new Specification("IL", 23, "F03F03F13", "IL620108000000099999999"));
  addSpecification(new Specification("IS", 26, "F04F02F06F10", "IS140159260076545510730339"));
  addSpecification(new Specification("IT", 27, "U01F05F05A12", "IT60X0542811101000000123456"));
  addSpecification(new Specification("IQ", 23, "U04F03A12", "IQ98NBIQ850123456789012"));
  addSpecification(new Specification("JO", 30, "A04F22", "JO15AAAA1234567890123456789012"));
  addSpecification(new Specification("KW", 30, "U04A22", "KW81CBKU0000000000001234560101"));
  addSpecification(new Specification("KZ", 20, "F03A13", "KZ86125KZT5004100100"));
  addSpecification(new Specification("LB", 28, "F04A20", "LB62099900000001001901229114"));
  addSpecification(new Specification("LC", 32, "U04F24", "LC07HEMM000100010012001200013015"));
  addSpecification(new Specification("LI", 21, "F05A12", "LI21088100002324013AA"));
  addSpecification(new Specification("LT", 20, "F05F11", "LT121000011101001000"));
  addSpecification(new Specification("LU", 20, "F03A13", "LU280019400644750000"));
  addSpecification(new Specification("LV", 21, "U04A13", "LV80BANK0000435195001"));
  addSpecification(new Specification("MC", 27, "F05F05A11F02", "MC5811222000010123456789030"));
  addSpecification(new Specification("MD", 24, "U02A18", "MD24AG000225100013104168"));
  addSpecification(new Specification("ME", 22, "F03F13F02", "ME25505000012345678951"));
  addSpecification(new Specification("MK", 19, "F03A10F02", "MK07250120000058984"));
  addSpecification(new Specification("MR", 27, "F05F05F11F02", "MR1300020001010000123456753"));
  addSpecification(new Specification("MT", 31, "U04F05A18", "MT84MALT011000012345MTLCAST001S"));
  addSpecification(new Specification("MU", 30, "U04F02F02F12F03U03", "MU17BOMM0101101030300200000MUR"));
  addSpecification(new Specification("NL", 18, "U04F10", "NL91ABNA0417164300"));
  addSpecification(new Specification("NO", 15, "F04F06F01", "NO9386011117947"));
  addSpecification(new Specification("PK", 24, "U04A16", "PK36SCBL0000001123456702"));
  addSpecification(new Specification("PL", 28, "F08F16", "PL61109010140000071219812874"));
  addSpecification(new Specification("PS", 29, "U04A21", "PS92PALS000000000400123456702"));
  addSpecification(new Specification("PT", 25, "F04F04F11F02", "PT50000201231234567890154"));
  addSpecification(new Specification("QA", 29, "U04A21", "QA30AAAA123456789012345678901"));
  addSpecification(new Specification("RO", 24, "U04A16", "RO49AAAA1B31007593840000"));
  addSpecification(new Specification("RS", 22, "F03F13F02", "RS35260005601001611379"));
  addSpecification(new Specification("SA", 24, "F02A18", "SA0380000000608010167519"));
  addSpecification(new Specification("SC", 31, "U04F04F16U03", "SC18SSCB11010000000000001497USD"));
  addSpecification(new Specification("SE", 24, "F03F16F01", "SE4550000000058398257466"));
  addSpecification(new Specification("SI", 19, "F05F08F02", "SI56263300012039086"));
  addSpecification(new Specification("SK", 24, "F04F06F10", "SK3112000000198742637541"));
  addSpecification(new Specification("SM", 27, "U01F05F05A12", "SM86U0322509800000000270100"));
  addSpecification(new Specification("ST", 25, "F08F11F02", "ST68000100010051845310112"));
  addSpecification(new Specification("SV", 28, "U04F20", "SV62CENR00000000000000700025"));
  addSpecification(new Specification("TL", 23, "F03F14F02", "TL380080012345678910157"));
  addSpecification(new Specification("TN", 24, "F02F03F13F02", "TN5910006035183598478831"));
  addSpecification(new Specification("TR", 26, "F05F01A16", "TR330006100519786457841326"));
  addSpecification(new Specification("UA", 29, "F25", "UA511234567890123456789012345"));
  addSpecification(new Specification("VG", 24, "U04F16", "VG96VPVG0000012345678901"));
  addSpecification(new Specification("XK", 20, "F04F10F02", "XK051212012345678906"));
  // The following countries are not included in the official IBAN registry but use the IBAN specification
  // Angola
  addSpecification(new Specification("AO", 25, "F21", "AO69123456789012345678901"));
  // Burkina
  addSpecification(new Specification("BF", 27, "F23", "BF2312345678901234567890123"));
  // Burundi
  addSpecification(new Specification("BI", 16, "F12", "BI41123456789012"));
  // Benin
  addSpecification(new Specification("BJ", 28, "F24", "BJ39123456789012345678901234"));
  // Ivory
  addSpecification(new Specification("CI", 28, "U01F23", "CI17A12345678901234567890123"));
  // Cameron
  addSpecification(new Specification("CM", 27, "F23", "CM9012345678901234567890123"));
  // Cape Verde
  addSpecification(new Specification("CV", 25, "F21", "CV30123456789012345678901"));
  // Algeria
  addSpecification(new Specification("DZ", 24, "F20", "DZ8612345678901234567890"));
  // Iran
  addSpecification(new Specification("IR", 26, "F22", "IR861234568790123456789012"));
  // Madagascar
  addSpecification(new Specification("MG", 27, "F23", "MG1812345678901234567890123"));
  // Mali
  addSpecification(new Specification("ML", 28, "U01F23", "ML15A12345678901234567890123"));
  // Mozambique
  addSpecification(new Specification("MZ", 25, "F21", "MZ25123456789012345678901"));
  // Senegal
  addSpecification(new Specification("SN", 28, "U01F23", "SN52A12345678901234567890123"));

  var NON_ALPHANUM = /[^a-zA-Z0-9]/g,
    EVERY_FOUR_CHARS = /(.{4})(?!$)/g;

  /**
   * Utility function to check if a variable is a String.
   *
   * @param v
   * @returns {boolean} true if the passed variable is a String, false otherwise.
   */
  function isString(v) {
    return typeof v == "string" || v instanceof String;
  }

  /**
   * Check if an IBAN is valid.
   *
   * @param {String} iban the IBAN to validate.
   * @returns {boolean} true if the passed IBAN is valid, false otherwise
   */
  exports.isValid = function(iban) {
    if (!isString(iban)) {
      return false;
    }
    iban = electronicFormat(iban);
    var countryStructure = countries[iban.slice(0, 2)];
    return !!countryStructure && countryStructure.isValid(iban);
  };

  /**
   * Convert an IBAN to a BBAN.
   *
   * @param iban
   * @param {String} [separator] the separator to use between the blocks of the BBAN, defaults to ' '
   * @returns {string|*}
   */
  exports.toBBAN = function(iban, separator) {
    if (typeof separator == "undefined") {
      separator = " ";
    }

    iban = electronicFormat(iban);
    var countryStructure = countries[iban.slice(0, 2)];
    if (!countryStructure) {
      throw new Error("No country with code " + iban.slice(0, 2));
    }

    return countryStructure.toBBAN(iban, separator);
  };

  /**
   * Convert the passed BBAN to an IBAN for this country specification.
   * Please note that <i>"generation of the IBAN shall be the exclusive responsibility of the bank/branch servicing the account"</i>.
   * This method implements the preferred algorithm described in http://en.wikipedia.org/wiki/International_Bank_Account_Number#Generating_IBAN_check_digits
   *
   * @param countryCode the country of the BBAN
   * @param bban the BBAN to convert to IBAN
   * @returns {string} the IBAN
   */
  exports.fromBBAN = function(countryCode, bban) {
    var countryStructure = countries[countryCode];
    if (!countryStructure) {
      throw new Error("No country with code " + countryCode);
    }
    return countryStructure.fromBBAN(electronicFormat(bban));
  };

  /**
   * Check the validity of the passed BBAN.
   *
   * @param countryCode the country of the BBAN
   * @param bban the BBAN to check the validity of
   */
  exports.isValidBBAN = function(countryCode, bban) {
    if (!isString(bban)) {
      return false;
    }
    var countryStructure = countries[countryCode];
    return countryStructure && countryStructure.isValidBBAN(electronicFormat(bban));
  };

  /**
   *
   * @param iban
   * @param separator
   * @returns {string}
   */
  exports.printFormat = function(iban, separator) {
    if (typeof separator == "undefined") {
      separator = " ";
    }
    return electronicFormat(iban).replace(EVERY_FOUR_CHARS, "$1" + separator);
  };
  exports.electronicFormat = electronicFormat;

  /**
   * An object containing all the known IBAN specifications.
   */
  exports.countries = countries;
});

/**
 * Validate IBAN
 * @returns {Boolean}
 */
function validateIBAN() {
  // v2018
  // If the payment method is not direct debit, the IBAN must not be validated
  if (document.getElementById("stic_Payment_Commitments___payment_method").value == "direct_debit") {
    var bankAccount = document.getElementById("stic_Payment_Commitments___bank_account");
    bankAccount.value = bankAccount.value.toUpperCase();
    if (bankAccount == null) {
      // If there is no account number it will give error
      return false;
    } else {
      if (!IBAN.isValid(bankAccount.value)) {
        alert(stic_Payment_Commitments_LBL_IBAN_NOT_VALID);
        selectTextInput(bankAccount);
        return false;
      }
    }
  }
  return true;
}
