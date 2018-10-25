<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
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
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

include_once 'SharedSecurityRulesHelperException.php';

class SharedSecurityRulesHelper
{
    
    /**
     *
     * @var DBManager
     */
    protected $db;
    
    /**
     *
     * @param DBManager $db
     */
    public function __construct(DBManager $db)
    {
        $this->db = $db;
    }
    
    /**
     * Quote all in post data
     *
     * @param array $post
     * @return array
     */
    public function quote($post)
    {
        foreach ($post as $key => $value) {
            $needsDeepQuote = false;
            if (is_array($value) || is_object($value)) {
                $needsDeepQuote = true;
            }
            $post[$key] = $needsDeepQuote ? $this->quote($value) : $this->db->quote($value);
        }
        return $post;
    }
    

    /**
     *
     * @param array $originalCondition
     * @param array $allConditionsResults
     * @return array
     */
    protected function getParenthesisConditions($originalCondition, $allConditionsResults)
    {
        LoggerManager::getLogger()->info('SharedSecurityRules: Entering getParenthesisConditions()');
        // Just get the conditions we need to check for this
        $allParenthesisConditions = array();

        foreach ($allConditionsResults as $condition) {
            if ($condition['condition_order'] > $originalCondition['condition_order'] && $condition['parenthesis'] != $originalCondition['id']) {
                array_push($allParenthesisConditions, $condition);
            }

            if ($condition['condition_order'] > $originalCondition['condition_order'] && $condition['parenthesis'] == $originalCondition['id']) {
                array_push($allParenthesisConditions, $condition);
                return $allParenthesisConditions;
            }
        }

        LoggerManager::getLogger()->info('SharedSecurityRules: Exiting getParenthesisConditions() with all parenthesis conditions');
        return $allParenthesisConditions;
    }
    
    /**
     *
     * @param bool $tempResult
     * @return boolean
     */
    protected function getParenthesisConditionsReturn($tempResult)
    {
        if (!$tempResult) {
            LoggerManager::getLogger()->info('SharedSecurityRules: Exiting checkParenthesisConditions returning false.');
            return false;
        }
        LoggerManager::getLogger()->info('SharedSecurityRules: Exiting checkParenthesisConditions returning true.');
        return true;
    }
    
    /**
     *
     * @param array $allParenthesisConditions
     * @param SugarBean $moduleBean
     * @param array $rule
     * @param string $view
     * @param string $action
     * @param string $key
     * @return array
     */
    protected function getConditionsToCheck($allParenthesisConditions, SugarBean $moduleBean, $rule, $view, $action, $key)
    {
        $conditionsToCheck = array();

        for ($j = 0; $j < count($allParenthesisConditions); $j++) {
            // Check parenthesis is equal to start, if so then start this whole process again
            if ($allParenthesisConditions[$j]['parenthesis'] == "START") {
                $parenthesisConditionArray = $this->getParenthesisConditions($allParenthesisConditions[$j], $allParenthesisConditions);
                $this->checkParenthesisConditions($parenthesisConditionArray, $moduleBean, $rule, $view, $action, $key);
            }

            // Check parenthesis is blank, if it is then process as normal...
            if ($allParenthesisConditions[$j]['parenthesis'] == "") {
                // Add to array to be processed once checked
                array_push($conditionsToCheck, $allParenthesisConditions[$j]);
            }
        }
        return $conditionsToCheck;
    }

    /**
     *
     * @param array $allParenthesisConditions
     * @param SugarBean $moduleBean
     * @param array $rule
     * @param string $view
     * @param string $action
     * @param string $key
     * @return boolean
     */
    protected function checkParenthesisConditions($allParenthesisConditions, SugarBean $moduleBean, $rule, $view, $action, $key)
    {
        LoggerManager::getLogger()->info('SharedSecurityRules: Entering checkParenthesisConditions()');

        
        $conditionsToCheck = $this->getConditionsToCheck();

        if (sizeof($conditionsToCheck) > 0) {
            // Get results of searching all conditions within the perms (true = condition met)
            $tempResult = $this->getConditionResult($conditionsToCheck, $moduleBean, $rule, $view, $action, $key);
            return $this->getParenthesisConditionsReturn($tempResult);
        }

        LoggerManager::getLogger()->info('SharedSecurityRules: Exiting checkParenthesisConditions with no conditions to check.');
        return false;
    }
    
    /**
     *
     * @param bool $overallResult
     * @param string $nextConditionLogicOperator
     * @return boolean
     * @throws SharedSecurityRulesHelperException
     */
    protected function getResultByLogicOp($overallResult, $nextConditionLogicOperator)
    {
        if ($overallResult) {
            if ($nextConditionLogicOperator === "AND") {
                LoggerManager::getLogger()->info('SharedSecurityRules: In getConditionResult() within parenthesis setting result to true');
                $result = true;
            } else {
                throw new SharedSecurityRulesHelperException('SharedSecurityRules: In getConditionResult() within parenthesis returning true', true);
            }
        } else {
            if ($nextConditionLogicOperator === "AND") {
                throw new SharedSecurityRulesHelperException('SharedSecurityRules: In getConditionResult() within parenthesis returning false', false);
            } else {
                LoggerManager::getLogger()->info('SharedSecurityRules: In getConditionResult() within parenthesis setting result to false');
                $result = false;
            }
        }
                
        return $result;
    }

    /**
     *
     * @global User $current_user
     * @global User $current_user
     * @param array $allConditions
     * @param SugarBean $moduleBean
     * @param array $rule
     * @param string $view
     * @param string $action
     * @param string $key
     * @param boolean $result
     * @return boolean
     */
    protected function getConditionResult($allConditions, SugarBean $moduleBean, $rule, $view, $action, $key, $result = false)
    {
        global $current_user;

        LoggerManager::getLogger()->info('SharedSecurityRules: Entering getConditionResult()');
        
        $end = false;
        $result = null;

        for ($x = 0; $x < sizeof($allConditions) && !$end; $x++) {
            // Is it the starting parenthesis?
            if ($allConditions[$x]['parenthesis'] == "START") {
                LoggerManager::getLogger()->info('SharedSecurityRules: Parenthesis condition found.');

                $parenthesisConditionArray = $this->getParenthesisConditions($allConditions[$x], $allConditions);
                $overallResult = $this->checkParenthesisConditions($parenthesisConditionArray, $moduleBean, $rule, $view, $action, $key);

                // Retrieve the number of parenthesis conditions so we know how many conditions to skip for next run through
                $x = $x + sizeof($parenthesisConditionArray);

                //Check next logical operator
                $nextOrder = $allConditions[$x]['condition_order'] + 1;
                $nextQuery = "SELECT logic_op FROM sharedsecurityrulesconditions WHERE sa_shared_sec_rules_id = '{$allConditions[$x]['sa_shared_sec_rules_id']}' AND condition_order = $nextOrder AND deleted=0";
                $nextResult = $this->db->query($nextQuery, true, "Error retrieving next condition");
                $nextRow = $this->db->fetchByAssoc($nextResult);
                $nextConditionLogicOperator = $nextRow['logic_op'];

                // If the condition is a match then continue if it is an AND and finish if its an OR
                try {
                    $result = $this->getResultByLogicOp($overallResult, $nextConditionLogicOperator);
                } catch (SharedSecurityRulesHelperException $e) {
                    LoggerManager::getLogger()->info($e->getMessage());
                    $end = true;
                    $result = $e->return;
                }

            } else {

                // Check if there is another condition and get the operator
                LoggerManager::getLogger()->info('SharedSecurityRules: All parenthesis looked at now working out next order number to be processed');
                $nextOrder = $allConditions[$x]['condition_order'] + 1;
                $nextQuery = "SELECT logic_op FROM sharedsecurityrulesconditions WHERE sa_shared_sec_rules_id = '{$allConditions[$x]['sa_shared_sec_rules_id']}' AND condition_order = $nextOrder AND deleted=0";
                $nextResult = $this->db->query($nextQuery, true, "Error retrieving next condition");
                $nextRow = $this->db->fetchByAssoc($nextResult);
                $nextConditionLogicOperator = $nextRow['logic_op'];
                $allConditions[$x]['module_path'] = $this->unserializeIfSerialized($allConditions[$x]['module_path']);

                /* this needs to be uncommented out and checked */

                if ($allConditions[$x]['module_path'][0] != $rule['flow_module']) {
                    foreach ($allConditions[$x]['module_path'] as $rel) {
                        if (!empty($rel)) {
                            $moduleBean->load_relationship($rel);
                            $related = $moduleBean->$rel->getBeans();
                        }
                    }
                }


                if ($related !== false && $related !== null && $related !== "") {
                    foreach ($related as $record) {
                        if ($moduleBean->field_defs[$allConditions[$x]['field']]['type'] == "relate") {
                            $allConditions[$x]['field'] = $moduleBean->field_defs[$allConditions[$x]['field']]['id_name'];
                        }
                        if ($allConditions[$x]['value_type'] == "currentUser") {
                            $allConditions[$x]['value_type'] = "Field";
                            $allConditions[$x]['value'] = $current_user->id;
                        }

                        if ($allConditions[$x]['field'] == 'assigned_user_name') {
                            $allConditions[$x]['field'] = 'assigned_user_id';
                        }
                        if ($this->checkOperator(
                                        $record->{$allConditions[$x]['field']}, $allConditions[$x]['value'], $allConditions[$x]['operator']
                                )) {
                            $result = true;
                        } else {
                            if (count($related) <= 1) {
                                $result = false;
                            }
                        }
                    }
                } else {
                    if ($allConditions[$x]['value_type'] == "currentUser") {
                        $allConditions[$x]['value_type'] = "Field";
                        $allConditions[$x]['value'] = $current_user->id;
                    }
                    //check and see if it is pointed at a field rather than a value.
                    if ($allConditions[$x]['value_type'] == "Field" &&
                            isset($moduleBean->{$allConditions[$x]['value']}) &&
                            !empty($moduleBean->{$allConditions[$x]['value']})) {
                        $allConditions[$x]['value'] = $moduleBean->{$allConditions[$x]['value']};
                    }

                    if ($allConditions[$x]['field'] == 'assigned_user_name') {
                        $allConditions[$x]['field'] = 'assigned_user_id';
                    }

                    $conditionResult = $this->checkOperator($moduleBean->{$allConditions[$x]['field']}, $allConditions[$x]['value'], $allConditions[$x]['operator']);

                    if ($conditionResult) {
                        if ($nextConditionLogicOperator === "AND") {
                            $result = true;
                        } else {
                            $end = true;
                            $result = true;
                        }
                    } else {
                        if ($rule['run'] == "Once True") {
                            if ($this->checkHistory($moduleBean, $allConditions[$x]['field'], $allConditions[$x]['value'])) {
                                $result = true;
                            } else {
                                $result = false;
                            }
                        } else {
                            $result = false;
                            if ($nextConditionLogicOperator === "AND") {
                                $end = true;
                            }
                        }
                    }
                }
            }
        }

        $converted_res = '';
        if (isset($result)) {
            $converted_res = $this->getConvertedRes($result);
        }
        LoggerManager::getLogger()->info('SharedSecurityRules: Exiting getConditionResult() with result: ' . $converted_res);

        return $result;
    }
    

    /**
     *
     * @param array $rule
     * @param SugarBean $moduleBean
     * @param string $view
     * @param string $action
     * @param string $key
     * @return boolean
     */
    public function checkConditions($rule, SugarBean $moduleBean, $view, $action, $key)
    {
        LoggerManager::getLogger()->info('SharedSecurityRules: Entered checkConditions() for rule name: ' . $rule['name']);

        $sql_query = "SELECT * FROM sharedsecurityrulesconditions WHERE sharedsecurityrulesconditions.sa_shared_sec_rules_id = '{$rule['id']}' AND sharedsecurityrulesconditions.deleted = '0' ORDER BY sharedsecurityrulesconditions.condition_order ASC ";
        $conditions_results = $moduleBean->db->query($sql_query);

        $allConditions = array();

        // Loop through all conditions and add to array
        while ($condition = $moduleBean->db->fetchByAssoc($conditions_results)) {
            array_push($allConditions, $condition);
        }

        $result = $this->getConditionResult($allConditions, $moduleBean, $rule, $view, $action, $key, $conditions_results);

        if (inDeveloperMode()) {
            $converted_res = '';
            if (isset($result)) {
                $converted_res = $this->getConvertedRes($result);
            }
            LoggerManager::getLogger()->info('SharedSecurityRules: Exiting checkConditions() with result: ' . $converted_res . '  ');
        }
        return $result;
    }

    /**
     * @param string $rowField
     * @param string $field
     * @param string $operator
     *
     * @return bool
     */
    protected function checkOperator($rowField, $field, $operator)
    {
        LoggerManager::getLogger()->info('SharedSecurityRules: In checkOperator() with row: ' . $rowField . ' field: ' . $field . ' operator: ' . $operator);
        switch ($operator) {
            case "Equal_To":
                return strcasecmp($rowField, $field) == 0;
            case "Not_Equal_To":
                return strcasecmp($rowField, $field) != 0;
            case "Starts_With":
                return substr($rowField, 0, strlen($field)) === $field;
            case "Ends_With":
                return substr($rowField, -strlen($field)) === $field;
            case "Contains":
                return strpos($rowField, $field) !== false;
            case "Greater_Than":
                return $rowField > $field;
            case "Less_Than":
                return $rowField < $field;
            case "Greater_Than_or_Equal_To":
                return $rowField >= $field;
            case "Less_Than_or_Equal_To":
                return $rowField <= $field;
            case "is_null":
                return $rowField == null || $rowField == "";
        }
        return false;
    }

    /**
     * @param string $view
     * @param string $item
     *
     * @return bool
     */
    public function findAccess($view, $item)
    {
        if (stripos($item, $view) !== false) {
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param mixed $result
     * @return string
     */
    public function getConvertedRes($result)
    {
        $converted_res = $result ? 'true' : 'false';
        return $converted_res;
    }
        
    /**
     * 
     * @param string $serialized
     * @return string
     */
    public function unserializeIfSerialized($serialized)
    {
        $unserialized = unserialize(base64_decode($serialized));
        if ($unserialized != false) {
            $serialized = $unserialized;
        }
        return $serialized;
    }
}
