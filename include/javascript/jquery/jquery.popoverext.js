!function( $ ) {

 "use strict"

  var PopoverExt = function ( element, options ) {
    this.init('popoverext', element, options)
  }

  /* NOTE: POPOVER EXTENDS BOOTSTRAP-TOOLTIP.js
     ========================================== */

  PopoverExt.prototype = $.extend({}, $.fn.popover.Constructor.prototype, {

    constructor: PopoverExt
  , init: function ( type, element, options ) {
      var eventIn
        , eventOut

      this.type = type
      this.$element = $(element)
      this.options = this.getOptions(options)
      this.enabled = true

      if (this.options.trigger != 'manual') {
        eventIn  = this.options.trigger == 'hover' ? 'mouseenter' : 'focus'
        eventOut = this.options.trigger == 'hover' ? 'mouseleave' : 'blur'
        this.$element.on(eventIn, this.options.selector, $.proxy(this.enter, this))
        this.$element.on(eventOut, this.options.selector, $.proxy(this.leave, this))
      }

      //console.log(this.tip())
      var $tip = this.tip();


      this.options.selector ?
        (this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' })) :
        this.fixTitle()
    }
    
  , setContent: function () {
      var $tip = this.tip()
        , title = this.getTitle()
        , content = this.getContent()
        , footer = this.getFooter();

      $tip.find('.popover-title')[ $.type(title) == 'object' ? 'append' : 'html' ](title);
      $tip.find('.popover-content > *')[ $.type(content) == 'object' ? 'append' : 'html' ](content);
      $tip.find('.popover-footer')[ $.type(footer) == 'object' ? 'append' : 'html' ](footer);

      $tip.removeClass('fade top bottom left right in');
    }

  , hasContent: function () {
      return this.getTitle() || this.getContent()
    }
    
    
  , setId: function() {
		var $tip;
		if(this.options.id) {
			$tip = this.tip();
			$tip.attr("id",this.$element.attr("id") + "Popover");
		}
	}
  , show: function () {
      var $tip
        , inside
        , pos
        , actualWidth
        , actualHeight
        , placement
        , tp;
        

      if (this.hasContent() && this.enabled) {
        $tip = this.tip();
        this.setContent();
        this.setId();

        if (this.options.animation) {
          $tip.addClass('fade')
        }

        placement = typeof this.options.placement == 'function' ?
          this.options.placement.call(this, $tip[0], this.$element[0]) :
            this.options.placement;

        inside = /in/.test(placement)

        $tip
          .remove()
          .css({ top: 0, left: 0, display: 'block' })
          .appendTo(inside ? this.$element : document.body);

        if(this.options.hideOnBlur) {
        $tip
          .attr("tabindex","-1")
          .on("blur", $.proxy(this.hide, this))
          .trigger("focus");
        }

        pos = this.getPosition(inside)
        actualWidth = $tip[0].offsetWidth
        actualHeight = $tip[0].offsetHeight

        switch (inside ? placement.split(' ')[1] : placement) {
          case 'bottom':
            tp = {top: pos.top + pos.height + this.options.topOffset, left: pos.left + pos.width / 2 - actualWidth / 2}
            break
          case 'bottom left':
            tp = {top: pos.top + pos.height + this.options.topOffset, left: pos.left + this.options.leftOffset}
            break
          case 'bottom right':
            tp = {top: pos.top + pos.height + this.options.topOffset , left: (pos.left + pos.width) - actualWidth - this.options.leftOffset }
            break
          case 'top':
            tp = {top: pos.top - actualHeight + this.options.topOffset, left: pos.left + (pos.width / 2 - actualWidth / 2) + this.options.leftOffset}
            break
          case 'top right':
            tp = {top: pos.top - actualHeight + this.options.topOffset, left: (pos.left + pos.width) - actualWidth - this.options.leftOffset}
            break
          case 'top left':
            tp = {top: pos.top - actualHeight  + this.options.topOffset, left: pos.left + this.options.leftOffset}
            break
          case 'left':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}
            break
          case 'right':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}
            break
        }

        $tip
          .css(tp)
          .addClass(placement)
          .addClass('in')
          
          if(this.options.fixed == true) {
          	$tip.css("position","fixed");	
          }
      }
          this.options.onShow();
    }
  , getFooter: function () {
      var footer
        , $e = this.$element
        , o = this.options;

      footer = $e.attr('data-footer')
        || (typeof o.content == 'function' ? o.footer.call($e[0]) :  o.footer);

      footer = footer.toString().replace(/(^\s*|\s*$)/, "");

      return footer;
    }

  })


 /* POPOVER PLUGIN DEFINITION
  * ======================= */

  $.fn.popoverext = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('popoverext')
        , options = typeof option == 'object' && option
      if (!data) $this.data('popoverext', (data = new PopoverExt(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.popoverext.Constructor = PopoverExt

  $.fn.popoverext.defaults = $.extend({} , $.fn.popover.defaults, {
  	fixed: false,
  	template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div><div class="popover-footer"></div></div></div>',
  	id: false,
  	footer: '',
    onShow:$.empty,
    leftOffset: 0,
    topOffset: 0,
    hideOnBlur: false
  })

}( window.jQuery );
