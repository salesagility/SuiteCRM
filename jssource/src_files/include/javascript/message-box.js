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
     * @event show
     */
    self.onShow = function () {
      "use strict";
      $(self).trigger('show');
      return false;
    };

    /**
     * @event shown
     */
    self.onShown = function () {
      "use strict";
      $(self).trigger('shown');
      return false;
    };

    /**
     * @event hide
     */
    self.onHide = function () {
      "use strict";
      $(self).trigger('hide');
      return false;
    };

    /**
     * @event hidden
     */
    self.onHidden = function () {
      $(self).trigger('hidden');
      return false;
    };

    /**
     * @event ok
     */
    self.onOk = function () {
      $(self).trigger('ok');
      return false;
    };

    /**
     * @event cancel
     */
    self.onCancel = function () {
      $(self).trigger('cancel');
      return false;
    };

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

    /**
     *
     * @param content htmlString|function
     */
    self.setTitle = function(content) {
      self.controls.modal.container.find('.modal-title').html(content);
    };

    /**
     * @return {jQuery}
     */
    self.getTitle = function() {
      return self.controls.modal.container.find('.modal-title');
    };

    /**
     *
     * @param content htmlString|function
     */
    self.setBody = function(content) {
      self.controls.modal.container.find('.modal-body').html(content);
    };

    /**
     * @return {jQuery}
     */
    self.getBody = function() {
      return self.controls.modal.container.find('.modal-body');
    };

    /**
     *
     */
    self.showHeader = function() {
      return self.controls.modal.container.find('.modal-header').show();
    };

    /**
     *
     */
    self.hideHeader = function() {
      return self.controls.modal.container.find('.modal-header').hide();
    };

    /**
     *
     */
    self.showFooter = function() {
      return self.controls.modal.container.find('.modal-footer').show();
    };

    /**
     *
     */
    self.hideFooter = function() {
      return self.controls.modal.container.find('.modal-footer').hide();
    };

    self.headerContent = '<button type="button" class="close btn-cancel" aria-label="Close"><span aria-hidden="true">×</span></button><h4 class="modal-title"></h4>';
    self.footerContent = '<button class="button btn-ok" type="button">'+SUGAR.language.translate('','LBL_OK')+'</button> <button class="button btn-cancel" type="button">'+SUGAR.language.translate('','LBL_CANCEL_BUTTON_LABEL')+'</button> ';

    self.construct = function (constructOptions) {
      if(typeof self.controls.modal.container === "undefined") {
        if(typeof opts.onOK === "undefined") {
          opts.onOK = self.onOk;
        }

        if(typeof opts.onCancel === "undefined") {
          opts.onCancel = self.onCancel;
        }

        if(typeof opts.onShow === "undefined") {
          opts.onShow = self.onShow;
        }

        if(typeof opts.onShown === "undefined") {
          opts.onShown = self.onShown;
        }

        if(typeof opts.onHide === "undefined") {
          opts.onShown = self.onShown;
        }

        if(typeof opts.onHidden === "undefined") {
          opts.onHidden = self.onHidden;
        }


        if(typeof opts.headerContent === "undefined") {
          opts.headerContent = self.headerContent;
        }

        if(typeof opts.footerContent === "undefined") {
          opts.footerContent = self.footerContent;
        }


        self.controls.modal.container =
          self
            .addClass('modal fade message-box')
            .attr('id', self.generateID())
            .attr('role', 'dialog');

        self.controls.modal.dialog =
          $('<div></div>')
            .addClass('modal-dialog modal-' + opts.size)
            .attr('role', 'document')
            .appendTo(self.controls.modal.container);

        self.controls.modal.content =
          $('<div></div>')
            .addClass('modal-content')
            .appendTo(self.controls.modal.dialog);

        self.controls.modal.header =
          $('<div></div>')
            .addClass('modal-header')
            .appendTo(self.controls.modal.content);

        self.controls.modal.header.html(opts.headerContent);

        self.controls.modal.body =
          $('<div></div>')
            .addClass('modal-body')
            .appendTo(self.controls.modal.content);

        self.controls.modal.footer =
          $('<div></div>')
            .addClass('modal-footer')
            .html(opts.footerContent)
            .appendTo(self.controls.modal.content);

        self.controls.modal.footer.html(opts.footerContent);

        // OK / Cancel
        self.controls.modal.container.find('.btn-ok').click(opts.onOK);
        self.controls.modal.container.find('.btn-cancel').click(opts.onCancel);

        if(opts.showHeader === false) {
          self.controls.modal.header.hide();
        };

        if(opts.showFooter === false) {
          self.controls.modal.footer.hide()
        };

        self.modal(opts);
      }

      $(self).on('remove', self.destruct);

      return self;
    }

    /**
     * @destructor
     */
    self.destruct = function () {
      self.attr('aria-hidden', "true");
      self.hide();
      $('.modal-backdrop').last().remove();
      if($('.message-box').length <= 1) {
        $('.modal-open').removeClass('modal-open');
      }


      return true;
    }

    self.construct(opts);
    // Return this
    return self;
  };


  $.fn.messageBox.defaults = {
    "showHeader": true,
    "headerContent": self.headerContent,
    "footerContent": self.footerContent,
    "showFooter" : true,
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
    "keyboard": false
  }
}( jQuery ));


/**
 * Alias for $.fn.messageBox(options)
 * @param options
 */
messageBox = function (options) {
  return $('<div></div>').appendTo('body').messageBox(options);
};