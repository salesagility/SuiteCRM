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

/**
 * Chart factory
 * @api
 */
class SugarChartFactory
{
    /**
	 * Returns a reference to the ChartEngine object for instance $chartEngine, or the default
     * instance if one is not specified
     *
     * @param string $chartEngine optional, name of the chart engine from $sugar_config['chartEngine']
     * @param string $module optional, name of module extension for chart engine (see JitReports or SugarFlashReports)
     * @return object ChartEngine instance
     */
	public static function getInstance(
        $chartEngine = '',
        $module = ''
        )
    {
        global $sugar_config;
		$defaultEngine = "Jit";
        //fall back to the default Js Engine if config is not defined
        if(empty($sugar_config['chartEngine'])){
        	$sugar_config['chartEngine'] = $defaultEngine;
        }

        if(empty($chartEngine)){
        	$chartEngine = $sugar_config['chartEngine'];
        }

        $file = "include/SugarCharts/".$chartEngine."/".$chartEngine.$module.".php";

        if(file_exists('custom/' . $file))
        {
          require_once('custom/' . $file);
        } else if(file_exists($file)) {
          require_once($file);
        } else {
          $GLOBALS['log']->debug("using default engine include/SugarCharts/".$defaultEngine."/".$defaultEngine.$module.".php");
          require_once("include/SugarCharts/".$defaultEngine."/".$defaultEngine.$module.".php");
          $chartEngine = $defaultEngine;
        }

        $className = $chartEngine.$module;
        return new $className();

    }

}

?>
