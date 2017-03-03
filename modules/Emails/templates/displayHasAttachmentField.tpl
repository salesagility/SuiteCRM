<div class="email-has-attachement">
    {if $bean}
        {if $bean.has_attachment}
            <div class="email-has-attachment"><span class="glyphicon"><img src="{sugar_getimagepath  directory='' file_name='attachment-indicator' file_extension="svg" file='attachment-indicator.svg'}"/></span></div>
        {/if}

    {/if}
</div>