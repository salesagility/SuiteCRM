(function( $ ) {
  /**
   *
   * @param options
   * @returns {jQuery|HTMLElement}
   * @constructor
   */
  $.fn.messageBox = function (options) {
    "use strict";
    var self = this;
    self.controls = {};
    self.controls.modal = {};

    if(typeof $.fn.modal === "undefined") {
      console.error('messageBox - Missing Dependency Required: Bootstrap model');
      return self;
    }

    self.modal = $.fn.modal;

    var opts = $.extend( {}, $.fn.messageBox.defaults, options );

    self.construct = function (constructOptions) {
      if(typeof self.controls.modal.container === "undefined") {
        self.controls.modal.container =
          self
            .addClass('modal fade message-box')
            .attr('id', self.generateID())
            .attr('role', 'dialog');

        self.controls.modal.dialog =
          $('<div></div>')
            .addClass('modal-dialog')
            .appendTo(self.controls.modal.container);

        self.controls.modal.content =
          $('<div></div>')
            .addClass('modal-content')
            .appendTo(self.controls.modal.dialog);

        self.controls.modal.header =
          $('<div></div>')
            .addClass('modal-header')
            .appendTo(self.controls.modal.content);

        self.controls.modal.body =
          $('<div></div>')
            .addClass('modal-body')
            .appendTo(self.controls.modal.content);

        self.controls.modal.footer =
          $('<div></div>')
            .addClass('modal-footer')
            .appendTo(self.controls.modal.content);
        self.controls.modal.container.modal(constructOptions);

        if(opts.showHeader === false) {
          debugger;
          self.controls.modal.header.hide();
        };

        if(opts.showFooter === false) {
          self.controls.modal.footer.hide()
        };
      }

      return self;
    }

    /**
     * Call open when there is no DOM. Show dialog
     */
    self.show = function () {
      "use strict";
      self.controls.modal.container.modal('show');

      return self;
    };

    /**
     *  Hide dialog
     */
    self.hide = function () {
      "use strict";
      self.controls.modal.container.modal('hide');
      return self;
    };

    // Default behavior handle
    /**
     * @event Show
     */
    self.onShow = function () {
      "use strict";
    };

    /**
     * @event Shown
     */
    self.onShown = function () {
      "use strict";
    };

    /**
     * @event Hide
     */
    self.onHide = function () {
      "use strict";
    };

    /**
     * @event Hidden
     */
    self.onHidden = function () {

    };

    /**
     * @event OK
     */
    self.onOk = function () {

    };

    /**
     * @event CANCEL
     */
    self.onCancel = function () {};

    // Utilities
    /**
     * @return string UUID
     */
    self.generateID = function () {
      "use strict";
      var characters = ['a', 'b', 'c', 'd', 'e', 'f', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
      var format = '0000000-0000-0000-0000-00000000000';
      var z = Array.prototype.map.call(format, function ($obj) {
        var min = 0;
        var max = characters.length - 1;

        if ($obj == '0') {
          var index = Math.round(Math.random() * (max - min) + min);
          $obj = characters[index];
        }

        return $obj;
      }).toString().replace(/(,)/g, '');
      return z;
    };

    self.hideElement = function(element) {
      $(element).toggleClass()
    }

    self.construct(opts);
    // Return this
    return self;
  };


  $.fn.messageBox.defaults = {
    "showHeader": false,
    "headerContent": '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h4 class="modal-title" id="title-cal-edit"></h4>',
    "headerButtons": '',
    "footerContent": '',
    "footerButtons": '',
    "showFooter" : false,
    // Message Box Specific events
    "onOK": self.onOK,
    "onCancel": self.onCancel,
    // Alias to the Bootstrap Modal Events
    "onShow": self.onShow,
    "onShown": self.onShown,
    "onHide": self.onShown,
    "onHidden": self.onHidden,
    // Style
    "size": 'sm',
    // Bootstrap
    "show": false,
    "backdrop": false,
    "keyboard": true
  }
}( jQuery ));

/**
 * Alias for $.fn.messageBox(options)
 * @param options
 */
var messageBox = function (options) {
  return $('<div></div>').appendTo('body').messageBox(options);
}