<?php

class CurrencyTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testCurrency()
    {
        //execute the contructor and check for the Object type and  attributes
        $currency = new Currency();
        $this->assertInstanceOf('Currency', $currency);
        $this->assertInstanceOf('SugarBean', $currency);

        $this->assertAttributeEquals('Currencies', 'module_dir', $currency);
        $this->assertAttributeEquals('Currency', 'object_name', $currency);
        $this->assertAttributeEquals('currencies', 'table_name', $currency);
        $this->assertAttributeEquals(true, 'disable_num_format', $currency);
        $this->assertAttributeEquals(true, 'new_schema', $currency);
    }

    public function testconvertToDollar()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $currency = new Currency();

        //test without setting attributes
        $this->assertEquals(0, $currency->convertToDollar(100, 2));

        //test with required attributes set
        $currency->conversion_rate = 1.6;
        $this->assertEquals(62.5, $currency->convertToDollar(100, 2));
        
        // clean up
        
        
    }

    public function testconvertFromDollar()
    {
        $currency = new Currency();

        //test without setting attributes
        $this->assertEquals(0, $currency->convertFromDollar(100, 2));

        //test with required attributes set
        $currency->conversion_rate = 1.6;
        $this->assertEquals(160, $currency->convertFromDollar(100, 2));
    }

    public function testgetDefaultCurrencyName()
    {
        $currency = new Currency();
        $this->assertEquals('US Dollars', $currency->getDefaultCurrencyName());
    }

    public function testgetDefaultCurrencySymbol()
    {
        $currency = new Currency();
        $this->assertEquals('$', $currency->getDefaultCurrencySymbol());
    }

    public function testgetDefaultISO4217()
    {
        $currency = new Currency();
        $this->assertEquals('USD', $currency->getDefaultISO4217());
    }

    public function testretrieveIDBySymbol()
    {
        $currency = new Currency();
        $this->assertEquals('', $currency->retrieveIDBySymbol(''));
        $this->assertEquals('', $currency->retrieveIDBySymbol('\$'));
    }

    public function testlist_view_parse_additional_sections()
    {
        global $isMerge;

        $currency = new Currency();

        //test without setting attributes
        $ss = new Sugar_Smarty();
        $result = $currency->list_view_parse_additional_sections($ss);
        $this->assertEquals(null, isset($result->_tpl_vars['PREROW']) ? $result->_tpl_vars['PREROW'] : null);

        //test with required attributes set
        $isMerge = true;
        $ss = new Sugar_Smarty();
        $result = $currency->list_view_parse_additional_sections($ss);
        $this->assertEquals('<input name="mergecur[]" type="checkbox" value="">', $result->_tpl_vars['PREROW']);
    }

    public function testretrieve_id_by_name()
    {
        $currency = new Currency();
        $this->assertEquals('', $currency->retrieve_id_by_name(''));
        $this->assertEquals('', $currency->retrieve_id_by_name('US Dollars'));
    }

    public function testretrieve()
    {
        $currency = new Currency();

        //execute the method and verify that it returns expected results
        $currency->retrieve();

        $this->assertEquals('US Dollars', $currency->name);
        $this->assertEquals('$', $currency->symbol);
        $this->assertEquals('-99', $currency->id);
        $this->assertEquals(1, $currency->conversion_rate);
        $this->assertEquals('USD', $currency->iso4217);
        $this->assertEquals(0, $currency->deleted);
        $this->assertEquals('Active', $currency->status);
        $this->assertEquals('<!--', $currency->hide);
        $this->assertEquals('-->', $currency->unhide);
    }

    public function testgetPdfCurrencySymbol()
    {
        $currency = new Currency();

        //test without setting attributes
        $this->assertEquals('', $currency->getPdfCurrencySymbol());

        //test with required attributes set
        $currency->symbol = '�';
        $this->assertEquals('�', $currency->getPdfCurrencySymbol());
    }

    public function testget_list_view_data()
    {
        $currency = new Currency();

        //execute the method and verify that it retunrs expected results
        $expected = array(
                    'CONVERSION_RATE' => '0.0000000000',
                    'HIDE' => '',
                    'UNHIDE' => '',
        );

        $actual = $currency->get_list_view_data();
        $this->assertSame($expected, $actual);
    }

    public function testsave()
    {
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('currencies');
        $state->pushTable('tracker');
        
        $currency = new Currency();
        $currency->name = 'Rand';
        $currency->iso4217 = 'R';
        $currency->symbol = 'SA Rand';
        $currency->conversion_rate = '2';

        $currency->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($currency->id));
        $this->assertEquals(36, strlen($currency->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $currency->mark_deleted($currency->id);
        $result = $currency->retrieve($currency->id);
        $this->assertEquals(-99, $result->id);
        
        // clean up
        
        
        $state->popTable('tracker');
        $state->popTable('currencies');
        $state->popTable('aod_index');
    }

    public function testcurrency_format_number()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('currencies');
        
        $this->assertEquals('$100.00', currency_format_number(100));
        $this->assertEquals('$100.0', currency_format_number(100, array('round' => 1, 'decimals' => 1)));
        
        // clean up
        
        $state->popTable('currencies');
    }

    public function testformat_number()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('currencies');
        
        $this->assertEquals('100.00', format_number(100));
        $this->assertEquals('100.1', format_number(100.09, 1, 1));
        $this->assertEquals('$100.1', format_number(100.09, 1, 1, array('convert' => 1, 'currency_symbol' => 'R')));
        
        // clean up
        
        $state->popTable('currencies');
    }

    public function testformat_place_symbol()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('currencies');
        
        $this->assertEquals('R&nbsp;100', format_place_symbol(100, 'R', true));
        $this->assertEquals('R100', format_place_symbol(100, 'R', false));
        $this->assertEquals('100', format_place_symbol(100, '', false));
        
        // clean up
        
        $state->popTable('currencies');
    }

    public function testunformat_number()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('currencies');
        
        $this->assertEquals('100', unformat_number('$100'));
        $this->assertEquals('100', unformat_number(100));
        
        // clean up
        
        $state->popTable('currencies');
    }

    public function testformat_money()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('currencies');
        
        $this->assertEquals('100.00', format_money('100'));
        $this->assertEquals('100.00', format_money('100', false));
        
        // clean up
        
        $state->popTable('currencies');
    }

    public function testget_number_seperators()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('currencies');
        
        $this->assertEquals(array(',', '.'), get_number_seperators());
        $this->assertEquals(array(',', '.'), get_number_seperators(false));
        
        // clean up
        
        $state->popTable('currencies');
    }

    public function testtoString()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('currencies');
        
        $expected = "\$m_currency_round= \n\$m_currency_decimal= \n\$m_currency_symbol= \n\$m_currency_iso= \n\$m_currency_name= \n";
        $this->assertSame($expected, toString(false));
        
        // clean up
        
        $state->popTable('currencies');
    }

    public function testgetCurrencyDropDown()
    {
        self::markTestIncomplete('#Warning: Strings contain different line endings!');
        //test with view = Default / DetailView
        $this->assertEquals('US Dollars', getCurrencyDropDown(null));

        //test with view = EditView  	
        $expected = "<select name=\"currency_id\" id=\"currency_id_select\" onchange=\"CurrencyConvertAll(this.form);\"><option value=\"-99\" selected>US Dollars : $</select><script>var ConversionRates = new Array(); \nvar CurrencySymbols = new Array(); \nvar lastRate = \"1\"; ConversionRates['-99'] = '1';\n CurrencySymbols['-99'] = '$';\nvar currencyFields = [];\n					function get_rate(id){\n						return ConversionRates[id];\n					}\n					function ConvertToDollar(amount, rate){\n						return amount / rate;\n					}\n					function ConvertFromDollar(amount, rate){\n						return amount * rate;\n					}\n					function ConvertRate(id,fields){\n							for(var i = 0; i < fields.length; i++){\n								fields[i].value = toDecimal(ConvertFromDollar(toDecimal(ConvertToDollar(toDecimal(fields[i].value), lastRate)), ConversionRates[id]));\n							}\n							lastRate = ConversionRates[id];\n						}\n					function ConvertRateSingle(id,field){\n						var temp = field.innerHTML.substring(1, field.innerHTML.length);\n						unformattedNumber = unformatNumber(temp, num_grp_sep, dec_sep);\n						\n						field.innerHTML = CurrencySymbols[id] + formatNumber(toDecimal(ConvertFromDollar(ConvertToDollar(unformattedNumber, lastRate), ConversionRates[id])), num_grp_sep, dec_sep, 2, 2);\n						lastRate = ConversionRates[id];\n					}\n					function CurrencyConvertAll(form){\n                        try {\n                        var id = form.currency_id.options[form.currency_id.selectedIndex].value;\n						var fields = new Array();\n						\n						for(i in currencyFields){\n							var field = currencyFields[i];\n							if(typeof(form[field]) != 'undefined'){\n								form[field].value = unformatNumber(form[field].value, num_grp_sep, dec_sep);\n								fields.push(form[field]);\n							}\n							\n						}\n							\n							ConvertRate(id, fields);\n						for(i in fields){\n							fields[i].value = formatNumber(fields[i].value, num_grp_sep, dec_sep);\n\n						}\n							\n						} catch (err) {\n                            // Do nothing, if we can't find the currency_id field we will just not attempt to convert currencies\n                            // This typically only happens in lead conversion and quick creates, where the currency_id field may be named somethnig else or hidden deep inside a sub-form.\n                        }\n						\n					}\n				</script>";
        $actual = getCurrencyDropDown(null, 'currency_id', '', 'EditView');
        $this->assertSame($expected, $actual);
    }

    public function testgetCurrencyNameDropDown()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('currencies');
        
        //test with view = Default / DetailView
        $this->assertEquals('US Dollars', getCurrencyNameDropDown(null));

        //test with view = EditView
        $expected = $expected = "<select name=\"currency_name\" id=\"currency_name\" />\n<OPTION value='US Dollars'>US Dollars</OPTION></select>";
        $actual = getCurrencyNameDropDown(null, 'currency_name', '', 'EditView');
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $state->popTable('currencies');
    }

    public function testgetCurrencySymbolDropDown()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('currencies');
        
        //test with view = Default / DetailView
        $this->assertEquals('US Dollars', getCurrencySymbolDropDown(null));

        //test with view = EditView
        $expected = $expected = "<select name=\"currency_name\" id=\"currency_name\" />\n<OPTION value='\$'>\$</OPTION></select>";
        $actual = getCurrencySymbolDropDown(null, 'currency_name', '', 'EditView');
        $this->assertSame($expected, $actual);
        
        
        // clean up
        
        $state->popTable('currencies');
    }
}
