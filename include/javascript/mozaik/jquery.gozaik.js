if(mozaik || $.mozaik) {
    throw 'MOZAIK: conflict detected';
}

// mozaik helpers (private)
var mozaik = {
    
    getEditor: function(innertext) {
                    var html = '<div class="mozaik-list">' +
                        '<div class="mozaik-elem">' +
                        '<div class="gozaik-inner">' +
                         innertext +
                         '</div></div></div>' ;
                return html ;
                },
};

var plgBackground = {

    name: 'background',
    title: 'Background color',
    image: 'img/paint.png',

};

(function($){
    $.fn.mozaik = function(options) {

        var tinyMCESettings = {
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
            toolbar2: 'print preview media | forecolor backcolor | image | emoticons | table | link | fontsizeselect',
            table_toolbar: "",
            image_advtab: true,
            textcolor_map: [
                "000000", "Black",
                "993300", "Burnt orange",
                "333300", "Dark olive",
                "003300", "Dark green",
                "003366", "Dark azure",
                "000080", "Navy Blue",
                "333399", "Indigo",
                "333333", "Very dark gray",
                "800000", "Maroon",
                "FF6600", "Orange",
                "808000", "Olive",
                "008000", "Green",
                "008080", "Teal",
                "0000FF", "Blue",
                "666699", "Grayish blue",
                "808080", "Gray",
                "FF0000", "Red",
                "FF9900", "Amber",
                "99CC00", "Yellow green",
                "339966", "Sea green",
                "33CCCC", "Turquoise",
                "3366FF", "Royal blue",
                "800080", "Purple",
                "999999", "Medium gray",
                "FF00FF", "Magenta",
                "FFCC00", "Gold",
                "FFFF00", "Yellow",
                "00FF00", "Lime",
                "00FFFF", "Aqua",
                "00CCFF", "Sky blue",
                "993366", "Red violet",
                "FFFFFF", "White",
                "FF99CC", "Pink",
                "FFCC99", "Peach",
                "FFFF99", "Light yellow",
                "CCFFCC", "Pale green",
                "CCFFFF", "Pale cyan",
                "99CCFF", "Light sky blue",
                "CC99FF", "Plum"
            ],
            //setup: function(editor) {
            //    var _editor = editor;
            //    editor.on('focus', function(event){
            //        mozaik.lastUsedEditor = _editor;
            //    });
            //}

            file_browser_callback: function(field_name, url, type, win, e) {
                mozaik.uploadPathField = field_name;
                if(type=='image') {
                    // $('#mozaik_upload_form input').click();
                    $('form#upload_form input[type="file"]').each(function(i,e){
                        if($(e).css('display') != 'none') {
                            $(e).click();
                        }
                    });
                }
            }
        };

        var settings = $.extend({
            base: '',
            editables: 'editable',
            style: 'tpls/default/styles/default.css',
            style: '',
            namespace: false,
            ace: true,
            width: '600px',
            toolPlugins: '',
            uploadPathField: null
        }, options);

        if(typeof settings.tinyMCE == 'undefined') {
            settings.tinyMCE = tinyMCESettings;
        }
        else {
            settings.tinyMCE = $.extend(settings.tinyMCE, tinyMCESettings);
        }

        // template styles added?
        var style = false;

        return this.each(function(i, e){
        
            $(e).addClass('mozaik');
            
            var html = $(e).html();
            $(e).html('');

            $(e).append(mozaik.getEditor(html));

            $(e).find('.mozaik-list').css('height','auto');
            
            var sels = '.gozaik-inner'; //, .mozaik-inner ' + e;
            var config = settings.tinyMCE;
                config.selector = sels;
                config.inline = false ;
                tinyMCE.init(config);
        });
    };
}(jQuery));


(function($){
    $.fn.getMozaikValue = function(options) {
        return tinyMCE.activeEditor.getContent();
    };
}(jQuery));
                                                                
