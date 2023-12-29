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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

if (!empty($_REQUEST['identifier'])) {
    global $current_language;
    $mod_strings = return_module_language($current_language, 'Campaigns');
    
    //Build Confirmation Message.
    $identifier = $_REQUEST['identifier'];
    $url = 'index.php?entryPoint=removemeConfirmed&identifier='.$identifier;
    $link = '<a href="'.$url.'">'.$mod_strings['LBL_CONFIRM_OPTOUT_HERE'].'</a>';
    $message = str_replace("%0", $link, $mod_strings['LBL_CONFIRM_OPTOUT']);

    //Print Confirmation Message.
    echo $message;
}
sugar_cleanup();