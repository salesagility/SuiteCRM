<?php

/**
 * 
 * This script is in charge of activating the option count_collapsed_subpanels and set "monday" as first day of the weekfor all users. 
 * 
 * The count_collapsed_subpanels option display in the title of each subpanel the number of records that contains that subpanel.
 * 
 * The first day of the week is used in the core Calendar of SuiteCRM and might be used as well by other modules
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
    // First day of the week = monday
    $userBean->setPreference('fdow', '1', 0, 'global');
    // Show record count on collapsed subpanels
    $userBean->setPreference('count_collapsed_subpanels', 'on', 0, 'global');
    // Save preferences
    $userBean->savePreferencesToDB();
}

// Output an extra line to ensure last savePreferencesToDB() execution
// STIC#436#issuecomment-948385071
echo "End Script EnableCountSubpanelAndFirstDayOfTheWeek\n";
