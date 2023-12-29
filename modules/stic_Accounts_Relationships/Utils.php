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
class stic_Accounts_RelationshipsUtils {
    /**
     * Indicates if the relationship is active at the current time.
     *   1. If start_date is future returns false
     *   2. If end_date is null or future returns true
     *
     * @param Object $CRBean stic_Acccount_Relationships bean
     * @return boolean
     */
    public static function isActive($ARBean, $date = null) {
        
        // Calculate if relationship is active using similar pattern that in setRelationshipType function
        $today = date("Y-m-d");
        $start = $ARBean->start_date;
        $end = $ARBean->end_date;

        if (
            (empty($start) || $start <= $today)
            && (empty($end) || $end > $today)
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Calculate and save Accounts relationship_type field based upon active records in Accounts Relationships module
     * @param string $accountId
     * @return mixed False if error, true if ok
     */
    public static function setRelationshipType($accountId) {
        $updateRelTypeQuery =
            "UPDATE accounts_cstm
            SET accounts_cstm.stic_relationship_type_c =
            (
                SELECT 
                if(
                    stic_accounts_relationships.relationship_type = '' || stic_accounts_relationships.relationship_type IS NULL,
                    '^^',
                    GROUP_CONCAT(
                        DISTINCT 
                        concat('^', stic_accounts_relationships.relationship_type, '^')
                        ORDER BY
                        stic_accounts_relationships.relationship_type ASC
                    )
                )
                FROM stic_accounts_relationships
                JOIN stic_accounts_relationships_accounts_c
                ON stic_accounts_relationships_accounts_c.stic_accoub36donships_idb = stic_accounts_relationships.id
                AND stic_accounts_relationships_accounts_c.stic_accounts_relationships_accountsaccounts_ida = '$accountId'
                WHERE stic_accounts_relationships.deleted = 0
                    AND stic_accounts_relationships_accounts_c.deleted = 0
                    AND (isnull(stic_accounts_relationships.start_date)
                        OR stic_accounts_relationships.start_date IS NULL
                        OR stic_accounts_relationships.start_date <= CURRENT_DATE()
                        )
                    AND (isnull(stic_accounts_relationships.end_date)
                        OR stic_accounts_relationships.end_date IS NULL
                        OR stic_accounts_relationships.end_date > CURRENT_DATE()
                        )
            )
            WHERE accounts_cstm.id_c = '$accountId'";

        $db = DBManagerFactory::getInstance();
        $result = $db->query($updateRelTypeQuery);
        if (!$result) {
            $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': ' . 'Database error while updating the Relationship type field for the Account Id: ' . $accountId);
            return false;
        }
        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ': ' . 'Relationship type field for the Account Id ' . $accountId . ' has been updated.');
    }
}
