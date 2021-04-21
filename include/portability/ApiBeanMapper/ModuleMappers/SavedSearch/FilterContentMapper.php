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

/* @noinspection PhpIncludeInspection */
require_once 'include/portability/ApiBeanMapper/FieldMappers/FieldMapperInterface.php';

class FilterContentMapper implements FieldMapperInterface
{
    public const FIELD_NAME = 'contents';

    /**
     * {@inheritDoc}
     */
    public static function getField(): string
    {
        return self::FIELD_NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function run(SugarBean $bean, array &$container, string $alternativeName = ''): void
    {
        $name = self::FIELD_NAME;

        if (!empty($alternativeName)) {
            $name = $alternativeName;
        }

        if ('SavedSearch' !== $bean->object_name) {
            $container[$name] = [];

            return;
        }

        if (empty($bean->contents)) {
            $container[$name] = [];

            return;
        }

        $container[$name] = $this->parseContent($bean->name, $bean->contents);
    }

    /**
     * Parse base64 encoded contents and convert to api format
     * @param string $filterName
     * @param string $serializedContents
     * @return array
     */
    public function parseContent(string $filterName, string $serializedContents): array
    {
        $contents = unserialize(base64_decode($serializedContents), ['allowed_classes' => true]);
        unset(
            $contents['searchFormTab'],
            $contents['query'],
            $contents['search_module'],
            $contents['saved_search_action'],
            $contents['displayColumns'],
            $contents['hideTabs'],
            $contents['orderBy'],
            $contents['sortOrder'],
            $contents['advanced']
        );

        $newContents = [
            'name' => $filterName,
            'filters' => []
        ];
        foreach ($contents as $key => $item) {
            if (empty($contents[$key])) {
                continue;
            }

            $newkey = str_replace('_advanced', '', $key);
            $values = $item;

            if (is_string($item)) {
                $values = [$item];
            }

            $newContents['filters'][$newkey] = [
                'field' => $newkey,
                'operator' => '=',
                'values' => $values
            ];
        }

        return $newContents;
    }
}
