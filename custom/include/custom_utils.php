<?php
/**
* function to get Securitygroups based on country
*   
* @param mixed $country
*/
function getSecurityGroups($country='uae'){
    global $db;
    $rs = $db->query("SELECT id from securitygroups WHERE name like '%{$country}%' AND deleted=0");
    $aData = array();
    while($row = $db->fetchByAssoc($rs)){
        $aData[$row['id']] = $row['id'];
    }
    return $aData;
    
}
?>
