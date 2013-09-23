{if $AUTHENTICATED}
{*<div id="search">
    <form name='UnifiedSearch' action='index.php'>
        <input type="hidden" name="action" value="UnifiedSearch">
        <input type="hidden" name="module" value="Home">
        <input type="hidden" name="search_form" value="false">
        <input type="hidden" name="advanced" value="false">
        <input type="text" name="query_string" id="query_string" class="sugar_spot_search" size="20" value="{$SEARCH}">
        <div id="glblSearchBtn">
        	<button type="submit" class="rmv_btn_css">
        	<div class="global_search_btn" onclick="javascript:this.form.submit()"></div>
        	</button>
    	</div>
    </form>
    <div id="unified_search_advanced_div"> </div>
</div>
{*
<div id="dcmenuSearchDiv">
	<div id="sugar_spot_search_div">
		<input size='60' id='sugar_spot_search'>
	</div>
</div>

<div id="glblSearchBtn">
	<a href="javascript: DCMenu.spot(document.getElementById('sugar_spot_search').value);">
	<div class="global_search_btn"></div>
	</a>
</div>
*}
{/if}