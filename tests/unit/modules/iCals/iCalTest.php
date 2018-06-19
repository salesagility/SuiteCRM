<?php

require_once 'modules/iCals/iCal.php';
class iCalTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function test__construct()
    {
        self::markTestIncomplete('environment dependency');
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('email_addresses');
        $state->pushGlobals();
        
	
        
        
        $ical = new iCal();
        $this->assertInstanceOf('iCal', $ical);
        $this->assertInstanceOf('vCal', $ical);
        $this->assertInstanceOf('SugarBean', $ical);
        
        
        
        $state->popGlobals();
        $state->popTable('email_addresses');
    }
































}
