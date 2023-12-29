<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/SugarObjects/forms/FormBase.php';

class AOS_Product_CategoriesFormBase extends FormBase
{
    public $moduleName = 'AOS_Product_Categories';
    public $objectName = 'AOS_Product_Categories';
    public function handleSave($prefix, $redirect = true, $useRequired = false)
    {
        require_once 'include/formbase.php';
        $focus = new AOS_Product_Categories();
        $focus = populateFromPost($prefix, $focus);
        $focus->save();
    }
}
