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

class stic_Payment_CommitmentsUtils {

    /**
     * Calculation of the annualized fee based on the amount and the periodicity of the payment commitment.
     *
     * @param Object Bean Payment Commitment bean
     * @return Int
     */
    public static function getAnnualizedFee($PCBean) {

        $multiplier = 1;
        
        switch ($PCBean->periodicity) {
        case "monthly":
            $multiplier = 12;
            break;

        case "bimonthly":
            $multiplier = 6;
            break;

        case "quarterly":
            $multiplier = 4;
            break;

        case "four_monthly":
            $multiplier = 3;
            break;

        case "half_yearly":
            $multiplier = 2;
            break;

        case "annual":
            $multiplier = 1;
            break;

        case "punctual":
            $multiplier = 1;
            break;
        }

        return $multiplier * $PCBean->amount;
    }

    /**
     *  Creation of initial payments after a new payment commitment is created:
     *   1) A first payment matching first_payment_date (always)
     *   2) A payment for the following month (if applicable according to GENERAL_PAYMENT_GENERATION_MONTH)
     *   3) Previous payments, according to the periodicity (if first_payment_date is earlier than the current month)
     *
     * @param Object $PCBean Payment commitment bean
     * @return void
     */
    public static function createInitialPayments($PCBean) {

        global $db;
        include_once 'modules/stic_Payment_Commitments/Utils.php';
        include_once 'modules/stic_Settings/Utils.php';

        // Get the value of 'GENERAL_PAYMENT_GENERATION_MONTH' setting:
        // 0 means current month - 1 means next month 
        $monthGenerationSetting = stic_SettingsUtils::getSetting('GENERAL_PAYMENT_GENERATION_MONTH') == 1 ? 1 : 0;

        // Set the number of months between payments according to the payment commitment periodicity
        $periodicity = $PCBean->periodicity;
        switch ($periodicity) {
        case 'monthly':
            $monthsEvery = '1';
            break;
        case 'bimonthly':
            $monthsEvery = '2';
            break;
        case 'quarterly':
            $monthsEvery = '3';
            break;
        case 'four_monthly':
            $monthsEvery = '4';
            break;
        case 'half_yearly':
            $monthsEvery = '6';
            break;
        case 'annual':
            $monthsEvery = '12';
            break;
        case 'punctual':
            $monthsEvery = '0';
            break;
        default:
            $GLOBALS['log']->error(__METHOD__ . ' line ' . __LINE__ . ' It is not possible to create the initial payments because the payment commitment has no periodicity.', $PCBean->name . " " . $PCBean->id);
            return;
            break;
        }

        // Set dates & date formats to use in payments
        $firstPaymentYearMonth = date('Y-m', strtotime($PCBean->first_payment_date));
        $firstPaymentDate = date('Y-m-d', strtotime($PCBean->first_payment_date));
        $currentYearMonth = date('Y-m');

        // Check if end date exists. If so, use it as deadline
        if ($PCBean->end_date == '') {
            $deadlineYearMonth = 'NULL';
        } else {
            $deadlineYearMonth = date('Y-m', strtotime($PCBean->end_date));
        }

        // Create initial payments according to specific conditions
        
        if ($monthGenerationSetting == '1' && $monthsEvery == '1' && $currentYearMonth == $firstPaymentYearMonth) {

            // In next month mode, for a payment commitment with monthly periodicity and first payment date in the current month
            // two payments must be created: one for the current month using first payment date and one for the next month.
            self::createPayment($PCBean, $firstPaymentDate, 0);
            self::createPayment($PCBean, 0, 1);

        } else if ($currentYearMonth > $firstPaymentYearMonth && $monthsEvery != '0') {

            // This is a periodical payment commitment with first payment date in the past.

            // Create the first payment
            self::createPayment($PCBean, $firstPaymentDate, 0);

            // Check month mode
            if ($monthGenerationSetting == '1') {
                // Create payments until next month
                $untilYearMonth = self::addMonths(1, $currentYearMonth);
            } else {
                // Create payments until this month
                $untilYearMonth = $currentYearMonth;
            }

            // Check if payment commitment end_date will affect payment creation
            if ($deadlineYearMonth != 'NULL' && $deadlineYearMonth < $untilYearMonth) {
                $untilYearMonth = $deadlineYearMonth;
            }
            
            // Create as many more payments as needed
            $nextYearMonth = self::addMonths($monthsEvery, $firstPaymentYearMonth);
            while ($nextYearMonth <= $untilYearMonth) {
                self::createPayment($PCBean, $nextYearMonth, 2);
                $nextYearMonth = self::addMonths($monthsEvery, $nextYearMonth);
            }
        
        } else {

            // In any other case only a single payment will be created
            self::createPayment($PCBean, $firstPaymentDate, 0);
        }

    }

    /**
     * Create a payment from a payment commitment
     *
     * @param ObjectBean $PCBean Payment Commitment Bean
     * @param String $paymentDate (will be 'Y-m-d', 'Y-m' or null depending on $creationMode)
     * @param Int $creationMode (0 - standard, 1 - next moth, 2 - recurring, so 'Y-m' date is provided)
     * @return void
     */
    public static function createPayment($PCBean, $paymentDate, $creationMode) {
        
        include_once 'SticInclude/Utils.php';

        // Build the payment date values that will be needed later
        if ($creationMode == '1') {
            // A payment for the next month will be created
            // The payment date (first day of next month) will be fully built from scratch
            $month = date('m') + 1;
            $year = date('Y');
            if ($month > '12') {
                $month = $month - 12;
                $year = $year + 1;
            }
            $month = sprintf('%02d', $month);
            $paymentDate = $year . '-' . $month . '-01';
            $formattedPaymentDate = $year . '-' . $month;
        } else if ($creationMode == '2') {
            // This is a past recurring payment, only YearMonth is provided
            // so Day part must be added
            $paymentDate = $paymentDate . '-01';
            $formattedPaymentDate = $paymentDate;
        } else {
            // Standard payment. Full date is provided as a param
            $paymentDate = $paymentDate;
            $formattedPaymentDate = $paymentDate;
        }

        // Create payment bean
        $paymentBean = BeanFactory::getBean('stic_Payments');
        
        // Override automatic user setting. This will allow to set specific users later. Useful for webforms record creation.
        $paymentBean->set_created_by = false;
        $paymentBean->update_modified_by = false;
        
        // Transfer data from the payment commitment to the payment
        $paymentBean->name = $PCBean->name . " - " . $formattedPaymentDate;
        $paymentBean->amount = format_number($PCBean->amount, 2, 2);
        $paymentBean->payment_method = $PCBean->payment_method;
        $paymentBean->payment_type = $PCBean->payment_type;
        $paymentBean->payment_date = $paymentDate;
        $paymentBean->segmentation = $PCBean->segmentation;
        $paymentBean->bank_account = $PCBean->bank_account;
        $paymentBean->transaction_type = $PCBean->transaction_type;
        $paymentBean->mandate = $PCBean->mandate;
        $paymentBean->banking_concept = $PCBean->banking_concept;
        $paymentBean->assigned_user_id = $PCBean->assigned_user_id;
        $paymentBean->created_by = $PCBean->created_by;
        $paymentBean->modified_user_id = $PCBean->modified_user_id;

        // The status will depend on the payment method
        // Direct debit -> Not remitted, Other -> Pending
        if ($PCBean->payment_method == 'direct_debit') {
            $paymentBean->status = 'not_remitted';
        } else {
            $paymentBean->status = 'pending';
        }

        // Set the relationship between payment & payment commitment
        $paymentBean->stic_paymebfe2itments_ida = $PCBean->id;

        // Save the payment
        $paymentBean->save(false);
    }

    /**
     * Add $number months to $date in format 'Y-m'
     *
     * @param Int $number
     * @param String $date ('Y-m')
     * @return String ('Y-m')
     */
    public static function addMonths($number, $date) {
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $month = $month + $number;
        if ($month > '12') {
            $month = $month - 12;
            $year = $year + 1;
        }
        $month = sprintf('%02d', $month);
        $date_format = $year . '-' . $month;
        return ($date_format);
    }
    
}
