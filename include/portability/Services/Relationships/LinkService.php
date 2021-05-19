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
 * Class LinkService
 * Port of include/generic/Save2.php
 * Accessing the above file directly is not possible
 */
class LinkService
{

    /**
     * Link related records for link field
     * @param string $module
     * @param string $record
     * @param string $linkField
     * @param string $linkedId
     * @return array with feedback
     */
    public function run(string $module, string $record, string $linkField, string $linkedId): array
    {
        global $beanList;

        //TODO handle special scenarios that are handled by Save2.php for Campaigns, target lists, documents etc

        if (empty($record) || empty($linkField) || empty($linkedId)) {
            return [
                'success' => false,
                'message' => 'LBL_RECORD_NOT_FOUND'
            ];
        }

        if (empty($module) || empty($beanList[$module])) {
            return [
                'success' => false,
                'message' => 'LBL_MODULE_NOT_FOUND'
            ];
        }

        $bean = BeanFactory::newBean($module);


        if (!$bean) {
            return [
                'success' => false,
                'message' => 'LBL_RECORD_NOT_FOUND'
            ];
        }

        $bean = $bean->retrieve($record);

        if (!$bean) {
            return [
                'success' => false,
                'message' => 'LBL_RELATIONSHIP_LOAD_ERROR'
            ];
        }

        if (!$bean->load_relationship($linkField)) {
            return [
                'success' => false,
                'message' => 'LBL_RELATIONSHIP_LOAD_ERROR'
            ];
        }

        $result = $this->link($bean, $linkField, $linkedId);

        if ($result === false) {
            return [
                'success' => false,
                'message' => 'LBL_LINK_RELATIONSHIP_FAILED'
            ];
        }

        return [
            'success' => true,
            'message' => 'LBL_LINK_RELATIONSHIP_SUCCESS'
        ];
    }

    /**
     * Link record for relationship link
     * @param SugarBean|null $bean
     * @param string $linkField
     * @param $linkedId
     * @return bool
     */
    protected function link(SugarBean $bean, string $linkField, string $linkedId): bool
    {
        $result = $bean->$linkField->add($linkedId);
        $bean->save();

        return $result === true;
    }
}
