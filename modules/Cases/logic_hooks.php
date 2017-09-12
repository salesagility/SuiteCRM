<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Cases push feed', 'modules/Cases/SugarFeeds/CaseFeed.php','CaseFeed', 'pushFeed');
 
$hook_array['before_save'][] = Array(10, 'Save case updates', 'custom/modules/AOP_Case_Updates/CaseUpdatesHook.php','CustomCaseUpdatesHook', 'saveUpdate');
 
$hook_array['before_save'][] = Array(11, 'Save case events', 'modules/AOP_Case_Events/CaseEventsHook.php','CaseEventsHook', 'saveUpdate');
 
$hook_array['before_save'][] = Array(12, 'Case closure prep', 'custom/modules/AOP_Case_Updates/CaseUpdatesHook.php','CustomCaseUpdatesHook', 'closureNotifyPrep');
 
$hook_array['before_save'][] = Array(77, 'updateGeocodeInfo', 'modules/Cases/CasesJjwg_MapsLogicHook.php','CasesJjwg_MapsLogicHook', 'updateGeocodeInfo'); 

$hook_array['after_save'] = Array();
$hook_array['after_save'][] = Array(10, 'Send contact case closure email', 'custom/modules/AOP_Case_Updates/CaseUpdatesHook.php','CustomCaseUpdatesHook', 'closureNotify');
 
$hook_array['after_save'][] = Array(77, 'updateRelatedMeetingsGeocodeInfo', 'modules/Cases/CasesJjwg_MapsLogicHook.php','CasesJjwg_MapsLogicHook', 'updateRelatedMeetingsGeocodeInfo'); 
$hook_array['after_relationship_add'] = Array(); 

$hook_array['after_relationship_add'][] = Array(9, 'Assign account', 'custom/modules/AOP_Case_Updates/CaseUpdatesHook.php','CustomCaseUpdatesHook', 'assignAccount'); 

$hook_array['after_relationship_add'][] = Array(10, 'Send contact case email', 'custom/modules/AOP_Case_Updates/CaseUpdatesHook.php','CustomCaseUpdatesHook', 'creationNotify');
 
$hook_array['after_relationship_add'][] = Array(77, 'addRelationship', 'modules/Cases/CasesJjwg_MapsLogicHook.php','CasesJjwg_MapsLogicHook', 'addRelationship'); 
$hook_array['after_retrieve'] = Array(); 

$hook_array['after_retrieve'][] = Array(10, 'Filter HTML', 'custom/modules/AOP_Case_Updates/CaseUpdatesHook.php','CustomCaseUpdatesHook', 'filterHTML');
 
$hook_array['after_relationship_delete'] = Array(); 
$hook_array['after_relationship_delete'][] = Array(77, 'deleteRelationship', 'modules/Cases/CasesJjwg_MapsLogicHook.php','CasesJjwg_MapsLogicHook', 'deleteRelationship'); 



?>