<?php
 /**
 * 
 * 
 * @package 
 * @copyright SalesAgility Ltd http://www.salesagility.com
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */
require_once 'include/MVC/View/views/view.detail.php';
require_once 'modules/AOW_WorkFlow/aow_utils.php';
require_once 'modules/AOR_Reports/aor_utils.php';
class AOR_ReportsViewDetail extends ViewDetail {
    public function __construct() {
        parent::ViewDetail();
    }
    private function getReportParameters(){
        if(!$this->bean->id){
            return array();
        }
        $conditions = $this->bean->get_linked_beans('aor_conditions','AOR_Conditions', 'condition_order');
        $parameters = array();
        foreach($conditions as $condition){
            if(!$condition->parameter){
                continue;
            }
            $condition->module_path = implode(":",unserialize(base64_decode($condition->module_path)));
            if($condition->value_type == 'Date'){
                $condition->value = unserialize(base64_decode($condition->value));
            }
            $condition_item = $condition->toArray();
            $display = getDisplayForField($condition->module_path, $condition->field, $this->bean->report_module);
            $condition_item['module_path_display'] = $display['module'];
            $condition_item['field_label'] = $display['field'];
            if(!empty($this->bean->user_parameters[$condition->id])){
                $param = $this->bean->user_parameters[$condition->id];
                $condition_item['operator'] = $param['operator'];
                $condition_item['value_type'] = $param['type'];
                $condition_item['value'] = $param['value'];
            }
            if(isset($parameters[$condition_item['condition_order']])) {
                $parameters[] = $condition_item;
            }
            else {
                $parameters[$condition_item['condition_order']] = $condition_item;
            }
        }
        return $parameters;
    }

    public function preDisplay() {
        global $app_list_strings;
        parent::preDisplay();
        $this->ss->assign('report_module',$this->bean->report_module);


        $this->bean->user_parameters = requestToUserParameters();



        //$reportHTML = $this->bean->build_group_report(0,true);
        //$chartsHTML = '<br />' . $this->bean->build_report_chart(null, AOR_Report::CHART_TYPE_CHARTJS);
        $reportHTML = $this->bean->build_group_report(0,true).'<br />';
        //$reportHTML .= $this->bean->build_report_chart(null, AOR_Report::CHART_TYPE_CHARTJS);



        $charts = $this->bean->build_report_chart(null, AOR_Report::CHART_TYPE_RGRAPH);

        //$reportHtml = str_replace(" class='resizableCanvas'"," style='width:10%;'",$reportHTML);
        //$GRAPHS = $this->bean->build_report_chart(null, AOR_Report::CHART_TYPE_RGRAPH);

        $chartsPerRow = $this->bean->graphs_per_row;
        $countOfCharts = substr_count($charts,"class='resizableCanvas'");
        if($countOfCharts > 0) {
            $width = ((int)(100 / $chartsPerRow)-1);

            $modulusRemainder = $countOfCharts % $chartsPerRow;
            $itemsWithModulus = 999;
            if ($modulusRemainder > 0) {
                $modulusWidth = ((int)(100 / $modulusRemainder)-1);
                $itemsWithModulus = $countOfCharts - $modulusRemainder;
            }

            $charts = str_replace("class='resizableCanvas'>","class='resizableCanvas' style='width:$width%;'>",$charts);
            $needle = "class='resizableCanvas'>";

            /*
            for ($x = 0; $x < $countOfCharts; $x++) {
                      if(is_null($itemsWithModulus) ||  $x < $itemsWithModulus)
                      {
                         // $test = "test";
                          //$charts = preg_replace("class='resizableCanvas'>","class='resizableCanvas' style='width:$width%;'>",$charts,1);
                         // $pos = strpos($charts,$needle);
                          //if($pos !== false)
                            //  $charts = substr_replace($charts,"class='resizableCanvas' style='width:$width%;'>",$pos,strlen($needle));
                      }

                    else
                    {
                        //$test = "test2";
                        //$pos = strpos($charts,$needle);
                        //if($pos !== false)
                          //  $charts = substr_replace($charts,"class='resizableCanvas' style='width:$modulusWidth%;'>",$pos,strlen($needle));
                        //$charts = preg_replace("class='resizableCanvas'>","class='resizableCanvas' style='width:$modulusWidth%;'>",$charts,1);
                    }

            //              $charts.= str_replace("class='resizableCanvas'","class='resizableCanvas' style='width:33%;'",$charts,$countOfGraphsToUpdate);
            //            else
                         //   $charts.= str_replace("class='resizableCanvas'","class='resizableCanvas' style='width:99%;'",$charts,$countOfGraphsToUpdate);
                //          $graphHtml.="<img src='.$graphs[$x].' style='width:$width%;' />";
                //      else
                //          $graphHtml.="<img src='.$graphs[$x].'k />";
            }
            */
        }


            $this->ss->assign('report_content',$reportHTML.$charts);
        //$this->ss->assign('charts_content',$chartsHTML);
        echo "<input type='hidden' name='report_module' id='report_module' value='{$this->bean->report_module}'>";
        if (!is_file('cache/jsLanguage/AOR_Conditions/' . $GLOBALS['current_language'] . '.js')) {
            require_once ('include/language/jsLanguage.php');
            jsLanguage::createModuleStringsCache('AOR_Conditions', $GLOBALS['current_language']);
        }
        echo '<script src="cache/jsLanguage/AOR_Conditions/'. $GLOBALS['current_language'] . '.js"></script>';

        $params = $this->getReportParameters();
        echo "<script>var reportParameters = ".json_encode($params).";</script>";

        $chartResize = <<<EOD
        <script>
            window.onload = function(){
                var graphs = document.getElementsByClassName("resizableCanvas");
                for(var i = 0; i < graphs.length; i++)
                {
                    if(i < $itemsWithModulus)
                        graphs[i].style["width"] = "$width%";
                    else
                        graphs[i].style["width"] = "$modulusWidth%";
                }
            }
        </script>
EOD;


        echo $chartResize;
    }



}
