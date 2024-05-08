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

class stic_SettingsLogicHooks
{

    public function before_save(&$bean, $event, $arguments)
    {
        // Force always settings name uppercase and without blank spaces
        $bean->name = strtoupper(str_replace(' ', '_', trim($bean->name)));
    }

    public function after_save(&$bean, $event, $arguments)
    {
        // If color changes, compile subtheme css
        if (($bean->name == 'GENERAL_CUSTOM_THEME_COLOR' && $bean->fetched_row['value'] != $bean->value)
            || ($bean->name == 'GENERAL_CUSTOM_SUBTHEME_MODE' && $bean->fetched_row['value'] != $bean->value)
        ) {
            include_once 'SticInclude/SticCustomScss.php';
        }
    }

}
