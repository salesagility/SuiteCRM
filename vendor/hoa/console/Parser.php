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

/**
 * Class \Hoa\Console\Parser.
 *
 * This class parses a command line.
 * See the parse() method to get more informations about command-line
 * vocabulary, patterns, limitations, etc.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Parser
{
    /**
     * If long value is not enabled, -abc is equivalent to -a -b -c, else -abc
     * is equivalent to --abc.
     *
     * @var \Hoa\Console\Parser
     */
    protected $_longonly = false;

    /**
     * The parsed result in three categories : command, input, and switch.
     *
     * @var array
     */
    protected $_parsed   = null;



    /**
     * Parse a command.
     * Some explanations :
     * 1. Command :
     *   $ cmd         is the command : cmd ;
     *   $ "cmd sub"   is the command : cmd sub ;
     *   $ cmd\ sub    is the command : cmd sub.
     *
     * 2. Short option :
     *   $ … -s        is a short option ;
     *   $ … -abc      is equivalent to -a -b -c if and only if $longonly is set
     *                 to false, else (set to true) -abc is equivalent to --abc.
     *
     * 3. Long option :
     *   $ … --long    is a long option ;
     *   $ … --lo-ng   is a long option.
     *   $ etc.
     *
     * 4. Boolean switch or flag :
     *   $ … -s        is a boolean switch, -s is set to true ;
     *   $ … --long    is a boolean switch, --long is set to true ;
     *   $ … -s -s and --long --long
     *                 are boolean switches, -s and --long are set to false ;
     *   $ … -aa       are boolean switches, -a is set to false, if and only if
     *                 the $longonly is set to false, else --aa is set to true.
     *
     * 5. Valued switch :
     *   x should be s, -long, abc etc.
     *   All the following examples are valued switches, where -x is set to the
     *   specified value.
     *   $ … -x=value      : value ;
     *   $ … -x=va\ lue    : va lue ;
     *   $ … -x="va lue"   : va lue ;
     *   $ … -x="va l\"ue" : va l"ue ;
     *   $ … -x value      : value ;
     *   $ … -x va\ lue    : va lue ;
     *   $ … -x "value"    : value ;
     *   $ … -x "va lue"   : va lue ;
     *   $ … -x va\ l"ue   : va l"ue ;
     *   $ … -x 'va "l"ue' : va "l"ue ;
     *   $ etc. (we did not written all cases, but the philosophy is here).
     *   Two type of quotes are supported : double quotes ("), and simple
     *   quotes (').
     *   We got very particulary cases :
     *   $ … -x=-value     : -value ;
     *   $ … -x "-value"   : -value ;
     *   $ … -x \-value    : -value ;
     *   $ … -x -value     : two switches, -x and -value are set to true ;
     *   $ … -x=-7         : -7, a negative number.
     *   And if we have more than one valued switch, the value is overwritted :
     *   $ … -x a -x b     : b.
     *   Maybe, it should produce an array, like the special valued switch (see
     *   the point 6. please).
     *
     * 6. Special valued switch :
     *   Some valued switch can have a list, or an interval in value ;
     *   e.g. -x=a,b,c, or -x=1:7 etc.
     *   This class gives the value as it is, i.e. no manipulation or treatment
     *   is made.
     *   $ … -x=a,b,c      : a,b,c (and no array('a', 'b', 'c')) ;
     *   $ etc.
     *   These manipulations should be made by the user no ? The
     *   self::parseSpecialValue() is written for that.
     *
     * 7. Input :
     *   The regular expression sets a value as much as possible to each
     *   switch (option). If a switch does not take a value (see the
     *   \Hoa\Console\GetOption::NO_ARGUMENT constant), the value will be
     *   transfered to the input stack. But this action is not made in this
     *   class, only in the \Hoa\Console\GetOption class, because this class
     *   does not have the options profile. We got the transferSwitchToInput()
     *   method, that is called in the GetOption class.
     *   So :
     *   $ cmd -x input           the input is the -x value ;
     *   $ cmd -x -- input        the input is a real input, not a value ;
     *   $ cmd -x value input     -x is set to value, and the input is a real
     *                            input ;
     *   $ cmd -x value -- input  equivalent to -x value input ;
     *   $ … -a b i -c d ii       -a is set to b, -c to d, and we got two
     *                            inputs : i and ii.
     *
     * Warning : if the command was reconstitued from the $_SERVER variable, all
     * these cases are not sure to work, because the command was already
     * interpreted/parsed by an other parser (Shell, DOS etc.), and maybe they
     * remove some character, or some particular case. But if we give the
     * command manually — i.e. without any reconstitution —, all these cases
     * will work :).
     *
     * @param   string  $command    Command to parse.
     * @return  void
     */
    public function parse($command)
    {
        unset($this->_parsed);
        $this->_parsed = [
            'input'  => [],
            'switch' => []
        ];

        /**
         * Here we go …
         *
         *     #
         *     (?:
         *         (?<b>--?[^=\s]+)
         *         (?:
         *             (?:(=)|(\s))
         *             (?<!\\\)(?:("|\')|)
         *             (?<s>(?(3)[^-]|).*?)
         *             (?(4)
         *                 (?<!\\\)\4
         *                 |
         *                 (?(2)
         *                     (?<!\\\)\s
         *                     |
         *                     (?:(?:(?<!\\\)\s)|$)
         *                 )
         *             )
         *         )?
         *     )
         *     |
         *     (?:
         *         (?<!\\\)(?:("|\')|)
         *         (?<i>.*?)
         *         (?(6)
         *             (?<!\\\)\6
         *             |
         *             (?:(?:(?<!\\\)\s)|$)
         *         )
         *     )
         *     #xSsm
         *
         * Nice isn't it :-D ?
         *
         * Note : this regular expression likes to capture empty array (near
         * <i>), why?
         */

        $regex = '#(?:(?<b>--?[^=\s]+)(?:(?:(=)|(\s))(?<!\\\)(?:("|\')|)(?<s>(?(3)[^-]|).*?)(?(4)(?<!\\\)\4|(?(2)(?<!\\\)\s|(?:(?:(?<!\\\)\s)|$))))?)|(?:(?<!\\\)(?:("|\')|)(?<i>.*?)(?(6)(?<!\\\)\6|(?:(?:(?<!\\\)\s)|$)))#Ssm';

        preg_match_all($regex, $command, $matches, PREG_SET_ORDER);

        for ($i = 0, $max = count($matches); $i < $max; ++$i) {
            $match = $matches[$i];

            if (isset($match['i']) &&
                ('0' === $match['i'] || !empty($match['i']))) {
                $this->addInput($match);
            } elseif (!isset($match['i']) && !isset($match['s'])) {
                if (isset($matches[$i + 1])) {
                    $nextMatch = $matches[$i + 1];

                    if (!empty($nextMatch['i']) &&
                        '=' === $nextMatch['i'][0]) {
                        ++$i;
                        $match[2]   = '=';
                        $match[3]   =
                        $match[4]   = null;
                        $match['s'] =
                        $match[5]   = substr($nextMatch[7], 1);

                        $this->addValuedSwitch($match);

                        continue;
                    }
                }

                $this->addBoolSwitch($match);
            } elseif (!isset($match['i']) && isset($match['s'])) {
                $this->addValuedSwitch($match);
            }
        }

        return;
    }

    /**
     * Add an input.
     *
     * @param   array  $input    Intput.
     * @return  void
     */
    protected function addInput(array $input)
    {
        $handle = $input['i'];

        if (!empty($input[6])) {
            $handle = str_replace('\\' . $input[6], $input[6], $handle);
        } else {
            $handle = str_replace('\\ ', ' ', $handle);
        }

        $this->_parsed['input'][] = $handle;

        return;
    }

    /**
     * Add a boolean switch.
     *
     * @param   array  $switch    Switch.
     * @return  void
     */
    protected function addBoolSwitch(array $switch)
    {
        $this->addSwitch($switch['b'], true);

        return;
    }

    /**
     * Add a valued switch.
     *
     * @param   array  $switch    Switch.
     * @return  void
     */
    protected function addValuedSwitch(array $switch)
    {
        $this->addSwitch($switch['b'], $switch['s'], $switch[4]);

        return;
    }

    /**
     * Add a switch.
     *
     * @param   string  $name      Switch name.
     * @param   string  $value     Switch value.
     * @param   string  $escape    Character to escape.
     * @return  void
     */
    protected function addSwitch($name, $value, $escape = null)
    {
        if (substr($name, 0, 2) == '--') {
            return $this->addSwitch(substr($name, 2), $value, $escape);
        }

        if (substr($name, 0, 1) == '-') {
            if (true === $this->getLongOnly()) {
                return $this->addSwitch('-' . $name, $value, $escape);
            }

            foreach (str_split(substr($name, 1)) as $foo => $switch) {
                $this->addSwitch($switch, $value, $escape);
            }

            return;
        }

        if (null !== $escape) {
            $escape = '' == $escape ? ' ' : $escape;

            if (is_string($value)) {
                $value = str_replace('\\' . $escape, $escape, $value);
            }
        } elseif (is_string($value)) {
            $value = str_replace('\\ ', ' ', $value);
        }

        if (isset($this->_parsed['switch'][$name])) {
            if (is_bool($this->_parsed['switch'][$name])) {
                $value = !$this->_parsed['switch'][$name];
            } else {
                $value = [$this->_parsed['switch'][$name], $value];
            }
        }

        if (empty($name)) {
            return $this->addInput([6 => null, 'i' => $value]);
        }

        $this->_parsed['switch'][$name] = $value;

        return;
    }

    /**
     * Transfer a switch value in the input stack.
     *
     * @param   string  $name     The switch name.
     * @param   string  $value    The switch value.
     * @return  void
     */
    public function transferSwitchToInput($name, &$value)
    {
        if (!isset($this->_parsed['switch'][$name])) {
            return;
        }

        $this->_parsed['input'][] = $this->_parsed['switch'][$name];
        $value                    = true;
        unset($this->_parsed['switch'][$name]);

        return;
    }

    /**
     * Get all inputs.
     *
     * @return  array
     */
    public function getInputs()
    {
        return $this->_parsed['input'];
    }

    /**
     * Distribute inputs in variable (like the list() function, but without
     * error).
     *
     * @param   string  $a     First input.
     * @param   string  $b     Second input.
     * @param   string  $c     Third input.
     * @param   ...     ...    ...
     * @param   string  $z     26th input.
     * @return  void
     */
    public function listInputs(
        &$a,
        &$b = null,
        &$c = null,
        &$d = null,
        &$e = null,
        &$f = null,
        &$g = null,
        &$h = null,
        &$i = null,
        &$j = null,
        &$k = null,
        &$l = null,
        &$m = null,
        &$n = null,
        &$o = null,
        &$p = null,
        &$q = null,
        &$r = null,
        &$s = null,
        &$t = null,
        &$u = null,
        &$v = null,
        &$w = null,
        &$x = null,
        &$y = null,
        &$z = null
    ) {
        $inputs = $this->getInputs();
        $i      = 'a';
        $ii     = -1;

        while (isset($inputs[++$ii]) && $i <= 'z') {
            ${$i++} = $inputs[$ii];
        }

        return;
    }

    /**
     * Get all switches.
     *
     * @return  array
     */
    public function getSwitches()
    {
        return $this->_parsed['switch'];
    }

    /**
     * Parse a special value, i.e. with comma and intervals.
     *
     * @param   string  $value       The value to parse.
     * @param   array   $keywords    Value of keywords.
     * @return  array
     * @throws  \Hoa\Console\Exception
     * @todo    Could be ameliorate with a ":" explode, and some eval.
     *          Check if operands are integer.
     */
    public function parseSpecialValue($value, array $keywords = [])
    {
        $out = [];

        foreach (explode(',', $value) as $key => $subvalue) {
            $subvalue = str_replace(
                array_keys($keywords),
                array_values($keywords),
                $subvalue
            );

            if (0 !== preg_match('#^(-?[0-9]+):(-?[0-9]+)$#', $subvalue, $matches)) {
                if (0 > $matches[1] && 0 > $matches[2]) {
                    throw new Exception(
                        'Cannot give two negative numbers, given %s.',
                        0,
                        $subvalue
                    );
                }

                array_shift($matches);
                $max = max($matches);
                $min = min($matches);

                if (0 > $max || 0 > $min) {
                    if (0 > $max - $min) {
                        throw new Exception(
                            'The difference between operands must be ' .
                            'positive.',
                            1
                        );
                    }

                    $min = $max + $min;
                }

                $out = array_merge(range($min, $max), $out);
            } else {
                $out[] = $subvalue;
            }
        }

        return $out;
    }

    /**
     * Set the long-only parameter.
     *
     * @param   bool  $longonly    The long-only value.
     * @return  bool
     */
    public function setLongOnly($longonly = false)
    {
        $old             = $this->_longonly;
        $this->_longonly = $longonly;

        return $old;
    }

    /**
     * Get the long-only value.
     *
     * @return  bool
     */
    public function getLongOnly()
    {
        return $this->_longonly;
    }
}
