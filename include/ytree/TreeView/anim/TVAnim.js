/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */

/**
 * A static factory class for tree view expand/collapse animations
 *
 * @constructor
 */
YAHOO.widget.TVAnim = new function() {
	/**
	 * Constant for the fade in animation
	 * 
	 * @type string
	 */
	this.FADE_IN  = "YAHOO.widget.TVFadeIn";

	/**
	 * Constant for the fade out animation
	 * 
	 * @type string
	 */
	this.FADE_OUT = "YAHOO.widget.TVFadeOut";

	/**
	 * Returns a ygAnim instance of the given type
	 *
	 * @param type {string} the type of animation
	 * @param el {HTMLElement} the element to element (probably the children div)
	 * @param callback {function} function to invoke when the animation is done.
	 * @return {YAHOO.util.Animation} the animation instance
	 */
	this.getAnim = function(type, el, callback) {
		switch (type) {
			case this.FADE_IN:	return new YAHOO.widget.TVFadeIn(el, callback);
			case this.FADE_OUT:	return new YAHOO.widget.TVFadeOut(el, callback);
			default:			return null;
		}
	};

	/**
	 * Returns true if the specified animation class is available
	 *
	 * @param type {string} the type of animation
	 * @return {boolean} true if valid, false if not
	 */
	this.isValid = function(type) {
		return ( "undefined" != eval("typeof " + type) );
	};
};

