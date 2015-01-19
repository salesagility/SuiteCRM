// Custom jQuery for theme

// Script to toggle copyright popup
$( "button" ).click(function() {
    $( "#sugarcopy" ).toggle();

});

// Custom JavaScript for copyright pop-ups
$(function() {
    $( "#dialog, #dialog2" ).dialog({
        autoOpen: false,
        show: {
            effect: "blind",
            duration: 100
        },
        hide: {
            effect: "fade",
            duration: 1000
        }
    });
    $( "#powered_by" ).click(function() {
        $( "#dialog" ).dialog( "open" );
        $("#overlay").show().css({"opacity": "0.5"});
    });
    $( "#admin_options" ).click(function() {
        $( "#dialog2" ).dialog( "open" );
    });
});

// Back to top animation
$('#backtotop').click(function(event) {
    event.preventDefault();
    $('html, body').animate({scrollTop:0}, 500); // Scroll speed to the top
});

// Refresh function for refresh button on sidebar
function refresh(reload)
{
    window.location.reload(true);
}

// Tabs jQuery for Admin panel
$(function() {
    var tabs = $( "#tabs" ).tabs();
    tabs.find( ".ui-tabs-nav" ).sortable({
        axis: "x",
        stop: function() {
            tabs.tabs( "refresh" );
        }
    });
});

// Function to call footable for responsive table functionality
$(function () {
    setTimeout(function() {
        $('#dashletPanel th:not(:first-child)').attr("data-hide","phone, tablet");
        $('#subPanel th:not(:first-child)').attr("data-hide","phone, tablet");
        $('.footable').footable();
        $(".footable").find("th:first").attr("data-toggle","true");
    },2000);
});

// JavaScript fix to remove unrequired classes on smaller screens where sidebar is obsolete
$( window ).resize(function () {
    $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main', $(window).width() < 768);
    if ($(window).width() > 979) {
        $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main');
    }
});

// Button to toggle list view search
$('.showsearch').click(function() {
    $('.search_form').toggle();
});

// jQuery to toggle sidebar
$('#buttontoggle').click(function(){
    $('.sidebar').toggle();
    if ($('.sidebar').is(':visible')){
        $.cookie('sidebartoggle', 'expanded');
        $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2');

    }

    if ($('.sidebar').is(':hidden')){
        $.cookie('sidebartoggle', 'collapsed');
        $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 col-sm-3 col-md-2 sidebar');

    }
    console.log($.cookie('sidebartoggle'));
});

var sidebartoggle = $.cookie('sidebartoggle');
if (sidebartoggle == 'collapsed'){
    $('.sidebar').hide();
    $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 col-sm-3 col-md-2 sidebar');
}
if (sidebartoggle == 'expanded'){
    $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2');
}

// End of custom jQuery