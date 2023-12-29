<?php

namespace Sepa;

use Sepa\Builder\CreditTransfer as Builder;
use Sepa\CreditTransfer\GroupHeader;
use Sepa\CreditTransfer\PaymentInformation;

/**
 * CreditTransfer
 *
 * @author Perry Faro 2015
 * @license MIT
 */
class CreditTransfer {

    /**
     *
     * @var Sepa\CreditTransfer\GroupHeader
     */
    protected $groupHeader = null;

    /**
     *
     * @var Sepa\CreditTransfer\PaymentInformation
     */
    protected $paymentInformation = null;

    /**
     * 
     * @param GroupHeader $groupHeader
     * @return CreditTransfer
     */
    public function setGroupHeader(GroupHeader $groupHeader) {
        $this->groupHeader = $groupHeader;
        return $this;
    }

    /**
     * 
     * @param  $paymentInformation
     * @return CreditTransfer
     */
    public function setPaymentInformation(PaymentInformation $paymentInformation) {
        $this->paymentInformation = $paymentInformation;
        return $this;
    }

    /**
     * 
     * @param string $xml
     * @param string $painformat
     * @return boolean
     */
    public function validate($xml, $painformat = 'pain.001.001.03') {
        $reader = new \DOMDocument;
        $reader->loadXML($xml);
        if ($reader->schemaValidate(__DIR__ . '/xsd/' . $painformat . '.xsd')) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @throws Exception
     */
    public function xml() {
        if ($this->groupHeader === null) {
            throw new Exception;
        }

        if ($this->paymentInformation === null) {
            throw new Exception;
        }

        $build = new Builder;
        $build->appendGroupHeader($this->groupHeader);
        $build->appendPaymentInformation($this->paymentInformation);
        return $build->xml();
    }

}
