/* jQuery elementReady plugin
 * Version 0.6
 * Copyright (C) 2007-08 Bennett McElwee.
 * Licensed under a Creative Commons Attribution-Share Alike 3.0 Unported License (http://creativecommons.org/licenses/by-sa/3.0/)
 * Permissions beyond the scope of this license may be available at http://www.thunderguy.com/semicolon/.
 */

/*
	IMPLEMENTATION NOTES
	There may be race conditions. The most likely could occur if check() is
	called while a previous invocation of check() is still running. This could
	cause a callback to be called more than once, or not at all. Less likely is
	for elementReady() to be called concurrently with check() (with similar
	effects) or with itself (which could cause an interval to run forever).
	None of these are likely to occur. In fact I don't think they are possible
	at all except on IE. -- Bennett McElwee, August 2007
*/
(function($) {

/**
 * While a page is loading, call a given callback function as soon as a specific
 * element (with a specific ID) is loaded into the DOM, even before the full DOM
 * has been loaded. Executes the function within the context of the element. This
 * means that when the passed-in function is executed, the 'this' keyword points
 * to the specific DOM element.
 *
 * The function returns 'this', so you can chain multiple calls to
 * elementReady(). (Not that there's much benefit in doing that.)
 *
 * One argument is passed to the callback: a reference to the jQuery function.
 * You can name this argument $ and therefore use the $ alias even in
 * noConflict mode.
 *
 * If the element has not been found by the time the DOM is fully loaded, then
 * the function will not be called.
 *
 * The function works by polling the DOM at short intervals. By default it polls
 * every 23 milliseconds, but you can change this by setting
 * $.elementReady.interval_ms to whatever value you like.
 * Don't bother changing this unless you really know what you're doing.
 *
 * @example
 * $.elementReady('powerpic', function(){
 *     this.src = 'powered-by-jquery.png';
 * });
 * @desc Change the source of a specific image as soon as it is loaded into the
 * DOM (before the whole DOM is loaded).
 *
 * @example
 * $.elementReady('header', function(){
 *     $(this).addClass('fancy');
 * });
 * @desc If you want to have the jQuery object instead of the regular DOM
 * element, use the $(this) function.
 *
 * @example
 * $.elementReady('first',  function(){ $(this).fancify(); })
 *  .elementReady('second', function(){ $(this).fancify(); });
 * @desc Chain multiple calls to $.elementReady().
 *
 * @example
 * jQuery.noConflict();
 * jQuery.elementReady('header', function($){
 *     $(this).addClass('fancy');
 * });
 * @desc Use the '$' alias within your callback, even in noConflict mode.
 *
 * @example
 * $.elementReady.interval_ms = 100;
 * @desc Change the polling interval to 100ms. This only works if $.elementReady()
 * has not yet been called.
 *
 * @name   $.elementReady
 * @type   jQuery
 * @param  String   id  string ID of the element to wait for
 * @param  Function fn  function to call when the element is ready
 * @return jQuery
 * @cat    Plugins/Event
 * @author Bennett McElwee
 */
var interval = null;
var checklist = [];

$.elementReady = function(id, fn) {
	checklist.push({id: id, fn: fn});
	if (!interval) {
		interval = setInterval(check, $.elementReady.interval_ms);
	}
	return this;
};

// Plugin settings
$.elementReady.interval_ms = 23; // polling interval in ms

// Private function
function check() {
	var docReady = $.isReady; // check doc ready first; thus ensure that check is made at least once _after_ doc is ready
	for (var i = checklist.length - 1; 0 <= i; --i) {
		var el = document.getElementById(checklist[i].id);
		if (el) {
			var fn = checklist[i].fn; // first remove from checklist, then call function
			checklist[i] = checklist[checklist.length - 1];
			checklist.pop();
			fn.apply(el, [$]);
		}
	}
	if (docReady) {
		clearInterval(interval);
		interval = null;
	}
};

})(jQuery);
