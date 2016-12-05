
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{literal}
<script>

    var listViewSearchIcon = {

        searchInfo: {/literal}{$searchInfoJson}{literal},

        infoInit: function() {

            $(function () {
                // load qtip
                if (typeof $.qtip == 'undefined') {
                    $.getScript('include/javascript/qtip/jquery.qtip.min.js');
                    $("<link/>", {
                        rel: "stylesheet",
                        type: "text/css",
                        href: "include/javascript/qtip/jquery.qtip.min.css"
                    }).appendTo("head");
                }

                // add qtip to search filter icon
                var qtipLoadInterval = setInterval(function () {
                    if (typeof $.qtip != 'undefined') {
                        clearInterval(qtipLoadInterval);

                        var qtipNeeded = false;
                        var qtipContent = '<table>';
                        for (var key in listViewSearchIcon.searchInfo) {
                            qtipContent += '<tr>';
                            qtipContent += '<td><b>' + key + '</b>&nbsp;</td>';
                            qtipContent += '<td>' + listViewSearchIcon.searchInfo[key] + '</td>';
                            qtipContent += '</tr>';
                            qtipNeeded = true;
                        }
                        qtipContent += '</table>';

                        if(qtipNeeded) {
                            $('.searchLink .searchAppliedAlert').qtip({
                                content: qtipContent
                            });
                            $('.searchLink .searchAppliedAlert').removeClass('hidden');
                        }
                    }
                }, 100);
            });

        },

        onOpen: function() {},

        lastLoadedDialogType: null,

        toggleSearchDialog: function(dialogType) {
            $('#searchDialog').modal('toggle');
            if(this.lastLoadedDialogType!==null && this.lastLoadedDialogType != dialogType) {
                $('#searchDialog .modal-body').addClass('modal-preload-hidden');
            }
            this.lastLoadedDialogType = dialogType;
            $('#'+dialogType+'_search_link').click();
        }

    };

    listViewSearchIcon.infoInit();



</script>
{/literal}
