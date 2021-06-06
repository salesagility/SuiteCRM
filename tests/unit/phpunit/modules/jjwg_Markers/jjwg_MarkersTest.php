<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class jjwg_MarkersTest extends SuitePHPUnitFrameworkTestCase
{
    public function testjjwg_Markers(): void
    {
        // Execute the constructor and check for the Object type and  attributes
        $jjwgMarkers = BeanFactory::newBean('jjwg_Markers');

        self::assertInstanceOf('jjwg_Markers', $jjwgMarkers);
        self::assertInstanceOf('Basic', $jjwgMarkers);
        self::assertInstanceOf('SugarBean', $jjwgMarkers);

        self::assertAttributeEquals('jjwg_Markers', 'module_dir', $jjwgMarkers);
        self::assertAttributeEquals('jjwg_Markers', 'object_name', $jjwgMarkers);
        self::assertAttributeEquals('jjwg_markers', 'table_name', $jjwgMarkers);

        self::assertAttributeEquals(true, 'new_schema', $jjwgMarkers);
        self::assertAttributeEquals(true, 'importable', $jjwgMarkers);
        self::assertAttributeEquals(true, 'disable_row_level_security', $jjwgMarkers);
    }

    public function testconfiguration(): void
    {
        $jjwgMarkers = BeanFactory::newBean('jjwg_Markers');

        $jjwgMarkers->configuration();

        self::assertInstanceOf('jjwg_Maps', $jjwgMarkers->jjwg_Maps);
        self::assertIsArray($jjwgMarkers->settings);
        self::assertGreaterThan(0, count($jjwgMarkers->settings));
    }

    public function testdefine_loc(): void
    {
        $jjwgMarkers = BeanFactory::newBean('jjwg_Markers');

        //test without pre settting attributes
        $result = $jjwgMarkers->define_loc(array());
        self::assertEquals('N/A', $result['name']);
        self::assertIsNumeric($result['lat']);
        self::assertIsNumeric($result['lng']);
        self::assertEquals('company', $result['image']);

        //test with required attributes preset
        $marker = array('name' => 'test', 'lat' => 50, 'lng' => 100, 'image' => null);
        $result = $jjwgMarkers->define_loc($marker);
        self::assertSame($marker, $result);
    }

    public function testis_valid_lng(): void
    {
        $jjwgMarkers = BeanFactory::newBean('jjwg_Markers');

        //test with invalid values
        self::assertEquals(false, $jjwgMarkers->is_valid_lng(''));
        self::assertEquals(false, $jjwgMarkers->is_valid_lng(181));
        self::assertEquals(false, $jjwgMarkers->is_valid_lng(-181));

        //test with valid values
        self::assertEquals(true, $jjwgMarkers->is_valid_lng(180));
        self::assertEquals(true, $jjwgMarkers->is_valid_lng(-180));
    }

    public function testis_valid_lat(): void
    {
        $jjwgMarkers = BeanFactory::newBean('jjwg_Markers');

        //test with invalid values
        self::assertEquals(false, $jjwgMarkers->is_valid_lat(''));
        self::assertEquals(false, $jjwgMarkers->is_valid_lat(91));
        self::assertEquals(false, $jjwgMarkers->is_valid_lat(-91));

        //test with valid values
        self::assertEquals(true, $jjwgMarkers->is_valid_lat(90));
        self::assertEquals(true, $jjwgMarkers->is_valid_lat(-90));
    }
}
