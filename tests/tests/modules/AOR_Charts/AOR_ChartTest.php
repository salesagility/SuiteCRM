<?php
/**
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
 * Class AOR_ChartTest
 */
//require_once 'modules/AOR_Charts/lib/pChart/pChart.php';
class AOR_ChartTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOR_Chart()
    {
        $this->markTestSkipped('Skipping AOR Charts Tests');
        //execute the contructor and check for the Object type and  attributes
        $aorChart = new AOR_Chart();
        $this->assertInstanceOf('AOR_Chart', $aorChart);
        $this->assertInstanceOf('Basic', $aorChart);
        $this->assertInstanceOf('SugarBean', $aorChart);
    
        $this->assertAttributeEquals('AOR_Charts', 'module_dir', $aorChart);
        $this->assertAttributeEquals('AOR_Chart', 'object_name', $aorChart);
        $this->assertAttributeEquals('aor_charts', 'table_name', $aorChart);
        $this->assertAttributeEquals(true, 'new_schema', $aorChart);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aorChart);
        $this->assertAttributeEquals(true, 'importable', $aorChart);
    }
    
    public function testsave_lines()
    {
        $this->markTestSkipped('Skipping AOR Charts Tests');
        error_reporting(E_ERROR | E_PARSE);
    
        $aorChart = new AOR_Chart();
    
        //preset the required data
        $post = array();
        $post['chartid'] = array('test' => '');
        $post['charttitle'] = array('test' => 'test');
        $post['charttype'] = array('test' => 'bar');
        $post['chartx_field'] = array('test' => '1');
        $post['charty_field'] = array('test' => '2');
    
        $postKey = 'chart';
    
        $bean = new AOR_Report();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $result = $aorChart->save_lines($post, $bean, $postKey);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testbuildChartImageBar()
    {
        $this->markTestSkipped('Skipping AOR Charts Tests');
        
        $aorChart = new AOR_Chart();
    
        $chartData = new pData();
        $chartData->addPoints(10, 'data');
        $chartData->addPoints(10, 'Labels');
    
        //execute with recordImageMap true and verify that the chartPicture is changed
        $chartPicture = new pImage(700, 700, $chartData);
        $aorChart->buildChartImageBar($chartPicture, true);
        $this->assertNotEquals($chartPicture, new pImage(700, 700, $chartData));
    
        //execute with recordImageMap false and verify that the chartPicture is changed
        $chartPicture = new pImage(700, 700, $chartData);
        $aorChart->buildChartImageBar($chartPicture, false);
        $this->assertNotEquals($chartPicture, new pImage(700, 700, $chartData));
    
        unset($chartData);
        unset($chartPicture);
    }
    
    public function testbuildChartImagePie()
    {
        $this->markTestSkipped('Skipping AOR Charts Tests');
        
        $aorChart = new AOR_Chart();
    
        $chartData = new pData();
        $chartData->addPoints(10, 'data');
        $chartData->addPoints(10, 'Labels');
    
        //execute with recordImageMap false  and verify that the chartPicture is changed
        $chartPicture = new pImage(700, 700, $chartData);
        $aorChart->buildChartImagePie($chartPicture, $chartData, array(array('x' => 10), array('x' => 20)), 700, 700,
                                      'x', false);
        $this->assertNotEquals($chartPicture, new pImage(700, 700, $chartData));
    
        //execute with recordImageMap true and verify that the chartPicture is changed
        $chartPicture = new pImage(700, 700, $chartData);
        $aorChart->buildChartImagePie($chartPicture, $chartData, array(array('x' => 10), array('x' => 20)), 700, 700,
                                      'x', true);
        $this->assertNotEquals($chartPicture, new pImage(700, 700, $chartData));
    
        unset($chartData);
        unset($chartPicture);
    }
    
    public function testbuildChartImageLine()
    {
        $this->markTestSkipped('Skipping AOR Charts Tests');
        
        $aorChart = new AOR_Chart();
    
        $chartData = new pData();
        $chartData->addPoints(10, 'data');
        $chartData->addPoints(10, 'Labels');
    
        //execute with recordImageMap true  and verify that the chartPicture is changed
        $chartPicture = new pImage(700, 700, $chartData);
        $aorChart->buildChartImageLine($chartPicture, true);
        $this->assertNotEquals($chartPicture, new pImage(700, 700, $chartData));
    
        //execute with recordImageMap false  and verify that the chartPicture is changed
        $chartPicture = new pImage(700, 700, $chartData);
        $aorChart->buildChartImageLine($chartPicture, false);
        $this->assertNotEquals($chartPicture, new pImage(700, 700, $chartData));
    
        unset($chartData);
        unset($chartPicture);
    }
    
    public function testbuildChartImageRadar()
    {
        $this->markTestSkipped('Skipping AOR Charts Tests');
        
        $aorChart = new AOR_Chart();
    
        //preset the required objects and properties
        $chartData = new pData();
        $chartData->loadPalette('modules/AOR_Charts/lib/pChart/palettes/navy.color', true);
        $chartData->addPoints(10, 'data');
        $chartData->addPoints('10', 'Labels');
        $chartData->addPoints(120, 'data');
        $chartData->addPoints('120', 'Labels');
    
        $chartData->setSerieDescription('Months', 'Month');
        $chartData->setAbscissa('Labels');
    
        $imageWidth = 700;
        $imageHeight = 700;
    
        //execute with recordImageMap true and verify that the chartPicture is changed
        $chartPicture = new pImage($imageWidth, $imageHeight, $chartData);
        $chartPicture->setGraphArea(60, 60, $imageWidth - 60, $imageHeight - 100);
        $aorChart->buildChartImageRadar($chartPicture, $chartData, true);
        $this->assertNotEquals($chartPicture, new pImage(700, 700, $chartData));
    
        //execute with recordImageMap false and verify that the chartPicture is changed
        $chartPicture = new pImage(700, 700, $chartData);
        $chartPicture->setGraphArea(60, 60, $imageWidth - 60, $imageHeight - 100);
        $aorChart->buildChartImageRadar($chartPicture, $chartData, false);
        $this->assertNotEquals($chartPicture, new pImage(700, 700, $chartData));
    
        unset($chartData);
        unset($chartPicture);
    }
    
    public function testbuildChartImage()
    {
        $this->markTestSkipped('Skipping testing chart image');
    
        global $current_user;
    
        $current_user->id = '1';
    
        $aorChart = new AOR_Chart();
    
        //preset the required objects and properties
    
        $aorChart->x_field = 'x';
        $aorChart->y_field = 'y';
    
        $fields = array();
        $fields['x'] = json_decode('{"label": "x"}');
        $fields['y'] = json_decode('{"label": "y"}');
    
        $reportData = array(array('xx' => 10, 'yy' => 10), array('xx' => 20, 'yy' => 20));
    
        //execute the method and verify it returns expected results
        $aorChart->type = 'bar';
        $result = $aorChart->buildChartImage($reportData, $fields);
        $this->assertEquals('data:image/png;base64,', $result);
    
        //execute the method and verify it returns expected results
        $aorChart->type = 'Line';
        $result = $aorChart->buildChartImage($reportData, $fields);
        $this->assertEquals('', $result);
    
        //execute the method and verify it returns expected results
        $aorChart->type = 'pie';
        $result = $aorChart->buildChartImage($reportData, $fields);
        $this->assertEquals('data:image/png;base64,', $result);
    
        //execute the method and verify it returns expected results
        $aorChart->type = 'radar';
        $result = $aorChart->buildChartImage($reportData, $fields, true);
        $this->assertEquals('data:image/png;base64,', $result);
    }
    
    public function testbuildChartHTML()
    {
        $this->markTestSkipped('Skipping testing chart HTML');
        $aorChart = new AOR_Chart();
    
        //preset the required objects and properties
        $aorChart->x_field = 'x';
        $aorChart->y_field = 'y';
    
        $fields = array();
        $fields['x'] = json_decode('{"label": "x"}');
        $fields['y'] = json_decode('{"label": "y"}');
    
        $reportData = array(array('xx' => 10, 'yy' => 10), array('xx' => 20, 'yy' => 20));
    
        $aorChart->type = 'bar';
    
        //test with type CHART_TYPE_PCHART and verify it returns expected results
        $expected =
            "<img id='_img' src='data:image/png;base64,'><script>\nSUGAR.util.doWhen(\"typeof addImage != 'undefined'\", function(){\n    addImage('_img','_img_map','index.php?module=AOR_Charts&action=getImageMap&to_pdf=1&imageMapId=0');\n});\n</script>";
        $result = $aorChart->buildChartHTML($reportData, $fields);
        $this->assertSame($expected, $result);
    
        //test with type CHART_TYPE_CHARTJS verify it returns expected results
        $expected =
            "<h3></h3><canvas id='chart' width='400' height='400'></canvas>        <script>\n        \$(document).ready(function(){\n            SUGAR.util.doWhen(\"typeof Chart != 'undefined'\", function(){\n                var data = {\"labels\":[\"10 [a]\",\"20 [e]\"],\"datasets\":[{\"fillColor\":\"rgba(151,187,205,0.2)\",\"strokeColor\":\"rgba(151,187,205,1)\",\"pointColor\":\"rgba(151,187,205,1)\",\"pointStrokeColor\":\"#fff\",\"pointHighlightFill\":\"#fff\",\"pointHighlightStroke\":\"rgba(151,187,205,1)4\",\"data\":[10,20]}]};\n                var ctx = document.getElementById(\"chart\").getContext(\"2d\");\n                console.log('Creating new chart');\n                var config = [];\n                var chart = new Chart(ctx).Bar(data, config);\n                var legend = chart.generateLegend();\n                $('#chart').after(legend);\n            });\n        });\n        </script>";
        $result = $aorChart->buildChartHTML($reportData, $fields, 0, AOR_Report::CHART_TYPE_CHARTJS);
        $this->assertSame($expected, $result);
    }
}
