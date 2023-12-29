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

require_once 'SticInclude/Utils.php';

/**
 * Class to check the following Payments fields
 * - Payment method
 * - Date of first payment
 * - Periodicity
 * - Amount
 * - Name
 * - IBAN
 * - WERE GOING
 */
class CheckPaymentsBeanData extends DataCheckFunction
{
    protected $currencyFormatParams = null;
    protected $fieldDefs = null;

    public function __construct($functionDef)
    {
        parent::__construct($functionDef);
        $this->currencyFormatParams = array('currency_symbol' => true);
        $objModel = BeanFactory::getBean($this->module);
        $this->fieldDefs = $objModel->field_defs;
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
        global $sugar_config;
        // It will indicate if records have been found to validate.
        $count = 0;
        // It will indicate if records with errors have been found.
        $errors = 0;
        // It will indicate how many records have been updated.        
        $updated = 0;

        $fieldsToValidate = $this->fieldsToValidate;
        $validateMP = in_array("payment_method", $fieldsToValidate);

        // direct debit
        // We will receive the data only of the wrong forms of payment
        while ($row = array_pop($records)) 
        {
            $bean = null;
            $logName = "[{$row['id']} - {$row['name']}]";

            // Check the fields to review
            foreach ($fieldsToValidate as $field) 
            {
                if (!SticUtils::isValidField($field, $row[$field], $this->fieldDefs, false) ||
                    ($field == 'payment_date' && empty($row[$field]))) {
                    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Field [{$field}] with value [{$row[$field]}] wrong in [{$this->module}] {$logName}.");
                    $fieldName = translate($this->fieldDefs[$field]['vname'], $this->module);
                    $name = $fieldName . ' ' . $this->getLabel('ERR_FIELD') . " [{$row[$field]}]";
                    $errorMsg = '<span style="color:red;">' . $name . '</span>';
                    $errorMsg2 = $field == 'name' ? '<br />- ID: <a href="' . $sugar_config["site_url"] . '/index.php?module=' . $this->module . '&return_module=' . $this->module . '&action=DetailView&record=' . $row['id'] . '">' . $row['id'] . '</a>' : '';
                    $data = array(
                        'name' => $this->getLabel('NAME') . ' - ' . $name,
                        'stic_validation_actions_id' => $actionBean->id,
                        'log' => '<div>' . $errorMsg . $errorMsg2 . '</div>',
                        'parent_type' => $this->functionDef['module'],
                        'parent_id' => $row['id'],
                        'reviewed' => 'no',   
                        'assigned_user_id' => $row['assigned_user_id'],
                    );
                    $this->logValidationResult($data);
                    $errors++;
                } else if ($field == 'amount' && filter_var($row[$field], FILTER_VALIDATE_FLOAT) && $row[$field] <= 0) {
                    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Field amount with value [{$row[$field]}] less than equal to 0.");
                    $fieldName = translate($this->fieldDefs[$field]['vname'], $this->module);
                    $bean = $this->loadBean($bean, $row);
                    $formatedNumber = format_number($row[$field], null, null, $this->currencyFormatParams);
                    $name = $fieldName . ' ' . $this->getLabel('WARN_FIELD') . " [{$formatedNumber}]";
                    $errorMsg = '<span style="color:red;">' . $name . '</span>';
                    $data = array(
                        'name' => $this->getLabel('NAME') . ' - ' . $name,
                        'stic_validation_actions_id' => $actionBean->id,
                        'log' => '<div>' . $errorMsg . '</div>',
                        'parent_type' => $this->functionDef['module'],
                        'parent_id' => $row['id'],
                        'reviewed' => 'no',   
                        'assigned_user_id' => $row['assigned_user_id'],
                    );
                    $this->logValidationResult($data);
                    $errors++;
                }
            }

            // If the payment method is validated and SEPA_VALIDATE_IBAN is true check if the account number has to be validated
            require_once 'modules/stic_Settings/Utils.php';
            if ($validateMP && stic_SettingsUtils::getSetting('GENERAL_IBAN_VALIDATION') != 0 
            && ($row['payment_method'] == 'direct_debit' || $row['payment_method'] == 'transfer_issued')) {
                $this->checkDirectDebit($row, $actionBean, $updated, $errors);
            }

            $count++; // Records processed
        }

        $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ": Reviewed Records [{$count}] erroneos [{$errors}], updated [{$updated}]");

        // Report_always
        global $current_user;
        if (!$count && $actionBean->report_always) {
            $errorMsg = $this->getLabel('NO_ROWS');
            $data = array(
                'name' => $errorMsg,
                'stic_validation_actions_id' => $actionBean->id,
                'log' => '<div>' . $errorMsg . '</div>',
                'reviewed' => 'not_necessary',              
                'assigned_user_id' => $current_user->id, // In this message we indicate the administrator user
            );
            $this->logValidationResult($data);
        } else if (!$errors && !$updated && $actionBean->report_always) {
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
     * Retrieve the payment commitments linked to the id
     * @param unknown $idPaymentCommitment
     * @return NULL|Bean
     */
    protected function getPC($idPaymentCommitment)
    {
        if (empty($idPaymentCommitment)) {
            return null;
        }
        return BeanFactory::getBean('stic_Payment_Commitments', $idPaymentCommitment);
    }

    /**
     *
     * @param unknown $row
     * @param unknown $updated
     * @param unknown $errors
     */
    protected function checkDirectDebit($row, $actionBean, &$updated, &$errors)
    {
        $logName = "[{$row['id']} - {$row['name']}]";
        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Cleaning bank account number of {$logName} ...");
        $iban = SticUtils::cleanIBAN($row['bank_account']);
        $updateBankAccount = $iban !== $row['bank_account']; // we aim to update the account number (to clean spaces)
        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Validating bank account number...");

        if (!SticUtils::checkIBAN($iban, false)) {
            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Bank account number [{$row['bank_account']}] de {$logName} invalid.");
            $name = translate($this->fieldDefs['bank_account']['vname'], $this->module) . $this->getLabel('ERR_FIELD') . " [{$row['bank_account']}]";
            $errorMsg = '<span style="color:red;">' . $name . '</span>';
            $data = array(
                'name' => $this->getLabel('NAME') . ' - ' . $name,
                'stic_validation_actions_id' => $actionBean->id,
                'log' => '<div>' . $errorMsg . '</div>',
                'parent_type' => $this->functionDef['module'],
                'parent_id' => $row['id'],
                'reviewed' => 'no',   
                'assigned_user_id' => $row['assigned_user_id'],
            );
            $this->logValidationResult($data);            
            $errors++;
        
        } else {
            $bean = null;
            $updateMandate = false;
            $labelMandate = '';

            // If there is an error in the command, try to recover the payment method data
            if (!SticUtils::isValidMandate($row['mandate'])) {
                $bean = $this->loadBean($bean, $row);
                $pc = $this->getPC($bean->stic_paymebfe2itments_ida);

                // If there is no linked payment method, the user is informed
                if (!$pc) {
                    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Mandate [{$row['mandate']}] de {$logName} Invalid and not recoverable from the payment method.");
                    $name = translate($this->fieldDefs['mandate']['vname'], $this->module) . " [{$row['mandate']}] " . $this->getLabel('NOVALID_MANDATE');
                    $errorMsg = '<span style="color:red;">' . $name . '</span>';
                    $data = array(
                        'name' => $this->getLabel('NAME') . ' - ' . $name,
                        'stic_validation_actions_id' => $actionBean->id,
                        'log' => '<div>' . $errorMsg . '</div>',
                        'parent_type' => $this->functionDef['module'],
                        'parent_id' => $row['id'],
                        'reviewed' => 'not_necessary',   
                        'assigned_user_id' => $row['assigned_user_id'],
                    );
                    $this->logValidationResult($data);                    
                    $errors++;
                    // If we have been able to recover the data and it is a direct debit check the account number
                } else {
                    $banckAccount = SticUtils::cleanIBAN($pc->bank_account);
                    // If the account numbers are different or the form of payment is not a direct debit, calculate a new number
                    if ($banckAccount != $iban || $pc->payment_method != $bean->payment_method) {
                        $bean->mandate = SticUtils::createMandate(); // modify the command
                        $labelMandate = 'UPDATED_MANDATE';
                        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": The Mandate of {$logName} was not valid, updating [{$row['mandate']}] [{$bean->mandate}] ...");
                        $updateMandate = true;
                        // If it is a direct debit and the account numbers are equal, check the mandate, if it is valid it is inherited
                    } else if (SticUtils::isValidMandate($pc->mandate)) {
                        $bean->mandate = $pc->mandate; // inherit the command
                        $labelMandate = 'INHERIT_MANDATE';
                        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ":The Mandate of {$logName} was not valid, inheriting [{$row['mandate']}] [{$bean->mandate}] ...");
                        $updateMandate = true;
                        // If it is not valid, the user is informed
                    } else {
                        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Mandate [{$row['mandate']}] de {$logName} Invalid and not recoverable from the payment method.");
                        $name = translate($this->fieldDefs['mandate']['vname'], $this->module) . " [{$row['mandate']}] " . $this->getLabel('NOVALID_MANDATE');
                        $errorMsg = '<span style="color:red;">' . $name . '</span>';
                        $data = array(
                            'name' => $this->getLabel('NAME') . ' - ' . $name,
                            'stic_validation_actions_id' => $actionBean->id,
                            'log' => '<div>' . $errorMsg . '</div>',
                            'parent_type' => $this->functionDef['module'],
                            'parent_id' => $row['id'],
                            'reviewed' => 'not_necessary',   
                            'assigned_user_id' => $row['assigned_user_id'],
                        );
                        $this->logValidationResult($data);   
                        $errors++;
                    }
                }
            }

            // If you have to update any of the fields we load and save the bean
            if ($updateBankAccount || $updateMandate) {
                if (!$bean) {$this->loadBean($bean, $row);}

                // Add the information of the changes
                if ($updateBankAccount) {
                    $bean->bank_account = $iban;
                    $name = translate($this->fieldDefs['bank_account']['vname'], $this->module) . $this->getLabel('UPDATED_IBAN') . " [{$row['bank_account']}] -> [{$bean->bank_account}] ";
                    $errorMsg = $name;
                    $data = array(
                        'name' => $this->getLabel('NAME') . ' - ' . $name,
                        'stic_validation_actions_id' => $actionBean->id,
                        'log' => '<div>' . $errorMsg . '</div>',
                        'parent_type' => $this->functionDef['module'],
                        'parent_id' => $row['id'],
                        'reviewed' => 'not_necessary',   
                        'assigned_user_id' => $row['assigned_user_id'],
                    );
                    $this->logValidationResult($data);                        
                }

                if ($updateMandate) {
                    $name = translate($this->fieldDefs['mandate']['vname'], $this->module) . $this->getLabel($labelMandate) . " [{$row['mandate']}] -> [{$bean->mandate}]";
                    $errorMsg = '<span style="color:red;">' . $name . '</span>';
                    $data = array(
                        'name' => $this->getLabel('NAME') . ' - ' . $name,
                        'stic_validation_actions_id' => $actionBean->id,
                        'log' => '<div>' . $errorMsg . '</div>',
                        'parent_type' => $this->functionDef['module'],
                        'parent_id' => $row['id'],
                        'reviewed' => 'not_necessary',   
                        'assigned_user_id' => $row['assigned_user_id'],
                    );
                    $this->logValidationResult($data);                       
                }

                $bean->save();
                $updated++;
            }
        }
    }
}
