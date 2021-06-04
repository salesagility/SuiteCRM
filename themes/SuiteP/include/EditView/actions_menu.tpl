{* <div id="no-tab-actions">
    <ul class="nav nav-pills"> *}
{* <ul class="dropdown-menu"> *}
<ul class="dropdown-menu" style="border-radius: 0px;margin-bottom: -1px;">
{*  *}
    {{if !isset($form.buttons)}}
    <li>{{sugar_button module="$module" id="SAVE" view="$view" form_id="$form_id"}}</li>
    <li>{{sugar_button module="$module" id="CANCEL" view="$view" form_id="$form_id"}}</li>
    {{else}}
    {{counter assign="num_buttons" start=0 print=false}}
{*    {{foreach from=$form.buttons key=val item=button}}
    {{if !is_array($button) && in_array($button, $built_in_buttons)}}
    {{counter print=false}}
    <li>{{sugar_button module="$module" id="$button" view="$view" form_id="$form_id"}}</li>
    {{/if}}
    {{/foreach}} *}
    {{if count($form.buttons) > $num_buttons}}
    {{foreach from=$form.buttons key=val item=button}}
    {{if is_array($button) && $button.customCode}}
    <li>{{sugar_button module="$module" id="$button" view="$view" form_id="$form_id"}}</li>
    {{/if}}
    {{/foreach}}
    {{/if}}
    {{foreach from=$form.buttons key=val item=button}}
    {{if !is_array($button) && in_array($button, $built_in_buttons)}}
    {{counter print=false}}
    <li>{{sugar_button module="$module" id="$button" view="$view" form_id="$form_id"}}</li>
    {{/if}}
    {{/foreach}}
    {{if empty($form.hideAudit) || !$form.hideAudit}}
    <li>{{sugar_button module="$module" id="Audit" view="$view" form_id="$form_id"}}</li>
    {{/if}}
    <li>
    {if $showVCRControl}
            <button type="button" id="save_and_continue" class="button saveAndContinue" title="{$app_strings.LBL_SAVE_AND_CONTINUE}" onClick="SUGAR.saveAndContinue(this);">
                {$APP.LBL_SAVE_AND_CONTINUE}
            </button>
    {/if}
    </li>
    {{/if}}
</ul>
{* </div> *}