<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * cssmin.php - A simple CSS minifier.
 * --
 *
 * <code>
 * include("cssmin.php");
 * file_put_contents("path/to/target.css", cssmin::minify(file_get_contents("path/to/source.css")));
 * </code>
 * --
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING
 * BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * --
 *
 * @package 	cssmin
 * @author 		Joe Scylla <joe.scylla@gmail.com>
 * @copyright 	2008 Joe Scylla <joe.scylla@gmail.com>
 * @license 	http://opensource.org/licenses/mit-license.php MIT License
 * @version 	1.0.1.b3 (2008-10-02)
 */
class cssmin
{
    /**
     * Minifies stylesheet definitions
     *
     * <code>
     * $css_minified = cssmin::minify(file_get_contents("path/to/target/file.css"));
     * </code>
     *
     * @param	string			$css		Stylesheet definitions as string
     * @param	array|string	$options	Array or comma speperated list of options:
     *
     * 										- remove-last-semicolon: Removes the last semicolon in
     * 										the style definition of an element (activated by default).
     *
     * 										- preserve-urls: Preserves every url defined in an url()-
     * 										expression. This option is only required if you have
     * 										defined really uncommon urls with multiple spaces or
     * 										combination of colon, semi-colon, braces with leading or
     * 										following spaces.
     * @return	string			Minified stylesheet definitions
     */
    public static function minify($css, $options = "remove-last-semicolon")
    {
        $options = ($options == "") ? array() : (is_array($options) ? $options : explode(",", $options));
        if (in_array("preserve-urls", $options)) {
            // Encode url() to base64
            $css = preg_replace_callback("/url\s*\((.*)\)/siU", "cssmin_encode_url", $css);
        }
        // Remove comments
        $css = preg_replace("/\/\*[\d\D]*?\*\/|\t+/", " ", $css);
        // Replace CR, LF and TAB to spaces
        $css = str_replace(array("\n", "\r", "\t"), " ", $css);
        // Replace multiple to single space
        $css = preg_replace("/\s\s+/", " ", $css);
        // Remove unneeded spaces
        $css = preg_replace("/\s*({|}|\[|=|~|\+|>|\||;|:|,)\s*/", "$1", $css);
        if (in_array("remove-last-semicolon", $options)) {
            // Removes the last semicolon of every style definition
            $css = str_replace(";}", "}", $css);
        }
        $css = trim($css);
        if (in_array("preserve-urls", $options)) {
            // Decode url()
            $css = preg_replace_callback("/url\s*\((.*)\)/siU", "cssmin_encode_url", $css);
        }
        return $css;
    }
    /**
     * Return a array structure of a stylesheet definitions.
     *
     * <code>
     * $css_structure = cssmin::toArray(file_get_contents("path/to/target/file.css"));
     * </code>
     *
     * @param	string		$css			Stylesheet definitions as string
     * @param	string		$options		Options for {@link cssmin::minify()}
     * @return	array						Structure of the stylesheet definitions as array
     */
    public static function toArray($css, $options = "")
    {
        $r = array();
        $css = cssmin::minify($css, $options);
        $items = array();
        preg_match_all("/(.+){(.+:.+);}/U", $css, $items);
        if (count($items[0]) > 0) {
            for ($i = 0; $i < count($items[0]); $i++) {
                $keys		= explode(",", $items[1][$i]);
                $styles_tmp	= explode(";", $items[2][$i]);
                $styles = array();
                foreach ($styles_tmp as $style) {
                    $style_tmp = explode(":", $style);
                    $styles[$style_tmp[0]] = $style_tmp[1];
                }
                $r[] = array(
                    "keys"		=> cssmin_array_clean($keys),
                    "styles"	=> cssmin_array_clean($styles)
                    );
            }
        }
        return $r;
    }
    /**
     * Return a array structure created by {@link cssmin::toArray()} to a string.
     *
     * <code>
     * $css_string = cssmin::toString($css_structure);
     * </code>
     *
     * @param	array		$css
     * @return	array
     */
    public static function toString(array $array)
    {
        $r = "";
        foreach ($array as $item) {
            $r .= implode(",", $item["keys"]) . "{";
            foreach ($item["styles"] as $key => $value) {
                $r .= $key . ":" . $value . ";";
            }
            $r .= "}";
        }
        return $r;
    }
}

/**
 * Trims all elements of the array and removes empty elements.
 *
 * @param	array		$array
 * @return	array
 */
function cssmin_array_clean(array $array)
{
    $r = array();
    if (cssmin_array_is_assoc($array)) {
        foreach ($array as $key => $value) {
            $r[$key] = trim($value);
        }
    } else {
        foreach ($array as $value) {
            if (trim($value) != "") {
                $r[] = trim($value);
            }
        }
    }
    return $r;
}
/**
 * Return if a value is a associative array.
 *
 * @param	array		$array
 * @return	bool
 */
function cssmin_array_is_assoc($array)
{
    if (!is_array($array)) {
        return false;
    } else {
        krsort($array, SORT_STRING);
        return !is_numeric(key($array));
    }
}
/**
 * Encodes a url() expression.
 *
 * @param	array	$match
 * @return	string
 */
function cssmin_encode_url($match)
{
    return "url(" . base64_encode(trim($match[1])) . ")";
}
/**
 * Decodes a url() expression.
 *
 * @param	array	$match
 * @return	string
 */
function cssmin_decode_url($match)
{
    return "url(" . base64_decode($match[1]) . ")";
}
