<?php
/**
 * JShrink
 *
 * Copyright (c) 2009-2012, Robert Hafner <tedivm@tedivm.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Robert Hafner nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    JShrink
 * @author     Robert Hafner <tedivm@tedivm.com>
 * @copyright  2009-2012 Robert Hafner <tedivm@tedivm.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       https://github.com/tedivm/JShrink
 * @version    Release: 0.4
 */

// Some changes done by Akshay Joshi to preserve compatibility with PHP 5.2.

/**
 * Minifier
 *
 * Usage - Minifier::minify($js);
 * Usage - Minifier::minify($js, $options);
 * Usage - Minifier::minify($js, array('flaggedComments' => false));
 *
 * @version 0.4
 * @package JShrink
 * @author  Robert Hafner <tedivm@tedivm.com>
 * @license http://www.opensource.org/licenses/bsd-license.php  BSD License
 */
class Minifier
{
    /**
     * The input javascript to be minified.
     *
     * @var string
     */
    protected $input;

    /**
     * The location of the character (in the input string) that is next to be processed.
     *
     * @var int
     */
    protected $index = 0;

    /**
     * The first of the characters currently being looked at.
     *
     * @var string
     */
    protected $a = '';


    /**
     * The next character being looked at (after a);
     *
     * @var string
     */
    protected $b = '';

    /**
     * This character is only active when certain look ahead actions take place.
     *
     *  @var string
     */
    protected $c;

    /**
     * Contains the options for the current minification process.
     *
     * @var array
     */
    protected $options;

    /**
     * Contains the default options for minification. This array is merged with the one passed in by the user to create
     * the request specific set of options (stored in the $options attribute).
     *
     * @var array
     */
    protected static $defaultOptions = array('flaggedComments' => true);

    /**
     * Contains a copy of the JShrink object used to run minification. This is only used internally, and is only stored
     * for performance reasons. There is no internal data shared between minification requests.
     */
    protected static $jshrink;

    /**
     * Minifier::minify takes a string containing javascript and removes unneeded characters in order to shrink the code
     * without altering it's functionality.
     */
    public static function minify($js, $options = array())
    {
        global $sugar_config;

        if (isset($sugar_config['developer_mode_disable_minifier']) && $sugar_config['developer_mode_disable_minifier'] === true) {
            return $js;
        }

        try {
            ob_start();
            $currentOptions = array_merge(self::$defaultOptions, $options);

            if (!isset(self::$jshrink)) {
                self::$jshrink = new Minifier();
            }

            self::$jshrink->breakdownScript($js, $currentOptions);
            return ob_get_clean();
        } catch (Exception $e) {
            if (isset(self::$jshrink)) {
                self::$jshrink->clean();
            }

            ob_end_clean();
            throw $e;
        }
    }

    /**
     * Processes a javascript string and outputs only the required characters, stripping out all unneeded characters.
     *
     * @param string $js The raw javascript to be minified
     * @param array $currentOptions Various runtime options in an associative array
     */
    protected function breakdownScript($js, $currentOptions)
    {
        // reset work attributes in case this isn't the first run.
        $this->clean();

        $this->options = $currentOptions;

        $js = str_replace("\r\n", "\n", $js);
        $this->input = str_replace("\r", "\n", $js);
        $this->input = preg_replace('/\h/u', ' ', $this->input);


        $this->a = $this->getReal();

        // the only time the length can be higher than 1 is if a conditional comment needs to be displayed
        // and the only time that can happen for $a is on the very first run
        while (strlen($this->a) > 1) {
            echo $this->a;
            $this->a = $this->getReal();
        }

        $this->b = $this->getReal();

        while ($this->a !== false && !is_null($this->a) && $this->a !== '') {

            // now we give $b the same check for conditional comments we gave $a before we began looping
            if (strlen($this->b) > 1) {
                echo $this->a . $this->b;
                $this->a = $this->getReal();
                $this->b = $this->getReal();
                continue;
            }

            switch ($this->a) {
                // new lines
                case "\n":
                    // if the next line is something that can't stand alone preserve the newline
                    if ($this->b != '' && strpos('(-+{[@', $this->b) !== false) {
                        echo $this->a;
                        $this->saveString();
                        break;
                    }

                    // if its a space we move down to the string test below
                    if ($this->b === ' ') {
                        break;
                    }

                    // otherwise we treat the newline like a space

                    // no break
                case ' ':
                    if (self::isAlphaNumeric($this->b)) {
                        echo $this->a;
                    }

                    $this->saveString();
                    break;

                default:
                    switch ($this->b) {
                        case "\n":
                            if (strpos('}])+-"\'', $this->a) !== false) {
                                echo $this->a;
                                $this->saveString();
                                break;
                            } else {
                                if (self::isAlphaNumeric($this->a)) {
                                    echo $this->a;
                                    $this->saveString();
                                }
                            }
                            break;

                        case ' ':
                            if (!self::isAlphaNumeric($this->a)) {
                                break;
                            }

                            // no break
                        default:
                            // check for some regex that breaks stuff
                            if ($this->a == '/' && ($this->b == '\'' || $this->b == '"')) {
                                $this->saveRegex();
                                continue;
                            }

                            echo $this->a;
                            $this->saveString();
                            break;
                    }
            }

            // do reg check of doom
            $this->b = $this->getReal();

            if (($this->b == '/' && strpos('(,=:[!&|?', $this->a) !== false)) {
                $this->saveRegex();
            }
        }
        $this->clean();
    }

    /**
     * Returns the next string for processing based off of the current index.
     *
     * @return string
     */
    protected function getChar()
    {
        if (isset($this->c)) {
            $char = $this->c;
            unset($this->c);
        } else {
            $tchar = substr($this->input, $this->index, 1);
            if (isset($tchar) && $tchar !== false) {
                $char = $tchar;
                $this->index++;
            } else {
                return false;
            }
        }

        if ($char !== "\n" && ord($char) < 32) {
            return ' ';
        }

        return $char;
    }

    /**
     * This function gets the next "real" character. It is essentially a wrapper around the getChar function that skips
     * comments. This has signifigant peformance benefits as the skipping is done using native functions (ie, c code)
     * rather than in script php.
     *
     * @return string Next 'real' character to be processed.
     */
    protected function getReal()
    {
        $startIndex = $this->index;
        $char = $this->getChar();

        if ($char == '/') {
            $this->c = $this->getChar();

            if ($this->c == '/') {
                $thirdCommentString = substr($this->input, $this->index, 1);

                // kill rest of line
                $char = $this->getNext("\n");

                if ($thirdCommentString == '@') {
                    $endPoint = ($this->index) - $startIndex;
                    unset($this->c);
                    $char = "\n" . substr($this->input, $startIndex, $endPoint);// . "\n";
                } else {
                    $char = $this->getChar();
                    $char = $this->getChar();
                }
            } elseif ($this->c == '*') {
                $this->getChar(); // current C
                $thirdCommentString = $this->getChar();

                if ($thirdCommentString == '@') {
                    // conditional comment

                    // we're gonna back up a bit and and send the comment back, where the first
                    // char will be echoed and the rest will be treated like a string
                    $this->index = $this->index-2;
                    return '/';
                } elseif ($this->getNext('*/')) {
                    // kill everything up to the next */

                    $this->getChar(); // get *
                    $this->getChar(); // get /

                    $char = $this->getChar(); // get next real character

                    // if YUI-style comments are enabled we reinsert it into the stream
                    if ($this->options['flaggedComments'] && $thirdCommentString == '!') {
                        $endPoint = ($this->index - 1) - $startIndex;
                        echo "\n" . substr($this->input, $startIndex, $endPoint) . "\n";
                    }
                } else {
                    $char = false;
                }

                if ($char === false) {
                    throw new RuntimeException('Stray comment. ' . $this->index);
                }

                // if we're here c is part of the comment and therefore tossed
                if (isset($this->c)) {
                    unset($this->c);
                }
            }
        }
        return $char;
    }

    /**
     * Pushes the index ahead to the next instance of the supplied string. If it is found the first character of the
     * string is returned.
     *
     * @return string|false Returns the first character of the string if found, false otherwise.
     */
    protected function getNext($string)
    {
        $pos = strpos($this->input, $string, $this->index);

        if ($pos === false) {
            return false;
        }

        $this->index = $pos;
        return substr($this->input, $this->index, 1);
    }

    /**
     * When a javascript string is detected this function crawls for the end of it and saves the whole string.
     *
     */
    protected function saveString()
    {
        $this->a = $this->b;
        if ($this->a == "'" || $this->a == '"') { // is the character a quote
            // save literal string
            $stringType = $this->a;

            while (1) {
                echo $this->a;
                $this->a = $this->getChar();

                switch ($this->a) {
                    case $stringType:
                        break 2;

                    case "\n":
                        throw new RuntimeException('Unclosed string. ' . $this->index);
                        break;

                    case '\\':
                        echo $this->a;
                        $this->a = $this->getChar();
                }
            }
        }
    }

    /**
     * When a regular expression is detected this funcion crawls for the end of it and saves the whole regex.
     */
    protected function saveRegex()
    {
        echo $this->a . $this->b;

        while (($this->a = $this->getChar()) !== false) {
            if ($this->a == '/') {
                break;
            }

            if ($this->a == '\\') {
                echo $this->a;
                $this->a = $this->getChar();
            }

            if ($this->a == "\n") {
                throw new RuntimeException('Stray regex pattern. ' . $this->index);
            }

            echo $this->a;
        }
        $this->b = $this->getReal();
    }

    /**
     * Resets attributes that do not need to be stored between requests so that the next request is ready to go.
     */
    protected function clean()
    {
        unset($this->input);
        $this->index = 0;
        $this->a = $this->b = '';
        unset($this->c);
        unset($this->options);
    }

    /**
     * Checks to see if a character is alphanumeric.
     *
     * @return bool
     */
    protected static function isAlphaNumeric($char)
    {
        return preg_match('/^[\w\$]$/', $char) === 1 || $char == '/';
    }
}
