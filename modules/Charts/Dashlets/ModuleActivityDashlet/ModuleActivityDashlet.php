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
* Module Activity Dashlet:
*
* Rick Timmis <rtimmis@wifispark.com>
*
* @desc	Enables reporting of records created by a selected set of users on a selected set of modules
* 
*/



require_once('include/Dashlets/DashletGenericChart.php');


class ModuleActivityDashlet extends DashletGenericChart
{
    public $pbss_date_start; 			// Start date to report from
    public $pbss_date_end;   			// End date to report to	
    public $modact_module_ids = array();	// Array to hold available / selected modules
    public $modact_user_ids = array();		// Array to hold available / selected users
   

    /**
     * @see DashletGenericChart::$_seedName
     */
    protected $_seedName = 'Opportunities';

    /**
     * @see DashletGenericChart::__construct()
     */
    public function __construct(
        $id,
        array $options = null
        )
    {
        global $timedate;

        if(empty($options['pbss_date_start']))
            $options['pbss_date_start'] = $timedate->nowDbDate();

        if(empty($options['pbss_date_end']))
            $options['pbss_date_end'] = $timedate->asDbDate($timedate->getNow()->modify("+6 months"));

        if(empty($options['title']))
        /** FIXME en_us.lang.php file will not load $dashletString, having burned 4 hours on the blooming thing, I opted to hardcode the labels
        *         in the interest of putting something into production and for the sake of my SANITY!!
        *         need to discover why the language strings aren't getting loaded, and fix this
        *         Rick Timmis
        */
		//$options['title'] = translate('LBL_TITLE', 'Home');
        	$options['title'] = "Module Activity";
              

        parent::__construct($id,$options);
    }

    /**
     * @see DashletGenericChart::displayOptions()
     */
    public function displayOptions()
    {
        global $app_list_strings;
        
         if (!empty($this->modact_module_ids) && count($this->modact_module_ids) > 0)
            foreach ($this->modact_module_ids as $key)
                $selected_datax[] = $key;
        else
            
            $selected_datax = array_keys($app_list_strings['moduleList']);
            

        //Pull available modules from /include/language/ vardafs
        $this->_searchFields['modact_module_ids']['options'] = $app_list_strings['moduleList'];
        $this->_searchFields['modact_module_ids']['input_name0'] = $selected_datax;
        return parent::displayOptions();
    }

    /**
     * @see DashletGenericChart::display()
     */
    public function display()
    {
        global $current_user, $sugar_config;

        require_once('include/SugarCharts/SugarChartFactory.php');
        $sugarChart = SugarChartFactory::getInstance();
        $sugarChart->base_url = array(
            'module' => 'Opportunities',
            'action' => 'index',
            'query' => 'true',
            'searchFormTab' => 'advanced_search',
            );
        //fixing bug #27097: The opportunity list is not correct after drill-down
        //should send to url additional params: start range value and end range value
        $sugarChart->url_params = array('start_range_date_closed' => $this->pbss_date_start,
                                        'end_range_date_closed' => $this->pbss_date_end);
        $sugarChart->group_by = $this->constructGroupBy();
        $sugarChart->setData($this->getChartData($this->constructQuery()));
        $sugarChart->is_currency = false;
       
        /** FIXME en_us.lang.php file will not load $dashletString, having burned 4 hours on the blooming thing, I opted to hardcode the labels
        *         in the interest of putting something into production and for the sake of my SANITY!!
        *         need to discover why the language strings aren't getting loaded, and fix this
        *         Rick Timmis
        */
        
        //$subtitle = translate('LBL_ACTIVITY_SCALE', 'Charts') . translate('LBL_ACTIVITY_UNITS', 'Charts');
        $subtitle = translate('Activity scale in ', 'Charts') . translate('records created ', 'Charts');
        //$pipeline_total_string = translate('LBL_TOTAL_ACTIVITY', 'Charts') . format_number($sugarChart->getTotal(), 0, 0, array('convert'=>true));
        $pipeline_total_string = translate('Total activity for period is ', 'Charts') . format_number($sugarChart->getTotal(), 0, 0, array('convert'=>true));
        $sugarChart->setProperties($pipeline_total_string, $subtitle, 'horizontal group by chart');

        $xmlFile = $sugarChart->getXMLFileName($this->id);
        $sugarChart->saveXMLFile($xmlFile, $sugarChart->generateXML());

        return $this->getTitle('') . '<div align="center">' . $sugarChart->display($this->id, $xmlFile, '100%', '480', false) . '</div>'. $this->processAutoRefresh();
    }

     
     /**
     * awu: Bug 16794 - this function is a hack to get the correct sales stage order until
     * i can clean it up later
     *
     * @param  $query string
     * @return array
     */
    private function getChartData($query)
    {
    	global $app_list_strings, $db;

    	$data = array();
    	$temp_data = array();
    	$selected_datax = array();

    	
        //set $datax using selected module keys
        $tempx = $this->modact_module_ids;
        
        if (count($tempx) > 0) {
            foreach ($tempx as $key) {
                $datax[$key] = $app_list_strings['moduleList'][$key];
                $selected_datax[] = $key;
            }
        }
        else {
            $datax = $app_list_strings['moduleList'];
            $selected_datax = array_keys($app_list_strings['moduleList']);
        }

        $result = $db->query($query);
        while($row = $db->fetchByAssoc($result, false))
        	$temp_data[] = $row;

	// reorder and set the array based on the order of selected_datax
        foreach($selected_datax as $module){
        	foreach($temp_data as $key => $value){
        		if ($value['module'] == $module){
        			$value['module'] = $app_list_strings['moduleList'][$value['module']];
        			$value['key'] = $module;
        			$value['value'] = $value['module'];
        			$data[] = $value;
        			unset($temp_data[$key]);
        		}
        	}
        }
        return $data;
    }

    /**
     * @see DashletGenericChart::constructQuery()
     */
    protected function constructQuery()
    {
	$ucount = count($this->modact_user_ids);
        $udataxArr = array();
        if ($ucount>0) {

            foreach ($this->modact_user_ids as $key) {
		$GLOBALS['log']->debug("Module Activity user selected is: $key");
                $udataxArr[] = "'".$key."'";
            }
            $udataxArr = join(",",$udataxArr);
            $uwhere = " users.id IN ($udataxArr) AND ";
            $uwhere .= " M.date_entered >= ".db_convert("'".$this->pbss_date_start."'",'datetime'). " AND M.date_entered <= ".db_convert("'".$this->pbss_date_end."'",'datetime');
        }


	if(count($this->modact_module_ids)==0){
	
		foreach($app_list_strings['moduleList'] as $key => $val){
			$query_arr[] = "select '".$key."' as module,user_name,M.created_by ,'' as opp_count, count(M.id) as total from ".strtolower($key)." as M INNER JOIN users ON users.id=M.created_by where ".$uwhere." group by M.created_by ";
		}
	}
	else
	{
		foreach ($this->modact_module_ids as $key){
			$query_arr[] = "select '".$key."' as module,user_name,M.created_by ,'' as opp_count, count(M.id) as total from ".strtolower($key)." as M INNER JOIN users ON users.id=M.created_by where ".$uwhere." group by M.created_by ";
		}
	}

	$query = implode(" UNION ",$query_arr);
	$GLOBALS['log']->debug("Module Activity query is: $query");
        return $query;
    }

    /**
     * @see DashletGenericChart::constructGroupBy()
     */
    protected function constructGroupBy()
    {
       return array(
           'module',
           'user_name',
           );
    }
}
