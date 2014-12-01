<?php
/**
 * Advanced OpenReports, SugarCRM Reporting.
 * @package Advanced OpenReports for SugarCRM
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
 * @author SalesAgility <info@salesagility.com>
 */

class AOR_Chart extends Basic {
	var $new_schema = true;
	var $module_dir = 'AOR_Charts';
	var $object_name = 'AOR_Chart';
	var $table_name = 'aor_charts';
	var $importable = true;
	var $disable_row_level_security = true ;
	
	var $id;
	var $name;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $modified_by_name;
	var $created_by;
	var $created_by_name;
	var $description;
	var $deleted;
	var $created_by_link;
	var $modified_user_link;

    var $type;
    var $x_field;
    var $y_field;
	
	function AOR_Chart(){
		parent::Basic();
	}

    function save_lines(array $post,AOR_Report $bean,$postKey){
        foreach($post[$postKey.'id'] as $key => $id){
            if($id){
                $aorChart = BeanFactory::getBean('AOR_Charts',$id);
            }else{
                $aorChart = BeanFactory::newBean('AOR_Charts');
            }
            $aorChart->name = $post[$postKey.'title'][$key];
            $aorChart->type = $post[$postKey.'type'][$key];
            $aorChart->x_field = $post[$postKey.'x_field'][$key];
            $aorChart->y_field = $post[$postKey.'y_field'][$key];
            $aorChart->aor_report_id = $bean->id;
            $aorChart->save();
            $seenIds[] = $aorChart->id;
        }
        //Any beans that exist but aren't in $seenIds must have been removed.
        foreach($bean->get_linked_beans('aor_charts','AOR_Charts') as $chart){
            if(!in_array($chart->id,$seenIds)){
                $chart->mark_deleted($chart->id);
            }
        }
    }

    private function getValidChartTypes(){
        return array('bar','line','pie','radar','polar');
    }

    private function getBarChartData($reportData, $xName,$yName){
        $data = array();
        $data['labels'] = array();
        $datasetData = array();
        foreach($reportData as $row){
            $data['labels'][] = $row[$xName];
            $datasetData[] = $row[$yName];
        }

        $data['datasets'] = array();
        $data['datasets'][] = array(
            'fillColor' => "rgba(151,187,205,0.2)",
            'strokeColor' => "rgba(151,187,205,1)",
            'pointColor' => "rgba(151,187,205,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(151,187,205,1)4",
            'data'=>$datasetData);
        return $data;
    }

    private function getLineChartData($reportData, $xName,$yName){
        return $this->getBarChartData($reportData, $xName,$yName);
    }

    private function getBarChartConfig(){
        return array();
    }
    private function getLineChartConfig(){
        return $this->getBarChartConfig();
    }

    private function getRadarChartData($reportData, $xName,$yName){
        return $this->getBarChartData($reportData, $xName,$yName);
    }

    private function getPolarChartData($reportData, $xName,$yName){
        return $this->getPieChartData($reportData, $xName,$yName);
    }

    private function getRadarChartConfig(){
        return array();
    }

    private function getPolarChartConfig(){
        return $this->getPieChartConfig();
    }
    private function getPieChartConfig(){
        $config = array();
        $config['legendTemplate'] = "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>";
        return $config;
    }

    private function getPieChartData($reportData, $xName,$yName){
        $data = array();

        foreach($reportData as $row){
            if(!$row[$yName]){
                continue;
            }
            $colour = $this->getColour($row[$xName]);
            $data[] = array(
                'value' => (int)$row[$yName],
                'label' => $row[$xName],
                'color' => $colour['main'],
                'highlight' => $colour['highlight'],
            );
        }
        return $data;
    }

    private function getColour($seed){
        $hash = md5($seed);
        $r = hexdec(substr($hash, 0, 2));
        $g = hexdec(substr($hash, 2, 2));
        $b = hexdec(substr($hash, 4, 2));
        $highR = $r + 10;
        $highG = $g + 10;
        $highB = $b + 10;
        $main = '#'.str_pad(dechex($r),2,'0',STR_PAD_LEFT)
            .str_pad(dechex($g),2,'0',STR_PAD_LEFT)
            .str_pad(dechex($b),2,'0',STR_PAD_LEFT);
        $highlight = '#'.dechex($highR).dechex($highG).dechex($highB);
        return array('main'=>$main,'highlight'=>$highlight);
    }

    public function buildChartHTML(array $reportData, array $fields){
        $html = '';
        if(!in_array($this->type, $this->getValidChartTypes())){
            return $html;
        }
        $x = $fields[$this->x_field];
        $y = $fields[$this->y_field];
        if(!$x || !$y){
            //Malformed chart object - missing an axis field
            return '';
        }
        $xName = str_replace(' ','_',$x->label) . $this->x_field;
        $yName = str_replace(' ','_',$y->label) . $this->y_field;

        switch($this->type){
            case 'polar':
                $chartFunction = 'PolarArea';
                $data = $this->getPolarChartData($reportData, $xName,$yName);
                $config = $this->getPolarChartConfig();
                break;
            case 'radar':
                $chartFunction = 'Radar';
                $data = $this->getRadarChartData($reportData, $xName,$yName);
                $config = $this->getRadarChartConfig();
                break;
            case 'pie':
                $chartFunction = 'Pie';
                $data = $this->getPieChartData($reportData, $xName,$yName);
                $config = $this->getPieChartConfig();
                break;
            case 'line':
                $chartFunction = 'Line';
                $data = $this->getLineChartData($reportData, $xName,$yName);
                $config = $this->getLineChartConfig();
                break;
            case 'bar':
            default:
                $chartFunction = 'Bar';
                $data = $this->getBarChartData($reportData, $xName,$yName);
                $config = $this->getBarChartConfig();
                break;
        }
        $data = json_encode($data);
        $config = json_encode($config);
        $chartId = 'chart'.$this->id;
        $html .= "<h3>{$this->name}</h3>";
        $html .= "<canvas id='{$chartId}' width='400' height='400'></canvas>";
        $html .= <<<EOF
        <script>
        $(document).ready(function(){
            var data = {$data};
            var ctx = document.getElementById("{$chartId}").getContext("2d");
            console.log('Creating new chart');
            var config = {$config};
            var chart = new Chart(ctx).{$chartFunction}(data, config);
            var legend = chart.generateLegend();
            $('#{$chartId}').after(legend);
        });
        </script>
EOF;
        return $html;
    }

}
