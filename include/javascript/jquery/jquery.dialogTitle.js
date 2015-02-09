/*
 * backward compatible support for html dialog title
 */

$.widget("ui.dialog",$.extend({},$.ui.dialog.prototype,{_title:function(e){if(!this.options.title){e.html("&#160;")}else{e.html(this.options.title)}}}))