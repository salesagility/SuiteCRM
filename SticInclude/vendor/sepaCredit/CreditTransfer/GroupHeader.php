<?php

/**
 * GroupHeader
 *
 * @author Perry Faro 2015
 * @license MIT
 */

namespace Sepa\CreditTransfer;

class GroupHeader {

    /**
     * @var string
     */
    protected $messageIdentification;

    /**
     * The initiating Party for this payment
     *
     * @var string
     */
    protected $initiatingPartyId;

    /**
     * @var integer
     */
    protected $numberOfTransactions = 0;

    /**
     * @var integer
     */
    protected $controlSum = 0;

    /**
     * @var string
     */
    protected $initiatingPartyName;
    
    
    /**
     * @var string
     */
    protected $initiatingPartyOrgIdOthrId; //Added SinergiaTIC 2018

    /**
     * @var \DateTime
     */
    protected $creationDateTime;

    /**
     * @param $messageIdentification
     * @param $initiatingPartyName
     * @param $initiatingPartyOrgIdOthrId 
     */
    function __construct($messageIdentification = false, $initiatingPartyName = false,$initiatingPartyOrgIdOthrId=false) {
        $this->messageIdentification = $messageIdentification;
        $this->initiatingPartyName = $initiatingPartyName;
        $this->initiatingPartyOrgIdOthrId = $initiatingPartyOrgIdOthrId; //Added SinergiaTIC 2018
        $this->creationDateTime = new \DateTime();
    }

    /**
     * @return integer
     */
    public function getControlSum() {
        return $this->controlSum;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDateTime() {
        return $this->creationDateTime;
    }

    /**
     * @return string
     */
    public function getInitiatingPartyId() {
        return $this->initiatingPartyId;
    }

    /**
     * @return string
     */
    public function getInitiatingPartyName() {
        return $this->initiatingPartyName;
    }
   
    /**
     * @return string
     */
    public function getInitiatingPartyOrgIdOthrId() {
        return $this->initiatingPartyOrgIdOthrId;
    }

    /**
     * @return integer
     */
    public function getNumberOfTransactions() {
        return $this->numberOfTransactions;
    }

    /**
     * @return string
     */
    public function getMessageIdentification() {
        return $this->messageIdentification;
    }

    /**
     * 
     * @param integer $controlSum
     * @return \Sepa\CreditTransfer\GroupHeader
     */
    public function setControlSum($controlSum) {
        $this->controlSum = $controlSum;
        return $this;
    }

    /**
     * 
     * @param string $initiatingPartyId
     * @return \Sepa\CreditTransfer\GroupHeader
     */
    public function setInitiatingPartyId($initiatingPartyId) {
        $this->initiatingPartyId = $initiatingPartyId;
        return $this;
    }

    /**
     * 
     * @param string $initiatingPartyName
     * @return \Sepa\CreditTransfer\GroupHeader
     */
    public function setInitiatingPartyName($initiatingPartyName) {
        $this->initiatingPartyName = $initiatingPartyName;
        return $this;
    }
   
    
    /**
     * 
     * @param string $initiatingPartyOrgIdOthrId
     * @return \Sepa\CreditTransfer\GroupHeader
     */
    public function setInitiatingPartyOrgIdOthrId($initiatingPartyOrgIdOthrId) {
        $this->initiatingPartyOrgIdOthrId = $initiatingPartyOrgIdOthrId;
        return $this;
    }
    

    /**
     * 
     * @param string $messageIdentification
     * @return \Sepa\CreditTransfer\GroupHeader
     */
    public function setMessageIdentification($messageIdentification) {
        $this->messageIdentification = $messageIdentification;
        return $this;
    }

    /**
     * 
     * @param integer $numberOfTransactions
     * @return \Sepa\CreditTransfer\GroupHeader
     */
    public function setNumberOfTransactions($numberOfTransactions) {
        $this->numberOfTransactions = $numberOfTransactions;
        return $this;
    }

}
