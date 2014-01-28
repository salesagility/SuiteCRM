<?php
// created: 2014-01-28 15:19:44
$viewdefs = array (
  'FP_Event_Locations' => 
  array (
    'DetailView' => 
    array (
      'templateMeta' => 
      array (
        'form' => 
        array (
          'buttons' => 
          array (
            0 => 'EDIT',
            1 => 'DUPLICATE',
            2 => 'DELETE',
            3 => 'FIND_DUPLICATES',
          ),
        ),
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
        'useTabs' => false,
        'tabDefs' => 
        array (
          'DEFAULT' => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
          ),
          'LBL_EDITVIEW_PANEL1' => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
          ),
        ),
        'syncDetailEditViews' => true,
      ),
      'panels' => 
      array (
        'default' => 
        array (
          0 => 
          array (
            0 => 'name',
            1 => 'date_entered',
          ),
          1 => 
          array (
            0 => 'description',
            1 => 
            array (
              'name' => 'capacity',
              'label' => 'LBL_CAPACITY',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'twitter_user_c',
            ),
          ),
        ),
        'lbl_editview_panel1' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'address',
              'label' => 'LBL_ADDRESS',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'address_city',
              'label' => 'LBL_ADDRESS_CITY',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'address_postalcode',
              'label' => 'LBL_ADDRESS_POSTALCODE',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'address_state',
              'label' => 'LBL_ADDRESS_STATE',
            ),
          ),
          4 => 
          array (
            0 => 
            array (
              'name' => 'address_country',
              'label' => 'LBL_ADDRESS_COUNTRY',
            ),
          ),
        ),
      ),
    ),
  ),
);