<?php

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
    ): array {

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

        $beanList = $response['list'] ?? [];
        $mappedBeans = [];

        foreach ($beanList as $beanData) {
            $mappedBeans[] = $this->apiBeanMapper->toArray($beanData);
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

        return [
            'data' => $mappedBeans,
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
            ]
        ];
    }

}
