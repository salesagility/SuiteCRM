<?php
// created: 2014-01-31 11:04:54
$viewdefs = array (
  'Users' => 
  array (
    'DetailView' => 
    array (
      'templateMeta' => 
      array (
        'maxColumns' => '2',
        'widths' => 
        array (
          0 => 
          array (
            'label' => '10',
            'field' => '30',
          ),
          1 => 
          array (
            'label' => '10',
            'field' => '30',
          ),
        ),
        'form' => 
        array (
          'headerTpl' => 'modules/Users/tpls/DetailViewHeader.tpl',
          'footerTpl' => 'modules/Users/tpls/DetailViewFooter.tpl',
        ),
      ),
      'panels' => 
      array (
        'LBL_USER_INFORMATION' => 
        array (
          0 => 
          array (
            0 => 'full_name',
            1 => 'user_name',
          ),
          1 => 
          array (
            0 => 'status',
            1 => 
            array (
              'name' => 'UserType',
              'customCode' => '{$USER_TYPE_READONLY}',
            ),
          ),
          2 => 
          array (
            1 => 
            array (
              'name' => 'twitter_user_c',
            ),
          ),
        ),
        'LBL_EMPLOYEE_INFORMATION' => 
        array (
          0 => 
          array (
            0 => 'employee_status',
            1 => 'show_on_employees',
          ),
          1 => 
          array (
            0 => 'title',
            1 => 'phone_work',
          ),
          2 => 
          array (
            0 => 'department',
            1 => 'phone_mobile',
          ),
          3 => 
          array (
            0 => 'reports_to_name',
            1 => 'phone_other',
          ),
          4 => 
          array (
            1 => 'phone_fax',
          ),
          5 => 
          array (
            1 => 'phone_home',
          ),
          6 => 
          array (
            0 => 'messenger_type',
            1 => 'messenger_id',
          ),
          7 => 
          array (
            0 => 'address_street',
            1 => 'address_city',
          ),
          8 => 
          array (
            0 => 'address_state',
            1 => 'address_postalcode',
          ),
          9 => 
          array (
            0 => 'address_country',
          ),
          10 => 
          array (
            0 => 'description',
          ),
        ),
      ),
    ),
  ),
);