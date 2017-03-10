<?php
namespace SuiteCRM;

/**
 * Class XTemplate 0.2.5
 * Html generation with templates - fast & easy
 * Copyright (c) 2000 barnabás debreceni [cranx@users.sourceforge.net]
 * Code optimization by Ivar Smolin <okul@linux.ee> 14-march-2001
 * Refactoring by Jakub Pas <jakubpas@gmail.com> 17-march-2016
 * Latest stable & CVS version always available @ http://sourceforge.net/projects/xtpl
 *
 * Tested with php 5.3.0 and 5.5.9
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License
 * version 2.1 as published by the Free Software Foundation.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package SuiteCRM
 * @license http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License
 */
class XTemplate
{
    public $filecontents = ""; // raw contents of template file 
    public $blocks = array(); // unparsed blocks 
    public $parsed_blocks = array(); // parsed blocks 
    public $block_parse_order = array(); // block parsing order for recursive parsing (sometimes reverse:) 
    public $sub_blocks = array(); // store sub-block names for fast resetting 
    public $VARS = array(); // variables array 
    public $alternate_include_directory = "";

    public $file_delim = "/\{FILE\s*\"([^\"]+)\"\s*\}/m"; // regexp for file includes 
    public $block_start_delim = "<!-- "; // block start delimiter 
    public $block_end_delim = "-->"; // block end delimiter 
    public $block_start_word = "BEGIN:"; // block start word 
    public $block_end_word = "END:"; // block end word 

    // this makes the delimiters look like: <!-- BEGIN: block_name --> if you use my syntax. 

    public $NULL_STRING = array("" => ""); // null string for unassigned vars 
    public $NULL_BLOCK = array("" => ""); // null string for unassigned blocks 
    public $mainblock = "";
    public $ERROR = "";
    public $AUTORESET = 1; // auto-reset sub blocks 

    public function __construct($file, $alt_include = "", $mainblock = "main")
    {
        $this->alternate_include_directory = $alt_include;
        $this->mainblock = $mainblock;
        $this->filecontents = $this->r_getfile($file); // read in template file 
        $this->blocks = $this->maketree($this->filecontents); // preprocess some stuff
    }

    /**
     * @param $name
     * @param string $val
     */
    public function assign($name, $val = "")
    {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->VARS[$k] = $v;
            }
        } else {
            $this->VARS[$name] = $val;
        }
    }

    /**
     * @param $varname
     * @param $name
     * @param string $val
     */
    public function append($varname, $name, $val = "")
    {
        if (!isset($this->VARS[$varname])) {
            $this->VARS[$varname] = array();
        }
        if (is_array($this->VARS[$varname])) {
            $this->VARS[$varname][$name] = $val;
        }
    }

    /**
     * @param $bname
     */
    public function parse($bname)
    {
        global $sugar_config;

        $this->assign('SUGAR_VERSION', $GLOBALS['js_version_key']);
        $this->assign('JS_CUSTOM_VERSION', $sugar_config['js_custom_version']);
        $this->assign('VERSION_MARK', getVersionedPath(''));

        if (empty($this->blocks[$bname]))
            return;

        $copy = $this->blocks[$bname];
        if (!isset($this->blocks[$bname]))
            $this->set_error("parse: blockname [$bname] does not exist");
        preg_match_all("/\{([A-Za-z0-9\._]+?)}/", $this->blocks[$bname], $var_array);
        $var_array = $var_array[1];
        foreach ($var_array as $k => $v) {
            $sub = explode(".", $v);
            if ($sub[0] == "_BLOCK_") {
                unset($sub[0]);
                $bname2 = implode(".", $sub);

                if (isset($this->parsed_blocks[$bname2])) {
                    $var = $this->parsed_blocks[$bname2];
                } else {
                    $var = null;
                }

                $nul = (!isset($this->NULL_BLOCK[$bname2])) ? $this->NULL_BLOCK[""] : $this->NULL_BLOCK[$bname2];
                $var = (empty($var)) ? $nul : trim($var);
                // Commented out due to regular expression issue with '$' in replacement string.
                // $copy=preg_replace("/\{".$v."\}/","$var",$copy);
                // This should be faster and work better for '$'
                $copy = str_replace("{" . $v . "}", $var, $copy);
            } else {
                $var = $this->VARS;

                foreach ($sub as $k1 => $v1) {
                    if (is_array($var) && isset($var[$v1])) {
                        $var = $var[$v1];
                    } else {
                        $var = null;
                    }
                }

                $nul = (!isset($this->NULL_STRING[$v])) ? ($this->NULL_STRING[""]) : ($this->NULL_STRING[$v]);
                $var = (!isset($var)) ? $nul : $var;
                // Commented out due to regular expression issue with '$' in replacement string.
                // $copy=preg_replace("/\{$v\}/","$var",$copy);
                // This should be faster and work better for '$'
                // this was periodically returning an array to string conversion error....
                if (!is_array($var)) {
                    $copy = str_replace("{" . $v . "}", $var, $copy);
                }
            }
        }

        if (isset($this->parsed_blocks[$bname])) {
            $this->parsed_blocks[$bname] .= $copy;
        } else {
            $this->parsed_blocks[$bname] = $copy;
        }

        // reset sub-blocks
        if ($this->AUTORESET && (!empty($this->sub_blocks[$bname]))) {
            reset($this->sub_blocks[$bname]);
            foreach ($this->sub_blocks[$bname] as $v)
                $this->reset($v);
        }
    }

    /**
     * @param $bname
     * @return bool
     */
    public function exists($bname)
    {
        return (!empty($this->parsed_blocks[$bname])) || (!empty($this->blocks[$bname]));
    }

    /**
     * @param $bname
     * @param $vname
     * @return bool
     */
    public function var_exists($bname, $vname)
    {
        if (!empty($this->blocks[$bname])) {
            return substr_count($this->blocks[$bname], '{' . $vname . '}') > 0;
        }
        return false;
    }

    /**
     * @param $bname
     */
    public function rparse($bname)
    {
        if (!empty($this->sub_blocks[$bname])) {
            reset($this->sub_blocks[$bname]);
            while (list($k, $v) = each($this->sub_blocks[$bname])) {
                unset($k);
                if (!empty($v)) {
                    $this->rparse($v);
                }
            }
        }
        $this->parse($bname);
    }

    /**
     * @param $bname
     * @param $var
     * @param string $value
     */
    public function insert_loop($bname, $var, $value = "")
    {
        $this->assign($var, $value);
        $this->parse($bname);
    }

    /**
     * @param $bname
     * @return string
     */
    public function text($bname)
    {

        if (!empty($this->parsed_blocks)) {
            return $this->parsed_blocks[isset($bname) ? $bname : $this->mainblock];
        } else {
            return '';
        }
    }

    /**
     * @param $bname
     */
    public function out($bname)
    {
        global $focus;
        if (isset($focus)) {
            global $action;
            if ($focus && is_subclass_of($focus, 'SugarBean') && !$focus->ACLAccess($action)) {
                \ACLController::displayNoAccess(true);
                sugar_die('');
                return;
            }
        }
        echo $this->text($bname);
    }

    /**
     * @param $bname
     */
    public function reset($bname)
    {
        $this->parsed_blocks[$bname] = "";
    }

    /**
     * @param $bname
     * @return bool
     */
    public function parsed($bname)
    {
        return (!empty($this->parsed_blocks[$bname]));
    }

    /**
     * @param $str
     * @param string $varname
     */
    public function SetNullString($str, $varname = "")
    {
        $this->NULL_STRING[$varname] = $str;
    }

    /**
     * @param $str
     * @param string $bname
     */
    public function SetNullBlock($str, $bname = "")
    {
        $this->NULL_BLOCK[$bname] = $str;
    }

    public function set_autoreset()
    {
        $this->AUTORESET = 1;
    }

    /**
     * sets AUTORESET to 0. (default is 1)
     * if set to 1, parse() automatically resets the parsed blocks' sub blocks
     * (for multiple level blocks)
     */
    public function clear_autoreset()
    {
        $this->AUTORESET = 0;
    }

    public function scan_globals()
    {
        $GLOB = '';
        reset($GLOBALS);
        while (list($k, $v) = each($GLOBALS))
            $GLOB[$k] = $v;
        $this->assign("PHP", $GLOB); // access global variables as {PHP.HTTP_HOST} in your template! 
    }

    /**
     * Generates the array containing to-be-parsed stuff:
     * $blocks["main"],$blocks["main.table"],$blocks["main.table.row"], etc.
     * also builds the reverse parse order.
     * @param $con
     * @return array
     */
    public function maketree($con)
    {
        $con2 = explode($this->block_start_delim, $con);
        $level = 0;
        $block_names = array();
        $blocks = array();
        reset($con2);
        while (list($k, $v) = each($con2)) {
            unset($k);
            $patt = "($this->block_start_word|$this->block_end_word)\s*(\w+)\s*$this->block_end_delim(.*)";
            if (preg_match_all("/$patt/ims", $v, $res, PREG_SET_ORDER)) {
                // $res[0][1] = BEGIN or END
                // $res[0][2] = block name
                // $res[0][3] = kinda content
                if ($res[0][1] == $this->block_start_word) {
                    $parent_name = implode(".", $block_names);
                    $block_names[++$level] = $res[0][2]; // add one level - array("main","table","row")
                    $cur_block_name = implode(".", $block_names); // make block name (main.table.row) 
                    $this->block_parse_order[] = $cur_block_name; // build block parsing order (reverse) 

                    if (array_key_exists($cur_block_name, $blocks)) {
                        $blocks[$cur_block_name] .= $res[0][3]; // add contents 
                    } else {
                        $blocks[$cur_block_name] = $res[0][3]; // add contents 
                    }

                    // add {_BLOCK_.blockname} string to parent block 
                    if (array_key_exists($parent_name, $blocks)) {
                        $blocks[$parent_name] .= "{_BLOCK_.$cur_block_name}";
                    } else {
                        $blocks[$parent_name] = "{_BLOCK_.$cur_block_name}";
                    }

                    $this->sub_blocks[$parent_name][] = $cur_block_name; // store sub block names for autoresetting and recursive parsing 
                    $this->sub_blocks[$cur_block_name][] = ""; // store sub block names for autoresetting 
                } else if ($res[0][1] == $this->block_end_word) {
                    unset($block_names[$level--]);
                    $parent_name = implode(".", $block_names);
                    $blocks[$parent_name] .= $res[0][3]; // add rest of block to parent block 
                }
            } else { // no block delimiters found 
                $index = implode(".", $block_names);
                if (array_key_exists($index, $blocks)) {
                    $blocks[] .= $this->block_start_delim . $v;
                } else {
                    $blocks[] = $this->block_start_delim . $v;
                }
            }
        }
        return $blocks;
    }

    /**
     * Sets and gets error
     * @return int|string
     */
    public function get_error()
    {
        return ($this->ERROR == "") ? 0 : $this->ERROR;
    }


    public function set_error($str)
    {
        $this->ERROR = $str;
    }

    /**
     * Returns the contents of a fil
     * @param $file
     * @return string
     */
    public function getfile($file)
    {
        if (!isset($file)) {
            $this->set_error("!isset file name!");
            return "";
        }

        if (!is_file($file))
            $file = $this->alternate_include_directory . $file;

        if (is_file($file)) {
            $file_text = file_get_contents($file);

        } else {
            $this->set_error("[$file] does not exist");
            $file_text = "<b>__XTemplate fatal error: file [$file] does not exist__</b>";
        }

        return $file_text;
    }

    /**
     * Recursively gets the content of a file with {FILE "filename.tpl"} directives
     * @param $file
     * @return mixed|string
     */
    public function r_getfile($file)
    {
        $text = $this->getfile($file);
        while (preg_match($this->file_delim, $text, $res)) {
            $text2 = $this->getfile($res[1]);
            $text = str_replace($res[0], $text2, $text);
        }
        return $text;
    }
}