<?php
namespace Flow\JSONPath\Test;
use Flow\JSONPath\JSONPath;
use Peekmo\JsonPath\JsonPath as PeekmoJsonPath;

require_once __DIR__ . "/../vendor/autoload.php";

class JSONPathBenchmarks extends \PHPUnit_Framework_TestCase
{

    public function testBenchmark()
    {
        $goessnerJsonPath = new PeekmoJsonPath;
        $exampleData = $this->exampleData();

        $start1 = microtime(true);
        for ($i = 0; $i < 100; $i += 1) {
            $results1 = $goessnerJsonPath->jsonPath($exampleData, '$.store.books[?(@."price" < 10)]');
        }
        $end1 = microtime(true);

        $start2 = microtime(true);
        for ($i = 0; $i < 100; $i += 1) {
            $results2 = (new JSONPath($exampleData))->find('$.store.books[?(@.price < 10)]');
        }
        $end2 = microtime(true);

        $this->assertEquals($results1, $results2->data());

        echo "Old JsonPath: " . ($end1 - $start1) . PHP_EOL;
        echo "JSONPath: " . ($end2 - $start2) . PHP_EOL;
    }

    public function testBenchmark2()
    {
        $goessnerJsonPath = new PeekmoJsonPath;
        $exampleData = $this->exampleData();

        $start1 = microtime(true);
        for ($i = 0; $i < 100; $i += 1) {
            $results1 = $goessnerJsonPath->jsonPath($exampleData, '$.store.*');
        }
        $end1 = microtime(true);

        $start2 = microtime(true);
        for ($i = 0; $i < 100; $i += 1) {
            $results2 = (new JSONPath($exampleData))->find('$.store.*');
        }
        $end2 = microtime(true);

        $this->assertEquals($results1, $results2->data());

        echo "Old JsonPath: " . ($end1 - $start1) . PHP_EOL;
        echo "JSONPath: " . ($end2 - $start2) . PHP_EOL;
    }

    public function testBenchmark3()
    {
        $goessnerJsonPath = new PeekmoJsonPath;
        $exampleData = $this->exampleData();

        $start1 = microtime(true);
        for ($i = 0; $i < 100; $i += 1) {
            $results1 = $goessnerJsonPath->jsonPath($exampleData, '$..*');
        }
        $end1 = microtime(true);

        $start2 = microtime(true);
        for ($i = 0; $i < 100; $i += 1) {
            $results2 = (new JSONPath($exampleData))->find('$..*');
        }
        $end2 = microtime(true);

        $this->assertEquals($results1, $results2->data());

        echo "Old JsonPath: " . ($end1 - $start1) . PHP_EOL;
        echo "JSONPath: " . ($end2 - $start2) . PHP_EOL;
    }

    public function testBenchmark4()
    {
        $goessnerJsonPath = new PeekmoJsonPath;
        $exampleData = $this->exampleData();

        $start1 = microtime(true);
        for ($i = 0; $i < 100; $i += 1) {
            $results1 = $goessnerJsonPath->jsonPath($exampleData, '$..price');
        }
        $end1 = microtime(true);

        $exampleData = $this->exampleData(true);

        $start2 = microtime(true);
        for ($i = 0; $i < 100; $i += 1) {
            $results2 = (new JSONPath($exampleData))->find('$..price');
        }
        $end2 = microtime(true);

        $this->assertEquals($results1, $results2->data());

        echo "Old JsonPath: " . ($end1 - $start1) . PHP_EOL;
        echo "JSONPath: " . ($end2 - $start2) . PHP_EOL;
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

}
