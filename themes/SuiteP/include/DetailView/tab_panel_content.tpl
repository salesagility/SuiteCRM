            {*{{if !is_array($panel)}}*}
                {*{sugar_include type='php' file='{{$panel}}'}*}
                {*if*}
            {*{{else}}*}
                {*else*}
                {*<table id='{{$label}}' class="panelContainer" cellspacing='{$gridline}'>*}
                    {*{{foreach name=rowIteration from=$panel key=row item=rowData}}*}
                        {*{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}*}
                        {*{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}*}
                        {*{capture name="tr" assign="tableRow"}*}
                        {*<tr><td>{{$rowData|var_dump}}</td></tr>*}

                        {*<tr>*}
                            {*{{assign var='columnsInRow' value=$rowData|@count}}*}
                            {*{{assign var='columnsUsed' value=0}}*}
                            {*{{foreach name=colIteration from=$rowData key=col item=colData}}*}
                                {*</td>*}
                                {*</td>*}
                                {*{{if !empty($colData.field.hideIf)}}*}
                            {*{{/if}}*}

                            {*{{/foreach}}*}
                        {*</tr>*}
                        {*{/capture}*}
                            {*{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}*}
                                {*{$tableRow}*}
                            {*{/if}*}
                    {*{{/foreach}}*}
                {*</table>*}
            {*{{/if}}*}

            <div class="row">

{{foreach name=rowIteration from=$panel key=row item=rowData}}
    {*row*}
    {{foreach name=colIteration from=$rowData key=col item=colData}}
        {*column*}
        <div class="col-xs-12 col-sm-6 col-lg-4">
        {{foreach name=fieldIteration from=$colData item=subField}}
            {*field*}
            <div class="col-xs-12">
                {{if $fields[$subField]}}
                    subfield
                {{sugar_field parentFieldArray='fields' tabindex=$tabIndex vardef=$fields[$subField] displayType='DetailView'}}
                {{else}}
                {{$subField}}
                {{/if}}
                {counter name="panelFieldCount"}
            </div>
        {{/foreach}}
        </div>
    {{/foreach}}
{{/foreach}}
            </div>