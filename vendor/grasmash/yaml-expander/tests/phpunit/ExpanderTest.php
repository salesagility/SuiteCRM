<?php

namespace Grasmash\YamlExpander\Tests\Command;

use Dflydev\DotAccessData\Data;
use Grasmash\YamlExpander\Expander;
use Grasmash\YamlExpander\Tests\TestBase;
use Symfony\Component\Yaml\Yaml;

class ExpanderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests Expander::expandArrayProperties().
     *
     * @param string $filename
     * @param array $reference_array
     *
     * @dataProvider providerYaml
     */
    public function testExpandArrayProperties($filename, $reference_array)
    {
        $array = Yaml::parse(file_get_contents(__DIR__ . "/../resources/$filename"));
        putenv("test=gomjabbar");
        $expanded = Expander::expandArrayProperties($array);
        $this->assertEquals('gomjabbar', $expanded['env-test']);
        $this->assertEquals('Frank Herbert 1965', $expanded['book']['copyright']);
        $this->assertEquals('Paul Atreides', $expanded['book']['protaganist']);
        $this->assertEquals('Dune by Frank Herbert', $expanded['summary']);
        $this->assertEquals('${book.media.1}, hardcover', $expanded['available-products']);
        $this->assertEquals('Dune', $expanded['product-name']);
        $this->assertEquals(Yaml::dump($array['inline-array'], 0), $expanded['expand-array']);

        $expanded = Expander::expandArrayProperties($array, $reference_array);
        $this->assertEquals('Dune Messiah, and others.', $expanded['sequels']);
        $this->assertEquals('Dune Messiah', $expanded['book']['nested-reference']);
    }

    /**
     * Tests Expander::parse().
     *
     * @param string $filename
     * @param array $reference_array
     *
     * @dataProvider providerYaml
     */
    public function testParse($filename, $reference_array)
    {
        $yaml_string = file_get_contents(__DIR__ . "/../resources/$filename");
        $expanded = Expander::parse($yaml_string);
        $this->assertEquals('Frank Herbert 1965', $expanded['book']['copyright']);
        $this->assertEquals('Paul Atreides', $expanded['book']['protaganist']);
        $this->assertEquals('Dune by Frank Herbert', $expanded['summary']);
        $this->assertEquals('${book.media.1}, hardcover', $expanded['available-products']);

        $expanded = Expander::parse($yaml_string, $reference_array);
        $this->assertEquals('Dune Messiah, and others.', $expanded['sequels']);
        $this->assertEquals('Dune Messiah', $expanded['book']['nested-reference']);
    }

    /**
     * @return array
     *   An array of values to test.
     */
    public function providerYaml()
    {
        return [
          ['valid.yml', [
            'book' => [
              'sequel' => 'Dune Messiah'
            ]
          ]],
        ];
    }

    /**
     * Tests Expander::expandProperty().
     *
     * @dataProvider providerTestExpandProperty
     */
    public function testExpandProperty($array, $property_name, $unexpanded_string, $expected)
    {
        $data = new Data($array);
        $expanded_value = Expander::expandProperty($property_name, $unexpanded_string, $data);

        $this->assertEquals($expected, $expanded_value);
    }

    /**
     * @return array
     */
    public function providerTestExpandProperty()
    {
        return [
            [ ['author' => 'Frank Herbert'], 'author', '${author}', 'Frank Herbert' ],
            [ ['book' =>  ['author' => 'Frank Herbert' ]], 'book.author', '${book.author}', 'Frank Herbert' ],
        ];
    }
}
