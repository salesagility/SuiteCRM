<div id="globalLinksModule">
	<div id="globalLinksCtrl">
	</div>
<div id="globalLinks">

    {foreach from=$GCLS item=GCL name=gcl key=gcl_key}

    <span {if $smarty.foreach.gcl.first}class="first"{/if}>|</span>
    <a id="{$gcl_key}_link" href="{$GCL.URL}" {if $smarty.foreach.gcl.last}class="last"{/if}{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a>

    {foreach from=$GCL.SUBMENU item=GCL_SUBMENU name=gcl_submenu key=gcl_submenu_key}
    <a id="{$gcl_submenu_key}_link" href="{$GCL_SUBMENU.URL}"{if !empty($GCL_SUBMENU.ONCLICK)} onclick="{$GCL_SUBMENU.ONCLICK}"{/if}>{$GCL_SUBMENU.LABEL}</a>
    {/foreach}

    {/foreach}
</div>
{include file="_welcome.tpl" theme_template=true}
</div>