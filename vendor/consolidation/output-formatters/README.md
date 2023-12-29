# Consolidation\OutputFormatters

Apply transformations to structured data to write output in different formats.

[![ci](https://github.com/consolidation/output-formatters/workflows/CI/badge.svg)](https://travis-ci.org/consolidation/output-formatters)
[![scrutinizer](https://scrutinizer-ci.com/g/consolidation/output-formatters/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/consolidation/output-formatters/?branch=master)
[![codecov](https://codecov.io/gh/consolidation/output-formatters/branch/main/graph/badge.svg?token=CAaB7ofhxx)](https://codecov.io/gh/consolidation/output-formatters)
[![license](https://poser.pugx.org/consolidation/output-formatters/license)](https://packagist.org/packages/consolidation/output-formatters)


## Motivation

Formatters are used to allow simple commandline tool commands to be implemented in a manner that is completely independent from the Symfony Console output interfaces.  A command receives its input via its method parameters, and returns its result as structured data (e.g. a php standard object or array).  The structured data is then formatted by a formatter, and the result is printed.

This process is managed by the [Consolidation/AnnotatedCommand](https://github.com/consolidation/annotated-command) project.

## Library Usage

This is a library intended to be used in some other project.  Require from your composer.json file:
```
    "require": {
        "consolidation/output-formatters": "^4"
    },
```

## Example Formatter

Simple formatters are very easy to write.
```php
class YamlFormatter implements FormatterInterface
{
    public function write(OutputInterface $output, $data, FormatterOptions $options)
    {
        $dumper = new Dumper();
        $output->writeln($dumper->dump($data));
    }
}
```
The formatter is passed the set of `$options` that the user provided on the command line. These may optionally be examined to alter the behavior of the formatter, if needed.

Formatters may also implement different interfaces to alter the behavior of the rendering engine.

- `ValidationInterface`: A formatter should implement this interface to test to see if the provided data type can be processed. Any formatter that does **not** implement this interface is presumed to operate exclusively on php arrays. The formatter manager will always convert any provided data into an array before passing it to a formatter that does not implement ValidationInterface. These formatters will not be made available when the returned data type cannot be converted into an array.
- `OverrideRestructureInterface`: A formatter that implements this interface will be given the option to act on the provided structured data object before it restructures itself. See the section below on structured data for details on data restructuring.
- `UnstructuredInterface`: A formatter that implements this interface will not be able to be formatted by the `string` formatter by default. Data structures that do not implement this interface will be automatically converted to a string when applicable; if this conversion fails, then no output is produced.
- `StringTransformationInterface`: Implementing this interface allows a data type to provide a specific implementation for the conversion of the data to a string. Data types that implement both `UnstructuredInterface` and `StringTransformationInterface` may be used with the `string` format.

## Configuring Formats for a Command

Commands declare what type of data they return using a `@return` annotation, as usual:
```php
    /**
     * Demonstrate formatters.  Default format is 'table'.
     *
     * @field-labels
     *   first: I
     *   second: II
     *   third: III
     * @default-string-field second
     * @usage try:formatters --format=yaml
     * @usage try:formatters --format=csv
     * @usage try:formatters --fields=first,third
     * @usage try:formatters --fields=III,II
     *
     * @return \Consolidation\OutputFormatters\StructuredData\RowsOfFields
     */
    public function tryFormatters($somthing = 'default', $options = ['format' => 'table', 'fields' => ''])
    {
        $outputData = [
            'en' => [ 'first' => 'One',  'second' => 'Two',  'third' => 'Three' ],
            'de' => [ 'first' => 'Eins', 'second' => 'Zwei', 'third' => 'Drei'  ],
            'jp' => [ 'first' => 'Ichi', 'second' => 'Ni',   'third' => 'San'   ],
            'es' => [ 'first' => 'Uno',  'second' => 'Dos',  'third' => 'Tres'  ],
        ];
        return new RowsOfFields($outputData);
    }
```
The output-formatters library determines which output formats are applicable to the command by querying all available formats, and selecting any that are able to process the data type that is returned. Thus, if a new format is added to a program, it will automatically be available via any command that it works with. It is not necessary to hand-select the available formats on every command individually.

### Structured Data

Most formatters will operate on any array or ArrayObject data. Some formatters require that specific data types be used. The following data types, all of which are subclasses of ArrayObject, are available for use:

- `RowsOfFields`: Each row contains an associative array of field:value pairs. It is also assumed that the fields of each row are the same for every row. This format is ideal for displaying in a table, with labels in the top row.
- `RowsOfFieldsWithMetadata`: Equivalent to `RowsOfFields`, but allows for metadata to be attached to the result. The metadata is not displayed in table format, but is evident if the data is converted to another format (e.g. `yaml` or `json`). The table data may either be nested inside of a specially-designated element, with other elements being used as metadata, or, alternately, the metadata may be nested inside of an element, with all other elements being used as data.
- `PropertyList`: Each row contains a field:value pair. Each field is unique. This format is ideal for displaying in a table, with labels in the first column and values in the second common.
- `UnstructuredListData`: The result is assumed to be a list of items, with the key of each row being used as the row id. The data elements may contain any sort of array data. The elements on each row do not need to be uniform, and the data may be nested to arbitrary depths.
- `UnstructuredData`: The result is an unstructured array nested to arbitrary levels.
- `DOMDocument`: The standard PHP DOM document class may be used by functions that need to be able to presicely specify the exact attributes and children when the XML output format is used.
- `ListDataFromKeys`: This data structure is deprecated. Use `UnstructuredListData` instead.

Commands that need to produce XML output should return a DOMDocument as its return type. The formatter manager will do its best to convert from an array to a DOMDocument, or from a DOMDocument to an array, as needed. It is important to note that a DOMDocument does not have a 1-to-1 mapping with a PHP array.  DOM elements contain both attributes and elements; a simple string property 'foo' may be represented either as <element foo="value"/> or <element><foo>value</foo></element>. Also, there may be multiple XML elements with the same name, whereas php associative arrays must always have unique keys. When converting from an array to a DOM document, the XML formatter will default to representing the string properties of an array as attributes of the element. Sets of elements with the same name may be used only if they are wrapped in a containing parent element--e.g. <element><foos><foo>one</foo><foo>two</foo></foos></element>. The XMLSchema class may be used to provide control over whether a property is rendered as an attribute or an element; however, in instances where the schema of the XML output is important, it is best for a function to return its result as a DOMDocument rather than an array.

A function may also define its own structured data type to return, usually by extending one of the types mentioned above.  If a custom structured data class implements an appropriate interface, then it can provide its own conversion function to one of the other data types:

- `DomDataInterface`: The data object may produce a DOMDocument via its `getDomData()` method, which will be called in any instance where a DOM document is needed--typically with the xml formatter.
- `ListDataInterface`: Any structured data object that implements this interface may use the `getListData()` method to produce the data set that will be used with the list formatter.
- `TableDataInterface`: Any structured data object that implements this interface may use the `getTableData()` method to produce the data set that will be used with the table formatter.
- `RenderCellInterface`: Structured data can also provide fine-grain control over how each cell in a table is rendered by implementing the RenderCellInterface.  See the section below for information on how this is done.
- `RestructureInterface`: The restructure interface can be implemented by a structured data object to restructure the data in response to options provided by the user. For example, the RowsOfFields and PropertyList data types use this interface to select and reorder the fields that were selected to appear in the output. Custom data types usually will not need to implement this interface, as they can inherit this behavior by extending RowsOfFields or PropertyList.

Additionally, structured data may be simplified to arrays via an array simplification object. To provide an array simplifier, implement `SimplifyToArrayInterface`, and register the simplifier via `FormatterManager::addSimplifier()`.

### Fields

Some commands produce output that contain *fields*. A field may be either the key in a key/value pair, or it may be the label used in tabular output and so on.

#### Declaring Default Fields

If a command declares a very large number of fields, it is possible to display only a subset of the available options by way of the `@default-fields` annotation. The following example comes from Drush:
```php
    /**
     * @command cache:get
     * @field-labels
     *   cid: Cache ID
     *   data: Data
     *   created: Created
     *   expire: Expire
     *   tags: Tags
     *   checksum: Checksum
     *   valid: Valid
     * @default-fields cid,data,created,expire,tags
     * @return \Consolidation\OutputFormatters\StructuredData\PropertyList
     */
    public function get($cid, $bin = 'default', $options = ['format' => 'json'])
    {
        $result = ...
        return new PropertyList($result);
    }
```
All of the available fields will be listed in the `help` output for the command, and may be selected by listing the desired fields explicitly via the `--fields` option.

To include all avalable fields, use `--fields=*`.

Note that using the `@default-fields` annotation will reduce the number of fields included in the output for all formats, including unstructured formats such as json and yaml. To specify a reduced set of fields to display only when using a human-readable output format (e.g. table), use the `@default-table-fields` annotation instead.

#### Reordering Fields

Commands that return table structured data with fields can be filtered and/or re-ordered by using the `--fields` option. These structured data types can also be formatted into a more generic type such as yaml or json, even after being filtered. This capabilities are not available if the data is returned in a bare php array. One of `RowsOfFields`, `PropertyList` or `UnstructuredListData` (or similar) must be used.

When the `--fields` option is provided, the user may stipulate the exact fields to list on each row, and what order they should appear in. For example, if a command usually produces output using the `RowsOfFields` data type, as shown below:
```
$ ./app try:formatters
 ------ ------ ------- 
  I      II     III    
 ------ ------ ------- 
  One    Two    Three  
  Eins   Zwei   Drei   
  Ichi   Ni     San    
  Uno    Dos    Tres   
 ------ ------ ------- 
```
Then the third and first fields may be selected as follows:
```
 $ ./app try:formatters --fields=III,I
 ------- ------ 
  III     I     
 ------- ------ 
  Three   One   
  Drei    Eins  
  San     Ichi  
  Tres    Uno   
 ------- ------ 
```
To select a single column and strip away all formatting, use the `--field` option:
```
$ ./app try:formatters --field=II
Two
Zwei
Ni
Dos
```
Commands that produce deeply-nested data structures using the `UnstructuredData` and `UnstructuredListData` data type may also be manipulated using the `--fields` and `--field` options. It is possible to address items deep in the heirarchy using dot notation.

The `UnstructuredData` type represents a single nested array with no requirements for uniform structure. The `UnstructuredListData` type is similar; it represents a list of `UnstructuredData` types. It is not required for the different elements in the list to have all of the same fields or structure, although it is expected that there will be a certain degree of similarity.

In the example below, a command returns a list of stores of different kinds. Each store has common top-level elements such as `name`, `products` and `sale-items`. Each store might have different sorts of products with different attributes:
```
$ ./app try:nested
bills-hardware:
  name: 'Bill''s Hardware'
  products:
    tools:
      electric-drill:
        price: '79.98'
      screwdriver:
        price: '8.99'
  sale-items:
    screwdriver: '4.99'
alberts-supermarket:
  name: 'Albert''s Supermarket'
  products:
    fruits:
      strawberries:
        price: '2'
        units: lbs
      watermellons:
        price: '5'
        units: each
  sale-items:
    watermellons: '4.50'
```
Just as is the case with tabular output, it is possible to select only a certain set of fields to display with each output item:
```
$ ./app try:nested --fields=sale-items
bills-hardware:
  sale-items:
    screwdriver: '4.99'
alberts-supermarket:
  sale-items:
    watermellons: '4.50'
```
With unstructured data, it is also possible to remap the name of the field to something else:
```
$ ./robo try:nested --fields='sale-items as items'
bills-hardware:
  items:
    screwdriver: '4.99'
alberts-supermarket:
  items:
    watermellons: '4.50'
```
The field name `.` is special, though: it indicates that the named element should be omitted, and its value or children should be applied directly to the result row:
```
$ ./app try:nested --fields='sale-items as .'
bills-hardware:
  screwdriver: '4.99'
alberts-supermarket:
  watermellons: '4.50'
```
Finally, it is also possible to reach down into nested data structures and pull out information about an element or elements identified using "dot" notation:
```
$ ./app try:nested --fields=products.fruits.strawberries
bills-hardware: {  }
alberts-supermarket:
  strawberries:
    price: '2'
    units: lbs
```
Commands that use `RowsOfFields` or `PropertyList` return type will be automatically converted to `UnstructuredListData` or `UnstructuredData`, respectively, whenever any field remapping is done. This will only work for data types such as `yaml` or `json` that can render unstructured data types. It is not possible to render unstructured data in a table, even if the resulting data happens to be uniform.

### Filtering Specific Rows

A command may allow the user to filter specific rows of data using simple boolean logic and/or regular expressions. For details, see the external library [consolidation/filter-via-dot-access-data](https://github.com/consolidation/filter-via-dot-access-data) that provides this capability.

## Rendering Table Cells

By default, both the RowsOfFields and PropertyList data types presume that the contents of each cell is a simple string. To render more complicated cell contents, create a custom structured data class by extending either RowsOfFields or PropertyList, as desired, and implement RenderCellInterface.  The `renderCell()` method of your class will then be called for each cell, and you may act on it as appropriate.
```php
public function renderCell($key, $cellData, FormatterOptions $options, $rowData)
{
    // 'my-field' is always an array; convert it to a comma-separated list.
    if ($key == 'my-field') {
        return implode(',', $cellData);
    }
    // MyStructuredCellType has its own render function
    if ($cellData instanceof MyStructuredCellType) {
        return $cellData->myRenderfunction();
    }
    // If we do not recognize the cell data, return it unchnaged.
    return $cellData;
}
```
Note that if your data structure is printed with a formatter other than one such as the table formatter, it will still be reordered per the selected fields, but cell rendering will **not** be done.

The RowsOfFields and PropertyList data types also allow objects that implement RenderCellInterface, as well as anonymous functions to be added directly to the data structure object itself. If this is done, then the renderer will be called for each cell in the table. An example of an attached renderer implemented as an anonymous function is shown below.
```php
    return (new RowsOfFields($data))->addRendererFunction(
        function ($key, $cellData, FormatterOptions $options, $rowData) {
            if ($key == 'my-field') {
                return implode(',', $cellData);
            }
            return $cellData;
        }
    );
```
This project also provides a built-in cell renderer, NumericCellRenderer, that adds commas at the thousands place and right-justifies columns identified as numeric. An example of a numeric renderer attached to two columns of a data set is shown below.
```php
use Consolidation\OutputFormatters\StructuredData\NumericCellRenderer;
...
    return (new RowsOfFields($data))->addRenderer(
         new NumericCellRenderer($data, ['population','cats-per-capita'])
    );
```

## API Usage

It is recommended to use [Consolidation/AnnotatedCommand](https://github.com/consolidation/annotated-command) to manage commands and formatters.  See the [AnnotatedCommand API Usage](https://github.com/consolidation/annotated-command#api-usage) for details.

The FormatterManager may also be used directly, if desired:
```php
/**
 * @param OutputInterface $output Output stream to write to
 * @param string $format Data format to output in
 * @param mixed $structuredOutput Data to output
 * @param FormatterOptions $options Configuration informatin and User options
 */
function doFormat(
    OutputInterface $output,
    string $format, 
    array $data,
    FormatterOptions $options) 
{
    $formatterManager = new FormatterManager();
    $formatterManager->write(output, $format, $data, $options);
}
```
The FormatterOptions class is used to hold the configuration for the command output--things such as the default field list for tabular output, and so on--and also the current user-selected options to use during rendering, which may be provided using a Symfony InputInterface object:
```
public function execute(InputInterface $input, OutputInterface $output)
{
    $options = new FormatterOptions();
    $options
      ->setInput($input)
      ->setFieldLabels(['id' => 'ID', 'one' => 'First', 'two' => 'Second'])
      ->setDefaultStringField('id');

    $data = new RowsOfFields($this->getSomeData($input));
    return $this->doFormat($output, $options->getFormat(), $data, $options);
}
```
## Comparison to Existing Solutions

Formatters have been in use in Drush since version 5. Drush allows formatters to be defined using simple classes, some of which may be configured using metadata. Furthermore, nested formatters are also allowed; for example, a list formatter may be given another formatter to use to format each of its rows. Nested formatters also require nested metadata, causing the code that constructed formatters to become very complicated and unweildy.

Consolidation/OutputFormatters maintains the simplicity of use provided by Drush formatters, but abandons nested metadata configuration in favor of using code in the formatter to configure itself, in order to keep the code simpler.

