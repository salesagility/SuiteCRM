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
 * Class to check the Payments relations
 */
class CheckPaymentsRelationships extends DataCheckFunction 
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
        $fp = BeanFactory::getBean($this->module);

        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Loading relationship with Contacts ...");
        $fp->load_relationship('stic_payments_contacts');
        $rel = $fp->stic_payments_contacts->getRelationshipObject();

        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Loading relationship with Accounts ...");
        $fp->load_relationship('stic_payments_accounts');
        $rel2 = $fp->stic_payments_accounts->getRelationshipObject();

        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Loading relationship with Payment Commitments ...");
        $fp->load_relationship('stic_payments_stic_payment_commitments');
        $rel3 = $fp->stic_payments_stic_payment_commitments->getRelationshipObject();

        return "SELECT distinct id, contact_id, account_id, fp_id FROM
                (
                (SELECT distinct {$rel->rhs_table}.{$rel->rhs_key} as id,
                        TRIM(COALESCE({$rel->join_table}.{$rel->join_key_lhs}, '')) as contact_id,
                        TRIM(COALESCE({$rel2->join_table}.{$rel2->join_key_lhs}, '')) as account_id,
                        TRIM(COALESCE({$rel3->join_table}.{$rel3->join_key_lhs}, '')) as fp_id
                    FROM {$rel->rhs_table}
                    LEFT JOIN {$rel->join_table} ON {$rel->rhs_table}.{$rel->rhs_key} = {$rel->join_table}.{$rel->join_key_rhs} and {$rel->join_table}.deleted = 0
                    LEFT JOIN {$rel2->join_table} ON {$rel2->rhs_table}.{$rel2->rhs_key} = {$rel2->join_table}.{$rel2->join_key_rhs} and {$rel2->join_table}.deleted = 0
                    LEFT JOIN {$rel3->join_table} ON {$rel3->rhs_table}.{$rel3->rhs_key} = {$rel3->join_table}.{$rel3->join_key_rhs} and {$rel3->join_table}.deleted = 0
                    WHERE {$rel->rhs_table}.deleted = 0 and ( ( TRIM(COALESCE({$rel->join_table}.{$rel->join_key_lhs}, '')) = '' and
                                                                TRIM(COALESCE({$rel2->join_table}.{$rel2->join_key_lhs}, '')) = '' ) or
                                                                TRIM(COALESCE({$rel3->join_table}.{$rel3->join_key_lhs}, '')) = '' )
                    )
                UNION
                (SELECT distinct {$rel->rhs_table}.id, WRONG_IDS_IN_RELATIONSHIP_TABLE.contact_id, WRONG_IDS_IN_RELATIONSHIP_TABLE.account_id, WRONG_IDS_IN_RELATIONSHIP_TABLE.fp_id FROM (
                    (SELECT distinct {$rel->join_key_rhs} as id, TRIM(COALESCE({$rel->lhs_table}.id, '')) as contact_id, '' as account_id, '' as fp_id
                        FROM {$rel->join_table}
                        LEFT JOIN {$rel->lhs_table} ON {$rel->join_table}.{$rel->join_key_lhs} = {$rel->lhs_table}.{$rel->lhs_key} and {$rel->lhs_table}.deleted = 0
                        WHERE {$rel->join_table}.deleted = 0 and (TRIM(COALESCE({$rel->lhs_table}.{$rel->lhs_key}, '')) = ''))
                    UNION
                    (SELECT distinct {$rel2->join_key_rhs} as id, '' as contact_id, TRIM(COALESCE({$rel2->lhs_table}.id, '')) as account_id, '' as fp_id
                        FROM {$rel2->join_table}
                        LEFT JOIN {$rel2->lhs_table} ON {$rel2->join_table}.{$rel2->join_key_lhs} = {$rel2->lhs_table}.{$rel2->lhs_key} and {$rel2->lhs_table}.deleted = 0
                        WHERE {$rel2->join_table}.deleted = 0 and (TRIM(COALESCE({$rel2->lhs_table}.{$rel2->lhs_key}, '')) = ''))
                    UNION
                    (SELECT distinct {$rel3->join_key_rhs} as id, '' as contact_id, '' as account_id, TRIM(COALESCE({$rel3->lhs_table}.id, '')) as fp_id
                        FROM {$rel3->join_table}
                        LEFT JOIN {$rel3->lhs_table} ON {$rel3->join_table}.{$rel3->join_key_lhs} = {$rel3->lhs_table}.{$rel3->lhs_key} and {$rel3->lhs_table}.deleted = 0
                        WHERE {$rel3->join_table}.deleted = 0 and (TRIM(COALESCE({$rel3->lhs_table}.{$rel3->lhs_key}, '')) = ''))
                        ) as WRONG_IDS_IN_RELATIONSHIP_TABLE
                    INNER JOIN {$rel->rhs_table} ON WRONG_IDS_IN_RELATIONSHIP_TABLE.id = {$rel->rhs_table}.{$rel->rhs_key}
                    WHERE {$rel->rhs_table}.deleted = 0)) as WRONG_IDS
                    ORDER BY id DESC, contact_id DESC, fp_id DESC";
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
        // It will indicate how many records have been updated.        
        $updated = 0;

        /**
         * The query can return multiple values ​​for a single payment if for a single id there are problems in the relationship table and in the payment table,
         * Por ejemplo ID, CONTACT_ID, ACCOUNT_ID, FP_ID
         *              1        NULL        NULL       1
         *              1        NULL        NULL    NULL
         * To avoid that the same payment appears with two errors that, in the end, suppose the same, we point the ids processed in an array and, yes we have already
         * processed re-process is skipped.
         */
        $processedIds = array();

        // We will receive the data only of the wrong forms of payment
        while ($p = array_pop($records)) 
        {
            // If the process has already been completed, the process is not repeated.
            if (isset($processedIds[$p['id']])) {
                $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Missed wrong registration [{$p['id']}].");
                $processedIds[$p['id']]++;
            } else {
                // Check if you have to take any action or inform
                $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ":Bad record found [{$this->module}] [{$p['id']}], retrieving object ...");
                $processedIds[$p['id']] = 1;

                $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Loading Payment data...");
                $bean = BeanFactory::getBean($this->module, $p['id']);

                $fp = null;

                // If you do not have a linked payment method, write it down.
                if (!$p['fp_id']) {
                    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": The payment commitment of [{$bean->id} - {$bean->name}] has no payment method id.");
                    $name = $this->getLabel('NO_FP');
                    $errorMsg = '<span style="color:red;">' . $name . '</span>';
                    $data = array(
                        'name' => $this->getLabel('NAME') . ' - ' . $name,
                        'stic_validation_actions_id' => $actionBean->id,
                        'log' => '<div>' . $errorMsg . '</div>',
                        'parent_type' => $this->functionDef['module'],
                        'parent_id' => $bean->id,
                        'reviewed' => 'no',   
                        'assigned_user_id' => $bean->assigned_user_id,
                    );
                    $this->logValidationResult($data);
                } else {
                    // If you have try to recover the data
                    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Loading payment commitment data...");
                    if (($fp = BeanFactory::getBean('stic_Payment_Commitments', $p['fp_id'])) === false) {
                        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Unable to retrieve the payment commitment of [{$bean->id} - {$bean->name}] [{$p['fp_id']}]");
                        $name = $this->getLabel('NO_FP');
                        $errorMsg = '<span style="color:red;">' . $name . '</span>';
                        $data = array(
                            'name' => $this->getLabel('NAME') . ' - ' . $name,
                            'stic_validation_actions_id' => $actionBean->id,
                            'log' => '<div>' . $errorMsg . '</div>',
                            'parent_type' => $this->functionDef['module'],
                            'parent_id' => $bean->id,
                            'reviewed' => 'no',   
                            'assigned_user_id' => $bean->assigned_user_id,
                        );
                        $this->logValidationResult($data);
                    } else {
                        // If the data can be recovered, the Person or Organization of the FP is recovered

                        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Retrieving relationships from the payment commitment [{$p['fp_id']}] ...");

                        // We establish the payment relationship with the account or contact as appropriate
                        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": IDBeanContact: [{$bean->stic_payments_contactscontacts_ida}] IdFPContact: [{$fp->stic_payment_commitments_contactscontacts_ida}]");

                        $bean->stic_payments_contactscontacts_ida = $fp->stic_payment_commitments_contactscontacts_ida;
                        if (is_object($fp->stic_payment_commitments_contactscontacts_ida)) {
                            $fp->stic_payment_commitments_contactscontacts_ida->load();
                            foreach ($fp->stic_payment_commitments_contactscontacts_ida->rows as $id_row => $valor) {
                                $bean->stic_payments_contactscontacts_ida = $id_row;
                            }

                        }

                        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": IDBeanAccount: [{$bean->stic_payments_accountsaccounts_ida}] IdFPAccount: [{$fp->stic_payments_accountsaccounts_ida}]");

                        $bean->stic_payments_accountsaccounts_ida = $fp->stic_payments_accountsaccounts_ida;
                        if (is_object($fp->stic_payments_accountsaccounts_ida)) {
                            $fp->stic_payments_accountsaccounts_ida->load();
                            foreach ($fp->stic_payments_accountsaccounts_ida->rows as $id_row => $valor) {
                                $bean->stic_payments_accountsaccounts_ida = $id_row;
                            }

                        }

                        if (empty($bean->stic_payments_accountsaccounts_ida) && empty($bean->stic_payments_contactscontacts_ida)) {
                            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Could not retrieve relationships.");
                            $name = $this->getLabel('NO_LINK');
                            $errorMsg = '<span style="color:red;">' . $name . '</span>';
                            $data = array(
                                'name' => $this->getLabel('NAME') . ' - ' . $name,
                                'stic_validation_actions_id' => $actionBean->id,
                                'log' => '<div>' . $errorMsg . '</div>',
                                'parent_type' => $this->functionDef['module'],
                                'parent_id' => $bean->id,
                                'reviewed' => 'no',   
                                'assigned_user_id' => $bean->assigned_user_id,
                            );
                            $this->logValidationResult($data);
                        } else {
                            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Updating relationships of [{$bean->id} - {$bean->name}] [{$bean->stic_payments_accountsaccounts_ida}] [{$bean->stic_payments_contactscontacts_ida}] ...");
                            $bean->save();
                            $name = $this->getLabel('UPDATED_LINK');                            
                            $errorMsg = $name;
                            $data = array(
                                'name' => $this->getLabel('NAME') . ' - ' . $name,
                                'stic_validation_actions_id' => $actionBean->id,
                                'log' => '<div>' . $errorMsg . '</div>',
                                'parent_type' => $this->functionDef['module'],
                                'parent_id' => $bean->id,
                                'reviewed' => 'not_necessary',   
                                'assigned_user_id' => $bean->assigned_user_id,
                            );
                            $this->logValidationResult($data);                            
                            $updated++;
                        }
                    }
                }
            }

            $count++; // Records Processed
        }

        $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ": [{$count}] payment/s without valid relationship found, [{$updated}] updated records.");

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
}
