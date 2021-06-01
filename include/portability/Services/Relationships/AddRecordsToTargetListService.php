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


/**
 * Class AddRecordsToTargetListService
 */
class AddRecordsToTargetListService
{

    /**
     * Add records to target list
     * @param string $baseModule - module name
     * @param array $baseIds - selected record ids
     * @param string $modalModule - modal module name
     * @param string $modalId - modal selected record id
     * @return array with feedback
     */
    public function run(
        string $baseModule,
        array $baseIds,
        string $modalModule,
        string $modalId
    ): array
    {
        global $beanList;

        if (empty($baseIds) || empty($modalModule) || empty($modalId)) {
            return [
                'success' => false,
                'message' => 'LBL_RECORD_NOT_FOUND'
            ];
        }

        if (empty($baseModule) || empty($beanList[$baseModule])) {
            return [
                'success' => false,
                'message' => 'LBL_MODULE_NOT_FOUND'
            ];
        }

        $bean = BeanFactory::newBean($baseModule);

        if (!$bean) {
            return [
                'success' => false,
                'message' => 'LBL_RECORD_NOT_FOUND'
            ];
        }

        $result = $this->linkRecordsToTargetList($bean, $baseIds, $modalModule, $modalId);

        if ($result === false) {
            return [
                'success' => false,
                'message' => 'LBL_ADD_RECORDS_TO_TARGET_LIST_FAILED'
            ];
        }

        return [
            'success' => true,
            'message' => 'LBL_ADD_RECORDS_TO_TARGET_LIST_SUCCESS'
        ];

    }

    /**
     * Link records to target list
     * @param SugarBean|null $bean - bean object of base module
     * @param array $beanIds
     * @param string $modalModule
     * @param string $modalId
     * @return bool
     */
    protected function linkRecordsToTargetList(
        SugarBean $bean,
        array $beanIds,
        string $modalModule,
        string $modalId
    ): bool
    {
        $result = true;
        $relationship = '';
        foreach ($bean->get_linked_fields() as $field => $def) {
            if ($bean->load_relationship($field) && $bean->$field->getRelatedModuleName() === $modalModule) {
                $relationship = $field;
                break;
            }
        }

        if (empty($relationship)) {
            return false;
        }

        foreach ($beanIds as $id) {
            $bean->retrieve($id);

            $bean->load_relationship($relationship);
            $result = $bean->{$relationship}->add($modalId);
            $bean->save();
        }
        return $result;
    }

}
