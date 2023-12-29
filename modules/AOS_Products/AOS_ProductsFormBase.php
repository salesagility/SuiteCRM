<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/SugarObjects/forms/FormBase.php';

class AOS_ProductsFormBase extends FormBase
{
    public $moduleName = 'AOS_Products';
    public $objectName = 'AOS_Products';
    public function handleSave($prefix, $redirect = true, $useRequired = false)
    {
        require_once 'include/formbase.php';
        $focus = new AOS_Products();
        $focus = populateFromPost($prefix, $focus);
        $focus->save();
    }
}
