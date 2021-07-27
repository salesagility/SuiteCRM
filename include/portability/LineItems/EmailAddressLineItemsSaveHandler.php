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

class EmailAddressLineItemsSaveHandler implements LineItemsSaveHandlerInterface
{
    public const MODULE = 'EmailAddresses';

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
        return self::MODULE;
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

        /** @var SugarEmailAddress $emailAddress */
        $emailAddress = $bean->emailAddress ?? null;

        if (empty($entries) || $emailAddress === null) {
            return;
        }

        $emailAddress->addresses = [];

        foreach ($entries as $entry) {
            if (empty($entry)) {
                continue;
            }

            if ($entry->deleted) {
                $this->remove($bean, $entry, 'unlink');
                continue;
            }

            $this->add($bean, $entry);
        }

        $emailAddress->saveEmail(
            $bean->id,
            $bean->module_dir,
            '',
            '',
            '',
            '',
            '',
            $bean->in_workflow
        );
    }

    /**
     * Remove Line Item
     * @param SugarBean $bean
     * @param SugarBean $entry
     * @param string $removalType
     */
    protected function remove(SugarBean $bean, SugarBean $entry, string $removalType): void
    {
        if (empty($entry->id)) {
            return;
        }

        if ($removalType === 'delete') {
            $entry->mark_deleted($entry->id);
        }
    }

    /**
     * Add line item
     * @param SugarBean $bean
     * @param SugarBean $entry
     */
    protected function add(SugarBean $bean, SugarBean $entry): void
    {
        /** @var EmailAddress $address */
        $address = $entry;

        /** @var SugarEmailAddress $emailAddress */
        $emailAddress = $bean->emailAddress;

        $emailAddress->addAddress(
            $address->email_address ?? '',
            $this->isTrue($address->primary_address ?? false),
            $this->isTrue($address->reply_to_address ?? false),
            $this->isTrue($address->invalid_email ?? false),
            $this->isTrue($address->opt_out ?? false),
            $address->id ?? null,
            $address->confirm_opt_in ?? null
        );
    }

    /**
     * @param $value
     * @return bool
     */
    protected function isTrue($value): bool
    {
        return in_array($value, [true, 'true', '1', 1], true);
    }

}
