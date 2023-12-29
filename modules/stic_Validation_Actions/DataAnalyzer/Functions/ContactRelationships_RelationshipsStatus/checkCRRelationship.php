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
class checkCRRelationship extends DataCheckFunction 
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

        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Loading relationship with contacts ...");
        $rp->load_relationship('stic_contacts_relationships_contacts');
        $rel = $rp->stic_contacts_relationships_contacts->getRelationshipObject();

        return "SELECT distinct id FROM
                (
                    (SELECT distinct {$rel->rhs_table}.{$rel->rhs_key} as id
                        FROM {$rel->rhs_table}
                        LEFT JOIN {$rel->join_table} ON {$rel->rhs_table}.{$rel->rhs_key} = {$rel->join_table}.{$rel->join_key_rhs} and {$rel->join_table}.deleted = 0
                        WHERE {$rel->rhs_table}.deleted = 0 and TRIM(COALESCE({$rel->join_table}.{$rel->join_key_lhs}, '')) = ''
                    )
                    UNION
                    (SELECT distinct {$rel->rhs_table}.id
                        FROM (
                        SELECT distinct {$rel->join_key_rhs} as id
                            FROM {$rel->join_table}
                            LEFT JOIN {$rel->lhs_table} ON {$rel->join_table}.{$rel->join_key_lhs} = {$rel->lhs_table}.{$rel->lhs_key} and {$rel->lhs_table}.deleted = 0
                            WHERE {$rel->join_table}.deleted = 0 and TRIM(COALESCE({$rel->lhs_table}.{$rel->lhs_key}, '')) = ''
                        ) as WRONG_IDS_IN_RELATIONSHIP_TABLE
                        INNER JOIN {$rel->rhs_table} ON WRONG_IDS_IN_RELATIONSHIP_TABLE.id = {$rel->rhs_table}.{$rel->rhs_key}
                        WHERE {$rel->rhs_table}.deleted = 0
                    )
                ) as WRONG_IDS";
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

        // We will receive the data only of the wrong forms of payment
        while ($row = array_pop($records)) 
        {
            // Check if you have to take any action or inform
            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Contact relationship record does not have a relationship with any person: [{$this->module}] [{$row['id']}]");
            $bean = BeanFactory::getBean($this->module, $row['id']);
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
            $count++; // Records Processed
        }

        $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ": [{$count}] Contact Relationship  without Contact.");

        // Report_always
        if (!$count && $actionBean->report_always) 
        {
            global $current_user;
            $errorMsg = $this->getLabel('NO_ROWS');
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