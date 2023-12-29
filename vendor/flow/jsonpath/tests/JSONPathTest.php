<?php
namespace Flow\JSONPath\Test;

require_once __DIR__ . "/../vendor/autoload.php";

use Flow\JSONPath\JSONPath;
use Flow\JSONPath\JSONPathLexer;
use \Peekmo\JsonPath\JsonPath as PeekmoJsonPath;

class JSONPathTest extends \PHPUnit_Framework_TestCase
{

    /**
     * $.store.books[0].title
     */
    public function testChildOperators()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find('$.store.books[0].title');
        $this->assertEquals('Sayings of the Century', $result[0]);
    }

    /**
     * $['store']['books'][0]['title']
     */
    public function testChildOperatorsAlt()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$['store']['books'][0]['title']");
        $this->assertEquals('Sayings of the Century', $result[0]);
    }

    /**
     * $.array[start:end:step]
     */
    public function testFilterSliceA()
    {
        // Copy all items... similar to a wildcard
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$['store']['books'][:].title");
        $this->assertEquals(['Sayings of the Century', 'Sword of Honour', 'Moby Dick', 'The Lord of the Rings'], $result->data());
    }

    public function testFilterSliceB()
    {
        // Fetch every second item starting with the first index (odd items)
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$['store']['books'][1::2].title");
        $this->assertEquals(['Sword of Honour', 'The Lord of the Rings'], $result->data());
    }

    public function testFilterSliceC()
    {
        // Fetch up to the second index
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$['store']['books'][0:2:1].title");
        $this->assertEquals(['Sayings of the Century', 'Sword of Honour', 'Moby Dick'], $result->data());
    }

    public function testFilterSliceD()
    {
        // Fetch up to the second index
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$['store']['books'][-1:].title");
        $this->assertEquals(['The Lord of the Rings'], $result->data());
    }

    /**
     * Everything except the last 2 items
     */
    public function testFilterSliceE()
    {
        // Fetch up to the second index
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$['store']['books'][:-2].title");
        $this->assertEquals(['Sayings of the Century', 'Sword of Honour'], $result->data());
    }

    /**
     * The Last item
     */
    public function testFilterSliceF()
    {
        // Fetch up to the second index
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$['store']['books'][-1].title");
        $this->assertEquals(['The Lord of the Rings'], $result->data());
    }

    /**
     * $.store.books[(@.length-1)].title
     *
     * This notation is only partially implemented eg. hacked in
     */
    public function testChildQuery()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$.store.books[(@.length-1)].title");
        $this->assertEquals(['The Lord of the Rings'], $result->data());
    }

    /**
     * $.store.books[?(@.price < 10)].title
     * Filter books that have a price less than 10
     */
    public function testQueryMatchLessThan()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$.store.books[?(@.price < 10)].title");
        $this->assertEquals(['Sayings of the Century', 'Moby Dick'], $result->data());
    }

    /**
     * $..books[?(@.author == "J. R. R. Tolkien")]
     * Filter books that have a title equal to "..."
     */
    public function testQueryMatchEquals()
    {
        $results = (new JSONPath($this->exampleData(rand(0, 1))))->find('$..books[?(@.author == "J. R. R. Tolkien")].title');
        $this->assertEquals($results[0], 'The Lord of the Rings');
    }

    /**
     * $..books[?(@.author = 1)]
     * Filter books that have a title equal to "..."
     */
    public function testQueryMatchEqualsWithUnquotedInteger()
    {
        $results = (new JSONPath($this->exampleDataWithSimpleIntegers(rand(0, 1))))->find('$..features[?(@.value = 1)]');
        $this->assertEquals($results[0]->name, "foo");
        $this->assertEquals($results[1]->name, "baz");
    }

    /**
     * $..books[?(@.author != "J. R. R. Tolkien")]
     * Filter books that have a title not equal to "..."
     */
    public function testQueryMatchNotEqualsTo()
    {
        $results = (new JSONPath($this->exampleData(rand(0, 1))))->find('$..books[?(@.author != "J. R. R. Tolkien")].title');
        $this->assertcount(3, $results);
        $this->assertEquals(['Sayings of the Century', 'Sword of Honour', 'Moby Dick'], [$results[0], $results[1], $results[2]]);

        $results = (new JSONPath($this->exampleData(rand(0, 1))))->find('$..books[?(@.author !== "J. R. R. Tolkien")].title');
        $this->assertcount(3, $results);
        $this->assertEquals(['Sayings of the Century', 'Sword of Honour', 'Moby Dick'], [$results[0], $results[1], $results[2]]);

        $results = (new JSONPath($this->exampleData(rand(0, 1))))->find('$..books[?(@.author <> "J. R. R. Tolkien")].title');
        $this->assertcount(3, $results);
        $this->assertEquals(['Sayings of the Century', 'Sword of Honour', 'Moby Dick'], [$results[0], $results[1], $results[2]]);
    }

    /**
     * $.store.books[*].author
     */
    public function testWildcardAltNotation()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$.store.books[*].author");
        $this->assertEquals(['Nigel Rees', 'Evelyn Waugh', 'Herman Melville', 'J. R. R. Tolkien'], $result->data());
    }

    /**
     * $..author
     */
    public function testRecursiveChildSearch()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$..author");
        $this->assertEquals(['Nigel Rees', 'Evelyn Waugh', 'Herman Melville', 'J. R. R. Tolkien'], $result->data());
    }

    /**
     * $.store.*
     * all things in store
     * the structure of the example data makes this test look weird
     */
    public function testWildCard()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$.store.*");
        if (is_object($result[0][0])) {
            $this->assertEquals('Sayings of the Century', $result[0][0]->title);
        } else {
            $this->assertEquals('Sayings of the Century', $result[0][0]['title']);
        }

        if (is_object($result[1])) {
            $this->assertEquals('red', $result[1]->color);
        } else {
            $this->assertEquals('red', $result[1]['color']);
        }
    }

    /**
     * $.store..price
     * the price of everything in the store.
     */
    public function testRecursiveChildSearchAlt()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$.store..price");
        $this->assertEquals([8.95, 12.99, 8.99, 22.99, 19.95], $result->data());
    }

    /**
     * $..books[2]
     * the third book
     */
    public function testRecursiveChildSearchWithChildIndex()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$..books[2].title");
        $this->assertEquals(["Moby Dick"], $result->data());
    }

    /**
     * $..books[(@.length-1)]
     */
    public function testRecursiveChildSearchWithChildQuery()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$..books[(@.length-1)].title");
        $this->assertEquals(["The Lord of the Rings"], $result->data());
    }

    /**
     * $..books[-1:]
     * Resturn the last results
     */
    public function testRecursiveChildSearchWithSliceFilter()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$..books[-1:].title");
        $this->assertEquals(["The Lord of the Rings"], $result->data());
    }

    /**
     * $..books[?(@.isbn)]
     * filter all books with isbn number
     */
    public function testRecursiveWithQueryMatch()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$..books[?(@.isbn)].isbn");

        $this->assertEquals(['0-553-21311-3', '0-395-19395-8'], $result->data());
    }

    /**
     * $..*
     * All members of JSON structure
     */
    public function testRecursiveWithWildcard()
    {
        $result = (new JSONPath($this->exampleData(rand(0, 1))))->find("$..*");
        $result = json_decode(json_encode($result), true);

        $this->assertEquals('Sayings of the Century', $result[0]['books'][0]['title']);
        $this->assertEquals(19.95, $result[26]);
    }

    /**
     * Tests direct key access.
     */
    public function testSimpleArrayAccess()
    {
        $result = (new JSONPath(array('title' => 'test title')))->find('title');

        $this->assertEquals(array('test title'), $result->data());
    }

    public function testFilteringOnNoneArrays()
    {
        $data = ['foo' => 'asdf'];

        $result = (new JSONPath($data))->find("$.foo.bar");
        $this->assertEquals([], $result->data());
    }


    public function testMagicMethods()
    {
        $fooClass = new JSONPathTestClass();

        $results = (new JSONPath($fooClass, JSONPath::ALLOW_MAGIC))->find('$.foo');

        $this->assertEquals(['bar'], $results->data());
    }


    public function testMatchWithComplexSquareBrackets()
    {
        $result = (new JSONPath($this->exampleDataExtra()))->find("$['http://www.w3.org/2000/01/rdf-schema#label'][?(@['@language']='en')]['@language']");
        $this->assertEquals(["en"], $result->data());
    }

    public function testQueryMatchWithRecursive()
    {
        $locations = $this->exampleDataLocations();
        $result = (new JSONPath($locations))->find("..[?(@.type == 'suburb')].name");
        $this->assertEquals(["Rosebank"], $result->data());
    }

    public function testFirst()
    {
        $result = (new JSONPath($this->exampleDataExtra()))->find("$['http://www.w3.org/2000/01/rdf-schema#label'].*");

        $this->assertEquals(["@language" => "en"], $result->first()->data());
    }

    public function testLast()
    {
        $result = (new JSONPath($this->exampleDataExtra()))->find("$['http://www.w3.org/2000/01/rdf-schema#label'].*");
        $this->assertEquals(["@language" => "de"], $result->last()->data());
    }

    public function testSlashesInIndex()
    {
        $result = (new JSONPath($this->exampleDataWithSlashes()))->find("$['mediatypes']['image/png']");

        $this->assertEquals(
            [
                "/core/img/filetypes/image.png",
            ],
            $result->data()
        );
    }

    public function testOffsetUnset()
    {
        $data = array(
            "route" => array(
                array("name" => "A", "type" => "type of A"),
                array("name" => "B", "type" => "type of B")
            )
        );
        $data = json_encode($data);

        $jsonIterator = new JSONPath(json_decode($data));

        /** @var JSONPath $route */
        $route = $jsonIterator->offsetGet('route');

        $route->offsetUnset(0);

        $first = $route->first();

        $this->assertEquals("B", $first['name']);
    }


    public function testFirstKey()
    {
        // Array test for array
        $jsonPath = new JSONPath(['a' => 'A', 'b', 'B']);

        $firstKey = $jsonPath->firstKey();

        $this->assertEquals('a', $firstKey);

        // Array test for object
        $jsonPath = new JSONPath((object) ['a' => 'A', 'b', 'B']);

        $firstKey = $jsonPath->firstKey();

        $this->assertEquals('a', $firstKey);
    }

    public function testLastKey()
    {
        // Array test for array
        $jsonPath = new JSONPath(['a' => 'A', 'b' => 'B', 'c' => 'C']);

        $lastKey = $jsonPath->lastKey();

        $this->assertEquals('c', $lastKey);

        // Array test for object
        $jsonPath = new JSONPath((object) ['a' => 'A', 'b' => 'B', 'c' => 'C']);

        $lastKey = $jsonPath->lastKey();

        $this->assertEquals('c', $lastKey);
    }

    /**
     * Test: ensure trailing comma is stripped during parsing
     */
    public function testTrailingComma()
    {
        $jsonPath = new JSONPath(json_decode('{"store":{"book":[{"category":"reference","author":"Nigel Rees","title":"Sayings of the Century","price":8.95},{"category":"fiction","author":"Evelyn Waugh","title":"Sword of Honour","price":12.99},{"category":"fiction","author":"Herman Melville","title":"Moby Dick","isbn":"0-553-21311-3","price":8.99},{"category":"fiction","author":"J. R. R. Tolkien","title":"The Lord of the Rings","isbn":"0-395-19395-8","price":22.99}],"bicycle":{"color":"red","price":19.95}},"expensive":10}'));

        $result = $jsonPath->find("$..book[0,1,2,]");

        $this->assertCount(3, $result);
    }

    /**
     * Test: ensure negative indexes return -n from last index
     */
    public function testNegativeIndex()
    {
        $jsonPath = new JSONPath(json_decode('{"store":{"book":[{"category":"reference","author":"Nigel Rees","title":"Sayings of the Century","price":8.95},{"category":"fiction","author":"Evelyn Waugh","title":"Sword of Honour","price":12.99},{"category":"fiction","author":"Herman Melville","title":"Moby Dick","isbn":"0-553-21311-3","price":8.99},{"category":"fiction","author":"J. R. R. Tolkien","title":"The Lord of the Rings","isbn":"0-395-19395-8","price":22.99}],"bicycle":{"color":"red","price":19.95}},"expensive":10}'));

        $result = $jsonPath->find("$..book[-2]");

        $this->assertEquals("Herman Melville", $result[0]['author']);
    }

    public function testQueryAccessWithNumericalIndexes()
    {
        $jsonPath = new JSONPath(json_decode('{
            "result": {
                "list": [
                    {
                        "time": 1477526400,
                        "o": "11.51000"
                    },
                    {
                        "time": 1477612800,
                        "o": "11.49870"
                    }
                ]
            }
        }'));

        $result = $jsonPath->find("$.result.list[?(@.o == \"11.51000\")]");

        $this->assertEquals("11.51000", $result[0]->o);

        $jsonPath = new JSONPath(json_decode('{
            "result": {
                "list": [
                    [
                        1477526400,
                        "11.51000"
                    ],
                    [
                        1477612800,
                        "11.49870"
                    ]
                ]
            }
        }'));

        $result = $jsonPath->find("$.result.list[?(@[1] == \"11.51000\")]");

        $this->assertEquals("11.51000", $result[0][1]);

    }


    public function exampleData($asArray = true)
    {
        $json = '
        {
          "store":{
            "books":[
              {
                "category":"reference",
                "author":"Nigel Rees",
                "title":"Sayings of the Century",
                "price":8.95
              },
              {
                "category":"fiction",
                "author":"Evelyn Waugh",
                "title":"Sword of Honour",
                "price":12.99
              },
              {
                "category":"fiction",
                "author":"Herman Melville",
                "title":"Moby Dick",
                "isbn":"0-553-21311-3",
                "price":8.99
              },
              {
                "category":"fiction",
                "author":"J. R. R. Tolkien",
                "title":"The Lord of the Rings",
                "isbn":"0-395-19395-8",
                "price":22.99
              }
            ],
            "bicycle":{
              "color":"red",
              "price":19.95
            }
          }
        }';
        return json_decode($json, $asArray);
    }

    public function exampleDataExtra($asArray = true)
    {
        $json = '
            {
               "http://www.w3.org/2000/01/rdf-schema#label":[
                  {
                     "@language":"en"
                  },
                  {
                     "@language":"de"
                  }
               ]
            }
        ';

        return json_decode($json, $asArray);
    }


    public function exampleDataLocations($asArray = true)
    {
        $json = '
            {
               "name": "Gauteng",
               "type": "province",
               "child": {
                    "name": "Johannesburg",
                    "type": "city",
                    "child": {
                        "name": "Rosebank",
                        "type": "suburb"
                    }
               }
            }
        ';

        return json_decode($json, $asArray);
    }


    public function exampleDataWithSlashes($asArray = true)
    {
        $json = '
            {
                "features": [],
                "mediatypes": {
                    "image/png": "/core/img/filetypes/image.png",
                    "image/jpeg": "/core/img/filetypes/image.png",
                    "image/gif": "/core/img/filetypes/image.png",
                    "application/postscript": "/core/img/filetypes/image-vector.png"
                }
            }
        ';

        return json_decode($json, $asArray);
    }

    public function exampleDataWithSimpleIntegers($asArray = true)
    {
        $json = '
            {
                "features": [{"name": "foo", "value": 1},{"name": "bar", "value": 2},{"name": "baz", "value": 1}]
            }
        ';

        return json_decode($json, $asArray);
    }



}

class JSONPathTestClass
{
    protected $attributes = [
        'foo' => 'bar'
    ];

    public function __get($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }
}
