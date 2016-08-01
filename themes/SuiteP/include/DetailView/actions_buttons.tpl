<div class="buttons">
    {*
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
    *}
    {{if !isset($form.buttons)}}
    {{sugar_button module="$module" id="EDIT" view="$view" form_id="formDetailView"}}
    {{sugar_button module="$module" id="DUPLICATE" view="EditView" form_id="formDetailView"}}
    {{sugar_button module="$module" id="DELETE" view="$view" form_id="formDetailView"}}
    {{else}}
    {{counter assign="num_buttons" start=0 print=false}}
    {{foreach from=$form.buttons key=val item=button}}
    {{if !is_array($button) && in_array($button, $built_in_buttons)}}
    {{counter print=false}}
    {{sugar_button module="$module" id="$button" view="EditView" form_id="formDetailView"}}
    {{/if}}
    {{/foreach}}
    {{if count($form.buttons) > $num_buttons}}
    {{foreach from=$form.buttons key=val item=button}}
    {{if is_array($button) && $button.customCode}}
    {{sugar_button module="$module" id="$button" view="EditView" form_id="formDetailView"}}
    {{/if}}
    {{/foreach}}
    {{/if}}
    {{if empty($form.hideAudit) || !$form.hideAudit}}
    {{sugar_button module="$module" id="Audit" view="EditView" form_id="formDetailView"}}
    {{/if}}
    {{/if}}
</div>