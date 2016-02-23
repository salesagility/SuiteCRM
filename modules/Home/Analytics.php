<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
global $sugar_config, $mod_strings;
?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<link rel="stylesheet" type="text/css" href="include/javascript/jpivot/pivot.css">
<!--<script type="text/javascript" src="include/javascript/jquery/jquery-min.js"></script>-->
<!--<script type="text/javascript" src="include/javascript/jquery/jquery-ui-min.js"></script>-->
<script type="text/javascript" src="include/javascript/jpivot/pivot.js"></script>
<script type="text/javascript" src="include/javascript/jpivot/c3_renderers.js"></script>


<!--<script type="text/javascript" src="include/javascript/cookie.js"></script>-->

<script type="text/javascript">

    var data = [{color: "blue", shape: "hexagon"},{color: "red", shape: "triangle"}];

    $(function() {
        var renderers = $.extend($.pivotUtilities.renderers, $.pivotUtilities.c3_renderers);

        $('#analysisType').change(function(){
            getDataForPivot();
        });

        function getDataForPivot()
        {
            var type = $('#analysisType').val();
            if(type !== undefined)
            {
                $.getJSON("index.php",
                    {
                        'module': 'Home',
                        'action': type,
                        'to_pdf':1
                    },
                    function (mps) {
                        $("#output").pivotUI(mps, {renderers: renderers}
                        );
                    });
            }

        }
        getDataForPivot();

    });
</script>
<hr>
<label for="analysisType">Area for Analysis:</label>
<select id="analysisType">
    <option value="getSalesPivotData">Sales</option>
    <option value="getAccountsPivotData">Accounts</option>
    <option value="getLeadsPivotData">Leads</option>
</select>
<div id="output" style="margin: 30px;"></div>
