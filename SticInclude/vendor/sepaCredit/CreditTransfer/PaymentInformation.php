<?php

/**
 * PaymentInformation
 *
 * @author Perry Faro 2015
 * @license MIT
 */

namespace Sepa\CreditTransfer;

use Sepa\CreditTransfer\Payment;

class PaymentInformation {

    /**
     * @var string
     */
    protected $paymentInformationIdentification;

    /**
     * The initiating Party for this payment
     *
     * @var string
     */
    protected $paymentMethod = 'TRF';

    /**
     * @var integer
     */
    protected $numberOfTransactions = false;

    /**
     * @var integer
     */
    protected $controlSum = false;

    /**
     * @var \DateTime
     */
    protected $requestedExecutionDate;

    /**
     *
     * @var string 
     */
    protected $debtorName;

    /**
     *
     * @var string 
     */
    protected $debtorIBAN;

    /**
     *
     * @var string 
     */
    protected $debtorBIC = 'NOTPROVIDED';

    /**
     *
     * @var array
     */
    protected $payments = array();

    /**
     * @return integer
     */
    public function getControlSum() {
        return $this->controlSum;
    }

    /**
     * 
     * @return string
     */
    public function getDebtorName() {
        return $this->debtorName;
    }

    /**
     * 
     * @return string
     */
    public function getDebtorIBAN() {
        return $this->debtorIBAN;
    }

    /**
     * 
     * @return string
     */
    public function getDebtorBIC() {
        return $this->debtorBIC;
    }

    /**
     * @return integer
     */
    public function getNumberOfTransactions() {
        return $this->numberOfTransactions;
    }

    /**
     * 
     * @return string
     */
    public function getPaymentInformationIdentification() {
        return $this->paymentInformationIdentification;
    }

    /**
     * 
     * @return string 
     */
    public function getPaymentMethod() {
        return $this->paymentMethod;
    }

    /**
     * 
     * @return array
     */
    public function getPayments() {
        return $this->payments;
    }

    /**
     * 
     * @return \DateTime
     */
    public function getRequestedExecutionDate() {
        return $this->requestedExecutionDate;
    }

    /**
     * @param integer $controlSum
     */
    public function setControlSum($controlSum) {
        $this->controlSum = $controlSum;
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return \Sepa\CreditTransfer\PaymentInformation
     */
    public function setDebtorName($name) {
        $this->debtorName = $name;
        return $this;
    }

    /**
     * 
     * @param string $IBAN
     * @return \Sepa\CreditTransfer\PaymentInformation
     */
    public function setDebtorIBAN($IBAN) {
        $this->debtorIBAN = $IBAN;
        return $this;
    }

    /**
     * 
     * @param string $BIC
     * @return \Sepa\CreditTransfer\PaymentInformation
     */
    public function setDebtorBIC($BIC) {
        $this->debtorBIC = $BIC;
        return $this;
    }

    /**
     * @param integer $numberOfTransactions
     */
    public function setNumberOfTransactions($numberOfTransactions) {
        $this->numberOfTransactions = $numberOfTransactions;
        return $this;
    }

    public function setPaymentInformationIdentification($paymentInformationIdentification) {
        $this->paymentInformationIdentification = $paymentInformationIdentification;
        return $this;
    }

    public function setRequestedExecutionDate($requestDate) {
        $this->requestedExecutionDate = $requestDate;
        return $this;
    }

    /**
     * 
     * @param array|Payment $payment
     */
    public function addPayments($payment) {
        if (is_array($payment)) {
            foreach ($payment as $transfer) {

                $this->payments[] = $transfer;
            }
        } else {

            $this->payments[] = $payment;
        }
    }

}
