<input id="type" type="hidden" value="{$OBJECT_NAME}"/>
{if !empty($FIELD.ID)}
    <input id="id" type="hidden" value="{$FIELD.ID}"/>
{/if}

{if !empty($FIELD.NAME)}
    <div>
        <strong>{$MOD.LBL_SUBJECT}</strong>
        <a href="index.php?action=DetailView&module={$MODULE_NAME}&record={$FIELD.ID}">{$FIELD.NAME}</a>
    </div>
{/if}

{if !empty($FIELD.DATE_START)}
    <div data-field="DATE_START" data-date="{$FIELD.DB_DATE_START}">
        <strong>{$MOD.LBL_DATE_TIME}</strong>
        {$FIELD.DATE_START}
    </div>
{/if}

{if !empty($FIELD.DURATION_HOURS)  or !empty($FIELD.DURATION_MINUTES)}
    <div>
        <strong>{$MOD.LBL_DURATION}</strong>
        {if !empty($FIELD.DURATION_HOURS)}
            {$FIELD.DURATION_HOURS} {$MOD.LBL_HOURS_ABBREV}
        {/if}

        {if !empty($FIELD.DURATION_MINUTES)}
            {$FIELD.DURATION_MINUTES} {$MOD.LBL_MINSS_ABBREV}
        {/if}
    </div>
{/if}

{if !empty($FIELD.PARENT_ID)}
    <div>
        <strong>{$MOD.LBL_RELATED_TO}</strong>
        <a href="index.php?module={$FIELD.PARENT_TYPE}&action=DetailView&record={$FIELD.PARENT_ID}">{$FIELD.PARENT_TYPE} - {$FIELD.PARENT_NAME}</a>
    </div>
{/if}

{if !empty($FIELD.STATUS)}
    <div>
        <strong>{$MOD.LBL_STATUS}</strong>
        {$FIELD.STATUS}
    </div>
{/if}

{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$MOD.LBL_DESCRIPTION}</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
