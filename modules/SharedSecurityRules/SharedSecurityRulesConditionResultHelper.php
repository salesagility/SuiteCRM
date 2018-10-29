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
class SharedSecurityRulesConditionResultHelper
{
    
    /**
     *
     * @var SharedSecurityRulesHelper
     */
    protected $rulesHelper;
    
    /**
     *
     * @var bool
     */
    protected $end;
    
    /**
     *
     * @param SharedSecurityRulesHelper $rulesHelper
     */
    public function __construct(SharedSecurityRulesHelper $rulesHelper)
    {
        $this->rulesHelper = $rulesHelper;
    }
    
    /**
     *
     * @param boolean $overallResult
     * @param string $nextConditionLogicOperator
     * @return bool
     */
    protected function getResultByLogicOp($overallResult, $nextConditionLogicOperator)
    {
        try {
            $result = $this->rulesHelper->getResultByLogicOp($overallResult, $nextConditionLogicOperator);
        } catch (SharedSecurityRulesHelperException $e) {
            LoggerManager::getLogger()->info($e->getMessage());
            $this->end = true;
            $result = $e->return;
        }
                
        return $result;
    }
    
    /**
     *
     * @param array|null $related
     * @param array $modulePath
     * @param string $flowModule
     * @param SugarBean $moduleBean
     * @return array
     */
    protected function updateRelated($related, $modulePath, $flowModule, SugarBean $moduleBean)
    {
        if ($modulePath[0] != $flowModule) {
            foreach ($modulePath as $rel) {
                if (!empty($rel)) {
                    $moduleBean->load_relationship($rel);
                    $related = $moduleBean->$rel->getBeans();
                }
            }
        }
                
        return $related;
    }
    
    /**
     *
     * @param SugarBean $moduleBean
     * @param array $allCondition
     * @param string $userId
     * @return array
     */
    protected function updateAllConditionRelated(SugarBean $moduleBean, $allCondition, $userId)
    {
        if ($moduleBean->field_defs[$allCondition['field']]['type'] == "relate") {
            $allCondition['field'] = $moduleBean->field_defs[$allCondition['field']]['id_name'];
        }
        if ($allCondition['value_type'] == "currentUser") {
            $allCondition['value_type'] = "Field";
            $allCondition['value'] = $userId;
        }

        if ($allCondition['field'] == 'assigned_user_name') {
            $allCondition['field'] = 'assigned_user_id';
        }
                        
        return $allCondition;
    }
    
    /**
     *
     * @param boolean $result
     * @param array $related
     * @param array $allCondition
     * @param SugarBean $moduleBean
     * @param string $userId
     * @return boolean
     */
    protected function updateResultByRelated($result, $related, $allCondition, SugarBean $moduleBean, $userId)
    {
        foreach ($related as $record) {
            $allCondition = $this->updateAllConditionRelated($moduleBean, $allCondition, $userId);
                        
            if ($this->rulesHelper->checkOperator(
                $record->{$allCondition['field']}, $allCondition['value'], $allCondition['operator']
            )) {
                $result = true;
            } elseif (count($related) <= 1) {
                $result = false;
            }
        }
        return $result;
    }
    
    /**
     *
     * @param array $allCondition
     * @param string $userId
     * @param SugarBean $moduleBean
     * @return array
     */
    protected function updateAllConditionStarted($allCondition, $userId, SugarBean $moduleBean)
    {
        if ($allCondition['value_type'] == "currentUser") {
            $allCondition['value_type'] = "Field";
            $allCondition['value'] = $userId;
        }
        //check and see if it is pointed at a field rather than a value.
        if ($allCondition['value_type'] == "Field" &&
            isset($moduleBean->{$allCondition['value']}) &&
            !empty($moduleBean->{$allCondition['value']})
        ) {
            $allCondition['value'] = $moduleBean->{$allCondition['value']};
        }

        if ($allCondition['field'] == 'assigned_user_name') {
            $allCondition['field'] = 'assigned_user_id';
        }
                    
        return $allCondition;
    }
    
    /**
     *
     * @param string $ruleRun
     * @param SugarBean $moduleBean
     * @param string $field
     * @param string $value
     * @param string $nextConditionLogicOperator
     * @return boolean
     */
    protected function getResultByRuleRun($ruleRun, SugarBean $moduleBean, $field, $value, $nextConditionLogicOperator)
    {
        if ($ruleRun == "Once True") {
            $result = $this->rulesHelper->checkHistory($moduleBean, $field, $value);
        } else {
            $result = false;
            $this->end = $nextConditionLogicOperator === "AND" ? true : $this->end;
        }

        return $result;
    }
    
    /**
     * 
     * @param bool $conditionResult
     * @param string $nextConditionLogicOperator
     * @param string $ruleRun
     * @param SugarBean $moduleBean
     * @param string $field
     * @param string $value
     * @return bool
     */
    protected function getResultByConditionResult($conditionResult, $nextConditionLogicOperator, $ruleRun, SugarBean $moduleBean, $field, $value)
    {
        if ($conditionResult) {
            $this->end = $nextConditionLogicOperator !== "AND" ? true : $this->end;
            $result = true;
        } else {
            $result = $this->getResultByRuleRun($ruleRun, $moduleBean, $field, $value, $nextConditionLogicOperator);
        }
        return $result;
    }
    
    /**
     * 
     * @param array $allConditions
     * @param SugarBean $moduleBean
     * @param array $rule
     * @param string $view
     * @param string $action
     * @param string $key
     * @param boolean $result
     * @return boolean
     */
    protected function getResult($allConditions, SugarBean $moduleBean, $rule, $view, $action, $key, $result = false) {
        
        $this->end = false;
        $related = null;

        for ($x = 0; $x < sizeof($allConditions) && !$this->end; $x++) {
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
                $result = $this->getResultByLogicOp($overallResult, $nextConditionLogicOperator);
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

                $related = $this->updateRelated($related, $allConditions[$x]['module_path'], $rule['flow_module'], $moduleBean);


                if ($related !== false && $related !== null && $related !== "") {
                    $result = $this->updateResultByRelated($result, $related, $allConditions[$x], $moduleBean, $current_user->id);
                } else {
                    $allConditions[$x] = $this->updateAllConditionStarted($allConditions[$x], $current_user->id, $moduleBean);

                    $conditionResult = $this->rulesHelper->checkOperator($moduleBean->{$allConditions[$x]['field']}, $allConditions[$x]['value'], $allConditions[$x]['operator']);

                    $result = $this->getResultByConditionResult($conditionResult, $nextConditionLogicOperator, $rule['run'], $moduleBean, $allConditions[$x]['field'], $allConditions[$x]['value']);
                }
            }
        }
        
        return $result;
    }

    /**
     *
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
    public function getConditionResult($allConditions, SugarBean $moduleBean, $rule, $view, $action, $key, $result = false)
    {
        global $current_user;

        $ret = $this->getResult($allConditions, $moduleBean, $rule, $view, $action, $key, $result);
        
        $converted_res = '';
        if (isset($ret)) {
            $converted_res = $this->rulesHelper->getConvertedRes($ret);
        }
        LoggerManager::getLogger()->info('SharedSecurityRules: Exiting getConditionResult() with result: ' . $converted_res);
        
        return $ret;
    }
}
