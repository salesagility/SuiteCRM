
<div class="marker"><b>{$moduleListSingular.Cases}: 
<a target="_blank" 
href="index.php?module={$module_type}&action=DetailView&record={$fields.id}">{$fields.name}</a></b> 
<br />{$address}<br />
<i>{$mod_strings.LBL_MAP_ASSIGNED_TO} {$fields.assigned_user_name}</i>
<br /><br />
<a target="_blank" href="http://maps.google.com/maps?q={$address|escape:'url'}">{$mod_strings.LBL_MAP_GOOGLE_MAPS_VIEW}</a>&nbsp;
<a target="_blank" href="http://maps.google.com/maps?saddr={$current_user_address|escape:'url'}&daddr={$address|escape:'url'}">{$mod_strings.LBL_MAP_GET_DIRECTIONS}</a>
</div>
