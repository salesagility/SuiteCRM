<?php
$hook_version = 1;
$hook_array = [];
$hook_array['before_save'] = array();
$hook_array['before_save'][] = [
    2,
    'Update historical data',
    'custom/modules/Accounts/logic_hooks/AllocateGroup.php',
    'SaveHooks',
    'UpdateGroup'
];
?>