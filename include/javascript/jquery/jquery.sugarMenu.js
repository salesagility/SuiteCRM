/* This is a simple plugin to render action dropdown menus from html.
 * John Barlow - SugarCRM
 * add secondary popup implementation by Justin Park - SugarCRM
 *
 * The html structure it expects is as follows:
 *
 * <ul>                                     - Menu root
 *      <li>                                - First element in menu (visible)
 *      <ul class="subnav">		            - Popout menu (should start hidden)
 *          <li></li>                       - \
 *          ...                             -  Elements in popout menu
 *          <li></li>                       - /
 *          <li>
 *              <input></input>  - element contains submenu
 *              <ul class="subnav-sub">     - sub-popout menu (shown when mouseover on the above element)
 *                  <li></li>               - \
 *                  ...                     -  Elements in sub-popout menu
 *                  <li></li>               - /
 *              </ul>
 *          </li>
 *      </ul>
 *      </li>
 * </ul>
 *
 * By adding a class of "fancymenu" to the menu root, the plugin adds an additional "ab" class to the
 * dropdown handle, allowing you to make the menu "fancy" with additional css if you would like :)
 *
 * Functions:
 *
 * 		init: initializes things (called by default)... currently no options are passed
 *
 * 		Adds item to the menu at position index
 * 		addItem: (item, index)
 * 			item - created dom element or string that represents one
 * 			index(optional) - the position you want your new menuitem. If you leave this off,
 * 				the item is appended to the end of the list.
 *      	returns: nothing
 *
 *      Finds an item in the menu (including the root node "outside" the ul structure).
 * 		findItem: (item)
 * 			item - string of the menu item you are looking for.
 * 			returns: index of element, or -1 if not found.
 */
(function($){
	var methods = {
		init: function(options){

			var menuNode = this;
			if(!this.hasClass("SugarActionMenu")){
				//tag this element as a sugarmenu
				this.addClass("SugarActionMenu");

				//Fix custom code buttons programatically to prevent metadata edits
				this.find("input[type='submit'], input[type='button']").each(function(idx, node){
					var jNode = $(node);
					var parent = jNode.parent();
                    var _subnav = menuNode.find("ul.subnav");
                    var _timer_for_subnav = null;
                    var disabled = $(this).prop('disabled');
					var newItem = $(document.createElement("li"));
					var newItemA = $(document.createElement("a"));
                    var accesskey = jNode.attr("accesskey");
                    var accesskey_el = $("<a></a>");

					newItemA.html(jNode.val());
                    if(!disabled )
                    {
                        newItemA.click(function(event){
                        	if($(this).hasClass("void") === false ){
                        		jNode.click();
                        	}
                        });
                    }
                    else
                    {
                        newItemA.addClass("disabled");
                    }
					newItemA.attr("id", jNode.attr("id"));
                    accesskey_el.attr("id", jNode.attr("id") + "_accesskey");
					jNode.attr("id", jNode.attr("id") + "_old");


                    if(accesskey !== undefined) {
                        if($('#'+accesskey_el.attr('id')).length === 0) {
                            accesskey_el.attr("accesskey", accesskey).click(function() {
                                jNode.click();
                            }).appendTo("#content");
                        }
                        jNode.attr("accesskey", '');
                    }

					//make sure the node we found isn't the main item of the list -- we don't want
					//to show it then.
					if(menuNode.sugarActionMenu("findItem", newItemA.html()) == -1){
                        parent.prepend(newItemA);
                    }

                    //make sub sliding menu
                    jNode.siblings(".subnav-sub").each(function(idx, node) {
                        var _menu = $(node);
                        var _hide_menu = function() {
                            if( _menu.hasClass("hover") === false )
                                _menu.hide();
                        };
                        var _hide_timer = null;
                        var _delay = 300;
                        _menu.mouseover(function(evt){
                                if( $(this).hasClass("hover") === false )
                                    $(this).addClass("hover");
                            }).mouseout(function(evt){
                                if( $(this).hasClass("hover") )
                                    $(this).removeClass("hover");
                                if(_hide_timer)
                                    clearTimeout(_hide_timer);
                                _hide_timer = setTimeout(_hide_menu, _delay);
                            });

                        newItemA.mouseover(function(evt) {
                                $("ul.SugarActionMenu ul.subnav-sub").each(function(index, node){
                                    $(node).removeClass("hover");
                                    $(node).hide();
                                });
                                var _left = parent.offset().left + parent.width() - newItemA.css("paddingRight").replace("px", "");
                                var _top = parent.offset().top - _menu.css("paddingTop").replace("px", "");
                                _menu.css({
                                    left: _left,
                                    top: _top
                                    });
                                if( _menu.hasClass("hover") === false )
                                    _menu.addClass("hover");
                                if( _subnav.hasClass("subnav-sub-handler") === false )
                                    _subnav.addClass("subnav-sub-handler");
                                _menu.show();
                            }).mouseout(function(evt) {
                                _menu.removeClass("hover");
                                _subnav.removeClass("subnav-sub-handler")
                                if(_hide_timer)
                                    clearTimeout(_hide_timer);
                                _hide_timer = setTimeout(_hide_menu, _delay);
                            }).click(function(evt){
                                if(_timer_for_subnav)
                                    clearTimeout(_timer_for_subnav);
                            }).addClass("void");
                        menuNode.append(_menu);
                    });
                    jNode.css("display", "none");
				});


				//look for all subnavs and set them up
				this.find("ul.subnav").each(function(index, node){
					var jNode = $(node);
					var parent = jNode.parent();
					var fancymenu = "";
					var slideUpSpeed = 1;
					var slideDownSpeed = 1;
                    var dropDownHandle;

					//if the dropdown handle doesn't exist, lets create it and
					//add it to the dom
					if(parent.find("span").length == 0){

						//create dropdown handle
						dropDownHandle = $(document.createElement("span"));
						parent.append(dropDownHandle);

					} else {
						dropDownHandle = $(parent.find("span"));
					}


						//add click handler to handle
						dropDownHandle.click(function(event){


							//close all other open menus
                            //retore the dom elements back by handling iefix
                            $("ul.SugarActionMenu > li").each(function() {
                                $(this).sugarActionMenu('IEfix');
                            });
							$("ul.SugarActionMenu ul.subnav").each(function(subIndex, node){
								var subjNode = $(node);
								if(!(subjNode[0] === jNode[0])){
									subjNode.slideUp(slideUpSpeed);
									subjNode.removeClass("ddopen");
								}
							});
							if(jNode.hasClass("ddopen")){
                                parent.sugarActionMenu('IEfix');
                                //Bug#50983: Popup the dropdown list above the arrow if the bottom part is cut off .
                                var _animation = {
                                    'height' : 0
                                };
                                if(jNode.hasClass("upper")) {
                                    _animation['top'] = (dropDownHandle.height() * -1);
                                }
								jNode.animate(_animation, slideUpSpeed, function() {
                                    $(this).css({
                                        'height' : '',
                                        'top' : ''
                                    }).hide().removeClass("upper ddopen");
                                });
							}
							else{
                                //To support IE fixed size rendering,
                                //parse out dom elements out of the fixed element
                                parent.sugarActionMenu('IEfix', jNode);
                                var _dropdown_height = jNode.height(),
                                    _animation = { 'height' : _dropdown_height },
                                    _dropdown_bottom = dropDownHandle.offset().top + dropDownHandle.height() - $(document).scrollTop() + jNode.outerHeight(),
                                    _win_height = $(window).height();
                                if(dropDownHandle.offset().top > jNode.height() && _dropdown_bottom > $(window).height()) {
                                    jNode.css('top', (dropDownHandle.height() * -1)).addClass("upper");
                                    _animation['top'] = (jNode.height() + dropDownHandle.height()) * -1;
                                }

								jNode.height(0).show().animate(_animation,slideDownSpeed, function() {
                                    $(this).css('height', '');
                                });
								jNode.addClass("ddopen");
							}
							event.stopPropagation();
						});

						//add submenu click off to body
						var jBody = $("body");
                        var _hide_subnav_delay = 30;
                        var _hide_subnav = function(subnav) {
                            if( subnav.hasClass("subnav-sub-handler") === false ) {
                                subnav.slideUp(slideUpSpeed);
                                subnav.removeClass("ddopen");
                            }
                        }
						if(jBody.data("sugarActionMenu") != true){
							jBody.data("sugarActionMenu", true);
							jBody.bind("click", function(){
                                //retore the dom elements back by handling iefix
                                $("ul.SugarActionMenu > li").each(function() {
                                    $(this).sugarActionMenu('IEfix');
                                });

								$("ul.SugarActionMenu ul.subnav").each(function(subIndex, node){
                                    //prevent hiding the submenu when user click the submenu which contains one more depth submenu
                                    var _hide = function() {
                                        _hide_subnav($(node));
                                    }
                                    setTimeout(_hide, _hide_subnav_delay);
								});
                                //Hide second depth submenu
                                $("ul.SugarActionMenu ul.subnav-sub").each(function(subIndex, node){
                                    var _hide = function() {
                                        $(this).removeClass("hover");
                                        $(this).hide();
                                    }
                                    _timer_for_subnav = setTimeout(_hide, _hide_subnav_delay);
                                });

							});
						}

						//add hover handler to handle
						dropDownHandle.hover(function(){
							dropDownHandle.addClass("subhover");
						}, function(){
							dropDownHandle.removeClass("subhover");
						});




					//bind click event to submenu items to hide the menu on click
					jNode.find("li").each(function(index, subnode){
                        //prevent hiding the submenu when user click the submenu which contains one more depth submenu
						$(subnode).bind("click", function(evt){
							var _hide = function() {
                                _hide_subnav(jNode);
                            }
                            setTimeout(_hide, _hide_subnav_delay);
						});
					});

					//fix up text of <a> tags so they span correctly
					jNode.find("a").each(function(index, subnode){
						$(subnode).html(function(index, oldhtml){
							return oldhtml.replace(" ", "&nbsp;");
						});
					});
				});

                //Bug#51579: delete li tags which contains empty due to access role
                this.find(".subnav > li").each(function(index, subnode) {
                    if($(subnode).html().replace(/ /g, '') == '') {
                        $(subnode).remove();
                    }
                });
                //Bug#51579: If the first item is empty due to the access role,
                //           replace the first button from the first of the sub-list items.
                this.find("li.sugar_action_button:first").each(function(index, node) {
                    var _this = $(node);
                    var _first_item = $(node).find("a:first").not($(node).find(".subnav > li a"));
                    if(_first_item.length == 0) {
                        var sub_items = $(node).find(".subnav > li:first").children();
                        if(sub_items.length == 0)
                            menuNode.hide();
                        else
                            _this.prepend(sub_items);
                    }
                });


			}
			return this;
		},
		addItem : function(args){
			if(args.index == null){
				this.find("ul.subnav").each(function(index, node){
					$(node).append(args.item);
				})
			}
			else{
				this.find("ul.subnav").find("li").each(function(index, node){
					if(args.index == index+1){
						$(node).before(args.item);
					}
				});
			}
			return this;
		},
		findItem: function(item){
			var index = -1;
			this.find("a").each(function(idx, node){
				var jNode = $(node);
				if($.trim(jNode.html()) == $.trim(item)){
					index = idx;
				}
			});
			return index;
		},
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
    IEfix: function($ul) {
            if($ul) {
                if( $ul.hasClass('iefixed') === false)
                    return;
                this.each(function(){
                    SUGAR.themes.counter = SUGAR.themes.counter ? SUGAR.themes.counter++ : 1;
                    var $$ = $(this),
                        _id = $$.attr("ul-child-id") ? $$.attr("ul-child-id") : ($$.parent('.SugarActionMenu').attr("id")) ? $$.parent('.SugarActionMenu').attr("id") + 'Subnav' : 'sugaractionmenu' + SUGAR.themes.counter,
                        _top = $$.position().top + $$.outerHeight(),
                        _width = 'auto', //to obtain a certain size, apply min-width in css
                        _css = {
                            top: _top,
                            width: _width,
                            position: 'fixed'
                        },
                        _right = $('body').width() - $$.offset().left - $$.width(),
                        _left = $$.offset().left;
                    //fixed positioning depends on the css property
                    if($ul.css('right') != 'auto') {
                        _css['right'] = _right;
                    } else {
                        _css['left'] = _left;
                    }
                    $('body').append($ul.attr("id", _id).addClass("SugarActionMenuIESub").css(_css));
                    $$.attr("ul-child-id", _id);
                });

            } else {
                this.each(function(){
                    var _id = $(this).attr("ul-child-id");
                    $(this).append($("body>#"+_id).removeClass("SugarActionMenuIESub"));
                });
            }
        }
	}

	$.fn.sugarActionMenu = function(method) {

		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(
					arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.tooltip');
		}
	}
})(jQuery);
