/*
* Superfish v1.4.8 - jQuery menu widget
* Copyright (c) 2008 Joel Birch
*
* Dual licensed under the MIT and GPL licenses:
* http://www.opensource.org/licenses/mit-license.php
* http://www.gnu.org/licenses/gpl.html
*
* CHANGELOG: http://users.tpg.com.au/j_birch/plugins/superfish/changelog.txt
*/

; (function($) {
    $.fn.superfish = function(op) {

        var sf = $.fn.superfish,
        c = sf.c,
        menuActive = false,
        $arrow = $(['<span class="', c.arrowClass, '"> &#187;</span>'].join('')),
        click = function(evt) {
        	$(".subnav.ddopen").hide();
            var $$ = $(this),
            menu = getMenu($$),
            o = sf.op;
            if (o.firstOnClick && !menuActive && $$.parent()[0] == menu)
            {
                menuActive = true;
                clearTimeout(menu.sfTimer);

                $$.showSuperfishUl().siblings().hideSuperfishUl();
                // prevent redirect to anchor target href
                evt.preventDefault();
            }
        },
        over = function() {
            var $$ = $(this),
            menu = getMenu($$),
            o = sf.op;
            //Bug#52225: Activate submenu while hs-activated
            if($$.parent().hasClass("hs-active")) {
                $$.addClass("iefix");
            } else {
                $$.removeClass("iefix");
            }

            if (!o.firstOnClick || menuActive || $$.parent()[0] != menu)
            {
                clearTimeout(menu.sfTimer);
                $$.showSuperfishUl().siblings().hideSuperfishUl();
                if($$.parent().hasClass('megamenuSiblings')) {
                	$$.parent().siblings().children('li').hideSuperfishUl();
                }
            }
        },
        out = function() {
            var $$ = $(this),
                menu = getMenu($$),
                o = sf.op,
                $menu = $(menu);
            //Bug#52225: Activate submenu while hs-activated
            if($$.parent().hasClass("hs-active")) {
                $$.addClass("iefix");
                setTimeout(function() {
                    if($menu.hasClass(sf.defaults['retainClass']) === false)
                        $$.hideSuperfishUl();
                }, o.delay);
            } else {
                $$.removeClass("iefix");
            }

            clearTimeout(menu.sfTimer);
            menu.sfTimer = $menu.hasClass(sf.defaults['retainClass']) ? null : setTimeout(function() {
                if($menu.hasClass(sf.defaults['retainClass']) === false) {
                    o.retainPath = ($.inArray($$[0], o.$path) > -1);
                    $$.hideSuperfishUl();
                    if (o.$path.length && $$.parents(['li.', o.hoverClass].join('')).length < 1)
                    {
                        over.call(o.$path);
                    }
                    else
                    {
                        menuActive = false;
                    }
                }

            },
            o.delay);
        },
        getMenu = function($menu) {
            var menu = $menu.hasClass(sf.menuClass) ? $menu[0] : $menu.parents(['ul.', c.menuClass, ':first'].join(''))[0];
            if(!menu)
                return $menu[0];
            sf.op = sf.o[menu.serial];
            return menu;
        },
        addArrow = function($a) {
            $a.addClass(c.anchorClass).append($arrow.clone());
        };
        sf.getMenu = getMenu;
        return this.each(function() {
            var s = this.serial = sf.o.length;
            var o = $.extend({},
            sf.defaults, op);
            o.$path =
            $('li.' + o.pathClass, this).slice(0, o.pathLevels).each
            (function() {

                $(this).addClass([o.hoverClass, c.bcClass].join(' '))

                .filter('li:has(ul)').removeClass(o.pathClass);
            });
            sf.o[s] = sf.op = o;

			if(o.firstOnClick){
				$('li:has(ul)', this).not('li:has( > .' + sf.ignoreClass + ')')['click'](click);
			} else {
				$('li:has(ul)', this).not('li:has( > .' + sf.ignoreClass + ')')[($.fn.hoverIntent && !o.disableHI) ? 'hoverIntent' : 'hover'](over, out);
			}
            
            $('li:has(ul)', this)
            .click(click)
            .each(function() {
                if (o.autoArrows) addArrow(
                $('>a:first-child', this));
            })
            .not('.' + c.bcClass)
            .hideSuperfishUl();

            var $a = $('a', this);
            $a.each(function(i) {
                var $li = $a.eq(i).parents('li');

                $a.eq(i).attr("tabindex",-1).focus(function() {
                    over.call($li);
                }).blur(function()
                {
                    out.call($li);
                });
                
                
                if(o.firstOnClick) {
	                $a.eq(i).click(function(event)
	                {
					  event.preventDefault();
					  if ( !$a.eq(i).hasClass("sf-with-ul") || $li.children('ul').size() == 0) {
					    SUGAR.ajaxUI.loadContent(this.href);
					  }
					});
					
					
					$a.eq(i).dblclick(function(event)
	                {
	                    SUGAR.ajaxUI.loadContent(this.href);
					});
                }
				
            });
            o.onInit.call(this);

        }).each(function() {
            var menuClasses = [c.menuClass];
            if (sf.op.dropShadows && !($.browser.msie &&
            $.browser.version <
            7)) menuClasses.push(c.shadowClass);
            $(this).addClass(menuClasses.join(' '));
        });
    };

    var sf = $.fn.superfish;
    sf.o = [];
    sf.op = {};
    sf.counter = 0;
    sf.IE7fix = function() {
        var o = sf.op;
        if ($.browser.msie && $.browser.version > 6 && o.dropShadows &&
        o.animation.opacity != undefined)
        this.toggleClass(sf.c.shadowClass + '-off');
    };
    
     sf.positionMenu = function($ul) {
         //reset css generating by positionMenu
        this.removeClass("rtl ltr");

    	if(this.offset() && this.parent().parent().hasClass('sf-menu') != true) {
            //reset position to origin
            var is_rtl_theme = sf.op['rtl'] || sf.defaults['rtl'];
            if(is_rtl_theme) {
                this.css({
                    'left' : 'auto',
                    'right' : this.attr("right") ? this.attr("right") : this.css("right"),
                    'top' : 0,
                    'bottom' : 'auto'
                });
            } else {
                this.css({
                    'left' : this.attr("left") ? this.attr("left") : this.css("left"),
                    'right' : 'auto',
                    'top' : 0,
                    'bottom' : 'auto'
                });
            }
            var viewPortHeight = $(window).height(),
                viewPortWidth = $(window).width(),
                submenuHeight = this.outerHeight(),
                megamenuWidth = (is_rtl_theme) ? this.parent().outerWidth() : sf.cssValue.call(this, 'left'),
                submenuTop = this.offset().top - $(document).scrollTop(),
                submenuLeft = this.offset().left - $(document).scrollLeft(),
                megamenuLeft = this.parent().offset().left - $(document).scrollLeft(),
                viewPortRSpace = (is_rtl_theme) ? viewPortWidth - megamenuLeft - megamenuWidth : viewPortWidth - submenuLeft,
                viewPortLSpace = (is_rtl_theme) ? megamenuLeft : submenuLeft - megamenuWidth;

            //Followings are required to optimize calculation in IE
            if(megamenuWidth == 0) {
                megamenuWidth = this.parent().outerWidth();
                viewPortRSpace -= megamenuWidth;
            }
    		if(submenuTop + submenuHeight > viewPortHeight) {
    			this.css('top',viewPortHeight - submenuTop - submenuHeight);
    		}
            if(is_rtl_theme === false && viewPortRSpace < viewPortLSpace && viewPortRSpace < megamenuWidth) {
                var _left = this.css('left');
                this.attr("left", _left).css({
                    'left': 'auto',
                    'right': _left
                }).addClass("rtl");
            } else if(is_rtl_theme && viewPortRSpace > viewPortLSpace && viewPortLSpace < megamenuWidth) {
                var _right = this.css('right');
                this.attr("right", _right).css({
                    'left': _right,
                    'right': 'auto'
                }).addClass("ltr");
            }
    	}
    }
    /**
     * Return css property variale which contains numerical data.
     * i.e. width, border, padding-left, etc.
     * @param this - element that is trying to retrive
     * @param $css - css properity which contains numerical data
     * @return int - value of the size
     */
    sf.cssValue = function($css) {
        if(this.length == 0)
            return 0;
        var _val = parseInt(this.css($css).replace("px", ""));
        return (_val) ? _val : 0;
    };
    /**
     * To support IE fixed size rendering,
     * parse out dom elements out of the fixed element
     *
     * Prepare ===
     * <div style=position:fixed>
     *     ...
     *     <li jquery-attached>
     *         <ul style=position:absoulte>
     *             ...
     *         </ul>
     *     </li>
     * </div>
     *
     * Application ===
     * <div style=position:fixed>
     *     <li ul-child-id='auto-evaluted-id'>
     *     ...
     *     </li>
     * </div>
     *
     * <ul id='auto-evaluted-id' style=position:fix;left/right/top-positioning:auto-calculated>
     *     ...
     * </ul>
     * @param this - element container which is inside the fixed box model
     * @param $ul - dropdown box model which needs to render out of the fixed box range
     *              if $ul is not given, it will restore back to the original structure
     */
    sf.IEfix = function($ul) {
        if ( ($.browser.msie && $.browser.version > 6) || $(this).hasClass("iefix") ) {
            if($ul) {
                //Take out the element out of the fixed box model,
                //and then append it into the end of body container
                this.each(function(){
                    var $$ = $(this),
                        o = sf.op,
                        is_rtl_theme = sf.op['rtl'] || sf.defaults['rtl'],
                        _id = $$.attr("ul-child-id") ? $$.attr("ul-child-id") : ($ul.attr('id')) ? $ul.attr('id') : o.megamenuID ? o.megamenuID + ++sf.counter : 'megamenu' + ++sf.counter,
                        _top = $$.position().top + $$.parent().offset().top - $(document).scrollTop(),
                        _rtl_adjustment = $$.width() - $ul.width(),
                        _left = $$.offset().left - sf.cssValue.call($ul, "border-left-width") - $(document).scrollLeft(),
                        _right = $(window).width() - _left - $$.width() - sf.cssValue.call($ul, "border-right-width"),
                        $menu = $('ul.' + sf.c.menuClass + ':visible');

                    //handling sub-sliding menu
                    if($$.css('position') == 'static' || $$.parent().hasClass('megamenuSiblings')) {

                        //When the submenu is positioned to the left-hand side, the absolute position should be adjusted as expected
                        if(is_rtl_theme) {
                            _right = $ul.hasClass("ltr") ?_right - $ul.outerWidth()
                                : _right + $$.outerWidth();
                        } else {
                            _left = $ul.hasClass("rtl") ? _left - $ul.outerWidth()
                                : _left + $$.outerWidth();
                        }
                        _top += sf.cssValue.call($ul, "top");
                        $ul.addClass('sf-sub-modulelist').on('mouseover', function(){
                                $$.addClass(sf.defaults['retainClass']);
                            }).on('mouseout', function(){
                                $$.removeClass(sf.defaults['retainClass']);
                                $('ul.' + sf.c.menuClass + ':visible').removeClass(sf.defaults['retainClass'])[0].sfTimer = setTimeout(function(){
                                    $$.hideSuperfishUl();
                                    $('ul.' + sf.c.menuClass + ':visible > li').hideSuperfishUl();
                                }, o.delay);
                            });
                    } else {
                        _top += $$.outerHeight();
                    }

                    //append the item into the body element, and then save the id to restore back later
                    $('body').append($ul.attr("id", _id).css({
                        top: _top,
                        left: (is_rtl_theme) ? '' : _left,
                        right: (is_rtl_theme) ? _right : '',
                        position: 'fixed'
                        }).on('mouseover',function(){
                            //maintaining the dropdown container
                            var menu = sf.getMenu($menu),
                                o = sf.op;
                            clearTimeout(menu.sfTimer);
                            if( $(menu).hasClass(sf.defaults['retainClass']) === false )
                                $(menu).addClass(sf.defaults['retainClass']);
                        }).on('mouseout', function(){
                            //clear out the dropdown menu
                            var menu = sf.getMenu($menu),
                                o = sf.op;
                            clearTimeout(menu.sfTimer);

                            menu.sfTimer = setTimeout(function() {
                                $$.hideSuperfishUl();
                                $(menu).removeClass(sf.defaults['retainClass']);
                                $(menu).hideSuperfishUl();
                            }, o.delay)
                        })
                    );
                    $$.attr("ul-child-id", _id);
                });

            } else {
                //restore back the element to the original structure
                this.each(function(){
                    var _id = $(this).attr("ul-child-id"),
                        _elem = $("#"+_id);
                    $(this).append(_elem.off('mouseover mouseout').css({
                        'left' : '',
                        'right' : '',
                        'top' : '',
                        'bottom' : '',
                        'position': ''
                    }));
                });
            }
        }
    };
    sf.c = {
        bcClass: 'sf-breadcrumb',
        menuClass: 'sf-js-enabled',
        anchorClass: 'sf-with-ul',
        arrowClass: 'sf-sub-indicator',
        shadowClass: 'sf-shadow'
    };
    sf.defaults = {
        hoverClass: 'sfHover',
        retainClass: 'retainThisItem',
        ignoreClass: 'none',
        pathClass: 'overideThisToUse',
        pathLevels: 8,
        delay: 800,
        animation: {
            opacity: 'show'
        },
        speed: 'normal',
        autoArrows: true,
        dropShadows: true,
        disableHI: false,
        // true disables hoverIntent detection
        onInit: function() {},
        // callback functions
        onBeforeShow: function() {},
        onShow: function() {},
        onHide: function() {},
        firstOnClick: false,
        // true - open first level on click (like classic application menu),
        rtl: false
        // true - if it is RTL theme

    };
    $.fn.extend({
        hideSuperfishUl: function() {
            var o = sf.op,
            not = (o.retainPath === true) ? o.$path: '';
            o.retainPath = false;
            sf.IEfix.call(this);
            var $ul = $(['li.', o.hoverClass].join(''), this).add(this).not
                (not).removeClass(o.hoverClass).find('>ul').hide().css('visibility', 'hidden');
            o.onHide.call($ul);
            return this;
        },
        showSuperfishUl: function() {
            var o = sf.op,
            sh = sf.c.shadowClass + '-off',
            $ul = this.addClass(o.hoverClass).find('>ul:hidden').show().css('visibility', 'visible');
            sf.positionMenu.call($ul);
            sf.IE7fix.call($ul);
            o.onBeforeShow.call($ul);
            sf.IEfix.call(this, $ul);
            $ul.animate(o.animation, o.speed,
            function() {
                sf.IE7fix.call($ul);
                o.onShow.call($ul);
            });
            return this;
        }
    });

})(jQuery);
