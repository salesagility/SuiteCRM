<?php

namespace Robo\Task\Assets;

use Robo\Result;
use Robo\Task\BaseTask;

abstract class CssPreprocessor extends BaseTask
{
    const FORMAT_NAME = '';

    /**
     * Default compiler to use.
     *
     * @var string
     */
    protected $compiler;

    /**
     * Available compilers list
     *
     * @var string[]
     */
    protected $compilers = [];

    /**
     * Compiler options.
     *
     * @var array
     */
    protected $compilerOptions = [];

    /**
     * @var array
     */
    protected $files = [];

    /**
     * Constructor. Accepts array of file paths.
     *
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->files = $input;

        $this->setDefaultCompiler();
    }

    protected function setDefaultCompiler()
    {
        if (isset($this->compilers[0])) {
            //set first compiler as default
            $this->compiler = $this->compilers[0];
        }
    }

    /**
     * Sets import directories
     * Alias for setImportPaths
     * @see CssPreprocessor::setImportPaths
     *
     * @param array|string $dirs
     *
     * @return $this
     */
    public function importDir($dirs)
    {
        return $this->setImportPaths($dirs);
    }

    /**
     * Adds import directory
     *
     * @param string $dir
     *
     * @return $this
     */
    public function addImportPath($dir)
    {
        if (!isset($this->compilerOptions['importDirs'])) {
            $this->compilerOptions['importDirs'] = [];
        }

        if (!in_array($dir, $this->compilerOptions['importDirs'], true)) {
            $this->compilerOptions['importDirs'][] = $dir;
        }

        return $this;
    }

    /**
     * Sets import directories
     *
     * @param array|string $dirs
     *
     * @return $this
     */
    public function setImportPaths($dirs)
    {
        if (!is_array($dirs)) {
            $dirs = [$dirs];
        }

        $this->compilerOptions['importDirs'] = $dirs;

        return $this;
    }

    /**
     * @param string $formatterName
     *
     * @return $this
     */
    public function setFormatter($formatterName)
    {
        $this->compilerOptions['formatter'] = $formatterName;

        return $this;
    }

    /**
     * Sets the compiler.
     *
     * @param string $compiler
     * @param array $options
     *
     * @return $this
     */
    public function compiler($compiler, array $options = [])
    {
        $this->compiler = $compiler;
        $this->compilerOptions = array_merge($this->compilerOptions, $options);

        return $this;
    }

    /**
     * Compiles file
     *
     * @param $file
     *
     * @return bool|mixed
     */
    protected function compile($file)
    {
        if (is_callable($this->compiler)) {
            return call_user_func($this->compiler, $file, $this->compilerOptions);
        }

        if (method_exists($this, $this->compiler)) {
            return $this->{$this->compiler}($file);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!in_array($this->compiler, $this->compilers, true)
            && !is_callable($this->compiler)
        ) {
            $message = sprintf('Invalid ' . static::FORMAT_NAME . ' compiler %s!', $this->compiler);

            return Result::error($this, $message);
        }

        foreach ($this->files as $in => $out) {
            if (!file_exists($in)) {
                $message = sprintf('File %s not found.', $in);

                return Result::error($this, $message);
            }
            if (file_exists($out) && !is_writable($out)) {
                return Result::error($this, 'Destination already exists and cannot be overwritten.');
            }
        }

        foreach ($this->files as $in => $out) {
            $css = $this->compile($in);

            if ($css instanceof Result) {
                return $css;
            } elseif (false === $css) {
                $message = sprintf(
                    ucfirst(static::FORMAT_NAME) . ' compilation failed for %s.',
                    $in
                );

                return Result::error($this, $message);
            }

            $dst = $out . '.part';
            $write_result = file_put_contents($dst, $css);

            if (false === $write_result) {
                $message = sprintf('File write failed: %s', $out);

                @unlink($dst);
                return Result::error($this, $message);
            }

            // Cannot be cross-volume: should always succeed
            @rename($dst, $out);

            $this->printTaskSuccess('Wrote CSS to {filename}', ['filename' => $out]);
        }

        return Result::success($this, 'All ' . static::FORMAT_NAME . ' files compiled.');
    }
}
