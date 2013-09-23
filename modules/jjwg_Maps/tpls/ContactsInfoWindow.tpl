
<div class="marker"><b>{$moduleListSingular.Contacts}: 
<a target="_blank" 
href="index.php?module={$module_type}&action=DetailView&record={$fields.id}">{$fields.name}</a></b> 
{if ($fields.account_id != '' && $fields.account_name != '')}<br />{$moduleListSingular.Accounts}: <a target="_blank" 
href="index.php?module=Accounts&action=DetailView&record={$fields.account_id}">{$fields.account_name}</a>{/if}
<br />{$address}
<br /><i>{$mod_strings.LBL_MAP_ASSIGNED_TO} {$fields.assigned_user_name}</i>
<br /><br />
<a href="http://maps.google.com/maps?saddr={$current_user_address|escape:'url'}&daddr={$address|escape:'url'}">{$mod_strings.LBL_MAP_GET_DIRECTIONS}</a>
</div>
