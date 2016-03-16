(function($){
    var $develToolbar;
    var $develToolbarTogglerButton;

    var injectDevelToolbar = function() {
        var openCloseClass = (SUGAR.config.develToolbar.toolbar_open ? 'open' : 'closed');
        $develToolbar = $('<div id="develToolbar"></div>');
        $develToolbar.addClass(openCloseClass);
        var $indicator;

        //request number with detail link
        $indicator = $('<a href="'+SUGAR.config.develToolbar.devel_detail_link+'">' +
            '<div class="requestNumber indicator"><code>'+SUGAR.config.develToolbar.request_number+'</code></div>' +
            '</a>'
        );
        $develToolbar.append($indicator);

        //execution length
        $indicator = $('<div class="executionLength indicator"><code>'+SUGAR.config.develToolbar.execution_length+'</code></div>');
        $develToolbar.append($indicator);

        //memory usage
        $indicator = $('<div class="memoryUsage indicator"><code>'+SUGAR.config.develToolbar.memory_usage+'</code></div>');
        $develToolbar.append($indicator);

        //queries
        $indicator = $('<div class="queryCount indicator"><code>'+SUGAR.config.develToolbar.total_query_count+'</code></div>');
        $develToolbar.append($indicator);


        //
        $("body").append($develToolbar);
    };

    var injectDevelToolbarTogglerButton = function() {
        var openCloseClass = (SUGAR.config.develToolbar.toolbar_open ? 'open' : 'closed');
        $develToolbarTogglerButton = $('<div id="develToolbarToggler"></div>');
        $develToolbarTogglerButton.addClass(openCloseClass);
        $("body").append($develToolbarTogglerButton);
        $develToolbarTogglerButton.on('click', toggleToolbarOpenClose);
    };

    var toggleToolbarOpenClose = function() {
        var newState = !SUGAR.config.develToolbar.toolbar_open;
        var openCloseClass = (newState ? 'open' : 'closed');
        $develToolbarTogglerButton.attr('class', '').addClass(openCloseClass);
        $develToolbar.attr('class', '').addClass(openCloseClass);
        //console.log("TOOGLE: "+ newState);
        SUGAR.config.develToolbar.toolbar_open = newState;
        $.ajax({
            url: "index.php?module=Devel&action=develToolbarToggleOpenClosedState",
            data: {},
            dataType: "json",
            type: "POST",
            success: function(data){
                console.log(data);
            }
        });
    };


    $(document).ready(function() {
        if(!SUGAR.config.develToolbar) {
            console.error("Missing develToolbar configuration!");
            return;
        }
        console.log("DevelToolbar Config: " + JSON.stringify(SUGAR.config.develToolbar));

        injectDevelToolbar();
        injectDevelToolbarTogglerButton();
    });
})(jQuery);