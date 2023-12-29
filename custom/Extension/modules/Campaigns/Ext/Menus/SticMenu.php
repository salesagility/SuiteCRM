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

global $module_menu;
if (ACLController::checkAccess('Campaigns', 'edit', true)) {
    array_unshift($module_menu, array(
        "index.php?module=Campaigns&action=EditView&return_module=Campaigns&return_action=index",
        $mod_strings['LNK_NEW_CAMPAIGN'], "Create Classic Campaign")
    );
}
if (ACLController::checkAccess('Campaigns', 'edit', true)) {
    $module_menu[] = array(
        "index.php?module=stic_Web_Forms&action=assistant&webFormClass=Donation&return_module=Campaigns&return_action=index",
        translate('LBL_STIC_WEB_FORMS_DONATION', 'stic_Web_Forms'), "Create_stic_Web_Forms", 'Campaigns',
    );
}
