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

class stic_SettingsUtils
{

    /**
     * Get the value of a setting record
     *
     * @param String $settingName
     * @return String The setting value
     */
    public static function getSetting($settingName)
    {
        global $db;

        $sql = "SELECT value FROM stic_settings WHERE name = '" . $settingName . "' AND deleted = 0";

        $result = $db->getOne($sql);

        if ($result !== false) {
            if (strlen($result) == 0) {
                $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Setting value {$settingName} is empty.");
            }
            return $result;
        } else {
            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Could not get the setting value of {$settingName}");
        }

        return false;
    }

    /**
     * Get all the settings of a certain type
     *
     * @param String $type The type of the setting to retrieve
     * @return Array with the names and values of retrieved settings
     */
    public static function getSettingsByType($type)
    {
        global $db;

        $sql = "SELECT name, value FROM stic_settings WHERE type = '" . $type . "' AND deleted = 0";
        $result = $db->query($sql);
        if ($result) {
            $settings = array();
            while ($row = $db->fetchByAssoc($result)) {
                $settings[$row['name']] = $row['value'];
                if (strlen($row['value']) == 0) {
                    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ': Setting value ' . $row['name'] . ' is empty.');
                }
            }
            return $settings;
        } else {
            $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': Could not get the ' . $type . ' settings.');
        }

        return false;
    }

    /**
     * Return TPV (Redsys) OR TPVCECA settings for the provided payment_method
     *
     * @param [String] $paymentMethod
     * @return void
     */
    public static function getTPVSettings($paymentMethod)
    {
        $tpvType = $paymentMethod == 'ceca_card' || substr($paymentMethod, 0, 10) == 'ceca_card_' ? 'TPVCECA' : 'TPV';

        // Get all TPV|TPVCECA settings
        $settingsTPV = self::getSettingsByType($tpvType);

        
        if ($tpvType == 'TPV') {
            // In case of secondary REDSYS POS/TPV (payment method begins with "card_"), get the proper settings
            if (substr($paymentMethod, 0, 5) == 'card_' || substr($paymentMethod, 0, 6) == 'bizum_') {

                // Replace "card_" prefix by "ALT_" in payment method in order to find secondary POS/TPV settings
                $paymentMethodFilter = strtoupper(str_ireplace(['card_', 'bizum_'], 'ALT_', $paymentMethod));

                // POS settings that match the current payment method will overwrite the original settings
                foreach ($settingsTPV as $key => $value) {
                    if (preg_match('/^TPV_' . $paymentMethodFilter . '/', $key)) {
                        $settingToOverwrite = str_replace('_' . $paymentMethodFilter, '', $key);
                        $settingsTPV[$settingToOverwrite] = $value;

                        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ': TPV Setting ' . $settingToOverwrite . ' has been overwritten with ' . $key . '[' . $value . ']');
                    }
                }
            }
        } elseif ($tpvType == 'TPVCECA') {
            // In case of secondary CECA POS/TPV (payment method begins with "ceca_card_"), get the proper settings
            if (substr($paymentMethod, 0, 10) == 'ceca_card_') {

                // Replace "ceca_card_" prefix by "ALT_" in payment method in order to find secondary POS/TPV settings
                $paymentMethodFilter = strtoupper(str_ireplace(['ceca_card_'], 'ALT_', $paymentMethod));

                // POS settings that match the current payment method will overwrite the original settings
                foreach ($settingsTPV as $key => $value) {
                    if (preg_match('/^TPVCECA_' . $paymentMethodFilter . '/', $key)) {
                        $settingToOverwrite = str_replace('_' . $paymentMethodFilter, '', $key);
                        $settingsTPV[$settingToOverwrite] = $value;

                        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ': TPVCECA Setting ' . $settingToOverwrite . ' has been overwritten with ' . $key . '[' . $value . ']');
                    }
                }
            }
        }
        return $settingsTPV;
    }
}
