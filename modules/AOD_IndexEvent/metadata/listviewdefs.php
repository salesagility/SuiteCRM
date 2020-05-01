<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
$module_name = 'AOD_IndexEvent';
$listViewDefs[$module_name] =
    [
        'RECORD_MODULE' => [
            'type' => 'varchar',
            'label' => 'LBL_RECORD_MODULE',
            'width' => '10%',
            'default' => true,
        ],
        'NAME' => [
            'width' => '30%',
            'label' => 'LBL_NAME',
            'default' => true,
            'link' => true,
            'customCode' => '<a href="index.php?action=EditView&module={$RECORD_MODULE}&record={$RECORD_ID}">{$NAME}</a>',
        ],
        'DATE_MODIFIED' => [
            'type' => 'datetime',
            'label' => 'LBL_DATE_MODIFIED',
            'width' => '10%',
            'default' => true,
        ],
        'ERROR' => [
            'type' => 'varchar',
            'label' => 'LBL_ERROR',
            'width' => '50%',
            'default' => true,
        ],
    ];
