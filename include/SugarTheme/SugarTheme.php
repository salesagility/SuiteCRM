<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


/*********************************************************************************

 * Description:  Contains a variety of utility functions used to display UI
 * components such as form headers and footers.  Intended to be modified on a per
 * theme basis.
 ********************************************************************************/

if(!defined('JSMIN_AS_LIB'))
    define('JSMIN_AS_LIB', true);

require_once("include/SugarTheme/cssmin.php");
require_once("jssource/jsmin.php");
require_once('include/utils/sugar_file_utils.php');

/**
 * Class that provides tools for working with a theme.
 * @api
 */
class SugarTheme
{
    /**
     * Theme name
     *
     * @var string
     */
    protected $name;

    /**
     * Theme description
     *
     * @var string
     */
    protected $description;

    /**
     * Defines which parent files to not include
     *
     * @var string
     */
    protected $ignoreParentFiles = array();

    /**
     * Defines which parent files to not include
     *
     * @var string
     */
    public $directionality = 'ltr';
    /**
     * Theme directory name
     *
     * @var string
     */
    protected $dirName;

    /**
     * Parent theme name
     *
     * @var string
     */
    protected $parentTheme;

    /**
     * Colors sets provided by the theme
     *
     * @deprecated only here for BC during upgrades
     * @var array
     */
    protected $colors = array();

    /**
     * Font sets provided by the theme
     *
     * @deprecated only here for BC during upgrades
     * @var array
     */
    protected $fonts  = array();

    /**
     * Maximum sugar version this theme is for; defaults to 5.5.1 as all the themes without this
     * parameter as assumed to work thru 5.5.1
     *
     * @var int
     */
    protected $version = '5.5.1';

    /**
     * Colors used in bar charts
     *
     * @var array
     */
    protected $barChartColors = array(
        "docBorder"             => "0xffffff",
        "docBg1"                => "0xffffff",
        "docBg2"                => "0xffffff",
        "xText"                 => "0x33485c",
        "yText"                 => "0x33485c",
        "title"                 => "0x333333",
        "misc"                  => "0x999999",
        "altBorder"             => "0xffffff",
        "altBg"                 => "0xffffff",
        "altText"               => "0x666666",
        "graphBorder"           => "0xcccccc",
        "graphBg1"              => "0xf6f6f6",
        "graphBg2"              => "0xf6f6f6",
        "graphLines"            => "0xcccccc",
        "graphText"             => "0x333333",
        "graphTextShadow"       => "0xf9f9f9",
        "barBorder"             => "0xeeeeee",
        "barBorderHilite"       => "0x333333",
        "legendBorder"          => "0xffffff",
        "legendBg1"             => "0xffffff",
        "legendBg2"             => "0xffffff",
        "legendText"            => "0x444444",
        "legendColorKeyBorder"  => "0x777777",
        "scrollBar"             => "0xcccccc",
        "scrollBarBorder"       => "0xeeeeee",
        "scrollBarTrack"        => "0xeeeeee",
        "scrollBarTrackBorder"  => "0xcccccc",
        );

    /**
     * Colors used in pie charts
     *
     * @var array
     */
    protected $pieChartColors = array(
        "docBorder"             => "0xffffff",
        "docBg1"                => "0xffffff",
        "docBg2"                => "0xffffff",
        "title"                 => "0x333333",
        "subtitle"              => "0x666666",
        "misc"                  => "0x999999",
        "altBorder"             => "0xffffff",
        "altBg"                 => "0xffffff",
        "altText"               => "0x666666",
        "graphText"             => "0x33485c",
        "graphTextShadow"       => "0xf9f9f9",
        "pieBorder"             => "0xffffff",
        "pieBorderHilite"       => "0x333333",
        "legendBorder"          => "0xffffff",
        "legendBg1"             => "0xffffff",
        "legendBg2"             => "0xffffff",
        "legendText"            => "0x444444",
        "legendColorKeyBorder"  => "0x777777",
        "scrollBar"             => "0xdfdfdf",
        "scrollBarBorder"       => "0xfafafa",
        "scrollBarTrack"        => "0xeeeeee",
        "scrollBarTrackBorder"  => "0xcccccc",
        );

    /**
     * Does this theme support group tabs
     *
     * @var bool
     */
    public $group_tabs;


    /**
     * Cache built of all css files locations
     *
     * @var array
     */
    private $_cssCache = array();

    /**
     * Cache built of all image files locations
     *
     * @var array
     */
    private $_imageCache = array();

    /**
     * Cache built of all javascript files locations
     *
     * @var array
     */
    private $_jsCache = array();

    /**
     * Cache built of all template files locations
     *
     * @var array
     */
    private $_templateCache = array();

	/**
	 * Cache built of sprite meta data
	 *
	 * @var array
	 */
	private $_spriteCache = array();

    /**
     * Size of the caches after the are initialized in the constructor
     *
     * @var array
     */
    private $_initialCacheSize = array(
        'cssCache'      => 0,
        'imageCache'    => 0,
        'jsCache'       => 0,
        'templateCache' => 0,
		'spriteCache'	=> 0,
        );

    /**
     * Controls whether or not to clear the cache on destroy; defaults to false
     */
    private $_clearCacheOnDestroy = false;

    private $imageExtensions = array(
            'gif',
            'png',
            'jpg',
            'tif',
            'bmp',
    );

    /**
     * Constructor
     *
     * Sets the theme properties from the defaults passed to it, and loads the file path cache from an external cache
     *
     * @param  $defaults string defaults for the current theme
     */
    public function __construct(
        $defaults
        )
    {
        // apply parent theme's properties first
        if ( isset($defaults['parentTheme']) ) {
            $themedef = array();
            include("themes/{$defaults['parentTheme']}/themedef.php");
            foreach ( $themedef as $key => $value ) {
                if ( property_exists(__CLASS__,$key) ) {
                    // For all arrays ( except colors and fonts ) you can just specify the items
                    // to change instead of all of the values
                    if ( is_array($this->$key) && !in_array($key,array('colors','fonts')) )
                        $this->$key = array_merge($this->$key,$value);
                    else
                        $this->$key = $value;
                }
            }
        }
        foreach ( $defaults as $key => $value ) {
            if ( property_exists(__CLASS__,$key) ) {
                // For all arrays ( except colors and fonts ) you can just specify the items
                // to change instead of all of the values
                if ( is_array($this->$key) && !in_array($key,array('colors','fonts')) )
                    $this->$key = array_merge($this->$key,$value);
                else
                    $this->$key = $value;
            }
        }
        if ( !inDeveloperMode() ) {
            if ( sugar_is_file($cachedfile = sugar_cached($this->getFilePath().'/pathCache.php'))) {
                $caches = unserialize(file_get_contents($cachedfile));
                if ( isset($caches['jsCache']) )
                    $this->_jsCache       = $caches['jsCache'];
                if ( isset($caches['cssCache']) )
                    $this->_cssCache      = $caches['cssCache'];
                if ( isset($caches['imageCache']) )
                    $this->_imageCache    = $caches['imageCache'];
                if ( isset($caches['templateCache']) )
                    $this->_templateCache = $caches['templateCache'];
            }
            $cachedfile = sugar_cached($this->getFilePath().'/spriteCache.php');
			if(!empty($GLOBALS['sugar_config']['use_sprites']) && sugar_is_file($cachedfile)) {
				$this->_spriteCache = unserialize(sugar_file_get_contents($cachedfile));
			}
        }
        $this->_initialCacheSize = array(
            'jsCache'       => count($this->_jsCache),
            'cssCache'      => count($this->_cssCache),
            'imageCache'    => count($this->_imageCache),
            'templateCache' => count($this->_templateCache),
			'spriteCache' 	=> count($this->_spriteCache),
            );
    }

    /**
	 * This is needed to prevent unserialize vulnerability
     */
    public function __wakeup()
    {
        // clean all properties
        foreach(get_object_vars($this) as $k => $v) {
            $this->$k = null;
        }
        throw new Exception("Not a serializable object");
    }

    /**
     * Destructor
     * Here we'll write out the internal file path caches to an external cache of some sort.
     */
    public function __destruct()
    {
        // Set the current directory to one which we expect it to be (i.e. the root directory of the install
        $dir = realpath(dirname(__FILE__) . '/../..');
        static $includePathIsPatched = false;
        if ($includePathIsPatched == false)
        {
            $path = explode(PATH_SEPARATOR, get_include_path());
            if (in_array($dir, $path) == false)
            {
                set_include_path($dir . PATH_SEPARATOR . get_include_path());
            }
            $includePathIsPatched = true;
        }
        chdir($dir); // destruct can be called late, and chdir could change
        $cachedir = sugar_cached($this->getFilePath());
        sugar_mkdir($cachedir, 0775, true);
        // clear out the cache on destroy if we are asked to
        if ( $this->_clearCacheOnDestroy ) {

            if (is_file("$cachedir/pathCache.php"))
                unlink("$cachedir/pathCache.php");
			if (is_file("$cachedir/spriteCache.php"))
				unlink("$cachedir/spriteCache.php");

        }
        elseif ( !inDeveloperMode() ) {
            // only update the caches if they have been changed in this request
            if ( count($this->_jsCache) != $this->_initialCacheSize['jsCache']
                    || count($this->_cssCache) != $this->_initialCacheSize['cssCache']
                    || count($this->_imageCache) != $this->_initialCacheSize['imageCache']
                    || count($this->_templateCache) != $this->_initialCacheSize['templateCache']
                ) {
                sugar_file_put_contents(
                    "$cachedir/pathCache.php",
                    serialize(
                        array(
                            'jsCache'       => $this->_jsCache,
                            'cssCache'      => $this->_cssCache,
                            'imageCache'    => $this->_imageCache,
                            'templateCache' => $this->_templateCache,
                            )
                        )
                    );

            }
			if ( count($this->_spriteCache) != $this->_initialCacheSize['spriteCache']) {
				sugar_file_put_contents(
					"$cachedir/spriteCache.php",
					serialize($this->_spriteCache)
				);
			}
        }
    }

    /**
     * Specifies what is returned when the object is cast to a string, in this case it will be the
     * theme directory name.
     *
     * @return string theme directory name
     */
    public function __toString()
    {
        return $this->dirName;
    }

    /**
     * Generic public accessor method for all the properties of the theme ( which are kept protected )
     *
     * @return string
     */
    public function __get(
        $key
        )
    {
        if ( isset($this->$key) )
            return $this->$key;
    }

    public function __isset($key){
    	return isset($this->$key);

    }

    public function clearJSCache()
    {
        $this->_jsCache = array();
    }

    /**
     * Clears out the caches used for this themes
     */
    public function clearCache()
    {
        $this->_clearCacheOnDestroy = true;
    }

    /**
     * Return array of all valid fields that can be specified in the themedef.php file
     *
     * @return array
     */
    public static function getThemeDefFields()
    {
        return array(
            'name',
            'description',
            'directionality',
            'dirName',
            'parentTheme',
            'version',
            'colors',
            'fonts',
            'barChartColors',
            'pieChartColors',
            'group_tabs',
            'ignoreParentFiles',
            );
    }

    /**
     * Returns the file path of the current theme
     *
     * @return string
     */
    public function getFilePath()
    {
        return 'themes/'.$this->dirName;
    }

    /**
     * Returns the image path of the current theme
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->getFilePath().'/images';
    }

    /**
     * Returns the css path of the current theme
     *
     * @return string
     */
    public function getCSSPath()
    {
        return $this->getFilePath().'/css';
    }

    /**
     * Returns the javascript path of the current theme
     *
     * @return string
     */
    public function getJSPath()
    {
        return $this->getFilePath().'/js';
    }

    /**
     * Returns the tpl path of the current theme
     *
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->getFilePath().'/tpls';
    }

    /**
     * Returns the file path of the theme defaults
     *
     * @return string
     */
    public final function getDefaultFilePath()
    {
        return 'themes/default';
    }

    /**
     * Returns the image path of the theme defaults
     *
     * @return string
     */
    public final function getDefaultImagePath()
    {
        return $this->getDefaultFilePath().'/images';
    }

    /**
     * Returns the css path of the theme defaults
     *
     * @return string
     */
    public final function getDefaultCSSPath()
    {
        return $this->getDefaultFilePath().'/css';
    }

    /**
     * Returns the template path of the theme defaults
     *
     * @return string
     */
    public final function getDefaultTemplatePath()
    {
        return $this->getDefaultFilePath().'/tpls';
    }

    /**
     * Returns the javascript path of the theme defaults
     *
     * @return string
     */
    public final function getDefaultJSPath()
    {
        return $this->getDefaultFilePath().'/js';
    }

    /**
     * Returns CSS for the current theme.
     *
     * @param  $color string optional, specifies the css color file to use if the theme supports it; defaults to cookie value or theme default
     * @param  $font  string optional, specifies the css font file to use if the theme supports it; defaults to cookie value or theme default
     * @return string HTML code
     */
    public function getCSS(
        $color = null,
        $font = null
        )
    {
        // include style.css file
        $html = '<link rel="stylesheet" type="text/css" href="'.$this->getCSSURL('yui.css').'" />';
        $html .= '<link rel="stylesheet" type="text/css" href="include/javascript/jquery/themes/base/jquery.ui.all.css" />';
        $html .= '<link rel="stylesheet" type="text/css" href="'.$this->getCSSURL('deprecated.css').'" />';
        $html .= '<link rel="stylesheet" type="text/css" href="'.$this->getCSSURL('style.css').'" />';

		// sprites
		if(!empty($GLOBALS['sugar_config']['use_sprites']) && $GLOBALS['sugar_config']['use_sprites']) {

			// system wide sprites
			if(file_exists("cache/sprites/default/sprites.css"))
				$html .= '<link rel="stylesheet" type="text/css" href="'.getJSPath('cache/sprites/default/sprites.css').'" />';

			// theme specific sprites
			if(file_exists("cache/sprites/{$this->dirName}/sprites.css"))
				$html .= '<link rel="stylesheet" type="text/css" href="'.getJSPath('cache/sprites/'.$this->dirName.'/sprites.css').'" />';

			// parent sprites
			if($this->parentTheme && $parent = SugarThemeRegistry::get($this->parentTheme)) {
				if(file_exists("cache/sprites/{$parent->dirName}/sprites.css"))
					$html .= '<link rel="stylesheet" type="text/css" href="'.getJSPath('cache/sprites/'.$parent->dirName.'/sprites.css').'" />';
			}

			// repeatable sprites
			if(file_exists("cache/sprites/Repeatable/sprites.css"))
				$html .= '<link rel="stylesheet" type="text/css" href="'.getJSPath('cache/sprites/Repeatable/sprites.css').'" />';
		}

        // for BC during upgrade
        if ( !empty($this->colors) ) {
            if ( isset($_SESSION['authenticated_user_theme_color']) && in_array($_SESSION['authenticated_user_theme_color'], $this->colors))
                $color = $_SESSION['authenticated_user_theme_color'];
            else
                $color = $this->colors[0];
            $html .= '<link rel="stylesheet" type="text/css" href="'.$this->getCSSURL('colors.'.$color.'.css').'" id="current_color_style" />';
        }

        if ( !empty($this->fonts) ) {
            if ( isset($_SESSION['authenticated_user_theme_font']) && in_array($_SESSION['authenticated_user_theme_font'], $this->fonts))
                $font = $_SESSION['authenticated_user_theme_font'];
            else
                $font = $this->fonts[0];
            $html .= '<link rel="stylesheet" type="text/css" href="'.$this->getCSSURL('fonts.'.$font.'.css').'" id="current_font_style" />';
        }

        return $html;
    }

    /**
     * Returns javascript for the current theme
     *
     * @return string HTML code
     */
    public function getJS()
    {
        $styleJS = $this->getJSURL('style.js');
        return <<<EOHTML
<script type="text/javascript" src="$styleJS"></script>
EOHTML;
    }

    /**
     * Returns the path for the tpl file in the current theme. If not found in the current theme, will revert
     * to looking in the base theme.
     *
     * @param  string $templateName tpl file name
     * @return string path of tpl file to include
     */
    public function getTemplate(
        $templateName
        )
    {
        if ( isset($this->_templateCache[$templateName]) )
            return $this->_templateCache[$templateName];

        $templatePath = '';
        if (sugar_is_file('custom/'.$this->getTemplatePath().'/'.$templateName))
            $templatePath = 'custom/'.$this->getTemplatePath().'/'.$templateName;
        elseif (sugar_is_file($this->getTemplatePath().'/'.$templateName))
            $templatePath = $this->getTemplatePath().'/'.$templateName;
        elseif (isset($this->parentTheme)
                && SugarThemeRegistry::get($this->parentTheme) instanceOf SugarTheme
                && ($filename = SugarThemeRegistry::get($this->parentTheme)->getTemplate($templateName)) != '')
            $templatePath = $filename;
        elseif (sugar_is_file('custom/'.$this->getDefaultTemplatePath().'/'.$templateName))
            $templatePath = 'custom/'.$this->getDefaultTemplatePath().'/'.$templateName;
        elseif (sugar_is_file($this->getDefaultTemplatePath().'/'.$templateName))
            $templatePath = $this->getDefaultTemplatePath().'/'.$templateName;
        else {
            $GLOBALS['log']->warn("Template $templateName not found");
            return false;
        }

        $this->_imageCache[$templateName] = $templatePath;

        return $templatePath;
    }

    /**
     * Returns an image tag for the given image.
     *
     * @param  string $image image name
     * @param  string $other_attributes optional, other attributes to add to the image tag, not cached
	 * @param  string $width optional, defaults to the actual image's width
	 * @param  string $height optional, defaults to the actual image's height
	 * @param  string $ext optional, image extension (TODO can we deprecate this one ?)
     * @param  string $alt optional, only used when image contains something useful, i.e. "Sally's profile pic"
     * @return string HTML image tag or sprite
     */
    public function getImage(
        $imageName,
        $other_attributes = '',
		$width = null,
		$height = null,
		$ext = null,
        $alt = ''
    )
    {

        static $cached_results = array();

		// trap deprecated use of image extension
		if(is_null($ext)) {
			$imageNameExp = explode('.',$imageName);
			if(count($imageNameExp) == 1)
				$imageName .= '.gif';
		} else {
			$imageName .= $ext;
		}

		// trap alt attributes in other_attributes
		if(preg_match('/alt=["\']([^\'"]+)["\']/i', $other_attributes))
			$GLOBALS['log']->debug("Sprites: alt attribute detected for $imageName");
		// sprite handler, makes use of own caching mechanism
		if(!empty($GLOBALS['sugar_config']['use_sprites']) && $GLOBALS['sugar_config']['use_sprites']) {
			// get sprite metadata
			if($sp = $this->getSpriteMeta($imageName)) {
				// requested size should match
				if( (!is_null($width) && $sp['width'] == $width) || (is_null($width)) &&
					(!is_null($height) && $sp['height'] == $height) || (is_null($height)) )
				{
                    $other_attributes .= ' data-orig="'.$imageName.'"';

                     if($sprite = $this->getSprite($sp['class'], $other_attributes, $alt))
                     {
                         return $sprite;
                     }
				}
			}
		}

		// img caching
		if(empty($cached_results[$imageName])) {
			$imageURL = $this->getImageURL($imageName,false);
			if ( empty($imageURL) )
				return false;
	        $cached_results[$imageName] = '<img src="'.getJSPath($imageURL).'" ';
		}

		$attr_width = (is_null($width)) ? "" : "width=\"$width\"";
		$attr_height = (is_null($height)) ? "" : "height=\"$height\"";
		return $cached_results[$imageName] . " $attr_width $attr_height $other_attributes alt=\"$alt\" />";
    }

	/**
	 * Returns sprite meta data
	 *
	 * @param  string $imageName Image filename including extension
	 * @return array  Sprite meta data
	 */
	public function getSpriteMeta($imageName) {

		// return from cache
	    if(isset($this->_spriteCache[$imageName]))
			return $this->_spriteCache[$imageName];

			// sprite keys are base on imageURL
		$imageURL = $this->getImageURL($imageName,false);
		if(empty($imageURL)) {
			$this->_spriteCache[$imageName] = false;
			return false;
		}

		// load meta data, includes default images
		require_once("include/SugarTheme/SugarSprites.php");
		$meta = SugarSprites::getInstance();
		// add current theme dir
		$meta->loadSpriteMeta($this->dirName);
		// add parent theme dir
		if($this->parentTheme && $parent = SugarThemeRegistry::get($this->parentTheme)) {
			$meta->loadSpriteMeta($parent->dirName);
		}

		// add to cache
		if(isset($meta->sprites[$imageURL])) {
			$this->_spriteCache[$imageName] = $meta->sprites[$imageURL];
			// add imageURL to cache
			//$this->_spriteCache[$imageName]['imageURL'] = $imageURL;
		} else {
			$this->_spriteCache[$imageName] = false;
			$GLOBALS['log']->debug("Sprites: miss for $imageURL");
		}
		return $this->_spriteCache[$imageName];
	}

	/**
	 * Returns sprite HTML span tag
	 *
	 * @param  string class The md5 id used in the CSS sprites class
	 * @param  string attr  optional, list of additional html attributes
	 * @param  string title optional, the title (equivalent to alt on img)
	 * @return string HTML span tag
	 */
	public function getSprite($class, $attr, $title) {

		// handle multiple class tags
		$class_regex = '/class=["\']([^\'"]+)["\']/i';
		preg_match($class_regex, $attr, $match);
		if(isset($match[1])) {
			$attr = preg_replace($class_regex, 'class="spr_'.$class.' ${1}"', $attr);

		// single class
		} else {
			$attr .= ' class="spr_'.$class.'"';
		}

		if($title)
			$attr .= ' title="'.$title.'"';

		// use </span> instead of /> to prevent weird UI results
		$GLOBALS['log']->debug("Sprites: generated sprite -> $attr");
		return "<span {$attr}></span>";
	}

	/**
	 * Returns a link HTML tag with or without an embedded image
	 */
    public function getLink(
		$url,
		$title,
		$other_attributes = '',
        $img_name = '',
        $img_other_attributes = '',
		$img_width = null,
		$img_height = null,
		$img_alt = '',
		$img_placement = 'imageonly'
    )
    {

		if($img_name) {
			$img = $this->getImage($img_name, $img_other_attributes, $img_width, $img_height, null, $img_alt);
			if($img == false) {
				$GLOBALS['log']->debug('Sprites: unknown image getLink');
				$img = 'unknown';
			}
			switch($img_placement) {
				case 'left': 	$inner_html = $img."<span class='title'>".$title."</span>"; break;
				case 'right':	$inner_html = "<span class='title'>".$title."</span>".$img; break;
				default:		$inner_html = $img; break;
			}
		} else {
			$inner_html = $title;
		}

		return '<a href="'.$url.'" title="'.$title.'" '.$other_attributes.'>'.$inner_html.'</a>';

	}

    /**
     * Returns the URL for an image in the current theme. If not found in the current theme, will revert
     * to looking in the base theme.
     * @param  string $imageName image file name
     * @param  bool   $addJSPath call getJSPath() with the results to add some unique image tracking support
     * @return string path to image
     */
    public function getImageURL(
        $imageName,
        $addJSPath = true
        ){
        if ( isset($this->_imageCache[$imageName]) ) {
            if ( $addJSPath )
                return getJSPath($this->_imageCache[$imageName]);
            else
                return $this->_imageCache[$imageName];
        }
        $imagePath = '';
        if (($filename = $this->_getImageFileName('custom/'.$this->getImagePath().'/'.$imageName)) != '')
            $imagePath = $filename;
        elseif (($filename = $this->_getImageFileName($this->getImagePath().'/'.$imageName)) != '')
            $imagePath = $filename;
        elseif (isset($this->parentTheme)
                && SugarThemeRegistry::get($this->parentTheme) instanceOf SugarTheme
                && ($filename = SugarThemeRegistry::get($this->parentTheme)->getImageURL($imageName,false)) != '')
            $imagePath = $filename;
        elseif (($filename = $this->_getImageFileName('custom/'.$this->getDefaultImagePath().'/'.$imageName)) != '')
            $imagePath = $filename;
        elseif (($filename = $this->_getImageFileName($this->getDefaultImagePath().'/'.$imageName)) != '')
            $imagePath = $filename;
		elseif (($filename = $this->_getImageFileName('include/images/'.$imageName)) != '')
			$imagePath = $filename;
        else {
            $GLOBALS['log']->warn("Image $imageName not found");
            return false;
        }

        $this->_imageCache[$imageName] = $imagePath;

        if ( $addJSPath )
            return getJSPath($imagePath);

        return $imagePath;
    }

    /**
     * Checks for an image using all of the accepted image extensions
     *
     * @param  string $imageName image file name
     * @return string path to image
     */
    protected function _getImageFileName(
        $imageName
        )
    {
        // return now if the extension matches that of which we are looking for
        if ( sugar_is_file($imageName) )
            return $imageName;
        $pathParts = pathinfo($imageName);
        foreach ( $this->imageExtensions as $extension )
            if ( isset($pathParts['extension']) )
                if ( ( $extension != $pathParts['extension'] )
                        && sugar_is_file($pathParts['dirname'].'/'.$pathParts['filename'].'.'.$extension) )
                    return $pathParts['dirname'].'/'.$pathParts['filename'].'.'.$extension;

        return '';
    }

    /**
     * Returns the URL for the css file in the current theme. If not found in the current theme, will revert
     * to looking in the base theme.
     *
     * @param  string $cssFileName css file name
     * @param  bool   $returnURL if true, returns URL with unique image mark, otherwise returns path to the file
     * @return string path of css file to include
     */
    public function getCSSURL($cssFileName, $returnURL = true)
    {
        if ( isset($this->_cssCache[$cssFileName]) && sugar_is_file(sugar_cached($this->_cssCache[$cssFileName])) ) {
            if ( $returnURL )
                return getJSPath("cache/".$this->_cssCache[$cssFileName]);
            else
                return sugar_cached($this->_cssCache[$cssFileName]);
        }

        $cssFileContents = '';
        $defaultFileName = $this->getDefaultCSSPath().'/'.$cssFileName;
        $fullFileName = $this->getCSSPath().'/'.$cssFileName;
        if (isset($this->parentTheme)
                && SugarThemeRegistry::get($this->parentTheme) instanceOf SugarTheme
                && ($filename = SugarThemeRegistry::get($this->parentTheme)->getCSSURL($cssFileName,false)) != '')
            $cssFileContents .= file_get_contents($filename);
        else {
            if (sugar_is_file($defaultFileName))
                $cssFileContents .= file_get_contents($defaultFileName);
            if (sugar_is_file('custom/'.$defaultFileName))
                $cssFileContents .= file_get_contents('custom/'.$defaultFileName);
        }
        if (sugar_is_file($fullFileName)) {
            $cssFileContents .= file_get_contents($fullFileName);
        }
        if (sugar_is_file('custom/'.$fullFileName)) {
            $cssFileContents .= file_get_contents('custom/'.$fullFileName);
        }
        if (empty($cssFileContents)) {
            $GLOBALS['log']->warn("CSS File $cssFileName not found");
            return false;
        }

        // fix any image references that may be defined in css files
        $cssFileContents = str_ireplace("entryPoint=getImage&",
            "entryPoint=getImage&themeName={$this->dirName}&",
            $cssFileContents);

        // create the cached file location
        $cssFilePath = create_cache_directory($fullFileName);

        // if this is the style.css file, prepend the base.css and calendar-win2k-cold-1.css
        // files before the theme styles
        if ( $cssFileName == 'style.css' && !isset($this->parentTheme) ) {
            if ( inDeveloperMode() )
                $cssFileContents = file_get_contents('include/javascript/yui/build/base/base.css') . $cssFileContents;
            else
                $cssFileContents = file_get_contents('include/javascript/yui/build/base/base-min.css') . $cssFileContents;
        }

        // minify the css
        if ( !inDeveloperMode() && !sugar_is_file($cssFilePath) ) {
            $cssFileContents = cssmin::minify($cssFileContents);
        }

        // now write the css to cache
        sugar_file_put_contents($cssFilePath,$cssFileContents);

        $this->_cssCache[$cssFileName] = $fullFileName;

        if ( $returnURL )
            return getJSPath("cache/".$fullFileName);

        return sugar_cached($fullFileName);
    }

    /**
     * Returns the URL for an image in the current theme. If not found in the current theme, will revert
     * to looking in the base theme.
     *
     * @param  string $jsFileName js file name
     * @param  bool   $returnURL if true, returns URL with unique image mark, otherwise returns path to the file
     * @return string path to js file
     */
    public function getJSURL($jsFileName, $returnURL = true)
    {
        if ( isset($this->_jsCache[$jsFileName]) && sugar_is_file(sugar_cached($this->_jsCache[$jsFileName])) ) {
            if ( $returnURL )
                return getJSPath("cache/".$this->_jsCache[$jsFileName]);
            else
                return sugar_cached($this->_jsCache[$jsFileName]);
        }

        $jsFileContents = '';
        $fullFileName = $this->getJSPath().'/'.$jsFileName;
        $defaultFileName = $this->getDefaultJSPath().'/'.$jsFileName;
        if (isset($this->parentTheme)
                && SugarThemeRegistry::get($this->parentTheme) instanceOf SugarTheme
                && ($filename = SugarThemeRegistry::get($this->parentTheme)->getJSURL($jsFileName,false)) != ''    && !in_array($jsFileName,$this->ignoreParentFiles)) {
           $jsFileContents .= file_get_contents($filename);
       } else {
            if (sugar_is_file($defaultFileName))
                $jsFileContents .= file_get_contents($defaultFileName);
            if (sugar_is_file('custom/'.$defaultFileName))
                $jsFileContents .= file_get_contents('custom/'.$defaultFileName);
        }
        if (sugar_is_file($fullFileName))
            $jsFileContents .= file_get_contents($fullFileName);
        if (sugar_is_file('custom/'.$fullFileName))
            $jsFileContents .= file_get_contents('custom/'.$fullFileName);
        if (empty($jsFileContents)) {
            $GLOBALS['log']->warn("Javascript File $jsFileName not found");
            return false;
        }

        // create the cached file location
        $jsFilePath = create_cache_directory($fullFileName);

        // minify the js
        if ( !inDeveloperMode()&& !sugar_is_file(str_replace('.js','-min.js',$jsFilePath)) ) {
            $jsFileContents = SugarMin::minify($jsFileContents);
            $jsFilePath = str_replace('.js','-min.js',$jsFilePath);
            $fullFileName = str_replace('.js','-min.js',$fullFileName);
        }

        // now write the js to cache
        sugar_file_put_contents($jsFilePath,$jsFileContents);

        $this->_jsCache[$jsFileName] = $fullFileName;

        if ( $returnURL )
            return getJSPath("cache/".$fullFileName);

        return sugar_cached($fullFileName);
    }

    /**
     * Returns an array of all of the images available for the current theme
     *
     * @return array
     */
    public function getAllImages()
    {
        // first, lets get all the paths of where to look
        $pathsToSearch = array($this->getImagePath());
        $theme = $this;
        while (isset($theme->parentTheme) && SugarThemeRegistry::get($theme->parentTheme) instanceOf SugarTheme ) {
            $theme = SugarThemeRegistry::get($theme->parentTheme);
            $pathsToSearch[] = $theme->getImagePath();
        }
        $pathsToSearch[] = $this->getDefaultImagePath();

        // now build the array
        $imageArray = array();
        foreach ( $pathsToSearch as $path )
        {
            if (!sugar_is_dir($path)) $path = "custom/$path";
            if (sugar_is_dir($path) && is_readable($path) && $dir = opendir($path)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file == ".."
                            || $file == "."
                            || $file == ".svn"
                            || $file == "CVS"
                            || $file == "Attic"
                            )
                        continue;
                    if ( !isset($imageArray[$file]) )
                        $imageArray[$file] = $this->getImageURL($file,false);
                }
                closedir($dir);
            }
        }

        ksort($imageArray);

        return $imageArray;
    }

}

/**
 * Registry for all the current classes in the system
 */
class SugarThemeRegistry
{
    /**
     * Array of all themes and thier object
     *
     * @var array
     */
    private static $_themes = array();

    /**
     * Name of the current theme; corresponds to an index key in SugarThemeRegistry::$_themes
     *
     * @var string
     */
    private static $_currentTheme;

    /**
     * Disable the constructor since this will be a singleton
     */
    private function __construct() {}

    /**
     * Adds a new theme to the registry
     *
     * @param $themedef array
     */
    public static function add(
        array $themedef
        )
    {
        // make sure the we know the sugar version
        global $sugar_version;
        if (empty($sugar_version))
        {
            include('sugar_version.php');
        }

        // Assume theme is designed for 5.5.x if not specified otherwise
        if ( !isset($themedef['version']) )
            $themedef['version']['regex_matches'] = array('5\.5\.*');

        // Check to see if theme is valid for this version of Sugar; return false if not
        $version_ok = false;
        if( isset($themedef['version']['exact_matches']) ){
            $matches_empty = false;
            foreach( $themedef['version']['exact_matches'] as $match ){
                if( $match == $GLOBALS['sugar_version'] ){
                    $version_ok = true;
                }
            }
        }
        if( !$version_ok && isset($themedef['version']['regex_matches']) ){
            $matches_empty = false;
            foreach( $themedef['version']['regex_matches'] as $match ){
                if( preg_match( "/$match/", $GLOBALS['sugar_version'] ) ){
                    $version_ok = true;
                }
            }
        }
        if ( !$version_ok )
            return false;

        $theme = new SugarTheme($themedef);
        self::$_themes[$theme->dirName] = $theme;
    }

    /**
     * Removes a new theme from the registry
     *
     * @param $themeName string
     */
    public static function remove(
        $themeName
        )
    {
        if ( self::exists($themeName) )
            unset(self::$_themes[$themeName]);
    }

    /**
     * Returns a theme object in the registry specified by the given $themeName
     *
     * @param $themeName string
     */
    public static function get(
        $themeName
        )
    {
        if ( isset(self::$_themes[$themeName]) )
            return self::$_themes[$themeName];
    }

    /**
     * Returns the current theme object
     *
     * @return SugarTheme object
     */
    public static function current()
    {
        if ( !isset(self::$_currentTheme) )
            self::buildRegistry();

        return self::$_themes[self::$_currentTheme];
    }

    /**
     * Returns the default theme object
     *
     * @return SugarTheme object
     */
    public static function getDefault()
    {
        if ( !isset(self::$_currentTheme) )
            self::buildRegistry();

        if ( isset($GLOBALS['sugar_config']['default_theme']) && self::exists($GLOBALS['sugar_config']['default_theme']) ) {
            return self::get($GLOBALS['sugar_config']['default_theme']);
        }

        return self::get(array_pop(array_keys(self::availableThemes())));
    }

    /**
     * Returns true if a theme object specified by the given $themeName exists in the registry
     *
     * @param  $themeName string
     * @return bool
     */
    public static function exists(
        $themeName
        )
    {
        return (self::get($themeName) !== null);
    }

    /**
     * Sets the given $themeName to be the current theme
     *
     * @param  $themeName string
     */
    public static function set(
        $themeName
        )
    {
        if ( !self::exists($themeName) )
            return false;

        self::$_currentTheme = $themeName;

        // set some of the expected globals
        $GLOBALS['barChartColors'] = self::current()->barChartColors;
        $GLOBALS['pieChartColors'] = self::current()->pieChartColors;
        return true;
    }

    /**
     * Builds the theme registry
     */
    public static function buildRegistry()
    {
        self::$_themes = array();
        $dirs = array("themes/","custom/themes/");

        // check for a default themedef file
        $themedefDefault = array();
        if ( sugar_is_file("custom/themes/default/themedef.php") ) {
            $themedef = array();
            require("custom/themes/default/themedef.php");
            $themedefDefault = $themedef;
        }

        foreach ($dirs as $dirPath ) {
            if (sugar_is_dir('./'.$dirPath) && is_readable('./'.$dirPath) && $dir = opendir('./'.$dirPath)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file == ".."
                            || $file == "."
                            || $file == ".svn"
                            || $file == "CVS"
                            || $file == "Attic"
                            || $file == "default"
                            || !sugar_is_dir("./$dirPath".$file)
                            || !sugar_is_file("./{$dirPath}{$file}/themedef.php")
                            )
                        continue;
                    $themedef = array();
                    require("./{$dirPath}{$file}/themedef.php");
                    $themedef = array_merge($themedef,$themedefDefault);
                    $themedef['dirName'] = $file;
                    // check for theme already existing in the registry
                    // if so, then it will override the current one
                    if ( self::exists($themedef['dirName']) ) {
                        $existingTheme = self::get($themedef['dirName']);
                        foreach ( SugarTheme::getThemeDefFields() as $field )
                            if ( !isset($themedef[$field]) )
                                $themedef[$field] = $existingTheme->$field;
                        self::remove($themedef['dirName']);
                    }
                    if ( isset($themedef['name']) ) {
                        self::add($themedef);
                    }
                }
                closedir($dir);
            }
        }
        // default to setting the default theme as the current theme
        if ( !isset($GLOBALS['sugar_config']['default_theme']) || !self::set($GLOBALS['sugar_config']['default_theme']) ) {
            if ( count(self::availableThemes()) == 0 )
            {
                sugar_die('No valid themes are found on this instance');
            } else {
                self::set(self::getDefaultThemeKey());
            }
        }
    }


    /**
     * getDefaultThemeKey
     *
     * This function returns the default theme key.  It takes into account string casing issues that may arise
     * from upgrades.  It attempts to look for the Sugar theme and if not found, defaults to return the name of the last theme
     * in the array of available themes loaded.
     *
     * @return $defaultThemeKey String value of the default theme key to use
     */
    private static function getDefaultThemeKey()
    {
        $availableThemes = self::availableThemes();
        foreach($availableThemes as $key=>$theme)
        {
            if(strtolower($key) == 'sugar')
            {
                return $key;
            }
        }

        return array_pop(array_keys($availableThemes));
    }


    /**
     * Returns an array of available themes. Designed to be absorbed into get_select_options_with_id()
     *
     * @return array
     */
    public static function availableThemes()
    {
        $themelist = array();
        $disabledThemes = array();
        if ( isset($GLOBALS['sugar_config']['disabled_themes']) )
            $disabledThemes = explode(',',$GLOBALS['sugar_config']['disabled_themes']);

        foreach ( self::$_themes as $themename => $themeobject ) {
            if ( in_array($themename,$disabledThemes) )
                continue;
            $themelist[$themeobject->dirName] = $themeobject->name;
        }
        asort($themelist, SORT_STRING);
        return $themelist;
    }

    /**
     * Returns an array of un-available themes. Designed used with the theme selector in the admin panel
     *
     * @return array
     */
    public static function unAvailableThemes()
    {
        $themelist = array();
        $disabledThemes = array();
        if ( isset($GLOBALS['sugar_config']['disabled_themes']) )
            $disabledThemes = explode(',',$GLOBALS['sugar_config']['disabled_themes']);

        foreach ( self::$_themes as $themename => $themeobject ) {
            if ( in_array($themename,$disabledThemes) )
                $themelist[$themeobject->dirName] = $themeobject->name;
        }

        return $themelist;
    }

    /**
     * Returns an array of all themes found in the current installation
     *
     * @return array
     */
    public static function allThemes()
    {
        $themelist = array();

        foreach ( self::$_themes as $themename => $themeobject )
            $themelist[$themeobject->dirName] = $themeobject->name;

        return $themelist;
    }

    /**
     * Clears out the cached path locations for all themes
     */
    public static function clearAllCaches()
    {
        foreach ( self::$_themes as $themeobject ) {
            $themeobject->clearCache();
        }
    }
}
