<?php

namespace SuiteCRM;

/**
 * Class SugarCleaner
 * @package SuiteCRM
 * Html Sanitizer
 */
class HtmlSanitizer
{
    /**
     * Singleton instance
     * @var HtmlSanitizer
     */
    private static $instance;

    /**
     * HTMLPurifier instance
     * @var \HTMLPurifier
     */
    protected $purifier;

    /**
     * SugarCleaner constructor.
     */
    public function __construct()
    {
        $configurator = new \Configurator();
        $sugar_config = $configurator->config;


        $config = \HTMLPurifier_Config::createDefault();

        if (!is_dir(sugar_cached("htmlclean"))) {
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
        $config->set('Filter.ExtractStyleBlocks.TidyImpl', false);
        if (!empty($sugar_config['html_allow_objects'])) {
            $config->set('HTML.SafeObject', true);
            $config->set('HTML.SafeEmbed', true);
        }
        $config->set('Output.FlashCompat', true);
        $config->set('Filter.Custom', array(new HTMLPurifierFilterXmp()));
        $config->set('HTML.DefinitionID', 'Sugar HTML Def');
        $config->set('HTML.DefinitionRev', 2);
        $config->set('Cache.SerializerPath', sugar_cached('htmlclean/'));
        $config->set('Attr.EnableID', true);
        $config->set('Attr.IDPrefix', 'sugar_text_');

        if ($def = $config->maybeGetRawHTMLDefinition()) {
            $iframe = $def->addElement(
                'iframe',
                'Flow',
                'Optional: #PCDATA | Flow | Block',
                'Core',
                array(
                    'src*' => 'URI',
                    'frameborder' => 'Enum#0,1',
                    'marginwidth' => 'Pixels',
                    'marginheight' => 'Pixels',
                    'scrolling' => 'Enum#|yes,no,auto',
                    'align' => 'Enum#top,middle,bottom,left,right,center',
                    'height' => 'Length',
                    'width' => 'Length',
                )
            );

            $iframe->excludes = array('iframe');
        }

        /** @var \HTMLPurifier_URIDefinition $uri */
        $uri = $config->getDefinition('URI');
        $uri->addFilter(new URIFilter(), $config);
        \HTMLPurifier_URISchemeRegistry::instance()->register('cid', new HTMLPurifierURISchemeCid());

        $this->purifier = new \HTMLPurifier($config);
    }

    /**
     * Get cleaner instance
     * @return HtmlSanitizer
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Clean string from potential XSS problems
     * @param string $dirtyHtml
     * @param bool $removeHtml - remove encoded html
     * @return string clean html
     */
    public static function cleanHtml($dirtyHtml, $removeHtml = false)
    {
        // $encode_html previously effected the decoding process.
        // we should decode regardless, just in case, the calling method passing encoded html
        $dirty_html_decoded = html_entity_decode($dirtyHtml);

        // Re-encode html
        if ($removeHtml === true) {
            // remove all HTML tags
            $sugarCleaner = new HtmlSanitizer();
            $purifier = $sugarCleaner->purifier;
            $clean_html = $purifier->purify($dirty_html_decoded);
        } else {
            // encode all HTML tags
            $clean_html = $dirty_html_decoded;
        }

        return $clean_html;
    }

    /**
     * @param $dirtyHtml
     * @param bool $isEncoded
     * @return string
     */
    public static function stripTags($dirtyHtml, $isEncoded = true)
    {
        if ($isEncoded) {
            $dirtyHtml = from_html($dirtyHtml);
        }
        $dirtyHtml = filter_var($dirtyHtml, FILTER_SANITIZE_STRIPPED, FILTER_FLAG_NO_ENCODE_QUOTES);
        return $isEncoded ? to_html($dirtyHtml) : $dirtyHtml;
    }
}


