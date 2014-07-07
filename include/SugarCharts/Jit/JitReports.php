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




require_once("include/SugarCharts/Jit/Jit.php");

class JitReports extends Jit {
	
	private $processed_report_keys = array();
	
	function __construct() {
		parent::__construct();
	}
	
		function calculateReportGroupTotal($dataset){
		$total = 0;				
		foreach ($dataset as $value){
			$total += $value['numerical_value'];
		}
		
		return $total;
	}	
	
    /**
     * Method checks is our dataset from currency field or not
     *
     * @param array $dataset of chart
     * @return bool is currency
     */
    public function isCurrencyReportGroupTotal(array $dataset)
    {
        $isCurrency = true;
        foreach ($dataset as $value)
        {
            if (empty($value['numerical_is_currency']))
            {
                $isCurrency = false;
                break;
            }
        }
        return $isCurrency;
    }

	function processReportData($dataset, $level=1, $first=false){
		$data = '';
		
		// rearrange $dataset to get the correct order for the first row
		if ($first){
			$temp_dataset = array();
			foreach ($this->super_set as $key){
				$temp_dataset[$key] = (isset($dataset[$key])) ? $dataset[$key] : array();
			}
			$dataset = $temp_dataset;			
		}
		
		foreach ($dataset as $key=>$value){
			if ($first && empty($value)){
				$data .= $this->processDataGroup(4, $key, 'NULL', '', '');
			}			
			else if (array_key_exists('numerical_value', $dataset)){
				$link = (isset($dataset['link'])) ? '#'.$dataset['link'] : '';
				$data .= $this->processDataGroup($level, $dataset['group_base_text'], $dataset['numerical_value'], $dataset['numerical_value'], $link);
				array_push($this->processed_report_keys, $dataset['group_base_text']);
				return $data;
			}
			else{
				$data .= $this->processReportData($value, $level+1);
			}
		}
		
		return $data;
	}
	
	function processReportGroup($dataset){
		$super_set = array();

        foreach($dataset as $groupBy => $groups){
            $prev_super_set = $super_set;
            if (count($groups) > count($super_set)){
	            $super_set = array_keys($groups);
                foreach($prev_super_set as $prev_group){
                    if (!in_array($prev_group, $groups)){
                        array_push($super_set, $prev_group);
                    }       
                }       
            }       
            else{ 
                foreach($groups as $group => $groupData){
                    if (!in_array($group, $super_set)){ 
                        array_push($super_set, $group);
                    }       
                }       
            }       
        }     
        $super_set = array_unique($super_set);

		return $super_set;
	}
	
	function xmlDataReportSingleValue(){
		$data = '';		
		foreach ($this->data_set as $key => $dataset){
			$total = $this->calculateReportGroupTotal($dataset);
			$this->checkYAxis($total);						

			$data .= $this->tab('<group>', 2);
			$data .= $this->tabValue('title',$key, 3);
			$data .= $this->tab('<subgroups>', 3);
			$data .= $this->tab('<group>',4);
			$data .= $this->tabValue('title',$total,5);
			$data .= $this->tabValue('value',$total,5);
			$data .= $this->tabValue('label',$key,5);
			$data .= $this->tab('<link></link>',5);
			$data .= $this->tab('</group>',4);
			$data .= $this->tab('</subgroups>', 3);				
			$data .= $this->tab('</group>', 2);			
		}
		return $data;
	}
	
    function xmlDataReportChart()
    {
        global $app_strings;
		$data = '';
		// correctly process the first row
		$first = true;	
		foreach ($this->data_set as $key => $dataset){
			
			$total = $this->calculateReportGroupTotal($dataset);
			$this->checkYAxis($total);

			$data .= $this->tab('<group>', 2);
			$data .= $this->tabValue('title',$key, 3);
			$data .= $this->tabValue('value',$total, 3);

            $label = $total;
            if ($this->isCurrencyReportGroupTotal($dataset))
            {;
                $label = currency_format_number($total, array(
                    'currency_symbol' => $this->currency_symbol,
                    'decimals' => ($this->chart_properties['thousands'] ? 0 : null)
                ));
            }
            if ($this->chart_properties['thousands'])
            {
                $label .= $app_strings['LBL_THOUSANDS_SYMBOL'];
            }
            $data .= $this->tabValue('label', $label, 3);

            $data .= $this->tab('<subgroups>', 3);
			
			if (count($this->group_by) > 1){
					$data .= $this->processReportData($dataset, 4, $first);
			}
			else if(count($this->data_set) == 1 && $first){
			    foreach ($dataset as $k=>$v){
			        if(isset($v['numerical_value'])) {
			            $data .= $this->processDataGroup(4, $k, $v['numerical_value'], $v['numerical_value'], '');
			        }
			    }
			}			

			if (!$first){											
				$not_processed = array_diff($this->super_set, $this->processed_report_keys);
				$processed_diff_count = count($this->super_set) - count($not_processed);

				if ($processed_diff_count != 0){
					foreach ($not_processed as $title){
						$data .= $this->processDataGroup(4, $title, 'NULL', '', '');
					}
				}
			}
			
			$data .= $this->tab('</subgroups>', 3);				
			$data .= $this->tab('</group>', 2);				
			$this->processed_report_keys = array();
			// we're done with the first row!
			//$first = false;
		}
		return $data;		
	}
	
	public function processXmlData(){
		$data = '';
		
		$this->super_set = $this->processReportGroup($this->data_set);
		$single_value = false;

		foreach ($this->data_set as $key => $dataset){
			if ((isset($dataset[$key]) && count($this->data_set[$key]) == 1)){
				$single_value = true;
			}
			else{
				$single_value = false;
			}
		}
		if ($this->chart_properties['type'] == 'line chart' && $single_value){
			$data .= $this->xmlDataReportSingleValue();
		}
		else{
			$data .= $this->xmlDataReportChart();
		}
		
		return $data;		
	}	
		
	/**
     * wrapper function to return the html code containing the chart in a div
	 * 
     * @param 	string $name 	name of the div
	 *			string $xmlFile	location of the XML file
	 *			string $style	optional additional styles for the div
     * @return	string returns the html code through smarty
     */					
	function display($name, $xmlFile, $width='320', $height='480', $reportChartDivStyle, $resize=false){
		if(empty($name)) {
			$name = "unsavedReport";	
		}
		
		parent::display($name, $xmlFile, $width, $height, $resize=false);			
		
		return $this->ss->fetch('include/SugarCharts/Jit/tpls/chart.tpl');	
		
		
	}
}
