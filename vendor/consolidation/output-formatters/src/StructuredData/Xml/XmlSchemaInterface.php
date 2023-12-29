<?php

namespace Consolidation\OutputFormatters\StructuredData\Xml;

/**
 * When using arrays, we could represent XML data in a number of
 * different ways.
 *
 * For example, given the following XML data strucutre:
 *
 * <document id="1" name="doc">
 *   <foobars>
 *     <foobar id="123">
 *       <name>blah</name>
 *       <widgets>
 *         <widget>
 *            <foo>a</foo>
 *            <bar>b</bar>
 *            <baz>c</baz>
 *         </widget>
 *       </widgets>
 *     </foobar>
 *   </foobars>
 * </document>
 *
 * This could be:
 *
 *  [
 *    'id' => 1,
 *    'name'  => 'doc',
 *    'foobars' =>
 *    [
 *       [
 *         'id' => '123',
 *         'name' => 'blah',
 *         'widgets' =>
 *         [
 *            [
 *              'foo' => 'a',
 *              'bar' => 'b',
 *              'baz' => 'c',
 *            ]
 *         ],
 *       ],
 *    ]
 *  ]
 *
 * The challenge is more in going from an array back to the more
 * structured xml format.  Note that any given key => string mapping
 * could represent either an attribute, or a simple XML element
 * containing only a string value. In general, we do *not* want to add
 * extra layers of nesting in the data structure to disambiguate between
 * these kinds of data, as we want the source data to render cleanly
 * into other formats, e.g. yaml, json, et. al., and we do not want to
 * force every data provider to have to consider the optimal xml schema
 * for their data.
 *
 * Our strategy, therefore, is to expect clients that wish to provide
 * a very specific xml representation to return a DOMDocument, and,
 * for other data structures where xml is a secondary concern, then we
 * will use some default heuristics to convert from arrays to xml.
 */
interface XmlSchemaInterface
{
    /**
     * Convert data to a format suitable for use in a list.
     * By default, the array values will be used.  Implement
     * ListDataInterface to use some other criteria (e.g. array keys).
     *
     * @return \DOMDocument
     */
    public function arrayToXml($structuredData);
}
