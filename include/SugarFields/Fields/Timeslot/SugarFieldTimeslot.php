<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 ********************************************************************************/

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldTimeslot extends SugarFieldBase {

    function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
        global $timedate;

        $displayParams['timeFormat'] = $timedate->get_user_time_format();
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch('include/SugarFields/Fields/Timeslot/EditView.tpl');
    }

    private function formatTimeslotField($value)
    {
        if(!empty($value)){
            if ($value == 86400 ){
                $value = "23:59";
            } else {
                $mins = $value % 3600;
                $hrs = ($value - $mins) / 3600;
                $mins = $mins / 60;
                $value = str_pad( $hrs, 2, "0", STR_PAD_LEFT ) . ":" . str_pad( $mins, 2, "0", STR_PAD_LEFT );
            }
        }
        return $value;
    }

    public function formatField( $rawField, $vardef )
    {
        return $this->formatTimeslotField($rawField);
    }

    function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) 
    {
        return $this->getSmartyView($parentFieldArray, $vardef, $displayParams, $tabindex, 'DetailView');
    }

    function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
        global $timedate;

        $displayParams['timeFormat'] = $timedate->get_user_time_format();
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch('include/SugarFields/Fields/Timeslot/EditView.tpl');
    }

    public function save(&$bean, $params, $field, $properties, $prefix = ''){
        global $timedate;

        if (isset($params[$prefix.$field])){
            $bean->$field = $params[$prefix.$field];
        }
    }

    public function importSanitize($value, $vardef, $focus, ImportFieldSanitize $settings)
    {
        if (!is_numeric($value)) {
            $value = strtotime($value);
            if ($value===false){
                return false;
            }
            $dateparts = date_parse(date("Y-m-d H:ia",$value));
            $hour = $dateparts["hour"];
            $minute = $dateparts["minute"];
            if ($hour == "23" && $minute == "59") {
                $s = 60;
            } else {
                $s = 0;
            }
            return((($hour * 60) + $minute) * 60) + $s;
        }
        if (($value <0) || ($value>86400)){
            return false;
        }
        return $value;
    }

}
