<?php

/** BEGIN SECURITY GROUPS */
//array_unshift($defaultDashlets, array('MessageDashlet'=>'Home'));	
$defaultDashlets = array_reverse($defaultDashlets, true);
$defaultDashlets['MessageDashlet'] = 'Home';
$defaultDashlets = array_reverse($defaultDashlets, true);  
/** END SECURITY GROUPS */	
    