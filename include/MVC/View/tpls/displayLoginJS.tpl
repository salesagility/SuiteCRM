{if $MODULE_SUGAR_GRP1}
    <script type="text/javascript">var module_sugar_grp1 = '{$MODULE_SUGAR_GRP1}';</script>
{/if}
{if $ACTION_SUGAR_GRP1}
    <script type="text/javascript">var action_sugar_grp1 = '{$ACTION_SUGAR_GRP1}';</script>
{/if}
<script type="text/javascript" src="{$SUGAR_GRP1_JQUERY}" z></script>
<script type="text/javascript" src="{$SUGAR_GRP1_YUI}"></script>
<script type="text/javascript" src="{$SUGAR_GRP1}"></script>
<script type="text/javascript" src="{$CALENDAR}"></script>
<script type="text/javascript">
{literal}
    if ( typeof(SUGAR) == 'undefined' ) {SUGAR = {}};
    if ( typeof(SUGAR.themes) == 'undefined' ) SUGAR.themes = {};
{/literal}
</script>

{if $HEADERSYNC}
    <script type="text/javascript" src="{$HEADERSYNC}"></script>
{/if}
