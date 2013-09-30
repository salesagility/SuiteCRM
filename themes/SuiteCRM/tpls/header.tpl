{include file="_head.tpl" theme_template=true}

<body>
	<div id="header">
		<a name="top"></a>
		{if $AUTHENTICATED}
		  {include file="_headerModuleList.tpl" theme_template=true}
		{/if}

		<div id="sub_header">
			{include file="_search.tpl" theme_template=true}

			{$SUGAR_DCMENU}

			{if !$AUTHENTICATED}
			<br /><br />
			{/if}

            {if $AUTHENTICATED}
                {include file="_headerLastViewed.tpl" theme_template=true}
            {/if}
			<div class="clear"></div>
		</div>

	</div>
    <div class="clear"></div>

	{literal}
	<iframe id='ajaxUI-history-iframe' src='index.php?entryPoint=getImage&imageName=blank.png' style='display:none'></iframe>
	<input id='ajaxUI-history-field' type='hidden'>
	<script type='text/javascript'>
	if (SUGAR.ajaxUI && !SUGAR.ajaxUI.hist_loaded)
	{
		YAHOO.util.History.register('ajaxUILoc', "", SUGAR.ajaxUI.go);
		{/literal}{if $smarty.request.module != "ModuleBuilder"}{* Module builder will init YUI history on its own *}
		YAHOO.util.History.initialize("ajaxUI-history-field", "ajaxUI-history-iframe");
		{/if}{literal}
	}
	</script>
	{/literal}

	<div id="main">
		<div id="content">
			<table style="width:100%" id="contentTable"><tr><td>
