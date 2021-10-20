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
require_once 'include/portability/ApiBeanMapper/ApiBeanMapper.php';

class SubpanelDataPort
{

    /**
     * @var ApiBeanMapper
     */
    protected $apiBeanMapper;

    public function __construct()
    {
        $this->apiBeanMapper = new ApiBeanMapper();
    }


    /**
     * @param SugarBean $bean
     * @param string $subpanel
     * @param int $offset
     * @param int $limit
     * @param string $orderBy
     * @param string $sortOrder
     * @return array
     */
    public function fetch(
        SugarBean $bean,
        string $subpanel = '',
        int $offset = -1,
        int $limit = -1,
        string $orderBy = '',
        string $sortOrder = ''
    ): array
    {

        /* @noinspection PhpIncludeInspection */
        require_once 'include/SubPanel/SubPanelDefinitions.php';

        $spd = new SubPanelDefinitions($bean);
        $aSubPanelObject = $spd->load_subpanel($subpanel);

        try {
            $response = SugarBean::get_union_related_list(
                $bean,
                $orderBy,
                $sortOrder,
                '',
                $offset,
                -1,
                $limit,
                0,
                $aSubPanelObject
            );
        } catch (Exception $ex) {
            LoggerManager::getLogger()->fatal('[' . __METHOD__ . "] . {$ex->getMessage()}");

            return ['data' => [], 'offsets' => [], 'ordering' => []];
        }

        $row_count = $response['row_count'];
        $next_offset = $response['next_offset'];
        $previous_offset = $response['previous_offset'];
        if (!empty($response['current_offset'])) {
            $offset = $response['current_offset'];
        }

        // Determine the start location of the last page
        if ($row_count === 0) {
            $number_pages = 0;
        } else {
            $number_pages = floor(($row_count - 1) / $limit);
        }

        $last_offset = $number_pages * $limit;

        $lisData = [
            'data' => [],
            "offsets" => [
                "current" => $offset,
                "next" => $next_offset,
                "prev" => $previous_offset,
                "end" => $last_offset,
                "total" => $row_count,
                "totalCounted" => true
            ],
            "ordering" => [
                "orderBy" => $orderBy,
                "sortOrder" => $sortOrder
            ],
            'pageData' => []
        ];

        $beanList = $response['list'] ?? [];
        $mappedBeans = [];

        foreach ($beanList as $key => $beanData) {
            $this->addACLInfo($beanData, $lisData['pageData']);
            $mappedBeans[] = $this->apiBeanMapper->toApi($beanData);
        }

        $lisData['data'] = $mappedBeans;


        return $lisData;
    }

    /**
     * @param SugarBean $bean
     * @param string $subpanel
     * @param int $offset
     * @param int $limit
     * @param string $orderBy
     * @param string $sortOrder
     * @param array $selectColumns
     * @return array|null
     * @noinspection NullPointerExceptionInspection
     */
    public function fetchFinalQuery(
        SugarBean $bean,
        string $subpanel = '',
        int $offset = -1,
        int $limit = -1,
        string $orderBy = '',
        string $sortOrder = '',
        array $selectColumns = []
    ): ?array
    {

        /* @noinspection PhpIncludeInspection */
        require_once 'include/SubPanel/SubPanelDefinitions.php';

        $spd = new SubPanelDefinitions($bean);
        $aSubPanelObject = $spd->load_subpanel($subpanel);

        try {
            $response = SugarBean::get_union_related_list_query_params(
                $bean,
                $orderBy,
                $sortOrder,
                '',
                $offset,
                -1,
                $limit,
                0,
                $aSubPanelObject,
                $selectColumns
            );

            return $response;
        } catch (Exception $ex) {
            LoggerManager::getLogger()->fatal('[' . __METHOD__ . "] . {$ex->getMessage()}");

            return null;
        }
    }

    /**
     * @param SugarBean $temp
     * @param array $pageData
     */
    protected function addACLInfo(SugarBean $temp, array &$pageData): void
    {
        $acls = [];

        $actions = ['list', 'edit', 'view', 'delete', 'export', 'import'];

        foreach ($actions as $action) {
            $hasAccess = $temp->ACLAccess($action);

            if ($hasAccess === true) {
                $acls[] = $action;
            }

        }

        $pageData['acls'][$temp->id] = $acls;
    }
}
