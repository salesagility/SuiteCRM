<?php

/**
 * Base
 *
 * @author Perry Faro 2015
 * @license MIT
 */

namespace Sepa\Builder;

class Base {

    /**
     * 
     * @param string $painFormat
     */
    public function __construct($painFormat) {
        $this->dom = new \DOMDocument('1.0', 'UTF-8');
        $this->dom->formatOutput = true;
        $this->root = $this->dom->createElement('Document');
        $this->root->setAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
        $this->root->setAttribute('xmlns', sprintf("urn:iso:std:iso:20022:tech:xsd:%s", $painFormat));
        $this->dom->appendChild($this->root);
    }

    /**
     * @param string $name
     * @param null $value
     * @return \DOMElement
     */
    protected function createElement($name, $value = null) {
        if ($value) {
            $elm = $this->dom->createElement($name);
            $elm->appendChild($this->dom->createTextNode($value));
            return $elm;
        } else {
            return $this->dom->createElement($name);
        }
    }

    /**
     * @param string $BIC
     * @return \DOMElement
     */
    protected function financialInstitution($BIC = '') {
        $finInstitution = $this->createElement('FinInstnId');
        $finInstitution->appendChild($this->createElement('BIC', $BIC));
        return $finInstitution;
    }

    /**
     * @param string $IBAN
     * @return \DOMElement
     */
    protected function IBAN($IBAN) {
        $id = $this->createElement('Id');
        $id->appendChild($this->createElement('IBAN', $IBAN));
        return $id;
    }

    /**
     * @param string $remittenceInformation
     * @return \DOMElement
     */
    protected function remittence($remittenceInformation) {
        $remittanceInformation = $this->createElement('RmtInf');
        $remittanceInformation->appendChild($this->createElement('Ustrd', $remittenceInformation));
        return $remittanceInformation;
    }

}
