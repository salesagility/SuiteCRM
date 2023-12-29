<?php
/**
 * Example construction of a SEPA direct debit (SDD) message in XML format.
 *
 * @author     Johannes Feichtner <johannes@web-wack.at>
 * @copyright  http://www.web-wack.at web wack creations
 * @license    http://creativecommons.org/licenses/by-nc/3.0/ CC Attribution-NonCommercial 3.0 license
 * For commercial use please contact sales@web-wack.at
 */

require_once('class.SEPADirectDebitTransaction.php');
require_once('class.SEPAException.php');
require_once('class.SEPAGroupHeader.php');
require_once('class.SEPAMessage.php');
require_once('class.SEPAPaymentInfo.php');
require_once('class.URLify.php');

$message = new SEPAMessage('urn:iso:std:iso:20022:tech:xsd:pain.008.003.02');
$groupHeader = new SEPAGroupHeader(); // (1..1)
$groupHeader->setMessageIdentification('SEPA-'.time()); // Unique ID for this job
$groupHeader->setInitiatingPartyName('Web wack creations'); // Name of the party sending the job. Usually the creditor
$message->setGroupHeader($groupHeader);

$paymentInfo = new SEPAPaymentInfo(); // (1..n)
$paymentInfo->setPaymentInformationIdentification(1); // Your own unique identifier for this batch
$paymentInfo->setBatchBooking('false');
$paymentInfo->setLocalInstrumentCode('CORE'); // Other options: COR1, B2B
// Type of the job and execution date
$paymentInfo->setSequenceType('RCUR');
// CORE: FRST: +6 days, RCUR: +3 days, FNAL: +3 days, OOFF: +6 days
// B2B: All +2 days
$paymentInfo->setRequestedCollectionDate(date('Y-m-d', strtotime('+3 days')));
// Account on which payment should be recieved
$paymentInfo->setCreditorName('Your creditor name');
$paymentInfo->setCreditorAccountIBAN('ES5121000900920211405107');
$paymentInfo->setCreditorAgentBIC('PBNKDEFF760');
//$paymentInfo->setCreditorSchemeIdentification('DE22ZZZ00000012345');

$transaction = new SEPADirectDebitTransaction(); // (1..n)
$transaction->setEndToEndIdentification('blablaTest124'); // Unique transaction identifier (shown to the debtor)
$transaction->setInstructedAmount(0.12);
$transaction->setMandateIdentification('AT5f6789'); // Shown to the debtor
$transaction->setDateOfSignature('2013-03-01');
$transaction->setAmendmentIndicator('false');
$transaction->setDebtorName('The debtor name');
$transaction->setDebtorIban('AT611904300234573201');
$transaction->setDebtorAgentBIC('INGBATWW');
$transaction->setRemittanceInformation('Invoice 1234'); // Shown to the debtor
$paymentInfo->addTransaction($transaction);

$message->addPaymentInfo($paymentInfo);

//if ($message->validateXML('validation_schemes/pain.008.003.02.xsd'))
  echo $message->printXML();
  $xml = fopen("sepa.xml","w");
