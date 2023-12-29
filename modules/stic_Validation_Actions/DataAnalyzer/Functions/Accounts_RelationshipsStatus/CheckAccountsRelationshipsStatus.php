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
class CheckAccountsRelationshipsStatus extends DataCheckFunction
{
    // Contains the FieldDefs of the Organization class
    protected $accountDef = null;

    public function __construct($functionDef)
    {
        parent::__construct($functionDef);
        $bean = BeanFactory::getBean('Accounts');
        $this->accountDef = $bean->field_defs;
    }

    /**
     * Receive an SQL proposal and modify it with the particularities necessary for the function.
     * Most functions should overwrite this method.
     * @param $actionBean Bean of the action in which the function is being executed.
     * @param $proposedSQL Array generated automatically (if possible) with the keys select, from, where and order_by.
     * @return string
     */
    public function prepareSQL(stic_Validation_Actions $actionBean, $proposedSQL)
    {
        // Create the query to retrieve the data of those organizations that must update the type of relationship

        //-- 1) First we show the active relationships
        $sql = "SELECT
					c.id id,
					if(
					c_cstm.stic_relationship_type_c = '' || c_cstm.stic_relationship_type_c IS NULL,
					'^^',
					c_cstm.stic_relationship_type_c
					) actuales,
					-- We always return ^^ in case of null or '' to be able to compare later
					replace(
					replace(
						if(
						max(status) = 1,
						GROUP_CONCAT(
							DISTINCT if(
							status = 1,
							concat('^', tiposrel.relationship_type, '^'),
							'@'
							)
							ORDER BY
							tiposrel.relationship_type ASC
						),
						'^^'
						),
						'@,',
						''
					),
					',@',
					''
					) activas -- We use the @ character to be able to replace later and show it the same as it is in People
				FROM accounts c
				JOIN accounts_cstm c_cstm ON c.id = c_cstm.id_c
				JOIN (
					-- We use a subquery that returns ONLY the existing relationships, active or not, indicating in the field state 1 if the relationship is active, 0 if it is not
					SELECT
						rel.stic_accounts_relationships_accountsaccounts_ida AS organizacion,
						h.relationship_type,
						if(
						(
							(
							(
								isnull(h.start_date)
								OR h.start_date = ''
							)
							AND (
								isnull(h.end_date)
								OR h.end_date = ''
							)
							)
							OR (
							(
								isnull(h.start_date)
								OR h.start_date = ''
							)
							AND h.end_date >= CURRENT_DATE()
							)
							OR (
							(
								isnull(h.end_date)
								OR h.end_date = ''
							)
							AND h.start_date <= CURRENT_DATE()
							)
							OR (
							CURRENT_DATE() BETWEEN h.start_date
							AND h.end_date
							)
						),
						'1',
						'0'
						) status
					FROM stic_accounts_relationships h
					JOIN stic_accounts_relationships_accounts_c rel ON h.id = rel.stic_accoub36donships_idb
					-- JOIN stic_accounts_relationships_cstm h_custom ON h.id = h_custom.id_c
					WHERE
						h.deleted = 0
						AND rel.deleted = 0
					ORDER BY
						rel.stic_Accounts_Relationships_accountsaccounts_ida,
						h.relationship_type
					) tiposrel ON tiposrel.organizacion = c.id
				WHERE
					c.deleted = 0
				GROUP BY
					c.id
				HAVING
					(actuales != activas) -- 2) Secondly, we join a query that gives us back organizations that have something indicated in relationship type, but that have no related record in redk_relacion accounts, or that is deleted = 0
				UNION
				SELECT
					id AS organizacion,
					stic_relationship_type_c,
					'^^' activas
				FROM (
					SELECT
						c.id,
						c_cstm.stic_relationship_type_c,
						min(ifnull(h.deleted, 1)) e
					FROM accounts c
					JOIN accounts_cstm c_cstm ON c_cstm.id_c = c.id
					LEFT JOIN stic_accounts_relationships_accounts_c c_rel ON c_rel.stic_Accounts_Relationships_accountsaccounts_ida = c.id
					LEFT JOIN stic_accounts_relationships h ON h.id = c_rel.stic_accoub36donships_idb
					WHERE
						length(c_cstm.stic_relationship_type_c) > 2
						AND c.deleted = 0
					GROUP BY
						c.id
					) a
				WHERE
					e = 1";

        return $sql;
    }

    /**
     * Función doAction.
     * Realiza the action defined in the function
     * @param $records Set of records on which the validation action is to be applied 
     * @param $actionBean stic_Validation_Actions Bean of the action in which the function is being executed.
     * @return boolean It will return true in case of success and false in case of error.
     */
    public function doAction($records, stic_Validation_Actions $actionBean)
    {
        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Checking organizations with active relationships ...");
        $update_count = 0;
        while ($account_row = array_pop($records)) 
        {
            $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ": Inconsistency detected in stic_relationship_type_c field of the organization [{" . $account_row['id'] . "}].");
            if ($this->isEqualRelationshipType($this->decodeRelationshipType($account_row['activas']), $this->decodeRelationshipType($account_row['actuales']))) {
                $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": The values ​​of the relationship type field for the Organization [" . $account_row['id'] . "] they are messy");
                $this->updateSQLRelationshipType($account_row['id'], $account_row['activas'], $account_row['actuales']);
            } else {
                $this->updateBeanRelationshipType($account_row['id'], $account_row['activas'], $actionBean);
            }
            $update_count++;
        }

        $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ": [{$update_count}] Records with the type of relationship updated.");

        // Report_always
        if (!$update_count && $actionBean->report_always) {
            global $current_user;
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
     * Sort the relationship type field of the Organizations module using an SQL query. Since it is not a change that should activate an LH or Workflow
     */
    private function updateSQLRelationshipType($id, $newRelationshipType, $oldRelationshipType)
    {
        $db = DBManagerFactory::getInstance();
        $sql = "UPDATE accounts_cstm
					SET stic_relationship_type_c='$newRelationshipType'
					WHERE id_c='$id'";
        $db->query($sql);
        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Updating / sorting the values ​​of the relationship type field of [{$id}] [{$oldRelationshipType}] -> [{$newRelationshipType}]...");
    }

    /**
     * Update the person's data to modify the type of relationship
     */
    private function updateBeanRelationshipType($id, $newRelationshipType, $actionBean)
    {
        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Retrieving Organization data [{$id}]...");
        $org = BeanFactory::getBean('Accounts', $id);
        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Updating relationship type of [{$org->id} - {$org->name}] [{$org->stic_relationship_type_c}] -> [{$newRelationshipType}]...");
        
        // Update account
        $labelOldRelationshipType = $this->translatedRelationshipType($org->stic_relationship_type_c);
        $labelNewRelationshipType = $this->translatedRelationshipType($newRelationshipType);
        $org->stic_relationship_type_c = $newRelationshipType;
        $org->save();

        // Build error message
        $errorMsg = $this->getLabel('UPDATED') . "<br />- [{$labelOldRelationshipType}] -> [{$labelNewRelationshipType}]";
        $data = array(
            'name' => $this->getLabel('NAME') . ' - ' . $org->name,
            'stic_validation_actions_id' => $actionBean->id,
            'log' =>  '<div>' . $errorMsg . '</div>',
            'parent_type' => $this->functionDef['module'],
            'parent_id' => $org->id,
            'reviewed' => 'not_necessary',      
            'assigned_user_id' => $org->assigned_user_id,
        );
        $this->logValidationResult($data);
    }

    /**
     * Returns an array with the values ​​of the stic_relationship_type_c field
     * @param unknown $stic_relationship_type_c
     */
    private function decodeRelationshipType($stic_relationship_type_c)
    {
        return explode('^,^', trim($stic_relationship_type_c, '^'));
    }

    /**
     * Returns a string with the relationship type values
     * @param String $relationship_type
     */
    private function translatedRelationshipType($relationship_type)
    {
        global $app_list_strings;
        $arrRelationshipType = $this->decodeRelationshipType($relationship_type);
        if (empty($arrRelationshipType) || empty($arrRelationshipType[0])) {
            $label = $this->getLabel('EMPTY_REL');
            return $this->getLabel('EMPTY_REL');
        }

        $translated = array();
        $labelsArray = $app_list_strings[$this->accountDef['stic_relationship_type_c']['options']];
        foreach ($arrRelationshipType as $rel) {
            if (!isset($labelsArray[$rel])) {
                $translated[] = $this->getLabel('INVALID_VALUE') . " \"{$rel}\"";
            } else {
                $translated[] = $labelsArray[$rel];
            }
        }

        return trim(implode(', ', $translated), ', ');
    }

    /**
     * Indicates whether the value of the stic_relationship_type_c field is correct or not
     * @param Array $idxAccounts Array of indexed values
     * @param String $id User ID
     * @param Array $relationship_type Array with the values
     * @return boolean
     */
    private function isEqualRelationshipType($newRelationshipType, $oldRelationshipType)
    {
        // We have to verify that the two arrays are identical since there can be no more relationships in either of the two arrays
        sort($newRelationshipType);
        sort($oldRelationshipType);

        $str1 = implode('', $newRelationshipType);
        $str2 = implode('', $oldRelationshipType);
        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": [$str1 - $str2]");
        return $str1 == $str2;
    }
}
