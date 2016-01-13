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

            function resizeGraph(graph)
            {
                var maxWidth = 900;
                var maxHeight = 500;
                var maxTextSize = 10;

                if($(window).width() * 0.8 > maxWidth)
                    graph.width  = maxWidth;
                else
                    graph.width = $(window).width() * 0.8;
                if($(window).width() * 0.5 > maxHeight)
                    graph.height = maxHeight;
                else
                    graph.height = $(window).width() * 0.5;



                var text_size = Math.min(12, ($(window).width() / 1000) * 10 );
                if(text_size > maxTextSize) text_size = maxTextSize;
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
                    window.open('index.php?module='+module+'&action='+action+'&query='+query+'&searchFormTab='+searchFormTab+'&assigned_user_id[]='+userId+'&date_closed_advanced_range_choice=between&start_range_date_closed_advanced='+startDate+'&end_range_date_closed_advanced='+endDate+'&sales_stage_advanced[]='+stage,'_self');
                }
            }

            function reportClickThroughForData(e,bar)
            {

                if(     bar["object"] !== undefined
                    &&  bar["object"]["id"] !== undefined)
                {
                    var canvasId = bar["object"]["id"];
                    var parent =  $("canvas#"+canvasId).parent();

                    var clicked;
                    if(bar['tooltip'] !== undefined && bar['tooltip'].length > 0)
                        clicked = bar['tooltip'];

                    var chartId = undefined;
                    if(     arguments !== undefined
                    &&  arguments[1] !== undefined
                    &&  arguments[1]["object"]!== undefined
                    &&  arguments[1]["object"]["id"] !== undefined)
                    chartId = arguments[1]["object"]["id"];

                var dashletId = $( "li[id^='dashlet_']" ).has("#"+chartId).attr("id")
                if(dashletId !== undefined)
                    dashletId = dashletId.replace("dashlet_","");

                    if($(parent).find('.clickThroughDataHolder').length === 0)
                        $(parent).append("<div class='clickThroughDataHolder'><h3 class='backToGraph'>Back to Graph</h3><div class='clickThroughData'></div></div>");
                    else
                    {
                        $(parent).find('.clickThroughDataHolder').show();
                    }

                    //$(parent).find('.clickThroughDataHolder').find(".clickThroughData").empty().append(clicked);

                    //Get the data asynchronously and only hide the graph when the data table is here
                    $.ajax({
                      url: 'index.php?action=DynamicAction&DynamicAction=getDataForDashlet&chartId='+chartId+'&dashletId='+dashletId+'&clickedItem='+clicked
                      //context: $(parent).find('.clickThroughDataHolder').find(".clickThroughData")
                    }).done(function(data) {
                      //$( this ).addClass( "done" );
                      alert(data);
                    });




                    $("body").on("click",".backToGraph",function(){
                        $("canvas#"+canvasId).show();
                        $(this).parent().hide();
                    });

                    $("canvas#"+canvasId).hide();
                }


            /*
                console.log(e);
                console.log(bar);
                var clicked = "";
                if(bar['tooltip'] !== undefined && bar['tooltip'].length > 0)
                    clicked = bar['tooltip'];

                var chartId = "";
                if(     arguments !== undefined
                    &&  arguments[1] !== undefined
                    &&  arguments[1]["object"]!== undefined
                    &&  arguments[1]["object"]["id"] !== undefined)
                    chartId = arguments[1]["object"]["id"];

                var dashletId = $( "li[id^='dashlet_']" ).has("#"+chartId).attr("id")
                if(dashletId !== undefined)
                    dashletId = dashletId.replace("dashlet_","");

                //alert("Chart ID is "+chartId+" and the click through is "+clicked +" and the dashlet ID is "+dashletId);

                //SUGAR.mySugar.retrieveDashlet('60674072-5747-56f2-27c1-568fcf145371'); return false;
                var cObj = YAHOO.util.Connect.asyncRequest('GET', 'index.php?action=DynamicAction&DynamicAction=getDataForDashlet&chartId='+chartId+'&dashletId='+dashletId+'&clickedItem='+clicked,
			                    {success: alert("success"), failure: alert("error")}, null);
                */

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
                var clicked = encodeURI(labels[bar[5]]);

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

                var labels = bar["object"]["properties"]["chart.key"];
                var clicked = encodeURI(labels[bar[2]]);

                window.open('index.php?module='+module+'&action='+action+'&query='+query+'&searchFormTab='+searchFormTab+'&start_range_date_closed='+startDate+'&end_range_date_closed='+endDate+'&sales_stage='+clicked,'_self');
            }
                else
                alert("Sorry, there has been an error with the click-through event");
            }
        </script>
EOD;
echo($chart);