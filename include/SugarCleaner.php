<?php

namespace SuiteCRM;

class SugarCleaner
{
    /**
     * Singleton instance
     * @var SugarCleaner
     */
    private static $instance;

    /**
     * HTMLPurifier instance
     * @var HTMLPurifier
     */
    protected $purifier;

    function __construct()
    {
        global $sugar_config;
        $config = HTMLPurifier_Config::createDefault();

        if(!is_dir(sugar_cached("htmlclean"))) {
            create_cache_directory("htmlclean/");
        }
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        $config->set('Core.Encoding', 'UTF-8');
        $hidden_tags = array('script' => true, 'style' => true, 'title' => true, 'head' => true);
        $config->set('Core.HiddenElements', $hidden_tags);
        $config->set('Cache.SerializerPath', sugar_cached("htmlclean"));
        $config->set('URI.Base', isset($sugar_config['site_url']) ? $sugar_config['site_url'] : null);
        $config->set('CSS.Proprietary', true);
        $config->set('HTML.TidyLevel', 'light');
        $config->set('HTML.ForbiddenElements', array('body' => true, 'html' => true));
        $config->set('AutoFormat.RemoveEmpty', true);
        $config->set('Cache.SerializerPermissions', 0775);
        // for style
        //$config->set('Filter.ExtractStyleBlocks', true);
        $config->set('Filter.ExtractStyleBlocks.TidyImpl', false); // can't use csstidy, GPL
        if(!empty($GLOBALS['sugar_config']['html_allow_objects'])) {
            // for object
            $config->set('HTML.SafeObject', true);
            // for embed
            $config->set('HTML.SafeEmbed', true);
        }
        $config->set('Output.FlashCompat', true);
        // for iframe and xmp
        $config->set('Filter.Custom',  array(new HTMLPurifier_Filter_Xmp()));
        // for link
        $config->set('HTML.DefinitionID', 'Sugar HTML Def');
        $config->set('HTML.DefinitionRev', 2);
        $config->set('Cache.SerializerPath', sugar_cached('htmlclean/'));
        // IDs are namespaced
        $config->set('Attr.EnableID', true);
        $config->set('Attr.IDPrefix', 'sugar_text_');

        if ($def = $config->maybeGetRawHTMLDefinition()) {
            $form = $def->addElement(
                'link',   // name
                'Flow',  // content set
                'Empty', // allowed children
                'Core', // attribute collection
                array( // attributes
                    'href*' => 'URI',
                    'rel' => 'Enum#stylesheet', // only stylesheets supported here
                    'type' => 'Enum#text/css' // only CSS supported here
                )
            );
            $iframe = $def->addElement(
                'iframe',   // name
                'Flow',  // content set
                'Optional: #PCDATA | Flow | Block', // allowed children
                'Core', // attribute collection
                array( // attributes
                    'src*' => 'URI',
                    'frameborder' => 'Enum#0,1',
                    'marginwidth' =>  'Pixels',
                    'marginheight' =>  'Pixels',
                    'scrolling' => 'Enum#|yes,no,auto',
                    'align' => 'Enum#top,middle,bottom,left,right,center',
                    'height' => 'Length',
                    'width' => 'Length',
                )
            );
            $iframe->excludes=array('iframe');
        }
        $uri = $config->getDefinition('URI');
        $uri->addFilter(new SugarURIFilter(), $config);
        HTMLPurifier_URISchemeRegistry::instance()->register('cid', new HTMLPurifier_URIScheme_cid());

        $this->purifier = new HTMLPurifier($config);
    }

    /**
     * Get cleaner instance
     * @return SugarCleaner
     */
    public static function getInstance()
    {
        return self::$instance instanceof self ? self::$instance : (self::$instance = new self());
    }

    /**
     * Clean string from potential XSS problems
     * @param string $dirty_html
     * @param bool $remove_html - encodes html
     * @return string
     */
    public static function cleanHtml($dirty_html, $remove_html = false)
    {

        // $encode_html previously effected the decoding process.
        // we should decode regardless, just in case, the calling method passing encoded html
        $dirty_html_decoded = html_entity_decode($dirty_html);

        // Re-encode html
        if ($remove_html === true) {
            // remove all HTML tags
            $sugarCleaner = new SugarCleaner();
            $purifier = $sugarCleaner->purifier;
            $clean_html = $purifier->purify($dirty_html_decoded);
        } else {
            // encode all HTML tags
            $clean_html = $dirty_html_decoded;
        }

        return $clean_html;
    }

    static public function stripTags($string, $encoded = true)
    {
        if($encoded) {
            $string = from_html($string);
        }
        $string = filter_var($string, FILTER_SANITIZE_STRIPPED, FILTER_FLAG_NO_ENCODE_QUOTES);
        return $encoded?to_html($string):$string;
    }
}


