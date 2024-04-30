<?php
class SaveHooks {
    /**
    * Logic hook to update related records based on historic checkbox
    */
    public function UpdateGroup($bean, $event, $args) {
        
        if(!empty($bean->billing_address_country) && $bean->billing_address_country != $bean->fetched_row['billing_address_country']) {
                $country = strtolower($bean->billing_address_country);
                $aSecurityGroup = array();
                if($country == 'uae' || $country == 'united arab emirates') {
                    $aSecurityGroup =  getSecurityGroups('UAE');
                }    
                elseif($country == 'oman') {
                    $aSecurityGroup =  getSecurityGroups('oman');    
                }
                elseif($country == 'qatar') {
                    $aSecurityGroup =  getSecurityGroups('qatar');
                }
                elseif($country == 'bahrain') {
                    $aSecurityGroup =  getSecurityGroups('bahrain');                    
                }
                $bean->load_relationship('SecurityGroups');
                foreach($aSecurityGroup as $groupID) {
                    $bean->SecurityGroups->add($groupID);
                }
        }
    }

}
?>