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
 * Class to check the following fields of the Payment Commitment
 * - Payment method
 * - Date of first payment
 * - Periodicity
 * - Amount
 * - Name
 * - IBAN
 * - WERE GOING
 */
class CheckPCBeanData extends DataCheckFunction
{
    protected $currencyFormatParams = null;

    public function __construct($functionDef)
    {
        parent::__construct($functionDef);
        $this->currencyFormatParams = array('currency_symbol' => true);
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
        $objModel = BeanFactory::getBean($this->module);
        $fieldDefs = $objModel->field_defs;

        // direct debit
        // We will receive the data only of the wrong forms of payment
        while ($row = array_pop($records)) 
        {
            $logName = "[{$row['id']} - {$row['name']}]";
            // Check the fields to review
            foreach ($fieldsToValidate as $field) 
            {
                if (!SticUtils::isValidField($field, $row[$field], $fieldDefs, false)) {
                    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Field [{$field}] with value [{$row[$field]}] wrong in [{$this->module}] {$logName}.");
                    $fieldName = translate($fieldDefs[$field]['vname'], $this->module);
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
                    $fieldName = translate($fieldDefs[$field]['vname'], $this->module);
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
                && ($row['payment_method'] == 'direct_debit' || $row['payment_method'] == 'transfer_issued')) 
            {
                $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Cleaning bank account number of {$logName} ...");
                $iban = SticUtils::cleanIBAN($row['bank_account']);
                $updateIBAN = $iban != $row['bank_account']; // We aim to update the account number (to clean spaces)
                $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Validating bank account number ...");
                if (!SticUtils::checkIBAN($iban, false)) {
                    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Bank account Number {$logName} not valid.");
                    $name = translate($fieldDefs['bank_account']['vname'], $this->module) . $this->getLabel('ERR_FIELD') . " [{$row['bank_account']}]";
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
                    // Calculate if it is necessary to update the command
                    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Mandate [{$row['mandate']}] of {$logName} ...");
                    $updateMandate = !SticUtils::isValidMandate($row['mandate']);

                    // If you have to update a field, load the Bean
                    if ($updateIBAN || $updateMandate) {

                        $bean = $this->loadBean($bean, $row);

                        if ($updateIBAN) {
                            $bean->bank_account = $iban; // modify account number
                            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Updating bank account number of {$logName} ...");
                        }

                        if ($updateMandate) {
                            $bean->mandate = SticUtils::createMandate(); // modify the command
                            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": The Mandate of {$logName} was not valid, updating [{$row['mandate']}] [{$bean->mandate}] ...");
                        }

                        $bean->save();

                        // Add the information of the changes
                        if ($updateIBAN) {
                            $name = translate($fieldDefs['bank_account']['vname'], $this->module) . $this->getLabel('UPDATED_IBAN') . " [{$row['bank_account']}] -> [{$iban}]";
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
                            $name = translate($fieldDefs['mandate']['vname'], $this->module) . $this->getLabel('UPDATED_MANDATE') . " [{$row['mandate']}] -> [{$bean->mandate}]";
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
                        $updated++;
                    }
                }
            }
            $count++; // Records Processed
        }
        
        $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ": Reviewed Records [{$count}] wrong [{$errors}], updated [{$updated}]");

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
        } else if (!$errors && $actionBean->report_always) {
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
