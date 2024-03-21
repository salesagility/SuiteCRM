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

// Prevent spam or unknown web form calls to avoid false error notifications. Just checking that main $_REQUEST items are present.
if (
    !isset($_REQUEST['defParams'])
    || !isset($_REQUEST['webFormClass'])
) {
    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Entrypoint stic_Web_Forms_save locked. REQUEST:" . print_r($_REQUEST, true));
    die('Unauthorized, check log.');
}

$GLOBALS['log']->debug('Entrypoint File: Save.php: Processing WebFormDataController...');

global $current_user;
$current_user->getSystemUser();

$_REQUEST['stic_send_feedBackErrors'] = 1;

require_once __DIR__ . '/../Catcher/WebFormDataController.php';
$controller = new WebFormDataController();
$controller->manage();
