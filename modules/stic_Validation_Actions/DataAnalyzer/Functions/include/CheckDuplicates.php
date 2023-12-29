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
 * Class to look for duplicates
 */
class checkDuplicates extends DataCheckFunction
{

    /**
     * It receives a proposal from SQL and modifies it with the necessary features for the function.
     * Most functions should override this method.
     * @param $actionBean Bean of the action the function is running on.
     * @param $proposedSQL Automatically generated array (if possible) with the keys select, from, where and order_by.
     * @return string
     */
    public function prepareSQL(stic_Validation_Actions $actionBean, $proposedSQL)
    {
        $last_execution = '';
        if ($this->selector == DataCheckFunction::SELECTOR_INCREMENTAL && !empty($actionBean->last_execution)) {
            global $timedate, $current_user;
            $timeformat = $timedate->get_date_time_format($current_user);
            $last_execution = $timedate->fromUser($actionBean->last_execution, $current_user)->asDB();
            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": Last execution date [{$actionBean->last_execution}] Format [{$timeformat}].");
        }
            
        // Gather the necessary data to create the query that will identify the duplicate records in the Contacts or Organizations module
        if ($this->module === 'Contacts') {
            $name = "CONCAT(a.first_name, ' ', a.last_name)";
        } else {
            // Accounts
            $name = 'a.name';
        }

        $field = $this->fieldToValidate;
        $bean = BeanFactory::getBean($this->module);

        $sql = "SELECT
                    GROUP_CONCAT($name SEPARATOR '||') AS 'name',
                    GROUP_CONCAT(a.id SEPARATOR '||') AS 'ids',
                    lpad(b.$field,9,'0') as 'id_key',
                    '$field'
                FROM
                    $bean->table_name a
                JOIN " . $bean->table_name . "_cstm b ON
                    b.id_c = a.id
                WHERE
                    a.deleted = 0
                    AND TRIM(b.$field) != ''
                    AND b.$field IS NOT NULL";

        if ($this->selector == DataCheckFunction::SELECTOR_INCREMENTAL){
            $sql.= "
                    AND date_modified > '$last_execution'";
        } 
        
        $sql.= "
                GROUP BY id_key
                HAVING COUNT(b.$field) > 1";

        return $sql;
    }

    /**
     * DoAction function
     * Perform the action defined in the function
     * @param $records Set of records on which the validation action is to be applied 
     * @param $actionBean stic_Validation_Actions Bean of the action in which the function is being executed.
     * @return boolean Return will enter true in case of success and false in case of error.
     */
    public function doAction($records, stic_Validation_Actions $actionBean)
    {
        global $sugar_config;
        $field = $this->fieldToValidate;
        $duplicated = false;
        $dupRows = 0;
        
        while ($row = array_pop($records)) 
        {
            $duplicated = true;
            $title = $this->getLabel('POSSIBLE_DUP') . translate('LBL_' . strtoupper(substr($field, 0, strlen($field) - 2)), $this->module) . ": " . $row['id_key'];
            $duplicated_ids = explode('||', $row['ids']);
            
            // Build error message
            $errorMsg = '<div><span style="color:red;">' . $title . '</span><br />';
            $errorMsg .= '<a style="text-decoration:none" href="' . $sugar_config["site_url"] . '/index.php?module=' . $this->module . '&action=index&query=true&searchFormTab=advanced_search&' . $this->fieldToValidate . '_advanced=' . $row["id_key"] . '"><span class="suitepicon suitepicon-action-list-maps" style="font-size:12px">&nbsp;&nbsp;</span><span> ' . $this->getLabel("LIST_VIEW") . '</span></a><br />';
            $errorMsg .= '<ul style="margin-top:2%">';
            foreach ($duplicated_ids as $key => $id) {
                $bean = BeanFactory::getBean($this->module, $id);
                // if the name field is not filled, we indicate the ID field
                $nombre = $bean->name ? $bean->name : $bean->id;
                $errorMsg .= '<li>- <a style="text-decoration:none" href="' . $sugar_config["site_url"] . '/index.php?module=' . $this->module . '&return_module=' . $this->module . '&action=DetailView&record=' . $id . '">' . $nombre . '</a></li>';
                $dupRows++;
            }
            $errorMsg .= '</ul></div>';

            $data = array(
                'name' => $this->getLabel('NAME') . ' [' . $row["id_key"] . ']',
                'stic_validation_actions_id' => $actionBean->id,
                'log' => $errorMsg,
                'assigned_user_id' => $bean->assigned_user_id,
            );
            $this->logValidationResult($data);
        }

        // Report_always
        if (!$duplicated && $actionBean->report_always) {
            global $current_user;
            $errorMsg = $this->getLabel('NO_DUPLICATED');
            $data = array(
                'name' => $this->getLabel('NAME') . $errorMsg,
                'stic_validation_actions_id' => $actionBean->id,
                'log' => '<div>' . $errorMsg  . '</div>',
                'reviewed' => 'not_necessary',   
                'assigned_user_id' => $current_user->id, // In this message we indicate the administrator user
            );
            $this->logValidationResult($data);
        }
        $GLOBALS['log']->info('Line ' . __LINE__ . ': ' . __METHOD__ . ": [{$duplicated}] duplicates detected with [{$dupRows}] records involved.");
        return true;
    }
}
