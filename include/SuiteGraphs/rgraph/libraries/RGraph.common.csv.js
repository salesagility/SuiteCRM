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

    /**
    * Initialise the various objects
    */
    RGraph = window.RGraph || {isRGraph: true};




    RGraph.CSV = function (url, func)
    {
        var RG  = RGraph,
            ua  = navigator.userAgent,
            ma  = Math;




        /**
        * Some default values
        */
        this.url       = url;
        this.ready     = func;
        this.data      = null;
        this.numrows   = null;
        this.numcols   = null;
        this.separator = arguments[2] || ',';
        this.endofline = arguments[3] || /\r?\n/;




        /**
        * A Custom split function
        * 
        * @param string str  The CSV string to split
        * @param mixed  char The character to split on - or it can also be an object like this:
        *                    {
        *                        preserve: false, // Whether to preserve whitespace
        *                        char: ','        // The character to split on
        *                    }
        */
        this.splitCSV = function (str, split)
        {
            // Defaults
            var arr            = [];
            var field          = '';
            var inDoubleQuotes = false;
            var inSingleQuotes = false;
            var preserve       = (typeof split === 'object' && split.preserve) ? true : false;
            
            // The character to split the CSV string on
            if (typeof split === 'object') {
                if (typeof split.char === 'string') {
                    split = split.char;
                } else {
                    split = ',';
                }
            } // If not an object just leave the char as it's supplied



            for (var i=0,len=str.length; i<len; i+=1) {
                
                char = str.charAt(i);
                
                if ( (char === '"') && !inDoubleQuotes) {
                    inDoubleQuotes = true;
                    continue;
                
                } else if ( (char === '"') && inDoubleQuotes) {
                    inDoubleQuotes = false;
                    continue;
                }
                if ( (char === "'") && !inSingleQuotes) {
                    inSingleQuotes = true;
                    continue;
                
                } else if ( (char === "'") && inSingleQuotes) {
                    inSingleQuotes = false;
                    continue;
    
                } else if (char === split && !inDoubleQuotes && !inSingleQuotes) {
// TODO look ahead in order to allow for multi-character separators
                    arr.push(field);
                    field = '';
                    continue;
    
                } else {
                    field = field + char;
                }
            }
            
            // Add the last field
            arr.push(field);
            
            // Now trim each value if necessary
            if (!preserve) {
                for (i=0,len=arr.length; i<len; i+=1) {
                    arr[i] = arr[i].trim();
                }
            }
    
            return arr;
        };




        /**
        * This function splits the CSV data into an array so that it can be useful.
        */
        this.fetch = function ()
        {
            var sep = this.separator;
            var eol = this.endofline;
            var obj = this;

            if (this.url.substring(0,3) == 'id:') {

                // Get rid of any surrounding whitespace
                var data = document.getElementById(this.url.substring(3)).innerHTML.trim();

                // Store the CSV data on the CSV object (ie - this object)
                obj.data = data.split(eol);

                // Store the number of rows
                obj.numrows = obj.data.length;

                for (var i=0,len=obj.data.length; i<len; i+=1) {


                    /**
                    * Split the individual line
                    */
                    //var row = obj.data[i].split(sep);
                    var row = obj.splitCSV(obj.data[i], {preserve: false, char: sep});


                    if (!obj.numcols) {
                        obj.numcols = row.length;
                    }

                    /**
                    * If the cell is purely made up of numbers - convert it
                    */
                    for (var j=0; j<row.length; j+=1) {
                        if ((/^[0-9.]+$/).test(row[j])) {
                            row[j] = parseFloat(row[j]);
                        }
                            
                        // Assign the split-up-row back to the data array
                        obj.data[i] = row;
                    }
                }
                
                // Call the ready function straight away
                obj.ready(obj);

            } else {

                RGraph.AJAX.getString(this.url, function (data)
                {
                    data = data.replace(/(\r?\n)+$/, '');

                    /**
                    * Split the lines in the CSV
                    */
                    obj.data = data.split(eol);

                    /**
                    * Store the number of rows
                    */
                    obj.numrows = obj.data.length;



                    /**
                    * Loop thru each lines in the CSV file
                    */
                    for (var i=0,len=obj.data.length; i<len; i+=1) {
                        /**
                        * Use the new split function to split each row NOT preserving whitespace
                        */
                        //var row = obj.data[i].split(sep);
                        var row = obj.splitCSV(obj.data[i], {preserve: false, char: sep});

                        if (!obj.numcols) {
                            obj.numcols = row.length;
                        }

                        /**
                        * If the cell is purely made up of numbers - convert it
                        */
                        for (var j=0; j<row.length; j+=1) {
                            if ((/^\-?[0-9.]+$/).test(row[j])) {
                                row[j] = parseFloat(row[j]);
                            }

                            // Assign the split-up-row back to the data array
                            obj.data[i] = row;
                        }

                    }

                    // Call the ready function straight away
                    obj.ready(obj);
                });
            }
        };




        /**
        * Returns a row of the CSV file
        * 
        * @param number index The index of the row to fetch
        * @param        start OPTIONAL If desired you can specify a column to start at (which starts at 0 by default)
        */
        this.getRow = function (index)
        {
            var row   = [];
            var start = arguments[1] || 0;

            for (var i=start; i<this.numcols; i+=1) {
                row.push(this.data[index][i]);
            }
            
            return row;
        };




        /**
        * Returns a column of the CSV file
        * 
        * @param number index The index of the column to fetch
        * @param        start OPTIONAL If desired you can specify a row to start at (which starts at 0 by default)
        */
        this.getCol =
        this.getColumn = function (index)
        {
            var col   = [];
            var start = arguments[1] || 0;

            for (var i=start; i<this.numrows; i+=1) {
                col.push(this.data[i][index]);
            }
            
            return col;
        };





        // Fetch the CSV file
        this.fetch();
    };
