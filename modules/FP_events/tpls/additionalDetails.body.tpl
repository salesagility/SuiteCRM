<input id="type" type="hidden" value="{$OBJECT_NAME}"/>
{if !empty($FIELD.ID)}
    <input id="id" type="hidden" value="{$FIELD.ID}"/>
{/if}

{if !empty($FIELD.NAME)}
    <div>
        <strong>{$MOD_STR.LBL_EVENT_NAME}</strong>
        <a class="link-color-add-details" href="index.php?action=DetailView&module={$MODULE_NAME}&record={$FIELD.ID}">{$FIELD.NAME}</a>
    </div>
{/if}

{if !empty($FIELD.DATE_START)}
    <div data-field="DATE_START" data-date="{$FIELD.DB_DATE_START}">
        <strong>{$MOD_STR.LBL_DATE_TIME}</strong>
        {$FIELD.DATE_START}
    </div>
{/if}

{if !empty($FIELD.DURATION_HOURS)  or !empty($FIELD.DURATION_MINUTES)}
    <div>
        <strong>{$MOD.LBL_DURATION}</strong>
        {if !empty($FIELD.DURATION_HOURS)}
            {if $FIELD.DURATION_HOURS > 1}
                {$FIELD.DURATION_HOURS} {$MOD_STR.LBL_EVENT_HOURS_ABBREV}
            {else}
                {$FIELD.DURATION_HOURS} {$MOD_STR.LBL_EVENT_HOUR_ABBREV}
            {/if}
        {/if}
        {if !empty($FIELD.DURATION_MINUTES)}
            {$FIELD.DURATION_MINUTES} {$MOD_STR.LBL_EVENT_MINSS_ABBREV}
        {/if}
    </div>
{/if}

{if !empty($FIELD.FP_EVENT_LOCATIONS_FP_EVENTS_1_NAME)}
    <div>
        <strong>{$MOD_STR.LBL_LOCATION_ADDITIONAL_DETAILS}</strong>
        <a class="link-color-add-details" href="index.php?module=FP_Event_Locations&action=DetailView&record={$FIELD.FP_EVENT_LOCATIONS_FP_EVENTS_1FP_EVENT_LOCATIONS_IDA}">{$FIELD.FP_EVENT_LOCATIONS_FP_EVENTS_1_NAME}</a>
    </div>
{/if}

{if !empty($FIELD.STATUS)}
    <div>
        <strong>{$MOD_STR.LBL_STATUS}</strong>
        {$FIELD.STATUS}
    </div>
{/if}

{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$MOD_STR.LBL_EVENT_DESCRIPTION}</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
