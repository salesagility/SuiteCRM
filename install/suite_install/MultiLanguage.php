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

function postInstallMultiLanguage()
{
    $GLOBALS['dictionary']['User']['custom_fields'] = true;
    $GLOBALS['dictionary']['Contact']['custom_fields'] = true;

    installLog("postInstallMultiLanguage: update Users");
    $users = BeanFactory::getBean('Users');
    $userslist = $users->get_full_list();

    if (!empty($userslist)){
       foreach( $userslist as $user ){
          $user->setupCustomFields($user->module_dir);
          $user->language_c = 'en';
          $user->field_defs["language_c"] = array( "name" => "language_c", "type" => "enum", "source" => "custom_fields");
          $user->custom_fields->bean = $user;
          $user->custom_fields->save( false );
       }
    }

    installLog("postInstallMultiLanguage: update Contacts");
    $contacts = BeanFactory::getBean('Contacts');
    $contactslist = $contacts->get_full_list();

    if (!empty($contactslist)){
       foreach( $contactslist as $contact ){
          $contact->setupCustomFields($contact->module_dir);
          $contact->language_c = 'en';
          $contact->field_defs["language_c"] = array( "name" => "language_c", "type" => "enum", "source" => "custom_fields");
          $contact->custom_fields->bean = $contact;
          $contact->custom_fields->save( false );
       }
   }
}

