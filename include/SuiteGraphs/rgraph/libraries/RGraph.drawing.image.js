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
    * Having this here means that the RGraph libraries can be included in any order, instead of you having
    * to include the common core library first.
    */

    // Define the RGraph global variable
    RGraph = window.RGraph || {isRGraph: true};
    RGraph.Drawing = RGraph.Drawing || {};

    /**
    * The constructor. This function sets up the object. It takes the ID (the HTML attribute) of the canvas as the
    * first argument and the data as the second. If you need to change this, you can.
    * 
    * @param string id    The canvas tag ID
    * @param number x    The X position of the label
    * @param number y    The Y position of the label
    * @param number text The text used
    */
    RGraph.Drawing.Image = function (conf)
    {
        /**
        * Allow for object config style
        */
        if (   typeof conf === 'object'
            && typeof conf.x === 'number'
            && typeof conf.y === 'number'
            && typeof conf.src === 'string'
            && typeof conf.id === 'string') {

            var id     = conf.id
            var canvas = document.getElementById(id);
            var x      = conf.x;
            var y      = conf.y;
            var src    = conf.src;

            var parseConfObjectForOptions = true; // Set this so the config is parsed (at the end of the constructor)
        
        } else {
        
            var id     = conf;
            var canvas = document.getElementById(id);
            var x      = arguments[1];
            var y      = arguments[2];
            var src    = arguments[3];
        }




        // id, x, y
        this.id                 = id;
        this.canvas             = document.getElementById(this.id);
        this.context            = this.canvas.getContext('2d');
        this.colorsParsed       = false;
        this.canvas.__object__  = this;
        this.alignmentProcessed = false;
        this.original_colors    = [];
        this.firstDraw         = true; // After the first draw this will be false


        /**
        * Store the properties
        */
        this.x   = x;
        this.y   = y;
        this.src = src;
        this.img = new Image();
        this.img.src = this.src;


        /**
        * This defines the type of this shape
        */
        this.type = 'drawing.image';


        /**
        * This facilitates easy object identification, and should always be true
        */
        this.isRGraph = true;


        /**
        * This adds a uid to the object that you can use for identification purposes
        */
        this.uid = RGraph.CreateUID();


        /**
        * This adds a UID to the canvas for identification purposes
        */
        this.canvas.uid = this.canvas.uid ? this.canvas.uid : RGraph.CreateUID();




        /**
        * Some example background properties
        */
        this.properties =
        {
            'chart.src':              null,
            'chart.width':            null,
            'chart.height':           null,
            'chart.halign':           'left',
            'chart.valign':           'top',
            'chart.events.mousemove': null,
            'chart.events.click':     null,
            'chart.shadow':           false,
            'chart.shadow.color':     'gray',
            'chart.shadow.offsetx':   3,
            'chart.shadow.offsety':   3,
            'chart.shadow.blur':      5,
            'chart.tooltips':           null,
            'chart.tooltips.highlight': true,
            'chart.tooltips.css.class': 'RGraph_tooltip',
            'chart.tooltips.event':     'onclick',
            'chart.highlight.stroke':     'rgba(0,0,0,0)',
            'chart.highlight.fill':       'rgba(255,255,255,0.7)',
            'chart.alpha':                1,
            'chart.border':               false,
            'chart.border.color':         'black',
            'chart.border.linewidth':     1,
            'chart.border.radius':        0,
            'chart.background.color':     'rgba(0,0,0,0)'
        }

        /**
        * A simple check that the browser has canvas support
        */
        if (!this.canvas) {
            alert('[DRAWING.IMAGE] No canvas support');
            return;
        }
        
        /**
        * This can be used to store the coordinates of shapes on the graph
        */
        this.coords = [];


        /**
        * Create the dollar object so that functions can be added to them
        */
        this.$0 = {};


        /*
        * Translate half a pixel for antialiasing purposes - but only if it hasn't beeen
        * done already
        */
        if (!this.canvas.__rgraph_aa_translated__) {
            this.context.translate(0.5,0.5);
            
            this.canvas.__rgraph_aa_translated__ = true;
        }




        // Short variable names
        var RG   = RGraph,
            ca   = this.canvas,
            co   = ca.getContext('2d'),
            prop = this.properties,
            pa   = RG.Path,
            pa2  = RG.path2,
            win  = window,
            doc  = document,
            ma   = Math
        
        
        
        /**
        * "Decorate" the object with the generic effects if the effects library has been included
        */
        if (RG.Effects && typeof RG.Effects.decorate === 'function') {
            RG.Effects.decorate(this);
        }




        /**
        * A setter method for setting graph properties. It can be used like this: obj.Set('chart.strokestyle', '#666');
        * 
        * @param name  string The name of the property to set OR it can be a map
        *                     of name/value settings like what you set in the constructor
        */
        this.set =
        this.Set = function (name)
        {
            var value = typeof arguments[1] === 'undefined' ? null : arguments[1];

            /**
            * the number of arguments is only one and it's an
            * object - parse it for configuration data and return.
            */
            if (arguments.length === 1 && typeof name === 'object') {
                RG.parseObjectStyleConfig(this, name);
                return this;
            }




    
            /**
            * This should be done first - prepend the propertyy name with "chart." if necessary
            */
            if (name.substr(0,6) != 'chart.') {
                name = 'chart.' + name;
            }




            // Convert uppercase letters to dot+lower case letter
            name = name.replace(/([A-Z])/g, function (str)
            {
                return '.' + String(RegExp.$1).toLowerCase();
            });





    
            prop[name] = value;
    
            return this;
        };




        /**
        * A getter method for retrieving graph properties. It can be used like this: obj.Get('chart.strokestyle');
        * 
        * @param name  string The name of the property to get
        */
        this.get =
        this.Get = function (name)
        {
            /**
            * This should be done first - prepend the property name with "chart." if necessary
            */
            if (name.substr(0,6) != 'chart.') {
                name = 'chart.' + name;
            }

            // Convert uppercase letters to dot+lower case letter
            name = name.replace(/([A-Z])/g, function (str)
            {
                return '.' + String(RegExp.$1).toLowerCase()
            });
    
            return prop[name.toLowerCase()];
        };




        /**
        * Draws the circle
        */
        this.draw =
        this.Draw = function ()
        {
            /**
            * Fire the onbeforedraw event
            */
            RG.FireCustomEvent(this, 'onbeforedraw');
    

            /**
            * Parse the colors. This allows for simple gradient syntax
            */
            var obj = this;
            this.img.onload = function ()
            {
                if (!obj.colorsParsed) {
    
                    obj.parseColors();
        
                    // Don't want to do this again
                    obj.colorsParsed = true;
                }
                
                obj.width  = this.width;
                obj.height = this.height;

    
    
    
    
    
    
                if (!this.alignmentProcessed) {
                
                    var customWidthHeight = (typeof obj.properties['chart.width'] == 'number' && typeof obj.properties['chart.width'] == 'number');

                    // Horizontal alignment
                    if (obj.properties['chart.halign'] == 'center') {
                        obj.x -= customWidthHeight ? (obj.properties['chart.width'] / 2) : (this.width / 2);
                    } else if (obj.properties['chart.halign'] == 'right') {
                        obj.x -= customWidthHeight ? obj.properties['chart.width'] : this.width;
                    }
                    
                    // Vertical alignment
                    if (obj.properties['chart.valign'] == 'center') {
                        obj.y -= customWidthHeight ? (obj.properties['chart.height'] / 2) : (this.height / 2);
                    } else if (obj.properties['chart.valign'] == 'bottom') {
                        obj.y -= customWidthHeight ? obj.properties['chart.height'] : this.height;
                    }
                    
                    // Don't do this again
                    this.alignmentProcessed = true;
                }
            }
    
    
    
    
    
    
    
            
            // The onload event doesn't always fire - so call it manually as well
            if (this.img.complete || this.img.readyState === 4) {
                this.img.onload();
            }
    
    
            /**
            * Draw the image here
            */
            
            if (prop['chart.shadow']) {
                RG.setShadow(this, prop['chart.shadow.color'], prop['chart.shadow.offsetx'], prop['chart.shadow.offsety'], prop['chart.shadow.blur']);
            }

            var oldAlpha = co.globalAlpha;
            co.globalAlpha = prop['chart.alpha'];





                /**
                * Draw a border around the image
                */
                if (prop['chart.border']) {
                    
                    co.strokeStyle = prop['chart.border.color'];
                    co.lineWidth   = prop['chart.border.linewidth'];
                    
                    var borderRadius = 0;
                    
                    // Work out the borderRadius only if the image has been loaded
                    if (this.width || this.height) {
                        borderRadius = ma.min(this.width / 2, this.height / 2)
                    }
                    
                    if ((prop['chart.width'] / 2) > borderRadius && (prop['chart.height'] / 2) > borderRadius) {
                        borderRadius = ma.min((prop['chart.width'] / 2), (prop['chart.height'] / 2))
                    }
                    
                    if (prop['chart.border.radius'] < borderRadius) {
                        borderRadius = prop['chart.border.radius'];
                    }
                
                
                
                
                    co.beginPath();
                    this.roundedRect(
                                     ma.round(this.x) - ma.round(co.lineWidth / 2),
                                     ma.round(this.y) - ma.round(co.lineWidth / 2),
                                     (prop['chart.width'] || this.img.width) + co.lineWidth,
                                     (prop['chart.height'] || this.img.height) + co.lineWidth,
                                     borderRadius
                                    );
                }
                
                
                
                if (borderRadius) {
                    co.save();
                    
                    // Draw the rect that casts the shadow
                    
                    // Draw the background color
                    this.drawBackgroundColor(borderRadius);



                    // Clip the canvas
                    co.beginPath();
                    this.roundedRect(
                                     ma.round(this.x) - ma.round(co.lineWidth / 2),
                                     ma.round(this.y) - ma.round(co.lineWidth / 2),
                                     (prop['chart.width'] || this.img.width) + co.lineWidth,
                                     (prop['chart.height'] || this.img.height) + co.lineWidth,
                                     borderRadius
                                    );
                    co.clip();
                
                } else {
                
                    // Draw the background color
                    this.drawBackgroundColor(0);
                }
                
                RG.noShadow(this);


                if (typeof prop['chart.height'] === 'number' || typeof prop['chart.width'] === 'number') {
                    co.drawImage(
                                 this.img,
                                 ma.round(this.x),
                                 ma.round(this.y),
                                 prop['chart.width'] || this.width,
                                 prop['chart.height'] || this.height
                                );
                } else {
                    co.drawImage(
                                 this.img,
                                 ma.round(this.x),
                                 ma.round(this.y)
                                );
                }




                // If borderRadius is enabled restore the canvas to it's pre-clipped state
                if (borderRadius) {
                    co.restore();
                }
                
                
        
                // If the border is enabled need a stroke so that the border is drawn
                if (prop['chart.border']) {
                    RG.noShadow(this);
                    co.stroke();
                }





            co.globalAlpha = oldAlpha;
    
            //var obj    = this;
    
            this.img.onload = function ()
            {
                RG.redrawCanvas(ca);
                
                obj.coords[0] = [Math.round(obj.x), Math.round(obj.y), typeof(prop['chart.width']) == 'number' ? prop['chart.width'] : this.width, typeof prop['chart.height'] == 'number' ? prop['chart.height'] : this.height];
    
            }
            
            RG.NoShadow(this);
    
    
            /**
            * This installs the event listeners
            */
            RG.InstallEventListeners(this);
    

            /**
            * Fire the onfirstdraw event
            */
            if (this.firstDraw) {
                RG.fireCustomEvent(this, 'onfirstdraw');
                this.firstDraw = false;
                this.firstDrawFunc();
            }




            /**
            * Fire the ondraw event
            */
            RG.FireCustomEvent(this, 'ondraw');
            
            return this;
        };
        
        
        
        /**
        * Used in chaining. Runs a function there and then - not waiting for
        * the events to fire (eg the onbeforedraw event)
        * 
        * @param function func The function to execute
        */
        this.exec = function (func)
        {
            func(this);
            
            return this;
        };




        /**
        * The getObjectByXY() worker method
        */
        this.getObjectByXY = function (e)
        {
            var mouseXY = RG.getMouseXY(e);
    
            if (this.getShape(e)) {
                return this;
            }
        };




        /**
        * Not used by the class during creating the shape, but is used by event handlers
        * to get the coordinates (if any) of the selected bar
        * 
        * @param object e The event object
        * @param object   OPTIONAL You can pass in the bar object instead of the
        *                          function using "this"
        */
        this.getShape = function (e)
        {
            var mouseXY = RG.getMouseXY(e);
            var mouseX  = mouseXY[0];
            var mouseY  = mouseXY[1];
    
            if (   this.coords
                && this.coords[0]
                && mouseXY[0] >= this.coords[0][0]
                && mouseXY[0] <= (this.coords[0][0] + this.coords[0][2])
                && mouseXY[1] >= this.coords[0][1]
                && mouseXY[1] <= (this.coords[0][1] + this.coords[0][3])) {
                
                return {
                        0: this, 1: this.coords[0][0], 2: this.coords[0][1], 3: this.coords[0][2], 4: this.coords[0][3], 5: 0,
                        'object': this, 'x': this.coords[0][0], 'y': this.coords[0][1], 'width': this.coords[0][2], 'height': this.coords[0][3], 'index': 0, 'tooltip': prop['chart.tooltips'] ? prop['chart.tooltips'][0] : null
                       };
            }
            
            return null;
        };




        /**
        * This function positions a tooltip when it is displayed
        * 
        * @param obj object     The chart object
        * @param int x          The X coordinate specified for the tooltip
        * @param int y          The Y coordinate specified for the tooltip
        * @param object tooltip The tooltips DIV element
        * @param number idx     The index of the tooltip
        */
        this.positionTooltip = function (obj, x, y, tooltip, idx)
        {
            var canvasXY   = RG.getCanvasXY(obj.canvas);
            var width      = tooltip.offsetWidth;
            var height     = tooltip.offsetHeight;
    
            // Set the top position
            tooltip.style.left = 0;
            tooltip.style.top  = canvasXY[1] - height - 7 + this.coords[0][1] + (obj.coords[0][3] / 2) + 'px';
    
            // By default any overflow is hidden
            tooltip.style.overflow = '';
    
            // The arrow
            var img = new Image();
                img.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABEAAAAFCAYAAACjKgd3AAAARUlEQVQYV2NkQAN79+797+RkhC4M5+/bd47B2dmZEVkBCgcmgcsgbAaA9GA1BCSBbhAuA/AagmwQPgMIGgIzCD0M0AMMAEFVIAa6UQgcAAAAAElFTkSuQmCC';
                img.style.position = 'absolute';
                img.id = '__rgraph_tooltip_pointer__';
                img.style.top = (tooltip.offsetHeight - 2) + 'px';
            tooltip.appendChild(img);
            
            // Reposition the tooltip if at the edges:
            
            // LEFT edge
            if ((canvasXY[0] + obj.coords[0][0] + (obj.coords[0][2] / 2) - (width / 2)) < 10) {
                tooltip.style.left = (canvasXY[0] + this.coords[0][0] + (this.coords[0][2] / 2) - (width * 0.1)) + 'px';
                img.style.left = ((width * 0.1) - 8.5) + 'px';
    
            // RIGHT edge
            } else if ((canvasXY[0] + this.coords[0][0] + (this.coords[0][2] / 2) + (width / 2)) > doc.body.offsetWidth) {
                tooltip.style.left = (canvasXY[0] + this.coords[0][0] + (this.coords[0][2] / 2) - (width * 0.9)) + 'px';
                img.style.left = ((width * 0.9) - 8.5) + 'px';
    
            // Default positioning - CENTERED
            } else {
                tooltip.style.left = (canvasXY[0] + this.coords[0][0] + (this.coords[0][2] / 2) - (width * 0.5)) + 'px';
                img.style.left = ((width * 0.5) - 8.5) + 'px';
            }
        };




        /**
        * Each object type has its own Highlight() function which highlights the appropriate shape
        * 
        * @param object shape The shape to highlight
        */
        this.highlight =
        this.Highlight = function (shape)
        {
            if (prop['chart.tooltips.highlight']) {
                pa(co, ['b','r',this.coords[0][0],this.coords[0][1],this.coords[0][2],this.coords[0][3], 'f',prop['chart.highlight.fill'], 's', prop['chart.highlight.stroke']]);
            }
        };




        /**
        * This allows for easy specification of gradients
        */
        this.parseColors = function ()
        {

            // Save the original colors so that they can be restored when the canvas is reset
            if (this.original_colors.length === 0) {
                this.original_colors['chart.highlight.stroke'] = RG.array_clone(prop['chart.highlight.stroke']);
                this.original_colors['chart.highlight.fill']   = RG.array_clone(prop['chart.highlight.fill']);
            }




            /**
            * Parse various properties for colors
            */
            prop['chart.highlight.stroke'] = this.parseSingleColorForGradient(prop['chart.highlight.stroke']);
            prop['chart.highlight.fill']   = this.parseSingleColorForGradient(prop['chart.highlight.fill']);
        };




        /**
        * Use this function to reset the object to the post-constructor state. Eg reset colors if
        * need be etc
        */
        this.reset = function ()
        {
        };




        /**
        * This parses a single color value
        */
        this.parseSingleColorForGradient = function (color)
        {
            if (!color) {
                return color;
            }
    

            if (typeof color === 'string' && color.match(/^gradient\((.*)\)$/i)) {

                var parts = RegExp.$1.split(':');
    
                // Create the gradient
                var grad = co.createLinearGradient(this.x, this.y, this.x + this.img.width, this.y);
    
                var diff = 1 / (parts.length - 1);
    
                grad.addColorStop(0, RG.trim(parts[0]));
    
                for (var j=1; j<parts.length; ++j) {
                    grad.addColorStop(j * diff, RG.trim(parts[j]));
                }
            }
    
            return grad ? grad : color;
        };




        /**
        * Using a function to add events makes it easier to facilitate method chaining
        * 
        * @param string   type The type of even to add
        * @param function func 
        */
        this.on = function (type, func)
        {
            if (type.substr(0,2) !== 'on') {
                type = 'on' + type;
            }
            
            this[type] = func;
    
            return this;
        };




        /**
        * This function runs once only
        * (put at the end of the file (before any effects))
        */
        this.firstDrawFunc = function ()
        {
        };




        /**
        * This draws a rectangle for the border of the image with optional rounded corners
        */
        this.roundedRect = function (x, y, width, height, radius)
        {
            // Save the existing state of the canvas so that it can be restored later
            co.save();
            
                // Translate to the given X/Y coordinates
                co.translate(x, y);
    
                // Move to the center of the top horizontal line
                co.moveTo(width / 2,0);
                
                // Draw the rounded corners. The connecting lines in between them are drawn automatically
                co.arcTo(width,0,width,height, ma.min(height / 2, radius));
                co.arcTo(width, height, 0, height, ma.min(width / 2, radius));
                co.arcTo(0, height, 0, 0, ma.min(height / 2, radius));
                co.arcTo(0, 0, radius, 0, ma.min(width / 2, radius));
    
                // Draw a line back to the start coordinates
                co.lineTo(width / 2,0);
    
            // Restore the state of the canvas to as it was before the save()
            co.restore();
        };




        /**
        * 
        */
        this.drawBackgroundColor = function (borderRadius)
        {
            co.beginPath();
            co.fillStyle = prop['chart.background.color'];
            this.roundedRect(
                             ma.round(this.x) - ma.round(co.lineWidth / 2),
                             ma.round(this.y) - ma.round(co.lineWidth / 2),
                             (prop['chart.width'] || this.img.width) + co.lineWidth,
                             (prop['chart.height'] || this.img.height) + co.lineWidth,
                             borderRadius
                            );
            co.fill();
        };



        RG.att(ca);


        /**
        * Objects are now always registered so that the chart is redrawn if need be.
        */
        RG.Register(this);




        /**
        * This is the 'end' of the constructor so if the first argument
        * contains configuration data - handle that.
        */
        if (parseConfObjectForOptions) {
            RG.parseObjectStyleConfig(this, conf.options);
        }
    };