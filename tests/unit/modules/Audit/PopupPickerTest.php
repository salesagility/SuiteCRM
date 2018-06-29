<?php

require_once 'modules/Audit/Popup_picker.php';

class PopupPickerTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract {    
    
    public function testProcessPage() {
        
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
        $this->assertEquals("<!DOCTYPE HTML>
<html lang='en_us'>
<head><title>SuiteCRM - Open Source CRM</title><link href=\"themes/SuiteP/css/bootstrap.min.css\" rel=\"stylesheet\">
            <!-- qtip & suggestion box -->
            <link rel=\"stylesheet\" type=\"text/css\" href=\"include/javascript/qtip/jquery.qtip.min.css\" /><link rel=\"stylesheet\" type=\"text/css\" href=\"include/javascript/jquery/themes/base/jquery.ui.all.css\" /><link rel=\"stylesheet\" type=\"text/css\" href=\"cache/themes/SuiteP/css/Dawn/style.css?v=L22H1-w31lhOpn6PgQjpkA\" /><meta http-equiv=\"Content-Type\" content=\"text/html; charset=\"{\$charset}\"><script type=\"text/javascript\" src=\"cache/include/javascript/sugar_grp1_jquery.js?v=L22H1-w31lhOpn6PgQjpkA\"></script><script type=\"text/javascript\" src=\"cache/include/javascript/sugar_grp1_yui.js?v=L22H1-w31lhOpn6PgQjpkA\"></script><script type=\"text/javascript\" src=\"cache/include/javascript/sugar_grp1.js?v=L22H1-w31lhOpn6PgQjpkA\"></script><meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"><meta name=\"viewport\" content=\"initial-scale=1.0, user-scalable=no\" /></head><body class=\"popupBody\"><table width='100%' cellpadding='0' cellspacing='0'><tr><td><div class='moduleTitle'>
<h2>Change Log</h2>
<div class='clear'><span class='utils'><a href=\"javascript:void window.open('index.php?','printwin','menubar=1,status=0,resizable=1,scrollbars=1,toolbar=0,location=1')\" class='utilsLink'>
<!--not_in_theme!--><img src=\"themes/default/images/print.gif?v=L22H1-w31lhOpn6PgQjpkA\" alt=\"Print\"></a>
<a href=\"javascript:void window.open('index.php?','printwin','menubar=1,status=0,resizable=1,scrollbars=1,toolbar=0,location=1')\" class='utilsLink'>
Print
</a></span></div><span class='utils'><a href=\"javascript:void window.open('index.php?','printwin','menubar=1,status=0,resizable=1,scrollbars=1,toolbar=0,location=1')\" class='utilsLink'>
<!--not_in_theme!--><img src=\"themes/default/images/print.gif?v=L22H1-w31lhOpn6PgQjpkA\" alt=\"Print\"></a>
<a href=\"javascript:void window.open('index.php?','printwin','menubar=1,status=0,resizable=1,scrollbars=1,toolbar=0,location=1')\" class='utilsLink'>
Print
</a></span></div>
<table><tr><td >Fields audited in this module: Lawful Basis Date Reviewed, Do Not Call, Office Phone, Assigned User, Lawful Basis, Lawful Basis Source</td></tr></table>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\" class=\"list view\" style=\"table-layout:fixed\">
<tr height=\"20\" >
<td width=\"1%\" ><img src=\"include/images/blank.gif\" width=\"1\" height=\"1\" alt=\"\"></td>
<td width=\"15%\" ></td>
<td width=\"25%\" ></td>
<td width=\"25%\" ></td>
<td width=\"15%\" ></td>
<td width=\"19%\"  nowrap></td>
</tr>

</table>
</body>
</html>", $output);
        
        $state->popTable('aod_indexevent');
        $state->popTable('contacts_cstm');
        $state->popTable('contacts');
        $state->popTable('sugarfeed');
        $state->popGlobals();
    }
    
}
