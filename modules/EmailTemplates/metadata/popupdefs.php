<?php
$popupMeta = array (
    'moduleMain' => 'EmailTemplate',
    'varName' => 'EmailTemplate',
    'orderBy' => 'emailtemplates.name',
    'whereClauses' => array (
    'name' => 'emailtemplates.name',
    ),
    'searchInputs' => array (
        0 => 'emailtemplates_number',
        1 => 'name',
        2 => 'priority',
        3 => 'status',
        ),
    'listviewdefs' => array (
        'NAME' =>
            array (
                'width' => '20%',
                'label' => 'LBL_NAME',
                'link' => true,
                'default' => true,
                'name' => 'name',
            ),
        'TYPE' =>
            array (
                'width' => '20%',
                'label' => 'LBL_TYPE',
                'link' => false,
                'default' => true,
                'name' => 'type',
            ),
        'DESCRIPTION' =>
            array (
                'width' => '40%',
                'default' => true,
                'sortable' => false,
                'label' => 'LBL_DESCRIPTION',
                'name' => 'description',
            ),
        'ASSIGNED_USER_NAME' =>
            array (
                'width' => '10%',
                'label' => 'LBL_LIST_ASSIGNED_USER',
                'module' => 'Employees',
                'id' => 'ASSIGNED_USER_ID',
                'default' => true,
                'name' => 'assigned_user_name',
            ),
        'DATE_MODIFIED' =>
            array (
                'width' => '10%',
                'default' => true,
                'label' => 'LBL_DATE_MODIFIED',
                'name' => 'date_modified',
            ),
        'DATE_ENTERED' =>
            array (
                'width' => '10%',
                'label' => 'LBL_DATE_ENTERED',
                'default' => true,
                'name' => 'date_entered',
            ),
        ),
    );