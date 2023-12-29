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

namespace Hoa\Console\Test\Unit;

use Hoa\Console\Tput as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Console\Test\Unit\Tput.
 *
 * Test suite of the tput parser.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Tput extends Test\Unit\Suite
{
    public function case_get_term_from_environment()
    {
        $this
            ->given($_SERVER['TERM'] = 'foo')
            ->when($result = SUT::getTerm())
            ->then
                ->string($result)
                    ->isEqualTo('foo');
    }

    public function case_get_unknown_term_on_windows()
    {
        unset($_SERVER['TERM']);

        $this
            ->given($this->constant->OS_WIN = true)
            ->when($result = SUT::getTerm())
            ->then
                ->string($result)
                    ->isEqualTo('windows-ansi');
    }

    public function case_get_unknown_term()
    {
        unset($_SERVER['TERM']);

        $this
            ->given($this->constant->OS_WIN = false)
            ->when($result = SUT::getTerm())
            ->then
                ->string($result)
                    ->isEqualTo('xterm');
    }

    public function case_unknown_file_when_parsing()
    {
        $this
            ->exception(function () {
                new SUT('/hoa/flatland');
            })
                ->isInstanceOf('Hoa\Console\Exception');
    }

    public function case_all_informations()
    {
        $this
            ->given($tput = new SUT('hoa://Library/Console/Terminfo/78/xterm'))
            ->when($result = $tput->getInformations())
            ->then
                ->array($result)
                    ->isIdenticalTo([
                        'file'    => 'hoa://Library/Console/Terminfo/78/xterm',
                        'headers' => [
                            'data_size'         => 3258,
                            'header_size'       => 12,
                            'magic_number'      => 282,
                            'names_size'        => 48,
                            'bool_count'        => 38,
                            'number_count'      => 15,
                            'string_count'      => 413,
                            'string_table_size' => 1388
                        ],
                        'name'        => 'xterm',
                        'description' => 'xterm terminal emulator (X Window System)',
                        'booleans'    => [
                            'auto_left_margin'         => false,
                            'auto_right_margin'        => true,
                            'no_esc_ctlc'              => false,
                            'ceol_standout_glitch'     => false,
                            'eat_newline_glitch'       => true,
                            'erase_overstrike'         => false,
                            'generic_type'             => false,
                            'hard_copy'                => false,
                            'meta_key'                 => true,
                            'status_line'              => false,
                            'insert_null_glitch'       => false,
                            'memory_above'             => false,
                            'memory_below'             => false,
                            'move_insert_mode'         => true,
                            'move_standout_mode'       => true,
                            'over_strike'              => false,
                            'status_line_esc_ok'       => false,
                            'dest_tabs_magic_smso'     => false,
                            'tilde_glitch'             => false,
                            'transparent_underline'    => false,
                            'xon_xoff'                 => false,
                            'needs_xon_xoff'           => false,
                            'prtr_silent'              => true,
                            'hard_cursor'              => false,
                            'non_rev_rmcup'            => false,
                            'no_pad_char'              => true,
                            'non_dest_scroll_region'   => false,
                            'can_change'               => false,
                            'back_color_erase'         => true,
                            'hue_lightness_saturation' => false,
                            'col_addr_glitch'          => false,
                            'cr_cancels_micro_mode'    => false,
                            'print_wheel'              => false,
                            'row_addr_glitch'          => false,
                            'semi_auto_right_margin'   => false,
                            'cpi_changes_res'          => false,
                            'lpi_changes_res'          => false,
                            'backspaces_with_bs'       => true
                        ],
                        'numbers' => [
                            'columns'             => 80,
                            'init_tabs'           => 8,
                            'lines'               => 24,
                            'lines_of_memory'     => -1,
                            'magic_cookie_glitch' => -1,
                            'padding_baud_rate'   => -1,
                            'virtual_terminal'    => -1,
                            'width_status_line'   => -1,
                            'num_labels'          => -1,
                            'label_height'        => -1,
                            'label_width'         => -1,
                            'max_attributes'      => -1,
                            'maximum_windows'     => -1,
                            'max_colors'          => 8,
                            'max_pairs'           => 64
                        ],
                        'strings' => [
                            'back_tab'               => '[Z',
                            'bell'                   => '',
                            'carriage_return'        => '',
                            'change_scroll_region'   => '[%i%p1%d;%p2%dr',
                            'clear_all_tabs'         => '[3g',
                            'clear_screen'           => '[H[2J',
                            'clr_eol'                => '[K',
                            'clr_eos'                => '[J',
                            'column_address'         => '[%i%p1%dG',
                            'cursor_address'         => '[%i%p1%d;%p2%dH',
                            'cursor_down'            => "\n",
                            'cursor_home'            => '[H',
                            'cursor_invisible'       => '[?25l',
                            'cursor_left'            => '',
                            'cursor_normal'          => '[?12l[?25h',
                            'cursor_right'           => '[C',
                            'cursor_up'              => '[A',
                            'cursor_visible'         => '[?12;25h',
                            'delete_character'       => '[P',
                            'delete_line'            => '[M',
                            'enter_alt_charset_mode' => '(0',
                            'enter_blink_mode'       => '[5m',
                            'enter_bold_mode'        => '[1m',
                            'enter_ca_mode'          => '[?1049h',
                            'enter_insert_mode'      => '[4h',
                            'enter_secure_mode'      => '[8m',
                            'enter_reverse_mode'     => '[7m',
                            'enter_standout_mode'    => '[7m',
                            'enter_underline_mode'   => '[4m',
                            'erase_chars'            => '[%p1%dX',
                            'exit_alt_charset_mode'  => '(B',
                            'exit_attribute_mode'    => '(B[m',
                            'exit_ca_mode'           => '[?1049l',
                            'exit_insert_mode'       => '[4l',
                            'exit_standout_mode'     => '[27m',
                            'exit_underline_mode'    => '[24m',
                            'flash_screen'           => '[?5h$<100/>[?5l',
                            'init_2string'           => '[!p[?3;4l[4l>',
                            'insert_line'            => '[L',
                            'key_backspace'          => '',
                            'key_dc'                 => '[3~',
                            'key_down'               => 'OB',
                            'key_f1'                 => 'OP',
                            'key_f10'                => '[21~',
                            'key_f2'                 => 'OQ',
                            'key_f3'                 => 'OR',
                            'key_f4'                 => 'OS',
                            'key_f5'                 => '[15~',
                            'key_f6'                 => '[17~',
                            'key_f7'                 => '[18~',
                            'key_f8'                 => '[19~',
                            'key_f9'                 => '[20~',
                            'key_home'               => 'OH',
                            'key_ic'                 => '[2~',
                            'key_left'               => 'OD',
                            'key_npage'              => '[6~',
                            'key_ppage'              => '[5~',
                            'key_right'              => 'OC',
                            'key_sf'                 => '[1;2B',
                            'key_sr'                 => '[1;2A',
                            'key_up'                 => 'OA',
                            'keypad_local'           => '[?1l>',
                            'keypad_xmit'            => '[?1h=',
                            'meta_off'               => '[?1034l',
                            'meta_on'                => '[?1034h',
                            'parm_dch'               => '[%p1%dP',
                            'parm_delete_line'       => '[%p1%dM',
                            'parm_down_cursor'       => '[%p1%dB',
                            'parm_ich'               => '[%p1%d@',
                            'parm_index'             => '[%p1%dS',
                            'parm_insert_line'       => '[%p1%dL',
                            'parm_left_cursor'       => '[%p1%dD',
                            'parm_right_cursor'      => '[%p1%dC',
                            'parm_rindex'            => '[%p1%dT',
                            'parm_up_cursor'         => '[%p1%dA',
                            'print_screen'           => '[i',
                            'prtr_off'               => '[4i',
                            'prtr_on'                => '[5i',
                            'reset_1string'          => 'c',
                            'reset_2string'          => '[!p[?3;4l[4l>',
                            'restore_cursor'         => '8',
                            'row_address'            => '[%i%p1%dd',
                            'save_cursor'            => '7',
                            'scroll_forward'         => "\n",
                            'scroll_reverse'         => 'M',
                            'set_attributes'         => '%?%p9%t(0%e(B%;[0%?%p6%t;1%;%?%p2%t;4%;%?%p1%p3%|%t;7%;%?%p4%t;5%;%?%p7%t;8%;m',
                            'set_tab'                => 'H',
                            'tab'                    => '	',
                            'key_b2'                 => 'OE',
                            'acs_chars'              => '``aaffggiijjkkllmmnnooppqqrrssttuuvvwwxxyyzz{{||}}~~',
                            'key_btab'               => '[Z',
                            'enter_am_mode'          => '[?7h',
                            'exit_am_mode'           => '[?7l',
                            'key_end'                => 'OF',
                            'key_enter'              => 'OM',
                            'key_sdc'                => '[3;2~',
                            'key_send'               => '[1;2F',
                            'key_shome'              => '[1;2H',
                            'key_sic'                => '[2;2~',
                            'key_sleft'              => '[1;2D',
                            'key_snext'              => '[6;2~',
                            'key_sprevious'          => '[5;2~',
                            'key_sright'             => '[1;2C',
                            'key_f11'                => '[23~',
                            'key_f12'                => '[24~',
                            'key_f13'                => '[1;2P',
                            'key_f14'                => '[1;2Q',
                            'key_f15'                => '[1;2R',
                            'key_f16'                => '[1;2S',
                            'key_f17'                => '[15;2~',
                            'key_f18'                => '[17;2~',
                            'key_f19'                => '[18;2~',
                            'key_f20'                => '[19;2~',
                            'key_f21'                => '[20;2~',
                            'key_f22'                => '[21;2~',
                            'key_f23'                => '[23;2~',
                            'key_f24'                => '[24;2~',
                            'key_f25'                => '[1;5P',
                            'key_f26'                => '[1;5Q',
                            'key_f27'                => '[1;5R',
                            'key_f28'                => '[1;5S',
                            'key_f29'                => '[15;5~',
                            'key_f30'                => '[17;5~',
                            'key_f31'                => '[18;5~',
                            'key_f32'                => '[19;5~',
                            'key_f33'                => '[20;5~',
                            'key_f34'                => '[21;5~',
                            'key_f35'                => '[23;5~',
                            'key_f36'                => '[24;5~',
                            'key_f37'                => '[1;6P',
                            'key_f38'                => '[1;6Q',
                            'key_f39'                => '[1;6R',
                            'key_f40'                => '[1;6S',
                            'key_f41'                => '[15;6~',
                            'key_f42'                => '[17;6~',
                            'key_f43'                => '[18;6~',
                            'key_f44'                => '[19;6~',
                            'key_f45'                => '[20;6~',
                            'key_f46'                => '[21;6~',
                            'key_f47'                => '[23;6~',
                            'key_f48'                => '[24;6~',
                            'key_f49'                => '[1;3P',
                            'key_f50'                => '[1;3Q',
                            'key_f51'                => '[1;3R',
                            'key_f52'                => '[1;3S',
                            'key_f53'                => '[15;3~',
                            'key_f54'                => '[17;3~',
                            'key_f55'                => '[18;3~',
                            'key_f56'                => '[19;3~',
                            'key_f57'                => '[20;3~',
                            'key_f58'                => '[21;3~',
                            'key_f59'                => '[23;3~',
                            'key_f60'                => '[24;3~',
                            'key_f61'                => '[1;4P',
                            'key_f62'                => '[1;4Q',
                            'key_f63'                => '[1;4R',
                            'clr_bol'                => '[1K',
                            'user6'                  => '[%i%d;%dR',
                            'user7'                  => '[6n',
                            'user8'                  => '[?1;2c',
                            'user9'                  => '[c',
                            'orig_pair'              => '[39;49m',
                            'set_foreground'         => '[3%?%p1%{1}%=%t4%e%p1%{3}%=%t6%e%p1%{4}%=%t1%e%p1%{6}%=%t3%e%p1%d%;m',
                            'set_background'         => '[4%?%p1%{1}%=%t4%e%p1%{3}%=%t6%e%p1%{4}%=%t1%e%p1%{6}%=%t3%e%p1%d%;m',
                            'key_mouse'              => '[M',
                            'set_a_foreground'       => '[3%p1%dm',
                            'set_a_background'       => '[4%p1%dm',
                            'memory_lock'            => 'l',
                            'memory_unlock'          => 'm'
                        ]
                    ]);
    }

    public function case_has()
    {
        $this
            ->given($tput = new SUT('hoa://Library/Console/Terminfo/78/xterm'))
            ->when($result = $tput->has('auto_left_margin'))
            ->then
                ->boolean($result)
                    ->isFalse()

            ->when($result = $tput->has('auto_right_margin'))
                ->then
                ->boolean($result)
                    ->isTrue();
    }

    public function case_has_unknown_boolean()
    {
        $this
            ->given($tput = new SUT('hoa://Library/Console/Terminfo/78/xterm'))
            ->when($result = $tput->has('💩'))
            ->then
                ->boolean($result)
                    ->isFalse();
    }

    public function case_count()
    {
        $this
            ->given($tput = new SUT('hoa://Library/Console/Terminfo/78/xterm'))
            ->when($result = $tput->count('columns'))
            ->then
                ->integer($result)
                    ->isEqualTo(80);
    }

    public function case_count_unknown_integer()
    {
        $this
            ->given($tput = new SUT('hoa://Library/Console/Terminfo/78/xterm'))
            ->when($result = $tput->count('💩'))
            ->then
                ->integer($result)
                    ->isEqualTo(0);
    }

    public function case_get()
    {
        $this
            ->given($tput = new SUT('hoa://Library/Console/Terminfo/78/xterm'))
            ->when($result = $tput->get('cursor_down'))
            ->then
                ->string($result)
                    ->isEqualTo("\n");
    }

    public function case_get_unknown_string()
    {
        $this
            ->given($tput = new SUT('hoa://Library/Console/Terminfo/78/xterm'))
            ->when($result = $tput->get('💩'))
            ->then
                ->variable($result)
                    ->isNull();
    }
}
