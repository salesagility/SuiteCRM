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
 * Report not authorized recurring payment commitments. Conditions:
 *   - Payment date is prior to first day of the last month (don't report payments in current or last months)
 *   - No value in the field that identifies recurrence
 *   - Periodicity other than punctual
 *   - Payment method is card or paypal
 *   - Payment status is pending
 */
class ReportFailedRecurringPC extends DataCheckFunction 
{
    /**
     * Receive an SQL proposal and modify it with the particularities necessary for the function.
     * Most functions should overwrite this method.
     * @param $actionBean Bean of the action in which the function is being executed.
     * @param $proposedSQL Array generated automatically (if possible) with the keys select, from, where and order_by.
     * @return string
     */
    public function prepareSQL(stic_Validation_Actions $actionBean, $proposedSQL) 
    {

        $sql = "SELECT
                    pc.id as pc_id,
                    count(p.id) as payments_count
                FROM
                    stic_payment_commitments pc
                    JOIN stic_payments_stic_payment_commitments_c spc on spc.stic_paymebfe2itments_ida = pc.id
                    JOIN stic_payments p on spc.stic_payments_stic_payment_commitmentsstic_payments_idb = p.id
                WHERE
                    IF(
                        pc.payment_method = 'paypal',
                        pc.paypal_subscr_id is null or pc.paypal_subscr_id = '',
                        pc.redsys_ds_merchant_identifier is null or pc.redsys_ds_merchant_identifier = ''
                    )
                    AND pc.periodicity != 'punctual'
                    AND p.status = 'pending'
                    AND (
                        pc.payment_method in ('card', 'paypal')
                        or SUBSTRING(pc.payment_method, 1, 5) = 'card_'
                    )
                    AND p.payment_date <= LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 2 MONTH))
                    AND p.deleted = 0
                    and pc.deleted = 0
                    and spc.deleted = 0 
                    GROUP BY pc.id";

        return $sql;
    }

    /**
     * DoAction function
     * Perform the action defined in the function
     * @param $records Set of records on which the validation action is to be applied 
     * @param $actionBean stic_Validation_Actions Bean of the action in which the function is being executed.
     * @return boolean It will return true in case of success and false in case of error.
     */
    public function doAction($records, stic_Validation_Actions $actionBean) 
    {
        global $app_list_strings;
        // It will indicate if records with errors have been found.
        $errors = 0;
        
        $resultInfo = $this->getLabel('RESULT_INFO'); // keep here
        $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ": Reporting ReportFailedRecurringPC (stic_Payment_Commitments) field SQL results: " . $resultInfo);
        
        while ($row = array_pop($records)) 
        {
            // Set payment commitment end date
            $PCBean = Beanfactory::getBean('stic_Payment_Commitments', $row['pc_id']);

            $paymentMethod=$app_list_strings['stic_payments_methods_list'][$PCBean->payment_method]; 
            $resultInfo = str_replace('@payment_method@',$paymentMethod,$resultInfo);
            $resultInfo = str_replace('@payment_count@',$row['payments_count'],$resultInfo);

            $errorMsg = '<span style="color:red;">' . $resultInfo . '</span>';
            $data = array(
                'name' => $this->getLabel('NAME') . ' - ' . $resultInfo,
                'stic_validation_actions_id' => $actionBean->id,
                'log' => '<div>' . $errorMsg . '</div>',
                'parent_type' => $this->functionDef['module'],
                'parent_id' => $PCBean->id,
                'reviewed' => 'no',   
                'assigned_user_id' => $PCBean->assigned_user_id,
            );
            $this->logValidationResult($data);
            $errors++;
        }
        
        // Report_always
        global $current_user;
        if (!$errors && $actionBean->report_always) {
            $errorMsg = $this->getLabel('NO_ERRORS');
            $data = array(
                'name' => $errorMsg,
                'stic_validation_actions_id' => $actionBean->id,
                'log' => '<div>' . $errorMsg . '</div>',
                'reviewed' => 'not_necessary',              
                'assigned_user_id' => $current_user->id, // In this message we indicate the administrator user
            );
            $this->logValidationResult($data);
        }

        return true;
    }
}
