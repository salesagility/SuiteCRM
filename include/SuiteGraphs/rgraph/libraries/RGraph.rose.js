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

    RGraph              = window.RGraph || {isRGraph: true};
    RGraph.Effects      = RGraph.Effects || {};
    RGraph.Effects.Rose = RGraph.Effects.Rose || {};

    /**
    * The rose chart constuctor
    * 
    * @param object canvas
    * @param array data
    */
    RGraph.Rose = function (conf)
    {
        /**
        * Allow for object config style
        */
        if (   typeof conf === 'object'
            && typeof conf.data === 'object'
            && typeof conf.id === 'string') {

            var parseConfObjectForOptions = true; // Set this so the config is parsed (at the end of the constructor)
        
        } else {
        
            var conf      = {id: conf};
                conf.data = arguments[1];
        }




        this.id                = conf.id;
        this.canvas            = document.getElementById(this.id);
        this.context           = this.canvas.getContext ? this.canvas.getContext("2d") : null;
        this.data              = conf.data;
        this.canvas.__object__ = this;
        this.type              = 'rose';
        this.isRGraph          = true;
        this.uid               = RGraph.CreateUID();
        this.canvas.uid        = this.canvas.uid ? this.canvas.uid : RGraph.CreateUID();
        this.colorsParsed      = false;
        this.coordsText        = [];
        this.original_colors   = [];
        this.firstDraw         = true; // After the first draw this will be false

        this.centerx = 0;
        this.centery = 0;
        this.radius  = 0;
        this.max     = 0;
        this.angles  = [];
        this.angles2 = [];
        
        this.properties =
        {
            'chart.background.axes':        true,
            'chart.background.axes.color':  'black',
            'chart.background.grid':        true,
            'chart.background.grid.color':  '#ccc',
            'chart.background.grid.size':   null,
            'chart.background.grid.radials':null,
            'chart.background.grid.count':  5,
            'chart.centerx':                null,
            'chart.centery':                null,
            'chart.radius':                 null,
            'chart.angles.start':           0,
            'chart.colors':                 ['rgba(255,0,0,0.5)', 'rgba(255,255,0,0.5)', 'rgba(0,255,255,0.5)', 'rgb(0,255,0)', 'gray', 'blue', 'rgb(255,128,255)','green', 'pink', 'gray', 'aqua'],
            'chart.linewidth':              1,
            'chart.colors.sequential':      false,
            'chart.colors.alpha':           null,
            'chart.margin':                 0,
            'chart.strokestyle':            '#aaa',
            'chart.gutter.left':            25,
            'chart.gutter.right':           25,
            'chart.gutter.top':             25,
            'chart.gutter.bottom':          25,
            'chart.title':                  '',
            'chart.title.background':       null,
            'chart.title.hpos':             null,
            'chart.title.vpos':             null,
            'chart.title.bold':             true,
            'chart.title.font':             null,
            'chart.title.x':                null,
            'chart.title.y':                null,
            'chart.title.halign':           null,
            'chart.title.valign':           null,
            'chart.labels':                 null,
            'chart.labels.color':           null,
            'chart.labels.position':       'center',
            'chart.labels.axes':            'nsew',
            'chart.labels.boxed':           false,
            'chart.labels.offset':          0,
            'chart.text.color':             'black',
            'chart.text.font':              'Arial',
            'chart.text.size':              12,
            'chart.key':                    null,
            'chart.key.background':         'white',
            'chart.key.position':           'graph',
            'chart.key.halign':             'right',
            'chart.key.shadow':             false,
            'chart.key.shadow.color':       '#666',
            'chart.key.shadow.blur':        3,
            'chart.key.shadow.offsetx':     2,
            'chart.key.shadow.offsety':     2,
            'chart.key.position.gutter.boxed': false,
            'chart.key.position.x':         null,
            'chart.key.position.y':         null,
            'chart.key.color.shape':        'square',
            'chart.key.rounded':            true,
            'chart.key.linewidth':          1,
            'chart.key.colors':             null,
            'chart.key.interactive':        false,
            'chart.key.interactive.highlight.chart.stroke': 'black',
            'chart.key.interactive.highlight.chart.fill': 'rgba(255,255,255,0.7)',
            'chart.key.interactive.highlight.label': 'rgba(255,0,0,0.2)',
            'chart.key.text.color':         'black',
            'chart.contextmenu':            null,
            'chart.tooltips':               null,
            'chart.tooltips.event':         'onclick',
            'chart.tooltips.effect':        'fade',
            'chart.tooltips.css.class':     'RGraph_tooltip',
            'chart.tooltips.highlight':     true,
            'chart.highlight.stroke':       'rgba(0,0,0,0)',
            'chart.highlight.fill':         'rgba(255,255,255,0.7)',
            'chart.annotatable':            false,
            'chart.annotate.color':         'black',
            'chart.zoom.factor':            1.5,
            'chart.zoom.fade.in':           true,
            'chart.zoom.fade.out':          true,
            'chart.zoom.hdir':              'right',
            'chart.zoom.vdir':              'down',
            'chart.zoom.frames':            25,
            'chart.zoom.delay':             16.666,
            'chart.zoom.shadow':            true,
            'chart.zoom.background':        true,
            'chart.zoom.action':            'zoom',
            'chart.resizable':              false,
            'chart.resize.handle.adjust':   [0,0],
            'chart.resize.handle.background': null,
            'chart.adjustable':             false,
            'chart.ymax':                   null,
            'chart.ymin':                   0,
            'chart.scale.decimals':         null,
            'chart.scale.point':            '.',
            'chart.scale.thousand':         ',',
            'chart.variant':                'stacked',
            'chart.variant.threed.depth':   10,
            'chart.exploded':               0,
            'chart.events.mousemove':       null,
            'chart.events.click':           null,
            'chart.animation.roundrobin.factor':  1,
            'chart.animation.roundrobin.radius': true,
            'chart.animation.grow.multiplier': 1,
            'chart.labels.count':              5,
            'chart.segment.highlight':         false,
            'chart.segment.highlight.count':   null,
            'chart.segment.highlight.fill':    'rgba(0,255,0,0.5)',
            'chart.segment.highlight.stroke':  'rgba(0,0,0,0)'
        }



        /**
        * Create the $ objects. In the case of non-equi-angular rose charts it actually creates too many $ objects,
        * but it doesn't matter.
        */
        var linear_data = RGraph.arrayLinearize(this.data);
        for (var i=0; i<linear_data.length; ++i) {
            this["$" + i] = {}
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





    
            
            
            
            // A little BC...
            if (name === 'chart.background.grid.spokes') name = 'chart.background.grid.radials';


            
            //
            // Change chart.segments.highlight* to chart.segment.highlight (no plural)
            //
            if (name === 'chart.segments.highlight')         name = 'chart.segment.highlight';
            if (name === 'chart.segments.highlight.fill')    name = 'chart.segment.highlight.fill';
            if (name === 'chart.segments.highlight.stroke')  name = 'chart.segment.highlight.stroke';

            prop[name.toLowerCase()] = value;


            return this;
        };




        /**
        * A simple getter
        * 
        * @param string name The name of the property to get
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
        * This method draws the rose chart
        */
        this.draw =
        this.Draw = function ()
        {

            /**
            * Fire the onbeforedraw event
            */
            RG.fireCustomEvent(this, 'onbeforedraw');
    
    
    
            /**
            * This doesn't affect the chart, but is used for compatibility
            */
            this.gutterLeft   = prop['chart.gutter.left'];
            this.gutterRight  = prop['chart.gutter.right'];
            this.gutterTop    = prop['chart.gutter.top'];
            this.gutterBottom = prop['chart.gutter.bottom'];
    
            // Calculate the radius
            this.radius       = (ma.min(ca.width - this.gutterLeft - this.gutterRight, ca.height - this.gutterTop - this.gutterBottom) / 2);
            this.centerx      = ((ca.width - this.gutterLeft - this.gutterRight) / 2) + this.gutterLeft;
            this.centery      = ((ca.height - this.gutterTop - this.gutterBottom) / 2) + this.gutterTop;
            this.angles       = [];
            this.angles2      = [];
            this.total        = 0;
            this.startRadians = prop['chart.angles.start'];
            this.coordsText   = [];
            
            /**
            * Change the centerx marginally if the key is defined
            */
            if (prop['chart.key'] && prop['chart.key'].length > 0 && prop['chart.key'].length >= 3) {
                this.centerx = this.centerx - this.gutterRight + 5;
            }
    
    
    
            // User specified radius, centerx and centery
            if (typeof prop['chart.centerx'] == 'number') this.centerx = prop['chart.centerx'];
            if (typeof prop['chart.centery'] == 'number') this.centery = prop['chart.centery'];
            if (typeof prop['chart.radius']  == 'number')  this.radius  = prop['chart.radius'];
    
            /**
            * Parse the colors for gradients. Its down here so that the center X/Y can be used
            */
            if (!this.colorsParsed) {
    
                this.parseColors();
    
                // Don't want to do this again
                this.colorsParsed = true;
            }



        // 3D variant
        if (prop['chart.variant'].indexOf('3d') !== -1) {

            var scaleX = 1.5;

            this.context.setTransform(
                scaleX,
                0,
                0,
                1,
                (ca.width * scaleX - ca.width) * -0.5,
                0
            );
        }





            this.drawBackground();





            // If a 3D variant draw the depth
            if (prop['chart.variant'].indexOf('3d') !== -1) {
            
                RG.setShadow(this,'rgba(0,0,0,0.35)',0,15,25);
            
                for (var i=prop['chart.variant.threed.depth']; i>0; i-=1) {

                    this.centery -= 1;
                    this.drawRose({storeAngles: false});
            
                    RG.setShadow(this,'rgba(0,0,0,0)',0,0,0);
            

                    // Make the segments darker
                    for (var j=0,len=this.angles.length; j<len; j+=1) {

                        var a = this.angles[j];

                        pa(co, [
                            'b',
                            'm', a[4], a[5],
                            'a', a[4], a[5], a[3] + 1.5, a[0] - 0.01, a[1] + 0.01, false,
                            'c',
                            'f', 'rgba(0,0,0,0.1)'
                        ]);
                    }
                }
            }

            this.drawRose();
            this.drawLabels();

            /**
            * Set the strokestyle to transparent because of a strange double stroke bug
            * 
            * DO NOT REMOVE
            */
            co.strokeStyle = 'rgba(0,0,0,0)'


            /**
            * Setup the context menu if required
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
            * This function enables adjusting
            */
            if (prop['chart.adjustable']) {
                RG.AllowAdjusting(this);
            }
    
    
            /**
            * This installs the event listeners
            */
            RG.InstallEventListeners(this);





            //
            // Allow the segments to be highlighted
            //
            if (prop['chart.segment.highlight']) {
                
                // Check to see if the dynamic library has been included
                if (!RG.allowSegmentHighlight) {
                    alert('[WARNING] The segment highlight function does not exist - have you included the dynamic library?');
                }

                RG.allowSegmentHighlight({
                    object: this,
                    count:  typeof prop['chart.segment.highlight.count'] === 'number' ? prop['chart.segment.highlight.count'] : this.data.length,
                    fill:   prop['chart.segment.highlight.fill'],
                    stroke: prop['chart.segment.highlight.stroke']
                });
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
            RG.FireCustomEvent(this, 'ondraw');
            
            return this;
        };




        /**
        * This method draws the rose charts background
        */
        this.drawBackground =
        this.DrawBackground = function ()
        {
            co.lineWidth = 1;
    
    
            // Draw the background grey circles/spokes
            if (prop['chart.background.grid']) {
                if (typeof(prop['chart.background.grid.count']) == 'number') {
                    prop['chart.background.grid.size'] = this.radius / prop['chart.background.grid.count'];
                }
        
                co.beginPath();
                    co.strokeStyle = prop['chart.background.grid.color'];
                    
                    // Radius must be greater than 0 for Opera to work
                    for (var i=prop['chart.background.grid.size']; i<=this.radius; i+=prop['chart.background.grid.size']) {
                        
                        // Hmmm... This is questionable
                        co.moveTo(this.centerx + i, this.centery);
            
                        // Radius must be greater than 0 for Opera to work
                        co.arc(this.centerx,
                               this.centery,
                               i,
                               0,
                               RG.TWOPI,
                               false);
                    }
                co.stroke();
    
    
    
    
    
    
                // Draw the background lines that go from the center outwards
                co.beginPath();
                if (typeof prop['chart.background.grid.radials'] !== 'number') {
                    prop['chart.background.grid.radials'] = this.data.length
                }

                var num = (360 / prop['chart.background.grid.radials']);

                for (var i=num; i<=360; i+=num) {
                
                    // Radius must be greater than 0 for Opera to work
                    co.arc(this.centerx,
                           this.centery,
                           this.radius,
                           ((i / (180 / RG.PI)) - RG.HALFPI) + this.startRadians,
                           (((i + 0.0001) / (180 / RG.PI)) - RG.HALFPI) + this.startRadians,
                           false);

                    co.lineTo(this.centerx, this.centery);
                }
                co.stroke();
            }
    
    
    
            if (prop['chart.background.axes']) {
                co.beginPath();
                co.strokeStyle = prop['chart.background.axes.color'];

                // Draw the X axis
                co.moveTo(this.centerx - this.radius, Math.round(this.centery) );
                co.lineTo(this.centerx + this.radius, Math.round(this.centery) );
            
                // Draw the X ends
                co.moveTo(Math.round(this.centerx - this.radius), this.centery - 5);
                co.lineTo(Math.round(this.centerx - this.radius), this.centery + 5);
                co.moveTo(Math.round(this.centerx + this.radius), this.centery - 5);
                co.lineTo(Math.round(this.centerx + this.radius), this.centery + 5);
                
                // Draw the X check marks
                for (var i=(this.centerx - this.radius); i<(this.centerx + this.radius); i+=(this.radius / 5)) {
                    co.moveTo(Math.round(i),  this.centery - 3);
                    co.lineTo(Math.round(i),  this.centery + 3.5);
                }
                
                // Draw the Y check marks
                for (var i=(this.centery - this.radius); i<(this.centery + this.radius); i+=(this.radius / 5)) {
                    co.moveTo(this.centerx - 3, Math.round(i));
                    co.lineTo(this.centerx + 3, Math.round(i));
                }
            
                // Draw the Y axis
                co.moveTo(ma.round(this.centerx), this.centery - this.radius);
                co.lineTo(ma.round(this.centerx), this.centery + this.radius);
            
                // Draw the Y ends
                co.moveTo(this.centerx - 5, ma.round(this.centery - this.radius));
                co.lineTo(this.centerx + 5, ma.round(this.centery - this.radius));
            
                co.moveTo(this.centerx - 5, ma.round(this.centery + this.radius));
                co.lineTo(this.centerx + 5, ma.round(this.centery + this.radius));
                
                // Stroke it
                co.closePath();
                co.stroke();
            }
        };




        /**
        * This method draws the data on the graph
        */
        this.drawRose =
        this.DrawRose = function ()
        {
            var max    = 0,
                data   = this.data,
                margin = RG.degrees2Radians(prop['chart.margin']),
                opt    = arguments[0] || {}

            co.lineWidth = prop['chart.linewidth'];
    
            // Work out the maximum value and the sum
            if (RG.isNull(prop['chart.ymax'])) {
    
                // Work out the max
                for (var i=0; i<data.length; ++i) {
                    if (typeof data[i] == 'number') {
                        max = ma.max(max, data[i]);
                    } else if (typeof data[i] == 'object' && prop['chart.variant'].indexOf('non-equi-angular') !== -1) {
                        max = ma.max(max, data[i][0]);
                    
                    // Fallback is stacked
                    } else {
                        max = ma.max(max, RG.arraySum(data[i]));
                    }
                }
    
                this.scale2 = RG.getScale2(this, {
                    'max':max,
                    'min':0,
                    'scale.thousand':prop['chart.scale.thousand'],
                    'scale.point':prop['chart.scale.point'],
                    'scale.decimals':prop['chart.scale.decimals'],
                    'ylabels.count':prop['chart.labels.count'],
                    'scale.round':prop['chart.scale.round'],
                    'units.pre': prop['chart.units.pre'],
                    'units.post': prop['chart.units.post']
                });
                this.max = this.scale2.max;
    
            } else {
    
                var ymax = prop['chart.ymax'];
    
    
    
                this.scale2 = RG.getScale2(this, {
                    'max':ymax,
                    'strict':true,
                    'scale.thousand':prop['chart.scale.thousand'],
                    'scale.point':prop['chart.scale.point'],
                    'scale.decimals':prop['chart.scale.decimals'],
                    'ylabels.count':prop['chart.labels.count'],
                    'scale.round':prop['chart.scale.round'],
                    'units.pre': prop['chart.units.pre'],
                    'units.post': prop['chart.units.post']
                });
                this.max = this.scale2.max
            }
            
            this.sum = RG.array_sum(data);
            
            // Move to the centre
            co.moveTo(this.centerx, this.centery);
        
            co.stroke(); // Stroke the background so it stays grey
        
            // Transparency
            if (prop['chart.colors.alpha']) {
                co.globalAlpha = prop['chart.colors.alpha'];
            }
            
            var sequentialIndex = 0;
    
            /*******************************************************
            * A non-equi-angular Rose chart
            *******************************************************/
            if (typeof(prop['chart.variant']) == 'string' && prop['chart.variant'].indexOf('non-equi-angular') !== -1) {

                var total=0;
                for (var i=0; i<data.length; ++i) {
                    total += data[i][1];
                }
                
                
                for (var i=0; i<this.data.length; ++i) {
                
                    var segmentRadians = ((this.data[i][1] / total) * RG.TWOPI);
                    var radius         = ((this.data[i][0] - prop['chart.ymin']) / (this.max - prop['chart.ymin'])) * this.radius;
                        radius = radius * prop['chart.animation.grow.multiplier'];
    
                    co.strokeStyle = prop['chart.strokestyle'];
                    co.fillStyle   = prop['chart.colors'][0];
    
                    if (prop['chart.colors.sequential']) {
                        co.fillStyle = prop['chart.colors'][i];
                    }
    
                    co.beginPath(); // Begin the segment
    
                        var startAngle = (this.startRadians * prop['chart.animation.roundrobin.factor']) - RG.HALFPI + margin;
                        var endAngle   = ((this.startRadians + segmentRadians) * prop['chart.animation.roundrobin.factor']) - RG.HALFPI - margin;
    
                        var exploded  = this.getexploded(i, startAngle, endAngle, prop['chart.exploded']);
                        var explodedX = exploded[0];
                        var explodedY = exploded[1];
    
    
                        co.arc(
                            this.centerx + explodedX,
                            this.centery + explodedY,
                            prop['chart.animation.roundrobin.radius'] ? radius * prop['chart.animation.roundrobin.factor'] : radius,
                            startAngle,
                            endAngle,
                            0
                        );
                        co.lineTo(this.centerx + explodedX, this.centery + explodedY);
                    co.closePath(); // End the segment
                    
                    co.stroke();
                    co.fill();
                    
                    // Store the start and end angles

                    this.angles[i] = [
                        startAngle,
                        endAngle,
                        0,
                        radius,
                        this.centerx + explodedX,
                        this.centery + explodedY
                    ];
                    
                    sequentialIndex++;
                    this.startRadians += segmentRadians;
                }
            } else {
            
                var sequentialColorIndex = 0;

                /*******************************************************
                * Draw regular segments here
                *******************************************************/
                for (var i=0; i<this.data.length; ++i) {
    
                    var segmentRadians = (1 / this.data.length) * RG.TWOPI;

                    if (typeof this.data[i] == 'number') {
                        co.beginPath(); // Begin the segment
    
                            co.strokeStyle = prop['chart.strokestyle'];
                            co.fillStyle = prop['chart.colors'][0];
            
                            /*******************************************************
                            * This allows sequential colors
                            *******************************************************/
                            if (prop['chart.colors.sequential']) {
                                co.fillStyle = prop['chart.colors'][i];
                            }
            
                            var radius = ((this.data[i] - prop['chart.ymin']) / (this.max - prop['chart.ymin'])) * this.radius;
                                radius = radius * prop['chart.animation.grow.multiplier'];
    
                            var startAngle = (this.startRadians * prop['chart.animation.roundrobin.factor']) - RG.HALFPI + margin;
                            var endAngle   = (this.startRadians * prop['chart.animation.roundrobin.factor']) + (segmentRadians * prop['chart.animation.roundrobin.factor']) - RG.HALFPI - margin;
    
                            var exploded  = this.getexploded(i, startAngle, endAngle, prop['chart.exploded']);
                            var explodedX = exploded[0];
                            var explodedY = exploded[1];
    
                            co.arc(this.centerx + explodedX,
                                   this.centery + explodedY,
                                   prop['chart.animation.roundrobin.radius'] ? radius * prop['chart.animation.roundrobin.factor'] : radius,
                                   startAngle,
                                   endAngle,
                                   0);
                            co.lineTo(this.centerx + explodedX, this.centery + explodedY);
                        co.closePath(); // End the segment
                        co.stroke();
                        co.fill();

                        // This skirts a double-stroke bug
                        co.beginPath();

                        if (endAngle == 0) {
                            //endAngle = RG.TWOPI;
                        }

                        // Store the start and end angles
                        this.angles[i] = [
                            startAngle,
                            endAngle,
                            0,
                            radius * prop['chart.animation.roundrobin.factor'],
                            this.centerx + explodedX,
                            this.centery + explodedY
                        ];
                        
                        sequentialIndex++;
    
                    /*******************************************************
                    * Draw a stacked segment
                    *******************************************************/
                    } else if (typeof(this.data[i]) == 'object') {

                        var margin = prop['chart.margin'] / (180 / RG.PI);

                        
                        // Initialise the angles2 array
                        if (!this.angles2[i]) {
                            this.angles2[i] = [];
                        }
                        
    
                        for (var j=0; j<this.data[i].length; ++j) {
                        
                            var startAngle = (this.startRadians * prop['chart.animation.roundrobin.factor']) - RG.HALFPI + margin;
                            var endAngle  = (this.startRadians * prop['chart.animation.roundrobin.factor'])+ (segmentRadians * prop['chart.animation.roundrobin.factor']) - RG.HALFPI - margin;
                        
                            var exploded  = this.getexploded(i, startAngle, endAngle, prop['chart.exploded']);
                            var explodedX = exploded[0];
                            var explodedY = exploded[1];
        
                            co.strokeStyle = prop['chart.strokestyle'];
                            co.fillStyle   = prop['chart.colors'][j];
    
                            // This facilitates sequential color support
                            if (prop['chart.colors.sequential']) {
                                co.fillStyle = prop['chart.colors'][sequentialColorIndex++];
                            }
    
                            if (j == 0) {
                                co.beginPath(); // Begin the segment
                                    var startRadius = 0;
                                    var endRadius = ((this.data[i][j] - prop['chart.ymin']) / (this.max - prop['chart.ymin'])) * this.radius;
                                        endRadius = endRadius * prop['chart.animation.grow.multiplier'];
                        
                                    co.arc(this.centerx + explodedX,
                                           this.centery + explodedY,
                                           prop['chart.animation.roundrobin.radius'] ? endRadius * prop['chart.animation.roundrobin.factor'] : endRadius,
                                           startAngle,
                                           endAngle,
                                           0);
                                    co.lineTo(this.centerx + explodedX, this.centery + explodedY);
                                co.closePath(); // End the segment
                                co.stroke();
                                co.fill();

                                this.angles[sequentialIndex++] = [
                                    startAngle,
                                    endAngle,
                                    0,
                                    endRadius * prop['chart.animation.roundrobin.factor'],
                                    this.centerx + explodedX,
                                    this.centery + explodedY
                                ];
        
                                this.angles2[i][j] = [
                                    startAngle,
                                    endAngle,
                                    0,
                                    endRadius * prop['chart.animation.roundrobin.factor'],
                                    this.centerx + explodedX,
                                    this.centery + explodedY
                                ];
                            
                            } else {
    
                                co.beginPath(); // Begin the segment
                                    
                                    var startRadius = endRadius; // This comes from the prior iteration of this loop
                                    var endRadius = (((this.data[i][j] - prop['chart.ymin']) / (this.max - prop['chart.ymin'])) * this.radius) + startRadius;
                                        endRadius = endRadius * prop['chart.animation.grow.multiplier'];
                    
                                    co.arc(this.centerx + explodedX,
                                           this.centery + explodedY,
                                           startRadius  * prop['chart.animation.roundrobin.factor'],
                                           startAngle,
                                           endAngle,
                                           0);
                    
                                    co.arc(this.centerx + explodedX,
                                           this.centery + explodedY,
                                           endRadius  * prop['chart.animation.roundrobin.factor'],
                                           endAngle,
                                           startAngle,
                                           true);
                    
                                co.closePath(); // End the segment
                                co.stroke();
                                co.fill();
        

                                this.angles[sequentialIndex++] = [
                                    startAngle,
                                    endAngle,
                                    startRadius * prop['chart.animation.roundrobin.factor'],
                                    endRadius * prop['chart.animation.roundrobin.factor'],
                                    this.centerx + explodedX,
                                    this.centery + explodedY
                                ];
        
                                this.angles2[i][j] = [
                                    startAngle,
                                    endAngle,
                                    startRadius * prop['chart.animation.roundrobin.factor'],
                                    endRadius * prop['chart.animation.roundrobin.factor'],
                                    this.centerx + explodedX,
                                    this.centery + explodedY
                                ];
                            }
                        }
                    }
        
                    this.startRadians += segmentRadians;
                }
            }
    
            // Turn off the transparency
            if (prop['chart.colors.alpha']) {
                co.globalAlpha = 1;
            }
    
            // Draw the title if any has been set
            if (prop['chart.title']) {
                RG.drawTitle(
                    this,
                    prop['chart.title'],
                    (ca.height / 2) - this.radius,
                    this.centerx,
                    prop['chart.title.size'] ? prop['chart.title.size'] : prop['chart.text.size'] + 2
                );
            }
        };




        /**
        * Unsuprisingly, draws the labels
        */
        this.drawLabels =
        this.DrawLabels = function ()
        {
            co.lineWidth = 1;
            var key = prop['chart.key'];
    
            if (key && key.length) {
                RG.DrawKey(this, key, prop['chart.colors']);
            }
            
            // Set the color to black
            co.fillStyle = prop['chart.text.color'];
            co.strokeStyle = 'black';
            
            var radius      = this.radius,
                font        = prop['chart.text.font'],
                size        = prop['chart.text.size'],
                axes        = prop['chart.labels.axes'].toLowerCase(),
                decimals    = prop['chart.scale.decimals'],
                units_pre   = prop['chart.units.pre'],
                units_post  = prop['chart.units.post'],
                centerx     = this.centerx,
                centery     = this.centery + (prop['chart.variant'].indexOf('3d') !== -1 ? prop['chart.variant.threed.depth'] : 0);

            // Draw any circular labels
            if (typeof prop['chart.labels'] == 'object' && prop['chart.labels']) {
                this.DrawCircularLabels(co, prop['chart.labels'], font, size, radius + 10);
            }
    
    
            // Size can be specified seperately for the scale now
            if (typeof(prop['chart.text.size.scale']) == 'number') {
                size = prop['chart.text.size.scale'];
            }
    
    
            var color     = 'rgba(255,255,255,0.8)';
    
            // The "North" axis labels
            if (axes.indexOf('n') > -1) {
                for (var i=0; i<prop['chart.labels.count']; ++i) {
                    RG.text2(this, {
                        'font':font,
                        'size':size,
                        'x':centerx - 10,
                        'y':centery - (radius * ((i+1) / prop['chart.labels.count'])),
                        'text':this.scale2.labels[i],
                        'valign':'center',
                        'halign':'right',
                        'bounding':true,
                        'boundingFill':color,
                        'boundingStroke':prop['chart.labels.boxed'] ? 'black' : 'rgba(0,0,0,0)',
                        'tag': 'scale'
                    });
                }
            }
    
            // The "South" axis labels
            if (axes.indexOf('s') > -1) {
                for (var i=0; i<prop['chart.labels.count']; ++i) {
                    RG.Text2(this, {
                        'font':font,
                        'size':size,
                        'x':centerx - 10,
                        'y':centery + (radius * ((i+1) / prop['chart.labels.count'])),
                        'text':this.scale2.labels[i],
                        'valign':'center',
                        'halign':'right',
                        'bounding':true,
                        'boundingFill':color,
                        'boundingStroke':prop['chart.labels.boxed'] ? 'black' : 'rgba(0,0,0,0)',
                        'tag': 'scale'
                    });
                }
            }
            
            // The "East" axis labels
            if (axes.indexOf('e') > -1) {
                for (var i=0; i<prop['chart.labels.count']; ++i) {
                    RG.Text2(this, {
                        'font':font,
                        'size':size,
                        'x':centerx + (radius * ((i+1) / prop['chart.labels.count'])),
                        'y':centery + 10,
                        'text':this.scale2.labels[i],
                        'valign':'top',
                        'halign':'center',
                        'bounding':true,
                        'boundingFill':color,
                        'boundingStroke':prop['chart.labels.boxed'] ? 'black' : 'rgba(0,0,0,0)',
                        'tag': 'scale'
                    });
                }
            }
    
            // The "West" axis labels
            if (axes.indexOf('w') > -1) {
                for (var i=0; i<prop['chart.labels.count']; ++i) {
                    RG.Text2(this, {
                        'font':font,
                        'size':size,
                        'x':centerx - (radius * ((i+1) / prop['chart.labels.count'])),
                        'y':centery + 10,
                        'text':this.scale2.labels[i],
                        'valign':'top',
                        'halign':'center',
                        'bounding':true,
                        'boundingFill':color,
                        'boundingStroke':prop['chart.labels.boxed'] ? 'black' : 'rgba(0,0,0,0)',
                        'tag': 'scale'
                    });
                }
            }

            if (RG.trim(axes).length > 0) {
                RG.Text2(this, {
                    'font':font,
                    'size':size,
                    'x':centerx,
                    'y':centery,
                    'text':typeof(prop['chart.ymin']) == 'number' ? RG.number_format(this, Number(prop['chart.ymin']).toFixed(prop['chart.scale.decimals']), units_pre, units_post) : '0',
                    'valign':'center',
                    'halign':'center',
                    'bounding':true,
                    'boundingFill':color,
                    'boundingStroke':prop['chart.labels.boxed'] ? 'black' : 'rgba(0,0,0,0)',
                    'tag': 'scale'
                });
            }
        };




        /**
        * Draws the circular labels that go around the charts
        * 
        * @param labels array The labels that go around the chart
        */
        this.drawCircularLabels =
        this.DrawCircularLabels = function (co, labels, font, size, radius)
        {
            var variant     = prop['chart.variant'],
                position    = prop['chart.labels.position'],
                radius      = radius + 5 + prop['chart.labels.offset'],
                centerx     = this.centerx,
                centery     = this.centery + (prop['chart.variant'].indexOf('3d') !== -1 ? prop['chart.variant.threed.depth'] : 0),
                labelsColor = prop['chart.labels.color'] || prop['chart.text.color']
    
            for (var i=0; i<labels.length; ++i) {
                if (typeof(variant) == 'string' && variant.indexOf('non-equi-angular') !== -1) {
                    var a = Number(this.angles[i][0]) + ((this.angles[i][1] - this.angles[i][0]) / 2);
                } else {
                    var a = (RG.TWOPI / labels.length) * (i + 1) - (RG.TWOPI / (labels.length * 2));
                    var a = a - RG.HALFPI + (prop['chart.labels.position'] == 'edge' ? ((RG.TWOPI / labels.length) / 2) : 0);
                }
    
                var x = centerx + (ma.cos(a) * radius);
                var y = centery + (ma.sin(a) * radius);
    
                // Horizontal alignment
                if (x > centerx) {
                    halign = 'left';
                } else if (Math.round(x) == centerx) {
                    halign = 'center';
                } else {
                    halign = 'right';
                }
    
                RG.text2(this, {
                    'color': labelsColor,
                    'font':font,
                    'size':size,
                    'x':x,
                    'y':y,
                    'text':String(labels[i]),
                    'halign':halign,
                    'valign':'center',
                    'tag': 'labels'
                });
            }
        };
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        /**
        * This function is for use with circular graph types, eg the Pie or Rose. Pass it your event object
        * and it will pass you back the corresponding segment details as an array:
        * 
        * [x, y, r, startAngle, endAngle]
        * 
        * Angles are measured in degrees, and are measured from the "east" axis (just like the canvas).
        * 
        * @param object e   Your event object
        * @param object Options (OPTIONAL):
        *                radius - whether to take into account
        *                         the radius of the segment
        */
        this.getShape =
        this.getSegment = function (e)
        {
            RG.fixEventObject(e);
    
            var angles  = this.angles;
            var ret     = [];
            var opt     = arguments[1] ? arguments[1] : {radius: true};
    
            /**
            * Go through all of the angles checking each one
            */
            for (var i=0; i<angles.length ; ++i) {
    
                var angleStart  = angles[i][0];
                var angleEnd    = angles[i][1];
                var radiusStart = opt.radius === false ? 0 : angles[i][2];
                var radiusEnd   = opt.radius === false ? this.radius : angles[i][3];
                var centerX     = angles[i][4];
                var centerY     = angles[i][5];// - (prop['chart.variant'].indexOf('3d') !== -1 ? prop['chart.variant.threed.depth'] : 0);
                var mouseXY     = RG.getMouseXY(e);
                var mouseX      = mouseXY[0] - centerX;
                var mouseY      = mouseXY[1] - centerY;
    
                // New click testing (the 0.01 is there because Opera doesn't like 0 as the radius)
                co.beginPath();
                    co.arc(centerX, centerY, radiusStart ? radiusStart : 0.01, angleStart, angleEnd, false);
                    co.arc(centerX, centerY, radiusEnd, angleEnd, angleStart, true);
                co.closePath();
    
                // No stroke() or fill()
    
    
                if (co.isPointInPath(mouseXY[0], mouseXY[1])) {
    
                    angles[i][6] = i;
                    
                    if (RG.parseTooltipText) {
                        var tooltip = RG.parseTooltipText(prop['chart.tooltips'], angles[i][6]);
                    }
    
                    // Add the textual keys
                    angles[i]['object']       = this;
                    angles[i]['x']            = angles[i][4];
                    angles[i]['y']            = angles[i][5];
                    angles[i]['angle.start']  = angles[i][0];
                    angles[i]['angle.end']    = angles[i][1];
                    angles[i]['radius.start'] = angles[i][2];
                    angles[i]['radius.end']   = angles[i][3];
                    angles[i]['index']        = angles[i][6];
                    angles[i]['tooltip']      = tooltip ? tooltip : null;

                    return angles[i];
                }
            }

            return null;
        };
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        /**
        * Returns any exploded for a particular segment
        */
        this.getExploded =
        this.getexploded = function (index, startAngle, endAngle, exploded)
        {
            var explodedx, explodedy;
    
            /**
            * Retrieve any exploded - the exploded can be an array of numbers or a single number
            * (which is applied to all segments)
            */
            if (typeof(exploded) == 'object' && typeof(exploded[index]) == 'number') {
                explodedx = Math.cos(((endAngle - startAngle) / 2) + startAngle) * exploded[index];
                explodedy = Math.sin(((endAngle - startAngle) / 2) + startAngle) * exploded[index];
            
            } else if (typeof(exploded) == 'number') {
                explodedx = Math.cos(((endAngle - startAngle) / 2) + startAngle) * exploded;
                explodedy = Math.sin(((endAngle - startAngle) / 2) + startAngle) * exploded;
    
            } else {
                explodedx = 0;
                explodedy = 0;
            }
            
            return [explodedx, explodedy];
        };




        /**
        * This function facilitates the installation of tooltip event listeners if
        * tooltips are defined.
        */
        this.allowTooltips =
        this.AllowTooltips = function ()
        {
            // Preload any tooltip images that are used in the tooltips
            RG.PreLoadTooltipImages(this);
    
    
            /**
            * This installs the window mousedown event listener that lears any
            * highlight that may be visible.
            */
            RG.InstallWindowMousedownTooltipListener(this);
    
    
            /**
            * This installs the canvas mousemove event listener. This function
            * controls the pointer shape.
            */
            RG.InstallCanvasMousemoveTooltipListener(this);
    
    
            /**
            * This installs the canvas mouseup event listener. This is the
            * function that actually shows the appropriate tooltip (if any).
            */
            RG.InstallCanvasMouseupTooltipListener(this);
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
                // Add the new segment highlight
                co.beginPath();
                
                    co.strokeStyle = prop['chart.highlight.stroke'];
                    co.fillStyle   = prop['chart.highlight.fill'];
                
                    co.arc(
                        shape['x'],
                        shape['y'],//- (prop['chart.variant'].indexOf('3d') !== -1 ? prop['chart.variant.threed.depth'] : 0),
                        shape['radius.end'],
                        shape['angle.start'],
                        shape['angle.end'],
                        false
                    );

                    if (shape['radius.start'] > 0) {
                        co.arc(
                            shape['x'],
                            shape['y'],
                            shape['radius.start'],
                            shape['angle.end'],
                            shape['angle.start'],
                            true
                        );
                    } else {
                        co.lineTo(
                            shape['x'],
                            shape['y']
                        );
                    }
                co.closePath();
        
                co.stroke();
                co.fill();
            }
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
            var mouseXY = RGraph.getMouseXY(e);
    
            // Work out the radius
            var radius = RG.getHypLength(this.centerx, this.centery, mouseXY[0], mouseXY[1]);

            // Account for the 3D stretching effect
            if (prop['chart.variant'].indexOf('3d') !== -1) {
                radius /= -1;
            }

            if (
                   mouseXY[0] > (this.centerx - this.radius)
                && mouseXY[0] < (this.centerx + this.radius)
                && mouseXY[1] > (this.centery - this.radius)
                && mouseXY[1] < (this.centery + this.radius)
                && radius <= this.radius
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
            var centerX     = this.angles[idx][4],
                centerY     = this.angles[idx][5] - (prop['chart.variant'].indexOf('3d') !== -1 ? prop['chart.variant.threed.depth'] : 0),
                radiusStart = this.angles[idx][2],
                radiusEnd   = this.angles[idx][3],
                coordX      = this.angles[idx][4],
                coordY      = this.angles[idx][5] - (prop['chart.variant'].indexOf('3d') !== -1 ? prop['chart.variant.threed.depth'] : 0),
                angleStart  = this.angles[idx][0],
                angleEnd    = this.angles[idx][1],
                radius      = ((radiusEnd - radiusStart) / 2) + radiusStart,
                angleCenter = ((angleEnd - angleStart) / 2) + angleStart,
                canvasXY    = RG.getCanvasXY(this.canvas),
                gutterLeft  = this.gutterLeft,
                gutterTop   = this.gutterTop,
                width       = tooltip.offsetWidth,
                height      = tooltip.offsetHeight
            
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
            if ((canvasXY[0] + coordX + (Math.cos(angleCenter) * radius) - (width / 2)) < 10) {
                tooltip.style.left = (canvasXY[0] + coordX + (Math.cos(angleCenter) * (radius * (prop['chart.variant'].indexOf('3d') !== -1 ? 1.5 : 1)) )- (width * 0.1)) + 'px';
                tooltip.style.top = (canvasXY[1] + coordY + (Math.sin(angleCenter) * radius)- height - 5) + 'px';
                img.style.left = ((width * 0.1) - 8.5) + 'px';
    
            // RIGHT edge
            } else if ((canvasXY[0] + coordX + (Math.cos(angleCenter) * radius) + (width / 2)) > (doc.body.offsetWidth - 10) ) {
                tooltip.style.left = (canvasXY[0] + coordX + (Math.cos(angleCenter) * (radius * (prop['chart.variant'].indexOf('3d') !== -1 ? 1.5 : 1)) ) - (width * 0.9)) + 'px';
                tooltip.style.top = (canvasXY[1] + coordY + (Math.sin(angleCenter) * radius)- height - 5) + 'px';
                img.style.left = ((width * 0.9) - 8.5) + 'px';
    
            // Default positioning - CENTERED
            } else {

                tooltip.style.left = (canvasXY[0] + coordX + (ma.cos(angleCenter) * (radius * (prop['chart.variant'].indexOf('3d') !== -1 ? 1.5 : 1) ) )- (width / 2)) + 'px';
                tooltip.style.top = (canvasXY[1] + coordY + (ma.sin(angleCenter) * radius)- height - 5) + 'px';
                img.style.left = ((width * 0.5) - 8.5) + 'px';
            }
        };




        /**
        * This method gives you the relevant radius for a particular value
        * 
        * @param number value The relevant value to get the radius for
        */
        this.getRadius = function (value)
        {
            // Range checking (the Rose minimum is always 0)
            if (value < 0 || value > this.max) {
                return null;
            }
            
            var r = (value / this.max) * this.radius;
            
            return r;
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
                this.original_colors['chart.text.color']       = RG.array_clone(prop['chart.text.color']);
                this.original_colors['chart.title.color']      = RG.array_clone(prop['chart.title.color']);
                this.original_colors['chart.highlight.stroke'] = RG.array_clone(prop['chart.highlight.stroke']);
                this.original_colors['chart.highlight.fill']   = RG.array_clone(prop['chart.highlight.fill']);
            }










            for (var i=0; i<prop['chart.colors'].length; ++i) {
                prop['chart.colors'][i] = this.parseSingleColorForGradient(prop['chart.colors'][i]);
            }
    
            /**
            * Key colors
            */
            if (!RG.is_null(prop['chart.key.colors'])) {
                for (var i=0; i<prop['chart.key.colors'].length; ++i) {
                    prop['chart.key.colors'][i] = this.parseSingleColorForGradient(prop['chart.key.colors'][i]);
                }
            }
            
            prop['chart.text.color']               = this.parseSingleColorForGradient(prop['chart.text.color']);
            prop['chart.title.color']              = this.parseSingleColorForGradient(prop['chart.title.color']);
            prop['chart.highlight.fill']           = this.parseSingleColorForGradient(prop['chart.highlight.fill']);
            prop['chart.highlight.stroke']         = this.parseSingleColorForGradient(prop['chart.highlight.stroke']);
            prop['chart.segment.highlight.stroke'] = this.parseSingleColorForGradient(prop['chart.segment.highlight.stroke']);
            prop['chart.segment.highlight.fill']   = this.parseSingleColorForGradient(prop['chart.segment.highlight.fill']);
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
                //var grad = context.createLinearGradient(0,0,canvas.width,0);
                var grad = co.createRadialGradient(this.centerx, this.centery, 0, this.centerx, this.centery, this.radius);
    
                var diff = 1 / (parts.length - 1);
    
                grad.addColorStop(0, RG.trim(parts[0]));
    
                for (var j=1; j<parts.length; ++j) {
                    grad.addColorStop(j * diff, RG.trim(parts[j]));
                }
            }

            return grad ? grad : color;
        };




        /**
        * This function handles highlighting an entire data-series for the interactive
        * key
        * 
        * @param int index The index of the data series to be highlighted
        */
        this.interactiveKeyHighlight = function (index)
        {
            var segments = this.angles2;
            
            for (var i=0; i<this.angles2.length; i+=1) {
                co.beginPath();
                    co.lineWidth = 2;
                    co.fillStyle = prop['chart.key.interactive.highlight.chart.fill'];
                    co.strokeStyle = prop['chart.key.interactive.highlight.chart.stroke'];
                    co.arc(segments[i][index][4], segments[i][index][5], segments[i][index][2], segments[i][index][0], segments[i][index][1], false);
                    co.arc(segments[i][index][4], segments[i][index][5], segments[i][index][3], segments[i][index][1], segments[i][index][0], true);
                co.closePath();
                co.fill();
                co.stroke();
            }

            return/*
            if (segments) {
                for (var i=0; i<segments.length; i+=1) {

                }
            }
            */
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
        * Rose chart explode
        * 
        * Explodes the Rose chart - gradually incrementing the size of the chart.explode property
        * 
        * @param object     Optional options for the effect. You can pass in frames here - such as:
        *                   myRose.roundRobin({frames: 60}; function () {alert('Done!');})
        * @param function   A callback function which is called when the effect is finished
        */
        this.explode = function ()
        {
            var obj         = this;
            var opt         = arguments[0] || {};
            var callback    = arguments[1] || function (){};
            var frames      = opt.frames ? opt.frames : 30;
            var frame       = 0;
            var explodedMax = ma.max(ca.width, ca.height);
            var exploded    = Number(this.Get('exploded'));
    
    
    
    
            function iterator ()
            {
                exploded =  (frame / frames) * explodedMax;

                // Set the new value
                obj.Set('exploded', exploded);
    
                RG.clear(ca);
                RG.redrawCanvas(ca);
    
                if (frame++ < frames) {
                    RG.Effects.updateCanvas(iterator);
                } else  {
                    callback(obj);
                }
            }




            iterator();
            
            return this;
        };




        /**
        * RoundRobin
        * 
        * This effect is similar to the Pie chart RoundRobin effect
        * 
        * @param object     Optional options for the effect. You can pass in frames here - such as:
        *                   myRose.roundRobin({frames: 60}; function () {alert('Done!');})
        * @param function   A callback function which is called when the effect is finished
        */
        this.roundrobin =
        this.roundRobin = function ()
        {
            var obj             = this;
            var opt             = arguments[0] || {}
            var frames          = opt.frames || 30;
            var frame           = 0;
            var original_margin = prop['chart.margin'];
            var margin          = (360 / this.data.length) / 2;
            var callback        = arguments[1] || function () {};
    
            this.Set('chart.margin', margin);
            this.Set('chart.animation.roundrobin.factor', 0);
    
            function iterator ()
            {
                RG.clear(obj.canvas);
                RG.redrawCanvas(obj.canvas);

                if (frame++ < frames) {
                    obj.set('animation.roundrobin.factor', frame / frames);
                    obj.set('margin', (frame / frames) * original_margin);
                    RG.Effects.updateCanvas(iterator);
                } else {
                    obj.set('animation.roundrobin.factor', 1);
                    obj.set('margin', original_margin);
                    
                    callback(obj);
                }
            }
            
            iterator();
            
            return this;
        };




        /**
        * Rose chart implode
        * 
        * Implodes the Rose chart - gradually decreasing the size of the chart.explode property. It starts at the largest of
        * the canvas width./height
        * 
        * @param object     Optional options for the effect. You can pass in frames here - such as:
        *                   myRose.implode({frames: 60}; function () {alert('Done!');})
        * @param function   A callback function which is called when the effect is finished
        */
        this.implode = function ()
        {
            var obj         = this;
            var opt         = arguments[0] || {};
            var callback    = arguments[1] || function (){};
            var frames      = opt.frames || 30;
            var frame       = 0;
            var explodedMax = ma.max(ca.width, ca.height);
            var exploded    = explodedMax;
    
    
    
            function iterator ()
            {
                exploded =  explodedMax - ((frame / frames) * explodedMax);

                // Set the new value
                obj.Set('exploded', exploded);
    
                RG.clear(ca);
                RG.redrawCanvas(ca);

                if (frame++ < frames) {
                    RG.Effects.updateCanvas(iterator);
                } else {
                    RG.clear(obj.canvas);
                    RG.redrawCanvas(obj.canvas);
                    callback(obj);
                }
            }
            
            iterator();

            return this;
        };




        /**
        * Rose chart Grow
        * 
        * This effect gradually increases the size of the Rose chart
        * 
        * @param object     Optional options for the effect. You can pass in frames here - such as:
        *                   myRose.grow({frames: 60}; function () {alert('Done!');})
        * @param function   A callback function which is called when the effect is finished
        */
        this.grow = function ()
        {
            var obj      = this;
            var opt      = arguments[0] || {};
            var callback = arguments[1] || function (){};
            var frames   = opt.frames || 30;
            var frame    = 0;

            function iterator ()
            {
                obj.Set('animation.grow.multiplier', frame / frames);
    
                RG.clear(ca);
                RG.redrawCanvas(ca);

                if (frame < frames) {
                    frame++;
                    RG.Effects.updateCanvas(iterator);
                } else {
                    callback(obj);
                }
            }
            
            iterator();

            return this;
        };




        /**
        * Register this object
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