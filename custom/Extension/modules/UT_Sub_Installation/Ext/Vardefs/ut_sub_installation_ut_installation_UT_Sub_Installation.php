<?php
// created: 2024-04-23 13:25:51
$dictionary["UT_Sub_Installation"]["fields"]["ut_sub_installation_ut_installation"] = array (
  'name' => 'ut_sub_installation_ut_installation',
  'type' => 'link',
  'relationship' => 'ut_sub_installation_ut_installation',
  'source' => 'non-db',
  'module' => 'UT_Installation',
  'bean_name' => false,
  'vname' => 'LBL_UT_SUB_INSTALLATION_UT_INSTALLATION_FROM_UT_INSTALLATION_TITLE',
  'id_name' => 'ut_sub_installation_ut_installationut_installation_ida',
);
$dictionary["UT_Sub_Installation"]["fields"]["ut_sub_installation_ut_installation_name"] = array (
  'name' => 'ut_sub_installation_ut_installation_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_UT_SUB_INSTALLATION_UT_INSTALLATION_FROM_UT_INSTALLATION_TITLE',
  'save' => true,
  'id_name' => 'ut_sub_installation_ut_installationut_installation_ida',
  'link' => 'ut_sub_installation_ut_installation',
  'table' => 'ut_installation',
  'module' => 'UT_Installation',
  'rname' => 'name',
);
$dictionary["UT_Sub_Installation"]["fields"]["ut_sub_installation_ut_installationut_installation_ida"] = array (
  'name' => 'ut_sub_installation_ut_installationut_installation_ida',
  'type' => 'link',
  'relationship' => 'ut_sub_installation_ut_installation',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_UT_SUB_INSTALLATION_UT_INSTALLATION_FROM_UT_SUB_INSTALLATION_TITLE',
);
