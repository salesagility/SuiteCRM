<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once 'modules/Audit/Popup_picker.php';

class PopupPickerTest extends SuitePHPUnitFrameworkTestCase
{
    public function testProcessPage(): void
    {
        global $focus;
        $focus = BeanFactory::getBean('Contacts');
        $focus->name = 'test';
        $focus->save();

        ob_start();
        $result = (new Popup_Picker())->process_page();
        $output = ob_get_contents();
        ob_end_clean();
        self::assertNull($result);
        self::assertNotEmpty($output);
        self::assertContains('<!DOCTYPE HTML>', $output);
        self::assertContains('<html lang=\'en_us\'>', $output);
        self::assertContains('<title>SuiteCRM - Open Source CRM</title>', $output);
        self::assertContains('<link rel="stylesheet" type="text/css" href="cache/themes/SuiteP/css/Dawn/style.css', $output);
        self::assertContains('<meta http-equiv="Content-Type" content="text/html; charset="{$charset}">', $output);
        self::assertContains('<body class="popupBody">', $output);
        self::assertContains('<div class=\'moduleTitle\'>', $output);
        self::assertContains('<img src="themes/default/images/print.gif', $output);
        self::assertContains('Fields audited in this module: Lawful Basis Date Reviewed, Do Not Call, Office Phone, Assigned User, Lawful Basis, Lawful Basis Source', $output);
    }
}
