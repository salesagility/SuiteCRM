JSONPath
=============

This is a [JSONPath](http://goessner.net/articles/JsonPath/) implementation for PHP based on Stefan Goessner's JSONPath script.

JSONPath is an XPath-like expression language for filtering, flattening and extracting data.

I believe that is improves on the original script (which was last updated in 2007) by doing a few things:

-   Object-oriented code (should be easier to manage or extend in future)
-   Expressions are parsed into tokens using some code cribbed from Doctrine Lexer and cached
-   There is no `eval()` in use
-   Performance is pretty much the same
-   Any combination of objects/arrays/ArrayAccess-objects can be used as the data input which is great if you're de-serializing JSON in to objects
    or if you want to process your own data structures.

JSONPath Examples
---

JSONPath                  | Result
--------------------------|-------------------------------------
`$.store.books[\*].author` | the authors of all books in the store
`$..author`                | all authors
`$.store..price`           | the price of everything in the store.
`$..books[2]`              | the third book
`$..books[(@.length-1)]`   | the last book in order.
`$..books[0,1]`            | the first two books
`$..books[:2]`             | the first two books
`$..books[?(@.isbn)]`      | filter all books with isbn number
`$..books[?(@.price<10)]`  | filter all books cheapier than 10
`$..*`                     | all elements in the data (recursively extracted)


Expression syntax
---

Symbol                | Description
----------------------|-------------------------
`$`                   | The root object/element (not strictly necessary)
`@`                   | The current object/element
`.` or `[]`           | Child operator
`..`                  | Recursive descent
`*`                   | Wildcard. All child elements regardless their index.
`[,]`                 | Array indices as a set
`[start:end:step]`    | Array slice operator borrowed from ES4/Python.
`?()`                 | Filters a result set by a script expression
`()`                  | Uses the result of a script expression as the index

PHP Usage
---

```php
$data = ['people' => [['name' => 'Joe'], ['name' => 'Jane'], ['name' => 'John']]];
$result = (new JSONPath($data))->find('$.people.*.name'); // returns new JSONPath
// $result[0] === 'Joe'
// $result[1] === 'Jane'
// $result[2] === 'John'
```

### Magic method access

The options flag `JSONPath::ALLOW_MAGIC` will instruct JSONPath when retrieving a value to first check if an object
has a magic `__get()` method and will call this method if available. This feature is *iffy* and
not very predictable as:

-  wildcard and recursive features will only look at public properties and can't smell which properties are magically accessible
-  there is no `property_exists` check for magic methods so an object with a magic `__get()` will always return `true` when checking
   if the property exists
-   any errors thrown or unpredictable behaviour caused by fetching via `__get()` is your own problem to deal with

```php
$jsonPath = new JSONPath($myObject, JSONPath::ALLOW_MAGIC);
```

For more examples, check the JSONPathTest.php tests file.

Script expressions
-------

Script expressions are not supported as the original author intended because:

-   This would only be achievable through `eval` (boo).
-   Using the script engine from different languages defeats the purpose of having a single expression evaluate the same way in different
    languages which seems like a bit of a flaw if you're creating an abstract expression syntax.

So here are the types of query expressions that are supported:

	[?(@._KEY_ _OPERATOR_ _VALUE_)] // <, >, !=, and ==
	Eg.
	[?(@.title == "A string")] //
	[?(@.title = "A string")]
	// A single equals is not an assignment but the SQL-style of '=='

Similar projects
----------------

[JMESPath](https://github.com/jmespath) does similiar things, is full of features and has a PHP implementation

The [Hash](http://book.cakephp.org/2.0/en/core-utility-libraries/hash.html) utility from CakePHP does some similar things 

The original JsonPath implementations is available at [http://code.google.com/p/jsonpath]() and re-hosted for composer
here [Peekmo/JsonPath](https://github.com/Peekmo/JsonPath).

[ObjectPath](http://objectpath.org) ([https://github.com/adriank/ObjectPath]()) appears to be a Python/JS implementation
with a new name and extra features.

Changelog
---------

### 0.3.0
 - Added JSONPathToken class as value object
 - Lexer clean up and refactor
 - Updated the lexing and filtering of the recursive token ("..") to allow for a combination of recursion
   and filters, eg. $..[?(@.type == 'suburb')].name

### 0.2.1 - 0.2.5
 - Various bug fixes and clean up

### 0.2.0
 - Added a heap of array access features for more creative iterating and chaining possibilities

### 0.1.x
 - Init
