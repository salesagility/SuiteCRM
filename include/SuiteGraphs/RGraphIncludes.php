<?php
$chart = <<<EOD
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.core.js' ></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.dynamic.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.key.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.effects.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.tooltips.js'></script>

        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.funnel.js' ></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.drawing.rect.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.drawing.text.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.pie.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.bar.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.hbar.js'></script>

        <script>
            function rgraphMouseMove(e,shape)
            {
                e.target.style.cursor = 'pointer';
            }

            function myPipelineBySalesStageClick(e,bar)
            {
                                if( bar !== undefined
                &&  bar[5] !== undefined
                &&  bar['object'] !== undefined
                &&  bar['object']['properties'] !== undefined
                &&  bar['object']['properties']['chart.tooltips']!== undefined
                &&  bar['object']['properties']['chart.tooltips'][bar[5]] !== undefined)
                {
                    var stage = encodeURI(bar['object']['properties']['chart.labels'][bar[5]]);
                    var graphId = bar[0]['id'];
                    var divHolder = $("#"+graphId).parent();
                    var module = $(divHolder).find(".module").val();
                    var action = $(divHolder).find(".action").val();
                    var query = $(divHolder).find(".query").val();
                    var searchFormTab = $(divHolder).find(".searchFormTab").val();
                    var userId = $(divHolder).find(".userId").val();
                    var startDate = encodeURI($(divHolder).find(".startDate").val());
                    var endDate = encodeURI($(divHolder).find(".endDate").val());
                    window.open('http://localhost/SuiteCRM/index.php?module='+module+'&action='+action+'&query='+query+'&searchFormTab='+searchFormTab+'&assigned_user_id[]='+userId+'&date_closed_advanced_range_choice=between&start_range_date_closed_advanced='+startDate+'&end_range_date_closed_advanced='+endDate+'&sales_stage_advanced[]='+stage,'_blank');
                }
            }

            function outcomeByMonthClick(e,bar)
            {
                 if( bar !== undefined
                &&  bar[5] !== undefined
                &&  bar['object'] !== undefined
                &&  bar['object']['properties'] !== undefined
                &&  bar['object']['properties']['chart.tooltips']!== undefined
                &&  bar['object']['properties']['chart.tooltips'][bar[5]] !== undefined)
                {
                    var info = bar['object']['properties']['chart.tooltips'][bar[5]];
                    var stage = $(info).find('.stage').val();
                    var date = $(info).find('.date').val();

                    stage = encodeURI($.trim(stage));
                    date = encodeURI($.trim(date));
                    //console.log(stage + ' ' + date);
                    window.open('http://localhost/SuiteCRM/index.php?module=Opportunities&action=index&query=true&searchFormTab=advanced_search&date_closed_advanced='+date+'&sales_stage='+stage,'_blank');
                }
            }

            function allOpportunititesByLeadSourceByOutcomeClick(e,bar)
            {
                if( bar !== undefined
                &&  bar[5] !== undefined
                &&  bar['object'] !== undefined
                &&  bar['object']['properties'] !== undefined
                &&  bar['object']['properties']['chart.tooltips']!== undefined
                &&  bar['object']['properties']['chart.tooltips'][bar[5]] !== undefined)
                {
                    var info = bar['object']['properties']['chart.tooltips'][bar[5]];
                    var stage = $(info).find('.stage').val();
                    var category = $(info).find('.category').val();

                    stage = encodeURI($.trim(stage));
                    category = encodeURI($.trim(category));
                    window.open('http://localhost/SuiteCRM/index.php?module=Opportunities&action=index&query=true&searchFormTab=advanced_search&lead_source='+category+'&sales_stage='+stage,'_blank');
                }
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