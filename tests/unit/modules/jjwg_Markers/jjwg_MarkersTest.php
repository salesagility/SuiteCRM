<?php


class jjwg_MarkersTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testjjwg_Markers()
    {

        
        $jjwgMarkers = new jjwg_Markers();

        $this->assertInstanceOf('jjwg_Markers', $jjwgMarkers);
        $this->assertInstanceOf('Basic', $jjwgMarkers);
        $this->assertInstanceOf('SugarBean', $jjwgMarkers);

        $this->assertAttributeEquals('jjwg_Markers', 'module_dir', $jjwgMarkers);
        $this->assertAttributeEquals('jjwg_Markers', 'object_name', $jjwgMarkers);
        $this->assertAttributeEquals('jjwg_markers', 'table_name', $jjwgMarkers);

        $this->assertAttributeEquals(true, 'new_schema', $jjwgMarkers);
        $this->assertAttributeEquals(true, 'importable', $jjwgMarkers);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $jjwgMarkers);
    }

    public function testconfiguration()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

        $jjwgMarkers = new jjwg_Markers();

        $jjwgMarkers->configuration();

        $this->assertInstanceOf('jjwg_Maps', $jjwgMarkers->jjwg_Maps);
        $this->assertTrue(is_array($jjwgMarkers->settings));
        $this->assertGreaterThan(0, count($jjwgMarkers->settings));
        
        
        
        
    }

    public function testdefine_loc()
    {
        $jjwgMarkers = new jjwg_Markers();

        
        $result = $jjwgMarkers->define_loc(array());
        $this->assertEquals('N/A', $result['name']);
        $this->assertTrue(is_numeric($result['lat']));
        $this->assertTrue(is_numeric($result['lng']));
        $this->assertEquals('company', $result['image']);

        
        $marker = array('name' => 'test', 'lat' => 50, 'lng' => 100, 'image' => null);
        $result = $jjwgMarkers->define_loc($marker);
        $this->assertSame($marker, $result);
    }

    public function testis_valid_lng()
    {
        $jjwgMarkers = new jjwg_Markers();

        
        $this->assertEquals(false, $jjwgMarkers->is_valid_lng(''));
        $this->assertEquals(false, $jjwgMarkers->is_valid_lng(181));
        $this->assertEquals(false, $jjwgMarkers->is_valid_lng(-181));

        
        $this->assertEquals(true, $jjwgMarkers->is_valid_lng(180));
        $this->assertEquals(true, $jjwgMarkers->is_valid_lng(-180));
    }

    public function testis_valid_lat()
    {
        $jjwgMarkers = new jjwg_Markers();

        
        $this->assertEquals(false, $jjwgMarkers->is_valid_lat(''));
        $this->assertEquals(false, $jjwgMarkers->is_valid_lat(91));
        $this->assertEquals(false, $jjwgMarkers->is_valid_lat(-91));

        
        $this->assertEquals(true, $jjwgMarkers->is_valid_lat(90));
        $this->assertEquals(true, $jjwgMarkers->is_valid_lat(-90));
    }
}
