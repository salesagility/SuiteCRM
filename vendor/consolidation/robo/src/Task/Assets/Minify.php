<?php

namespace Robo\Task\Assets;

use Robo\Result;
use Robo\Task\BaseTask;

/**
 * Minifies an asset file (CSS or JS).
 *
 * ``` php
 * <?php
 * $this->taskMinify('web/assets/theme.css')
 *      ->run()
 * ?>
 * ```
 * Please install additional packages to use this task:
 *
 * ```
 * composer require patchwork/jsqueeze:^2.0
 * composer require natxet/cssmin:^3.0
 * ```
 */
class Minify extends BaseTask
{
    /**
     * @var string[]
     */
    protected $types = ['css', 'js'];

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $dst;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var bool[]
     */
    protected $squeezeOptions = [
        'singleLine' => true,
        'keepImportantComments' => true,
        'specialVarRx' => false,
    ];

    /**
     * Constructor. Accepts asset file path or string source.
     *
     * @param string $input
     */
    public function __construct($input)
    {
        if (file_exists($input)) {
            $this->fromFile($input);
            return;
        }

        $this->fromText($input);
    }

    /**
     * Sets destination. Tries to guess type from it.
     *
     * @param string $dst
     *
     * @return $this
     */
    public function to($dst)
    {
        $this->dst = $dst;

        if (!empty($this->dst) && empty($this->type)) {
            $this->type($this->getExtension($this->dst));
        }

        return $this;
    }

    /**
     * Sets type with validation.
     *
     * @param string $type
     *   Allowed values: "css", "js".
     *
     * @return $this
     */
    public function type($type)
    {
        $type = strtolower($type);

        if (in_array($type, $this->types)) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Sets text from string source.
     *
     * @param string $text
     *
     * @return $this
     */
    protected function fromText($text)
    {
        $this->text = (string)$text;
        unset($this->type);

        return $this;
    }

    /**
     * Sets text from asset file path. Tries to guess type and set default destination.
     *
     * @param string $path
     *
     * @return $this
     */
    protected function fromFile($path)
    {
        $this->text = file_get_contents($path);

        unset($this->type);
        $this->type($this->getExtension($path));

        if (empty($this->dst) && !empty($this->type)) {
            $ext_length = strlen($this->type) + 1;
            $this->dst = substr($path, 0, -$ext_length) . '.min.' . $this->type;
        }

        return $this;
    }

    /**
     * Gets file extension from path.
     *
     * @param string $path
     *
     * @return string
     */
    protected function getExtension($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Minifies and returns text.
     *
     * @return string|bool
     */
    protected function getMinifiedText()
    {
        switch ($this->type) {
            case 'css':
                if (!class_exists('\CssMin')) {
                    return Result::errorMissingPackage($this, 'CssMin', 'natxet/cssmin');
                }

                return \CssMin::minify($this->text);
                break;

            case 'js':
                if (!class_exists('\JSqueeze') && !class_exists('\Patchwork\JSqueeze')) {
                    return Result::errorMissingPackage($this, 'Patchwork\JSqueeze', 'patchwork/jsqueeze');
                }

                if (class_exists('\JSqueeze')) {
                    $jsqueeze = new \JSqueeze();
                } else {
                    $jsqueeze = new \Patchwork\JSqueeze();
                }

                return $jsqueeze->squeeze(
                    $this->text,
                    $this->squeezeOptions['singleLine'],
                    $this->squeezeOptions['keepImportantComments'],
                    $this->squeezeOptions['specialVarRx']
                );
                break;
        }

        return false;
    }

    /**
     * Single line option for the JS minimisation.
     *
     * @param bool $singleLine
     *
     * @return $this
     */
    public function singleLine($singleLine)
    {
        $this->squeezeOptions['singleLine'] = (bool)$singleLine;
        return $this;
    }

    /**
     * keepImportantComments option for the JS minimisation.
     *
     * @param bool $keepImportantComments
     *
     * @return $this
     */
    public function keepImportantComments($keepImportantComments)
    {
        $this->squeezeOptions['keepImportantComments'] = (bool)$keepImportantComments;
        return $this;
    }

    /**
     * Set specialVarRx option for the JS minimisation.
     *
     * @param bool $specialVarRx
     *
     * @return $this
     */
    public function specialVarRx($specialVarRx)
    {
        $this->squeezeOptions['specialVarRx'] = (bool)$specialVarRx;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getMinifiedText();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (empty($this->type)) {
            return Result::error($this, 'Unknown asset type.');
        }

        if (empty($this->dst)) {
            return Result::error($this, 'Unknown file destination.');
        }

        if (file_exists($this->dst) && !is_writable($this->dst)) {
            return Result::error($this, 'Destination already exists and cannot be overwritten.');
        }

        $size_before = strlen($this->text);
        $minified = $this->getMinifiedText();

        if ($minified instanceof Result) {
            return $minified;
        } elseif (false === $minified) {
            return Result::error($this, 'Minification failed.');
        }

        $size_after = strlen($minified);

        // Minification did not reduce file size, so use original file.
        if ($size_after > $size_before) {
            $minified = $this->text;
            $size_after = $size_before;
        }

        $dst = $this->dst . '.part';
        $write_result = file_put_contents($dst, $minified);

        if (false === $write_result) {
            @unlink($dst);
            return Result::error($this, 'File write failed.');
        }
        // Cannot be cross-volume; should always succeed.
        @rename($dst, $this->dst);
        if ($size_before === 0) {
            $minified_percent = 0;
        } else {
            $minified_percent = number_format(100 - ($size_after / $size_before * 100), 1);
        }
        $this->printTaskSuccess('Wrote {filepath}', ['filepath' => $this->dst]);
        $context = [
            'bytes' => $this->formatBytes($size_after),
            'reduction' => $this->formatBytes(($size_before - $size_after)),
            'percentage' => $minified_percent,
        ];
        $this->printTaskSuccess('Wrote {bytes} (reduced by {reduction} / {percentage})', $context);
        return Result::success($this, 'Asset minified.');
    }
}
