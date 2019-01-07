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

/**
 *
 * @author gyula
 */
class EmailsControllerActionGetFromFields {

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
    protected $err;
    protected $oe;
    // ------------------ FROM DATA STRUCT -------------------
    protected $replyTo;
    protected $fromAddr;
    protected $fromName;
    protected $oeId;
    protected $oeName;

    // -------------------------------------------------------

    /**
     *
     * @param User $currentUser
     * @param array $sugarConfig
     */
    public function __construct(User $currentUser, $sugarConfig) {
        $this->currentUser = $currentUser;
        $this->sugarConfig = $sugarConfig;
    }

    public function handleActionGetFromFields(Email $email, InboundEmail $ie) {
        $email->email2init();
        $ie->email = $email;
        $ieAccounts = $ieAccountsFull = $ie->retrieveAllByGroupIdWithGroupAccounts($this->currentUser->id);
        $accountSignatures = $this->currentUser->getPreference('account_signatures', 'Emails');
        $showFolders = unserialize(base64_decode($this->currentUser->getPreference('showFolders', 'Emails')));
        $emailSignatures = $this->getEmailSignatures($accountSignatures);
        $defaultEmailSignature = $this->getDefaultSignatures();
        $prependSignature = $this->currentUser->getPreference('signature_prepend');
        $dataAddresses = $this->collectDataAddressesFromIEAccounts(
                $ieAccounts, $showFolders, $prependSignature, $emailSignatures, $defaultEmailSignature
        );

        $dataEncoded = json_encode(array('data' => $dataAddresses), JSON_UNESCAPED_UNICODE);
        $results = utf8_decode($dataEncoded);
        return $results;
    }

    protected function fillDataAddress($dataAddresses, $defaultEmailSignature, $prependSignature) {
        $dataAddressesWithUserAddresses = $this->fillDataAddressFromUserAddresses(
                $dataAddresses, $defaultEmailSignature, $prependSignature
        );
        $dataAddressesWithUserAddressesAndMailerSettings = $this->fillDataAddressWithSystemMailerSettings($dataAddressesWithUserAddresses, $defaultEmailSignature);

        return $dataAddressesWithUserAddressesAndMailerSettings;
    }

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

    protected function fillDataAddressWithSystemMailerSettings($dataAddresses, $defaultEmailSignature) {
        $this->oe = new OutboundEmail();
        if ($this->oe->isAllowUserAccessToSystemDefaultOutbound()) {
            $system = $this->oe->getSystemMailerSettings();
            $dataAddresses[] = $this->getFillDataAddressArray(
                    $system->id, $system->name, $system->smtp_from_name, $system->smtp_from_addr, $system->mail_smtpuser, $defaultEmailSignature
            );
        }
        return $dataAddresses;
    }

    protected function getFillDataAddressArray($id, $name, $fromName, $fromAddr, $mailUser, $defaultEmailSignature) {
        return [
            'type' => 'system',
            'id' => $id,
            'attributes' => $this->getFillDataAddressAttributes(
                    utf8_encode($fromName), utf8_encode($fromAddr), utf8_encode($mailUser)
            ),
            'prepend' => false,
            'isPersonalEmailAccount' => false,
            'isGroupEmailAccount' => true,
            'outboundEmail' => $this->getFillDataAddressOutboundEmail($id, $name),
            'emailSignatures' => $defaultEmailSignature,
        ];
    }

    protected function getFillDataAddressAttributes($fromName, $fromAddr, $mailUser) {
        return [
            'reply_to' => "$fromName &lt;$fromAddr&gt;",
            'from' => "$fromName &lt;$fromAddr&gt;",
            'name' => $fromName,
            'oe' => $mailUser,
        ];
    }

    protected function getFillDataAddressOutboundEmail($id, $name) {
        return [
            'id' => $id,
            'name' => $name,
        ];
    }

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

    protected function getCollectDataAddressArrayFromUserAddresses($userAddress, $fromString, $prependSignature, $signatureHtml, $signatureTxt) {
        return [
            'type' => 'personal',
            'id' => $userAddress['email_address_id'],
            'attributes' => array(
                'from' => utf8_encode($fromString),
                'reply_to' => utf8_encode($this->currentUser->full_name . ' &lt;' . $userAddress['email_address'] . '&gt;'),
                'name' => utf8_encode($this->currentUser->full_name),
            ),
            'prepend' => $prependSignature,
            'isPersonalEmailAccount' => true,
            'isGroupEmailAccount' => false,
            'emailSignatures' => array(
                'html' => utf8_encode(html_entity_decode($signatureHtml)),
                'plain' => $signatureTxt,
            ),
        ];
    }

    protected function getSignatureTxt($defaultEmailSignature) {
        if (!isset($defaultEmailSignature['signature'])) {
            LoggerManager::getLogger()->warn('EmailController::action_getFromFields() is Panicking: Default email signature array does not have index as signature');
            $signatureTxt = null;
        } else {
            $signatureTxt = $defaultEmailSignature['signature'];
        }
        return $signatureTxt;
    }

    protected function getSignatureHtml($defaultEmailSignature) {
        if (!isset($defaultEmailSignature['signature_html'])) {
            LoggerManager::getLogger()->warn('EmailController::action_getFromFields() is Panicking: Default email signature array does not have index as signature_html');
            $signatureHtml = null;
        } else {
            $signatureHtml = $defaultEmailSignature['signature_html'];
        }
        return $signatureHtml;
    }

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
     * @throws InvalidArgumentException
     */
    protected function validateInboundEmail($inboundEmail = null) {
        if (!$inboundEmail instanceof InboundEmail) {
            throw new InvalidArgumentException('Inbound Email Account should be a valid Inbound Email. ' . gettype($inboundEmail) . ' given.', self::ERR_INVALID_INBOUND_EMAIL_TYPE);
        }
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

    protected function getDataAddressFromIEAccounts(
    InboundEmail $inboundEmail, $storedOptions, $prependSignature, $isPersonalEmailAccount, $isGroupEmailAccount, $emailSignatures, $defaultEmailSignature
    ) {
        $dataAddress = $this->getDataAddressArrayFromIEAccounts($inboundEmail, $storedOptions, $prependSignature, $isPersonalEmailAccount, $isGroupEmailAccount);

        $emailSignatureId = $this->getEmailSignatureId($emailSignatures, $inboundEmail);

        $signature = $this->currentUser->getSignature($emailSignatureId);
        if (!$signature) {
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

    protected function getDataAddressArrayFromIEAccounts(InboundEmail $inboundEmail, $storedOptions, $prependSignature, $isPersonalEmailAccount, $isGroupEmailAccount) {

        return array(
            'type' => $inboundEmail->module_name,
            'id' => $inboundEmail->id,
            'attributes' => array(
                'reply_to' => utf8_encode($storedOptions['reply_to_addr']),
                'name' => utf8_encode($storedOptions['from_name']),
                'from' => utf8_encode($storedOptions['from_addr']),
            ),
            'prepend' => $prependSignature,
            'isPersonalEmailAccount' => $isPersonalEmailAccount,
            'isGroupEmailAccount' => $isGroupEmailAccount,
            'outboundEmail' => array(
                'id' => $this->oeId,
                'name' => $this->oeName,
            ),
        );
    }

    protected function getEmailSignatureId($emailSignatures, InboundEmail $inboundEmail) {

        // Include signature
        if (isset($emailSignatures[$inboundEmail->id]) && !empty($emailSignatures[$inboundEmail->id])) {
            $emailSignatureId = $emailSignatures[$inboundEmail->id];
        } else {
            $emailSignatureId = '';
        }
        return $emailSignatureId;
    }

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

    protected function validateForLogReplyToError($tmpName, $tmpAddr, EmailFromValidator $emailFromValidator, &$replyToErr) {

        $tmpEmail = new Email();
        $tmpEmail->FromName = $tmpEmail->from_name = $tmpName;
        $tmpEmail->From = $tmpEmail->from_addr = $tmpAddr;
        $tmpEmail->from_addr_name = $this->replyTo;

        if (!$emailFromValidator->isValid($tmpEmail)) {
            // exception
            LoggerManager::getLogger()->error('EmailController::action_getFromFields() panic: An Outbound Email Reply-to Address is invalid.');
            $replyToErr = self::ERR_REPLY_TO_FROMAT_INVALID_AS_FROM;
        }
    }

    protected function getTmpNameForLogReplyToError($splits, &$replyToErr) {

        if (!isset($splits[0])) {
            LoggerManager::getLogger()->error('Reply-to name part not found: ' . $this->replyTo);
            $replyToErr = self::ERR_REPLY_TO_FROMAT_INVALID_NO_NAME;
        }
        $tmpName = isset($splits[0]) ? $splits[0] : null;
        return $tmpName;
    }

    protected function getTmpAddrForLogReplyToError($splits, &$replyToErr) {

        if (!isset($splits[1])) {
            LoggerManager::getLogger()->error('Reply-to email address part not found: ' . $this->replyTo);
            $replyToErr = self::ERR_REPLY_TO_FROMAT_INVALID_NO_ADDR;
        }
        $tmpAddr = isset($splits[1]) ? $splits[1] : null;
        return $tmpAddr;
    }

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

    protected function getReplyToOnError($storedOptions) {


        if (!isset($storedOptions['reply_to_addr'])) {
            LoggerManager::getLogger()->warn('Stored reply to address is not set.');
        } elseif (!$storedOptions['reply_to_addr']) {
            LoggerManager::getLogger()->warn('Stored reply to address is not filled.');
        }
        $this->replyTo = isset($storedOptions['reply_to_addr']) ? $storedOptions['reply_to_addr'] : null;
        return $this->replyTo;
    }

    protected function getFromNameOnError($storedOptions) {
        if (!isset($storedOptions['from_name'])) {
            LoggerManager::getLogger()->warn('Stored from name is not set.');
        } elseif (!$storedOptions['from_name']) {
            LoggerManager::getLogger()->warn('Stored from name is not filled.');
        }
        $this->fromName = isset($storedOptions['from_name']) ? $storedOptions['from_name'] : null;
        return $this->fromName;
    }

    protected function getFromAddrOnError($storedOptions) {
        if (!isset($storedOptions['from_addr'])) {
            LoggerManager::getLogger()->warn('Stored from address is not set.');
        } elseif (!$storedOptions['from_addr']) {
            LoggerManager::getLogger()->warn('Stored from address is not filled.');
        }
        $this->fromAddr = isset($storedOptions['from_addr']) ? $storedOptions['from_addr'] : null;
        return $this->fromAddr;
    }

    protected function getOutboundEmailOrError($storedOptions, InboundEmail $inboundEmail) {
        $this->err = null;
        $this->oe = null;
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
                $this->oe = $this->getOutboundEmailOrErrorByStoredOptions($storedOptions);
            }
        }
    }

    protected function getOutboundEmailOrErrorByStoredOptions($storedOptions) {
        $this->oe = new OutboundEmail();
        if (!$this->oe->retrieve($storedOptions['outbound_email'])) {
            // exception
            LoggerManager::getLogger()->error('Trying to retrieve an OutboundEmail by ID: ' . $storedOptions['outbound_email'] . ' but it is not found.');
            $this->err = self::ERR_STORED_OUTBOUND_EMAIL_NOT_FOUND;
        }
        return $this->oe;
    }

}
