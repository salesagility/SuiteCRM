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
$hook_array['before_save'][] = Array(77, 'updateGeocodeInfo', 'modules/Project/ProjectJjwg_MapsLogicHook.php', 'ProjectJjwg_MapsLogicHook', 'updateGeocodeInfo');
$hook_array['after_save'] = Array();
$hook_array['after_save'][] = Array(77, 'updateRelatedMeetingsGeocodeInfo', 'modules/Project/ProjectJjwg_MapsLogicHook.php', 'ProjectJjwg_MapsLogicHook', 'updateRelatedMeetingsGeocodeInfo');
$hook_array['after_relationship_add'] = Array();
$hook_array['after_relationship_add'][] = Array(77, 'addRelationship', 'modules/Project/ProjectJjwg_MapsLogicHook.php', 'ProjectJjwg_MapsLogicHook', 'addRelationship');
$hook_array['after_relationship_delete'] = Array();
$hook_array['after_relationship_delete'][] = Array(77, 'deleteRelationship', 'modules/Project/ProjectJjwg_MapsLogicHook.php', 'ProjectJjwg_MapsLogicHook', 'deleteRelationship');
$hook_array['after_ui_frame'] = Array();
$hook_array['after_ui_frame'][] = Array(1002, 'Document Templates after_ui_frame Hook', 'custom/modules/Project/DHA_DocumentTemplatesHooks.php', 'DHA_DocumentTemplatesProjectHook_class', 'after_ui_frame_method');

// Logic hook copied from custom/modules/Projects/language/en_us.lang.php (deleted)
$hook_array['before_delete'] = Array();
$hook_array['before_delete'][] = Array(1, 'Delete Project Tasks', 'modules/Project/delete_project_tasks.php', 'delete_project_tasks', 'delete_tasks');

?>