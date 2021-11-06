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

require_once __DIR__ . '/LineItemsSaveHandlerInterface.php';

class DefaultLineItemsSaveHandler implements LineItemsSaveHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function getModule(): string
    {
        return 'default';
    }


    /**
     * @inheritDoc
     */
    public function getRelateModule(): string
    {
        return 'default';
    }

    /**
     * @inheritDoc
     */
    public function getField(): string
    {
        return 'all';
    }

    /**
     * @inheritDoc
     */
    public function save(SugarBean $bean, string $field): void
    {
        /** @var SugarBean[] */
        $entries = $bean->line_item_entries[$field] ?? [];

        if (empty($entries)) {
            return;
        }

        $lineItemDefinition = $bean->field_defs[$field] ?? [];
        $removalType = $lineItemDefinition['removal-type'] ?? 'unlink';
        $relationship = $lineItemDefinition['relationship'] ?? '';
        $joinFieldsDefinitions = $this->getJoinFieldDefinitions($bean, $relationship);

        if ($lineItemDefinition['type'] !== 'link'  || !$bean->load_relationship($field)) {
            return;
        }

        foreach ($entries as $entry) {
            if (empty($entry)) {
                continue;
            }

            if ($entry->deleted) {
                $this->remove($bean, $entry, $field, $removalType);
                continue;
            }

            $this->add($bean, $entry, $field, $joinFieldsDefinitions);
        }
    }

    /**
     * Remove Line Item
     * @param SugarBean $bean
     * @param SugarBean $entry
     * @param string $linkField
     * @param string $removalType
     */
    protected function remove(SugarBean $bean, SugarBean $entry, string $linkField, string $removalType): void
    {
        if ($removalType === 'delete') {
            $entry->mark_deleted($entry->id);

            return;
        }

        /** @var Link2 $link */
        $link = $bean->$linkField;

        $link->remove([$entry]);
    }

    /**
     * Add line item
     * @param SugarBean $bean
     * @param SugarBean $entry
     * @param string $linkField
     * @param array $joinFieldsDefinitions
     */
    protected function add(SugarBean $bean, SugarBean $entry, string $linkField, array $joinFieldsDefinitions): void
    {
        $joinFields = $this->getJoinFields($bean, $joinFieldsDefinitions);
        /** @var Link2 $link */
        $link = $bean->$linkField;

        $link->add([$entry], $joinFields);
    }

    /**
     * Get join fields definitions
     * @param SugarBean $bean
     * @param string $relationship
     * @return array
     */
    protected function getJoinFieldDefinitions(SugarBean $bean, string $relationship): array
    {
        if (empty($bean->field_defs)) {
            return [];
        }

        $joinFields = [];

        foreach ($bean->field_defs as $definition) {
            $fieldRelationship = $definition['relationship'] ?? '';
            $isJoinField = $definition['join-field'] ?? false;

            if ($fieldRelationship === $relationship && $isJoinField) {
                $joinFields[] = $definition;
            }
        }

        return $joinFields;
    }

    /**
     * Get join fields
     * @param SugarBean|null $bean
     * @param array $definitions
     * @return array
     */
    protected function getJoinFields(?SugarBean $bean, array $definitions): array
    {
        if ($bean === null || empty($definitions)) {
            return [];
        }

        $joinFields = [];

        foreach ($definitions as $definition) {
            $name = $definition['name'] ?? '';

            if ($name === '') {
                continue;
            }

            $joinFields[$name] = $bean->$name;
        }

        return $joinFields;
    }
}
