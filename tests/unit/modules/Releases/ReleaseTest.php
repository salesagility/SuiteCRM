<?php

class ReleaseTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testRelease()
    {

        
        $release = new Release();

        $this->assertInstanceOf('Release', $release);
        $this->assertInstanceOf('SugarBean', $release);

        $this->assertAttributeEquals('releases', 'table_name', $release);
        $this->assertAttributeEquals('Releases', 'module_dir', $release);
        $this->assertAttributeEquals('Release', 'object_name', $release);

        $this->assertAttributeEquals(true, 'new_schema', $release);
    }

    public function testget_summary_text()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

        $release = new Release();

        
        $this->assertEquals(null, $release->get_summary_text());

        
        $release->name = 'test';
        $this->assertEquals('test', $release->get_summary_text());
        
        
        
        
    }

    public function testget_releases()
    {
        $release = new Release();

        
        $result = $release->get_releases();
        $this->assertTrue(is_array($result));

        
        $result = $release->get_releases(true, 'Hidden', 'name is not null');
        $this->assertTrue(is_array($result));
    }

    public function testfill_in_additional_list_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $release = new Release();

        
        try {
            $release->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testfill_in_additional_detail_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $release = new Release();

        
        try {
            $release->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testget_list_view_data()
    {
        $release = new Release();

        $release->name = 'test';
        $release->status = 'Hidden';

        $expected = array(
                    'NAME' => 'test',
                    'STATUS' => 'Hidden',
                    'ENCODED_NAME' => 'test',
                    'ENCODED_STATUS' => null,
        );

        $actual = $release->get_list_view_data();

        $this->assertSame($expected, $actual);
    }

    public function testbuild_generic_where_clause()
    {
        $release = new Release();

        
        $expected = "name like '%'";
        $actual = $release->build_generic_where_clause('');
        $this->assertSame($expected, $actual);

        
        $expected = "name like 'test%'";
        $actual = $release->build_generic_where_clause('test');
        $this->assertSame($expected, $actual);
    }
}
