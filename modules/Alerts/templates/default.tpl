{$Flash}

{if !$Flash}
<div class="clear-all-alerts-container">
    <a class="clear-all-alerts-btn btn btn-warning btn-xs">{sugar_translate label="LBL_CLEARALL"}</a>
    {literal}
    <script>
          $('.clear-all-alerts-btn').unbind('click').click(function (event) {
            $('.desktop_notifications:first .alert-dismissible .close').each(function (i, v) {
              $(v).click();
            });
          });
    </script>
    {/literal}
</div>
{/if}
{foreach from=$Results item=result}
    <div class="alert alert-{if $result->type != null}{$result->type}{else}info{/if} alert-dismissible module-alert" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="Alerts.prototype.markAsRead('{$result->id}');"><span aria-hidden="true">&times;</span></button>
        <h4 class="alert-header">
        {if $result->url_redirect != null && !($result->url_redirect|strstr:"fake_") }
        <a class="alert-link text-{if $result->type != null}{$result->type}{else}info{/if}" href="index.php?module=Alerts&action=redirect&record={$result->id}">
        {/if}
            {if $result->target_module != null }
                {* Pluralize the module name if necessary. *}
                <span class="suitepicon suitepicon-module-{$result->target_module|lower|replace:'_':'-'}{if substr($result->target_module, -1) !== 's'}s{/if}"></span>
                <strong class="text-{if $result->type != null}{$result->type}{else}info{/if}">{$result->target_module}</strong>
            {else}
                <strong class="text-{if $result->type != null}{$result->type}{else}info{/if}">Alert</strong>
            {/if}
        {if $result->url_redirect != null }
        </a>
        {/if}
        </h4>
        <p class="alert-body alert-body-{if $result->type != null}{$result->type}{else}info{/if}">
            <span class="alert-name alert-name-{if $result->type != null}{$result->type}{else}info{/if}">{$result->name|nl2br}</span><br/>
            <span class="alert-description alert-description-{if $result->type != null}{$result->type}{else}info{/if}">{$result->description|nl2br}</span>
        </p>
    </div>
{/foreach}

