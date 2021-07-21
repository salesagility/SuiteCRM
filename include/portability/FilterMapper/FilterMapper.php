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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

require_once __DIR__ . '/FilterMappers.php';
require_once __DIR__ . '/FilterMapperInterface.php';

class FilterMapper
{
    /**
     * @var array
     */
    private $filterOperatorMap;

    /**
     * @var FilterMappers
     */
    private $mappers;

    /**
     * LegacyFilterMapper constructor.
     */
    public function __construct()
    {
        $filter_operator_map = [];
        require 'filter_operator_map.php';
        $this->filterOperatorMap = $filter_operator_map;
        $this->mappers = new FilterMappers();
    }


    /**
     * Map filter to api
     * @param array $contents
     * @return array
     */
    public function toApi(array $contents): array
    {
        $filters = [];

        foreach ($contents as $key => $value) {
            if (empty($contents[$key])) {
                continue;
            }

            $filter = [
                'field' => '',
                'operator' => '=',
                'values' => '',
                'start' => '',
                'end' => '',
                'target' => ''
            ];

            $isRange = preg_match('/(.*)_advanced_range_choice/', $key);
            if ($isRange) {
                $fieldKey = str_replace('_advanced_range_choice', '', $key);

                $filter['field'] = $fieldKey;
                $filter['operator'] = $value;
                $filter['start'] = $contents["start_range_${fieldKey}_advanced"] ?? '';
                $filter['end'] = $contents["end_range_${fieldKey}_advanced"] ?? '';
                $filter['target'] = $contents["range_${fieldKey}_advanced"] ?? '';
                $filter['fieldType'] = $contents["field_type_${fieldKey}"] ?? '';

                $filters[$fieldKey] = $filter;
                continue;
            }

            $isRangeValue = preg_match('/range_(.*)_advanced/', $key);
            if ($isRangeValue) {
                continue;
            }

            $isFieldType = preg_match('/field_type_(.*)/', $key);
            if ($isFieldType) {
                continue;
            }

            $isRegularValue = preg_match('/(.*)_advanced/', $key);
            if ($isRegularValue) {
                $fieldKey = str_replace('_advanced', '', $key);
                $filter['field'] = $fieldKey;

                $values = [];
                if (is_string($value)) {
                    $values = [$value];
                }

                $filter['values'] = $values;
                $filter['fieldType'] = $contents["field_type_${fieldKey}"] ?? '';
                $filters[$fieldKey] = $filter;
                continue;
            }
        }

        return $filters;
    }

    /**
     * Map Filters to legacy
     * @param array $criteria
     * @param string $type
     * @return array
     */
    public function toLegacy(array $criteria, string $type): array
    {
        $mapped = [];

        if (empty($criteria['filters'])) {
            return $mapped;
        }

        foreach ($criteria['filters'] as $key => $item) {
            if (empty($item['operator'])) {
                continue;
            }

            $fieldType = $item['fieldType'] ?? '';
            $operator = $item['operator'] ?? '';
            $typeConfig = $this->filterOperatorMap[$fieldType] ?? [];

            $mergedConfig = array_merge($this->filterOperatorMap['default'], $typeConfig);
            $mapConfig = $mergedConfig[$operator];

            if (empty($mapConfig)) {
                continue;
            }

            foreach ($mapConfig as $mappedKey => $mappedValue) {
                $legacyKey = $this->mapFilterKey($type, $key, $mappedKey);
                $legacyValue = $this->mapFilterValue($mappedValue, $item);

                $mapped[$legacyKey] = $legacyValue;
            }
            $mapped['field_type_' . $key] = $fieldType;
        }

        return $mapped;
    }

    /**
     * Map Filter key to legacy
     * @param string $type
     * @param string $key
     * @param string $mappedKey
     * @return string
     */
    protected function mapFilterKey(string $type, string $key, string $mappedKey): string
    {
        return str_replace(array('{field}', '{type}'), array($key, $type), $mappedKey);
    }

    /**
     * Map Filter value to legacy
     * @param string $mappedValue
     * @param array $item
     * @return mixed|string|string[]
     */
    protected function mapFilterValue(string $mappedValue, array $item)
    {
        $fieldType = $item['fieldType'] ?? '';


        if ($mappedValue === 'values') {
            if ($this->mappers->hasMapper($fieldType)) {
                return $this->mappers->get($fieldType)->mapValue($mappedValue, $item);
            }

            return $this->mappers->get('default')->mapValue($mappedValue, $item);
        }

        $operator = $item['operator'] ?? '';
        $start = $item['start'] ?? '';
        $end = $item['end'] ?? '';
        $target = $item['target'] ?? '';

        return str_replace(
            ['{operator}', '{start}', '{end}', '{target}'],
            [$operator, $start, $end, $target],
            $mappedValue
        );
    }

    /**
     * Get order by
     * @param array $sort
     * @return string
     */
    public function getOrderBy(array $sort): string
    {
        return $sort['orderBy'] ?? 'date_entered';
    }

    /**
     * Get sort order
     * @param array $sort
     * @return string
     */
    public function getSortOrder(array $sort): string
    {
        return $sort['sortOrder'] ?? 'DESC';
    }
}
