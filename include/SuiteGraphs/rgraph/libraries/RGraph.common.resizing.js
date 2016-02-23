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
    var RG     = RGraph,
        ua     = navigator.userAgent,
        ma     = Math,
        active = null;


    /**
    * This function can be used to allow resizing
    * 
    * @param object obj Your graph object
    */
    RGraph.allowResizing =
    RGraph.AllowResizing = function (obj)
    {
        var ca = obj.canvas,
            co = obj.context,
            pa = RGraph.path;
        
        ca.resizing = ca.resizing || {};
        ca.resizing.placeHolders = ca.resizing.placeHolders || [];
        
        /**
        * Store the original width/height on the canvas
        */
        if (!ca.resizing.originalw) { ca.resizing.originalw = ca.width; }
        if (!ca.resizing.originalh) { ca.resizing.originalh = ca.height; }













        // The size of the resize handle (so '15' isn't littered throughout the code)
        var resizeHandleSize = 15;


        // Add the original width and height to the canvas
        if (   !ca.resizing.__rgraph_original_width__
            || !ca.resizing.__rgraph_original_height__
            || !ca.resizing.__adjustX
            || !ca.resizing.__adjustY
           ) {

            ca.resizing.__rgraph_original_width__  = ca.width;
            ca.resizing.__rgraph_original_height__ = ca.height;
            ca.resizing.adjustX = (typeof obj.get('chart.resize.handle.adjust') == 'object' && typeof obj.get('chart.resize.handle.adjust')[0] == 'number' ? obj.Get('chart.resize.handle.adjust')[0] : 0);
            ca.resizing.adjustY = (typeof obj.get('chart.resize.handle.adjust') == 'object' && typeof obj.get('chart.resize.handle.adjust')[1] == 'number' ? obj.Get('chart.resize.handle.adjust')[1] : 0);
            ca.resizing.bgcolor = obj.get('chart.resize.handle.background') || 'rgba(0,0,0,0)';
        }




        // Draw the resize handle
        pa(co, ['b','m', ca.width - resizeHandleSize - resizeHandleSize + ca.resizing.adjustX, ca.height - resizeHandleSize,'r', ca.width - resizeHandleSize - resizeHandleSize + ca.resizing.adjustX, ca.height - resizeHandleSize + ca.resizing.adjustY, 2 * resizeHandleSize, resizeHandleSize,'f', ca.resizing.bgcolor]);

        // Draw the arrows
        pa(co, ['b','lw', 1,'m', ma.round(ca.width - (resizeHandleSize / 2) + ca.resizing.adjustX), ca.height - resizeHandleSize + ca.resizing.adjustY,'l', ma.round(ca.width - (resizeHandleSize / 2) + ca.resizing.adjustX), ca.height + ca.resizing.adjustY,'m',ca.width + ca.resizing.adjustX, ma.round(ca.height - (resizeHandleSize / 2) + ca.resizing.adjustY),'l',  ca.width - resizeHandleSize + ca.resizing.adjustX, ma.round(ca.height - (resizeHandleSize / 2) + ca.resizing.adjustY), 's', 'gray', 'f', 'transparent']);

        // Top arrow head
        pa(co, [ 'b', 'm', ca.width - (resizeHandleSize / 2) + ca.resizing.adjustX, ca.height - resizeHandleSize + ca.resizing.adjustY, 'l',ca.width - (resizeHandleSize / 2) + 3 + ca.resizing.adjustX, ca.height - resizeHandleSize + 3 + ca.resizing.adjustY, 'l',ca.width - (resizeHandleSize / 2) - 3 + ca.resizing.adjustX, ca.height - resizeHandleSize + 3 + ca.resizing.adjustY, 'c', 'f','gray']);

        // Bottom arrow head
        pa(co, ['b','m', ca.width - (resizeHandleSize / 2) + ca.resizing.adjustX, ca.height + ca.resizing.adjustY,'l', ca.width - (resizeHandleSize / 2) + 3 + ca.resizing.adjustX, ca.height - 3 + ca.resizing.adjustY,'l', ca.width - (resizeHandleSize / 2) - 3 + ca.resizing.adjustX, ca.height - 3 + ca.resizing.adjustY,'c','f', 'gray']);

        // Left arrow head
        pa(co, ['b','m', ca.width - resizeHandleSize + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) + ca.resizing.adjustY,'l', ca.width - resizeHandleSize + 3 + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) + 3 + ca.resizing.adjustY,'l', ca.width - resizeHandleSize + 3 + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) - 3 + ca.resizing.adjustY,'c','f', 'gray']);
        
        // Right arrow head
        pa(co, ['b','m',ca.width + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) + ca.resizing.adjustY,'l',ca.width - 3 + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) + 3 + ca.resizing.adjustY,'l',ca.width  - 3 + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) - 3 + ca.resizing.adjustY,'c','f', 'gray']);
        
        // Square at the centre of the arrows
        pa(co, ['b','m',ca.width + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) + ca.resizing.adjustY,'r',ca.width - (resizeHandleSize / 2) - 2 + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) - 2 + ca.resizing.adjustY, 4, 4,'r',ca.width - (resizeHandleSize / 2) - 2 + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) - 2 + ca.resizing.adjustY, 4, 4,'s','gray','f','white']);

        // Draw the "Reset" button
        pa(co, ['b','m',ma.round(ca.width - resizeHandleSize - 3 + ca.resizing.adjustX), ca.height - resizeHandleSize / 2 + ca.resizing.adjustY,'l',ma.round(ca.width - resizeHandleSize - resizeHandleSize + ca.resizing.adjustX), ca.height - (resizeHandleSize / 2) + ca.resizing.adjustY,'l',ca.width - resizeHandleSize - resizeHandleSize + 2 + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) - 2 + ca.resizing.adjustY,'l',ca.width - resizeHandleSize - resizeHandleSize + 2 + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) + 2 + ca.resizing.adjustY,'l',ca.width - resizeHandleSize - resizeHandleSize + ca.resizing.adjustX, ca.height - (resizeHandleSize / 2) + ca.resizing.adjustY,'s','gray','f','gray']);

        // The vertical line at the end of the reset button
        pa(co, ['b','m', ma.round(ca.width - resizeHandleSize - resizeHandleSize - 1 + ca.resizing.adjustX), ca.height - (resizeHandleSize / 2) - 3 + ca.resizing.adjustY,'l', ma.round(ca.width - resizeHandleSize - resizeHandleSize - 1 + ca.resizing.adjustX), ca.height - (resizeHandleSize / 2) + 3 + ca.resizing.adjustY,'s','f']);







        /**
        * The code inside this if() condition only runs once due to the if() condition tests- if
        * the obj.rgraphResizewrapper variable exists then the code has run
        */
        if (obj.get('chart.resizable') && !ca.rgraphResizewrapper) {



// ** TODO ** Needs fixing
//
//
// Wrap the canvas
// ** NEEDS FIXING **
//
ca.rgraphResizewrapper = $('<div id="rgraph_resize_container_' + ca.id +'"></div>').css({
    'float': ca.style.cssFloat,
    position: 'relative'
}).get(0);

$(ca).wrap(ca.rgraphResizewrapper);

// TODO Might need to add more properties here (eg margin, padding etc)
ca.style.cssFloat = 'none';
ca.style.top   = 0;
ca.style.left  = 0;



            var window_onmousemove = function (e)
            {
                var ca = active;
                
                if (ca) {

                    e = RG.fixEventObject(e);

                    if (ca.resizing.mousedown) {
    
                        var newWidth  = ca.width + (e.pageX - ca.resizing.originalx);
                        var newHeight = ca.height + (e.pageY - ca.resizing.originaly);

                        if (newWidth > (ca.resizing.originalw / 2)) {
                            ca.resizing.div.style.width = newWidth + 'px';
                        }
                        
                        if (newHeight > (ca.resizing.originalh / 2)) {
                            ca.resizing.div.style.height = newHeight + 'px';
                        }
                        
                        RG.fireCustomEvent(ca.__object__, 'onresize');
                    }
                }
            }
            // Install the function as an event listener - but only once
            if (typeof(canvas.rgraph_resize_window_mousemove_listener_installed) != 'boolean') {
                window.addEventListener('mousemove', window_onmousemove, false);
                canvas.rgraph_resize_window_mousemove_listener_installed = true;
            }

            // The window onmouseup function
            var MouseupFunc = function (e)
            {
                if (!ca.resizing || !ca.resizing.div || !ca.resizing.mousedown) {
                    return;
                }

                if (ca.resizing.div) {

                    var div    = ca.resizing.div;
                    var coords = RG.getCanvasXY(ca);

                    var parentNode = ca.parentNode;

                    if (ca.style.position != 'absolute') {
                        
                        // Create a DIV to go in the canvases place
                        var placeHolderDIV               = document.createElement('DIV');
                            placeHolderDIV.style.width   = ca.resizing.originalw + 'px';
                            placeHolderDIV.style.height  = ca.resizing.originalh + 'px';

                            placeHolderDIV.style.display  = 'inline-block'; // Added 5th Nov 2010
                            placeHolderDIV.style.position = ca.style.position;
                            placeHolderDIV.style.left     = ca.style.left;
                            placeHolderDIV.style.top      = ca.style.top;
                            placeHolderDIV.style.cssFloat = ca.style.cssFloat;

                        parentNode.insertBefore(placeHolderDIV, ca);
                    }


                    // Now set the canvas to be positioned absolutely
                    ca.style.backgroundColor = 'white';
                    ca.style.position        = 'absolute';
                    ca.style.border          = '1px dashed gray';
                    ca.style.boxShadow       = '2px 2px 5px #ddd';


                    ca.style.left = 0;//(ca.resizing.originalCanvasX  - 2) + 'px';
                    ca.style.top  = 0;//(ca.resizing.originalCanvasY - 2) + 'px';


                    // Set the dimensions of the canvas using the HTML attributes
                    ca.width  = parseInt(div.style.width);
                    ca.height = parseInt(div.style.height);




                    // Because resizing the canvas resets any tranformation - the antialias fix needs to be reapplied.
                    ca.getContext('2d').translate(0.5,0.5);



                    // Reset the gradient parsing status by setting all of the color values back to their original
                    // values before Draw was first called
                    var objects = RG.ObjectRegistry.getObjectsByCanvasID(ca.id);
                    for (var i=0,len=objects.length; i<len; i+=1) {
                        
                        RG.resetColorsToOriginalValues(objects[i]);
                        if (typeof objects[i].reset === 'function') {
                            objects[i].reset();
                        }
                    }
                    
                    
                    
                    
                    // Kill the background cache
                    RG.cache = [];
                

                    // Fire the onresize event
                    RG.fireCustomEvent(canvas.__object__, 'onresizebeforedraw');

                    RG.redrawCanvas(ca);
                    

                    // Get rid of transparent semi-opaque DIV
                    ca.resizing.mousedown = false;
                    div.style.display = 'none';
                    document.body.removeChild(div);
                }


                // If there is zoom enabled in thumbnail mode, lose the zoom image
                if (RG.Registry.Get('chart.zoomed.div') || RGraph.Registry.Get('chart.zoomed.img')) {
                    RG.Registry.Set('chart.zoomed.div', null);
                    RG.Registry.Set('chart.zoomed.img', null);
                }


                // Fire the onresize event
                RG.FireCustomEvent(ca.__object__, 'onresizeend');
            };


            var window_onmouseup = MouseupFunc;
            
            // Install the function as an event listener - but only once
            if (typeof ca.rgraph_resize_window_mouseup_listener_installed != 'boolean') {
                window.addEventListener('mouseup', window_onmouseup, false);
                ca.rgraph_resize_window_mouseup_listener_installed = true;
            }




























            var canvas_onmousemove = function (e)
            {

                e = RG.fixEventObject(e);
                
                var coords  = RG.getMouseXY(e);
                var obj     = e.target.__object__;
                var ca      = e.target;
                var co      = ca.getContext('2d');
                var cursor  = ca.style.cursor;

                // Save the original cursor
                if (!ca.resizing.original_cursor) {
                    ca.resizing.original_cursor = cursor;
                }
                
                if (   (coords[0] > (ca.width - resizeHandleSize)
                    && coords[0] < ca.width
                    && coords[1] > (ca.height - resizeHandleSize)
                    && coords[1] < ca.height)) {

                        ca.style.cursor = 'move';

                } else if (   coords[0] > (ca.width - resizeHandleSize - resizeHandleSize)
                           && coords[0] < ca.width - resizeHandleSize
                           && coords[1] > (ca.height - resizeHandleSize)
                           && coords[1] < ca.height) {
                    
                    ca.style.cursor = 'pointer';

                } else {
                    if (ca.resizing.original_cursor) {
                        ca.style.cursor = ca.resizing.original_cursor;
                        ca.resizing.original_cursor = null;
                    } else {
                        ca.style.cursor = 'default';
                    }
                }
            };





            // Install the function as an event listener - but only once
            if (typeof ca.rgraph_resize_mousemove_listener_installed != 'boolean') {
                ca.addEventListener('mousemove', canvas_onmousemove, false);
                ca.rgraph_resize_mousemove_listener_installed = true;
            }





            var canvas_onmouseout = function (e)
            {
                e.target.style.cursor = 'default';
                e.target.title        = '';
            };

            // Install the function as an event listener - but only once
            if (typeof ca.rgraph_resize_mouseout_listener_installed != 'boolean') {
                ca.addEventListener('mouseout', canvas_onmouseout, false);
                ca.rgraph_resize_mouseout_listener_installed = true;
            }





            var canvas_onmousedown = function (e)
            {
                e = RG.fixEventObject(e);

                var coords   = RG.getMouseXY(e);
                var canvasXY = RG.getCanvasXY(e.target);
                var ca       = e.target;
                
                /**
                * Set the active variable to the last canvas that was clicked on
                */
                active = ca;






                if (   coords[0] > (ca.width - resizeHandleSize)
                    && coords[0] < ca.width
                    && coords[1] > (ca.height - resizeHandleSize)
                    && coords[1] < ca.height) {

                    RG.fireCustomEvent(obj, 'onresizebegin');
                    
                    // Save the existing border
                    if (ca.resizing.original_css_border == null) {
                        ca.resizing.original_css_border = ca.style.border;
                    }
                    
                    // Save the existing shadow
                    if (ca.resizing.original_css_shadow == null) {
                        ca.resizing.original_css_shadow = ca.style.boxShadow;
                    }

                    ca.resizing.mousedown = true;


                    // Create the semi-opaque DIV
                    var div = document.createElement('DIV');
                        div.style.position = 'absolute';
                        div.style.left     = canvasXY[0] + 'px';
                        div.style.top      = canvasXY[1] + 'px';
                        div.style.width    = ca.width + 'px';
                        div.style.height   = ca.height + 'px';
                        div.style.border   = '1px dotted black';
                        div.style.backgroundColor = 'gray';
                        div.style.opacity  = 0.5;
                        div.__canvas__ = e.target;
                    document.body.appendChild(div);

                    ca.resizing.div = div;
                    ca.resizing.placeHolders.push(div);
                    
                    // Hide the previous resize indicator layers. This is only necessary it seems for the Meter chart
                    for (var i=0; i<(ca.resizing.placeHolders.length - 1); ++i) {
                        ca.resizing.placeHolders[i].style.display = 'none';
                    }

                    // This is a repetition of the window.onmouseup function (No need to use DOM2 here)
                    div.onmouseup = function (e)
                    {
                        MouseupFunc(e);
                    }

                    
                    // No need to use DOM2 here
                    ca.resizing.div.onmouseover = function (e)
                    {
                        e = RG.fixEventObject(e);
                        e.stopPropagation();
                    }

                    // The mouse
                    ca.resizing.originalx = e.pageX;
                    ca.resizing.originaly = e.pageY;

                    ca.resizing.originalCanvasX = RG.getCanvasXY(ca)[0];
                    ca.resizing.originalCanvasY = RG.getCanvasXY(ca)[1];
                }

                // This facilitates the reset button
                if (   coords[0] > (ca.width - resizeHandleSize - resizeHandleSize)
                    && coords[0] < ca.width - resizeHandleSize
                    && coords[1] > (ca.height - resizeHandleSize)
                    && coords[1] < ca.height
                    && ca.resizing.originalw
                    && ca.resizing.originaly) {
                    

                    // Fire the onresizebegin event
                    RG.fireCustomEvent(ca.__object__, 'onresizebegin');

                    // Restore the original width and height
                    ca.width = ca.resizing.originalw;
                    ca.height = ca.resizing.originalh;

                    // TODO Need to check the parent is actually a DIV container or not?
                    
                    // Show the link if it exists and the display is set to none
                    if (ca.__link__ && ca.__link__.style.display === 'none') {
                        ca.__link__.style.display = 'inline';
                    }

                    if (typeof ca.parentNode.id === 'string' && ca.parentNode.id.substring(0, 24) === 'rgraph_resize_container_') {
                        ca.parentNode.style.width  = ca.resizing.originalw + 'px';
                        ca.parentNode.style.height = ca.resizing.originalh + 'px';
                    }

                    // Lose the border
                    ca.style.border = ca.resizing.original_css_border;
                    
                    //Lose the shadow
                    ca.style.boxShadow = ca.resizing.original_css_shadow;

                    
                    // Add 1 pixel to the top/left because the border is going
                    ca.style.left = (parseInt(ca.style.left)) + 'px';
                    ca.style.top  = (parseInt(ca.style.top)) + 'px';



                    // Because resetting the canvas resizes it - and so loses any translation - need to reapply the
                    // antialiasing translation
                    ca.getContext('2d').translate(0.5,0.5);
                    
                    
                    RG.fireCustomEvent(ca.__object__, 'onresizebeforedraw');
                    
                    // Since gradients are pre-parsed colors - this resets the colors to what they were
                    // before the parsing.
                    var objects = RG.ObjectRegistry.getObjectsByCanvasID(ca.id);
                    for (var i=0; i<objects.length; i+=1) {
                        RG.resetColorsToOriginalValues(objects[i]);
                        if (objects[i].reset) {
                            objects[i].reset();
                        }
                        
                        RG.redrawCanvas(objects[i].canvas);
                    }
                    
                    
                    // Clear the cache so that old things (eg backgrounds) are not reused
                    RG.cache = [];






                    // Redraw the canvas
                    //RG.redrawCanvas(objects[i].canvas);
                    

                    // Set the width and height on the DIV
                    if (ca.resizing.div) {
                        ca.resizing.div.style.width  = ca.__original_width__ + 'px';
                        ca.resizing.div.style.height = ca.__original_height__ + 'px';
                    }


                    // Fire the resize event
                    RG.fireCustomEvent(ca.__object__, 'onresize');
                    RG.fireCustomEvent(ca.__object__, 'onresizeend');
                }
            };

            // Install the function as an event listener - but only once
            if (typeof ca.rgraph_resize_mousedown_listener_installed != 'boolean') {
                ca.addEventListener('mousedown', canvas_onmousedown, false);
                ca.rgraph_resize_mousedown_listener_installed = true;
            }
        }
    };
// End module pattern
})(window, document);