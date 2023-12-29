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

/**
 * This function creates a relationship between the selected payments in 
 * stic_Payments module listview and the selected remittance.
 * 
 * The function uses three queries:
 * - The first one retrieves the listview selected payments.
 * - The second one deletes any previous relationship between these payments and any other remittance but the selected one.
 * - The third one creates a relationship between the selected payments and remittance that were not already related.
 */
function addPaymentsToRemittance() {
    
    global $db, $mod_strings;
    $remittanceId = $_REQUEST['remittanceId'];
    
    // Build the query for retrieving selected payments
    $sql = "SELECT id from stic_payments WHERE deleted=0";
    $where = '';
    if (isset($_REQUEST['select_entire_list']) && $_REQUEST['select_entire_list'] == '1' && isset($_REQUEST['current_query_by_page'])) {
        // If "Select all" option is checked then we'll use the same where clause used to filter the listview
        require_once 'include/export_utils.php';
        $retArray = generateSearchWhere('stic_Payments', $_REQUEST['current_query_by_page']);
        $where = '';
        if (!empty($retArray['where'])) {
            $where = " AND " . $retArray['where'];
        }
    } else {
        // If not all payments in the listview were selected then we'll get their ids from the form request var
        $ids = explode(',', $_REQUEST['uid']);
        $idList = implode("','", $ids);
        $where = " AND id in ('{$idList}')";
    }
    $sql .= $where;
    // Retrieve selected payments from db
    $paymentsQuery = $db->query($sql);
    // Build two queries, one for deleting relationships with other remittances
    $deleteRelationQuery = "UPDATE stic_payments_stic_remittances_c SET deleted = 1, date_modified = NOW() WHERE deleted = 0 AND stic_payments_stic_remittancesstic_remittances_ida != '$remittanceId' AND stic_payments_stic_remittancesstic_payments_idb in (";
    // ... and another one for creating relationships with the selected remittance
    $insertRelationQuery = "INSERT INTO stic_payments_stic_remittances_c SELECT * FROM ( SELECT 'id','date_modified','deleted','stic_payments_stic_remittancesstic_remittances_ida','stic_payments_stic_remittancesstic_payments_idb' ";
    while ($paymentRow = $db->fetchByAssoc($paymentsQuery)) {
        $paymentId = $paymentRow['id'];
        $relationshipId = create_guid();
        $deleteRelationQuery .= "'$paymentId',";
        $insertRelationQuery .= "UNION SELECT '$relationshipId',NOW(),0,'$remittanceId','$paymentId' ";
    }
    $deleteRelationQuery = substr($deleteRelationQuery, 0, -1);
    $deleteRelationQuery .= ")";
    $insertRelationQuery .= ") t WHERE stic_payments_stic_remittancesstic_payments_idb NOT IN (SELECT DISTINCT stic_payments_stic_remittancesstic_payments_idb FROM stic_payments_stic_remittances_c WHERE stic_payments_stic_remittancesstic_remittances_ida = '$remittanceId' AND deleted = 0) and stic_payments_stic_remittancesstic_payments_idb != 'stic_payments_stic_remittancesstic_payments_idb'";
    // Execute the deletion query
    $resultQuery = $db->query($deleteRelationQuery);
    if (!$resultQuery) {
        $GLOBALS['log']->fatal(__METHOD__.' '.__LINE__.$mod_strings['LBL_ERROR_QUERY_PAYMENTS_TO_REMITTANCE']);
        SugarApplication::appendErrorMessage('<div class="msg-fatal-lock">' . $mod_strings['LBL_ERROR_QUERY_PAYMENTS_TO_REMITTANCE'] . '</div>');
        SugarApplication::redirect("index.php?module=stic_Remittances&action=DetailView&record={$remittanceId}");
    }
    // Execute the creation query
    $resultQuery = $db->query($insertRelationQuery);
    if (!$resultQuery) {
        $GLOBALS['log']->fatal(__METHOD__.' '.__LINE__.$mod_strings['LBL_ERROR_QUERY_PAYMENTS_TO_REMITTANCE']);
        SugarApplication::appendErrorMessage('<div class="msg-fatal-lock">' . $mod_strings['LBL_ERROR_QUERY_PAYMENTS_TO_REMITTANCE'] . '</div>');
    }
    
    // Redirect user to remittance detail view
    SugarApplication::redirect("index.php?module=stic_Remittances&action=DetailView&record={$remittanceId}");
}
