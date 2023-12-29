// load qtip for first non active .inline-help element
function setInlineHelpQtip(){
$('i.inline-help:not([data-hasqtip])').qtip({
    content: {
      text: function (api) {
        return $(this).parent().find('.inline-help-content').html();
      },
      title: {
        text: SUGAR.language.languages.app_strings.LBL_ALT_INFO,
      },
      style: {
        classes: 'qtip-inline-help'
      }
    },
    hide: { 
      event: 'mouseleave unfocus',
      fixed: true,
      delay: 200,
    }
  });
}
