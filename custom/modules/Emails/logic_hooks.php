<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(10, 'Save email case updates', 'modules/AOP_Case_Updates/CaseUpdatesHook.php','CaseUpdatesHook', 'saveEmailUpdate'); 

$hook_array['before_delete'] = Array(); 
$hook_array['before_delete'][] = Array(30, 'Delete the emails from crm to imap server', 'custom/modules/Emails/delEmailCls.php','delEmailCls', 'delEmailFunc'); 
