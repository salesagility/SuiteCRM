SEPA Direct Debit (SDD) XML Generator
====================================

### How to use?

See *index.php* for an example how to create a SEPA message. 
  * Set the namespace according to your requirements. By default, the message scheme for Germany (`pain.008.003.02`) is set.<br>
  For Austria you would have to change it to `ISO:pain.008.001.02:APC:STUZZA:payments:003`<br>
  Instead if you want the EPC standard, set `urn:iso:std:iso:20022:tech:xsd:pain.008.001.02`
  * Note that the `SEPAGroupHeader` must exist only once per message.
  * Per message you can include multiple `SEPAPaymentInfo` blocks (e.g. one per debit sequence type).
  * Per `SEPAPaymentInfo` block multiple transactions `SEPADirectDebitTransaction` may be added.
  * It is possible to validate a message against a XSD scheme prior to generating a XML file. Therefore, have a look at the 
  commented statement near the end of *index.php*.

### What is this?

The Single Euro Payments Area (SEPA) is a payment-integration initiative of the European Union for simplification of bank transfers denominated in euro.
Based on your input data, this script faciliates the process of generating a SEPA compliant XML file for direct debit.

---

#### LICENSE

![CC BY-NC](http://i.creativecommons.org/l/by-nc/3.0/88x31.png)

This work is licensed under the Creative Commons Attribution-NonCommercial 3.0 License. To view a copy of this license, visit http://creativecommons.org/licenses/by-nc/3.0/.
For commercial use please contact sales@web-wack.at