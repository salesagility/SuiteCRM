/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/




function loadSugarChart (chartId,jsonFilename,css,chartConfig) {

                //Bug#45831
                if(document.getElementById(chartId) == null) {
                    return false;
                }

				var labelType, useGradients, nativeTextSupport, animate;		    	
				(function() {
				  var ua = navigator.userAgent,
					  typeOfCanvas = typeof HTMLCanvasElement,
					  nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
					  textSupport = nativeCanvasSupport 
						&& (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
				  labelType = 'Native';
				  nativeTextSupport = labelType == 'Native';
				  useGradients = nativeCanvasSupport;
				  animate = false;
				})();
				
			var delay = 500;
			switch(chartConfig["chartType"]) {
			case "barChart":
				var handleFailure = function(o){
				alert('fail');
					if(o.responseText !== undefined){
						alert('failed');
					}
				}	
				var handleSuccess = function(o){

					if(o.responseText !== undefined && o.responseText != "No Data"){	
					var json = eval('('+o.responseText+')');

				var properties = $jit.util.splat(json.properties)[0];	
				var marginBottom = (chartConfig["orientation"] == 'vertical' && json.values.length > 8) ? 20*4 : 20;

                 // Bug #49732 : Bars in charts overlapping
                // if to many data to display fix canvas width and set up width to container to allow overflow
                if ( chartConfig["orientation"] == 'vertical' )
                {
                    function fixChartContainer(event, itemsCount)
                    {
                        var region = YAHOO.util.Dom.getRegion('content');
                        if ( region && region.width )
                        {
                            // one bar needs about 40 px to correct display data and labels
                            var realWidth = itemsCount * 40;
                            if ( realWidth > region.width )
                            {
                                var chartCanvas = YAHOO.util.Dom.getElementsByClassName('chartCanvas', 'div');
                                var chartContainer = YAHOO.util.Dom.getElementsByClassName('chartContainer', 'div');
                                if ( chartContainer.length > 0 && chartCanvas.length > 0 )
                                {
                                    chartContainer = YAHOO.util.Dom.get(chartContainer[0])
                                    YAHOO.util.Dom.setStyle(chartContainer, 'width', region.width+'px')
                                    chartCanvas = YAHOO.util.Dom.get(chartCanvas[0]);
                                    YAHOO.util.Dom.setStyle(chartCanvas, 'width', realWidth+'px');
                                    if (!event)
                                    {
                                        YAHOO.util.Event.addListener(window, "resize", fixChartContainer, json.values.length);
                                    }
                                }
                            }
                        }
                    }
                    fixChartContainer(null, json.values.length);
                }

				//init BarChart
				var barChart = new $jit.BarChart({
				  //id of the visualization container
				  injectInto: chartId,
				  //whether to add animations
				  animate: false,
				  nodeCount: json.values.length,
				  renderBackground: chartConfig['imageExportType'] == "jpg" ? true: false,
				  backgroundColor: 'rgb(255,255,255)',
				  colorStop1: 'rgba(255,255,255,.8)',
				  colorStop2: 'rgba(255,255,255,0)',
				  shadow: {
				     enable: true,
				     size: 2	
				  },
				  //horizontal or vertical barcharts
				  orientation: chartConfig["orientation"],
				  hoveredColor: false,
				  Title: {
					text: properties['title'],
					size: 16,
					color: '#444444',
					offset: 20
				  },
				  Subtitle: {
					text: properties['subtitle'],
					size: 11,
					color: css["color"],
					offset: 20
				  },
				  Ticks: {
					enable: true,
					color: css["gridLineColor"]
				  },
				  //bars separation
				  barsOffset: (chartConfig["orientation"] == "vertical") ? 30 : 20,
				  //visualization offset
				  Margin: {
					top:20,
					left: 30,
					right: 20,
					bottom: marginBottom
				  },
				  ScrollNote: {
				  	text: (chartConfig["scroll"] && SUGAR.util.isTouchScreen()) ? "Use two fingers to scroll" : "",
				  	size: 12
				  },
				  Events: {
					enable: true,
					onClick: function(node) {  
					if(!node || SUGAR.util.isTouchScreen()) return;  
					if(node.link == 'undefined' || node.link == '') return;
					window.location.href=node.link;
					}
				  },
				  //labels offset position
				  labelOffset: 5,
				  //bars style
				  type: useGradients? chartConfig["barType"]+':gradient' : chartConfig["barType"],
				  //whether to show the aggregation of the values
				  showAggregates:true,
				  //whether to show the labels for the bars
				  showLabels:true,
				  //labels style
				  Label: {
					type: labelType, //Native or HTML
					size: 12,
					family: css["font-family"],
					color: css["color"],
					colorAlt: "#ffffff"
				  },
				  //add tooltips
				  Tips: {
					enable: true,
					onShow: function(tip, elem) {
					  if(elem.link != 'undefined' && elem.link != '') {
						drillDown = (SUGAR.util.isTouchScreen()) ? "<br><a href='"+ elem.link +"'>Click to drilldown</a>" : "<br>Click to drilldown";
					  } else {
						drillDown = "";
					  }

					  if(elem.valuelabel != 'undefined' && elem.valuelabel != undefined && elem.valuelabel != '') {
						value = "elem.valuelabel";
					  } else {
						value = "elem.value";
					  }
					  eval("tip.innerHTML = '<b>' + elem."+chartConfig["tip"]+" + '</b>: ' + "+value+" + ' - ' + elem.percentage + '%' + drillDown");
					}
				  }
				});
				//load JSON data.
				barChart.loadJSON(json);
				

				//end
				
				/*
				var list = $jit.id('id-list'),
					button = $jit.id('update'),
					orn = $jit.id('switch-orientation');
				//update json on click 'Update Data'
				$jit.util.addEvent(button, 'click', function() {
				  var util = $jit.util;
				  if(util.hasClass(button, 'gray')) return;
				  util.removeClass(button, 'white');
				  util.addClass(button, 'gray');
				  barChart.updateJSON(json2);
				});
				*/
				//dynamically add legend to list
				var list = $jit.id('legend'+chartId);
				var legend = barChart.getLegend(),
					cols = (typeof SUGAR == 'undefined' || typeof SUGAR.mySugar == 'undefined') ? 8 : 4,
					rows = Math.ceil(legend["name"].length/cols),
					table = "<table cellpadding='0' cellspacing='0' align='left'>";
				var j = 0;
				for(i=0;i<rows;i++) {
					table += "<tr>"; 
					for(td=0;td<cols;td++) {
						
						table += '<td width=\'16\' valign=\'top\'>';
						if(legend["name"][j] != undefined) {
							table += '<div class=\'query-color\' style=\'background-color:'
							  + legend["color"][j] +'\'>&nbsp;</div>';
						}
						  
						table += '</td>';
						table += '<td class=\'label\' valign=\'top\'>';
						if(legend["name"][j] != undefined) {
							table += legend["name"][j];
						}
						  
						table += '</td>';
						j++;
						}
					table += "</tr>"; 
				}
				
					table += "</table>";
				list.innerHTML = table;
				
				
				//save canvas to image for pdf consumption
				$jit.util.saveImageTest(chartId,jsonFilename,chartConfig["imageExportType"]);
		    	
                trackWindowResize(barChart, chartId, json);
					}
				}
				
				var callback =
				{
				  success:handleSuccess,
				  failure:handleFailure,
				  argument: { foo:'foo', bar:''}
				};
				
				var request = YAHOO.util.Connect.asyncRequest('GET', jsonFilename + "?r=" + new Date().getTime(), callback);
				break;
				
			case "lineChart":
				var handleFailure = function(o){
				alert('fail');
					if(o.responseText !== undefined){
						alert('failed');
					}
				}	
				var handleSuccess = function(o){

					if(o.responseText !== undefined && o.responseText != "No Data"){	
					var json = eval('('+o.responseText+')');

				var properties = $jit.util.splat(json.properties)[0];	
				//init Linecahrt
				var lineChart = new $jit.LineChart({
				  //id of the visualization container
				  injectInto: chartId,
				  //whether to add animations
				  animate: false,
				  renderBackground: chartConfig['imageExportType'] == "jpg" ? true: false,
				  backgroundColor: 'rgb(255,255,255)',
				  colorStop1: 'rgba(255,255,255,.8)',
				  colorStop2: 'rgba(255,255,255,0)',
				  selectOnHover: false,
				  Title: {
					text: properties['title'],
					size: 16,
					color: '#444444',
					offset: 20
				  },
				  Subtitle: {
					text: properties['subtitle'],
					size: 11,
					color: css["color"],
					offset: 20
				  },
				  Ticks: {
					enable: true,
					color: css["gridLineColor"]
				  },
				  //visualization offset
				  Margin: {
					top:20,
					left: 40,
					right: 40,
					bottom: 20
				  },
				  Events: {
					enable: true,
					onClick: function(node) {  
					if(!node || SUGAR.util.isTouchScreen()) return;  
					if(node.link == 'undefined' || node.link == '') return;
					window.location.href=node.link;
					}
				  },
				  //labels offset position
				  labelOffset: 5,
				  //bars style
				  type: useGradients? chartConfig["lineType"]+':gradient' : chartConfig["lineType"],
				  //whether to show the aggregation of the values
				  showAggregates:true,
				  //whether to show the labels for the bars
				  showLabels:true,
				  //labels style
				  Label: {
					type: labelType, //Native or HTML
					size: 12,
					family: css["font-family"],
					color: css["color"],
					colorAlt: "#ffffff"
				  },
				  //add tooltips
				  Tips: {
					enable: true,
					onShow: function(tip, elem) {
					  if(elem.link != 'undefined' && elem.link != '') {
						drillDown = (SUGAR.util.isTouchScreen()) ? "<br><a href='"+ elem.link +"'>Click to drilldown</a>" : "<br>Click to drilldown";
					  } else {
						drillDown = "";
					  }

					  if(elem.valuelabel != 'undefined' && elem.valuelabel != undefined && elem.valuelabel != '') {
						var value = "elem.valuelabel";
					  } else {
						var value = "elem.value";
					  }
					  
					  if(elem.collision) {
					  	eval("var name = elem."+chartConfig["tip"]+";");
					  	var content = '<table>';
					  	
					  	for(var i=0; i<name.length; i++) {
					  		content += '<tr><td><b>' + name[i] + '</b>:</td><td> ' + elem.value[i] + ' - ' + elem.percentage[i] + '%' + '</td></tr>';
					  	}
					  	content += '</table>';
					  	tip.innerHTML = content;
					  } else {
					  	eval("tip.innerHTML = '<b>' + elem."+chartConfig["tip"]+" + '</b>: ' + "+value+" + ' - ' + elem.percentage + '%' + drillDown");	
					  }
					}
				  }
				});
				//load JSON data.
				lineChart.loadJSON(json);
				//end
				
				/*
				var list = $jit.id('id-list'),
					button = $jit.id('update'),
					orn = $jit.id('switch-orientation');
				//update json on click 'Update Data'
				$jit.util.addEvent(button, 'click', function() {
				  var util = $jit.util;
				  if(util.hasClass(button, 'gray')) return;
				  util.removeClass(button, 'white');
				  util.addClass(button, 'gray');
				  barChart.updateJSON(json2);
				});
				*/
				//dynamically add legend to list
				var list = $jit.id('legend'+chartId);
				var legend = lineChart.getLegend(),
					cols = (typeof SUGAR == 'undefined' || typeof SUGAR.mySugar == 'undefined') ? 8 : 4,
					rows = Math.ceil(legend["name"].length/cols),
					table = "<table cellpadding='0' cellspacing='0' align='left'>";
				var j = 0;
				for(i=0;i<rows;i++) {
					table += "<tr>"; 
					for(td=0;td<cols;td++) {
						
						table += '<td width=\'16\' valign=\'top\'>';
						if(legend["name"][j] != undefined) {
							table += '<div class=\'query-color\' style=\'background-color:'
							  + legend["color"][j] +'\'>&nbsp;</div>';
						}
						  
						table += '</td>';
						table += '<td class=\'label\' valign=\'top\'>';
						if(legend["name"][j] != undefined) {
							table += legend["name"][j];
						}
						  
						table += '</td>';
						j++;
						}
					table += "</tr>"; 
				}
				
					table += "</table>";
				list.innerHTML = table;
				
				
				//save canvas to image for pdf consumption
				$jit.util.saveImageTest(chartId,jsonFilename,chartConfig["imageExportType"]);

                trackWindowResize(lineChart, chartId, json);
					}
				}
				
				var callback =
				{
				  success:handleSuccess,
				  failure:handleFailure,
				  argument: { foo:'foo', bar:''}
				};
				
				var request = YAHOO.util.Connect.asyncRequest('GET', jsonFilename + "?r=" + new Date().getTime(), callback);
				break;
			
				
			case "pieChart":

				var handleFailure = function(o){
				alert('fail');
					if(o.responseText !== undefined){
						alert('failed');
					}
				}	
				var handleSuccess = function(o){

					if(o.responseText !== undefined){			
					var json = eval('('+o.responseText+')');
					var properties = $jit.util.splat(json.properties)[0];	

						//init BarChart
				var pieChart = new $jit.PieChart({
				  //id of the visualization container
				  injectInto: chartId,
				  //whether to add animations
				  animate: false,
				  renderBackground: chartConfig['imageExportType'] == "jpg" ? true: false,
				  backgroundColor: 'rgb(255,255,255)',
				  colorStop1: 'rgba(255,255,255,.8)',
				  colorStop2: 'rgba(255,255,255,0)',	
				  labelType: properties['labels'],
				  hoveredColor: false,
				  //offsets
				  offset: 50,
				  sliceOffset: 0,
				  labelOffset: 30,
				  //slice style
				  type: useGradients? chartConfig["pieType"]+':gradient' : chartConfig["pieType"],
				  //whether to show the labels for the slices
				  showLabels:true,
				  Title: {
					text: properties['title'],
					size: 16,
					color: '#444444',
					offset: 20
				  },
				  Subtitle: {
					text: properties['subtitle'],
					size: 11,
					color: css["color"],
					offset: 20
				  },
				  Margin: {
					top:20,
					left: 20,
					right: 20,
					bottom: 20
				  },
				  Events: {
					enable: true,
					onClick: function(node) {  
					if(!node || SUGAR.util.isTouchScreen()) return;  
					if(node.link == 'undefined' || node.link == '') return;
					window.location.href=node.link;
					}
				  },
				  //label styling
				  Label: {
					type: labelType, //Native or HTML
					size: 12,
					family: css["font-family"],
					color: css["color"]
				  },
				  //enable tips
				  Tips: {
					enable: true,
					onShow: function(tip, elem) {
					  if(elem.link != 'undefined' && elem.link != '') {
						drillDown = (SUGAR.util.isTouchScreen()) ? "<br><a href='"+ elem.link +"'>Click to drilldown</a>" : "<br>Click to drilldown";
					  } else {
						drillDown = "";
					  }
					  
					  if(elem.valuelabel != 'undefined' && elem.valuelabel != undefined && elem.valuelabel != '') {
						value = "elem.valuelabel";
					  } else {
						value = "elem.value";
					  }
					   eval("tip.innerHTML = '<b>' + elem.label + '</b>: ' + "+ value +" + ' - ' + elem.percentage + '%' + drillDown");
					}
				  }
				});
				//load JSON data.
				pieChart.loadJSON(json);
				//end
				//dynamically add legend to list
				var list = $jit.id('legend'+chartId);
				var legend = pieChart.getLegend(),
					cols = (typeof SUGAR == 'undefined' || typeof SUGAR.mySugar == 'undefined') ? 8 : 4,
					rows = Math.ceil(legend["name"].length/cols);
					table = "<table cellpadding='0' cellspacing='0' align='left'>";
				var j = 0;
				for(i=0;i<rows;i++) {
					table += "<tr>"; 
					for(td=0;td<cols;td++) {
						
						table += '<td width=\'16\' valign=\'top\'>';
						if(legend["name"][j] != undefined) {
							table += '<div class=\'query-color\' style=\'background-color:'
							  + legend["color"][j] +'\'>&nbsp;</div>';
						}
						  
						table += '</td>';
						table += '<td class=\'label\' valign=\'top\'>';
						if(legend["name"][j] != undefined) {
							table += legend["name"][j];
						}
						  
						table += '</td>';
						j++;
						}
					table += "</tr>"; 
				}
				
					table += "</table>";
				list.innerHTML = table;
				
								
				//save canvas to image for pdf consumption
				$jit.util.saveImageTest(chartId,jsonFilename,chartConfig["imageExportType"]);
			
                trackWindowResize(pieChart, chartId, json);
					}
				}
				
				var callback =
				{
				  success:handleSuccess,
				  failure:handleFailure,
				  argument: { foo:'foo', bar:''}
				};
				
				var request = YAHOO.util.Connect.asyncRequest('GET', jsonFilename + "?r=" + new Date().getTime(), callback);
							
				break;
				
				
			case "funnelChart":

				var handleFailure = function(o){
				alert('fail');
					if(o.responseText !== undefined){
						alert('failed');
					}
				}	
				var handleSuccess = function(o){

					if(o.responseText !== undefined && o.responseText != "No Data"){	
					var json = eval('('+o.responseText+')');

				var properties = $jit.util.splat(json.properties)[0];	

				//init Funnel Chart
				var funnelChart = new $jit.FunnelChart({
				  //id of the visualization container
				  injectInto: chartId,
				  //whether to add animations
				  animate: false,
				  renderBackground: chartConfig['imageExportType'] == "jpg" ? true: false,
				  backgroundColor: 'rgb(255,255,255)',
				  colorStop1: 'rgba(255,255,255,.8)',
				  colorStop2: 'rgba(255,255,255,0)',	
				  //orientation setting should not be changed
				  orientation: "vertical",
				  hoveredColor: false,
				  Title: {
					text: properties['title'],
					size: 16,
					color: '#444444',
					offset: 20
				  },
				  Subtitle: {
					text: properties['subtitle'],
					size: 11,
					color: css["color"],
					offset: 20
				  },
				  //segment separation
				  segmentOffset: 20,
				  //visualization offset
				  Margin: {
					top:20,
					left: 20,
					right: 20,
					bottom: 20
				  },
				  Events: {
					enable: true,
					onClick: function(node) {  
					if(!node || SUGAR.util.isTouchScreen()) return;  
					if(node.link == 'undefined' || node.link == '') return;
					window.location.href=node.link;
					}
				  },
				  //labels offset position
				  labelOffset: 10,
				  //bars style
				  type: useGradients? chartConfig["funnelType"]+':gradient' : chartConfig["funnelType"],
				  //whether to show the aggregation of the values
				  showAggregates:true,
				  //whether to show the labels for the bars
				  showLabels:true,
				  //labels style
				  Label: {
					type: labelType, //Native or HTML
					size: 12,
					family: css["font-family"],
					color: css["color"],
					colorAlt: "#ffffff"
				  },
				  //add tooltips
				  Tips: {
					enable: true,
					onShow: function(tip, elem) {
					  if(elem.link != 'undefined' && elem.link != '') {
						drillDown = (SUGAR.util.isTouchScreen()) ? "<br><a href='"+ elem.link +"'>Click to drilldown</a>" : "<br>Click to drilldown";
					  } else {
						drillDown = "";
					  }

					  if(elem.valuelabel != 'undefined' && elem.valuelabel != undefined && elem.valuelabel != '') {
						value = "elem.valuelabel";
					  } else {
						value = "elem.value";
					  }
					  eval("tip.innerHTML = '<b>' + elem."+chartConfig["tip"]+" + '</b>: ' + "+value+"  + ' - ' + elem.percentage + '%' +  drillDown");
					}
				  }
				});
				//load JSON data.
				funnelChart.loadJSON(json);
				//end
				
				/*
				var list = $jit.id('id-list'),
					button = $jit.id('update'),
					orn = $jit.id('switch-orientation');
				//update json on click 'Update Data'
				$jit.util.addEvent(button, 'click', function() {
				  var util = $jit.util;
				  if(util.hasClass(button, 'gray')) return;
				  util.removeClass(button, 'white');
				  util.addClass(button, 'gray');
				  barChart.updateJSON(json2);
				});
				*/
				//dynamically add legend to list
				var list = $jit.id('legend'+chartId);
				var legend = funnelChart.getLegend(),
					cols = (typeof SUGAR == 'undefined' || typeof SUGAR.mySugar == 'undefined') ? 8 : 4,
					rows = Math.ceil(legend["name"].length/cols);
					table = "<table cellpadding='0' cellspacing='0' align='left'>";
				var j = 0;
				for(i=0;i<rows;i++) {
					table += "<tr>"; 
					for(td=0;td<cols;td++) {
						
						table += '<td width=\'16\' valign=\'top\'>';
						if(legend["name"][j] != undefined) {
							table += '<div class=\'query-color\' style=\'background-color:'
							  + legend["color"][j] +'\'>&nbsp;</div>';
						}
						  
						table += '</td>';
						table += '<td class=\'label\' valign=\'top\'>';
						if(legend["name"][j] != undefined) {
							table += legend["name"][j];
						}
						  
						table += '</td>';
						j++;
						}
					table += "</tr>"; 
				}
				
					table += "</table>";
				list.innerHTML = table;
								
				//save canvas to image for pdf consumption
				$jit.util.saveImageTest(chartId,jsonFilename,chartConfig["imageExportType"]);
				
                trackWindowResize(funnelChart, chartId, json);
					}
				}
				
				var callback =
				{
				  success:handleSuccess,
				  failure:handleFailure,
				  argument: { foo:'foo', bar:''}
				};
				
				var request = YAHOO.util.Connect.asyncRequest('GET', jsonFilename + "?r=" + new Date().getTime(), callback);
				break;
				
				
				
			case "gaugeChart":

				var handleFailure = function(o){
				alert('fail');
					if(o.responseText !== undefined){
						alert('failed');
					}
				}	
				var handleSuccess = function(o){

					if(o.responseText !== undefined){			
					var json = eval('('+o.responseText+')');
					var properties = $jit.util.splat(json.properties)[0];	

						//init Gauge Chart
				var gaugeChart = new $jit.GaugeChart({
				  //id of the visualization container
				  injectInto: chartId,
				  //whether to add animations
				  animate: false,
				  renderBackground: chartConfig['imageExportType'] == "jpg" ? true: false,
				  backgroundColor: 'rgb(255,255,255)',
				  colorStop1: 'rgba(255,255,255,.8)',
				  colorStop2: 'rgba(255,255,255,0)',
				  labelType: properties['labels'],
				  hoveredColor: false,
				  Title: {
					text: properties['title'],
					size: 16,
					color: '#444444',
					offset: 20
				  },
				  Subtitle: {
					text: properties['subtitle'],
					size: 11,
					color: css["color"],
					offset: 5
				  },
				  //offsets
				  offset: 20,
				  gaugeStyle: {
					backgroundColor: '#aaaaaa',
					borderColor: '#999999',
					needleColor: 'rgba(255,0,0,.8)',
					borderSize: 4,
					positionFontSize: 24,
					positionOffset: 2
				  },
				  //slice style
				  type: useGradients? chartConfig["gaugeType"]+':gradient' : chartConfig["gaugeType"],
				  //whether to show the labels for the slices
				  showLabels:true,
				  Events: {
					enable: true,
					onClick: function(node) {  
					if(!node || SUGAR.util.isTouchScreen()) return;  
					if(node.link == 'undefined' || node.link == '') return;
					window.location.href=node.link;
					}
				  },
				  //label styling
				  Label: {
					type: labelType, //Native or HTML
					size: 12,
					family: css["font-family"],
					color: css["color"]
				  },
				  //enable tips
				  Tips: {
					enable: true,
					onShow: function(tip, elem) {
					  if(elem.link != 'undefined' && elem.link != '') {
						drillDown = (SUGAR.util.isTouchScreen()) ? "<br><a href='"+ elem.link +"'>Click to drilldown</a>" : "<br>Click to drilldown";
					  } else {
						drillDown = "";
					  }
					  if(elem.valuelabel != 'undefined' && elem.valuelabel != undefined && elem.valuelabel != '') {
						value = "elem.valuelabel";
					  } else {
						value = "elem.value";
					  }
					   eval("tip.innerHTML = '<b>' + elem.label + '</b>: ' + "+ value +" + drillDown");
					}
				  }
				});
				//load JSON data.
				gaugeChart.loadJSON(json);

				
				var list = $jit.id('legend'+chartId);
				var legend = gaugeChart.getLegend(),
					cols = (typeof SUGAR == 'undefined' || typeof SUGAR.mySugar == 'undefined') ? 8 : 4,
					rows = Math.ceil(legend["name"].length/cols);
					table = "<table cellpadding='0' cellspacing='0' align='left'>";
				var j = 1;
				for(i=0;i<rows;i++) {
					table += "<tr>"; 
					for(td=0;td<cols;td++) {
						
						table += '<td width=\'16\' valign=\'top\'>';
						if(legend["name"][j] != undefined) {
							table += '<div class=\'query-color\' style=\'background-color:'
							  + legend["color"][j] +'\'>&nbsp;</div>';
						}
						  
						table += '</td>';
						table += '<td class=\'label\' valign=\'top\'>';
						if(legend["name"][j] != undefined) {
							table += legend["name"][j];
						}
						  
						table += '</td>';
						j++;
						}
					table += "</tr>"; 
				}
				
					table += "</table>";
				list.innerHTML = table;
				
								
				//save canvas to image for pdf consumption
				$jit.util.saveImageTest(chartId,jsonFilename,chartConfig["imageExportType"]);
				
                trackWindowResize(gaugeChart, chartId, json);
					}
				}
				
				var callback =
				{
				  success:handleSuccess,
				  failure:handleFailure,
				  argument: { foo:'foo', bar:''}
				};
				
				var request = YAHOO.util.Connect.asyncRequest('GET', jsonFilename + "?r=" + new Date().getTime(), callback);
							
				break;
				
			}
    
            function trackWindowResize(chart, chartId, json)
            {
                var origWindowWidth = document.documentElement.scrollWidth,
                    container = document.getElementById(chartId),
                    widget = document.getElementById(chartId + "-canvaswidget");

                var timeout;

                // refresh graph on window resize
                YAHOO.util.Event.addListener(window, "resize", function()
                {
                    if (timeout)
                    {
                        clearTimeout(timeout);
                    }

                    timeout = setTimeout(function()
                    {
                        var newWindowWidth = document.documentElement.scrollWidth;

                        // if window width has changed during resize
                        if (newWindowWidth != origWindowWidth)
                        {
                            // hide widget in order to let it's container have
                            // width corresponding to current window size,
                            // not it's contents
                            widget.style.display = "none";

                            // add one more timeout in order to let all widgets
                            // on the page hide
                            setTimeout(function()
                            {
                                // measure container width
                                var width = container.offsetWidth;

                                // display widget before resize, otherwise
                                // it will be rendered incorrectly in IE
                                widget.style.display = "";

                                chart.resizeGraph(json, width);
                                origWindowWidth = newWindowWidth;
                            }, 0);
                        }
                    }, delay);
                });
			}
		}