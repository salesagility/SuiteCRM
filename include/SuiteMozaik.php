<?php

class SuiteMozaik {

    private $mozaikPath = 'include/javascript/mozaik';
    private $vendorPath;

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

    public function getElementHTML($contents = '', $textareaId = null, $elementId = 'mozaik', $width = 'initial') {
        if(is_numeric($width)) {
            $width .= 'px';
        }
        $refreshTextareaScript = '';
        if($textareaId) {
            $refreshTextareaScript = $this->getRefreshTextareaScript($textareaId, $elementId, $width);
        }
        $html = <<<HTML
<div id="{$elementId}">{$contents}</div>
<script type="text/javascript">
    $(function() {
        // initialize
        $('#{$elementId}').mozaik({
            thumbs: {
                headline: {thumbnail: '{$this->mozaikPath}/tpls/default/thumbs/headline.png', label: 'Headline', tpl: '{$this->mozaikPath}/tpls/default/headline.html'},
                content1: {thumbnail: '{$this->mozaikPath}/tpls/default/thumbs/content1.png', label: 'Content', tpl: '{$this->mozaikPath}/tpls/default/content1.html'},
                //content3: {thumbnail: '{$this->mozaikPath}/tpls/default/thumbs/content3.jpg', label: 'Three column', tpl: '{$this->mozaikPath}/tpls/default/content3.html'},
                //content2: {thumbnail: '{$this->mozaikPath}/tpls/default/thumbs/content2.jpg', label: 'Two column', tpl: '{$this->mozaikPath}/tpls/default/content2.html'},
                //image3: {thumbnail: '{$this->mozaikPath}/tpls/default/thumbs/image3.jpg', label: 'Three column with image', tpl: '{$this->mozaikPath}/tpls/default/image3.html'},
                //image2: {thumbnail: '{$this->mozaikPath}/tpls/default/thumbs/image2.jpg', label: 'Two column with image', tpl: '{$this->mozaikPath}/tpls/default/image2.html'},
                //image1left: {thumbnail: '{$this->mozaikPath}/tpls/default/thumbs/image1left.jpg', label: 'Content with image (left)', tpl: '{$this->mozaikPath}/tpls/default/image1left.html'},
                //image1right: {thumbnail: '{$this->mozaikPath}/tpls/default/thumbs/image1right.jpg', label: 'Content with image (right)', tpl: '{$this->mozaikPath}/tpls/default/image1right.html'},
                footer: {thumbnail: '{$this->mozaikPath}/tpls/default/thumbs/footer.png', label: 'Footer', tpl: '{$this->mozaikPath}/tpls/default/footer.html'},
            },
            editables: 'editable',
            style: '{$this->mozaikPath}/tpls/default/styles/default.css',
            namespace: false,
            ace: false,
            width: '{$width}'
        });
    });
    // refresh textarea
    {$refreshTextareaScript}
</script>
HTML;
        return $html;
    }

    public function getAllHTML($contents = '', $textareaId = null, $elementId = 'mozaik', $width = 'initial') {
        if(is_numeric($width)) {
            $width .= 'px';
        }
        $mozaikHTML = $this->getDependenciesHTML();
        $mozaikHTML .= $this->getIncludeHTML();
        $mozaikHTML .= $this->getElementHTML($contents, $textareaId, $elementId, $width);
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

}