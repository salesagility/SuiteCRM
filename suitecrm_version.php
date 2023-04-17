<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// These can be udpated by an automated release build tool.
$_SUITECRM_MAJOR_='7';
$_SUITECRM_MINOR_='12';
$_SUITECRM_PATCH_='10';
$_SUITECRM_PRE_RELEASE_TAG_=''; // dev test alpha beta rc1 rc2 (etc), optional.
$_SUITECRM_BUILD_METADATA_='';  //  any metadata info, for example: 2023H1, optional.

$suitecrm_timestamp = '2023-03-02 12:00:00';   //  can be updated by automated build release tool.

// version string is constructed of the generated values above.
$suitecrm_version = $_SUITECRM_MAJOR_ . '.' . $_SUITECRM_MINOR_ . '.' . $_SUITECRM_PATCH_ . $_SUITECRM_PRE_RELEASE_TAG_;
