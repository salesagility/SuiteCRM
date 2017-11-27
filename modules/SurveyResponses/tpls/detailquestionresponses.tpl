<div>
    <table id="questionResponseTable" class="table table-bordered">
        <tr>
            <th></th>
            <th>
                Question
            </th>
            <th>
                Response
            </th>
        </tr>
        {foreach from=$questionResponses item=questionResponse}
            <tr>
                <td>Q{$questionResponse.sort_order+1}</td>
                <td>
                    {$questionResponse.questionName}
                </td>
                <td>
                    {$questionResponse.answer}
                </td>
            </tr>
        {/foreach}
    </table>
</div>
