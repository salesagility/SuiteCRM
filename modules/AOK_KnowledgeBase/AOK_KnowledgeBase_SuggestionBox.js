/**
 * @author SalesAgility (Andrew Mclaughlan) <support@salesagility.com>
 * Date: 06/03/15
 * Using Qtip to provide KnowledgeBase article overlay.
 * Using bindWithDelay to delay request until after the user has stopped typing
 */
$(document).ready(function() {
    //Get KnowledgeBase article suggestions based on what is typed into the name field
    $('#name').bindWithDelay("keyup", function () {
        var url = 'index.php?module=Cases&action=get_kb_articles';
        var search = $('#name').val();
        var dataString = 'search=' + search;
        $.ajax({
            type:"POST",
            url:url,
            data: dataString,
            success: function (data) {
                $("#suggestion_box").html(data);
            }
        });

    }, 1000);
    //open article in tool-tip on hover over suggestion box list items
    $("body").on("mouseover",'.kb_article', function () {
        var title = SUGAR.language.get('Cases', 'LBL_TOOL_TIP_BOX_TITLE');
        var url = 'index.php?module=Cases&action=get_kb_article';
        // Updates existing tool-tips content via ajax
        if($("#suggestion_box").data('qtip') ) {
            var article = $(this).data( "id" );
            var dataString = 'article=' + article;
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
                success: function (data) {
                    $(".qtip-content").html(data);
                }
            });
        }
        else {//Creates new qtip tool-tip
            var article = $(this).data( "id" );
            var dataString = 'article=' + article;
            $("#suggestion_box").qtip({
                content: {
                    text: "Loading...",
                    ajax:{
                        url: url, // Use href attribute as URL
                        type: 'POST', // POST or GET
                        data: dataString, // Data to pass along with your request
                        success: function(data, status) {
                            // Set the content manually (required!)
                            this.set('content.text', data);
                        }
                    },
                    title: {
                        button: true, //show close button
                        text: title
                    }
                },
                position: { //position of tool-tip relative to suggestion box
                    my: 'middle right',
                    at: 'middle left',
                    adjust: {
                        mouse: false,
                        scroll: true,
                        y: -100,
                        x: 0
                    }
                },
                show: {
                    event: 'mouseover', // Show it on click...
                    ready: true, // Show the tooltip when ready
                    delay: 1000,
                    effect: function() {
                        $(this).fadeTo(800, 1);
                    }
                },
                hide: false,
                style: {
                    classes : 'qtip-default qtip qtip qtip-tipped qtip-shadow', //qtip-rounded'
                    tip: {
                        offset: 0
                    }
                }
            });
        }
    });
    //Animate transfer effect from additional into resolution box
    $("body").on("click",'#use_resolution', function () {
        if($('#additional_info_p').text() !=  $('#resolution').val()){
            $('#additional_info_p').effect("transfer", { to: "#resolution", className: "transfer" }, 1000, moveText);
        }
    });

    // callback function to bring text to the resolution box
    function moveText() {
        setTimeout(function() {
            var text = $('#additional_info_p').text();
            $('#resolution').val(text);
        }, 300 );
    };
});