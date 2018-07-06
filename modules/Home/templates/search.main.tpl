<h1 class="module-title-text">MasterSearch</h1>

<form id="mastersearch-form">
    <input name="action" value="Search" type="hidden">
    <label for="search-query-string">Search Query</label>
    <input type="text"
           name="search-query-string"
           id="search-query-string"
           placeholder="Search"
           value="{$searchQueryString}"/>

    <label for="search-query-size">Results per page</label>
    {html_options options=$sizeOptions selected=$searchQuerySize id="search-query-size" name="search-query-size"}

    <label for="search-query-size">Engine</label>
    {html_options options=$engineOptions selected=$searchQueryEngine id="search-engine" name="search-engine"}

    <input type="submit" value="search"/>
</form>

{if !empty($searchQueryString)}
    {include file="modules/Home/templates/search.results.tpl"}
{/if}