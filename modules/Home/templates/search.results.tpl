<h2 class="moduleTitle">Results</h2>
{foreach from=$hits item=beans key=module}
    <h3>{$module}</h3>
    <ul>
        {foreach from=$beans item=bean}
            <li>
                <a href="/index.php?action=DetailView&module={$module}&record={$bean->id}&offset=1">{$bean->name}</a>
            </li>
        {/foreach}
    </ul>
{/foreach}