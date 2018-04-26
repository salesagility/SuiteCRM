<?php
$chart = <<<EOD
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.core.js' ></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.dynamic.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.key.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.effects.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.tooltips.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.context.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.common.annotate.js'></script>

        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.funnel.js' ></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.drawing.rect.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.drawing.text.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.pie.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.bar.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.line.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.radar.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.hbar.js'></script>
        <script type='text/javascript' src='include/SuiteGraphs/rgraph/libraries/RGraph.rose.js'></script>

        <script>
            function rgraphMouseMove(e,shape)
            {
                e.target.style.cursor = 'pointer';
            }

            	var maxYForSmallNumbers = 5;    //The Y axis for bars needs to have at least a max of 5 of it shows (0,0,0,1,1) as per bug 876
                function calculateMaxYForSmallNumbers(dataPoints)
                {
                    var largest = null;
                    if(dataPoints !== undefined && dataPoints.length > 0)
                        largest = Math.max.apply(Math,dataPoints);//http://stackoverflow.com/a/14693622/3894683

                    if (largest === null || largest < maxYForSmallNumbers) {
                      return maxYForSmallNumbers;
                    }
                    return(null);
                }

            function resizeGraph(graph)
            {
              var maxHeight = 500;
              var maxTextSize = 10;
    
              graph.width = $(graph).parent().width();
              graph.height = ($(graph).parent().height() < maxHeight ? $(graph).parent().height() : maxHeight);
    
              var text_size = Math.min(maxTextSize, (graph.width / 700) * 10 );
              graph.__object__["properties"]["chart.text.size"] = text_size;
              graph.__object__["properties"]["chart.key.text.size"] = text_size;
                
              RGraph.redrawCanvas(graph);
            }

            function resizeGraphs()
            {
              var graphs = $(".resizableCanvas");
              $.each(graphs,function(i,v){
                resizeGraph(v);
              });
            }

            $(window).resize(function ()
            {
              resizeGraphs();
            });


            function myPipelineBySalesStageClick(e,bar)
            {
                                if( bar !== undefined
                &&  bar[5] !== undefined
                &&  bar['object'] !== undefined
                &&  bar['object']['properties'] !== undefined
                &&  bar['object']['properties']['chart.tooltips']!== undefined
                &&  bar['object']['properties']['chart.tooltips'][bar[5]] !== undefined)
                {
                    var graphId = bar[0]['id'];
                    var divHolder = $("#"+graphId).parent();
                    var module = $(divHolder).find(".module").val();
                    var action = $(divHolder).find(".action").val();
                    var query = $(divHolder).find(".query").val();
                    var searchFormTab = $(divHolder).find(".searchFormTab").val();
                    var userId = $(divHolder).find(".userId").val();
                    var startDate = encodeURI($(divHolder).find(".startDate").val());
                    var endDate = encodeURI($(divHolder).find(".endDate").val());
                    
                    var keys = window["chartHBarKeys"+graphId];
                    var stage = encodeURI(keys[bar[5]]);
                    
                    window.open('index.php?module='+module+'&action='+action+'&query='+query+'&searchFormTab='+searchFormTab+'&assigned_user_id[]='+userId+'&date_closed_advanced_range_choice=between&start_range_date_closed_advanced='+startDate+'&end_range_date_closed_advanced='+endDate+'&sales_stage_advanced[]='+stage,'_self');
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
                    window.open('index.php?module=Opportunities&action=index&query=true&searchFormTab=advanced_search&date_closed_advanced='+date+'&sales_stage='+stage,'_self');
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
                    window.open('index.php?module=Opportunities&action=index&query=true&searchFormTab=advanced_search&lead_source='+category+'&sales_stage='+stage,'_self');
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

                var keys = window["chartHBarKeys"+graphId];
                var clicked = encodeURI(keys[bar[5]]);

                window.open('index.php?module='+module+'&action='+action+'&query='+query+'&searchFormTab='+searchFormTab+'&lead_source='+clicked,'_self');
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

                var labels = bar["object"]["properties"]["chart.labels"];
                var keys = window["chartHBarKeys"+graphId];
                var clicked = encodeURI(keys[bar[5]]);

                window.open('index.php?module='+module+'&action='+action+'&query='+query+'&searchFormTab='+searchFormTab+'&start_range_date_closed='+startDate+'&end_range_date_closed='+endDate+'&sales_stage='+clicked,'_self');
            }
                else
                alert("Sorry, there has been an error with the click-through event");
            }
        </script>
EOD;
echo($chart);
