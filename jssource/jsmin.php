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
    function joinAndMinifyJSFiles($jsFiles)
    {
        $target = SugarThemeRegistry::current()->getJSPath()
                . '/' .
                sha1(implode('|', $jsFiles)) . '.js';

        if (!is_file(sugar_cached($target))) {
            $customJSContents = '';

            foreach ($jsFiles as $jsFileName) {
                $jsFileContents = '';

                if (is_file($jsFileName)) {
                    $jsFileContents .= sugar_file_get_contents($jsFileName);
                }

                if (empty($jsFileContents)) {
                    LoggerManager::getLogger()->warn(
                        translate('ERR_FILE_EMPTY') .': '. "{$jsFileName}"
                    );
                }
                $customJSContents .= $jsFileContents;
            }

            $customJSPath = create_cache_directory($target);

            if ((!inDeveloperMode()) && (!is_file($customJSPath))) {
                $customJSContents = SugarMin::minify($customJSContents);
            }

            sugar_file_put_contents($customJSPath, $customJSContents);
        }

        $customJSURL = sugar_cached($target);
        return getJSPath($customJSURL);
    }
}
