<?php
$chart = <<<EOD
        <script type='text/javascript' src='../SuiteCRM/include/SuiteGraphs/rgraph/libraries/RGraph.common.core.js' ></script>
        <script type='text/javascript' src='../SuiteCRM/include/SuiteGraphs/rgraph/libraries/RGraph.funnel.js' ></script>
        <script type='text/javascript' src='../SuiteCRM/include/SuiteGraphs/rgraph/libraries/RGraph.common.dynamic.js'></script>
        <script type='text/javascript' src='../SuiteCRM/include/SuiteGraphs/rgraph/libraries/RGraph.common.key.js'></script>
        <script type='text/javascript' src='../SuiteCRM/include/SuiteGraphs/rgraph/libraries/RGraph.drawing.rect.js'></script>
        <script type='text/javascript' src='../SuiteCRM/include/SuiteGraphs/rgraph/libraries/RGraph.drawing.text.js'></script>
        <script type='text/javascript' src='../SuiteCRM/include/SuiteGraphs/rgraph/libraries/RGraph.common.effects.js'></script>
        <script type='text/javascript' src='../SuiteCRM/include/SuiteGraphs/rgraph/libraries/RGraph.common.tooltips.js'></script>
        <script type='text/javascript' src='../SuiteCRM/include/SuiteGraphs/rgraph/libraries/RGraph.pie.js'></script>

        <script>
            function rgraphMouseMove(e,shape)
            {
                e.target.style.cursor = 'pointer';
            }

            function opportunitiesByLeadSourceDashletClick(e,bar)
            {
            if(bar['object']!== undefined && bar['object']['id']!==undefined)
            {
                var graphId = bar['object']['id'];
                var divHolder = $("#"+graphId).parent();
                var module = $(divHolder).find(".module").val();
                var action = $(divHolder).find(".action").val();
                var query = $(divHolder).find(".query").val();
                var searchFormTab = $(divHolder).find(".searchFormTab").val();

                var labels = bar["object"]["properties"]["chart.labels"];
                var clicked = encodeURI(labels[bar[5]]);

                window.open('http://localhost/SuiteCRM/index.php?module='+module+'&action='+action+'&query='+query+'&searchFormTab='+searchFormTab+'&lead_source='+clicked,'_blank');
            }
                else
                alert("Sorry, there has been an error with the click-through event");
            }

            function myFunnelClick(e,bar)
            {
            if(bar[0]!== undefined && bar[0]['id']!==undefined)
            {
                var graphId = bar[0]['id'];
                var divHolder = $("#"+graphId).parent();
                var module = $(divHolder).find(".module").val();
                var action = $(divHolder).find(".action").val();
                var query = $(divHolder).find(".query").val();
                var searchFormTab = $(divHolder).find(".searchFormTab").val();
                var startDate = $(divHolder).find(".startDate").val();
                var endDate = $(divHolder).find(".endDate").val();

                var labels = bar["object"]["properties"]["chart.key"];
                var clicked = encodeURI(labels[bar[2]]);

                window.open('http://localhost/SuiteCRM/index.php?module='+module+'&action='+action+'&query='+query+'&searchFormTab='+searchFormTab+'&start_range_date_closed='+startDate+'&end_range_date_closed='+endDate+'&sales_stage='+clicked,'_blank');
            }
                else
                alert("Sorry, there has been an error with the click-through event");
            }
        </script>
EOD;
echo($chart);