<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/SugarObjects/forms/FormBase.php';

class AOS_Products_QuotesFormBase extends FormBase
{
    public $moduleName = 'AOS_Products_Quotes';
    public $objectName = 'AOS_Products_Quotes';
    public function handleSave($prefix, $redirect = true, $useRequired = false)
    {
        require_once 'include/formbase.php';
        $focus = new AOS_Products_Quotes();
        $focus = populateFromPost($prefix, $focus);
        $focus->save();
    }
}
