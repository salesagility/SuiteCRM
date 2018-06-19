<?php

require_once 'include/utils/array_utils.php';
class array_utilsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testvar_export_helper()
    {

        

        $tempArray = array('Key1' => 'value1', 'Key2' => 'value2');

        $expected = "array (\n  'Key1' => 'value1',\n  'Key2' => 'value2',\n)";
        $actual = var_export_helper($tempArray);
        $this->assertSame($actual, $expected);
    }

    public function testoverride_value_to_string()
    {

        

        $expected = "\$array_name['value_name'] = 'value';";
        $actual = override_value_to_string('array_name', 'value_name', 'value');
        $this->assertSame($actual, $expected);
    }

    public function testadd_blank_option()
    {

        
        $tempArray = array('Key1' => 'value1', 'Key2' => 'value2');
        $expected = array('' => '', 'Key1' => 'value1', 'Key2' => 'value2');

        $actual = add_blank_option($tempArray);
        $this->assertSame($actual, $expected);

        
        $tempArray = array('' => '', 'Key1' => 'value1', 'Key2' => 'value2');
        $expected = array('' => '', 'Key1' => 'value1', 'Key2' => 'value2');

        $actual = add_blank_option($tempArray);
        $this->assertSame($actual, $expected);
    }

    public function testoverride_value_to_string_recursive()
    {

        

        
        $tempArray = array('Key1' => 'value1', 'Key2' => 'value2');
        $expected = "\$tempArray=array (\n  'Key1' => 'value1',\n  'Key2' => 'value2',\n);";
        $actual = override_value_to_string_recursive('', 'tempArray', $tempArray);
        $this->assertSame($actual, $expected);

        
        $tempArray = array();
        $tempArray['Key1']['Key2'] = array('Key3' => 'value', 'Key4' => 'value');
        $expected = "\$tempArray['key1']['key2']=array (\n  'Key1' => \n  array (\n    'Key2' => \n    array (\n      'Key3' => 'value',\n      'Key4' => 'value',\n    ),\n  ),\n);";
        $actual = override_value_to_string_recursive(array('key1', 'key2'), 'tempArray', $tempArray);
        
        $this->assertSame($actual, $expected);
    }

    public function testoverride_recursive_helper()
    {

        

        
        $tempArray = array('Key1' => 'value1', 'Key2' => 'value2');
        $expected = "=array (\n  'Key1' => 'value1',\n  'Key2' => 'value2',\n);";
        $actual = override_recursive_helper('', 'tempArray', $tempArray);
        $this->assertSame($actual, $expected);

        
        $tempArray = array();
        $tempArray['Key1']['Key2'] = array('Key3' => 'value', 'Key4' => 'value');
        $expected = "['key1']['key2']=array (\n  'Key1' => \n  array (\n    'Key2' => \n    array (\n      'Key3' => 'value',\n      'Key4' => 'value',\n    ),\n  ),\n);";
        $actual = override_recursive_helper(array('key1', 'key2'), 'tempArray', $tempArray);
        $this->assertSame($actual, $expected);
    }

    public function testoverride_value_to_string_recursive2()
    {

        

        
        $expected = null;
        $actual = override_value_to_string_recursive2('tempArray', 'key1', '', false);
        $this->assertSame($actual, $expected);

        
        $tempArray = array('Key1' => 'value1', 'Key2' => 'value2');
        $expected = "\$['tempArray']['Key1'] = 'value1';\n$['tempArray']['Key2'] = 'value2';\n";
        $actual = override_value_to_string_recursive2('', 'tempArray', $tempArray);
        $this->assertSame($actual, $expected);

        
        $tempArray = array();
        $tempArray['Key1']['Key2'] = array('Key3' => 'value', 'Key4' => 'value');
        $expected = "\$tempArray['key1']['Key2']['Key3'] = 'value';\n\$tempArray['key1']['Key2']['Key4'] = 'value';\n";
        $actual = override_value_to_string_recursive2('tempArray', 'key1', $tempArray['Key1']);
        $this->assertSame($actual, $expected);
    }

    public function testobject_to_array_recursive()
    {
        

        
        $obj = '';
        $expected = '';
        $actual = object_to_array_recursive($obj);
        $this->assertSame($actual, $expected);

        
        $obj = new TimeDate();
        $expected = array('dbDayFormat' => 'Y-m-d', 'dbTimeFormat' => 'H:i:s', 'allow_cache' => true);
        $actual = object_to_array_recursive($obj);

        $this->assertSame($actual, $expected);
    }

    public function testdeepArrayDiff()
    {

        

        
        $tempArray1 = array('Key1' => 'value1', 'Key2' => 'value2');
        $tempArray2 = array('Key1' => 'value1', 'Key2' => 'value2');
        $expected = array();
        $actual = deepArrayDiff($tempArray1, $tempArray2);
        $this->assertSame($actual, $expected);

        
        $tempArray1 = array('Key1' => 'value1', 'Key2' => 'value2');
        $tempArray2 = array('Key1' => 'value1', 'Key2' => 'value3');
        $expected = array('Key2' => 'value2');
        $actual = deepArrayDiff($tempArray1, $tempArray2);
        $this->assertSame($actual, $expected);

        
        $tempArray1 = array('Key1' => array('Key2' => 'value2', 'Key3' => 'value3'));
        $tempArray2 = array('Key1' => array('Key2' => 'value2', 'Key3' => 'value3'));
        $expected = array();
        $actual = deepArrayDiff($tempArray1, $tempArray2);
        $this->assertSame($actual, $expected);

        
        $tempArray1 = array('Key1' => array('Key2' => 'value2', 'Key3' => 'value3'));
        $tempArray2 = array('Key2' => array('Key2' => 'value2', 'Key3' => 'value3'));
        $expected = array('Key1' => array('Key2' => 'value2', 'Key3' => 'value3'));
        $actual = deepArrayDiff($tempArray1, $tempArray2);
        $this->assertSame($actual, $expected);

        
        $tempArray1 = array('Key1' => array('Key2' => 'value2', 'Key3' => 'value3'));
        $tempArray2 = array('Key1' => array('Key2' => 'value2', 'Key4' => 'value4'));
        $expected = array('Key1' => array('Key3' => 'value3'));
        $actual = deepArrayDiff($tempArray1, $tempArray2);
        $this->assertSame($actual, $expected);
    }

    public function testsetDeepArrayValue()
    {

        

        
        $tempArray = array('Key1' => array('Key2' => 'value2', 'Key3' => 'value3'));
        $expected = array('Key1' => array('Key2' => 'value2', 'Key3' => 'value3'), 'key4' => 'value4');
        setDeepArrayValue($tempArray, 'key4', 'value4');
        $this->assertSame($tempArray, $expected);

        
        $tempArray = array();
        $expected = array('key1' => array('key2' => array('key3' => 'value3')));
        setDeepArrayValue($tempArray, 'key1_key2_key3', 'value3');
        
        $this->assertSame($tempArray, $expected);
    }

    public function testarray_merge_values()
    {

        

        
        $tempArray1 = array('v1', 'v2', 'v3');
        $tempArray2 = array('v4', 'v5');
        $actual = array_merge_values($tempArray1,  $tempArray2);
        $this->assertFalse($actual);

        
        $tempArray1 = array('v1', 'v2', 'v3');
        $tempArray2 = array('v4', 'v5', 'v6');
        $expected = array('v1v4', 'v2v5', 'v3v6');
        $actual = array_merge_values($tempArray1,  $tempArray2);
        $this->assertSame($expected, $actual);
    }

    public function testarray_search_insensitive()
    {
        

        
        $tempArray = '';
        $actual = array_search_insensitive('', $tempArray);
        $this->assertFalse($actual);

        
        $tempArray = array('Key1' => 'value1', 'Key2' => 'value2', 'Key3' => 'value3', 'key4' => 'value4');
        $actual = array_search_insensitive('', $tempArray);
        $this->assertFalse($actual);

        
        $tempArray = array('Key1' => 'value1', 'Key2' => 'value2', 'Key3' => 'value3', 'key4' => 'value4');
        $actual = array_search_insensitive('value4', $tempArray);
        $this->assertTrue($actual);

        
    }

    public function testget()
    {

        

        
        $tempArray = new SugarArray(array('Key1' => array('Key2' => 'value2', 'Key3' => 'value3'), 'key4' => 'value4'));
        $expected = 'value4';
        $actual = $tempArray->get('key4');
        $this->assertSame($expected, $actual);

        
        $tempArray = new SugarArray(array('key1' => array('key2' => 'value2', 'key3' => 'value3'), 'key4' => 'value4'));
        $expected = 'value3';
        $actual = $tempArray->get('key1.key3');
        $this->assertSame($expected, $actual);
    }

    public function teststaticGet()
    {

        

        
        $haystack = array('key1' => array('key2' => 'value2', 'key3' => 'value3'), 'key4' => 'value4');
        $expected = 'value4';
        $actual = SugarArray::staticGet($haystack, 'key4');
        $this->assertSame($expected, $actual);

        
        $haystack = array('key1' => array('key2' => 'value2', 'key3' => 'value3'), 'key4' => 'value4');
        $expected = 'value3';
        $actual = SugarArray::staticGet($haystack, 'key1.key3');
        $this->assertSame($expected, $actual);
    }
}
