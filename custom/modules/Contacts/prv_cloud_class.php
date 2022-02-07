<?php

if (!defined("sugarEntry") || !sugarEntry)
{
    die("Not A Valid Entry Point");
}
include ("custom/application/Ext/PrvCloud/prv_cloud.ext.php");


class PrvCloud
{
    function PrvSave($bean, $event, $arguments)
    {

        $prv = new PrvCloudMethods();

        $data = ["frozen" => "false", "record" => ["first_name" => $bean->first_name, "last_name" => $bean->last_name, "phone_home" => $bean->phone_mobile, "email" => $bean->email1, ]];
        $GLOBALS["log"]->fatal("Token" . var_export($data, true));
        $prv->createRecord($data);

    }

}

?>
