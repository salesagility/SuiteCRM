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





require_once('include/Dashlets/DashletGenericChart.php');

class RGraph_PipelineBySalesStageDashlet extends DashletGenericChart
{
    public $pbss_date_start;
    public $pbss_date_end;
    public $pbss_sales_stages = array();

    //Overwrite the default version in DashletGenericChart.php
    public function setRefreshIcon()
    {
        $additionalTitle = '';
        if($this->isRefreshable)

            $additionalTitle .= '<a href="#" onclick="SUGAR.mySugar.retrieveDashlet(\''
                . $this->id
                . '\',\'predefined_chart\'); return false;"><!--not_in_theme!-->'
                . SugarThemeRegistry::current()->getImage(
                    'dashlet-header-refresh',
                    'border="0" align="absmiddle" title="'. translate('LBL_DASHLET_REFRESH', 'Home') . '"',
                    null,
                    null,
                    '.gif',
                    translate('LBL_DASHLET_REFRESH', 'Home')
                )
                . '</a>';
        return $additionalTitle;
    }

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
        	$options['title'] = translate('LBL_RGraph_PIPELINE_FORM_TITLE', 'Home');

        parent::__construct($id,$options);
    }

    /**
     * @see DashletGenericChart::displayOptions()
     */
    public function displayOptions()
    {
        global $app_list_strings;

        if (!empty($this->pbss_sales_stages) && count($this->pbss_sales_stages) > 0)
            foreach ($this->pbss_sales_stages as $key)
                $selected_datax[] = $key;
        else
            $selected_datax = array_keys($app_list_strings['sales_stage_dom']);

        $this->_searchFields['pbss_sales_stages']['options'] = $app_list_strings['sales_stage_dom'];
        $this->_searchFields['pbss_sales_stages']['input_name0'] = $selected_datax;

        return parent::displayOptions();
    }

    /**
     * @see DashletGenericChart::display()
     */
    public function display()
    {
        global $current_user, $sugar_config;

/*
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
        $sugarChart->is_currency = true;
        $sugarChart->thousands_symbol = translate('LBL_OPP_THOUSANDS', 'Charts');

        $currency_symbol = $sugar_config['default_currency_symbol'];
        if ($current_user->getPreference('currency')){

            $currency = new Currency();
            $currency->retrieve($current_user->getPreference('currency'));
            $currency_symbol = $currency->symbol;
        }
        $subtitle = translate('LBL_OPP_SIZE', 'Charts') . " " . $currency_symbol . "1" . translate('LBL_OPP_THOUSANDS', 'Charts');

        $pipeline_total_string = translate('LBL_TOTAL_PIPELINE', 'Charts') . $sugarChart->currency_symbol . format_number($sugarChart->getTotal(), 0, 0, array('convert'=>true)) . $sugarChart->thousands_symbol;
            $sugarChart->setProperties($pipeline_total_string, $subtitle, 'funnel chart 3D');

        $xmlFile = $sugarChart->getXMLFileName($this->id);
        $sugarChart->saveXMLFile($xmlFile, $sugarChart->generateXML());

        return $this->getTitle('') . '<div align="center">' . $sugarChart->display($this->id, $xmlFile, '100%', '480', false) . '</div>'. $this->processAutoRefresh();
*/

        $is_currency = true;
        $thousands_symbol = translate('LBL_OPP_THOUSANDS', 'Charts');

        $currency_symbol = $sugar_config['default_currency_symbol'];
        if ($current_user->getPreference('currency')){

            $currency = new Currency();
            $currency->retrieve($current_user->getPreference('currency'));
            $currency_symbol = $currency->symbol;
        }


        $data = $this->getChartData($this->constructQuery());
        $chartReadyData = $this->prepareChartData($data, $currency_symbol, $thousands_symbol);

        $jsonData = json_encode($chartReadyData['data']);
        $jsonLabels = json_encode($chartReadyData['labels']);
        $jsonLabelsAndValues = json_encode($chartReadyData['labelsAndValues']);

        $total = $chartReadyData['total'];

        $startDate = $this->pbss_date_start;
        $endDate = $this->pbss_date_end;

        //TODO find a better way of doing this
        $canvasId = 'rGraphFunnel'.uniqid();

        //These are taken in the same fashion as the hard-coded array above
        $module = 'Opportunities';
        $action = 'index';
        $query  ='true';
        $searchFormTab ='advanced_search';

        $chartWidth     = 650;
        $chartHeight    = 600;

        /*
         *
         *
         */

        $chart = <<<EOD

        <canvas id='$canvasId' width='$chartWidth' height='$chartHeight'>[No canvas support]</canvas>
        <script>
        function myFunnelClick(e,bar)
        {
            var labels = $jsonLabels;
            var clicked = encodeURI(labels[bar[2]]);
            window.open('http://localhost/SuiteCRM/index.php?module=$module&action=$action&query=$query&searchFormTab=$searchFormTab&start_range_date_closed=$startDate&end_range_date_closed=$endDate&sales_stage='+clicked,'_blank');

        }

        function myFunnelMousemove(e,shape)
        {
            e.target.style.cursor = 'pointer';
        }

        window.onload = function ()
        {
            drawFunnelGraph();
        }

        function drawFunnelGraph(){
            var funnel = new RGraph.Funnel({
                id:'$canvasId',
                data:$jsonData,
                options: {
                    labels:$jsonLabelsAndValues,
                    labelsSticks: true,
                    labelsX: 10,
                    key:$jsonLabels,
                    //keyInteractive: true,
                    //keyPositionX: 465,
                    eventsMousemove:myFunnelMousemove,
                    eventsClick:myFunnelClick,
                    gutterRight: 0,
                    gutterTop: 50,
                    gutterLeft: 320,
                    strokestyle: 'rgba(0,0,0,0)',
                    textBoxed: false,
                    shadow: true,
                    shadowOffsetx: 0,
                    shadowOffsety: 0,
                    shadowBlur: 15,
                    shadowColor: 'gray'
                }
            }).draw();

            var text = new RGraph.Drawing.Text({
            id: '$canvasId',
            x: 10,
            y: 22,
            text: 'Pipeline Total is $currency_symbol$total',
            options: {
                font: 'Arial',
                bold: true,
                //halign: 'left',
                //valign: 'bottom',
                colors: ['black'],
                size: 12
            }
        }).draw();

        var sizeIncrement = new RGraph.Drawing.Text({
            id: '$canvasId',
            x: 10,
            y: 550,
            text: 'Opportunity size in ${currency_symbol}1$thousands_symbol',
            options: {
                font: 'Arial',
                bold: true,
                //halign: 'left',
                //valign: 'bottom',
                colors: ['black'],
                size: 10
            }
        }).draw();

        }
         //drawFunnelGraph();
        </script>
EOD;


        return $chart;
    }

	/**
     * awu: Bug 16794 - this function is a hack to get the correct sales stage order until
     * i can clean it up later
     *
     * @param  $query string
     * @return array
     */
    private function getChartData(
        $query
        )
    {
    	global $app_list_strings, $db;

    	$data = array();
    	$temp_data = array();
    	$selected_datax = array();

    	$user_sales_stage = $this->pbss_sales_stages;
        $tempx = $user_sales_stage;

        //set $datax using selected sales stage keys
        if (count($tempx) > 0) {
            foreach ($tempx as $key) {
                $datax[$key] = $app_list_strings['sales_stage_dom'][$key];
                $selected_datax[] = $key;
            }
        }
        else {
            $datax = $app_list_strings['sales_stage_dom'];
            $selected_datax = array_keys($app_list_strings['sales_stage_dom']);
        }

        $result = $db->query($query);
        while($row = $db->fetchByAssoc($result, false))
        	$temp_data[] = $row;

		// reorder and set the array based on the order of selected_datax
        foreach($selected_datax as $sales_stage){
        	foreach($temp_data as $key => $value){
        		if ($value['sales_stage'] == $sales_stage){
        			$value['sales_stage'] = $app_list_strings['sales_stage_dom'][$value['sales_stage']];
        			$value['key'] = $sales_stage;
        			$value['value'] = $value['sales_stage'];
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
/*
    protected function constructQuery()
    {
        $query = "  SELECT opportunities.sales_stage,
                        users.user_name,
                        opportunities.assigned_user_id,
                        count(*) AS opp_count,
                        sum(amount_usdollar/1000) AS total
                    FROM users,opportunities  ";
        $query .= " WHERE opportunities.date_closed >= ". db_convert("'".$this->pbss_date_start."'",'date').
                        " AND opportunities.date_closed <= ".db_convert("'".$this->pbss_date_end."'",'date') .
                        " AND opportunities.assigned_user_id = users.id  AND opportunities.deleted=0 ";
        if ( count($this->pbss_sales_stages) > 0 )
            $query .= " AND opportunities.sales_stage IN ('" . implode("','",$this->pbss_sales_stages) . "') ";
        $query .= " GROUP BY opportunities.sales_stage ,users.user_name,opportunities.assigned_user_id";

        return $query;
    }
*/
    protected function constructQuery()
    {
        $query = "  SELECT opportunities.sales_stage,
                        count(*) AS opp_count,
                        sum(amount_usdollar/1000) AS total
                    FROM users,opportunities  ";
        $query .= " WHERE opportunities.date_closed >= ". db_convert("'".$this->pbss_date_start."'",'date').
            " AND opportunities.date_closed <= ".db_convert("'".$this->pbss_date_end."'",'date') .
            " AND opportunities.assigned_user_id = users.id  AND opportunities.deleted=0 ";
        $query .= " GROUP BY opportunities.sales_stage";

        return $query;
    }

    protected function prepareChartData($data,$currency_symbol, $thousands_symbol)
    {
        //return $data;
        $chart['labels']=array();
        $chart['data']=array();
        $total = 0;
        foreach($data as $i)
        {
            //$chart['labelsAndValues'][]=$i['key'].' ('.$currency.(int)$i['total'].')';
            $chart['labelsAndValues'][]=$i['key'].' ('.$currency_symbol.(int)$i['total'].$thousands_symbol.')';
            $chart['labels'][]=$i['key'];
            $chart['data'][]=(int)$i['total'];
            $total+=(int)$i['total'];
        }
        //The funnel needs n+1 elements (to bind the shape to as per http://www.rgraph.net/demos/funnel-interactive-key.html)
        $chart['data'][]=1;
        $chart['total']=$total;
        return $chart;
    }

    /**
     * @see DashletGenericChart::constructGroupBy()
     */
    /*
    protected function constructGroupBy()
    {
       return array(
           'sales_stage',
           'user_name',
           );
    }
    */
}
