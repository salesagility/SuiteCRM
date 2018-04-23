<?php

class PersonTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSetLawfulBasis()
    {
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
        $this->assertEquals(0, $person->setLawfulBasis('', ''));
        $this->assertEquals(0, $person->setLawfulBasis('consent', ''));
        $this->assertEquals(0, $person->setLawfulBasis('contract', ''));
        $this->assertEquals(0, $person->setLawfulBasis('legal_obligation', ''));
        $this->assertEquals(0, $person->setLawfulBasis('protection_of_interest', ''));
        $this->assertEquals(0, $person->setLawfulBasis('public_interest', ''));
        $this->assertEquals(0, $person->setLawfulBasis('legitimate_interest', ''));
        $this->assertEquals(0, $person->setLawfulBasis('withdrawn', ''));

        // test lawful basis has been set
        $person->setLawfulBasis('consent', '');
        $this->assertEquals($person->lawful_basis, 'consent');

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
        $this->assertEquals(0, $person->setLawfulBasis('', ''));
        $this->assertEquals(0, $person->setLawfulBasis('', 'website'));
        $this->assertEquals(0, $person->setLawfulBasis('', 'phone'));
        $this->assertEquals(0, $person->setLawfulBasis('', 'given_to_user'));
        $this->assertEquals(0, $person->setLawfulBasis('', 'email'));
        $this->assertEquals(0, $person->setLawfulBasis('', 'third_party'));

        // test that source is being set
        $this->assertEquals('third_party', $person->lawful_basis_source);
    }
}