{if $AUTHENTICATED}
<div id="user_info">
	<div id="admin_list">
	</div>
	
	<div id="user_list">
		<div id="user_link">{$CURRENT_USER}</div>
	</div>
</div>
{/if}

<div id="user_options" style="display: none;">
	<a href='index.php?module=Users&action=EditView&record={$CURRENT_USER_ID}'>My Profile</a><br/>
	
	{foreach from=$GCLS item=GCL name=gcl key=gcl_key}
	<a id="{$gcl_key}_link" href="{$GCL.URL}" {if $smarty.foreach.gcl.last}class="last"{/if}{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a><br/>

	{foreach from=$GCL.SUBMENU item=GCL_SUBMENU name=gcl_submenu key=gcl_submenu_key}
	<a id="{$gcl_submenu_key}_link" href="{$GCL_SUBMENU.URL}"{if !empty($GCL_SUBMENU.ONCLICK)} onclick="{$GCL_SUBMENU.ONCLICK}"{/if}>{$GCL_SUBMENU.LABEL}</a><br/>
	{/foreach}

	{/foreach}
	<a id="logout_link" href='{$LOGOUT_LINK}' class='utilsLink'>{$LOGOUT_LABEL}</a>
</div>