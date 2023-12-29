<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Cases push feed', 'modules/Cases/SugarFeeds/CaseFeed.php','CaseFeed', 'pushFeed'); 
$hook_array['before_save'][] = Array(10, 'Save case updates', 'modules/AOP_Case_Updates/CaseUpdatesHook.php','CaseUpdatesHook', 'saveUpdate'); 
$hook_array['before_save'][] = Array(11, 'Save case events', 'modules/AOP_Case_Events/CaseEventsHook.php','CaseEventsHook', 'saveUpdate'); 
$hook_array['before_save'][] = Array(12, 'Case closure prep', 'modules/AOP_Case_Updates/CaseUpdatesHook.php','CaseUpdatesHook', 'closureNotifyPrep'); 
$hook_array['before_save'][] = Array(77, 'updateGeocodeInfo', 'modules/Cases/CasesJjwg_MapsLogicHook.php','CasesJjwg_MapsLogicHook', 'updateGeocodeInfo'); 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(10, 'Send contact case closure email', 'modules/AOP_Case_Updates/CaseUpdatesHook.php','CaseUpdatesHook', 'closureNotify'); 
$hook_array['after_save'][] = Array(77, 'updateRelatedMeetingsGeocodeInfo', 'modules/Cases/CasesJjwg_MapsLogicHook.php','CasesJjwg_MapsLogicHook', 'updateRelatedMeetingsGeocodeInfo'); 
$hook_array['after_relationship_add'] = Array(); 
$hook_array['after_relationship_add'][] = Array(9, 'Assign account', 'modules/AOP_Case_Updates/CaseUpdatesHook.php','CaseUpdatesHook', 'assignAccount'); 
$hook_array['after_relationship_add'][] = Array(10, 'Send contact case email', 'modules/AOP_Case_Updates/CaseUpdatesHook.php','CaseUpdatesHook', 'creationNotify'); 
$hook_array['after_relationship_add'][] = Array(77, 'addRelationship', 'modules/Cases/CasesJjwg_MapsLogicHook.php','CasesJjwg_MapsLogicHook', 'addRelationship'); 
$hook_array['after_retrieve'] = Array(); 
$hook_array['after_retrieve'][] = Array(10, 'Filter HTML', 'modules/AOP_Case_Updates/CaseUpdatesHook.php','CaseUpdatesHook', 'filterHTML'); 
$hook_array['after_relationship_delete'] = Array(); 
$hook_array['after_relationship_delete'][] = Array(77, 'deleteRelationship', 'modules/Cases/CasesJjwg_MapsLogicHook.php','CasesJjwg_MapsLogicHook', 'deleteRelationship'); 
$hook_array['after_ui_frame'] = Array(); 
$hook_array['after_ui_frame'][] = Array(1002, 'Document Templates after_ui_frame Hook', 'custom/modules/Cases/DHA_DocumentTemplatesHooks.php','DHA_DocumentTemplatesCasesHook_class', 'after_ui_frame_method'); 



?>