<?php

require_once 'include/ListView/ListViewData.php';

class ListViewDataPort extends ListViewData
{
    /**
     * @inheritDoc
     */
    public function getOrderBy($orderBy = '', $direction = ''): array
    {
        return ['orderBy' => $orderBy, 'sortOrder' => $direction];
    }
}