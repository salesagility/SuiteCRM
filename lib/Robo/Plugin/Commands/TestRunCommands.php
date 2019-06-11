<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
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
namespace SuiteCRM\Robo\Plugin\Commands;

class TestRunCommands extends \Robo\Tasks
{
    use \SuiteCRM\Robo\Traits\RoboTrait;

    /**
     * Run install test suite.
     * @param array $opts
     * @option boolean verbose Whether to set the test suite to output extra information. Good for debugging.
     * @option boolean fail-fast Stop after first failure.
     */
    public function TestsInstall($opts = ['verbose' => false, 'fail-fast' => false]) {
      $this->say('Running Install Test Suite.');

      $command = './vendor/bin/codecept run install --env chrome-driver';

      if ($opts['verbose']) {
        $command .= ' -vvv -d';
      }
      if ($opts['fail-fast']) {
        $command .= ' -f';
      }
      
      $this->_exec($command);
    }

    /**
     * Run API test suite.
     * @param array $opts
     * @option boolean verbose Whether to set the test suite to output extra information. Good for debugging.
     * @option boolean fail-fast Stop after first failure.
     */
    public function TestsAPI($opts = ['verbose' => false, 'fail-fast' => false]) {
      $this->say('Running API Test Suite.');

      $command = './vendor/bin/codecept run api';

      if ($opts['verbose']) {
        $command .= ' -vvv -d';
      }
      if ($opts['fail-fast']) {
        $command .= ' -f';
      }
      
      $this->_exec($command);
    }

    /**
     * Run acceptance test suite.
     * @param array $opts
     * @option boolean verbose Whether to set the test suite to output extra information. Good for debugging.
     * @option boolean fail-fast Stop after first failure.
     */
    public function TestsAcceptance($opts = ['verbose' => false, 'fail-fast' => false]) {
      $this->say('Running Codeception Acceptance Test Suite.');

      $command = './vendor/bin/codecept run acceptance --env chrome-driver';

      if ($opts['verbose']) {
        $command .= ' -vvv -d';
      }
      if ($opts['fail-fast']) {
        $command .= ' -f';
      }
      
      $this->_exec($command);
    }

    /**
     * Run PHPUnit unit test suite.
     * @param array $opts
     * @option boolean verbose Whether to set the test suite to output extra information. Good for debugging.
     * @option boolean fail-fast Stop after first failure.
     */
    public function TestsUnit($opts = ['verbose' => false, 'fail-fast' => false]) {
      $this->say('Running PHPUnit Unit Test Suite.');

      $command = './vendor/bin/phpunit --colors --configuration ./tests/phpunit.xml.dist ./tests/unit/phpunit';
      
      if ($opts['verbose']) {
        $command .= ' -v --debug';
      }
      if ($opts['fail-fast']) {
        $command .= ' --stop-on-error --stop-on-failure';
      }

      $this->_exec($command);
    }
}
