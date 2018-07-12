<h1 class="module-title-text">Search</h1>

<form id="mastersearch-form">
    {*hidden inputs to handle actions*}
    <input name="action" value="Search" type="hidden">

    <div class="row">
        <div class="col-md-6 msfcol">
            <label for="search-query-string" class="text-muted" style="left: 23px">Search Query</label>
            <input type="text"
                   name="search-query-string"
                   id="search-query-string"
                   placeholder="Search..."
                   value="{$searchQueryString}"
                   autofocus/>
        </div>
        <div class="col-md-2 msfcol">
            <label for="search-query-size" class="text-muted">Results per page</label>
            {html_options options=$sizeOptions selected=$searchQuerySize id="search-query-size" name="search-query-size"}
        </div>
        <div class="col-md-2 msfcol">
            <label for="search-query-size" class="text-muted">Engine</label>
            {html_options options=$engineOptions selected=$searchQueryEngine id="search-engine" name="search-engine"}
        </div>
        <div class="col-md-2 msfcol">
            <input type="submit" value="search"/>
        </div>
    </div>
</form>

{literal}
    <style>
        #mastersearch-form {
            margin-top: 60px;
            margin-bottom: 60px;
        }

        #mastersearch-form label {
            position: absolute;
            top: -17px;
            left: 12px;
        }

        #mastersearch-form .msfcol {
            position: relative;
            margin: -3px;
        }

        #mastersearch-form input, #mastersearch-form select {
            width: 100%;
            height: 40px;
            border-radius: 0;
            background: #d8f5ee;
            border: 1px solid #a5e8d6;
        }

        #mastersearch-form input[type="submit"] {
            background: #f08377;
            border: none;
            border-radius: 0 20px 20px 0;
        }

        #search-query-string {
            border-radius: 20px 0 0 20px !important;
            padding-left: 20px;
        }
    </style>
{/literal}

{if !empty($searchQueryString)}
    {include file="modules/Home/templates/search.results.tpl"}
{/if}