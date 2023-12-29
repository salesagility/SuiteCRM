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
 * Class to check the following fields of Relationships Organization
 * - Discharge date
 * - Type of relationship
 * - Registration Name
 * - With registration date after discharge date
 */
class CheckAccountsRelationshipsBeanData extends DataCheckFunction 
{
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

        $fieldsToValidate = $this->fieldsToValidate;
        $objModel = BeanFactory::getBean($this->module);
        $fieldDefs = $objModel->field_defs;

        while ($row = array_pop($records)) 
        {
            $bean = null;
            $logName = "[{$row['id']} - {$row['name']}]";

            // Check the fields to review
            foreach ($fieldsToValidate as $field) 
            {
                if (!SticUtils::isValidField($field, $row[$field], $fieldDefs, $field == 'start_date')) {
                    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Field [{$field}] with value [{$row[$field]}] wrong in [{$this->module}] {$logName}.");
                    $fieldName = translate($fieldDefs[$field]['vname'], $this->module);
                    $name = $row[$field] ? '[' . $row[$field] . '] - ':'';
                    $name .= $fieldName . ' ' . $this->getLabel('ERR_FIELD');
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
                }
            }

            // If you have a discharge date, compare it with the discharge date
            if ($row['end_date'] && $row['start_date'] && SticUtils::compareDate($row['start_date'], $row['end_date']) < 0) {
                $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": End date [{$row['end_date']}] prior to start date [{$row['start_date']}] in [{$this->module}] {$logName}.");
                $name = $this->getLabel('LEAVING_DATE');
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

            $count++; // Records Processed
        }

        $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ": Revieweds records [{$count}] wrong [{$errors}].");

        // Report_always
        global $current_user;
        if (!$count && $actionBean->report_always) {
            $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ": No record has been retrieved to validate.");
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