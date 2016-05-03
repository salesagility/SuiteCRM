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
    * The pie chart constructor
    * 
    * @param data array The data to be represented on the Pie chart
    */
    RGraph.Pie = function (conf)
    {
        /**
        * Allow for object config style
        */
        if (   typeof conf === 'object'
            && typeof conf.data === 'object'
            && typeof conf.id === 'string') {

            var id                        = conf.id;
            var canvas                    = document.getElementById(id);
            var data                      = conf.data;
            var parseConfObjectForOptions = true; // Set this so the config is parsed (at the end of the constructor)
        
        } else {
        
            var id     = conf;
            var canvas = document.getElementById(id);
            var data   = arguments[1];
        }




        // Get the canvas and context objects
        this.id                = id;
        this.canvas            = canvas;
        this.context           = this.canvas.getContext ? this.canvas.getContext("2d", {alpha: (typeof id === 'object' && id.alpha === false) ? false : true}) : null;
        this.canvas.__object__ = this;
        this.total             = 0;
        this.subTotal          = 0;
        this.angles            = [];
        this.data              = data;
        this.properties        = [];
        this.type              = 'pie';
        this.isRGraph          = true;
        this.coords            = [];
        this.coords.key        = [];
        this.coordsSticks      = [];
        this.coordsText        = [];
        this.uid               = RGraph.CreateUID();
        this.canvas.uid        = this.canvas.uid ? this.canvas.uid : RGraph.CreateUID();
        this.colorsParsed      = false;
        this.original_colors   = [];
        this.firstDraw         = true; // After the first draw this will be false


        /**
        * Compatibility with older browsers
        */
        //RGraph.OldBrowserCompat(this.context);

        this.properties =
        {
            'chart.centerx.adjust':         0,
            'chart.centery.adjust':         0,
            'chart.colors':                 ['Gradient(red:#fcc)', 'Gradient(#ddd:#eee)', 'Gradient(#0f0:#cfc)', 'Gradient(blue:#ccf)', 'Gradient(#FB7BA3:#FCC7EE)', 'Gradient(yellow:#ffc)', 'Gradient(#000:#ccc)', 'Gradient(#EE9D80:#FEE5C8)', 'Gradient(cyan:#ccf)','Gradient(#9E7BF6:#C7B6D2)','Gradient(#78CAEA:#C5FBFD)','Gradient(#E284E9:#FDC4FF)','Gradient(white:#ccf)','Gradient(blue:#ccf)','Gradient(#9E7BF6:#C7B6D2)'],
            'chart.strokestyle':            'white',
            'chart.linewidth':              3,
            'chart.labels':                 [],
            'chart.labels.sticks':          false,
            'chart.labels.sticks.length':   7,
            'chart.labels.sticks.color':    '#aaa',
            'chart.labels.sticks.hlength':  5,
            'chart.labels.ingraph':         null,
            'chart.labels.ingraph.color':   null,
            'chart.labels.ingraph.font':    null,
            'chart.labels.ingraph.size':    null,
            'chart.labels.ingraph.bounding':true,
            'chart.labels.ingraph.bounding.fill':'white',
            'chart.labels.ingraph.specific':null,
            'chart.labels.ingraph.units.pre':'',
            'chart.labels.ingraph.units.post':'',
            'chart.labels.ingraph.radius':  null,
            'chart.labels.center':            null,
            'chart.labels.center.size':       26,
            'chart.labels.center.font':       'Arial',
            'chart.labels.center.color':      'black',
            'chart.labels.center.italic':     false,
            'chart.labels.center.bold':       false,
            'chart.labels.center.units.pre':  '',
            'chart.labels.center.units.post': '',
            'chart.gutter.left':            25,
            'chart.gutter.right':           25,
            'chart.gutter.top':             25,
            'chart.gutter.bottom':          25,
            'chart.title':                  '',
            'chart.title.background':       null,
            'chart.title.hpos':             null,
            'chart.title.vpos':             0.5,
            'chart.title.bold':             true,
            'chart.title.font':             null,
            'chart.title.x':                null,
            'chart.title.y':                null,
            'chart.title.halign':           null,
            'chart.title.valign':           null,
            'chart.shadow':                 true,
            'chart.shadow.color':           '#aaa',
            'chart.shadow.offsetx':         0,
            'chart.shadow.offsety':         0,
            'chart.shadow.blur':            15,
            'chart.text.size':              12,
            'chart.text.color':             'black',
            'chart.text.font':              'Arial',
            'chart.contextmenu':            null,
            'chart.tooltips':               null,
            'chart.tooltips.event':         'onclick',
            'chart.tooltips.effect':        'fade',
            'chart.tooltips.css.class':     'RGraph_tooltip',
            'chart.tooltips.highlight':     true,
            'chart.highlight.style':        '2d',
            'chart.highlight.style.2d.fill': 'rgba(255,255,255,0.7)',
            'chart.highlight.style.2d.stroke': 'rgba(255,255,255,0.7)',
            'chart.centerx':                null,
            'chart.centery':                null,
            'chart.radius':                 null,
            'chart.border':                 false,
            'chart.border.color':           'rgba(255,255,255,0.5)',
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
            'chart.variant':                'pie',
            'chart.variant.donut.width':    null,
            'chart.variant.threed.depth':   20,
            'chart.exploded':               [],
            'chart.effect.roundrobin.multiplier': 1,
            'chart.events.click':             null,
            'chart.events.mousemove':         null,
            'chart.centerpin':                null,
            'chart.centerpin.fill':           'gray',
            'chart.centerpin.stroke':         'white',
            'chart.origin':                   0 - (Math.PI / 2),
            'chart.events':                   true,
            'chart.labels.colors':            []
        }



        /**
        * Calculate the total
        */
        for (var i=0,len=data.length; i<len; i++) {
            this.total += data[i];
            
            // This loop also creates the $xxx objects - this isn't related to
            // the code above but just saves doing another loop through the data
            this['$' + i] = {};
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
        * A generic setter
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
            * This should be done first - prepend the property name with "chart." if necessary
            */
            if (name.substr(0,6) != 'chart.') {
                name = 'chart.' + name;
            }




            // Convert uppercase letters to dot+lower case letter
            name = name.replace(/([A-Z])/g, function (str)
            {
                return '.' + String(RegExp.$1).toLowerCase();
            });
    
            if (name == 'chart.highlight.style.2d.color') {
                name = 'chart.highlight.style.2d.fill';
            }





    
            prop[name] = value;
    
            return this;
        };




        /**
        * A generic getter
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
    
            if (name == 'chart.highlight.style.2d.color') {
                name = 'chart.highlight.style.2d.fill';
            }
    
            return prop[name];
        };




        /**
        * This draws the pie chart
        */
        this.draw =
        this.Draw = function ()
        {
            /**
            * Fire the onbeforedraw event
            */
            RG.FireCustomEvent(this, 'onbeforedraw');
            
            // NB: Colors are parsed further down so that the center X/Y can be used
    
    
            /**
            * This is new in May 2011 and facilitates indiviual gutter settings,
            * eg chart.gutter.left
            */
            this.gutterLeft   = prop['chart.gutter.left'];
            this.gutterRight  = prop['chart.gutter.right'];
            this.gutterTop    = prop['chart.gutter.top'];
            this.gutterBottom = prop['chart.gutter.bottom'];

            this.radius     = this.getRadius();// MUST be first
            this.centerx    = (this.graph.width / 2) + this.gutterLeft + prop['chart.centerx.adjust'];
            this.centery    = (this.graph.height / 2) + this.gutterTop + prop['chart.centery.adjust'];
            this.subTotal   = this.properties['chart.origin'];
            this.angles     = [];
            this.coordsText = [];
    
            /**
            * Allow specification of a custom radius & center X/Y
            */
            if (typeof prop['chart.radius'] === 'number')  this.radius  = prop['chart.radius'];
            if (typeof prop['chart.centerx'] === 'number') this.centerx = prop['chart.centerx'];
            if (typeof prop['chart.centery'] === 'number') this.centery = prop['chart.centery'];
    
    
            if (this.radius <= 0) {
                return;
            }
    
            /**
            * Parse the colors for gradients. Its down here so that the center X/Y can be used
            */
            if (!this.colorsParsed) {
    
                this.parseColors();
    
                // Don't want to do this again
                this.colorsParsed = true;
            }
    
    
    
            /**
            * This sets the label colors. Doing it here saves lots of if() conditions in the draw method
            */
            if (prop['chart.labels.colors'].length < prop['chart.labels'].length) {
                while (prop['chart.labels.colors'].length < prop['chart.labels'].length) {
                    prop['chart.labels.colors'].push(prop['chart.labels.colors'][prop['chart.labels.colors'].length - 1]);
                }
            } else {
                if (typeof prop['chart.labels.colors'] === 'undefined') {
                    prop['chart.labels.colors'] = [];
                }

                while (prop['chart.labels.colors'].length < prop['chart.labels'].length) {
                    prop['chart.labels.colors'].push(prop['chart.text.color']);
                }
            }




            if (prop['chart.variant'].indexOf('3d') > 0) {
                return this.draw3d();
            }




            /**
            * Draw the title
            */
            RG.DrawTitle(
                this,
                prop['chart.title'],
                (ca.height / 2) - this.radius - 5,
                this.centerx,
                prop['chart.title.size'] ? prop['chart.title.size'] : prop['chart.text.size'] + 2
            );
    
            /**
            * Draw the shadow if required
            * 
            * ???
            */
            //if (prop['chart.shadow'] && false) {
            //
            //    var offsetx = doc.all ? prop['chart.shadow.offsetx'] : 0;
            //    var offsety = doc.all ? prop['chart.shadow.offsety'] : 0;
            // 
            //    co.beginPath();
            //   co.fillStyle = prop['chart.shadow.color'];
            //
            //    co.shadowColor   = prop['chart.shadow.color'];
            //    co.shadowBlur    = prop['chart.shadow.blur'];
            //    co.shadowOffsetX = prop['chart.shadow.offsetx'];
            //    co.shadowOffsetY = prop['chart.shadow.offsety'];
            //   
            //    co.arc(this.centerx + offsetx, this.centery + offsety, this.radius, 0, TWOPI, 0);
            //    
            //    co.fill();
            //    
            //    // Now turn off the shadow
            //    RG.NoShadow(this);
            //}

            /**
            * The total of the array of values
            */
            this.total = RG.array_sum(this.data);
            var tot    = this.total;
            var data   = this.data;

            for (var i=0,len=this.data.length; i<len; i++) {
                
                var angle = ((data[i] / tot) * RG.TWOPI);
    
                // Draw the segment
                this.DrawSegment(angle,prop['chart.colors'][i],i == (len - 1), i);
            }

            RG.NoShadow(this);

            /**
            * Redraw the seperating lines
            */
            if (prop['chart.linewidth'] > 0) {
                this.DrawBorders();
            }

            /**
            * Now draw the segments again with shadow turned off. This is always performed,
            * not just if the shadow is on.
            */
            var len = this.angles.length;
            var r   = this.radius;

            
            for (var action=0; action<2; action+=1) {
                for (var i=0; i<len; i++) {
    
                    co.beginPath();
     
                    var segment = this.angles[i];
            
                        if (action === 1) {
                            co.strokeStyle = typeof(prop['chart.strokestyle']) == 'object' ? prop['chart.strokestyle'][i] : prop['chart.strokestyle'];
                        }
                        prop['chart.colors'][i] ?  co.fillStyle = prop['chart.colors'][i] : null;
                        co.lineJoin = 'round';
                        
                        co.arc(segment[2],
                               segment[3],
                               r,
                               (segment[0]),
                               (segment[1]),
                               false);
                        if (prop['chart.variant'] == 'donut') {
        
                            co.arc(
                                segment[2],
                                segment[3],
                                typeof(prop['chart.variant.donut.width']) == 'number' ? r - prop['chart.variant.donut.width'] : r / 2,
                                (segment[1]),
                                (segment[0]),
                                true
                            );
                            
                        } else {
                            co.lineTo(segment[2], segment[3]);
                        }
                    co.closePath();
                    action === 0 ? co.fill() : co.stroke();
                }
            }
            

    

            /**
            * Draw label sticks
            */
            if (prop['chart.labels.sticks']) {
                
                this.DrawSticks();
    
                // Redraw the border going around the Pie chart if the stroke style is NOT white
                var strokeStyle = prop['chart.strokestyle'];
            }

            /**
            * Draw the labels
            */
            if (prop['chart.labels']) {
                this.DrawLabels();
            }
            
            
            /**
            * Draw centerpin if requested
            */
            if (prop['chart.centerpin']) {
                this.DrawCenterpin();
            }
    
    
    
    
            /**
            * Draw ingraph labels
            */
            if (prop['chart.labels.ingraph']) {
                this.DrawInGraphLabels();
            }
    
    
    
    
            /**
            * Draw the center label if requested
            */
            if (!RG.isNull(prop['chart.labels.center'])) {
                this.drawCenterLabel(prop['chart.labels.center']);
            }
    
            
            /**
            * Setup the context menu if required
            */
            if (prop['chart.contextmenu']) {
                RG.ShowContext(this);
            }
    
    
    
            /**
            * If a border is pecified, draw it
            */
            if (prop['chart.border']) {
                co.beginPath();
                co.lineWidth = 5;
                co.strokeStyle = prop['chart.border.color'];
    
                co.arc(this.centerx,
                       this.centery,
                       this.radius - 2,
                       0,
                       RG.TWOPI,
                       0);
    
                co.stroke();
            }

            /**
            * Draw the kay if desired
            */
            if (prop['chart.key'] && prop['chart.key'].length) {
                RG.DrawKey(this, prop['chart.key'], prop['chart.colors']);
            }
    
            RG.NoShadow(this);
    
            
            /**
            * This function enables resizing
            */
            if (prop['chart.resizable']) {
                RG.AllowResizing(this);
            }
    
    
            /**
            * This installs the event listeners
            */
            if (prop['chart.events'] == true) {
                RG.InstallEventListeners(this);
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
        * Draws a single segment of the pie chart
        * 
        * @param int degrees The number of degrees for this segment
        */
        this.drawSegment =
        this.DrawSegment = function (radians, color, last, index)
        {
            // IE7/8/ExCanvas fix (when there's only one segment the Pie chart doesn't display
            if (RGraph.ISOLD && radians == RG.TWOPI) {
                radians -= 0.0001;
            } else if (RGraph.ISOLD && radians == 0) {
                radians = 0.001;
            }
    
            var context  = co;
            var canvas   = ca;
            var subTotal = this.subTotal;
                radians  = radians * prop['chart.effect.roundrobin.multiplier'];
    
            co.beginPath();
    
                color ? co.fillStyle   = color : null;
                co.strokeStyle = prop['chart.strokestyle'];
                co.lineWidth   = 0;
    
                if (prop['chart.shadow']) {
                    RG.SetShadow(this,
                                 prop['chart.shadow.color'],
                                 prop['chart.shadow.offsetx'],
                                 prop['chart.shadow.offsety'],
                                 prop['chart.shadow.blur']);
                }
    
                /**
                * Exploded segments
                */
                if ( (typeof(prop['chart.exploded']) == 'object' && prop['chart.exploded'][index] > 0) || typeof(prop['chart.exploded']) == 'number') {
                    
                    var explosion = typeof(prop['chart.exploded']) == 'number' ? prop['chart.exploded'] : prop['chart.exploded'][index];
                    var x         = 0;
                    var y         = 0;
                    var h         = explosion;
                    var t         = subTotal + (radians / 2);
                    var x         = (Math.cos(t) * explosion);
                    var y         = (Math.sin(t) * explosion);
                    var r         = this.radius;
                
                    co.moveTo(this.centerx + x, this.centery + y);
                } else {
                    var x = 0;
                    var y = 0;
                    var r = this.radius;
                }
    
                /**
                * Calculate the angles
                */
                var startAngle = subTotal;
                var endAngle   = ((subTotal + radians));
    
                co.arc(this.centerx + x,
                       this.centery + y,
                       r,
                       startAngle,
                       endAngle,
                       0);
    
                if (prop['chart.variant'] == 'donut') {
    
                    co.arc(this.centerx + x,
                           this.centery + y,
                           typeof(prop['chart.variant.donut.width']) == 'number' ? r - prop['chart.variant.donut.width'] : r / 2,
                           endAngle,
                           startAngle,
                           true);
                } else {
                    co.lineTo(this.centerx + x, this.centery + y);
                }
    
            co.closePath();
    
    
            // Keep hold of the angles
            this.angles.push([subTotal, subTotal + radians, this.centerx + x, this.centery + y]);
    
    
            
            //co.stroke();
            co.fill();
    
            /**
            * Calculate the segment angle
            */
            this.subTotal += radians;
        };




        /**
        * Draws the graphs labels
        */
        this.drawLabels =
        this.DrawLabels = function ()
        {
            var hAlignment = 'left';
            var vAlignment = 'center';
            var labels     = prop['chart.labels'];
            var context    = co;
            var font       = prop['chart.text.font'];
            var text_size  = prop['chart.text.size'];
            var cx         = this.centerx;
            var cy         = this.centery;
            var r          = this.radius;
    
            /**
            * Turn the shadow off
            */
            RG.NoShadow(this);
            
            co.fillStyle = 'black';
            co.beginPath();
    
            /**
            * Draw the labels
            */
            if (labels && labels.length) {
    
                for (i=0; i<this.angles.length; ++i) {
                
                    var segment = this.angles[i];
                
                    if (typeof(labels[i]) != 'string' && typeof(labels[i]) != 'number') {
                        continue;
                    }
    
                    // Move to the centre
                    co.moveTo(cx,cy);
                    
                    var a = segment[0] + ((segment[1] - segment[0]) / 2);
                    var angle = ((segment[1] - segment[0]) / 2) + segment[0];
    
                    /**
                    * Handle the additional "explosion" offset
                    */
                    if (typeof prop['chart.exploded'] === 'object' && prop['chart.exploded'][i] || typeof(prop['chart.exploded']) == 'number') {
    
                        var t = ((segment[1] - segment[0]) / 2);
                        var seperation = typeof(prop['chart.exploded']) == 'number' ? prop['chart.exploded'] : prop['chart.exploded'][i];
    
                        // Adjust the angles
                        var explosion_offsetx = (Math.cos(angle) * seperation);
                        var explosion_offsety = (Math.sin(angle) * seperation);
                    } else {
                        var explosion_offsetx = 0;
                        var explosion_offsety = 0;
                    }
                    
                    /**
                    * Allow for the label sticks
                    */
                    if (prop['chart.labels.sticks']) {
                        explosion_offsetx += (ma.cos(angle) * (typeof prop['chart.labels.sticks.length'] === 'object' ? prop['chart.labels.sticks.length'][i] : prop['chart.labels.sticks.length']) );
                        explosion_offsety += (ma.sin(angle) * (typeof prop['chart.labels.sticks.length'] === 'object' ? prop['chart.labels.sticks.length'][i] : prop['chart.labels.sticks.length']) );
                    }
    
                    /**
                    * Coords for the text
                    */
                    var x = cx + explosion_offsetx + ((r + 10)* Math.cos(a)) + (prop['chart.labels.sticks'] ? (a < RG.HALFPI || a > (RG.TWOPI + RG.HALFPI) ? 2 : -2) : 0)
                    var y = cy + explosion_offsety + (((r + 10) * Math.sin(a)));




                    /**
                    *  If sticks are enabled use the endpoints that have been saved
                    */
                    if (this.coordsSticks && this.coordsSticks[i]) {
                        var x = this.coordsSticks[i][4][0] + (x < cx ? -5 : 5);
                        var y = this.coordsSticks[i][4][1];
                    }


                    /**
                    * Alignment
                    */
                    //vAlignment = y < cy ? 'center' : 'center';
                    vAlignment = 'center';
                    hAlignment = x < cx ? 'right' : 'left';
    
                    co.fillStyle = prop['chart.text.color'];
                    if (   typeof(prop['chart.labels.colors']) == 'object' && prop['chart.labels.colors'] && prop['chart.labels.colors'][i]) {
                        co.fillStyle = prop['chart.labels.colors'][i];
                    }
    
    
                    RG.Text2(this, {'font':font,
                                        'size':text_size,
                                        'x':x,
                                        'y':y,
                                        'text':labels[i],
                                        'valign':vAlignment,
                                        'halign':hAlignment,
                                        'tag': 'labels'
                                       });
                }
                
                co.fill();
            }
        };




    
        /**
        * This function draws the pie chart sticks (for the labels)
        */
        this.drawSticks =
        this.DrawSticks = function ()
        {
            var context  = co;
            var offset   = prop['chart.linewidth'] / 2;
            var exploded = prop['chart.exploded'];
            var sticks   = prop['chart.labels.sticks'];
            var cx       = this.centerx;
            var cy       = this.centery;
            var radius   = this.radius;
            var points   = [];
    
            for (var i=0,len=this.angles.length; i<len; ++i) {
            
                var segment = this.angles[i];
    
                // This allows the chart.labels.sticks to be an array as well as a boolean
                if (typeof sticks === 'object' && !sticks[i]) {
                    continue;
                }
    
                var radians = segment[1] - segment[0];
    
                co.beginPath();
                co.strokeStyle = prop['chart.labels.sticks.color'];
                co.lineWidth   = 1;
    
                var midpoint = (segment[0] + (radians / 2));
    
                if (typeof exploded === 'object' && exploded[i]) {
                    var extra = exploded[i];
                } else if (typeof exploded === 'number') {
                    var extra = exploded;
                } else {
                    var extra = 0;
                }
    
                //context.lineJoin = 'round';
                co.lineWidth = 1;
                
                /**
                * Determine the stick length
                */
                var stickLength = typeof prop['chart.labels.sticks.length'] === 'object' ? prop['chart.labels.sticks.length'][i] : prop['chart.labels.sticks.length'];
                
                
                points[0] = RG.getRadiusEndPoint(cx, cy, midpoint, radius + extra + offset);
                points[1] = RG.getRadiusEndPoint(cx, cy, midpoint, radius + stickLength + extra - 5);
                
                points[2] = RG.getRadiusEndPoint(cx, cy, midpoint, radius + stickLength + extra);
                
                points[3] = RG.getRadiusEndPoint(cx, cy, midpoint, radius + stickLength + extra);
                points[3][0] += (points[3][0] > cx ? 5 : -5);
                
                points[4] = [
                    points[2][0] + (points[2][0] > cx ? 5 + prop['chart.labels.sticks.hlength'] : -5 - prop['chart.labels.sticks.hlength']),
                    points[2][1]
                ];

                
                co.moveTo(points[0][0], points[0][1]);
                co.quadraticCurveTo(points[2][0], points[2][1], points[4][0], points[4][1]);
    
                co.stroke();
                
                /**
                * Save the stick end coords
                */
                this.coordsSticks[i] = [points[0],points[1], points[2], points[3], points[4]];
            }
        };




        /**
        * The (now Pie chart specific) getSegment function
        * 
        * @param object e The event object
        */
        this.getShape =
        this.getSegment = function (e)
        {
            RG.FixEventObject(e);
    
            // The optional arg provides a way of allowing some accuracy (pixels)
            var accuracy = arguments[1] ? arguments[1] : 0;
    
            var canvas      = ca;
            var context     = co;
            var mouseCoords = RG.getMouseXY(e);
            var mouseX      = mouseCoords[0];
            var mouseY      = mouseCoords[1];
            var r           = this.radius;
            var angles      = this.angles;
            var ret         = [];
    
            for (var i=0,len=angles.length; i<len; ++i) {
    
                // DRAW THE SEGMENT AGAIN SO IT CAN BE TESTED //////////////////////////
                co.beginPath();
                    co.strokeStyle = 'rgba(0,0,0,0)';
                    co.arc(angles[i][2], angles[i][3], this.radius, angles[i][0], angles[i][1], false);
                    
                    if (this.type == 'pie' && prop['chart.variant'] == 'donut') {
                        co.arc(angles[i][2], angles[i][3], (typeof(prop['chart.variant.donut.width']) == 'number' ? this.radius - prop['chart.variant.donut.width'] : this.radius / 2), angles[i][1], angles[i][0], true);
                    } else {
                        co.lineTo(angles[i][2], angles[i][3]);
                    }
                co.closePath();
                    
                if (!co.isPointInPath(mouseX, mouseY)) {
                    continue;
                }
    
                ////////////////////////////////////////////////////////////////////////
    
                ret[0] = angles[i][2];
                ret[1] = angles[i][3];
                ret[2] = this.radius;
                ret[3] = angles[i][0] - RG.TWOPI;
                ret[4] = angles[i][1];
                ret[5] = i;
    
    
                
                if (ret[3] < 0) ret[3] += RG.TWOPI;
                if (ret[4] > RG.TWOPI) ret[4] -= RG.TWOPI;
                
                /**
                * Add the tooltip to the returned shape
                */
                var tooltip = RG.parseTooltipText ? RG.parseTooltipText(prop['chart.tooltips'], ret[5]) : null;
                
                /**
                * Now return textual keys as well as numerics
                */
                ret['object']      = this;
                ret['x']           = ret[0];
                ret['y']           = ret[1];
                ret['radius']      = ret[2];
                ret['angle.start'] = ret[3];
                ret['angle.end']   = ret[4];
                ret['index']       = ret[5];
                ret['tooltip']     = tooltip;
    
                return ret;
            }
            
            return null;
        };




        this.drawBorders =
        this.DrawBorders = function ()
        {
            if (prop['chart.linewidth'] > 0) {
    
                co.lineWidth = prop['chart.linewidth'];
                co.strokeStyle = prop['chart.strokestyle'];
                
                var r = this.radius;
    
                for (var i=0,len=this.angles.length; i<len; ++i) {
                
                    var segment = this.angles[i];

                    co.beginPath();
                        co.arc(segment[2],
                               segment[3],
                               r,
                               (segment[0]),
                               (segment[0] + 0.001),
                               0);
                        co.arc(segment[2],
                               segment[3],
                               prop['chart.variant'] == 'donut' ? (typeof(prop['chart.variant.donut.width']) == 'number' ? this.radius - prop['chart.variant.donut.width'] : r / 2): r,
                               segment[0],
                               segment[0] + 0.0001,
                               0);
                    co.closePath();
                    co.stroke();
                }
            }
        };




        /**
        * Returns the radius of the pie chart
        * 
        * [06-02-2012] Maintained for compatibility ONLY.
        */
        this.getRadius = function ()
        {
            this.graph = {width: ca.width - prop['chart.gutter.left'] - prop['chart.gutter.right'], height: ca.height - prop['chart.gutter.top'] - prop['chart.gutter.bottom']}
    
            if (typeof(prop['chart.radius']) == 'number') {
                this.radius = prop['chart.radius'];
            } else {
                this.radius = Math.min(this.graph.width, this.graph.height) / 2;
            }
    
            return this.radius;
        };




        /**
        * A programmatic explode function
        * 
        * @param object obj   The chart object
        * @param number index The zero-indexed number of the segment
        * @param number size  The size (in pixels) of the explosion
        */
        this.explodeSegment =
        this.Explode = function (index, size)
        {
            //this.Set('chart.exploded', []);
            if (!prop['chart.exploded']) {
                prop['chart.exploded'] = [];
            }
            
            // If chart.exploded is a number - convert it to an array
            if (typeof(prop['chart.exploded']) == 'number') {
    
                var original_explode = prop['chart.exploded'];
                var exploded = prop['chart.exploded'];
    
                prop['chart.exploded'] = [];
                
                for (var i=0,len=this.data.length; i<len; ++i) {
                    prop['chart.exploded'][i] = exploded;
                }
            }
            
            prop['chart.exploded'][index] = typeof(original_explode) == 'number' ? original_explode : 0;
    
            for (var o=0; o<size; ++o) {
    
                setTimeout(
                    function ()
                    {
                        prop['chart.exploded'][index] += 1;
                        RG.Clear(ca);
                        RG.RedrawCanvas(ca);
                    }, o * (RGraph.ISIE &&  !RGraph.ISIE10 ? 25 : 16.666));
            }
        };




        /**
        * This function highlights a segment
        * 
        * @param array segment The segment information that is returned by the pie.getSegment(e) function
        */
        this.highlight_segment = function (segment)
        {
            co.beginPath();
                co.strokeStyle = prop['chart.highlight.style.2d.stroke'];
                co.fillStyle   = prop['chart.highlight.style.2d.fill'];
                co.moveTo(segment[0], segment[1]);
                co.arc(segment[0], segment[1], segment[2], this.angles[segment[5]][0], this.angles[segment[5]][1], 0);
                co.lineTo(segment[0], segment[1]);
            co.closePath();
            
            co.stroke();
            co.fill();
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
                /**
                * 3D style of highlighting
                */
                if (prop['chart.highlight.style'] == '3d') {

                    co.lineWidth = 1;
                    
                    // This is the extent of the 2D effect. Bigger values will give the appearance of a larger "protusion"
                    var extent = 2;
            
                    // Draw a white-out where the segment is
                    co.beginPath();
                        RG.NoShadow(this);
                        co.fillStyle   = 'rgba(0,0,0,0)';
                        co.arc(shape['x'], shape['y'], shape['radius'], shape['angle.start'], shape['angle.end'], false);
                        if (prop['chart.variant'] == 'donut') {
                            co.arc(shape['x'], shape['y'], shape['radius'] / 5, shape['angle.end'], shape['angle.start'], true);
                        } else {
                            co.lineTo(shape['x'], shape['y']);
                        }
                    co.closePath();
                    co.fill();
        
                    // Draw the new segment
                    co.beginPath();
        
                        co.shadowColor   = '#666';
                        co.shadowBlur    = 3;
                        co.shadowOffsetX = 3;
                        co.shadowOffsetY = 3;
        
                        co.fillStyle   = prop['chart.colors'][shape['index']];
                        co.strokeStyle = prop['chart.strokestyle'];
                        co.arc(shape['x'] - extent, shape['y'] - extent, shape['radius'], shape['angle.start'], shape['angle.end'], false);
                        if (prop['chart.variant'] == 'donut') {
                            co.arc(shape['x'] - extent, shape['y'] - extent, shape['radius'] / 2, shape['angle.end'], shape['angle.start'],  true)
                        } else {
                            co.lineTo(shape['x'] - extent, shape['y'] - extent);
                        }
                    co.closePath();
                    
                    co.stroke();
                    co.fill();
                    
                    // Turn off the shadow
                    RG.NoShadow(this);
        
                    /**
                    * If a border is defined, redraw that
                    */
                    if (prop['chart.border']) {
                        co.beginPath();
                        co.strokeStyle = prop['chart.border.color'];
                        co.lineWidth = 5;
                        co.arc(shape['x'] - extent, shape['y'] - extent, shape['radius'] - 2, shape['angle.start'], shape['angle.end'], false);
                        co.stroke();
                    }
        
        
        
        
                // Default 2D style of  highlighting
                } else {

                    co.beginPath();
    
                        co.strokeStyle = prop['chart.highlight.style.2d.stroke'];
                        co.fillStyle   = prop['chart.highlight.style.2d.fill'];
                        
                        if (prop['chart.variant'].indexOf('donut') -1) {
                            co.arc(shape['x'], shape['y'], shape['radius'], shape['angle.start'], shape['angle.end'], false);
                            co.arc(shape['x'], shape['y'], typeof(prop['chart.variant.donut.width']) == 'number' ? this.radius - prop['chart.variant.donut.width'] : shape['radius'] / 2, shape['angle.end'], shape['angle.start'], true);
                        } else {
                            co.arc(shape['x'], shape['y'], shape['radius'] + 1, shape['angle.start'], shape['angle.end'], false);
                            co.lineTo(shape['x'], shape['y']);
                        }
                    co.closePath();
        
                    //co.stroke();
                    co.fill();
                }
            }
        };




        /**
        * The getObjectByXY() worker method. The Pie chart is able to use the
        * getShape() method - so it does.
        */
        this.getObjectByXY = function (e)
        {
            if (this.getShape(e)) {
                return this;
            }
        };




        /**
        * Draws the centerpin if requested
        */
        this.drawCenterpin =
        this.DrawCenterpin = function ()
        {
            if (typeof(prop['chart.centerpin']) == 'number' && prop['chart.centerpin'] > 0) {
            
                var cx = this.centerx;
                var cy = this.centery;
            
                co.beginPath();
                    co.strokeStyle = prop['chart.centerpin.stroke'] ? prop['chart.centerpin.stroke'] : prop['chart.strokestyle'];
                    co.fillStyle = prop['chart.centerpin.fill'] ? prop['chart.centerpin.fill'] : prop['chart.strokestyle'];
                    co.moveTo(cx, cy);
                    co.arc(cx, cy, prop['chart.centerpin'], 0, RG.TWOPI, false);
                co.stroke();
                co.fill();
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
            var coordX      = obj.angles[idx][2];
            var coordY      = obj.angles[idx][3];
            var angleStart  = obj.angles[idx][0];
            var angleEnd    = obj.angles[idx][1];
            var angleCenter = ((angleEnd - angleStart) / 2) + angleStart;
            var canvasXY    = RGraph.getCanvasXY(obj.canvas);
            var gutterLeft  = prop['chart.gutter.left'];
            var gutterTop   = prop['chart.gutter.top'];
            var width       = tooltip.offsetWidth;
            var height      = tooltip.offsetHeight;
            var x           = canvasXY[0] + this.angles[idx][2] + (Math.cos(angleCenter) * (prop['chart.variant'] == 'donut' && typeof(prop['chart.variant.donut.width']) == 'number' ? ((this.radius - prop['chart.variant.donut.width']) + (prop['chart.variant.donut.width'] / 2)) : (this.radius * 0.75)));
            var y           = canvasXY[1] + this.angles[idx][3] + (Math.sin(angleCenter) * (prop['chart.variant'] == 'donut' && typeof(prop['chart.variant.donut.width']) == 'number' ? ((this.radius - prop['chart.variant.donut.width']) + (prop['chart.variant.donut.width'] / 2)) : (this.radius * 0.75)));
    
            
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
            if ((x - (width / 2)) < 10) {
                tooltip.style.left = (x - (width * 0.1)) + 'px';
                tooltip.style.top  = (y - height - 4) + 'px';
                img.style.left = ((width * 0.1) - 8.5) + 'px';
    
            // RIGHT edge
            } else if ((x + (width / 2)) > (doc.body.offsetWidth - 10) ) {
                tooltip.style.left = (x - (width * 0.9)) + 'px';
                tooltip.style.top  = (y - height - 4) + 'px';
                img.style.left = ((width * 0.9) - 8.5) + 'px';
    
            // Default positioning - CENTERED
            } else {
                tooltip.style.left = (x - (width / 2)) + 'px';
                tooltip.style.top  = (y - height - 4) + 'px';
                img.style.left = ((width * 0.5) - 8.5) + 'px';
            }
        };




        /**
        * This draws Ingraph labels
        */
        this.drawInGraphLabels =
        this.DrawInGraphLabels = function ()
        {
            var context = co;
            var cx      = this.centerx;
            var cy      = this.centery;
            var radius  = prop['chart.labels.ingraph.radius'];
            
            //
            // Is the radius less than 2? If so then it's a factor and not n exact point
            //
            if (radius <= 2 && radius > 0) {
                radiusFactor = radius;
            } else {
                radiusFactor = 0.5;
            }

            if (prop['chart.variant'] == 'donut') {
                var r = this.radius * (0.5 + (radiusFactor * 0.5));
                
                if (typeof(prop['chart.variant.donut.width']) == 'number') {
                    var r = (this.radius - prop['chart.variant.donut.width']) + (prop['chart.variant.donut.width'] / 2);
                }
            } else {
                var r = this.radius * radiusFactor;
            }

            if (radius > 2) {
                r = radius;
            }
    
            for (var i=0,len=this.angles.length; i<len; ++i) {
    
                // This handles any explosion that the segment may have
                if (typeof(prop['chart.exploded']) == 'object' && typeof(prop['chart.exploded'][i]) == 'number') {
                    var explosion = prop['chart.exploded'][i];
                } else if (typeof(prop['chart.exploded']) == 'number') {
                    var explosion = parseInt(prop['chart.exploded']);
                } else {
                    var explosion = 0;
                }
    
                var angleStart  = this.angles[i][0];
                var angleEnd    = this.angles[i][1];
                var angleCenter = ((angleEnd - angleStart) / 2) + angleStart;
                var coords      = RG.getRadiusEndPoint(
                    this.centerx,
                    this.centery,
                    angleCenter,
                    r + (explosion ? explosion : 0)
                );

                var x           = coords[0];
                var y           = coords[1];
    
                var text = prop['chart.labels.ingraph.specific'] && typeof(prop['chart.labels.ingraph.specific'][i]) == 'string' ? prop['chart.labels.ingraph.specific'][i] : RG.number_format(this, this.data[i], prop['chart.labels.ingraph.units.pre'] , prop['chart.labels.ingraph.units.post']);
    
                if (text) {
                    co.beginPath();
                        
                        var font = typeof prop['chart.labels.ingraph.font'] === 'string' ? prop['chart.labels.ingraph.font'] : prop['chart.text.font'];
                        var size = typeof prop['chart.labels.ingraph.size'] === 'number' ? prop['chart.labels.ingraph.size'] : prop['chart.text.size'] + 2;
                        
                        //
                        // Set the colors
                        //
                        co.fillStyle = prop['chart.labels.ingraph.color'] ? prop['chart.labels.ingraph.color'] : 'black';
    
                        RG.Text2(this, {
                            'font':font,
                            'size':size,
                            'x':x,
                            'y':y,
                            'text':text,
                            'valign':'center',
                            'halign':'center',
                            'bounding': prop['chart.labels.ingraph.bounding'],
                            'bounding.fill': prop['chart.labels.ingraph.bounding.fill'],
                            'tag':'labels.ingraph'
                        });
                    co.stroke();
                }
            }
        };
        
        
        
        
        //
        // Draws the center label if required
        //
        this.drawCenterLabel = function (label)
        {
            var font      = prop['chart.labels.center.font'],
                size      = prop['chart.labels.center.size'],
                color     = prop['chart.labels.center.color'],
                unitsPre  = prop['chart.labels.center.units.pre'],
                unitsPost = prop['chart.labels.center.units.post'],
                bold      = prop['chart.labels.center.bold'],
                italic    = prop['chart.labels.center.italic'];


            RG.text2(this, {
                color: color,
                bold: bold,
                italic: italic,
                font: font,
                size: size,
                x: this.centerx,
                y: this.centery,
                halign: 'center',
                valign: 'center',
                text: RG.numberFormat(this, label,unitsPre, unitsPost)
            });
        }




        /**
        * This returns the angle for a value based around the maximum number
        * 
        * @param number value The value to get the angle for
        */
        this.getAngle = function (value)
        {
            if (value > this.total) {
                return null;
            }
            
            var angle = (value / this.total) * RG.TWOPI;
    
            // Handle the origin (it can br -HALFPI or 0)
            angle += prop['chart.origin'];
    
            return angle;
        };




        /**
        * This allows for easy specification of gradients
        */
        this.parseColors = function ()
        {
            // Save the original colors so that they can be restored when the canvas is reset
            if (this.original_colors.length === 0) {
                this.original_colors['chart.colors']                  = RG.arrayClone(prop['chart.colors']);
                this.original_colors['chart.key.colors']              = RG.arrayClone(prop['chart.key.colors']);
                this.original_colors['chart.strokestyle']             = RG.arrayClone(prop['chart.strokestyle']);
                this.original_colors['chart.highlight.stroke']        = RG.arrayClone(prop['chart.highlight.stroke']);
                this.original_colors['chart.highlight.style.2d.fill'] = RG.arrayClone(prop['chart.highlight.style.2d.fill']);
                this.original_colors['chart.highlight.style.stroke']  = RG.arrayClone(prop['chart.highlight.style.2d.stroke']);
                this.original_colors['chart.ingraph.bounding.fill']   = RG.arrayClone(prop['chart.ingraph.bounding.fill']);
                this.original_colors['chart.ingraph.color']           = RG.arrayClone(prop['chart.ingraph.color']);
            }

            for (var i=0; i<prop['chart.colors'].length; ++i) {
                prop['chart.colors'][i] = this.parseSingleColorForGradient(prop['chart.colors'][i]);
            }
    
            var keyColors = prop['chart.key.colors'];
            if (keyColors) {
                for (var i=0; i<keyColors.length; ++i) {
                    keyColors[i] = this.parseSingleColorForGradient(keyColors[i]);
                }
            }
    
            prop['chart.strokestyle']                  = this.parseSingleColorForGradient(prop['chart.strokestyle']);
            prop['chart.highlight.stroke']             = this.parseSingleColorForGradient(prop['chart.highlight.stroke']);
            prop['chart.highlight.style.2d.fill']      = this.parseSingleColorForGradient(prop['chart.highlight.style.2d.fill']);
            prop['chart.highlight.style.2d.stroke']    = this.parseSingleColorForGradient(prop['chart.highlight.style.2d.stroke']);
            prop['chart.labels.ingraph.bounding.fill'] = this.parseSingleColorForGradient(prop['chart.labels.ingraph.bounding.fill']);
            prop['chart.labels.ingraph.color']         = this.parseSingleColorForGradient(prop['chart.labels.ingraph.color']);
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
    
                // If the chart is a donut - the first width should half the total radius
                if (prop['chart.variant'] == 'donut') {
                    var radius_start = typeof(prop['chart.variant.donut.width']) == 'number' ? this.radius - prop['chart.variant.donut.width'] : this.radius / 2;
                } else {
                    var radius_start = 0;
                }

                // Create the gradient
                var grad = co.createRadialGradient(this.centerx, this.centery, radius_start, this.centerx, this.centery, Math.min(ca.width - prop['chart.gutter.left'] - prop['chart.gutter.right'], ca.height - prop['chart.gutter.top'] - prop['chart.gutter.bottom']) / 2);
    
    
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
            if (this.angles && this.angles[index]) {

                var segment = this.angles[index];
                var x = segment[2];
                var y = segment[3];
                var start = segment[0];
                var end   = segment[1];
                
                co.strokeStyle = prop['chart.key.interactive.highlight.chart.stroke'];
                co.fillStyle = prop['chart.key.interactive.highlight.chart.fill'];
                co.lineWidth = 2;
                co.lineJoin = 'bevel';
                
                co.beginPath();
                co.moveTo(x, y);
                co.arc(x, y, this.radius, start, end, false);
                co.closePath();
                co.fill();
                co.stroke();
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




        //
        // Draw a 3D Pie/Donut chart
        //
        this.draw3d = function ()
        {
            var scaleX            = 1.5,
                depth             = prop['chart.variant.threed.depth'],
                prop_shadow       = prop['chart.shadow'],
                prop_labels       = prop['chart.labels'],
                prop_labelsSticks = prop['chart.labels.sticks']

            this.set({
                labels: [],
                labelsSticks: false,
                strokestyle: 'rgba(0,0,0,0)'
            });
            
            //
            // Change the variant so that the draw function doesn't keep
            // coming in here
            //
            this.set({
                variant: this.get('variant').replace(/3d/, '')
            });
            
            this.context.setTransform(scaleX, 0, 0, 1, (ca.width * (scaleX) - ca.width) * -0.5, 0);
            
            for (var i=depth; i>0; i-=1) {
                
                this.set({
                    centeryAdjust: i
                });
                
                if (i === parseInt(depth / 2) ) {
                    this.set({
                        labels: prop_labels,
                        labelsSticks: prop_labelsSticks
                    });
                }
                
                if (i === 0) {
                    this.set({
                        shadow: prop_shadow
                    });
                }

                this.draw();

                // Turn off the shadow after the bottom pie/donut has
                // been drawn
                this.set('shadow', false);

                //
                // If on the middle pie/donut turn the labels and sticks off
                //
                if (i <= parseInt(depth / 2) ) {
                    this.set({
                        labels: [],
                        labelsSticks: false
                    });
                }

                //
                // Make what we're drawng darker by going over
                // it in a semi-transparent dark color
                //
                if (i > 1) {
                    if (prop['chart.variant'].indexOf('donut') !== -1) {

                        for (var j=0; j<this.angles.length; ++j) {
                            pa(this.context,[
                                'b',
                                'a', this.angles[j][2], this.angles[j][3], this.radius + 1, this.angles[j][0], this.angles[j][1] * prop['chart.effect.roundrobin.multiplier'], false,
                                'a', this.angles[j][2], this.angles[j][3], this.radius / 2, this.angles[j][1] * prop['chart.effect.roundrobin.multiplier'], this.angles[j][0], true,
                                'f', 'rgba(0,0,0,0.15)'
                            ]);
                        }

                    // Draw the pie chart darkened segments
                    } else {

                        for (var j=0; j<this.angles.length; ++j) {

                            pa(this.context,[
                                'b',
                                'm', this.angles[j][2], this.angles[j][3],
                                'a', this.angles[j][2],
                                     this.angles[j][3],
                                     this.radius + 1,
                                     this.angles[j][0],
                                     this.angles[j][1] * prop['chart.effect.roundrobin.multiplier'],
                                     false,
                                'c',
                                'f', 'rgba(0,0,0,0.15)'
                            ]);
                        }
                    }
                }
            }

            //
            // Reset the variant by adding the 3d back on
            //
            this.set({
                variant: this.get('variant') + '3d',
                shadow: prop_shadow,
                labels: prop_labels,
                labelsSticks: prop_labelsSticks
            });
            
            // Necessary to allow method chaining
            return this;
        };




        /**
        * Pie chart explode
        * 
        * Explodes the Pie chart - gradually incrementing the size of the chart.explode property
        * 
        * @param object     Options for the effect
        * @param function   An optional callback function to call when the animation completes
        */
        this.explode = function ()
        {
            var obj            = this;
            var opt            = arguments[0] ? arguments[0] : {};
            var callback       = arguments[1] ? arguments[1] : function () {};
            var frames         = opt.frames ? opt.frames : 30;
            var frame          = 0;
            var maxExplode     = Number(typeof opt.radius === 'number' ? opt.radius : ma.max(ca.width, ca.height));
            var currentExplode = Number(obj.get('exploded')) || 0;
            var step           = (maxExplode - currentExplode) / frames;

            // chart.exploded
            var iterator = function ()
            {
                obj.set('exploded', currentExplode + (step * frame) );

                RGraph.clear(obj.canvas);
                RGraph.redrawCanvas(obj.canvas);
    
                if (frame++ < frames) {
                    RGraph.Effects.updateCanvas(iterator);
                } else {
                    callback(obj);
                }
            }
            
            iterator();
            
            return this;
        };




        /**
        * Pie chart grow
        * 
        * Gradually increases the pie chart radius
        * 
        * @param object   OPTIONAL An object of options
        * @param function OPTIONAL A callback function
        */
        this.grow = function ()
        {
            var obj      = this;
            var canvas   = obj.canvas;
            var opt      = arguments[0] ? arguments[0] : {};
            var frames   = opt.frames || 30;
            var frame    = 0;
            var callback = arguments[1] ? arguments[1] : function () {};
            var radius   = obj.getRadius();


            prop['chart.radius'] = 0;

            var iterator = function ()
            {
                obj.set('chart.radius', (frame / frames) * radius);
                
                RG.redrawCanvas(ca);
    
                if (frame++ < frames) {
                    RG.Effects.updateCanvas(iterator);
                
                } else {

                    RG.redrawCanvas(obj.canvas);


                    callback(obj);
                }
            };
    
            iterator();
            
            return this;
        };





        /**
        * RoundRobin
        * 
        * This effect does two things:
        *  1. Gradually increases the size of each segment
        *  2. Gradually increases the size of the radius from 0
        * 
        * @param object OPTIONAL Options for the effect
        * @param function OPTIONAL A callback function
        */
        this.roundrobin =
        this.roundRobin = function ()
        {
            var obj      = this;
            var opt      = arguments[0] || {};
            var callback = arguments[1] || function () {};
            var frame    = 0;
            var frames   = opt.frames || 30;
            var radius   =  obj.getRadius();
            
            obj.Set('chart.events', false);

            var iterator = function ()
            {                
                obj.set(
                    'effect.roundrobin.multiplier',
                    RG.Effects.getEasingMultiplier(frames, frame)
                );

                RGraph.redrawCanvas(ca);

                if (frame++ < frames) {
                    RGraph.Effects.updateCanvas(iterator);
                
                } else {
                    
                    // Re-enable the events and redraw the chart.
                    obj.set('events', true);
                    RGraph.redrawCanvas(obj.canvas);

                    callback(obj);
                }
            };
    
            iterator();
            
            return this;
        };
        
        
        
        
        RG.att(ca);









        /**
        * Pie chart implode
        * 
        * Implodes the Pie chart - gradually decreasing the size of the chart.explode property. It starts at the largest of
        * the canvas width./height
        * 
        * @param object     Optional options for the effect. You can pass in frames here - such as:
        *                   myPie.implode({frames: 60}; function () {alert('Done!');})
        * @param function   A callback function which is called when the effect is finished
        */
        this.implode = function ()
        {
            var obj         = this,
                opt         = arguments[0] || {},
                callback    = arguments[1] || function (){},
                frames      = opt.frames || 30,
                frame       = 0,
                explodedMax = ma.max(ca.width, ca.height),
                exploded    = explodedMax;
    
    
    
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
        * Now need to register all chart types. MUST be after the setters/getters are defined
        */
        RG.register(this);




        /**
        * This is the 'end' of the constructor so if the first argument
        * contains configuration data - handle that.
        */
        if (parseConfObjectForOptions) {
            RG.parseObjectStyleConfig(this, conf.options);
        }
    };