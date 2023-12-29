<?php

namespace Robo\Task\Assets;

use Robo\Result;

/**
 * Compiles scss files.
 *
 * ```php
 * <?php
 * $this->taskScss([
 *     'scss/default.scss' => 'css/default.css'
 * ])
 * ->importDir('assets/styles')
 * ->run();
 * ?>
 * ```
 *
 * Use the following scss compiler in your project:
 *
 * ```
 * "scssphp/scssphp ": "~1.0.0",
 * ```
 *
 * You can implement additional compilers by extending this task and adding a
 * method named after them and overloading the scssCompilers() method to
 * inject the name there.
 */
class Scss extends CssPreprocessor
{
    const FORMAT_NAME = 'scss';

    /**
     * @var string[]
     */
    protected $compilers = [
        'scssphp', // https://github.com/scssphp/scssphp
    ];

    /**
     * scssphp compiler
     * @link https://github.com/scssphp/scssphp
     *
     * @param string $file
     *
     * @return string
     */
    protected function scssphp($file)
    {
        if (!class_exists('\ScssPhp\ScssPhp\Compiler')) {
            return Result::errorMissingPackage($this, 'scssphp', 'scssphp/scssphp');
        }

        $scssCode = file_get_contents($file);
        $scss = new \ScssPhp\ScssPhp\Compiler();

        // set options for the scssphp compiler
        if (isset($this->compilerOptions['importDirs'])) {
            $scss->setImportPaths($this->compilerOptions['importDirs']);
        }

        if (isset($this->compilerOptions['formatter'])) {
            $scss->setFormatter($this->compilerOptions['formatter']);
        }

        return $scss->compile($scssCode);
    }

    /**
     * Sets the formatter for scssphp
     *
     * The method setFormatter($formatterName) sets the current formatter to $formatterName,
     * the name of a class as a string that implements the formatting interface. See the source
     * for ScssPhp\ScssPhp\Formatter\Expanded for an example.
     *
     * Five formatters are included with scssphp/scssphp:
     * - ScssPhp\ScssPhp\Formatter\Expanded
     * - ScssPhp\ScssPhp\Formatter\Nested (default)
     * - ScssPhp\ScssPhp\Formatter\Compressed
     * - ScssPhp\ScssPhp\Formatter\Compact
     * - ScssPhp\ScssPhp\Formatter\Crunched
     *
     * @link https://scssphp.github.io/scssphp/docs/#output-formatting
     *
     * @param string $formatterName
     *
     * @return $this
     */
    public function setFormatter($formatterName)
    {
        return parent::setFormatter($formatterName);
    }
}
