<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/SugarObjects/forms/FormBase.php';

class AOS_InvoicesFormBase extends FormBase
{
    public $moduleName = 'AOS_Invoices';
    public $objectName = 'AOS_Invoices';
    public function handleSave($prefix, $redirect = true, $useRequired = false)
    {
        require_once 'include/formbase.php';
        $focus = new AOS_Invoices();
        $focus = populateFromPost($prefix, $focus);
        $focus->save();
    }
}
