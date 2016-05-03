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
    * first argument and the data as the second. If you need to change this, you can. Alternatively it can take
    * a single JSON-style configuration object
    * 
    * @param string id    The canvas tag ID
    * @param number x    The X position of the marker
    * @param number y    The Y position of the marker
    * @param number text The max radius of the pulsing circle
    */
    RGraph.Drawing.Marker3 = function (conf)
    {
        /**
        * Allow for object config style
        */
        if (   typeof conf === 'object'
            && typeof conf.x === 'number'
            && typeof conf.y === 'number'
            && typeof conf.id === 'string'
            && typeof conf.radius === 'number') {

            var id     = conf.id
            var canvas = document.getElementById(id);
            var x      = conf.x;
            var y      = conf.y;
            var radius = conf.radius;

            var parseConfObjectForOptions = true; // Set this so the config is parsed (at the end of the constructor)
        
        } else {
        
            var id     = conf;
            var canvas = document.getElementById(id);
            var x      = arguments[1];
            var y      = arguments[2];
            var radius = arguments[3];
        }




        this.id                = id;
        this.canvas            = document.getElementById(this.id);
        this.context           = this.canvas.getContext('2d')
        this.colorsParsed      = false;
        this.canvas.__object__ = this;
        this.original_colors   = [];
        this.firstDraw         = true; // After the first draw this will be false
        
        // The actual radius is what is used to draw the marker - the other radius is the maximum target radius
        // that the marker grows to
        this.actualRadius = 0;
        
        // This is the alpha value that is used to fade out the pulsing marker
        this.alpha = 1;


        /**
        * Store the properties
        */
        this.centerx = x;
        this.centery = y;
        this.radius  = radius;


        /**
        * This defines the type of this shape
        */
        this.type = 'drawing.marker3';


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
            'chart.fillstyle':          'rgba(255,255,255,1)',
            'chart.delay':              50,
            'chart.events.click':       null,
            'chart.events.mousemove':   null,
            'chart.highlight.fill':     'rgba(255,0,0,1.0)',
            'chart.tooltips':           null,
            'chart.tooltips.highlight': true,
            'chart.tooltips.event':     'onclick'
        }

        /**
        * A simple check that the browser has canvas support
        */
        if (!this.canvas) {
            alert('[DRAWING.MARKER3] No canvas support');
            return;
        }
        
        /**
        * These are used to store coords
        */
        this.coords     = [];
        this.coordsText = [];


        /**
        * Create the dollar object so that functions can be added to them
        */
        this.$0 = {};


        /**
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
        * Draws the marker
        */
        this.draw =
        this.Draw = function ()
        {
            // Draw a circle to start with
            co.globalAlpha = this.alpha;
            pa(this, [
                'b',
                'a', this.centerx, this.centery, this.actualRadius, 0, 2 * Math.PI,false,
                'a', this.centerx, this.centery, ma.max(this.actualRadius - 8, 0), 2 * Math.PI,0, true,
                'f', prop['chart.fillstyle']]
            );
            this.alpha = this.actualRadius ? 1 - ( (this.actualRadius * 0.75) / this.radius) : 1;
            co.globalAlpha = 1;
            
            
            if (this.actualRadius < this.radius) {
                this.actualRadius += 2;
            } else if (this.actualRadius >= this.radius) {
                this.actualRadius = 0;
                this.alpha = 1;
            }

            var obj = this;
            setTimeout(function ()
            {
                RG.redrawCanvas(ca);
            }, prop['chart.delay']);




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
            RG.fireCustomEvent(this, 'ondraw');
            
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
            if (this.getShape(e)) {
                return this;
            }
        };




        /**
        * Not used by the class during creating the shape, but is used by event handlers
        * to get the coordinates (if any) of the selected bar
        * 
        * @param object e The event object
        */
        this.getShape = function (e)
        {
            var mouseXY = RGraph.getMouseXY(e);
            var mouseX  = mouseXY[0];
            var mouseY  = mouseXY[1];
    
            if (RG.getHypLength(this.centerx, this.centery, mouseXY[0], mouseXY[1]) <= this.radius) {
                
                return {
                    0: this, 1: this.centerx, 2: this.centery, 3: this.radius, 4: null, 5: 0,
                    'object': this, 'x': this.centerx, 'y': this.centery, 'radius': this.radius, 'index': 0, 'tooltip': prop['chart.tooltips'] ? prop['chart.tooltips'][0] : null
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
            var radius     = this.radius;
    
            // Set the top position
            tooltip.style.left = 0;
            tooltip.style.top  = canvasXY[1] + obj.centery - height - 7 + 'px';
            
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
            if ((canvasXY[0] + obj.centerx - (width / 2)) < 10) {
                tooltip.style.left = (canvasXY[0] + this.centerx - (width * 0.1))  + 'px';
                img.style.left = ((width * 0.1) - 8.5) + 'px';
    
            // RIGHT edge
            } else if ((canvasXY[0] + obj.centerx + (width / 2)) > doc.body.offsetWidth) {
                tooltip.style.left = canvasXY[0] + this.centerx - (width * 0.9) + 'px';
                img.style.left = ((width * 0.9) - 8.5) + 'px';
    
            // Default positioning - CENTERED
            } else {
                tooltip.style.left = (canvasXY[0] + this.centerx - (width * 0.5)) + 'px';
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
                pa(this, ['b','r',this.coords[0][0],this.coords[0][1],this.coords[0][2],this.coords[0][3],'f',prop['chart.highlight.fill'],'s',prop['chart.highlight.stroke']]);
            }
        };




        /**
        * This allows for easy specification of gradients
        */
        this.parseColors = function ()
        {
            // Save the original colors so that they can be restored when the canvas is reset
            if (this.original_colors.length === 0) {
                this.original_colors['chart.fillstyle']        = RG.array_clone(prop['chart.fillstyle']);
                this.original_colors['chart.highlight.fill']   = RG.array_clone(prop['chart.highlight.fill']);
            }




            /**
            * Parse various properties for colors
            */
            prop['chart.fillstyle']        = this.parseSingleColorForGradient(prop['chart.fillstyle']);
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
            var canvas  = this.canvas;
            var context = this.context;
            
            if (!color) {
                return color;
            }
    
            if (typeof color === 'string' && color.match(/^gradient\((.*)\)$/i)) {
    
                var parts = RegExp.$1.split(':');
    
                // Create the gradient
                var grad = co.createRadialGradient(this.centerx, this.centery, 0, this.centerx, this.centery, this.radius);

                var diff = 1 / (parts.length - 1);
    
                //grad.addColorStop(0, RG.trim(parts[0]));
    
                for (var j=0; j<parts.length; j+=1) {
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


        RG.att(ca);


        /**
        * Objects are now always registered so that the chart is redrawn if need be.
        */
        RG.Register(this);




        /**
        * the number of arguments is only one and it's an
        * object - parse it for configuration data and return.
        */
        if (parseConfObjectForOptions) {
            RG.parseObjectStyleConfig(this, conf.options);
        }
    };