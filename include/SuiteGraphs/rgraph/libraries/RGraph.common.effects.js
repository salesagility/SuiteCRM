// version: 2015-11-02
    /**
    * o--------------------------------------------------------------------------------o
    * | This file is part of the RGraph package - you can learn more at:               |
    * |                                                                                |
    * |                          http://www.rgraph.net                                 |
    * |                                                                                |
    * | RGraph is dual licensed under the Open Source GPL (General Public License)     |
    * | v2.0 license and a commercial license which means that you're not bound by     |
    * | the terms of the GPL. The commercial license is just £99 (GBP) and you can     |
    * | read about it here:                                                            |
    * |                      http://www.rgraph.net/license                             |
    * o--------------------------------------------------------------------------------o
    */

    /**
    * This is a library of a few functions that make it easier to do
    * effects like fade-ins or eaxpansion.
    */

    /**
    * Initialise the various objects
    */
    RGraph                = window.RGraph || {isRGraph: true};
    RGraph.Effects        = RGraph.Effects || {};
    RGraph.Effects.Common = {};

// Module pattern
(function (win, doc, undefined)
{
    var RG = RGraph,
        ua = navigator.userAgent,
        ma = Math;




    /**
    * This functions adds the generic effects to thechart object
    * 
    * @param object obj The chart object
    */
    RG.Effects.decorate = function (obj)
    {
        for (i in RG.Effects.Common) {
            if (typeof RG.Effects.Common[i] === 'function') {

                obj[i] = RG.Effects.Common[i];
            }
        }
    };





    /**
    * A function used to replace the canvas with a DIV, which in turn holds the canvas. This way the page
    * layout doesn't shift in the canvas is resized.
    * 
    * @param object canvas The canvas to replace.
    */
    RG.Effects.replaceCanvasWithDIV =
    RG.Effects.ReplaceCanvasWithDIV =
    RG.Effects.wrap                 = function (canvas)
    {
        if (!canvas.rgraph_wrapper) {
            // Create the place holder DIV
            var div = $('<div></div>')
                       .css({
                             width: canvas.width + 'px',
                             height: canvas.height + 'px',
                             cssFloat: canvas.style.cssFloat,
                             left: canvas.style.left,
                             top: canvas.style.top,
                             display: 'inline-block'
                        })
                        .get(0);

            // Add the new DIV to the DOM
            canvas.parentNode.insertBefore(div, canvas);

            // Remove the canvas from the document
            canvas.parentNode.removeChild(canvas);
            
            // Add it back in as a child of the place holder
            div.appendChild(canvas);
            
            // Reset the positioning information on the canvas
            canvas.style.position = 'relative';
            canvas.style.left     = (div.offsetWidth / 2) + 'px';
            canvas.style.top      = (div.offsetHeight / 2) + 'px';
            canvas.style.cssFloat = '';
        
            // Add a reference to the canvas to the DIV so that repeated plays of the anumation
            // don't keep replacing the canvas with a new DIV
            canvas.rgraph_wrapper = div;
        }
        
        var div = canvas.rgraph_wrapper;
        
        return div;
    };





    /**
    * fadeIn
    * 
    * This function simply uses the CSS opacity property - initially set to zero and
    * increasing to 1 over the period of 0.5 second
    */
    RG.Effects.Common.fadeIn = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 30;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};


        // Initially the opacity should be zero
        obj.canvas.style.opacity = 0;
        
        // Draw the chart
        RG.redrawCanvas(obj.canvas);

        // Now fade the chart in
        for (var i=1; i<=frames; ++i) {
            (function (index)
            {
                setTimeout(function ()
                {
                    obj.canvas.style.opacity = (index / frames);
                }, (index / frames) * duration);
            })(i)
        }
        
        setTimeout(function () {callback(obj);}, duration);
        
        
        return obj;
    };




    /**
    * fadeOut
    * 
    * This function is a reversal of the above function - fading out instead of in
    */
    RG.Effects.Common.fadeOut = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 30;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};


        // Now fade the chart in
        for (var i=1; i<=frames; ++i) {
            (function (index)
            {
                setTimeout(function ()
                {
                    obj.canvas.style.opacity = 1 - (index / frames);
                }, (index / frames) * duration);
            })(i)
        }
        
        setTimeout(function () {callback(obj);}, duration);

        return this;
        
        /**
        * Callback
        */
        callback(obj);
    };




    /**
    * fadeSlideIn
    * 
    * This function fades the canvas in in a sliding motion
    */
    RG.Effects.Common.fadeSlideIn = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 30;
        var frame    = 0;
        var pc       = -20;
        var step     = (120 - pc) / frames;
        var canvasXY = RG.getCanvasXY(obj.canvas);
        var color    = opt.color || 'white';
        var callback = arguments[1] || function () {};

        
        // Draw the chart
        RG.redrawCanvas(obj.canvas);


        // Create the cover
        $('<div id="rgraph_fadeslide_cover_' + obj.id + '"></div>').css({
            background: 'linear-gradient(135deg, rgba(255,255,255,0) ' + pc + '%, ' + color + ' ' + (pc + 20) + '%)',
            width:obj.canvas.width + 'px',
            height: obj.canvas.height + 'px',
            top: canvasXY[1] + 'px',
            left: canvasXY[0] + 'px',
            position: 'absolute'
        }).appendTo($(obj.canvas.parentNode));

            function iterator ()
            {
                if (pc < 120) {
                    $('div#rgraph_fadeslide_cover_' + obj.id).css({
                                                                   background: 'linear-gradient(135deg, rgba(255,255,255,0) ' + pc + '%, ' + color + ' ' + (pc + 20) + '%)'
                                                                  });
                    pc += step;
                    RG.Effects.updateCanvas(iterator);
                
                } else {
                
                    $('div#rgraph_fadeslide_cover_' + obj.id).remove();

                    callback(obj);
                }
            }
            
            iterator();
    };




    /**
    * fadeSlideOut
    * 
    Fades the canvas out in a sliding motion
    */
    RG.Effects.Common.fadeSlideOut = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 30;
        var frame    = 0;
        var pc       = -20;
        var step     = (120 - pc) / frames;
        var canvasXY = RG.getCanvasXY(obj.canvas);
        var color    = opt.color || 'white';
        var callback = arguments[1] || function () {};


        // Draw the chart
        RG.redrawCanvas(obj.canvas);

        // Create the cover
        $('<div id="rgraph_fadeslide_cover_' + obj.id + '"></div>').css({
            background: 'linear-gradient(135deg, ' + color + ' ' + pc + '%, rgba(255,255,255,0) ' + (pc + 20) + '%)',
            width:obj.canvas.width + 'px',
            height: obj.canvas.height + 'px',
            top: canvasXY[1] + 'px',
            left: canvasXY[0] + 'px',
            position: 'absolute'
        }).appendTo($(obj.canvas.parentNode));

            function iterator ()
            {
                if (pc < 120) {
                    $('div#rgraph_fadeslide_cover_' + obj.id).css({
                                                                   background: 'linear-gradient(135deg, ' + color + ' ' + pc + '%, rgba(255,255,255,0) ' + (pc + 20) + '%)'
                                                                  });
                    pc += step;
                    RG.Effects.updateCanvas(iterator);
                
                } else {
                
                    RG.clear(obj.canvas, color)
                
                    $('div#rgraph_fadeslide_cover_' + obj.id).remove();

                    callback(obj);
                }
            }
            
            iterator();
    };





    /**
    * fadeCircularIn
    * 
    * This function uses radial CSS gradients to cover the canvas with a radial fade in effect
    * (from the center outwards)
    */
    RG.Effects.Common.fadeCircularInOutwards = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 120;
        var frame    = 0;
        var radius   = 0;
        var canvasXY = RG.getCanvasXY(obj.canvas);
        var color    = opt.color || 'white';
        var callback = arguments[1] || function () {};

        
        // Draw the chart
        RG.redrawCanvas(obj.canvas);



        // Create the cover
        $('<div id="rgraph_fadeslide_cover_' + obj.id + '"></div>').css({
            background: 'radial-gradient(rgba(255,255,255,0) 0%, white ' + radius + '%)',
            width:obj.canvas.width + 'px',
            height: obj.canvas.height + 'px',
            top: canvasXY[1],
            left: canvasXY[0],
            position: 'absolute'
        }).appendTo($(obj.canvas.parentNode));

        function iterator ()
        {
            if (frame < frames) {

                    $('div#rgraph_fadeslide_cover_' + obj.id).css({
                        background: 'radial-gradient(rgba(255,255,255,0) ' + ((frame++ / frames) * 100) + '%, ' + color + ' ' + ((frame++ / frames) * 150) + '%)'
                    });

                    RG.Effects.updateCanvas(iterator);
            
            } else {
            
                $('div#rgraph_fadeslide_cover_' + obj.id).remove();

                callback(obj);
            }
        }
        
        iterator();
    };




    /**
    * fadeCircularOut
    * 
    * This function uses radial CSS gradients to cover the canvas with a radial fade out effect
    * (from the center outwards)
    */
    RG.Effects.Common.fadeCircularOutOutwards = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 120;
        var frame    = 0;
        var canvasXY = RG.getCanvasXY(obj.canvas);
        var color    = opt.color || 'white';
        var callback = arguments[1] || function () {};

        
        // Draw the chart
        RG.redrawCanvas(obj.canvas);



        // Create the cover
        $('<div id="rgraph_fadeslide_cover_' + obj.id + '"></div>').css({
            background: 'radial-gradient(rgba(255,255,255,0) 0%, white 0%)',
            width:obj.canvas.width + 'px',
            height: obj.canvas.height + 'px',
            top: canvasXY[1],
            left: canvasXY[0],
            position: 'absolute'
        }).appendTo($(obj.canvas.parentNode));

        function iterator ()
        {
            if (frame < frames) {

                    $('div#rgraph_fadeslide_cover_' + obj.id).css({
                                                                   background: 'radial-gradient(' + color + ' ' + ((frame++ / frames) * 100) + '%, rgba(255,255,255,0) ' + ((frame++ / frames) * 150) + '%)'
                                                                  });
                    RG.Effects.updateCanvas(iterator);
            
            } else {
            
                RG.clear(obj.canvas, color);
            
                $('div#rgraph_fadeslide_cover_' + obj.id).remove();

                callback(obj);
            }
        }
        
        iterator();
    };




    /**
    * fadeCircularInInwards
    */
    RG.Effects.Common.fadeCircularInInwards = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 120;
        var frame    = 0;
        var radius   = ma.max(obj.canvas.width, obj.canvas.height);
        var canvasXY = RG.getCanvasXY(obj.canvas);
        var color    = opt.color || 'white';
        var callback = arguments[1] || function () {};


        // Draw the chart
        RG.redrawCanvas(obj.canvas);



        // Create the cover
        $('<div id="rgraph_fadeslide_cover_' + obj.id + '"></div>').css({
            background: 'radial-gradient(rgba(255,255,255,0) 100%, rgba(255,255,255,0) 0%)',
            width:obj.canvas.width + 'px',
            height: obj.canvas.height + 'px',
            top: canvasXY[1] + 'px',
            left: canvasXY[0] + 'px',
            position: 'absolute'
        }).appendTo($(obj.canvas.parentNode));

        function iterator ()
        {
            if (frame < frames) {

                    $('div#rgraph_fadeslide_cover_' + obj.id).css({
                                                                   background: 'radial-gradient(' + color + ' ' + (( (frames - frame++) / frames) * 100) + '%, rgba(255,255,255,0) ' + (( (frames - frame++) / frames) * 120) + '%)'
                                                                  });
                    RG.Effects.updateCanvas(iterator);
            
            } else {
            
                $('div#rgraph_fadeslide_cover_' + obj.id).remove();

                callback(obj);
            }
        }
        
        iterator();
    };




    /**
    * fadeCircularOutReverse
    */
    RG.Effects.Common.fadeCircularOutInwards = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 120;
        var frame    = 0;
        var radius   = ma.max(obj.canvas.width, obj.canvas.height);
        var canvasXY = RG.getCanvasXY(obj.canvas);
        var color    = opt.color || 'white';
        var callback = arguments[1] || function () {};


        // Draw the chart
        RG.redrawCanvas(obj.canvas);



        // Create the cover
        $('<div id="rgraph_fadeslide_cover_' + obj.id + '"></div>').css({
            background: 'radial-gradient(rgba(255,255,255,0) 0%, rgba(255,255,255,0) 0%)',
            width:obj.canvas.width + 'px',
            height: obj.canvas.height + 'px',
            top: canvasXY[1],
            left: canvasXY[0],
            position: 'absolute'
        }).appendTo($(obj.canvas.parentNode));

        function iterator ()
        {
            if (frame < frames) {

                    $('div#rgraph_fadeslide_cover_' + obj.id).css({
                                                                   background: 'radial-gradient(rgba(255,255,255,0) ' + (( (frames - frame++) / frames) * 100) + '%, ' + color + ' ' + (( (frames - frame++) / frames) * 120) + '%)'
                                                                  });
                    RG.Effects.updateCanvas(iterator);
            
            } else {
            
                RG.clear(obj.canvas);
            
                $('div#rgraph_fadeslide_cover_' + obj.id).remove();

                callback(obj);
            }
        }
        
        iterator();
    };




    /**
    * Expand
    * 
    * This effect is like the tooltip effect of the same name. I starts in the middle
    * and expands out to full size.
    * 
    * @param object obj The graph object
    */
    RG.Effects.Common.expand = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj       = this;
        var opt       = arguments[0] || {};
        var bounce    = typeof opt.bounce === 'boolean' ? opt.bounce : true;
        var frames    = opt.frames || 60;
        var duration  = (frames / 60) * 1000;
        var callback  = arguments[1] || function () {};

        if (!this.canvas.rgraph_wrapper) {
            var div    = RG.Effects.wrap(this.canvas);
            this.canvas.rgraph_wrapper = div;
        } else {
            div = this.canvas.rgraph_wrapper;
        }

        div.style.position = 'relative';
        //this.canvas.style.position = 'relative'; // absolute should work here too - but doesn't in Chrome
        this.canvas.style.top  = (this.canvas.height / 2) + 'px';
        this.canvas.style.left = (this.canvas.width / 2) + 'px';

        this.canvas.style.width  = 0;
        this.canvas.style.height = 0;

        this.canvas.style.opacity = 0;


        RG.clear(this.canvas);
        RG.redrawCanvas(this.canvas);

        if (bounce) {

            jQuery('#' + obj.id).animate({opacity: 1, width: (obj.canvas.width * 1.2) + 'px', height: (obj.canvas.height * 1.2) + 'px', left: (obj.canvas.width * -0.1) + 'px', top: (obj.canvas.height * -0.1) + 'px'}, duration * 0.5, function ()
            {
                jQuery('#' + obj.id).animate({width: (obj.canvas.width * 0.9) + 'px', height: (obj.canvas.height * 0.9) + 'px', top: (obj.canvas.height * 0.05) + 'px', left: (obj.canvas.width * 0.05) + 'px'}, duration * 0.25, function ()
                {
                    jQuery('#' + obj.id).animate({width: obj.canvas.width + 'px', height: obj.canvas.height + 'px', top: 0, left: 0}, duration * 0.25, function () {callback(obj);});
                });
              });
        
        } else {

            jQuery(obj.canvas).animate({
                opacity: 1,
                width: obj.canvas.width + 'px',
                height: obj.canvas.height + 'px',
                left: 0,
                top: 0
            }, duration, function () {callback(obj);})
        }
        
        

        return this;
    };




    /**
    * Contract
    * 
    * This effect is a good one to use with the Expand effect to make a transition
    * 
    * @param object     You can specify frames here: {frames: 120}
    * @param function   Optional callback to run when the effect is done.
    */
    RG.Effects.Common.contract = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj       = this;
        var opt       = arguments[0] || {};
        var frames    = opt.frames || 60;
        var duration  = (frames / 60) * 1000;
        var callback  = arguments[1] || function () {};

        if (!obj.canvas.rgraph_wrapper) {
            var div    = RG.Effects.wrap(obj.canvas);
            obj.canvas.rgraph_wrapper = div;
        } else {
            div = obj.canvas.rgraph_wrapper;
        }


        div.style.position = 'relative';
        //canvas.style.position = 'absolute'; // Chrome bug...?
        obj.canvas.style.top      = 0;
        obj.canvas.style.left     = 0;


        jQuery('#' + obj.id).animate({
            width: (obj.canvas.width * 1.2) + 'px',
            height: (obj.canvas.height * 1.2) + 'px',
            left: (obj.canvas.width * -0.1) + 'px',
            top: (obj.canvas.height * -0.1) + 'px'
        }, duration * 0.25, function ()
        {
                jQuery('#' + obj.id).animate({
                    opacity: 0,
                    width: 0,
                    height: 0,
                    left: (obj.canvas.width * 0.5) + 'px',
                    top: (obj.canvas.height * 0.5) + 'px'
                }, duration * 0.75, function () {callback(obj);});
        });
        
        
        return this;
    };




    /**
    * Reveal
    * 
    * This effect issmilar to the Expand effect - the canvas is slowly revealed from
    * the centre outwards
    * 
    * @param object    Options for the effect. You can give frames here
    * @param function  An optional callback function
    */
    RG.Effects.Common.reveal = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj       = this;
        var opt       = arguments[0] || {};
        var frames    = opt.frames || 60;
        var duration  = (frames / 60) * 1000;
        var callback  = arguments[1] || function () {};
        var xy        = RG.getCanvasXY(obj.canvas);




        var divs = [
            ['rgraph_reveal_left_' + obj.id, xy[0], xy[1], obj.canvas.width  / 2, obj.canvas.height],
            ['rgraph_reveal_right_' + obj.id,(xy[0] + (obj.canvas.width  / 2)),xy[1],(obj.canvas.width  / 2),obj.canvas.height],
            ['rgraph_reveal_top_' + obj.id,xy[0],xy[1],obj.canvas.width,(obj.canvas.height / 2)],
            ['rgraph_reveal_bottom_' + obj.id,xy[0],(xy[1] + (obj.canvas.height  / 2)),obj.canvas.width,(obj.canvas.height / 2)]
        ];
        
        for (var i=0,len=divs.length; i<len; ++i) {
            var div = document.createElement('DIV');
                div.id             = divs[i][0];
                div.style.width    = divs[i][3]+ 'px';
                div.style.height   = divs[i][4] + 'px';
                div.style.left     = divs[i][1] + 'px';
                div.style.top      = divs[i][2] + 'px';
                div.style.position = 'absolute';
                div.style.backgroundColor = opt && typeof opt.color === 'string' ? opt.color : 'white';
            document.body.appendChild(div);
        }


        // Clear the canvas and redraw it
        RG.clear(obj.canvas);
        RG.redrawCanvas(obj.canvas);


        // Animate the shrinking of the DIVs
        jQuery('#rgraph_reveal_left_' + obj.id).animate({width: 0}, duration);
        jQuery('#rgraph_reveal_right_' + obj.id).animate({left: '+=' + (obj.canvas.width / 2),width: 0}, duration);
        jQuery('#rgraph_reveal_top_' + obj.id).animate({height: 0}, duration);
        jQuery('#rgraph_reveal_bottom_' + obj.id).animate({top: '+=' + (obj.canvas.height / 2),height: 0}, duration);
        
        // Remove the DIVs from the DOM 100ms after the animation ends
        setTimeout(function ()
        {
            doc.body.removeChild(doc.getElementById("rgraph_reveal_top_" + obj.id));
            doc.body.removeChild(doc.getElementById("rgraph_reveal_bottom_" + obj.id));
            doc.body.removeChild(doc.getElementById("rgraph_reveal_left_" + obj.id));
            doc.body.removeChild(doc.getElementById("rgraph_reveal_right_" + obj.id));
            
            callback(obj);
        }, duration);
        
        
        return this;
    };




    /**
    * RevealCircular
    * 
    * This effect is smilar to the Reveal effect - the canvas is slowly revealed from
    * the centre outwards using a circular shape
    * 
    * @param object       An object of options - eg {frames: 30}
    * @param function     An optional callback function that runs when the effect is finished
    */
    RG.Effects.Common.revealCircular =
    RG.Effects.Common.revealcircular = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj           = this;
        var opt           = arguments[0] || {};
        var frames        = opt.frames || 30;
        var frame         = 0;
        var callback      = arguments[1] || function () {};
        var currentRadius = 0
        var centerx       = obj.canvas.width / 2;
        var centery       = obj.canvas.height / 2;
        var targetRadius  = ma.max(obj.canvas.height, obj.canvas.width);
        var step          = targetRadius / frames;
        var color         = opt.background || opt.color || opt.backgroundColor || 'transparent';




        /**
        * This is the iterator function which gradually increases the radius of the clip circle
        */
        function iterator ()
        {
            // Begin by clearing the canvas
            RG.clear(obj.canvas, color);

            obj.context.save();
                // First draw the circle and clip to it
                obj.context.beginPath();
                obj.context.arc(centerx, centery, currentRadius, 0, RG.TWOPI, false);
                obj.context.clip();
                
                // Clear the canvas to a white color
                if (opt.background) {
                    RG.clear(obj.canvas, opt.background);
                }
                
                // Now draw the chart
                obj.draw();
            obj.context.restore();


            // Increment the radius
            if (currentRadius < targetRadius) {
                currentRadius += step;
                RG.Effects.updateCanvas(iterator);

            } else {
                callback(obj);
            }
        }
        
        iterator();
        
        return this;
    };




    /**
    * Conceal
    * 
    * This effect is the reverse of the Reveal effect - instead of revealing the canvas it
    * conceals it. Combined with the reveal effect would make for a nice wipe effect.
    * 
    * @param object obj The chart object
    */
    RG.Effects.Common.conceal = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 60;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};
        var xy       = RG.getCanvasXY(obj.canvas);
        var color    = opt.background || opt.color || opt.backgroundColor || 'white';




        var divs = [
            ['rgraph_conceal_left_' + obj.id, xy[0], xy[1], 0, obj.canvas.height],
            ['rgraph_conceal_right_' + obj.id,(xy[0] + obj.canvas.width),xy[1],0,obj.canvas.height],
            ['rgraph_conceal_top_' + obj.id,xy[0],xy[1],obj.canvas.width,0],
            ['rgraph_conceal_bottom_' + obj.id,xy[0],(xy[1] + obj.canvas.height),obj.canvas.width,0]
        ];




        for (var i=0,len=divs.length; i<len; ++i) {
            var div = doc.createElement('DIV');
                div.id             = divs[i][0];
                div.style.width    =  divs[i][3]+ 'px';
                div.style.height   = divs[i][4] + 'px';
                div.style.left     = divs[i][1] + 'px';
                div.style.top      = divs[i][2] + 'px';
                div.style.position = 'absolute';
                div.style.backgroundColor = color;
            doc.body.appendChild(div);
        }


        jQuery('#rgraph_conceal_left_' + obj.id).animate({width: '+=' + (obj.canvas.width / 2)}, duration);
        jQuery('#rgraph_conceal_right_' + obj.id).animate({left: '-=' + (obj.canvas.width / 2),width: (obj.canvas.width / 2)}, duration);
        jQuery('#rgraph_conceal_top_' + obj.id).animate({height: '+=' + (obj.canvas.height / 2)}, duration);
        jQuery('#rgraph_conceal_bottom_' + obj.id).animate({top: '-=' + (obj.canvas.height / 2),height: (obj.canvas.height / 2)}, duration);
        
        // Remove the DIVs from the DOM 100ms after the animation ends
        setTimeout(
        function ()
        {
            doc.body.removeChild(doc.getElementById("rgraph_conceal_top_" + obj.id));
            doc.body.removeChild(doc.getElementById("rgraph_conceal_bottom_" + obj.id));
            doc.body.removeChild(doc.getElementById("rgraph_conceal_left_" + obj.id));
            doc.body.removeChild(doc.getElementById("rgraph_conceal_right_" + obj.id));
            
            RG.clear(obj.canvas, color);
            
            callback(obj);
        
        }, duration);
        
        return this;
    };




    /**
    * Horizontal Blinds (open)
    * 
    * @params object obj The graph object
    */
    RG.Effects.Common.hBlindsOpen =
    RG.Effects.Common.hblindsOpen = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 60;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};
        var color    = opt.background || opt.color || opt.backgroundColor || 'white';
        var xy       = RG.getCanvasXY(this.canvas);
        var height   = this.canvas.height / 5;
        
        /**
        * First draw the chart
        */
        RG.clear(this.canvas);
        RG.redrawCanvas(this.canvas);

        for (var i=0; i<5; ++i) {
            var div = doc.createElement('DIV');
                div.id                    = 'rgraph_hblinds_' + i + '_' + obj.id;
                div.style.width           =  this.canvas.width + 'px';
                div.style.height          = height + 'px';
                div.style.left            = xy[0] + 'px';
                div.style.top             = (xy[1] + (this.canvas.height * (i / 5))) + 'px';
                div.style.position        = 'absolute';
                div.style.backgroundColor = color;
            document.body.appendChild(div);

            jQuery('#rgraph_hblinds_' + i + '_' + obj.id).animate({height: 0}, duration);
        }

        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_hblinds_0_' + obj.id));}, duration);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_hblinds_1_' + obj.id));}, duration);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_hblinds_2_' + obj.id));}, duration);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_hblinds_3_' + obj.id));}, duration);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_hblinds_4_' + obj.id));}, duration);
        setTimeout(function () {callback(obj);}, duration);
        
        return this;
    };




    /**
    * Horizontal Blinds (close)
    * 
    * @params object obj The graph object
    */
    RG.Effects.Common.hBlindsClose =
    RG.Effects.Common.hblindsclose = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 60;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};
        var color    = opt.background || opt.color || opt.backgroundColor || 'white';
        var xy       = RG.getCanvasXY(this.canvas);
        var height   = this.canvas.height / 5;



        for (var i=0; i<5; ++i) {
            var div = doc.createElement('DIV');
                div.id                    = 'rgraph_hblinds_' + i + '_' + obj.id;
                div.style.width           = this.canvas.width + 'px';
                div.style.height          = 0;
                div.style.left            = xy[0] + 'px';
                div.style.top             = (xy[1] + (this.canvas.height * (i / 5))) + 'px';
                div.style.position        = 'absolute';
                div.style.backgroundColor = color;
            doc.body.appendChild(div);

            jQuery('#rgraph_hblinds_' + i + '_' + obj.id).animate({height: height + 'px'}, duration);
        }



        setTimeout(function () {RG.clear(obj.canvas);}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_hblinds_0_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_hblinds_1_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_hblinds_2_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_hblinds_3_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_hblinds_4_' + obj.id));}, duration + 100);
        setTimeout(function () {callback(obj);}, duration + 100);
    };




    /**
    * Vertical Blinds (open)
    * 
    * @params object obj The graph object
    */
    RG.Effects.Common.vBlindsOpen =
    RG.Effects.Common.vblindsopen = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 60;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};
        var color    = opt.background || opt.color || opt.backgroundColor || 'white';
        var xy       = RG.getCanvasXY(this.canvas);
        var width    = this.canvas.width / 10;
        
        /**
        * First draw the chart
        */
        //RG.clear(obj.canvas);
        RG.redrawCanvas(obj.canvas);

        for (var i=0; i<10; ++i) {
            var div = doc.createElement('DIV');
                div.id = 'rgraph_vblinds_' + i + '_' + obj.id;
                div.style.width =  width + 'px';
                div.style.height = this.canvas.height + 'px';
                div.style.left   = (xy[0] + (this.canvas.width * (i / 10))) + 'px';
                div.style.top   = (xy[1]) + 'px';
                div.style.position = 'absolute';
                div.style.backgroundColor = color;
            doc.body.appendChild(div);

            jQuery('#rgraph_vblinds_' + i + '_' + obj.id).animate({width: 0}, duration);
        }

        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_0_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_1_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_2_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_3_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_4_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_5_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_6_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_7_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_8_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_9_' + obj.id));}, duration + 100);
        
        setTimeout(function () {callback(obj);}, duration + 100);

        return this;
    };




    /**
    * Vertical Blinds (close)
    * 
    * @params object obj The graph object
    */
    RG.Effects.Common.vblindsclose =
    RG.Effects.Common.vBlindsClose = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 60;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};
        var color    = opt.background || opt.color || opt.backgroundColor || 'white';
        var xy       = RG.getCanvasXY(this.canvas);
        var width    = this.canvas.width / 10;
        
        // Don't draw the chart

        // Create the blinds
        for (var i=0; i<10; ++i) {
            var div = doc.createElement('DIV');
                div.id                    = 'rgraph_vblinds_' + i + '_' + obj.id;
                div.style.width           = 0;
                div.style.height          = this.canvas.height + 'px';
                div.style.left            = (xy[0] + (this.canvas.width * (i / 10))) + 'px';
                div.style.top             = (xy[1]) + 'px';
                div.style.position        = 'absolute';
                div.style.backgroundColor = color;
            doc.body.appendChild(div);

            jQuery('#rgraph_vblinds_' + i + '_' + obj.id).animate({width: width}, duration);
        }

        setTimeout(function () {RG.clear(obj.canvas);}, duration + 100);

        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_0_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_1_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_2_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_3_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_4_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_5_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_6_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_7_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_8_' + obj.id));}, duration + 100);
        setTimeout(function () {doc.body.removeChild(doc.getElementById('rgraph_vblinds_9_' + obj.id));}, duration + 100);
        
        setTimeout(function () {callback(obj);}, duration + 100);

        return this;
    };




    /**
    * Slide in
    * 
    * This function is a wipe that can be used when switching the canvas to a new graph
    * 
    * @param object obj The graph object
    */
    RG.Effects.Common.slideIn = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 60;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};
        var color    = opt.background || opt.color || opt.backgroundColor || 'white';
        var xy       = RG.getCanvasXY(this.canvas);
        var width    = this.canvas.width / 10;
        var div      = RG.Effects.wrap(obj.canvas);
        var from     = opt.from || 'left';

        div.style.overflow = 'hidden';

        RG.clear(obj.canvas);
        RG.redrawCanvas(obj.canvas);

        
        canvas.style.position = 'relative';
        
        if (from == 'left') {
            obj.canvas.style.left = (0 - div.offsetWidth) + 'px';
            obj.canvas.style.top  = 0;
        } else if (from == 'top') {
            obj.canvas.style.left = 0;
            obj.canvas.style.top  = (0 - div.offsetHeight) + 'px';
        } else if (from == 'bottom') {
            obj.canvas.style.left = 0;
            obj.canvas.style.top  = div.offsetHeight + 'px';
        } else {
            obj.canvas.style.left = div.offsetWidth + 'px';
            obj.canvas.style.top  = 0;
        }
        
        jQuery('#' + obj.id).animate({left:0,top:0}, duration, function ()
        {
            callback(obj);
        });
        
        return this;
    };




    /**
    * Slide out
    * 
    * This function is a wipe that can be used when switching the canvas to a new graph
    * 
    * @param object   Optional object containing configuration.
    * @param function Optional callback function
    */
    RG.Effects.Common.slideOut = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 60;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};
        var color    = opt.background || opt.color || opt.backgroundColor || 'white';
        var xy       = RG.getCanvasXY(this.canvas);
        var width    = this.canvas.width / 10;
        var div      = RG.Effects.wrap(obj.canvas);
        var to       = opt.to || 'left';

        div.style.overflow= 'hidden';
        
        obj.canvas.style.position = 'relative';
        obj.canvas.style.left = 0;
        obj.canvas.style.top  = 0;
        
        if (to == 'left') {
            jQuery('#' + obj.id).animate({left: (0 - obj.canvas.width) + 'px'}, duration, function () {callback(obj);});
        } else if (to == 'top') {
            jQuery('#' + obj.id).animate({left: 0, top: (0 - div.offsetHeight) + 'px'}, duration, function () {callback(obj);});
        } else if (to == 'bottom') {
            jQuery('#' + obj.id).animate({top: (0 + div.offsetHeight) + 'px'}, duration, function () {callback(obj);});
        } else {
            jQuery('#' + obj.id).animate({left: (0 + obj.canvas.width) + 'px'}, duration, function () {callback(obj);});
        }
        
        return this;
    };




    /**
    * Horizontal Scissors (open)
    * 
    * @param @object      Optional array of options
    * @param function     Optional callback function
    * 
    */
    RG.Effects.Common.hscissorsopen =
    RG.Effects.Common.hScissorsOpen = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 60;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};
        var color    = opt.background || opt.color || opt.backgroundColor || 'white';
        var xy       = RG.getCanvasXY(this.canvas);
        var width    = this.canvas.width / 10;
        var to       = opt.to || 'left';
        var height   = obj.canvas.height / 5;

        /**
        * First draw the chart
        */
        RG.clear(obj.canvas);
        RG.redrawCanvas(obj.canvas);

        for (var i=0; i<5; ++i) {
            var div = doc.getElementById("rgraph_hscissors_" + i + '_' + obj.id)
            if (!div) {
                var div = doc.createElement('DIV');
                    div.id = 'rgraph_hscissors_' + i + '_' + obj.id;
                    div.style.width =  obj.canvas.width + 'px';
                    div.style.height = height + 'px';
                    div.style.left   = xy[0] + 'px';
                    div.style.top   = (xy[1] + (obj.canvas.height * (i / 5))) + 'px';
                    div.style.position = 'absolute';
                    div.style.backgroundColor = color;
                doc.body.appendChild(div);
            }
    
            if (i % 2 == 0) {
                jQuery('#' + 'rgraph_hscissors_' + i + '_' + obj.id).animate({left: xy[0] + obj.canvas.width + 'px', width: 0}, duration);
            } else {
                jQuery('#' + 'rgraph_hscissors_' + i + '_' + obj.id).animate({width: 0}, duration);
            }
        }

        setTimeout(function ()
        {
            doc.body.removeChild(doc.getElementById('rgraph_hscissors_0_' + obj.id));
            doc.body.removeChild(doc.getElementById('rgraph_hscissors_1_' + obj.id));
            doc.body.removeChild(doc.getElementById('rgraph_hscissors_2_' + obj.id));
            doc.body.removeChild(doc.getElementById('rgraph_hscissors_3_' + obj.id));
            doc.body.removeChild(doc.getElementById('rgraph_hscissors_4_' + obj.id));
            
            callback(obj);
        }, duration);
        
        
        return this;
    };




    /**
    * Horizontal Scissors (Close)
    * 
    * @param @object      Optional object of options
    * @param function     Optional callback function
    * 
    */
    RG.Effects.Common.hScissorsClose =
    RG.Effects.Common.hscissorsclose = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 60;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};
        var color    = opt.background || opt.color || opt.backgroundColor || 'white';
        var xy       = RG.getCanvasXY(this.canvas);
        var height   = obj.canvas.height / 5;


        
        /**
        * First draw the chart
        */
        //RG.clear(obj.canvas);
        RG.redrawCanvas(obj.canvas);

        for (var i=0; i<5; ++i) {
            var div                = doc.createElement('DIV');
                div.id             = 'rgraph_hscissors_' + i + '_' + obj.id;
                div.style.width    = 0;
                div.style.height   = height + 'px';
                div.style.left     = (i % 2 == 0 ? xy[0] + obj.canvas.width : xy[0]) + 'px';
                div.style.top      = (xy[1] + (obj.canvas.height * (i / 5))) + 'px';
                div.style.position = 'absolute';
                div.style.backgroundColor = color;
            doc.body.appendChild(div);

            if (i % 2 == 0) {
                jQuery('#' + 'rgraph_hscissors_' + i + '_' + obj.id).animate({left: xy[0] + 'px', width: obj.canvas.width + 'px'}, duration);
            } else {
                jQuery('#' + 'rgraph_hscissors_' + i + '_' + obj.id).animate({width: obj.canvas.width + 'px'}, duration);
            }
        }
        
        setTimeout(function () {callback(obj);}, duration);
        
        return this;
    };




    /**
    * Vertical Scissors (open)
    * 
    * @param @object      Optional object of options
    * @param function     Optional callback function
    * 
    */
    RG.Effects.Common.vScissorsOpen =
    RG.Effects.Common.vscissorsopen = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 60;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};
        var xy       = RG.getCanvasXY(obj.canvas);
        var color    = opt.background || opt.color || opt.backgroundColor || 'white';
        var xy       = RG.getCanvasXY(this.canvas);
        var width    = this.canvas.width / 10;
        
        /**
        * First draw the chart
        */
        //RG.clear(obj.canvas);
        RG.redrawCanvas(obj.canvas);

        for (var i=0; i<10; ++i) {
            var div = doc.getElementById("rgraph_vscissors_" + i + '_' + obj.id);

            if (!div) {
                var div = doc.createElement('DIV');
                    div.id = 'rgraph_vscissors_' + i + '_' + obj.id;
                    div.style.width    =  width + 'px';
                    div.style.height   = obj.canvas.height + 'px';
                    div.style.left     = xy[0] + (obj.canvas.width * (i / 10)) + 'px';
                    div.style.top      = xy[1] + 'px';
                    div.style.position = 'absolute';
                    div.style.backgroundColor = color;
                doc.body.appendChild(div);
            }

            if (i % 2 == 0) {
                jQuery('#' + 'rgraph_vscissors_' + i + '_' + obj.id).animate({top: xy[1] + obj.canvas.height + 'px', height: 0}, duration);
            } else {
                jQuery('#' + 'rgraph_vscissors_' + i + '_' + obj.id).animate({height: 0}, duration);
            }
        }

        setTimeout(function ()
        {
            doc.body.removeChild(doc.getElementById('rgraph_vscissors_0' + '_' + obj.id));
            doc.body.removeChild(doc.getElementById('rgraph_vscissors_1' + '_' + obj.id));
            doc.body.removeChild(doc.getElementById('rgraph_vscissors_2' + '_' + obj.id));
            doc.body.removeChild(doc.getElementById('rgraph_vscissors_3' + '_' + obj.id));
            doc.body.removeChild(doc.getElementById('rgraph_vscissors_4' + '_' + obj.id));
            
            callback(obj);

        }, duration);

        return this;
    };




    /**
    * Vertical Scissors (close)
    * 
    * @param object   obj The graph object
    * @param @object      An array of options
    * @param function     Optional callback function
    * 
    */
    RG.Effects.Common.vscissorsclose =
    RG.Effects.Common.vScissorsClose = function ()
    {
        // This function gets added to the chart object - so the this
        // variable is the chart object
        var obj      = this;
        var opt      = arguments[0] || {};
        var frames   = opt.frames || 60;
        var duration = (frames / 60) * 1000;
        var frame    = 0;
        var callback = arguments[1] || function () {};
        var xy       = RG.getCanvasXY(obj.canvas);
        var color    = opt.background || opt.color || opt.backgroundColor || 'white';
        var xy       = RG.getCanvasXY(this.canvas);
        var width    = this.canvas.width / 10;
        
        /**
        * First draw the chart
        */
        //RG.clear(obj.canvas);
        RG.redrawCanvas(obj.canvas);

        for (var i=0; i<10; ++i) {
            var div = doc.getElementById("rgraph_vscissors_" + i + '_' + obj.id)
            if (!div) {
                var div                = doc.createElement('DIV');
                    div.id             = 'rgraph_vscissors_' + i + '_' + obj.id;
                    div.style.width    =  width + 'px';
                    div.style.height   = 0;
                    div.style.left     = xy[0] + (width * i) + 'px';
                    div.style.top      = (i % 2 == 0 ? xy[1] + obj.canvas.height : xy[1]) + 'px';
                    div.style.position = 'absolute';
                    div.style.backgroundColor = color;
                doc.body.appendChild(div);
            }

            if (i % 2 == 0) {
                jQuery('#' + 'rgraph_vscissors_' + i + '_' + obj.id).animate({top: xy[1] + 'px', height: obj.canvas.height + 'px'}, duration);
            } else {
                jQuery('#' + 'rgraph_vscissors_' + i + '_' + obj.id).animate({height: obj.canvas.height + 'px'}, duration);
            }
        }
        
        setTimeout(function () {callback(obj);}, duration);
        
        return this;
    };




    /**
    * The Animate function. Similar to the jQuery Animate() function - simply pass it a
    * map of the properties and their target values, and this function will animate
    * them to get to those values.
    * 
    * @param object map A map (an associative array) of the properties and their target values.
    * @param            An optional function which will be called when the animation is complete
    */
    RG.Effects.Common.animate = function (map)
    {
        var obj = this;
        obj.draw();

        var totalFrames    = (map && map['frames']) ? map['frames'] : 30;
        var currentFrame   = new Array();
        var originalValues = new Array();
        var diffs          = new Array();
        var steps          = new Array();
        var callback       = arguments[1]

        function iterator ()
        {
            var id = [obj.id +  '_' + obj.type];

            // Initialise the arrays
            if (!currentFrame[id]) {
                currentFrame[id]   = totalFrames;
                originalValues[id] = {};
                diffs[id]          = {};
                steps[id]          = {};
            }

            for (var i in map) {
                if (typeof map[i] === 'string' || typeof map[i] === 'number') {

                    // If this the first frame, record the proginal value
                    if (currentFrame[id] == totalFrames) {
                        originalValues[id][i] = obj.get(i);
                        diffs[id][i]          = map[i] - originalValues[id][i];
                        steps[id][i]          = diffs[id][i] / totalFrames;
                    }

                    obj.set(i, obj.get(i) + steps[id][i]);

                    RG.clear(obj.canvas);
                    obj.draw();
                }
            }

            // If the current frame number is above zero, run the animation iterator again
            if (--currentFrame[id] > 0) {
                RG.Effects.updateCanvas(iterator);
            
            // Optional callback
            } else {

                if (typeof callback === 'function') {
                    callback(obj);
                }
            }
        }

        iterator();
    }




// End Module pattern
})(window, document);