<div>
    <table id="{$question.id}List" style="display: none; width:33%" class="table table-bordered">
        <tr>
            <th>
                {$mod.LBL_RESPONSE_ANSWER}
            </th>
            <th>
                {$mod.LBL_RESPONSE_CONTACT}
            </th>
            <th>
                {$mod.LBL_RESPONSE_TIME}
            </th>
        </tr>
        {foreach from=$question.responses item=response}
            <tr>
                <td>
                    {$response.answer}
                </td>
                <td>
                    {if $response.contact}
                        <a href="index.php?module=Contacts&action=DetailView&record={$response.contact.id}">
                            {$response.contact.name}
                        </a>
                    {else}
                        {$mod.LBL_UNKNOWN_CONTACT}
                    {/if}
                </td>
                <td>
                    {$response.time}
                </td>
            </tr>
        {/foreach}
    </table>
    <a href="#" class="showHideResponses" data-question-id="{$question.id}">{$mod.LBL_SHOW_RESPONSES}</a>
</div>