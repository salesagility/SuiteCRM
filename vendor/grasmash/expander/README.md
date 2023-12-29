[![Build Status](https://app.travis-ci.com/grasmash/expander.svg?branch=master)](https://app.travis-ci.com/grasmash/expander) [![Packagist](https://img.shields.io/packagist/v/grasmash/expander.svg)](https://packagist.org/packages/grasmash/expander)
[![Total Downloads](https://poser.pugx.org/grasmash/expander/downloads)](https://packagist.org/packages/grasmash/expander) [![Coverage Status](https://coveralls.io/repos/github/grasmash/expander/badge.svg?branch=master)](https://coveralls.io/github/grasmash/expander?branch=master)

This tool expands dot-notated, string property references into their corresponding values. This is useful for run time expansion of property references in configuration files.

For example implementation, see [Yaml Expander](https://github.com/grasmash/yaml-expander).

### Installation

    composer require grasmash/expander

### Example usage:

Property references use dot notation to indicate array keys, and must be wrapped in `${}`.

Expansion logic:

```php
<?php

$array = [
    'type' => 'book',
    'book' => [
        'title' => 'Dune',
        'author' => 'Frank Herbert',
        'copyright' => '${book.author} 1965',
        'protaganist' => '${characters.0.name}',
        'media' => [
            0 => 'hardcover',
            1 => 'paperback',
        ],
        'nested-reference' => '${book.sequel}',
    ],
    'characters' => [
        0 => [
            'name' => 'Paul Atreides',
            'occupation' => 'Kwisatz Haderach',
            'aliases' => [
                0 => 'Usul',
                1 => 'Muad\'Dib',
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
    'null-value' => NULL,
    'inline-array' => [
        0 => 'one',
        1 => 'two',
        2 => 'three',
    ],
    'expand-array' => '${inline-array}',
    'env-test' => '${env.test}',
];

$expander = new Expander();
// Optionally set a logger.
$expander->setLogger(new Psr\Log\NullLogger());
// Optionally set a Stringfier, used to convert array placeholders into strings. Defaults to using implode() with `,` delimeter.
// @see StringifierInterface.
$expander->setStringifier(new Grasmash\Expander\Stringifier());

// Parse an array, expanding internal property references.
$expanded = $expander->expandArrayProperties($array);

// Parse an array, expanding references using both internal and supplementary values.
$reference_properties =  'book' => ['sequel' => 'Dune Messiah'];
// Set an environmental variable.
putenv("test=gomjabbar");
$expanded = $expander->expandArrayProperties($array, $reference_properties);

print_r($expanded);
````

Resultant array:

```php
Array
(
    [type] => book
    [book] => Array
        (
            [title] => Dune
            [author] => Frank Herbert
            [copyright] => Frank Herbert 1965
            [protaganist] => Paul Atreides
            [media] => Array
                (
                    [0] => hardcover
                    [1] => paperback
                )

            [nested-reference] => Dune Messiah
        )

    [characters] => Array
        (
            [0] => Array
                (
                    [name] => Paul Atreides
                    [occupation] => Kwisatz Haderach
                    [aliases] => Array
                        (
                            [0] => Usul
                            [1] => Muad\'Dib
                            [2] => The Preacher
                        )

                )

            [1] => Array
                (
                    [name] => Duncan Idaho
                    [occupation] => Swordmaster
                )

        )

    [summary] => Dune by Frank Herbert
    [publisher] => ${not.real.property}
    [sequels] => Dune Messiah, and others.
    [available-products] => paperback, hardcover
    [product-name] => Dune
    [boolean-value] => true,
    [expand-boolean] => true,
    [null-value] =>
    [inline-array] => Array
        (
            [0] => one
            [1] => two
            [2] => three
        )

    [expand-array] => one,two,three
    [env-test] => gomjabbar
    [env] => Array
        (
            [test] => gomjabbar
        )

)

```
