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

$GLOBALS['log']->debug('Entrypoint File: AttachmentLimitsResponse.php.php:  getConfigVariables...');

require_once 'include/utils.php';
$someArray = [
    "uploadMaxFilesize" => ini_get('upload_max_filesize'),
    "uploadMaxFilesizeBytes" => return_bytes(ini_get('upload_max_filesize')),
    "postMaxSize" => ini_get('post_max_size'),
    "postMaxSizeBytes" => return_bytes(ini_get('post_max_size')),
];

// Convert Array to JSON String
$someJSON = json_encode($someArray);
echo "getConfigVariables(" . $someJSON . ");";
