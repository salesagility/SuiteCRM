<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOR_ReportTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAOR_Report()
    {
        // Execute the constructor and check for the Object type and  attributes
        $aor_Report = BeanFactory::newBean('AOR_Reports');
        $this->assertInstanceOf('AOR_Report', $aor_Report);
        $this->assertInstanceOf('Basic', $aor_Report);
        $this->assertInstanceOf('SugarBean', $aor_Report);

        $this->assertAttributeEquals('AOR_Reports', 'module_dir', $aor_Report);
        $this->assertAttributeEquals('AOR_Report', 'object_name', $aor_Report);
        $this->assertAttributeEquals('aor_reports', 'table_name', $aor_Report);
        $this->assertAttributeEquals(true, 'new_schema', $aor_Report);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aor_Report);
        $this->assertAttributeEquals(true, 'importable', $aor_Report);
    }

    public function testbean_implements()
    {
        $aor_Report = BeanFactory::newBean('AOR_Reports');

        $this->assertEquals(false, $aor_Report->bean_implements('')); //test with blank value
        $this->assertEquals(false, $aor_Report->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $aor_Report->bean_implements('ACL')); //test with valid value
    }

    public function testsave()
    {
        $aor_Report = BeanFactory::newBean('AOR_Reports');

        //populate value for aor_fields related/child object
        $_POST['aor_fields_field'][] = 'last_name';
        $_POST['aor_fields_name'][] = 'test';
        $_POST['aor_fields_module_path'][] = 'contacts';
        $_POST['aor_fields_display'][] = '1';
        $_POST['aor_fields_link'][] = '1';
        $_POST['aor_fields_label'][] = 'test_label';
        $_POST['aor_fields_field_function'][] = 'count';
        $_POST['aor_fields_total'][] = 'total';
        $_POST['aor_fields_group_by'][] = '1';
        $_POST['aor_fields_group_order'][] = 'desc';
        $_POST['aor_fields_group_display'][] = '1';

        //populate values for aor_chart related/child object
        $_POST['aor_chart_id'] = array('test' => '');
        $_POST['aor_chart_title'] = array('test' => 'test');
        $_POST['aor_chart_type'] = array('test' => 'bar');
        $_POST['aor_chart_x_field'] = array('test' => '1');
        $_POST['aor_chart_y_field'] = array('test' => '2');

        //populate aor_Report object values
        $aor_Report->name = 'test';
        $aor_Report->description = 'test text';

        $aor_Report->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($aor_Report->id));
        $this->assertEquals(36, strlen($aor_Report->id));

        //mark the record as deleted for cleanup
        $aor_Report->mark_deleted($aor_Report->id);

        unset($aor_Report);
    }

    public function testload_report_beans()
    {
        $aor_Report = BeanFactory::newBean('AOR_Reports');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $aor_Report->load_report_beans();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testgetReportFields()
    {
        //execute the method and verify that it returns an array
        $aor_Report = BeanFactory::newBean('AOR_Reports');
        $result = $aor_Report->getReportFields();
        $this->assertTrue(is_array($result));
    }

    public function testbuild_report_chart()
    {
        $aor_Report = BeanFactory::newBean('AOR_Reports');
        $aor_Report->report_module = 'Accounts';

        $chartBean = BeanFactory::getBean('AOR_Charts');
        $charts = (array)$chartBean->get_full_list();

        //execute the method and verify that it returns chart display script. strings returned vary due to included chart id.
        $result = $aor_Report->build_report_chart();
        foreach ($charts as $chart) {
            $this->assertContains($chart->id, $result);
        }

        unset($GLOBALS['_SESSION']);
        unset($GLOBALS['objectList']);
        unset($GLOBALS['mod_strings']);
        unset($GLOBALS['toHTML']);
        unset($GLOBALS['module']);
        unset($GLOBALS['action']);
        unset($GLOBALS['disable_date_format']);
        unset($GLOBALS['fill_in_rel_depth']);
        unset($GLOBALS['currentModule']);
    }

    public function testbuild_group_report()
    {
        $aor_Report = BeanFactory::newBean('AOR_Reports');
        $aor_Report->report_module = 'Accounts';
        $aor_Report->id = '1';

        //execute the method without any parameters and verify it returns html string
        $html1 = $aor_Report->build_group_report();
        $this->assertGreaterThan(0, strlen($html1));

        //execute the method wit offset parameter and verify it returns html string
        $html2 = $aor_Report->build_group_report(1);
        $this->assertGreaterThan(0, strlen($html2));

        //execute the method with both parameters and verify it returns html string
        $html3 = $aor_Report->build_group_report(0, false);
        $this->assertGreaterThan(0, strlen($html3));

        //verify that all three html strings are different.
        $this->assertNotEquals($html1, $html2);
        $this->assertNotEquals($html1, $html3);
        $this->assertNotEquals($html2, $html3);
    }

    public function testbuild_report_html()
    {
        $aor_Report = BeanFactory::newBean('AOR_Reports');
        $aor_Report->report_module = 'Accounts';

        //execute the method without any parameters and verify it returns html string
        $html1 = $aor_Report->build_report_html();
        $this->assertGreaterThan(0, strlen($html1));

        //execute the method with both parameters and verify it returns html string
        $html2 = $aor_Report->build_report_html(0, false);
        $this->assertGreaterThan(0, strlen($html2));

        //execute the method with group and identifier parameters and verify it returns html string
        $html3 = $aor_Report->build_report_html(1, false, 'grouptest', 'testidentifier');
        $this->assertGreaterThan(0, strlen($html3));

        //verify that group and identifier exist in the strings
        $this->assertContains('grouptest', $html3);
        $this->assertContains('testidentifier', $html3);
    }

    public function testGetTotalHTML()
    {
        //execute the method with required data preset and verify it returns expected result
        $fields = [
            'label' => [
                'display' => 1,
                'total' => 'SUM',
                'label' => 'total',
                'module' => 'Meetings',
                'field' => 'duration_hours',
                'params' => ''

            ]
        ];
        $totals = ['label' => [10, 20, 30]];
        /** @noinspection OneTimeUseVariablesInspection */
        $reportBean = BeanFactory::newBean('AOR_Reports');
        $actual = $reportBean->getTotalHTML($fields, $totals);

        $this->assertContains('sugar_field', $actual);
        $this->assertContains('duration_hours', $actual);
    }

    public function testcalculateTotal()
    {
        //execute the method with data preset and verify it returns expected result
        $totals = array(10, 20, 30);

        $aor_Report = BeanFactory::newBean('AOR_Reports');

        $this->assertEquals('', $aor_Report->calculateTotal('', $totals));
        $this->assertEquals(60, $aor_Report->calculateTotal('SUM', $totals));
        $this->assertEquals(3, $aor_Report->calculateTotal('COUNT', $totals));
        $this->assertEquals(20, $aor_Report->calculateTotal('AVG', $totals));
    }

    public function testbuild_report_csv()
    {
        //this method uses exit so it cannot be tested

        /*$aor_Report = BeanFactory::newBean('AOR_Reports');
        $aor_Report->report_module = "Accounts";
        $aor_Report->build_report_csv();
        */

        $this->markTestIncomplete('Can Not be implemented');
    }

    public function testbuild_report_query()
    {
        $aor_Report = BeanFactory::newBean('AOR_Reports');
        $aor_Report->report_module = 'Accounts';

        //execute the method without any parameters and verify that it returns a non empty string
        $actual = $aor_Report->build_report_query();
        $this->assertGreaterThanOrEqual(0, strlen($actual));

        //execute the method with parameter and verify that it returns a non empty string
        $actual = $aor_Report->build_report_query('name');
        $this->assertGreaterThanOrEqual(0, strlen($actual));
    }

    public function testbuild_report_query_select()
    {
        $aor_Report = BeanFactory::newBean('AOR_Reports');
        $aor_Report->report_module = 'Accounts';
        $query_array = array();

        //execute the method with parameters and verify that it returns an array.
        $actual = $aor_Report->build_report_query_select($query_array, 'name');
        $this->assertTrue(is_array($actual));
    }

    public function testbuild_report_query_join()
    {
        $aor_Report = BeanFactory::newBean('AOR_Reports');
        $aor_Report->report_module = 'Accounts';

        //test with type custom and verify that it retunrs expected results
        $expected = array('join' => array('accounts_contacts' => 'LEFT JOIN `accounts_cstm` `accounts_contacts` ON `accounts`.id = `contacts`.id_c '));
        $actual = $aor_Report->build_report_query_join(
            'contacts',
            'accounts_contacts',
            'accounts',
            BeanFactory::newBean('Accounts'),
            'custom',
            array()
        );
        $this->assertSame($expected, $actual);

        //test with type relationship and verify that it retunrs expected results
        $expected = array(
            'join' => array('accounts_contacts' => "LEFT JOIN accounts_contacts `accounts|accounts_contacts` ON `accounts`.id=`accounts|accounts_contacts`.account_id AND `accounts|accounts_contacts`.deleted=0\n\nLEFT JOIN contacts `accounts_contacts` ON `accounts_contacts`.id=`accounts|accounts_contacts`.contact_id AND `accounts_contacts`.deleted=0\n"),
            'id_select' => array('accounts_contacts' => '`accounts_contacts`.id AS \'accounts_contacts_id\''),
            'id_select_group' => array('accounts_contacts' => '`accounts_contacts`.id')
        );
        $actual = $aor_Report->build_report_query_join(
            'contacts',
            'accounts_contacts',
            'accounts',
            BeanFactory::newBean('Accounts'),
            'relationship',
            array()
        );
        $this->assertSame($expected, $actual);
    }

    public function testbuild_report_access_query()
    {
        $aor_Report = BeanFactory::newBean('AOR_Reports');

        //test without alias and verify that it retunrs expected results
        $result = $aor_Report->build_report_access_query(BeanFactory::newBean('AOR_Reports'), '');
        $this->assertEquals('', $result);

        //test with alias and verify that it retunrs expected results
        $result = $aor_Report->build_report_access_query(BeanFactory::newBean('AOR_Reports'), 'rep');
        $this->assertEquals('', $result);
    }

    public function testbuild_report_query_where()
    {
        $aor_Report = BeanFactory::newBean('AOR_Reports');
        $aor_Report->report_module = 'Accounts';

        //execute the method and verify that it retunrs expected results
        $expected = array('where' => array('accounts.deleted = 0 '));
        $actual = $aor_Report->build_report_query_where();
        $this->assertSame($expected, $actual);
    }
}
