/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */

/**
 * A 1/2 second fade-in animation.
 *
 * @constructor
 * @param el {HTMLElement} the element to animate
 * @param callback {function} function to invoke when the animation is finished
 */
YAHOO.widget.TVFadeIn = function(el, callback) {
	/**
	 * The element to animate
     * @type HTMLElement
	 */
	this.el = el;

	/**
	 * the callback to invoke when the animation is complete
	 *
	 * @type function
	 */
	this.callback = callback;

	/**
	 * @private
	 */
	this.logger = new ygLogger("TVFadeIn");
};

/**
 * Performs the animation
 */
YAHOO.widget.TVFadeIn.prototype = {
    animate: function() {
        var tvanim = this;

        var s = this.el.style;
        s.opacity = 0.1;
        s.filter = "alpha(opacity=10)";
        s.display = "";

        // var dur = ( navigator.userAgent.match(/msie/gi) ) ? 0.05 : 0.4;
        var dur = 0.4; 
        // this.logger.debug("duration: " + dur);
        // var a = new ygAnim_Fade(this.el, dur, 1);
        // a.setStart(0.1);
        // a.onComplete = function() { tvanim.onComplete(); };

        // var a = new YAHOO.util.Anim(this.el, 'opacity', 0.1, 1);
        var a = new YAHOO.util.Anim(this.el, {opacity: {from: 0.1, to: 1, unit:""}}, dur);
        a.onComplete.subscribe( function() { tvanim.onComplete(); } );
        a.animate();
    },

    /**
     * Clean up and invoke callback
     */
    onComplete: function() {
        this.callback();
    }
};

