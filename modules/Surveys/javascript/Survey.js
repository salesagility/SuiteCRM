var Survey = (function ($) {
    var bindToggle = function (event) {
        event.preventDefault();

        var clickedElement = $(event.target);
        var resultTable = $('#' + clickedElement.data('question-id') + 'List');

        resultTable.slideToggle(500, function () {
            clickedElement.text(resultTable.is(':visible') ? 'Hide responses' : 'Show responses');
        });
    };

    var showHide = function (elements) {
        $(elements).each(function (index, element) {
            $(element).on('click', bindToggle);
        });
    };

    var result = {};
    result.showHide = showHide;

    return result;
})(jQuery);
