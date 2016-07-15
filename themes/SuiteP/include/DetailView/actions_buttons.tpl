<div class="buttons">
    {{if !empty($form) && !empty($form.buttons)}}
    {{foreach from=$form.buttons key=val item=button}}
    {{sugar_button module="$module" id="$button" form_id="formDetailView" view="$view" }}
    {{/foreach}}
    {{else}}
    {{sugar_button module="$module" id="SAVE" view="$view" form_id="formDetailView"}}
    {{sugar_button module="$module" id="CANCEL" view="$view" form_id="formDetailView"}}
    {{/if}}
    {{if empty($form.hideAudit) || !$form.hideAudit}}
    {{sugar_button module="$module" id="Audit" view="$view" form_id="formDetailView"}}
    {{/if}}
</div>