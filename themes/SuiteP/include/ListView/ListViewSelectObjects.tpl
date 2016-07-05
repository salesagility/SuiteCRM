<label style='{$DISPLAY_STYLE}' id='selectedRecordsTop'>
    <span id="selectedRecordsTopLabel">{$APP.LBL_LISTVIEW_SELECTED_OBJECTS}</span><span id="selectedRecordsTopValue">{$TOTAL_ITEMS_SELECTED}</span>
    <input type='hidden' id='selectCountTop' name='selectCount[]' value='{$TOTAL_ITEMS_SELECTED}' />
</label>
<script>
{literal}
    $(document).ready(function () {
        function update_selectedRecordsTopValue() {
            $('#selectedRecordsTopValue').html(sugarListView.get_num_selected())
        }
        setInterval(update_selectedRecordsTopValue, 600);
    });
{/literal}
</script>