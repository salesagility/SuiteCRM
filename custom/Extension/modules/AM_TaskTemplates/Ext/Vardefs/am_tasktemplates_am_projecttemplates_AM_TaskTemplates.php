<?php
// created: 2014-05-30 00:06:35
$dictionary["AM_TaskTemplates"]["fields"]["am_tasktemplates_am_projecttemplates"] = array (
  'name' => 'am_tasktemplates_am_projecttemplates',
  'type' => 'link',
  'relationship' => 'am_tasktemplates_am_projecttemplates',
  'source' => 'non-db',
  'module' => 'AM_ProjectTemplates',
  'bean_name' => 'AM_ProjectTemplates',
  'vname' => 'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_PROJECTTEMPLATES_TITLE',
  'id_name' => 'am_tasktemplates_am_projecttemplatesam_projecttemplates_ida',
);
$dictionary["AM_TaskTemplates"]["fields"]["am_tasktemplates_am_projecttemplates_name"] = array (
  'name' => 'am_tasktemplates_am_projecttemplates_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_PROJECTTEMPLATES_TITLE',
  'save' => true,
  'id_name' => 'am_tasktemplates_am_projecttemplatesam_projecttemplates_ida',
  'link' => 'am_tasktemplates_am_projecttemplates',
  'table' => 'am_projecttemplates',
  'module' => 'AM_ProjectTemplates',
  'rname' => 'name',
);
$dictionary["AM_TaskTemplates"]["fields"]["am_tasktemplates_am_projecttemplatesam_projecttemplates_ida"] = array (
  'name' => 'am_tasktemplates_am_projecttemplatesam_projecttemplates_ida',
  'type' => 'link',
  'relationship' => 'am_tasktemplates_am_projecttemplates',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_TASKTEMPLATES_TITLE',
);
