[![Build Status](https://travis-ci.org/grasmash/yaml-expander.svg?branch=master)](https://travis-ci.org/grasmash/yaml-expander) [![Packagist](https://img.shields.io/packagist/v/grasmash/yaml-expander.svg)](https://packagist.org/packages/grasmash/yaml-expander)
[![Total Downloads](https://poser.pugx.org/grasmash/yaml-expander/downloads)](https://packagist.org/packages/grasmash/yaml-expander) [![Coverage Status](https://coveralls.io/repos/github/grasmash/yaml-expander/badge.svg?branch=master)](https://coveralls.io/github/grasmash/yaml-expander?branch=master)

This tool expands property references in YAML files.

### Installation

    composer require grasmash/yaml-expander

### Example usage:

Example dune.yml:

```yaml
type: book
book:
  title: Dune
  author: Frank Herbert
  copyright: ${book.author} 1965
  protaganist: ${characters.0.name}
  media:
    - hardcover
characters:
  - name: Paul Atreides
    occupation: Kwisatz Haderach
    aliases:
      - Usul
      - Muad'Dib
      - The Preacher
  - name: Duncan Idaho
    occupation: Swordmaster
summary: ${book.title} by ${book.author}
product-name: ${${type}.title}
```

Property references use dot notation to indicate array keys, and must be wrapped in `${}`.

Expansion logic:

```php
<?php

// Parse a yaml string directly, expanding internal property references.
$yaml_string = file_get_contents("dune.yml");
$expanded = \Grasmash\YamlExpander\Expander::parse($yaml_string);
print_r($expanded);

// Parse an array, expanding internal property references.
$array = \Symfony\Component\Yaml\Yaml::parse(file_get_contents("dune.yml"));
$expanded = \Grasmash\YamlExpander\Expander::expandArrayProperties($array);
print_r($expanded);

// Parse an array, expanding references using both internal and supplementary values.
$array = \Symfony\Component\Yaml\Yaml::parse(file_get_contents("dune.yml"));
$reference_properties = ['book' => ['publication-year' => 1965]];
$expanded = \Grasmash\YamlExpander\Expander::expandArrayProperties($array, $reference_properties);
print_r($expanded);
````

Resultant array:

```php
<?php

array (
  'type' => 'book',
  'book' => 
  array (
    'title' => 'Dune',
    'author' => 'Frank Herbert',
    'copyright' => 'Frank Herbert 1965',
    'protaganist' => 'Paul Atreides',
    'media' => 
    array (
      0 => 'hardcover',
    ),
  ),
  'characters' => 
  array (
    0 => 
    array (
      'name' => 'Paul Atreides',
      'occupation' => 'Kwisatz Haderach',
      'aliases' => 
      array (
        0 => 'Usul',
        1 => 'Muad\'Dib',
        2 => 'The Preacher',
      ),
    ),
    1 => 
    array (
      'name' => 'Duncan Idaho',
      'occupation' => 'Swordmaster',
    ),
  ),
  'summary' => 'Dune by Frank Herbert',
  'product-name' => 'Dune',
);
```
