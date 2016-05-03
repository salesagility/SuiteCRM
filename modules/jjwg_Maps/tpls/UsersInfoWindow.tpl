
<div class="marker"><b>{$moduleListSingular.Users}: 
<a target="_blank" 
href="index.php?module={$module_type}&action=DetailView&record={$fields.id}">{$fields.first_name} {$fields.last_name}</a></b> 
<br />{$address}
<br /><br />
<a target="_blank" href="http://maps.google.com/maps?q={$address|escape:'url'}">{$mod_strings.LBL_MAP_GOOGLE_MAPS_VIEW}</a>&nbsp;
<a target="_blank" href="http://maps.google.com/maps?saddr={$current_user_address|escape:'url'}&daddr={$address|escape:'url'}">{$mod_strings.LBL_MAP_GET_DIRECTIONS}</a>
</div>
