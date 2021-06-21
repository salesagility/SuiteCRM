<?php
/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

require_once __DIR__ . '/../../../MassUpdate.php';
require_once __DIR__ . '/../../Services/DateTime/DateFormatService.php';

/**
 * Class MassUpdatePort
 * Port of SugarController::action_massupdate and MassUpdate
 */
class MassUpdatePort extends MassUpdate
{
    /**
     * @var SugarBean
     */
    public $sugarbean;

    /**
     * @var DateFormatService
     */
    protected $dateFormatService;

    public function __construct()
    {
        $this->dateFormatService = new DateFormatService();
    }

    /**
     * @param array $inputs
     * @return array
     */
    public function run(array $inputs): array
    {
        $seed = BeanFactory::newBean($inputs['module']);
        $this->setSugarBean($seed);

        if (!$this->sugarbean->ACLAccess('save')) {
            return [
                'success' => false,
                'messages' => ['LBL_BULK_ACTION_MASS_UPDATE_NO_ACLS'],
                'debug' => ["No acls to save record for module '" . $inputs['module'] . "'"]
            ];
        }

        if (empty($this->sugarbean)) {
            return [
                'success' => false,
                'messages' => ['LBL_UNEXPECTED_ERROR'],
                'debug' => ["Bean not loaded properly '" . $inputs['module'] . "'"]
            ];
        }


        // Taken from SugarController::action_massupdate
        set_time_limit(0);
        DBManagerFactory::getInstance()::setQueryLimit(0);

        return $this->runMassUpdate($inputs);
    }

    /**
     * Executes the massupdate form
     * @param array $inputs to display in the popup window
     * @return array feedback
     */
    public function runMassUpdate(array $inputs): array
    {
        require_once __DIR__ . '/../../../formbase.php';
        global $current_user, $db, $disable_date_format;

        $this->parseInputs($inputs);

        $feedback = [
            'success' => true,
            'messages' => [],
            'debug' => [],
            'updated' => []
        ];
        $updateRecords = [];

        //We need to disable_date_format so that date values for the beans remain in database format
        //notice we make this call after the above section since the calls to TimeDate class there could wind up
        //making it's way to the UserPreferences objects in which case we want to enable the global date formatting
        //to correctly retrieve the user's date format preferences
        $old_value = $disable_date_format;
        $disable_date_format = true;

        $this->setIdsToUpdate($inputs, $db);

        if (!isset($inputs['mass']) || !is_array($inputs['mass'])) {
            $feedback['messages'][] = 'LBL_BULK_ACTION_MASS_UPDATE_NO_RECORDS';
            $feedback['debug'][] = ['No records to update'];
            $feedback['success'] = false;

            return $feedback;
        }

        $count = 0;

        foreach ($inputs['mass'] as $id) {
            if (empty($id)) {
                continue;
            }

            if (isset($inputs['Delete'])) {
                $this->sugarbean->retrieve($id);
                if ($this->sugarbean->ACLAccess('Delete')) {
                    $this->sugarbean->mark_deleted($id);
                }
                continue;
            }

            $this->handleContactsSync($inputs, $id, $feedback);

            if ($count++ !== 0) {
                //Create a new instance to clear values and handle additional updates to bean's 2,3,4...
                $className = get_class($this->sugarbean);
                $this->sugarbean = new $className();
            }

            $this->sugarbean->retrieve($id);

            if (!$this->sugarbean->ACLAccess('Save')) {
                $feedback['debug'][] = "No save acls for '$id'. not updating";
                continue;
            }

            $inputs['record'] = $id;
            $newbean = $this->sugarbean;

            $check_notify = false;

            if (isset($this->sugarbean->assigned_user_id)) {
                $old_assigned_user_id = $this->sugarbean->assigned_user_id;
                if (!empty($inputs['assigned_user_id'])
                    && ($old_assigned_user_id != $inputs['assigned_user_id'])
                    && ($inputs['assigned_user_id'] != $current_user->id)
                ) {
                    $check_notify = true;
                }
            }

            //Call include/formbase.php, but do not call retrieve again
            $this->populateFromInputs($inputs, '', $newbean);
            $newbean->save_from_post = false;

            if (!isset($inputs['parent_id'])) {
                $newbean->parent_type = null;
            }

            $this->updateDynamicEnums($newbean);

            $updateRecords[] = $newbean->id;
            $newbean->save($check_notify);
            $this->updateEmailAddress($inputs);
        }

        $disable_date_format = $old_value;

        $feedback['updated'] = $updateRecords;


        $feedback['messages'] = ['LBL_BULK_ACTION_MASS_UPDATE_PARTIAL_SUCCESS'];

        if (count($updateRecords) === count($inputs['mass'])) {
            $feedback['messages'] = ['LBL_BULK_ACTION_MASS_UPDATE_SUCCESS'];
        }

        return $feedback;
    }

    /**
     * @param $inputs
     */
    protected function parseInputs(&$inputs): void
    {
        foreach ($inputs as $field => $value) {
            $definition = $this->sugarbean->field_defs[$field] ?? [];
            $type = $definition['type'] ?? '';
            $customType = $definition['custom_type'] ?? '';
            $dbType = $definition['dbType'] ?? '';

            if (is_array($value) && empty($value)) {
                unset($inputs[$field]);

            } elseif ($value === '') {

                if ($type === 'radioenum' && isset($inputs[$field])) {
                    $inputs[$field] = '';
                } else {
                    unset($inputs[$field]);
                }
            }

            if (!is_string($value) || empty($definition)) {
                continue;
            }

            if ($type === 'bool' || $customType === 'bool') {

                if (strcmp($value, '2') === 0) {
                    $inputs[$field] = 0;
                }

                if (strcmp($dbType, 'varchar') === 0) {
                    if (strcmp($value, '1') === 0) {
                        $inputs[$field] = 'on';
                    }
                    if (strcmp($value, '2') === 0) {
                        $inputs[$field] = 'off';
                    }
                }
            }

            if (
                ($type === 'radioenum' && isset($inputs[$field]) && $value === '') ||
                ($type === 'enum' && $value === '__SugarMassUpdateClearField__') // Set to '' if it's an explicit clear
            ) {
                $inputs[$field] = '';
            }

            if ($type === 'bool') {
                $this->checkClearField($field, $value);
            }

            if ($type === 'date' && !empty($value)) {
                $inputs[$field] = $this->dateFormatService->toDBDate($value);
            }

            if ($type === 'datetime' && !empty($value)) {
                $inputs[$field] = $this->dateFormatService->toDBDateTime($value);
            }

            if ($type === 'datetimecombo' && !empty($value)) {
                $inputs[$field] = $this->dateFormatService->toDBDateTime($value);
            }
        }
    }

    /**
     * Calculate and set upds to update;
     * @param array $inputs
     * @param DBManager $db
     */
    protected function setIdsToUpdate(array &$inputs, DBManager $db): void
    {
        if (!empty($inputs['uid'])) {
            $inputs['mass'] = explode(',', $inputs['uid']);

            return;
        } // coming from listview

        if (isset($inputs['entire']) && empty($inputs['mass'])) {
            $order_by = '';

            // TODO: define filter array here to optimize the query
            // by not joining the unneeded tables
            $query = $this->sugarbean->create_new_list_query(
                $order_by,
                $this->where_clauses,
                array(),
                array(),
                0,
                '',
                false,
                $this,
                true,
                true
            );
            $result = $db->query($query, true);
            $new_arr = array();
            while ($val = $db->fetchByAssoc($result, false)) {
                $new_arr[] = $val['id'];
            }
            $inputs['mass'] = $new_arr;
        }
    }

    /**
     * Handle contact sync flag
     * @param array $inputs
     * @param string $id
     * @param array $feedback
     */
    protected function handleContactsSync(array $inputs, string $id, array &$feedback): void
    {
        global $current_user;
        if ($this->sugarbean->object_name !== 'Contact' || !isset($inputs['Sync'])) {
            return;
        }
        $this->sugarbean->retrieve($id);
        if (!$this->sugarbean->ACLAccess('Save')) {
            $feedback['debug'][] = 'No save acls for saving';
        }

        if ($inputs['Sync']) {
            $feedback['debug'][] = 'Sync set to true. Updating sync. saving';
            $this->sugarbean->contacts_users_id = $current_user->id;
            $this->sugarbean->save(false);

            return;
        }

        $users = $this->sugarbean->users;
        if (isset($users)) {
            $this->sugarbean->load_relationship('user_sync');
        }

        $this->sugarbean->contacts_users_id = null;
        $this->sugarbean->user_sync->delete($this->sugarbean->id, $current_user->id);
        $feedback['debug'][] = "Sync set to false. Deleted user sync. Unset 'contacts_users_id'";
    }

    /**
     * Populating inputs
     *
     * @param array $inputs of name of fields
     * @param string $prefix of name of fields
     * @param SugarBean $focus bean
     */
    protected function populateFromInputs(array $inputs, string $prefix, SugarBean $focus): void
    {
        global $current_user, $log;

        if (!empty($inputs['assigned_user_id']) &&
            ($focus->assigned_user_id !== $inputs['assigned_user_id']) &&
            ($inputs['assigned_user_id'] !== $current_user->id)) {
            $GLOBALS['check_notify'] = true;
        }

        require_once __DIR__ . '/../../../SugarFields/SugarFieldHandler.php';
        $sfh = new SugarFieldHandler();

        foreach ($focus->field_defs as $field => $def) {
            if ($field === 'id' && !empty($focus->id)) {
                // Don't try and overwrite the ID
                continue;
            }

            $type = !empty($def['custom_type']) ? $def['custom_type'] : $def['type'];
            $sf = $sfh::getSugarField($type);
            if ($sf !== null) {
                $sf->save($focus, $inputs, $field, $def, $prefix);
            } else {
                $log->fatal("Field '$field' does not have a SugarField handler");
            }
        }

        foreach ($focus->additional_column_fields as $field) {
            $key = $prefix . $field;
            if (isset($inputs[$key])) {
                $value = $inputs[$key];
                $focus->$field = $value;
            }
        }
    }

    /**
     * Update dynamic enums
     * @param SugarBean $newbean
     */
    protected function updateDynamicEnums(SugarBean $newbean): void
    {
        global $app_list_strings;

        // Mass update the cases, and change the state value from open to close,
        // Status value can still display New, Assigned, Pending Input (even though it should not)
        foreach ($newbean->field_name_map as $field_name) {
            $type = $field_name['type'] ?? '';
            $parentenum = $field_name['parentenum'] ?? '';
            if ($type !== 'dynamicenum' || $parentenum === '') {
                continue;
            }

            $parentenum_name = $field_name['parentenum'];
            // Updated parent field value.
            $parentenum_value = $newbean->$parentenum_name;

            $dynamic_field_name = $field_name['name'];
            // Dynamic field set value.
            [$dynamic_field_value] = explode('_', $newbean->$dynamic_field_name);

            if ($parentenum_value !== $dynamic_field_value) {

                // Change to the default value of the correct value set.
                $defaultValue = '';
                foreach ($app_list_strings[$field_name['options']] as $key => $value) {
                    if (strpos($key, $parentenum_value) === 0) {
                        $defaultValue = $key;
                        break;
                    }
                }
                $newbean->$dynamic_field_name = $defaultValue;
            }
        }
    }

    /**
     * Update email address
     * @param array $inputs
     */
    protected function updateEmailAddress(array $inputs): void
    {
        // get primary address id
        $email_address_id = $this->getPrimaryEmailAddressId();

        if (empty($email_address_id)) {
            return;
        }

        [$setOptOutPrimaryEmailAddress, $optout_flag_value] = $this->getOptout($inputs);

        /** @var EmailAddress $primaryEmailAddress */
        $primaryEmailAddress = BeanFactory::getBean('EmailAddresses', $email_address_id);
        if ($setOptOutPrimaryEmailAddress) {
            $primaryEmailAddress->opt_out = (bool)$optout_flag_value;
        }

        [$setOptInPrimaryEmailAddress, $optin_flag_value] = $this->getOptin($inputs);
        if ($setOptInPrimaryEmailAddress) {
            if ($optin_flag_value === true) {
                $primaryEmailAddress->OptIn();
            } else {
                $primaryEmailAddress->resetOptIn();
            }
        }
        $primaryEmailAddress->save();
    }

    /**
     * Get primary address id
     * @return string|null
     */
    protected function getPrimaryEmailAddressId(): ?string
    {
        $emailAddressId = '';
        $emailAddress = $this->sugarbean->emailAddress ?? null;
        if (!empty($emailAddress)) {
            foreach ($this->sugarbean->emailAddress->addresses as $emailAddressRow) {
                if ($emailAddressRow['primary_address'] === '1') {
                    $emailAddressId = $emailAddressRow['email_address_id'];
                    break;
                }
            }
        }

        return $emailAddressId;
    }

    /**
     * Get optout info
     * @param array $inputs
     * @return array
     */
    protected function getOptout(array $inputs): array
    {
        $setOptOutPrimaryEmailAddress = false;
        $optout_flag_value = false;
        if (!empty($inputs['optout_primary'])) {
            $setOptOutPrimaryEmailAddress = true;
            $optout_flag_value = true;
        }

        return [$setOptOutPrimaryEmailAddress, $optout_flag_value];
    }

    /**
     * Get optin info
     * @param array $inputs
     * @return array
     */
    protected function getOptin(array $inputs): array
    {
        $setOptInPrimaryEmailAddress = false;
        $optin_flag_value = false;
        if (!empty($inputs['optin_primary'])) {
            $setOptInPrimaryEmailAddress = true;
            $optin_flag_value = true;
        }

        return [$setOptInPrimaryEmailAddress, $optin_flag_value];
    }
}
