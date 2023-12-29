<?php
/**
 * This class organizes the GrpHdr element of a SEPA message.
 *
 * @author     Johannes Feichtner <johannes@web-wack.at>
 * @copyright  http://www.web-wack.at web wack creations
 * @license    http://creativecommons.org/licenses/by-nc/3.0/ CC Attribution-NonCommercial 3.0 license
 * For commercial use please contact sales@web-wack.at
 */

class SEPAGroupHeader {
  /**
   * Point to point reference assigned by the instructing party and sent to the next party in the chain
   * to unambiguously identify the message. (Tag: <MsgId>)
   *
   * @var string
   */
  private $messageIdentification = '';

  /**
   * Date and time at which a (group of) payment instruction(s) was created
   * by the instructing party. (Tag: <CreDtTm>)
   *
   * @var DateTime object
   */
  private $creationDateTime = null;

  /**
   * Number of individual transactions contained in the message. (Tag: <NbOfTxs>)
   *
   * @var int
   */
  private $numberOfTransactions = 0;

  /**
   * Total of all individual amounts included in the message. (Tag: <CtrlSum>)
   *
   * @var float
   */
  private $controlSum = 0.00;

  /**
   * Party that initiates the payment. This can either be the creditor or a party that initiates
   * the direct debit on behalf of the creditor. (Tag: <InitgPty->Nm>)
   *
   * @var string
   */
  private $initiatingPartyName = '';
  
  /**
   * Party that initiates the payment. This can either be the creditor or a party that initiates
   * the direct debit on behalf of the creditor. (Tag: <InitgPty->Id>)
   *
   * @var string
   */
  private $initiatingPartyId = '';

  /**
   * Getter for Message Identification (MsgId)
   *
   * @return string
   */
  public function getMessageIdentification()
  {
    return $this->messageIdentification;
  }

  /**
   * Setter for Message Identification (MsgId)
   *
   * @param $msgId
   * @throws SEPAException
   */
  public function setMessageIdentification($msgId)
  {
    $msgId = URLify::downcode($msgId, "de");

    if (!preg_match("/^([A-Za-z0-9]|[\+|\?|\/|\-|:|\(|\)|\.|,|'| ]){1,35}\z/", $msgId))
      throw new SEPAException("MsgId empty, contains invalid characters or too long (max. 35).");
    
    $this->messageIdentification = $msgId;
    
    }

  /**
   * Getter for Creation Date Time (CreDtTm)
   *
   * @return DateTime object
   */
  public function getCreationDateTime()
  {
    $creationDate = new DateTime();

    if (!$this->creationDateTime)
      $this->creationDateTime = $creationDate->format('Y-m-d\TH:i:s');

    return $this->creationDateTime;
  }

  /**
   * Setter for Creation Date Time (CreDtTm)
   *
   * @param string $creDtTm
   */
  public function setCreationDateTime($creDtTm)
  {
    $this->creationDateTime = $creDtTm;
  }

  /**
   * Getter for Number of Transactions (NbOfTxs)
   *
   * @return int
   */
  public function getNumberOfTransactions()
  {
    return $this->numberOfTransactions;
  }

  /**
   * Setter for Number of Transactions (NbOfTxs)
   *
   * @param int $nbOfTxs
   * @throws SEPAException
   */
  public function setNumberOfTransactions($nbOfTxs)
  {
    if (!preg_match("/^[0-9]{1,15}\z/", $nbOfTxs))
      throw new SEPAException("Invalid NbOfTxs value (max. 15 digits).");

    $this->numberOfTransactions = $nbOfTxs;
  }

  /**
   * Getter for ControlSum (CtrlSum)
   *
   * @return float
   */
  public function getControlSum()
  {
    return $this->controlSum;
  }

  /**
   * Setter for ControlSum (CtrlSum)
   *
   * @param float $ctrlSum
   */
  public function setControlSum($ctrlSum)
  {
    $this->controlSum = floatval($ctrlSum);
  }

  /**
   * Getter for Initiating Party Name (InitgPty->Nm)
   *
   * @return string
   */
  public function getInitiatingPartyName()
  {
    return $this->initiatingPartyName;
  }
  /**
   * Getter for Initiating Party Name (InitgPty->Id)
   *
   * @return string
   */
  public function getInitiatingPartyId()
  {
    return $this->initiatingPartyId;
  }

  /**
   * Setter for Initiating Party Name (InitgPty->Nm)
   *
   * @param string $initgPty
   * @throws SEPAException
   */
  public function setInitiatingPartyName($initgPty)
  {
    $initgPty = URLify::downcode($initgPty, "latin");

    if (strlen($initgPty) == 0 || strlen($initgPty) > 70)
      throw new SEPAException("Invalid initiating party name (max. 70).");

    $this->initiatingPartyName = $initgPty;    
   }
   
   public function setInitiatingPartyId($initgPty)
  {
    $this->initiatingPartyId = $initgPty;    
   }

  /**
   * Returns a SimpleXMLElement for the SEPAGroupHeader object.
   *
   * @return SimpleXMLElement object
   */
  public function getXmlGroupHeader()
  {
    $xml = new SimpleXMLElement("<GrpHdr></GrpHdr>");
    $xml->addChild('MsgId', $this->getMessageIdentification());
    $xml->addChild('CreDtTm', $this->getCreationDateTime());
    $xml->addChild('NbOfTxs', $this->getNumberOfTransactions());
    // $xml->addChild('CtrlSum', $this->getControlSum());
    $xml->addChild('CtrlSum', number_format($this->getControlSum(), 2, '.', '')); // SinergiaTIC 10/05/2016
	$xml->addChild('InitgPty')->addChild('Nm', $this->getInitiatingPartyName());
    $xml->InitgPty-> addChild('Id')->addChild('OrgId')->addChild('Othr')->addChild('Id',$this->getInitiatingPartyId());

    return $xml;
  }
}
