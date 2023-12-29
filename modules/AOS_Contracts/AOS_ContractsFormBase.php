<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/SugarObjects/forms/FormBase.php';

class AOS_ContractsFormBase extends FormBase
{
    public $moduleName = 'AOS_Contracts';
    public $objectName = 'AOS_Contracts';
    public function handleSave($prefix, $redirect = true, $useRequired = false)
    {
        require_once 'include/formbase.php';
        $focus = new AOS_Contracts();
        $focus = populateFromPost($prefix, $focus);
        $focus->save();
    }
}
