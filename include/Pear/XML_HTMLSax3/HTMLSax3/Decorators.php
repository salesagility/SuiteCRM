<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Alexander Zhukov <alex@veresk.ru> Original port from Python |
// | Authors: Harry Fuecks <hfuecks@phppatterns.com> Port to PEAR + more  |
// | Authors: Many @ Sitepointforums Advanced PHP Forums                  |
// +----------------------------------------------------------------------+
//

//
/**
* Decorators for dealing with parser options
* @package XML_HTMLSax3

* @see XML_HTMLSax3::set_option
*/
/**
* Trims the contents of element data from whitespace at start and end
* @package XML_HTMLSax3
* @access protected
*/
class XML_HTMLSax3_Trim
{
    /**
    * Original handler object
    * @var object
    * @access private
    */
    public $orig_obj;
    /**
    * Original handler method
    * @var string
    * @access private
    */
    public $orig_method;
    /**
    * Constructs XML_HTMLSax3_Trim
    * @param object handler object being decorated
    * @param string original handler method
    * @access protected
    */
    public function __construct(&$orig_obj, $orig_method)
    {
        $this->orig_obj =& $orig_obj;
        $this->orig_method = $orig_method;
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function XML_HTMLSax3_Trim(&$orig_obj, $orig_method)
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct($orig_obj, $orig_method);
    }

    /**
    * Trims the data
    * @param XML_HTMLSax3
    * @param string element data
    * @access protected
    */
    public function trimData(&$parser, $data)
    {
        $data = trim($data);
        if ($data != '') {
            $this->orig_obj->{$this->orig_method}($parser, $data);
        }
    }
}
/**
* Coverts tag names to upper case
* @package XML_HTMLSax3
* @access protected
*/
class XML_HTMLSax3_CaseFolding
{
    /**
    * Original handler object
    * @var object
    * @access private
    */
    public $orig_obj;
    /**
    * Original open handler method
    * @var string
    * @access private
    */
    public $orig_open_method;
    /**
    * Original close handler method
    * @var string
    * @access private
    */
    public $orig_close_method;
    /**
    * Constructs XML_HTMLSax3_CaseFolding
    * @param object handler object being decorated
    * @param string original open handler method
    * @param string original close handler method
    * @access protected
    */
    public function __construct(&$orig_obj, $orig_open_method, $orig_close_method)
    {
        $this->orig_obj =& $orig_obj;
        $this->orig_open_method = $orig_open_method;
        $this->orig_close_method = $orig_close_method;
    }
    /**
    * Folds up open tag callbacks
    * @param XML_HTMLSax3
    * @param string tag name
    * @param array tag attributes
    * @access protected
    */
    public function foldOpen(&$parser, $tag, $attrs=array(), $empty = false)
    {
        $this->orig_obj->{$this->orig_open_method}($parser, strtoupper($tag), $attrs, $empty);
    }
    /**
    * Folds up close tag callbacks
    * @param XML_HTMLSax3
    * @param string tag name
    * @access protected
    */
    public function foldClose(&$parser, $tag, $empty = false)
    {
        $this->orig_obj->{$this->orig_close_method}($parser, strtoupper($tag), $empty);
    }
}
/**
* Breaks up data by linefeed characters, resulting in additional
* calls to the data handler
* @package XML_HTMLSax3
* @access protected
*/
class XML_HTMLSax3_Linefeed
{
    /**
    * Original handler object
    * @var object
    * @access private
    */
    public $orig_obj;
    /**
    * Original handler method
    * @var string
    * @access private
    */
    public $orig_method;
    /**
    * Constructs XML_HTMLSax3_LineFeed
    * @param object handler object being decorated
    * @param string original handler method
    * @access protected
    */
    public function XML_HTMLSax3_LineFeed(&$orig_obj, $orig_method)
    {
        $this->orig_obj =& $orig_obj;
        $this->orig_method = $orig_method;
    }
    /**
    * Breaks the data up by linefeeds
    * @param XML_HTMLSax3
    * @param string element data
    * @access protected
    */
    public function breakData(&$parser, $data)
    {
        $data = explode("\n", $data);
        foreach ($data as $chunk) {
            $this->orig_obj->{$this->orig_method}($parser, $chunk);
        }
    }
}
/**
* Breaks up data by tab characters, resulting in additional
* calls to the data handler
* @package XML_HTMLSax3
* @access protected
*/
class XML_HTMLSax3_Tab
{
    /**
    * Original handler object
    * @var object
    * @access private
    */
    public $orig_obj;
    /**
    * Original handler method
    * @var string
    * @access private
    */
    public $orig_method;
    /**
    * Constructs XML_HTMLSax3_Tab
    * @param object handler object being decorated
    * @param string original handler method
    * @access protected
    */
    public function __construct(&$orig_obj, $orig_method)
    {
        $this->orig_obj =& $orig_obj;
        $this->orig_method = $orig_method;
    }
    /**
    * Breaks the data up by linefeeds
    * @param XML_HTMLSax3
    * @param string element data
    * @access protected
    */
    public function breakData(&$parser, $data)
    {
        $data = explode("\t", $data);
        foreach ($data as $chunk) {
            $this->orig_obj->{$this->orig_method}($this, $chunk);
        }
    }
}
/**
* Breaks up data by XML entities and parses them with html_entity_decode(),
* resulting in additional calls to the data handler<br />
* Requires PHP 4.3.0+
* @package XML_HTMLSax3
* @access protected
*/
class XML_HTMLSax3_Entities_Parsed
{
    /**
    * Original handler object
    * @var object
    * @access private
    */
    public $orig_obj;
    /**
    * Original handler method
    * @var string
    * @access private
    */
    public $orig_method;
    /**
    * Constructs XML_HTMLSax3_Entities_Parsed
    * @param object handler object being decorated
    * @param string original handler method
    * @access protected
    */
    public function __construct(&$orig_obj, $orig_method)
    {
        $this->orig_obj =& $orig_obj;
        $this->orig_method = $orig_method;
    }
    /**
    * Breaks the data up by XML entities
    * @param XML_HTMLSax3
    * @param string element data
    * @access protected
    */
    public function breakData(&$parser, $data)
    {
        $data = preg_split('/(&.+?;)/', $data, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        foreach ($data as $chunk) {
            $chunk = html_entity_decode($chunk, ENT_NOQUOTES);
            $this->orig_obj->{$this->orig_method}($this, $chunk);
        }
    }
}
/**
* Compatibility with older PHP versions
*/
if (version_compare(phpversion(), '4.3', '<') && !function_exists('html_entity_decode')) {
    function html_entity_decode($str, $style=ENT_NOQUOTES)
    {
        return strtr(
            $str,
            array_flip(get_html_translation_table(HTML_ENTITIES, $style))
        );
    }
}
/**
* Breaks up data by XML entities but leaves them unparsed,
* resulting in additional calls to the data handler<br />
* @package XML_HTMLSax3
* @access protected
*/
class XML_HTMLSax3_Entities_Unparsed
{
    /**
    * Original handler object
    * @var object
    * @access private
    */
    public $orig_obj;
    /**
    * Original handler method
    * @var string
    * @access private
    */
    public $orig_method;
    /**
    * Constructs XML_HTMLSax3_Entities_Unparsed
    * @param object handler object being decorated
    * @param string original handler method
    * @access protected
    */
    public function __construct(&$orig_obj, $orig_method)
    {
        $this->orig_obj =& $orig_obj;
        $this->orig_method = $orig_method;
    }
    /**
    * Breaks the data up by XML entities
    * @param XML_HTMLSax3
    * @param string element data
    * @access protected
    */
    public function breakData(&$parser, $data)
    {
        $data = preg_split('/(&.+?;)/', $data, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        foreach ($data as $chunk) {
            $this->orig_obj->{$this->orig_method}($this, $chunk);
        }
    }
}

/**
* Strips the HTML comment markers or CDATA sections from an escape.
* If XML_OPTIONS_FULL_ESCAPES is on, this decorator is not used.<br />
* @package XML_HTMLSax3
* @access protected
*/
class XML_HTMLSax3_Escape_Stripper
{
    /**
    * Original handler object
    * @var object
    * @access private
    */
    public $orig_obj;
    /**
    * Original handler method
    * @var string
    * @access private
    */
    public $orig_method;
    /**
    * Constructs XML_HTMLSax3_Entities_Unparsed
    * @param object handler object being decorated
    * @param string original handler method
    * @access protected
    */
    public function __construct(&$orig_obj, $orig_method)
    {
        $this->orig_obj =& $orig_obj;
        $this->orig_method = $orig_method;
    }
    /**
    * Breaks the data up by XML entities
    * @param XML_HTMLSax3
    * @param string element data
    * @access protected
    */
    public function strip(&$parser, $data)
    {
        // Check for HTML comments first
        if (substr($data, 0, 2) == '--') {
            $patterns = array(
                '/^\-\-/',          // Opening comment: --
                '/\-\-$/',          // Closing comment: --
            );
            $data = preg_replace($patterns, '', $data);

        // Check for XML CDATA sections (note: don't do both!)
        } elseif (substr($data, 0, 1) == '[') {
            $patterns = array(
                '/^\[.*CDATA.*\[/s', // Opening CDATA
                '/\].*\]$/s',       // Closing CDATA
                );
            $data = preg_replace($patterns, '', $data);
        }

        $this->orig_obj->{$this->orig_method}($this, $data);
    }
}
