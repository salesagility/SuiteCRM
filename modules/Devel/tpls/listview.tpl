<link href="modules/Devel/assets/css/Devel.css" rel="stylesheet" type="text/css" />
<div id="{$containerID}">
    <h1>List of requests</h1>
    <table cellpadding='0' cellspacing='0' width='100%' border='0' class='table table-bordered table-condensed table-striped'>
        <tr>
            <th>#</th>
            <th>Module</th>
            <th>Action</th>
            <th>Method</th>
            <th>Time</th>
            <th>Memory</th>
            <th>Queries</th>
            <th>Execution Date</th>
        </tr>
        {foreach from=$stats item=stat}
            <tr>
                <td scope='col' nowrap="nowrap">
                    <a href="index.php?module=Devel&action=DetailView&request={$stat.number}">
                        {$stat.number}
                    </a>
                </td>
                <td scope='col' nowrap="nowrap">
                    {$stat.module}
                </td>
                <td scope='col' nowrap="nowrap">
                    {$stat.action}
                </td>
                <td scope='col' nowrap="nowrap">
                    {$stat.method}
                </td>
                <td scope='col' nowrap="nowrap">
                    {$stat.exec_length}
                </td>
                <td scope='col' nowrap="nowrap">
                    {$stat.memory_usage}
                </td>
                <td scope='col' nowrap="nowrap">
                    {$stat.query_count}
                </td>
                <td scope='col' nowrap="nowrap">
                    {$stat.exec_date}
                </td>
            </tr>
        {/foreach}
    </table>
</div>