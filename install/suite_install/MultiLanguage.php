<?php
function install_multilanguage()
{
    require_once('ModuleInstall/ModuleInstaller.php');
    $ModuleInstaller = new ModuleInstaller();
    $ModuleInstaller->install_custom_fields(getMultiLanguageCustomFields());
}

function getMultiLanguageCustomFields()
{
    $custom_fields =
        array(
            'Userslanguage_c' =>
                array(
                    'id' => 'Userslanguage_c',
                    'name' => 'language_c',
                    'label' => 'LBL_LANGUAGE',
                    'comments' => 'The language of the user',
                    'help' => 'The language of the user',
                    'module' => 'Users',
                    'type' => 'enum',
                    'max_size' => '100',
                    'require_option' => '0',
                    'default_value' => 'en',
                    'date_modified' => '2018-04-18 17:14:00',
                    'deleted' => '0',
                    'audited' => '0',
                    'mass_update' => '1',
                    'duplicate_merge' => '0',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => 'language_dom',
                ),
            'Contactslanguage' =>
                array(
                    'id' => 'Contactslanguage_c',
                    'name' => 'language_c',
                    'label' => 'LBL_LANGUAGE',
                    'comments' => 'The language of the contact',
                    'help' => 'The language of the contact',
                    'module' => 'Contacts',
                    'type' => 'enum',
                    'max_size' => '100',
                    'require_option' => '0',
                    'default_value' => 'en',
                    'date_modified' => '2018-04-18 17:14:00',
                    'deleted' => '0',
                    'audited' => '0',
                    'mass_update' => '1',
                    'duplicate_merge' => '0',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => 'language_dom',
                ),
        );

    return $custom_fields;
}
