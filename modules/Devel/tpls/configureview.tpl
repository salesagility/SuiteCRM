<link href="modules/Devel/assets/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<link href="modules/Devel/assets/css/Devel.css" rel="stylesheet" type="text/css" />

<script src="modules/Devel/assets/js/bootstrap-switch.min.js"></script>
<script src="modules/Devel/assets/js/configureview.js"></script>


<div id="devel_tools_configure">
    <h1>Configure Devel Tools</h1>
    <p>Devel Tools can be enabled per session.</p>
    <form action="index.php?module=Devel&action=configure" method="post" class="form-horizontal">
        <div class="form-group">
            <label for="devel-tools-enabled" class="col-sm-2 control-label">Enable/Disable Devel Tools</label>
            <div class="col-sm-10">
                <input type="checkbox" name="devel-tools-enabled" id="devel-tools-enabled" {$devel_tool_checked} />
            </div>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
