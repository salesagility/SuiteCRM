<?php
/** 
 * 
 * SugarCRM Community Edition is a customer relationship management program developed by 
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc. 
 * 
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd. 
 * Copyright (C) 2011 - 2016 SalesAgility Ltd. 
 * 
 * This program is free software; you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License version 3 as published by the 
 * Free Software Foundation with the addition of the following permission added 
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK 
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY 
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS. 
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT 
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more 
 * details. 
 * 
 * You should have received a copy of the GNU Affero General Public License along with 
 * this program; if not, see http://www.gnu.org/licenses or write to the Free 
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 
 * 02110-1301 USA. 
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road, 
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com. 
 * 
 * The interactive user interfaces in modified source and object code versions 
 * of this program must display Appropriate Legal Notices, as required under 
 * Section 5 of the GNU Affero General Public License version 3. 
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3, 
 * these Appropriate Legal Notices must retain the display of the "Powered by 
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not 
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must 
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM". 
 */
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/AOBH_BusinessHours/AOBH_BusinessHours_sugar.php');
class AOBH_BusinessHours extends AOBH_BusinessHours_sugar {

    private $cached = array();
    private $businessHoursSet = null;

	function AOBH_BusinessHours(){	
		parent::AOBH_BusinessHours_sugar();
	}

    function areBusinessHoursSet(){
        if($this->businessHoursSet === null){
            $this->businessHoursSet = count($this->get_full_list());
        }
        return $this->businessHoursSet;
    }

    function getBusinessHoursForDay($day){
        if(!array_key_exists($day,$this->cached)){
            $this->cached[$day] = $this->get_full_list("","day = '".$day."'");
        }
        return $this->cached[$day];
    }

    function getOrCreate($day){
        $bhList = $this->getBusinessHoursForDay($day);
        if($bhList){
            return $bhList[0];
        }else{
            return BeanFactory::newBean("AOBH_BusinessHours");
        }
    }

    private function insideThisBusinessHour($datetime){
        if(!$this->open){
            return false;
        }
        $hour = $datetime->format("G");
        if($hour >= $this->opening_hours && $hour < $this->closing_hours){
            return true;
        }else{
            return false;
        }
    }


    function diffBusinessHours(DateTime $startTime, DateTime $endTime){
        $hours = ($endTime->getTimestamp() - $startTime->getTimestamp())/(60*60);
        $GLOBALS['log']->fatal("-------Hours------->" . $hours);
		$GLOBALS['log']->fatal( $startTime->getTimestamp() );
		$GLOBALS['log']->fatal( $endTime->getTimestamp() );
		
		
		$sub = $hours < 0;
        $interval = new DateInterval("PT1H");
        if($sub){
            $hours = 0 - $hours;
            $interval->invert = 1;
        }
        $businessHours = 0;
        while($hours > 0){
            if($this->insideAnyBusinessHours($startTime)){
                $startTime->add($interval);
                $businessHours++;
            }else{
                $startTime->add($interval);
            }
            $hours--;
        }
        if($sub){
            $businessHours = 0-$businessHours;
        }
		$GLOBALS['log']->fatal("-------businessHours-------" . $businessHours);
        return $businessHours;
    }

    function addBusinessHours($hours, DateTime $date = null){
        if($date == null){
            $date = new DateTime();
        }
        $sub = $hours < 0;
        $interval = new DateInterval("PT1H");
        if($sub){
            $hours = 0 - $hours;
            $interval->invert = 1;
        }
        while($hours > 0){
            if($this->insideAnyBusinessHours($date)){
                $date->add($interval);
                $hours--;
            }else{
                $date->add($interval);
            }
        }
        //If date has landed outside the business hours fix this.
        while(!$this->insideAnyBusinessHours($date)){
            $date->add($interval);
        }
        return $date;
    }

    private function insideAnyBusinessHours(DateTime $datetime){
        if(!$this->areBusinessHoursSet()){
            return true;
        }
        //Get the day of this datetime
        $day = $datetime->format("l");
        //get the business hours for this day
        $bhList = $this->getBusinessHoursForDay($day);
        //Check inside business hours
        foreach($bhList as $bh){
            if($bh->insideThisBusinessHour($datetime)){
                return true;
            }
        }
        return false;
    }
}
?>