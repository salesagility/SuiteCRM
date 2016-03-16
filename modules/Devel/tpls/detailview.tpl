{*
    @var \DevelRequestStats $stats
*}
<link href="modules/Devel/assets/css/Devel.css" rel="stylesheet" type="text/css" />
<div id="{$containerID}">

    <h1>Details for requests #{$stats->getRequestNumber()}</h1>

    <table class='table table-bordered table-striped'>
        <tr>
            <th>Module</th>
            <th>Action</th>
            <th>Method</th>
            <th>Time</th>
            <th>Memory</th>
            <th>Queries</th>
            <th>Execution Date</th>
        </tr>
        <tr>
            <td>{$stats->getModule()}</td>
            <td>{$stats->getAction()}</td>
            <td>{$stats->getRequestMethod()}</td>
            <td>{$stats->getExecutionLength()|string_format:"%.2f"}s</td>
            <td>{$stats->getFormattedMemoryUsage()}</td>
            <td>{$stats->getTotalQueryCount()}</td>
            <td>{$stats->getFormattedExecutionTime()}</td>
        </tr>
    </table>

    <div class="tabs">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#queries" aria-controls="queries" role="tab" data-toggle="tab">Queries</a></li>
            <li role="presentation"><a href="#get" aria-controls="get" role="tab" data-toggle="tab">Get</a></li>
            <li role="presentation"><a href="#post" aria-controls="post" role="tab" data-toggle="tab">Post</a></li>
            <li role="presentation"><a href="#files" aria-controls="files" role="tab" data-toggle="tab">Files</a></li>
            <li role="presentation"><a href="#session" aria-controls="session" role="tab" data-toggle="tab">Session</a></li>
            <li role="presentation"><a href="#environment" aria-controls="environment" role="tab" data-toggle="tab">Environment</a></li>
            <li role="presentation"><a href="#cookie" aria-controls="cookie" role="tab" data-toggle="tab">Cookies</a></li>
            <li role="presentation"><a href="#server" aria-controls="server" role="tab" data-toggle="tab">Server</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

            <!-- QUERIES -->
            <div role="tabpanel" class="tab-pane active" id="queries">
                {convert_to_printable_key_value_array data = $stats->getExecutedQueries() assign='php_data'}
                {if !empty($php_data)}
                    <table class='table table-bordered'>
                        <tr>
                            <th>#</th>
                            <th>Query</th>
                        </tr>
                        {counter start=0 print=false}
                        {foreach from=$php_data item=query}
                        <tr>
                            <td>{counter}</td>
                            <td><code>{$query}</code></td>
                        </tr>
                        {/foreach}
                    </table>
                {else}
                    <p>No queries.</p>
                {/if}
            </div>

            <!-- GET -->
            <div role="tabpanel" class="tab-pane" id="get">
                {convert_to_printable_key_value_array data = $stats->getPhpGet() assign='php_data'}
                {if !empty($php_data)}
                    <table class='table table-bordered'>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                        </tr>
                        {foreach from=$php_data key=k item=v}
                            <tr>
                                <td>{$k}</td>
                                <td>{$v}</td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p>No GET variables.</p>
                {/if}
            </div>

            <!-- POST -->
            <div role="tabpanel" class="tab-pane" id="post">
                {convert_to_printable_key_value_array data = $stats->getPhpPost() assign='php_data'}
                {if !empty($php_data)}
                    <table class='table table-bordered'>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                        </tr>
                        {foreach from=$php_data key=k item=v}
                            <tr>
                                <td>{$k}</td>
                                <td>{$v}</td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p>No POST variables.</p>
                {/if}
            </div>

            <!-- FILES -->
            <div role="tabpanel" class="tab-pane" id="files">
                {convert_to_printable_key_value_array data = $stats->getPhpFiles() assign='php_data'}
                {if !empty($php_data)}
                    <table class='table table-bordered'>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                        </tr>
                        {foreach from=$php_data key=k item=v}
                            <tr>
                                <td>{$k}</td>
                                <td>{$v}</td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p>No FILES variables.</p>
                {/if}
            </div>

            <!-- SESSION -->
            <div role="tabpanel" class="tab-pane" id="session">
                {convert_to_printable_key_value_array data = $stats->getPhpSession() assign='php_data'}
                {if !empty($php_data)}
                    <table class='table table-bordered'>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                        </tr>
                        {foreach from=$php_data key=k item=v}
                            <tr>
                                <td>{$k}</td>
                                <td>
                                    {if $v|is_string && !$v|is_array}
                                        {$v}
                                    {elseif $v|is_array}
                                        {$v|@debug_print_var}
                                    {else}
                                        {$v|@print_r}
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p>No session variables.</p>
                {/if}
            </div>

            <!-- ENVIRONMENT -->
            <div role="tabpanel" class="tab-pane" id="environment">
                {convert_to_printable_key_value_array data = $stats->getPhpEnv() assign='php_data'}
                {if !empty($php_data)}
                    <table class='table table-bordered'>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                        </tr>
                        {foreach from=$php_data key=k item=v}
                            <tr>
                                <td>{$k}</td>
                                <td>
                                    {if $v|is_string && !$v|is_array}
                                        {$v}
                                    {elseif $v|is_array}
                                        {$v|@debug_print_var}
                                    {else}
                                        {$v|@print_r}
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p>No environment variables.</p>
                {/if}
            </div>

            <!-- COOKIES -->
            <div role="tabpanel" class="tab-pane" id="cookie">
                {convert_to_printable_key_value_array data = $stats->getPhpCookie() assign='php_data'}
                {if !empty($php_data)}
                    <table class='table table-bordered'>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                        </tr>
                        {foreach from=$php_data key=k item=v}
                            <tr>
                                <td>{$k}</td>
                                <td>
                                    {if $v|is_string && !$v|is_array}
                                        {$v}
                                    {elseif $v|is_array}
                                        {$v|@debug_print_var}
                                    {else}
                                        {$v|@print_r}
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p>No cookie variables.</p>
                {/if}
            </div>

            <!-- SERVER -->
            <div role="tabpanel" class="tab-pane" id="server">
                {convert_to_printable_key_value_array data = $stats->getPhpServer() assign='php_data'}
                {if !empty($php_data)}
                    <table class='table table-bordered'>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                        </tr>
                        {foreach from=$php_data key=k item=v}
                            <tr>
                                <td>{$k}</td>
                                <td>{$v}</td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p>No server variables.</p>
                {/if}
            </div>

        </div>
    </div>
</div>