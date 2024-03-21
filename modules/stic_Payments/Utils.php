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
class stic_PaymentsUtils
{
    /**
     * Generate a record in the Calls module
     *
     * @param Object $paymentBean The payment bean
     * @return void
     */
    public static function generateCallFromUnpaid($paymentBean)
    {

        global $current_user, $timedate;

        // Create the new call
        $callBean = new Call();
        $callDate = $timedate->fromDb(gmdate('Y-m-d H:i:s'));
        $callBean->date_start = $timedate->asUser($callDate, $current_user);
        $callBean->name = translate('LBL_CALL_SUBJECT', 'stic_Payments');

        // Link the call to the Person / Organization linked to the Payment
        if (!empty($paymentBean->stic_payments_contactscontacts_ida)) {
            $callBean->name .= " - {$paymentBean->stic_payments_contacts_name}";
        } else if (!empty($paymentBean->stic_payments_accountsaccounts_ida)) {
            $callBean->name .= " - {$paymentBean->stic_payments_accounts_name}";
        }

        $callBean->assigned_user_id = (empty($paymentBean->assigned_user_id) ? $current_user->id : $paymentBean->assigned_user_id);
        $callBean->direction = 'Outbound';
        $callBean->parent_id = $paymentBean->id;
        $callBean->parent_type = 'stic_Payments';

        // STIC NOTE - $_REQUEST variable is not the same when saving a record from EDIT_VIEW as from INLINE_EDIT.
        // In order to generate the relationship between the contact and the call, it is necessary to enter the following properties in $_REQUEST
        if ($_REQUEST['action'] == 'saveHTMLField') {
            $_REQUEST['relate_to'] = 'Contacts';
            $_REQUEST['relate_id'] = $paymentBean->stic_payments_contactscontacts_ida;
        }

        $callBean->save();
    }

    public static function createCurrentMonthRecurringPayments()
    {
        global $db;
        include_once 'modules/stic_Settings/Utils.php';

        $monthGenerationPaymentSetting = stic_SettingsUtils::getSetting('GENERAL_PAYMENT_GENERATION_MONTH') == 1 ? 1 : 0;

        // Creating values of all the DATE variables and assign them to use later
        if ($monthGenerationPaymentSetting == '1') {
            $month = date('m') + 1;
            $year = date('Y');
            if ($month > '12') {
                $month = $month - 12;
                $year = $year + 1;}
            $month = sprintf('%02d', $month);
            $dateGenerationPayment = $year . $month;
            $datePayment = $year . '-' . $month . '-01';
            $datePaymentFormat = $month . '-' . $year;
        } else {
            $month = date('m');
            $year = date('Y');
            $dateGenerationPayment = date('Ym');
            $datePayment = date('Y-m-d');
            $datePaymentFormat = date('Y-m');
        }

        // We search the BD for all forms of payment that have periodicity (not punctual),
        // that are active (no withdrawal date) and that do not have associated payments in the current month

        $sql = " SELECT
                    id,
                    periodicity,
                    amount,
                    payment_type,
                    payment_method,
                    first_payment_date,
                    end_date,
                    date_format(first_payment_date, '%Y') as first_payment_year,
                    date_format(first_payment_date, '%m') as first_payment_month
                FROM
                    stic_payment_commitments masterResult
                WHERE
                    deleted = 0
                    AND periodicity <> ''
                    AND periodicity <> 'punctual'
                    AND (end_date is null
                    or end_date > '$datePayment')
                    AND PERIOD_DIFF($dateGenerationPayment, date_format(first_payment_date, '%Y%m')) >= 0
                    AND NOT EXISTS (
                    SELECT
                        stic_payments.id
                    FROM
                        stic_payments
                    INNER JOIN stic_payments_stic_payment_commitments_c pfp ON
                        stic_payments.id = pfp.stic_payments_stic_payment_commitmentsstic_payments_idb
                        AND pfp.deleted = 0
                        AND stic_payments.deleted = 0
                    WHERE
                        PERIOD_DIFF($dateGenerationPayment, date_format(payment_date, '%Y%m')) = 0
                        AND masterResult.id = pfp.stic_paymebfe2itments_ida )";

        $table = $db->query($sql);

        if (!$table) {
            $GLOBALS['log']->error(__METHOD__ . ' Error SELECT query createPayments: ' . $sql);
            return false;
        }

        while ($row = $db->fetchByAssoc($table)) {

            // We check the periodicity
            for ($i = 0; $i <= 12; $i++) {
                $mes[$i] = $row['first_payment_month'] + $i;
                if ($mes[$i] > 12) {$mes[$i] = $mes[$i] - 12;}
            }

            if ($row['periodicity'] == 'annual') {
                if ($mes[0] != $month) {
                    continue;
                }
            } elseif ($row['periodicity'] == 'half_yearly') {
                if ($mes[0] != $month && $mes[6] != $month) {
                    continue;
                }
            } elseif ($row['periodicity'] == 'four_monthly') {
                if ($mes[0] != $month && $mes[4] != $month && $mes[8] != $month) {
                    continue;
                }
            } elseif ($row['periodicity'] == 'quarterly') {
                if ($mes[0] != $month && $mes[3] != $month && $mes[6] != $month && $mes[9] != $month) {
                    continue;
                }
            } elseif ($row['periodicity'] == 'bimonthly') {
                if ($mes[0] != $month && $mes[2] != $month && $mes[4] != $month && $mes[6] != $month && $mes[8] != $month && $mes[10] != $month) {
                    continue;
                }
            }

            // For each payment method, you must create a payment for the current month
            $PCBean = new stic_Payment_Commitments();
            $PCBean->retrieve($row['id']);
            $paymentBean = new stic_Payments();

            // We transfer all the necessary data from the payment method to the payment
            $paymentBean->name = $PCBean->name . " - " . $datePaymentFormat;
            $paymentBean->amount = format_number($PCBean->amount, 2, 2);
            $paymentBean->payment_method = $PCBean->payment_method;
            $paymentBean->payment_type = $PCBean->payment_type;
            $paymentBean->payment_date = $datePayment;
            $paymentBean->transaction_type = $PCBean->transaction_type;
            $paymentBean->segmentation = $PCBean->segmentation;
            $paymentBean->bank_account = $PCBean->bank_account;
            $paymentBean->mandate = $PCBean->mandate;
            $paymentBean->banking_concept = $PCBean->banking_concept;
            $paymentBean->assigned_user_id = $PCBean->assigned_user_id;

            // The status will depend on the payment_method:
            // "direct_debit", "card" and "card_<...>" = "Not remitted", other values = "Pending"
            // Note: "card_<...>" refers to additional POS (TPV) that might exist
            if (in_array($row['payment_method'], array('direct_debit', 'card'))
                || substr($row['payment_method'], 0, 5) == 'card_') {
                $paymentBean->status = 'not_remitted';
            } else {
                $paymentBean->status = 'pending';
            }

            // Set the relationship of payment with the form of payment
            $paymentBean->load_relationship('stic_payments_stic_payment_commitments');
            $paymentBean->stic_paymebfe2itments_ida = $PCBean->id;

            $paymentBean->save();
        }

        // Recalculate pending_annualized_fee for all payment commitments
        require_once 'modules/stic_Payment_Commitments/Utils.php';
        stic_Payment_CommitmentsUtils::recalculateAllFuturePaymentsViaSQL();

        // Empty the 'paid_annualized_fee' field if the execution corresponds to the month of January (1)
        if (date('n') == 1) {
            $emptyPaidAnnualizedFeeSQL = "UPDATE stic_payment_commitments SET paid_annualized_fee = NULL WHERE 1";
            $result = $db->query($emptyPaidAnnualizedFeeSQL);

            if ($result === false) {
                $GLOBALS['log']->error(__METHOD__ . ": Error executing SQL query [{$emptyPaidAnnualizedFeeSQL}]");
            } else {
                $updatedRows = $db->getAffectedRowCount($result);
                $GLOBALS['log']->info(__METHOD__ . ": Successfully emptied 'paid_annualized_fee' for [{$updatedRows}] payment commitments.");
            }
        }
        return true;
    }
}
