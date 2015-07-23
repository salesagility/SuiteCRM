<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
//$hook_array['before_save'][] = Array(1, 'Leads push feed', 'modules/Leads/SugarFeeds/LeadFeed.php','LeadFeed', 'pushFeed');
$hook_array['before_save'][] = Array(1, 'update dependencies', 'custom/modules/ProjectTask/updateDependencies.php','updateDependencies', 'update_dependency');
$hook_array['after_save'] = Array();
$hook_array['after_save'][] = Array(1, 'update project end date', 'custom/modules/ProjectTask/updateProject.php','updateEndDate', 'update');
//$hook_array['after_ui_frame'] = Array();
//$hook_array['after_ui_frame'][] = Array(1, 'Leads InsideView frame', 'modules/Connectors/connectors/sources/ext/rest/insideview/InsideViewLogicHook.php','InsideViewLogicHook', 'showFrame');


?>