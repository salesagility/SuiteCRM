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

require_once __DIR__  .'/../../../ApiBeanMapper/FieldMappers/FieldMapperInterface.php';
require_once __DIR__ . '/../../../ModuleNameMapper.php';
require_once __DIR__ . '/../../../FilterMapper/FilterMapper.php';

class FilterContentMapper implements FieldMapperInterface
{
    public const FIELD_NAME = 'contents';

    /**
     * @var ModuleNameMapper
     */
    protected $moduleNameMapper;

    /**
     * @var FilterMapper
     */
    protected $filterMapper;

    /**
     * RouteConverter constructor.
     */
    public function __construct()
    {
        $this->moduleNameMapper = new ModuleNameMapper();
        $this->filterMapper = new FilterMapper();
    }

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
    public function toApi(SugarBean $bean, array &$container, string $alternativeName = ''): void
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

        $contents = $this->parseContent($bean->name, $bean->contents);
        $container[$name] = $contents;

        $container['orderBy'] = $contents['orderBy'] ?? '';
        $container['sortOrder'] = $contents['sortOrder'] ?? '';
    }

    /**
     * @inheritDoc
     */
    public function toBean(SugarBean $bean, array &$container, string $alternativeName = ''): void
    {
        $contents = $container[self::getField()] ?? [];

        $legacyContents = [
            'searchFormTab' => 'advanced',
            'query' => '',
            'search_module' => '',
            'saved_search_action' => '',
            'displayColumns' => '',
            'hideTabs' => '',
            'orderBy' => '',
            'sortOrder' => '',
            'advanced' => ''
        ];

        if (!empty($bean->contents)) {
            $legacyContents = unserialize(base64_decode($bean->contents), ['allowed_classes' => true]);
        }

        if (empty($contents) || empty($contents['filters'])) {
            $container[self::getField()] = $this->encode($legacyContents);

            return;
        }

        $mappedFilters = $this->filterMapper->toLegacy($contents, 'advanced');
        $legacyContents = array_merge($legacyContents, $mappedFilters);

        $legacyContents['orderBy'] = strtoupper($contents['orderBy'] ?? '');
        $legacyContents['sortOrder'] = strtoupper($contents['sortOrder'] ?? '');

        $module = $contents['searchModule'] ?? ($container['search_module'] ?? '');
        if (!empty($module)) {
            $legacyContents['search_module'] = $this->moduleNameMapper->toLegacy($module);
        }

        $container[self::getField()] = $this->encode($legacyContents);
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

        $newContents = [
            'name' => $filterName,
            'filters' => [],
            'searchModule' => '',
            'orderBy' => strtolower($contents['orderBy'] ?? ''),
            'sortOrder' => strtolower($contents['sortOrder'] ?? '')
        ];

        if (!empty($contents['search_module'])) {
            $newContents['searchModule'] = $this->moduleNameMapper->toFrontEnd($contents['search_module']);
        }

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

        $filters = $this->filterMapper->toApi($contents);
        $newContents['filters'] = $filters;

        return $newContents;
    }

    /**
     * Encode criteria
     * @param array $content
     * @return string
     */
    public function encode(array $content): string
    {
        if (empty($content)) {
            return '';
        }

        return base64_encode(serialize($content));
    }
}
