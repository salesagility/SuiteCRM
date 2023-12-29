<?php
// Copyright 2004-present Facebook. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace Facebook\WebDriver\Firefox;

use Facebook\WebDriver\Exception\WebDriverException;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class FirefoxProfile
{
    /**
     * @var array
     */
    private $preferences = [];
    /**
     * @var array
     */
    private $extensions = [];
    /**
     * @var array
     */
    private $extensions_datas = [];
    /**
     * @var string
     */
    private $rdf_file;

    /**
     * @param string $extension The path to the xpi extension.
     * @return FirefoxProfile
     */
    public function addExtension($extension)
    {
        $this->extensions[] = $extension;

        return $this;
    }

    /**
     * @param string $extension_datas The path to the folder containing the datas to add to the extension
     * @return FirefoxProfile
     */
    public function addExtensionDatas($extension_datas)
    {
        if (!is_dir($extension_datas)) {
            return null;
        }

        $this->extensions_datas[basename($extension_datas)] = $extension_datas;

        return $this;
    }

    /**
     * @param string $rdf_file The path to the rdf file
     * @return FirefoxProfile
     */
    public function setRdfFile($rdf_file)
    {
        if (!is_file($rdf_file)) {
            return null;
        }

        $this->rdf_file = $rdf_file;

        return $this;
    }

    /**
     * @param string $key
     * @param string|bool|int $value
     * @throws WebDriverException
     * @return FirefoxProfile
     */
    public function setPreference($key, $value)
    {
        if (is_string($value)) {
            $value = sprintf('"%s"', $value);
        } else {
            if (is_int($value)) {
                $value = sprintf('%d', $value);
            } else {
                if (is_bool($value)) {
                    $value = $value ? 'true' : 'false';
                } else {
                    throw new WebDriverException(
                        'The value of the preference should be either a string, int or bool.'
                    );
                }
            }
        }
        $this->preferences[$key] = $value;

        return $this;
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function getPreference($key)
    {
        if (array_key_exists($key, $this->preferences)) {
            return $this->preferences[$key];
        }

        return null;
    }

    /**
     * @return string
     */
    public function encode()
    {
        $temp_dir = $this->createTempDirectory('WebDriverFirefoxProfile');

        if (isset($this->rdf_file)) {
            copy($this->rdf_file, $temp_dir . DIRECTORY_SEPARATOR . 'mimeTypes.rdf');
        }

        foreach ($this->extensions as $extension) {
            $this->installExtension($extension, $temp_dir);
        }

        foreach ($this->extensions_datas as $dirname => $extension_datas) {
            mkdir($temp_dir . DIRECTORY_SEPARATOR . $dirname);
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($extension_datas, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($iterator as $item) {
                $target_dir = $temp_dir . DIRECTORY_SEPARATOR . $dirname . DIRECTORY_SEPARATOR
                    . $iterator->getSubPathName();

                if ($item->isDir()) {
                    mkdir($target_dir);
                } else {
                    copy($item, $target_dir);
                }
            }
        }

        $content = '';
        foreach ($this->preferences as $key => $value) {
            $content .= sprintf("user_pref(\"%s\", %s);\n", $key, $value);
        }
        file_put_contents($temp_dir . '/user.js', $content);

        $zip = new ZipArchive();
        $temp_zip = tempnam(sys_get_temp_dir(), 'WebDriverFirefoxProfileZip');
        $zip->open($temp_zip, ZipArchive::CREATE);

        $dir = new RecursiveDirectoryIterator($temp_dir);
        $files = new RecursiveIteratorIterator($dir);

        $dir_prefix = preg_replace(
            '#\\\\#',
            '\\\\\\\\',
            $temp_dir . DIRECTORY_SEPARATOR
        );

        foreach ($files as $name => $object) {
            if (is_dir($name)) {
                continue;
            }

            $path = preg_replace("#^{$dir_prefix}#", '', $name);
            $zip->addFile($name, $path);
        }
        $zip->close();

        $profile = base64_encode(file_get_contents($temp_zip));

        // clean up
        $this->deleteDirectory($temp_dir);
        unlink($temp_zip);

        return $profile;
    }

    /**
     * @param string $extension The path to the extension.
     * @param string $profile_dir The path to the profile directory.
     * @return string The path to the directory of this extension.
     */
    private function installExtension($extension, $profile_dir)
    {
        $temp_dir = $this->createTempDirectory('WebDriverFirefoxProfileExtension');
        $this->extractTo($extension, $temp_dir);

        // This is a hacky way to parse the id since there is no offical RDF parser library.
        // Find the correct namespace for the id element.
        $install_rdf_path = $temp_dir . '/install.rdf';
        $xml = simplexml_load_file($install_rdf_path);
        $ns = $xml->getDocNamespaces();
        $prefix = '';
        if (!empty($ns)) {
            foreach ($ns as $key => $value) {
                if (mb_strpos($value, '//www.mozilla.org/2004/em-rdf') > 0) {
                    if ($key != '') {
                        $prefix = $key . ':'; // Separate the namespace from the name.
                    }
                    break;
                }
            }
        }
        // Get the extension id from the install manifest.
        $matches = [];
        preg_match('#<' . $prefix . 'id>([^<]+)</' . $prefix . 'id>#', $xml->asXML(), $matches);
        if (isset($matches[1])) {
            $ext_dir = $profile_dir . '/extensions/' . $matches[1];
            mkdir($ext_dir, 0777, true);
            $this->extractTo($extension, $ext_dir);
        } else {
            $this->deleteDirectory($temp_dir);

            throw new WebDriverException('Cannot get the extension id from the install manifest.');
        }

        $this->deleteDirectory($temp_dir);

        return $ext_dir;
    }

    /**
     * @param string $prefix Prefix of the temp directory.
     *
     * @throws WebDriverException
     * @return string The path to the temp directory created.
     */
    private function createTempDirectory($prefix = '')
    {
        $temp_dir = tempnam(sys_get_temp_dir(), $prefix);
        if (file_exists($temp_dir)) {
            unlink($temp_dir);
            mkdir($temp_dir);
            if (!is_dir($temp_dir)) {
                throw new WebDriverException('Cannot create firefox profile.');
            }
        }

        return $temp_dir;
    }

    /**
     * @param string $directory The path to the directory.
     */
    private function deleteDirectory($directory)
    {
        $dir = new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS);
        $paths = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($paths as $path) {
            if ($path->isDir() && !$path->isLink()) {
                rmdir($path->getPathname());
            } else {
                unlink($path->getPathname());
            }
        }

        rmdir($directory);
    }

    /**
     * @param string $xpi The path to the .xpi extension.
     * @param string $target_dir The path to the unzip directory.
     *
     * @throws \Exception
     * @return FirefoxProfile
     */
    private function extractTo($xpi, $target_dir)
    {
        $zip = new ZipArchive();
        if (file_exists($xpi)) {
            if ($zip->open($xpi)) {
                $zip->extractTo($target_dir);
                $zip->close();
            } else {
                throw new \Exception("Failed to open the firefox extension. '$xpi'");
            }
        } else {
            throw new \Exception("Firefox extension doesn't exist. '$xpi'");
        }

        return $this;
    }
}
