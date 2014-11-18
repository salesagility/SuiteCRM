
<button id="addFileButton" type="button">{$MOD.LBL_ADD_CASE_FILE}</button>
{literal}
<script>
    $(document).ready(function(){
        $('#addFileButton').click(function(e){
            var template = $('#updateFileRowTemplate').html();
            $(e.target).before(template);
        });
        $(document).on('click','.removeFileButton',function(e){
            $(e.target).closest('span').remove();
        });
    });
</script>
{/literal}
<script id="updateFileRowTemplate"  type="text/template">
    <span><input type="file" id="case_update_file[]" name="case_update_file[]"><button class="removeFileButton" type="button">{$MOD.LBL_REMOVE_CASE_FILE}</button><br></span>
</script>
