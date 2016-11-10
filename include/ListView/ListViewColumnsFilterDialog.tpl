{if !$columnsFilterDialogAdded}

    <div id="columnsFilterDialog" class="modal fade modal-columns-filter" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{$APP.LBL_COLUMNS_FILTER_HEADER_TITLE}</h4>
                </div>
                <div class="modal-body" id="columnsFilterList">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn button purple btn-default" data-dismiss="modal">{$APP.LBL_CLOSE_BUTTON_TITLE}</button>
                    <button type="button" onclick="columnsFilter.onSaveClick();" type="button" class="button red">{$APP.LBL_SAVE_CHANGES_BUTTON_TITLE}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="chooserTemplate" class="hidden">
        <div class="chooserContent">
            <h1>{$APP.LBL_DISPLAYED}</h1>
            <ul class="chooserList green"></ul>
            <h1>{$APP.LBL_HIDDEN}</h1>
            <ul class="chooserList red"></ul>
        </div>
    </div>

    {literal}
        <script>

            // TODO add it to sListView
            if(typeof columnsFilter == 'undefined') {

                var columnsFilter = {

                    onOpen: function() {
                        console.log('columns filter dialog open clicked..');
                        this.loadColumnsSettings();
                    },

                    showContents: function(contents) {
                        $('#columnsFilterList').html(contents);
                    },

                    showPreload: function() {
                        this.showContents('<p><img src="themes/SuiteP/images/loading.gif" width="48" height="48" align="baseline" border="0" alt=""></p>');
                    },

                    loadColumnsSettings: function() {
                        var _this = this;
                        this.showPreload();

                        if(typeof module_sugar_grp1 != 'undefined' && module_sugar_grp1) {

                            var url = 'index.php?module=' + module_sugar_grp1 + '&action=index&search_form_only=true&to_pdf=true&search_form_view=advanced_search&columnsFilter=true';

                            var cObj = YAHOO.util.Connect.asyncRequest('GET', url, {success: function(e){
                                //console.log(e);
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
                        console.log(chooserData);

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

                        $( "#columnsFilterList .chooserContent .chooserList.green" ).sortable({
                            connectWith: "#columnsFilterList .chooserContent .chooserList.red"
                        });
                        $( "#columnsFilterList .chooserContent .chooserList.green" ).disableSelection();

                        $( "#columnsFilterList .chooserContent .chooserList.red" ).sortable({
                            connectWith: "#columnsFilterList .chooserContent .chooserList.green"
                        });
                        $( "#columnsFilterList .chooserContent .chooserList.red" ).disableSelection();

                    },

                    onSaveClick: function() {
                        if(this.isValid) {
                            this.save();
                        }
                    },

                    isValid: function() {
                        // TODO make a validation (return true if valid, otherwise show error(s) and return false)
                        return true;
                    },

                    // send it to server to save user preferences (refresh the page to show changes)
                    save: function() {

                        // TODO : show loading message...

                        // make query columns list
                        var cols = [];
                        $('#columnsFilterList > div > ul.chooserList.green.ui-sortable > li').each(function(i,e){
                            cols.push($(e).attr('data-key'));
                        });

                        $.post($('#search_form').attr('action'), {
                            displayColumns: cols.join('|'),
                            query: 'true'
                        }, function(){
                            //close form and refresh page after save
                            $('#columnsFilterDialog > div > div > div.modal-footer > button.btn.button.purple.btn-default').click();
                            if($('#search_form').lenght > 0) {
                                document.location.href = $('#search_form').attr('action');
                            } else {
                                document.location.href = document.location.href;
                            }
                        });

                    }

                };

            }

        </script>
    {/literal}

    {assign var="columnsFilterDialogAdded" value="true"}
{/if}