<?php


class SugarBeanTest extends PHPUnit_Framework_TestCase
{

    protected $env = array();

    public function setUp() {
        global $current_user;
        $current_user = new User();
        get_sugar_config_defaults();

        if(isset($GLOBALS['reload_vardefs'])) {
            $this->env['$GLOBALS']['reload_vardefs'] = $GLOBALS['reload_vardefs'];
        }
        if(isset($GLOBALS['dictionary'])) {
            $this->env['$GLOBALS']['dictionary'] = $GLOBALS['dictionary'];
        }
    }

    public function tearDown() {
        if(isset($this->env['$GLOBALS']['reload_vardefs'])) {
            $GLOBALS['reload_vardefs'] = $this->env['$GLOBALS']['reload_vardefs'];
        }
        if(isset($this->env['$GLOBALS']['dictionary'])) {
            $GLOBALS['dictionary'] = $this->env['$GLOBALS']['dictionary'];
        }
    }

    /**
     * Test for __construct()
     */
    public function testConstruct()
    {
        global $dictionary;

        $_REQUEST['test1'] = true;

        // test dup3
        include_once __DIR__ . '/../../../modules/AM_ProjectTemplates/AM_ProjectTemplates_sugar.php';
        $bean = new AM_ProjectTemplates_sugar();
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertEquals('AM_ProjectTemplates', $bean->module_name);
        self::assertEquals(array(
            'id' => 1,
            'name' => 1,
        ), $bean->required_fields);
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules/AM_ProjectTemplates/Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertEquals('AM_ProjectTemplates', $bean->custom_fields->module);
        self::assertEquals(Array (
            0 => 'id',
            1 => 'name',
            2 => 'date_entered',
            3 => 'date_modified',
            4 => 'modified_user_id',
            5 => 'modified_by_name',
            6 => 'created_by',
            7 => 'created_by_name',
            8 => 'description',
            9 => 'deleted',
            10 => 'created_by_link',
            11 => 'modified_user_link',
            12 => 'assigned_user_id',
            13 => 'assigned_user_name',
            14 => 'assigned_user_link',
            15 => 'status',
            16 => 'priority',
            17 => 'am_projecttemplates_project_1',
            18 => 'am_tasktemplates_am_projecttemplates',
            19 => 'am_projecttemplates_users_1',
            20 => 'am_projecttemplates_contacts_1',
            21 => 'override_business_hours',
        ), $bean->column_fields);

        $keys = array_keys($bean->field_name_map);
        self::assertEquals(Array (
            0 => 'id',
            1 => 'name',
            2 => 'date_entered',
            3 => 'date_modified',
            4 => 'modified_user_id',
            5 => 'modified_by_name',
            6 => 'created_by',
            7 => 'created_by_name',
            8 => 'description',
            9 => 'deleted',
            10 => 'created_by_link',
            11 => 'modified_user_link',
            12 => 'assigned_user_id',
            13 => 'assigned_user_name',
            14 => 'assigned_user_link',
            15 => 'status',
            16 => 'priority',
            17 => 'am_projecttemplates_project_1',
            18 => 'am_tasktemplates_am_projecttemplates',
            19 => 'am_projecttemplates_users_1',
            20 => 'am_projecttemplates_contacts_1',
            21 => 'override_business_hours',
        ), $keys);

        self::assertEquals($keys, array_keys($bean->field_defs));
        self::assertEquals(true, $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertNotTrue(isset($bean->added_custom_field_defs));
        self::assertEquals(true, $bean->acl_fields);


        // test
        $bean = new SugarBean();
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertEquals('', $bean->module_name);
        self::assertNotTrue(isset($bean->required_fields));
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules//Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertEquals('', $bean->custom_fields->module);
        self::assertEquals(array(), $bean->column_fields);
        self::assertEquals('', $bean->field_name_map);
        self::assertEquals('', $bean->field_defs);
        self::assertEquals('', $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertNotTrue(isset($bean->added_custom_field_defs));
        self::assertNotTrue(isset($bean->acl_fields));

        // test
        $dictionary['']['optimistic_locking'] = true;
        $bean = new SugarBean();
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertEquals('', $bean->module_name);
        self::assertNotTrue(isset($bean->required_fields));
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules//Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertEquals('', $bean->custom_fields->module);
        self::assertEquals(array(), $bean->column_fields);
        self::assertEquals('', $bean->field_name_map);
        self::assertEquals('', $bean->field_defs);
        self::assertEquals(true, $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertTrue($bean->added_custom_field_defs);
        self::assertNotTrue(isset($bean->acl_fields));
        $dictionary['']['optimistic_locking'] = null;

        // test
        $bean = new SugarBean();
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertEquals('', $bean->module_name);
        self::assertNotTrue(isset($bean->required_fields));
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules//Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertEquals('', $bean->custom_fields->module);
        self::assertEquals(array(), $bean->column_fields);
        self::assertEquals('', $bean->field_name_map);
        self::assertEquals('', $bean->field_defs);
        self::assertEquals('', $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertTrue($bean->added_custom_field_defs);
        self::assertNotTrue(isset($bean->acl_fields));

        // test
        $GLOBALS['reload_vardefs'] = true;
        $dictionary['']['fields'] = $dictionary['User']['fields'];
        $bean = new SugarBean();
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertEquals('', $bean->module_name);
        self::assertTrue(isset($bean->required_fields));
        self::assertEquals(array(
            'id' => 1,
            'user_name' => 1,
            'system_generated_password' => 1,
            'last_name' => 1,
            'date_entered' => 1,
            'date_modified' => 1,
            'status' => 1,
            'email1' => 1,
            'email_addresses' => 1,
            'email_addresses_primary' => 1,
        ), $bean->required_fields);
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules//Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertEquals('', $bean->custom_fields->module);
        self::assertEquals(array(
            0 => 'id',
            1 => 'user_name',
            2 => 'user_hash',
            3 => 'system_generated_password',
            4 => 'pwd_last_changed',
            5 => 'authenticate_id',
            6 => 'sugar_login',
            7 => 'first_name',
            8 => 'last_name',
            9 => 'full_name',
            10 => 'name',
            11 => 'is_admin',
            12 => 'external_auth_only',
            13 => 'receive_notifications',
            14 => 'description',
            15 => 'date_entered',
            16 => 'date_modified',
            17 => 'modified_user_id',
            18 => 'modified_by_name',
            19 => 'created_by',
            20 => 'created_by_name',
            21 => 'title',
            22 => 'photo',
            23 => 'department',
            24 => 'phone_home',
            25 => 'phone_mobile',
            26 => 'phone_work',
            27 => 'phone_other',
            28 => 'phone_fax',
            29 => 'status',
            30 => 'address_street',
            31 => 'address_city',
            32 => 'address_state',
            33 => 'address_country',
            34 => 'address_postalcode',
            35 => 'UserType',
            36 => 'deleted',
            37 => 'portal_only',
            38 => 'show_on_employees',
            39 => 'employee_status',
            40 => 'messenger_id',
            41 => 'messenger_type',
            42 => 'calls',
            43 => 'meetings',
            44 => 'contacts_sync',
            45 => 'reports_to_id',
            46 => 'reports_to_name',
            47 => 'reports_to_link',
            48 => 'reportees',
            49 => 'email1',
            50 => 'email_addresses',
            51 => 'email_addresses_primary',
            52 => 'email_link_type',
            53 => 'editor_type',
            54 => 'aclroles',
            55 => 'is_group',
            56 => 'c_accept_status_fields',
            57 => 'm_accept_status_fields',
            58 => 'accept_status_id',
            59 => 'accept_status_name',
            60 => 'prospect_lists',
            61 => 'emails_users',
            62 => 'eapm',
            63 => 'oauth_tokens',
            64 => 'project_resource',
            65 => 'project_users_1',
            66 => 'am_projecttemplates_resources',
            67 => 'am_projecttemplates_users_1',
            68 => 'SecurityGroups',
            69 => 'securitygroup_noninher_fields',
            70 => 'securitygroup_noninherit_id',
            71 => 'securitygroup_noninheritable',
            72 => 'securitygroup_primary_group',
        ), $bean->column_fields);

        $keys = array_keys($bean->field_name_map);
        self::assertEquals($bean->column_fields, $keys);

        $keys = array_keys($bean->field_defs);
        self::assertEquals($bean->column_fields, $keys);

        self::assertEquals('', $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertNotTrue(isset($bean->added_custom_field_defs));
        self::assertNotTrue(isset($bean->acl_fields));


        // test
        $GLOBALS['reload_vardefs'] = true;
        $dictionary['']['fields'] = $dictionary['User']['fields'];
        $dictionary['']['optimistic_locking'] = true;
        $bean = new SugarBean();
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertEquals('', $bean->module_name);
        self::assertTrue(isset($bean->required_fields));
        self::assertEquals(array(
            'id' => 1,
            'user_name' => 1,
            'system_generated_password' => 1,
            'last_name' => 1,
            'date_entered' => 1,
            'date_modified' => 1,
            'status' => 1,
            'email1' => 1,
            'email_addresses' => 1,
            'email_addresses_primary' => 1,
        ), $bean->required_fields);
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules//Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertEquals('', $bean->custom_fields->module);
        self::assertEquals(array(
            0 => 'id',
            1 => 'user_name',
            2 => 'user_hash',
            3 => 'system_generated_password',
            4 => 'pwd_last_changed',
            5 => 'authenticate_id',
            6 => 'sugar_login',
            7 => 'first_name',
            8 => 'last_name',
            9 => 'full_name',
            10 => 'name',
            11 => 'is_admin',
            12 => 'external_auth_only',
            13 => 'receive_notifications',
            14 => 'description',
            15 => 'date_entered',
            16 => 'date_modified',
            17 => 'modified_user_id',
            18 => 'modified_by_name',
            19 => 'created_by',
            20 => 'created_by_name',
            21 => 'title',
            22 => 'photo',
            23 => 'department',
            24 => 'phone_home',
            25 => 'phone_mobile',
            26 => 'phone_work',
            27 => 'phone_other',
            28 => 'phone_fax',
            29 => 'status',
            30 => 'address_street',
            31 => 'address_city',
            32 => 'address_state',
            33 => 'address_country',
            34 => 'address_postalcode',
            35 => 'UserType',
            36 => 'deleted',
            37 => 'portal_only',
            38 => 'show_on_employees',
            39 => 'employee_status',
            40 => 'messenger_id',
            41 => 'messenger_type',
            42 => 'calls',
            43 => 'meetings',
            44 => 'contacts_sync',
            45 => 'reports_to_id',
            46 => 'reports_to_name',
            47 => 'reports_to_link',
            48 => 'reportees',
            49 => 'email1',
            50 => 'email_addresses',
            51 => 'email_addresses_primary',
            52 => 'email_link_type',
            53 => 'editor_type',
            54 => 'aclroles',
            55 => 'is_group',
            56 => 'c_accept_status_fields',
            57 => 'm_accept_status_fields',
            58 => 'accept_status_id',
            59 => 'accept_status_name',
            60 => 'prospect_lists',
            61 => 'emails_users',
            62 => 'eapm',
            63 => 'oauth_tokens',
            64 => 'project_resource',
            65 => 'project_users_1',
            66 => 'am_projecttemplates_resources',
            67 => 'am_projecttemplates_users_1',
            68 => 'SecurityGroups',
            69 => 'securitygroup_noninher_fields',
            70 => 'securitygroup_noninherit_id',
            71 => 'securitygroup_noninheritable',
            72 => 'securitygroup_primary_group',
        ), $bean->column_fields);

        $keys = array_keys($bean->field_name_map);
        self::assertEquals($bean->column_fields, $keys);

        $keys = array_keys($bean->field_defs);
        self::assertEquals($bean->column_fields, $keys);

        self::assertEquals(true, $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertNotTrue(isset($bean->added_custom_field_defs));
        self::assertNotTrue(isset($bean->acl_fields));



        // test
        $GLOBALS['reload_vardefs'] = true;
        $dictionary['']['fields'] = $dictionary['User']['fields'];
        $dictionary['']['optimistic_locking'] = true;
        $bean = new SugarBean();
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertEquals('', $bean->module_name);
        self::assertTrue(isset($bean->required_fields));
        self::assertEquals(array(
            'id' => 1,
            'user_name' => 1,
            'system_generated_password' => 1,
            'last_name' => 1,
            'date_entered' => 1,
            'date_modified' => 1,
            'status' => 1,
            'email1' => 1,
            'email_addresses' => 1,
            'email_addresses_primary' => 1,
        ), $bean->required_fields);
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules//Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertEquals('', $bean->custom_fields->module);
        self::assertEquals(array(
            0 => 'id',
            1 => 'user_name',
            2 => 'user_hash',
            3 => 'system_generated_password',
            4 => 'pwd_last_changed',
            5 => 'authenticate_id',
            6 => 'sugar_login',
            7 => 'first_name',
            8 => 'last_name',
            9 => 'full_name',
            10 => 'name',
            11 => 'is_admin',
            12 => 'external_auth_only',
            13 => 'receive_notifications',
            14 => 'description',
            15 => 'date_entered',
            16 => 'date_modified',
            17 => 'modified_user_id',
            18 => 'modified_by_name',
            19 => 'created_by',
            20 => 'created_by_name',
            21 => 'title',
            22 => 'photo',
            23 => 'department',
            24 => 'phone_home',
            25 => 'phone_mobile',
            26 => 'phone_work',
            27 => 'phone_other',
            28 => 'phone_fax',
            29 => 'status',
            30 => 'address_street',
            31 => 'address_city',
            32 => 'address_state',
            33 => 'address_country',
            34 => 'address_postalcode',
            35 => 'UserType',
            36 => 'deleted',
            37 => 'portal_only',
            38 => 'show_on_employees',
            39 => 'employee_status',
            40 => 'messenger_id',
            41 => 'messenger_type',
            42 => 'calls',
            43 => 'meetings',
            44 => 'contacts_sync',
            45 => 'reports_to_id',
            46 => 'reports_to_name',
            47 => 'reports_to_link',
            48 => 'reportees',
            49 => 'email1',
            50 => 'email_addresses',
            51 => 'email_addresses_primary',
            52 => 'email_link_type',
            53 => 'editor_type',
            54 => 'aclroles',
            55 => 'is_group',
            56 => 'c_accept_status_fields',
            57 => 'm_accept_status_fields',
            58 => 'accept_status_id',
            59 => 'accept_status_name',
            60 => 'prospect_lists',
            61 => 'emails_users',
            62 => 'eapm',
            63 => 'oauth_tokens',
            64 => 'project_resource',
            65 => 'project_users_1',
            66 => 'am_projecttemplates_resources',
            67 => 'am_projecttemplates_users_1',
            68 => 'SecurityGroups',
            69 => 'securitygroup_noninher_fields',
            70 => 'securitygroup_noninherit_id',
            71 => 'securitygroup_noninheritable',
            72 => 'securitygroup_primary_group',
        ), $bean->column_fields);

        $keys = array_keys($bean->field_name_map);
        self::assertEquals($bean->column_fields, $keys);

        $keys = array_keys($bean->field_defs);
        self::assertEquals($bean->column_fields, $keys);

        self::assertEquals(true, $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertNotTrue(isset($bean->added_custom_field_defs));
        self::assertNotTrue(isset($bean->acl_fields));

    }

}