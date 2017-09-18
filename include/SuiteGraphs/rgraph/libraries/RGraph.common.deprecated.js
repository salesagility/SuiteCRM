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

    RGraph = window.RGraph || {isRGraph: true};

// Module pattern
(function (win, doc, undefined)
{
    var RG = RGraph,
        ua = navigator.userAgent,
        ma = Math;




    /**
    * This is a useful function which is basically a shortcut for drawing left, right, top and bottom alligned text.
    * 
    * @param object context The context
    * @param string font    The font
    * @param int    size    The size of the text
    * @param int    x       The X coordinate
    * @param int    y       The Y coordinate
    * @param string text    The text to draw
    * @parm  string         The vertical alignment. Can be null. "center" gives center aligned  text, "top" gives top aligned text.
    *                       Anything else produces bottom aligned text. Default is bottom.
    * @param  string        The horizontal alignment. Can be null. "center" gives center aligned  text, "right" gives right aligned text.
    *                       Anything else produces left aligned text. Default is left.
    * @param  bool          Whether to show a bounding box around the text. Defaults not to
    * @param int            The angle that the text should be rotate at (IN DEGREES)
    * @param string         Background color for the text
    * @param bool           Whether the text is bold or not
    */
    RG.text =
    RG.Text = function (context, font, size, x, y, text)
    {
        // "Cache" the args as a local variable
        var args = arguments;

        // Handle undefined - change it to an empty string
        if ((typeof(text) != 'string' && typeof(text) != 'number') || text == 'undefined') {
            return;
        }




        /**
        * This accommodates multi-line text
        */
        if (typeof(text) == 'string' && text.match(/\r\n/)) {

            var dimensions = RGraph.MeasureText('M', args[11], font, size);

            /**
            * Measure the text (width and height)
            */

            var arr = text.split('\r\n');

            /**
            * Adjust the Y position
            */
            
            // This adjusts the initial y position
            if (args[6] && args[6] == 'center') y = (y - (dimensions[1] * ((arr.length - 1) / 2)));

            for (var i=1; i<arr.length; ++i) {
    
                RGraph.Text(context,
                            font,
                            size,
                            args[9] == -90 ? (x + (size * 1.5)) : x,
                            y + (dimensions[1] * i),
                            arr[i],
                            args[6] ? args[6] : null,
                            args[7],
                            args[8],
                            args[9],
                            args[10],
                            args[11],
                            args[12]);
            }
            
            // Update text to just be the first line
            text = arr[0];
        }


        // Accommodate MSIE
        if (document.all && RGraph.ISOLD) {
            y += 2;
        }


        context.font = (args[11] ? 'Bold ': '') + size + 'pt ' + font;

        var i;
        var origX = x;
        var origY = y;
        var originalFillStyle = context.fillStyle;
        var originalLineWidth = context.lineWidth;

        // Need these now the angle can be specified, ie defaults for the former two args
        if (typeof(args[6])  == 'undefined') args[6]  = 'bottom'; // Vertical alignment. Default to bottom/baseline
        if (typeof(args[7])  == 'undefined') args[7]  = 'left';   // Horizontal alignment. Default to left
        if (typeof(args[8])  == 'undefined') args[8]  = null;     // Show a bounding box. Useful for positioning during development. Defaults to false
        if (typeof(args[9])  == 'undefined') args[9]  = 0;        // Angle (IN DEGREES) that the text should be drawn at. 0 is middle right, and it goes clockwise

        // The alignment is recorded here for purposes of Opera compatibility
        if (navigator.userAgent.indexOf('Opera') != -1) {
            context.canvas.__rgraph_valign__ = args[6];
            context.canvas.__rgraph_halign__ = args[7];
        }

        // First, translate to x/y coords
        context.save();

            context.canvas.__rgraph_originalx__ = x;
            context.canvas.__rgraph_originaly__ = y;

            context.translate(x, y);
            x = 0;
            y = 0;

            // Rotate the canvas if need be
            if (args[9]) {
                context.rotate(args[9] / (180 / RGraph.PI));
            }


            // Vertical alignment - defaults to bottom
            if (args[6]) {

                var vAlign = args[6];

                if (vAlign == 'center') {
                    context.textBaseline = 'middle';
                } else if (vAlign == 'top') {
                    context.textBaseline = 'top';
                }
            }


            // Hoeizontal alignment - defaults to left
            if (args[7]) {

                var hAlign = args[7];
                var width  = context.measureText(text).width;
    
                if (hAlign) {
                    if (hAlign == 'center') {
                        context.textAlign = 'center';
                    } else if (hAlign == 'right') {
                        context.textAlign = 'right';
                    }
                }
            }
            
            
            context.fillStyle = originalFillStyle;

            /**
            * Draw a bounding box if requested
            */
            context.save();
                 context.fillText(text,0,0);
                 context.lineWidth = 1;

                var width = context.measureText(text).width;
                var width_offset = (hAlign == 'center' ? (width / 2) : (hAlign == 'right' ? width : 0));
                var height = size * 1.5; // !!!
                var height_offset = (vAlign == 'center' ? (height / 2) : (vAlign == 'top' ? height : 0));
                var ieOffset = RGraph.ISOLD ? 2 : 0;

                if (args[8]) {

                    context.strokeRect(-3 - width_offset,
                                       0 - 3 - height - ieOffset + height_offset,
                                       width + 6,
                                       height + 6);
                    /**
                    * If requested, draw a background for the text
                    */
                    if (args[10]) {
                        context.fillStyle = args[10];
                        context.fillRect(-3 - width_offset,
                                           0 - 3 - height - ieOffset + height_offset,
                                           width + 6,
                                           height + 6);
                    }

                    
                    context.fillStyle = originalFillStyle;


                    /**
                    * Do the actual drawing of the text
                    */
                    context.fillText(text,0,0);
                }
            context.restore();
            
            // Reset the lineWidth
            context.lineWidth = originalLineWidth;

        context.restore();
    };




    /**
    * This function returns the mouse position in relation to the canvas
    * 
    * @param object e The event object.
    */
    RG.getMouseXY = function (e)
    {
        var el = (RGraph.ISOLD ? event.srcElement : e.target);
        var x;
        var y;

        // ???
        var paddingLeft = el.style.paddingLeft ? parseInt(el.style.paddingLeft) : 0;
        var paddingTop  = el.style.paddingTop ? parseInt(el.style.paddingTop) : 0;
        var borderLeft  = el.style.borderLeftWidth ? parseInt(el.style.borderLeftWidth) : 0;
        var borderTop   = el.style.borderTopWidth  ? parseInt(el.style.borderTopWidth) : 0;
        
        if (RGraph.ISIE8) e = event;

        // Browser with offsetX and offsetY
        if (typeof(e.offsetX) == 'number' && typeof(e.offsetY) == 'number') {
            x = e.offsetX;
            y = e.offsetY;

        // FF and other
        } else {
            x = 0;
            y = 0;

            while (el != document.body && el) {
                x += el.offsetLeft;
                y += el.offsetTop;

                el = el.offsetParent;
            }

            x = e.pageX - x;
            y = e.pageY - y;
        }

        return [x, y];
    };
    
    
    
    
    /**
    * This function attempts to "fill in" missing functions from the canvas
    * context object. Only two at the moment - measureText() nd fillText().
    * 
    * @param object context The canvas 2D context
    */
    RG.oldBrowserCompat =
    RG.OldBrowserCompat = function (co)
    {
        if (!co) {
            return;
        }

        if (!co.measureText) {
        
            // This emulates the measureText() function
            co.measureText = function (text)
            {
                var textObj = document.createElement('DIV');
                textObj.innerHTML = text;
                textObj.style.position = 'absolute';
                textObj.style.top = '-100px';
                textObj.style.left = 0;
                document.body.appendChild(textObj);

                var width = {width: textObj.offsetWidth};
                
                textObj.style.display = 'none';
                
                return width;
            }
        }

        if (!co.fillText) {
            // This emulates the fillText() method
            co.fillText    = function (text, targetX, targetY)
            {
                return false;
            }
        }

        // If IE8, add addEventListener()
        if (!co.canvas.addEventListener) {
            window.addEventListener = function (ev, func, bubble)
            {
                return this.attachEvent('on' + ev, func);
            }

            co.canvas.addEventListener = function (ev, func, bubble)
            {
                return this.attachEvent('on' + ev, func);
            }
        }
    };




    /**
    * Similar to the jQuery each() function - this lets you iterate easily over an array. The 'this' variable is set]
    * to the array in the callback function.
    * 
    * @param array    arr The array
    * @param function func The function to call
    * @param object        Optionally you can specify the object that the "this" variable is set to
    */
    RG.each = function (arr, func)
    {
        for(var i=0, len=arr.length; i<len; i+=1) {
                
            if (typeof arguments[2] !== 'undefined') {
                var ret = func.call(arguments[2], i, arr[i]);
            } else {
                var ret = func.call(arr, i, arr[i]);
            }
            
            if (ret === false) {
                return;
            }
        }
    };




    /**
    * An old function the was used before all 4 gutters were added
    * 
    * DEPRECATED
    * 
    * @param object obj The chart object
    */
    RG.getHeight =
    RG.GetHeight = function (obj)
    {
        return obj.canvas.height;
    };
    
    
    
    
    /**
    * An old function the was used before all 4 gutters were added
    * 
    * DEPRECATED
    * 
    * @param object obj The chart object
    */
    RG.getWidth =
    RG.GetWidth = function (obj)
    {
        return obj.canvas.width;
    };




    /**
    * A timer function for measuring... time!
    * 
    * @param string label A string to associate with this 'checkpoint'
    */
    RG.timer =
    RG.Timer = function (label)
    {
        if(typeof RG.TIMER_LAST_CHECKPOINT == 'undefined') {
        
            RG.TIMER_LAST_CHECKPOINT = Date.now();
        }
    
        var now = Date.now();
        
        console.log(label+': ' + (now - RG.TIMER_LAST_CHECKPOINT).toString());
        
        RG.TIMER_LAST_CHECKPOINT = now;
    };




    /**
    * If you prefer, you can use the SetConfig() method to set the configuration information
    * for your chart. You may find that setting the configuration this way eases reuse.
    * 
    * @param object obj    The graph object
    * @param object config The graph configuration information
    */
    RG.setConfig =
    RG.SetConfig = function (obj, config)
    {
        for (i in config) {
            if (typeof i === 'string') {
                obj.Set(i, config[i]);
            }
        }
        
        return obj;
    };




// End module pattern
})(window, document);




    /**
    * Checks whether strings or numbers are empty or not. It also
    * handles null or variables set to undefined. If a variable really
    * is undefined - ie it hasn't been declared at all - you need to use
    * "typeof variable" and check the return value - which will be undefined.
    * 
    * @param mixed value The variable to check
    */
    window.$empty = function (value)
    {
        if (!value || value.length <= 0) {
            return true;
        }

        return false;
    };