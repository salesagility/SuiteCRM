<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2017, Hoa community. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Hoa\Console;

use Hoa\Ustring;

/**
 * Class \Hoa\Console\GetOption.
 *
 * This class is complementary to the \Hoa\Console\Parser class.
 * This class manages the options profile for a command, i.e. argument,
 * interactivity, option name etc.
 * And, of course, it proposes the getOption method, that allow user to loop
 * easily the command options/arguments.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class GetOption
{
    /**
     * Argument: no argument is needed.
     *
     * @const int
     */
    const NO_ARGUMENT        = 0;

    /**
     * Argument: required.
     *
     * @const int
     */
    const REQUIRED_ARGUMENT  = 1;

    /**
     * Argument: optional.
     *
     * @const int
     */
    const OPTIONAL_ARGUMENT  = 2;

    /**
     * Option bucket: name.
     *
     * @const int
     */
    const OPTION_NAME        = 0;

    /**
     * Option bucket: has argument.
     *
     * @const int
     */
    const OPTION_HAS_ARG     = 1;

    /**
     * Option bucket: value.
     *
     * @const int
     */
    const OPTION_VAL         = 2;

    /**
     * Describe the command options (or switches).
     * An option is describing like this:
     *     name, has_arg, val
     * (In C, we got the flag data before val, but it does not have sens here).
     *
     * The name is the option name and the long option value.
     * The has_arg is a constant: NO_ARGUMENT, REQUIRED_ARGUMENT, and
     * OPTIONAL_ARGUMENT.
     * The val is the short option value.
     *
     * @var array
     */
    protected $_options       = [];

    /**
     * Parser.
     *
     * @var \Hoa\Console\Parser
     */
    protected $_parser        = null;

    /**
     * The pipette contains all the short value of options.
     *
     * @var array
     */
    protected $_pipette       = [];



    /**
     * Prepare the pipette.
     *
     * @param   array                $options    The option definition.
     * @param   \Hoa\Console\Parser  $parser     The parser.
     * @throws  \Hoa\Console\Exception
     */
    public function __construct(array $options, Parser $parser)
    {
        $this->_options = $options;
        $this->_parser  = $parser;

        if (empty($options)) {
            $this->_pipette[null] = null;

            return;
        }

        $names  = [];

        foreach ($options as $i => $option) {
            if (isset($option[self::OPTION_NAME])) {
                $names[$option[self::OPTION_NAME]] = $i;
            }

            if (isset($option[self::OPTION_VAL])) {
                $names[$option[self::OPTION_VAL]]  = $i;
            }
        }

        $_names   = array_keys($names);
        $switches = $parser->getSwitches();

        foreach ($switches as $name => $value) {
            if (false === in_array($name, $_names)) {
                if (1 === strlen($name)) {
                    $this->_pipette[] = ['__ambiguous', [
                        'solutions' => [],
                        'value'     => $value,
                        'option'    => $name
                    ]];

                    continue;
                }

                $haystack    = implode(';', $_names);
                $differences = (int) ceil(strlen($name) / 3);
                $searched    = Ustring\Search::approximated(
                    $haystack,
                    $name,
                    $differences
                );
                $solutions   = [];

                foreach ($searched as $s) {
                    $h = substr($haystack, $s['i'], $s['l']);

                    if (false !== strpos($h, ';') ||
                        false !== in_array($h, array_keys($switches)) ||
                        false === in_array($h, $_names)) {
                        continue;
                    }

                    $solutions[] = $h;
                }

                if (empty($solutions)) {
                    continue;
                }

                $this->_pipette[] = ['__ambiguous', [
                    'solutions' => $solutions,
                    'value'     => $value,
                    'option'    => $name
                ]];

                continue;
            }

            $option   = $options[$names[$name]];
            $argument = $option[self::OPTION_HAS_ARG];

            if (self::NO_ARGUMENT === $argument) {
                if (!is_bool($value)) {
                    $parser->transferSwitchToInput($name, $value);
                }
            } elseif (self::REQUIRED_ARGUMENT === $argument && !is_string($value)) {
                throw new Exception(
                    'The argument %s requires a value (it is not a switch).',
                    0,
                    $name
                );
            }

            $this->_pipette[] = [$option[self::OPTION_VAL], $value];
        }

        $this->_pipette[null] = null;
        reset($this->_pipette);

        return;
    }

    /**
     * Get option from the pipette.
     *
     * @param   string  &$optionValue    Place a variable that will receive the
     *                                   value of the current option.
     * @param   string  $short           Short options to scan (in a single
     *                                   string). If $short = null, all short
     *                                   options will be selected.
     * @return  mixed
     */
    public function getOption(&$optionValue, $short = null)
    {
        static $first = true;

        $optionValue = null;

        if (true === $this->isPipetteEmpty() && true === $first) {
            $first = false;

            return false;
        }

        $k     = key($this->_pipette);
        $c     = current($this->_pipette);
        $key   = $c[0];
        $value = $c[1];

        if (null == $k && null === $c) {
            reset($this->_pipette);
            $first = true;

            return false;
        }

        $allow = [];

        if (null === $short) {
            foreach ($this->_options as $option) {
                $allow[] = $option[self::OPTION_VAL];
            }
        } else {
            $allow = str_split($short);
        }

        if (!in_array($key, $allow) && '__ambiguous' != $key) {
            return false;
        }

        $optionValue = $value;
        $return      = $key;
        next($this->_pipette);

        return $return;
    }

    /**
     * Check if the pipette is empty.
     *
     * @return  bool
     */
    public function isPipetteEmpty()
    {
        return count($this->_pipette) == 1;
    }

    /**
     * Resolve option ambiguity. Please see the special pipette entry
     * “ambiguous” in the self::__construct method.
     * For a smarter resolving, you could use the console kit (please, see
     * Hoa\Console\Dispatcher\Kit).
     *
     * @param   array  $solutions    Solutions.
     * @return  void
     * @throws  \Hoa\Console\Exception
     */
    public function resolveOptionAmbiguity(array $solutions)
    {
        if (!isset($solutions['solutions']) ||
            !isset($solutions['value']) ||
            !isset($solutions['option'])) {
            throw new Exception(
                'Cannot resolve option ambiguity because the given solution ' .
                'seems to be corruped.',
                1
            );
        }

        $choices = $solutions['solutions'];

        if (1 > count($choices)) {
            throw new Exception(
                'Cannot resolve ambiguity, fix your typo in the option %s :-).',
                2,
                $solutions['option']
            );
        }

        $theSolution = $choices[0];

        foreach ($this->_options as $option) {
            if ($theSolution == $option[self::OPTION_NAME] ||
                $theSolution == $option[self::OPTION_VAL]) {
                $argument = $option[self::OPTION_HAS_ARG];
                $value    = $solutions['value'];

                if (self::NO_ARGUMENT === $argument) {
                    if (!is_bool($value)) {
                        $this->_parser->transferSwitchToInput($theSolution, $value);
                    }
                } elseif (self::REQUIRED_ARGUMENT === $argument &&
                          !is_string($value)) {
                    throw new Exception(
                        'The argument %s requires a value (it is not a switch).',
                        3,
                        $theSolution
                    );
                }

                unset($this->_pipette[null]);
                $this->_pipette[]     = [$option[self::OPTION_VAL], $value];
                $this->_pipette[null] = null;

                return;
            }
        }

        return;
    }
}
