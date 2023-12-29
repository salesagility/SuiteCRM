<?php

/**
 * CreditTransfer
 *
 * @author Perry Faro 2015
 * @license MIT
 */

namespace Sepa\Builder;

use Sepa\Builder\Base;
use Sepa\CreditTransfer\GroupHeader;
use Sepa\CreditTransfer\PaymentInformation;

class CreditTransfer extends Base
{

    public function __construct($painFormat = 'pain.001.001.03')
    {
        parent::__construct($painFormat);
        $this->transfer = $this->createElement('CstmrCdtTrfInitn');
        $this->root->appendChild($this->transfer);
    }

    /**
     *
     * @param GroupHeader $groupHeader
     */
    public function appendGroupHeader(GroupHeader $groupHeader)
    {
        $groupHeaderElement = $this->createElement('GrpHdr');

        $messageIdentification = $this->createElement('MsgId', $groupHeader->getMessageIdentification());
        $groupHeaderElement->appendChild($messageIdentification);

        // 2021-08-26 STIC
        // Original statement
        // $creationDateTime = $this->createElement('CreDtTm', $groupHeader->getCreationDateTime()->format('Y-m-d\TH:i:s\Z'));
        // Remove \Z suffix in time format as it causes the field to be longer than the 19 characters allowed
        $creationDateTime = $this->createElement('CreDtTm', $groupHeader->getCreationDateTime()->format('Y-m-d\TH:i:s'));
        $groupHeaderElement->appendChild($creationDateTime);
        
        $numberOfTransactions = $this->createElement('NbOfTxs', $groupHeader->getNumberOfTransactions());
        $groupHeaderElement->appendChild($numberOfTransactions);

        $controlSum = $this->createElement('CtrlSum', $groupHeader->getControlSum());
        $groupHeaderElement->appendChild($controlSum);

        $initiatingParty = $this->createElement('InitgPty');
        $initiatingPartyName = $this->createElement('Nm', $groupHeader->getInitiatingPartyName());
        $initiatingParty->appendChild($initiatingPartyName);
        
        //2018-03-15 Añadido por SinergiaCRM, ya que la libreria original no incluye esta parte
        //Agregamos Id
        $initiatingPartyId = $this->createElement('Id', $groupHeader->getInitiatingPartyId());
        $initiatingParty->appendChild($initiatingPartyId);
        
        //Agregamos OrgId
        $initiatingPartyOrgId = $this->createElement('OrgId');
        $initiatingPartyId->appendChild($initiatingPartyOrgId);
        
        //Agregamos Othr
        $initiatingPartyOrgIdOthr = $this->createElement('Othr');
        $initiatingPartyOrgId->appendChild($initiatingPartyOrgIdOthr);
        
        //Agregamos Othr
        $initiatingPartyOrgIdOthrId = $this->createElement('Id',$groupHeader->getInitiatingPartyOrgIdOthrId());
        $initiatingPartyOrgIdOthr->appendChild($initiatingPartyOrgIdOthrId);
        ///////////

        $groupHeaderElement->appendChild($initiatingParty);

        $this->transfer->appendChild($groupHeaderElement);
    }

    public function appendPaymentInformation(PaymentInformation $paymentInformation)
    {
        $this->payment = $this->createElement('PmtInf');

        $paymentInformationIdentification = $this->createElement('PmtInfId', $paymentInformation->getPaymentInformationIdentification());
        $this->payment->appendChild($paymentInformationIdentification);

        $paymentMethod = $this->createElement('PmtMtd', $paymentInformation->getPaymentMethod());
        $this->payment->appendChild($paymentMethod);

        if ($paymentInformation->getNumberOfTransactions() !== false) {
            $numberOfTransactions = $this->createElement('NbOfTxs', $paymentInformation->getNumberOfTransactions());
            $this->payment->appendChild($numberOfTransactions);
        }
        if ($paymentInformation->getControlSum() !== false) {
            $controlSum = $this->createElement('CtrlSum', $paymentInformation->getControlSum());
            $this->payment->appendChild($controlSum);
        }

        $requestedExecutionDate = $this->createElement('ReqdExctnDt', $paymentInformation->getRequestedExecutionDate());
        $this->payment->appendChild($requestedExecutionDate);

        $debtor = $this->createElement('Dbtr');
        $debtor->appendChild($this->createElement('Nm', $paymentInformation->getDebtorName()));
        $this->payment->appendChild($debtor);

        $debtorAgentAccount = $this->createElement('DbtrAcct');
        $debtorAgentAccount->appendChild($this->IBAN($paymentInformation->getDebtorIBAN()));
        $this->payment->appendChild($debtorAgentAccount);

        $debtorAgent = $this->createElement('DbtrAgt');
        $debtorAgent->appendChild($this->financialInstitution($paymentInformation->getDebtorBIC()));
        $this->payment->appendChild($debtorAgent);

        $this->appendPayments($paymentInformation->getPayments());

        $this->transfer->appendChild($this->payment);
    }

    protected function appendPayments($payments)
    {
        foreach ($payments as $payment) {
            $creditTransferTransactionInformation = $this->createElement('CdtTrfTxInf');

            $paymentIdentification = $this->createElement('PmtId');
            $paymentIdentification->appendChild($this->createElement('EndToEndId', $payment->getEndToEndId()));
            $creditTransferTransactionInformation->appendChild($paymentIdentification);

            $amount = $this->createElement('Amt');
            $instructedAmount = $this->createElement('InstdAmt', $payment->getAmount());
            $instructedAmount->setAttribute('Ccy', $payment->getCurrency());
            $amount->appendChild($instructedAmount);
            $creditTransferTransactionInformation->appendChild($amount);

            $creditorAgent = $this->createElement('CdtrAgt');
            $financialInstitution = $this->createElement('FinInstnId');
            // $financialInstitution->appendChild($this->createElement('BIC', $payment->getCreditorBIC())); //Omitimos la creación de este elemento porque da error en algunas entidades (Caja de Ingenieros)
            $creditorAgent->appendChild($financialInstitution);
            $creditTransferTransactionInformation->appendChild($creditorAgent);

            $creditor = $this->createElement('Cdtr');
            $creditor->appendChild($this->createElement('Nm', $payment->getCreditorName()));
            $creditTransferTransactionInformation->appendChild($creditor);

            $creditorAccount = $this->createElement('CdtrAcct');
            $id = $this->createElement('Id');
            $id->appendChild($this->createElement('IBAN', $payment->getCreditorIBAN()));
            $creditorAccount->appendChild($id);
            $creditTransferTransactionInformation->appendChild($creditorAccount);

            $remittanceInformation = $this->remittence($payment->getRemittanceInformation());
            $creditTransferTransactionInformation->appendChild($remittanceInformation);
            $this->payment->appendChild($creditTransferTransactionInformation);
        }
    }

    /**
     * Return xml
     *
     * @return string
     */
    public function xml()
    {
        return (string) $this->dom->saveXML();
    }

}
