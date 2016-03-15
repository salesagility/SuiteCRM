<?php


class VersionTest extends PHPUnit_Framework_TestCase {

	
	public function testVersion() {

		error_reporting(E_ERROR | E_PARSE);
		
		//execute the contructor and check for the Object type and  attributes
		$version = new Version();
			
		$this->assertInstanceOf('Version',$version);
		$this->assertInstanceOf('SugarBean',$version);
		
		$this->assertAttributeEquals('versions', 'table_name', $version);
		$this->assertAttributeEquals('Versions', 'module_dir', $version);
		$this->assertAttributeEquals('Version', 'object_name', $version);
		
		$this->assertAttributeEquals(true, 'new_schema', $version);
		
	}
	
	public function testbuild_generic_where_clause() {
	
		$version = new Version();
		
		//test with empty string params
		$expected = "name like '%'";
		$actual = $version->build_generic_where_clause('');
		$this->assertSame($expected,$actual);
		
			
		//test with valid string params
		$expected = "name like 'test%'";
		$actual = $version->build_generic_where_clause('test');
		$this->assertSame($expected,$actual);
		
		
	}
	
	public function testis_expected_version(){
	
		$version = new Version();
		
		//test without setting attributes
		$actual = $version->is_expected_version(array("file_version"=>"1","db_version"=>"2"));
		$this->assertEquals(false,$actual);
		
		
		//test with attributes set to on matching values
		$version->file_version = "2";
		$version->db_version = "2";
		$actual = $version->is_expected_version(array("file_version"=>"1","db_version"=>"2"));
		$this->assertEquals(false,$actual);
		
			
		//test with valid param
		$version->file_version = "1";
		$version->db_version = "2";
		$actual = $version->is_expected_version(array("file_version"=>"1","db_version"=>"2"));
		$this->assertEquals(true,$actual);
	
	}
	
	public function testmark_upgraded(){
	
		$version = new Version();
		
		$version->mark_upgraded('test', 1, 1);
		
		$version = $version->retrieve_by_string_fields(array("name" => "test"));
		
		//test for record ID to verify that record is saved
		$this->assertTrue(isset($version->id));
		$this->assertEquals(36, strlen($version->id));
		
		
		//mark the record as deleted and verify that this record cannot be retrieved anymore.
		$version->mark_deleted($version->id);
		$result = $version->retrieve($version->id);
		$this->assertEquals(null,$result);
		
	}
	
	public function testget_profile(){
	
		$version = new Version();

		//test without setting attributes
		$expected = array('name'=> null, 'file_version'=> null, 'db_version'=>null);
		$actual = $version->get_profile();
		$this->assertSame($expected,$actual);
		
		
		//test with attributes set
		$version->name = "test";
		$version->file_version = 1;
		$version->db_version = 1;
		
		$expected = array('name'=> 'test', 'file_version'=> 1, 'db_version'=>1);
		$actual = $version->get_profile();
		$this->assertSame($expected,$actual);
		
	}

}

?>