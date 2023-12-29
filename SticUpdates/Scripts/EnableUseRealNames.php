<?php

/**
 * 
 * This script is in charge of activating the option "use_real_names" for all users. 
 * 
 * The use_real_names option, also called "Show full names", enables the displaying of the User's full name in the assigned_user fields.
 * We enable this globally in order to avoid the bug that won't apply the Security Suite groups in the QuickSearch assigned_user field.
 * STIC#514
 * 
 */

// Load an admin user as current one in order to be able to get user data later
global $current_user;
$current_user = new User();
$current_user->getSystemUser();

// Get all users
$userEmptyBean = BeanFactory::getBean('Users');
$userBeanArray = $userEmptyBean->get_full_list();
// Set the config params for each user
foreach ($userBeanArray as $userBean) {
    // Enable "Show full names" User profile property
    $userBean->setPreference('use_real_names', 'on', 0, 'global');
    // Save preferences
    $userBean->savePreferencesToDB();
}

// Output an extra line to ensure last savePreferencesToDB() execution
// STIC#436#issuecomment-948385071
echo "End Script EnableUseRealNames\n";
