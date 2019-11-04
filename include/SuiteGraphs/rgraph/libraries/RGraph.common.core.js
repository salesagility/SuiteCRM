// version: 2015-11-02
    /**
    * o--------------------------------------------------------------------------------o
    * | This file is part of the RGraph package - you can learn more at:               |
    * |                                                                                |
    * |                          http://www.rgraph.net                                 |
    * |                                                                                |
    * | RGraph is dual licensed under the Open Source GPL (General Public License)     |
    * | v2.0 license and a commercial license which means that you're not bound by     |
    * | the terms of the GPL. The commercial license is just �99 (GBP) and you can     |
    * | read about it here:                                                            |
    * |                      http://www.rgraph.net/license                             |
    * o--------------------------------------------------------------------------------o
    */

    RGraph = window.RGraph || {isRGraph: true};

// Module pattern
(function (win, doc, undefined)
{
    var RG  = RGraph,
        ua  = navigator.userAgent,
        ma  = Math;




    /**
    * Initialise the various objects
    */
    RG.Highlight      = {};
    RG.Registry       = {};
    RG.Registry.store = [];
    RG.Registry.store['chart.event.handlers']       = [];
    RG.Registry.store['__rgraph_event_listeners__'] = []; // Used in the new system for tooltips
    RG.Background     = {};
    RG.background     = {};
    RG.objects        = [];
    RG.Resizing       = {};
    RG.events         = [];
    RG.cursor         = [];
    RG.Effects        = RG.Effects || {};
    RG.cache          = [];

    RG.ObjectRegistry                    = {};
    RG.ObjectRegistry.objects            = {};
    RG.ObjectRegistry.objects.byUID      = [];
    RG.ObjectRegistry.objects.byCanvasID = [];




    /**
    * Some "constants". The ua variable is navigator.userAgent (definedabove)
    */
    RG.PI       = ma.PI;
    RG.HALFPI   = RG.PI / 2;
    RG.TWOPI    = RG.PI * 2;

    RG.ISFF     = ua.indexOf('Firefox') != -1;
    RG.ISOPERA  = ua.indexOf('Opera') != -1;
    RG.ISCHROME = ua.indexOf('Chrome') != -1;
    RG.ISSAFARI = ua.indexOf('Safari') != -1 && !RG.ISCHROME;
    RG.ISWEBKIT = ua.indexOf('WebKit') != -1;

    RG.ISIE   = ua.indexOf('Trident') > 0 || navigator.userAgent.indexOf('MSIE') > 0;
    RG.ISIE6  = ua.indexOf('MSIE 6') > 0;
    RG.ISIE7  = ua.indexOf('MSIE 7') > 0;
    RG.ISIE8  = ua.indexOf('MSIE 8') > 0;
    RG.ISIE9  = ua.indexOf('MSIE 9') > 0;
    RG.ISIE10 = ua.indexOf('MSIE 10') > 0;
    RG.ISOLD  = RGraph.ISIE6 || RGraph.ISIE7 || RGraph.ISIE8; // MUST be here
    
    RG.ISIE11UP = ua.indexOf('MSIE') == -1 && ua.indexOf('Trident') > 0;
    RG.ISIE10UP = RG.ISIE10 || RG.ISIE11UP;
    RG.ISIE9UP  = RG.ISIE9 || RG.ISIE10UP;




    /**
    * Returns five values which are used as a nice scale
    * 
    * @param  max int    The maximum value of the graph
    * @param  obj object The graph object
    * @return     array   An appropriate scale
    */
    RG.getScale = function (max, obj)
    {
        /**
        * Special case for 0
        */
        if (max == 0) {
            return ['0.2', '0.4', '0.6', '0.8', '1.0'];
        }

        var original_max = max;

        /**
        * Manually do decimals
        */
        if (max <= 1) {
            if (max > 0.5) {
                return [0.2,0.4,0.6,0.8, Number(1).toFixed(1)];

            } else if (max >= 0.1) {
                return obj.Get('chart.scale.round') ? [0.2,0.4,0.6,0.8,1] : [0.1,0.2,0.3,0.4,0.5];

            } else {

                var tmp = max;
                var exp = 0;

                while (tmp < 1.01) {
                    exp += 1;
                    tmp *= 10;
                }

                var ret = ['2e-' + exp, '4e-' + exp, '6e-' + exp, '8e-' + exp, '10e-' + exp];


                if (max <= ('5e-' + exp)) {
                    ret = ['1e-' + exp, '2e-' + exp, '3e-' + exp, '4e-' + exp, '5e-' + exp];
                }

                return ret;
            }
        }

        // Take off any decimals
        if (String(max).indexOf('.') > 0) {
            max = String(max).replace(/\.\d+$/, '');
        }

        var interval = ma.pow(10, Number(String(Number(max)).length - 1));
        var topValue = interval;

        while (topValue < max) {
            topValue += (interval / 2);
        }

        // Handles cases where the max is (for example) 50.5
        if (Number(original_max) > Number(topValue)) {
            topValue += (interval / 2);
        }

        // Custom if the max is greater than 5 and less than 10
        if (max < 10) {
            topValue = (Number(original_max) <= 5 ? 5 : 10);
        }
        
        /**
        * Added 02/11/2010 to create "nicer" scales
        */
        if (obj && typeof(obj.Get('chart.scale.round')) == 'boolean' && obj.Get('chart.scale.round')) {
            topValue = 10 * interval;
        }

        return [topValue * 0.2, topValue * 0.4, topValue * 0.6, topValue * 0.8, topValue];
    };




    /**
    * Returns an appropriate scale. The return value is actualy an object consisting of:
    *  scale.max
    *  scale.min
    *  scale.scale
    * 
    * @param  obj object  The graph object
    * @param  prop object An object consisting of configuration properties
    * @return     object  An object containg scale information
    */
    RG.getScale2 = function (obj, opt)
    {
        var ca   = obj.canvas,
            co   = obj.context,
            prop = obj.properties,
            numlabels    = typeof opt['ylabels.count'] == 'number' ? opt['ylabels.count'] : 5,
            units_pre    = typeof opt['units.pre'] == 'string' ? opt['units.pre'] : '',
            units_post   = typeof opt['units.post'] == 'string' ? opt['units.post'] : '',
            max          = Number(opt['max']),
            min          = typeof opt['min'] == 'number' ? opt['min'] : 0,
            strict       = opt['strict'],
            decimals     = Number(opt['scale.decimals']), // Sometimes the default is null
            point        = opt['scale.point'], // Default is a string in all chart libraries so no need to cast it
            thousand     = opt['scale.thousand'], // Default is a string in all chart libraries so no need to cast it
            original_max = max,
            round        = opt['scale.round'],
            scale        = {'max':1,'labels':[]}



        /**
        * Special case for 0
        * 
        * ** Must be first **
        */
        if (!max) {

            var max   = 1;

            var scale = {max:1,min:0,labels:[]};

            for (var i=0; i<numlabels; ++i) {
                var label = ((((max - min) / numlabels) + min) * (i + 1)).toFixed(decimals);
                scale.labels.push(units_pre + label + units_post);
            }

        /**
        * Manually do decimals
        */
        } else if (max <= 1 && !strict) {

            if (max > 0.5) {

                max  = 1;
                min  = min;
                scale.min = min;

                for (var i=0; i<numlabels; ++i) {
                    var label = ((((max - min) / numlabels) * (i + 1)) + min).toFixed(decimals);

                    scale.labels.push(units_pre + label + units_post);
                }

            } else if (max >= 0.1) {
                
                max   = 0.5;
                min   = min;
                scale = {'max': 0.5, 'min':min,'labels':[]}

                for (var i=0; i<numlabels; ++i) {
                    var label = ((((max - min) / numlabels) + min) * (i + 1)).toFixed(decimals);
                    scale.labels.push(units_pre + label + units_post);
                }

            } else {

                scale = {'min':min,'labels':[]}
                var max_str = String(max);

                if (max_str.indexOf('e') > 0) {
                    var numdecimals = ma.abs(max_str.substring(max_str.indexOf('e') + 1));
                } else {
                    var numdecimals = String(max).length - 2;
                }

                var max = 1  / ma.pow(10,numdecimals - 1);

                for (var i=0; i<numlabels; ++i) {
                    var label = ((((max - min) / numlabels) + min) * (i + 1));
                    label     = label.toExponential();
                    label     = label.split(/e/);
                    label[0]  = ma.round(label[0]);
                    label     = label.join('e');
                    
                    scale.labels.push(label);
                }

                //This makes the top scale value of the format 10e-2 instead of 1e-1
                tmp = scale.labels[scale.labels.length - 1].split(/e/);
                tmp[0] += 0;
                tmp[1] = Number(tmp[1]) - 1;
                tmp = tmp[0] + 'e' + tmp[1];
                scale.labels[scale.labels.length - 1] = tmp;
                
                // Add the units
                for (var i=0; i<scale.labels.length ; ++i) {
                    scale.labels[i] = units_pre + scale.labels[i] + units_post;
                }
                
                scale.max = Number(max);
            }


        } else if (!strict) {

            /**
            * Now comes the scale handling for integer values
            */


            // This accomodates decimals by rounding the max up to the next integer
            max = ma.ceil(max);

            var interval = ma.pow(10, ma.max(1, Number(String(Number(max) - Number(min)).length - 1)) );

            var topValue = interval;

            while (topValue < max) {
                topValue += (interval / 2);
            }

            // Handles cases where the max is (for example) 50.5
            if (Number(original_max) > Number(topValue)) {
                topValue += (interval / 2);
            }

            // Custom if the max is greater than 5 and less than 10
            if (max <= 10) {
                topValue = (Number(original_max) <= 5 ? 5 : 10);
            }
    
    
            // Added 02/11/2010 to create "nicer" scales
            if (obj && typeof(round) == 'boolean' && round) {
                topValue = 10 * interval;
            }

            scale.max = topValue;

            // Now generate the scale. Temporarily set the objects chart.scale.decimal and chart.scale.point to those
            //that we've been given as the number_format functuion looks at those instead of using argumrnts.
            var tmp_point    = prop['chart.scale.point'];
            var tmp_thousand = prop['chart.scale.thousand'];

            obj.Set('chart.scale.thousand', thousand);
            obj.Set('chart.scale.point', point);


            for (var i=0; i<numlabels; ++i) {
                scale.labels.push( RG.number_format(obj, ((((i+1) / numlabels) * (topValue - min)) + min).toFixed(decimals), units_pre, units_post) );
            }

            obj.Set('chart.scale.thousand', tmp_thousand);
            obj.Set('chart.scale.point', tmp_point);
        
        } else if (typeof(max) == 'number' && strict) {

            /**
            * ymax is set and also strict
            */
            for (var i=0; i<numlabels; ++i) {
                scale.labels.push( RG.number_format(obj, ((((i+1) / numlabels) * (max - min)) + min).toFixed(decimals), units_pre, units_post) );
            }
            
            // ???
            scale.max = max;
        }

        
        scale.units_pre  = units_pre;
        scale.units_post = units_post;
        scale.point      = point;
        scale.decimals   = decimals;
        scale.thousand   = thousand;
        scale.numlabels  = numlabels;
        scale.round      = Boolean(round);
        scale.min        = min;


        return scale;
    };




    /**
    * Makes a clone of an object
    * 
    * @param obj val The object to clone
    */
    RG.arrayClone =
    RG.array_clone = function (obj)
    {
        if(obj === null || typeof obj !== 'object') {
            return obj;
        }

        var temp = [];

        for (var i=0,len=obj.length;i<len; ++i) {

            if (typeof obj[i]  === 'number') {
                temp[i] = (function (arg) {return Number(arg);})(obj[i]);
            
            } else if (typeof obj[i]  === 'string') {
                temp[i] = (function (arg) {return String(arg);})(obj[i]);
            
            } else if (typeof obj[i] === 'function') {
                temp[i] = obj[i];
            
            } else {
                temp[i] = RG.array_clone(obj[i]);
            }
        }

        return temp;
    };




    /**
    * Returns the maximum numeric value which is in an array
    * 
    * @param  array arr The array (can also be a number, in which case it's returned as-is)
    * @param  int       Whether to ignore signs (ie negative/positive)
    * @return int       The maximum value in the array
    */
    RG.arrayMax =
    RG.array_max = function (arr)
    {
        var max = null,
            ma  = Math
        
        if (typeof arr === 'number') {
            return arr;
        }
        
        if (RG.isNull(arr)) {
            return 0;
        }

        for (var i=0,len=arr.length; i<len; ++i) {
            if (typeof arr[i] === 'number') {

                var val = arguments[1] ? ma.abs(arr[i]) : arr[i];
                
                if (typeof max === 'number') {
                    max = ma.max(max, val);
                } else {
                    max = val;
                }
            }
        }

        return max;
    };




    /**
    * Returns the minimum numeric value which is in an array
    * 
    * @param  array arr The array (can also be a number, in which case it's returned as-is)
    * @param  int       Whether to ignore signs (ie negative/positive)
    * @return int       The minimum value in the array
    */
    RG.arrayMin = function (arr)
    {
        var max = null,
            ma  = Math;
        
        if (typeof arr === 'number') {
            return arr;
        }
        
        if (RG.isNull(arr)) {
            return 0;
        }

        for (var i=0,len=arr.length; i<len; ++i) {
            if (typeof arr[i] === 'number') {

                var val = arguments[1] ? ma.abs(arr[i]) : arr[i];
                
                if (typeof min === 'number') {
                    min = ma.min(min, val);
                } else {
                    min = val;
                }
            }
        }

        return min;
    };




    /**
    * Returns the maximum value which is in an array
    * 
    * @param  array arr The array
    * @param  int   len The length to pad the array to
    * @param  mixed     The value to use to pad the array (optional)
    */
    RG.arrayPad =
    RG.array_pad = function (arr, len)
    {
        if (arr.length < len) {
            var val = arguments[2] ? arguments[2] : null;
            
            for (var i=arr.length; i<len; i+=1) {
                arr[i] = val;
            }
        }
        
        return arr;
    };




    /**
    * An array sum function
    * 
    * @param  array arr The  array to calculate the total of
    * @return int       The summed total of the arrays elements
    */
    RG.arraySum =
    RG.array_sum = function (arr)
    {
        // Allow integers
        if (typeof arr === 'number') {
            return arr;
        }
        
        // Account for null
        if (RG.is_null(arr)) {
            return 0;
        }

        var i, sum, len = arr.length;

        for(i=0,sum=0;i<len;sum+=arr[i++]);

        return sum;
    };




    /**
    * Takes any number of arguments and adds them to one big linear array
    * which is then returned
    * 
    * @param ... mixed The data to linearise. You can strings, booleans, numbers or arrays
    */
    RG.arrayLinearize =
    RG.array_linearize = function ()
    {
        var arr  = [],
            args = arguments

        for (var i=0,len=args.length; i<len; ++i) {

            if (typeof args[i] === 'object' && args[i]) {
                for (var j=0,len2=args[i].length; j<len2; ++j) {
                    var sub = RG.array_linearize(args[i][j]);
                    
                    for (var k=0,len3=sub.length; k<len3; ++k) {
                        arr.push(sub[k]);
                    }
                }
            } else {
                arr.push(args[i]);
            }
        }

        return arr;
    };




    /**
    * Takes one off the front of the given array and returns the new array.
    * 
    * @param array arr The array from which to take one off the front of array 
    * 
    * @return array The new array
    */
    RG.arrayShift =
    RG.array_shift = function(arr)
    {
        var ret = [];
        
        for(var i=1,len=arr.length; i<len; ++i) {
            ret.push(arr[i]);
        }
        
        return ret;
    };




    /**
    * Reverses the order of an array
    * 
    * @param array arr The array to reverse
    */
    RG.arrayReverse =
    RG.array_reverse = function (arr)
    {
        var newarr=[];
        
        for(var i=arr.length - 1; i>=0; i-=1) {
            newarr.push(arr[i]);
        }
        
        return newarr;
    };




    /**
    * Clears the canvas by setting the width. You can specify a colour if you wish.
    * 
    * @param object canvas The canvas to clear
    * @param mixed         Usually a color string to use to clear the canvas
    *                      with - could also be a gradient object
    */
    RG.clear =
    RG.Clear = function (ca)
    {
        var obj   = ca.__object__,
            co    = ca.getContext('2d'),
            color = arguments[1] || (obj && obj.get('clearto'))

        if (!ca) {
            return;
        }
        
        RG.FireCustomEvent(obj, 'onbeforeclear');

        if (RG.ISIE8 && !color) {
            color = 'white';
        }

        /**
        * Can now clear the canvas back to fully transparent
        */
        if (!color || (color && color === 'rgba(0,0,0,0)' || color === 'transparent')) {

            co.clearRect(0,0,ca.width, ca.height);
            
            // Reset the globalCompositeOperation
            co.globalCompositeOperation = 'source-over';

        } else {

            co.fillStyle = color;
            co.beginPath();

            if (RG.ISIE8) {
                co.fillRect(0,0,ca.width,ca.height);
            } else {
                co.fillRect(-10,-10,ca.width + 20,ca.height + 20);
            }

            co.fill();
        }
        
        //if (RG.ClearAnnotations) {
            //RG.ClearAnnotations(ca.id);
        //}
        
        /**
        * This removes any background image that may be present
        */
        if (RG.Registry.Get('chart.background.image.' + ca.id)) {
            var img = RG.Registry.Get('chart.background.image.' + ca.id);
            img.style.position = 'absolute';
            img.style.left     = '-10000px';
            img.style.top      = '-10000px';
        }
        
        /**
        * This hides the tooltip that is showing IF it has the same canvas ID as
        * that which is being cleared
        */
        if (RG.Registry.Get('chart.tooltip') && obj.get('chart.tooltips.nohideonclear') !== true) {
            RG.HideTooltip(ca);
            //RG.Redraw();
        }



        //
        // Hide all DOM text by positioning it outside the canvas
        //
        //for (i in RG.cache) {
        //    if (typeof i === 'string' && i.indexOf('-text-') > 0) {
        //        RG.cache[i].style.left = '-100px';
        //        RG.cache[i].style.top  = '-100px';
        //    }
        //}

        /**
        * Set the cursor to default
        */
        ca.style.cursor = 'default';

        RG.FireCustomEvent(obj, 'onclear');
    };




    /**
    * Draws the title of the graph
    * 
    * @param object  canvas The canvas object
    * @param string  text   The title to write
    * @param integer gutter The size of the gutter
    * @param integer        The center X point (optional - if not given it will be generated from the canvas width)
    * @param integer        Size of the text. If not given it will be 14
    * @param object         An optional object which has canvas and context properties to use instead of those on
    *                       the obj argument (so as to enable caching)
    */
    RG.drawTitle =
    RG.DrawTitle = function (obj, text, gutterTop)
    {
        var ca = canvas  = obj.canvas,
            co = context = obj.context,
            prop         = obj.properties,
            gutterLeft   = prop['chart.gutter.left'],
            gutterRight  = prop['chart.gutter.right'],
            gutterTop    = gutterTop,
            gutterBottom = prop['chart.gutter.bottom'],
            size         = arguments[4] ? arguments[4] : 12,
            bold         = prop['chart.title.bold'],
            centerx      = (arguments[3] ? arguments[3] : ((ca.width - gutterLeft - gutterRight) / 2) + gutterLeft),
            keypos       = prop['chart.key.position'],
            vpos         = prop['chart.title.vpos'],
            hpos         = prop['chart.title.hpos'],
            bgcolor      = prop['chart.title.background'],
            x            = prop['chart.title.x'],
            y            = prop['chart.title.y'],
            halign       = 'center',
            valign       = 'center'

        // Account for 3D effect by faking the key position
        if (obj.type == 'bar' && prop['chart.variant'] == '3d') {
            keypos = 'gutter';
        }

        co.beginPath();
        co.fillStyle = prop['chart.text.color'] ? prop['chart.text.color'] : 'black';





        /**
        * Vertically center the text if the key is not present
        */
        if (keypos && keypos != 'gutter') {
            var valign = 'center';

        } else if (!keypos) {
            var valign = 'center';

       } else {
            var valign = 'bottom';
        }





        // if chart.title.vpos is a number, use that
        if (typeof prop['chart.title.vpos'] === 'number') {
            vpos = prop['chart.title.vpos'] * gutterTop;

            if (prop['chart.xaxispos'] === 'top') {
                vpos = prop['chart.title.vpos'] * gutterBottom + gutterTop + (ca.height - gutterTop - gutterBottom);
            }

        } else {
            vpos = gutterTop - size - 5;

            if (prop['chart.xaxispos'] === 'top') {
                vpos = ca.height  - gutterBottom + size + 5;
            }
        }




        // if chart.title.hpos is a number, use that. It's multiplied with the (entire) canvas width
        if (typeof hpos === 'number') {
            centerx = hpos * ca.width;
        }

        /**
        * Now the chart.title.x and chart.title.y settings override (is set) the above
        */
        if (typeof x === 'number') centerx = x;
        if (typeof y === 'number') vpos    = y;




        /**
        * Horizontal alignment can now (Jan 2013) be specified
        */
        if (typeof prop['chart.title.halign'] === 'string') {
            halign = prop['chart.title.halign'];
        }
        
        /**
        * Vertical alignment can now (Jan 2013) be specified
        */
        if (typeof prop['chart.title.valign'] === 'string') {
            valign = prop['chart.title.valign'];
        }




        
        // Set the colour
        if (typeof prop['chart.title.color'] !== null) {
            var oldColor = co.fillStyle
            var newColor = prop['chart.title.color'];
            co.fillStyle = newColor ? newColor : 'black';
        }




        /**
        * Default font is Arial
        */
        var font = prop['chart.text.font'];




        /**
        * Override the default font with chart.title.font
        */
        if (typeof prop['chart.title.font'] === 'string') {
            font = prop['chart.title.font'];
        }




        /**
        * Draw the title
        */
        RG.Text2(co, {
            'font':font,
            'size':size,
            'x':centerx,
            'y':vpos,
            'text':text,
            'valign':valign,
            'halign':halign,
            'bounding':bgcolor != null,
            'bounding.fill':bgcolor,
            'bold':bold,
            'tag':'title'
        });

        // Reset the fill colour
        co.fillStyle = oldColor;
    };




    /**
    * Gets the mouse X/Y coordinates relative to the canvas
    * 
    * @param object e The event object. As such this method should be used in an event listener.
    */
    RG.getMouseXY = function(e)
    {
        var el      = e.target;
        var ca      = el;
        var caStyle = ca.style;
        var offsetX = 0;
        var offsetY = 0;
        var x;
        var y;
        var ISFIXED     = (ca.style.position == 'fixed');
        var borderLeft  = parseInt(caStyle.borderLeftWidth) || 0;
        var borderTop   = parseInt(caStyle.borderTopWidth) || 0;
        var paddingLeft = parseInt(caStyle.paddingLeft) || 0
        var paddingTop  = parseInt(caStyle.paddingTop) || 0
        var additionalX = borderLeft + paddingLeft;
        var additionalY = borderTop + paddingTop;


        if (typeof e.offsetX === 'number' && typeof e.offsetY === 'number') {

            if (ISFIXED) {
                if (RG.ISOPERA) {
                    x = e.offsetX;
                    y = e.offsetY;
                
                } else if (RG.ISWEBKIT) {
                    x = e.offsetX - paddingLeft - borderLeft;
                    y = e.offsetY - paddingTop - borderTop;
                
                } else if (RG.ISIE) {
                    x = e.offsetX - paddingLeft;
                    y = e.offsetY - paddingTop;
    
                } else {
                    x = e.offsetX;
                    y = e.offsetY;
                }
    
    
    
    
            } else {
    
    
    
    
                if (!RG.ISIE && !RG.ISOPERA) {
                    x = e.offsetX - borderLeft - paddingLeft;
                    y = e.offsetY - borderTop - paddingTop;
                
                } else if (RG.ISIE) {
                    x = e.      offsetX - paddingLeft;
                    y = e.offsetY - paddingTop;
                
                } else {
                    x = e.offsetX;
                    y = e.offsetY;
                }
            }   

        } else {

            if (typeof el.offsetParent !== 'undefined') {
                do {
                    offsetX += el.offsetLeft;
                    offsetY += el.offsetTop;
                } while ((el = el.offsetParent));
            }

            x = e.pageX - offsetX - additionalX;
            y = e.pageY - offsetY - additionalY;

            x -= (2 * (parseInt(document.body.style.borderLeftWidth) || 0));
            y -= (2 * (parseInt(document.body.style.borderTopWidth) || 0));

            //x += (parseInt(caStyle.borderLeftWidth) || 0);
            //y += (parseInt(caStyle.borderTopWidth) || 0);
        }

        // We return a javascript array with x and y defined
        return [x, y];
    };




    /**
    * This function returns a two element array of the canvas x/y position in
    * relation to the page
    * 
    * @param object canvas
    */
    RG.getCanvasXY = function (canvas)
    {
        var x  = 0;
        var y  = 0;
        var el = canvas; // !!!

        do {

            x += el.offsetLeft;
            y += el.offsetTop;
            
            // ACCOUNT FOR TABLES IN wEBkIT
            if (el.tagName.toLowerCase() == 'table' && (RG.ISCHROME || RG.ISSAFARI)) {
                x += parseInt(el.border) || 0;
                y += parseInt(el.border) || 0;
            }

            el = el.offsetParent;

        } while (el && el.tagName.toLowerCase() != 'body');


        var paddingLeft = canvas.style.paddingLeft ? parseInt(canvas.style.paddingLeft) : 0;
        var paddingTop  = canvas.style.paddingTop ? parseInt(canvas.style.paddingTop) : 0;
        var borderLeft  = canvas.style.borderLeftWidth ? parseInt(canvas.style.borderLeftWidth) : 0;
        var borderTop   = canvas.style.borderTopWidth  ? parseInt(canvas.style.borderTopWidth) : 0;

        if (navigator.userAgent.indexOf('Firefox') > 0) {
            x += parseInt(document.body.style.borderLeftWidth) || 0;
            y += parseInt(document.body.style.borderTopWidth) || 0;
        }

        return [x + paddingLeft + borderLeft, y + paddingTop + borderTop];
    };




    /**
    * This function determines whther a canvas is fixed (CSS positioning) or not. If not it returns
    * false. If it is then the element that is fixed is returned (it may be a parent of the canvas).
    * 
    * @return Either false or the fixed positioned element
    */
    RG.isFixed = function (canvas)
    {
        var obj = canvas;
        var i = 0;

        while (obj && obj.tagName.toLowerCase() != 'body' && i < 99) {

            if (obj.style.position == 'fixed') {
                return obj;
            }
            
            obj = obj.offsetParent;
        }

        return false;
    };




    /**
    * Registers a graph object (used when the canvas is redrawn)
    * 
    * @param object obj The object to be registered
    */
    RG.register =
    RG.Register = function (obj)
    {
        // Checking this property ensures the object is only registered once
        if (!obj.Get('chart.noregister')) {
            // As of 21st/1/2012 the object registry is now used
            RGraph.ObjectRegistry.Add(obj);
            obj.Set('chart.noregister', true);
        }
    };




    /**
    * Causes all registered objects to be redrawn
    * 
    * @param string An optional color to use to clear the canvas
    */
    RG.redraw =
    RG.Redraw = function ()
    {
        var objectRegistry = RGraph.ObjectRegistry.objects.byCanvasID;

        // Get all of the canvas tags on the page
        var tags = document.getElementsByTagName('canvas');

        for (var i=0,len=tags.length; i<len; ++i) {
            if (tags[i].__object__ && tags[i].__object__.isRGraph) {
                
                // Only clear the canvas if it's not Trace'ing - this applies to the Line/Scatter Trace effects
                if (!tags[i].noclear) {
                    RGraph.clear(tags[i], arguments[0] ? arguments[0] : null);
                }
            }
        }

        // Go through the object registry and redraw *all* of the canvas'es that have been registered
        for (var i=0,len=objectRegistry.length; i<len; ++i) {
            if (objectRegistry[i]) {
                var id = objectRegistry[i][0];
                objectRegistry[i][1].Draw();
            }
        }
    };




    /**
    * Causes all registered objects ON THE GIVEN CANVAS to be redrawn
    * 
    * @param canvas object The canvas object to redraw
    * @param        bool   Optional boolean which defaults to true and determines whether to clear the canvas
    */
    RG.redrawCanvas =
    RG.RedrawCanvas = function (ca)
    {
        var objects = RG.ObjectRegistry.getObjectsByCanvasID(ca.id);

        /**
        * First clear the canvas
        */
        if (!arguments[1] || (typeof arguments[1] === 'boolean' && !arguments[1] == false) ) {
            var color = arguments[2] || ca.__object__.get('clearto') || 'transparent';
            RG.clear(ca, color);
        }

        /**
        * Now redraw all the charts associated with that canvas
        */
        for (var i=0,len=objects.length; i<len; ++i) {
            if (objects[i]) {
                if (objects[i] && objects[i].isRGraph) { // Is it an RGraph object ??
                    objects[i].Draw();
                }
            }
        }
    };




    /**
    * This function draws the background for the bar chart, line chart and scatter chart.
    * 
    * @param  object obj The graph object
    */
    RG.Background.draw =
    RG.background.draw =
    RG.background.Draw = function (obj)
    {
        var func = function (obj, canvas, context)
        {
            var ca   = canvas,
                co   = context,
                prop = obj.properties,

                height       = 0,
                gutterLeft   = obj.gutterLeft,
                gutterRight  = obj.gutterRight,
                gutterTop    = obj.gutterTop,
                gutterBottom = obj.gutterBottom,
                variant      = prop['chart.variant']
            
            co.fillStyle = prop['chart.text.color'];
            
            // If it's a bar and 3D variant, translate
            if (variant == '3d') {
                co.save();
                co.translate(prop['chart.variant.threed.offsetx'], -1 * prop['chart.variant.threed.offsety']);
            }
    
            // X axis title
            if (typeof prop['chart.title.xaxis'] === 'string' && prop['chart.title.xaxis'].length) {
            
                var size = prop['chart.text.size'] + 2;
                var font = prop['chart.text.font'];
                var bold = prop['chart.title.xaxis.bold'];
    
                if (typeof(prop['chart.title.xaxis.size']) == 'number') {
                    size = prop['chart.title.xaxis.size'];
                }
    
                if (typeof(prop['chart.title.xaxis.font']) == 'string') {
                    font = prop['chart.title.xaxis.font'];
                }
                
                var hpos = ((ca.width - gutterLeft - gutterRight) / 2) + gutterLeft;
                var vpos = ca.height - gutterBottom + 25;
                
                if (typeof prop['chart.title.xaxis.pos'] === 'number') {
                    vpos = ca.height - (gutterBottom * prop['chart.title.xaxis.pos']);
                }
    
    
    
    
                // Specifically specified X/Y positions
                if (typeof prop['chart.title.xaxis.x'] === 'number') {
                    hpos = prop['chart.title.xaxis.x'];
                }
    
                if (typeof prop['chart.title.xaxis.y'] === 'number') {
                    vpos = prop['chart.title.xaxis.y'];
                }
    
    
    
    
                RG.Text2(co,  {
					'font':font,
					'size':size,
					'x':hpos,
					'y':vpos,
					'text':prop['chart.title.xaxis'],
					'halign':'center',
					'valign':'center',
					'bold':bold,
					'tag': 'title xaxis'
				});
            }
    
            // Y axis title
            if (typeof(prop['chart.title.yaxis']) == 'string' && prop['chart.title.yaxis'].length) {
    
                var size  = prop['chart.text.size'] + 2;
                var font  = prop['chart.text.font'];
                var angle = 270;
                var bold  = prop['chart.title.yaxis.bold'];
                var color = prop['chart.title.yaxis.color'];
    
                if (typeof(prop['chart.title.yaxis.pos']) == 'number') {
                    var yaxis_title_pos = prop['chart.title.yaxis.pos'] * gutterLeft;
                } else {
                    var yaxis_title_pos = ((gutterLeft - 25) / gutterLeft) * gutterLeft;
                }
    
                if (typeof prop['chart.title.yaxis.size'] === 'number') {
                    size = prop['chart.title.yaxis.size'];
                }
    
                if (typeof prop['chart.title.yaxis.font'] === 'string') {
                    font = prop['chart.title.yaxis.font'];
                }
    
                if (   prop['chart.title.yaxis.align'] == 'right'
                    || prop['chart.title.yaxis.position'] == 'right'
                    || (obj.type === 'hbar' && prop['chart.yaxispos'] === 'right' && typeof prop['chart.title.yaxis.align'] === 'undefined' && typeof prop['chart.title.yaxis.position'] === 'undefined')
                   ) {
    
                    angle = 90;
                    yaxis_title_pos = prop['chart.title.yaxis.pos'] ? (ca.width - gutterRight) + (prop['chart.title.yaxis.pos'] * gutterRight) :
                                                                       ca.width - gutterRight + prop['chart.text.size'] + 5;
                } else {
                    yaxis_title_pos = yaxis_title_pos;
                }
                
                var y = ((ca.height - gutterTop - gutterBottom) / 2) + gutterTop;
                
                // Specifically specified X/Y positions
                if (typeof prop['chart.title.yaxis.x'] === 'number') {
                    yaxis_title_pos = prop['chart.title.yaxis.x'];
                }
    
                if (typeof prop['chart.title.yaxis.y'] === 'number') {
                    y = prop['chart.title.yaxis.y'];
                }
    
                co.fillStyle = color;
                RG.text2(co,  {
					'font':font,
					'size':size,
					'x':yaxis_title_pos,
					'y':y,
					'valign':'center',
					'halign':'center',
					'angle':angle,
					'bold':bold,
					'text':prop['chart.title.yaxis'],
					'tag':'title yaxis'
				});
            }
    
            /**
            * If the background color is spec ified - draw that. It's a rectangle that fills the
            * entire area within the gutters
            */
            var bgcolor = prop['chart.background.color'];
            if (bgcolor) {
                co.fillStyle = bgcolor;
                co.fillRect(gutterLeft + 0.5, gutterTop + 0.5, ca.width - gutterLeft - gutterRight, ca.height - gutterTop - gutterBottom);
            }



















            /**
            * Draw horizontal background bars
            */
            var numbars   = (prop['chart.ylabels.count'] || 5);
            var barHeight = (ca.height - gutterBottom - gutterTop) / numbars;

            co.beginPath();
                co.fillStyle   = prop['chart.background.barcolor1'];
                co.strokeStyle = co.fillStyle;
                height = (ca.height - gutterBottom);

                for (var i=0; i<numbars; i+=2) {
                    co.rect(gutterLeft,
                            (i * barHeight) + gutterTop,
                            ca.width - gutterLeft - gutterRight,
                            barHeight
                            );
                }
            co.fill();



            co.beginPath();
                co.fillStyle   = prop['chart.background.barcolor2'];
                co.strokeStyle = co.fillStyle;
        
                for (var i=1; i<numbars; i+=2) {
                    co.rect(
                        gutterLeft,
                        (i * barHeight) + gutterTop,
                        ca.width - gutterLeft - gutterRight,
                        barHeight
                    );
                }
            
            co.fill();















            








            // Draw the background grid
            if (prop['chart.background.grid']) {

                // If autofit is specified, use the .numhlines and .numvlines along with the width to work
                // out the hsize and vsize
                if (prop['chart.background.grid.autofit']) {

                    /**
                    * Align the grid to the tickmarks
                    */
                    if (prop['chart.background.grid.autofit.align']) {

                        // Align the horizontal lines
                        if (obj.type === 'hbar') {
                            obj.set('chart.background.grid.autofit.numhlines', obj.data.length);
                        }

                        // Align the vertical lines for the line
                        if (obj.type === 'line') {
                            if (typeof prop['chart.background.grid.autofit.numvlines'] === 'number') {
                                // Nada
                            } else if (prop['chart.labels'] && prop['chart.labels'].length) {
                                obj.Set('chart.background.grid.autofit.numvlines', prop['chart.labels'].length - 1);
                            } else {
                                obj.Set('chart.background.grid.autofit.numvlines', obj.data[0].length - 1);
                            }
                        } else if (obj.type === 'waterfall') {
                            obj.set(
                                'backgroundGridAutofitNumvlines',
                                obj.data.length + (prop['chart.total'] ? 1 : 0)
                            );


                        // Align the vertical lines for the bar, Scatter
                        } else if ( (
                            obj.type === 'bar' ||
                            obj.type === 'scatter'
                            )
                            
                            && (
                                   (prop['chart.labels'] && prop['chart.labels'].length)
                                || obj.type === 'bar'
                               )
                        ) {

                            var len = (prop['chart.labels'] && prop['chart.labels'].length) || obj.data.length;


                            obj.set({
                                backgroundGridAutofitNumvlines: len
                            });

                        // Gantt
                        } else if (obj.type === 'gantt') {

                            if (typeof obj.get('chart.background.grid.autofit.numvlines') === 'number') {
                                // Nothing to do here
                            } else {
                                obj.set('chart.background.grid.autofit.numvlines', prop['chart.xmax']);
                            }

                            obj.set('chart.background.grid.autofit.numhlines', obj.data.length);
                        
                        // HBar
                        } else if (obj.type === 'hbar' && RG.isNull(prop['chart.background.grid.autofit.numhlines']) ) {
                            obj.set('chart.background.grid.autofit.numhlines', obj.data.length);
                        }
                    }

                    var vsize = ((ca.width - gutterLeft - gutterRight)) / prop['chart.background.grid.autofit.numvlines'];
                    var hsize = (ca.height - gutterTop - gutterBottom) / prop['chart.background.grid.autofit.numhlines'];

                    obj.Set('chart.background.grid.vsize', vsize);
                    obj.Set('chart.background.grid.hsize', hsize);
                }

                co.beginPath();
                co.lineWidth   = prop['chart.background.grid.width'] ? prop['chart.background.grid.width'] : 1;
                co.strokeStyle = prop['chart.background.grid.color'];
    
                // Dashed background grid
                if (prop['chart.background.grid.dashed'] && typeof co.setLineDash == 'function') {
                    co.setLineDash([3,5]);
                }
                
                // Dotted background grid
                if (prop['chart.background.grid.dotted'] && typeof co.setLineDash == 'function') {
                    co.setLineDash([1,3]);
                }
                
                co.beginPath();
    
    
                // Draw the horizontal lines
                if (prop['chart.background.grid.hlines']) {
                    height = (ca.height - gutterBottom)
                    var hsize = prop['chart.background.grid.hsize'];
                    for (y=gutterTop; y<=height; y+=hsize) {
                        context.moveTo(gutterLeft, ma.round(y));
                        context.lineTo(ca.width - gutterRight, ma.round(y));
                    }
                }
    
                if (prop['chart.background.grid.vlines']) {
                    // Draw the vertical lines
                    var width = (ca.width - gutterRight)
                    var vsize = prop['chart.background.grid.vsize'];

                    for (x=gutterLeft; x<=width; x+=vsize) {
                        co.moveTo(ma.round(x), gutterTop);
                        co.lineTo(ma.round(x), ca.height - gutterBottom);
                    }
                }
    
                if (prop['chart.background.grid.border']) {
                    // Make sure a rectangle, the same colour as the grid goes around the graph
                    co.strokeStyle = prop['chart.background.grid.color'];
                    co.strokeRect(ma.round(gutterLeft), ma.round(gutterTop), ca.width - gutterLeft - gutterRight, ca.height - gutterTop - gutterBottom);
                }
            }

            co.stroke();



            // Necessary to ensure the gris drawn before continuing
            co.beginPath();
            co.closePath();



            // If it's a bar and 3D variant, translate
            if (variant == '3d') {
                co.restore();
            }

            // Reset the line dash
            if (typeof co.setLineDash == 'function') {
                co.setLineDash([1,0]);
            }
    
            // Draw the title if one is set
            if ( typeof(prop['chart.title']) == 'string') {

                if (obj.type == 'gantt') {
                    gutterTop -= 10;
                }
    
                RG.drawTitle(
					// Because of caching the obj variablee cannot be used here
					{context: co, canvas: ca, properties: prop},
					prop['chart.title'],
					gutterTop,
					null,
					prop['chart.title.size'] ? prop['chart.title.size'] : prop['chart.text.size'] + 2,
					{canvas: ca, context: co}
				);
            }
    
            co.stroke();
        }

        // Now a cached draw in newer browsers
        RG.ISOLD ? func(obj, obj.canvas, obj.context) : RG.cachedDraw(obj, obj.uid + '_background', func);
    };




    /**
    * Formats a number with thousand separators so it's easier to read
    * 
    * @param  integer obj The chart object
    * @param  integer num The number to format
    * @param  string      The (optional) string to prepend to the string
    * @param  string      The (optional) string to append to the string
    * @return string      The formatted number
    */
    RG.numberFormat =
    RG.number_format = function (obj, num)
    {
        var ca   = obj.canvas;
        var co   = obj.context;
        var prop = obj.properties;

        var i;
        var prepend = arguments[2] ? String(arguments[2]) : '';
        var append  = arguments[3] ? String(arguments[3]) : '';
        var output  = '';
        var decimal = '';
        var decimal_separator  = typeof prop['chart.scale.point'] == 'string' ? prop['chart.scale.point'] : '.';
        var thousand_separator = typeof prop['chart.scale.thousand'] == 'string' ? prop['chart.scale.thousand'] : ',';
        RegExp.$1   = '';
        var i,j;

        if (typeof prop['chart.scale.formatter'] === 'function') {
            return prop['chart.scale.formatter'](obj, num);
        }

        // Ignore the preformatted version of "1e-2"
        if (String(num).indexOf('e') > 0) {
            return String(prepend + String(num) + append);
        }

        // We need then number as a string
        num = String(num);
        
        // Take off the decimal part - we re-append it later
        if (num.indexOf('.') > 0) {
            var tmp = num;
            num     = num.replace(/\.(.*)/, ''); // The front part of the number
            decimal = tmp.replace(/(.*)\.(.*)/, '$2'); // The decimal part of the number
        }

        // Thousand separator
        //var separator = arguments[1] ? String(arguments[1]) : ',';
        var separator = thousand_separator;
        
        /**
        * Work backwards adding the thousand separators
        */
        var foundPoint;
        for (i=(num.length - 1),j=0; i>=0; j++,i--) {
            var character = num.charAt(i);
            
            if ( j % 3 == 0 && j != 0) {
                output += separator;
            }
            
            /**
            * Build the output
            */
            output += character;
        }
        
        /**
        * Now need to reverse the string
        */
        var rev = output;
        output = '';
        for (i=(rev.length - 1); i>=0; i--) {
            output += rev.charAt(i);
        }

        // Tidy up
        //output = output.replace(/^-,/, '-');
        if (output.indexOf('-' + prop['chart.scale.thousand']) == 0) {
            output = '-' + output.substr(('-' + prop['chart.scale.thousand']).length);
        }

        // Reappend the decimal
        if (decimal.length) {
            output =  output + decimal_separator + decimal;
            decimal = '';
            RegExp.$1 = '';
        }

        // Minor bugette
        if (output.charAt(0) == '-') {
            output = output.replace(/-/, '');
            prepend = '-' + prepend;
        }

        return prepend + output + append;
    };




    /**
    * Draws horizontal coloured bars on something like the bar, line or scatter
    */
    RG.drawBars =
    RG.DrawBars = function (obj)
    {
        var prop  = obj.properties;
        var co    = obj.context;
        var ca    = obj.canvas;
        var hbars = prop['chart.background.hbars'];

        if (hbars === null) {
            return;
        }

        /**
        * Draws a horizontal bar
        */
        co.beginPath();

        for (i=0,len=hbars.length; i<len; ++i) {
        
            var start  = hbars[i][0];
            var length = hbars[i][1];
            var color  = hbars[i][2];
            

            // Perform some bounds checking
            if(RG.is_null(start))start = obj.scale2.max
            if (start > obj.scale2.max) start = obj.scale2.max;
            if (RG.is_null(length)) length = obj.scale2.max - start;
            if (start + length > obj.scale2.max) length = obj.scale2.max - start;
            if (start + length < (-1 * obj.scale2.max) ) length = (-1 * obj.scale2.max) - start;

            if (prop['chart.xaxispos'] == 'center' && start == obj.scale2.max && length < (obj.scale2.max * -2)) {
                length = obj.scale2.max * -2;
            }


            /**
            * Draw the bar
            */
            var x = prop['chart.gutter.left'];
            var y = obj.getYCoord(start);
            var w = ca.width - prop['chart.gutter.left'] - prop['chart.gutter.right'];
            var h = obj.getYCoord(start + length) - y;

            // Accommodate Opera :-/
            if (RG.ISOPERA != -1 && prop['chart.xaxispos'] == 'center' && h < 0) {
                h *= -1;
                y = y - h;
            }

            /**
            * Account for X axis at the top
            */
            if (prop['chart.xaxispos'] == 'top') {
                y  = ca.height - y;
                h *= -1;
            }

            co.fillStyle = color;
            co.fillRect(x, y, w, h);
        }
/*


            


            // If the X axis is at the bottom, and a negative max is given, warn the user
            if (obj.Get('chart.xaxispos') == 'bottom' && (hbars[i][0] < 0 || (hbars[i][1] + hbars[i][1] < 0)) ) {
                alert('[' + obj.type.toUpperCase() + ' (ID: ' + obj.id + ') BACKGROUND HBARS] You have a negative value in one of your background hbars values, whilst the X axis is in the center');
            }

            var ystart = (obj.grapharea - (((hbars[i][0] - obj.scale2.min) / (obj.scale2.max - obj.scale2.min)) * obj.grapharea));
            //var height = (Math.min(hbars[i][1], obj.max - hbars[i][0]) / (obj.scale2.max - obj.scale2.min)) * obj.grapharea;
            var height = obj.getYCoord(hbars[i][0]) - obj.getYCoord(hbars[i][1]);

            // Account for the X axis being in the center
            if (obj.Get('chart.xaxispos') == 'center') {
                ystart /= 2;
                //height /= 2;
            }
            
            ystart += obj.Get('chart.gutter.top')

            var x = obj.Get('chart.gutter.left');
            var y = ystart - height;
            var w = obj.canvas.width - obj.Get('chart.gutter.left') - obj.Get('chart.gutter.right');
            var h = height;

            // Accommodate Opera :-/
            if (navigator.userAgent.indexOf('Opera') != -1 && obj.Get('chart.xaxispos') == 'center' && h < 0) {
                h *= -1;
                y = y - h;
            }
            
            /**
            * Account for X axis at the top
            */
            //if (obj.Get('chart.xaxispos') == 'top') {
            //    y  = obj.canvas.height - y;
            //    h *= -1;
            //}

            //obj.context.fillStyle = hbars[i][2];
            //obj.context.fillRect(x, y, w, h);
        //}
    };




    /**
    * Draws in-graph labels.
    * 
    * @param object obj The graph object
    */
    RG.drawInGraphLabels =
    RG.DrawInGraphLabels = function (obj)
    {
        var ca      = obj.canvas;
        var co      = obj.context;
        var prop    = obj.properties;
        var labels  = prop['chart.labels.ingraph'];
        var labels_processed = [];

        // Defaults
        var fgcolor   = 'black';
        var bgcolor   = 'white';
        var direction = 1;

        if (!labels) {
            return;
        }

        /**
        * Preprocess the labels array. Numbers are expanded
        */
        for (var i=0,len=labels.length; i<len; i+=1) {
            if (typeof labels[i] === 'number') {
                for (var j=0; j<labels[i]; ++j) {
                    labels_processed.push(null);
                }
            } else if (typeof labels[i] === 'string' || typeof labels[i] === 'object') {
                labels_processed.push(labels[i]);
            
            } else {
                labels_processed.push('');
            }
        }

        /**
        * Turn off any shadow
        */
        RG.NoShadow(obj);

        if (labels_processed && labels_processed.length > 0) {

            for (var i=0,len=labels_processed.length; i<len; i+=1) {
                if (labels_processed[i]) {
                    var coords = obj.coords[i];
                    
                    if (coords && coords.length > 0) {
                        var x      = (obj.type == 'bar' ? coords[0] + (coords[2] / 2) : coords[0]);
                        var y      = (obj.type == 'bar' ? coords[1] + (coords[3] / 2) : coords[1]);
                        var length = typeof labels_processed[i][4] === 'number' ? labels_processed[i][4] : 25;
    
                        co.beginPath();
                        co.fillStyle   = 'black';
                        co.strokeStyle = 'black';
                        
    
                        if (obj.type === 'bar') {
                        
                            /**
                            * X axis at the top
                            */
                            if (obj.Get('chart.xaxispos') == 'top') {
                                length *= -1;
                            }
    
                            if (prop['chart.variant'] == 'dot') {
                                co.moveTo(ma.round(x), obj.coords[i][1] - 5);
                                co.lineTo(ma.round(x), obj.coords[i][1] - 5 - length);
                                
                                var text_x = ma.round(x);
                                var text_y = obj.coords[i][1] - 5 - length;
                            
                            } else if (prop['chart.variant'] == 'arrow') {
                                co.moveTo(ma.round(x), obj.coords[i][1] - 5);
                                co.lineTo(ma.round(x), obj.coords[i][1] - 5 - length);
                                
                                var text_x = ma.round(x);
                                var text_y = obj.coords[i][1] - 5 - length;
                            
                            } else {
    
                                co.arc(ma.round(x), y, 2.5, 0, 6.28, 0);
                                co.moveTo(ma.round(x), y);
                                co.lineTo(ma.round(x), y - length);

                                var text_x = ma.round(x);
                                var text_y = y - length;
                            }

                            co.stroke();
                            co.fill();
                            
    
                        } else if (obj.type == 'line') {
                        
                            if (
                                typeof labels_processed[i] == 'object' &&
                                typeof labels_processed[i][3] == 'number' &&
                                labels_processed[i][3] == -1
                               ) {

                                co.moveTo(ma.round(x), y + 5);
                                co.lineTo(ma.round(x), y + 5 + length);
                                
                                co.stroke();
                                co.beginPath();                                
                                
                                // This draws the arrow
                                co.moveTo(ma.round(x), y + 5);
                                co.lineTo(ma.round(x) - 3, y + 10);
                                co.lineTo(ma.round(x) + 3, y + 10);
                                co.closePath();
                                
                                var text_x = x;
                                var text_y = y + 5 + length;
                            
                            } else {
                                
                                var text_x = x;
                                var text_y = y - 5 - length;

                                co.moveTo(ma.round(x), y - 5);
                                co.lineTo(ma.round(x), y - 5 - length);
                                
                                co.stroke();
                                co.beginPath();
                                
                                // This draws the arrow
                                co.moveTo(ma.round(x), y - 5);
                                co.lineTo(ma.round(x) - 3, y - 10);
                                co.lineTo(ma.round(x) + 3, y - 10);
                                co.closePath();
                            }
                        
                            co.fill();
                        }

                        // Taken out on the 10th Nov 2010 - unnecessary
                        //var width = context.measureText(labels[i]).width;
                        
                        co.beginPath();
                            
                            // Fore ground color
                            co.fillStyle = (typeof labels_processed[i] === 'object' && typeof labels_processed[i][1] === 'string') ? labels_processed[i][1] : 'black';

                            RG.Text2(obj,{'font':prop['chart.text.font'],
                                          'size':prop['chart.text.size'],
                                          'x':text_x,
                                          'y':text_y,
                                          'text': (typeof labels_processed[i] === 'object' && typeof labels_processed[i][0] === 'string') ? labels_processed[i][0] : labels_processed[i],
                                          'valign': 'bottom',
                                          'halign':'center',
                                          'bounding':true,
                                          'bounding.fill': (typeof labels_processed[i] === 'object' && typeof labels_processed[i][2] === 'string') ? labels_processed[i][2] : 'white',
                                          'tag':'labels ingraph'
                                         });
                        co.fill();
                    }
                }
            }
        }
    };




    /**
    * This function "fills in" key missing properties that various implementations lack
    * 
    * @param object e The event object
    */
    RG.fixEventObject =
    RG.FixEventObject = function (e)
    {
        if (RG.ISOLD) {
            var e = event;

            e.pageX  = (event.clientX + doc.body.scrollLeft);
            e.pageY  = (event.clientY + doc.body.scrollTop);
            e.target = event.srcElement;
            
            if (!doc.body.scrollTop && doc.documentElement.scrollTop) {
                e.pageX += parseInt(doc.documentElement.scrollLeft);
                e.pageY += parseInt(doc.documentElement.scrollTop);
            }
        }

        
        // Any browser that doesn't implement stopPropagation() (MSIE)
        if (!e.stopPropagation) {
            e.stopPropagation = function () {window.event.cancelBubble = true;}
        }
        
        return e;
    };




    /**
    * Thisz function hides the crosshairs coordinates
    */
    RG.hideCrosshairCoords =
    RG.HideCrosshairCoords = function ()
    {
        var div = RG.Registry.Get('chart.coordinates.coords.div');

        if (   div
            && div.style.opacity == 1
            && div.__object__.Get('chart.crosshairs.coords.fadeout')
           ) {
            
            var style = RG.Registry.Get('chart.coordinates.coords.div').style;

            setTimeout(function() {style.opacity = 0.9;}, 25);
            setTimeout(function() {style.opacity = 0.8;}, 50);
            setTimeout(function() {style.opacity = 0.7;}, 75);
            setTimeout(function() {style.opacity = 0.6;}, 100);
            setTimeout(function() {style.opacity = 0.5;}, 125);
            setTimeout(function() {style.opacity = 0.4;}, 150);
            setTimeout(function() {style.opacity = 0.3;}, 175);
            setTimeout(function() {style.opacity = 0.2;}, 200);
            setTimeout(function() {style.opacity = 0.1;}, 225);
            setTimeout(function() {style.opacity = 0;}, 250);
            setTimeout(function() {style.display = 'none';}, 275);
        }
    };




    /**
    * Draws the3D axes/background
    * 
    * @param object obj The chart object
    */
    RG.draw3DAxes =
    RG.Draw3DAxes = function (obj)
    {
        var prop = obj.properties;
        var co   = obj.context;
        var ca   = obj.canvas;

        var gutterLeft    = obj.gutterLeft,
            gutterRight   = obj.gutterRight,
            gutterTop     = obj.gutterTop,
            gutterBottom  = obj.gutterBottom,
            xaxispos      = prop['chart.xaxispos'],
            graphArea     = ca.height - gutterTop - gutterBottom,
            halfGraphArea = graphArea / 2,
            offsetx       = prop['chart.variant.threed.offsetx'],
            offsety       = prop['chart.variant.threed.offsety']

        if (!prop['chart.noaxes'] && !prop['chart.noyaxis']) {
            RG.path(co, [
                'b',
                // Y axis
                'm', gutterLeft,gutterTop,
                'l',gutterLeft + offsetx,gutterTop - offsety,
                'l',gutterLeft + offsetx,ca.height - gutterBottom - offsety,
                'l',gutterLeft,ca.height - gutterBottom
            ]);
        }
        
        // X axis
        if (xaxispos === 'center') {
            RG.path(co, [
                'm',gutterLeft,gutterTop + halfGraphArea,
                'l',gutterLeft + offsetx,gutterTop + halfGraphArea - offsety,

                'l',ca.width - gutterRight + offsetx,gutterTop + halfGraphArea - offsety,
                'l',ca.width - gutterRight,gutterTop + halfGraphArea,
                'c','s','#aaa','f','#ddd'
            ]);
        } else {
            RG.path(co, [
                'm',gutterLeft,ca.height - gutterBottom,
                'l',gutterLeft + offsetx,ca.height - gutterBottom - offsety,
                'l',ca.width - gutterRight + offsetx,ca.height - gutterBottom - offsety,
                'l',ca.width - gutterRight,ca.height - gutterBottom,
                'c','s','#aaa','f','#ddd'
            ]);
        }
    };




    /**
    * Draws a rectangle with curvy corners
    * 
    * @param co object The context
    * @param x number The X coordinate (top left of the square)
    * @param y number The Y coordinate (top left of the square)
    * @param w number The width of the rectangle
    * @param h number The height of the rectangle
    * @param   number The radius of the curved corners
    * @param   boolean Whether the top left corner is curvy
    * @param   boolean Whether the top right corner is curvy
    * @param   boolean Whether the bottom right corner is curvy
    * @param   boolean Whether the bottom left corner is curvy
    */
    RG.strokedCurvyRect = function (co, x, y, w, h)
    {
        // The corner radius
        var r = arguments[5] ? arguments[5] : 3;

        // The corners
        var corner_tl = (arguments[6] || arguments[6] == null) ? true : false;
        var corner_tr = (arguments[7] || arguments[7] == null) ? true : false;
        var corner_br = (arguments[8] || arguments[8] == null) ? true : false;
        var corner_bl = (arguments[9] || arguments[9] == null) ? true : false;

        co.beginPath();

            // Top left side
            co.moveTo(x + (corner_tl ? r : 0), y);
            co.lineTo(x + w - (corner_tr ? r : 0), y);
            
            // Top right corner
            if (corner_tr) {
                co.arc(x + w - r, y + r, r, RG.PI + RG.HALFPI, RG.TWOPI, false);
            }

            // Top right side
            co.lineTo(x + w, y + h - (corner_br ? r : 0) );

            // Bottom right corner
            if (corner_br) {
                co.arc(x + w - r, y - r + h, r, RG.TWOPI, RG.HALFPI, false);
            }

            // Bottom right side
            co.lineTo(x + (corner_bl ? r : 0), y + h);

            // Bottom left corner
            if (corner_bl) {
                co.arc(x + r, y - r + h, r, RG.HALFPI, RG.PI, false);
            }

            // Bottom left side
            co.lineTo(x, y + (corner_tl ? r : 0) );

            // Top left corner
            if (corner_tl) {
                co.arc(x + r, y + r, r, RG.PI, RG.PI + RG.HALFPI, false);
            }

        co.stroke();
    };




    /**
    * Draws a filled rectangle with curvy corners
    * 
    * @param context object The context
    * @param x       number The X coordinate (top left of the square)
    * @param y       number The Y coordinate (top left of the square)
    * @param w       number The width of the rectangle
    * @param h       number The height of the rectangle
    * @param         number The radius of the curved corners
    * @param         boolean Whether the top left corner is curvy
    * @param         boolean Whether the top right corner is curvy
    * @param         boolean Whether the bottom right corner is curvy
    * @param         boolean Whether the bottom left corner is curvy
    */
    RG.filledCurvyRect = function (co, x, y, w, h)
    {
        // The corner radius
        var r = arguments[5] ? arguments[5] : 3;

        // The corners
        var corner_tl = (arguments[6] || arguments[6] == null) ? true : false;
        var corner_tr = (arguments[7] || arguments[7] == null) ? true : false;
        var corner_br = (arguments[8] || arguments[8] == null) ? true : false;
        var corner_bl = (arguments[9] || arguments[9] == null) ? true : false;

        co.beginPath();

            // First draw the corners

            // Top left corner
            if (corner_tl) {
                co.moveTo(x + r, y + r);
                co.arc(x + r, y + r, r, RG.PI, RG.PI + RG.HALFPI, false);
            } else {
                co.fillRect(x, y, r, r);
            }

            // Top right corner
            if (corner_tr) {
                co.moveTo(x + w - r, y + r);
                co.arc(x + w - r, y + r, r, RG.PI + RG.HALFPI, 0, false);
            } else {
                co.moveTo(x + w - r, y);
                co.fillRect(x + w - r, y, r, r);
            }


            // Bottom right corner
            if (corner_br) {
                co.moveTo(x + w - r, y + h - r);
                co.arc(x + w - r, y - r + h, r, 0, RG.HALFPI, false);
            } else {
                co.moveTo(x + w - r, y + h - r);
                co.fillRect(x + w - r, y + h - r, r, r);
            }

            // Bottom left corner
            if (corner_bl) {
                co.moveTo(x + r, y + h - r);
                co.arc(x + r, y - r + h, r, RG.HALFPI, RG.PI, false);
            } else {
                co.moveTo(x, y + h - r);
                co.fillRect(x, y + h - r, r, r);
            }

            // Now fill it in
            co.fillRect(x + r, y, w - r - r, h);
            co.fillRect(x, y + r, r + 1, h - r - r);
            co.fillRect(x + w - r - 1, y + r, r + 1, h - r - r);

        co.fill();
    };




    /**
    * Hides the zoomed canvas
    */
    RG.hideZoomedCanvas =
    RG.HideZoomedCanvas = function ()
    {
        var interval = 10;
        var frames   = 15;

        if (typeof RG.zoom_image === 'object') {
            var obj  = RG.zoom_image.obj;
            var prop = obj.properties;
        } else {
            return;
        }

        if (prop['chart.zoom.fade.out']) {
            for (var i=frames,j=1; i>=0; --i, ++j) {
                if (typeof RG.zoom_image === 'object') {
                    setTimeout("RGraph.zoom_image.style.opacity = " + String(i / 10), j * interval);
                }
            }

            if (typeof RG.zoom_background === 'object') {
                setTimeout("RGraph.zoom_background.style.opacity = " + String(i / frames), j * interval);
            }
        }

        if (typeof RG.zoom_image === 'object') {
            setTimeout("RGraph.zoom_image.style.display = 'none'", prop['chart.zoom.fade.out'] ? (frames * interval) + 10 : 0);
        }

        if (typeof RG.zoom_background === 'object') {
            setTimeout("RGraph.zoom_background.style.display = 'none'", prop['chart.zoom.fade.out'] ? (frames * interval) + 10 : 0);
        }
    };




    /**
    * Adds an event handler
    * 
    * @param object obj   The graph object
    * @param string event The name of the event, eg ontooltip
    * @param object func  The callback function
    */
    RG.addCustomEventListener =
    RG.AddCustomEventListener = function (obj, name, func)
    {
        var RG = RGraph;

        if (typeof RG.events[obj.uid] === 'undefined') {
            RG.events[obj.uid] = [];
        }

        RG.events[obj.uid].push([obj, name, func]);
        
        return RG.events[obj.uid].length - 1;
    };




    /**
    * Used to fire one of the RGraph custom events
    * 
    * @param object obj   The graph object that fires the event
    * @param string event The name of the event to fire
    */
    RG.fireCustomEvent =
    RG.FireCustomEvent = function (obj, name)
    {
        if (obj && obj.isRGraph) {
        
            // New style of adding custom events
            if (obj[name]) {
                (obj[name])(obj);
            }
            
            var uid = obj.uid;
    
            if (   typeof uid === 'string'
                && typeof RG.events === 'object'
                && typeof RG.events[uid] === 'object'
                && RG.events[uid].length > 0) {
    
                for(var j=0; j<RG.events[uid].length; ++j) {
                    if (RG.events[uid][j] && RG.events[uid][j][1] == name) {
                        RG.events[uid][j][2](obj);
                    }
                }
            }
        }
    };




    /**
    * Clears all the custom event listeners that have been registered
    * 
    * @param    string Limits the clearing to this object ID
    */
    RGraph.removeAllCustomEventListeners =
    RGraph.RemoveAllCustomEventListeners = function ()
    {
        var id = arguments[0];

        if (id && RG.events[id]) {
            RG.events[id] = [];
        } else {
            RG.events = [];
        }
    };




    /**
    * Clears a particular custom event listener
    * 
    * @param object obj The graph object
    * @param number i   This is the index that is return by .AddCustomEventListener()
    */
    RG.removeCustomEventListener =
    RG.RemoveCustomEventListener = function (obj, i)
    {
        if (   typeof RG.events === 'object'
            && typeof RG.events[obj.id] === 'object'
            && typeof RG.events[obj.id][i] === 'object') {
            
            RG.events[obj.id][i] = null;
        }
    };




    /**
    * This draws the background
    * 
    * @param object obj The graph object
    */
    RG.drawBackgroundImage =
    RG.DrawBackgroundImage = function (obj)
    {
        var prop = obj.properties;
        var ca   = obj.canvas;
        var co   = obj.context;

        if (typeof prop['chart.background.image'] === 'string') {
            if (typeof ca.__rgraph_background_image__ === 'undefined') {
                var img = new Image();
                img.__object__  = obj;
                img.__canvas__  = ca;
                img.__context__ = co;
                img.src         = obj.Get('chart.background.image');
                
                ca.__rgraph_background_image__ = img;
            } else {
                img = ca.__rgraph_background_image__;
            }

            // When the image has loaded - redraw the canvas
            img.onload = function ()
            {
                obj.__rgraph_background_image_loaded__ = true;
                RG.clear(ca);
                RG.redrawCanvas(ca);
            }
                
            var gutterLeft   = obj.gutterLeft;
            var gutterRight  = obj.gutterRight;
            var gutterTop    = obj.gutterTop;
            var gutterBottom = obj.gutterBottom;
            var stretch      = prop['chart.background.image.stretch'];
            var align        = prop['chart.background.image.align'];
    
            // Handle chart.background.image.align
            if (typeof align === 'string') {
                if (align.indexOf('right') != -1) {
                    var x = ca.width - (prop['chart.background.image.w'] || img.width) - gutterRight;
                } else {
                    var x = gutterLeft;
                }
    
                if (align.indexOf('bottom') != -1) {
                    var y = ca.height - (prop['chart.background.image.h'] || img.height) - gutterBottom;
                } else {
                    var y = gutterTop;
                }
            } else {
                var x = gutterLeft || 25;
                var y = gutterTop || 25;
            }

            // X/Y coords take precedence over the align
            var x = typeof prop['chart.background.image.x'] === 'number' ? prop['chart.background.image.x'] : x;
            var y = typeof prop['chart.background.image.y'] === 'number' ? prop['chart.background.image.y'] : y;
            var w = stretch ? ca.width - gutterLeft - gutterRight : img.width;
            var h = stretch ? ca.height - gutterTop - gutterBottom : img.height;
            
            /**
            * You can now specify the width and height of the image
            */
            if (typeof prop['chart.background.image.w'] === 'number') w  = prop['chart.background.image.w'];
            if (typeof prop['chart.background.image.h'] === 'number') h = prop['chart.background.image.h'];

            var oldAlpha = co.globalAlpha;
                co.globalAlpha = prop['chart.background.image.alpha'];
                co.drawImage(img,x,y,w, h);
            co.globalAlpha = oldAlpha;
        }
    };




    /**
    * This function determines wshether an object has tooltips or not
    * 
    * @param object obj The chart object
    */
    RG.hasTooltips = function (obj)
    {
        var prop = obj.properties;

        if (typeof prop['chart.tooltips'] == 'object' && prop['chart.tooltips']) {
            for (var i=0,len=prop['chart.tooltips'].length; i<len; ++i) {
                if (!RG.is_null(obj.Get('chart.tooltips')[i])) {
                    return true;
                }
            }
        } else if (typeof prop['chart.tooltips'] === 'function') {
            return true;
        }
        
        return false;
    };




    /**
    * This function creates a (G)UID which can be used to identify objects.
    * 
    * @return string (g)uid The (G)UID
    */
    RG.createUID =
    RG.CreateUID = function ()
    {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c)
        {
            var r = ma.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
            return v.toString(16);
        });
    };



    /**
    * This is the new object registry, used to facilitate multiple objects per canvas.
    * 
    * @param object obj The object to register
    */
    RG.ObjectRegistry.add =
    RG.ObjectRegistry.Add = function (obj)
    {
        var uid = obj.uid;
        var id  = obj.canvas.id;

        /**
        * Index the objects by UID
        */
        RG.ObjectRegistry.objects.byUID.push([uid, obj]);
        
        /**
        * Index the objects by the canvas that they're drawn on
        */
        RG.ObjectRegistry.objects.byCanvasID.push([id, obj]);
    };




    /**
    * Remove an object from the object registry
    * 
    * @param object obj The object to remove.
    */
    RG.ObjectRegistry.remove =
    RG.ObjectRegistry.Remove = function (obj)
    {
        var id  = obj.id;
        var uid = obj.uid;

        for (var i=0; i<RG.ObjectRegistry.objects.byUID.length; ++i) {
            if (RG.ObjectRegistry.objects.byUID[i] && RG.ObjectRegistry.objects.byUID[i][1].uid == uid) {
                RG.ObjectRegistry.objects.byUID[i] = null;
            }
        }


        for (var i=0; i<RG.ObjectRegistry.objects.byCanvasID.length; ++i) {
            if (   RG.ObjectRegistry.objects.byCanvasID[i]
                && RG.ObjectRegistry.objects.byCanvasID[i][1]
                && RG.ObjectRegistry.objects.byCanvasID[i][1].uid == uid) {
                
                RG.ObjectRegistry.objects.byCanvasID[i] = null;
            }
        }
    };




    /**
    * Removes all objects from the ObjectRegistry. If either the ID of a canvas is supplied,
    * or the canvas itself, then only objects pertaining to that canvas are cleared.
    * 
    * @param mixed   Either a canvas object (as returned by document.getElementById()
    *                or the ID of a canvas (ie a string)
    */
    RG.ObjectRegistry.clear =
    RG.ObjectRegistry.Clear = function ()
    {
        // If an ID is supplied restrict the learing to that
        if (arguments[0]) {
            var id      = (typeof arguments[0] === 'object' ? arguments[0].id : arguments[0]);
            var objects = RG.ObjectRegistry.getObjectsByCanvasID(id);

            for (var i=0,len=objects.length; i<len; ++i) {
                RG.ObjectRegistry.remove(objects[i]);
            }

        } else {

            RG.ObjectRegistry.objects            = {};
            RG.ObjectRegistry.objects.byUID      = [];
            RG.ObjectRegistry.objects.byCanvasID = [];
        }
    };




    /**
    * Lists all objects in the ObjectRegistry
    * 
    * @param boolean ret Whether to return the list or alert() it
    */
    RGraph.ObjectRegistry.list =
    RGraph.ObjectRegistry.List = function ()
    {
        var list = [];

        for (var i=0,len=RG.ObjectRegistry.objects.byUID.length; i<len; ++i) {
            if (RG.ObjectRegistry.objects.byUID[i]) {
                list.push(RG.ObjectRegistry.objects.byUID[i][1].type);
            }
        }
        
        if (arguments[0]) {
            return list;
        } else {
            p(list);
        }
    };




    /**
    * Clears the ObjectRegistry of objects that are of a certain given type
    * 
    * @param type string The type to clear
    */
    RG.ObjectRegistry.clearByType =
    RG.ObjectRegistry.ClearByType = function (type)
    {
        var objects = RG.ObjectRegistry.objects.byUID;

        for (var i=0,len=objects.length; i<len; ++i) {
            if (objects[i]) {
                var uid = objects[i][0];
                var obj = objects[i][1];
                
                if (obj && obj.type == type) {
                    RG.ObjectRegistry.remove(obj);
                }
            }
        }
    };




    /**
    * This function provides an easy way to go through all of the objects that are held in the
    * Registry
    * 
    * @param func function This function is run for every object. Its passed the object as an argument
    * @param string type Optionally, you can pass a type of object to look for
    */
    RG.ObjectRegistry.iterate =
    RG.ObjectRegistry.Iterate = function (func)
    {
        var objects = RGraph.ObjectRegistry.objects.byUID;

        for (var i=0,len=objects.length; i<len; ++i) {
        
            if (typeof arguments[1] === 'string') {
                
                var types = arguments[1].split(/,/);

                for (var j=0,len2=types.length; j<len2; ++j) {
                    if (types[j] == objects[i][1].type) {
                        func(objects[i][1]);
                    }
                }
            } else {
                func(objects[i][1]);
            }
        }
    };




    /**
    * Retrieves all objects for a given canvas id
    * 
    * @patarm id string The canvas ID to get objects for.
    */
    RG.ObjectRegistry.getObjectsByCanvasID = function (id)
    {
        var store = RG.ObjectRegistry.objects.byCanvasID;
        var ret = [];

        // Loop through all of the objects and return the appropriate ones
        for (var i=0,len=store.length; i<len; ++i) {
            if (store[i] && store[i][0] == id ) {
                ret.push(store[i][1]);
            }
        }

        return ret;
    };




    /**
    * Retrieves the relevant object based on the X/Y position.
    * 
    * @param  object e The event object
    * @return object   The applicable (if any) object
    */
    RG.ObjectRegistry.getFirstObjectByXY =
    RG.ObjectRegistry.getObjectByXY = function (e)
    {
        var canvas  = e.target;
        var ret     = null;
        var objects = RG.ObjectRegistry.getObjectsByCanvasID(canvas.id);

        for (var i=(objects.length - 1); i>=0; --i) {

            var obj = objects[i].getObjectByXY(e);

            if (obj) {
                return obj;
            }
        }
    };




    /**
    * Retrieves the relevant objects based on the X/Y position.
    * NOTE This function returns an array of objects
    * 
    * @param  object e The event object
    * @return          An array of pertinent objects. Note the there may be only one object
    */
    RG.ObjectRegistry.getObjectsByXY = function (e)
    {
        var canvas  = e.target;
        var ret     = [];
        var objects = RG.ObjectRegistry.getObjectsByCanvasID(canvas.id);

        // Retrieve objects "front to back"
        for (var i=(objects.length - 1); i>=0; --i) {

            var obj = objects[i].getObjectByXY(e);

            if (obj) {
                ret.push(obj);
            }
        }
        
        return ret;
    };




    /**
    * Retrieves the object with the corresponding UID
    * 
    * @param string uid The UID to get the relevant object for
    */
    RG.ObjectRegistry.getObjectByUID = function (uid)
    {
        var objects = RG.ObjectRegistry.objects.byUID;

        for (var i=0,len=objects.length; i<len; ++i) {
            if (objects[i] && objects[i][1].uid == uid) {
                return objects[i][1];
            }
        }
    };




    /**
    * Brings a chart to the front of the ObjectRegistry by
    * removing it and then readding it at the end and then
    * redrawing the canvas
    * 
    * @param object  obj    The object to bring to the front
    * @param boolean redraw Whether to redraw the canvas after the 
    *                       object has been moved
    */
    RG.ObjectRegistry.bringToFront = function (obj)
    {
        var redraw = typeof arguments[1] === 'undefined' ? true : arguments[1];

        RG.ObjectRegistry.remove(obj);
        RG.ObjectRegistry.add(obj);
        
        if (redraw) {
            RG.redrawCanvas(obj.canvas);
        }
    };




    /**
    * Retrieves the objects that are the given type
    * 
    * @param  mixed canvas  The canvas to check. It can either be the canvas object itself or just the ID
    * @param  string type   The type to look for
    * @return array         An array of one or more objects
    */
    RG.ObjectRegistry.getObjectsByType = function (type)
    {
        var objects = RG.ObjectRegistry.objects.byUID;
        var ret     = [];

        for (var i=0,len=objects.length; i<len; ++i) {

            if (objects[i] && objects[i][1] && objects[i][1].type && objects[i][1].type && objects[i][1].type == type) {
                ret.push(objects[i][1]);
            }
        }

        return ret;
    };




    /**
    * Retrieves the FIRST object that matches the given type
    *
    * @param  string type   The type of object to look for
    * @return object        The FIRST object that matches the given type
    */
    RG.ObjectRegistry.getFirstObjectByType = function (type)
    {
        var objects = RG.ObjectRegistry.objects.byUID;
    
        for (var i=0,len=objects.length; i<len; ++i) {
            if (objects[i] && objects[i][1] && objects[i][1].type == type) {
                return objects[i][1];
            }
        }
        
        return null;
    };




    /**
    * This takes centerx, centery, x and y coordinates and returns the
    * appropriate angle relative to the canvas angle system. Remember
    * that the canvas angle system starts at the EAST axis
    * 
    * @param  number cx  The centerx coordinate
    * @param  number cy  The centery coordinate
    * @param  number x   The X coordinate (eg the mouseX if coming from a click)
    * @param  number y   The Y coordinate (eg the mouseY if coming from a click)
    * @return number     The relevant angle (measured in in RADIANS)
    */
    RG.getAngleByXY = function (cx, cy, x, y)
    {
        var angle = ma.atan((y - cy) / (x - cx));
            angle = ma.abs(angle)

        if (x >= cx && y >= cy) {
            angle += RG.TWOPI;

        } else if (x >= cx && y < cy) {
            angle = (RG.HALFPI - angle) + (RG.PI + RG.HALFPI);

        } else if (x < cx && y < cy) {
            angle += RG.PI;

        } else {
            angle = RG.PI - angle;
        }

        /**
        * Upper and lower limit checking
        */
        if (angle > RG.TWOPI) {
            angle -= RG.TWOPI;
        }

        return angle;
    };




    /**
    * This function returns the distance between two points. In effect the
    * radius of an imaginary circle that is centered on x1 and y1. The name
    * of this function is derived from the word "Hypoteneuse", which in
    * trigonmetry is the longest side of a triangle
    * 
    * @param number x1 The original X coordinate
    * @param number y1 The original Y coordinate
    * @param number x2 The target X coordinate
    * @param number y2 The target Y  coordinate
    */
    RG.getHypLength = function (x1, y1, x2, y2)
    {
        var ret = ma.sqrt(((x2 - x1) * (x2 - x1)) + ((y2 - y1) * (y2 - y1)));

        return ret;
    };




    /**
    * This function gets the end point (X/Y coordinates) of a given radius.
    * You pass it the center X/Y and the radius and this function will return
    * the endpoint X/Y coordinates.
    * 
    * @param number cx The center X coord
    * @param number cy The center Y coord
    * @param number r  The lrngth of the radius
    */
    RG.getRadiusEndPoint = function (cx, cy, angle, radius)
    {
        var x = cx + (ma.cos(angle) * radius);
        var y = cy + (ma.sin(angle) * radius);
        
        return [x, y];
    };




    /**
    * This installs all of the event listeners
    * 
    * @param object obj The chart object
    */
    RG.installEventListeners =
    RG.InstallEventListeners = function (obj)
    {
        var prop = obj.properties;

        /**
        * Don't attempt to install event listeners for older versions of MSIE
        */
        if (RG.ISOLD) {
            return;
        }

        /**
        * If this function exists, then the dynamic file has been included.
        */
        if (RG.installCanvasClickListener) {

            RG.installWindowMousedownListener(obj);
            RG.installWindowMouseupListener(obj);
            RG.installCanvasMousemoveListener(obj);
            RG.installCanvasMouseupListener(obj);
            RG.installCanvasMousedownListener(obj);
            RG.installCanvasClickListener(obj);
        
        } else if (   RG.hasTooltips(obj)
                   || prop['chart.adjustable']
                   || prop['chart.annotatable']
                   || prop['chart.contextmenu']
                   || prop['chart.resizable']
                   || prop['chart.key.interactive']
                   || prop['chart.events.click']
                   || prop['chart.events.mousemove']
                   || typeof obj.onclick === 'function'
                   || typeof obj.onmousemove === 'function'
                  ) {

            alert('[RGRAPH] You appear to have used dynamic features but not included the file: RGraph.common.dynamic.js');
        }
    };




    /**
    * Loosly mimicks the PHP function print_r();
    */
    RG.pr = function (obj)
    {
        var indent = (arguments[2] ? arguments[2] : '    ');
        var str    = '';

        var counter = typeof arguments[3] == 'number' ? arguments[3] : 0;
        
        if (counter >= 5) {
            return '';
        }
        
        switch (typeof obj) {
            
            case 'string':    str += obj + ' (' + (typeof obj) + ', ' + obj.length + ')'; break;
            case 'number':    str += obj + ' (' + (typeof obj) + ')'; break;
            case 'boolean':   str += obj + ' (' + (typeof obj) + ')'; break;
            case 'function':  str += 'function () {}'; break;
            case 'undefined': str += 'undefined'; break;
            case 'null':      str += 'null'; break;
            
            case 'object':
                // In case of null
                if (RGraph.is_null(obj)) {
                    str += indent + 'null\n';
                } else {
                    str += indent + 'Object {' + '\n'
                    for (j in obj) {
                        str += indent + '    ' + j + ' => ' + RGraph.pr(obj[j], true, indent + '    ', counter + 1) + '\n';
                    }
                    str += indent + '}';
                }
                break;
            
            
            default:
                str += 'Unknown type: ' + typeof obj + '';
                break;
        }


        /**
        * Finished, now either return if we're in a recursed call, or alert()
        * if we're not.
        */
        if (!arguments[1]) {
            alert(str);
        }
        
        return str;
    };




    /**
    * Produces a dashed line
    * 
    * @param object co The 2D context
    * @param number x1 The start X coordinate
    * @param number y1 The start Y coordinate
    * @param number x2 The end X coordinate
    * @param number y2 The end Y coordinate
    */
    RG.dashedLine =
    RG.DashedLine = function(co, x1, y1, x2, y2)
    {
        /**
        * This is the size of the dashes
        */
        var size = 5;

        /**
        * The optional fifth argument can be the size of the dashes
        */
        if (typeof arguments[5] === 'number') {
            size = arguments[5];
        }

        var dx  = x2 - x1;
        var dy  = y2 - y1;
        var num = ma.floor(ma.sqrt((dx * dx) + (dy * dy)) / size);

        var xLen = dx / num;
        var yLen = dy / num;

        var count = 0;

        do {
            (count % 2 == 0 && count > 0) ? co.lineTo(x1, y1) : co.moveTo(x1, y1);

            x1 += xLen;
            y1 += yLen;
        } while(count++ <= num);
    };




    /**
    * Makes an AJAX call. It calls the given callback (a function) when ready
    * 
    * @param string   url      The URL to retrieve
    * @param function callback A function that is called when the response is ready, there's an example below
    *                          called "myCallback".
    */
    RG.AJAX = function (url, callback)
    {
        // Mozilla, Safari, ...
        if (window.XMLHttpRequest) {
            var httpRequest = new XMLHttpRequest();

        // MSIE
        } else if (window.ActiveXObject) {
            var httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }

        httpRequest.onreadystatechange = function ()
        {
            if (this.readyState == 4 && this.status == 200) {
                this.__user_callback__ = callback;
                this.__user_callback__(this.responseText);
            }
        }

        httpRequest.open('GET', url, true);
        httpRequest.send();
    };




    /**
    * Makes an AJAX POST request. It calls the given callback (a function) when ready
    * 
    * @param string   url      The URL to retrieve
    * @param object   data     The POST data
    * @param function callback A function that is called when the response is ready, there's an example below
    *                          called "myCallback".
    */
    RG.AJAX.POST = function (url, data, callback)
    {
        // Used when building the POST string
        var crumbs = [];






        // Mozilla, Safari, ...
        if (window.XMLHttpRequest) {
            var httpRequest = new XMLHttpRequest();

        // MSIE
        } else if (window.ActiveXObject) {
            var httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }





        httpRequest.onreadystatechange = function ()
        {
            if (this.readyState == 4 && this.status == 200) {
                this.__user_callback__ = callback;
                this.__user_callback__(this.responseText);
            }
        }

        httpRequest.open('POST', url, true);
        httpRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        
        for (i in data) {
            if (typeof i == 'string') {
                crumbs.push(i + '=' + encodeURIComponent(data[i]));
            }
        }

        httpRequest.send(crumbs.join('&'));
    };




    /**
    * Uses the above function but calls the call back passing a number as its argument
    * 
    * @param url string The URL to fetch
    * @param callback function Your callback function (which is passed the number as an argument)
    */
    RG.AJAX.getNumber = function (url, callback)
    {
        RG.AJAX(url, function ()
        {
            var num = parseFloat(this.responseText);

            callback(num);
        });
    };




    /**
    * Uses the above function but calls the call back passing a string as its argument
    * 
    * @param url string The URL to fetch
    * @param callback function Your callback function (which is passed the string as an argument)
    */
    RG.AJAX.getString = function (url, callback)
    {
        RG.AJAX(url, function ()
        {
            var str = String(this.responseText);

            callback(str);
        });
    };




    /**
    * Uses the above function but calls the call back passing JSON (ie a JavaScript object ) as its argument
    * 
    * @param url string The URL to fetch
    * @param callback function Your callback function (which is passed the JSON object as an argument)
    */
    RG.AJAX.getJSON = function (url, callback)
    {
        RG.AJAX(url, function ()
        {
            var json = eval('(' + this.responseText + ')');

            callback(json);
        });
    };




    /**
    * Uses the above RGraph.AJAX function but calls the call back passing an array as its argument.
    * Useful if you're retrieving CSV data
    * 
    * @param url string The URL to fetch
    * @param callback function Your callback function (which is passed the CSV/array as an argument)
    */
    RG.AJAX.getCSV = function (url, callback)
    {
        var separator = arguments[2] ? arguments[2] : ',';

        RG.AJAX(url, function ()
        {
            var regexp = new RegExp(separator);
            var arr = this.responseText.split(regexp);
            
            // Convert the strings to numbers
            for (var i=0,len=arr.length;i<len;++i) {
                arr[i] = parseFloat(arr[i]);
            }

            callback(arr);
        });
    };




    /**
    * Rotates the canvas
    * 
    * @param object canvas The canvas to rotate
    * @param  int   x      The X coordinate about which to rotate the canvas
    * @param  int   y      The Y coordinate about which to rotate the canvas
    * @param  int   angle  The angle(in RADIANS) to rotate the canvas by
    */
    RG.rotateCanvas =
    RG.RotateCanvas = function (ca, x, y, angle)
    {
        var co = ca.getContext('2d');

        co.translate(x, y);
        co.rotate(angle);
        co.translate(0 - x, 0 - y);    
    };




    /**
    * Measures text by creating a DIV in the document and adding the relevant text to it.
    * Then checking the .offsetWidth and .offsetHeight.
    * 
    * @param  string text   The text to measure
    * @param  bool   bold   Whether the text is bold or not
    * @param  string font   The font to use
    * @param  size   number The size of the text (in pts)
    * @return array         A two element array of the width and height of the text
    */
    RG.measureText =
    RG.MeasureText = function (text, bold, font, size)
    {
        // Add the sizes to the cache as adding DOM elements is costly and causes slow downs
        if (typeof RGraph.measuretext_cache === 'undefined') {
            RGraph.measuretext_cache = [];
        }

        var str = text + ':' + bold + ':' + font + ':' + size;
        if (typeof RGraph.measuretext_cache == 'object' && RGraph.measuretext_cache[str]) {
            return RGraph.measuretext_cache[str];
        }
        
        if (!RGraph.measuretext_cache['text-div']) {
            var div = document.createElement('DIV');
                div.style.position = 'absolute';
                div.style.top = '-100px';
                div.style.left = '-100px';
            document.body.appendChild(div);
            
            // Now store the newly created DIV
            RGraph.measuretext_cache['text-div'] = div;

        } else if (RGraph.measuretext_cache['text-div']) {
            var div = RGraph.measuretext_cache['text-div'];
        }

        div.innerHTML = text.replace(/\r\n/g, '<br />');
        div.style.fontFamily = font;
        div.style.fontWeight = bold ? 'bold' : 'normal';
        div.style.fontSize = (size || 12) + 'pt';
        
        var size = [div.offsetWidth, div.offsetHeight];

        //document.body.removeChild(div);
        RGraph.measuretext_cache[str] = size;
        
        return size;
    };




    /* New text function. Accepts two arguments:
    *  o obj - The chart object
    *  o opt - An object/hash/map of properties. This can consist of:
    *          x                The X coordinate (REQUIRED)
    *          y                The Y coordinate (REQUIRED)
    *          text             The text to show (REQUIRED)
    *          font             The font to use
    *          size             The size of the text (in pt)
    *          italic           Whether the text should be italic or not
    *          bold             Whether the text shouldd be bold or not
    *          marker           Whether to show a marker that indicates the X/Y coordinates
    *          valign           The vertical alignment
    *          halign           The horizontal alignment
    *          bounding         Whether to draw a bounding box for the text
    *          boundingStroke   The strokeStyle of the bounding box
    *          boundingFill     The fillStyle of the bounding box
    */
    RG.text2 =
    RG.Text2 = function (obj, opt)
    {
        /**
        * An RGraph object can be given, or a string or the 2D rendering context
        * The coords are placed on the obj.coordsText variable ONLY if it's an RGraph object. The function
        * still returns the cooords though in all cases.
        */
        if (obj && obj.isRGraph) {
            var obj = obj;
            var co  = obj.context;
            var ca  = obj.canvas;
        } else if (typeof obj == 'string') {
            var ca  = document.getElementById(obj);
            var co  = ca.getContext('2d');
            var obj = ca.__object__;
        } else if (typeof obj.getContext === 'function') {
            var ca = obj;
            var co = ca.getContext('2d');
            var obj = ca.__object__;
        } else if (obj.toString().indexOf('CanvasRenderingContext2D') != -1 || RGraph.ISIE8 && obj.moveTo) {
            var co  = obj;
            var ca  = obj.canvas;
            var obj = ca.__object__;

        // IE7/8
        } else if (RG.ISOLD && obj.fillText) {
            var co  = obj;
            var ca  = obj.canvas;
            var obj = ca.__object__;
        }

        var x              = opt.x;
        var y              = opt.y;
        var originalX      = x;
        var originalY      = y;
        var text           = opt.text;
        var text_multiline = typeof text === 'string' ? text.split(/\r?\n/g) : '';
        var numlines       = text_multiline.length;
        var font           = opt.font ? opt.font : 'Arial';
        var size           = opt.size ? opt.size : 10;
        var size_pixels    = size * 1.5;
        var bold           = opt.bold;
        var italic         = opt.italic;
        var halign         = opt.halign ? opt.halign : 'left';
        var valign         = opt.valign ? opt.valign : 'bottom';
        var tag            = typeof opt.tag == 'string' && opt.tag.length > 0 ? opt.tag : '';
        var marker         = opt.marker;
        var angle          = opt.angle || 0;



        
        
        
        
        
















        /**
        * Changed the name of boundingFill/boundingStroke - this allows you to still use those names
        */
        if (typeof opt.boundingFill === 'string')   opt['bounding.fill']   = opt.boundingFill;
        if (typeof opt.boundingStroke === 'string') opt['bounding.stroke'] = opt.boundingStroke;

        var bounding                = opt.bounding;
        var bounding_stroke         = opt['bounding.stroke'] ? opt['bounding.stroke'] : 'black';
        var bounding_fill           = opt['bounding.fill'] ? opt['bounding.fill'] : 'rgba(255,255,255,0.7)';
        var bounding_shadow         = opt['bounding.shadow'];
        var bounding_shadow_color   = opt['bounding.shadow.color'] || '#ccc';
        var bounding_shadow_blur    = opt['bounding.shadow.blur'] || 3;
        var bounding_shadow_offsetx = opt['bounding.shadow.offsetx'] || 3;
        var bounding_shadow_offsety = opt['bounding.shadow.offsety'] || 3;
        var bounding_linewidth      = opt['bounding.linewidth'] || 1;



        /**
        * Initialize the return value to an empty object
        */
        var ret = {};
        
        //
        // Color
        //
        if (typeof opt.color === 'string') {
            var orig_fillstyle = co.fillStyle;
            co.fillStyle = opt.color;
        }



        /**
        * The text arg must be a string or a number
        */
        if (typeof text == 'number') {
            text = String(text);
        }

        if (typeof text !== 'string') {
            return;
        }
        
        
        
        /**
        * This facilitates vertical text
        */
        if (angle != 0) {
            co.save();
            co.translate(x, y);
            co.rotate((ma.PI / 180) * angle)
            x = 0;
            y = 0;
        }


        
        /**
        * Set the font
        */
        co.font = (opt.italic ? 'italic ' : '') + (opt.bold ? 'bold ' : '') + size + 'pt ' + font;



        /**
        * Measure the width/height. This must be done AFTER the font has been set
        */
        var width=0;
        for (var i=0; i<numlines; ++i) {
            width = ma.max(width, co.measureText(text_multiline[i]).width);
        }
        var height = size_pixels * numlines;




        /**
        * Accommodate old MSIE 7/8
        */
        //if (document.all && RGraph.ISOLD) {
            //y += 2;
        //}



        /**
        * If marker is specified draw a marker at the X/Y coordinates
        */
        if (opt.marker) {
            var marker_size = 10;
            var strokestyle = co.strokeStyle;
            co.beginPath();
                co.strokeStyle = 'red';
                co.moveTo(x, y - marker_size);
                co.lineTo(x, y + marker_size);
                co.moveTo(x - marker_size, y);
                co.lineTo(x + marker_size, y);
            co.stroke();
            co.strokeStyle = strokestyle;
        }



        /**
        * Set the horizontal alignment
        */
        if (halign == 'center') {
            co.textAlign = 'center';
            var boundingX = x - 2 - (width / 2);
        } else if (halign == 'right') {
            co.textAlign = 'right';
            var boundingX = x - 2 - width;
        } else {
            co.textAlign = 'left';
            var boundingX = x - 2;
        }


        /**
        * Set the vertical alignment
        */
        if (valign == 'center') {
            
            co.textBaseline = 'middle';
            // Move the text slightly
            y -= 1;
            
            y -= ((numlines - 1) / 2) * size_pixels;
            var boundingY = y - (size_pixels / 2) - 2;
        
        } else if (valign == 'top') {
            co.textBaseline = 'top';

            var boundingY = y - 2;

        } else {

            co.textBaseline = 'bottom';
            
            // Move the Y coord if multiline text
            if (numlines > 1) {
                y -= ((numlines - 1) * size_pixels);
            }

            var boundingY = y - size_pixels - 2;
        }
        
        var boundingW = width + 4;
        var boundingH = height + 4;



        /**
        * Draw a bounding box if required
        */
        if (bounding) {

            var pre_bounding_linewidth     = co.lineWidth;
            var pre_bounding_strokestyle   = co.strokeStyle;
            var pre_bounding_fillstyle     = co.fillStyle;
            var pre_bounding_shadowcolor   = co.shadowColor;
            var pre_bounding_shadowblur    = co.shadowBlur;
            var pre_bounding_shadowoffsetx = co.shadowOffsetX;
            var pre_bounding_shadowoffsety = co.shadowOffsetY;

            co.lineWidth   = bounding_linewidth;
            co.strokeStyle = bounding_stroke;
            co.fillStyle   = bounding_fill;

            if (bounding_shadow) {
                co.shadowColor   = bounding_shadow_color;
                co.shadowBlur    = bounding_shadow_blur;
                co.shadowOffsetX = bounding_shadow_offsetx;
                co.shadowOffsetY = bounding_shadow_offsety;
            }

            //obj.context.strokeRect(boundingX, boundingY, width + 6, (size_pixels * numlines) + 4);
            //obj.context.fillRect(boundingX, boundingY, width + 6, (size_pixels * numlines) + 4);
            co.strokeRect(boundingX, boundingY, boundingW, boundingH);
            co.fillRect(boundingX, boundingY, boundingW, boundingH);

            // Reset the linewidth,colors and shadow to it's original setting
            co.lineWidth     = pre_bounding_linewidth;
            co.strokeStyle   = pre_bounding_strokestyle;
            co.fillStyle     = pre_bounding_fillstyle;
            co.shadowColor   = pre_bounding_shadowcolor
            co.shadowBlur    = pre_bounding_shadowblur
            co.shadowOffsetX = pre_bounding_shadowoffsetx
            co.shadowOffsetY = pre_bounding_shadowoffsety
        }

        
        
        /**
        * Draw the text
        */
        if (numlines > 1) {
            for (var i=0; i<numlines; ++i) {
                co.fillText(text_multiline[i], x, y + (size_pixels * i));
            }
        } else {
            co.fillText(text, x + 0.5, y + 0.5);
        }
        
        
        
        /**
        * If the text is at 90 degrees restore() the canvas - getting rid of the rotation
        * and the translate that we did
        */
        if (angle != 0) {
            if (angle == 90) {
                if (halign == 'left') {
                    if (valign == 'bottom') {boundingX = originalX - 2; boundingY = originalY - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'center') {boundingX = originalX - (height / 2) - 2; boundingY = originalY - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'top')    {boundingX = originalX - height - 2; boundingY = originalY - 2; boundingW = height + 4; boundingH = width + 4;}
                
                } else if (halign == 'center') {
                    if (valign == 'bottom') {boundingX = originalX - 2; boundingY = originalY - (width / 2) - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'center') {boundingX = originalX - (height / 2) -  2; boundingY = originalY - (width / 2) - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'top')    {boundingX = originalX - height -  2; boundingY = originalY - (width / 2) - 2; boundingW = height + 4; boundingH = width + 4;}
                
                } else if (halign == 'right') {
                    if (valign == 'bottom') {boundingX = originalX - 2; boundingY = originalY - width - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'center') {boundingX = originalX - (height / 2) - 2; boundingY = originalY - width - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'top')    {boundingX = originalX - height - 2; boundingY = originalY - width - 2; boundingW = height + 4; boundingH = width + 4;}
                }

            } else if (angle == 180) {

                if (halign == 'left') {
                    if (valign == 'bottom') {boundingX = originalX - width - 2; boundingY = originalY - 2; boundingW = width + 4; boundingH = height + 4;}
                    if (valign == 'center') {boundingX = originalX - width - 2; boundingY = originalY - (height / 2) - 2; boundingW = width + 4; boundingH = height + 4;}
                    if (valign == 'top')    {boundingX = originalX - width - 2; boundingY = originalY - height - 2; boundingW = width + 4; boundingH = height + 4;}
                
                } else if (halign == 'center') {
                    if (valign == 'bottom') {boundingX = originalX - (width / 2) - 2; boundingY = originalY - 2; boundingW = width + 4; boundingH = height + 4;}
                    if (valign == 'center') {boundingX = originalX - (width / 2) - 2; boundingY = originalY - (height / 2) - 2; boundingW = width + 4; boundingH = height + 4;}
                    if (valign == 'top')    {boundingX = originalX - (width / 2) - 2; boundingY = originalY - height - 2; boundingW = width + 4; boundingH = height + 4;}
                
                } else if (halign == 'right') {
                    if (valign == 'bottom') {boundingX = originalX - 2; boundingY = originalY - 2; boundingW = width + 4; boundingH = height + 4;}
                    if (valign == 'center') {boundingX = originalX - 2; boundingY = originalY - (height / 2) - 2; boundingW = width + 4; boundingH = height + 4;}
                    if (valign == 'top')    {boundingX = originalX - 2; boundingY = originalY - height - 2; boundingW = width + 4; boundingH = height + 4;}
                }
            
            } else if (angle == 270) {

                if (halign == 'left') {
                    if (valign == 'bottom') {boundingX = originalX - height - 2; boundingY = originalY - width - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'center') {boundingX = originalX - (height / 2) - 4; boundingY = originalY - width - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'top')    {boundingX = originalX - 2; boundingY = originalY - width - 2; boundingW = height + 4; boundingH = width + 4;}
                
                } else if (halign == 'center') {
                    if (valign == 'bottom') {boundingX = originalX - height - 2; boundingY = originalY - (width/2) - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'center') {boundingX = originalX - (height/2) - 4; boundingY = originalY - (width/2) - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'top')    {boundingX = originalX - 2; boundingY = originalY - (width/2) - 2; boundingW = height + 4; boundingH = width + 4;}
                
                } else if (halign == 'right') {
                    if (valign == 'bottom') {boundingX = originalX - height - 2; boundingY = originalY - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'center') {boundingX = originalX - (height/2) - 2; boundingY = originalY - 2; boundingW = height + 4; boundingH = width + 4;}
                    if (valign == 'top')    {boundingX = originalX - 2; boundingY = originalY - 2; boundingW = height + 4; boundingH = width + 4;}
                }
            }

            co.restore();
        }




        /**
        * Reset the text alignment so that text rendered after this text function is not affected
        */
        co.textBaseline = 'alphabetic';
        co.textAlign    = 'left';





        /**
        * Fill the ret variable with details of the text
        */
        ret.x      = boundingX;
        ret.y      = boundingY;
        ret.width  = boundingW;
        ret.height = boundingH
        ret.object = obj;
        ret.text   = text;
        ret.tag    = tag;



        /**
        * Save and then return the details of the text (but oly
        * if it's an RGraph object that was given)
        */
        if (obj && obj.isRGraph && obj.coordsText) {
            obj.coordsText.push(ret);
        }
        
        //
        // Restore the original fillstyle
        //
        if (typeof orig_fillstyle === 'string') {
            co.fillStyle = orig_fillstyle;
        }

        return ret;
    };




    /**
    * Takes a sequential index abd returns the group/index variation of it. Eg if you have a
    * sequential index from a grouped bar chart this function can be used to convert that into
    * an appropriate group/index combination
    * 
    * @param nindex number The sequential index
    * @param data   array  The original data (which is grouped)
    * @return              The group/index information
    */
    RG.sequentialIndexToGrouped = function (index, data)
    {
        var group         = 0;
        var grouped_index = 0;

        while (--index >= 0) {

            if (RG.is_null(data[group])) {
                group++;
                grouped_index = 0;
                continue;
            }

            // Allow for numbers as well as arrays in the dataset
            if (typeof data[group] == 'number') {
                group++
                grouped_index = 0;
                continue;
            }
            

            grouped_index++;
            
            if (grouped_index >= data[group].length) {
                group++;
                grouped_index = 0;
            }
        }
        
        return [group, grouped_index];
    };




    /**
    * This function highlights a rectangle
    * 
    * @param object obj    The chart object
    * @param number shape  The coordinates of the rect to highlight
    */
    RG.Highlight.rect =
    RG.Highlight.Rect = function (obj, shape)
    {
        var ca   = obj.canvas;
        var co   = obj.context;
        var prop = obj.properties;

        if (prop['chart.tooltips.highlight']) {
            
        
            // Safari seems to need this
            co.lineWidth = 1;

            /**
            * Draw a rectangle on the canvas to highlight the appropriate area
            */
            co.beginPath();

                co.strokeStyle = prop['chart.highlight.stroke'];
                co.fillStyle   = prop['chart.highlight.fill'];
    
                co.rect(shape['x'],shape['y'],shape['width'],shape['height']);
                //co.fillRect(shape['x'],shape['y'],shape['width'],shape['height']);
            co.stroke();
            co.fill();
        }
    };




    /**
    * This function highlights a point
    * 
    * @param object obj    The chart object
    * @param number shape  The coordinates of the rect to highlight
    */
    RG.Highlight.point =
    RG.Highlight.Point = function (obj, shape)
    {
        var prop = obj.properties;
        var ca   = obj.canvas;
        var co   = obj.context;

        if (prop['chart.tooltips.highlight']) {
    
            /**
            * Draw a rectangle on the canvas to highlight the appropriate area
            */
            co.beginPath();
                co.strokeStyle = prop['chart.highlight.stroke'];
                co.fillStyle   = prop['chart.highlight.fill'];
                var radius   = prop['chart.highlight.point.radius'] || 2;
                co.arc(shape['x'],shape['y'],radius, 0, RG.TWOPI, 0);
            co.stroke();
            co.fill();
        }
    };




    /**
    * This is the same as Date.parse - though a little more flexible.
    * 
    * @param string str The date string to parse
    * @return Returns the same thing as Date.parse
    */
    RG.parseDate = function (str)
    {
        str = RG.trim(str);

        // Allow for: now (just the word "now")
        if (str === 'now') {
            str = (new Date()).toString();
        }

        // Allow for: 2013-11-22 12:12:12 or  2013/11/22 12:12:12
        if (str.match(/^(\d\d\d\d)(-|\/)(\d\d)(-|\/)(\d\d)( |T)(\d\d):(\d\d):(\d\d)$/)) {
            str = RegExp.$1 + '-' + RegExp.$3 + '-' + RegExp.$5 + 'T' + RegExp.$7 + ':' + RegExp.$8 + ':' + RegExp.$9;
        }

        // Allow for: 2013-11-22
        if (str.match(/^\d\d\d\d-\d\d-\d\d$/)) {
            str = str.replace(/-/g, '/');
        }

        // Allow for: 12:09:44 (time only using todays date)
        if (str.match(/^\d\d:\d\d:\d\d$/)) {
        
            var dateObj  = new Date();
            var date     = dateObj.getDate();
            var month    = dateObj.getMonth() + 1;
            var year     = dateObj.getFullYear();
            
            // Pad the date/month with a zero if it's not two characters
            if (String(month).length === 1) month = '0' + month;
            if (String(date).length === 1) date = '0' + date;

            str = (year + '/' + month + '/' + date) + ' ' + str;
        }

        return Date.parse(str);
    };




    /**
    * Reset all of the color values to their original values
    * 
    * @param object
    */
    RG.resetColorsToOriginalValues = function (obj)
    {
        if (obj.original_colors) {
            // Reset the colors to their original values
            for (var j in obj.original_colors) {
                if (typeof j === 'string' && j.substr(0,6) === 'chart.') {
                    obj.properties[j] = RG.arrayClone(obj.original_colors[j]);
                }
            }
        }



        /**
        * If the function is present on the object to reset specific colors - use that
        */
        if (typeof obj.resetColorsToOriginalValues === 'function') {
            obj.resetColorsToOriginalValues();
        }



        // Reset the colorsParsed flag so that they're parsed for gradients again
        obj.colorsParsed = false;
    };




    /**
    * This function is a short-cut for the canvas path syntax (which can be rather verbose)
    * 
    * @param mixed  obj  This can either be the 2D context or an RGraph object
    * @param array  path The path details
    */
    RG.path =
    RG.Path = function (obj, path)
    {
        /**
        * Allow either the RGraph object or the context to be used as the first argument
        */
        if (obj.isRGraph && typeof obj.type === 'string') {
            var co = obj.context;
        } else {
            var co = obj;
               obj = obj.canvas.__object__;
        }

        /**
        * If the Path information has been passed as a  string - split it up
        */
        if (typeof path == 'string') {
            path = path.split(/ +/);
        }

        /**
        * Go through the path information
        */
        for (var i=0,len=path.length; i<len; i+=1) {
            
            var op = path[i];
            
            // 100,100,50,0,Math.PI * 1.5, false
            switch (op) {
                case 'b':co.beginPath();break;
                case 'c':co.closePath();break;
                case 'm':co.moveTo(parseFloat(path[i+1]),parseFloat(path[i+2]));i+=2;break;
                case 'l':co.lineTo(parseFloat(path[i+1]),parseFloat(path[i+2]));i+=2;break;
                case 's':if(path[i+1])co.strokeStyle=obj.parseSingleColorForGradient(path[i+1]);co.stroke();i++;break;
                case 'f':if(path[i+1]){co.fillStyle = obj.parseSingleColorForGradient(path[i+1]);}co.fill();i++;break;
                case 'qc':co.quadraticCurveTo(parseFloat(path[i+1]),parseFloat(path[i+2]),parseFloat(path[i+3]),parseFloat(path[i+4]));i+=4;break;
                case 'bc':co.bezierCurveTo(parseFloat(path[i+1]),parseFloat(path[i+2]),parseFloat(path[i+3]),parseFloat(path[i+4]),parseFloat(path[i+5]),parseFloat(path[i+6]));i+=6;break;
                case 'r':co.rect(parseFloat(path[i+1]),parseFloat(path[i+2]),parseFloat(path[i+3]),parseFloat(path[i+4]));i+=4;break;
                case 'a':co.arc(parseFloat(path[i+1]),parseFloat(path[i+2]),parseFloat(path[i+3]),parseFloat(path[i+4]),parseFloat(path[i+5]),path[i+6]==='true'||path[i+6]===true?true:false);i+=6;break;
                case 'at':co.arcTo(parseFloat(path[i+1]),parseFloat(path[i+2]),parseFloat(path[i+3]),parseFloat(path[i+4]),parseFloat(path[i+5]));i+=5;break;
                case 'lw':co.lineWidth=parseFloat(path[i+1]);i++;break;
                case 'lj':co.lineJoin=path[i+1];i++;break;
                case 'lc':co.lineCap=path[i+1];i++;break;
                case 'sc':co.shadowColor=path[i+1];i++;break;
                case 'sb':co.shadowBlur=parseFloat(path[i+1]);i++;break;
                case 'sx':co.shadowOffsetX=parseFloat(path[i+1]);i++;break;
                case 'sy':co.shadowOffsetY=parseFloat(path[i+1]);i++;break;
                case 'fu':(path[i+1])(obj);i++;break;
                case 'fs':co.fillStyle=obj.parseSingleColorForGradient(path[i+1]);i++;break;
                case 'ss':co.strokeStyle=obj.parseSingleColorForGradient(path[i+1]);i++;break;
                case 'fr':co.fillRect(parseFloat(path[i+1]),parseFloat(path[i+2]),parseFloat(path[i+3]),parseFloat(path[i+4]));i+=4;break;
                case 'sr':co.strokeRect(parseFloat(path[i+1]),parseFloat(path[i+2]),parseFloat(path[i+3]),parseFloat(path[i+4]));i+=4;break;
                case 'cl':co.clip();break;
                case 'ct':co.save();co.beginPath();RG.path(co, path[i+1]);co.clip();i++;break;
                case 'sa':co.save();break;
                case 'rs':co.restore();break;
            }
        }
    };



    /**
    * Creates a Linear gradient
    * 
    * @param object obj The chart object
    * @param number x1 The start X coordinate
    * @param number x2 The end X coordinate
    * @param number y1 The start Y coordinate
    * @param number y2 The end Y coordinate
    * @param string color1 The start color
    * @param string color2 The end color
    */
    RG.linearGradient =
    RG.LinearGradient = function (obj, x1, y1, x2, y2, color1, color2)
    {
        var gradient = obj.context.createLinearGradient(x1, y1, x2, y2);
        var numColors=arguments.length-5;
        
        for (var i=5; i<arguments.length; ++i) {
            
            var color = arguments[i];
            var stop = (i - 5) / (numColors - 1);
            
            gradient.addColorStop(stop, color);
        }
        
        return gradient;
    };



    
    /**
    * Creates a Radial gradient
    * 
    * @param object obj The chart object
    * @param number x1 The start X coordinate
    * @param number x2 The end X coordinate
    * @param number y1 The start Y coordinate
    * @param number y2 The end Y coordinate
    * @param string color1 The start color
    * @param string color2 The end color
    */
    RG.radialGradient =
    RG.RadialGradient = function(obj, x1, y1, r1, x2, y2, r2, color1, color2)
    {
        var gradient  = obj.context.createRadialGradient(x1, y1, r1, x2, y2, r2);
        var numColors = arguments.length-7;
        
        for(var i=7; i<arguments.length; ++i) {
            
            var color = arguments[i];
            var stop  = (i-7) / (numColors-1);
            
            gradient.addColorStop(stop, color);
        }
        
        return gradient;
    };




    /**
    * Adds an event listener to RGraphs internal array so that RGraph can track them.
    * This DOESN'T add the event listener to the canvas/window.
    * 
    * 5/1/14 TODO Used in the tooltips file, but is it necessary any more?
    */
    RG.addEventListener =
    RG.AddEventListener = function (id, e, func)
    {
        var type = arguments[3] ? arguments[3] : 'unknown';
        
        RG.Registry.get('chart.event.handlers').push([id,e,func,type]);
    };




    /**
    * Clears event listeners that have been installed by RGraph
    * 
    * @param string id The ID of the canvas to clear event listeners for - or 'window' to clear
    *                  the event listeners attached to the window
    */
    RG.clearEventListeners =
    RG.ClearEventListeners = function(id)
    {
        if (id && id == 'window') {
        
            window.removeEventListener('mousedown', window.__rgraph_mousedown_event_listener_installed__, false);
            window.removeEventListener('mouseup', window.__rgraph_mouseup_event_listener_installed__, false);
        
        } else {
            
            var canvas = document.getElementById(id);
            
            canvas.removeEventListener('mouseup', canvas.__rgraph_mouseup_event_listener_installed__, false);
            canvas.removeEventListener('mousemove', canvas.__rgraph_mousemove_event_listener_installed__, false);
            canvas.removeEventListener('mousedown', canvas.__rgraph_mousedown_event_listener_installed__, false);
            canvas.removeEventListener('click', canvas.__rgraph_click_event_listener_installed__, false);
        }
    };




    /**
    * Hides the annotating palette. It's here because it can be called
    * from code other than the annotating code.
    */
    RG.hidePalette =
    RG.HidePalette = function ()
    {
        var div = RG.Registry.get('palette');
        
        if(typeof div == 'object' && div) {
            
            div.style.visibility = 'hidden';
            div.style.display = 'none';
            
            RG.Registry.set('palette', null);
        }
    };




    /**
    * Generates a random number between the minimum and maximum
    * 
    * @param number min The minimum value
    * @param number max The maximum value
    * @param number     OPTIONAL Number of decimal places
    */
    RG.random = function (min, max)
    {
        var dp = arguments[2] ? arguments[2] : 0;
        var r  = ma.random();
        
        return Number((((max - min) * r) + min).toFixed(dp));
    };




    /**
    * 
    */
    RG.random.array = function (num, min, max)
    {
        var arr = [];
        
        for(var i=0; i<num; i+=1) {
            arr.push(RG.random(min,max));
        }
        
        return arr;
    };




    /**
    * Turns off shadow by setting blur to zero, the offsets to zero and the color to transparent black.
    * 
    * @param object obj The chart object
    */
    RG.noShadow =
    RG.NoShadow = function (obj)
    {
        var co = obj.context;

        co.shadowColor   = 'rgba(0,0,0,0)';
        co.shadowBlur    = 0;
        co.shadowOffsetX = 0;
        co.shadowOffsetY = 0;
    };




    /**
    * Sets the various shadow properties
    * 
    * @param object obj     The chart object
    * @param string color   The color of the shadow
    * @param number offsetx The offsetX value for the shadow
    * @param number offsety The offsetY value for the shadow
    * @param number blur    The blurring value for the shadow
    */
    RG.setShadow =
    RG.SetShadow = function (obj, color, offsetx, offsety, blur)
    {
        var co = obj.context;

        co.shadowColor   = color;
        co.shadowOffsetX = offsetx;
        co.shadowOffsetY = offsety;
        co.shadowBlur    = blur;

    };




    /**
    * Sets an object in the RGraph registry
    * 
    * @param string name The name of the value to set
    */
    RG.Registry.set =
    RG.Registry.Set = function (name, value)
    {
        // Convert uppercase letters to dot+lower case letter
        name = name.replace(/([A-Z])/g, function (str)
        {
            return '.' + String(RegExp.$1).toLowerCase();
        });
        
        // Ensure there is the chart. prefix
        if (name.substr(0,6) !== 'chart.') {
            name = 'chart.' + name;
        }

        RG.Registry.store[name] = value;
        
        return value;
    };




    /**
    * Gets an object from the RGraph registry
    * 
    * @param string name The name of the value to fetch
    */
    RG.Registry.get =
    RG.Registry.Get = function (name)
    {
        // Convert uppercase letters to dot+lower case letter
        name = name.replace(/([A-Z])/g, function (str)
        {
            return '.' + String(RegExp.$1).toLowerCase();
        });
        
        // Ensure there is the chart. prefix
        if (name.substr(0,6) !== 'chart.') {
            name = 'chart.' + name;
        }


        return RG.Registry.store[name];
    };




    /**
    * Converts the given number of degrees to radians. Angles in canvas are measured in radians
    * 
    * @param number deg The value to convert
    */
    RG.degrees2Radians = function (deg)
    {
        return deg * (RG.PI / 180);
    };




    /**
    * Generates logs for... ...log charts
    * 
    * @param number n    The number to generate the log for
    * @param number base The base to use
    */
    RG.log = function (n,base)
    {
        return ma.log(n) / (base ? ma.log(base) : 1);
    };




    /**
    * Determines if the given object is an array or not
    * 
    * @param mixed obj The variable to test
    */
    RG.isArray =
    RG.is_array = function (obj)
    {
        if (obj && obj.constructor) {
            var pos = obj.constructor.toString().indexOf('Array');
        } else {
            return false;
        }

        return obj != null &&
               typeof pos === 'number' &&
               pos > 0 &&
               pos < 20;
    };




    /**
    * Removes white-space from the start aqnd end of a string
    * 
    * @param string str The string to trim
    */
    RG.trim = function (str)
    {
        return RG.ltrim(RG.rtrim(str));
    };




    /**
    * Trims the white-space from the start of a string
    * 
    * @param string str The string to trim
    */
    RG.ltrim = function (str)
    {
        return str.replace(/^(\s|\0)+/, '');
    };




    /**
    * Trims the white-space off of the end of a string
    * 
    * @param string str The string to trim
    */
    RG.rtrim = function (str)
    {
        return str.replace(/(\s|\0)+$/, '');
    };



    /**
    * Returns true/false as to whether the given variable is null or not
    * 
    * @param mixed arg The argument to check
    */
    RG.isNull =
    RG.is_null = function (arg)
    {
        // must BE DOUBLE EQUALS - NOT TRIPLE
        if (arg == null || typeof arg === 'object' && !arg) {
            return true;
        }
        
        return false;
    };




    /**
    * This function facilitates a very limited way of making your charts
    * whilst letting the rest of page continue - using  the setTimeout function
    * 
    * @param function func The function to run that creates the chart
    */
    RG.async =
    RG.Async = function (func)
    {
        return setTimeout(func, arguments[1] ? arguments[1] : 1);
    };




    /**
    * Resets (more than just clears) the canvas and clears any pertinent objects
    * from the ObjectRegistry
    * 
    * @param object ca The canvas object (as returned by document.getElementById() ).
    */
    RG.reset =
    RG.Reset = function (ca)
    {
        ca.width = ca.width;
        
        RG.ObjectRegistry.clear(ca);
        
        ca.__rgraph_aa_translated__ = false;





        //
        // Clear any text objects that are in the cache
        //
        //var len = (ca.id + '-text-').length;

        //for (i in RG.cache) {
        //
        //    var value = RG.cache[i];

        //    if (i.substr(0, len) === (ca.id + '-text-') && typeof value === 'object' && value) {
        //        RG.cache[i].parentNode.removeChild(RG.cache[i]);
        //        RG.cache[i] = null;
        //    }
        //}
    };




    /**
    * NOT USED ANY MORE
    */
    RG.att = function (ca)
    {
    }



    /**
    * This function is due to be removed.
    * 
    * @param string id The ID of what can be either the canvas tag or a DIV tag
    */
    RG.getCanvasTag = function (id)
    {
        id = typeof id === 'object' ? id.id : id;
        var canvas = doc.getElementById(id);

        return [id, canvas];
    };




    /**
    * A wrapper function that encapsulate requestAnimationFrame
    * 
    * @param function func The animation function
    */
    RG.Effects.updateCanvas =
    RG.Effects.UpdateCanvas = function (func)
    {
        win.requestAnimationFrame =    win.requestAnimationFrame
                                    || win.webkitRequestAnimationFrame
                                    || win.msRequestAnimationFrame
                                    || win.mozRequestAnimationFrame
                                    || (function (func){setTimeout(func, 16.666);});
        
        win.requestAnimationFrame(func);
    };




    /**
    * This function returns an easing multiplier for effects so they eas out towards the
    * end of the effect.
    * 
    * @param number frames The total number of frames
    * @param number frame  The frame number
    */
    RG.Effects.getEasingMultiplier = function (frames, frame)
    {
        return ma.pow(ma.sin((frame / frames) * RG.HALFPI), 3);
    };




    /**
    * This function converts an array of strings to an array of numbers. Its used by the meter/gauge
    * style charts so that if you want you can pass in a string. It supports various formats:
    * 
    * '45.2'
    * '-45.2'
    * ['45.2']
    * ['-45.2']
    * '45.2,45.2,45.2' // A CSV style string
    * 
    * @param number frames The string or array to parse
    */
    RG.stringsToNumbers = function (str)
    {
        // An optional separator to use intead of a comma
        var sep = arguments[1] || ',';
        
        
        // If it's already a number just return it
        if (typeof str === 'number') {
            return str;
        }





        if (typeof str === 'string') {
            if (str.indexOf(sep) != -1) {
                str = str.split(sep);
            } else {
                str = parseFloat(str);
            }
        }





        if (typeof str === 'object') {
            for (var i=0,len=str.length; i<len; i+=1) {
                str[i] = parseFloat(str[i]);
            }
        }

        return str;
    };




    /**
    * Drawing cache function. This function creates an off-screen canvas and draws [wwhatever] to it
    * and then subsequent calls use that  instead of repeatedly drawing the same thing.
    * 
    * @param object   obj  The graph object
    * @param string   id   An ID string used to identify the relevant entry in the cache
    * @param function func The drawing function. This will be called to do the draw.
    */
    RG.cachedDraw = function (obj, id, func)
    {
        //If the cache entry xists - just copy it across to the main canvas
        if (!RG.cache[id]) {

            RG.cache[id] = {};
            RG.cache[id].object = obj;
             RG.cache[id].canvas = document.createElement('canvas');
             RG.cache[id].canvas.setAttribute('width', obj.canvas.width);
             RG.cache[id].canvas.setAttribute('height', obj.canvas.height);
             RG.cache[id].canvas.setAttribute('id', 'background_cached_canvas' + obj.canvas.id);
                        
            //Add MSIE support
            if (typeof G_vmlCanvasManager === 'object' && G_vmlCanvasManager.initElement) {
                G_vmlCanvasManager.initElement(RG.cache[id].canvas);
            }

            RG.cache[id].context = RG.cache[id].canvas.getContext('2d');
            
            // Antialiasing on the cache canvas
            RG.cache[id].context.translate(0.5,0.5);
            
            // Call the function
            func(obj, RG.cache[id].canvas, RG.cache[id].context);
        }
        
        // Now copy the contents of the cached canvas over to the main one.
        // The coordinates are -0.5 because of the anti-aliasing effect in
        // use on the main canvas
        obj.context.drawImage(RG.cache[id].canvas,-0.5,-0.5);
    };




    /**
    * The function that runs through the supplied configuration and
    * converts it to the RGraph stylee.
    * 
    * @param object conf The config
    * @param object      The settings for the object
    */
    RG.parseObjectStyleConfig = function (obj, config)
    {
        /**
        * The recursion function
        */
        var recurse = function (obj, config, name, settings)
        {
            var i;
    
            for (key in config) {

                // Allow for functions in the configuration. Run them immediately
                if (key.match(/^exec[0-9]*$/)) {
                    config[key](obj, settings);
                    continue;
                }

                var isObject = false; // Default value
                var isArray  = false; // Default value
                var value    = config[key];

                // Change caps to dots. Eg textSize => text.size
                while(key.match(/([A-Z])/)) {
                    key = key.replace(/([A-Z])/, '.' + RegExp.$1.toLowerCase());
                }

                if (!RG.isNull(value) && value.constructor) {
                    isObject = value.constructor.toString().indexOf('Object') > 0;
                    isArray  = value.constructor.toString().indexOf('Array') > 0;
                }

                if (isObject && !isArray) {
                    recurse(obj, config[key], name + '.' + key, settings);
                
                } else if (key === 'self') {
                    settings[name] = value;

                } else {
                    settings[name + '.' + key] = value;
                }
            }

            return settings;
        };




        /**
        * Go through the settings that we've been given
        */
        var settings = recurse(obj, config, 'chart', {});

        /**
        * Go through the settings and set them on the object
        */
        for (key in settings) {
            if (typeof key === 'string') {
                obj.set(key, settings[key]);
            }
        }
    };




    /**
    * This function is a short-cut for the canvas path syntax (which can be rather
    * verbose). You can read a description of it (which details all of the
    * various options) on the RGraph blog (www.rgraph.net/blog). The function is
    * added to the CanvasRenderingContext2D object so it becomes a context function.
    * 
    * So you can use it like these examples show:
    * 
    * 1. RG.pa2(context, 'b r 0 0 50 50 f red');
    * 2. RG.pa2(context, 'b a 50 50 50 0 3.14 false f red');
    * 3. RG.pa2(context, 'b m 5 100 bc 5 0 100 0 100 100 s red');
    * 4. RG.pa2(context, 'b m 5 100 at 50 0 95 100 50 s red');
    * 5. RG.pa2(context, 'sa b r 0 0 50 50 c b r 5 5 590 240 f red rs');
    * 6. RG.pa2(context, 'ld [2,6] ldo 4 b r 5 5 590 240 f red');
    * 7. RG.pa2(context, 'ga 0.25 b r 5 5 590 240 f red');
    * 
    * @param   array p  The path details
    */
    RG.path2 = function (co, p)
    {
        if (typeof p === 'string') {
            
            // Clear leading and trailing whitespace
            p = p.trim();




            // Allow for % placeholder substitution
            if (p.indexOf('%') !== -1) {

                p = p.split(/%/);

                for (var i=1; i<p.length; i+=1) {
                    p[i] = arguments[i+1].toString() + ' ' + p[i];
                }

                p = p.join(' ');
            }




            // Split up the path
            p = p.split(/ +/);
        }

        // Collapse args that are in single or double quotes
        p = collapseQuoted(p);


        // Go through the path information
        for (var i=0,len=p.length; i<len; i+=1) {

            switch (p[i]) {
                case 'b':co.beginPath();break;
                case 'c':co.closePath();break;
                case 'm':co.moveTo(parseFloat(p[i+1]),parseFloat(p[i+2]));i+=2;break;
                case 'l':co.lineTo(parseFloat(p[i+1]),parseFloat(p[i+2]));i+=2;break;
                case 's':if(p[i+1])co.strokeStyle=p[i+1];co.stroke();i++;break;
                case 'f':if(p[i+1]){co.fillStyle=p[i+1];}co.fill();i++;break;
                case 'qc':co.quadraticCurveTo(parseFloat(p[i+1]),parseFloat(p[i+2]),parseFloat(p[i+3]),parseFloat(p[i+4]));i+=4;break;
                case 'bc':co.bezierCurveTo(parseFloat(p[i+1]),parseFloat(p[i+2]),parseFloat(p[i+3]),parseFloat(p[i+4]),parseFloat(p[i+5]),parseFloat(p[i+6]));i+=6;break;
                case 'r':co.rect(parseFloat(p[i+1]),parseFloat(p[i+2]),parseFloat(p[i+3]),parseFloat(p[i+4]));i+=4;break;
                case 'a':co.arc(parseFloat(p[i+1]),parseFloat(p[i+2]),parseFloat(p[i+3]),parseFloat(p[i+4]),parseFloat(p[i+5]),p[i+6]==='true'||p[i+6]===true||p[i+6]===1||p[i+6]==='1'?true:false);i+=6;break;
                case 'at':co.arcTo(parseFloat(p[i+1]),parseFloat(p[i+2]),parseFloat(p[i+3]),parseFloat(p[i+4]),parseFloat(p[i+5]));i+=5;break;
                case 'lw':co.lineWidth=parseFloat(p[i+1]);i++;break;
                case 'e':co.ellipse(parseFloat(p[i+1]),parseFloat(p[i+2]),parseFloat(p[i+3]),parseFloat(p[i+4]),parseFloat(p[i+5]),parseFloat(p[i+6]),parseFloat(p[i+7]),p[i+8] === 'true' ? true : false);i+=8;break;
                case 'lj':co.lineJoin=p[i+1];i++;break;
                case 'lc':co.lineCap=p[i+1];i++;break;
                case 'sc':co.shadowColor=p[i+1];i++;break;
                case 'sb':co.shadowBlur=parseFloat(p[i+1]);i++;break;
                case 'sx':co.shadowOffsetX=parseFloat(p[i+1]);i++;break;
                case 'sy':co.shadowOffsetY=parseFloat(p[i+1]);i++;break;
                case 'fs':co.fillStyle=p[i+1];i++;break;
                case 'ss':co.strokeStyle=p[i+1];i++;break;
                case 'fr':co.fillRect(parseFloat(p[i+1]),parseFloat(p[i+2]),parseFloat(p[i+3]),parseFloat(p[i+4]));i+=4;break;
                case 'sr':co.strokeRect(parseFloat(p[i+1]),parseFloat(p[i+2]),parseFloat(p[i+3]),parseFloat(p[i+4]));i+=4;break;
                case 'cl':co.clip();break;
                case 'sa':co.save();break;
                case 'rs':co.restore();break;
                case 'tr':co.translate(parseFloat(p[i+1]),parseFloat(p[i+2]));i+=2;break;
                case 'sl':co.scale(parseFloat(p[i+1]), parseFloat(p[i+2]));i+=2;break;
                case 'ro':co.rotate(parseFloat(p[i+1]));i++;break;
                case 'tf':co.transform(parseFloat(p[i+1]),parseFloat(p[i+2]),parseFloat(p[i+3]),parseFloat(p[i+4]),parseFloat(p[i+5]),parseFloat(p[i+6]));i+=6;break;
                case 'stf':co.setTransform(parseFloat(p[i+1]),parseFloat(p[i+2]),parseFloat(p[i+3]),parseFloat(p[i+4]),parseFloat(p[i+5]),parseFloat(p[i+6]));i+=6;break;
                case 'cr':co.clearRect(parseFloat(p[i+1]),parseFloat(p[i+2]),parseFloat(p[i+3]),parseFloat(p[i+4]));i+=4;break;
                case 'ld':var parts = p[i+1].split(/,/);for (var j=0;j<parts.length; j++){parts[j] = parts[j].replace(/^\[/, '');parts[j] = parts[j].replace(/\]$/, '');}co.setLineDash(parts);i+=1;break;
                case 'ldo':co.lineDashOffset=p[i+1];i++;break;
                case 'fo':co.font=p[i+1];i++;break;
                case 'ft':co.fillText(p[i+1], parseFloat(p[i+2]), parseFloat(p[i+3]));i+=3;break;
                case 'st':co.strokeText(p[i+1], parseFloat(p[i+2]), parseFloat(p[i+3]));i+=3;break;
                case 'ta':co.textAlign=p[i+1];i++;break;
                case 'tbl':co.textBaseline=p[i+1];i++;break;
                case 'ga':co.globalAlpha=parseFloat(p[i+1]);i++;break;
                case 'gco':co.globalCompositeOperation=p[i+1];i++;break;
                
                // Empty option - ignore it
                case '':break;
                
                // Unknown option
                default: alert('[ERROR] Unknown option: ' + p[i]);
            }
        }
        
        //
        // This function looks for quoted args and collapses them
        //
        function collapseQuoted (arr)
        {
            var buffer = '', quote, index,out = [],quotes = ['"', "'"];

            for (var j=0; j<quotes.length; j+=1) {
                for (var i=0; i<arr.length; i+=1) {
                
                    // Start and close quotes in the same part
                    if (arr[i].match('/^' + quotes[j] + '/') && arr[i].match('/' + quotes[j] + '$/')) {
                        arr[i] = arr[i].substr(1, arr[i].length - 2);
                    }
                    
                    // Start quoted part
                    if (buffer.length === 0 && arr[i].indexOf(quotes[j]) !== -1) {
                        buffer = arr[i].substr(arr[i].indexOf(quotes[j]) + 1, arr[i].length);
                        quote = quotes[j];
                        index = i;
    
                    // End quoted part
                    } else if (quote && arr[i].indexOf(quote) !== -1) {
    
                        buffer = buffer + ' ' + arr[i].substr(0, arr[i].length - 1);
                        arr[index] = buffer;
                        arr[i] = '';
                        quote  = '';
                        buffer = '';
                    
                    // Add to quoted part
                    } else if (quote) {
                        buffer += ' ' + arr[i];
                        arr[i] = '';
                    }
                }
            }

            // Trim the array down
            for (i=0; i<arr.length; i+=1) {
                if (arr[i].length) {
                    out.push(arr[i]);
                }
            }

            return out;
        }
    };




    //
    // Wraps the canvas in a DIV to allow DOM text to be used
    //
    // NOT USED ANY MORE
    //
    RG.wrap = function () {};




// End module pattern
})(window, document);




    /**
    * Uses the alert() function to show the structure of the given variable
    * 
    * @param mixed v The variable to print/alert the structure of
    */
    window.$p  = function (v)
    {
        RGraph.pr(arguments[0], arguments[1], arguments[3]);
    };




    /**
    * A shorthand for the default alert() function
    */
    window.$a = function (v)
    {
        alert(v);
    };




    /**
    * Short-hand for console.log
    * 
    * @param mixed v The variable to log to the console
    */
    window.$cl = function (v)
    {
        return console.log(v);
    };
