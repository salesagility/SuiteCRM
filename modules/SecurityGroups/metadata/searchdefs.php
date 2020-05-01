<?php

$module_name = 'SecurityGroups';
  $searchdefs[$module_name] = [
      'templateMeta' => [
          'maxColumns' => '3',
          'widths' => ['label' => '10', 'field' => '30'],
      ],
      'layout' => [
          'basic_search' => [
              'name',
              ['name' => 'current_user_only', 'label' => 'LBL_CURRENT_USER_FILTER', 'type' => 'bool'],
          ],
          'advanced_search' => [
              'name',
              ['name' => 'assigned_user_id', 'type' => 'enum', 'function' => ['name' => 'get_user_array', 'params' => [false]]],
          ],
      ],
  ];
