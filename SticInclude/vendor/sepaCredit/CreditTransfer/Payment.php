<?php

/**
 * Payment
 *
 * @author Perry Faro 2015
 * @license MIT
 */

namespace Sepa\CreditTransfer;

class Payment {

    /**
     *
     * @var string
     */
    protected $amount;

    /**
     *
     * @var string 
     */
    protected $creditorName;

    /**
     *
     * @var string 
     */
    protected $creditorIBAN;

    /**
     *
     * @var string 
     */
    protected $creditorBIC = 'NOTPROVIDED';
    
    /**
     *
     * @var string
     */
    protected $currency = 'EUR';

    /**
     *
     * @var string
     */
    protected $endToEndId;

    /**
     *
     * @var string
     */
    protected $remittanceInformation;

    /**
     * 
     * @return string
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * 
     * @return string
     */
    public function getCreditorName() {
        return $this->creditorName;
    }

    /**
     * 
     * @return string
     */
    public function getCreditorIBAN() {
        return $this->creditorIBAN;
    }

    /**
     * 
     * @return string
     */
    public function getCreditorBIC() {
        return $this->creditorBIC;
    }
    
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * 
     * @return string
     */
    public function getEndToEndId() {
        return $this->endToEndId;
    }

    /**
     * 
     * @return string
     */
    public function getRemittanceInformation() {
        return $this->remittanceInformation;
    }

    /**
     * 
     * @param string $amount
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setCreditorName($name) {
        $this->creditorName = $name;
        return $this;
    }

    /**
     * 
     * @param string $IBAN
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setCreditorIBAN($IBAN) {
        $this->creditorIBAN = $IBAN;
        return $this;
    }

    /**
     * 
     * @param string $BIC
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setCreditorBIC($BIC) {
        $this->creditorBIC = $BIC;
        return $this;
    }
    
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    /**
     * 
     * @param string $endToEndId
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setEndToEndId($endToEndId) {
        $this->endToEndId = $endToEndId;
        return $this;
    }

    /**
     * 
     * @param string $remittanceInformation
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setRemittanceInformation($remittanceInformation) {
        $this->remittanceInformation = $remittanceInformation;
        return $this;
    }

}
