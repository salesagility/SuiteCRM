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

{if !empty($FIELD.DATE_DUE)}
    <div data-field="DATE_DUE">
        <strong>{$MOD.LBL_DUE_DATE_AND_TIME}</strong>
        {$FIELD.DATE_DUE}
    </div>
{/if}

{if !empty($FIELD.PRIORITY)}
    <div data-field="PRIORITY">
        <strong>{$MOD.LBL_PRIORITY}</strong>
        {$FIELD.PRIORITY}
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
