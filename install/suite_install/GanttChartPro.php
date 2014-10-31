<?php
function install_ganttChartPro() {

    require_once('ModuleInstall/ModuleInstaller.php');
    $ModuleInstaller = new ModuleInstaller();
    $ModuleInstaller->install_custom_fields(getCustomFields());

}

function getCustomFields(){
    $custom_fields =
  array (
      'ProjectTaskrelationship_type_c' =>
          array (
              'id' => 'ProjectTaskrelationship_type_c',
              'name' => 'relationship_type_c',
              'label' => 'LBL_RELATIONSHIP_TYPE',
              'comments' => '',
              'help' => '',
              'module' => 'ProjectTask',
              'type' => 'enum',
              'max_size' => '100',
              'require_option' => '0',
              'default_value' => 'FS',
              'date_modified' => '2014-04-05 00:51:06',
              'deleted' => '0',
              'audited' => '0',
              'mass_update' => '0',
              'duplicate_merge' => '0',
              'reportable' => '1',
              'importable' => 'true',
              'ext1' => 'relationship_type_list',
              'ext2' => '',
              'ext3' => '',
              'ext4' => '',
          ),
  );

	return $custom_fields;
}
