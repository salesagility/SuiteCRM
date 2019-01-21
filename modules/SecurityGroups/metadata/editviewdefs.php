<?php

$module_name = 'SecurityGroups';
$viewdefs[$module_name]['EditView'] = array(

    'templateMeta' => array('maxColumns' => '2', 

                            'widths' => array(

                                            array('label' => '10', 'field' => '30'), 

                                            array('label' => '10', 'field' => '30')

                                            ),                                                                                                                                    

                                            ),

                                            

                                            
 'panels' =>array (
  'default' => 
  array (
    
    array (
      array('name' => 'name', 'displayParams'=>array('required'=>true)),
      'assigned_user_name',
    ),







    array (
    	'noninheritable',
    ),    
    array (
      'description',
    ),
  ),

                                                    
),

                        

);
