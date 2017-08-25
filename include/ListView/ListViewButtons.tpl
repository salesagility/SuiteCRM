{if isset($form.buttons)}
<ul class="list-view-action-buttons">

    {counter assign="num_action_buttons" start=0 print=false}
    {if count($form.buttons) > $num_action_buttons}
        {foreach from=$form.buttons key=val item=button}
        {if is_array($button) && $button.customCode}<li>{eval var=$button.customCode} </li>{/if}
        {/foreach}
    {/if}
</ul>
{/if}
