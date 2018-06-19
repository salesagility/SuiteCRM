<?php

require_once 'modules/iCals/iCal.php';
class iCalTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function test__construct()
    {
        self::markTestIncomplete('environment dependency');
        
	// save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('email_addresses');
        $state->pushGlobals();
        
	// test
        
        //execute the contructor and check for the Object type and  attributes
        $ical = new iCal();
        $this->assertInstanceOf('iCal', $ical);
        $this->assertInstanceOf('vCal', $ical);
        $this->assertInstanceOf('SugarBean', $ical);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('email_addresses');
    }

//    public function testgetVcalIcal()
//    {
//	// save state
//



//        
//	// test
//        
//        

//


//
//        //break the string in two pieces leaving out date part.


//

//
//        //match the leading and trailing string parts to verify it returns expected results


//        
//        // clean up
//        


//    }
}
