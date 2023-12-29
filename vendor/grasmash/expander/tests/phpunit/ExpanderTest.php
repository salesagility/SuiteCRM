<?php

namespace Grasmash\Expander\Tests\Command;

use Dflydev\DotAccessData\Data;
use Grasmash\Expander\Expander;
use Grasmash\Expander\Stringifier;
use PHPUnit\Framework\TestCase;

class ExpanderTest extends TestCase
{

    /**
     * Tests Expander::expandArrayProperties().
     *
     * @param array $array
     * @param array $reference_array
     *
     * @dataProvider providerSourceData
     */
    public function testExpandArrayProperties(array $array, array $reference_array)
    {
        $expander = new Expander();

        $this->setEnvVarFixture('test', 'gomjabbar');

        $expanded = $expander->expandArrayProperties($array);
        $this->assertEquals('gomjabbar', $expanded['env-test']);
        $this->assertEquals('Frank Herbert 1965', $expanded['book']['copyright']);
        $this->assertEquals('Paul Atreides', $expanded['book']['protaganist']);
        $this->assertEquals('Dune by Frank Herbert', $expanded['summary']);
        $this->assertEquals('${book.media.1}, hardcover', $expanded['available-products']);
        $this->assertEquals('Dune', $expanded['product-name']);
        $this->assertEquals(Stringifier::stringifyArray($array['inline-array']), $expanded['expand-array']);

        $this->assertEquals(true, $expanded['boolean-value']);
        $this->assertIsBool($expanded['boolean-value']);
        $this->assertEquals(true, $expanded['expand-boolean']);
        $this->assertIsBool($expanded['expand-boolean']);

        $expanded = $expander->expandArrayProperties($array, $reference_array);
        $this->assertEquals('Dune Messiah, and others.', $expanded['sequels']);
        $this->assertEquals('Dune Messiah', $expanded['book']['nested-reference']);
    }

    /**
     * @return array
     *   An array of values to test.
     */
    public function providerSourceData()
    {
        return [
          [
            [
              'type' => 'book',
              'book' => [
                'title' => 'Dune',
                'author' => 'Frank Herbert',
                'copyright' => '${book.author} 1965',
                'protaganist' => '${characters.0.name}',
                'media' => [
                  0 => 'hardcover',
                ],
                'nested-reference' => '${book.sequel}',
              ],
              'characters' => [
                0 => [
                  'name' => 'Paul Atreides',
                  'occupation' => 'Kwisatz Haderach',
                  'aliases' => [
                    0 => 'Usul',
                    1 => "Muad'Dib",
                    2 => 'The Preacher',
                  ],
                ],
                1 => [
                  'name' => 'Duncan Idaho',
                  'occupation' => 'Swordmaster',
                ],
              ],
              'summary' => '${book.title} by ${book.author}',
              'publisher' => '${not.real.property}',
              'sequels' => '${book.sequel}, and others.',
              'available-products' => '${book.media.1}, ${book.media.0}',
              'product-name' => '${${type}.title}',
              'boolean-value' => true,
              'expand-boolean' => '${boolean-value}',
              'null-value' => null,
              'inline-array' => [
                0 => 'one',
                1 => 'two',
                2 => 'three',
              ],
              'expand-array' => '${inline-array}',
              'env-test' => '${env.test}',
              'test_expanded_to_null' => '${book.expanded_to_null}'
            ],
            [
              'book' => [
                'sequel' => 'Dune Messiah',
                'expanded_to_null' => null,
              ]
            ]
          ],
        ];
    }

    /**
     * Tests Expander::expandProperty().
     *
     * @dataProvider providerTestExpandProperty
     */
    public function testExpandProperty(array $array, $property_name, $unexpanded_string, $expected)
    {
        $data = new Data($array);
        $expander = new Expander();
        $expanded_value = $expander->expandProperty($property_name, $unexpanded_string, $data);

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

    protected function setEnvVarFixture($key, $value)
    {
        putenv("$key=$value");
        $_SERVER[$key] = $value;
    }
}
