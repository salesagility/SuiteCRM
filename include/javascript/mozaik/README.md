# mozaik

### Usage:
```
<!-- include dependencies -->
<link rel="stylesheet" href="vendor/components/jqueryui/themes/ui-lightness/jquery-ui.min.css">
<script src='vendor/components/jquery/jquery.min.js'></script>
<script src="vendor/components/jqueryui/jquery-ui.min.js"></script>
<script src='vendor/tinymce/tinymce/tinymce.min.js'></script>
<script src="vendor/gymadarasz/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="vendor/gymadarasz/ace/src-min/ace.js" type="text/javascript" charset="utf-8"></script>

<!-- include mozaik -->
<link rel="stylesheet" href="jquery.mozaik.css">
<script src='jquery.mozaik.js'></script>
```

### Example:
HTML:
```
<div id="template"></div>
```

JavaScript:
```
$(function(){
    // initialize
    $('#template').mozaik();

    // get value
    $('#template').getMozaikValue();

    // apply inline styles (tipically for email templates)
    $('#template').getMozaikValue({inlineStyles: true});
});
```

Default settings:
```
$('#template').mozaik({
                headline: {thumbnail: 'tpls/default/thumbs/headline.png', label: 'Headline', tpl: 'tpls/default/headline.html'},
                content1: {thumbnail: 'tpls/default/thumbs/content1.png', label: 'Content', tpl: 'tpls/default/content1.html'},
                content3: {thumbnail: 'tpls/default/thumbs/content3.jpg', label: 'Three column', tpl: 'tpls/default/content3.html'},
                content2: {thumbnail: 'tpls/default/thumbs/content2.jpg', label: 'Two column', tpl: 'tpls/default/content2.html'},
                image3: {thumbnail: 'tpls/default/thumbs/image3.jpg', label: 'Three column with image', tpl: 'tpls/default/image3.html'},
                image2: {thumbnail: 'tpls/default/thumbs/image2.jpg', label: 'Two column with image', tpl: 'tpls/default/image2.html'},
                image1left: {thumbnail: 'tpls/default/thumbs/image1left.jpg', label: 'Content with image (left)', tpl: 'tpls/default/image1left.html'},
                image1right: {thumbnail: 'tpls/default/thumbs/image1right.jpg', label: 'Content with image (right)', tpl: 'tpls/default/image1right.html'},
                footer: {thumbnail: 'tpls/default/thumbs/footer.png', label: 'Footer', tpl: 'tpls/default/footer.html'},
            },
            editables: 'editable',
            style: 'tpls/default/styles/default.css',
            namespace: false,
            tinyMCEPlugins: "link image imagetools code"
        });
```

See more on Guthub: https://github.com/gymadarasz/mozaik
