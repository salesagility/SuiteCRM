{if !$searchDialogAdded}

    <div id="searchDialog" class="modal fade modal-search" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{$APP.LBL_SEARCH_HEADER_TITLE}</h4>
                </div>
                <div class="modal-body" id="searchList">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="chooserTemplate" class="hidden">
        <div class="chooserContent">
            <h1>{$APP.LBL_DISPLAYED}</h1>
            <ul class="chooserList green"></ul>
            <div id="error-displayed-search" class="error"></div>
            <h1>{$APP.LBL_HIDDEN}</h1>
            <ul class="chooserList red"></ul>
        </div>
    </div>

{literal}
    <script>

        // TODO add it to sListView
        if(typeof search == 'undefined') {

            var search = {

                onOpen: function() {
                    this.loadSearchForm();
                },

                showContents: function(contents) {
                    $('#searchList').html(contents);
                },

                showPreload: function() {
                    this.showContents('<p class="preloading"></p>');
                },

                loadSearchForm: function() {
                    var _this = this;
                    this.showPreload();

                    if(typeof module_sugar_grp1 != 'undefined' && module_sugar_grp1) {

                        var url = 'index.php?module=' + module_sugar_grp1 + '&action=index&search_form_only=true&to_pdf=true&search_form_view=basic_search&search=true&hasAdvancedSearch=false';

                        var cObj = YAHOO.util.Connect.asyncRequest('GET', url, {success: function(e){
                            var actionLink = $('#search_form').attr('action');
                            var $searchFormPopup = $('<form id="search_form_popup" method="post" action="'+actionLink+'"></form>').html(e.responseText);
                            $searchFormPopup.find();
                            _this.showContents($('<form id="search_form_popup" method="post" action="'+actionLink+'"></form>').html(e.responseText));

                            $('#searchList #search_form_popup').prepend('<input type="hidden" name="searchFormTab" value="{/literal}{$displayView}{literal}">');
                            $('#searchList #search_form_popup').prepend('<input type="hidden" name="module" value="{/literal}{$module}{literal}">');
                            $('#searchList #search_form_popup').prepend('<input type="hidden" name="action" value="{/literal}{$action}{literal}">');
                            $('#searchList #search_form_popup').prepend('<input type="hidden" name="query" value="true">');

                            var prefixString = 'searchFormPopup_';
                            var prefixLength = prefixString.length;

                            // add unique id and name in popup search form elements
                            $('#searchList #search_form_popup *').each(function(i,e){
                                var elemId = $(e).attr('id');
                                var elemName = $(e).attr('name');
                                var elemFor = $(e).attr('for');
                                if(elemId) {
                                    $(e).attr('id', prefixString + elemId);
                                }
                                if(elemName) {
                                    $(e).attr('name', prefixString + elemName);
                                }
                                if(elemFor) {
                                    $(e).attr('for', prefixString + elemFor);
                                }
                            });

                            // remove unique names from popup search form elements before submit
                            $('#searchList #search_form_popup').submit(function(e){
                                $('#searchList #search_form_popup *').each(function(i,e){
                                    var elemName = $(e).attr('name');
                                    if(elemName && elemName.substr(0, prefixLength) == prefixString) {
                                        $(e).attr('name', elemName.substr(prefixLength));
                                    }
                                });
                                $('#search_form_popup').submit();
                                return false;
                            });

                        }, failure: function(){
                            _this.showContents('ERR_COMMUNICATION_ERROR');
                        }});
                    }
                    else {
                        _this.showContents('ERR_NO_MODULE_SELECTED');
                    }

                },

            };

        }

    </script>
{/literal}

    {assign var="searchDialogAdded" value="true"}
{/if}