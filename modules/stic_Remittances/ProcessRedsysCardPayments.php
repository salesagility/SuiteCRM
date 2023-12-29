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
 * Processes recurring payments included in the remittance
 *
 * @param Object $remittance The $this object from which this function is invoked, including the view and the bean of the remittance
 * @return void
 */
function processRedsysCardPayments($remittance)
{
    require_once 'modules/stic_Settings/Utils.php';
    require_once 'SticInclude/Utils.php';
    require_once 'modules/stic_Remittances/Utils.php';
    require_once 'modules/stic_Payments/RedsysUtils.php';

    // Start timestamp to measure performance
    $start = microtime(true);

    global $mod_strings, $timedate, $db, $current_user;

    // Check remittance type
    $remittance->bean->type != 'cards' ? SticUtils::showErrorMessagesAndDie($remittance, $mod_strings['LBL_CARD_PAYMENTS_REMITTANCE_INVALID_TYPE']) : '';

    // Get all remittance related payment records
    $sqlPayments =
        "SELECT
            p.id, name, payment_method, status
        FROM
            stic_payments_stic_remittances_c pr
        JOIN stic_payments p on
            p.id = pr.stic_payments_stic_remittancesstic_payments_idb
        WHERE
            pr.stic_payments_stic_remittancesstic_remittances_ida = '{$remittance->bean->id}'
            and pr.deleted = 0
            and p.deleted = 0";

    $result = $db->query($sqlPayments);

    // Initialize result counters
    $processRecurringPayments = array('success' => 0, 'fail' => 0, 'omitted' => 0);

    // Process the payments
    while ($paymentResult = $db->fetchByAssoc($result)) {

        // If payment_method != "card"|"card_" then include the error in the remittance log and continue
        if (substr($paymentResult['payment_method'], 0, 4) != 'card') {
            $errorMsg .= '<p class="msg-error">' . $mod_strings['LBL_CARD_PAYMENTS_PAYMENT_INVALID_METHOD'] . " " . stic_RemittancesUtils::goToEdit('stic_Payments', $paymentResult['id'], $paymentResult['name']);
            $processRecurringPayments['omitted']++;
            continue;
        }

        // If payment status is "paid" then output to CRM log and continue
        // Don't put it in the remittance log to avoid long logs when most payments are paid and just retrying for failed ones
        if ($paymentResult['status'] == 'paid') {
            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Payment is omitted because it is already paid [{$paymentResult['id']}]");
            $processRecurringPayments['omitted']++;
            continue;
        }

        // Exec the payment
        $paymentResult = RedsysUtils::runRecurringCardPayment($paymentResult['id']);

        // Process the result
        if ($paymentResult['res'] === true) {
            $processRecurringPayments['success']++;
        } elseif ($paymentResult['res'] === false) {
            // Include the error in the remittance log
            $errorMsg .= '<p class="msg-error">' . $paymentResult['resCode'] . " " . stic_RemittancesUtils::goToEdit('stic_Payments', $paymentResult['id'], $paymentResult['name']);
            $processRecurringPayments['fail']++;
        } else {
            $errorMsg .= '<p class="msg-error">' . $mod_strings['LBL_CARD_PAYMENTS_UNKNOWN_ERROR'] . " " . stic_RemittancesUtils::goToEdit('stic_Payments', $paymentResult['id'], $paymentResult['name']);
        }

    }

    $time_elapsed = round(microtime(true) - $start, 2) . ' s';

    // Prepare log header
    $logHeader = $mod_strings['LBL_CARD_PAYMENTS_REMITTANCE_INFO_HEADER'] . ' ' . $result->num_rows . '<br>';
    $logHeader .= $mod_strings['LBL_CARD_PAYMENTS_REMITTANCE_INFO_SUCCESS'] . ' ' . $processRecurringPayments['success'] . '<br>';
    $logHeader .= $mod_strings['LBL_CARD_PAYMENTS_REMITTANCE_INFO_OMITTED'] . ' ' . $processRecurringPayments['omitted'] . '<br>';
    $logHeader .= $mod_strings['LBL_CARD_PAYMENTS_REMITTANCE_INFO_FAILED'] . ' ' . $processRecurringPayments['fail'] . '<hr>';

    // Set remittance log (header + user, date and elapsed time + single payment error messages)
    $remittance->bean->log = htmlentities('<p class="info"><strong>' . $logHeader . '</strong></p><p> ' . $current_user->name . ' | ' . date('d/m/Y H:i') . ' | ' . $time_elapsed . $errorMsg);

    // Set final result message
    if ($processRecurringPayments['fail'] == 0) {
        // All payments successfully processed
        SugarApplication::appendErrorMessage('<div class="msg-success-lock">' . $mod_strings['LBL_CARD_PAYMENTS_ALL_SUCCESS'] . '</div>');
        $remittance->bean->status = 'sent';
    } else if ($processRecurringPayments['success'] == 0) {
        // No payments successfully processed
        SugarApplication::appendErrorMessage('<div class="msg-fatal-lock">' . $mod_strings['LBL_CARD_PAYMENTS_NONE_SUCCESS'] . '</div>');
    } else {
        // Some payments successfully processed and some not
        SugarApplication::appendErrorMessage('<div class="msg-warning-lock">' . $mod_strings['LBL_CARD_PAYMENTS_SOME_SUCCESS'] . '</div>');
    }

    // Save the remittance
    $remittance->bean->save();

    // Redirect to remittance detail view
    SugarApplication::redirect("index.php?module={$remittance->bean->module_dir}&action=DetailView&record={$remittance->bean->id}");

    die();
}
