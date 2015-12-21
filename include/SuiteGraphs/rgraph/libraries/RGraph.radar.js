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

    /**
    * The traditional radar chart constructor
    * 
    * @param string id   The ID of the canvas
    * @param array  data An array of data to represent
    */
    RGraph.Radar = function (conf)
    {
        /**
        * Allow for object config style
        */
        if (   typeof conf === 'object'
            && typeof conf.data === 'object'
            && typeof conf.id === 'string') {

            var parseConfObjectForOptions = true; // Set this so the config is parsed (at the end of the constructor)
            
            // Turn conf.data into a multi-d array if it's not already
            if (typeof conf.data[0] === 'number') {
                conf.data = [conf.data];
            }
        
        } else {

            var conf = {id: conf, data: []};
            
            // Arguments style: var foo = new RGraph.Radar('cvs', [1,2,3], [1,2,3], [1,2,3]);
            if (typeof arguments[1] === 'object' && typeof arguments[1][0] === 'number') {
                for (var i=1; i<arguments.length; ++i) {
                    conf.data.push(RGraph.arrayClone(arguments[i]));
                }

            // Arguments style: var foo = new RGraph.Radar('cvs', [[1,2,3], [1,2,3], [1,2,3]]);
            } else if (   typeof arguments[1] === 'object'
                       && typeof arguments[1][0] === 'object'
                       && typeof arguments[1][0][0] === 'number') {
                
                conf.data = RGraph.arrayClone(arguments[1]);
            }
        }




        this.id                = conf.id;
        this.canvas            = document.getElementById(conf.id);
        this.context           = this.canvas.getContext ? this.canvas.getContext("2d") : null;
        this.canvas.__object__ = this;
        this.type              = 'radar';
        this.isRGraph          = true;
        this.data              = [];
        this.max               = 0;
        this.uid               = RGraph.CreateUID();
        this.canvas.uid        = this.canvas.uid ? this.canvas.uid : RGraph.CreateUID();
        this.colorsParsed      = false;
        this.coords            = [];
        this.coordsText        = [];
        this.original_data     = [];
        this.original_colors   = [];
        this.firstDraw         = true; // After the first draw this will be false

        /**
        * Add the data to the .original_data array and work out the max value
        */
        for (var i=0,len=conf.data.length; i<len; ++i) {
            this.original_data.push(RGraph.arrayClone(conf.data[i]));
            this.data.push(RGraph.arrayClone(conf.data[i]));
            this.max = Math.max(this.max, RGraph.arrayMax(conf.data[i]));
        }


        this.properties =
        {
            'chart.strokestyle':           '#aaa',
            'chart.gutter.left':           25,
            'chart.gutter.right':          25,
            'chart.gutter.top':            25,
            'chart.gutter.bottom':         25,
            'chart.linewidth':             1,
            'chart.colors':                ['rgba(255,255,0,0.25)','rgba(0,255,255,0.25)','rgba(255,0,0,0.5)', 'red', 'green', 'blue', 'pink', 'aqua','brown','orange','grey'],
            'chart.colors.alpha':          null,
            'chart.circle':                0,
            'chart.circle.fill':           'red',
            'chart.circle.stroke':         'black',

            'chart.labels':                [],
            'chart.labels.color':          null,
            'chart.labels.offset':         10,
            'chart.labels.axes':            '',
            'chart.labels.background.fill': 'white',
            'chart.labels.boxed':           false,
            'chart.labels.axes.bold':       [],
            'chart.labels.axes.boxed':      null, // This defaults to true - but that's set in the Draw() method
            'chart.labels.axes.boxed.zero': true,
            'chart.labels.specific':        [],

            'chart.labels.count':           5,
            'chart.background.circles':    true,
            'chart.background.circles.count': null,
            'chart.background.circles.color': '#ddd',
            'chart.background.circles.poly':  true,
            'chart.background.circles.spokes': 24,
            'chart.text.size':             12,
            'chart.text.size.scale':       null,
            'chart.text.font':             'Arial',
            'chart.text.color':            'black',
            'chart.title':                 '',
            'chart.title.background':      null,
            'chart.title.hpos':            null,
            'chart.title.vpos':            null,
            'chart.title.color':           'black',
            'chart.title.bold':             true,
            'chart.title.font':             null,
            'chart.title.x':                null,
            'chart.title.y':                null,
            'chart.title.halign':           null,
            'chart.title.valign':           null,
            'chart.linewidth':             1,
            'chart.key':                   null,
            'chart.key.background':        'white',
            'chart.key.shadow':            false,
            'chart.key.shadow.color':       '#666',
            'chart.key.shadow.blur':        3,
            'chart.key.shadow.offsetx':     2,
            'chart.key.shadow.offsety':     2,
            'chart.key.position':          'graph',
            'chart.key.halign':             'right',
            'chart.key.position.gutter.boxed': false,
            'chart.key.position.x':         null,
            'chart.key.position.y':         null,
            'chart.key.color.shape':        'square',
            'chart.key.rounded':            true,
            'chart.key.linewidth':          1,
            'chart.key.colors':             null,
            'chart.key.interactive':        false,
            'chart.key.interactive.highlight.chart.stroke': 'rgba(255,0,0,0.3)',
            'chart.key.interactive.highlight.label': 'rgba(255,0,0,0.2)',
            'chart.key.text.color':        'black',
            'chart.contextmenu':           null,
            'chart.annotatable':           false,
            'chart.annotate.color':        'black',
            'chart.zoom.factor':           1.5,
            'chart.zoom.fade.in':          true,
            'chart.zoom.fade.out':         true,
            'chart.zoom.hdir':             'right',
            'chart.zoom.vdir':             'down',
            'chart.zoom.frames':            25,
            'chart.zoom.delay':             16.666,
            'chart.zoom.shadow':           true,
            'chart.zoom.background':        true,
            'chart.zoom.action':            'zoom',
            'chart.tooltips.effect':        'fade',
            'chart.tooltips.event':         'onmousemove',
            'chart.tooltips.css.class':     'RGraph_tooltip',
            'chart.tooltips.highlight':     true,
            'chart.highlight.stroke':       'gray',
            'chart.highlight.fill':         'rgba(255,255,255,0.7)',
            'chart.highlight.point.radius': 2,
            'chart.resizable':              false,
            'chart.resize.handle.adjust':   [0,0],
            'chart.resize.handle.background': null,
            'chart.ymax':                   null,
            'chart.accumulative':           false,
            'chart.radius':                 null,
            'chart.events.click':           null,
            'chart.events.mousemove':       null,
            'chart.scale.decimals':         0,
            'chart.scale.point':            '.',
            'chart.scale.thousand':         ',',
            'chart.units.pre':              '',
            'chart.units.post':             '',
            'chart.tooltips':             null,
            'chart.tooltips.event':       'onmousemove',
            'chart.centerx':              null,
            'chart.centery':              null,
            'chart.radius':               null,
            'chart.numxticks':            5,
            'chart.numyticks':            5,
            'chart.axes.color':           'rgba(0,0,0,0)',
            'chart.highlights':           false,
            'chart.highlights.stroke':    '#ddd',
            'chart.highlights.fill':      null,
            'chart.highlights.radius':    3,
            'chart.fill.click':           null,
            'chart.fill.mousemove':       null,
            'chart.fill.tooltips':        null,
            'chart.fill.highlight.fill':   'rgba(255,255,255,0.7)',
            'chart.fill.highlight.stroke': 'rgba(0,0,0,0)',
            'chart.fill.mousemove.redraw': false,
            'chart.animation.trace.clip': 1
        }



        // Must have at least 3 points
        for (var dataset=0; dataset<this.data.length; ++dataset) {
            if (this.data[dataset].length < 3) {
                alert('[RADAR] You must specify at least 3 data points');
                return;
            }
        }
        
        
        /**
        * Linearize the data and then create the $ objects
        */
        var idx = 0;
        for (var dataset=0; dataset<this.data.length; ++dataset) {
            for (var i=0,len=this.data[dataset].length; i<len; ++i) {
                this['$' + (idx++)] = {};
            }
        }



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
        * A simple setter
        * 
        * @param string name  The name of the property to set
        * @param string value The value of the property
        */
        this.set =
        this.Set = function (name, value)
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






            if (name == 'chart.text.diameter') {
                name = 'chart.text.size';
            }
    
            /**
            * If the name is chart.color, set chart.colors too
            */
            if (name == 'chart.color') {
                this.properties['chart.colors'] = [value];
            }





    
            prop[name] = value;
    
            return this;
        };





        /**
        * A simple getter
        * 
        * @param string name  The name of the property to get
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
    
            if (name == 'chart.text.diameter') {
                name = 'chart.text.size';
            }
    
            return prop[name];
        };




        /**
        * The draw method which does all the brunt of the work
        */
        this.draw =
        this.Draw = function ()
        {
            /**
            * Fire the onbeforedraw event
            */
            RG.FireCustomEvent(this, 'onbeforedraw');
            
            // NB: Colors are parsed further down
    
            // Reset the coords array to stop it growing
            this.coords     = [];
            this.coords2    = [];
            this.coordsText = [];
    
            /**
            * Reset the data to the original_data
            */
            this.data = RG.arrayClone(this.original_data);

            // Loop thru the data array if chart.accumulative is enable checking to see if all the
            // datasets have the same number of elements.
            if (prop['chart.accumulative']) {
                for (var i=0; i<this.data.length; ++i) {
                    if (this.data[i].length != this.data[0].length) {
                        alert('[RADAR] Error! When the radar has chart.accumulative set to true all the datasets must have the same number of elements');
                    }
                }
            }
    
    
            /**
            * This defaults to true, but needs to be an array with a size matching the number of
            * labels.
            */
            if (RG.isNull(prop['chart.labels.axes.boxed'])) {
                prop['chart.labels.axes.boxed'] = [];
                for (var i=0; i<(prop['chart.labels.specific'].length || prop['chart.labels.count'] || 5); ++i) {
                    prop['chart.labels.axes.boxed'][i] = false;
                }
            }




            /**
            * This is new in May 2011 and facilitates indiviual gutter settings,
            * eg chart.gutter.left
            */
            this.gutterLeft   = prop['chart.gutter.left'];
            this.gutterRight  = prop['chart.gutter.right'];
            this.gutterTop    = prop['chart.gutter.top'];
            this.gutterBottom = prop['chart.gutter.bottom'];
    
            this.centerx  = ((ca.width - this.gutterLeft - this.gutterRight) / 2) + this.gutterLeft;
            this.centery  = ((ca.height - this.gutterTop - this.gutterBottom) / 2) + this.gutterTop;
            this.radius   = Math.min(ca.width - this.gutterLeft - this.gutterRight, ca.height - this.gutterTop - this.gutterBottom) / 2;
    
    
    
            /**
            * Allow these to be set by hand
            */
            if (typeof prop['chart.centerx'] == 'number') this.centerx = 2 * prop['chart.centerx'];
            if (typeof prop['chart.centery'] == 'number') this.centery = 2 * prop['chart.centery'];
            if (typeof prop['chart.radius'] == 'number') this.radius   = prop['chart.radius'];
    
    
            /**
            * Parse the colors for gradients. Its down here so that the center X/Y can be used
            */
            if (!this.colorsParsed) {
    
                this.parseColors();
    
                // Don't want to do this again
                this.colorsParsed = true;
            }
    
    
    
            // Work out the maximum value and the sum
            if (!prop['chart.ymax']) {
    
                // this.max is calculated in the constructor
    
                // Work out this.max again if the chart is (now) set to be accumulative
                if (prop['chart.accumulative']) {
                    
                    var accumulation = [];
                    var len = this.original_data[0].length
    
                    for (var i=1; i<this.original_data.length; ++i) {
                        if (this.original_data[i].length != len) {
                            alert('[RADAR] Error! Stacked Radar chart datasets must all be the same size!');
                        }
                        
                        for (var j=0; j<this.original_data[i].length; ++j) {
                            this.data[i][j] += this.data[i - 1][j];
                            this.max = Math.max(this.max, this.data[i][j]);
                        }
                    }
                }
    
    
                this.scale2 = RG.getScale2(this, {'max':typeof(prop['chart.ymax']) == 'number' ? prop['chart.ymax'] : this.max,
                                                  'min':0,
                                                  'scale.decimals':Number(prop['chart.scale.decimals']),
                                                  'scale.point':prop['chart.scale.point'],
                                                  'scale.thousand':prop['chart.scale.thousand'],
                                                  'scale.round':prop['chart.scale.round'],
                                                  'units.pre':prop['chart.units.pre'],
                                                  'units.post':prop['chart.units.post'],
                                                  'ylabels.count':prop['chart.labels.count']
                                                 });
                this.max = this.scale2.max;
    
            } else {
                var ymax = prop['chart.ymax'];
    
                this.scale2 = RG.getScale2(this, {'max':ymax,
                                                  'min':0,
                                                  'strict':true,
                                                  'scale.decimals':Number(prop['chart.scale.decimals']),
                                                  'scale.point':prop['chart.scale.point'],
                                                  'scale.thousand':prop['chart.scale.thousand'],
                                                  'scale.round':prop['chart.scale.round'],
                                                  'units.pre':prop['chart.units.pre'],
                                                  'units.post':prop['chart.units.post'],
                                                  'ylabels.count':prop['chart.labels.count']
                                                 });
                this.max = this.scale2.max;
            }

            this.drawBackground();
            this.drawAxes();
            this.drawCircle();
            this.drawLabels();


            /**
            * Allow clipping
            */
            co.save();
                co.beginPath();
                    co.arc(this.centerx, this.centery, this.radius * 2, -RG.HALFPI, (RG.TWOPI * prop['chart.animation.trace.clip']) - RG.HALFPI, false);
                    co.lineTo(this.centerx, this.centery);
                co.closePath();
                co.clip();
    
                this.DrawChart();
                this.DrawHighlights();
            co.restore();
            
            //
            // Draw the axis labels
            //
            this.drawAxisLabels();
            
            // Draw the title
            if (prop['chart.title']) {
                RG.DrawTitle(this, prop['chart.title'], this.gutterTop, null, prop['chart.title.diameter'] ? prop['chart.title.diameter'] : null)
            }
    
            // Draw the key if necessary
            // obj, key, colors
            if (prop['chart.key']) {
                RG.DrawKey(this, prop['chart.key'], prop['chart.colors']);
            }
    
            /**
            * Show the context menu
            */
            if (prop['chart.contextmenu']) {
                RG.ShowContext(this);
            }
    
            
            /**
            * This function enables resizing
            */
            if (prop['chart.resizable']) {
                RG.AllowResizing(this);
            }
    
    
            /**
            * This installs the event listeners
            */
            RG.InstallEventListeners(this);

            /**
            * This installs the Radar chart specific area listener
            */
            if ( (prop['chart.fill.click'] || prop['chart.fill.mousemove'] || !RG.is_null(prop['chart.fill.tooltips'])) && !this.__fill_click_listeners_installed__) {
                this.AddFillListeners();
                this.__fill_click_listeners_installed__ = true;
            }



            /**
            * Fire the onfirstdraw event
            */
            if (this.firstDraw) {
                RG.fireCustomEvent(this, 'onfirstdraw');
                this.firstDraw = false;
                this.firstDrawFunc();
            }




            /**
            * Fire the RGraph ondraw event
            */
            RGraph.FireCustomEvent(this, 'ondraw');
            
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
        * Draws the background circles
        */
        this.drawBackground =
        this.DrawBackground = function ()
        {
            var color   = prop['chart.background.circles.color'];
            var poly    = prop['chart.background.circles.poly'];
            var spacing = prop['chart.background.circles.spacing'];
            var spokes  = prop['chart.background.circles.spokes'];
    
    
    
    
            // Set the linewidth for the grid (so that repeated redrawing works OK)
            co.lineWidth = 1;
    
    
    
    
            /**
            * Draws the background circles
            */
            if (prop['chart.background.circles'] && poly == false) {
    
    
    
    
    
                // Draw the concentric circles
                co.strokeStyle = color;
               co.beginPath();
                    
                    var numrings = typeof(prop['chart.background.circles.count']) == 'number' ? prop['chart.background.circles.count'] : prop['chart.labels.count'];

                    // TODO Currently set to 5 - needs changing
                   for (var r=0; r<=this.radius; r+=(this.radius / numrings)) {
                        co.moveTo(this.centerx, this.centery);
                        co.arc(this.centerx, this.centery,r, 0, RG.TWOPI, false);
                    }
                co.stroke();
    
    
    
    
        
                /**
                * Draw the diagonals/spokes
                */
                co.strokeStyle = color;
    
                for (var i=0; i<360; i+=(360 / spokes)) {
                    co.beginPath();
                        co.arc(this.centerx,
                               this.centery,
                               this.radius,
                               (i / 360) * RG.TWOPI,
                               ((i+0.001) / 360) * RG.TWOPI,
                               false); // The 0.01 avoids a bug in Chrome 6
                        co.lineTo(this.centerx, this.centery);
                    co.stroke();
                }
    
    
    
    
    
    
            /**
            * The background"circles" are actually drawn as a poly based on how many points there are
            * (ie hexagons if there are 6 points, squares if the are four etc)
            */
            } else if (prop['chart.background.circles'] && poly == true) {
    
                /**
                * Draw the diagonals/spokes
                */
                co.strokeStyle = color;
                var increment = 360 / this.data[0].length
    
                for (var i=0; i<360; i+=increment) {
                    co.beginPath();
                        co.arc(this.centerx,
                               this.centery,
                               this.radius,
                               ((i / 360) * RG.TWOPI) - RG.HALFPI,
                               (((i + 0.001) / 360) * RG.TWOPI) - RG.HALFPI,
                               false); // The 0.001 avoids a bug in Chrome 6
                        co.lineTo(this.centerx, this.centery);
                    co.stroke();
                }
    
    
                /**
                * Draw the lines that go around the Radar chart
                */
                co.strokeStyle = color;
                
                    var numrings = typeof(prop['chart.background.circles.count']) == 'number' ? prop['chart.background.circles.count'] : prop['chart.labels.count'];

                    for (var r=0; r<=this.radius; r+=(this.radius / numrings)) {
                        co.beginPath();
                            for (var a=0; a<=360; a+=(360 / this.data[0].length)) {
                                co.arc(this.centerx,
                                       this.centery,
                                       r,
                                       RG.degrees2Radians(a) - RG.HALFPI,
                                       RG.degrees2Radians(a) + 0.001 - RG.HALFPI,
                                       false);
                            }
                        co.closePath();
                        co.stroke();
                    }
            }
        };




        /**
        * Draws the axes
        */
        this.drawAxes =
        this.DrawAxes = function ()
        {
            co.strokeStyle = prop['chart.axes.color'];
    
            var halfsize = this.radius;
    
            co.beginPath();
                /**
                * The Y axis
                */
                co.moveTo(Math.round(this.centerx), this.centery + this.radius);
                co.lineTo(Math.round(this.centerx), this.centery - this.radius);
                
        
                // Draw the bits at either end of the Y axis
                co.moveTo(this.centerx - 5, Math.round(this.centery + this.radius));
                co.lineTo(this.centerx + 5, Math.round(this.centery + this.radius));
                co.moveTo(this.centerx - 5, Math.round(this.centery - this.radius));
                co.lineTo(this.centerx + 5, Math.round(this.centery - this.radius));
    
                // Draw Y axis tick marks
                for (var y=(this.centery - this.radius); y<(this.centery + this.radius); y+=(this.radius/prop['chart.numyticks'])) {
                    co.moveTo(this.centerx - 3, Math.round(y));
                    co.lineTo(this.centerx + 3, Math.round(y));
                }
        
                /**
                * The X axis
                */
                co.moveTo(this.centerx - this.radius, Math.round(this.centery));
                co.lineTo(this.centerx + this.radius, Math.round(this.centery));
        
                // Draw the bits at the end of the X axis
                co.moveTo(Math.round(this.centerx - this.radius), this.centery - 5);
                co.lineTo(Math.round(this.centerx - this.radius), this.centery + 5);
                co.moveTo(Math.round(this.centerx + this.radius), this.centery - 5);
                co.lineTo(Math.round(this.centerx + this.radius), this.centery + 5);
        
                // Draw X axis tick marks
                for (var x=(this.centerx - this.radius); x<(this.centerx + this.radius); x+=(this.radius/prop['chart.numxticks'])) {
                    co.moveTo(Math.round(x), this.centery - 3);
                    co.lineTo(Math.round(x), this.centery + 3);
                }
    
            // Stroke it
            co.stroke();
        };




        /**
        * The function which actually draws the radar chart
        */
        this.drawChart =
        this.DrawChart = function ()
        {
            var alpha = prop['chart.colors.alpha'];
    
            if (typeof(alpha) == 'number') {
                var oldAlpha = co.globalAlpha;
                co.globalAlpha = alpha;
            }

            var numDatasets = this.data.length;
    
            for (var dataset=0; dataset<this.data.length; ++dataset) {
    
                co.beginPath();
    
                    var coords_dataset = [];
        
                    for (var i=0; i<this.data[dataset].length; ++i) {
                        
                        var coords = this.GetCoordinates(dataset, i);
    
                        if (coords_dataset == null) {
                            coords_dataset = [];
                        }
    
                        coords_dataset.push(coords);
                        this.coords.push(coords);
                    }
                    
                    this.coords2[dataset] = coords_dataset;
                    
    
                    /**
                    * Now go through the coords and draw the chart itself
                    *
                    * 18/5/2012 - chart.strokestyle can now be an array of colors as well as a single color
                    */
    
                    co.strokeStyle = (typeof(prop['chart.strokestyle']) == 'object' && prop['chart.strokestyle'][dataset]) ? prop['chart.strokestyle'][dataset] : prop['chart.strokestyle'];
                    co.fillStyle   = prop['chart.colors'][dataset] ? prop['chart.colors'][dataset] : 'rgba(0,0,0,0)';
                    if (co.fillStyle === 'transparent') {
                        co.fillStyle = 'rgba(0,0,0,0)';
                    }
                    co.lineWidth   = prop['chart.linewidth'];
    
                    for (i=0; i<coords_dataset.length; ++i) {
                        if (i == 0) {
                            co.moveTo(coords_dataset[i][0], coords_dataset[i][1]);
                        } else {
                            co.lineTo(coords_dataset[i][0], coords_dataset[i][1]);
                        }
                    }
                    
    
                    // If on the second or greater dataset, backtrack
                    if (prop['chart.accumulative'] && dataset > 0) {
    
                        // This goes back to the start coords of this particular dataset
                        co.lineTo(coords_dataset[0][0], coords_dataset[0][1]);
                        
                        //Now move down to the end point of the previous dataset
                        co.moveTo(last_coords[0][0], last_coords[0][1]);
    
                        for (var i=coords_dataset.length - 1; i>=0; --i) {
                            co.lineTo(last_coords[i][0], last_coords[i][1]);
                        }
                    }
                
                // This is used by the next iteration of the loop
                var last_coords = coords_dataset;
    
                co.closePath();
        
                co.stroke();
                co.fill();
            }
            
            // Reset the globalAlpha
            if (typeof(alpha) == 'number') {
                co.globalAlpha = oldAlpha;
            }
        };




        /**
        * Gets the coordinates for a particular mark
        * 
        * @param  number i The index of the data (ie which one it is)
        * @return array    A two element array of the coordinates
        */
        this.getCoordinates =
        this.GetCoordinates = function (dataset, index)
        {
            // The number  of data points
            var len = this.data[dataset].length;
    
            // The magnitude of the data (NOT the x/y coords)
            var mag = (this.data[dataset][index] / this.max) * this.radius;
    
            /**
            * Get the angle
            */
            var angle = (RG.TWOPI / len) * index; // In radians
                angle -= RG.HALFPI;
    
    
            /**
            * Work out the X/Y coordinates
            */
            var x = Math.cos(angle) * mag;
            var y = Math.sin(angle) * mag;
    
            /**
            * Put the coordinate in the right quadrant
            */
            x = this.centerx + x;
            y = this.centery + y;
            
            return [x,y];
        };




        /**
        * This function adds the labels to the chart
        */
        this.drawLabels =
        this.DrawLabels = function ()
        {
            var labels = prop['chart.labels'];

            if (labels && labels.length > 0) {
    
                co.lineWidth = 1;
                co.strokeStyle = 'gray';
                co.fillStyle = prop['chart.labels.color'] || prop['chart.text.color'];
                
                var bgFill  = prop['chart.labels.background.fill'],
                    bold    = prop['chart.labels.bold'],
                    bgBoxed = prop['chart.labels.boxed'],
                    offset  = prop['chart.labels.offset'],
                    font    = prop['chart.text.font'],
                    size    = prop['chart.text.size'],
                    radius  = this.radius,
                    color   = prop['chart.labels.color'] || prop['chart.text.color']

                for (var i=0; i<labels.length; ++i) {
                    
                    var angle  = (RG.TWOPI / prop['chart.labels'].length) * i;
                        angle -= RG.HALFPI;
    
                    var x = this.centerx + (ma.cos(angle) * (radius + offset));
                    var y = this.centery + (ma.sin(angle) * (radius + offset));

                    /**
                    * Horizontal alignment
                    */
                    var halign = x < this.centerx ? 'right' : 'left' ;
                    if (i == 0 || (i / labels.length) == 0.5) halign = 'center';
    
                    if (labels[i] && labels[i].length) {

                        RG.text2(this, {
                            'color': color,
                            'font':font,
                            'size':size,
                            'x':x,
                            'y':y,
                            'text':labels[i],
                            'valign':'center',
                            'halign':halign,
                            'bounding':bgBoxed,
                            'boundingFill':bgFill,
                            'bold':bold,
                            'tag': 'labels'
                        });
                    }
                }
            }
        };




        /**
        * Draws the circle. No arguments as it gets the information from the object properties.
        */
        this.drawCircle =
        this.DrawCircle = function ()
        {
            var circle     = {};
            circle.limit   = prop['chart.circle'];
            circle.fill    = prop['chart.circle.fill'];
            circle.stroke  = prop['chart.circle.stroke'];
    
            if (circle.limit) {
    
                var r = (circle.limit / this.max) * this.radius;
                
                co.fillStyle = circle.fill;
                co.strokeStyle = circle.stroke;
    
                co.beginPath();
                co.arc(this.centerx, this.centery, r, 0, RG.TWOPI, 0);
                co.fill();
                co.stroke();
            }
        };




        /**
        * Unsuprisingly, draws the labels
        */
        this.drawAxisLabels =
        this.DrawAxisLabels = function ()
        {
            /**
            * Draw specific axis labels
            */
            if (RG.isArray(prop['chart.labels.specific']) && prop['chart.labels.specific'].length) {
                this.drawSpecificAxisLabels();
                return;
            }
    
            co.lineWidth = 1;
            
            // Set the color to black
            co.fillStyle   = 'black';
            co.strokeStyle = 'black';
    
            var r          = this.radius;
            var font       = prop['chart.text.font'];
            var size       = typeof(prop['chart.text.size.scale']) == 'number' ? prop['chart.text.size.scale'] : prop['chart.text.size'];
            var axes       = prop['chart.labels.axes'].toLowerCase();
            var color      = 'rgba(255,255,255,0.9)';
            var drawzero   = false;
            var units_pre  = prop['chart.units.pre'];
            var units_post = prop['chart.units.post'];
            var decimals   = prop['chart.scale.decimals'];
            var bold       = prop['chart.labels.axes.bold'];
            var boxed      = prop['chart.labels.axes.boxed'];
            var centerx    = this.centerx;
            var centery    = this.centery;
            var scale      = this.scale;

            co.fillStyle = prop['chart.text.color'];

            // The "North" axis labels
            if (axes.indexOf('n') > -1) {
                for (var i=0; i<this.scale2.labels.length; ++i) {
                    RG.Text2(this, {
                        'bold':bold[i],
                        'font':font,
                        'size':size,
                        'x':centerx,
                        'y':centery - (r * ((i+1)/this.scale2.labels.length)),
                        'text':this.scale2.labels[i],
                        'valign':'center',
                        'halign':'center',
                        'bounding':boxed[i] || color,
                        'boundingFill':color,
                        'boundingStroke':'rgba(0,0,0,0)',
                        'tag': 'scale'
                       });
                }
                
                drawzero = true;
            }
    
            // The "South" axis labels
            if (axes.indexOf('s') > -1) {
                for (var i=0; i<this.scale2.labels.length; ++i) {
                    RG.Text2(this, {
                        'bold':bold[i],
                        'font':font,
                        'size':size,
                        'x':centerx,
                        'y':centery + (r * ((i+1)/this.scale2.labels.length)),
                        'text':this.scale2.labels[i],
                        'valign':'center',
                        'halign':'center',
                        'bounding':boxed[i] || color,
                        'boundingFill':color,
                        'boundingStroke':'rgba(0,0,0,0)',
                        'tag': 'scale'
                       });
                }
                
                drawzero = true;
            }
            
            // The "East" axis labels
            if (axes.indexOf('e') > -1) {
                
                for (var i=0; i<this.scale2.labels.length; ++i) {
                    RG.Text2(this, {
                        'bold':bold[i],
                        'font':font,
                        'size':size,
                        'x':centerx + (r * ((i+1)/this.scale2.labels.length)),
                        'y':centery,
                        'text':this.scale2.labels[i],
                        'valign':'center',
                        'halign':'center',
                        'bounding':boxed[i]|| color,
                        'boundingFill':color,
                        'boundingStroke':'rgba(0,0,0,0)',
                        'tag': 'scale'
                       });
                }
    
                drawzero = true;
            }
    
            // The "West" axis labels
            if (axes.indexOf('w') > -1) {
    
                for (var i=0; i<this.scale2.labels.length; ++i) {
                    RG.Text2(this, {
                        'bold':bold[i],
                        'font':font,
                        'size':size,
                        'x':centerx - (r * ((i+1)/this.scale2.labels.length)),
                        'y':centery,
                        'text':this.scale2.labels[i],
                        'valign':'center',
                        'halign':'center',
                        'bounding':boxed[i]|| color,
                        'boundingFill':color,
                        'boundingStroke':'rgba(0,0,0,0)',
                        'tag': 'scale'
                    });
                }
    
                drawzero = true;
            }
    
            if (drawzero) {
                RG.Text2(this, {
                    'font':font,
                    'size':size,
                    'x':centerx,
                    'y':centery,
                    'text':RG.number_format(this, Number(0).toFixed(decimals), units_pre, units_post),
                    'valign':'center',
                    'halign':'center',
                    'bounding':prop['chart.labels.axes.boxed.zero'],
                    'boundingFill':color,
                    'boundingStroke':'rgba(0,0,0,0)',
                    'bold':prop['chart.labels.axes.bold.zero'],
                    'tag': 'scale'
                });
            }
        };




        /**
        * Draws specific axis labels
        */
        this.drawSpecificAxisLabels =
        this.DrawSpecificAxisLabels = function ()
        {
            /**
            * Specific axis labels
            */
            var labels          = prop['chart.labels.specific'];
            var bold            = RG.array_pad(prop['chart.labels.axes.bold'],labels.length);
            var boxed           = RG.array_pad(prop['chart.labels.axes.boxed'],labels.length);
            var reversed_labels = RG.array_reverse(labels);
            var reversed_bold   = RG.array_reverse(bold);
            var reversed_boxed  = RG.array_reverse(boxed);
            var font            = prop['chart.text.font'];
            var size            = typeof(prop['chart.text.size.scale']) == 'number' ? prop['chart.text.size.scale'] : prop['chart.text.size'];
            var axes            = prop['chart.labels.axes'].toLowerCase();
            
            co.fillStyle = prop['chart.text.color'];

            for (var i=0; i<labels.length; ++i) {
    
                if (axes.indexOf('n') > -1) RG.Text2(this, {'tag': 'labels.specific', 'bold':reversed_bold[i],'font':font,'size':size,'x':this.centerx,'y':this.centery - this.radius + ((this.radius / labels.length) * i),'text':reversed_labels[i],'valign':'center','halign':'center','bounding':reversed_boxed[i],'boundingFill':'white'});
                if (axes.indexOf('s') > -1) RG.Text2(this, {'tag': 'labels.specific', 'bold':bold[i],'font':font,'size':size,'x':this.centerx,'y':this.centery + ((this.radius / labels.length) * (i+1)),'text':labels[i],'valign':'center','halign':'center','bounding':boxed[i],'boundingFill':'white'});
                
                if (axes.indexOf('w') > -1) RG.Text2(this, {'tag': 'labels.specific', 'bold':reversed_bold[i],'font':font,'size':size,'x':this.centerx - this.radius + ((this.radius / labels.length) * i),'y':this.centery,'text':reversed_labels[i],'valign':'center','halign':'center','bounding':reversed_boxed[i],'boundingFill':'white'});
                if (axes.indexOf('e') > -1) RG.Text2(this, {'tag': 'labels.specific', 'bold':bold[i],'font':font,'size':size,'x':this.centerx + ((this.radius / labels.length) * (i+1)),'y':this.centery,'text':labels[i],'valign':'center','halign':'center','bounding':boxed[i],'boundingFill':'white'});
            }
        };




        /**
        * This method eases getting the focussed point (if any)
        * 
        * @param event e The event object
        */
        this.getShape =
        this.getPoint = function (e)
        {
            for (var i=0; i<this.coords.length; ++i) {
    
                var x        = this.coords[i][0];
                var y        = this.coords[i][1];
                var tooltips = prop['chart.tooltips'];
                var index    = Number(i);
                var mouseXY  = RG.getMouseXY(e);
                var mouseX   = mouseXY[0];
                var mouseY   = mouseXY[1];
    
                if (   mouseX < (x + 5)
                    && mouseX > (x - 5)
                    && mouseY > (y - 5)
                    && mouseY < (y + 5)
                   ) {
                    
                    var tooltip = RG.parseTooltipText(prop['chart.tooltips'], index);
    
                    return {0: this,    'object':  this,
                            1: x,       'x':       x,
                            2: y,       'y':       y,
                            3: null, 'dataset': null,
                            4: index,       'index':   i,
                                        'tooltip': tooltip
                           }
                }
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
            // Add the new highlight
            RG.Highlight.Point(this, shape);
        };




        /**
        * The getObjectByXY() worker method. Don't call this call:
        * 
        * RGraph.ObjectRegistry.getObjectByXY(e)
        * 
        * @param object e The event object
        */
        this.getObjectByXY = function (e)
        {
            var mouseXY = RG.getMouseXY(e);
    
            if (
                   mouseXY[0] > (this.centerx - this.radius)
                && mouseXY[0] < (this.centerx + this.radius)
                && mouseXY[1] > (this.centery - this.radius)
                && mouseXY[1] < (this.centery + this.radius)
                ) {
    
                return this;
            }
        };




        /**
        * This function positions a tooltip when it is displayed
        * 
        * @param obj object    The chart object
        * @param int x         The X coordinate specified for the tooltip
        * @param int y         The Y coordinate specified for the tooltip
        * @param objec tooltip The tooltips DIV element
        */
        this.positionTooltip = function (obj, x, y, tooltip, idx)
        {
            var dataset    = tooltip.__dataset__;
            var index      = tooltip.__index__;
            var coordX     = this.coords[index][0];
            var coordY     = this.coords[index][1];
            var canvasXY   = RG.getCanvasXY(obj.canvas);
            var gutterLeft = this.gutterLeft;
            var gutterTop  = this.gutterTop;
            var width      = tooltip.offsetWidth;
    
            // Set the top position
            tooltip.style.left = 0;
            tooltip.style.top  = parseInt(tooltip.style.top) - 9 + 'px';
            
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
            if ((canvasXY[0] + coordX - (width / 2)) < 10) {
                tooltip.style.left = (canvasXY[0] + coordX - (width * 0.1)) + 'px';
                img.style.left = ((width * 0.1) - 8.5) + 'px';
    
            // RIGHT edge
            } else if ((canvasXY[0] + coordX + (width / 2)) > doc.body.offsetWidth) {
                tooltip.style.left = canvasXY[0] + coordX - (width * 0.9) + 'px';
                img.style.left = ((width * 0.9) - 8.5) + 'px';
    
            // Default positioning - CENTERED
            } else {
                tooltip.style.left = (canvasXY[0] + coordX - (width * 0.5)) + 'px';
                img.style.left = ((width * 0.5) - 8.5) + 'px';
            }
        };




        /**
        * This draws highlights on the points
        */
        this.drawHighlights =
        this.DrawHighlights = function ()
        {
            if (prop['chart.highlights']) {
                
                var sequentialIdx = 0;
                var dataset       = 0;
                var index         = 0;
                var radius        = prop['chart.highlights.radius'];
                
    
                
                for (var dataset=0; dataset <this.data.length; ++dataset) {
                    for (var index=0; index<this.data[dataset].length; ++index) {
                        co.beginPath();
                            co.strokeStyle = prop['chart.highlights.stroke'];
                            co.fillStyle = prop['chart.highlights.fill'] ? prop['chart.highlights.fill'] : ((typeof(prop['chart.strokestyle']) == 'object' && prop['chart.strokestyle'][dataset]) ? prop['chart.strokestyle'][dataset] : prop['chart.strokestyle']);
                            co.arc(this.coords[sequentialIdx][0], this.coords[sequentialIdx][1], radius, 0, RG.TWOPI, false);
                        co.stroke();
                        co.fill();
                        ++sequentialIdx;
                    }
                }
                
            }
        };




        /**
        * This function returns the radius (ie the distance from the center) for a particular
        * value. Note that if you want the angle for a point you can use getAngle(index)
        * 
        * @param number value The value you want the radius for
        */
        this.getRadius = function (value)
        {
            if (value < 0 || value > this.max) {
                return null;
            }
    
            // Radar doesn't support minimum value
            var radius = (value / this.max) * this.radius;
            
            return radius;
        };




        /**
        * This function returns the angle (in radians) for a particular index.
        * 
        * @param number numitems The total number of items
        * @param number index    The zero index number of the item to get the angle for
        */
        this.getAngle = function (numitems, index)
        {
            var angle = (RG.TWOPI / numitems) * index;
                angle -= RG.HALFPI;
            
            return angle;
        };




        /**
        * This allows for easy specification of gradients
        */
        this.parseColors = function ()
        {
            // Save the original colors so that they can be restored when the canvas is reset
            if (this.original_colors.length === 0) {
                this.original_colors['chart.colors']           = RG.array_clone(prop['chart.colors']);
                this.original_colors['chart.key.colors']       = RG.array_clone(prop['chart.key.colors']);
                this.original_colors['chart.title.color']      = RG.array_clone(prop['chart.title.color']);
                this.original_colors['chart.text.color']       = RG.array_clone(prop['chart.text.color']);
                this.original_colors['chart.highlight.stroke'] = RG.array_clone(prop['chart.highlight.stroke']);
                this.original_colors['chart.highlight.fill']   = RG.array_clone(prop['chart.highlight.fill']);
                this.original_colors['chart.circle.fill']      = RG.array_clone(prop['chart.circle.fill']);
                this.original_colors['chart.circle.stroke']    = RG.array_clone(prop['chart.circle.stroke']);
            }

            for (var i=0; i<prop['chart.colors'].length; ++i) {
                prop['chart.colors'][i] = this.parseSingleColorForGradient(prop['chart.colors'][i]);
            }
            
            var keyColors = prop['chart.key.colors'];
    
            if (typeof(keyColors) != 'null' && keyColors && keyColors.length) {
                for (var i=0; i<prop['chart.key.colors'].length; ++i) {
                    prop['chart.key.colors'][i] = this.parseSingleColorForGradient(prop['chart.key.colors'][i]);
                }
            }
    
            prop['chart.title.color']      = this.parseSingleColorForGradient(prop['chart.title.color']);
            prop['chart.text.color']       = this.parseSingleColorForGradient(prop['chart.text.color']);
            prop['chart.highlight.stroke'] = this.parseSingleColorForGradient(prop['chart.highlight.stroke']);
            prop['chart.highlight.fill']   = this.parseSingleColorForGradient(prop['chart.highlight.fill']);
            prop['chart.circle.fill']      = this.parseSingleColorForGradient(prop['chart.circle.fill']);
            prop['chart.circle.stroke']    = this.parseSingleColorForGradient(prop['chart.circle.stroke']);
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
            if (!color || typeof(color) != 'string') {
                return color;
            }
    
            if (color.match(/^gradient\((.*)\)$/i)) {
    
                var parts = RegExp.$1.split(':');
    
                // Create the gradient
                var grad = co.createRadialGradient(this.centerx, this.centery, 0, this.centerx, this.centery, this.radius);
    
                var diff = 1 / (parts.length - 1);
    
                grad.addColorStop(0, RG.trim(parts[0]));
    
                for (var j=1; j<parts.length; ++j) {
                    grad.addColorStop(j * diff, RG.trim(parts[j]));
                }
            }
    
            return grad ? grad : color;
        };




        this.addFillListeners =
        this.AddFillListeners = function (e)
        {
            var obj = this;

            var func = function (e)
            {
                //var canvas  = e.target;
                //var context = canvas.getContext('2d');
                var coords  = this.coords;
                var coords2 = this.coords2;
                var mouseXY = RG.getMouseXY(e);
                var dataset = 0;
                
                if (e.type == 'mousemove' && prop['chart.fill.mousemove.redraw']) {
                    RG.RedrawCanvas(ca);
                }

                for (var dataset=(obj.coords2.length-1); dataset>=0; --dataset) {
                    
                    // Draw the path again so that it can be checked
                    co.beginPath();
                        co.moveTo(obj.coords2[dataset][0][0], obj.coords2[dataset][0][1]);
                        for (var j=0; j<obj.coords2[dataset].length; ++j) {
                            co.lineTo(obj.coords2[dataset][j][0], obj.coords2[dataset][j][1]);
                        }
                        
                    // Draw a line back to the starting point
                    co.lineTo(obj.coords2[dataset][0][0], obj.coords2[dataset][0][1]);
        
                    // Go thru the previous datasets coords in reverse order
                    if (prop['chart.accumulative'] && dataset > 0) {
                        co.lineTo(obj.coords2[dataset - 1][0][0], obj.coords2[dataset - 1][0][1]);
                        for (var j=(obj.coords2[dataset - 1].length - 1); j>=0; --j) {
                            co.lineTo(obj.coords2[dataset - 1][j][0], obj.coords2[dataset - 1][j][1]);
                        }
                    }
    
                    co.closePath();
                    
                    if (co.isPointInPath(mouseXY[0], mouseXY[1])) {
                        var inPath = true;
                        break;
                    }
                }
                
                // Call the events
                if (inPath) {
    
                    var fillTooltips = prop['chart.fill.tooltips'];
    
                    /**
                    * Click event
                    */
                    if (e.type == 'click') {
                        if (prop['chart.fill.click']) {
                            prop['chart.fill.click'](e, dataset);
                        }
                    
                        if (prop['chart.fill.tooltips'] && prop['chart.fill.tooltips'][dataset]) {
                            obj.DatasetTooltip(e, dataset);
                        }
                    }

    
    
                    /**
                    * Mousemove event
                    */
                    if (e.type == 'mousemove') {
    
                        if (prop['chart.fill.mousemove']) {
                            prop['chart.fill.mousemove'](e, dataset);
                        }
                        
                        if (!RG.is_null(fillTooltips)) {
                            e.target.style.cursor = 'pointer';
                        }
                    
                        if (prop['chart.fill.tooltips'] && prop['chart.fill.tooltips'][dataset]) {
                            e.target.style.cursor = 'pointer';
                        }
                    }
    
                    e.stopPropagation();
                
                } else if (e.type == 'mousemove') {
                    ca.style.cursor = 'default';
                }
            };
            
            /**
            * Add the click listener
            */
            if (prop['chart.fill.click'] || !RG.is_null(prop['chart.fill.tooltips'])) {
                ca.addEventListener('click', func, false);
            }
    
            /**
            * Add the mousemove listener
            */
            if (prop['chart.fill.mousemove'] || !RG.is_null(prop['chart.fill.tooltips'])) {
                ca.addEventListener('mousemove', func, false);
            }
        };




        /**
        * This highlights a specific dataset on the chart
        * 
        * @param number dataset The index of the dataset (which starts at zero)
        */
        this.highlightDataset =
        this.HighlightDataset = function (dataset)
        {
            co.beginPath();
            for (var j=0; j<this.coords2[dataset].length; ++j) {
                if (j == 0) {
                    co.moveTo(this.coords2[dataset][0][0], this.coords2[dataset][0][1]);
                } else {
                    co.lineTo(this.coords2[dataset][j][0], this.coords2[dataset][j][1]);
                }
            }
    
            co.lineTo(this.coords2[dataset][0][0], this.coords2[dataset][0][1]);
            
            if (prop['chart.accumulative'] && dataset > 0) {
                co.lineTo(this.coords2[dataset - 1][0][0], this.coords2[dataset - 1][0][1]);
                for (var j=(this.coords2[dataset - 1].length - 1); j>=0; --j) {
                    co.lineTo(this.coords2[dataset - 1][j][0], this.coords2[dataset - 1][j][1]);
                }
            }
    
            co.strokeStyle = prop['chart.fill.highlight.stroke'];
            co.fillStyle   = prop['chart.fill.highlight.fill'];
    
            co.stroke();
            co.fill();
        };




        /**
        * Shows a tooltip for a dataset (a "fill" tooltip), You can pecify these
        * with chart.fill.tooltips
        */
        this.datasetTooltip =
        this.DatasetTooltip = function (e, dataset)
        {
            // Highlight the dataset
            this.HighlightDataset(dataset);
            
            // Use the First datapoints coords for the Y position of the tooltip NOTE The X position is changed in the
            // obj.positionTooltip() method so set the index to be the first one
            var text = prop['chart.fill.tooltips'][dataset];
            var x    = 0;
            var y    = this.coords2[dataset][0][1] + RG.getCanvasXY(ca)[1];
    
    
            // Show a tooltip
            RG.Tooltip(this, text, x, y, 0, e);
        };




        /**
        * This function handles highlighting an entire data-series for the interactive
        * key
        * 
        * @param int index The index of the data series to be highlighted
        */
        this.interactiveKeyHighlight = function (index)
        {
            var coords = this.coords2[index];

            if (coords) {
                
                var pre_linewidth = co.lineWidth;
                var pre_linecap   = co.lineCap;
                
                
                
                
                // ------------------------------------------ //

                co.lineWidth   = prop['chart.linewidth'] + 10;
                co.lineCap     = 'round';
                co.strokeStyle = prop['chart.key.interactive.highlight.chart.stroke'];

                
                co.beginPath();
                for (var i=0,len=coords.length; i<len; i+=1) {
                    if (i == 0) {
                        co.moveTo(coords[i][0], coords[i][1]);
                    } else {
                        co.lineTo(coords[i][0], coords[i][1]);
                    }
                }
                co.closePath();
                co.stroke();
                
                // ------------------------------------------ //
                
                
                
                
                // Reset the lineCap and lineWidth
                co.lineWidth = pre_linewidth;
                co.lineCap = pre_linecap;
            }
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
        * Radar chart grow
        * 
        * This effect gradually increases the magnitude of the points on the radar chart
        * 
        * @param object     Options for the effect
        * @param function   An optional callback that is run when the effect is finished
        */
        this.grow = function ()
        {
            var obj           = this;
            var callback      = arguments[1] ? arguments[1] : function () {};
            var opt           = arguments[0] ? arguments[0] : {};
            var frames        = opt.frames ? opt.frames : 30;
            var frame         = 0;
            var data          = RG.array_clone(obj.data);

            function iterator ()
            {
                for (var i=0,len=data.length; i<len; ++i) {

                    //if (obj.original_data[i] == null) {
                    //    obj.original_data[i] = [];
                    //}
    
                    for (var j=0,len2=data[i].length; j<len2; ++j) {
                        obj.original_data[i][j] = (frame / frames)  * data[i][j];
                    }
                }
    
                RGraph.clear(obj.canvas);
                RGraph.redrawCanvas(obj.canvas);
    
                if (frame < frames) {
                    frame++;
                    RGraph.Effects.updateCanvas(iterator);
                } else {
                    callback(obj);
                }
            }
            
            iterator();
            
            return this;
        };




        /**
        * Trace (Radar chart)
        * 
        * This is a Trace effect for the Radar chart
        * 
        * @param object     Options for the effect. Currently only "frames" is available.
        * @param function   A function that is called when the ffect is complete
        */
        this.trace = function ()
        {
            var obj       = this;
            var opt       = arguments[0] || {};
            var frames    = opt.frames || 60;
            var frame     = 0;
            var callback  = arguments[1] || function () {};
    
            obj.Set('animation.trace.clip', 0);


            var iterator = function ()
            {
                if (frame < frames) {
        
                    obj.Set('animation.trace.clip', frame / frames);
        
                    frame++;
                    RG.redrawCanvas(obj.canvas);
                    RG.Effects.updateCanvas(iterator);

                } else {

                    obj.Set('animation.trace.clip', 1);
                    RG.redrawCanvas(obj.canvas);
                    callback(obj);
                }
            };
            
            iterator();
            
            return this;
        };
        
        
        
        
        RG.att(ca);




        /**
        * Always register the object
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