/**
 * HoverScroll jQuery Plugin
 *
 * Make an unordered list scrollable by hovering the mouse over it
 *
 * @author RasCarlito <carl.ogren@gmail.com>
 * @version 0.2.4
 * @revision 21
 *
 * 
 *
 * FREE BEER LICENSE VERSION 1.02
 *
 * The free beer license is a license to give free software to you and free
 * beer (in)to the author(s).
 * 
 *
 * Released: 09-12-2010 11:31pm
 *
 * Changelog
 * ----------------------------------------------------
 *
 * 0.2.4    - Added "Right to Left" option, only works with horizontal lists
 *          - Optimization of arrows opacity control (Thanks to Josef Körner)
 *
 * 0.2.3    - Added fixed arrows option
 *          - Binded startMoving and stopMoving functions to the HoverScrolls HTML object for external access
 *
 * 0.2.2    Bug fixes
 *          - Backward compatibility with jQuery 1.1.x
 *          - Added test file to the archive
 *          - Bug fix: The right arrow appeared when it wasn't necessary (thanks to <admin at unix dot am>)
 *        
 * 0.2.1    Bug fixes
 *          - Backward compatibility with jQuery 1.2.x (thanks to Andy Mull for compatibility with jQuery >= 1.2.4)
 *          - Added information to the debug log
 * 
 * 0.2.0    Added some new features
 *          - Direction indicator arrows
 *          - Permanent override of default parameters
 * 
 * 0.1.1    Minor bug fix
 *          - Hover zones did not cover the complete container
 *
 *          note: The css file has not changed therefore it is still versioned 0.1.0
 *
 * 0.1.0    First release of the plugin. Supports:
 *          - Horizontal and vertical lists
 *          - Width and height control
 *          - Debug log (doesn't show useful information for the moment)
 */
 
(function($) {

/**
 * @method hoverscroll
 * @param	params {Object}  Parameter list
 * 	params = {
 * 		vertical {Boolean},	// Vertical list or not ?
 * 		width {Integer},	// Width of list container
 * 		height {Integer},	// Height of list container
 *  	arrows {Boolean},	// Show direction indicators or not
 *  	arrowsOpacity {Float},	// Arrows maximum opacity
 *  	fixedArrows {Boolean},  // Display arrows permenantly, this overrides arrowsOpacity option
 * 		debug {Boolean}		// Debug output in firebug console
 * 	};
 */
$.fn.hoverscroll = function(params) {
	if (!params) { params = {}; }
	
	// Extend default parameters
	// note: empty object to prevent params object from overriding default params object
	params = $.extend({}, $.fn.hoverscroll.params, params);
	
	// Loop through all the elements
	this.each(function() {
		var $this = $(this);
		
		if (params.debug) {
			$.log('[HoverScroll] Trying to create hoverscroll on element ' + this.tagName + '#' + this.id);
		}
		
		// wrap ul list with a div.listcontainer
        if (params.fixedArrows) {
            $this.wrap('<div class="fixed-listcontainer"></div>')
        }
        else {
            $this.wrap('<div class="listcontainer"></div>');
        }
		
		$this.addClass('listitem');
		//.addClass('ui-helper-clearfix');
		
		// store handle to listcontainer
		var listctnr = $this.parent();
		
		// wrap listcontainer with a div.hoverscroll
		listctnr.wrap('<div class="ui-widget-content hoverscroll' +
			(params.rtl && !params.vertical ? " rtl" : "") + '"></div>');
		//listctnr.wrap('<div class="hoverscroll"></div>');
		
		// store hoverscroll container
		var ctnr = listctnr.parent();

        var leftArrow, rightArrow, topArrow, bottomArrow;

		// Add arrow containers
		if (params.arrows) {
			if (!params.vertical) {
                if (params.fixedArrows) {
                    leftArrow = '<div class="fixed-arrow left"></div>';
                    rightArrow = '<div class="fixed-arrow right"></div>';

                    listctnr.before(leftArrow).after(rightArrow);
                }
                else {
                    leftArrow = '<div class="arrow left"></div>';
                    rightArrow = '<div class="arrow right"></div>';
                    
                    listctnr.append(leftArrow).append(rightArrow);
                }
			}
			else {
                if (params.fixedArrows) {
                    topArrow = '<div class="fixed-arrow top"></div>';
                    bottomArrow = '<div class="fixed-arrow bottom"></div>';

                    listctnr.before(topArrow).after(bottomArrow);
                }
                else {
                    topArrow = '<div class="arrow top"></div>';
                    bottomArrow = '<div class="arrow bottom"></div>';

                    listctnr.append(topArrow).append(bottomArrow);
                }
			}
		}
		
		// Apply parameters width and height
		ctnr.width(params.width).height(params.height);

        if (params.arrows && params.fixedArrows) {
            if (params.vertical) {
                topArrow = listctnr.prev();
                bottomArrow = listctnr.next();

                listctnr.width(params.width)
                    .height(params.height - (topArrow.height() + bottomArrow.height()));
            }
            else {
                leftArrow = listctnr.prev();
                rightArrow = listctnr.next();
                
                listctnr.height(params.height)
                    .width(params.width - (leftArrow.width() + rightArrow.width()));
            }
        }
        else {
            listctnr.width(params.width).height(params.height);
        }
		
		var size = 0;
		
		if (!params.vertical) {
			ctnr.addClass('horizontal');
			
			// Determine content width
			$this.children().each(function() {
				$(this).addClass('item');
				
				if ($(this).outerWidth) {
					size += $(this).outerWidth(true);
				}
				else {
					// jQuery < 1.2.x backward compatibility patch
					size += $(this).width() + parseInt($(this).css('padding-left')) + parseInt($(this).css('padding-right'))
						+ parseInt($(this).css('margin-left')) + parseInt($(this).css('margin-right'));
				}
			});
			// Apply computed width to listcontainer
			$this.width(size);
			
			if (params.debug) {
				$.log('[HoverScroll] Computed content width : ' + size + 'px');
			}
			
			// Retrieve container width instead of using the given params.width to include padding
			if (ctnr.outerWidth) {
				size = ctnr.outerWidth();
			}
			else {
				// jQuery < 1.2.x backward compatibility patch
				size = ctnr.width() + parseInt(ctnr.css('padding-left')) + parseInt(ctnr.css('padding-right'))
					+ parseInt(ctnr.css('margin-left')) + parseInt(ctnr.css('margin-right'));
			}
			
			if (params.debug) {
				$.log('[HoverScroll] Computed container width : ' + size + 'px');
			}
		}
		else {
			ctnr.addClass('vertical');
			
			// Determine content height
			$this.children().each(function() {
				$(this).addClass('item')
				if ($(this).css('display') != "none"){
					if ($(this).outerHeight) {
						size += $(this).outerHeight(true);
					}
					else {
						// jQuery < 1.2.x backward compatibility patch
						size += $(this).height() + parseInt($(this).css('padding-top')) + parseInt($(this).css('padding-bottom'))
							+ parseInt($(this).css('margin-bottom')) + parseInt($(this).css('margin-bottom'));
					}
				}
			});
			// Apply computed height to listcontainer
			$this.height(size);
			
			if (params.debug) {
				$.log('[HoverScroll] Computed content height : ' + size + 'px');
			}
			
			// Retrieve container height instead of using the given params.height to include padding
			if (ctnr.outerHeight) {
				size = ctnr.outerHeight();
			}
			else {
				// jQuery < 1.2.x backward compatibility patch
				size = ctnr.height() + parseInt(ctnr.css('padding-top')) + parseInt(ctnr.css('padding-bottom'))
					+ parseInt(ctnr.css('margin-top')) + parseInt(ctnr.css('margin-bottom'));
			}
			
			if (params.debug) {
				$.log('[HoverScroll] Computed container height : ' + size + 'px');
			}
		}
		
		// Define hover zones on container
		var arrowHeight = $(this).parent().find('.arrow.top').height();
		
		
		if(params.hoverZone == "gradual") {
			var zone = {
				1: {action: 'move', from: 0, to: 0.06 * size, direction: -1 , speed: 16},
				2: {action: 'move', from: 0.06 * size, to: 0.15 * size, direction: -1 , speed: 8},
				3: {action: 'move', from: 0.15 * size, to: 0.25 * size, direction: -1 , speed: 4},
				4: {action: 'move', from: 0.25 * size, to: 0.4 * size, direction: -1 , speed: 2},
				5: {action: 'stop', from: 0.4 * size, to: 0.6 * size},
				6: {action: 'move', from: 0.6 * size, to: 0.75 * size, direction: 1 , speed: 2},
				7: {action: 'move', from: 0.75 * size, to: 0.85 * size, direction: 1 , speed: 4},
				8: {action: 'move', from: 0.85 * size, to: 0.94 * size, direction: 1 , speed: 8},
				9: {action: 'move', from: 0.94 * size, to: size, direction: 1 , speed: 16}
			}
		} else {
			var zone = {
				1: {action: 'move', from: 0, to: arrowHeight, direction: -1 , speed: 16},
				2: {action: 'move', from: size-arrowHeight, to: size, direction: 1 , speed: 16}
			}
		}
		
		// Store default state values in container
		ctnr[0].isChanging = false;
		ctnr[0].direction  = 0;
		ctnr[0].speed      = 1;
		
		
		/**
		 * Check mouse position relative to hoverscroll container
		 * and trigger actions according to the zone table
		 *
		 * @param x {Integer} Mouse X event position
		 * @param y {Integer} Mouse Y event position
		 */
		function checkMouse(x, y) {
			x = x - ctnr.offset().left;
			y = y - ctnr.offset().top;
			
			var pos;
			if (!params.vertical) {pos = x;}
			else {pos = y;}
			
			for (i in zone) {
				if (pos >= zone[i].from && pos < zone[i].to) {
					if (zone[i].action == 'move') {startMoving(zone[i].direction, zone[i].speed);}
					else {stopMoving();}
				}
			}
		}
		
		
		/**
		 * Sets the opacity of the left|top and right|bottom
		 * arrows according to the scroll position.
		 */
		function setArrowOpacity() {
			if (!params.arrows || params.fixedArrows) {return;}
			
			var maxScroll;
			var scroll;
			
			if (!params.vertical) {
				maxScroll = listctnr[0].scrollWidth - listctnr.width();
				scroll = listctnr[0].scrollLeft;
			}
			else {
				maxScroll = listctnr[0].scrollHeight - listctnr.height();
				scroll = listctnr[0].scrollTop;
			}
			var limit = params.arrowsOpacity;
			
            // Optimization of opacity control by Josef Körner
            // Initialize opacity; keep it between its extremas (0 and limit) we don't need to check limits after init
			var opacity = (scroll / maxScroll) * limit;
            
   		    if (opacity > limit) { opacity = limit; }
			if (isNaN(opacity)) { opacity = 0; }
            
			// Check if the arrows are needed
			// Thanks to <admin at unix dot am> for fixing the bug that displayed the right arrow when it was not needed
			var done = false;
			if (opacity <= 0) {
                $('div.arrow.left, div.arrow.top', ctnr).hide();
                if(maxScroll > 0) {
                    $('div.arrow.right, div.arrow.bottom', ctnr).show().css('opacity', limit);
                }
                done = true;
            }
			if (opacity >= limit || maxScroll <= 0) {
           	    $('div.arrow.right, div.arrow.bottom', ctnr).hide();
                done = true;
            }

			if (!done) {
				$('div.arrow.left, div.arrow.top', ctnr).show().css('opacity', opacity);
				$('div.arrow.right, div.arrow.bottom', ctnr).show().css('opacity', (limit - opacity));
			}
            // End of optimization
		}
		
		
		/**
		 * Start scrolling the list with a given speed and direction
		 *
		 * @param direction {Integer}	Direction of the displacement, either -1|1
		 * @param speed {Integer}		Speed of the displacement (20 being very fast)
		 */
		function startMoving(direction, speed) {
			if (ctnr[0].direction != direction) {
				if (params.debug) {
					$.log('[HoverScroll] Starting to move. direction: ' + direction + ', speed: ' + speed);
				}
				
				stopMoving();
				ctnr[0].direction  = direction;
				ctnr[0].isChanging = true;
				move();
			}
			if (ctnr[0].speed != speed) {
				if (params.debug) {
					$.log('[HoverScroll] Changed speed: ' + speed);
				}
				
				ctnr[0].speed = speed;
			}
		}
		
		/**
		 * Stop scrolling the list
		 */
		function stopMoving() {
			if (ctnr[0].isChanging) {
				if (params.debug) {
					$.log('[HoverScroll] Stoped moving');
				}
				
				ctnr[0].isChanging = false;
				ctnr[0].direction  = 0;
				ctnr[0].speed      = 1;
				clearTimeout(ctnr[0].timer);
			}
		}
		
		/**
		 * Move the list one step in the given direction and speed
		 */
		function move() {
			if (ctnr[0].isChanging == false) {return;}
			
			setArrowOpacity();
			
			var scrollSide;
			if (!params.vertical) {scrollSide = 'scrollLeft';}
			else {scrollSide = 'scrollTop';}
			
			listctnr[0][scrollSide] += ctnr[0].direction * ctnr[0].speed;
			ctnr[0].timer = setTimeout(function() {move();}, 50);
		}

		// Initialize "right to left" option if specified
		if (params.rtl && !params.vertical) {
			listctnr[0].scrollLeft = listctnr[0].scrollWidth - listctnr.width();
		}
		
		// Bind actions to the hoverscroll container
		ctnr
		// Bind checkMouse to the mousemove
		.mousemove(function(e) {checkMouse(e.pageX, e.pageY);})
		// Bind stopMoving to the mouseleave
		// jQuery 1.2.x backward compatibility, thanks to Andy Mull!
		// replaced .mouseleave(...) with .bind('mouseleave', ...)
		.bind('mouseleave, mouseout', function() {stopMoving();});

        // Bind the startMoving and stopMoving functions
        // to the HTML object for external access
        this.startMoving = startMoving;
        this.stopMoving = stopMoving;
		
		if (params.arrows && !params.fixedArrows) {
			// Initialise arrow opacity
			setArrowOpacity();
		}
		else {
			// Hide arrows
			$('.arrowleft, .arrowright, .arrowtop, .arrowbottom', ctnr).hide();
		}
	});
	
	return this;
};


// Backward compatibility with jQuery 1.1.x
if (!$.fn.offset) {
	$.fn.offset = function() {
		this.left = this.top = 0;
		
		if (this[0] && this[0].offsetParent) {
			var obj = this[0];
			do {
				this.left += obj.offsetLeft;
				this.top += obj.offsetTop;
			} while (obj = obj.offsetParent);
		}
		
		return this;
	}
}



/**
 * HoverScroll default parameters
 */
$.fn.hoverscroll.params = {
	vertical:	false,      // Display the list vertically or not
	width:		400,        // Width of the list
	height:		50,         // Height of the list
	arrows:		true,       // Display arrows to the left and top or the top and bottom
	arrowsOpacity:	0.7,    // Maximum opacity of the arrows if fixedArrows
    fixedArrows: false,     // Fix the displayed arrows to the side of the list
	rtl:		false,		// Set display mode to "Right to Left"
	debug:		false,       // Display some debugging information in firebug console
	hoverZone:	'gradual'       // Display some debugging information in firebug console
};


$.fn.hoverscroll.destroy = function(el) {
	var container = el.parent().parent(),
		originalContainer = container.parent();
		
		$(el).prependTo(originalContainer)
		.removeClass('listitem')
		.removeAttr("style");
		
		container.remove();
		
	//console.log(el.parent().parent());
};

/**
 * Log errors to consoles (firebug, opera) if exist, else uses alert()
 */
$.log = function() {
	try {console.log.apply(console, arguments);}
	catch (e) {
		try {opera.postError.apply(opera, arguments);}
		catch (e) {
//            alert(Array.prototype.join.call(arguments, " "));
        }
	}
};


})(jQuery);
