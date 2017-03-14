
var ComposeView = function (options) {
  "use strict";
  var self = this;
  options = $.extend({"id": ''}, options);
  options = $.extend({"email": Email.prototype.fromSelector(options.id+'.compose-view')}, options);

  $('#' + options.id + ' .btn-send-email').click(function () {
    self.email = Email.prototype.fromSelector(options.id+'.compose-view');

    if(validate_form('ComposeView', '')) {
      $('#' + options.id).submit();
    }

    return false;
  });

  $('<div></div>').addClass('hidden').addClass('html_preview').appendTo("form#" + options.id + ".composer-view")


  $("form#" + options.id + ".composer-view").submit( function () {
    $.ajax({
      type: "POST",
      data : $(this).serialize(),
      cache: false,
      url: $(this).attr('action')
    }).done(function (data) {
      console.log(data);
    });
    return false;
  });

  $(document).ready(function() {
    if(options.email.bodyType == EmailBodyType.html) {
      tinymce.init({
        selector: '#'+options.id + ' #description_html',
        mode : "specific_textareas",
        plugins: "fullscreen",
        formats: {
          bold: {inline: 'b'},
          italic: {inline: 'i'},
          underline: {inline: 'u'}
        },
        setup: function(editor) {
          editor.on('change', function(e) {
            $('#'+options.id + ' .html_preview').html(editor.getContent());
            $('#'+options.id + ' textarea#description_html').val(editor.getContent());
            $('#'+options.id + ' textarea#description').val( $('#'+options.id + ' .html_preview').text());
          });
        }
      });
      $('#'+options.id + ' #description').closest('.edit-view-row-item').addClass('hidden');
    }
  });

  self.options = options;
};
