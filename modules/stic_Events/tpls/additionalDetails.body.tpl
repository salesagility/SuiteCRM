{if !empty($FIELD.NAME)}
    <div>
        <a href="index.php?action=DetailView&module={$MODULE_NAME}&record={$FIELD.ID}">{$FIELD.NAME}</a>
    </div>
{/if}
<br>
{if !empty($FIELD.LBL_EXPECTED_COST)}
    <div>
        <strong>{$PARAM.LBL_EXPECTED_COST}:</strong>
        {$FIELD.LBL_EXPECTED_COST}
    </div>
{/if}
{if !empty($FIELD.LBL_TIMETABLE)}
    <div>
        <strong>{$PARAM.LBL_TIMETABLE}:</strong>
        {$FIELD.LBL_TIMETABLE}
    </div>
{/if}
<div>
    <strong>{$PARAM.LBL_STATUS_PANEL}:</strong><br>
    {$PARAM.LBL_STATUS_MAYBE} {$FIELD.STATUS_MAYBE}<br>
    {$PARAM.LBL_STATUS_CONFIRMED} {$FIELD.STATUS_CONFIRMED}<br>
    {$PARAM.LBL_STATUS_REJECTED} {$FIELD.STATUS_REJECTED}<br>
    {$PARAM.LBL_STATUS_INVITED} {$FIELD.STATUS_INVITED}<br>
    {$PARAM.LBL_STATUS_NOT_INVITED} {$FIELD.STATUS_NOT_INVITED}<br>
    {$PARAM.LBL_STATUS_DIDNT_TAKE_PART} {$FIELD.STATUS_DIDNT_TAKE_PART}<br>
    {$PARAM.LBL_STATUS_TOOK_PART} {$FIELD.STATUS_TOOK_PART}<br>
    {$PARAM.LBL_STATUS_DROP_OUT} {$FIELD.STATUS_DROP_OUT}<br><br>
</div>
{if !empty($FIELD.SESSION_AMOUNT)}
    <div>
        <strong>{$PARAM.LBL_SESSION_AMOUNT}:</strong>
        {sugar_number_format var=$FIELD.SESSION_AMOUNT stringFormat=false}
    </div>
{/if}
{if !empty($FIELD.PRICE)}
    <div>
        <strong>{$PARAM.LBL_PRICE}:</strong>
        {$FIELD.PRICE}
    </div>
{/if}
{if !empty($FIELD.STIC_EVENTS_PROJECT_NAME)}
    <div>
        <strong>{$PARAM.LBL_STIC_EVENTS_PROJECT_FROM_PROJECT_TITLE}:</strong>
        <a href="index.php?module=Project&action=DetailView&record={$FIELD.STIC_EVENTS_PROJECTPROJECT_IDA}">{$FIELD.STIC_EVENTS_PROJECT_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.STIC_EVENTS_FP_EVENT_LOCATIONS_NAME)}
    <div>
        <strong>{$PARAM.LBL_STIC_EVENTS_FP_EVENT_LOCATIONS_FROM_FP_EVENT_LOCATIONS_TITLE}:</strong>
        <a href="index.php?module=FP_Event_Locations&action=DetailView&record={$FIELD.STIC_EVENTS_FP_EVENT_LOCATIONSFP_EVENT_LOCATIONS_IDA}">{$FIELD.STIC_EVENTS_FP_EVENT_LOCATIONS_NAME}</a>
    </div>
{/if}

{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.PRICE) 
    || !empty($FIELD.STIC_EVENTS_PROJECT_NAME) 
    || !empty($FIELD.STIC_EVENTS_FP_EVENT_LOCATIONS_NAME) 
    || !empty($FIELD.LBL_TIMETABLE)
    ||!empty($FIELD.LBL_EXPECTED_COST)}
    <br>
{/if}

{if !empty($FIELD.DATE_ENTERED)}
    <div>
        <strong>{$PARAM.LBL_DATE_ENTERED}:</strong>
        {$FIELD.DATE_ENTERED}
    </div>
{/if}
{if !empty($FIELD.DATE_MODIFIED)}
    <div>
        <strong>{$PARAM.LBL_DATE_MODIFIED}:</strong>
        {$FIELD.DATE_MODIFIED}
    </div>
{/if}
