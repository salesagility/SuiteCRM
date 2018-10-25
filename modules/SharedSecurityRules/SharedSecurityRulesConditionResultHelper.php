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


/**
 * SharedSecurityRulesConditionResultHelper
 *
 * @author gyula
 */
class SharedSecurityRulesConditionResultHelper {
    
    protected $rulesHelper;
    
    public function __construct(SharedSecurityRulesHelper $rulesHelper) {
        $this->rulesHelper = $rulesHelper;
    }
    
    /**
     * 
     * @param type $result
     * @param type $overallResult
     * @param type $nextConditionLogicOperator
     * @return type
     */
    protected function updateResultByLogicOp($result, $overallResult, $nextConditionLogicOperator) {
        
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
    protected function getConditionResult($allConditions, SugarBean $moduleBean, $rule, $view, $action, $key, $result = false) {
        
        global $current_user;
        
        $end = false;
        $result = null;

        for ($x = 0; $x < sizeof($allConditions) && !$end; $x++) {
            // Is it the starting parenthesis?
            if ($allConditions[$x]['parenthesis'] == "START") {
                LoggerManager::getLogger()->info('SharedSecurityRules: Parenthesis condition found.');

                $parenthesisConditionArray = $this->rulesHelper->getParenthesisConditions($allConditions[$x], $allConditions);
                $overallResult = $this->rulesHelper->checkParenthesisConditions($parenthesisConditionArray, $moduleBean, $rule, $view, $action, $key);

                // Retrieve the number of parenthesis conditions so we know how many conditions to skip for next run through
                $x = $x + sizeof($parenthesisConditionArray);

                //Check next logical operator
                $nextOrder = $allConditions[$x]['condition_order'] + 1;
                $nextQuery = "SELECT logic_op FROM sharedsecurityrulesconditions WHERE sa_shared_sec_rules_id = '{$allConditions[$x]['sa_shared_sec_rules_id']}' AND condition_order = $nextOrder AND deleted=0";
                $nextResult = $this->rulesHelper->db->query($nextQuery, true, "Error retrieving next condition");
                $nextRow = $this->rulesHelper->db->fetchByAssoc($nextResult);
                $nextConditionLogicOperator = $nextRow['logic_op'];

                // If the condition is a match then continue if it is an AND and finish if its an OR
                $result = $this->updateResultByLogicOp($result, $overallResult, $nextConditionLogicOperator);
                try {
                    $result = $this->rulesHelper->getResultByLogicOp($overallResult, $nextConditionLogicOperator);
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
                $nextResult = $this->rulesHelper->db->query($nextQuery, true, "Error retrieving next condition");
                $nextRow = $this->rulesHelper->db->fetchByAssoc($nextResult);
                $nextConditionLogicOperator = $nextRow['logic_op'];
                $allConditions[$x]['module_path'] = $this->rulesHelper->unserializeIfSerialized($allConditions[$x]['module_path']);

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
                        if ($this->rulesHelper->checkOperator(
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

                    $conditionResult = $this->rulesHelper->checkOperator($moduleBean->{$allConditions[$x]['field']}, $allConditions[$x]['value'], $allConditions[$x]['operator']);

                    if ($conditionResult) {
                        if ($nextConditionLogicOperator === "AND") {
                            $result = true;
                        } else {
                            $end = true;
                            $result = true;
                        }
                    } else {
                        if ($rule['run'] == "Once True") {
                            if ($this->rulesHelper->checkHistory($moduleBean, $allConditions[$x]['field'], $allConditions[$x]['value'])) {
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
            $converted_res = $this->rulesHelper->getConvertedRes($result);
        }
        LoggerManager::getLogger()->info('SharedSecurityRules: Exiting getConditionResult() with result: ' . $converted_res);
        
        return $result;
    }
    
}
