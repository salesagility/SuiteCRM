<?php

include_once __DIR__ . '/../../TestLogger.php';
include_once __DIR__ . '/SugarBeanMock.php';
include_once __DIR__ . '/../../../include/SubPanel/SubPanelDefinitions.php';

/** @noinspection PhpUndefinedClassInspection */
class SugarBeanTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var array
     */
    protected $env = array();

    /**
     * @var LoggerManager
     */
    protected $log;

    /**
     * @var DBManager
     */
    protected $db;

    /**
     * @var array
     */
    protected $dbManagerFactoryInstances;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        global $current_user;
        $current_user = new User();
        get_sugar_config_defaults();

        $this->log = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        $this->dbManagerFactoryInstances = DBManagerFactory::$instances;
        DBManagerFactory::$instances = array();
        $this->db = DBManagerFactory::getInstance();


        if (isset($GLOBALS['reload_vardefs'])) {
            $this->env['$GLOBALS']['reload_vardefs'] = $GLOBALS['reload_vardefs'];
        }
        if (isset($GLOBALS['dictionary'])) {
            $this->env['$GLOBALS']['dictionary'] = $GLOBALS['dictionary'];
        }

    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {
        if (isset($this->env['$GLOBALS']['reload_vardefs'])) {
            $GLOBALS['reload_vardefs'] = $this->env['$GLOBALS']['reload_vardefs'];
        }
        if (isset($this->env['$GLOBALS']['dictionary'])) {
            $GLOBALS['dictionary'] = $this->env['$GLOBALS']['dictionary'];
        }

        $GLOBALS['log'] = $this->log;

        DBManagerFactory::$instances = $this->dbManagerFactoryInstances;
    }


    /**
     * Test for __construct()
     */
    public function testConstruct()
    {
        global $dictionary;

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
        self::assertEquals(Array(
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
        self::assertEquals(Array(
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

        $GLOBALS['log']->reset();
        $bean = new SugarBean();
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);
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

    /**
     * Test for setupCustomFields()
     */
    public function testSetupCustomFields()
    {
        $bean = new SugarBean();

        // test
        $bean->setupCustomFields('test');
        self::assertEquals('custom/Extension/modules/test/Ext/Vardefs', $bean->custom_fields->base_path);

        // test
        $bean->setupCustomFields('Users');
        self::assertEquals('custom/Extension/modules/Users/Ext/Vardefs', $bean->custom_fields->base_path);
    }

    /**
     * Test for bean_implements()
     */
    public function testBeanImplements()
    {
        $bean = new SugarBean();

        // test
        $results = $bean->bean_implements('test');
        self::assertEquals(false, $results);
    }

    /**
     * Test for populateDefaultValues()
     */
    public function testPopulateDefaultValues()
    {

        $testBean1 = new SugarBean();
        $testBean1->field_defs = null;
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $testBean1->populateDefaultValues();
        self::assertEquals(null, $results);
        self::assertEquals(null, $testBean1->field_defs);

        // test
        $bean = new SugarBean();
        $force = false;
        $fieldDefsBefore = $bean->field_defs;
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->populateDefaultValues($force);
        self::assertEquals(null, $results);
        self::assertEquals($fieldDefsBefore, $bean->field_defs);


        // test
        $bean = new SugarBean();
        $force = true;
        $bean->field_defs['test'] = array(
            'default' => true,
        );
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->populateDefaultValues($force);
        self::assertEquals(null, $results);
        self::assertEquals(array(
            'test' => array(
                'default' => true,
            ),
        ), $bean->field_defs);


        // test
        $bean = new SugarBean();
        $force = true;
        $bean->field_defs['test'] = array(
            'default' => true,
        );
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->populateDefaultValues($force);
        self::assertEquals(null, $results);
        self::assertEquals(array(
            'test' => array(
                'default' => true,
            ),
        ), $bean->field_defs);
        $field = 'test';
        self::assertEquals(1, $bean->$field);


        // test
        $bean = new SugarBean();
        $force = true;
        $bean->field_defs['test'] = array(
            'default' => '<b>bold</b>',
        );
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->populateDefaultValues($force);
        self::assertEquals(null, $results);
        self::assertEquals(array(
            'test' => array(
                'default' => '<b>bold</b>',
            ),
        ), $bean->field_defs);
        $field = 'test';
        self::assertEquals('&lt;b&gt;bold&lt;/b&gt;', $bean->$field);


        // test
        $bean = new SugarBean();
        $force = true;
        $bean->field_defs['test'] = array(
            'default' => '',
        );
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->populateDefaultValues($force);
        self::assertEquals(null, $results);
        self::assertEquals(array(
            'test' => array(
                'default' => '',
            ),
        ), $bean->field_defs);
        $field = 'test';
        self::assertEquals('', $bean->$field);


        // test
        $bean = new SugarBean();
        $force = true;
        $bean->field_defs['test'] = array(
            'default' => '<b>bold</b>',
            'type' => 'multienum',
        );
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->populateDefaultValues($force);
        self::assertEquals(null, $results);
        self::assertEquals(array(
            'test' => array(
                'default' => '<b>bold</b>',
                'type' => 'multienum',
            ),
        ), $bean->field_defs);
        $field = 'test';
        self::assertEquals('<b>bold</b>', $bean->$field);


        // test
        $bean = new SugarBean();
        $force = true;
        $bean->field_defs['test'] = array(
            'display_default' => '<b>bold</b>',
            'type' => 'multienum',
        );
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->populateDefaultValues($force);
        self::assertEquals(null, $results);
        self::assertEquals(array(
            'test' => array(
                'display_default' => '<b>bold</b>',
                'type' => 'multienum',
            ),
        ), $bean->field_defs);
        $field = 'test';
        self::assertEquals('<b>bold</b>', $bean->$field);


        // test
        $bean = new SugarBean();
        $force = true;
        $bean->field_defs['test'] = array(
            'display_default' => '<b>bold</b>',
            'type' => 'datetime',
        );
        $bean->field_defs['test2'] = array(
            'display_default' => '<b>bold</b>',
            'type' => 'date',
        );
        $exception = null;
        try {
            /** @noinspection PhpVoidFunctionResultUsedInspection */
            $results = $bean->populateDefaultValues($force);
            // this function call should failed with an exception
            self::assertTrue(false);
        } /** @noinspection PhpUndefinedClassInspection */ catch (\PHPUnit_Framework_Exception $e) {
            $exception = $e;
            self::assertEquals(2, $e->getCode());
        }
        self::assertNotNull($exception);
        self::assertEquals(null, $results);
        self::assertEquals(array(
            'test' => array(
                'display_default' => '<b>bold</b>',
                'type' => 'datetime',
            ),
            'test2' => array(
                'display_default' => '<b>bold</b>',
                'type' => 'date',
            ),
        ), $bean->field_defs);
        $field = 'test';
        self::assertEquals('<b>bold</b>', $bean->$field);

    }

    /**
     * Test for parseDateDefault()
     */
    public function testParseDateDefault()
    {
        $bean = new SugarBeanMock();

        // test
        try {
            $bean->publicParseDateDefault(null);
            self::assertTrue(false);
        } /** @noinspection PhpUndefinedClassInspection */ catch (\PHPUnit_Framework_Exception $e) {
            $code = $e->getCode();
            self::assertEquals(2, $code);
        }

        // test
        $results = $bean->publicParseDateDefault('2015-05-05');
        self::assertEquals('05/05/2015', $results);

        // test
        $results = $bean->publicParseDateDefault('2015-05-05', true);
        self::assertNotEquals('05/05/2015', $results);
        self::assertEquals(1, preg_match('/05\/05\/2015 \d{2}:\d{2}/', $results));

        // test
        $results = $bean->publicParseDateDefault('2015-05-05 11:11', true);
        self::assertEquals('05/05/2015 11:11', $results);

        // test
        $results = $bean->publicParseDateDefault('2015-05-05&11:11', true);
        self::assertEquals('05/05/2015 11:11', $results);
    }

    /**
     * Test for removeRelationshipMeta()
     */
    public function testRemoveRelationshipMeta()
    {
        // test
        $GLOBALS['log']->reset();
        SugarBean::removeRelationshipMeta(null, null, null, null, null);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::removeRelationshipMeta(null, null, null, null, 'Contacts');
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::removeRelationshipMeta('key', null, null, array('key' => 'value'), 'Tests');
        self::assertNotTrue(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        SugarBean::removeRelationshipMeta('key', null, null, array(
            'key' => array(
                'relationships' => true,
            ),
        ), 'Tests');
        self::assertCount(2, $GLOBALS['log']->calls['fatal']);

    }

    /**
     * Test for createRelationshipMeta()
     */
    public function testCreateRelationshipMeta()
    {
        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta(null, null, null, null, null);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta(null, null, null, null, 'Contacts');
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta(null, null, null, null, 'Contacts', true);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta('User', null, null, null, 'Contacts');
        self::assertCount(6, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta('User', $this->db, null, null, 'Contacts');
        self::assertNotTrue(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta('Nonexists1', $this->db, null, null, 'Nonexists2');
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta('User', null, null, null, 'Contacts');
        self::assertCount(6, $GLOBALS['log']->calls['fatal']);

    }

    /**
     * Test for get_union_related_list()
     * @todo need more test coverage and less function complexity
     */
    public function testGetUnionRelatedList()
    {
        // test
        $GLOBALS['log']->reset();
        $results = SugarBean::get_union_related_list(null);
        self::assertCount(3, $GLOBALS['log']->calls['fatal']);
        self::assertEquals(null, $results);


        // test
        $GLOBALS['log']->reset();
        $_SESSION['show_deleted'] = 1;
        $results = SugarBean::get_union_related_list(null);
        self::assertCount(3, $GLOBALS['log']->calls['fatal']);
        self::assertEquals(null, $results);


        // test
        $GLOBALS['log']->reset();
        $_SESSION['show_deleted'] = 1;
        $parentBean = new SugarBeanMock();
        $subPanelDef = new aSubPanel(null, null, $parentBean);
        $results = SugarBean::get_union_related_list($parentBean, '', '', '', 0, -1, -1, 0, $subPanelDef);
        self::assertCount(5, $GLOBALS['log']->calls['fatal']);
        self::assertEquals(array(
            'list' => array(),
            'parent_data' => array(),
            'row_count' => 0,
            'next_offset' => 10,
            'previous_offset' => -10,
            'current_offset' => 0,
            'query' => '',
        ), $results);


        // test
        $GLOBALS['log']->reset();
        $subPanelDef->_instance_properties['type'] = 'collection';
        $results = SugarBean::get_union_related_list($parentBean, '', '', '', 0, -1, -1, 0, $subPanelDef);
        self::assertCount(2, $GLOBALS['log']->calls['fatal']);
        self::assertEquals(array(
            'list' => Array(),
            'parent_data' => Array(),
            'row_count' => 0,
            'next_offset' => 10,
            'previous_offset' => -10,
            'current_offset' => 0,
            'query' => '',
        ), $results);


        // test
        $GLOBALS['log']->reset();
        $_SESSION['show_deleted'] = 1;
        $parentBean = new SugarBeanMock();
        $subPanelDef = new aSubPanel(null, null, $parentBean);
        $subPanelDef->_instance_properties['type'] = 'collection';
        $subPanelDef->_instance_properties['collection_list'] = array(
            array('module' => 'Contacts'),
        );
        $subPanelDef->_instance_properties['get_subpanel_data'] = 'function';
        $subPanelDef->_instance_properties['generate_select'] = array();
        $results = SugarBean::get_union_related_list($parentBean, '', '', '', 0, -1, -1, 0, $subPanelDef);

        self::assertCount(7, $GLOBALS['log']->calls['fatal']);
        self::assertEquals(array(
            'list' => Array(),
            'parent_data' => Array(),
            'row_count' => 0,
            'next_offset' => 10,
            'previous_offset' => -10,
            'current_offset' => 0,
            'query' => '',
        ), $results);

    }


    /**
     * Test for build_sub_queries_for_union()
     */
    public function testBuildSubQueriesForUnion()
    {

        // test
        $bean = new SugarBeanMock();
        $panel =
            new aSubPanel('Test', array(
                'get_subpanel_data' => 1,
            ), $bean);
        $subpanel_list = array(
            $panel
        );
        $subpanel_def = null;
        $parentbean = new SugarBeanMock();
        $order_by = null;
        $GLOBALS['log']->reset();
        $results = SugarBeanMock::publicBuildSubQueriesForUnion($subpanel_list, $subpanel_def, $parentbean, $order_by);
        self::assertEquals(array(), $results);
        self::assertNotTrue(isset($GLOBALS['log']->calls['fatal']));


        // test
        $subpanel_list = array(
            new aSubPanel('Test', array(), new SugarBeanMock())
        );
        $subpanel_def = null;
        $parentbean = null;
        $order_by = null;
        $GLOBALS['log']->reset();
        $results = SugarBeanMock::publicBuildSubQueriesForUnion($subpanel_list, $subpanel_def, $parentbean, $order_by);
        self::assertEquals(array(
            array(
                'select' => ' , \'Test\' panel_name ',
                'query_array' => null,
                'params' => array(
                    'distinct' => false,
                    'joined_tables' => null,
                    'include_custom_fields' => null,
                    'collection_list' => null,
                ),
            ),
        ), $results);
        self::assertCount(6, $GLOBALS['log']->calls['fatal']);


        // test
        $subpanel_list = array(
            1
        );
        $subpanel_def = null;
        $parentbean = null;
        $order_by = null;
        $GLOBALS['log']->reset();
        $results = SugarBeanMock::publicBuildSubQueriesForUnion($subpanel_list, $subpanel_def, $parentbean, $order_by);
        self::assertEquals(array(), $results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);


        // test
        $subpanel_list = null;
        $subpanel_def = null;
        $parentbean = null;
        $order_by = null;
        $GLOBALS['log']->reset();
        $results = SugarBeanMock::publicBuildSubQueriesForUnion($subpanel_list, $subpanel_def, $parentbean, $order_by);
        self::assertEquals(array(), $results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);
    }

    public function testProcessUnionListQuery()
    {


        // test
        $GLOBALS['log']->reset();
        $bean = new Contact();
        $bean->id = 'test_contact1';
        $bean->save();
        try {
            $results = $bean->process_union_list_query(null, 'SELECT DISTINCT * FROM contacts', null);
            self::assertTrue(false);
        } catch (\Exception $e) {
            self::assertTrue(true);
        }
        self::assertTrue(2 <= count($GLOBALS['log']->calls['fatal']));
        self::assertNotTrue(isset($results));


        // test
        $GLOBALS['log']->reset();
        $bean = new SugarBeanMock();
        try {
            $results = $bean->process_union_list_query(null, 'DISTINCT', null);
            self::assertTrue(false);
        } catch (\Exception $e) {
            self::assertTrue(true);
            self::assertEquals(1, $e->getCode());
        }
        self::assertCount(4, $GLOBALS['log']->calls['fatal']);
        self::assertNotTrue(isset($results));


        // test
        $GLOBALS['log']->reset();
        $bean = new SugarBeanMock();
        $results = $bean->process_union_list_query(null, null, null);
        self::assertCount(4, $GLOBALS['log']->calls['fatal']);
        self::assertEquals(array(
            'list' => Array(),
            'parent_data' => Array(),
            'row_count' => 0,
            'next_offset' => 10,
            'previous_offset' => -10,
            'current_offset' => 0,
            'query' => null,
        ), $results);

        // test
        $GLOBALS['log']->reset();
        $bean = new Contact();
        $bean->retrieve('test_contact1');
        $results = $bean->process_union_list_query(null, 'SELECT DISTINCT * FROM contacts', 'end');
        self::assertCount(2, $GLOBALS['log']->calls['fatal']);
        self::assertEquals(array(
            'list' => Array(),
            'parent_data' => Array(),
            'row_count' => 2010,
            'next_offset' => 2010.0,
            'previous_offset' => 1990.0,
            'current_offset' => 2000.0,
            'query' => 'SELECT DISTINCT * FROM contacts',
        ), $results);

    }


}