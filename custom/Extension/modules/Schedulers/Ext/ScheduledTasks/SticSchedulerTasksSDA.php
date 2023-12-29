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
// Scheduled task that rebuilds the views and tables used as data sources in SinergiaDA, if  $sugar_config['stic_sinergiada']['enabled'] is true

$job_strings[] = 'rebuildSDASources';

/**
 * Rebuilds SinergiaDA data sources if $sugar_config['stic_sinergiada']['enabled'] is 1.
 *
 * This function is part of a scheduled task in SuiteCRM.
 *
 * @return bool Returns true if the task is successful, false otherwise.
 */
function rebuildSDASources()
{
    global $sugar_config;

    $GLOBALS['log']->stic('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Running the task rebuildSDASources');

    // Get the value of $sugar_config['stic_sinergiada']['enabled'].
    $sdaEnabled = $sugar_config['stic_sinergiada']['enabled'] ?? false;

    if ($sdaEnabled) {
        // If SinergiaDA is enabled, rebuild SinergiaDA data sources.
        require_once 'SticInclude/SinergiaDARebuild.php';
        $res = SinergiaDARebuild::rebuild(true, 'all');
        $GLOBALS['log']->stic('Line ' . __LINE__ . ': ' . __METHOD__ . ': ' . "Rebuilding SinergiaDA return [{$res}]");

        // Return true if the rebuild was successful, false otherwise.
        return $res == 'ok' ? true : false;
    } else {
        // If SinergiaDA is disabled, skip the task.
        $GLOBALS['log']->stic('Line ' . __LINE__ . ': ' . __METHOD__ . ':  The rebuildSDASources task has been skipped because  SinergiaDA is disabled.');
        return true;
    }
}
