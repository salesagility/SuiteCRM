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


class stic_Work_Experience extends Basic
{
    public $new_schema = true;
    public $module_dir = 'stic_Work_Experience';
    public $object_name = 'stic_Work_Experience';
    public $table_name = 'stic_work_experience';
    public $importable = true;

    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $assigned_user_id;
    public $assigned_user_name;
    public $assigned_user_link;
    public $SecurityGroups;
    public $position_type;
    public $contract_type;
    public $workday_type;
    public $schedule;
    public $sector;
    public $subsector;
    public $achieved;
    public $position;
    public $start_date;
    public $end_date;
	
    public function bean_implements($interface)
    {
        switch($interface)
        {
            case 'ACL':
                return true;
        }

        return false;
    }
        /**
     * Override the bean's save function to assign an auto-incrementing value to the code field when a new record is created
     *
     * @param boolean $check_notify
     * @return void
     */
    public function save($check_notify = false)
    {
        $this->fillName();

        // Save the bean
        parent::save($check_notify);
    }

    protected function fillName()
    {
        // Auto name
        if (empty($this->name)) {
            global $app_list_strings;
            include_once 'SticInclude/Utils.php';

            $contactName = '';
            $contactBean = BeanFactory::getBean('Contacts', $this->stic_work_experience_contactscontacts_ida);
            if ($contactBean){
                $contactName = $contactBean->first_name . ' ' . $contactBean->last_name;
            }

            $this->name = $contactName . ' - ' . 
                $this->position
            . ' - ' .
                $app_list_strings['stic_work_experience_contract_types_list'][$this->contract_type];
        }
    }

	
}