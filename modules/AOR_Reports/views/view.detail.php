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
include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'rootPath.php';
require_once ROOTPATH.'/include/MVC/View/views/view.detail.php';
require_once ROOTPATH.'/modules/AOW_WorkFlow/aow_utils.php';
require_once ROOTPATH.'/modules/AOR_Reports/aor_utils.php';


class AOR_ReportsViewDetail extends ViewDetail {
    public function __construct()
    {
        parent::__construct();
    }

    public function preDisplay() {
        parent::preDisplay();
        $params =  $this->view_object_map['reportParams'];
        $reportHTML =  $this->view_object_map['reportHTML'];
        $chartsHTML =  $this->view_object_map['chartsHTML'];
        $chartsPerRow =  $this->view_object_map['chartsPerRow'];

        $this->ss->assign('charts_content', $chartsHTML);
        $this->ss->assign('report_content', $reportHTML);
        $this->ss->assign('hidden_field',$this->bean->report_module);
        $this->ss->assign('report_module',$this->bean->report_module);


        //TODO: Move markup from view to tpl
        echo "<input type='hidden' name='report_module' id='report_module' value='{$this->bean->report_module}'>";
        if (!is_file(ROOTPATH.'/cache/jsLanguage/AOR_Conditions/' . $GLOBALS['current_language'] . '.js')) {
            require_once (ROOTPATH.'/include/language/jsLanguage.php');
            jsLanguage::createModuleStringsCache('AOR_Conditions', $GLOBALS['current_language']);
        }
        echo '<script src="cache/jsLanguage/AOR_Conditions/'. $GLOBALS['current_language'] . '.js"></script>';
        echo "<script>var reportParameters = ".json_encode($params).";</script>";
        $resizeGraphsPerRow = <<<EOD
        <script>
        function resizeGraphsPerRow()
        {
                var maxWidth = 900;
                var maxHeight = 500;
                var maxTextSize = 10;
                var divWidth = $("#detailpanel_report").width();

                var graphWidth = Math.floor(divWidth / $chartsPerRow);

                var graphs = document.getElementsByClassName('resizableCanvas');
                for(var i = 0; i < graphs.length; i++)
                {
                    if(graphWidth * 0.9 > maxWidth)
                    graphs[i].width  = maxWidth;
                else
                    graphs[i].width = graphWidth * 0.9;
                if(graphWidth * 0.9 > maxHeight)
                    graphs[i].height = maxHeight;
                else
                    graphs[i].height = graphWidth * 0.9;
                /*
                var text_size = Math.min(12, (graphWidth / 1000) * 12 );
                if(text_size < 6)text_size=6;
                if(text_size > maxTextSize) text_size = maxTextSize;
                if(     graphs[i] !== undefined
                    &&  graphs[i].__object__ !== undefined
                    &&  graphs[i].__object__["properties"] !== undefined
                    &&  graphs[i].__object__["properties"]["chart.text.size"] !== undefined
                    &&  graphs[i].__object__["properties"]["chart.key.text.size"] !== undefined)
                 {
                    graphs[i].__object__["properties"]["chart.text.size"] = text_size;
                    graphs[i].__object__["properties"]["chart.key.text.size"] = text_size;
                 }
                //http://www.rgraph.net/docs/issues.html
                //As per Google Chrome not initially drawing charts
                RGraph.redrawCanvas(graphs[i]);
                */
                }
                if (typeof RGraph !== 'undefined') {
                    RGraph.redraw();
                }
        }
        </script>
EOD;
        echo $resizeGraphsPerRow;
        echo "<script> $(document).ready(function(){resizeGraphsPerRow();}); </script>";
        echo "<script> $(window).resize(function(){resizeGraphsPerRow();}); </script>";

    }
}
