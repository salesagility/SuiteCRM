<?php

/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once __DIR__ . '/../../include/SugarEmailAddress/SugarEmailAddress.php';


class EmailsControllerActionGetFromFieldsSignatureResolver {
    
    const ERR_HTML_AMBIGUOUS = 301;
    const ERR_HTML_NONE = 302;
    const ERR_PLAINTEXT_AMBIGUOUS = 303;
    const ERR_PLAINTEXT_NONE = 304;
    
    /**
     *
     * @var array
     */
    protected $signatureArray;
    
    /**
     *
     * @var string
     */
    protected $html;
    
    /**
     *
     * @var string
     */
    protected $plaintext;
    
    /**
     *
     * @var array
     */
    protected $errors;
    
    /**
     *
     * @var bool
     */
    protected $noDefaultAvailable;
    
    /**
     * 
     * @param array $signatureArray
     * @return array errors
     */
    public function setSignatureArray($signatureArray) {
        $this->signatureArray = $signatureArray;
        $this->errors = [];
        $this->html = $this->resolveHtml();
        $this->plaintext = $this->resolvePlaintext();
        $this->noDefaultAvailable = false;
        if (in_array(self::ERR_HTML_NONE, $this->errors) && in_array(self::ERR_PLAINTEXT_NONE, $this->errors)) {
            $this->noDefaultAvailable = true;
        }
        return $this->errors;
    }
    
    /**
     * 
     * @return string|null this function returns null and/or set errors variable if error(s) occured
     */
    protected function resolveHtml() {
        if (isset($this->signatureArray['html']) && $this->signatureArray['html']) {
            if (isset($this->signatureArray['signature_html']) && $this->signatureArray['signature_html'] && 
                    $this->signatureArray['signature_html'] != $this->signatureArray['html']) {
                $this->errors[] = self::ERR_HTML_AMBIGUOUS;
                LoggerManager::getLogger()->error('Ambiguous signature html found!');
            }
            return $this->signatureArray['html'];
        }
        if (isset($this->signatureArray['signature_html']) && $this->signatureArray['signature_html']) {
            return $this->signatureArray['signature_html'];
        }
        $this->errors[] = self::ERR_HTML_NONE;
        LoggerManager::getLogger()->error('Signature html not found!');
        return null;
    }
    
    /**
     * 
     * @return string|null this function returns null and/or set errors variable if error(s) occured
     */
    protected function resolvePlaintext() {
        if (isset($this->signatureArray['plain']) && $this->signatureArray['plain']) {
            if (isset($this->signatureArray['signature']) && $this->signatureArray['signature'] && 
                    $this->signatureArray['signature'] != $this->signatureArray['plain']) {
                $this->errors[] = self::ERR_PLAINTEXT_AMBIGUOUS;
                LoggerManager::getLogger()->error('Ambiguous signature plain text found!');
            }
            return $this->signatureArray['plain'];
        }
        if (isset($this->signatureArray['signature']) && $this->signatureArray['signature']) {
            return $this->signatureArray['signature'];
        }
        $this->errors[] = self::ERR_PLAINTEXT_NONE;   
        LoggerManager::getLogger()->error('Signature plain text not found!');     
        return null;
    }
    
    /**
     * 
     * @return string
     */
    public function getHtml() {
        return $this->html;
    }
    
    /**
     * 
     * @return string
     */
    public function getPlaintext() {
        return $this->plaintext;
    }
    
    /**
     * 
     * @return bool
     */
    public function isNoDefaultAvailable() {
        return $this->noDefaultAvailable;
    }
    
}

class EmailsControllerActionGetFromFieldsDataAddress {
    
    /**
     * 
     * @param string $type
     * @param string $id
     * @param string $attributesReplyTo
     * @param string $attributesFrom
     * @param string $attributesName
     * @param string $attributesOe
     * @param string $prepend
     * @param bool $isPersonalEmailAccount
     * @param bool $isGroupEmailAccount
     * @param string $outboundEmailId
     * @param string $outboundEmailName
     * @param array $emailSignaturesArray
     * @return array
     */
    public function getDataArray(
            $type,
            $id,
            $attributesReplyTo,
            $attributesFrom,
            $attributesName,
            $attributesOe,
            $prepend,
            $isPersonalEmailAccount,
            $isGroupEmailAccount,
            $outboundEmailId,
            $outboundEmailName,
            $emailSignaturesArray
    ) {
        $signatureResolver = new EmailsControllerActionGetFromFieldsSignatureResolver($emailSignaturesArray);
        
        $dataArray = [
            'type' => $type,
            'id' => $id,
            'attributes' => $this->getDataArrayAttributes($attributesReplyTo, $attributesFrom, $attributesName, $attributesOe),
            'prepend' => $prepend,
            'isPersonalEmailAccount' => $isPersonalEmailAccount,
            'isGroupEmailAccount' => $isGroupEmailAccount,
            'outboundEmail' => [
                'id' => $outboundEmailId,
                'name' => $outboundEmailName,
            ],
            'emailSignatures' => [
                'html' => $signatureResolver->getHtml(),
                'plain' => $signatureResolver->getPlaintext(),
                'no_default_available' => $signatureResolver->isNoDefaultAvailable(),
            ],
        ];
        
        return $dataArray;
    }
    
    /**
     * 
     * @param string $attributesReplyTo
     * @param string $attributesFrom
     * @param string $attributesName
     * @param string $attributesOe
     * @return array
     */
    protected function getDataArrayAttributes($attributesReplyTo, $attributesFrom, $attributesName, $attributesOe) {
        return [
            'reply_to' => utf8_encode($attributesReplyTo),
            'from' => utf8_encode($attributesFrom),
            'name' => utf8_encode($attributesName),
            'oe' => utf8_encode($attributesOe),
        ];
    }
    
}

class EmailsControllerActionGetFromFieldsDataAddressCollector {
    
    const ERR_INVALID_INBOUND_EMAIL_TYPE = 201;
    const ERR_STORED_OUTBOUND_EMAIL_NOT_SET = 202;
    const ERR_STORED_OUTBOUND_EMAIL_ID_IS_INVALID = 203;
    const ERR_REPLY_TO_ADDR_NOT_FOUND = 204;
    const ERR_REPLY_TO_FROMAT_INVALID_SPLITS = 205;
    const ERR_STORED_OUTBOUND_EMAIL_NOT_FOUND = 206;
    
    /**
     *
     * @var User
     */
    protected $currentUser;
    
    /**
     *
     * @var int 
     */
    protected $err;
    
    /**
     *
     * @var OutboundEmail 
     */
    protected $oe;
    
    // ------------------ FROM DATA STRUCT -------------------
    
    /**
     *
     * @var string
     */
    protected $replyTo;
    
    /**
     *
     * @var string
     */
    protected $fromAddr;
    
    /**
     *
     * @var string
     */
    protected $fromName;
    
    /**
     *
     * @var string
     */
    protected $oeId;
    
    /**
     *
     * @var string
     */
    protected $oeName;

    // -------------------------------------------------------
    
    /**
     * 
     * @param User $currentUser
     */
    public function __construct(User $currentUser) {
        $this->currentUser = $currentUser;
    }

    /**
     *
     * @param InboundEmail[] $ieAccounts
     * @param mixed $showFolders
     * @return array
     */
    protected function collectDataAddressesFromIEAccounts(
        $ieAccounts, $showFolders, $prependSignature, $emailSignatures, $defaultEmailSignature
    ) {
        $dataAddresses = array();
        foreach ($ieAccounts as $inboundEmail) {
            $this->validateInboundEmail($inboundEmail);

            if (in_array($inboundEmail->id, $showFolders)) {
                $storedOptions = unserialize(base64_decode($inboundEmail->stored_options));
                $isGroupEmailAccount = $inboundEmail->isGroupEmailAccount();
                $isPersonalEmailAccount = $inboundEmail->isPersonalEmailAccount();

                $this->getOutboundEmailOrError();
                $this->retriveFromDataStruct($storedOptions);

                $emailFromValidator = new EmailFromValidator();

                $this->logReplyToError($emailFromValidator);


                $dataAddress = $this->getDataAddressFromIEAccounts(
                        $inboundEmail, $storedOptions, $prependSignature, $isPersonalEmailAccount, $isGroupEmailAccount, $emailSignatures, $defaultEmailSignature
                );

                $dataAddresses[] = $dataAddress;
            }
        }

        $dataAddressesResults = $this->fillDataAddress($dataAddresses, $defaultEmailSignature, $prependSignature);
        return $dataAddressesResults;
    }
    

    /**
     *
     * @param InboundEmail $inboundEmail
     * @throws InvalidArgumentException
     */
    protected function validateInboundEmail($inboundEmail = null) {
        if (!$inboundEmail instanceof InboundEmail) {
            throw new InvalidArgumentException('Inbound Email Account should be a valid Inbound Email. ' . gettype($inboundEmail) . ' given.', self::ERR_INVALID_INBOUND_EMAIL_TYPE);
        }
    }

    /**
     * 
     * @param array $storedOptions
     * @param InboundEmail $inboundEmail
     */
    protected function getOutboundEmailOrError($storedOptions, InboundEmail $inboundEmail) {
        $this->err = null;
        $this->collector->setOe(null);
        if (!isset($storedOptions['outbound_email'])) {
            // exception
            LoggerManager::getLogger()->error('EmailController::action_getFromFields() expects an outbound email id as stored option of inbound email (' . $inboundEmail->id . ') but it isn\'t set.');
            $this->err = self::ERR_STORED_OUTBOUND_EMAIL_NOT_SET;
        } else {
            $validator = new SuiteCRM\Utility\SuiteValidator();
            if ($validator->isValidId($storedOptions['outbound_email'])) {
                // exception
                LoggerManager::getLogger()->error('EmailController::action_getFromFields() expects an outbound email id as stored option of inbound email (' . $inboundEmail->id . ') but it isn\'t valid.');
                $this->err = self::ERR_STORED_OUTBOUND_EMAIL_ID_IS_INVALID;
            } else {
                $this->collector->setOe($this->getOutboundEmailOrErrorByStoredOptions($storedOptions));
            }
        }
    }

    /**
     * 
     * @param array $storedOptions
     */
    protected function retriveFromDataStruct($storedOptions) {
        if ($this->err) {
            LoggerManager::getLogger()->error('EmailController::action_getFromFields() panic: An error occurred! (' . $this->err . ')');

            $this->replyTo = $this->getReplyToOnError($storedOptions);
            $this->fromName = $this->getFromNameOnError($storedOptions);
            $this->fromAddr = $this->getFromAddrOnError($storedOptions);
            $this->oeId = null;
            $this->oeName = null;
        } else {
            $this->replyTo = utf8_encode($storedOptions['reply_to_addr']);
            $this->fromName = utf8_encode($storedOptions['from_name']);
            $this->fromAddr = utf8_encode($storedOptions['from_addr']);
            $this->oeId = $this->oe->id;
            $this->oeName = $this->oe->name;
        }
    }

    /**
     * 
     * @param EmailFromValidator $emailFromValidator
     */
    protected function logReplyToError(EmailFromValidator $emailFromValidator) {
        if (!$this->replyTo) {
            // exception
            LoggerManager::getLogger()->error('EmailController::action_getFromFields() panic: An Outbound Email Reply-to Address is not found.');
            $replyToErr = self::ERR_REPLY_TO_ADDR_NOT_FOUND;
        } else {
            $splits = explode(' ', $this->replyTo);
            if (count($splits) !== 2) {
                LoggerManager::getLogger()->error('Incorrect "replay to" format found: ' . $this->replyTo);
                $replyToErr = self::ERR_REPLY_TO_FROMAT_INVALID_SPLITS;
            } else {
                $tmpName = $this->getTmpNameForLogReplyToError($splits, &$replyToErr);
                $tmpAddr = $this->getTmpAddrForLogReplyToError($splits, &$replyToErr);

                $this->validateForLogReplyToError($tmpName, $tmpAddr, $emailFromValidator, &$replyToErr);
            }
        }

        if (isset($replyToErr) && $replyToErr) {
            // exception
            LoggerManager::getLogger()->error('EmailController::action_getFromFields() error: ' . $replyToErr);
        }
    }

    /**
     * 
     * @param InboundEmail $inboundEmail
     * @param array $storedOptions
     * @param string $prependSignature
     * @param bool $isPersonalEmailAccount
     * @param bool $isGroupEmailAccount
     * @param array $emailSignatures
     * @param array $defaultEmailSignature
     * @return array
     */
    protected function getDataAddressFromIEAccounts(
        InboundEmail $inboundEmail, $storedOptions, $prependSignature, $isPersonalEmailAccount, $isGroupEmailAccount, $emailSignatures, $defaultEmailSignature
    ) {
        $dataAddress = $this->getDataAddressArrayFromIEAccounts($inboundEmail, $storedOptions, $prependSignature, $isPersonalEmailAccount, $isGroupEmailAccount);

        $emailSignatureId = $this->getEmailSignatureId($emailSignatures, $inboundEmail);

        $signature = $this->currentUser->getSignature($emailSignatureId);
        if (!$signature) {
            // TODO: needs to validate email signature
            if ($defaultEmailSignature['no_default_available'] === true) {
                $dataAddress['emailSignatures'] = $defaultEmailSignature;
            } else {
                $dataAddress['emailSignatures'] = array(
                    'html' => utf8_encode(html_entity_decode($defaultEmailSignature['signature_html'])),
                    'plain' => $defaultEmailSignature['signature'],
                );
            }
        } else {
            $dataAddress['emailSignatures'] = array(
                'html' => utf8_encode(html_entity_decode($signature['signature_html'])),
                'plain' => $signature['signature'],
            );
        }
        return $dataAddress;
    }

    /**
     * 
     * @param array $dataAddresses
     * @param array $defaultEmailSignature
     * @param string $prependSignature
     * @return array
     */
    protected function fillDataAddress($dataAddresses, $defaultEmailSignature, $prependSignature) {
        $dataAddressesWithUserAddresses = $this->fillDataAddressFromUserAddresses(
                $dataAddresses, $defaultEmailSignature, $prependSignature
        );
        $dataAddressesWithUserAddressesAndMailerSettings = $this->fillDataAddressWithSystemMailerSettings($dataAddressesWithUserAddresses, $defaultEmailSignature);

        return $dataAddressesWithUserAddressesAndMailerSettings;
    }
    
    /**
     * 
     * @param array $dataAddresses
     * @param array $defaultEmailSignature
     * @param string $prependSignature
     * @return array
     */
    protected function fillDataAddressFromUserAddresses($dataAddresses, $defaultEmailSignature, $prependSignature) {
        if (isset($this->sugarConfig['email_allow_send_as_user']) && $this->sugarConfig['email_allow_send_as_user']) {
            $sugarEmailAddress = new SugarEmailAddress();
            $userAddressesArr = $sugarEmailAddress->getAddressesByGUID($this->currentUser->id, 'Users');
            $dataAddresses = $this->collectDataAddressesFromUserAddresses(
                    $dataAddresses, $userAddressesArr, $defaultEmailSignature, $prependSignature
            );
        }
        return $dataAddresses;
    }
    
    /**
     * 
     * @param array $dataAddresses
     * @param array $defaultEmailSignature
     * @return array
     */
    protected function fillDataAddressWithSystemMailerSettings($dataAddresses, $defaultEmailSignature) {
        $this->collector->setOe(new OutboundEmail());
        if ($this->collector->getOe()->isAllowUserAccessToSystemDefaultOutbound()) {
            $system = $this->collector->getOe()->getSystemMailerSettings();
            $dataAddresses[] = $this->getFillDataAddressArray(
                    $system->id, $system->name, $system->smtp_from_name, $system->smtp_from_addr, $system->mail_smtpuser, $defaultEmailSignature
            );
        }
        return $dataAddresses;
    }

    /**
     * 
     * @param array $storedOptions
     * @return OutboundEmail
     */
    protected function getOutboundEmailOrErrorByStoredOptions($storedOptions) {
        $this->oe = new OutboundEmail();
        if (!$this->oe->retrieve($storedOptions['outbound_email'])) {
            // exception
            LoggerManager::getLogger()->error('Trying to retrieve an OutboundEmail by ID: ' . $storedOptions['outbound_email'] . ' but it is not found.');
            $this->err = self::ERR_STORED_OUTBOUND_EMAIL_NOT_FOUND;
        }
        return $this->oe;
    }

    /**
     * 
     * @param array $storedOptions
     * @return string
     */
    protected function getReplyToOnError($storedOptions) {
        if (!isset($storedOptions['reply_to_addr'])) {
            LoggerManager::getLogger()->warn('Stored reply to address is not set.');
        } elseif (!$storedOptions['reply_to_addr']) {
            LoggerManager::getLogger()->warn('Stored reply to address is not filled.');
        }
        $this->replyTo = isset($storedOptions['reply_to_addr']) ? $storedOptions['reply_to_addr'] : null;
        return $this->replyTo;
    }

    /**
     * 
     * @param array $storedOptions
     * @return string
     */
    protected function getFromNameOnError($storedOptions) {
        if (!isset($storedOptions['from_name'])) {
            LoggerManager::getLogger()->warn('Stored from name is not set.');
        } elseif (!$storedOptions['from_name']) {
            LoggerManager::getLogger()->warn('Stored from name is not filled.');
        }
        $this->fromName = isset($storedOptions['from_name']) ? $storedOptions['from_name'] : null;
        return $this->fromName;
    }

    /**
     * 
     * @param array $storedOptions
     * @return string
     */
    protected function getFromAddrOnError($storedOptions) {
        if (!isset($storedOptions['from_addr'])) {
            LoggerManager::getLogger()->warn('Stored from address is not set.');
        } elseif (!$storedOptions['from_addr']) {
            LoggerManager::getLogger()->warn('Stored from address is not filled.');
        }
        $this->fromAddr = isset($storedOptions['from_addr']) ? $storedOptions['from_addr'] : null;
        return $this->fromAddr;
    }
    
}

/**
 *
 * @author gyula
 */
class EmailsControllerActionGetFromFields {
    
    const ERR_REPLY_TO_FROMAT_INVALID_AS_FROM = 101;
    const ERR_REPLY_TO_FROMAT_INVALID_NO_NAME = 102;
    const ERR_REPLY_TO_FROMAT_INVALID_NO_ADDR = 103;

    /**
     *
     * @var User
     */
    protected $currentUser;

    /**
     *
     * @var array
     */
    protected $sugarConfig;
    
    /**
     *
     * @var EmailsControllerActionGetFromFieldsDataAddressCollector 
     */
    protected $collector;

    /**
     *
     * @param User $currentUser
     * @param array $sugarConfig
     */
    public function __construct(User $currentUser, $sugarConfig, EmailsControllerActionGetFromFieldsDataAddressCollector $collector) {
        $this->currentUser = $currentUser;
        $this->sugarConfig = $sugarConfig;
        $this->collector = $collector;
    }

    /**
     * 
     * @param Email $email
     * @param InboundEmail $ie
     * @return string JSON
     */
    public function handleActionGetFromFields(Email $email, InboundEmail $ie) {
        $email->email2init();
        $ie->email = $email;
        $ieAccounts = $ieAccountsFull = $ie->retrieveAllByGroupIdWithGroupAccounts($this->currentUser->id);
        $accountSignatures = $this->currentUser->getPreference('account_signatures', 'Emails');
        $showFolders = unserialize(base64_decode($this->currentUser->getPreference('showFolders', 'Emails')));
        $emailSignatures = $this->getEmailSignatures($accountSignatures);
        $defaultEmailSignature = $this->getDefaultSignatures();
        $prependSignature = $this->currentUser->getPreference('signature_prepend');
        $dataAddresses = $this->collector->collectDataAddressesFromIEAccounts(
            $ieAccounts, $showFolders, $prependSignature, $emailSignatures, $defaultEmailSignature
        );

        $dataEncoded = json_encode(array('data' => $dataAddresses), JSON_UNESCAPED_UNICODE);
        $results = utf8_decode($dataEncoded);
        return $results;
    }

    /**
     * 
     * @param string $id
     * @param string $name
     * @param string $fromName
     * @param string $fromAddr
     * @param string $mailUser
     * @param array $defaultEmailSignature
     * @return array
     */
    protected function getFillDataAddressArray($id, $name, $fromName, $fromAddr, $mailUser, $defaultEmailSignature) {
        $dataAddress = new EmailsControllerActionGetFromFieldsDataAddress();
        $dataArray = $dataAddress->getDataArray(
            'system', 
            $id, 
            "$fromName &lt;$fromAddr&gt;", 
            "$fromName &lt;$fromAddr&gt;", 
            $fromName, 
            false, 
            false, 
            true, 
            $id, 
            $name, 
            $mailUser, 
            $defaultEmailSignature
        );
        return $dataArray;
    }
    
    /**
     * 
     * @param array $dataAddresses
     * @param array $userAddressesArr
     * @param array $defaultEmailSignature
     * @param string $prependSignature
     * @return array
     */
    protected function collectDataAddressesFromUserAddresses(
        $dataAddresses, $userAddressesArr, $defaultEmailSignature, $prependSignature
    ) {
        foreach ($userAddressesArr as $userAddress) {
            if (!isset($userAddress['reply_to_addr']) || !$userAddress['reply_to_addr']) {
                LoggerManager::getLogger()->error('EmailController::action_getFromFields() is Panicking: Reply-To address is not filled.');
            }
            $fromString = $this->getFromString($userAddress);
            $signatureHtml = $this->getSignatureHtml($defaultEmailSignature);
            $signatureTxt = $this->getSignatureTxt($defaultEmailSignature);

            $dataAddresses[] = $this->getCollectDataAddressArrayFromUserAddresses(
                    $userAddress, $fromString, $prependSignature, $signatureHtml, $signatureTxt);
        }

        return $dataAddresses;
    }

    /**
     * 
     * @param array $userAddress
     * @param string $fromString
     * @param string $prependSignature
     * @param string $signatureHtml
     * @param string $signatureTxt
     * @return array
     */
    protected function getCollectDataAddressArrayFromUserAddresses($userAddress, $fromString, $prependSignature, $signatureHtml, $signatureTxt) {
        $dataAddress = new EmailsControllerActionGetFromFieldsDataAddress();
        $dataArray = $dataAddress->getDataArray(
            'personal', 
            $userAddress['email_address_id'], 
            $this->currentUser->full_name . ' &lt;' . $userAddress['email_address'] . '&gt;', 
            $fromString, 
            $this->currentUser->full_name, 
            null, 
            $prependSignature, 
            true,
            false, 
            null, 
            null, [
                'html' => utf8_encode(html_entity_decode($signatureHtml)),
                'plain' => $signatureTxt,
            ]);
        return $dataArray;
    }

    /**
     * 
     * @param array $defaultEmailSignature
     * @return string
     */
    protected function getSignatureTxt($defaultEmailSignature) {
        if (!isset($defaultEmailSignature['signature'])) {
            LoggerManager::getLogger()->warn('EmailController::action_getFromFields() is Panicking: Default email signature array does not have index as signature');
            $signatureTxt = null;
        } else {
            $signatureTxt = $defaultEmailSignature['signature'];
        }
        return $signatureTxt;
    }

    /**
     * 
     * @param array $defaultEmailSignature
     * @return string
     */
    protected function getSignatureHtml($defaultEmailSignature) {
        if (!isset($defaultEmailSignature['signature_html'])) {
            LoggerManager::getLogger()->warn('EmailController::action_getFromFields() is Panicking: Default email signature array does not have index as signature_html');
            $signatureHtml = null;
        } else {
            $signatureHtml = $defaultEmailSignature['signature_html'];
        }
        return $signatureHtml;
    }

    /**
     * 
     * @param array $userAddress
     * @return string
     */
    protected function getFromString($userAddress) {
        if (isset($userAddress['reply_to_addr']) && $userAddress['reply_to_addr'] === '1') {
            $fromString = $this->currentUser->full_name . ' &lt;' . $userAddress['email_address'] . '&gt;';
        } else {
            $fromString = $this->currentUser->full_name . ' &lt;' . $this->currentUser->email1 . '&gt;';
        }
        return $fromString;
    }

    /**
     *
     * @param string|null $accountSignatures
     * @return array|null
     */
    protected function getEmailSignatures($accountSignatures = null) {
        if ($accountSignatures != null) {
            $emailSignatures = unserialize(base64_decode($accountSignatures));
        } else {
            $GLOBALS['log']->warn('User ' . $this->currentUser->name . ' does not have a signature');
            $emailSignatures = null;
        }

        return $emailSignatures;
    }

    /**
     *
     * @return array
     */
    protected function getDefaultSignatures() {
        $defaultEmailSignature = $this->currentUser->getDefaultSignature();
        if (empty($defaultEmailSignature)) {
            $defaultEmailSignature = array(
                'html' => '<br>',
                'plain' => '\r\n',
            );
            $defaultEmailSignature['no_default_available'] = true;
        } else {
            $defaultEmailSignature['no_default_available'] = false;
        }

        return $defaultEmailSignature;
    }

    /**
     * 
     * @param InboundEmail $inboundEmail
     * @param array $storedOptions
     * @param string $prependSignature
     * @param bool $isPersonalEmailAccount
     * @param bool $isGroupEmailAccount
     * @return array
     */
    protected function getDataAddressArrayFromIEAccounts(InboundEmail $inboundEmail, $storedOptions, $prependSignature, $isPersonalEmailAccount, $isGroupEmailAccount) {
        $dataAddress = new EmailsControllerActionGetFromFieldsDataAddress();
        $dataArray = $dataAddress->getDataArray(
            $inboundEmail->module_name, 
            $inboundEmail->id, 
            $storedOptions['reply_to_addr'], 
            $storedOptions['from_addr'], 
            $storedOptions['from_name'], 
            null, 
            $prependSignature, 
            $isPersonalEmailAccount, 
            $isGroupEmailAccount, 
            $this->collector->getOeId(), 
            $this->collector->getOeName(), 
            []
        );
        return $dataArray;
    }

    /**
     * 
     * @param array $emailSignatures
     * @param InboundEmail $inboundEmail
     * @return string
     */
    protected function getEmailSignatureId($emailSignatures, InboundEmail $inboundEmail) {

        // Include signature
        if (isset($emailSignatures[$inboundEmail->id]) && !empty($emailSignatures[$inboundEmail->id])) {
            $emailSignatureId = $emailSignatures[$inboundEmail->id];
        } else {
            $emailSignatureId = '';
        }
        return $emailSignatureId;
    }

    /**
     * 
     * @param string $tmpName
     * @param string $tmpAddr
     * @param EmailFromValidator $emailFromValidator
     * @param int $replyToErr
     */
    protected function validateForLogReplyToError($tmpName, $tmpAddr, EmailFromValidator $emailFromValidator, &$replyToErr) {
        $tmpEmail = new Email();
        $tmpEmail->FromName = $tmpEmail->from_name = $tmpName;
        $tmpEmail->From = $tmpEmail->from_addr = $tmpAddr;
        $tmpEmail->from_addr_name = $this->collector->getReplyTo();

        if (!$emailFromValidator->isValid($tmpEmail)) {
            // exception
            LoggerManager::getLogger()->error('EmailController::action_getFromFields() panic: An Outbound Email Reply-to Address is invalid.');
            $replyToErr = self::ERR_REPLY_TO_FROMAT_INVALID_AS_FROM;
        }
    }

    /**
     * 
     * @param array $splits
     * @param int $replyToErr
     * @return string
     */
    protected function getTmpNameForLogReplyToError($splits, &$replyToErr) {

        if (!isset($splits[0])) {
            LoggerManager::getLogger()->error('Reply-to name part not found: ' . $this->collector->getReplyTo());
            $replyToErr = self::ERR_REPLY_TO_FROMAT_INVALID_NO_NAME;
        }
        $tmpName = isset($splits[0]) ? $splits[0] : null;
        return $tmpName;
    }

    /**
     * 
     * @param array $splits
     * @param int $replyToErr
     * @return string
     */
    protected function getTmpAddrForLogReplyToError($splits, &$replyToErr) {

        if (!isset($splits[1])) {
            LoggerManager::getLogger()->error('Reply-to email address part not found: ' . $this->collector->getReplyTo());
            $replyToErr = self::ERR_REPLY_TO_FROMAT_INVALID_NO_ADDR;
        }
        $tmpAddr = isset($splits[1]) ? $splits[1] : null;
        return $tmpAddr;
    }

}
