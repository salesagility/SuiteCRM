<?php

class SugarMin {

    /**
     * jsParser will take javascript source code and minify it.
     *
     * Note: There is a lot of redundant code since both passes
     * operate similarly but with slight differences. It will probably
     * be a good idea to refactor the code at a later point when it is stable.
     *
     * JSParser will perform 3 passes on the code. Pass 1 takes care of single
     * line and mult-line comments. Pass 2 performs some sanitation on each of the lines
     * and pass 3 works on stripping out unnecessary spaces.
     *
     * @param string $js
     * @param string $currentOptions
     * @return void
     */
    private function __construct($text, $compression) {
        $this->text = trim($text)."\n";
        $this->compression = $compression;
    }

    /**
     * Entry point function to minify javascript.
     *
     * @param string $js Javascript source code as a string.
     * @param string $compression Compression option. {light, deep}.
     * @return string $output Output javascript code as a string.
     */
    static public function minify($js, $compression = 'light') {
        try {
            $me = new SugarMin($js, $compression);
            $output = $me->jsParser();

            return $output;
        } catch (Exception $e) {
            // Exception handling is left up to the implementer.
            throw $e;
        }
    }

    protected function jsParser() {
        require_once('jssource/Minifier.php');
        return Minifier::minify($this->text);
	}

    /**
     * Join and minify JS files
     *
     * @param array $jsFiles an 'array' of js files
     *
     * @author Jose C. Massón <jose@gcoop.coop>
     *
     * @return Minified JS file path
     */
    static public function joinAndMinifyJSFiles($jsFiles)
    {
        $target = SugarThemeRegistry::current()->getJSPath()
                . '/' .
                sha1(implode('|', $jsFiles)) . '.js';
        $ret = sugar_cached($target);

        if (!is_file($ret)) {
            $customJSContents = '';

            foreach ($jsFiles as $jsFileName) {
                $jsFileContents = '';
                $jsFileContent = '';

                if (is_file($jsFileName)) {
                    $jsFileContent = sugar_file_get_contents($jsFileName);

                    if ($jsFileContent === false) {
                        LoggerManager::getLogger()->warn(
                            "joinAndMinifyJSFiles - There was an error opening ". 
                            "the file: {$jsFileName}"
                        );
                    } else if (strlen($jsFileContent) === 0) {
                        LoggerManager::getLogger()->warn(
                            "joinAndMinifyJSFiles - The content of JS is empty: " .
                            "{$jsFileName}"
                        );
                    } else {
                        $jsFileContents .= $jsFileContent;
                    }
                } else {
                    LoggerManager::getLogger()->warn(
                        "joinAndMinifyJSFiles - {$jsFileName} is not a file."
                    );
                }
                $customJSContents .= $jsFileContents;
            }

            $customJSPath = create_cache_directory($target);

            if ((!inDeveloperMode()) && (!is_file($customJSPath))) {
                $customJSContents = SugarMin::minify($customJSContents);
            }

            $sfpc = sugar_file_put_contents($customJSPath, $customJSContents);

            if ($sfpc === 0) {
                LoggerManager::getLogger()->warn(
                    "joinAndMinifyJSFiles - The".
                    " content of all files is empty."
                );
            } else if ($sfpc === false) {
                LoggerManager::getLogger()->error(
                    "joinAndMinifyJSFiles - There was an error writing the file".
                    " {$customJSPath}"
                );
                return false;
            }
        }

        return getJSPath($ret);
    }
}
