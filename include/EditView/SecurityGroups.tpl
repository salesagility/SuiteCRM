<div class="panel panel-default">
    <div class="panel-heading">
        <a class="" role="button" data-toggle="collapse" aria-expanded="false">
            <div class="col-xs-10 col-sm-11 col-md-11">
                {$SECURITY_GROUP_SELECT}
            </div>
        </a>
    </div>
    <div class="panel-body panel-collapse collapse in" id="detailpanel_0">
        <div class="tab-content">
            <div class="row edit-view-row">
                <div class="col-xs-12 col-sm-6 edit-view-row-item">
                    <div class="col-xs-12 col-sm-4 label">
                        {$SECURITY_GROUPS}
                    </div>
                    <div class="col-xs-12 col-sm-8 edit-view-field " type="enum" field="securitygroups_panel">
                        <select title="" id="securitygroup_list" name="securitygroup_list[]" multiple="multiple" size="{$SECURITY_GROUP_COUNT}" style="height: 100%">
                            {$SECURITY_GROUP_OPTIONS}
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
