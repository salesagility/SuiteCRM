/**
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
* the Free Software Foundation; either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
* along with this program; if not, see http://www.gnu.org/licenses
* or write to the Free Software Foundation,Inc., 51 Franklin Street,
* Fifth Floor, Boston, MA 02110-1301  USA
* @Package Gantt chart
* @copyright Andrew Mclaughlan 2014
* @author Andrew Mclaughlan <andrew@mclaughlan.info>
*/
// unblock when ajax activity stops
$(document).ajaxStop($.unblockUI);
//Get the default sugar page loading message
var loading = SUGAR.language.languages.app_strings['LBL_LOADING_PAGE'];

$(function() {
   //generate the chart on page load
    gen_chart('0');

  //message for ajax loading screen
    var msg = '<div><br />' +
        '<h1><img align="absmiddle" src="themes/'+SUGAR.themes.theme_name+'/images/img_loading.gif"> ' + loading + '</h1>' + '</div>';
    //on button click re-generate the chart
    $(document.body).on('change','#resources', function(e) {
        $(".qtip").remove(); //Clear all tooltips before re-generating the chart

        $.blockUI({//ajax loading screen
            message:msg,
            css: {
                height: '50px',
                width: '240px',
               // top:  ($(window).height() - 50) /2 + 'px',
                left: ($(window).width() - 240) /2 + 'px'//centre box
            }
        });
        setTimeout(gen_chart(0,true),800); //call the ajax generate chart function with delay
    });
    //Gets the previous month
    $(document.body).on('click','#prev_month', function(e) {
        e.preventDefault();
        $(".qtip").remove(); //Clear all tooltips before re-generating the chart

        $.blockUI({//ajax loading screen
            message:msg,
            css: {
                height: '50px',
                width: '240px',
                // top:  ($(window).height() - 50) /2 + 'px',
                left: ($(window).width() - 240) /2 + 'px'//centre box
            }
        });
        setTimeout(gen_chart('-1'),800); //call the ajax generate chart function with delay
    });
    //Gets the next month
    $(document.body).on('click','#next_month', function(e) {
        e.preventDefault();
        $(".qtip").remove(); //Clear all tooltips before re-generating the chart

        $.blockUI({//ajax loading screen
            message:msg,
            css: {
                height: '50px',
                width: '240px',
                // top:  ($(window).height() - 50) /2 + 'px',
                left: ($(window).width() - 240) /2 + 'px'//centre box
            }
        });
        setTimeout(gen_chart('+1'),800); //call the ajax generate chart function with delay
    });

});
/*
* This function generates the html chart grid by calling the update_chart function in the controller using ajax.
* The jquery block UI plugin is used for the loading screen
* */

 function gen_chart(month, flag){
    //Get the chart properties
    var start = $('#date_start').val();
    var end = $('#date_end').val();
    var resources = $('#resources').val();
    var type = 'all';

    if(!resources){
        resources = 'all';
    }
    else {
        var selected = $('#resources').find('option:selected');
        type = selected.data('type');
    }
    if(flag){
        flag = '1';
    }
    else {
        flag = '0';
    }

    //Put the properties into a string
    var dataString = '&start=' + start + '&end=' + end + '&resources=' + resources + '&month=' + month + '&flag=' + flag + '&type=' + type ;
    //Pass the properties to the controller function via ajax
    $.ajax({
        type: "POST",
        url: "index.php?module=Project&action=update_chart",
        data: dataString,
        success: function(data) { // On success generate the tasks for the chart
            // data is ur summary
            $('#gantt_chart').html(data);
            add_tooltips();
        }
    });
}

/*
 * This function generates the tooltips on the resource chart by calling the tooltip function in the controller using ajax.
 * qTips tooltip jquery plugin is used for the tooltips
 * */

 function add_tooltips(){
    //loop through each task and add tooltips
    $('.h').each(function(event) {

        //set tooltip title
        var title = SUGAR.language.get('Project', 'LBL_TOOLTIP_TITLE');
        //get start and end date of the task to pass via ajax to the tooltip controller function
        var rel = $(this).attr('rel');
        var dates = rel.split("|");
        var dataString = 'start_date=' + dates[0] + '&resource_id=' + dates[1] + '&type=' + dates[2];
        var url = 'index.php?module=Project&action=Tooltips';

        $(this).qtip({
            content: {
                text: function(event, api) {
                    $.ajax({
                        url: url,
                        data: dataString
                    }).then(function(content) {
                            // Set the tooltip content upon successful retrieval
                            api.set('content.text', content);
                        },
                        function(xhr, status, error) {
                            // Upon failure... set the tooltip content to the status and error value
                            api.set('content.text', status + ': ' + error);
                        });

                    return 'Loading...'; // Set some initial text
                },
                title: {
                    button: true,
                    text: title
                }
            },
            position: {
                my: 'bottom center',
                at: 'top center',
                target: 'mouse',
                adjust: {
                    mouse: false,
                    scroll: false,
                    y: -10
                }
            },
            show: {
                event: 'click'

            },
            hide: false,
            style: {
                classes : 'qtip-green qtip-shadow qtip_box', //qtip-rounded'
                tip: {

                    offset: 10

                }
            }
        });
    });
}

