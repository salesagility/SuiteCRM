/*
 * jQuery showLoading plugin v1.0
 *
 * Copyright (c) 2009 Jim Keller
 * Context - http://www.contextllc.com
 *
 * Dual licensed under the MIT and GPL licenses.
 *
 */

	jQuery.fn.showLoading = function(options) {

		var indicatorID;
       		var settings = {
       			'addClass': '',
	       		'beforeShow': '',
       			'afterShow': '',
       			'hPos': 'center',
	       		'vPos': 'center',
       			'indicatorZIndex' : 5001,
       			'overlayZIndex': 5000,
	       		'parent': '',
       			'marginTop': 0,
       			'marginLeft': 0,
	       		'overlayWidth': null,
       			'overlayHeight': null
	       	};

		jQuery.extend(settings, options);

       	var loadingDiv = jQuery('<div></div>');
		var overlayDiv = jQuery('<div></div>');

		// Set up ID and classes
		if ( settings.indicatorID ) {
			indicatorID = settings.indicatorID;
		}
		else {
			indicatorID = jQuery(this).attr('id');
		}

		jQuery(loadingDiv).attr('id', 'loading-indicator-' + indicatorID );
		jQuery(loadingDiv).addClass('loading-indicator-ui');

		if ( settings.addClass ){
			jQuery(loadingDiv).addClass(settings.addClass);
		}


		// Create the overlay
		jQuery(overlayDiv).css('display', 'none');

		// Append to body, otherwise position() doesn't work on Webkit-based browsers
		jQuery(document.body).append(overlayDiv);

		// Set overlay classes
		jQuery(overlayDiv).attr('id', 'loading-indicator-' + indicatorID + '-overlay');

		jQuery(overlayDiv).addClass('loading-indicator-ui-overlay');

		if ( settings.addClass ){
			jQuery(overlayDiv).addClass(settings.addClass + '-overlay');
		}

		// Set overlay position

		var overlay_width;
		var overlay_height;

		var border_top_width = jQuery(this).css('border-top-width');
		var border_left_width = jQuery(this).css('border-left-width');

		//
		// IE will return values like 'medium' as the default border,
		// but we need a number
		//
		border_top_width = isNaN(parseInt(border_top_width)) ? 0 : border_top_width;
		border_left_width = isNaN(parseInt(border_left_width)) ? 0 : border_left_width;

		var overlay_left_pos = jQuery(this).offset().left + parseInt(border_left_width);
		var overlay_top_pos = jQuery(this).offset().top + parseInt(border_top_width);

		if ( settings.overlayWidth !== null ) {
			overlay_width = settings.overlayWidth;
		}
		else {
			overlay_width = parseInt(jQuery(this).width()) + parseInt(jQuery(this).css('padding-right')) + parseInt(jQuery(this).css('padding-left'));
		}

		if ( settings.overlayHeight !== null ) {
			overlay_height = settings.overlayWidth;
		}
		else {
			overlay_height = parseInt(jQuery(this).height()) + parseInt(jQuery(this).css('padding-top')) + parseInt(jQuery(this).css('padding-bottom'));
		}


		jQuery(overlayDiv).css('width', overlay_width.toString() + 'px');
		jQuery(overlayDiv).css('height', overlay_height.toString() + 'px');

		jQuery(overlayDiv).css('left', overlay_left_pos.toString() + 'px');
		jQuery(overlayDiv).css('position', 'absolute');

		jQuery(overlayDiv).css('top', overlay_top_pos.toString() + 'px' );
		jQuery(overlayDiv).css('z-index', settings.overlayZIndex);

		// Set any custom overlay CSS
       		if ( settings.overlayCSS ) {
       			jQuery(overlayDiv).css ( settings.overlayCSS );
       		}


		//
		// We have to append the element to the body first
		// or .width() won't work in Webkit-based browsers (e.g. Chrome, Safari)
		//
		jQuery(loadingDiv).css('display', 'none');
		jQuery(document.body).append(loadingDiv);

		jQuery(loadingDiv).css('position', 'absolute');
		jQuery(loadingDiv).css('z-index', settings.indicatorZIndex);

		// Set top margin

		var indicatorTop = overlay_top_pos;

		if ( settings.marginTop ) {
			indicatorTop += parseInt(settings.marginTop);
		}

		var indicatorLeft = overlay_left_pos;

		if ( settings.marginLeft ) {
			indicatorLeft += parseInt(settings.marginTop);
		}


		// set horizontal position
		if ( settings.hPos.toString().toLowerCase() == 'center' ) {
			jQuery(loadingDiv).css('left', (indicatorLeft + ((jQuery(overlayDiv).width() - parseInt(jQuery(loadingDiv).width())) / 2)).toString()  + 'px');
		}
		else if ( settings.hPos.toString().toLowerCase() == 'left' ) {
			jQuery(loadingDiv).css('left', (indicatorLeft + parseInt(jQuery(overlayDiv).css('margin-left'))).toString() + 'px');
		}
		else if ( settings.hPos.toString().toLowerCase() == 'right' ) {
			jQuery(loadingDiv).css('left', (indicatorLeft + (jQuery(overlayDiv).width() - parseInt(jQuery(loadingDiv).width()))).toString()  + 'px');
		}
		else {
			jQuery(loadingDiv).css('left', (indicatorLeft + parseInt(settings.hPos)).toString() + 'px');
		}

		// set vertical position
		if ( settings.vPos.toString().toLowerCase() == 'center' ) {
			jQuery(loadingDiv).css('top', (indicatorTop + ((jQuery(overlayDiv).height() - parseInt(jQuery(loadingDiv).height())) / 2)).toString()  + 'px');
		}
		else if ( settings.vPos.toString().toLowerCase() == 'top' ) {
			jQuery(loadingDiv).css('top', indicatorTop.toString() + 'px');
		}
		else if ( settings.vPos.toString().toLowerCase() == 'bottom' ) {
			jQuery(loadingDiv).css('top', (indicatorTop + (jQuery(overlayDiv).height() - parseInt(jQuery(loadingDiv).height()))).toString()  + 'px');
		}
		else {
			jQuery(loadingDiv).css('top', (indicatorTop + parseInt(settings.vPos)).toString() + 'px' );
		}

		// Set any custom css for loading indicator
       		if ( settings.css ) {
       			jQuery(loadingDiv).css ( settings.css );
       		}

		// Set up callback options
		var callback_options =
			{
				'overlay': overlayDiv,
				'indicator': loadingDiv,
				'element': this
			};

		// beforeShow callback
		if ( typeof(settings.beforeShow) == 'function' ) {
			settings.beforeShow( callback_options );
		}

		// Show the overlay
		jQuery(overlayDiv).show();


		// Show the loading indicator
		jQuery(loadingDiv).show();

		// afterShow callback
		if ( typeof(settings.afterShow) == 'function' ) {
			settings.afterShow( callback_options );
		}

		return this;
    	 };


	jQuery.fn.hideLoading = function(options) {

        var settings = {};

        jQuery.extend(settings, options);

		if ( settings.indicatorID ) {
			indicatorID = settings.indicatorID;
		}
		else {
			indicatorID = jQuery(this).attr('id');
		}

   		jQuery(document.body).find('#loading-indicator-' + indicatorID ).remove();
		jQuery(document.body).find('#loading-indicator-' + indicatorID + '-overlay' ).remove();

		return this;
     };