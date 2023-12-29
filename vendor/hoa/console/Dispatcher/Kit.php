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

namespace Hoa\Console\Dispatcher;

use Hoa\Console;
use Hoa\Dispatcher;
use Hoa\Router;
use Hoa\View;

/**
 * Class \Hoa\Console\Dispatcher\Kit.
 *
 * A structure, given to action, that holds some important data.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Kit extends Dispatcher\Kit
{
    /**
     * CLI parser.
     *
     * @var \Hoa\Console\Parser
     */
    public $parser      = null;

    /**
     * Options (as described in \Hoa\Console\GetOption).
     *
     * @var array
     */
    protected $options  = null;

    /**
     * Options analyzer.
     *
     * @var \Hoa\Console\GetOption
     */
    protected $_options = null;



    /**
     * Build a dispatcher kit.
     *
     * @param   \Hoa\Router           $router        The router.
     * @param   \Hoa\Dispatcher       $dispatcher    The dispatcher.
     * @param   \Hoa\View\Viewable    $view          The view.
     */
    public function __construct(
        Router        $router,
        Dispatcher    $dispatcher,
        View\Viewable $view = null
    ) {
        parent::__construct($router, $dispatcher, $view);

        $this->parser = new Console\Parser();

        return;
    }

    /**
     * Alias of \Hoa\Console\GetOption::getOptions().
     *
     * @param   string  &$optionValue    Please, see original API.
     * @param   string  $short           Please, see original API.
     * @return  mixed
     */
    public function getOption(&$optionValue, $short = null)
    {
        if (null === $this->_options && !empty($this->options)) {
            $this->setOptions($this->options);
        }

        if (null === $this->_options) {
            return false;
        }

        return $this->_options->getOption($optionValue, $short);
    }

    /**
     * Initialize options.
     *
     * @param   array  $options    Options, as described in
     *                             \Hoa\Console\GetOption.
     * @return  array
     */
    public function setOptions(array $options)
    {
        $old           = $this->options;
        $this->options = $options;
        $rule          = $this->router->getTheRule();
        $variables     = $rule[Router::RULE_VARIABLES];

        if (isset($variables['_tail'])) {
            $this->parser->parse($variables['_tail']);
            $this->_options = new Console\GetOption(
                $this->options,
                $this->parser
            );
        }

        return $old;
    }

    /**
     * It is a helper to make the usage options list.
     *
     * @param   array  $definitions    An associative arry: short or long option
     *                                 associated to the definition.
     * @return  string
     */
    public function makeUsageOptionsList(array $definitions = [])
    {
        $out = [];

        foreach ($this->options as $i => $options) {
            $out[] = [
                '  -' . $options[Console\GetOption::OPTION_VAL] . ', --' .
                $options[Console\GetOption::OPTION_NAME] .
                ($options[Console\GetOption::OPTION_HAS_ARG] ===
                    Console\GetOption::REQUIRED_ARGUMENT
                    ? '='
                    : ($options[Console\GetOption::OPTION_HAS_ARG] ===
                           Console\GetOption::OPTIONAL_ARGUMENT
                        ? '[=]'
                        : '')),
                (isset($definitions[$options[Console\GetOption::OPTION_VAL]])
                    ? $definitions[$options[Console\GetOption::OPTION_VAL]]
                    : (isset($definitions[$options[0]])
                        ? $definitions[$options[Console\GetOption::OPTION_NAME]]
                        : null
                    )
                )
            ];
        }

        return Console\Chrome\Text::columnize(
            $out,
            Console\Chrome\Text::ALIGN_LEFT,
            .5,
            0,
            '|: '
        );
    }

    /**
     * Resolve option ambiguity by asking the user to choose amongst some
     * appropriated solutions.
     *
     * @param   array  $solutions    Solutions.
     * @return  void
     */
    public function resolveOptionAmbiguity(array $solutions)
    {
        echo
            'You have made a typo in the option ',
            $solutions['option'], '; it can match the following options: ', "\n",
            '    • ',  implode(";\n    • ", $solutions['solutions']), '.', "\n",
            'Please, type the right option (empty to choose the first one):', "\n";
        $new = $this->readLine('> ');

        if (empty($new)) {
            $new = $solutions['solutions'][0];
        }

        $solutions['solutions'] = [$new];

        $this->_options->resolveOptionAmbiguity($solutions);

        return;
    }

    /**
     * Make a render of an operation.
     *
     * @param   string  $text      The operation text.
     * @param   bool    $status    The operation status.
     * @return  void
     */
    public function status($text, $status)
    {
        $window = Console\Window::getSize();
        $out    =
            ' ' . Console\Chrome\Text::colorize('*', 'foreground(yellow)') . ' ' .
            $text . str_pad(
                ' ',
                $window['x']
                - strlen(preg_replace('#' . "\033" . '\[[0-9]+m#', '', $text))
                - 8
            ) .
            ($status === true
                ? '[' . Console\Chrome\Text::colorize('ok', 'foreground(green)') . ']'
                : '[' . Console\Chrome\Text::colorize('!!', 'foreground(white) background(red)') . ']');

        Console::getOutput()->writeAll($out . "\n");

        return;
    }

    /**
     * Read, edit, bind… a line from STDIN.
     *
     * @param   string  $prefix    Prefix.
     * @return  string
     */
    public function readLine($prefix = null)
    {
        static $_rl = null;

        if (null === $_rl) {
            $_rl = new Console\Readline();
        }

        return $_rl->readLine($prefix);
    }

    /**
     * Read, edit, bind… a password from STDIN.
     *
     * @param   string  $prefix    Prefix.
     * @return  string
     */
    public function readPassword($prefix = null)
    {
        static $_rl = null;

        if (null === $_rl) {
            $_rl = new Console\Readline\Password();
        }

        return $_rl->readLine($prefix);
    }
}
