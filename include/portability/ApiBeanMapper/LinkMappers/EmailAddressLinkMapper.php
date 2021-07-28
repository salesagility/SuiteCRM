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

require_once __DIR__ . '/LineItemMapper.php';

class EmailAddressLinkMapper extends LineItemMapper
{
    public const MODULE = 'EmailAddress';

    /**
     * @inheritDoc
     */
    public static function getField(): string
    {
        return 'all';
    }

    /**
     * @inheritDoc
     */
    public static function getRelateModule(): string
    {
        return self::MODULE;
    }

    /**
     * @inheritDoc
     */
    public static function getModule(): string
    {
        return 'default';
    }

    /**
     * @inheritDoc
     */
    protected function getItemBeans(SugarBean $bean, array $definition): array
    {
        $addresses = $bean->emailAddress->addresses ?? [];

        /** @var SugarBean[] $beans */
        $beans = [];

        foreach ($addresses as $address) {
            $itemBean = new EmailAddress();

            if ($itemBean === null) {
                continue;
            }

            $itemBean->populateFromRow($address);
            $itemBean->primary_address = (bool)($address['primary_address'] ?? false);
            $itemBean->reply_to_address = (bool)($address['reply_to_address'] ?? false);

            $beans[] = $itemBean;
        }

        return $beans;
    }

    /**
     * @inheritDoc
     */
    protected function isLineItem(SugarBean $bean, string $name): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function mapItem(SugarBean $itemBean): array
    {
        $attributes = parent::mapItem($itemBean);

        $attributes['primary_address'] = $itemBean->primary_address;
        $attributes['reply_to_address'] = $itemBean->reply_to_address;

        return $attributes;
    }

    /**
     * @inheritDoc
     */
    protected function buildItemBean(string $module, $item)
    {
        $itemBean = new EmailAddress();
        $id = $item['attributes']['id'] ?? '';
        if (!empty($id)) {
            $itemBean->retrieve($id);
        }
        $itemBean->primary_address = $item['attributes']['primary_address'] ?? false;
        $itemBean->reply_to_address = $item['attributes']['reply_to_address'] ?? false;

        return $itemBean;
    }
}
