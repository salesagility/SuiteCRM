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
 * Class to check the relationship of Person to People Relations
 */
class CheckRemittancesRelationships extends DataCheckFunction
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
        $rp = BeanFactory::getBean($this->module);

        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Loading relationship with Payments ...");
        $rp->load_relationship('stic_payments_stic_remittances');
        $rel = $rp->stic_payments_stic_remittances->getRelationshipObject();

        $sql = "SELECT {$rel->lhs_table}.{$rel->lhs_key} as id, {$rel->lhs_table}.status, {$rel->rhs_table}.{$rel->rhs_key} as payment_id, {$rel->rhs_table}.name as payment_name, {$rel->rhs_table}.status as payment_status
                FROM {$rel->lhs_table}
                INNER JOIN {$rel->join_table} ON {$rel->lhs_table}.{$rel->lhs_key} = {$rel->join_table}.{$rel->join_key_lhs} and {$rel->join_table}.deleted = 0
                INNER JOIN {$rel->rhs_table} ON {$rel->rhs_table}.{$rel->rhs_key} = {$rel->join_table}.{$rel->join_key_rhs} and {$rel->join_table}.deleted = 0
                WHERE {$rel->lhs_table}.deleted = 0";
        $sqlIncremental = stic_DataAnalyzer::getSQLIncremental($actionBean);

        if ($sqlIncremental) {
            $sql .= " AND ({$rel->rhs_table}.{$sqlIncremental} or {$rel->rhs_table}.{$sqlIncremental})";
        }

        return $sql;
    }

    /**
     * Función doAction.
     * Perform the action defined in the function
     * @param $records Set of records on which the validation action is to be applied 
     * @param $actionBean stic_Validation_Actions Bean of the action in which the function is being executed.
     * @return boolean It will return true in case of success and false in case of error.
     */
    public function doAction($records, stic_Validation_Actions $actionBean)
    {
        global $sugar_config;
        // It will indicate if records have been found to validate.
        $count = 0;
        // It will indicate if records with errors have been found.
        $errors = 0;
        $beanRemesa = null;
        $statusLabels = $this->getStatusLabels();
        // We will receive the data only of the wrong forms of payment
        while ($rp = array_pop($records))
        {
            if (!$this->checkStatus($rp['status'], $rp['payment_status'])) {
                $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Bad record found [{$this->module}] [{$rp['id']}], retrieving object ...");
                $beanRemesa = $this->loadBean($beanRemesa, $rp);
                $name = $this->getLabel('ERROR_STATUS_1') . " [{$statusLabels[$rp['payment_status']]}]" . $this->getLabel('ERROR_STATUS_2');
                $paymentName = empty($rp['payment_name']) ? $rp['id'] : $rp['payment_name'];
                $errorMsg = '<span style="color:red;">' . $name . '</span>';
                $errorMsg2 = '<br />- <a href="' . $sugar_config["site_url"] . '/index.php?module=stic_Payments&return_module=' . $this->module . '&action=DetailView&record=' . $rp['payment_id'] . '">' . $paymentName . '</a>';                
                $data = array(
                    'name' => $this->getLabel('NAME') . ' - ' . $name,
                    'stic_validation_actions_id' => $actionBean->id,
                    'log' => '<div>' . $errorMsg . $errorMsg2 .'</div>',
                    'parent_type' => $this->functionDef['module'],
                    'parent_id' => $beanRemesa->id,
                    'reviewed' => 'no',   
                    'assigned_user_id' => $beanRemesa->assigned_user_id,
                );
                $this->logValidationResult($data);                
                $errors++;
            }

            $count++; // Records Processed
        }

        $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ": [{$count}] verified payments, [{$errors}] errors found.");

        // Report_always
        global $current_user;
        if (!$count && $actionBean->report_always) {
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

    /**
     * Indicates if the payment status is consistent with the remittance status
     * @param unknown $remittanceStatus
     * @param unknown $paymentStatus
     */
    private function checkStatus($remittanceStatus, $paymentStatus)
    {
        switch ($remittanceStatus) {
            case 'open':return $paymentStatus != 'paid' && $paymentStatus != 'pending' && $paymentStatus != 'cancelled';
            case 'generated':return $paymentStatus == 'remitted';
            case 'sent':return $paymentStatus != 'not_remitted' && $paymentStatus != 'remitted' && $paymentStatus != 'pending' && $paymentStatus != 'rejected_gateway';
            default:return true; // If there is no remittance status, the payment is not taken into account.
        }
    }

    /**
     * Returns the array with the state labels
     */
    protected function getStatusLabels()
    {
        global $app_list_strings;

        if (empty($this->paymentModel)) {
            $this->paymentModel = BeanFactory::getBean('stic_Payments');
        }

        $fieldDefs = $this->paymentModel->field_defs;
        $options_key = $fieldDefs['status']['options'];
        return $app_list_strings[$options_key]; // Field Values
    }
}
