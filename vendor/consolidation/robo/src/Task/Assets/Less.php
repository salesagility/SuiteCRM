<?php

namespace Robo\Task\Assets;

use Robo\Result;

/**
 * Compiles less files.
 *
 * ```php
 * <?php
 * $this->taskLess([
 *     'less/default.less' => 'css/default.css'
 * ])
 * ->run();
 * ?>
 * ```
 *
 * Use one of both less compilers in your project:
 *
 * ```
 * "leafo/lessphp": "~0.5",
 * "oyejorge/less.php": "~1.5"
 * ```
 *
 * Specify directory (string or array) for less imports lookup:
 *
 * ```php
 * <?php
 * $this->taskLess([
 *     'less/default.less' => 'css/default.css'
 * ])
 * ->importDir('less')
 * ->compiler('lessphp')
 * ->run();
 * ?>
 * ```
 *
 * You can implement additional compilers by extending this task and adding a
 * method named after them and overloading the lessCompilers() method to
 * inject the name there.
 */
class Less extends CssPreprocessor
{
    const FORMAT_NAME = 'less';

    /**
     * @var string[]
     */
    protected $compilers = [
        'less', // https://github.com/oyejorge/less.php
        'lessphp', //https://github.com/leafo/lessphp
    ];

    /**
     * lessphp compiler
     * @link https://github.com/leafo/lessphp
     *
     * @param string $file
     *
     * @return string
     */
    protected function lessphp($file)
    {
        if (!class_exists('\lessc')) {
            return Result::errorMissingPackage($this, 'lessc', 'leafo/lessphp');
        }

        $lessCode = file_get_contents($file);

        $less = new \lessc();
        if (isset($this->compilerOptions['importDirs'])) {
            $less->setImportDir($this->compilerOptions['importDirs']);
        }

        return $less->compile($lessCode);
    }

    /**
     * less compiler
     * @link https://github.com/oyejorge/less.php
     *
     * @param string $file
     *
     * @return string
     */
    protected function less($file)
    {
        if (!class_exists('\Less_Parser')) {
            return Result::errorMissingPackage($this, 'Less_Parser', 'oyejorge/less.php');
        }

        $lessCode = file_get_contents($file);

        $parser = new \Less_Parser();
        $parser->SetOptions($this->compilerOptions);
        if (isset($this->compilerOptions['importDirs'])) {
            $importDirs = [];
            foreach ($this->compilerOptions['importDirs'] as $dir) {
                $importDirs[$dir] = $dir;
            }
            $parser->SetImportDirs($importDirs);
        }

        $parser->parse($lessCode);

        return $parser->getCss();
    }
}
