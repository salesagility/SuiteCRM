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


require_once __DIR__ . '/ImapHandler.php';

/**
 * ImapHandlerFactory
 *
 * @author gyula
 */
class ImapHandlerFactory
{
    const ERR_TEST_SET_NOT_FOUND = 1;
    const ERR_TEST_SET_NOT_EXISTS = 2;
    const ERR_KEY_NOT_FOUND = 3;
    const ERR_KEY_SAVE_ERROR = 4;
    
    const SETTINGS_KEY_FILE = __DIR__ . '/ImapTestSettings.txt';
    
    /**
     *
     * @var ImapHandlerInterface
     */
    protected $interfaceObject = null;
    
    /**
     *
     * @var array
     */
    protected $imapHandlerTestInterface = [
        'file' => 'include/Imap/ImapHandlerFake.php',
        'class' => 'ImapHandlerFake',
        'calls' => 'include/Imap/ImapHandlerFakeCalls.php',
    ];
    
    /**
     *
     */
    protected function includeFakeInterface()
    {
        if (!class_exists($this->imapHandlerTestInterface['class'])) {
            require_once $this->imapHandlerTestInterface['file'];
        }
    }
    
    /**
     *
     * @global array $sugar_config
     * @param string $testSettings
     * @throws Exception
     */
    protected function loadTestSettings($testSettings = null)
    {
        if (!$testSettings) {
            if (file_exists(self::SETTINGS_KEY_FILE)) {
                $testSettings = file_get_contents(self::SETTINGS_KEY_FILE);
            }
            if (!$testSettings) {
                throw new Exception("Test settings not set.", self::ERR_TEST_SET_NOT_FOUND);
            }
        }
        $this->includeFakeInterface();
        $interfaceClass = $this->imapHandlerTestInterface['class'];
        $interfaceCallsSettings = include $this->imapHandlerTestInterface['calls'];

        if (!isset($interfaceCallsSettings[$testSettings])) {
            throw new Exception("Test settings does not exists: $testSettings", self::ERR_TEST_SET_NOT_EXISTS);
        }

        $interfaceCalls = $interfaceCallsSettings[$testSettings];
        $interfaceFakeData = new ImapHandlerFakeData();
        $interfaceFakeData->retrieve($interfaceCalls);
        $this->interfaceObject = new $interfaceClass($interfaceFakeData);
    }
    
    /**
     * 
     * @param string $key
     * @return boolean
     * @throws Exception
     */
    public function saveTestSettingsKey($key)
    {
        $calls = include $this->imapHandlerTestInterface['calls'];

        if (!isset($calls[$key])) {
            throw new Exception('Key not found: ' . $key, self::ERR_KEY_NOT_FOUND);
        } else {
            if (!file_put_contents(ImapHandlerFactory::SETTINGS_KEY_FILE, $key)) {
                throw new Exception('Key save error', self::ERR_KEY_SAVE_ERROR);
            } else {
                return true;
            }
        }
        return false;
    }
    
    /**
     *
     * @global array $sugar_config
     * @param string $testSettings
     * @return ImapHandlerInterface
     * @throws Exception
     */
    public function getImapHandler($testSettings = null)
    {
        if (null === $this->interfaceObject) {
            global $sugar_config;
            $test = isset($sugar_config['imap_test']) && $sugar_config['imap_test'];
            
            if ($sugar_config['developerMode']) {
                $logErrors = true;
                $logCalls = true;
            } else {
                $logErrors = true;
                $logCalls = false;
            }
            
            $interfaceClass = ImapHandler::class;
            if ($test) {
                $this->loadTestSettings($testSettings);
            } else {
                $this->interfaceObject = new $interfaceClass($logErrors, $logCalls);
            }
        }
        return $this->interfaceObject;
    }
}
