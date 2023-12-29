<?php
/**
 * This class represents the overall SEPA message and is used for XML generation and validation.
 *
 * @author     Johannes Feichtner <johannes@web-wack.at>
 * @copyright  http://www.web-wack.at web wack creations
 * @license    http://creativecommons.org/licenses/by-nc/3.0/ CC Attribution-NonCommercial 3.0 license
 * For commercial use please contact sales@web-wack.at
 */

class SEPAMessage
{
  /**
   * The used ISO 20022 message format.
   *
   * @var string
   */
  private $messageDefintion = '';

  /**
   * GroupHeader object. (Tag: <GrpHdr>)
   *
   * @var SEPAGroupHeader object
   */
  private $groupHeader = null;

  /**
   * A container for all PaymentInfo objects.
   *
   * @var SEPAPaymentInfo[] array
   */
  private $paymentInfos = array();

  /**
   * The constructor sets the used message format.
   *
   * @param string $messageDefinition
   */
  public function __construct($messageDefinition)
  {
    $this->messageDefintion = $messageDefinition;
    
    }

  /**
   * Getter for the group header object.
   *
   * @return SEPAGroupHeader object
   */
  public function getGroupHeader()
  {
    if (is_null($this->groupHeader))
      $this->groupHeader = new SEPAGroupHeader();

    return $this->groupHeader;
  }

  /**
   * Setter for the group header object.
   *
   * @param SEPAGroupHeader $groupHeader
   */
  public function setGroupHeader(SEPAGroupHeader $groupHeader)
  {
    $this->groupHeader = $groupHeader;
    
    }

  /**
   * Adds a PaymentInfo object to the collection.
   *
   * @param SEPAPaymentInfo $paymentInfo
   */
  public function addPaymentInfo(SEPAPaymentInfo $paymentInfo)
  {
    $this->paymentInfos[] = $paymentInfo;

    $nbOfTxs = $this->getGroupHeader()->getNumberOfTransactions() + $paymentInfo->getNumberOfTransactions();
    $ctrlSum = $this->getGroupHeader()->getControlSum() + $paymentInfo->getControlSum();
    $this->getGroupHeader()->setNumberOfTransactions($nbOfTxs);
    $this->getGroupHeader()->setControlSum($ctrlSum);
  }

  /**
   * Returns the message as SimpleXMLElement object.
   *
   * @return SimpleXMLElement object
   */
  public function getXML()
  {
    // Initialize the actual message and add the group header
    $message = new SimpleXMLElement("<CstmrDrctDbtInitn></CstmrDrctDbtInitn>");
    $this->addSubtree($message, $this->getGroupHeader()->getXmlGroupHeader());

    // Add all payment blocks
    for ($i = 0; $i < count($this->paymentInfos); $i++)
      $this->addSubtree($message, $this->paymentInfos[$i]->getXmlPaymentInfo());

    $message->GrpHdr->NbOfTxs = $this->getGroupHeader()->getNumberOfTransactions();
    // $message->GrpHdr->CtrlSum = $this->getGroupHeader()->getControlSum();
    $message->GrpHdr->CtrlSum = number_format($this->getGroupHeader()->getControlSum(), 2, '.', ''); // SinergiaTIC 10/05/2016
	
    // Finally add the XML structure
    $doc = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><Document xmlns="' . $this->messageDefintion . '" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></Document>');
    $this->addSubtree($doc, $message);

    return $doc;
  }

  /**
   * Returns a printable and formatted XML message.
   *
   * @return string
   */
  public function printXML()
  {
    @header('Content-type: text/xml');
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($this->getXML()->asXML());

    return $dom->saveXML();
  }

  /**
   * Validate the generated XML over the .xsd specification.
   *
   * @param string $schemePath
   * @return bool
   */
  public function validateXML($schemePath)
  {
    $dom = new DOMDocument();
    $dom->loadXML($this->getXML()->asXML());

    libxml_use_internal_errors(true);
    if (!$dom->schemaValidate($schemePath))
    {
      echo "XML validation failed!\n";

      $errors = libxml_get_errors();
      for ($i = 0; $i < count($errors); $i++)
        echo "Error " . $errors[$i]->code . ": " . $errors[$i]->message . "\n";

      return false;
    }

    return true;
  }

  /**
   * Creates new DOM elements from two given SimpleXMLElement objects.
   *
   * @param SimpleXMLElement $xmlTarget
   * @param SimpleXMLElement $xmlOrigin
   */
  private function addSubtree(SimpleXMLElement $xmlTarget, SimpleXMLElement $xmlOrigin)
  {
    $domTarget = dom_import_simplexml($xmlTarget);
    $domOrigin = dom_import_simplexml($xmlOrigin);

    $domTarget->appendChild($domTarget->ownerDocument->importNode($domOrigin, true));
  }
}
