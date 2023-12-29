# SEPA Credit Transfer

[![Build Status](https://travis-ci.org/perryfaro/sepa.svg?branch=master)](https://travis-ci.org/perryfaro/sepa)

### Installation using Composer

```
composer require perryfaro/sepa
```

### Example

```php
$creditTransfer = new \Sepa\CreditTransfer();
//group header
$groupHeader = new \Sepa\CreditTransfer\GroupHeader();
$groupHeader->setControlSum(150.00)
        ->setInitiatingPartyName('Company name')
        ->setMessageIdentification('lkgjekrthrewkjtherwkjtherwkjtrhewr')
        ->setNumberOfTransactions(2);
$creditTransfer->setGroupHeader($groupHeader);
//payment information
$paymentInformation = new \Sepa\CreditTransfer\PaymentInformation;

$paymentInformation
        ->setDebtorIBAN('NL91ABNA0417164300')
        ->setDebtorName('Name')
        ->setPaymentInformationIdentification('1281543153223-3463265456')
        ->setRequestedExecutionDate('2015-01-01');

//payment
$payment = new \Sepa\CreditTransfer\Payment;
$payment->setAmount(100.00)
        ->setCreditorBIC('ABNANL2A')
        ->setCreditorIBAN('NL91ABNA0417164300')
        ->setCreditorName('My Name')
        ->setEndToEndId('askfjhwqkjthewqjktewrter')
        ->setRemittanceInformation('Transaction testing');

$paymentInformation->addPayments($payment);
//payment
$payment = new \Sepa\CreditTransfer\Payment;
$payment->setAmount(50.00)
        ->setCreditorIBAN('NL91ABNA0417164300')
        ->setCreditorName('My Name 2')
        ->setEndToEndId('askfjhwqkjthewqjktewrter')
        ->setRemittanceInformation('Transaction testing 2');

$paymentInformation->addPayments($payment);

$creditTransfer->setPaymentInformation($paymentInformation);
$xml = $creditTransfer->xml();
```
