<div id="searchDialog" class="modal fade modal-search" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{$APP.LBL_SEARCH_HEADER_TITLE}</h4>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="searchTabHandler basic active"><a href="javascript:void(0)" onclick="listViewSearchIcon.toggleSearchDialog('basic'); return false;" aria-controls="searchList" role="tab" data-toggle="tab">{$APP.LBL_QUICK_SEARCH}</a></li>
                    <li class="searchTabHandler advanced"><a href="javascript:void(0)" onclick="listViewSearchIcon.toggleSearchDialog('advanced'); return false;" aria-controls="searchList" role="tab" data-toggle="tab">{$APP.LBL_ADVANCED_SEARCH}</a></li>
                </ul>
            </div>



            <div class="modal-body" id="searchList">