<?php

namespace Robo\Task\Assets;

use Robo\Result;
use Robo\Exception\TaskException;
use Robo\Task\BaseTask;
use Robo\Task\Base\Exec;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem as sfFilesystem;

/**
 * Minifies images.
 *
 * When the task is run without any specified minifier it will compress the
 * images based on the extension.
 *
 * ```php
 * $this->taskImageMinify('assets/images/*')
 *     ->to('dist/images/')
 *     ->run();
 * ```
 *
 * This will use the following minifiers based in the extension:
 *
 * - PNG: optipng
 * - GIF: gifsicle
 * - JPG, JPEG: jpegtran
 * - SVG: svgo
 *
 * When the required minifier is not installed on the system the task will try
 * to download it from the [imagemin](https://github.com/imagemin) repository
 * into a local directory.
 * This directory is `vendor/bin/` by default and may be changed:
 *
 * ```php
 * $this->taskImageMinify('assets/images/*')
 *     ->setExecutableDir('/tmp/imagemin/bin/)
 *     ->to('dist/images/')
 *     ->run();
 * ```
 *
 * When the minifier is specified the task will use that for all the input
 * files. In that case it is useful to filter the files with the extension:
 *
 * ```php
 * $this->taskImageMinify('assets/images/*.png')
 *     ->to('dist/images/')
 *     ->minifier('pngcrush');
 *     ->run();
 * ```
 *
 * The task supports the following minifiers:
 *
 * - optipng
 * - pngquant
 * - advpng
 * - pngout
 * - zopflipng
 * - pngcrush
 * - gifsicle
 * - jpegoptim
 * - jpeg-recompress
 * - jpegtran
 * - svgo (only minification, no downloading)
 *
 * You can also specifiy extra options for the minifiers:
 *
 * ```php
 * $this->taskImageMinify('assets/images/*.jpg')
 *     ->to('dist/images/')
 *     ->minifier('jpegtran', ['-progressive' => null, '-copy' => 'none'])
 *     ->run();
 * ```
 *
 * This will execute as:
 * `jpegtran -copy none -progressive -optimize -outfile "dist/images/test.jpg" "/var/www/test/assets/images/test.jpg"`
 */
class ImageMinify extends BaseTask
{
    /**
     * Destination directory for the minified images.
     *
     * @var string
     */
    protected $to;

    /**
     * Array of the source files.
     *
     * @var array
     */
    protected $dirs = [];

    /**
     * Symfony 2 filesystem.
     *
     * @var sfFilesystem
     */
    protected $fs;

    /**
     * Target directory for the downloaded binary executables.
     *
     * @var string
     */
    protected $executableTargetDir;

    /**
     * Array for the downloaded binary executables.
     *
     * @var array
     */
    protected $executablePaths = [];

    /**
     * Array for the individual results of all the files.
     *
     * @var array
     */
    protected $results = [];

    /**
     * Default minifier to use.
     *
     * @var string
     */
    protected $minifier;

    /**
     * Array for minifier options.
     *
     * @var array
     */
    protected $minifierOptions = [];

    /**
     * Supported minifiers.
     *
     * @var array
     */
    protected $minifiers = [
        // Default 4
        'optipng',
        'gifsicle',
        'jpegtran',
        'svgo',
        // PNG
        'pngquant',
        'advpng',
        'pngout',
        'zopflipng',
        'pngcrush',
        // JPG
        'jpegoptim',
        'jpeg-recompress',
    ];

    /**
     * Binary repositories of Imagemin.
     *
     * @link https://github.com/imagemin
     *
     * @var string[]
     */
    protected $imageminRepos = [
        // PNG
        'optipng' => 'https://github.com/imagemin/optipng-bin',
        'pngquant' => 'https://github.com/imagemin/pngquant-bin',
        'advpng' => 'https://github.com/imagemin/advpng-bin',
        'pngout' => 'https://github.com/imagemin/pngout-bin',
        'zopflipng' => 'https://github.com/imagemin/zopflipng-bin',
        'pngcrush' => 'https://github.com/imagemin/pngcrush-bin',
        // Gif
        'gifsicle' => 'https://github.com/imagemin/gifsicle-bin',
        // JPG
        'jpegtran' => 'https://github.com/imagemin/jpegtran-bin',
        'jpegoptim' => 'https://github.com/imagemin/jpegoptim-bin',
        'cjpeg' => 'https://github.com/imagemin/mozjpeg-bin', // note: we do not support this minifier because it creates JPG from non-JPG files
        'jpeg-recompress' => 'https://github.com/imagemin/jpeg-recompress-bin',
        // WebP
        'cwebp' => 'https://github.com/imagemin/cwebp-bin', // note: we do not support this minifier because it creates WebP from non-WebP files
    ];

    /**
     * @param string|string[] $dirs
     */
    public function __construct($dirs)
    {
        is_array($dirs)
            ? $this->dirs = $dirs
            : $this->dirs[] = $dirs;

        $this->fs = new sfFilesystem();

        // guess the best path for the executables based on __DIR__
        if (($pos = strpos(__DIR__, 'consolidation/robo')) !== false) {
            // the executables should be stored in vendor/bin
            $this->setExecutableDir(substr(__DIR__, 0, $pos) . 'bin');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        // find the files
        $files = $this->findFiles($this->dirs);

        // minify the files
        $result = $this->minify($files);
        // check if there was an error
        if ($result instanceof Result) {
            return $result;
        }

        $amount = (count($files) == 1 ? 'image' : 'images');
        $message = "Minified {filecount} out of {filetotal} $amount into {destination}";
        $context = ['filecount' => count($this->results['success']), 'filetotal' => count($files), 'destination' => $this->to];

        if (count($this->results['success']) == count($files)) {
            $this->printTaskSuccess($message, $context);

            return Result::success($this, $message, $context);
        } else {
            return Result::error($this, $message, $context);
        }
    }

    /**
     * Sets the target directory for executables (`vendor/bin/` by default)
     *
     * @param string $directory
     *
     * @return $this
     */
    public function setExecutableDir($directory)
    {
        $this->executableTargetDir = $directory;

        // check if the executables are already available in there
        foreach ($this->imageminRepos as $exec => $url) {
            $path = $this->executableTargetDir . '/' . $exec;
            // if this is Windows add a .exe extension
            if (substr($this->getOS(), 0, 3) == 'win') {
                $path .= '.exe';
            }
            if (is_file($path)) {
                $this->executablePaths[$exec] = $path;
            }
        }

        return $this;
    }

    /**
     * Sets the target directory where the files will be copied to.
     *
     * @param string $target
     *
     * @return $this
     */
    public function to($target)
    {
        $this->to = rtrim($target, '/');

        return $this;
    }

    /**
     * Sets the minifier.
     *
     * @param string $minifier
     * @param array  $options
     *
     * @return $this
     */
    public function minifier($minifier, array $options = [])
    {
        $this->minifier = $minifier;
        $this->minifierOptions = array_merge($this->minifierOptions, $options);

        return $this;
    }

    /**
     * @param string[] $dirs
     *
     * @return array|\Robo\Result
     *
     * @throws \Robo\Exception\TaskException
     */
    protected function findFiles($dirs)
    {
        $files = array();

        // find the files
        foreach ($dirs as $k => $v) {
            // reset finder
            $finder = new Finder();

            $dir = $k;
            $to = $v;
            // check if target was given with the to() method instead of key/value pairs
            if (is_int($k)) {
                $dir = $v;
                if (isset($this->to)) {
                    $to = $this->to;
                } else {
                    throw new TaskException($this, 'target directory is not defined');
                }
            }

            try {
                $finder->files()->in($dir);
            } catch (\InvalidArgumentException $e) {
                // if finder cannot handle it, try with in()->name()
                if (strpos($dir, '/') === false) {
                    $dir = './' . $dir;
                }
                $parts = explode('/', $dir);
                $new_dir = implode('/', array_slice($parts, 0, -1));
                try {
                    $finder->files()->in($new_dir)->name(array_pop($parts));
                } catch (\InvalidArgumentException $e) {
                    return Result::fromException($this, $e);
                }
            }

            foreach ($finder as $file) {
                // store the absolute path as key and target as value in the files array
                $files[$file->getRealpath()] = $this->getTarget($file->getRealPath(), $to);
            }
            $fileNoun = count($finder) == 1 ? ' file' : ' files';
            $this->printTaskInfo("Found {filecount} $fileNoun in {dir}", ['filecount' => count($finder), 'dir' => $dir]);
        }

        return $files;
    }

    /**
     * @param string $file
     * @param string $to
     *
     * @return string
     */
    protected function getTarget($file, $to)
    {
        $target = $to . '/' . basename($file);

        return $target;
    }

    /**
     * @param string[] $files
     *
     * @return \Robo\Result
     */
    protected function minify($files)
    {
        // store the individual results into the results array
        $this->results = [
            'success' => [],
            'error' => [],
        ];

        // loop through the files
        foreach ($files as $from => $to) {
            $minifier = '';

            if (!isset($this->minifier)) {
                // check filetype based on the extension
                $extension = strtolower(pathinfo($from, PATHINFO_EXTENSION));

                // set the default minifiers based on the extension
                switch ($extension) {
                    case 'png':
                        $minifier = 'optipng';
                        break;
                    case 'jpg':
                    case 'jpeg':
                        $minifier = 'jpegtran';
                        break;
                    case 'gif':
                        $minifier = 'gifsicle';
                        break;
                    case 'svg':
                        $minifier = 'svgo';
                        break;
                }
            } else {
                if (!in_array($this->minifier, $this->minifiers, true)
                    && !is_callable(strtr($this->minifier, '-', '_'))
                ) {
                    $message = sprintf('Invalid minifier %s!', $this->minifier);

                    return Result::error($this, $message);
                }
                $minifier = $this->minifier;
            }

            // Convert minifier name to camelCase (e.g. jpeg-recompress)
            $funcMinifier = $this->camelCase($minifier);

            // call the minifier method which prepares the command
            if (is_callable($funcMinifier)) {
                $command = call_user_func($funcMinifier, $from, $to, $this->minifierOptions);
            } elseif (method_exists($this, $funcMinifier)) {
                $command = $this->{$funcMinifier}($from, $to);
            } else {
                $message = sprintf('Minifier method <info>%s</info> cannot be found!', $funcMinifier);

                return Result::error($this, $message);
            }

            // launch the command
            $this->printTaskInfo('Minifying {filepath} with {minifier}', ['filepath' => $from, 'minifier' => $minifier]);
            $result = $this->executeCommand($command);

            // check the return code
            if ($result->getExitCode() == 127) {
                $this->printTaskError('The {minifier} executable cannot be found', ['minifier' => $minifier]);
                // try to install from imagemin repository
                if (array_key_exists($minifier, $this->imageminRepos)) {
                    $result = $this->installFromImagemin($minifier);
                    if ($result instanceof Result) {
                        if ($result->wasSuccessful()) {
                            $this->printTaskSuccess($result->getMessage());
                            // retry the conversion with the downloaded executable
                            if (is_callable($minifier)) {
                                $command = call_user_func($minifier, $from, $to, $this->minifierOptions);
                            } elseif (method_exists($this, $minifier)) {
                                $command = $this->{$minifier}($from, $to);
                            }
                            // launch the command
                            $this->printTaskInfo('Minifying {filepath} with {minifier}', ['filepath' => $from, 'minifier' => $minifier]);
                            $result = $this->executeCommand($command);
                        } else {
                            $this->printTaskError($result->getMessage());
                            // the download was not successful
                            return $result;
                        }
                    }
                } else {
                    return $result;
                }
            }

            // check the success of the conversion
            if ($result->getExitCode() !== 0) {
                $this->results['error'][] = $from;
            } else {
                $this->results['success'][] = $from;
            }
        }
    }

    /**
     * @return string
     */
    protected function getOS()
    {
        $os = php_uname('s');
        $os .= '/' . php_uname('m');
        // replace x86_64 to x64, because the imagemin repo uses that
        $os = str_replace('x86_64', 'x64', $os);
        // replace i386, i686, etc to x86, because of imagemin
        $os = preg_replace('/i[0-9]86/', 'x86', $os);
        // turn info to lowercase, because of imagemin
        $os = strtolower($os);

        return $os;
    }

    /**
     * @param string $command
     *
     * @return \Robo\Result
     */
    protected function executeCommand($command)
    {
        // insert the options into the command
        $a = explode(' ', $command);
        $executable = array_shift($a);
        foreach ($this->minifierOptions as $key => $value) {
            // first prepend the value
            if (!empty($value)) {
                array_unshift($a, $value);
            }
            // then add the key
            if (!is_numeric($key)) {
                array_unshift($a, $key);
            }
        }
        // prefer the downloaded executable if it exists already
        if (array_key_exists($executable, $this->executablePaths)) {
            $executable = $this->executablePaths[$executable];
        }
        array_unshift($a, $executable);
        $command = implode(' ', $a);

        // execute the command
        $exec = new Exec($command);

        return $exec->inflect($this)->printOutput(false)->run();
    }

    /**
     * @param string $executable
     *
     * @return \Robo\Result
     */
    protected function installFromImagemin($executable)
    {
        // check if there is an url defined for the executable
        if (!array_key_exists($executable, $this->imageminRepos)) {
            $message = sprintf('The executable %s cannot be found in the defined imagemin repositories', $executable);

            return Result::error($this, $message);
        }
        $this->printTaskInfo('Downloading the {executable} executable from the imagemin repository', ['executable' => $executable]);

        $os = $this->getOS();
        $url = $this->imageminRepos[$executable] . '/blob/main/vendor/' . $os . '/' . $executable . '?raw=true';
        if (substr($os, 0, 3) == 'win') {
            // if it is win, add a .exe extension
            $url = $this->imageminRepos[$executable] . '/blob/main/vendor/' . $os . '/' . $executable . '.exe?raw=true';
        }
        $data = @file_get_contents($url, false, null);
        if ($data === false) {
            // there is something wrong with the url, try it without the version info
            $url = preg_replace('/x[68][64]\//', '', $url);
            $data = @file_get_contents($url, false, null);
            if ($data === false) {
                // there is still something wrong with the url if it is win, try with win32
                if (substr($os, 0, 3) == 'win') {
                    $url = preg_replace('win/', 'win32/', $url);
                    $data = @file_get_contents($url, false, null);
                    if ($data === false) {
                        // there is nothing more we can do
                        $message = sprintf('Could not download the executable <info>%s</info>', $executable);

                        return Result::error($this, $message);
                    }
                }
                // if it is not windows there is nothing we can do
                $message = sprintf('Could not download the executable <info>%s</info>', $executable);

                return Result::error($this, $message);
            }
        }
        // check if target directory was set
        if (empty($this->executableTargetDir)) {
            return Result::error($this, 'No target directory for executables set');
        }
        // check if target directory exists
        if (!is_dir($this->executableTargetDir)) {
            // create and check access rights (directory created, but not readable)
            if (!mkdir($this->executableTargetDir) && !is_dir($this->executableTargetDir)) {
                $message = sprintf('Can not create target directory for executables in <info>%s</info>', $this->executableTargetDir);

                return Result::error($this, $message);
            }
        }
        // save the executable into the target dir
        $path = $this->executableTargetDir . '/' . $executable;
        if (substr($os, 0, 3) == 'win') {
            // if it is win, add a .exe extension
            $path = $this->executableTargetDir . '/' . $executable . '.exe';
        }
        $result = file_put_contents($path, $data);
        if ($result === false) {
            $message = sprintf('Could not copy the executable <info>%s</info> to %s', $executable, $path);

            return Result::error($this, $message);
        }
        // set the binary to executable
        chmod($path, 0755);

        // if everything successful, store the executable path
        $this->executablePaths[$executable] = $this->executableTargetDir . '/' . $executable;
        // if it is win, add a .exe extension
        if (substr($os, 0, 3) == 'win') {
            $this->executablePaths[$executable] .= '.exe';
        }

        $message = sprintf('Executable <info>%s</info> successfully downloaded', $executable);

        return Result::success($this, $message);
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function optipng($from, $to)
    {
        $command = sprintf('optipng -quiet -out "%s" -- "%s"', $to, $from);
        if ($from != $to && is_file($to)) {
            // earlier versions of optipng do not overwrite the target without a backup
            // https://sourceforge.net/p/optipng/bugs/37/
            unlink($to);
        }

        return $command;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function jpegtran($from, $to)
    {
        $command = sprintf('jpegtran -optimize -outfile "%s" "%s"', $to, $from);

        return $command;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function gifsicle($from, $to)
    {
        $command = sprintf('gifsicle -o "%s" "%s"', $to, $from);

        return $command;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function svgo($from, $to)
    {
        $command = sprintf('svgo "%s" "%s"', $from, $to);

        return $command;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function pngquant($from, $to)
    {
        $command = sprintf('pngquant --force --output "%s" "%s"', $to, $from);

        return $command;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function advpng($from, $to)
    {
        // advpng does not have any output parameters, copy the file and then compress the copy
        $command = sprintf('advpng --recompress --quiet "%s"', $to);
        $this->fs->copy($from, $to, true);

        return $command;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function pngout($from, $to)
    {
        $command = sprintf('pngout -y -q "%s" "%s"', $from, $to);

        return $command;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function zopflipng($from, $to)
    {
        $command = sprintf('zopflipng -y "%s" "%s"', $from, $to);

        return $command;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function pngcrush($from, $to)
    {
        $command = sprintf('pngcrush -q -ow "%s" "%s"', $from, $to);

        return $command;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function jpegoptim($from, $to)
    {
        // jpegoptim only takes the destination directory as an argument
        $command = sprintf('jpegoptim --quiet -o --dest "%s" "%s"', dirname($to), $from);

        return $command;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function jpegRecompress($from, $to)
    {
        $command = sprintf('jpeg-recompress --quiet "%s" "%s"', $from, $to);

        return $command;
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public static function camelCase($text)
    {
        // non-alpha and non-numeric characters become spaces
        $text = preg_replace('/[^a-z0-9]+/i', ' ', $text);
        $text = trim($text);
        // uppercase the first character of each word
        $text = ucwords($text);
        $text = str_replace(" ", "", $text);
        $text = lcfirst($text);

        return $text;
    }
}
