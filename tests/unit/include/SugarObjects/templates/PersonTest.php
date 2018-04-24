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

class PersonTest extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSetLawfulBasis()
    {

        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('aod_indexevent');
        $state->pushTable('contacts');
        $state->pushTable('contacts_cstm');
        $state->pushTable('sugarfeed');


        $person = new Contact();
        $person->last_name = 'Smith';

        // Test when  basis is not a string
        $this->tester->expectException(
             new InvalidArgumentException('basis must be a string'),
             function() use ($person) {
                 $person->setLawfulBasis(1, '');
             }
        );

        // test when basis does not exist
        $this->tester->expectException(
            new InvalidArgumentException('invalid lawful basis'),
            function() use ($person) {
                $person->setLawfulBasis('Test Invalid Basis', '');
            }
        );

        // test valid basis
        $this->assertEquals(1, $person->setLawfulBasis('', ''));
        $this->assertEquals(1, $person->setLawfulBasis('consent', ''));
        $this->assertEquals(1, $person->setLawfulBasis('contract', ''));
        $this->assertEquals(1, $person->setLawfulBasis('legal_obligation', ''));
        $this->assertEquals(1, $person->setLawfulBasis('protection_of_interest', ''));
        $this->assertEquals(1, $person->setLawfulBasis('public_interest', ''));
        $this->assertEquals(1, $person->setLawfulBasis('legitimate_interest', ''));
        $this->assertEquals(1, $person->setLawfulBasis('withdrawn', ''));

        // test lawful basis has been set
        $person->setLawfulBasis('consent', '');
        $this->assertEquals($person->lawful_basis, '^consent^');

        // Test when source is not a string
        $this->tester->expectException(
            new InvalidArgumentException('source for lawful basis must be a string'),
            function() use ($person) {
                $person->setLawfulBasis('', 1);
            }
        );

        // test when source does not exist
        $this->tester->expectException(
            new InvalidArgumentException('invalid lawful basis source'),
            function() use ($person) {
                $person->setLawfulBasis('','Test Invalid Sources');
            }
        );

        // test lawful sources
        $this->assertEquals(true, $person->setLawfulBasis('', ''));
        $this->assertEquals(true, $person->setLawfulBasis('', 'website'));
        $this->assertEquals(true, $person->setLawfulBasis('', 'phone'));
        $this->assertEquals(true, $person->setLawfulBasis('', 'given_to_user'));
        $this->assertEquals(true, $person->setLawfulBasis('', 'email'));
        $this->assertEquals(true, $person->setLawfulBasis('', 'third_party'));

        // test that source is being set
        $this->assertEquals('third_party', $person->lawful_basis_source);

        $state->popTable('aod_indexevent');
        $state->popTable('contacts');
        $state->popTable('contacts_cstm');
        $state->popTable('sugarfeed');
        $state->popGlobals();
    }
}