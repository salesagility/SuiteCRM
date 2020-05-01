<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

/**
 * @internal
 */
class jjwg_AreasTest extends SuitePHPUnitFrameworkTestCase
{
    public function testjjwgAreas()
    {
        // Execute the constructor and check for the Object type and  attributes
        $jjwgAreas = new jjwg_Areas();

        $this->assertInstanceOf('jjwg_Areas', $jjwgAreas);
        $this->assertInstanceOf('Basic', $jjwgAreas);
        $this->assertInstanceOf('SugarBean', $jjwgAreas);

        $this->assertAttributeEquals('jjwg_Areas', 'module_dir', $jjwgAreas);
        $this->assertAttributeEquals('jjwg_Areas', 'object_name', $jjwgAreas);
        $this->assertAttributeEquals('jjwg_areas', 'table_name', $jjwgAreas);

        $this->assertAttributeEquals(true, 'new_schema', $jjwgAreas);
        $this->assertAttributeEquals(true, 'importable', $jjwgAreas);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $jjwgAreas);

        $this->assertAttributeEquals(null, 'polygon', $jjwgAreas);
        $this->assertAttributeEquals(true, 'point_on_vertex', $jjwgAreas);
        $this->assertAttributeEquals(0, 'area', $jjwgAreas);
        $this->assertAttributeEquals(null, 'centroid', $jjwgAreas);
    }

    public function testconfiguration()
    {
        $jjwgAreas = new jjwg_Areas();
        $jjwgAreas->configuration();

        $this->assertInstanceOf('jjwg_Maps', $jjwgAreas->jjwg_Maps);
        $this->assertTrue(is_array($jjwgAreas->settings));
        $this->assertGreaterThan(0, count($jjwgAreas->settings));
    }

    public function testretrieve()
    {
        $this->markTestSkipped('Skipped pending feedback on the area behaviour.');
        $jjwgAreas = new jjwg_Areas();

        //test without pre settting attributes
        $jjwgAreas->retrieve();
        $this->assertEquals(false, $jjwgAreas->polygon);
        $this->assertEquals(0, $jjwgAreas->area);
        $this->assertEquals(null, $jjwgAreas->centroid);

        //test with required attributes preset
        $jjwgAreas->coordinates = "100,80,10\r\n101,81,11\r\n102,82,12";

        $expected_polygon = [
            ['lng' => '100', 'lat' => '80', 'elv' => '10'],
            ['lng' => '101', 'lat' => '81', 'elv' => '11'],
            ['lng' => '102', 'lat' => '82', 'elv' => '12'],
        ];
        $expected_centroid = ['lng' => 67.3333333333333285963817615993320941925048828125, 'lat' => 54.0, 'elv' => 0];

        $jjwgAreas->retrieve();

        $this->assertSame($expected_polygon, $jjwgAreas->polygon);
        $this->assertEquals(20, $jjwgAreas->area);
        $this->assertSame($expected_centroid, $jjwgAreas->centroid);
    }

    public function testdefinePolygon()
    {
        $jjwgAreas = new jjwg_Areas();

        //test without pre settting attributes
        $actual = $jjwgAreas->define_polygon();
        $this->assertEquals(false, $actual);

        //test with required attributes preset
        $jjwgAreas->coordinates = "100,80,10\r\n101,81,11\r\n102,82,12";
        $expected = [
            ['lng' => '100', 'lat' => '80', 'elv' => '10'],
            ['lng' => '101', 'lat' => '81', 'elv' => '11'],
            ['lng' => '102', 'lat' => '82', 'elv' => '12'],
        ];
        $actual = $jjwgAreas->define_polygon();
        $this->assertSame($actual, $expected);
    }

    public function testdefineAreaLoc()
    {
        $jjwgAreas = new jjwg_Areas();

        //test without pre settting attributes
        $result = $jjwgAreas->define_area_loc();
        $this->assertEquals('N/A', $result['name']);
        $this->assertTrue(is_numeric($result['lat']));
        $this->assertTrue(is_numeric($result['lng']));

        //test with required attributes preset
        $jjwgAreas->name = 'test';
        $jjwgAreas->centroid = ['lng' => 100, 'lat' => 50];

        $expected = ['name' => 'test', 'lat' => 50, 'lng' => 100];
        $result = $jjwgAreas->define_area_loc();
        $this->assertSame($expected, $result);
    }

    public function testdefineCentroid()
    {
        $this->markTestSkipped('Skipped pending feedback on the area behaviour.');
        $jjwgAreas = new jjwg_Areas();

        //test without setting up coordinates
        $result = $jjwgAreas->define_centroid();
        $this->assertEquals(null, $result);

        //test with coordinates setup
        $jjwgAreas->coordinates = "100,80,10\r\n101,81,11\r\n102,82,12";
        $expected = ['lng' => 67.3333333333333285963817615993320941925048828125, 'lat' => 54.0, 'elv' => 0];

        $result = $jjwgAreas->define_centroid();
        $this->assertSame($expected, $result);
    }

    public function testdefineArea()
    {
        $this->markTestSkipped('Skipped pending feedback on the area behaviour.');
        $jjwgAreas = new jjwg_Areas();

        //test without setting up coordinates
        $result = $jjwgAreas->define_area();
        $this->assertEquals(0, $result);

        //test with coordinates setup
        $jjwgAreas->coordinates = "100,80,10\r\n101,81,11\r\n102,82,12";

        $result = $jjwgAreas->define_area();
        $this->assertEquals(20, $result);
    }

    public function testdefineLoc()
    {
        $jjwgAreas = new jjwg_Areas();

        //test without pre settting attributes
        $result = $jjwgAreas->define_loc([]);
        $this->assertEquals('N/A', $result['name']);
        $this->assertTrue(is_numeric($result['lat']));
        $this->assertTrue(is_numeric($result['lng']));

        //test with required attributes preset
        $marker = ['name' => 'test', 'lat' => 50, 'lng' => 100];
        $result = $jjwgAreas->define_loc($marker);
        $this->assertSame($marker, $result);
    }

    public function testisValidLng()
    {
        $jjwgAreas = new jjwg_Areas();

        //test with invalid values
        $this->assertEquals(false, $jjwgAreas->is_valid_lng(''));
        $this->assertEquals(false, $jjwgAreas->is_valid_lng(181));
        $this->assertEquals(false, $jjwgAreas->is_valid_lng(-181));

        //test with valid values
        $this->assertEquals(true, $jjwgAreas->is_valid_lng(180));
        $this->assertEquals(true, $jjwgAreas->is_valid_lng(-180));
    }

    public function testisValidLat()
    {
        $jjwgAreas = new jjwg_Areas();

        //test with invalid values
        $this->assertEquals(false, $jjwgAreas->is_valid_lat(''));
        $this->assertEquals(false, $jjwgAreas->is_valid_lat(91));
        $this->assertEquals(false, $jjwgAreas->is_valid_lat(-91));

        //test with valid values
        $this->assertEquals(true, $jjwgAreas->is_valid_lat(90));
        $this->assertEquals(true, $jjwgAreas->is_valid_lat(-90));
    }

    public function testisMarkerInArea()
    {
        $jjwgAreas = new jjwg_Areas();

        $marker = ['name' => 'test', 'lat' => 100, 'lng' => 40];

        //test without setting up coordinates
        $this->assertEquals(false, $jjwgAreas->is_marker_in_area($marker));

        //test with coordinates set
        $jjwgAreas->coordinates = '100,40,0.0 101,81,0.0 102,32,0.0';
        $this->assertEquals(false, $jjwgAreas->is_marker_in_area($marker));
    }

    public function testisPointInArea()
    {
        $jjwgAreas = new jjwg_Areas();

        //test without setting up coordinates
        $this->assertEquals(false, $jjwgAreas->is_point_in_area(100, 40));

        //test with coordinates set
        $jjwgAreas->coordinates = '100,40,10 101,81,11 102,82,12';
        $this->assertEquals(false, $jjwgAreas->is_point_in_area(101, 40));
        $this->assertEquals(true, $jjwgAreas->is_point_in_area(100, 40));
    }

    public function testpointInPolygon()
    {
        $jjwgAreas = new jjwg_Areas();

        //test without setting up coordinates
        $this->assertEquals(false, $jjwgAreas->point_in_polygon('100,40,0.0'));

        //test with coordinates set
        $jjwgAreas->coordinates = '100,40,10 101,81,11 102,82,12';
        $this->assertEquals(true, $jjwgAreas->point_in_polygon('100,40,0.0'));
    }

    public function testpointOnVertex()
    {
        $jjwgAreas = new jjwg_Areas();

        $vertices = ['100,40,10', '101,81,11', '102,82,12'];
        $this->assertEquals(false, $jjwgAreas->point_on_vertex('100,40,0.0', $vertices));
        $this->assertEquals(true, $jjwgAreas->point_on_vertex('100,40,10', $vertices));
    }

    public function testpointStringToCoordinates()
    {
        $jjwgAreas = new jjwg_Areas();

        $expected = ['x' => 100, 'y' => 40];
        $actual = $jjwgAreas->point_string_to_coordinates('100,40,10');
        $this->assertEquals($expected, $actual);
    }
}
