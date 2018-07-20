<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
require_once('modules/DynamicFields/templates/Fields/TemplateTimeslot.php');

function get_body(&$ss, $vardef)
{
    $templateTimeslot = new TemplateTimeslot();
    $help_minute = !empty($vardef['help_minute']) ? $vardef['help_minute'] : '';
    if (!empty($vardef['default'])){
        if ($vardef['default'] == 86400){
            $mins = "59";
            $hrs = "23";
        } else {
            $v = $vardef['default'];
            $mins = $v % 3600;
            $hrs = ($v - $mins) / 3600;
            $mins = intdiv( $mins, 60 );
        }
    } else {
        $mins = "";
        $hrs = "";
    }
    $ss->assign('help_minute', $help_minute);    
    $ss->assign('default_hours', $hrs);
    $ss->assign('default_minutes', $mins);
    $ss->assign('defaultTime', $vardef['default']);
    $ss->assign('valdefaultTime', 'ok');
    $ss->assign('default_hours_values', array_flip($templateTimeslot->hoursEnum));
    $ss->assign('default_minutes_values', array_flip($templateTimeslot->minutesEnum));
    return $ss->fetch('modules/DynamicFields/templates/Fields/Forms/timeslot.tpl');
}
