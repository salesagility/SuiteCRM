{$Flash}

{foreach from=$Results item=result}
    <div class="alert alert-{if $result->type != null}{$result->type}{else}info{/if} alert-dismissible module-alert" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="Alerts.prototype.markAsRead('{$result->id}');"><span aria-hidden="true">&times;</span></button>
        <h4>
        {if $result->url_redirect != null && !($result->url_redirect|strstr:"fake_") }
        <a class="alert-link text-{if $result->type != null}{$result->type}{else}info{/if}" href="index.php?module=Alerts&action=redirect&record={$result->id}">
        {/if}
            {if $result->target_module != null }
                <img src="index.php?entryPoint=getImage&themeName=SuiteR+&imageName={$result->target_module}s.gif"/>
                <strong class="text-{if $result->type != null}{$result->type}{else}info{/if}">{$result->target_module}</strong>
            {else}
                <strong class="text-{if $result->type != null}{$result->type}{else}info{/if}">Alert</strong>
            {/if}
        {if $result->url_redirect != null }
        </a>
        {/if}
        </h4>
        <p>
            {$result->name|nl2br}<br/>
            {$result->description|nl2br}
        </p>
    </div>
{/foreach}

