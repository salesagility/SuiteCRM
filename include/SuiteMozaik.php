<?php

class SuiteMozaik {

    private $mozaikPath = 'include/javascript/mozaik';
    private $vendorPath;

    private static $defaultThumbnails = array(
        'headline' => array(
            //'thumbnail' => 'tpls/default/thumbs/headline.png',
            'label' => 'Headline',
            //'tpl' => 'tpls/default/headline.html',
            'tpl' => 'string:<p><h1>Add your headline here..</h1></p>',
        ),
        'content' => array(
            //'thumbnail' => 'tpls/default/thumbs/content1.png',
            'label' => 'Content',
            //'tpl' => 'tpls/default/content1.html',
            'tpl' => 'string:<p>Put your contents here...</p>',
        ),
        'footer' => array(
            //'thumbnail' => 'tpls/default/thumbs/footer.png',
            'label' => 'Footer',
            //'tpl' => 'tpls/default/footer.html',
            'tpl' => 'string:<p class="footer">Take your footer contents and information here..</p>',
        ),
    );

    public function __construct() {
        $this->vendorPath = $this->mozaikPath . '/vendor';
    }

    public function getDependenciesHTML() {
        $html = <<<HTML
<link rel="stylesheet" href="{$this->vendorPath}/components/jqueryui/themes/ui-lightness/jquery-ui.min.css">
<!--
<script src='{$this->vendorPath}/components/jquery/jquery.min.js'></script>
-->
<script src="{$this->vendorPath}/components/jqueryui/jquery-ui.min.js"></script>
<script src='{$this->vendorPath}/tinymce/tinymce/tinymce.min.js'></script>
<script src="{$this->vendorPath}/gymadarasz/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="{$this->vendorPath}/gymadarasz/ace/src-min/ace.js" type="text/javascript" charset="utf-8"></script>

<!-- for color picker plugin -->
<link rel="stylesheet" media="screen" type="text/css" href="{$this->vendorPath}/../colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="{$this->vendorPath}/../colorpicker/js/colorpicker.js"></script>
HTML;
        return $html;
    }

    public function getIncludeHTML() {
        $html = <<<HTML
<link rel="stylesheet" href="{$this->mozaikPath}/jquery.mozaik.css">
<script src='{$this->mozaikPath}/jquery.mozaik.js'></script>
HTML;
        return $html;
    }

    public function getElementHTML($contents = '', $textareaId = null, $elementId = 'mozaik', $width = 'initial', $thumbs = array()) {
        if(is_numeric($width)) {
            $width .= 'px';
        }
        if(!$thumbs) {
            $thumbs = self::$defaultThumbnails;
        }
        $thumbsJSON = json_encode($thumbs);
        $refreshTextareaScript = '';
        if($textareaId) {
            $refreshTextareaScript = $this->getRefreshTextareaScript($textareaId, $elementId, $width);
        }
        $html = <<<HTML
<div id="{$elementId}">{$contents}</div>
<script type="text/javascript">
    $(function() {
        // initialize

        if(typeof window.mozaikSettings == 'undefined') {
            window.mozaikSettings = {};
        }

        window.mozaikSettings.{$elementId} = {
            base: '{$this->mozaikPath}/',
            thumbs: {$thumbsJSON},
            editables: 'editable',
            style: 'tpls/default/styles/default.css',
            namespace: false,
            ace: false,
            width: '{$width}'
        };

        window.plgBackground.image = '{$this->mozaikPath}/' + window.plgBackground.image;

        $('#{$elementId}').mozaik(window.mozaikSettings.{$elementId});
    });
    // refresh textarea
    {$refreshTextareaScript}
</script>
HTML;
        return $html;
    }

    public function getAllHTML($contents = '', $textareaId = null, $elementId = 'mozaik', $width = 'initial', $group = '') {
        if(is_numeric($width)) {
            $width .= 'px';
        }
        $mozaikHTML = $this->getDependenciesHTML();
        $mozaikHTML .= $this->getIncludeHTML();
        $thumbs = $this->getThumbs($group);
        $mozaikHTML .= $this->getElementHTML($contents, $textareaId, $elementId, $width, $thumbs);
        return $mozaikHTML;
    }

    private function getRefreshTextareaScript($textareaId, $elementId, $width = 'initial') {
        if(is_numeric($width)) {
            $width .= 'px';
        }
        $js = <<<SCRIPT
setInterval(function(){
    $('#{$textareaId}').val($('#{$elementId}').getMozaikValue({width: '{$width}'}));
}, 300);
SCRIPT;
        return $js;
    }

    private function getThumbs($group = '') {
        $db = DBManagerFactory::getInstance();
        $_group = $db->quote($group);
        $templateEditorBean = BeanFactory::getBean('TemplateEditor');
        $thumbBeans = $templateEditorBean->get_full_list('ord', "(grp LIKE '$_group' OR grp IS NULL)");
        $thumbs = array();
        if($thumbBeans) {
            foreach ($thumbBeans as $thumbBean) {
                $thumbs[$thumbBean->name] = array(
                    'label' => $thumbBean->name,
                    'tpl' => 'string:' . html_entity_decode($thumbBean->description),
                );
            }
        }
        return $thumbs;
    }

}