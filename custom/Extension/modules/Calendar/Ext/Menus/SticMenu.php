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

if (ACLController::checkAccess('stic_Sessions', 'edit', true)) {
    $last = array_pop($module_menu);
    $module_menu[] = array("index.php?module=stic_Sessions&action=EditView&return_module=Calendar&return_action=index", translate('LNK_NEW_RECORD', 'stic_Sessions'), "create-stic-sessions", 'stic_Sessions');
    $module_menu[] = $last;
}

if (ACLController::checkAccess('stic_FollowUps', 'edit', true)) {
    $last = array_pop($module_menu);
    $module_menu[] = array("index.php?module=stic_FollowUps&action=EditView&return_module=Calendar&return_action=index", translate('LNK_NEW_RECORD', 'stic_FollowUps'), "create-stic-followups", 'stic_FollowUps');
    $module_menu[] = $last;
}

if (ACLController::checkAccess('stic_Work_Calendar', 'edit', true)) {
    $last = array_pop($module_menu);
    $module_menu[] = array("index.php?module=stic_Work_Calendar&action=EditView&return_module=Calendar&return_action=index", translate('LNK_NEW_RECORD', 'stic_Work_Calendar'), "schedule", 'stic_Work_Calendar');
    $module_menu[] = $last;
}