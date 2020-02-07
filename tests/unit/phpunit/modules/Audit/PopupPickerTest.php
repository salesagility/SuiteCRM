<?php

require_once 'modules/Audit/Popup_picker.php';

class PopupPickerTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testProcessPage()
    {
        $state = new \SuiteCRM\StateSaver();
        
        $state->pushGlobals();
        $state->pushTable('sugarfeed');
        $state->pushTable('contacts');
        $state->pushTable('contacts_cstm');
        $state->pushTable('aod_indexevent');
        
        
        global $focus;
        $focus = BeanFactory::getBean('Contacts');
        $focus->name = 'test';
        $focus->save();
        
        ob_start();
        $popupPicker = new Popup_Picker();
        $result = $popupPicker->process_page();
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertTrue(is_null($result));
        $this->assertNotEmpty($output);
        $this->assertContains('<!DOCTYPE HTML>', $output);
        $this->assertContains('<html lang=\'en_us\'>', $output);
        $this->assertContains('<title>SuiteCRM - Open Source CRM</title>', $output);
        $this->assertContains('<link rel="stylesheet" type="text/css" href="cache/themes/SuiteP/css/Dawn/style.css', $output);
        $this->assertContains('<meta http-equiv="Content-Type" content="text/html; charset="{$charset}">', $output);
        $this->assertContains('<body class="popupBody">', $output);
        $this->assertContains('<div class=\'moduleTitle\'>', $output);
        $this->assertContains('<img src="themes/default/images/print.gif', $output);
        $this->assertContains('Fields audited in this module: Lawful Basis Date Reviewed, Do Not Call, Office Phone, Assigned User, Lawful Basis, Lawful Basis Source', $output);
        
        $state->popTable('aod_indexevent');
        $state->popTable('contacts_cstm');
        $state->popTable('contacts');
        $state->popTable('sugarfeed');
        $state->popGlobals();
    }
}
