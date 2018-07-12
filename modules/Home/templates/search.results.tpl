<h2 class="moduleTitle">Results</h2>
{if isset($error)}
    <p class="error">An error has occurred while performing the search. Your query syntax might not be valid.</p>
{else}
{foreach from=$hits item=beans key=module}
    <h3>{$module}</h3>
    <ul>
        {foreach from=$beans item=bean}
            <li>
                <a href="/index.php?action=DetailView&module={$module}&record={$bean->id}&offset=1">{$bean->name}</a>
            </li>
        {/foreach}
    </ul>
    {foreachelse}
    <p class="error">No results matching your search criteria. Try broadening your search.</p>
{/foreach}
{/if}