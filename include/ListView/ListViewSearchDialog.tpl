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
                <div class="modal-footer">
                    <button type="button" class="btn button purple btn-default" data-dismiss="modal">{$APP.LBL_CLOSE_BUTTON_TITLE}</button>
                    <button type="button" onclick="search.onSaveClick();" type="button" class="button red">{$APP.LBL_SAVE_CHANGES_BUTTON_TITLE}</button>
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
                    this.loadSearchSettings();
                },

                showContents: function(contents) {
                    $('#searchList').html(contents);
                },

                showPreload: function() {
                    this.showContents('<p class="preloading"></p>');
                },

                loadSearchSettings: function() {
                    var _this = this;
                    this.showPreload();

                    if(typeof module_sugar_grp1 != 'undefined' && module_sugar_grp1) {

                        var url = 'index.php?module=' + module_sugar_grp1 + '&action=index&search_form_only=true&to_pdf=true&search_form_view=advanced_search&search=true';

                        var cObj = YAHOO.util.Connect.asyncRequest('GET', url, {success: function(e){
                            _this.showContents(_this.getDragDropChooserHTML(JSON.parse($('<div></div>').html(e.responseText).find('#responseData').html())));
                            _this.initDragDropChooser();
                        }, failure: function(){
                            _this.showContents('ERR_COMMUNICATION_ERROR');
                        }});
                    }
                    else {
                        _this.showContents('ERR_NO_MODULE_SELECTED');
                    }

                },

                getDragDropChooserHTML: function(chooserData) {

                    $('#chooserTemplate .chooserList.green').html('');
                    $.each(chooserData.args.values_array[0], function(key, value){
                        $('#chooserTemplate .chooserList.green').append('<li data-key="'+key+'">'+value+'</li>');
                    });

                    $('#chooserTemplate .chooserList.red').html('');
                    $.each(chooserData.args.values_array[1], function(key, value){
                        $('#chooserTemplate .chooserList.red').append('<li data-key="'+key+'">'+value+'</li>');
                    });

                    return $('#chooserTemplate').html();
                },

                initDragDropChooser: function() {
                    var _this = this;
                    $( "#searchList .chooserContent .chooserList.green" ).sortable({
                        connectWith: "#searchList .chooserContent .chooserList.red",
                        stop: function() {
                            _this.isValid();
                        }
                    });
                    $( "#searchList .chooserContent .chooserList.green" ).disableSelection();

                    $( "#searchList .chooserContent .chooserList.red" ).sortable({
                        connectWith: "#searchList .chooserContent .chooserList.green",
                        stop: function() {
                            _this.isValid();
                        }
                    });
                    $( "#searchList .chooserContent .chooserList.red" ).disableSelection();

                },

                onSaveClick: function() {
                    if(this.isValid()) {
                        this.save();
                    }
                },

                // validation (return true if valid, otherwise show error(s) and return false)
                isValid: function() {
                    // clear error message
                    $('#error-displayed-search').html('');
                    // check validation for empty list
                    var v = $('#searchList > div > ul.chooserList.green.ui-sortable li').length > 0;
                    if(!v) {
                        // show error
                        $('#error-displayed-search').html('{/literal}{$APP.ERR_EMPTY_SEARCH_LIST}{literal}');
                        // scroll to error message
                        $('#searchDialog').animate({
                            scrollTop: $("#error-displayed-search").offset().top - 100
                        });
                    }
                    // return validation result
                    return v;
                },

                // send it to server to save user preferences (refresh the page to show changes)
                save: function() {

                    // TODO : show loading message...

                    // make query search list
                    var cols = [];
                    $('#searchList > div > ul.chooserList.green.ui-sortable > li').each(function(i,e){
                        cols.push($(e).attr('data-key'));
                    });

                    $.post($('#search_form').attr('action'), {
                        displaySearch: cols.join('|'),
                        query: 'true'
                    }, function(){
                        //close form and refresh page after save
                        $('#searchDialog > div > div > div.modal-footer > button.btn.button.purple.btn-default').click();
                        if($('#search_form').length > 0) {
                            document.location.href = $('#search_form').attr('action');
                        } else {
                            if(typeof module_sugar_grp1 != 'undefined' && module_sugar_grp1) {
                                document.location.href = 'index.php?module=' + module_sugar_grp1 + '&action=index';
                            } else {
                                document.location.href = document.location.href;
                            }
                        }
                    });

                }

            };

        }

    </script>
{/literal}

    {assign var="searchDialogAdded" value="true"}
{/if}