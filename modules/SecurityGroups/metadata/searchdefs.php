<?php

$module_name = 'SecurityGroups';
  $searchdefs[$module_name] = array(
					'templateMeta' => array(
							'maxColumns' => '3', 
                            'widths' => array('label' => '10', 'field' => '30'),                 
                           ),
                    'layout' => array(  					
						'basic_search' => array(
							'name', 
							array('name'=>'current_user_only', 'label'=>'LBL_CURRENT_USER_FILTER', 'type'=>'bool'),
							),
						'advanced_search' => array(
							'name', 
							array('name' => 'assigned_user_id', 'type' => 'enum', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
						),
					),
 			   );
