<?php
// created: 2014-06-04 23:46:40
$dictionary["Project"]["fields"]["am_projecttemplates_project_1"] = array (
  'name' => 'am_projecttemplates_project_1',
  'type' => 'link',
  'relationship' => 'am_projecttemplates_project_1',
  'source' => 'non-db',
  'module' => 'AM_ProjectTemplates',
  'bean_name' => 'AM_ProjectTemplates',
  'vname' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_AM_PROJECTTEMPLATES_TITLE',
  'id_name' => 'am_projecttemplates_project_1am_projecttemplates_ida',
);
$dictionary["Project"]["fields"]["am_projecttemplates_project_1_name"] = array (
  'name' => 'am_projecttemplates_project_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_AM_PROJECTTEMPLATES_TITLE',
  'save' => true,
  'id_name' => 'am_projecttemplates_project_1am_projecttemplates_ida',
  'link' => 'am_projecttemplates_project_1',
  'table' => 'am_projecttemplates',
  'module' => 'AM_ProjectTemplates',
  'rname' => 'name',
);
$dictionary["Project"]["fields"]["am_projecttemplates_project_1am_projecttemplates_ida"] = array (
  'name' => 'am_projecttemplates_project_1am_projecttemplates_ida',
  'type' => 'link',
  'relationship' => 'am_projecttemplates_project_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_PROJECT_TITLE',
);
